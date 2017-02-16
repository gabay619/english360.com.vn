<?php
foreach (glob(__DIR__.'/../helpers/*.php') as $filename)
{
    include $filename;
}
include "../config/config.php";
include "../config/connect.php";
$gtcbcl = $dbmg->gtcb;
$gtcbbt = $dbmg->gtcb_baitap;
$gtcbln = $dbmg->gtcb_luyennghe;
$id = $_GET['id'];
$obj = (array)$gtcbcl->findOne(array("_id" => $id));
$tracnghiem = iterator_to_array($gtcbbt->find(array('gtcbid'=> $id, 'type' => 'gtcb_tracnghiem')), false);
$dientu = $gtcbbt->findOne(array('gtcbid' => $id, 'type' => 'gtcb_dientu'));
$sapxep = $gtcbbt->findOne(array('gtcbid' => $id, 'type' => 'gtcb_sapxep'));
$ghepcau = $gtcbbt->findOne(array('gtcbid' => $id, 'type' => 'gtcb_ghepcau'));
$luyennghe = $gtcbln->findOne(array('gtcbid' => $id));
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
<!--            <div class="face"><img src="asset/images/data_like_share.png" alt=""></div>-->
        </div>
    </div>
    <div class="content_cate p5">
        <div class="item_cate">
            <?php if(count($tracnghiem) >0 ) :?>
            <div class="baitap" id="bt-tracnghiem">
                <div class="title_bt">Chọn câu trả lời đúng cho mỗi tình huống:</div>
                <div class="view_bt">
                    <?php foreach ($tracnghiem as $key => $item): ?>
                        <div class="c item-tracnghiem" data-true="<?php echo $item['trueaw']?>" data-id="<?php echo $item['_id']?>">
                            <span><b class="stt"><?php echo($key + 1) ?></b><?php echo $item['name'] ?></span>
                            <div class="radio">
                                <?php foreach ($item['aw'] as $akey => $avalue) { ?>
                                    <div>
                                        <input type="radio" class="kq_<?php echo $item['_id'] ?>" name="kq_<?php echo $item['_id'] ?>">
                                        <span><?php echo Common::numtoalpha($akey) ?>: <?php echo $avalue ?> </span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

<!--                    --><?php //} ?>
                <div class="center">
                    <button class="ht hoanthanh" onclick="completeTracnghiem()" type="button">Hoàn thành</button>
                    <button class="ht baitiep" onclick="toNext()" type="button" style="display: none">Bài tiếp</button>
                </div>
            </div>
            <?php endif; ?>
            <?php if($sapxep) :?>
                <div class="baitap" id="bt-sapxep">
                    <div class="title_bt"><?php echo $sapxep['name']?> </div>
                    <div class="view_bt">
                        <div class="c item-sapxep">
                            <div class="bt_list_view">
                                <?php $count = 0; ?>
                                <?php foreach(Common::shuffle_assoc($sapxep['aw']) as $key=>$anAns):?>
                                <div>
                                    <span data-id="<?php echo $key+1 ?>" data-ans="<?php echo Common::numtoalpha($count)?>"><?php echo Common::numtoalpha($count++)?>: <?php echo $anAns?> </span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="bt_show">
                                <div class="your-ans">
                                    <span class="title-show"> Câu trả lời của bạn! </span>
                                    <div class="kq_show mg10">
                                        <?php for($i=1; $i<=count($sapxep['aw']); $i++):?>
                                            <span><?php echo $i ?>. <input type="text" maxlength="1" data-id="<?php echo $i ?>" style="text-transform: uppercase"></span>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="right-ans" style="display: none">
                                    <span class="title-show"> Câu trả lời đúng! </span>
                                    <div class="kq_show mg10">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <button class="ht hoanthanh" onclick="completeSapxep()" type="button">Hoàn thành</button>
                        <button class="ht baitiep" onclick="toNext()" type="button" style="display: none">Bài tiếp</button>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($dientu) :?>
                <div class="baitap" id="bt-dientu">
                    <div class="title_bt"><?php echo $dientu['name']?> </div>
                    <div class="content_dientu">
                        <?php echo $dientu['contents']?>
                    </div>
                    <div class="center">
                        <button class="ht hoanthanh" onclick="completeDientu()" type="button">Hoàn thành</button>
                        <button class="ht baitiep" onclick="toNext()" type="button" style="display: none">Bài tiếp</button>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($ghepcau) :?>
                <div class="baitap" id="bt-ghepcau">
                    <div class="title_bt"><?php echo $ghepcau['name']?> </div>
                    <div class="view_bt bt_list">
                        <div class="c">
                            <div class="bt_list_view">
                                <?php foreach($ghepcau['aw'] as $key=>$val):?>
                                <div class="posaw">
                                    <span><?php echo $key+1?>. <?php echo $val?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="bt_list_view hr">
                                <?php foreach($ghepcau['ax'] as $key=>$val): ?>
                                <div class="posaw">
                                    <span><?php echo Common::numtoalpha($key)?>. <?php echo $val?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="bt_show ">
                                <span class="title-show"> Câu trả lời của bạn! </span>
                                <div class="kq_show mg10">
                                    <?php for($i=0; $i<count($ghepcau['true']); $i++):?>
                                    <span><?php echo $i+1 ?>. <input style="text-transform: uppercase" type="text" maxlength="1" data-ans="<?php echo $ghepcau['true'][$i]?>"></span>
                                    <?php endfor; ?>
                                </div>
                                <div class="right-ans" style="display: none">
                                    <span class="title-show"> Câu trả lời đúng! </span>
                                    <div class="kq_show mg10 awform">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <button class="ht hoanthanh" onclick="completeGhepcau()" type="button">Hoàn thành</button>
                        <button class="ht baitiep" onclick="toNext()" type="button" style="display: none">Bài tiếp</button>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($luyennghe) :?>
                <div class="baitap" id="bt-luyennghe">
                    <div class="title_bt"><?php echo $luyennghe['name']?> </div>
                    <div class="content_luyennghe">
                        <div class="audio center">
                            <audio src="<?php echo $luyennghe['medialink']?>" controls></audio>
                        </div>
                        <div class="content_dientu">
                            <?php echo $luyennghe['contents']?>
                        </div>
                    </div>
                    <div class="center">
                        <button class="ht hoanthanh" onclick="completeLuyennghe()" type="button">Hoàn thành</button>
                        <button class="ht baitiep" onclick="toBegin()" type="button" style="display: none">Quay lại từ đầu</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        $(function(){
            var a = $('#bt-dientu img.InputQuestion');
            $.each(a, function (i) {
                var kq = $(this).attr('alt');
                $(this).before('<span class="stt">' + (i + 1) + '</span>');
                $(this).after('<input class="dt tocheck" data-aw="' + kq.toLowerCase() + '" data-full="' + kq + '" type="text" placeholder="Từ cần điền"></span>');
                $(this).hide();
            })
            var b = $('#bt-luyennghe img.InputQuestion');
            $.each(b, function (i) {
                var kq = $(this).attr('alt');
                $(this).before('<span class="stt">' + (i + 1) + '</span>');
                $(this).after('<input class="dt tocheck" data-aw="' + kq.toLowerCase() + '" data-full="' + kq + '" type="text" placeholder="Từ cần điền"></span>');
                $(this).hide();
            })

            $('.baitap').hide();
            $('.baitap:first-child').show();
        })

        var baitapIndex = 0;

        function toNext(){
            baitapIndex++;
            $('.baitap').hide();
            $('.baitap').eq(baitapIndex).show();
            if(!$('.baitap').eq(baitapIndex+1).length){
                $('.baitap').eq(baitapIndex).find('.baitiep').attr('onclick','toBegin()').html('Làm lại');
            }
            $('html,body').scrollTop(0);
        }

        function toBegin(){
            location.reload();
        }

        function completeTracnghiem(){
//            if(!validateTracnghiem()){
//                alert('Bạn chưa hoàn thành các lựa chọn.'); return false;
//            }

            $('.item-tracnghiem').each(function(e){
                trueaw = $(this).attr('data-true');
                qid = $(this).attr('data-id');
                $(this).find('.kq_'+qid).each(function(eq){
                    index = parseInt(eq)+1;
                    if(trueaw == index){
                        htmlx = '<span class="kq_t"></span>';
                        $(this).parent().append(htmlx);
                    }else if($(this).is(':checked') && index != trueaw){
                        htmlx = '<span class="kq_f"></span>';
                        $(this).parent().append(htmlx);
                    }
                    $(this).prop('disabled', true);
                });
            });

            $('#bt-tracnghiem .hoanthanh').hide();
            $('#bt-tracnghiem .baitiep').show();
        }

        function validateTracnghiem(){
            result = false;
            $('.item-tracnghiem').each(function(e){
                $(this).find('input').each(function(eq){
                    if($(this).is(':checked'))
                        result = true;
                });
            });
            return result;
        }

        function completeSapxep(){
//            if(!validateSapxep()){
//                alert('Bạn phải điền đầy đủ vào các ô trống.'); return false;
//            }

            for(i=1; i <= <?php echo count($sapxep['aw'])?>; i++){
                ans = $('#bt-sapxep .bt_list_view span[data-id='+i+']').attr('data-ans');
                console.log(i+'-'+ans);
                html = '<span>'+i+'. <input type="text" disabled style="text-transform: uppercase" value="'+ans+'"></span>';
                $('#bt-sapxep .right-ans .kq_show').append(html);
            }
            $('#bt-sapxep .right-ans').show();

            $('#bt-sapxep .your-ans input').each(function(){
               id = $(this).attr('data-id');
                trueans = $('#bt-sapxep .bt_list_view span[data-id='+id+']').attr('data-ans').toLowerCase();
                yourans = $(this).val().toLowerCase();
                if(trueans == yourans){
                    htmlx = '<i class="kq_t"></i>';
                }else{
                    htmlx = '<i class="kq_f"></i>';
                }
                $(this).after(htmlx);
                $(this).prop('disabled', true);
            });

            $('#bt-sapxep .hoanthanh').hide();
            $('#bt-sapxep .baitiep').show();
        }

        function validateSapxep(){
            result = true;
            $('.item-sapxep .your-ans input').each(function(){
                if($(this).val() == '')
                    result = false;
            })

            return result;
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

        function completeGhepcau(){
//            if(!validateGhepcau()){
//                alert('Bạn phải điền đầy đủ vào các ô trống.'); return false;
//            }

            $('#bt-ghepcau .bt_show input').each(function(e){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-ans').toLowerCase();
                index = parseInt(e)+1;
                htmlx = '<span>'+index+'. <input type="text" value="'+trueans+'" disabled style="text-transform: uppercase"></span>';
                $('#bt-ghepcau .right-ans .kq_show').append(htmlx);
                if(ans == trueans){
                    $(this).after('<i class="kq_t"></i>');
                }else{
                    $(this).after('<i class="kq_f"></i>');
                }
                $(this).prop('disabled',true);
            })

            $('#bt-ghepcau .right-ans').show();

            $('#bt-ghepcau .hoanthanh').hide();
            $('#bt-ghepcau .baitiep').show();
        }

        function validateGhepcau(){
            result = true;
            $('#bt-ghepcau .bt_show input').each(function(){
                if($(this).val() == '')
                    result = false;
            })

            return result;

        }

        function completeLuyennghe(){
//            if(!validateLuyennghe()){
//                alert('Bạn phải điền đầy đủ vào các ô trống.'); return false;
//            }

            $('#bt-luyennghe input.tocheck').each(function () {
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
            $('#bt-luyennghe .hoanthanh').hide();
            $('#bt-luyennghe .baitiep').show();
        }

        function validateLuyennghe(){
            result = true;
            $('#bt-luyennghe .content_dientu input').each(function(){
                if($(this).val() == '')
                    result = false;
            })

            return result;
        }
    </script>
    <style>
        .baitap{
            height: 350px;
            overflow: scroll;
        }
    </style>
</div>
</body>
</html>