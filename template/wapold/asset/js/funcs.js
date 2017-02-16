var funcs = {};
var l = window.location;
var basepath = l.protocol + "//" + l.host + "/";
funcs.register = {
    step : function(step){
        if(step == 1)
        {
            $('#step-1').show();
            $('#step-2').hide();
            funcs.scroll.toPos('body');
        }
        else if(step == 2)
        {           
            //Process validate form step 1
            var user = $("#username");
            var password = $("#password");
            var repassword = $("#repassword");
            var email = $("#email");
            var params = {
                'vstep1' : true,
                'user' : user.val(),
                'pass' : password.val(),
                'repass' : repassword.val(),
                'email' : email.val()
            }
            this.processing(params);

        }                
    },
    processing : function(params){
        if(params.vstep1){
            $.post(l.pathname,params,function(rt){

                $(".m_err_noti").find('span').text('');
                $(".m_input_text").removeClass('m_input_error');
                if(funcs.string.IsJsonString(rt))
                {
                    var rt = jQuery.parseJSON(rt);
                    var i = 0;
                    var tmp = 'body';
                    $.each(rt, function( key, value ) {
                        (i == 0) ? tmp = '#' + key : null;
                        i++;

                        $("#" + key).parent().addClass('m_input_error');
                        $("#" + key).parent().next().find("span").text(value);                        
                    })
                    funcs.scroll.toPos(tmp);
                }
                else
                {
                    $('#step-1').hide();
                    $('#step-2').show();
                    funcs.scroll.toPos('body'); 
                }
            });
        }
        if(params.submit){
            //funcs.page.changeCaptcha();
            params = $("#form-register").serialize();
            $.post(l.pathname,params,function(rt){
                $(".m_err_noti").find('span').text('');
                $(".m_input_text").removeClass('m_input_error');
                if(funcs.string.IsJsonString(rt))
                {
                    var rt = jQuery.parseJSON(rt);
                    var i = 0;
                    var tmp = 'body';
                    $.each(rt, function( key, value ) {
                        (i == 0) ? tmp = '#' + key : null;
                        i++;
                        if(key != 'dieukhoan')
                            $("#" + key).parent().addClass('m_input_error');
                        if(key == 'username' || key == 'email')
                        {
                            $('#step-1').show();
                            $('#step-2').hide();
                        }
                        //Neu loi thuc thi
                        if(key == 'ersuccess')
                            alert('Có lỗi trong quá trình đăng ký bạn hãy thử lại');
                        if(key == 'success')
                            funcs.page.reLoad();

                        $("#" + key).parent().next().find("span").text(value);                        
                    })                    
                    funcs.scroll.toPos(tmp);
                }
            })
        }    
        return false;
    }             
},
funcs.scroll = {
    toPos : function (ElementTo)
    {
        var postCm = $(ElementTo).offset()
        if(postCm != undefined)
            $('html, body').animate({scrollTop:postCm.top},300);
    }
},
funcs.string = {
    IsJsonString : function(code)
    {   
        if($.trim(code) == "")
        {
            return false;
        }
        try {        
            $.parseJSON(code)
        } catch (e) {
            return false;
        }
        return true;
    }
},
funcs.page = {
    reLoad : function(){
        location.reload(true);
    },
    changeCaptcha : function(){
        var d = new Date ();
        $('#m_img_captcha').attr('src', basepath + '/pages/captcha.php?r' + d.getTime());
    }
},
funcs.dich = {
    show : function(agrm){
        if($(agrm).attr('show') == 'false'){
            $(".m_tsl_box").show();
            $('.m_tsl_top table').show();
            $(agrm).attr('show','true')
        }else{
            $(".m_tsl_top table").hide();
            $(".m_tsl_box").hide(); 
            $(agrm).attr('show','false');
        }


    },
    close : function(){
        $(".m_tsl_top table").hide();
        $(".m_tsl_box").hide();
        $('.m_tsl_bt').attr('show','false');
    },
    tratu : function(){
        var key = $('.m_tsl_inputsearch').val();
        if(key == ''){
            alert('Bạn chưa nhập từ cần tra vào ô bên cạnh!');
        }else{
            var url = 'http://dic.tienganh123.com/m_dich.php';
            var params = {
                'key' : key
            };
            $.ajax({
                type : "GET",
                url: url,
                dataType: 'jsonp',
                data : params,
                success : function(rs){
                    if(rs.error)
                        $('#m_tsl_info').show().html('<center>Không tìm thấy từ!</center>');
                    else
                    {
                        var edic = "<div class='m_tsl_content_text'><span style='float:left;'>";
                        edic += "<span class='m_tsl_vcab'>"+ rs.name +"</span><br><span>/<font color='#a66322'>"+ rs.pronounciation +"</font>/ </span></span>";
                        edic += "<a href='javascript:;'><img onclick=\"funcs.dich.playaudio('"+ rs.forder +"','"+ rs.name +"');\" src='"+ basepath +"mobile/images/speaker-stop.gif' class='m_tsl_audio'></a></div>";
                        for(var key in rs.dict_classifyword){
                            edic += "<div class='m_tsl_title'>"+ rs.dict_classifyword[key][1] +"</div><div class='m_tsl_content_text'>";
                            for(var x in rs.dict_classifyword[key].dict_mean){
                                edic += "<div class='m_tsl_bigtext'>"+ rs.dict_classifyword[key].dict_mean[x][1] +"</div>";
                                edic += "<ul class='m_tsl_content_list'>";
                                for(var y in rs.dict_classifyword[key].dict_mean[x].dict_example){
                                    edic += "<li>"+ rs.dict_classifyword[key].dict_mean[x].dict_example[y][0] +" + <span class='m_tsl_important'>"+ rs.dict_classifyword[key].dict_mean[x].dict_example[y][1] +"</span></li>";
                                }                                            
                                edic += "</ul>"; 
                            }                                    
                            edic += "</div>";
                        }                            
                        edic += "<div class='m_tsl_control'><span class='m_tsl_ctrl_bt close' onclick='funcs.dich.close()'>Đóng</span></div>";
                        $('#m_tsl_info').show().html(edic);
                    }
                }
            });
        }
    },
    playaudio : function(forder,name){
        var  Beep = document.createElement('audio');
        Beep.setAttribute('src', "http://dic.tienganh123.com/sound/"+ forder +"/"+ name +".mp3");
        Beep.load();
        Beep.play();                           
    }
},
funcs.comment = {
    send : function(tag){
        var cont = $('.m_area_cm').val();
        var url = '/ajax/ajax/rcomment/add_comment';
        cont = cont.replace(/<br>/g,'');
        if($.trim(cont) == '')
        {
            alert('Bạn chưa nhập nội dung bài gửi');
            return false;
        }else if(cont.length < 11){
            alert('Nội dung bạn nhập phải >= 11 ký tự');
            return false;
        }
        if (encodeURIComponent){
            cont = encodeURIComponent(cont);
        }else{
            cont = escape(cont);
        }
        var parrams = {
            'content' : cont             
        };
        $.post(url,parrams,function(rs){
            var rs = jQuery.parseJSON(rs);
            if(rs.success){
                $(tag).parent().html('<span style="color:#479700;font-weight: bold;">Bạn đã gửi bài thành công</span>');
            }else if(rs.error){
                alert(rs.error);
            }
        })
    },
    more : function(page,agrm,mem,ft){
        var offset = $(agrm).attr('id');
        var limit = $(agrm).attr('class');               

        var url = '/ajax/ajax/rcomment/show_comment_by_page';
        url = url+'?url='+page+'&of='+offset+'&lm='+limit+'&cid='+Math.random();       
        //Neu la more theo filter
        if(mem != '')
            url = url+'&mem='+mem;
        if(ft != '')
            url = url+'&ft='+ft;

        $.get(url, function(data){            
            $(agrm).parent().parent().remove();
            $('#show_comment').append(data);
            $('.jquery_jplayer_comment').each(function(i){                    
                     addAudioLong(this,i);      
               });                                  
        });   
    },
    sort_comment : function(){
        var url = '/ajax/ajax/rcomment/fillter';        
        var ft = $('#sort_cm').val();    
        var member = $('.m_input_cm_search').val();        
        url=url+"?ft="+ft;
        url=url+"&mem="+member;
        url=url+"&cid="+Math.random();           
        
        $.get(url, function(data) {          
            $('#show_comment').html(data);        
             $('.jquery_jplayer_comment').each(function(i){                  
                    addAudioLong(this,i);      
             });
        });
    },
    close : function(){
        $('#m_rs_cm_post').hide();
        $('.m_statis_item').removeAttr('show');
        funcs.scroll.toPos('.m_statis_ctrl');
    }
},
funcs.option = {
    remember_lesson : function(){
         var url = '/ajax/ajax/remember_lesson/index';
         $.post(url,{'option':'remember'},function(rs){
            alert(rs); 
         })
    }
}

