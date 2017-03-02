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
}