<?php

class LinksController extends \BaseController {

    public function getNew(){
        return View::make('link.new');
    }

    public function postGenerateLink(){
        $linkRedirect = Input::get('link');
        $longUrl = Constant::BASE_URL.'/aff/'.Auth::user()->_id.'?redirect='.$linkRedirect;
        $ggApiUrl = 'https://www.googleapis.com/urlshortener/v1/url?key='.Constant::GOOLE_APP_KEY;
        $data = array(
            'longUrl' => $longUrl
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $ggApiUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CAINFO, NULL);
        curl_setopt($ch, CURLOPT_CAPATH, NULL);
        $output = curl_exec($ch);
        curl_close($ch);

        $rs = (array)json_decode($output);
        $shortUrl = $rs['id'];
        return Response::json(array('success'=>true, 'longUrl'=>$longUrl, 'shortUrl'=>$shortUrl));
    }
}