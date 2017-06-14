<?php
foreach (glob(__DIR__.'/helpers/*.php') as $filename)
{
    include $filename;
}
class makelink{
    static function maketypegtcb($id,$name){
        return "/gtcb.php?type=$id";
    }
    static function maketypelna($id,$name){
        return "/luyennguam.php?type=$id";
    }
    static function maketypenp($id,$name){
        return "/nguphap.php?type=$id";
    }
    static function maketypethuvien($id,$name){
        return "/category.php?type=$id";
    }
    static function makehoidap($id,$name){
        return "/hoidap.php?id=$id";
    }
    static function makegtcb($id,$name){
        return "/gtcb.php?id=$id";
    }
    static function makelna($id,$name){
        return "/luyennguam.php?id=$id";
    }
    static function makenp($id,$name){
        return "/nguphap.php?id=$id";
    }
    static function makecat($catid,$type,$name){
        return "/category.php?catid=$catid&type=$type";
    }
    static function makethuvien($cat,$id,$name){
        return "/thuvien.php?cat=$cat&id=$id";
    }
    static function maketudien($id,$name){
        return "/category.php?id=$id";
    }
    static function maketypehmcaudio($id,$name){
        return "/hmcaudio.php?type=$id";
    }
    static function makecathmcaudio($id,$name){
        return "/hmcaudio.php?catid=$id";
    }
    static function makehmcaudio($id,$name){
        return "/hmcaudio.php?id=$id";
    }
    static function makehmcvideo($id,$name){
        return "/hmcvideo.php?id=$id";
    }
    static function makefaq($id, $name){
        return "/hoidap.php?id=$id";
    }
    static function makenews($id, $name){
        return "/news.php?id=$id";
    }
    static function  returnimage($url){
        global $config;
        return $config['sitemedia']['static_url'].$url;
    }
    static function  returncategory($id,$url){
        global $config;
        return $config['sitemedia']['static_url'].$url."/"."category.php?id=$id";
    }
    static function returnvideo($url){
        global $config;
        return $config['sitemedia']['static_url'].$url;
    }
}
function cleanstring($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

function getiteminarray($array, $member, $value) {
    foreach ($array as $i) if ($i["$member"] == $value) return $i;
}

function isacceptpermission($key) {
    $listpermiss = $_SESSION['permission'];
    if (is_array($key)) {
        foreach ($key as $item) {
            if (in_array($item, $listpermiss)) return true;
        }
    }
    else return in_array($key, $listpermiss);
    return false;
}

function curPageURL() {
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

function cpagerparm($para_need_remove, $replace_space = 0) {
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
    if ($replace_space == 1) return str_replace(' ', '+', removeqsvar($pageURL, $para_need_remove));
    else return removeqsvar($pageURL, $para_need_remove);
}

function removeqsvar($url, $varname) {
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

function removeallspace($string) {
    $string = preg_replace('/\s+/', '', $string);
    return $string;
}

function getIP() {
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

function encryptpassword($pass) {
    return md5(md5($pass));
}

function convert_vi_to_en($str) {
    if (!$str) return false;
    $unicode = array('a' => array('á', 'à', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ặ', 'ằ', 'ẳ', 'ẵ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ'), 'A' => array('Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ặ', 'Ằ', 'Ẳ', 'Ẵ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ'), 'd' => array('đ'), 'D' => array('Đ'), 'e' => array('é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ'), 'E' => array('É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ'), 'i' => array('í', 'ì', 'ỉ', 'ĩ', 'ị'), 'I' => array('Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị'), 'o' => array('ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ'), 'O' => array('Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ'), 'u' => array('ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự'), 'U' => array('Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự'), 'y' => array('ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ'), 'Y' => array('Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ'), '-' => array(' ', '&quot;', '.', '-–-'));
    foreach ($unicode as $nonUnicode => $uni) {
        foreach ($uni as $value) $str = @str_replace($value, $nonUnicode, $str);
        $str = preg_replace("/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/", "-", $str);
        $str = preg_replace("/-+-/", "-", $str);
        $str = preg_replace("/^\-+|\-+$/", "", $str);
    }
    $str = str_replace("-", " ", $str);
    return $str;
}

function removeemptyinarray($array, $convert_to_lowser = true) {
    $index = 0;
    foreach ($array as $item) {
        if ($convert_to_lowser == true) $array[$index] = strtolower($array[$index]);
        if (strlen($item) <= 0 || !isset($item)) unset($array[$index]);
        ++$index;
    }
    return array_values($array);
}

function start_with($haystack, $needle) {
    return strpos($haystack, $needle) === 0;
}

function resortarray($data_array, $array_key, $property) {
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

function clearcache() {
    array_map("unlink", glob(raintpl::$cache_dir . "*"));
}

function time_stamp($time_ago) {
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

function calc($equation) {
    // Remove whitespaces
    $equation = preg_replace('/\s+/', '', $equation);
    //echo "$equation\n";
    $number = '((?:0|[1-9]\d*)(?:\.\d*)?(?:[eE][+\-]?\d+)?|pi|π)'; // What is a number
    $functions = '(?:sinh?|cosh?|tanh?|acosh?|asinh?|atanh?|exp|log(10)?|deg2rad|rad2deg
|sqrt|pow|abs|intval|ceil|floor|round|(mt_)?rand|gmp_fact)'; // Allowed PHP functions
    $operators = '[\/*\^\+-,]'; // Allowed math operators
    $regexp = '/^([+-]?(' . $number . '|' . $functions . '\s*\((?1)+\)|\((?1)+\))(?:' . $operators . '(?1))?)+$/'; // Final regexp, heavily using recursive patterns
    if (preg_match($regexp, $equation)) {
        $equation = preg_replace('!pi|π!', 'pi()', $equation); // Replace pi with pi function
        //echo "$equation\n";
        eval('$result = ' . $equation . ';');
    }
    else $result = false;
    return $result;
}

$categorytype = Common::getAllCategoryType();

function formartnumber($number) {
    $number = number_format($number, 0, "", ".");
    return $number;
}

function revertphone($phone) { // return 09xxx
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
function phone($phone){
   $phone = substr($phone,0,1) ;}

function isMobifoneNumber($phone) {
    $mobileFoneRegex = '/^(84|0)?(90|93|120|121|122|125|126|128)\d{7}$/';
    if (preg_match($mobileFoneRegex, $phone) == true) {
        return 1;
    }
    else {
        return 0;
    }
}

function getListOS($game_info) {
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

function returnImage($val) {
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

function getcategorytype($key) {
    global $categorytype;
    foreach ($categorytype as $val) if ($val['key'] == $key) return $val;
    return array("name" => "", "key" => "");
}

function currentdomain() {
    return "http://" . $_SERVER['HTTP_HOST'];
}


function alphatonum($str) {
    $num = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $num += ord($str[$i]);
        $num *= 26;
    }
    return $num;
}

function numtoalpha($num) {
    $alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X ', 'Y', 'Z');
    return $alpha[$num];
}

//Support Page Trả lời câu hỏi trắc nghiệm
function returnchecked($key, $value) {
    if ($_POST[$key] == $value) echo "checked";
    echo "";
}

function returnaw($question, $idpost,$index) {
    $selectedvalue = $_POST[$idpost];
    $showtrue==10;
    if($question['trueaw']==$index && !empty($_POST)) $showtrue = 1;
    else if($question['trueaw']==$selectedvalue && $index==$selectedvalue && !empty($_POST)) $showtrue = 2;
    if($question['trueaw']!=$selectedvalue && $index==$selectedvalue && !empty($_POST)) $showtrue = 2;
    return $showtrue;

}
function show_paging($maxPage, $currentPage, $paramsName = 'page') {
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
    // số trang hiển thị
    $max = $nav['left'] + $nav['right'];
    // phân tích cách hiển thị
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
        // trang hiện tại
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
    // hiển thị kết quả
    return $navig;
}
function wordFilter($str) {
    $badString = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/config/wordfilter.txt');
    $blackList = explode(PHP_EOL,$badString);
    foreach ($blackList as $val) {
        $pattern = '/'.$val.'/iu';
        $str =preg_replace($pattern,'***', $str);
    }
    return $str;
}
$hcmgametype[] = array("name"=>"Đoán từ qua tranh","_id"=>"1","avatar"=>"http://tagt.nhacchovui.vn/template/wap/asset/images/data_thumb_game.jpg");

function convertToNonAccented($str)
{
    if (!$str) return false;
    $unicode = array('a' => array('á', 'à', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ặ', 'ằ', 'ẳ', 'ẵ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ'), 'A' => array('Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ặ', 'Ằ', 'Ẳ', 'Ẵ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ'), 'd' => array('đ'), 'D' => array('Đ'), 'e' => array('é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ'), 'E' => array('É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ'), 'i' => array('í', 'ì', 'ỉ', 'ĩ', 'ị'), 'I' => array('Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị'), 'o' => array('ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ'), 'O' => array('Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ'), 'u' => array('ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự'), 'U' => array('Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự'), 'y' => array('ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ'), 'Y' => array('Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ'), '-' => array(' ', '&quot;', '.', '-–-'));
    foreach ($unicode as $nonUnicode => $uni) {
        foreach ($uni as $value) $str = @str_replace($value, $nonUnicode, $str);
    }
    $str = str_replace("-", " ", $str);
    return $str;
}
function isLiked($userId){
    return isset($this->like) ? in_array($userId, $this->like) : false;
}

//function addLike($userId){
//    $like = isset($this->like) ? $this->like : array();
//    if(!in_array($userId, $like))
//        array_push($like, $userId);
//
//    $this->like = $like;
//    return $this->save();
//}

function removeLike($userId){
    $like = isset($this->like) ? $this->like : array();
    if(($key = array_search($userId, $like)) !== false) {
        unset($like[$key]);
    }
    $this->like = $like;
    return $this->save();
}

function getValueByKey($key, array $arr){
    return $arr[$key];
}

function subString($str, $len){
    $str = trim($str);
    if (strlen($str) <= $len) return $str;
    $str = substr($str, 0, $len);
    if ($str != "") {
        if (!substr_count($str, " ")) return $str." ...";
        while (strlen($str) && ($str[strlen($str) - 1] != " ")) $str = substr($str, 0, -1);
        $str = substr($str, 0, -1)." ...";
    }
    return $str;
}

function getDisplayName($uinfo){
    return isset($uinfo['displayname']) && !empty($uinfo['displayname']) && $uinfo['displayname']!=$uinfo['email'] ? $uinfo['displayname'] : $uinfo['email'];
}

function getFullDisplayName($uinfo){
    return isset($uinfo['displayname']) && !empty($uinfo['displayname'])  ? $uinfo['displayname'] : (isset($uinfo['email']) ? $uinfo['email'] : $uinfo['username']);
}

function isLikeByUser(array $like, $uinfo){
    if(!isset($uinfo))
        return false;

    return isset($like) ? in_array($uinfo['_id'], $like) : false;
}
function shuffle_assoc($list) {
    if (!is_array($list)) return $list;

    $keys = array_keys($list);
    shuffle($keys);
    $random = array();
    foreach ($keys as $key) {
        $random[$key] = $list[$key];
    }
    return $random;
}

function getSmsLink($to,$body){
    $char = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone") ? '&' : '?';
    if(stripos($_SERVER['HTTP_USER_AGENT'],"iPhone")){
        $version = preg_replace("/(.*) OS ([0-9]*)_(.*)/","$2", $_SERVER['HTTP_USER_AGENT']);
        if($version > 7)
            return 'sms:'.$to.'&body='.$body;
        else
            return 'sms:'.$to.';body='.$body;
    }elseif(stripos($_SERVER['HTTP_USER_AGENT'],"Windows Phone")){
        return 'sms://'.$to.'&body='.$body;
    }
    return 'sms:'.$to.$char.'body='.$body;
}

// Có thể chuyển sang app tin nhắn với cú pháp hay không? Android và iOS >7
function canGotoSmsApp(){
    if(stripos($_SERVER['HTTP_USER_AGENT'],"Android")) return true;
//    if(stripos($_SERVER['HTTP_USER_AGENT'],"Windows Phone")) return true;
    if(stripos($_SERVER['HTTP_USER_AGENT'],"iPhone")){
        $version = preg_replace("/(.*) OS ([0-9]*)_(.*)/","$2", $_SERVER['HTTP_USER_AGENT']);
        if($version > 7)
            return true;
    }
    return false;
}


?>
