<?php
include "../config/config.php";
include "../config/connect.php";
$lnaCl = $dbmg->luyennguam;
$id = $_GET['id'];
if(isset($id)) {
    $o = (array)$lnaCl->findOne(array("_id" => $id));
}
else {
    $limit = 20;
    $p = $_GET['p'];if($p<=1) $p= 1;$cp = ($p-1)*$limit;
    $cond = array("status"=>"1");
    $list = iterator_to_array($lnaCl->find($cond)->sort(array("_id"=>-1))->skip($cp)->limit($limit),false);
    $tpl->assign("listlna", $list);
    ##Paging
    $rowcount = $lnaCl->count($cond);
    $totalpage = ceil($rowcount/$limit);if($totalpage<=1) $totalpage = 1;
    $paginginfo = array("totalpage"=>$totalpage,"rowcount"=>$rowcount,"pagenow"=>$p,"link"=>cpagerparm("p"),"maxpage"=>3,"listpage"=>range(1,$totalpage));
    $tpl->assign("paging",$paginginfo);
    $tpl->assign("pagefile", "luyennguam/index");
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
<audio style="width: 0;height: 0;" id="mainaudio" controls></audio>
<div class="main">
    <div class="p5">
        <div class="breadcrumb">
            <div class="title_br"><?php echo $o['name'] ?></div>
            <div class="face"><img src="<?php echo $o['avatar'] ?>" alt=""></div>
        </div>
    </div>
    <div class="content_cate p5">
        <div class="item_cate">
            <div class="title_item_small"><i class="icon_small"></i><span class="orange">C</span>ách phát âm</div>
            <div class="content_item">
                <div class="noidung">
                    <?php echo $o['contents'] ?>
                </div>
            </div>
            <div class="face">
                <!--{$facebooklink=makelink::makelna($obj._id,$obj.name)}-->
                <div class="fb-like" data-href="{$facebooklink}" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div></div>
            <div class="comment">
                <div class="title_item_small"><i class="icon_small"></i><span class="orange">B</span>ình luận</div>
                <div>
                    <textarea placeholder="Bạn phải đăng nhập để sử dụng chức năng này" id="comment-input" name="content"></textarea>
                    <button type="button" onclick="saveComment('<?php echo $o['_id'] ?>')">Bình luận</button>
                </div>
                <div class="list_comment">
                    <ul class="listcomment">
                    </ul>
                </div>
                <div class="page pagination-centered">
                    <ul>
                        <li><a href="javascript:void(0)" onclick="getComment()">Xem thêm</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script>
    $('.Loa').click(function(e){
        var src = $(this).attr('alt');
        $('#mainaudio').attr('src',src);
        $('#mainaudio')[0].play();
    })
    var pagenow = 1;
    getComment();
    function savearticle(exid, obj) {
        $.post('incoming.php', {act: 'saveexam', id: exid}, function (re) {
            if (re.status == 200) $(obj).parent().remove();
            alert(re.mss);
        });
    }
    function getComment() {
        $.post('incoming.php', {act: 'getcomment', id: '{$obj._id}', type: 'lna', p: pagenow}, function (re) {
            if (re.data.length > 0) {
                var data = re.data;
                data.forEach(function (e) {
                    var htmlx = '<li><span class="user">' + e.userinfo.displayname + '</span><span class="date">' + e.datecreate + '</span><span class="view_content">' + e.content + '</span></li>';
                    $('.listcomment').append(htmlx);
                });
                ++pagenow;
            } else $('.page').hide();
        });
    }
    function saveComment(objid) {
        var commentContent = $("#comment-input").val();
        if (commentContent.length > 2) {
            $.post('incoming.php', {act: 'savecomment', id: objid, type: 'lna', content: commentContent}, function (re) {
                if (re.status == 200) {
                    var htmlx = '<li><span class="user">' + re.data.userinfo.displayname + '</span><span class="date">' + re.data.datecreate + '</span><span class="view_content">' + re.data.content + '</span></li>';
                    $('.listcomment').prepend(htmlx);
                    $("#comment-input").val('');
                } else alert("Bạn cần đăng nhập để thực hiện tính năng này");
            });
        } else alert("Nội dung bình luận phải dài ít nhất 2 ký tự");
    }
</script>
</body>
</html>