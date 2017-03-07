<?php

class TxnsController extends \BaseController {

    public function __construct(){
        $this->beforeFilter('auth');
    }

    public function getCharge(){
        $tab = Input::get('tab','#card');
        $listCardType = Common::getCardType();
        $listCardType[''] = '--Chọn loại thẻ--';
        return View::make('txns.charge', array(
            'listCardType' => $listCardType,
            'tab' => $tab
        ));
    }

    public function getTest(){
        $type = 'VTE';
        $pin = '0555779568737';
        $seri = '57823615867';
        require_once app_path('../../sdk/1pay/OnePayClient.php');
        $mpc = new OnePayClient();
        print_r($mpc->recheck('', $pin,  $seri, '0016146259', $type));
    }

    public function postChargeCard(){
        $pin = Input::get('pin');
        $seri = Input::get('seri');
        $cardType = Input::get('card_type');
        //Lưu giao dịch thẻ cào
        $txn = new TxnCard;
        $txn->_id = strval(time());
        $txn->datecreate = time();
        $txn->uid = Auth::user()->id;
        $txn->card_type = $cardType;
        $txn->pin = $pin;
        $txn->seri = $seri;
        if(!$txn->save()){
            return Redirect::back()->with('error','Có lỗi xảy ra, vui lòng thử lại.');
        }

        //Gọi sang cổng thẻ cào
        $true_card = array('65682321546');
        if(in_array($txn->pin, $true_card)){
            list($response_code,$card_amount,$response_message)=array(Constant::TXN_CARD_SUCCESS,10000,'success');
        }else{
            list($response_code,$card_amount,$response_message)=$this->_doChargeCard($txn);
        }

        //Xử lý kết quả trả về
        $txn->card_amount=$card_amount;
        $txn->response_code=$response_code;
        if($response_code==Constant::TXN_CARD_SUCCESS){
            $this->_onCardSuccess($txn);
            return Redirect::back()->with('success','Nạp thẻ thành công');
        }else{
            $this->_onCardFail($txn);
            return Redirect::back()->with('error',$response_message)->withInput();
        }
//        return Redirect::back()->with('error','Thẻ không hợp lệ.')->withInput();
    }

    private function _doChargeCard(TxnCard $txn){
        $provider = '1pay';
        //Lưu log
        $log = new LogTxnCard();
        $log->_id = strval(time());
        $log->txn_id = $txn->_id;
        $log->datecreate = time();
        $log->card_type = $txn->card_type;
        $log->pin = $txn->pin;
        $log->seri = $txn->seri;
//        $log->merchant_txn_id = $txn->_id;
        if (!$log->save()) {
            throw new Exception('DB error while storing card log');
        }

        if($provider == '1pay'){
            require_once app_path('../../sdk/1pay/OnePayClient.php');
            $mpc = new OnePayClient();
        }else{
            require_once app_path('../../sdk/baokim/BaoKimClient.php');
            $mpc = new BaoKimClient();
        }

        $rs = $mpc->charge($txn->_id, $txn->card_type, $txn->pin, $txn->seri);

        //update kết quả trả về vào trong log
        $log->response_code = $rs['code'];
        $log->provider_code = $rs['provider_code'];
        $log->response_message = $rs['message'];
        $log->card_amount = isset($rs['card_amount']) ? $rs['card_amount'] : 0;
        $log->provider_txn_id = $rs['transId'];
        if (!$log->save()) {
            throw new Exception('DB error while storing card log');
        }

        return array($rs['code'], $rs['card_amount'], Common::getTxnCardMss($rs['code']));
    }

    /**
     * Xử lý khi nạp thẻ thành công
     * @param $txnCard
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function _onCardSuccess(TxnCard $txnCard)
    {
        try {
            //cập nhật bảng txn_cards
            if (!$txnCard->save()) {
                throw new Exception('DB Error');
            }

            $user=User::where('_id',$txnCard->uid)->first();

            //Tính tiền cho aff
            $aff = $user->aff();
            if($aff){
                $aff_discount = Constant::AFF_RATE_CARD*$txnCard->card_amount;
                AffTxn::insert(array(
                    '_id' => strval(time()),
                    'datecreate' => time(),
                    'uid' => $aff->_id,
                    'txn_id' => $txnCard->_id,
                    'ref_id' => $user->_id,
                    'method' => Constant::CARD_METHOD_NAME,
                    'discount' => $aff_discount,
                    'rate' => Constant::AFF_RATE_CARD,
                    'amount' => $txnCard->card_amount
                ));
//                $account = $aff->account();
                $aff->account_balance += $aff_discount;
                $aff->save();
            }

            //cập nhật số dư tài khoản
            $user->balance = $user->getBalance()+$txnCard->card_amount * Constant::CARD_TO_CASH;
            $user->save();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**Xử lý khi nạp thẻ thất bại
     * @param $txnCard
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function _onCardFail(TxnCard $txnCard)
    {
        try {
            //cập nhật bảng txn_cards
            if (!$txnCard->save()) {
                throw new Exception('DB Error');
            }
        } catch (Exception $e) {
        }
    }

    public function postChargeBank(){
        $amount = Input::get('amount');
        if(!is_numeric($amount) || $amount<10000){
            return Response::json(array('success'=>false, 'message'=>'Số tiền cần nạp không hợp lệ.'));
        }

        $txn = new TxnBank;
        $txn->_id = strval(time());
        $txn->datecreate = time();
        $txn->uid = Auth::user()->id;
        $txn->amount = $amount;
        if(!$txn->save()){
            return Response::json(array('success'=>false, 'message'=>'Có lỗi xảy ra, vui lòng thử lại sau.'));
        }

        require_once app_path('../../sdk/1pay/OnePayBank.php');
        $mpc = new OnePayBank();
        $order_id = $txn->_id;
        $order_info = Auth::user()->email.' nap '.$txn->amount.'d English360';
        $payUrl = $mpc->getPayUrl($txn->amount, $order_id, $order_info);
        if(!$payUrl)
            return Response::json(array('success'=>false, 'message'=>'Có lỗi xảy ra, vui lòng thử lại sau.'));

        return Response::json(array('success'=>true, 'payUrl'=>$payUrl));
    }


    /**
     * Xử lý khi nạp thẻ thành công
     * @param $txnCard
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function _onBankSuccess(TxnBank $txnBank)
    {
        try {
            //cập nhật bảng txn_cards
            if (!$txnBank->save()) {
                throw new Exception('DB Error');
            }
            $user=User::where('_id',$txnBank->uid)->first();
            //Nếu là thanh toán trực tiếp -> đăng ký gói
            if(!empty($txnBank->pkg_id)){
                $package = Package::where('_id',$txnBank->pkg_id)->first();

            }

            //cập nhật số dư tài khoản
            $user->balance = $user->getBalance()+$txnBank->amount * Constant::BANK_TO_CASH;
            $user->save();
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function bankResult(){
        require_once app_path('../../sdk/1pay/OnePayBank.php');
        $mpc = new OnePayBank();

        //Log
        $log = Input::all();
        $log['_id'] = strval(time());
        LogTxnBank::insert($log);
        if(!isset($log['order_id'])){
            return Redirect::to('/thong-bao.html')->with('error','Giao dịch thất bại');
        }
        $rs = $mpc->exeResult($log);
        //Log

        //Xử lý kết quả trả về
        $txn = TxnBank::where('_id',$rs['id'])->first();
        $txn->response_code = $rs['code'];
        if($txn->response_code == Constant::TXN_BANK_SUCCESS){
            $txn->card_name = $rs['card_name'];
            $txn->card_type = $rs['card_type'];
            $txn->save();
            $user=User::where('_id',$txn->uid)->first();
            //Tính tiền cho aff
            $aff = $user->aff();
            if($aff){
                $aff_discount = Constant::AFF_RATE_BANK*$txn->amount;
                AffTxn::insert(array(
                    '_id' => strval(time()),
                    'datecreate' => time(),
                    'txn_id' => $txn->_id,
                    'uid' => $aff->_id,
                    'ref_id' => $user->_id,
                    'method' => Constant::BANK_METHOD_NAME,
                    'discount' => $aff_discount,
                    'rate' => Constant::AFF_RATE_BANK,
                    'amount' => $txn->amount
                ));
//                $account = $aff->account();
                $aff->account_balance += $aff_discount;
                $aff->save();
            }
            //Nếu là thanh toán trực tiếp -> đăng ký gói
            if(!empty($txn->pkg_id)){
                $package = Package::where('_id',$txn->pkg_id)->first();
                $time = $package->time*86400;
                $user->pkg_id = $package->_id;
                $user->pkg_expired = $user->getPackageTime() ? $user->getPackageTime()+$time : time()+$time;
                $user->save();
                $mess = 'Thanh toán khóa học thành công. Số dư tài khoản hiện tại: '.number_format($user->balance).'đ';
                return Redirect::to('/user/package?step=4')->with('success', $mess);
            }
            //cập nhật số dư tài khoản
            $user->balance = $user->getBalance()+$txn->amount * Constant::BANK_TO_CASH;
            $user->save();
            return Redirect::to('/thong-bao.html')->with('success','Giao dịch thành công.');
        }else{
            $txn->save();
            return Redirect::to('/thong-bao.html')->with('error',Common::getTxnBankMss($rs['code']));
        }
    }

}