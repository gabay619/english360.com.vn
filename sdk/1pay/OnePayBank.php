<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 23/02/2017
 * Time: 3:25 PM
 */
class OnePayBank
{
    const API_URL = 'http://api.1pay.vn/bank-charging/service';
    const ACCESS_KEY = '4o3fu8sl04i24br64wmb';
    const SECRET_KEY = 'url0b0xm4s4l3309d455xyigdac6161y';
    const SUCCESS_CODE = '00';
    const RETURN_URL = Constant::BASE_URL.'/bank-result.html';

    public function getPayUrl($amount, $order_id, $order_info)
    {
        $return_url = self::RETURN_URL;
        $command = 'request_transaction';
        $data = "access_key=".self::ACCESS_KEY."&amount=".$amount."&command=".$command."&order_id=".$order_id."&order_info=".$order_info."&return_url=".$return_url;
        $signature = hash_hmac("sha256", $data, self::SECRET_KEY);
        $data.= "&signature=".$signature;
        $json_bankCharging = $this->_execPostRequest(self::API_URL, $data);
        $decode_bankCharging = json_decode($json_bankCharging,true);  // decode json
        $pay_url = $decode_bankCharging["pay_url"];
        return isset($pay_url) ? $pay_url : false;
    }

    private function _postResult($transRef){
        $command = "close_transaction";
        $data = "access_key=".self::ACCESS_KEY."&command=".$command."&trans_ref=".$transRef;
        $signature = hash_hmac("sha256", $data, self::SECRET_KEY);
        $data.= "&signature=" . $signature;

        $json_bankCharging = $this->_execPostRequest(self::API_URL, $data);

        $decode_bankCharging=json_decode($json_bankCharging,true);  // decode json

        $response_message = $decode_bankCharging["response_message"];
        $response_code = $decode_bankCharging["response_code"];
        $amount = $decode_bankCharging["amount"];
        return array(
            'code' => $response_code,
            'message' => $response_message,
            'amount' => $amount
        );
    }

    public function exeResult($input){
        $result = array('id'=>$input['order_id']);
        if($input['response_code'] == self::SUCCESS_CODE){
            $postRs = $this->_postResult($input['trans_ref']);
            if($postRs['code'] == self::SUCCESS_CODE){
                $result['code'] = Constant::TXN_BANK_SUCCESS;
                $result['message'] = 'Giao dịch thành công';
                $result['card_name'] = $input['card_name'];
                $result['card_type'] = $input['card_type'];
            }else{
                $result['code'] = $this->_mapCode($postRs['code']);
                $result['message'] = $postRs['message'];
            }
        }else{
            $result['code'] = $this->_mapCode($input['response_code']);
            $result['message'] = $input['response_message'];
        }
        return $result;
    }

    private function _execPostRequest($url, $data)
    {
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

    private function _mapCode($code){
        $arr = array(
            '00' => Constant::TXN_BANK_SUCCESS,
            '01' => Constant::TXN_BANK_REFUSE,
            '02' => Constant::TXN_BANK_INVALID,
            '03' => Constant::TXN_BANK_INVALID,
            '04' => Constant::TXN_BANK_USER_ERROR,
            '05' => Constant::TXN_BANK_ERROR,
            '06' => Constant::TXN_BANK_ERROR,
            '07' => Constant::TXN_BANK_ACCOUNT_NOT_ENOUGH,
            '08' => Constant::TXN_BANK_ERROR,
            '09' => Constant::TXN_BANK_ERROR,
            '10' => Constant::TXN_BANK_FAIL,
            '11' => Constant::TXN_BANK_ERROR_OTP,
            '12' => Constant::TXN_BANK_OVER_LIMIT,
            '13' => Constant::TXN_BANK_NOT_INTERNETBANKING,
            '14' => Constant::TXN_BANK_ERROR_OTP,
            '15' => Constant::TXN_BANK_WRONG_INFO,
            '16' => Constant::TXN_BANK_WRONG_INFO,
            '17' => Constant::TXN_BANK_WRONG_INFO,
            '18' => Constant::TXN_BANK_WRONG_INFO,
            '19' => Constant::TXN_BANK_WRONG_INFO,
            '20' => Constant::TXN_BANK_ERROR_OTP,
            '21' => Constant::TXN_BANK_TIMEOUT,
            '22' => Constant::TXN_BANK_USER_ERROR,
            '23' => Constant::TXN_BANK_INVALID,
            '24' => Constant::TXN_BANK_OVER_LIMIT,
            '25' => Constant::TXN_BANK_OVER_LIMIT,
            '26' => Constant::TXN_BANK_PENDING,
            '27' => Constant::TXN_BANK_WRONG_INFO,
            '28' => Constant::TXN_BANK_ERROR,
            '99' => Constant::TXN_BANK_PENDING,
        );
        return isset($arr[$code]) ? $arr[$code] : Constant::TXN_BANK_PENDING;
    }
}