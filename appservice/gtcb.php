<?php
include "../config/config.php";
include "../config/connect.php";
$id = $_GET['id'];
$gtcbcl = $dbmg->gtcb;
$gtcbln = $dbmg->gtcb_luyennghe;
$obj = (array)$gtcbcl->findOne(array("_id"=>$id));
// Nếu là câu hỏi đầu tiên. (Không có Get next ID)

if(!isset($_GET['nextid'])) $question = iterator_to_array($gtcbln->find(array("gtcbid"=>$id))->sort(array("sort"=>1))->limit(1),false);
else $question = iterator_to_array($gtcbln->find(array("_id"=>$_GET['nextid']))->sort(array("sort"=>1))->limit(1),false);
if(count($question)>0) $question = $question[0];
else $question = array();
$nowshort = $question['sort']; // Lấy vị trí của câu hỏi hiện tại
$nextquestion = iterator_to_array($gtcbln->find(array("gtcbid"=>$id,"sort"=>array('$gt'=>$nowshort)))->sort(array("sort"=>1))->limit(1),false);
if(count($nextquestion)>0) $nextquestion = $nextquestion[0];
else $nextquestion = array();
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
    <div class="p5">
        <div class="breadcrumb">
            <div class="title_br"><?php echo $obj['name'] ?></div>
            <div class="face"><img src="asset/images/data_like_share.png" alt=""></div>
        </div>
    </div>
    <div class="content_cate p5">
        <div class="item_cate">
            <div class="title_luyennghe">
                <i class="icon_audio_orange"></i>
                <span><?php echo $obj['name'] ?></span>
            </div>
            <div class="content_luyennghe">
                <div class="audio center">
                    <audio src="<?php echo $obj['medialink'] ?>" controls></audio>
                </div>
                <div class="kq_show" style="display: none"><span class="kq1">Kết quả</span> <span class="kq2">Số ô phải điền: <strong class="orange totalinput">...</strong></span> <span class="kq3">Đúng: <strong class="orange usertrue">1/3</strong></span></div>
                <div class="content_dientu">
                    <?php echo $question['contents'] ?>
                </div>
                <div class="show_kq_input" style="display: none">
                    <p>Đáp án đúng:</p>
                </div>
            </div>
            <div class="center hoanthanh">
                <button class="ht" onclick="checkquestion(this)">Hoàn thành</button>
            </div>
            <div class="center luachon" style="display: none">
                <a class="ht" href="">Làm lại</a>
                {if condition="$nextquestion._id>0"}
                <a class="ht" href="?id=<?php echo $obj['_id'] ?>&nextid=<?php echo $nextquestion['gtcbid'] ?>">Bài tiếp</a>
                {else}
                <a class="ht" href="?id={$obj._id}">Quay lại từ đầu</a>
                {/if}
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
        $(obj).parent().hide();// Ẩn nút hoàn thành
        $(obj).parent().next().show();// Show nút tiếp
        // Tính điểm
        $('.totalinput').html(a.length);
        $('.usertrue').html(scorenow+"/"+ a.length);
        $('.kq_show').show();
    }
</script>
</body>
</html>