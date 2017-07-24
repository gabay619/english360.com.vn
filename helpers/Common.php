<?php

/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 12/16/2015
 * Time: 8:32 AM
 */
class Common
{
    public static function getAllCategoryType(){
        $categorytype[] = array("name" => "None", "key" => Constant::TYPE_NONE);
        $categorytype[] = array("name" => "Người nổi tiếng", "key" => Constant::TYPE_FAMOUS);
        $categorytype[] = array("name" => "Bài hát tiếng Anh", "key" => Constant::TYPE_SONG);
        $categorytype[] = array("name" => "Video", "key" => Constant::TYPE_VIDEO);
        $categorytype[] = array("name" => "Radio", "key" => Constant::TYPE_RADIO);
        $categorytype[] = array("name" => "Phim", "key" => Constant::TYPE_FILM);
        $categorytype[] = array("name" => "Tiếng Anh hàng ngày", "key" => Constant::TYPE_DAILY);
        $categorytype[] = array("name" => "Thành ngữ", "key" => Constant::TYPE_IDIOM);
        $categorytype[] = array("name" => "Kinh nghiệm", "key" => Constant::TYPE_EXP);
        $categorytype[] = array("name" => "Tin tức", "key" => Constant::TYPE_NEWS);
        $categorytype[] = array("name" => "Giao tiếp cơ bản", "key" => Constant::TYPE_GTCB);
        $categorytype[] = array("name" => "Từ điển", "key" => Constant::TYPE_TUDIEN);
        $categorytype[] = array("name" => "Luyện ngữ âm", "key" => Constant::TYPE_LUYENNGUAM);
        $categorytype[] = array("name" => "Ngữ pháp", "key" => Constant::TYPE_NGUPHAP);
        $categorytype[] = array("name" => "Thư viện", "key" => Constant::TYPE_THUVIEN);
        $categorytype[] = array("name" => "Học mà chơi", "key" => Constant::TYPE_HOCMACHOI);
        $categorytype[] = array("name" => "Hỏi đáp", "key" => Constant::TYPE_HOIDAP);
        $categorytype[] = array("name" => "Chia sẻ", "key" => Constant::TYPE_SHARE);
        $categorytype[] = array("name" => "Giao tiếp hàng ngày", "key" => Constant::TYPE_GT_HANGNGAY);
        $categorytype[] = array("name" => "Giao tiếp cho người đi làm", "key" => Constant::TYPE_GT_DILAM);
        $categorytype[] = array("name" => "Chia sẻ", "key" => Constant::TYPE_SHARE);
        return $categorytype;
    }

    public static function getAllGameDegree(){
        return array(
            Constant::LEVEL_EASY => 'Dễ',
            Constant::LEVEL_HARD => 'Khó'
        );
    }

    public static function cleanstring($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

    public static function getiteminarray($array, $member, $value) {
        foreach ($array as $i) if ($i["$member"] == $value) return $i;
    }

    public static function isacceptpermission($key) {
        $listpermiss = $_SESSION['permission'];
        if (is_array($key)) {
            foreach ($key as $item) {
                if (in_array($item, $listpermiss)) return true;
            }
        }
        else return in_array($key, $listpermiss);
        return false;
    }

    public static function curPageURL() {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        }
        else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    public static function cpagerparm($para_need_remove, $replace_space = 0) {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        }
        else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        if ($replace_space == 1) return str_replace(' ', '+', static::removeqsvar($pageURL, $para_need_remove));
        else return static::removeqsvar($pageURL, $para_need_remove);
    }

    public static function removeqsvar($url, $varname) {
        $pa = $_GET;
        $s = explode(',', $varname);
        $str = '';
        foreach ($s as $item) unset($pa[$item]);
        foreach ($pa as $key => $val) {
            if (is_array($val)) {
                foreach ($val as $sitem) $hs .= $key . '[]=' . $sitem . '&';
                $str .= $hs;
            }
            else $str .= $key . '=' . $val . '&';
        }
        $str = str_replace('?', '&', $str);
        $link = explode('?', $url);
        $link = $link[0] . '?' . $str;
        return $link;
    }

    public static function removeallspace($string) {
        $string = preg_replace('/\s+/', '', $string);
        return $string;
    }

    public static function getIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) //check ip from share internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //to check ip is pass from proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;

    }

    public static function encryptpassword($pass) {
        return md5(md5($pass));
    }

    public static function convert_vi_to_en($str) {
        if (!$str) return false;
        $unicode = array('a' => array('á', 'à', '?', 'ã', '?', '?', '?', '?', '?', '?', '?', 'â', '?', '?', '?', '?', '?'), 'A' => array('Á', 'À', '?', 'Ã', '?', '?', '?', '?', '?', '?', '?', 'Â', '?', '?', '?', '?', '?'), 'd' => array('?'), 'D' => array('?'), 'e' => array('é', 'è', '?', '?', '?', 'ê', '?', '?', '?', '?', '?'), 'E' => array('É', 'È', '?', '?', '?', 'Ê', '?', '?', '?', '?', '?'), 'i' => array('í', 'ì', '?', '?', '?'), 'I' => array('Í', 'Ì', '?', '?', '?'), 'o' => array('ó', 'ò', '?', 'õ', '?', 'ô', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?'), 'O' => array('Ó', 'Ò', '?', 'Õ', '?', 'Ô', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?'), 'u' => array('ú', 'ù', '?', '?', '?', '?', '?', '?', '?', '?', '?'), 'U' => array('Ú', 'Ù', '?', '?', '?', '?', '?', '?', '?', '?', '?'), 'y' => array('ý', '?', '?', '?', '?'), 'Y' => array('Ý', '?', '?', '?', '?'), '-' => array(' ', '&quot;', '.', '-–-'));
        foreach ($unicode as $nonUnicode => $uni) {
            foreach ($uni as $value) $str = @str_replace($value, $nonUnicode, $str);
            $str = preg_replace("/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/", "-", $str);
            $str = preg_replace("/-+-/", "-", $str);
            $str = preg_replace("/^\-+|\-+$/", "", $str);
        }
        $str = str_replace("-", " ", $str);
        return $str;
    }

    public static function removeemptyinarray($array, $convert_to_lowser = true) {
        $index = 0;
        foreach ($array as $item) {
            if ($convert_to_lowser == true) $array[$index] = strtolower($array[$index]);
            if (strlen($item) <= 0 || !isset($item)) unset($array[$index]);
            ++$index;
        }
        return array_values($array);
    }

    public static function start_with($haystack, $needle) {
        return strpos($haystack, $needle) === 0;
    }

    public static function resortarray($data_array, $array_key, $property) {
        foreach ($array_key as $key => $val) {
            foreach ($data_array as $item) {
                if ($item["$property"] == $val) {
                    $hdata[] = $item;
                    unset($item);
                }
            }
        }
        return $hdata;
    }

    public static function clearcache() {
        array_map("unlink", glob(raintpl::$cache_dir . "*"));
    }

    public static function time_stamp($time_ago) {
        $cur_time = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);
        if ($minutes == 1) return 1;
        else return $minutes;
    }

    public static function calc($equation) {
        // Remove whitespaces
        $equation = preg_replace('/\s+/', '', $equation);
        //echo "$equation\n";
        $number = '((?:0|[1-9]\d*)(?:\.\d*)?(?:[eE][+\-]?\d+)?|pi|?)'; // What is a number
        $functions = '(?:sinh?|cosh?|tanh?|acosh?|asinh?|atanh?|exp|log(10)?|deg2rad|rad2deg
|sqrt|pow|abs|intval|ceil|floor|round|(mt_)?rand|gmp_fact)'; // Allowed PHP public static functions
        $operators = '[\/*\^\+-,]'; // Allowed math operators
        $regexp = '/^([+-]?(' . $number . '|' . $functions . '\s*\((?1)+\)|\((?1)+\))(?:' . $operators . '(?1))?)+$/'; // Final regexp, heavily using recursive patterns
        if (preg_match($regexp, $equation)) {
            $equation = preg_replace('!pi|?!', 'pi()', $equation); // Replace pi with pi public static function
            //echo "$equation\n";
            eval('$result = ' . $equation . ';');
        }
        else $result = false;
        return $result;
    }

    public static function formartnumber($number) {
        $number = number_format($number, 0, "", ".");
        return $number;
    }

    public static function revertphone($phone) { // return 09xxx
        $phone = str_replace("+84", "0", $phone);
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

    public static function isMobifoneNumber($phone) {
        $mobileFoneRegex = '/^(84|0)?(90|93|120|121|122|125|126|128)\d{7}$/';
        if (preg_match($mobileFoneRegex, $phone) == true) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function getListOS($game_info) {
        $str_os = '';
        if (isset($game_info['link_plist']) && isset($game_info['link_apk'])) {
            if ($game_info['link_plist'] != '') {
                $str_os .= '<i class="icon_ios"></i>';
            }
            if ($game_info['link_apk'] != '') {
                $str_os .= '<i class="icon_android"></i>';
            }
        }
        return $str_os;
    }

    public static function returnImage($val) {
        global $sourcedir, $site_url;
        if (strlen($val) <= 0) return $sourcedir . "component/asset/images/WP67X6E7.jpg";
        else {
            if (strpos($val, $site_url) === false) {
                return $site_url . $val;
            }
            else {
                return $val;
            }
        }
    }

    public static function getcategorytype($key) {
        $categorytype = static::getAllCategoryType();
        foreach ($categorytype as $val) if ($val['key'] == $key) return $val;
        return array("name" => "", "key" => "");
    }

    public static function currentdomain() {
        return "http://" . $_SERVER['HTTP_HOST'];
    }


    public static function alphatonum($str) {
        $num = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            $num += ord($str[$i]);
            $num *= 26;
        }
        return $num;
    }

    public static function numtoalpha($num) {
        $alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X ', 'Y', 'Z');
        return $alpha[$num];
    }

//Support Page Tr? l?i câu h?i tr?c nghi?m
    public static function returnchecked($key, $value) {
        if ($_POST[$key] == $value) echo "checked";
        echo "";
    }

    public static function returnaw($question, $idpost,$index) {
        $selectedvalue = $_POST[$idpost];
        $showtrue==10;
        if($question['trueaw']==$index && !empty($_POST)) $showtrue = 1;
        else if($question['trueaw']==$selectedvalue && $index==$selectedvalue && !empty($_POST)) $showtrue = 2;
        if($question['trueaw']!=$selectedvalue && $index==$selectedvalue && !empty($_POST)) $showtrue = 2;
        return $showtrue;

    }
    public static function show_paging($maxPage, $currentPage, $paramsName = 'page') {
        $path = curPageURL();
        $path = strpos($path, '?') !== false ? $path . '&' : $path . '?';
        $path = str_replace("?page=" . $currentPage . "&", "?", $path);
        $path = str_replace("&page=" . $currentPage . "&", "&", $path);
        if ($maxPage <= 1) {
            $html = "";
            return $html;
        }
        $nav = array('left' => 2, 'right' => 2);
        if ($maxPage < $currentPage) {
            $currentPage = $maxPage;
        }
        // s? trang hi?n th?
        $max = $nav['left'] + $nav['right'];
        // phân tích cách hi?n th?
        if ($max >= $maxPage) {
            $start = 1;
            $end = $maxPage;
        } elseif ($currentPage - $nav['left'] <= 0) {
            $start = 1;
            $end = $max + 1;
        } elseif (($right = $maxPage - ($currentPage + $nav['right'])) <= 0) {
            $start = $maxPage - $max;
            $end = $maxPage;
        } else {
            $start = $currentPage - $nav['left'];
            if ($start == 2) {
                $start = 1;
            }
            $end = $start + $max;
            if ($end == $maxPage - 1) {
                ++$end;
            }
        }
        $navig = '<div class="page pagination-centered">';
        $navig .= '<ul>';
        if ($currentPage >= 2) {
            if ($currentPage >= $nav['left']) {
                if ($currentPage - $nav['left'] > 2 && $max < $maxPage) {
                    // thêm nút "1"
                    $navig .= '<li><a href="' . $path . $paramsName . '=1' . '">1</a>';
                    $navig .= '<li><a href="javascript:void(0);">...</a></li>';
                }
            }
        }
        for ($i = $start; $i <= $end; $i++) {
            // trang hi?n t?i
            if ($i == $currentPage) {
                $navig .= '<li class="active"><a href="javascript:void(0);">' . $i . '</a></li>';
            } // trang khác
            else {
                $navig .= '<li><a href="' . $path . $paramsName . '=' . $i . '">' . $i . '</a></li>';
            }
        }
        if ($currentPage <= $maxPage - 1) {
            if ($currentPage + $nav['right'] < $maxPage - 1 && $max + 1 < $maxPage) {
                // trang cuoi
                $navig .= '<li><a href="javascript:void(0);">...</a></li>';
                $navig .= '<li><a href="' . $path . $paramsName . '=' . $maxPage . '">' . $maxPage . '</a></li>';
            }
            //$navig .= '<a href="' . $path . 'page'.$object.'=' . ($currentPage + 1) . '"> > </a>';
        }
        $navig .= '</ul>';
        $navig .= '</div>';
        // hi?n th? k?t qu?
        return $navig;
    }
    public static function wordFilter($str) {
        $badString = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/config/wordfilter.txt');
        $blackList = explode(PHP_EOL,$badString);
        foreach ($blackList as $val) {
            $pattern = '/'.$val.'/iu';
            $str =preg_replace($pattern,'***', $str);
        }
        return $str;
    }

    public static function convertToNonAccented($str)
    {
        if (!$str) return false;
        $unicode = array('a' => array('á', 'à', '?', 'ã', '?', '?', '?', '?', '?', '?', '?', 'â', '?', '?', '?', '?', '?'), 'A' => array('Á', 'À', '?', 'Ã', '?', '?', '?', '?', '?', '?', '?', 'Â', '?', '?', '?', '?', '?'), 'd' => array('?'), 'D' => array('?'), 'e' => array('é', 'è', '?', '?', '?', 'ê', '?', '?', '?', '?', '?'), 'E' => array('É', 'È', '?', '?', '?', 'Ê', '?', '?', '?', '?', '?'), 'i' => array('í', 'ì', '?', '?', '?'), 'I' => array('Í', 'Ì', '?', '?', '?'), 'o' => array('ó', 'ò', '?', 'õ', '?', 'ô', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?'), 'O' => array('Ó', 'Ò', '?', 'Õ', '?', 'Ô', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?'), 'u' => array('ú', 'ù', '?', '?', '?', '?', '?', '?', '?', '?', '?'), 'U' => array('Ú', 'Ù', '?', '?', '?', '?', '?', '?', '?', '?', '?'), 'y' => array('ý', '?', '?', '?', '?'), 'Y' => array('Ý', '?', '?', '?', '?'), '-' => array(' ', '&quot;', '.', '-–-'));
        foreach ($unicode as $nonUnicode => $uni) {
            foreach ($uni as $value) $str = @str_replace($value, $nonUnicode, $str);
        }
        $str = str_replace("-", " ", $str);
        return $str;
    }
    public static function sapxep($str){

    }

    public static function getClFromType($type){
        switch($type){
            case Constant::TYPE_GTCB:
                $cl = 'gtcb';
                break;
            case Constant::TYPE_SONG:
                $cl = 'hmcaudio';
                break;
            case Constant::TYPE_LUYENNGUAM:
                $cl = 'luyennguam';
                break;
            case Constant::TYPE_NGUPHAP:
                $cl = 'nguphap';
                break;
            default:
                $cl = 'thuvien';
                break;
        }
        return $cl;
    }

    public static function getWebImageLink($image){
        $result = Constant::BASE_URL . $image;
        if (strpos($image, 'http://') !== false)
            $result = $image;

        return $result;
    }

    public static function getUrlFromType($type){
        switch($type){
            case Constant::TYPE_GTCB:
                $url = 'gtcb.php';
                break;
            case Constant::TYPE_SONG:
                $url = 'hmcaudio.php';
                break;
            case Constant::TYPE_LUYENNGUAM:
                $url = 'luyennguam.php';
                break;
            case Constant::TYPE_NGUPHAP:
                $url = 'nguphap.php';
                break;
            case Constant::TYPE_HOIDAP:
                $url = 'hoidap.php';
                break;
            default:
                $url = 'thuvien.php';
                break;
        }
        return $url;
    }

    public static function generateRandomPassword(){
        return rand(100000,999999);
    }

    public static function convertDateFormat($date, $input_format = 'd/m/Y', $out_format = 'Y-m-d')
    {
        $from = DateTime::createFromFormat($input_format, $date);
        if(!$from)
            return $date;
        else
            return $from->format($out_format);
    }

    //check date format d-m-Y
    public static function checkDateValid($date){
        $arr = explode('-', $date);
        $day = intval($arr[0]);
        $mon = intval($arr[1]);
        $year = intval($arr[2]);
        return checkdate($mon, $day, $year);
    }

    public static function formatTranslatecontent($EngContent, $VieContent){
        $engArr = array();
        $vieArr = array();
        if(!empty($EngContent)){
            $doc = new DOMDocument();
            $doc->loadHTML('<?xml encoding="UTF-8">'.$EngContent);
            $items = $doc->getElementsByTagName('p');
            if(count($items) > 0) //Only if tag1 items are found
            {
                foreach ($items as $tag1)
                {
                    $engArr[] = static::DOMinnerHTML($tag1);
                }
            }
        }

        if(!empty($VieContent)){
            $doc->loadHTML('<?xml encoding="UTF-8">'.$VieContent);
            $items = $doc->getElementsByTagName('p');
            if(count($items) > 0) //Only if tag1 items are found
            {
                foreach ($items as $tag1)
                {
                    $vieArr[] = static::DOMinnerHTML($tag1);
                }
            }
        }

        $content = '';
        if(count($engArr) > 0)
        foreach($engArr as $key=>$val){
            $vieContent = isset($vieArr[$key]) ? $vieArr[$key] : '';
            $content .= '<tr><td>'.$val.'</td><td>'.$vieContent.'</td></tr>';
        }
        return $content;
    }

    public static function DOMinnerHTML(DOMNode $element)
    {
        $innerHTML = "";
        $children  = $element->childNodes;

        foreach ($children as $child)
        {
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }

        return $innerHTML;
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

    public static function maskPhone($phone){
        return strlen($phone) > 6 ? substr($phone,0,3).str_repeat('*',strlen($phone)-6).substr($phone,strlen($phone)-3,3) : $phone;
    }

    public static function numberToRoman($number){
        $arr = array(1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI', 7=>'VII', 8=>'VIII', 9=>'IX', 10=>'X');
        return isset($arr[$number]) ? $arr[$number] : $number;
    }

    public static function getTypebyCateSlug($cateSlug){
        $slugArr = array(
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
                Constant::TYPE_HOIDAP => 'hoi-dap'
        );
        foreach($slugArr as $key=>$val){
            if($val == $cateSlug)
                return $key;
        }
        return false;
    }

    public static function getCateSlugByType($type){
        $slugArr = array(
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
        return $slugArr[$type];
    }

    public static function saveLog($content){
        $file = __DIR__ . '/../log/package.txt';
        $myfile = fopen($file, "a+") or die("Unable to open file!");
        fwrite($myfile, $content.PHP_EOL);
        fclose($myfile);
        return;
    }

    public static function array_strip_tags($array)
    {
        $result = array();
        foreach ($array as $key => $value) {
            $key = strip_tags($key);
            if (is_array($value)) {
                $result[$key] = Common::array_strip_tags($value);
            }
            else {
                $result[$key] = htmlentities(strip_tags($value));
            }
        }
        return $result;
    }

    public static function isTestUser($phone){
        $file = __DIR__ . '/../config/test_phone.txt';
        $lines = file($file);
        foreach ($lines as $line) if ($phone == $line || $phone == trim($line)) return true;
        return false;
    }

    public static function isEventUser($uid){
        global $dbmg;
        $eucl = $dbmg->event_user;
        $eventcl = $dbmg->event;
        $eventUser = $eucl->findOne(array('uid'=>array('$in'=>array(strval($uid),intval($uid)))));
//        return $eventUser;
        if(!$eventUser) return false;
        $event = $eventcl->findOne(array('_id'=>$eventUser['eid']));
        if(!$event) return false;
        $freeday = $event['free_day'];
        $dateDiff = (time() - $eventUser['datecreate'])/86400;
        return $dateDiff <= $freeday;
    }

    public static function isRegPackage($uid){
        global $dbmg;
        $usercl = $dbmg->user;
        $user = $usercl->findOne(array('_id'=>$uid));
        return isset($user['pkg_expired']) && $user['pkg_expired']>time();
    }

    public static function isFreeUser($phone){
        global $dbmg;
        $freeday = 15;
        $freecl = $dbmg->free_user;
        $user = $freecl->findOne(array('phone'=>$phone));
        if(!$user) return false;
        $dateDiff = (time() - $user['_id'])/86400;
        return $dateDiff <= $freeday;
    }

    public static function getBalance($uid){
        global $dbmg;
        $usercl = $dbmg->user;
//        return $uid;
        $cond = array(array('_id',$uid));
        $user = $usercl->findOne($cond);
        return $user;
//        return $user['email'];
        if($user)
            return isset($user['balance']) ? $user['balance'] : 0;
        return 0;
    }

    public static function isFreeLession($id,$type){
        global $dbmg;
        $showcl = $dbmg->showcl;
        $free = $showcl->findOne(array('type'=>'free_lession'));
        if(!$free) return false;
        $allLesssion = $free['lession'];
        $current = array(
            'type' => $type,
            'id' => strval($id)
        );
        return in_array($current, $allLesssion);
    }

    public static function isHssvUser($uid){
//        return true;
        global $dbmg;
        $usercl = $dbmg->user;
        $user = $usercl->findOne(array('_id'=>$uid));
        $timeDiff = 30*86400;
        if($user && isset($user['event']) && $user['event']==Event::HOC_SINH_SINH_VIEN && time()-$user['event_time']>$timeDiff) return true;
        else return false;
    }

    public static function isInWhiteList($phone){
        $file = __DIR__ . '/../config/whitelist.txt';
        $lines = file($file);
        foreach ($lines as $line) if ($phone == $line || $phone == trim($line)) return true;
        return false;
    }

    public static function getRandomIp(){
        $file = __DIR__ . '/../config/ip.txt';
        $lines = file($file);
//        $randomkey = array_rand($lines, 1);
        $random = rand(0, count($lines));
        return trim($lines[$random]);
    }

    public static function isSmartphone($phone){
        return true;
        $file = __DIR__ . '/../config/codau.txt';
        $lines = file($file);
        foreach ($lines as $line){
            if (trim($phone) == trim($line)) return true;
        }
        return false;
    }

    public static function vietnameseToEnglish($sample){
        $marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
                "ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
        ,"ế","ệ","ể","ễ",
                "ì","í","ị","ỉ","ĩ",
                "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
        ,"ờ","ớ","ợ","ở","ỡ",
                "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
                "ỳ","ý","ỵ","ỷ","ỹ",
                "đ",
                "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
        ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
                "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
                "Ì","Í","Ị","Ỉ","Ĩ",
                "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
        ,"Ờ","Ớ","Ợ","Ở","Ỡ",
                "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
                "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
                "Đ");
        $marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
        ,"a","a","a","a","a","a",
                "e","e","e","e","e","e","e","e","e","e","e",
                "i","i","i","i","i",
                "o","o","o","o","o","o","o","o","o","o","o","o"
        ,"o","o","o","o","o",
                "u","u","u","u","u","u","u","u","u","u","u",
                "y","y","y","y","y",
                "d",
                "A","A","A","A","A","A","A","A","A","A","A","A"
        ,"A","A","A","A","A",
                "E","E","E","E","E","E","E","E","E","E","E",
                "I","I","I","I","I",
                "O","O","O","O","O","O","O","O","O","O","O","O"
        ,"O","O","O","O","O",
                "U","U","U","U","U","U","U","U","U","U","U",
                "Y","Y","Y","Y","Y",
                "D");
        return str_replace($marTViet,$marKoDau,$sample);
    }

    public static function getAllLessionType(){
        return $allType = array(
                Constant::TYPE_FAMOUS => 'Người nổi tiếng',
                Constant::TYPE_SONG => 'Bài hát',
                Constant::TYPE_VIDEO => 'Video',
                Constant::TYPE_RADIO => 'Radio',
                Constant::TYPE_FILM => 'Phim',
                Constant::TYPE_DAILY => 'Tiếng Anh hàng ngày',
                Constant::TYPE_IDIOM => 'Thành ngữ',
                Constant::TYPE_EXP => 'Kinh nghiệm'
        );
    }

    public static function makeLinkDisableEmailNotify($phone, $password){
        $key = base64_encode($phone.'+'.$password);
        return Constant::BASE_URL.'/disable-email.html?key='.$key;
    }

    public static function getVerifyEmailUrl($uid,$email,$domain=Constant::BASE_URL){
        $key = base64_encode($uid.'+'.$email.'+'.time());
        return $domain.'/verify-email.html?key='.$key.'&email='.$email;
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

    public static function getSmsLink($to,$body){
        $char = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone") ? '&' : '?';
        return 'sms:'.$to.$char.'body='.$body;
    }
    
    public static function getCardType(){
        return array(
            Constant::CARD_TYPE_VIETTEL => 'Viettel',
            Constant::CARD_TYPE_MOBIFONE => 'Mobifone',
            Constant::CARD_TYPE_VINAPHONE => 'Vinaphone'
        );
    }

    public static function getTxnCardMss($code){
        $arr = array(
            Constant::TXN_CARD_SUCCESS => 'Thành công',
            Constant::TXN_CARD_USED => 'Thẻ đã sử dụng',
            Constant::TXN_CARD_PENDING => 'Chờ xử lý',
            Constant::TXN_CARD_PROVIDER_ERROR => 'Lỗi hệ thống',
            Constant::TXN_CARD_LOCKED => 'Thẻ bị khóa',
            Constant::TXN_CARD_INVALID => 'Thẻ không hợp lệ',
            Constant::TXN_CARD_PIN_INVALID => 'Mã thẻ không hợp lệ',
            Constant::TXN_CARD_SERI_INVALID => 'Số seri không hợp lệ'
        );
        return isset($arr[$code]) ? $arr[$code] : 'Chờ xử lý';
    }

    public static function getTxnBankMss($code){
        $arr = array(
            Constant::TXN_BANK_SUCCESS => 'Thành công',
            Constant::TXN_BANK_REFUSE => 'Ngân hàng từ chối thanh toán',
            Constant::TXN_BANK_INVALID => 'Thẻ không hợp lệ',
            Constant::TXN_BANK_USER_ERROR => 'Lỗi từ phía người dùng',
            Constant::TXN_BANK_ERROR => 'Lỗi kết nối với Ngân hàng',
            Constant::TXN_BANK_ACCOUNT_NOT_ENOUGH => 'Tài khoản không đủ tiền',
            Constant::TXN_BANK_FAIL => 'Giao dịch thất bại',
            Constant::TXN_BANK_WRONG_INFO => 'Nhập sai thông tin thẻ',
            Constant::TXN_BANK_NOT_INTERNETBANKING => 'Tài khoản chưa đăng ký InternetBanking',
            Constant::TXN_BANK_ERROR_OTP => 'Lỗi xác thực OTP',
            Constant::TXN_BANK_OVER_LIMIT => 'Giao dịch thất bại do sử dụng quá hạn mức ngân hàng',
            Constant::TXN_BANK_TIMEOUT => 'Thời gian thực hiện giao dịch quá lâu',
            Constant::TXN_BANK_PENDING => 'Giao dịch chờ xử lý',
        );
        return isset($arr[$code]) ? $arr[$code] : 'Giao dịch thất bại';
    }

    public static function getTxnSmsMss($code){
        $arr = array(
            Constant::TXN_SMS_SUCCESS => 'Thành công',
            Constant::TXN_SMS_INVALID => 'Thuê bao không hợp lệ',
            Constant::TXN_SMS_ERROR => 'Giao dịch thất bại',
            Constant::TXN_SMS_NOT_ENOUGH => 'Tài khoản không đủ'
        );
        return isset($arr[$code]) ? $arr[$code] : 'Giao dịch thất bại';
    }

    public static function getTxnOtpMss($code){
        $arr = array(
            Constant::TXN_OTP_SUCCESS => 'Giao dịch thành công',
            Constant::TXN_OTP_PROVIDER_ERROR => 'Lỗi hệ thống, vui lòng thử lại sau',
            Constant::TXN_OTP_MSISDN_INVALID => 'Thuê bao không hợp lệ',
            Constant::TXN_OTP_SENT_ERROR => 'Không thể gửi OTP',
            Constant::TXN_OTP_ACCOUNT_NOT_ENOUGH => 'Tài khoản không đủ tiền',
            Constant::TXN_OTP_INPUT_WRONG => 'OTP không chính xác',
            Constant::TXN_OTP_TOO_MUCH => 'Số tiền thanh toán quá lớn',
            Constant::TXN_OTP_SENT_SUCCESS => 'Gửi OTP thành công',
            Constant::TXN_OTP_ERROR => 'Lỗi không xác định, vui lòng thử lại sau'
        );
        return isset($arr[$code]) ? $arr[$code] : 'Giao dịch thất bại';
    }

    public static function isPhoneNumber($phone){
       return preg_match("/^\+?(84|0)(1\d{9}|9\d{8})$/", $phone);
    }

    public static function getAllBank(){
        return array(
            1 => 'Ngân hàng Á Châu (ACB)',
            2 => 'Ngân hàng Nông nghiệp và Phát triển Nông thôn Việt Nam (Agribank)',
            3 => 'ANZ Việt Nam (ANZ)',
            4 => 'Ngân hàng Bắc Á (BACABank)',
            5 => 'Ngân hàng Bảo Việt (BaoViet Bank)',
            6 => 'Ngân hàng đầu tư và phát triển Việt Nam (BIDV)',
            7 => 'Ngân hàng An Bình (ABBank)',
            8 => 'Ngân hàng Đông Á (DongA Bank)',
            9 => 'Ngân hàng Xuất nhập khẩu (Eximbank)',
            10 => 'Ngân hàng Dầu khí toàn cầu (GP Bank)',
            11 => 'Ngân hàng phát triển nhà TPHCM (HDBank)',
            12 => 'Ngân hàng HSBC (HSBC)',
            13 => 'Ngân hàng Kiên Long (KienLongBank)',
            14 => 'Ngân hàng Liên Việt (LienVietBank)',
            15 => 'Ngân hàng quân đội (MB)',
            16 => 'Ngân hàng Hàng hải Việt Nam (MSB)',
            17 => 'Ngân hàng Nam Á (Nam A Bank)',
            18 => 'Ngân hàng Quốc dân (NCB)',
            19 => 'Ngân hàng Phương Đông (OCB)',
            20 => 'Ngân hàng Đại Dương (Ocean Bank)',
            21 => 'Ngân hàng TMCP Xăng Dầu (PG Bank)',
            22 => 'Ngân hàng Sài Gòn Thương tín (Sacombank)',
            23 => 'Ngân hàng Sài Gòn Công Thương (Saigonbank)',
            24 => 'Ngân hàng TMCP Sài Gòn (SCB)',
            25 => 'Ngân hàng Đông Nam Á (SeaBank)',
            26 => 'Ngân hàng Sài Gòn - Hà Nội (SHB)',
            27 => 'Ngân hàng Phương Nam (Southern Bank)',
            28 => 'Ngân hàng Kỹ thương Việt Nam (Techcombank)',
            29 => 'Ngân hàng Tiên Phong (TienPhongBank)',
            30 => 'Ngân hàng TMCP Việt Nam Tín Nghĩa (TinNghiaBank)',
            31 => 'Ngân hàng Xây dựng Việt Nam (Trurst Bank)',
            32 => 'Ngân hàng Quốc tế (VIB)',
            33 => 'Ngân hàng Việt Nam Thương Tín (VietBank)',
            34 => 'Ngân hàng TMCP Bản Việt (VietCapitalBank)',
            35 => 'Ngân hàng Ngoại thương Việt Nam (Vietcombank)',
            36 => 'Ngân hàng Công thương Việt Nam (Vietinbank)',
            37 => 'Ngân hàng Việt Nam thịnh vượng (VPBank)'
        );
    }

    public static function encodeAffCookie($input){
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(Constant::AFF_SECRET_KEY), $input, MCRYPT_MODE_CBC, md5(md5(Constant::AFF_SECRET_KEY))));
    }

    public static function decodeAffCookie($input){
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(Constant::AFF_SECRET_KEY), base64_decode($input), MCRYPT_MODE_CBC, md5(md5(Constant::AFF_SECRET_KEY))), "\0");
    }

    public static function getPaymentMethod($code){
        $arr = array(
            Constant::CARD_METHOD_NAME => 'Thẻ cào',
            Constant::BANK_METHOD_NAME => 'ATM nội địa',
            Constant::SMS_METHOD_NAME => 'Tin nhắn SMS',
            Constant::OTP_METHOD_NAME => 'OTP',
            Constant::CHUYENKHOAN_METHOD_NAME => 'Chuyển khoản',
        );
        return isset($arr[$code]) ? $arr[$code] : '';
    }

    public static function getWithdrawStatus($code){
        $arr = array(
            Constant::WITHDRAW_STATUS_NEW => 'Chờ duyệt',
            Constant::WITHDRAW_STATUS_COMPLETE => 'Hoàn thành',
            Constant::WITHDRAW_STATUS_CANCEL => 'Đã hủy',
        );
        return isset($arr[$code]) ? $arr[$code] : '';
    }
}