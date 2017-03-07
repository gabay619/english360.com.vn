<?php
use Gregwar\Captcha\CaptchaBuilder;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 06/03/2017
 * Time: 10:02 AM
 */
class PaymentsController extends \BaseController
{

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post', 'except'=>array(
//            'postUploadAvatar',
        )));
        $this->beforeFilter('auth', array('except' => array(
        )));

        $this->beforeFilter('payment', array('except' =>    array(
            'getSetting',
            'postSetting'
        )));
    }

    public function getInfo(){
        $myBank = Auth::user()->myBank();
        return View::make('payment.info', array(
            'myBank' => $myBank
        ));
    }

    public function getSetting(){
        $allBank = array(''=>'--Chọn ngân hàng--')+Common::getAllBank();
        $myBank = Auth::user()->myBank();
        return View::make('payment.setting', array(
            'allBank' => $allBank,
            'myBank' => $myBank
        ));
    }

    public function postSetting(){
        $user = Auth::user();
        $user->bank =array(
            'id' => Input::get('id'),
            'branch' => Input::get('branch'),
            'account_name' => Input::get('account_name'),
            'account_number' => Input::get('account_number')
        );
        $user->save();
        return Redirect::to('/payment/info')->with('success', 'Cập nhật thông tin thanh toán thành công');
    }

    public function getList()
    {
        $cond = array(
            'uid' => Auth::user()->_id,
        );
        $start = date('01/m/Y');
        $end = date('d/m/Y');
        if(!empty(Input::get('start'))){
            $start = Input::get('start');
        }
        if(!empty(Input::get('end'))){
            $end = Input::get('end');
        }
        $convertStartdate = DateTime::createFromFormat('d/m/Y', $start)->format('Y-m-d');
        $convertEnddate = DateTime::createFromFormat('d/m/Y', $end)->format('Y-m-d');
        $cond['datecreate'] = array(
            '$gte' => (int)strtotime($convertStartdate. ' 00:00:00'),
            '$lte' => (int)strtotime($convertEnddate. ' 23:59:59')
        );
        $allTxn = Withdraw::where($cond)->paginate(10);
        return View::make('payment.list',array(
            'allTxn'=> $allTxn,
            'start' => $start,
            'end' => $end
        ));
    }
//
//    public function getWithdraw(){
//        return View::make('payment.withdraw');
//    }


//    public function postWithdraw(){
//        if(Input::get('amount') > Auth::user()->account()->balance){
//            return Redirect::back()->with('error','Số tiền quá lớn.')->withInput();
//        }
//        $builder = new CaptchaBuilder;
//        $builder->setPhrase(Session::get('captchaPhrase'));
//        if(!$builder->testPhrase(Input::get('captcha'))) {
//            return Redirect::back()->with('error','Mã xác thực nhập không chính xác')->withInput();
//        }
//        //TODO: Dat lenh rut tien
//    }
}