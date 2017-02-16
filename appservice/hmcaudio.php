<?php
include "../config/config.php";
include "../config/connect.php";
$hmcaudiocl = $dbmg->hmcaudio;
$id = $_GET['id'];
if(!isset($id)) { // Lấy danh sách bài hát
    $limit = 20;
    $p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
    $cond['status'] = "1";
    $list = iterator_to_array($hmcaudiocl->find($cond,array("_id","name","avatar","contents"))->sort(array("_id"=>-1))->skip($cp)->limit($limit),false);
    ##Paging
    $rowcount = $hmcaudiocl->count($cond);
    $totalpage = ceil($rowcount/$limit);if($totalpage<=1) $totalpage = 1;
    $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
    $tpl->assign("paging",$paginginfo);
}
else{ // Lấy chi tiết bài hát
    $obj = (array)$hmcaudiocl->findOne(array("_id"=>$id),array("medialink","contents","exam"), array("contents"));
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
    <link rel="stylesheet" href="{$sourcedir}css/idangerous.swiper.css">
    <script src="/template/wap/asset/js/jquery-1.10.1.min.js"></script>
</head>
<body>
<div class="main">
    <div class="content_cate p5">
        <div class="item_cate fleft w100">
            <div class="content_item ib">
                <!--<div class="video mgt0">
                    <audio src="{$obj.medialink}" controls></audio>
                </div>-->
<!--                <div class="audio center">-->
<!--                    <audio controls src="--><?php //echo $obj['medialink'] ?><!--" controls></audio>-->
<!--                </div>-->
                <div class="content_dientu">
                    <?php echo $obj['exam'];?>
                </div>
                <div class="center btn_view">
                    <button class="blue" onclick="checkquestion(this)">Hoàn thành</button>
                    <button class="blue" id="show">Hiện lời BH</button>
                    <div class="show_goiy" style="display:none;">
                        <?php echo $obj['contents']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var a = $('.content_dientu img.InputQuestion');
        $.each(a, function (i) {
            var kq = $(this).attr('alt');
            $(this).before('<span class="stt">' + (i + 1) + '</span>');
            $(this).after('<input class="dt tocheck" data-aw="' + kq.toLowerCase() + '" data-full="' + kq + '" type="text" placeholder="Từ cần điền"></span>');
            $(this).hide();
        })
    });
    function checkquestion(obj) {
        var scorenow = 0;
        var a = $('.content_cate .tocheck'); // Lấy danh sách những input ng dùng nhập
        $('.content_cate .stt').hide();// Ẩn index câu hỏi
        $.each(a, function (i) {
            var useraw = $(this).val(); // Lấy câu trả lời của  ng dùng
            var systemaw = $(this).attr("data-aw"); // Câu trả lời hệ thống (lower case)
            var systemawfull = $(this).attr("data-full"); // Câu trả lời hệ thống Fullcase
            // So sánh kết quả
            if (useraw.toLowerCase() == systemaw) { // Nếu câu trả lời = câu trả lời hệ thống
                $(this).after('<span class="t">' + systemawfull + '</span>');
                $(this).hide();
                ++scorenow;// Cộng điểm
            } else { // Nếu user trả lời sai, hiển thị từ mà user nhập
                $(this).after('<span class="f">' + useraw + '</span>');
                $(this).hide();
            }
            // Show kết quả đúng
            $('.content_cate .show_kq_input').append('<span><b class="stt">' + (i + 1) + '</b>' + systemawfull + '</span>');
        });
        $('.content_cate .show_kq_input').show(); // Show form kết quả cho user đối sánh
        // Tính điểm
        $('.totalinput').html(a.length);
        $('.usertrue').html(scorenow+"/"+ a.length);
        $('.kq_show').show();
    }

    $( "#show" ).click(function() {
        $('.show_goiy').toggle();
    });

</script>
</body>
</html>