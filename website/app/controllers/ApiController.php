<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 02/03/2017
 * Time: 2:28 PM
 */
class ApiController extends \BaseController 
{
    public function getCheckMoSmsPlus(){
        require_once app_path('../../sdk/1pay/OnePayClient.php');
        $data = "access_key=" . Input::get('access_key','') . "&amount=" . Input::get('amount','') . "&command_code=" . Input::get('command_code','') . "&mo_message=" . Input::get('mo_message','') . "&msisdn=" . Input::get('msisdn','') . "&telco=" . Input::get('telco','');
        $secret = OnePayClient::SECRET_KEY; //product's secret key (get value from 1Pay product detail)
        $signature = hash_hmac("sha256", $data, $secret); // create signature to check
        $arResponse['type'] = 'text';
        // kiem tra signature neu can
        $arResponse['status'] = 0;
        if (Input::get('signature','') != $signature) {
            $arResponse['sms'] = 'Khong hop le';
            return Response::json($arResponse);
        }
        $moContent = Input::get('mo_message','');
        $moArr = explode(' ', $moContent);
        $info = isset($moArr[2]) ? $moArr[2] : '';
        if(empty($info)){
            $arResponse['sms'] = 'Cú pháp không hợp lệ. Vui lòng thử lại.';
            return Response::json($arResponse);
        }
        $uid = explode('.',$info)[0];
        $user = User::where('_id', $uid)->first();
        if(!$user){
            $arResponse['sms'] = 'Tài khoản không tồn tại. Vui lòng thử lại.';
            return Response::json($arResponse);
        }
        //if sms content and amount and ... are ok. return success case
        $arResponse['status'] = 1;
        $arResponse['sms'] = 'Hop le';

        // return json for 1pay system
        return Response::json($arResponse);
    }

    public function getSmsPlus(){
        require_once app_path('../../sdk/1pay/OnePayClient.php');
        $data = "access_key=" . Input::get('access_key','') . "&amount=" . Input::get('amount','') .
            "&command_code=" . Input::get('command_code','') . "&error_code=" . Input::get('error_code','') .
            "&error_message=" . Input::get('error_message','') . "&mo_message=" . Input::get('mo_message','') .
            "&msisdn=" .Input::get('msisdn','') . "&request_id=" . Input::get('request_id','') . "&request_time=" .
            Input::get('request_time','');
        $secret = OnePayClient::SECRET_KEY;; //product's secret key (get value from 1Pay product detail)
        $signature = hash_hmac("sha256", $data, $secret); // create signature to check
        $arResponse['type'] = 'text';
        $arResponse['status'] = 0;
        // kiem tra signature neu can
        if (Input::get('signature','') != $signature) {
            $arResponse['sms'] = 'Giao dich khong thanh cong. Lien he '.Constant::SUPPORT_PHONE.' de biet them chi tiet.';
            return Response::json($arResponse);
        }
        $moContent = Input::get('mo_message','');
        $moArr = explode(' ', $moContent);
        $info = isset($moArr[2]) ? $moArr[2] : '';
        $infoArr = explode('.',$info);
        $uid = $infoArr[0];
        $pkgCode = isset($infoArr[1]) ?$infoArr[1]:'';
        $package = false;
//        $user = User::where('_id', $uid)->first();
        $txn = TxnSms::where('request_id',Input::get('request_id',''))->first();
        if($txn){
            return Response::json($arResponse);
        }

        if($txn->response_code == OnePayClient::SMS_SUCCESS_CODE){
            $user=User::where('_id',$uid)->first();
            $arResponse['status'] = 1;
            //Neu kem goi cuoc
            if($package){
                $missBalance = $package->price - $txn->amount;
                //Neu so tien nho hon hoc phi
                if($missBalance > 0){
                    //update so du
                    $user->balance = $user->getBalance() + $txn->amount * Constant::SMS_TO_CASH;
                    $arResponse['sms'] = 'Ban da thanh toan so tien '.number_format($txn->amount). 'd. Vui long nap them '.number_format($missBalance).'d de dang ky khoa hoc '.Common::vietnameseToEnglish($package->name).'. Truy cap http://english360.com.vn de su dung. Chi tiet lien he: '.Constant::SUPPORT_PHONE.'.';
                }else{
                    //Dang ky goi
                    $time = $package->time*86400;
                    $user->pkg_id = $package->_id;
                    $user->pkg_expired = $user->getPackageTime() ? $user->getPackageTime()+$time : time()+$time;
                    if($missBalance < 0){
                        //cập nhật số dư tài khoản
                        $user->balance = $user->getBalance() + $txn->amount * Constant::SMS_TO_CASH - $package->price;
                    }
                    $arResponse['sms'] = 'Ban da dang ky thanh cong khoa hoc '.Common::vietnameseToEnglish($package->name).'. Truy cap http://english360.com.vn de su dung. Chi tiet lien he: '.Constant::SUPPORT_PHONE.'.';
                }
            }else{
                //update so du
                $user->balance = $user->getBalance() + $txn->amount * Constant::SMS_TO_CASH;
                $arResponse['sms'] = 'Ban da thanh toan so tien '.number_format($txn->amount). 'd. Vui long truy cap http://english360.com.vn de su dung. Chi tiet lien he: '.Constant::SUPPORT_PHONE.'.';
            }
            $user->save();
        }else{
            $arResponse['sms'] = 'Giao dich that bai. Chi tiet lien he: '.Constant::SUPPORT_PHONE.'.';
        }
        return Response::json($arResponse);
    }
}