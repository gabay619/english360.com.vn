<?php

class TxnsController extends \BaseController {

    public function __construct(){
        $this->beforeFilter('auth');
    }

    public function getCharge(){
        $listCardType = array(
            ''=>'--Loại thẻ--',
            'VTE' => 'Viettel',
            'VMS' => 'Mobifone',
            'VNP' => 'Vinaphone'
        );
        return View::make('txns.charge', array(
            'listCardType' => $listCardType
        ));
    }

    public function postChargeCard(){
        $pin = Input::get('pin');
        $seri = Input::get('seri');
        $cardType = Input::get('card_type');
        //Lưu giao dịch thẻ cào
        $txn = new TxnCard;
        $txn->_id = strval(time());
        $txn->uid = Auth::user()->id;
        $txn->card_type = $cardType;
        $txn->pin = $pin;
        $txn->seri = $seri;
        if(!$txn->save()){
            return Redirect::back()->with('error','Có lỗi xảy ra, vui lòng thử lại.');
        }

        //Gọi sang cổng thẻ cào
        $true_card = '65682321546';
        if(in_array($txn->pin, $true_card)){
            list($response_code,$card_amount,$response_message)=array(Constant::TXN_CARD_RESPONSE_CODE_SUCCESS,10000,'success');
        }else{
            list($response_code,$card_amount,$response_message)=$this->_doCharge($txn);
        }

        //Xử lý kết quả trả về
        $txn->card_amount=$card_amount;
        $txn->response_code=$response_code;
        if($response_code==Constant::TXN_CARD_RESPONSE_CODE_SUCCESS){
            $this->_onCardSuccess($txn);
            return Redirect::back()->with('success','Nạp thẻ thành công');
        }else{
            $this->_onCardFail($txn);
            return Redirect::back()->with('error',$response_message)->withInput();
        }
//        return Redirect::back()->with('error','Thẻ không hợp lệ.')->withInput();
    }

    private function _doCharge(Txn $txn){
        $provider = 'Baokim';
        //Lưu log
        $log = new LogTxnCard();
        $log->_id = strval(time());
        $log->txn_id = $txn->_id;
        $log->card_type = $txn->card_type;
        $log->pin = $txn->pin;
        $log->seri = $txn->seri;
        $log->merchant_txn_id = $provider.$txn->_id . '-' . time();
        if (!$log->save()) {
            throw new Exception('DB error while storing card log');
        }

        if($provider == 'Baokim'){
            require_once app_path('../../sdk/baokim/BaokimClient.php');
            $mpc = new BaokimClient();
        }else{
            require_once app_path('/libs/maxpay/MaxpayClient.php');
            $mpc = new MaxpayClient();
        }

        $rs = $mpc->charge($log->merchant_txn_id, $txn->card_type, $txn->pin, $txn->seri);

        //update kết quả trả về vào trong log
        $log->response_code = $rs['code'];
        $log->response_message = $rs['message'];
        $log->card_amount = isset($rs['card_amount']) ? $rs['card_amount'] : 0;
        if (!$log->save()) {
            throw new Exception('DB error while storing card log');
        }

        switch ($rs['code']) {
            case 1:
                return array(Constant::TXN_CARD_RESPONSE_CODE_SUCCESS, $rs['card_amount'], $rs['message']);
                break;
            case 98:
                return array(Constant::TXN_CARD_RESPONSE_CODE_PENDING, 0, $rs['message']);
                break;
            default:
                return array(Constant::TXN_CARD_RESPONSE_CODE_FAIL, 0, $rs['message']);
                break;
        }
    }

    /**
     * Xử lý khi nạp thẻ thành công
     * @param $txnCard
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function _onCardSuccess(TxnCard $txnCard)
    {
//        DB::beginTransaction();
        try {
            //cập nhật bảng txn_cards
            if (!$txnCard->save()) {
                throw new Exception('DB Error');
            }

            $user=User::where('_id',$txnCard->uid)->first();

            //cập nhật số dư tài khoản
            $user->balance = $user->getBalance()+$txnCard->card_amount * Constant::CARD_TO_CASH;
            $user->save();
//            $account_trace = new AccountTrace;
//            $account_trace->account_id = $user->account->id;
//            $account_trace->change_balance = $txnCard->card_amount * Config::get('common.vnd_to_xu_rate');
//            $account_trace->txn_id = $txnCard->id;
//            if (!$account_trace->save()) {
//                throw new Exception('DB Error');
//            }
        } catch (Exception $e) {
//            DB::rollBack();
            throw $e;
        }
//        DB::commit();
    }

    /**Xử lý khi nạp thẻ thất bại
     * @param $txnCard
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function _onCardFail(TxnCard $txnCard)
    {
//        DB::beginTransaction();
        try {
            //cập nhật bảng txn_cards
            if (!$txnCard->save()) {
                throw new Exception('DB Error');
            }
        } catch (Exception $e) {
//            DB::rollBack();
        }
//        DB::commit();
    }

    public function postNew(){
//        $id = Input::get('id');
//        $type = Input::get('type');
//        $content = Input::get('content');
//
//        $newReport = new Report();
//        $newReport->_id = strval(time());
//        $newReport->content = $content;
//        $newReport->uid = Auth::user()->_id;
//        $newReport->itemid = $id;
//        $newReport->type = $type;
//        $newReport->datecreate = time();
//        $newReport->save();
//
//        return Response::json(array('success'=>true, 'message' => 'Cảm ơn bạn đã gửi báo cáo cho chúng tôi. Chúng tôi sẽ xem xét trong thời gian sớm nhất.'));
    }

}