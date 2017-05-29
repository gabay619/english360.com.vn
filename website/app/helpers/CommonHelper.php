<?php

/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 11/18/2015
 * Time: 4:48 PM
 */
class CommonHelpers
{
    public static $slugArr = array(
            Constant::TYPE_FAMOUS => 'nguoi-noi-tieng',
            Constant::TYPE_SONG => 'bai-hat-tieng-anh',
            Constant::TYPE_VIDEO => 'video',
            Constant::TYPE_RADIO => 'radio',
            Constant::TYPE_FILM => 'phim',
            Constant::TYPE_DAILY => 'tieng-anh-hang-ngay',
            Constant::TYPE_IDIOM => 'thanh-ngu',
            Constant::TYPE_EXP => 'kinh-nghiem',
            Constant::TYPE_NEWS => 'tin-tuc',
            Constant::TYPE_GTCB => 'giao-tiep-co-ban',
            Constant::TYPE_TUDIEN => 'tu-dien',
            Constant::TYPE_LUYENNGUAM => 'luyen-ngu-am',
            Constant::TYPE_NGUPHAP => 'ngu-phap',
            Constant::TYPE_THUVIEN => 'thu-vien',
            Constant::TYPE_HOCMACHOI => 'hoc-ma-choi',
            Constant::TYPE_HOIDAP => 'hoi-dap',
            Constant::TYPE_SHARE => 'chia-se'
    );

    public static function encryptpassword($pass) {
        return md5(md5($pass));
    }

    public static function utf8_to_url($str) {
        $str = strip_tags(trim($str));
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);

        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/i", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str);
        $str = preg_replace(array('#(amp;|quot;|;)#', '#[^\d\w- ]#'), '', $str);
        $str = str_replace(array(" ", "----", "---", "--"), "-", trim($str));
        $str = strtolower($str);
        return mb_convert_encoding($str, "SJIS","UTF-8");
    }

    public static function getIdFromSlug($slug){
        $tmpArr = explode('-', $slug);
        return array_pop($tmpArr);
    }

    public static function getCateSlugbyType($type){
        $slugArr = static::$slugArr;

        return isset($slugArr[$type]) ? $slugArr[$type] : '';
    }

    public static function getTypebyCateSlug($cateSlug){
        foreach(static::$slugArr as $key=>$val){
            if($val == $cateSlug)
                return $key;
        }
        return false;
    }

    public static function getModelFromType($type){
        switch($type){
            case Constant::TYPE_GTCB:
                $model = 'GiaoTiepCoBan';
                break;
            case Constant::TYPE_SONG:
                $model = 'Song';
                break;
            case Constant::TYPE_LUYENNGUAM:
                $model = 'LuyenNguAm';
                break;
            case Constant::TYPE_NGUPHAP:
                $model = 'NguPhap';
                break;
            default:
                $model = 'ThuVien';
                break;
        }
        return $model;
    }

    public static function checkAnswerQuiz($ans, $select){
        return strtolower($ans) == strtolower($select);
    }

    public static function shuffle_assoc($list) {
        if (!is_array($list)) return $list;

        $keys = array_keys($list);
        shuffle($keys);
        $random = array();
        foreach ($keys as $key) {
            $random[$key] = $list[$key];
        }
        return $random;
    }

    public static function generateDienchu($short){
        return str_replace('_', '<input type="text" class="input_2 w20" />', $short);
        $shortArr = str_split($short);
        $ansArr = str_split($answer);
        $result = '';
        foreach($shortArr as $key=>$val){
            if($val == '_'){
                $result .= '<input type="text" class="input_2 w20" data-answer="'.$ansArr[$key].'" />';
            }else{
                $result .= $val;
            }
        }

        return $result;
    }
}