<?php
foreach (glob(__DIR__.'/../helpers/*.php') as $filename)
{
    include $filename;
}
include "../config/config.php";
include "../config/connect.php";
$lnacl = $dbmg->luyennguam;
$lnabt = $dbmg->luyennguam_baitap;
$id = $_GET['id'];
$obj = (array)$lnacl->findOne(array("_id" => $id));
$dienchu = $lnabt->findOne(array('lnaid'=> $id, 'type' => 'lna_dienchu'));
$dientu = $lnabt->findOne(array('lnaid' => $id, 'type' => 'lna_dientu'));
$tracnghiem = iterator_to_array($lnabt->find(array('lnaid' => $id, 'type' => 'lna_tracnghiem')), false);
$xemtranh = iterator_to_array($lnabt->find(array('lnaid' => $id, 'type' => 'lna_xemtranh')), false);
$phatam = $lnabt->findOne(array('lnaid' => $id, 'type' => 'lna_phatam'));
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
            <?php if($dienchu) :?>
                <div class="baitap" id="bt-dienchu">
                    <div class="title_bt"><?php echo $dienchu['name'] ?></div>
                    <div class="view_bt">
                        <?php foreach($dienchu['question'] as $key=>$aDienchu):?>
                            <div class="posaw" data-ans="<?php echo $aDienchu['aw'] ?>">
                                <label for=""><?php echo $key+1?>.</label>
                                <div style="display: inline-block" class="your-ans">
                                    <?php echo str_replace('_', '<input type="text" maxlength="1" style="text-transform: lowercase"/>', $aDienchu['short']);?>
                                </div>
                                <img class="Loa" src="../resource/images/icon_audio.png" alt="<?php echo $aDienchu['audio']?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="center" style="margin-top: 20px">
                        <button class="ht hoanthanh" onclick="completeDienchu()" type="button">Hoàn thành</button>
                        <button class="ht baitiep" onclick="toNext()" type="button" style="display: none">Bài tiếp</button>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(count($xemtranh) >0 ) :?>
                <div class="baitap" id="bt-xemtranh">
                    <div class="title_bt">Nghe và xem tranh gợi ý để điền từ vào chỗ trống</div>
                    <div class="view_bt">
                        <?php foreach($xemtranh as $key=>$aXemtranh):?>
                        <div class="posaw" style="margin-bottom: 10px">
                            <div style="margin: 0 auto; width: 75%">
                                <img style="width: 100%" src="<?php echo $aXemtranh['avatar']?>" />
                            </div>
                            <div class="your-ans" style="text-align: center">
                                <input type="text" data-ans="<?php echo $aXemtranh['aw']?>">
                                <img class="Loa" src="../resource/images/icon_audio.png" alt="<?php echo $aXemtranh['medialink']?>">
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                    <div class="center" style="margin-top: 20px">
                        <button class="ht hoanthanh" onclick="completeXemtranh()" type="button">Hoàn thành</button>
                        <button class="ht baitiep" onclick="toNext()" type="button" style="display: none">Bài tiếp</button>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(count($tracnghiem) > 0) :?>
                <div class="baitap" id="bt-tracnghiem">
                    <div class="title_bt"><?php echo $tracnghiem[0]['name']?></div>
                    <div class="view_bt">
                        <?php foreach($tracnghiem as $key=>$aTracnghiem): ?>
                        <div class="c item-tracnghiem" data-true="<?php echo $aTracnghiem['trueaw']?>">
                            <div class="radio">
                                <?php foreach ($aTracnghiem['aw'] as $akey => $avalue): ?>
                                    <div>
                                        <input type="radio" class="kq_tracnghiem" name="kq_tracnghiem_<?php echo $aTracnghiem['_id']?>">
                                        <span><?php numtoalpha($akey) ?>: <?php echo $avalue ?> </span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php  endforeach; ?>
                    </div>
                    <div class="center" style="margin-top: 20px">
                        <button class="ht hoanthanh" onclick="completeTracnghiem()" type="button">Hoàn thành</button>
                        <button class="ht baitiep" onclick="toNext()" type="button" style="display: none">Bài tiếp</button>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($phatam) :?>
                <div class="baitap" id="bt-phatam">
                    <div class="title_bt"><?php echo $phatam['name'] ?></div>
                    <div class="view_bt">
                        <?php foreach($phatam['question'] as $key=>$aPhatam):?>
                            <div class="posaw" data-ans="<?php echo $aPhatam['aw'] ?>">
                                <label for=""><?php echo $key+1?>.</label>
                                <span><?php echo $aPhatam['spelling'] ?></span>
                                <div style="display: inline-block" class="your-ans">
                                    <input type="text" style="text-transform: lowercase" data-ans="<?php echo $aPhatam['word']?>"/>
                                </div>
                                <img class="Loa" src="../resource/images/icon_audio.png" alt="<?php echo $aPhatam['audio']?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="center" style="margin-top: 20px">
                        <button class="ht hoanthanh" onclick="completePhatam()" type="button">Hoàn thành</button>
                        <button class="ht baitiep" onclick="toNext()" type="button" style="display: none">Bài tiếp</button>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($dientu) :?>
                <div class="baitap" id="bt-dientu">
                    <div class="title_bt"><?php echo $dientu['name'] ?></div>
                    <div class="content_luyennghe">
                        <div class="audio center">
                            <audio src="<?php echo $dientu['medialink']?>" controls></audio>
                        </div>
                        <div class="list_tu_goi_y block">

                        </div>
                        <div class="content_dientu">
                            <?php echo $dientu['contents']?>
                        </div>
                    </div>
                    <div class="center" style="margin-top: 20px">
                        <button class="ht hoanthanh" onclick="completeDientu()" type="button">Hoàn thành</button>
                        <button class="ht baitiep" onclick="toBegin()" type="button" style="display: none">Làm lại</button>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <audio style="width: 0;height: 0;" id="mainaudio" controls></audio>

    <script>
        var baitapIndex = 0;
        $(function(){
            var a = $('#bt-dientu img.InputQuestion');
            var dientuArr = [];
            $.each(a, function (i) {
                var kq = $(this).attr('alt');
                dientuArr[dientuArr.length] = kq;
                $(this).before('<span class="stt">' + (i + 1) + '</span>');
                $(this).after('<input class="dt tocheck" data-aw="' + kq.toLowerCase() + '" data-full="' + kq + '" type="text" placeholder="Từ cần điền"></span>');
                $(this).hide();
            })
            shuffle(dientuArr);
            for(i=0; i< dientuArr.length; i++){
                $('.list_tu_goi_y').append('<span>'+dientuArr[i]+'</span>');
            }

            $('.Loa').click(function(e){
                var src = $(this).attr('alt');
                $('#mainaudio').attr('src',src);
                $('#mainaudio')[0].play();
            })

            $('#bt-dienchu input').keyup(function () {
                if($(this).val() != '')
                    $(this).next('#bt-dienchu input').focus();
            })

            $('.baitap').hide();
            $('.baitap').eq(baitapIndex).show();
        })

        function toNext(){
            baitapIndex++;
            $('.baitap').hide();
            $('.baitap').eq(baitapIndex).show();
            if(!$('.baitap').eq(parseInt(baitapIndex)+1).length){
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

            $('.item-tracnghiem').each(function(){
                trueaw = $(this).attr('data-true');
                $(this).find('.kq_tracnghiem').each(function(eq){
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
            })

            $('#bt-tracnghiem .hoanthanh').hide();
            $('#bt-tracnghiem .baitiep').show();
        }

        function validateTracnghiem(){
            result = true;
            $('.item-tracnghiem').each(function(eq){
                result = false;
                $(this).find('input').each(function(){
                    if($(this).is(':checked'))
                        result = true;
                })

            });
            return result;
        }

        function completeDienchu(){
//            if(!validateDienchu()){
//                alert('Bạn phải điền đầy đủ vào các ô trống.'); return false;
//            }

            $('#bt-dienchu .posaw').each(function(){
                trueans = $(this).attr('data-ans');
                yourans = '';
                $(this).find('.your-ans input').each(function(){
                    $(this).after('<b>'+$(this).val().toLowerCase()+'</b>');
                    $(this).remove();
                })
                yourans = strip($(this).find('div.your-ans').html()).trim();
                console.log(yourans);
                if(yourans.toLowerCase() == trueans.toLowerCase()){
                    htmlx = '<span class="kq_t"></span>';
                }else{
                    htmlx = '<span class="kq_f"></span><span class="t">'+trueans+'</span>';
                }
                $(this).append(htmlx);
            })

            $('#bt-dienchu .hoanthanh').hide();
            $('#bt-dienchu .baitiep').show();
        }

        function strip(html)
        {
            var tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        }

        function validateDienchu(){
            result = true;
            $('#bt-dienchu input').each(function(){
                if($(this).val() == '')
                    result = false;
            })

            return result;
        }

        function completeXemtranh(){
//            if(!validateXemtranh()){
//                alert('Bạn phải điền đầy đủ vào các chỗ trống.'); return false;
//            }

            $('#bt-xemtranh .posaw input').each(function(){
                trueans = $(this).attr('data-ans').toLowerCase();
                yourans = $(this).val().toLowerCase();
                if(trueans == yourans){
                    htmlx = '<span class="t">'+trueans+'</span><span class="kq_t"></span>';
                }else{
                    htmlx = '<span class="f">'+yourans+'</span><span class="kq_f"></span><span class="t">'+trueans+'</span>';
                }
                $(this).parent().prepend(htmlx);
                $(this).remove();
            })

            $('#bt-xemtranh .hoanthanh').hide();
            $('#bt-xemtranh .baitiep').show();
        }

        function validateXemtranh(){
            result = true;
            $('#bt-xemtranh input').each(function(){
                if($(this).val() == '')
                    result = false;
            })

            return result;
        }

        function completePhatam(){
//            if(!validatePhatam()){
//                alert('Bạn phải điền đầy đủ vào các chỗ trống.'); return false;
//            }

            $('#bt-phatam .posaw input').each(function(){
                trueans = $(this).attr('data-ans').toLowerCase();
                yourans = $(this).val().toLowerCase();
                if(trueans == yourans){
                    htmlx = '<span class="t">'+trueans+'</span><span class="kq_t"></span>';
                }else{
                    htmlx = '<span class="f">'+yourans+'</span><span class="kq_f"></span><span class="t">'+trueans+'</span>';
                }
                $(this).parent().prepend(htmlx);
                $(this).remove();
            })

            $('#bt-phatam .hoanthanh').hide();
            $('#bt-phatam .baitiep').show();

        }

        function validatePhatam(){
            result = true;
            $('#bt-phatam input').each(function(){
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

        function shuffle(array) {
            var currentIndex = array.length, temporaryValue, randomIndex;

            // While there remain elements to shuffle...
            while (0 !== currentIndex) {

                // Pick a remaining element...
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex -= 1;

                // And swap it with the current element.
                temporaryValue = array[currentIndex];
                array[currentIndex] = array[randomIndex];
                array[randomIndex] = temporaryValue;
            }

            return array;
        }
    </script>
    <style>
        .baitap{
            height: 350px;
            overflow: scroll;
        }
        #bt-dienchu input{
            padding: 3px;
            width: 20px;
            margin: 0;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        #bt-dienchu .posaw, #bt-phatam .posaw{
            margin: 10px 0 10px 0;
        }
        #bt-phatam input{
            padding: 3px;
            margin: 0;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        #bt-xemtranh input{
            padding: 3px;
            margin: 10px 0 10px 0;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        #bt-tracnghiem .item-tracnghiem{
            border-bottom: 1px solid #ccc;
        }
        .list_tu_goi_y{
            margin-bottom: 10px;
        }
        .list_tu_goi_y span {
            display: inline-block;
            border: 1px solid #999;
            margin: 2px;
            padding: 5px 16px;
        }
    </style>
</div>
</body>
</html>