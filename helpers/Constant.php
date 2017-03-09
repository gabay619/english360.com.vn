<?php

/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 12/22/2015
 * Time: 4:45 PM
 */
class Constant
{
    const BASE_URL = 'http://english360.com.vn';
    const PLAYER_SKIN = 'bekle';
    const PLAYER_SUB_COLOR = '#FFF';
    const PLAYER_SUB_CONFIG =   'color: "#FFF",
                                backgroundOpacity: 75,
                                edgeStyle : "raised"';
    const FACEBOOK_URL = 'https://www.facebook.com/english360.vn';
    const STATUS_ENABLE = '1';
    const STATUS_DISABLE = '0';
    const TYPE_NONE = 'none';
    const TYPE_FAMOUS = 'famous';
    const TYPE_SONG = 'song';
    const TYPE_VIDEO = 'video';
    const TYPE_RADIO = 'radio';
    const TYPE_FILM = 'film';
    const TYPE_DAILY = 'daily';
    const TYPE_IDIOM = 'idiom';
    const TYPE_EXP = 'exp';
    const TYPE_NEWS = 'news';
    const TYPE_GTCB = 'giaotiepcoban';
    const TYPE_TUDIEN = 'tudien';
    const TYPE_LUYENNGUAM = 'luyennguam';
    const TYPE_NGUPHAP = 'nguphap';
    const TYPE_THUVIEN = 'thuvien';
    const TYPE_HOCMACHOI = 'hocmachoi';
    const TYPE_HOIDAP = 'hoidap';
    const TYPE_COMMENT = 'comment';
    const TYPE_NOTIFY = 'notify';
    const TYPE_INFO = 'info';
    const TYPE_TERM = 'term';
    const TYPE_CONTACT = 'contact';
    const TYPE_DOWNLOAD = 'download';
    const LEVEL_HARD = 'hard';
    const LEVEL_EASY = 'easy';
    const MAX_CONTENT_FREE = 10;
    const MAX_CONTENT_CATE_FREE = 2;
    const SUPPORT_PHONE = '0432474175';
    const CONFIG_AUTH = 'AUTH_ADMIN';
    const CONFIG_1TOUCH = '1TOUCH';
    const CONFIG_1_5TOUCH = '1_5TOUCH';
    const CONFIG_POPUP_REG = 'PREG';
    const BANNER_WEB_FOOTER = 'webfooter';
    const BANNER_WAP_FIXED = 'wapfixed';
    const BANNER_WEB_HEADER = 'webheader';
    const FACEBOOK_APP_ID = '1539737363001576';
    const FACEBOOK_APP_KEY = '4e2fd0ebbaacbaca83e713c966d1969d';
    const GOOGLE_APP_ID = '440039211672-b01gs92p5nc2iuke6j3mfjfhgcl02p1e.apps.googleusercontent.com';
    const GOOGLE_APP_SECRET = 'M2yzirHAhLJexKk-Fk-_Ztd2';
    const GOOLE_APP_KEY = 'AIzaSyAn7B6h2yxxCSAx3mb-6ZcnlWKvCKuDWTI';
    const CASH_NAME = 'Số dư';
    
    //Txn Card
    const TXN_CARD_SUCCESS = 1;
    const TXN_CARD_USED = 2;
    const TXN_CARD_PENDING = 0;
    const TXN_CARD_PROVIDER_ERROR = 3;
    const TXN_CARD_LOCKED = 4;
    const TXN_CARD_INVALID = 5;
    const TXN_CARD_PIN_INVALID = 6;
    const TXN_CARD_SERI_INVALID = 6;
    const CARD_TO_CASH = 1;
    const CARD_METHOD_NAME = 'card';
    //Cardtype
    const CARD_TYPE_VIETTEL = 'VTE';
    const CARD_TYPE_MOBIFONE = 'VMS';
    const CARD_TYPE_VINAPHONE = 'VNP';
    //Txn Bank
    const TXN_BANK_SUCCESS = 1;
    const TXN_BANK_REFUSE = 2;
    const TXN_BANK_INVALID = 3;
    const TXN_BANK_USER_ERROR = 4;
    const TXN_BANK_ERROR = 5;
    const TXN_BANK_ACCOUNT_NOT_ENOUGH = 6;
    const TXN_BANK_FAIL = 7;
    const TXN_BANK_WRONG_INFO = 8;
    const TXN_BANK_NOT_INTERNETBANKING = 9;
    const TXN_BANK_ERROR_OTP = 10;
    const TXN_BANK_OVER_LIMIT = 11;
    const TXN_BANK_TIMEOUT = 12;
    const TXN_BANK_PENDING = 13;
    const BANK_TO_CASH = 1;
    const BANK_METHOD_NAME = 'bank';

    //Txn Sms
    const TXN_SMS_SUCCESS = 'WCG-0000';
    const TXN_SMS_INVALID = 'WCG-0001';
    const TXN_SMS_ERROR = 'WCG-0002';
    const TXN_SMS_NOT_ENOUGH = 'WCG-0005';
    const SMS_TO_CASH = 1;
    const SMS_METHOD_NAME = 'sms';

    //Txn Otp
    const TXN_OTP_SUCCESS = 0;
    const TXN_OTP_PROVIDER_ERROR = 1;
    const TXN_OTP_MSISDN_INVALID = 2;
    const TXN_OTP_SENT_ERROR = 3;
    const TXN_OTP_ACCOUNT_NOT_ENOUGH = 4;
    const TXN_OTP_INPUT_WRONG = 5;
    const TXN_OTP_TOO_MUCH = 6;
    const TXN_OTP_SENT_SUCCESS = 7;
    const TXN_OTP_ERROR = 8;
    const OTP_TO_CASH =1;
    const OTP_METHOD_NAME = 'otp';

    //Aff
    const AFF_SECRET_KEY = 'rAlFu8v6KxcBTYgJm7Tq';
    const AFF_COOKIE_NAME = 'aff_uid';
    const AFF_COOKIE_EXPIRED = 86400*60;
    const AFF_RATE_CARD = 0.3;
    const AFF_RATE_BANK = 0.3;
    const AFF_RATE_SMS = 0.3;
    const AFF_RATE_OTP = 0.3;

    //Withdraw
    const WITHDRAW_STATUS_NEW = 1;
    const WITHDRAW_STATUS_COMPLETE = 2;
    const WITHDRAW_STATUS_CANCEL = 3;   
    const WITHDRAW_MIN_PAY = 1000;
}