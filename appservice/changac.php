<?php
$act = $_GET['act'];if(!isset($act)) $act = $_POST['act'];
switch($act){
    case "home":home();break;
    case "getListByCate":getListByCate();break;
    case "getDetail":getDetail();break;
    case "sidebar":sidebar();break;
    case "login":login();break;
    case "logout":logout();break;
    case "register":register();break;
    case "search" : search();break;
    case "user" : user();break;
    case "category": category();break;
    case "saveexam":saveexam();break;
    case 'deletenotify':deletenotify();break;
    case 'deleteexam':deleteexam();break;
    case 'active':active();break;
    case 'getuserinfor':getuserinfor();break;
    case 'updateinfor':updateinfor();break;
    case 'news': news();break;
    case 'checkquestion': checkquestion();break;
}
function home(){
    global $dbmg;
    $categoryCl = $dbmg->category;
    $popupcl = $dbmg->popup;
    $freecl = $dbmg->free_user;

    $limit = 5;
    $dtr['status'] = 200;
    ##### Slide Show ##############
    $showCl = $dbmg->showcl;
    $listmedia = $showCl->findOne(array('type'=>'slideshow'));
    $dataSlide = array();
    foreach($listmedia['lession'] as $aSlideLession){
        $slideshowCl = Common::getClFromType($aSlideLession['type']);
        $slideshowCl = $dbmg->$slideshowCl;

        $lession = $slideshowCl->findOne(array('_id'=> $aSlideLession['id']));
        $dataSlide[] = array(
            '_id' => $aSlideLession['id'],
            'name' => $lession['name'],
            'avatar' => Common::getWebImageLink($lession['avatar']),
            'type' => $aSlideLession['type'],
            'nametype' => Common::getcategorytype($aSlideLession['type'])['name'],
            'time' => date('d/m/Y H:i', $lession['datecreate'])
        );
    }
    $dtr['data']['slideshow'] = $dataSlide;

    ### List Giao tiếp cơ bản ###
    $gtcbcl = $dbmg->gtcb;
    $listgtcb = iterator_to_array($gtcbcl->find(array("status"=>"1"))->sort(array("_id"=>-1))->limit($limit),false);
    $dataGtcb = array();
    $gtcbParentCate = $categoryCl->findOne(array('parentid'=>'0','type' => Constant::TYPE_GTCB));
    $allGtcbCate = iterator_to_array($categoryCl->find(array('parentid'=>$gtcbParentCate['_id']), array('_id','name')), false);
    foreach ($listgtcb as $key=>$elem) {
        $dataGtcb[] = array(
                '_id' => $elem['_id'],
                'name' => $elem['name'],
                'avatar' => Common::getWebImageLink($elem['avatar']),
                'time' => date('d/m/Y H:i', $elem['datecreate'])
        );
    }
    $dtr['data'][Constant::TYPE_GTCB] = array(
        '_id' => $gtcbParentCate['_id'],
        'icon'=> Constant::BASE_URL.'/template/wap/asset/images/sidebar_icon_giaotiep.png',
        'type' => Constant::TYPE_GTCB,
        'name' => 'Giao tiếp cơ bản',
        'list' => $dataGtcb,
        'category' => $allGtcbCate
    );

    ###List Luyện ngữ âm
//    $lnacl = $dbmg->luyennguam;
//    $listlna = iterator_to_array($lnacl->find(array("status"=>"1"))->sort(array("_id"=>-1))->limit($limit),false);
//    $dataLna = array();
//    $lnaParentCate = $categoryCl->findOne(array('parentid'=>'0','type' => Constant::TYPE_LUYENNGUAM));
//    $allLnaCate = iterator_to_array($categoryCl->find(array('parentid'=>$lnaParentCate['_id']), array('_id','name')), false);
//
//    foreach ($listlna as $key=>$elem) {
//        $dataLna[] = array(
//                '_id' => $elem['_id'],
//                'name' => $elem['name'],
//                'avatar' => Common::getWebImageLink($elem['avatar']),
//                'time' => date('d/m/Y H:i', $elem['datecreate'])
//        );
//    }
//    $dtr['data'][Constant::TYPE_LUYENNGUAM] = array(
//        '_id' => $lnaParentCate['_id'],
//        'icon' => Constant::BASE_URL.'/assets/app/icon_sidebar_nguam.png',
//        'type' => Constant::TYPE_LUYENNGUAM,
//        'name' => 'Luyện ngữ âm',
//        'list' => $dataLna,
//        'category' => $allLnaCate
//    );

    ###List bài hát
    $songcl = $dbmg->hmcaudio;
    $listsong = iterator_to_array($songcl->find(array("status"=>"1"))->sort(array("_id"=>-1))->limit($limit),false);
    $dataSong = array();
    $songParentCate = $categoryCl->findOne(array('parentid'=>'0','type' => Constant::TYPE_SONG));
    $allSongCate = iterator_to_array($categoryCl->find(array('parentid'=>$songParentCate['_id']), array('_id','name')), false);

    foreach ($listsong as $key=>$elem) {
        $dataSong[] = array(
                '_id' => $elem['_id'],
                'name' => $elem['name'],
                'avatar' => Common::getWebImageLink($elem['avatar']),
                'time' => date('d/m/Y H:i', $elem['datecreate'])
        );
    }
    $dtr['data'][Constant::TYPE_SONG] = array(
            '_id' => $songParentCate['_id'],
            'icon' => Constant::BASE_URL.'/assets/app/icon_nhac.png',
            'type' => Constant::TYPE_SONG,
            'name' => 'Bài hát',
            'list' => $dataSong,
            'category' => $allSongCate
    );

    ###List thư viện
    $tvcl = $dbmg->thuvien;
    $thuvienParentCate = $categoryCl->findOne(array('parentid'=>'0','type' => Constant::TYPE_THUVIEN));
    $allThuvienCateHome = array(
        Constant::TYPE_FAMOUS => 'Người nổi tiếng',
        Constant::TYPE_VIDEO => 'Video',
        Constant::TYPE_RADIO => 'Radio',
        Constant::TYPE_IDIOM => 'Thành ngữ',
        Constant::TYPE_FILM => 'Phim',
        Constant::TYPE_DAILY => 'Tiếng Anh hàng ngày',
        Constant::TYPE_EXP => 'Kinh nghiệm'
    );

    $iconArr = array(
        Constant::TYPE_FAMOUS => Constant::BASE_URL.'/assets/app/sidebar_icon_nguoinoitieng.png',
        Constant::TYPE_VIDEO => Constant::BASE_URL.'/assets/app/icon_sidebar_video.png',
        Constant::TYPE_RADIO => Constant::BASE_URL.'/assets/app/sidebar_icon_radio.png',
        Constant::TYPE_IDIOM => Constant::BASE_URL.'/assets/app/icon_sidebar_thanhngu.png',
        Constant::TYPE_FILM => Constant::BASE_URL.'/assets/app/icon_phim.png',
        Constant::TYPE_DAILY => Constant::BASE_URL.'/assets/app/icon_sidebar_hangngay.png',
        Constant::TYPE_EXP => Constant::BASE_URL.'/assets/app/icon_kinhnghiem.png',
    );
    foreach($allThuvienCateHome as $key=>$value){
        $parentCate = $categoryCl->findOne(array('parentid'=> $thuvienParentCate['_id'], 'type'=> $key));
        $allChildCate = iterator_to_array($categoryCl->find(array('parentid'=>$parentCate['_id']), array('_id','name')), false);
        $condPost = array(
            'status' => Constant::STATUS_ENABLE,
            'category' => $parentCate['_id'],
            '$or' => array(
                    array('calendar' => array('$exists'=>false)),
                    array('calendar' => array('$lte'=> time()))
            )
        );
        $listPost = iterator_to_array($tvcl->find($condPost)->sort(array("_id"=>-1))->limit($limit),false);
        $dataPost = array();
        foreach($listPost as $elem){
            $dataPost[] = array(
                    '_id' => $elem['_id'],
                    'name' => $elem['name'],
                    'avatar' => Common::getWebImageLink($elem['avatar']),
                    'time' => date('d/m/Y H:i', $elem['datecreate'])
            );
        }
        $dtr['data'][$key] = array(
                '_id' => $parentCate['_id'],
                'icon' => $iconArr[$key],
                'type' => $key,
                'name' => $value,
                'list' => $dataPost,
                'category' => $allChildCate
        );
    }

    ###List trò chơi
    $gameParentCate = $categoryCl->findOne(array('parentid'=>'0', 'type' => Constant::TYPE_HOCMACHOI));
    $allTopic = iterator_to_array($categoryCl->find(array('parentid'=>$gameParentCate['_id']), array('_id','name')), false);
    $dtr['data'][Constant::TYPE_HOCMACHOI] = array(
            'type' => Constant::TYPE_HOCMACHOI,
            'icon' => Constant::BASE_URL.'/assets/app/icon_game.png',
            'name' => 'Trò chơi',
            'list' => $allTopic,
    );

    ##Popup
    $dtr['popup'] = '';
    if(isset($_SESSION['uinfo']))
        $login = '1';
    else
        $login = '2';
    $popupCond = array(
            'status' => Constant::STATUS_ENABLE,
            'start' => array('$lte'=>time()),
            'end' => array('$gte'=>time()),
            'url' => '',
            'login' => array('$in' => array($login, '3')),
            'ver' => 'app'
    );
    $popup = $popupcl->findOne($popupCond, array('_id', 'content', 'timeout', 'count_on_day', 'distance_time'));
    if($popup){
        $popupId = $popup['_id'];
        $popup['content'] = _getTrueLink($popup['content']);
        $popupCount = isset($_SESSION['popup_count_'.$popupId]) ? $_SESSION['popup_count_'.$popupId] : 0;
        $popupTime = isset($_SESSION['popup_time_'.$popupId]) ? $_SESSION['popup_time_'.$popupId] : 0;
        if($popupCount < $popup['count_on_day'] && time()-$popupTime>=$popup['distance_time']){
            $popupCount++;
            $_SESSION['popup_count_'.$popupId] = $popupCount;
            $_SESSION['popup_time_'.$popupId] = time();
            unset($popup['count_on_day'], $popup['distance_time']);
            $dtr['popup'] = $popup;
        }
    }

    ##event welcome
    if(isset($_SESSION['uinfo'])){
        $checkFreeUser = $freecl->findOne(array('phone'=>$_SESSION['uinfo']['phone']));
        if($checkFreeUser){
            if($checkFreeUser['show'] == 0){
                $dtr['popup']['timeout'] = 0;
                $dtr['popup']['content'] = '<h1 style="text-align: center>CHÚC MỪNG!</h1>
                <div style="text-align: center">
                    <p>Bạn đã nhận được học bổng của English360, khóa học hoàn toàn miễn phí trong 15 ngày.</p>
                    <p>Chúc bạn có khoảng thời gian học tập thú vị cùng English360.</p>
                </div>';
                $freecl->update(array('phone'=>$_SESSION['uinfo']['phone']), array('$set'=>array('show'=>1)));
            }
            $dateDiff = (time() - $checkFreeUser['_id'])/86400;
            if($dateDiff > 15){
                $dtr['popup']['timeout'] = 0;
                $dtr['popup']['content'] = '<h1 style="text-align: center>THÔNG BÁO</h1>
                <div style="text-align: center">
                    <p>Khóa học bổng của English360 đã kết thúc. Bạn hãy tiếp tục đăng ký để nhận được các ưu đãi sau:</p>
                    <p>- Được tham gia tất cả các bài học của English360</p>
                    <p>- Được miễn phí 1 ngày học tiếp theo</p>
                    <p>Soạn tin DK E gửi 9317 để đăng ký.</p>>
                </div>';
            }
        }
    }

//    $dtr['data']['thuvien'] = $listtv;
    echo json_encode($dtr);
    exit();
}

function getListByCate(){
    global $dbmg;
    $categoryCl = $dbmg->category;
    $dtr['status'] = 500;
    $id = $_GET['id'];
    $type = $_GET['type'];
    $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1)*$limit;
    if(empty($id) || empty($type)){
        $dtr['message'] = 'Thiếu id hoặc type danh mục';
        echo json_encode($dtr);exit();
    }

    $cateCl = Common::getClFromType($type);

    $cateCl = $dbmg->$cateCl;
    $allCateChild = iterator_to_array($categoryCl->find(array('parentid'=>$id), array('_id','name')), false);
    $dtr['category'] = $allCateChild;
    $dtr['data'] = array();
    $cond = array(
            "status"=>Constant::STATUS_ENABLE,
            'category' => $id,
            '$or' => array(
                    array('calendar' => array('$exists'=>false)),
                    array('calendar' => array('$lte'=> time()))
            )
    );
    $dataSlide = iterator_to_array($cateCl->find($cond, array('_id','name','avatar','datecreate'))->sort(array("_id"=>-1))->limit(5),false);
    $slideId = array();
    foreach($dataSlide as $key=>$val){
        $slideId[] = $val['_id'];
        $dataSlide[$key]['avatar'] = Common::getWebImageLink($val['avatar']);
        $dataSlide[$key]['type'] = $type;
        $dataSlide[$key]['time'] = date('d/m/Y H:i', $val['datecreate']);
    }
    $dtr['slideshow'] = $dataSlide;
    $cond['_id'] = array('$nin'=>$slideId);
    $totalpage = ceil($cateCl->count($cond) / $limit);
    $list = iterator_to_array($cateCl->find($cond)->sort(array("_id"=>-1))->skip($start)->limit($limit),false);
//    var_dump($list);die;
    foreach($list as $item){
        $dtr['data'][] = array(
                '_id' => $item['_id'],
                'name' => $item['name'],
                'avatar' => Common::getWebImageLink($item['avatar']),
                'time' => date('d/m/Y H:i', $item['datecreate'])
        );
    }

    $dtr['status'] = 200;
    $dtr['totalpage'] = $totalpage;
    echo json_encode($dtr);exit();
}

function getDetail(){
    global $dbmg;
    $historycl = $dbmg->history_log;
    $popupcl = $dbmg->popup;
    $freecl = $dbmg->free_user;
    $configcl = $dbmg->config;
    $dtr['status'] = 500;
    if(!isset($_GET['id']) || !isset($_GET['type'])){
        $dtr['message'] = 'Thiếu id hoặc type.';
        echo json_encode($dtr);exit();
    }
    $id = $_GET['id'];
    $type = $_GET['type'];
    switch($type){
        case Constant::TYPE_SONG:
            $data = songDetail($id);
            break;
        case Constant::TYPE_GTCB:
            $data = gtcbDetail($id);
            break;
        case Constant::TYPE_LUYENNGUAM:
            $data = luyennguamDetail($id);
            break;
        default:
            $data = thuvienDetail($id, $type);
            break;
    }

    $data['tuvung'] = _getTrueLink($data['tuvung']);
    $data['tuvung'] .= '<audio style="width: 0;height: 0;" id="mainaudio" controls></audio>';
    $data['tuvung'] .= "<script src='".Constant::BASE_URL."/template/wap/asset/js/jquery-1.10.1.min.js'></script>
    <script>
            $(function(){
                $('.Loa').click(function(e){
                    var src = $(this).attr('alt');
                    $('#mainaudio').attr('src',src);
                    $('#mainaudio')[0].play();
                });
            })
    </script>";
    $data['tuvung'] .= '<style> img{max-width:100%; height: auto !important; display: block; } video{max-width:100%} table{max-width: 100%}</style>';
    $data['new'] = _getNewest();
    $dtr['data'] = $data;
    $dtr['status'] = 200;

    ##Popup
    $dtr['popup'] = '';
    $timeout = 0;
    $linkVms = '';
//    if(!isset($_SESSION['uinfo']) || Network::getUserInfo($_SESSION['uinfo']['phone'])!=1){
//        $config = $configcl->findOne(array('name' => Constant::CONFIG_POPUP_REG));
//        if($config){
//
//            $number = isset($_SESSION['number_popreg']) ? $_SESSION['number_popreg'] : 0;
//            if($number < $config['value']['number']){
//                $_SESSION['number_popreg'] = $number+1;
//                $timeout = $config['value']['timeout'];
//                if(Network::is3g() && Network::is3gmobifone() && Network::OPEN_REG){
//                    $link_callback = Constant::BASE_URL . "/wapportal.php?params=" . base64_encode('E' . '&WAP');
//                    $linkVms = Network::genLinkConfirmVms("E",$link_callback);
//                }
//            }
//        }
//    }
    if($timeout){
        if($linkVms)
            $popcontent = '<p style="text-align: center">Đăng ký English360 để học không giới hạn tiếng Anh giao tiếp: Học tiếng Anh qua bài hát, phim, radio, học tiếng Anh với người nổi tiếng,
                video các tình huống giao tiếp thông dụng. Dịch vụ không mất phí 3G, miễn phí 1 ngày dùng thử.
                </p>
                <p style="text-align: center; margin-top: 5px"><a href="'.$linkVms.'" class="ht_1">Đăng ký</a></p>';
        else
            $popcontent = '<p style="text-align: center">Đăng ký English360 để học không giới hạn tiếng Anh giao tiếp: Học tiếng Anh qua bài hát, phim, radio, học tiếng Anh với người nổi tiếng,
                video các tình huống giao tiếp thông dụng. Dịch vụ không mất phí 3G, miễn phí 1 ngày dùng thử.
                Phí DV: 2.000đ/ngày (gia hạn hàng ngày)</p>
                <p style="text-align: center; margin-top: 5px"><a href="'.Common::getSmsLink('9317','DK E').'" class="ht_1">Đăng ký</a></p>';

        $popcontent .= '<style>
                        .ht_1{
                            background-color: #146eb4;
                            border: medium none;
                            border-radius: 20px;
                            color: #fff;
                            cursor: pointer;
                            display: inline-block;
                            font-size: 14px;
                            padding: 8px 16px;
                            display: inline-block;
                            text-align: center;
                            margin: 0 2px;
                            font-weight: bold;
                        }
                    </style>';

        $dtr['popup'] = array(
            '_id' => '',
            'timeout' => $timeout,
            'content' => $popcontent
        );
    }else{
        if(isset($_SESSION['uinfo']))
            $login = '1';
        else
            $login = '2';
        $popupCond = array(
            'status' => Constant::STATUS_ENABLE,
            'start' => array('$lte'=>time()),
            'end' => array('$gte'=>time()),
            '$or' => array(
                array('url' => ''),
                array('url' => $id)
            ),
            'login' => array('$in' => array($login, '3')),
            'ver' => 'app'
        );
        $popup = $popupcl->findOne($popupCond, array('_id', 'content', 'timeout', 'count_on_day', 'distance_time'));
        if($popup){
            $popup['content'] = _getTrueLink($popup['content']);
            $popupId = $popup['_id'];
            $popupCount = isset($_SESSION['popup_count_'.$popupId]) ? $_SESSION['popup_count_'.$popupId] : 0;
            $popupTime = isset($_SESSION['popup_time_'.$popupId]) ? $_SESSION['popup_time_'.$popupId] : 0;
            if($popupCount < $popup['count_on_day'] && time()-$popupTime>=$popup['distance_time']){
                $popupCount++;
                $_SESSION['popup_count_'.$popupId] = $popupCount;
                $_SESSION['popup_time_'.$popupId] = time();
                unset($popup['count_on_day'], $popup['distance_time']);
                $dtr['popup'] = $popup;
            }
        }
    }


    ##event welcome
    if(isset($_SESSION['uinfo'])){
        $checkFreeUser = $freecl->findOne(array('phone'=>$_SESSION['uinfo']['phone']));
        if($checkFreeUser){
            if($checkFreeUser['show'] == 0){
                $dtr['popup']['timeout'] = 0;
                $dtr['popup']['content'] = '<h1 style="text-align: center>CHÚC MỪNG!</h1>
                <div style="text-align: center">
                    <p>Bạn đã nhận được học bổng của English360, khóa học hoàn toàn miễn phí trong 15 ngày.</p>
                    <p>Chúc bạn có khoảng thời gian học tập thú vị cùng English360.</p>
                </div>';
                $freecl->update(array('phone'=>$_SESSION['uinfo']['phone']), array('$set'=>array('show'=>1)));
            }
            $dateDiff = (time() - $checkFreeUser['_id'])/86400;
            if($dateDiff > 15){
                $dtr['popup']['timeout'] = 0;
                $dtr['popup']['content'] = '<h1 style="text-align: center>THÔNG BÁO</h1>
                <div style="text-align: center">
                    <p>Khóa học bổng của English360 đã kết thúc. Bạn hãy tiếp tục đăng ký để nhận được các ưu đãi sau:</p>
                    <p>- Được tham gia tất cả các bài học của English360</p>
                    <p>- Được miễn phí 1 ngày học tiếp theo</p>
                    <p>Soạn tin DK E gửi 9317 để đăng ký.</p>>
                </div>';
            }
        }
    }

    //log
    $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => $type,
            'chanel' => HistoryLog::CHANEL_APP,
            'ip' => Network::ip(),
            'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
            'status' => Constant::STATUS_ENABLE,
            'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
            'price'=> 0,
        'useragent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""

    );
    $historycl->insert($newHistoryLog);
    echo json_encode($dtr);exit();
}

function songDetail($id){
    global $dbmg;
    $songCl = $dbmg->hmcaudio;
    $uploadcl = $dbmg->upload;
    $detail = $songCl->findOne(array('_id' => $id));
    $detail['medialink'] = Common::getWebImageLink($detail['medialink']);
    $detail['avatar'] = Common::getWebImageLink($detail['avatar']);
    $detail['datecreate'] = date('d/m/Y H:i', $detail['datecreate']);
    $detail['content'] = array(
        'eng' => _getTrueLink($detail['contents']['eng']),
        'vie' => _getTrueLink($detail['contents']['vie']),
    );
    unset($detail['contents']);
    $detail['sub'] = array(
        'eng' => !empty($detail['sub']['eng']) ? Common::getWebImageLink($detail['sub']['eng']) : '',
        'vie' => !empty($detail['sub']['vie']) ? Common::getWebImageLink($detail['sub']['vie']): '',
    );
    $detail['lession'] = _getTrueLink($detail['lession']);
    $detail['lession'] .= '<audio style="width: 0;height: 0;" id="mainaudio" controls></audio>';
    $detail['lession'] .= "<script src='".Constant::BASE_URL."/template/wap/asset/js/jquery-1.10.1.min.js'></script>
    <script>
             $(function(){
                $('.Loa').click(function(e){
                    var src = $(this).attr('alt');
                    $('#mainaudio').attr('src',src);
                    $('#mainaudio')[0].play();
                });
            })
    </script>";
    $detail['lession'] .= '<style> img{max-width:100%; height: auto !important; display: block;} video{max-width:100%} table{max-width: 100%}</style>';

    $related = iterator_to_array($songCl->find(array(
            '_id'=> array('$ne'=>$id),
            'category' => array('$in'=>$detail['category']),
    ), array('_id', 'name', 'datecreate', 'avatar'))->sort(array('datecreate'=> -1))->limit(5), false);
    foreach($related as $key=>$val){
        $related[$key]['avatar'] = Common::getWebImageLink($val['avatar']);
        $related[$key]['datecreate'] = date('d/m/Y H:i', $val['datecreate']);
        $related[$key]['type'] = Constant::TYPE_SONG;
    }
    $detail['related'] = $related;

    //upload
    $allUpload = iterator_to_array($uploadcl->find(array('type'=>Constant::TYPE_SONG,'itemid'=>$id),array('_id','uid','path','datecreate','type','itemid'))->sort(array('datecreate'=>-1)),false);
    foreach($allUpload as $key=>$val){
        $allUpload[$key]['datecreate'] = date('d/m/Y H:i', $val['datecreate']);
        $allUpload[$key]['path'] = Common::getWebImageLink($val['path']);
        $allUpload[$key]['uinfo'] = _getDisplayInfo($val['uid']);
        $allUpload[$key]['allow_delete'] = isset($_SESSION['uinfo']) && $_SESSION['uinfo']['_id'] == $val['uid'] ? 1 : 0;
        unset($allUpload[$key]['uid'],$allUpload[$key]['type'],$allUpload[$key]['itemid']);
    }
    $detail['upload'] = $allUpload;
    return $detail;
}

function gtcbDetail($id){
    global $dbmg;
    $gtcbCl = $dbmg->gtcb;
    $detail = $gtcbCl->findOne(array('_id' => $id));
    $detail['medialink'] = Common::getWebImageLink($detail['medialink']);
    $detail['avatar'] = Common::getWebImageLink($detail['avatar']);
    $detail['datecreate'] = date('d/m/Y H:i', $detail['datecreate']);
    $detail['tuvung'] = _getTrueLink($detail['tuvung']);
    $detail['contents'] = _getTrueLink($detail['contents']);
    $detail['contents'] .= '<audio style="width: 0;height: 0;" id="mainaudio" controls></audio>';
    $detail['contents'] .= "<script src='".Constant::BASE_URL."/template/wap/asset/js/jquery-1.10.1.min.js'></script>
    <script>
             $(function(){
                $('.Loa').click(function(e){
                    var src = $(this).attr('alt');
                    $('#mainaudio').attr('src',src);
                    $('#mainaudio')[0].play();
                });
            })
    </script>";
    $detail['contents'] .= '<style> img{max-width:100%; height: auto !important; display: block;} video{max-width:100%} table{max-width: 100%}</style>';

    $detail['content'] = array(
        'eng' => _getTrueLink($detail['content']['eng']),
        'vie' => _getTrueLink($detail['content']['vie']),
    );
    $detail['sub'] = array(
        'eng' => !empty($detail['sub']['eng']) ? Common::getWebImageLink($detail['sub']['eng']) : '',
        'vie' => !empty($detail['sub']['vie']) ? Common::getWebImageLink($detail['sub']['vie']) : '',
    );

    $related = iterator_to_array($gtcbCl->find(array(
            '_id'=> array('$ne'=>$id),
            'category' => array('$in'=>$detail['category']),
    ), array('_id', 'name', 'datecreate', 'avatar'))->sort(array('datecreate'=> -1))->limit(5), false);
    foreach($related as $key=>$val){
        $related[$key]['avatar'] = Common::getWebImageLink($val['avatar']);
        $related[$key]['datecreate'] = date('d/m/Y H:i', $val['datecreate']);
        $related[$key]['type'] = Constant::TYPE_GTCB;
    }
    $detail['related'] = $related;
    return $detail;
}

function luyennguamDetail($id){
    global $dbmg;
    $lnaCl = $dbmg->luyennguam;
    $detail = $lnaCl->findOne(array('_id' => $id));
    $detail['medialink'] = Common::getWebImageLink($detail['medialink']);
    $detail['avatar'] = Common::getWebImageLink($detail['avatar']);
    $detail['datecreate'] = date('d/m/Y H:i', $detail['datecreate']);
    $detail['contents'] = _getTrueLink($detail['contents']);
    $detail['contents'] .= '<audio style="width: 0;height: 0;" id="mainaudio" controls></audio>';
    $detail['contents'] .= "<script src='".Constant::BASE_URL."/template/wap/asset/js/jquery-1.10.1.min.js'></script>
    <script>
            $(function(){
                $('.Loa').click(function(e){
                    var src = $(this).attr('alt');
                    $('#mainaudio').attr('src',src);
                    $('#mainaudio')[0].play();
                });
            })
    </script>";
    $detail['contents'] .= '<style> img{max-width:100%; height: auto !important; display: block; } video{max-width:100%} table{max-width: 100%}</style>';

    $detail['sub'] = array(
        'eng' => !empty($detail['sub']['eng']) ? Common::getWebImageLink($detail['sub']['eng']) : '',
        'vie' => !empty($detail['sub']['vie']) ? Common::getWebImageLink($detail['sub']['vie']) : '',
    );

    $related = iterator_to_array($lnaCl->find(array(
            '_id'=> array('$ne'=>$id),
            'category' => array('$in'=>$detail['category']),
    ), array('_id', 'name', 'datecreate', 'avatar'))->sort(array('datecreate'=> -1))->limit(5), false);
    foreach($related as $key=>$val){
        $related[$key]['avatar'] = Common::getWebImageLink($val['avatar']);
        $related[$key]['datecreate'] = date('d/m/Y H:i', $val['datecreate']);
        $related[$key]['type'] = Constant::TYPE_LUYENNGUAM;
    }
    $detail['related'] = $related;
    return $detail;
}

function thuvienDetail($id, $type){
    global $dbmg;
    $thuvienCl = $dbmg->thuvien;
    $detail = $thuvienCl->findOne(array('_id' => $id));
    $detail['medialink'] = Constant::BASE_URL . $detail['medialink'];
    $detail['avatar'] = Constant::BASE_URL . $detail['avatar'];
    $detail['datecreate'] = date('d/m/Y H:i', $detail['datecreate']);
    $detail['sub'] = array(
        'eng' => !empty($detail['sub']['eng']) ? Common::getWebImageLink($detail['sub']['eng']) : '',
        'vie' => !empty($detail['sub']['vie']) ? Common::getWebImageLink($detail['sub']['vie']) : '',
    );
    $detail['content'] = array(
        'eng' => _getTrueLink($detail['content']['eng']),
        'vie' => _getTrueLink($detail['content']['vie']),
    );
    $detail['lession'] = _getTrueLink($detail['lession']);
    $detail['lession'] .= '<audio style="width: 0;height: 0;" id="mainaudio" controls></audio>';
    $detail['lession'] .= "<script src='".Constant::BASE_URL."/template/wap/asset/js/jquery-1.10.1.min.js'></script>
    <script>
            $(function(){
                $('.Loa').click(function(e){
                    var src = $(this).attr('alt');
                    $('#mainaudio').attr('src',src);
                    $('#mainaudio')[0].play();
                });
            })
    </script>";
    $detail['lession'] .= '<style> img{max-width:100%; height: auto !important; display: block; } video{max-width:100%} table{max-width: 100%}</style>';

    $related = iterator_to_array($thuvienCl->find(array(
            '_id'=> array('$ne'=>$id),
            'category' => array('$in'=>$detail['category']),
            '$or' => array(
                    array('calendar' => array('$exists'=>false)),
                    array('calendar' => array('$lte'=> time()))
            )
    ), array('_id', 'name', 'datecreate', 'avatar'))->sort(array('datecreate'=> -1))->limit(5), false);
    foreach($related as $key=>$val){
        $related[$key]['avatar'] = Common::getWebImageLink($val['avatar']);
        $related[$key]['datecreate'] = date('d/m/Y H:i', $val['datecreate']);
        $related[$key]['type'] = $type;
    }
    $detail['related'] = $related;
    return $detail;
}

function _getNewest(){
    global $dbmg;
    $thuvienCl = $dbmg->thuvien;
    $cateCl = $dbmg->category;

    $cond = array(
            'status'=>Constant::STATUS_ENABLE,
            '$or' => array(
                    array('calendar' => array('$exists'=>false)),
                    array('calendar' => array('$lte'=> time()))
            )
    );
    $list = iterator_to_array($thuvienCl->find($cond, array('_id', 'name', 'datecreate', 'avatar','category'))->sort(array('datecreate'=>-1))->limit(5), false);

    foreach($list as $key=>$val){
        $cate = $cateCl->findOne(array('_id'=>array('$in'=>$val['category'])));
        $list[$key]['type'] = $cate['type'];
        $list[$key]['nametype'] = $cate['name'];
        $list[$key]['avatar'] = Common::getWebImageLink($val['avatar']);
        $list[$key]['datecreate'] = date('d/m/Y H:i', $val['datecreate']);
        unset($list[$key]['category']);
    }
    return $list;
}

function sidebar(){
    global $dbmg;
//    $notifycl = $dbmg->notify;
//    $categorycl = $dbmg->category;
//    $thuvienId = $categorycl->findOne(array('parentid'=>'0', 'type'=> Constant::TYPE_THUVIEN))['_id'];
//    $famousId = $categorycl->findOne(array('parentid'=>$thuvienId, 'type' => Constant::TYPE_FAMOUS))['_id'];
//    $videoId = $categorycl->findOne(array('parentid'=>$thuvienId, 'type'=>Constant::TYPE_VIDEO))['_id'];
//    $radioId = $categorycl->findOne(array('parentid'=>$thuvienId, 'type'=>Constant::TYPE_RADIO))['_id'];
//    $idiomId = $categorycl->findOne(array('parentid'=>$thuvienId, 'type'=>Constant::TYPE_IDIOM))['_id'];
//    $dailyId = $categorycl->findOne(array('parentid'=>$thuvienId, 'type'=>Constant::TYPE_DAILY))['_id'];
//    $gtcbId = $categorycl->findOne(array('parentid'=>'0', 'type'=>Constant::TYPE_GTCB))['_id'];
//    $lnaId = $categorycl->findOne(array('parentid'=>'0', 'type'=>Constant::TYPE_LUYENNGUAM))['_id'];
//    $songId = $categorycl->findOne(array('parentid'=>'0', 'type'=>Constant::TYPE_SONG))['_id'];
    $famousId = '1450844989';
    $videoId = '1427183162';
    $radioId = '1427344702';
    $idiomId = '1427183137';
    $dailyId = '1428995217';
    $gtcbId = '1425089128';
    $lnaId = '1451894509';
    $expId = '1427344743';
    $songId = '1450854263';
    $filmId = '1450861603';
    $hmcId = '1425089517';

    $dtr['status'] = 200;
    $ui = $_SESSION['uinfo'];
    $dtr['data'] = array(
        array(
            '_id' => $famousId,
            'icon' => Constant::BASE_URL.'/assets/app/sidebar_icon_nguoinoitieng.png',
            'type' => Constant::TYPE_FAMOUS,
            'name' => 'Người nổi tiếng'
        ),
        array(
            '_id' => $gtcbId,
            'icon' => Constant::BASE_URL.'/assets/app/sidebar_icon_giaotiep.png',
            'type' => Constant::TYPE_GTCB,
            'name' => 'Giao tiếp cơ bản'
        ),
        array(
            '_id' => $videoId,
            'icon' => Constant::BASE_URL.'/assets/app/icon_sidebar_video.png',
            'type' => Constant::TYPE_VIDEO,
            'name' => 'Video',
        ),
        array(
            '_id' => $radioId,
            'icon' => Constant::BASE_URL.'/assets/app/sidebar_icon_radio.png',
            'type' => Constant::TYPE_RADIO,
            'name' => 'Radio'
        ),
        array(
            '_id' => $idiomId,
            'icon' => Constant::BASE_URL.'/assets/app/icon_sidebar_thanhngu.png',
            'type' => Constant::TYPE_IDIOM,
            'name' => 'Thành ngữ'
        ),
        array(
            '_id' => $dailyId,
            'icon' => Constant::BASE_URL.'/assets/app/icon_sidebar_hangngay.png',
            'type' => Constant::TYPE_DAILY,
            'name' => 'Tiếng Anh hàng ngày'
        ),
        array(
            '_id' => '',
            'icon' => Constant::BASE_URL.'/assets/app/sidebar_icon_tudien.png',
            'type' => Constant::TYPE_TUDIEN,
            'name' => 'Từ điển'
        ),
        array(
            '_id' => $lnaId,
            'icon' => Constant::BASE_URL.'/template/wap/asset/images/sidebar_icon_nguam.png',
            'type' => Constant::TYPE_LUYENNGUAM,
            'name' => 'Ngữ âm'
        ),
        array(
            '_id' => $expId,
            'icon' => Constant::BASE_URL.'/template/wap/asset/images/sidebar_icon_kinhnghiem.png',
            'type' => Constant::TYPE_EXP,
            'name' => 'Kinh nghiệm'
        ),
        array(
            '_id' => '',
            'icon' => Constant::BASE_URL.'/assets/app/sidebar_icon_hoidap.png',
            'type' => Constant::TYPE_HOIDAP,
            'name' => 'Hỏi đáp'
        ),
        array(
            '_id' => $songId,
            'icon' => Constant::BASE_URL.'/assets/app/icon_nhac.png',
            'type' => Constant::TYPE_SONG,
            'name' => 'Bài hát'
        ),
        array(
            '_id' => $filmId,
            'icon' => Constant::BASE_URL.'/assets/app/icon_phim.png',
            'type' => Constant::TYPE_FILM,
            'name' => 'Phim'
        ),
        array(
            '_id' => $hmcId,
            'icon' => Constant::BASE_URL.'/assets/app/icon_game.png',
            'type' => Constant::TYPE_HOCMACHOI,
            'name' => 'Trò chơi'
        ),
        array(
            '_id' => '',
            'icon' => Constant::BASE_URL.'/assets/app/sidebar_icon_gioithieu.png',
            'type' => Constant::TYPE_INFO,
            'name' => 'Giới thiệu dịch vụ'
        ),
        array(
            '_id' => '',
            'icon' => Constant::BASE_URL.'/assets/app/sidebar_icon_dieukhoan.png',
            'type' => Constant::TYPE_TERM,
            'name' => 'Điều khoản sử dụng'
        ),
        array(
            '_id' => '',
            'icon' => Constant::BASE_URL.'/assets/app/sidebar_icon_thoat.png',
            'type' => 'logout',
            'name' => 'Thoát'
        )
    );
    $dtr['displayname'] = 'Tài khoản';
    if (isset($ui)) {
##Select Count Notify + Mail
//        $notifycount =  $notifycl->count(array("uid" => $ui['_id'], "status" => "1", "type" => "notify"));
//        $dtr['notifycount'] = $notifycount;
        $dtr['displayname'] = isset($ui['displayname']) ? $ui['displayname'] : $ui['phone'];
    }

    echo json_encode($dtr);
    exit;
}

function login(){
    global $dbmg;
    $usercl = $dbmg->user;
    $faqcl = $dbmg->faq;
    $notifycl = $dbmg->notify;
    $historycl = $dbmg->history_log;
    $dtr['status'] = 500;
    if(!isset($_GET['phone']) || !isset($_GET['password'])){
        $dtr['mss'] = 'Vui lòng điền đầy đủ số điện thoại/tên đăng nhập và mật khẩu.';
        echo json_encode($dtr);exit;
    }
    $phone = $_GET['phone'];
    $phone = strtolower($phone);
//    if(!Network::mobifoneNumber($phone)){
//        $dtr['mss'] = 'Vui lòng nhập số điện thoại MobiFone.';
//        echo json_encode($dtr);exit;
//    }
    $password = Common::encryptpassword($_GET['password']);
    $o = $usercl->findOne(array('$or'=>array(array('phone'=>$phone),array('username'=>$phone))), array('_id', 'phone', 'thong_bao', 'fullname', 'birthday', 'cmnd', 'cmnd_ngaycap', 'cmnd_noicap', 'displayname', 'email', 'priavatar', 'password', 'status'));
//    var_dump($o);die;
    if(!$o){
        $dtr['mss'] = 'Số điện thoại/Tên đăng nhập này chưa được đăng ký.';
        echo json_encode($dtr);exit;
    }
    $checkTCSMS = Network::checkTCSMS($phone);
    $o['thong_bao'] = array(
        'noti' => $o['thong_bao']['noti'],
        'sms' => $checkTCSMS==0? '1' : '0',
        'email' => $o['thong_bao']['email']
    );

    if($password != $o['password']){
        $dtr['mss'] = 'Mật khẩu không đúng, vui lòng thử lại.';
        echo json_encode($dtr);exit;
    }

//    if ($o['status'] != 0) {
        ## Set thoong tin ban đầu
        $o['displayname'] = getFullDisplayName($o);
        $o['priavatar'] = isset($o['priavatar']) && !empty($o['priavatar']) ? Common::getWebImageLink($o['priavatar']) : '';
        $o['cmnd'] = isset($o['cmnd']) ? $o['cmnd'] : '';
        $o['cmnd_ngaycap'] = isset($o['cmnd_ngaycap']) ? $o['cmnd_ngaycap'] :'';
        $o['cmnd_noicap'] = isset($o['cmnd_noicap']) ? $o['cmnd_noicap'] :'';
        $o['birthday'] = isset($o['birthday']) ? $o['birthday'] :'';
        $o['email'] = isset($o['email']) ? $o['email'] : '';
        $checkTCSMS = Network::checkTCSMS($phone);
        $o['thong_bao'] = array(
                'noti' => isset($o['thong_bao']['noti']) ? $o['thong_bao']['noti'] : '0',
                'sms' => $checkTCSMS==0? '1' : '0',
                'email' => isset($o['thong_bao']['email']) ? $o['thong_bao']['email'] : '0'
        );

        unset ($o['password']);
        unset ($o['namenoneutf']);
        unset ($o['datecreate']);
        unset ($o['priority']);
        unset ($o['status']);
        unset ($o['sendsmscount']);
        unset ($o['is_active']);
        unset ($o['role']);
        unset ($o['file_upload']);
        unset ($o['permission']);
        unset ($o['dob']);
        unset ($o['un_password']);

        $_SESSION['uinfo'] = $o;
       /* $mgconn->close();
        if(isset($_GET['rd'])) $link = $_GET['rd'];
        else $link = "index.php";
        header("Location: $link");*/
        $dtr['status'] = 200;
        $dtr['mss'] = "Đăng nhập thành công";
        $dtr['data'] = $_SESSION['uinfo'];
        $dtr['ssid'] = session_id();
//    } else { // Kiểm tra xem tài khoản đã đc active chưa. Nếu chưa đưa người dùng về trang active
//        $_SESSION['activephone'] = $o['phone'];
//        $mgconn->close();
//        header("Location: /active.php?p=reactive");
//    }
    $ui = $_SESSION['uinfo'];
//    if (isset($ui)) {
//        $tabbarinfo = array(
//            "notifycount" => $notifycl->count(array("uid" => $ui['_id'], "status" => "1", "type" => "notify")),
//            "mailcount" => $notifycl->count(array("uid" => $ui['_id'], "status" => "1", "type" => "mail"))
//        );
//    }
//    $dtr['countinfor'] = $tabbarinfo;
    ##log
    $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_DANG_NHAP,
            'chanel' => HistoryLog::CHANEL_APP,
            'ip' => Network::ip(),
            'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
            'status' => Constant::STATUS_ENABLE,
            'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
            'price'=> 0,
            'useragent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""

    );
    $historycl->insert($newHistoryLog);
    echo json_encode($dtr);exit;
}

function logout() {
    global $dbmg;
    $historycl = $dbmg->history_log;
    ##log
    $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_DANG_XUAT,
            'chanel' => HistoryLog::CHANEL_APP,
            'ip' => Network::ip(),
            'uid' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['_id'] : '',
            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
            'status' => Constant::STATUS_ENABLE,
            'phone' => isset($_SESSION['uinfo']) ? $_SESSION['uinfo']['phone'] : '',
            'price'=> 0,
            'useragent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""

    );
    $historycl->insert($newHistoryLog);
    session_start();
    session_destroy();
    $dtr['status'] = 200;
    $dtr['mss'] = "Đăng xuất thành công";
    echo json_encode($dtr);
}

function register(){
    global $dbmg;
    $usercl = $dbmg->user;
    $historycl = $dbmg->history_log;
    $dtr['status'] = 500;
    if(!isset($_GET['phone'])){
        $dtr['mss'] = 'Vui lòng nhập số điện thoại.';
        echo json_encode($dtr);exit;
    }
    $phone = $_GET['phone'];
    if(!Network::mobifoneNumber($phone)){
        $dtr['mss'] = 'Vui lòng nhập số điện thoại MobiFone.';
        echo json_encode($dtr);exit;
    }

    $checkUser = $usercl->findOne(array('phone' => $phone));
    if(!empty($checkUser)){
        $sendPassCount = isset($checkUser['send_pass']['count']) ? $checkUser['send_pass']['count'] : 0;
        $sendPassTime = isset($checkUser['send_pass']['time']) ? $checkUser['send_pass']['time'] : time();
        if(time() - $sendPassTime > 60*60){
            $sendPassCount = 0;
        }
        if($sendPassCount >= 5){
            $dtr['mss'] = 'Quý khách đã lấy mật khẩu 5 lần. Vui lòng chờ sau 60 phút để lấy lại mật khẩu.';
            echo json_encode($dtr);exit;
        }
        $dtr['mss'] = 'Tài khoản đã tồn tại. Mật khẩu đã được gửi về số điện thoại của quý khách. Vui lòng đăng nhập để sử dụng dịch vụ.';
        $info = 'Mật khẩu để sử dụng dịch vụ English360 của Quý khách là:'.$checkUser['un_password'];
        Network::sentMT($phone, 'MK', $info);
        $usercl->update(array('phone' => $phone), array('$set'=>array('send_pass'=>array('count'=>$sendPassCount + 1, 'time'=>time()))));
        echo json_encode($dtr);exit;
    }
    $password = Common::generateRandomPassword();
    $timeNow = time();
    $info = 'Mật khẩu để sử dụng dịch vụ English360 của Quý khách là:'.$password;
    $resultSMS = Network::sentMT($phone, 'MK', $info);
    if($resultSMS != 0){
        $dtr['mss'] = 'Không thể gửi tin nhắn đến số điện thoại của bạn, vui lòng thử lại sau.';
        echo json_encode($dtr);exit;
    }

    $newAccount = array(
        '_id' => strval($timeNow),
        'phone' => $phone,
        'password' => Common::encryptpassword($password),
        'un_password' => $password,
        'datecreate' => $timeNow,
        'status'=>Constant::STATUS_ENABLE,
        'thong_bao' => array(
            'noti' => "1",
            'sms' => "1",
            'email' => "1",
        ),
        'cmnd'=>'',
        'cmnd_noicap'=>'',
        'cmnd_ngaycap'=>'',
        'email'=>'',
        'birthday'=>'',
        'priavatar' => '',
        'fullname' => ''
    );

    $usercl->insert($newAccount);
    $dtr['status'] = 200;
    $dtr['mss'] = 'Mật khẩu đã được gửi về số điện thoại của bạn. Vui lòng kiểm tra lại.';
    ##log
    ##log
    $newHistoryLog = array(
            '_id' => strval(time().rand(10,99)),
            'datecreate' => time(),
            'action' => HistoryLog::LOG_DANG_KY,
            'chanel' => HistoryLog::CHANEL_APP,
            'ip' => Network::ip(),
            'uid' => '',
            'url' => Constant::BASE_URL.$_SERVER['REQUEST_URI'],
            'status' => Constant::STATUS_ENABLE,
            'phone' => $phone,
            'price'=> 0,
            'useragent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""

    );
    $historycl->insert($newHistoryLog);
    echo json_encode($dtr);exit;
}

function search(){
    global $dbmg;
    $gtcbcl= $dbmg->gtcb;
    $lnacl = $dbmg->luyennguam;
    $thuviencl = $dbmg->thuvien;
    $songcl = $dbmg->hmcaudio;
    $cateCl = $dbmg->category;
    $dtr['status'] = 200;
    $keyword = !empty($_GET['keyword']) ? convert_vi_to_en(strip_tags(trim($_GET['keyword']))) : '';
    $keywordRegex = new MongoRegex('/' . Common::convert_vi_to_en($keyword) . '/ui');
//    $page = !empty($_GET['page']) && intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
//    $limit = 10;
//    $cp = ($page - 1) * $limit;

    $list= array();
    $cond = array('namenonutf'=>$keywordRegex);
    $sort = array('datecreate'=>-1);
    $allGtcb = $gtcbcl->find($cond)->sort($sort)->limit(5);
    foreach($allGtcb as $aGtcb){
        $list[] = array(
            '_id' => $aGtcb['_id'],
            'name' => $aGtcb['name'],
            'avatar' => Common::getWebImageLink($aGtcb['avatar']),
            'datecreate' => date('d/m/Y H:i', $aGtcb['datecreate']),
            'type' => Constant::TYPE_GTCB
        );
    }

    $allLna = $lnacl->find($cond)->sort($sort)->limit(5);
    foreach($allLna as $aLna){
        $list[] = array(
            '_id' => $aLna['_id'],
            'name' => $aLna['name'],
            'avatar' => Common::getWebImageLink($aLna['avatar']),
            'datecreate' => date('d/m/Y H:i', $aLna['datecreate']),
            'type' => Constant::TYPE_LUYENNGUAM
        );
    }

    $allSong = $songcl->find($cond)->sort($sort)->limit(5);
    foreach($allSong as $aSong){
        $list[] = array(
            '_id' => $aSong['_id'],
            'name' => $aSong['name'],
            'avatar' => Common::getWebImageLink($aSong['avatar']),
            'datecreate' => date('d/m/Y H:i', $aSong['datecreate']),
            'type' => Constant::TYPE_SONG
        );
    }

    $allThuvien = $thuviencl->find($cond)->sort($sort)->limit(20);
    foreach($allThuvien as $aThuvien){
        $cate = $cateCl->findOne(array('_id'=>array('$in'=>$aThuvien['category'])));
        $list[] = array(
            '_id' => $aThuvien['_id'],
            'name' => $aThuvien['name'],
            'avatar' => Common::getWebImageLink($aThuvien['avatar']),
            'datecreate' => date('d/m/Y H:i', $aThuvien['datecreate']),
            'type' => $cate['type']
        );
    }
//    $totalCount = 0;
//    $totalCount = $cursor->count();
//    $dtr['gtcb'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),false);
//    unset ($cursor);

//    $cursor = $lnacl->find(array('namenonutf'=>$keywordRegex));
//    $totalCount = 0;
//    $totalCount = $cursor->count();
//    $dtr['lna'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),false);
//    unset ($cursor);
//
//    $cursor = $thuviencl->find(array('namenonutf'=>$keywordRegex));
//    $totalCount = 0;
//    $totalCount = $cursor->count();
//    $dtr['thuvien'] = iterator_to_array($cursor->sort(array('_id'=>-1))->skip($cp)->limit($limit),false);
//    unset ($cursor);

    $dtr['data'] = $list;
##Draw template
    echo json_encode($dtr);
}
function user(){
    global $dbmg;
    $notifycl = $dbmg->notify;
    $ui = $_SESSION['uinfo'];
    $uid = $ui['_id'];
    $t = $_GET['t'];if(!isset($t)) $t="home";
    if($t=="home") { // User profile
        $pagefile = "user/profile";
        $saveexamcl = $dbmg->saveexam;
        $listidex = (array)$saveexamcl->findOne(array("uid"=>$uid),array("uid","ex"));
        $gtcbcl = $dbmg->gtcb;
        $limit = 20;
        $p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
        $cond = array("_id"=>array('$in'=>$listidex['ex']));
        $listarticle = resortarray($gtcbcl->find($cond,array("_id","name")),$listidex['ex'],"_id");
        foreach($listarticle as $key=>$value){
            $t=$value['_id'];
             $listarticle[$key]['weblink'] = "http://tagt.nhacchovui.vn/appservice/gtcb.php?id=$t";
        }
        $dtr['status'] = 200;
        /*$dtr['home'] =$listidex;*/
        $dtr['name'] = $listarticle;
        #Paging
        /*$rowcount = $gtcbcl->count($cond);
        $totalpage = ceil($rowcount/$limit);if($totalpage<=1) $totalpage = 1;
        $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
        $tpl->assign("paging",$paginginfo);*/

        /*$tpl->assign("countsave",count($listidex['ex']));
        $tpl->assign("listarticle",$listarticle);
        $tpl->assign("obj",$ui);*/
    }
    else if($t=='notify') { // User Profile
        $pagefile = "user/notify";
        $limit = 20;
        $p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
        $cond = array("uid"=>$uid,"type"=>"notify");
        ## Lấy danh sách thông báo
        $listnotify = iterator_to_array($notifycl->find($cond,array("mss"))->sort(array("datecreate"=>-1))->skip($cp)->limit($limit),false);
        foreach($listnotify as $val){
            $t=$val['_id'];
            $listnotify["link"] = "http://tagt.nhacchovui.vn/hoidap.php?id=$t";
        }
        $dtr['status'] = 200;
        $dtr['notify'] = $listnotify;
        #Paging
        $rowcount = $notifycl->count($cond);
        $totalpage = ceil($rowcount/$limit);if($totalpage<=1) $totalpage = 1;
        $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
        /*$tpl->assign("paging",$paginginfo);
        $tpl->assign("listnotify",$listnotify);*/
    }
    else if($t=='mail'){ // User Mail
        $usercl = $dbmg->user;
        $pagefile = "user/mail";
        $limit = 20;
        $p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
        $cond = array("uid"=>$uid,"type"=>"mail");
        ## Lấy danh sách thông báo
        $listnotify = iterator_to_array($notifycl->find($cond)->sort(array("datecreate"=>-1))->skip($cp)->limit($limit),false);
        foreach($listnotify as $key=>$val){
            $listnotify[$key]['usersender'] = (array) $usercl->findOne(array("_id"=>$val['usercreate']),array("_id","name","username"));
        }
        $dtr['status'] = 200;
        $dtr['mail'] = $listnotify;
        #Paging
        $rowcount = $notifycl->count($cond);
        $totalpage = ceil($rowcount/$limit);if($totalpage<=1) $totalpage = 1;
        $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
       /* $tpl->assign("paging",$paginginfo);
        $tpl->assign("listnotify",$listnotify);*/
    }
    else if($t=='setup') {
        if(!empty($_POST)){
            $usercl = $dbmg->user;
            $_POST['dob'] = strtotime($_POST['dob']);
            $_POST['cmtnd_ngaycap'] = strtotime($_POST['cmtnd_ngaycap']);
            $usercl->update(array("_id"=>$uid),array('$set'=>$_POST),array("multiple"=>false));
            $ui = (array)$usercl->find(array("_id"=>$uid),array("priavatar","displayname","email","fullname","cmtnd","cmtnd_ngaycap","cmtnd_noicap","dob","address","gender"));
            $_SESSION['uinfo'] = $ui;
            $messageinfo = array("mss"=>"Cập nhật thông tin thành công","display"=>"");
            /*$tpl->assign("messageinfo",$messageinfo);*/

        }
        $ui['dob'] = date("d-m-Y",$ui['dob']);
        $ui['cmtnd_ngaycap'] = date("d-m-Y",$ui['cmtnd_ngaycap']);
       /* $tpl->assign("uinfo",$ui);*/
        $pagefile = "user/setup";
        unset ($ui['role']);
        unset ($ui['phone']);
        unset ($ui['username']);
        unset ($ui['namenoneutf']);
        unset ($ui['password']);
        unset ($ui['datecreate']);
        unset ($ui['priority']);
        unset ($ui['is_active']);
        unset ($ui['activecode']);
        unset ($ui['sendsmscount']);
        unset ($ui['status']);
        unset ($ui['datecountsms']);
        unset ($ui['file_upload']);
        unset ($ui['profile']);
        unset ($ui['namenonutf']);
        unset ($ui['permission']);
        $dtr['status'] = 200;
        $dtr['setup'] = $ui;


    }
    else if($t=='maildetail') {
        $id = $_GET['id'];
        $notifycl->update(array("_id"=>$id),array('$set'=>array("status"=>"0")));
        $objs = (array)$notifycl->findOne(array("_id"=>$id));
        /*$tpl->assign("obj",$objs);
        $pagefile = "user/maildetail";*/
        $dtr['status'] = 200;
        $dtr['maildetail'] = $objs;
    }
    echo json_encode($dtr);
}

function saveexam(){
    global $dbmg;
    $uinfo = $_SESSION['uinfo'];
    if(!isset($uinfo)) $dtr = array("status"=>505,"mss"=>"Bạn cần đăng nhập để thực hiện tính năng này");
    else {
        $saveexamcl = $dbmg->saveexam;
        $exid = $_POST['id'];
        $saveexamcl->update(array("uid"=>$uinfo['_id']),array('$addToSet'=>array("ex"=>$exid)),array("upsert"=>true));
        $dtr = array("status"=>200,"mss"=>"Lưu thành công");
    }
    echo json_encode($dtr);
}
function deletenotify(){
    global $dbmg;
    $uinfo = $_SESSION['uinfo'];
    if(!isset($uinfo)) $dtr = array("status"=>505,"mss"=>"Bạn cần đăng nhập để thực hiện tính năng này");
    else {
        $notifycl = $dbmg->notify;
        $ntid = $_POST['id'];
        $notifycl->remove(array("uid"=>$uinfo['_id'],"_id"=>$ntid));
        $dtr = array("status"=>200,"mss"=>"Xóa thành công");
    }
    echo json_encode($dtr);
}
function deleteexam(){
    global $dbmg;
    $uinfo = $_SESSION['uinfo'];
    if(!isset($uinfo)) $dtr = array("status"=>505,"mss"=>"Bạn cần đăng nhập để thực hiện tính năng này");
    else {
        $saveexamcl = $dbmg->saveexam;
        $exid = $_POST['id'];
        $saveexamcl->update(array("uid"=>$uinfo['_id']),array('$pull'=>array("ex"=>$exid)),array("upsert"=>false));
        $dtr = array("status"=>200,"mss"=>"Xóa thành công");
    }
    echo json_encode($dtr);
}

function active(){
    global $dbmg;
$usercl = $dbmg->user;
$mes = array('mss'=>"","class"=>"none");
if(!empty($_POST)){
    $querry = array("phone"=>$_POST['phone']);
    $userobj = (object) $usercl->findOne($querry);
    if ($userobj->_id){
        if ($userobj->activecode=== $_POST['activecode']){ // Người dùng nhập đúng  mã active
            $usercl->update($querry, array('$set'=>array("status"=>1,"is_active"=>1)), array("multiple"=>false));
            $_SESSION['uinfo'] = (array) $userobj;
            $mes = array('mss'=>"Kích hoạt thành công".'<p><a href="index.php">Quay lại trang chủ</a></p>',"class"=>"");
        }
        else $mes = array('mss'=>'Nhập sai mã xác thực. Vui lòng thử lại.',"class"=>""); // Nếu nhập sai mã
    }
    else  $mes = array('mss'=>'Không có người dùng với số điện thoại này',"class"=>""); // Nếu Số điện thoại chưa được đăng ký trên hệ thống
}
else {
    $_POST['phone'] = $_SESSION['activephone'];
    if($_GET['p']=="reactive")$mes = array('mss'=>"Tài khoản của bạn chưa được xác thực. Vui lòng nhập lại mã xác thực vào đây","class"=>"");
    else $mes = array('mss'=>"Bạn cần nhập đầy đủ thông tin","class"=>"none");
}
    $dtr['data'] = $querry;
    $dtr['mss'] = $mes;
    echo json_encode($dtr);
}

function getuserinfor() {
    global $dbmg;
    if (!isset($_SESSION['uinfo'])) {
        $dtr['mss'] = 'Bạn cần đăng nhập để có thể thực hiện chức năng này';
        $dtr['status'] = 403;
    } else {
        $dtr['mss'] = 'Thong tin ca nhan';
        $dtr['data'] = $_SESSION['uinfo'];
        $dtr['status'] = 200;
    }
    echo json_encode($dtr);
}

function updateinfor() {
    global $dbmg;
    $userCl = $dbmg->user;
    $dtr['status'] = 404;

    unset($_POST['act']);
    $checkError = false;

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $checkError = true;
        $dtr['mss'] = 'Địa chỉ email không đúng';
    }

    if (preg_match('![^-a-zA-Z0-9\\s]!i', convertToNonAccented($_POST['fullname'])) === 1) {
        $checkError = true;
        $dtr['mss'] = 'Họ tên không chứa các ký tự đặc biệt';
    }

    if (preg_match('![^-a-zA-Z0-9,\\s]!i', convertToNonAccented($_POST['place'])) === 1) {
        $checkError = true;
        $dtr['mss'] = 'Nơi cấp không chứa các ký tự đặc biệt';
    }

    if (preg_match('![^-/0-9\\s]!i', $_POST['birthday']) === 1) {
        $checkError = true;
        $dtr['mss'] = 'Ngày sinh không chứa chữ cái';
    }

    if (preg_match('![^-/0-9\\s]!i', $_POST['cmtnd_ngaycap']) === 1) {
        $checkError = true;
        $dtr['mss'] = 'Ngày cấp phép không chứa chữ cái';
    }

    if (preg_match('![^0-9]!i', $_POST['cmtnd']) === 1) {
        $checkError = true;
        $dtr['mss'] = 'Số CMND/ Hộ chiếu không chứa chữ cái';
    }

    if ($checkError == false) {
        $userCl->update(array("_id" => $_SESSION['uinfo']['_id']), array('$set' => $_POST));
        $_SESSION['uinfo'] = $userCl->findOne(array("_id" => $_SESSION['uinfo']['_id']));
        $_SESSION['uinfo']["enoughInfor"] = 1;
        $dtr['mss'] = 'cap nhat thanh cong';
        $dtr['status'] = 200;
    }

    echo json_encode($dtr);
}
function news(){
    global $dbmg;

$gtcbcl = $dbmg->news;
    $dtr['status'] = 200;
// Nếu là bài chi tiết
$id = $_GET['id'];
if(isset($id)) {
    $o = (array)$gtcbcl->findOne(array("_id" => $id),array("name","avatar","contents"));
        $o["avatar"] = makelink::returnimage($o["avatar"]);
    $dtr['data'] = $o;
}
    echo json_encode($dtr);
}

function _getTrueLink($link){
    return str_replace('../', Constant::BASE_URL.'/', $link);
}

