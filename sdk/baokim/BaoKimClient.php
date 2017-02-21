<?php

/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 12/15/2015
 * Time: 2:20 PM
 */
class BaokimClient
{
    const API_URL = 'https://www.baokim.vn/the-cao/restFul/send';
    const MERCHANT_ID = '20348';
    const API_USERNAME = 'trumhackcom';
    const API_PASSWORD = '4CZsK3TF5e8QYz7eaUiE';
    const SECURE_CODE = '3a9350ea93f86707';
    const CORE_API_HTTP_USR = 'merchant_19002';
    const CORE_API_HTTP_PWD = '19002mQ2L8ifR11axUuCN9PMqJrlAHFS04o';

    public function charge($txn_id,$cardType, $pin, $seri){
        $arrayPost = array(
            'merchant_id'=>self::MERCHANT_ID,
            'api_username'=>self::API_USERNAME,
            'api_password'=>self::API_PASSWORD,
            'transaction_id'=>$txn_id,
            'card_id'=>$this->_mapCardType($cardType),
            'pin_field'=>$pin,
            'seri_field'=>$seri,
            'algo_mode'=>'hmac'
        );

        ksort($arrayPost);

        $data_sign = hash_hmac('SHA1',implode('',$arrayPost),self::SECURE_CODE);

        $arrayPost['data_sign'] = $data_sign;

        $curl = curl_init(self::API_URL);

        curl_setopt_array($curl, array(
            CURLOPT_POST=>true,
            CURLOPT_HEADER=>false,
            CURLINFO_HEADER_OUT=>true,
            CURLOPT_TIMEOUT=>30,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPAUTH=>CURLAUTH_DIGEST|CURLAUTH_BASIC,
            CURLOPT_USERPWD=>self::CORE_API_HTTP_USR.':'.self::CORE_API_HTTP_PWD,
            CURLOPT_POSTFIELDS=>http_build_query($arrayPost)
        ));

        $data = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $result = json_decode($data,true);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $time = time();
        if($status==200) {
            return array(
                'code' => 1,
                'message' => 'Nạp thành công',
                'card_amount' => $result['amount']
            );
        }elseif($status == 202){
            return array(
                'code'=>98,
                'message'=>'Giao dịch đang chờ xử lý.'
            );
        }else{
            return array(
                'code'=>$status,
                'message'=>$result['errorMessage']
            );
        }
    }

    private function _mapCardType($cardtype){
        $arr = array(
            'VTE' => 'VIETEL',
            'VMS' => 'MOBI',
            'VNP' => 'VINA',
            'FPT' => 'GATE'
        );
        return isset($arr[$cardtype]) ? $arr[$cardtype] : $cardtype;
    }
}