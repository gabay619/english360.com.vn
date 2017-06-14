<div class="chucnang_right"><a href="#" class="">
        </a><div class="chucnang_tratu"><a href="#" class="">
        </a>
        <a class="tooltips tts big-link" href="" id="open-tratu" data-featherlight="#fl2">
            <i class="fa fa-fw icon_tratu_1"></i>
            <span>Tra từ nhanh</span>
        </a>
    </div>
    <div class="gotoTop">
        <a class="tooltips tts" href="#">
            <i class="fa fa-fw tomahok"></i>
            <span>Lên đầu trang</span>
        </a>
    </div>
</div>
<div class="lightbox lb2" id="fl2">
    <!--<h2 class="heading_lightbox">Đăng ký tài khoản</h2>-->
    <div class="content_lightbox">
        <div class="ct_tratu">
            <div class="heading_ct_tratu">
                <h1 class="center">Tra từ nhanh</h1>
                <div class="box_input_tratu block" style="position: relative">
                    <div class="tratu_lang">
                        <a href="javascript:void(0)" class="btn-lang" data-value="1"><img src="/assets/web/images/lang_ev.png" /></a>
                        <a href="javascript:void(0)" class="btn-lang" data-value="2"><img src="/assets/web/images/lang_ve.png" /></a>
                    </div>
                    <div class="input-tratu">
                        <input class="input_tratu txtTratu" type="text" placeholder="Nhập từ cần tra" />
                        <ul class="suggestions" style="display: none">
                        </ul>
                    </div>
                    <button class="btn_tratu" type="button"></button>
                </div>
                <div class="tratu_result" style="display: none">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){

        $('.btn-lang').click(function(){
            $('.btn-lang').removeClass('active');
            $(this).addClass('active');
            setCookie('tratu-lang', $(this).attr('data-value'), 365);
        })

        $('#open-tratu').featherlight({
            afterOpen: function(event){
                var lang = getCookie('tratu-lang') != '' ? getCookie('tratu-lang') : '1';
                $('.btn-lang[data-value='+lang+']').addClass('active');
                $('.tratu_result').html('').hide();
            }
        })
    })
</script>

<style>
    .suggestions {
        background: #fff;
        padding: 5px;
        position: absolute;
        z-index: 10;
        -webkit-box-shadow: 0px 3px 8px 0px rgba(50, 50, 50, 0.37);
        -moz-box-shadow: 0px 3px 8px 0px rgba(50, 50, 50, 0.37);
        box-shadow: 0px 3px 8px 0px rgba(50, 50, 50, 0.37);
        width: 100%;
        top: 50px;
    }
    ul li .suggested{
        display: block;
    }
    ul li .suggested:hover {
        background: #f5e1ce none repeat scroll 0 0;
        color: #f36f5d;
        padding: 2px;
    }
    .input-tratu{
        position: relative;
        /*overflow: hidden;*/
        width: 310px;
        display: inline-block;
        float: left;
    }
    .featherlight-content{
        overflow: visible !important;
    }
</style>