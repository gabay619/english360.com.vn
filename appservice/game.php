<?php
foreach (glob(__DIR__.'/../helpers/*.php') as $filename)
{
    include $filename;
}
include "../config/config.php";
include "../config/connect.php";
if(!isset($_SESSION['uinfo'])){
    echo 'Bạn cần đăng nhập để chơi game.';exit;
}
$gameCl = $dbmg->hmcgame;
$saveCl = $dbmg->savegame;
$categoryCl = $dbmg->category;
$pointCl= $dbmg->game_point;
$historycl = $dbmg->history_log;
$id = $_GET['id'];
$degree = 'easy';
$cate = $categoryCl->findOne(array('_id'=>$id));
if(!$cate){
    echo 'Chủ đề này không tồn tại!'; exit;
}

##log
$newHistoryLog = array(
        '_id' => strval(time().rand(10,99)),
        'datecreate' => time(),
        'action' => HistoryLog::LOG_GAME,
        'chanel' => HistoryLog::CHANEL_APP,
        'ip' => Network::ip(),
        'uid' => $_SESSION['uinfo']['_id'],
        'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
        'status' => Constant::STATUS_ENABLE,
        'phone' => $_SESSION['uinfo']['phone'],
        'price'=> 0,
        'useragent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""

);
$historycl->insert($newHistoryLog);
if(isset($_GET['d']) && $_GET['d'] == 'h')
    include "game_hard.php";
else
    include "game_easy.php";
?>
