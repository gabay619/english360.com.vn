<?php
foreach (glob(__DIR__.'/../helpers/*.php') as $filename)
{
    include $filename;
}
include "../config/config.php";
include "../config/connect.php";
$songcl = $dbmg->hmcaudio;
$id = $_GET['id'];
$obj = (array)$songcl->findOne(array("_id" => $id));
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
    <script type="text/javascript" src="/assets/lib/jwplayer/jwplayer.js"></script>
    <script type="text/javascript">jwplayer.key="BdmcBP4sG4W6RjYSbz5mgrt3LnBDB3ZWvFTDlP9FBj9KK6JOtwDLpKnJXgo=";</script>
    <link href="/template/wap/asset/css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{$sourcedir}css/idangerous.swiper.css">
    <script src="/template/wap/asset/js/jquery-1.10.1.min.js"></script>
</head>

<body>
<div class="main">
    <div class="p5">
        <div class="breadcrumb">
            <div class="title_br">Luyện tập bài hát: <?php echo $obj['name'] ?></div>
            <div>
                <span class="date"><?php echo date('d/m/Y H:i', $obj['datecreate']) ?></span>
            </div>
            <!--            <div class="face"><img src="asset/images/data_like_share.png" alt=""></div>-->
        </div>
    </div>
    <div id="myElement">Loading the player...</div>
    <div class="content_cate p5">
        <div class="item_cate">
            <?php if($obj['exam']) :?>
                <div class="baitap" id="bt-dientu">
                    <div class="title_bt">Điền từ còn thiếu vào chỗ trống</div>
                    <div class="content_dientu">
                        <?php echo $obj['exam']?>
                    </div>
                    <div class="center">
                        <button class="ht hoanthanh" onclick="completeDientu()" type="button">Hoàn thành</button>
                        <button class="ht baitiep" onclick="toBegin()" type="button" style="display: none">Làm lại</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        jwplayer("myElement").setup({
            file: "<?php echo $obj['medialink'] ?>",
            image: "<?php echo $obj['avatar'] ?>",
            width: "100%",
            aspectratio: "16:9",
            //        skin: 'bekle',
            captions: {
                color: '#fff',
                //                fontSize: 20,
                backgroundOpacity: 50
            }
        });

        $(function(){
            var a = $('#bt-dientu img.InputQuestion');
            $.each(a, function (i) {
                var kq = $(this).attr('alt');
                $(this).before('<span class="stt">' + (i + 1) + '</span>');
                $(this).after('<input class="dt tocheck" data-aw="' + kq.toLowerCase() + '" data-full="' + kq + '" type="text" placeholder="Từ cần điền"></span>');
                $(this).hide();
            })
        })

        var baitapIndex = 0;

        function toBegin(){
            location.reload();
        }

        function completeDientu(){
//            if(!validateDientu()){
//                alert('Bạn phải điền đầy đủ vào các chỗ trống.'); return false;
//            }

            $('#bt-dientu input.tocheck').each(function () {
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                if(ans == trueans){
                    htmlx = '<span class="t">' + trueans + '</span><span class="kq_t"></span>';
                }else{
                    htmlx = '<span class="f">' + ans + '</span><span class="kq_f"></span><span class="t">' + trueans + '</span>';
                }
                $(this).after(htmlx);
                $(this).remove()
            })
            $('#bt-dientu .hoanthanh').hide();
            $('#bt-dientu .baitiep').show();
        }

        function validateDientu(){
            result = true;
            $('#bt-dientu .content_dientu input').each(function(){
                if($(this).val() == '')
                    result = false;
            })

            return result;
        }
    </script>
</div>
</body>
</html>
