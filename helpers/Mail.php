<?php

namespace helpers;

/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 5/19/2016
 * Time: 9:51 AM
 */
use cURL;
class Mail
{
//    private $host = 'http://10.54.128.164:8080/WS_SendMail_E360/SendMailService?WSDL';
    private $baseUrl = 'http://mail.english360.com.vn';
    private $username = 'thongbao@english360.com.vn';
    private $password = 'Thongbao@123';
//    private $from = array('address'=>'thongbao@english360.vn', 'name'=>'English360');
    private $to, $subject, $body, $bcc;


    public function __construct($to, $subject='', $body='', $bcc=''){
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
        $this->bcc = $bcc;
        if(!$this->_checkLogin()){
            $this->_login();
        }
    }

//    public function send(){
//        try {
//            $client = new \SoapClient($this->host);
//        } catch (\Exception $e) {
//            return -1;
//            exit();
//        }
//        $opt = array(
//            "to" => $this->to,
//            "subject" => $this->subject,
//            "content" => $this->body
//        );
//        $result = $client->ActionSendMailPublic($opt);
//        $rs = trim($result->return);
//        $rs = explode('|',$rs)[0];
////        Common::saveLog(date('d/m/Y H:i:s').': reg-pack|'.$msisdn.'|'.$chanel.'|'.$result->return);
//        return $rs=='true';
//
//        $mail = new \PHPMailer();
//        $mail->isSMTP();
//        $mail->Host = $this->host;
//        $mail->SMTPAuth = true;
//        $mail->Username = $this->username;
//        $mail->Password = $this->password;
//        $mail->SMTPSecure = 'tls';
//        $mail->Port = 25;
//
//        $mail->setFrom($this->from['address'], $this->from['name']);
//        $mail->addAddress($this->to);
//        $mail->isHTML(true);
//        $mail->Subject = $this->subject;
//        $mail->Body = $this->body;
////        return true;
//        if(!$mail->send()) {
//            echo 'Message could not be sent.';
//            echo 'Mailer Error: ' . $mail->ErrorInfo;
//        } else {
//            echo 'Message has been sent';
//        }
////        return $mail->send();
//    }

    private function _getId(){
        $curl = new cURL();
        $url =  $this->baseUrl.'/?_task=mail&_action=compose';
        $content = $curl->get($url, true);
//    $result = get_headers($url);
//    print_r($result);die;
        preg_match('#<input type="hidden" name="_id" value="(.*)"><input type="hidden"#', $content, $matches);
//    return $matches;
        return $matches[1];
    }

    private function _getToken(){
        $curl = new cURL();
        $url =  $this->baseUrl;
        $content = $curl->get($url);
        preg_match('#<input type="hidden" name="_token" value="(.*)">#',$content,$_token);
        return $_token[1];
    }

    private function _checkLogin(){
        $curl = new cURL();
        $url = $this->baseUrl;
        $content = $curl->get($url);
        if(strpos($content,'<span class="username">thongbao@english360.com.vn</span>'))
            return true;
        return false;
    }

    private function _login(){
        $curl = new cURL();
        $url = $this->baseUrl.'/?_task=login';
        $data = array(
            '_token' => $this->_getToken(),
            '_task' => 'login',
            '_action' => 'login',
            '_timezone' => 'Asia/Jakarta',
            '_url' => '',
            '_user' => $this->username,
            '_pass' => $this->password
        );
        $curl->post($url, http_build_query($data));
        return;
    }

    public function send(){
        $curl = new cURL();
        $id = $this->_getId();
        $url = $this->baseUrl.'/?_task=mail&_action=compose&_id='.$id;
        $content = $curl->get($url);
        preg_match('#<input type="hidden" name="_token" value="(.*)">#',$content, $_token);
        $_token = $_token[1];
        $url =  $this->baseUrl.'/?_task=mail&_unlock=loading'.microtime(true).'&_lang=undefined&_framed=1';
        $data = array(
            '_token' => $_token,
            '_task' => 'mail',
            '_action' => 'send',
            '_id' => $id,
            '_attachments' => '',
            '_from' => 417,
            '_to' => $this->to,
            '_cc' => '',
            '_bcc' => $this->bcc,
            '_replyto' => '',
            '_followupto' => '',
            '_subject' => $this->subject,
            'editorSelector' => 'html',
            '_priority' => 0,
            '_store_target' => 'Sent',
            '_draft_saveid' => '',
            '_draft' => '',
            '_is_html' => 1,
            '_framed' => 1,
            '_message' => $this->body
        );
        //echo $body.PHP_EOL;
        $content = $curl->post($url, http_build_query($data));
        if(!strpos($content,'parent.rcmail.sent_successfully')){
            $content = $curl->post($url, http_build_query($data));
            if(!strpos($content,'parent.rcmail.sent_successfully')){
                return true;
            }else
                return false;
        }else
            return true;
    }

    public function sendVerifyEmail($verifyUrl, $base_url = \Constant::BASE_URL, $name=''){
        $this->subject = 'Xác nhận tài khoản English360.com.vn';
        $this->body = '<p>Xin chào '.$name.'</p>'.
        '<p>Để hoàn thành việc kích hoạt tài khoản, bạn vui lòng click vào đường link xác thực dưới đây:</p>'.
        '<p><a href="'.$verifyUrl.'">'.$verifyUrl.'</a></p>'.
        '<p>Tài khoản của bạn có thể sử dụng tất cả các dịch vụ của English360.</p>'.
        '<p>Cảm ơn bạn đã đồng hành cùng chúng tôi.</p>'.
        '<p>Nếu đây là một sự nhầm lẫn, vui lòng bỏ qua email này.</p>'.
        '<p>Ban quản trị English360</p>'.
        '<p>Hotline: '.\Constant::SUPPORT_PHONE.'; Email: cskh@english360.com.vn</p>';
        return self::send();
    }
}