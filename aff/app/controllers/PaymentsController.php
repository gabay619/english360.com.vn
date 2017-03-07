<?php

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

    public function getWithdraw(){
        return View::make('payment.withdraw');
    }
    
    public function postWithdraw(){
        if(Input::get('amount') > Auth::user()->account()->balance){
            return Redirect::back()->with('error','Số tiền quá lớn.')->withInput();
        }
        //TODO: Dat lenh rut tien
    }
}