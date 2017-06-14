<?php
$hmcgamecl = $dbmg->hmcgame;
$categorycl = $dbmg->category;
$saveCl = $dbmg->savegame;
$pointCl= $dbmg->game_point;
$userCl = $dbmg->user;
$historycl = $dbmg->history_log;
include '/checkLogin.php';


//$id = $_GET['id'];
$d = $_GET['d'];
$catid = $_GET['catid'];
$act = $_GET['act'];
$listcat = iterator_to_array($categorycl->find(array('type'=>Constant::TYPE_HOCMACHOI,"status"=>"1", "parentid"=>array('$ne'=>'0'))),false);
$tpl->assign("listcat",$listcat);
if(isset($act) && $act=='guide'){
    $tpl->assign("pagefile", "hmc/game/guide");
}
else if(isset($act) && $act=='rank'){
    $allRank = iterator_to_array($pointCl->find(array(), array('uid','point'))->sort(array('point'=>-1))->limit(10), false);
    foreach($allRank as $key=>$val){
        $user = $userCl->findOne(array('_id'=>$val['uid']));
        if(!$user)
            unset($allRank[$key]);
        $allRank[$key]['name'] = getDisplayName($user);
    }
    $myPoint = 0;
    if(isset($_SESSION['uinfo'])){
        $myPointDoc = $pointCl->findOne(array('uid'=>$_SESSION['uinfo']['_id']));
        if(!$myPointDoc){
            $pointCl->insert(array(
                'uid'=>$_SESSION['uinfo']['_id'],
                'point'=>0
            ));
        }else{
            $myPoint = isset($myPointDoc['point']) ? $myPointDoc['point'] : 0;
        }

    }

    $tpl->assign("allRank", $allRank);
    $tpl->assign("myPoint", $myPoint);
    $tpl->assign("pagefile", "hmc/game/rank");
}
else if(isset($catid)) {
    $tpl->assign("catid", $catid);
    //Lưu log
    $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_GAME,
            'chanel' => HistoryLog::CHANEL_WAP,
            'ip' => Network::ip(),
            'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
            'status' => Constant::STATUS_ENABLE,
            'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
            'price'=>0,
            'useragent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""

    );
    if(!isset($_SESSION['notsave_log']))
        $historycl->insert($newHistoryLog);
    if ($d == 'e') {
        $save = $saveCl->findOne(array('uid' => $_SESSION['uinfo']['_id'], 'degree' => Constant::LEVEL_EASY, 'category' => strval($catid)));
        if (!$save) {
            $newSave = array('uid' => $_SESSION['uinfo']['_id'], 'degree' => Constant::LEVEL_EASY, 'category' => $catid, 'level' => 1);
            $saveCl->insert($newSave);
            $level = 1;
        }
        else {
            $level = $save['level'];
        }
        $cond = array('category' => strval($catid), "degree" => Constant::LEVEL_EASY, "level" => strval($level));
        $game = $hmcgamecl->findOne($cond);
        $tpl->assign("game", $game);
        $tpl->assign("catid", $catid);
        $tpl->assign("level", $level);
        $tpl->assign("pagefile", "hmc/game/easy_game");
        if (isset($_POST['select'])) {
            $saveCl->update(array(
                    'uid' => $_SESSION['uinfo']['_id'],
                    'degree' => Constant::LEVEL_EASY,
                    'category' => strval($catid)
            ), array('$set' => array('level' => $level + 1)));
            $gamePoint = $pointCl->findOne(array('uid' => $_SESSION['uinfo']['_id']));
            if (!$gamePoint) {
                $newPoint = array('uid' => $_SESSION['uinfo']['_id'], 'point' => 0);
                $pointCl->insert($newPoint);
                $point = 0;
            }
            else {
                $point = isset($gamePoint['point']) ? $gamePoint['point'] : 0;
            }
            $trueAns = 0;
            foreach ($game['question'] as $key => $aQuestion) {
                if ($_POST['select'][$key] == $aQuestion['aw']) {
                    $point++;
                    $trueAns++;
                }
            }
            $pointCl->update(array('uid' => $_SESSION['uinfo']['_id']), array('$set' => array('point' => $point)));
            $select = $_POST['select'];
            $tpl->assign("select", $select);
            $tpl->assign("trueAns", $trueAns);
            $tpl->assign("question", $question);
            $tpl->assign("pagefile", "hmc/game/ketqua");
        }
    }else {
        $save = $saveCl->findOne(array('uid' => $_SESSION['uinfo']['_id'], 'degree' => Constant::LEVEL_HARD, 'category' => $catid));
        if (!$save) {
            $newSave = array('uid' => $_SESSION['uinfo']['_id'], 'degree' => Constant::LEVEL_HARD, 'category' => $catid, 'level' => 1);
            $saveCl->insert($newSave);
            $level = 1;
        }
        else {
            $level = $save['level'];
        }
        $cond = array('category' => $catid, "degree" => Constant::LEVEL_HARD, "level" => strval($level));
        $game = $hmcgamecl->findOne($cond);
        foreach($game['question'] as $key=>$val){
            $game['question'][$key]['range'] = range(1,strlen($val['aw']));
        }
//        print_r($game);
        $tpl->assign("game", $game);
        $tpl->assign("level", $level);
        $tpl->assign("catid", $catid);
        $tpl->assign("pagefile", "hmc/game/hard_game");
        if (isset($_POST['select'])) {
            foreach($_POST['select'] as $k=>$v){
                $_POST['select'][$k] = strtolower($v);
            }
//            print_r($_POST['select']);
//            print_r($game['question']);
            //Lưu level
            $saveCl->update(array('uid' => $_SESSION['uinfo']['_id'], 'degree' => Constant::LEVEL_HARD, 'category' => $catid), array('$set' => array('level' => $level + 1)));
            //Tính điểm
            $gamePoint = $pointCl->findOne(array('uid' => $_SESSION['uinfo']['_id']));
            if (!$gamePoint) {
                $newPoint = array('uid' => $_SESSION['uinfo']['_id'], 'point' => 0);
                $pointCl->insert($newPoint);
                $point = 0;
            }
            else {
                $point = isset($gamePoint['point']) ? $gamePoint['point'] : 0;
            }
            $trueAns = 0;
            foreach ($game['question'] as $key => $aQuestion) {
                if ($_POST['select'][$key] == $aQuestion['aw']) {
                    $point++;
                    $trueAns++;
                }
            }
            $pointCl->update(array('uid' => $_SESSION['uinfo']['_id']), array('$set' => array('point' => $point)));
            $select = $_POST['select'];
            $tpl->assign("select", $select);
            $tpl->assign("trueAns", $trueAns);
            $tpl->assign("pagefile", "hmc/game/ketqua_hard");
        }
    }
}else{
    $tpl->assign("pagefile", "hmc/game/category");
}
include "controller/hmc/index.php";
?>