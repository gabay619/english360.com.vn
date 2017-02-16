<?php

namespace helpers;

/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 5/19/2016
 * Time: 9:51 AM
 */

class Mail
{
    private $host = 'http://10.54.128.164:8080/WS_SendMail_E360/SendMailService?WSDL';
    private $username = 'thongbao@english360.vn';
    private $password = 'thongbao@123';
    private $from = array('address'=>'thongbao@english360.vn', 'name'=>'English360');
    private $to, $subject, $body;


    public function __construct($to, $subject, $body){
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function setFrom($fromAdd, $fromName){
        $this->from = array(
            'address' => $fromAdd,
            'name' => $fromName
        );
    }

    public function send(){
        try {
            $client = new \SoapClient($this->host);
        } catch (\Exception $e) {
            return -1;
            exit();
        }
        $opt = array(
            "to" => $this->to,
            "subject" => $this->subject,
            "content" => $this->body
        );
        $result = $client->ActionSendMailPublic($opt);
        $rs = trim($result->return);
        $rs = explode('|',$rs)[0];
//        Common::saveLog(date('d/m/Y H:i:s').': reg-pack|'.$msisdn.'|'.$chanel.'|'.$result->return);
        return $rs=='true';

        $mail = new \PHPMailer();
        $mail->isSMTP();
        $mail->Host = $this->host;
        $mail->SMTPAuth = true;
        $mail->Username = $this->username;
        $mail->Password = $this->password;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 25;

        $mail->setFrom($this->from['address'], $this->from['name']);
        $mail->addAddress($this->to);
        $mail->isHTML(true);
        $mail->Subject = $this->subject;
        $mail->Body = $this->body;
//        return true;
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
//        return $mail->send();
    }
}