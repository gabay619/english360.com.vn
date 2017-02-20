<?php

/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 12/16/2015
 * Time: 8:44 AM
 */
class Network
{

    const MOBIFONE = 1;
    const IP_SERVICE = '10.54.128.164';
    const USER = "wap";
    const PASSWORD = "wap$6789";
    const VMS_ID = "136";
    const KEY_VMS = "MaOC86Pp81h1735b";
    const OPEN_REG = true;
    const OPEN_REG_WEB = true;

    public static function getIpService(){
        $file = __DIR__ . '/../config/service_ip.txt';
        $ofile = fopen($file, "r");
        $content = fgets($ofile);
        fclose($ofile);
        $ip = static::IP_SERVICE;
        if ($content)
            $ip = trim($content);
        return $ip;
    }

    public static function getLinkService()
    {
        $ip = static::getIpService();
        return "http://" . $ip . ":8080/ServiceEnglish/Service?WSDL";
    }

    public static function ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function reversephone($phone)
    {
        $phone = str_replace("+", "", $phone);
        $rest = substr($phone, 0, 1);
        if ($rest == '0') {
            $phone = "84" . substr($phone, 1);
        }
        $rest = substr($phone, 0, 2);
        if ($rest != '84') {
            $phone = "84" . $phone;
        }
        return $phone;
    }

    public static function reversephoneToZero($phone){
        $phone = str_replace("+", "", $phone);
        $rest = substr($phone, 0, 2);
        if ($rest == '84') {
            $phone = "0" . substr($phone, 2);
        }
        $rest = substr($phone, 0, 1);
        if ($rest != '0') {
            $phone = "0" . $phone;
        }
        return $phone;
    }

    public static function is3g()
    {
        $phone = isset($_SERVER['HTTP_MSISDN']) ? $_SERVER['HTTP_MSISDN'] : '';
        if ($phone) {
            $rest = substr($phone, 0, 2);
            if ($rest == '84') {
                $phone = "0" . substr($phone, 2);
            }
        }
        return $phone;
    }

    public static function is3gmobifone()
    {
//        return 1;
        $file = __DIR__ . '/../config/mobile_ip.txt';
        $lines = file($file);
        $ip = static::ip();
        foreach ($lines as $line) if (static::ip_in_range($ip, $line) == true) return 1;
        return 0;
    }

    protected static function ip_in_range($ip, $range)
    {
        if (strpos($range, '/') == false)
            $range .= '/32';
        list($range, $netmask) = explode('/', $range, 2);
        $range_decimal = ip2long($range);
        $ip_decimal = ip2long($ip);
        $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
        $netmask_decimal = ~$wildcard_decimal;
        return (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal));
    }

    public static function mobifoneNumber($phone)
    {
        return true;
        $mobileFoneRegex = '/^(84|0)?(89|90|93|120|121|122|126|128)\d{7}$/';
        if (preg_match($mobileFoneRegex, $phone) == true) {
            return true;
        } else {
            return false;
        }
    }

    public static function registedpack($msisdn, $chanel = "WEB", $code = "E")
    {
        if(!self::OPEN_REG && !self::OPEN_REG_WEB) return 3;
        try {
            $client = new SoapClient(static::getLinkService(),array('cache_wsdl'=>WSDL_CACHE_NONE));
        } catch (Exception $e) {
            return -1;
            exit();
        }
        $msisdn = static::reversephone($msisdn);
        $type = "WIFI";
        if (static::is3g())
            $type = "3G";
        $opt = array(
                "channel" => $chanel,
                "msisdn" => "$msisdn",
                "packageCode" => $code,
                "userName" => static::USER,
                "password" => static::PASSWORD,
                "typeinternet" => $type,
        );
        $result = $client->registerService($opt);
        Common::saveLog(date('d/m/Y H:i:s').': reg-pack|'.$msisdn.'|'.$chanel.'|'.$result->return);
        return trim($result->return);
    }

    public static function cancelpack($msisdn, $chanel = "WAP", $code = "E")
    {
        try {
            $client = new SoapClient(static::getLinkService(),array('cache_wsdl'=>WSDL_CACHE_NONE));
        } catch (Exception $e) {
            return -1;
            exit();
        }
        $msisdn = static::reversephone($msisdn);
        $type = "WIFI";
        if (static::is3g())
            $type = "3G";
        $opt = array(
                "channel" => $chanel,
                "msisdn" => "$msisdn",
                "packageCode" => $code,
                "userName" => static::USER,
                "password" => static::PASSWORD,
                "typeinternet" => $type,
        );
        $result = $client->unregisterService($opt);
        Common::saveLog(date('d/m/Y H:i:s').': can-pack|'.$msisdn.'|'.$chanel.'|'.$result->return);
        return trim($result->return);
    }

    public static function getUserInfo($msisdn, $serviceCode = "E", $uid='')
    {
        return 1;
        if(Common::isTestUser($msisdn) || Common::isFreeUser($msisdn)) return 1;
        if(!empty($uid)){
            if(Common::isHssvUser($uid)) return 1;
            if(Common::isEventUser($uid)) return 1;
        }

        try {
            $client = new SoapClient(static::getLinkService(),array('cache_wsdl'=>WSDL_CACHE_NONE));
        } catch (Exception $e) {
            return -1;
        }
        $msisdn = static::reversephone($msisdn);
        $opt = array(
                "msisdn" => "$msisdn",
                "packageCode" => $serviceCode,
                "userName" => static::USER,
                "password" => static::PASSWORD,
        );
        $result = $client->getRegisterInfo($opt);
//        echo $client->__getLastRequest();
        return trim($result->return);
    }

    public static function getRealUserInfo($msisdn, $serviceCode = "E")
    {
        try {
            $client = new SoapClient(static::getLinkService(),array('cache_wsdl'=>WSDL_CACHE_NONE));
        } catch (Exception $e) {
            return -1;
        }
        $msisdn = static::reversephone($msisdn);
        $opt = array(
            "msisdn" => "$msisdn",
            "packageCode" => $serviceCode,
            "userName" => static::USER,
            "password" => static::PASSWORD,
        );
        $result = $client->getRegisterInfo($opt);
//        echo $client->__getLastRequest();
        return trim($result->return);
    }

    public static function getChargeStatus($msisdn, $serviceCode = "E"){
        try {
            $client = new SoapClient(static::getLinkService(),array('cache_wsdl'=>WSDL_CACHE_NONE));
        } catch (Exception $e) {
            return -1;
            exit();
        }
        $msisdn = static::reversephone($msisdn);
        $opt = array(
                "msisdn" => "$msisdn",
                "packageCode" => $serviceCode,
                "userName" => static::USER,
                "password" => static::PASSWORD,
        );
        $result = $client->getChargeStatus($opt);
        return trim($result->return);
    }

    public static function getCancelInfo($msisdn, $serviceCode = "E")
    {
        try {
            $client = new SoapClient(static::getLinkService(),array('cache_wsdl'=>WSDL_CACHE_NONE));
        } catch (Exception $e) {
            return -1;
            exit();
        }
        $msisdn = static::reversephone($msisdn);
        $opt = array(
                "msisdn" => "$msisdn",
                "packageCode" => $serviceCode,
                "userName" => static::USER,
                "password" => static::PASSWORD,
        );
        $result = $client->getCancelInfo($opt);
        return $result->return;
    }

    public static function sendToDaily($msisdn){
//        return 1;
        if(static::getUserInfo($msisdn) == 1) return 1;
        try {
            $client = new SoapClient(static::getLinkService(),array('cache_wsdl'=>WSDL_CACHE_NONE));
        } catch (Exception $e) {
            return -1;
            exit();
        }
        $msisdn = static::reversephone($msisdn);
        $opt = array(
            "msisdn" => "$msisdn",
            "userName" => static::USER,
            "password" => static::PASSWORD,
        );
        $result = $client->sendaySMS($opt);
        Common::saveLog(date('d/m/Y H:i:s').': reg-daily|'.$msisdn.'|'.$result->return);
        return trim($result->return);
    }

    public static function TCSMS($msisdn)
    {
        return 1;
        try {
            $client = new SoapClient(static::getLinkService(),array('cache_wsdl'=>WSDL_CACHE_NONE));
        } catch (Exception $e) {
            return -1;
            exit();
        }
        $msisdn = static::reversephone($msisdn);
        $opt = array(
            "msisdn" => "$msisdn",
            "userName" => static::USER,
            "password" => static::PASSWORD,
        );
        $result = $client->TCSMS($opt);
        return trim($result->return);
    }

    public static function DKSMS($msisdn)
    {
        return 1;
        try {
            $client = new SoapClient(static::getLinkService(),array('cache_wsdl'=>WSDL_CACHE_NONE));
        } catch (Exception $e) {
            return -1;
            exit();
        }
        $msisdn = static::reversephone($msisdn);
        $opt = array(
            "msisdn" => "$msisdn",
            "userName" => static::USER,
            "password" => static::PASSWORD,
        );
        $result = $client->DKSMS($opt);
        return trim($result->return);
    }

    public static function checkTCSMS($msisdn)
    {
        return 1;
//        if(Common::isTestUser($msisdn)) return 1;
        try {
            $client = new SoapClient(static::getLinkService(),array('cache_wsdl'=>WSDL_CACHE_NONE));
        } catch (Exception $e) {
            return -1;
            exit();
        }
        $msisdn = static::reversephone($msisdn);
        $opt = array(
            "msisdn" => "$msisdn",
            "userName" => static::USER,
            "password" => static::PASSWORD,
        );
        $result = $client->checkTCSMS($opt);
        return trim($result->return);
    }

    public static function sentMT($msisdn, $comandcode = "INVALID", $info)
    {
        try {
            $client = new SoapClient(static::getLinkService(),array('cache_wsdl'=>WSDL_CACHE_NONE));
        } catch (Exception $e) {
            Common::saveLog(date('d/m/Y H:i:s').': sentMT|Service Error');
            return -1;
            exit();
        }
//        $codau = Common::isSmartphone($msisdn);
        $msisdn = static::reversephone($msisdn);
        $opt = array(
                "userId" => "$msisdn",
                "shortCode" => "9317",
                "commandCode" => $comandcode,
                "serviceCode" => $comandcode,
                "info" => $info,
                "location" => "HN",
        );
        $result = $client->sendMT($opt);
        $result = trim($result->return);
        if($result != 0)
            Common::saveLog(date('d/m/Y H:i:s').': sentMT|'.$msisdn.'|'.$info.'|'.$result);

        return $result;
    }

    public static function paymentClient($msisdn, $price, $chanel = "WAP")
    {
        $msisdn = static::reversephone($msisdn);
        try {
            $client = new SoapClient(static::getLinkService(),array('cache_wsdl'=>WSDL_CACHE_NONE));
        } catch (Exception $e) {
            return -1;
            exit();
        }
        $opt = array(
                "msisdn" => "$msisdn",
                "commandCode" => "TUVAN",
                "packageCode" => "TUVAN",
                "price" => "$price",
                "channel" => $chanel,
                "chargeType" => "TUVAN",
                "userName" => static::USER,
                "password" => static::PASSWORD,
        );
        $result = $client->chargeSubscriber($opt);
        return trim($result->return);
    }

    public static function genLinkConfirmVms($pkg, $link_confirm, $trans_id = '')
    {
        $msisdn = static::is3g();
        $result = static::getCancelInfo($msisdn, $pkg);
        $arr_pack = static::getPackageItem();
        $trans_id = !empty($trans_id) ? $trans_id : time() . rand(100, 999);
        $info = str_replace("&#", "##", static::UniToDecimal($arr_pack[$pkg]['info']));
        $free_circle = $arr_pack[$pkg]['cirlce'];
        $price = $arr_pack[$pkg]['price'];
        $circle = $arr_pack[$pkg]['free_cirlce'];
        $customer_care = '9090';
        $price_customer_care = '200';
        if ($result <= 0 && $pkg == "E") {
            $price = 0;
            $info = str_replace("&#", "##", static::UniToDecimal($arr_pack[$pkg]['infomationquery']));
        }
        $data = $trans_id . '&' . $pkg . '&' . $price . '&' . $link_confirm . '&' . $info;
        $string_aes128 = base64_encode(static::aes128_ecb_encrypt(static::KEY_VMS, $data, ''));
        $link_confirm_vms = 'http://dangky.mobifone.com.vn/wap/html/sp/confirm.jsp?sp_id=' . static::VMS_ID . '&link=' . $string_aes128;
        return $link_confirm_vms;
    }

    public static function genNewLinkConfirmVms($pkg, $link_confirm, $trans_id = '')
    {
        $msisdn = static::is3g();
        $result = static::getCancelInfo($msisdn, $pkg);
        $arr_pack = static::getPackageItem();
        $trans_id = !empty($trans_id) ? $trans_id : time() . rand(100, 999);
        $info = str_replace("&#", "##", static::UniToDecimal($arr_pack[$pkg]['info']));
        $free_circle = $arr_pack[$pkg]['cirlce'];
        $price = $arr_pack[$pkg]['price'];
        $circle = $arr_pack[$pkg]['free_cirlce'];
        $customer_care = '9090';
        $price_customer_care = '200';
        if ($result <= 0 && $pkg == "E") {
            $price = 0;
            $info = str_replace("&#", "##", static::UniToDecimal($arr_pack[$pkg]['infomationquery']));
        }
        $data = $trans_id . '&' . $pkg . '&' . $free_circle . '&' . $price . '&' . $customer_care . '&' . $price_customer_care .'&' . $link_confirm;
        $string_aes128 = base64_encode(static::aes128_ecb_encrypt(static::KEY_VMS, $data, ''));
        $link_confirm_vms = 'http://dangky.mobifone.com.vn/wap/html/sp/confirm.jsp?sp_id=' . static::VMS_ID . '&link=' . $string_aes128;
        return $link_confirm_vms;
    }

    public static function genLinkConfirmAppVms($pkg, $link_confirm, $trans_id = '')
    {
        $msisdn = static::is3g();
        $result = static::getCancelInfo($msisdn, $pkg);
        $arr_pack = static::getPackageItem();
        $trans_id = !empty($trans_id) ? $trans_id : time() . rand(100, 999);
        $info = str_replace("&#", "##", static::UniToDecimal($arr_pack[$pkg]['info']));
        $free_circle = $arr_pack[$pkg]['cirlce'];
        $price = $arr_pack[$pkg]['price'];
        $circle = $arr_pack[$pkg]['free_cirlce'];
        $customer_care = '9090';
        $price_customer_care = '200';
        if ($result <= 0 && $pkg == "E") {
            $price = 0;
            $info = str_replace("&#", "##", static::UniToDecimal($arr_pack[$pkg]['infomationquery']));
        }
        $data = $trans_id . '&' . $pkg . '&' . $free_circle . '&' . $price . '&' . $customer_care . '&' . $price_customer_care .'&' . $link_confirm;
        $string_aes128 = base64_encode(static::aes128_ecb_encrypt(static::KEY_VMS, $data, ''));
        $link_confirm_vms = 'http://dangky.mobifone.com.vn/wap/html/appsp/confirm.jsp?sp_id=' . static::VMS_ID . '&link=' . $string_aes128;
        return $link_confirm_vms;
    }


    public static function aes128_ecb_encrypt($key, $data, $iv)
    {
        if (16 !== strlen($key)) $key = hash('MD5', $key, true);
        if (16 !== strlen($iv)) $iv = hash('MD5', $iv, true);
        $padding = 16 - (strlen($data) % 16);
        $data .= str_repeat(chr($padding), $padding);
        return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_ECB, $iv);
    }

    public static function aes128_ecb_decrypt($key, $data, $iv)
    {
        if (16 !== strlen($key)) $key = hash('MD5', $key, true);
        if (16 !== strlen($iv)) $iv = hash('MD5', $iv, true);
        $data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_ECB, $iv);
        $padding = ord($data[strlen($data) - 1]);
        return substr($data, 0, -$padding);
    }

    protected static function UniToDecimal($str)
    {
        $convmap = array(
                0xe1, 0xe1, 0x0, 0xe1, 0xc1, 0xc1, 0x0, 0xc1, 0xe0, 0xe0, 0x0, 0xe0, 0xc0, 0xc0, 0x0, 0xc0, 0x1ea3, 0x1ea3, 0x0, 0x1ea3
        , 0x1ea2, 0x1ea2, 0x0, 0x1ea2, 0xe3, 0xe3, 0x0, 0xe3, 0xc3, 0xc3, 0x0, 0xc3, 0x1ea1, 0x1ea1, 0x0, 0x1ea1, 0x1ea0, 0x1ea0, 0x0, 0x1ea0,
                0x103, 0x103, 0x0, 0x103, 0x102, 0x102, 0x0, 0x102, 0x1eaf, 0x1eaf, 0x0, 0x1eaf, 0x1eae, 0x1eae, 0x0, 0x1eae, 0x1eb1, 0x1eb1, 0x0, 0x1eb1, 0x1eb0,
                0x1eb0, 0x0, 0x1eb0, 0x1eb3, 0x1eb3, 0x0, 0x1eb3, 0x1eb2, 0x1eb2, 0x0, 0x1eb2, 0x1eb5
        , 0x1eb5, 0x0, 0x1eb5, 0x1eb4, 0x1eb4, 0x0, 0x1eb4, 0x1eb7, 0x1eb7, 0x0, 0x1eb7, 0x1eb6, 0x1eb6, 0x0, 0x1eb6, 0xe2, 0xe2, 0x0, 0xe2, 0xc2, 0xc2, 0x0, 0xc2, 0x1ea5, 0x1ea5, 0x0, 0x1ea5, 0x1ea4, 0x1ea4, 0x0, 0x1ea4, 0x1ea7, 0x1ea7, 0x0, 0x1ea7, 0x1ea6, 0x1ea6, 0x0, 0x1ea6, 0x1ea9,
                0x1ea9, 0x0, 0x1ea9, 0x1ea8, 0x1ea8, 0x0, 0x1ea8, 0x1eab, 0x1eab, 0x0, 0x1eab, 0x1eaa, 0x1eaa, 0x0, 0x1eaa, 0x1ead,
                0x1ead, 0x0, 0x1ead, 0x1eac, 0x1eac, 0x0, 0x1eac, 0xe9, 0xe9, 0x0, 0xe9, 0xc9, 0xc9, 0x0, 0xc9, 0xe8, 0xe8, 0x0, 0xe8,
                0xc8, 0xc8, 0x0, 0xc8,
                0x1ebb, 0x1ebb, 0x0, 0x1ebb, 0x1eba, 0x1eba, 0x0, 0x1eba, 0x1ebd, 0x1ebd, 0x0, 0x1ebd, 0x1ebc, 0x1ebc, 0x0, 0x1ebc,
                0x1eb9, 0x1eb9, 0x0, 0x1eb9, 0x1eb8, 0x1eb8, 0x0, 0x1eb8, 0xea, 0xea, 0x0, 0xea, 0xca, 0xca, 0x0, 0xca, 0x1ebf, 0x1ebf, 0x0, 0x1ebf, 0x1ebe,
                0x1ebe, 0x0, 0x1ebe, 0x1ec1, 0x1ec1, 0x0, 0x1ec1, 0x1ec0, 0x1ec0, 0x0, 0x1ec0, 0x1ec3, 0x1ec3, 0x0, 0x1ec3, 0x1ec2,
                0x1ec2, 0x0, 0x1ec2, 0x1ec5, 0x1ec5, 0x0, 0x1ec5, 0x1ec4, 0x1ec4, 0x0, 0x1ec4, 0x1ec7, 0x1ec7, 0x0, 0x1ec7, 0x1ec6,
                0x1ec6, 0x0, 0x1ec6,
                0xed, 0xed, 0x0, 0xed, 0xcd, 0xcd, 0x0, 0xcd, 0xec, 0xec, 0x0, 0xec, 0xcc, 0xcc, 0x0, 0xcc, 0x1ec9, 0x1ec9, 0x0, 0x1ec9
        , 0x1ec8, 0x1ec8, 0x0, 0x1ec8, 0x1ecb, 0x1ecb, 0x0, 0x1ecb, 0x1eca, 0x1eca, 0x0, 0x1eca, 0xf3, 0xf3, 0x0, 0xf3, 0xd3,
                0xd3, 0x0, 0xd3, 0xf2,
                0xf2, 0x0, 0xf2, 0xd2, 0xd2, 0x0, 0xd2, 0x1ecf, 0x1ecf, 0x0, 0x1ecf, 0x1ece, 0x1ece, 0x0, 0x1ece, 0xf5, 0xf5, 0x0, 0xf5, 0xd5, 0xd5, 0x0, 0xd5, 0x1ecd, 0x1ecd, 0x0, 0x1ecd, 0x1ecc, 0x1ecc, 0x0, 0x1ecc, 0x1a1, 0x1a1, 0x0, 0x1a1, 0x1a0, 0x1a0, 0x0, 0x1a0, 0x1edb, 0x1edb, 0x0, 0x1edb, 0x1eda, 0x1eda, 0x0, 0x1eda, 0x1edd, 0x1edd, 0x0, 0x1edd, 0x1edc, 0x1edc, 0x0, 0x1edc, 0x1edf,
                0x1edf, 0x0, 0x1edf, 0x1ede, 0x1ede, 0x0, 0x1ede, 0x1ee1, 0x1ee1, 0x0, 0x1ee1, 0x1ee0, 0x1ee0, 0x0, 0x1ee0, 0x1ee3,
                0x1ee3, 0x0, 0x1ee3,
                0x1ee2, 0x1ee2, 0x0, 0x1ee2, 0xf4, 0xf4, 0x0, 0xf4, 0xd4, 0xd4, 0x0, 0xd4, 0x1ed1, 0x1ed1, 0x0, 0x1ed1, 0x1ed0, 0x1ed0, 0x0, 0x1ed0, 0x1ed3, 0x1ed3, 0x0, 0x1ed3, 0x1ed2, 0x1ed2, 0x0, 0x1ed2, 0x1ed5, 0x1ed5, 0x0, 0x1ed5, 0x1ed4, 0x1ed4, 0x0, 0x1ed4, 0x1ed7,
                0x1ed7, 0x0, 0x1ed7, 0x1ed6, 0x1ed6, 0x0, 0x1ed6, 0x1ed9, 0x1ed9, 0x0, 0x1ed9, 0x1ed8, 0x1ed8, 0x0, 0x1ed8, 0xfa, 0xfa, 0x0, 0xfa, 0xda, 0xda, 0x0, 0xda, 0xf9, 0xf9, 0x0, 0xf9, 0xd9, 0xd9, 0x0, 0xd9, 0x1ee7, 0x1ee7, 0x0, 0x1ee7, 0x1ee6
        , 0x1ee6, 0x0, 0x1ee6,
                0x169, 0x169, 0x0, 0x169, 0x168, 0x168, 0x0, 0x168, 0x1ee5, 0x1ee5, 0x0, 0x1ee5, 0x1ee4, 0x1ee4, 0x0, 0x1ee4, 0x1b0,
                0x1b0, 0x0, 0x1b0, 0x1af, 0x1af, 0x0, 0x1af, 0x1ee9, 0x1ee9, 0x0, 0x1ee9, 0x1ee8, 0x1ee8, 0x0, 0x1ee8, 0x1eeb, 0x1eeb, 0x0, 0x1eeb, 0x1eea,
                0x1eea, 0x0, 0x1eea, 0x1eed, 0x1eed, 0x0, 0x1eed, 0x1eec, 0x1eec, 0x0, 0x1eec, 0x1eef, 0x1eef, 0x0, 0x1eef, 0x1eee,
                0x1eee, 0x0, 0x1eee, 0x1ef1, 0x1ef1, 0x0, 0x1ef1, 0x1ef0, 0x1ef0, 0x0, 0x1ef0, 0xfd, 0xfd, 0x0, 0xfd, 0xdd, 0xdd, 0x0
        , 0xdd, 0x1ef3, 0x1ef3,
                0x0, 0x1ef3, 0x1ef2, 0x1ef2, 0x0, 0x1ef2, 0x1ef7, 0x1ef7, 0x0, 0x1ef7, 0x1ef6, 0x1ef6, 0x0, 0x1ef6, 0x1ef9, 0x1ef9,
                0x0, 0x1ef9, 0x1ef8, 0x1ef8, 0x0, 0x1ef8, 0x1ef5, 0x1ef5, 0x0, 0x1ef5, 0x1ef4, 0x1ef4, 0x0, 0x1ef4, 0x111, 0x111, 0x0, 0x111, 0x110, 0x110, 0x0, 0x110,
                0x128, 0x128, 0x0, 0x128, 0x129, 0x129, 0x0, 0x129,
        );
        return mb_encode_numericentity($str, $convmap, "UTF-8");
    }

    public static function getPackageItem()
    {
        $list = array(
                'E' => array('price' => '2000', 'circle'=> 1, 'free_circle'=>1 ,'info' => 'ngày', 'infomationquery' => '2.000đ/ ngày||Miễn phí 1 ngày'),
        );

        return $list;
    }
}