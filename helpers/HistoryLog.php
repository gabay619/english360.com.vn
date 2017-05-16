<?php

/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 4/15/2016
 * Time: 4:25 PM
 */
class HistoryLog
{
    //log action
    const LOG_XEM_BAI_HOC = 'lession';
    const LOG_XEM_BAI_HOC_PHIM = Constant::TYPE_FILM;
    const LOG_XEM_BAI_HOC_VIDEO = Constant::TYPE_VIDEO;
    const LOG_XEM_BAI_HOC_RADIO = Constant::TYPE_RADIO;
    const LOG_XEM_BAI_HOC_NGUOI_NOI_TIENG = Constant::TYPE_FAMOUS;
    const LOG_XEM_BAI_HOC_HANG_NGAY = Constant::TYPE_DAILY;
    const LOG_XEM_BAI_HOC_KINH_NGHIEM = Constant::TYPE_EXP;
    const LOG_XEM_BAI_HOC_THANH_NGU = Constant::TYPE_IDIOM;
    const LOG_XEM_BAI_HOC_BAI_HAT = Constant::TYPE_SONG;
    const LOG_XEM_BAI_HOC_GTCB = Constant::TYPE_GTCB;
    const LOG_XEM_BAI_HOC_NGU_AM = Constant::TYPE_LUYENNGUAM;
    const LOG_XEM_BAI_HOC_NGU_PHAP = Constant::TYPE_NGUPHAP;
    const LOG_GAME = 'game';
    const LOG_TU_DIEN ='tudien';
    const LOG_DANG_NHAP = 'login';
    const LOG_DANG_XUAT = 'logout';
    const LOG_DANG_KY = 'register';
    const LOG_DANG_KY_GOI_CUOC = 'package';
    const LOG_HUY_GOI_CUOC = 'canpack';
    const LOG_EDIT_PROFILE = 'e_profile';
    const LOG_HOI_DAP = 'hoidap';
    const LOG_TEST = 'test';

    //log chanel
    const CHANEL_WEB = 'WEB';
    const CHANEL_WAP = 'WAP';
    const CHANEL_APP = 'APP';

    public static function getArr(){
        return array(
            self::LOG_DANG_KY => 'Đăng ký',
            self::LOG_DANG_KY_GOI_CUOC => 'Đăng ký gói cước',
            self::LOG_DANG_NHAP => 'Đăng nhập',
            self::LOG_EDIT_PROFILE => 'Sửa thông tin cá nhân',
            self::LOG_GAME => 'Chơi trò chơi',
            self::LOG_HOI_DAP => 'Hỏi đáp',
            self::LOG_HUY_GOI_CUOC => 'Hủy gói cước',
//            self::LOG_XEM_BAI_HOC => 'Xem bài học',
            self::LOG_XEM_BAI_HOC_BAI_HAT => 'Xem bài học: Bài hát',
            self::LOG_XEM_BAI_HOC_NGU_AM => 'Xem bài học: Luyện ngữ âm',
            self::LOG_XEM_BAI_HOC_NGU_PHAP => 'Xem bài học: Ngữ pháp',
            self::LOG_XEM_BAI_HOC_GTCB => 'Xem bài học: Giao tiếp cơ bản',
            self::LOG_XEM_BAI_HOC_HANG_NGAY => 'Xem bài học: TA hàng ngày',
            self::LOG_XEM_BAI_HOC_KINH_NGHIEM => 'Xem bài học: Kinh nghiệm',
            self::LOG_XEM_BAI_HOC_NGUOI_NOI_TIENG => 'Xem bài học: Người nổi tiếng',
            self::LOG_XEM_BAI_HOC_THANH_NGU => 'Xem bài học: Thành ngữ',
            self::LOG_XEM_BAI_HOC_PHIM => 'Xem bài học: Phim',
            self::LOG_XEM_BAI_HOC_VIDEO => 'Xem bài học: Video',
            self::LOG_XEM_BAI_HOC_RADIO => 'Xem bài học: Radio',
            self::LOG_DANG_XUAT => 'Đăng xuất',
            self::LOG_TU_DIEN => 'Tra từ điển',
            self::LOG_TEST => 'Test trình độ'
        );
    }

    public static function getChanelArr(){
        return array(
            self::CHANEL_WAP => 'Wap',
            self::CHANEL_APP => 'App',
            self::CHANEL_WEB => 'Web'
        );
    }

    public static function getLogName($action){
        return isset(self::getArr()[$action]) ? self::getArr()[$action] : '';
    }
}