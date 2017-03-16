<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 23/02/2017
 * Time: 8:49 AM
 */
class OnePayClient
{
    const API_URL = 'https://api.1pay.vn/card-charging/v5';
    const ACCESS_KEY = '4o3fu8sl04i24br64wmb';
    const SECRET_KEY = 'url0b0xm4s4l3309d455xyigdac6161y';
    const SUCCESS_CODE = '00';
    const SMS_SUCCESS_CODE = 'WCG-0000';
    const API_SMS_URL = 'http://merchant.1pay.vn/charging/service/logs';
    const API_OTP_URL = 'http://api.1pay.vn/direct-charging/charge';

    public function charge($txn_id, $cardType, $pin, $seri){
        $json_cardCharging = $this->_execPostRequest($txn_id, $cardType, $pin, $seri);
//        return $json_cardCharging;
        $decode_cardCharging=json_decode($json_cardCharging,true);  // decode json
//        return $decode_cardCharging;
        if (isset($decode_cardCharging)) {
            $description = $decode_cardCharging["description"];   // transaction description
            $status = $decode_cardCharging["status"];
            $amount = $decode_cardCharging["amount"];       // card's amount
            $transId = $decode_cardCharging["transId"];
            // xử lý dữ liệu của merchant
            if($status == self::SUCCESS_CODE){
                return array(
                    'code' => $this->_mapCode($status),
                    'message' => 'Nạp thành công',
                    'card_amount' => $amount,
                    'transId' => $transId,
                    'provider_code' => $status
                );
            }else{
                return array(
                    'code' => $this->_mapCode($status),
                    'message' => $description,
                    'card_amount' => $amount,
                    'transId' => $transId,
                    'provider_code' => $status
                );
            }
        }else{
            return array(
                'code' => Constant::TXN_CARD_PENDING,
                'message' => 'Chờ xử lý',
                'card_amount' => 0,
                'transId' => '',
                'provider_code' => '99'
            );
        }
    }

    private function _execPostRequest($txn_id, $cardType, $pin, $seri){
        $data = "access_key=" . self::ACCESS_KEY . "&pin=" . $pin . "&serial=" . $seri . "&transRef=" . $txn_id . "&type=" . $this->_mapCardType($cardType);
        $signature = hash_hmac("sha256", $data, self::SECRET_KEY);
//        $data = "access_key=" . self::ACCESS_KEY . "&pin=" . $pin . "&serial=" . $seri . "&transRef=" . $txn_id . "&type=" . $this->_mapCardType($cardType);
        $data .= "&signature=" . $signature;
//        return $data;

        $url = self::API_URL.'/topup';
        // open connection
        $ch = curl_init();

        // set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // execute post
        $result = curl_exec($ch);

        // close connection
        curl_close($ch);
        return $result;
    }

    public function recheck($txn_id,$pin, $seri, $transId, $cardType){
//        $data = "access_key=" . self::ACCESS_KEY . "&pin=" . $pin . "&serial=" . $seri . "&transRef=" .$txn_id . "&transId=" . $transId . "&type=" . $this->_mapCardType($cardType);
        $data = "access_key=" . self::ACCESS_KEY . "&pin=" . $pin . "&serial=" . $seri . "&transId=".$transId."&transRef=" .$txn_id . "&type=" . $this->_mapCardType($cardType);
        $signature = hash_hmac("sha256", $data, self::SECRET_KEY);
        $data .= "&signature=" . $signature;

        $url = self::API_URL.'/query';
        // open connection
        $ch = curl_init();

        // set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // execute post
        $result = curl_exec($ch);

        // close connection
        curl_close($ch);
//        return $result;
//        $json_cardCharging = $this->_execPostRequest($txn_id, $cardType, $pin, $seri);
//        return $json_cardCharging;
        $decode_cardCharging=json_decode($result,true);  // decode json
//        return $decode_cardCharging;
        if (isset($decode_cardCharging)) {
            $description = $decode_cardCharging["description"];   // transaction description
            $status = $decode_cardCharging["status"];
            $amount = $decode_cardCharging["amount"];       // card's amount
            $transId = $decode_cardCharging["transId"];
            // xử lý dữ liệu của merchant
            if($status == self::SUCCESS_CODE){
                return array(
                    'code' => $this->_mapCode($status),
                    'message' => 'Nạp thành công',
                    'card_amount' => $amount,
                    'transId' => $transId,
                    'provider_code' => $status

                );
            }else{
                return array(
                    'code' => $this->_mapCode($status),
                    'message' => $description,
                    'card_amount' => $amount,
                    'transId' => $transId,
                    'provider_code' => $status

                );
            }
        }else{
            return array(
                'code' => Constant::TXN_CARD_PENDING,
                'message' => 'Chờ xử lý',
                'card_amount' => 0,
                'transId' => '',
                'provider_code' => '99'

            );
        }
//        return $result;
    }

    public function requestOtpVnp($txn_id, $amount, $msisdn, $content){
        $data = "access_key=".self::ACCESS_KEY."&amount=".$amount."&content=".$content."&msisdn=".$msisdn."&requestId=".$txn_id;
        $signature = hash_hmac("sha256", $data, self::SECRET_KEY);
        $data.= "&signature=" . $signature; //"&backUrl=".$back_url.
        $json_Charging = $this->_exec(self::API_OTP_URL.'/request', $data);
        $decode_Charging=json_decode($json_Charging,true);  // decode json
        $errorMessage = $decode_Charging["errorMessage"];
        $requestId_back = $decode_Charging["requestId"];
        $transId = $decode_Charging["transId"];
        $errorCode = $decode_Charging["errorCode"];
        $redirect_url = $decode_Charging["redirectUrl"];
        return array(
            'code' => $this->_mapCodeOtp($errorCode),
            'message' => $errorMessage,
            'id' =>$requestId_back,
            'transId' => $transId,
            'provider_code' => $errorCode,
            'redirect_url' => $redirect_url
        );
    }

    public function requestOtp($txn_id, $amount, $msisdn, $content){
        $data = "access_key=".self::ACCESS_KEY."&amount=".$amount."&content=".$content."&msisdn=".$msisdn."&requestId=".$txn_id;
        $signature = hash_hmac("sha256", $data, self::SECRET_KEY);
        $data.= "&signature=" . $signature;
        $json_Charging = $this->_exec(self::API_OTP_URL.'/request', $data);
        $decode_Charging=json_decode($json_Charging,true);		// decode json
        $errorMessage = $decode_Charging["errorMessage"];
        $requestId_back = $decode_Charging["requestId"];
        $transId = $decode_Charging["transId"];
        $errorCode = $decode_Charging["errorCode"];
        $redirect_url = isset($decode_Charging["redirectUrl"]) ? $decode_Charging["redirectUrl"] : '';
        return array(
            'code' => $this->_mapCodeOtp($errorCode),
            'message' => $errorMessage,
            'id' =>$requestId_back,
            'transId' => $transId,
            'provider_code' => $errorCode,
            'redirect_url' => $redirect_url,
            'data' => $data
        );
    }

    public function confirmOtp($otp, $txn_id, $transId){
		$data = "access_key=".self::ACCESS_KEY."&otp=".$otp."&requestId=".$txn_id."&transId=".$transId;
        $signature = hash_hmac("sha256", $data, self::SECRET_KEY);
        $data.= "&signature=" . $signature;
        $json_bankCharging = $this->_exec(self::API_OTP_URL.'/confirm', $data);
        //decode json
        $decode_bankCharging=json_decode($json_bankCharging,true);
        $errorMessage = $decode_bankCharging["errorMessage"];
        $requestId_back = $decode_bankCharging["requestId"];
        $transId = $decode_bankCharging["transId"];
        $errorCode = $decode_bankCharging["errorCode"];
        return array(
            'code' => $this->_mapCodeOtp($errorCode),
            'message' => $errorMessage,
            'id' =>$requestId_back,
            'transId' => $transId,
            'provider_code' => $errorCode
        );
    }

    public function confirmOtpVnp($input){
        if(!isset($input['access_key'])) $input['access_key'] = '';
        if(!isset($input['amount'])) $input['amount'] = '';
        if(!isset($input['errorCode'])) $input['errorCode'] = '';
        if(!isset($input['errorMessage'])) $input['errorMessage'] = '';
        if(!isset($input['msisdn'])) $input['msisdn'] = '';
        if(!isset($input['requestId'])) $input['requestId'] = '';
        if(!isset($input['request_time'])) $input['request_time'] = '';
        if(!isset($input['transId'])) $input['transId'] = '';
        if(!isset($input['signature'])) $input['signature'] = '';
        $data = "access_key=".$input['access_key']."&amount=".$input['amount']."&errorCode=".$input['errorCode'].
            "&errorMessage=".$input['errorMessage']."&msisdn=".$input['msisdn']."&requestId=".$input['requestId'].
            "&request_time=".$input['request_time']."&transId=".$input['transId'];
        $signature = hash_hmac("sha256", $data, self::SECRET_KEY);
        if($signature == $input['signature']){
            if($input['errorCode'] == '18') $input['errorCode'] = '00';
            return array(
                'code' => $this->_mapCodeOtp($input['errorCode']),
                'message' => $input['errorMessage'],
                'id' => $input['requestId'],
                'transId' => $input['transId'],
                'provider_code' => $input['errorCode']
            );
        }
        return array(
            'code' => 04,
            'message' => 'Chữ ký xác thực E360 nhận được không chính xác',
            'id' => $input['requestId'],
            'transId' => $input['transId'],
            'provider_code' => $input['errorCode']
        );
    }

    private function _exec($url, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    private function _mapCodeOtp($code){
        $arr = array(
            '00' => Constant::TXN_OTP_SUCCESS,
            '01' => Constant::TXN_OTP_PROVIDER_ERROR,
            '02' => Constant::TXN_OTP_PROVIDER_ERROR,
            '03' => Constant::TXN_OTP_PROVIDER_ERROR,
            '04' => Constant::TXN_OTP_PROVIDER_ERROR,
            '05' => Constant::TXN_OTP_PROVIDER_ERROR,
            '06' => Constant::TXN_OTP_PROVIDER_ERROR,
            '07' => Constant::TXN_OTP_MSISDN_INVALID,
            '08' => Constant::TXN_OTP_SENT_ERROR,
            '09' => Constant::TXN_OTP_PROVIDER_ERROR,
            '10' => Constant::TXN_OTP_ACCOUNT_NOT_ENOUGH,
            '11' => Constant::TXN_OTP_INPUT_WRONG,
            '12' => Constant::TXN_OTP_PROVIDER_ERROR,
            '13' => Constant::TXN_OTP_PROVIDER_ERROR,
            '14' => Constant::TXN_OTP_TOO_MUCH,
            '15' => Constant::TXN_OTP_PROVIDER_ERROR,
            '16' => Constant::TXN_OTP_TOO_MUCH,
            '17' => Constant::TXN_OTP_PROVIDER_ERROR,
            '18' => Constant::TXN_OTP_SENT_SUCCESS,
            '19' => Constant::TXN_OTP_MSISDN_INVALID,
            '20' => Constant::TXN_OTP_MSISDN_INVALID,
            '21' => Constant::TXN_OTP_PROVIDER_ERROR,
            '22' => Constant::TXN_OTP_PROVIDER_ERROR,
            '23' => Constant::TXN_OTP_PROVIDER_ERROR,
            '24' => Constant::TXN_OTP_PROVIDER_ERROR,
            '99' => Constant::TXN_OTP_ERROR,
        );
        return isset($arr[$code]) ? $arr[$code] : Constant::TXN_CARD_PENDING;
    }

    private function _mapCode($code){
        $arr = array(
            '00' => Constant::TXN_CARD_SUCCESS,
            '01' => Constant::TXN_CARD_PROVIDER_ERROR,
            '02' => Constant::TXN_CARD_PROVIDER_ERROR,
            '03' => Constant::TXN_CARD_PROVIDER_ERROR,
            '04' => Constant::TXN_CARD_PROVIDER_ERROR,
            '05' => Constant::TXN_CARD_PROVIDER_ERROR,
            '06' => Constant::TXN_CARD_PROVIDER_ERROR,
            '07' => Constant::TXN_CARD_USED,
            '08' => Constant::TXN_CARD_LOCKED,
            '09' => Constant::TXN_CARD_INVALID,
            '10' => Constant::TXN_CARD_INVALID,
            '11' => Constant::TXN_CARD_PIN_INVALID,
            '12' => Constant::TXN_CARD_SERI_INVALID,
            '13' => Constant::TXN_CARD_INVALID,
            '14' => Constant::TXN_CARD_INVALID,
            '15' => Constant::TXN_CARD_PROVIDER_ERROR,
            '16' => Constant::TXN_CARD_INVALID,
            '17' => Constant::TXN_CARD_PROVIDER_ERROR,
            '18' => Constant::TXN_CARD_PENDING,
            '19' => Constant::TXN_CARD_PROVIDER_ERROR,
            '20' => Constant::TXN_CARD_PROVIDER_ERROR,
            '21' => Constant::TXN_CARD_PROVIDER_ERROR,
            '22' => Constant::TXN_CARD_PENDING,
            '23' => Constant::TXN_CARD_PENDING,
            '99' => Constant::TXN_CARD_PENDING,
        );
        return isset($arr[$code]) ? $arr[$code] : Constant::TXN_CARD_PENDING;
    }


    private function _mapCardType($cardtype){
        $arr = array(
            'VTE' => 'viettel',
            'VMS' => 'mobifone',
            'VNP' => 'vinaphone',
            'FPT' => 'gate'
        );
        return isset($arr[$cardtype]) ? $arr[$cardtype] : 'viettel';
    }

    private function _mapTelcoOtp($cardtype){
        $arr = array(
            'VTE' => 'vtm',
            'VMS' => 'vms',
            'VNP' => 'vnp',
        );
        return isset($arr[$cardtype]) ? $arr[$cardtype] : 'vtm';
    }
}