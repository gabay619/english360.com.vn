<?php if(!class_exists('raintpl')){exit;}?><div class="comment_block">
    <div class="lists_comment_item">
        <?php $counter1=-1; if( isset($comment) && is_array($comment) && sizeof($comment) ) foreach( $comment as $key1 => $value1 ){ $counter1++; ?>
        <?php if( $value1["userinfo"] ){ ?>
        <div class="comment_item comment_father" id="cm-<?php echo $value1["_id"];?>">
            <div class="top_comment_item">
                <?php if( $value1["userinfo"]["priavatar"] ){ ?>
                <div class="avatar_comment"><img src="<?php echo $value1["userinfo"]["priavatar"];?>" alt=""></div>
                <?php }else{ ?>
                <div class="avatar_comment"><img src="/template/wap/asset/images/avt.png" alt=""></div>
                <?php } ?>
                <div class="user_post_comment"><?php echo getDisplayName($value1["userinfo"]); ?></div>
                <div class="date_post_comment"><?php echo $value1["datecreate"];?></div>
            </div>
            <div class="middle_comment_item">
                <div class="text_comment_item">
                    <p><?php echo $value1["content"];?></p>
                </div>
            </div>
            <div class="bottom_comment_item">
                <div class="three_select_comment_item">
                    <div class="selects_comment_item">
                        <?php if( $value1["islike"] ){ ?>
                        <a href="javacript:void(0)" class="btn-unlike" data-id="<?php echo $value1["_id"];?>"><i class="icon- icon-like-cm"></i>Bỏ thích <span>(<?php echo $value1["countlike"];?>)</span></a>
                        <?php }else{ ?>
                        <a href="javacript:void(0)" class="btn-like" data-id="<?php echo $value1["_id"];?>"><i class="icon- icon-like-cm"></i>Thích <span>(<?php echo $value1["countlike"];?>)</span></a>
                        <?php } ?>
                    </div>
                    <div class="selects_comment_item">
                        <a href="javacript:void(0)" class="btn-report" data-id="<?php echo $value1["_id"];?>"><i class="icon- icon-report-cm"></i>Vi phạm</a>
                    </div>
                    <div class="selects_comment_item">
                        <a href="javascript:void(0)" class="btn-reply" data-id="<?php echo $value1["_id"];?>"><i class="icon- icon-reply-cm"></i>Trả lời</a>
                    </div>
                </div>
            </div>
        </div>
        <?php $counter2=-1; if( isset($value1["childs"]) && is_array($value1["childs"]) && sizeof($value1["childs"]) ) foreach( $value1["childs"] as $key2 => $value2 ){ $counter2++; ?>
        <?php if( $value2["userinfo"] ){ ?>
        <div class="comment_item comment_son son-of-<?php echo $value2["parentid"];?>">
            <div class="top_comment_item">
                <?php if( $value2["userinfo"]["priavatar"] ){ ?>
                <div class="avatar_comment"><img src="<?php echo $value2["userinfo"]["priavatar"];?>" alt=""></div>
                <?php }else{ ?>
                <div class="avatar_comment"><img src="/template/wap/asset/images/avt.png" alt=""></div>
                <?php } ?>
                <div class="user_post_comment"><?php echo getDisplayName($value2["userinfo"]); ?></div>
                <div class="date_post_comment"><?php echo $value2["datecreate"];?></div>
            </div>
            <div class="middle_comment_item">
                <div class="text_comment_item">
                    <p><?php echo $value2["content"];?></p>
                </div>
            </div>
            <div class="bottom_comment_item">
                <div class="three_select_comment_item">
                    <div class="selects_comment_item">
                        <?php if( $value2["islike"] ){ ?>
                        <a href="javascript:void(0)" class="btn-unlike" data-id="<?php echo $value2["_id"];?>"><i class="icon- icon-like-cm"></i>Bỏ thích <span>(<?php echo $value2["countlike"];?>)</span></a>
                        <?php }else{ ?>
                        <a href="javascript:void(0)" class="btn-like" data-id="<?php echo $value2["_id"];?>"><i class="icon- icon-like-cm"></i>Thích <span>(<?php echo $value2["countlike"];?>)</span></a>
                        <?php } ?>
                    </div>
                    <div class="selects_comment_item">
                        <a href="javacript:void(0)" class="btn-report" data-id="<?php echo $value2["_id"];?>"><i class="icon- icon-report-cm"></i>Vi phạm</a>
                    </div>

                </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <?php } ?>
    </div>
    <div class="comment_type_box">
        <textarea class="type_1" id="comment-input" type="text" placeholder="Thêm bình luận"></textarea>
        <div class="btn_gui_comment center"><a href="javascript:void(0)" onclick="saveComment('')"  class="btn_1">Gửi</a></div>
    </div>
</div>

<script>
    function saveComment(parentid) {
        var objid = '<?php echo $objid;?>';
        var commentContent = parentid == '' ? $("#comment-input").val() : $("#comment-input-"+parentid).val();
        if (commentContent.length > 2) {
            $.post('/incoming.php', {
                act: 'savecomment', id: objid, type: '<?php echo $type;?>', content: commentContent, parentid: parentid, return_url: window.location.href
            }, function (re) {
                if (re.status == 200) {
                    //                    var htmlx = '<li><span class="user_post_comment">' + re.data.userinfo.displayname + '</span><span class="date_post_comment">' + re.data.datecreate + '</span><span class="text_comment_item">' + re.data.content + '</span></li>';
                    var htmlx = parentid == '' ? '<div class="comment_item comment_father" id="cm-'+re.data._id+'">'+
                            '<div class="top_comment_item">'+
                            '<div class="avatar_comment">'+'<img src="'+re.data.userinfo.priavatar+'" alt="">'+
                            '</div>'+
                            '<div class="user_post_comment">'+re.data.userinfo.displayname+'</div>'+
                            '<div class="date_post_comment">'+re.data.datecreate+'</div>'+
                            '<ul class="listcomment"></ul>'+
                            '</div>'+
                            '<div class="middle_comment_item">'+
                            '<div class="text_comment_item">'+
                            '<p>'+re.data.content+'</p>'+
                            '</div>'+
                            '</div>'+
                            '<div class="bottom_comment_item">'+
                            '<div class="three_select_comment_item">'+
                            '<div class="selects_comment_item">'+
                            '<a href="javascript:void(0)" class="btn-like" data-id="'+re.data._id+'"><i class="icon- icon-like-cm"></i>Thích <span>(0)</span></a>'+
                            '</div>'+
                            '<div class="selects_comment_item">'+
                            '<a href="javacript:void(0)" class="btn-report" data-id="'+re.data._id+'"><i class="icon- icon-report-cm"></i>Vi phạm</a>'+
                            '</div>'+
                            '<div class="selects_comment_item">'+
                            '<a href="javascript:void(0)" class="btn-reply" data-id="'+re.data._id+'"><i class="icon- icon-reply-cm"></i>Trả lời</a>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '</div>'
                                    :
                            '<div class="comment_item comment_son">'+
                            '<div class="top_comment_item">'+
                            '<div class="avatar_comment">'+'<img src="'+re.data.userinfo.priavatar+'" alt="">'+
                            '</div>'+
                            '<div class="user_post_comment">'+re.data.userinfo.displayname+'</div>'+
                            '<div class="date_post_comment">'+re.data.datecreate+'</div>'+
                            '<ul class="listcomment"></ul>'+
                            '</div>'+
                            '<div class="middle_comment_item">'+
                            '<div class="text_comment_item">'+
                            '<p>'+re.data.content+'</p>'+
                            '</div>'+
                            '</div>'+
                            '<div class="bottom_comment_item">'+
                            '<div class="three_select_comment_item">'+
                            '<div class="selects_comment_item">'+
                            '<a href="javascript:void(0)" class="btn-like" data-id="'+re.data._id+'"><i class="icon- icon-like-cm"></i>Thích <span>(0)</span></a>'+
                            '</div>'+
                            '<div class="selects_comment_item">'+
                            '<a href="javacript:void(0)" class="btn-report" data-id="'+re.data._id+'"><i class="icon- icon-report-cm"></i>Vi phạm</a>'+
                            '</div>'+
                            '<div class="selects_comment_item">'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '</div>'
                            ;

                    if(parentid == ''){
                        $('.lists_comment_item').prepend(htmlx);
                        $("#comment-input").val('');
                    }else{
                        $last = $('.son-of-'+parentid).last();
                        if($last.length){
                            $last.after(htmlx);
                        }else
                            $('#cm-'+parentid).after(htmlx);
                        $('.reply-box').remove();
                    }

                } else if(re.status == 505)
                    window.location.href = '/login.php';
                else if(re.status == 400)
                    window.location.href = '/regispack.php';
            });
        }
        else alert("Nội dung bình luận phải dài ít nhất 2 ký tự");
    }
    function reply(){
        var htmlx= '<div class="comment_item comment_son">'
                +'<div class="top_comment_item">'
                '<div class="avatar_comment">'+'<img src="'+re.data.userinfo.priavatar+'" alt="">'+
                '</div>'+
                +'<div class="user_post_comment">'+'Le Phuong Nam'+'</div>'+
                +'<div class="date_post_comment">'+'</div>'
                +'</div>'
                +'<div class="middle_comment_item">'
                +'<div class="text_comment_item">'
                +'<p>Bài học này quá hữu ích, phải lưu lại để sau học mới được. Hihi</p>'
                +'</div>'
                +'</div>'
                +'<div class="bottom_comment_item">'
                +'<div class="three_select_comment_item">'
                +'<div class="selects_comment_item">'
                +'<a href=""><i class="icon- icon-like-cm"></i>Thích</a>'
                +'</div>'
                +'<div class="selects_comment_item">'
                +'<a href=""><i class="icon- icon-report-cm"></i>Vi phạm</a>'
                +'</div>'

                +'</div>'
                +'</div>'
                +'</div>'
        $('.comment_son').append(htmlx);
    }

    function like(id){
        $.post('/incoming.php?act=likecomment', {
            id:id
        }, function (result) {
            if(result.success){
                htmlx = '<i class="icon- icon-like-cm"></i>Bỏ thích <span>('+result.countlike+')</span>';
                $('.btn-like[data-id='+id+']').html(htmlx);
                $('.btn-like[data-id='+id+']').attr('class', 'btn-unlike');
            }else{
                alert(result.mss);
            }
        }, 'json')
    }

    function unlike(id){
        $.post('/incoming.php?act=unlikecomment', {
            id:id
        }, function (result) {
            if(result.success){
                htmlx = '<i class="icon- icon-like-cm"></i>Thích <span>('+result.countlike+')</span>';
                $('.btn-unlike[data-id='+id+']').html(htmlx);
                $('.btn-unlike[data-id='+id+']').attr('class', 'btn-like');
            }else{
                alert(result.mss);
            }
        }, 'json')
    }

    function report(){
        $.post('/incoming.php?act=report',{
            id:id, type: 'comment'
        }, function(result){
            alert(result.mss);
        });
    }

    $(function(){
        $('.lists_comment_item').on('click', '.btn-reply', function(){
            id = $(this).attr('data-id');
            var htmlx = '<div class="comment_type_box reply-box">'+
                    '<textarea class="type_1" id="comment-input-'+id+'" type="text" placeholder="Thêm trả lời"></textarea>'+
                    '<div class="btn_gui_comment center"><a href="javascript:saveComment('+id+')" class="btn_1">Gửi</a></div>'+
                    '</div>';

            $('.reply-box').remove();
            $last = $('.son-of-'+id).last();
            //            $parent = $(this).parent().parent().parent().parent();
            if($last.length)
                $last.after(htmlx);
            else
                $('#cm-'+id).after(htmlx);
            //            $('.comment_son').append(htmlx);
            //            alert(1);
        });

        $('.lists_comment_item').on('click', '.btn-like', function(){
            id = $(this).attr('data-id');
            console.log(id);
            like(id);
        });

        $('.lists_comment_item').on('click', '.btn-unlike', function(){
            id = $(this).attr('data-id');
            console.log(id);
            unlike(id);
        });

        $('.lists_comment_item').on('click', '.btn-report', function(){
            id = $(this).attr('data-id');
            if(confirm('Bạn muốn báo cáo bình luận này là Vi phạm?')){
                report(id);
            }
        });
    })
</script>