<?php
$save = $saveCl->findOne(array(
    'uid'=>$_SESSION['uinfo']['_id'],
    'degree' => Constant::LEVEL_EASY,
    'category' => $id
));
if(!$save){
    $newSave = array(
        'uid'=>$_SESSION['uinfo']['_id'],
        'degree' => Constant::LEVEL_EASY,
        'category' => $id,
        'level' => 1
    );
    $saveCl->insert($newSave);
    $level = 1;
}else{
    $level = $save['level'];
}
$game = $gameCl->findOne(array(
    'category' => $id,
    'degree' => Constant::LEVEL_EASY,
    'level' => strval($level),
));
if(isset($_POST['select'])){
    $saveCl->update(array(
        'uid'=>$_SESSION['uinfo']['_id'],
        'degree' => Constant::LEVEL_EASY,
        'category' => $id
    ), array('$set'=>array('level'=>$level+1)));

    $gamePoint = $pointCl->findOne(array('uid'=> $_SESSION['uinfo']['_id']));
    if(!$gamePoint){
        $newPoint = array(
            'uid' => $_SESSION['uinfo']['_id'],
            'point' => 0
        );
        $pointCl->insert($newPoint);
        $point = 0;
    }else{
        $point = isset($gamePoint['point']) ? $gamePoint['point'] : 0;
    }
    $trueAns = 0;
    foreach($game['question'] as $key=>$aQuestion){
        if($_POST['select'][$key] == $aQuestion['aw']){
            $point++;
            $trueAns++;
        }
    }
    $pointCl->update(array('uid' => $_SESSION['uinfo']['_id']), array('$set'=> array('point'=>$point)));
}
?>
<!doctype html>
<html>
<head>
    <meta name="MobileOptimized" content="100" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="MobileOptimized" content="320">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="<apple-to></apple-to>uch-fullscreen" content="yes">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="/template/wap/asset/css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/template/wap/asset/css/idangerous.swiper.css">
    <link rel="stylesheet" href="/template/wap/asset/css/font-awesome.css">
    <link rel="stylesheet" href="/template/wap/asset/css/27012016.css">
    <link rel="stylesheet" href="/template/wap/asset/css/help.css">
    <script src="/template/wap/asset/js/jquery-1.10.1.min.js"></script>
</head>

<body>
<div class="wrapper">
    <div class="carea">
        <div class="main">
            <div class="content_cate h5">
                <div class="item_cate center mgb0 block">
                <?php echo $cate['name'] ?>
                </div>
            </div>
            <?php if(!$game): ?>
            <div class="content_cate h5">
                <div class="item_cate mgb0 item_game item_game_view block">
                    <div class="game_page block">
                        <div class="header_game_page font_game center block">
                        </div>
                        <div class="footer_game_page block">
                            <div class="game_page_notifi p20 center font_game">
                                <p>Chúc mừng bạn đã hoàn thành tất cả các LEVEL trong chủ đề này!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php elseif(isset($_POST['select'])):?>
                <div class="content_cate h5">
                    <div class="item_cate mgb0 item_game item_game_view block">
                        <div class="game_page block">
                            <div class="header_game_page font_game center block">
                            </div>
                            <div class="footer_game_page block">
                                <div class="game_page_notifi p20 center font_game">
                                    <p>Xin chúc mừng !</p>
                                    <p>Bạn đã trả lời đúng <?php echo $trueAns ?>/10 câu hỏi của level <?php echo $level ?> </p>
                                </div>
                            </div>
                        </div>
                        <?php foreach($game['question'] as $key=>$aQuestion): ?>
                        <div class="game_page block">
                            <div class="header_game_page font_game center block">
                                <div class="level_game_item">
                                    <span>Câu <?php echo $key+1  ?></span>
                                </div>
                            </div>
                            <div class="footer_game_page block">
                                <table class="table_question_game" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <div class="game_question center">
                                                <div class="game_question_img">
                                                    <img src="<?php echo $aQuestion['avatar'] ?>" />
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table_answer_game" cellpadding="0" cellspacing="0">
                                    <?php foreach($aQuestion['select'] as $aSelect): ?>
                                    <tr>
                                        <td>
                                            <a href="javascript:void(0)" class="item_answer_game btn_game <?php if($aQuestion['aw'] == $aSelect) echo 'btn_game_4'; elseif($_POST['select'][$key] == $aSelect) echo 'btn_game_3 select'; else echo 'btn_game_3' ?>"><?php echo $aSelect ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <div class="btn_game_area center block mgb15 btn_game_area_f">
                            <a class="btn_game btn_game_2 font_game" href="">Tiếp tục nào</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>

            <div class="content_cate h5">
                <div class="item_cate mgb0 item_game block">
                    <div class="game_page block">
                        <div class="header_game_page font_game center block">
                            <div class="level_game_item">
                                <span>Level <?php echo $level ?></span>
                            </div>
                            <div class="here_game_item">
                                <span class="btn_game btn_game_1 text_shadow_game">1/10</span>
                            </div>
<!--                            <div class="list_cate_game_item">-->
<!--                                <span>10</span>-->
<!--                            </div>-->
                        </div>
                        <?php foreach($game['question'] as $key=>$aQuestion):?>
                        <div class="footer_game_page block">
                            <table class="table_question_game" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <button class="btn_game btn_game_2 btn_game_circle" onclick="showItem(<?php echo $key-1 ?>)"><i class="fa fa-fw"></i></button>
                                    </td>
                                    <td>
                                        <div class="game_question center">
                                            <div class="game_question_img">
                                                <img src="<?php echo $aQuestion['avatar']?>" />
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn_game btn_game_2 btn_game_circle" onclick="showItem(<?php echo $key+1 ?>)"><i class="fa fa-fw"></i></button>
                                    </td>
                                </tr>
                            </table>
                            <table class="table_answer_game" cellpadding="0" cellspacing="0">
                                <?php if(isset($aQuestion['select'])):
                                    foreach($aQuestion['select'] as $aSelect):
                                    ?>
                                        <tr>
                                            <td>
                                                <a href="javascript:void(0)" class="item_answer_game btn_game btn_ans btn_game_3"><?php echo $aSelect ?></a>
                                            </td>
                                        </tr>
                                <?php endforeach;
                                endif;?>
                            </table>
                        </div>
                        <?php endforeach; ?>
                        <div style="text-align: center; margin-bottom: 20px"><a href="javascript:complete()" class="btn_game btn_game_2 font_game">Hoàn thành</a></div>
                    </div>
                </div>
            </div>
                <script>
                    var item_show = 0;
                    $(function(){
                        showItem(item_show);
                        $('.btn_ans').click(function(){
                            $(this).parent().parent().parent().find('.btn_ans').removeClass('select');
                            $(this).addClass('select');
                        });
                    });

                    function showItem(eq){
                        if(eq<0 || eq>9){
                            alert('Mỗi level chỉ có 10 câu hỏi.');return false;
                        }
                        $('.footer_game_page').hide();
                        $('.footer_game_page').eq(eq).show();
                        number = parseInt(eq)+1;
                        $('.text_shadow_game').html(number+'/10');
                    }

                    function complete(){
                        var select = [];
                        $('.table_answer_game').each(function(e){
                            choose = $(this).find('.select');
                            if(choose.length != 0)
                                select[e] = choose.html().toLowerCase();
                        });

                        if(select.filter(function(value) { return value !== undefined }).length < 10){
                            alert('Bạn phải hoàn thành tất cả 10 câu hỏi.');
                            return false;
                        }
                        for (index = 0; index < select.length; ++index) {
                            html = '<input type="hidden" name="select['+index+']" value="'+select[index]+'"/>';
                            $('#form-result').append(html);
                        }
                        console.log(select.length);
                        $('#form-result').submit();
                    }
                </script>
            <?php endif;?>
        </div>
    </div>
</div>
<form action="" method="post" id="form-result">
</form>
<!-- JS -->
<script src="/template/wap/asset/js/idangerous.swiper-2.1.min.js"></script>
<script src="/template/wap/asset/js/funcs.js"></script>
<script src="/template/wap/asset/js/giaitri.ui.js"></script>

</body>
</html>