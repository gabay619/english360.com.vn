@extends('layouts.private')
@section('content')
        <!--TAB CONTENT-->
        <div class="content_tab_text">
            @if($event)
                <p><strong>Bạn đã đăng ký chương trình "{{$event->name}}"</strong></p>
                <p><strong>Tài khoản miễn phí có hiệu lực từ {{date('d/m/Y', $eventUser->datecreate)}} đến {{date('d/m/Y', $eventUser->datecreate+$event->free_day*24*60*60)}}</strong></p>
            @elseif($checkPackage != 1)
                @if(Network::OPEN_REG_WEB && !empty(Auth::user()->phone))
            <p><strong>Hãy đăng ký dịch vụ để được hưởng ƯU ĐÃI:</strong></p>
            <p>- Sử dụng không giới hạn các tính năng của English360</p>
            <p>- Miễn phí 3G/GPRS</p>
            <p>- Miễn phí 1 ngày sử dụng cho thuê bao đăng ký lần đầu</p>
            <br />
            <p><a href="javascript:confirmRegPackage()" class="btn_x btn_blue btn_padding bold">Đăng ký</a></p>
            <p>(Cước dịch vụ 2.000đ/ngày, gia hạn hàng ngày)</p>
                @else
                    <p><strong>Hãy đăng ký dịch vụ để học tiếng anh mỗi ngày với English360</strong></p>
                    <p>- Dịch vụ MIỄN PHÍ 3G/GPRS</p>
                    <p>- MIỄN PHÍ 1 ngày sử dụng cho thuê bao đăng ký lần đầu</p>
                    <p>- Để đăng ký gói, soạn tin DK E gửi 9317. (Cước phí: 2.000đ/ngày, tự động gia hạn)</p>
                    @endif
            @else
                @if(Common::isFreeUser(Auth::user()->phone))
                    <p><strong>Bạn đã nhận được học bổng của English360, khóa học hoàn toàn miễn phí trong 15 ngày.</strong></p>
                    <p><strong>Chúc bạn có khoảng thời gian học tập thú vị cùng English360.</strong></p>
                @elseif(Common::isHssvUser(Auth::user()->_id))
                    <p><strong>Chúc mừng Quý khách đã đăng ký tham gia chương trình English360 đồng hành cùng học sinh – sinh viên.</strong></p>
                    <p><strong>MIỄN PHÍ 30 ngày trải nghiệm. Hết thời gian khuyến mãi, dịch vụ sẽ tự động huỷ.</strong></p>
                @else
                    <p><strong>Bạn đã đăng ký gói E (2.000đ/ngày) từ dịch vụ English360. Bạn được xem không giới hạn các nội dung bài học</strong></p>
                    <p><a href="javascript:confirmCancel()" class="btn_x btn_red btn_padding bold">Hủy dịch vụ</a></p>
                @endif
            @endif
                @if(Session::has('error'))
                    <p><b>{{ Session::get('error') }}</b></p>
                @endif
        </div>

<script>
//    $(function(){
//       $('#txtToken').keypress(function () {
//           $('#ajaxMsg4').html('');
//       })
//    });

    function confirmRegPackage(){
        sendAuthKey();
        bootbox.dialog({
            message: '<p id="ajaxMsg3" class="text-success" style="font-weight: bold">Mã xác thực đã được gửi về số điện thoại của Quý khách. Vui lòng nhập mã xác thực và nhấn nút Đồng ý.</p>'+
            '<div>' +
            '<label id="ajaxMsg4" style="color: red; font-weight: bold;"></label>'+
            '<input id="txtToken" class="form-control" style="margin-bottom: 5px" type="password" placeholder="Nhập mã xác thực" />' +
            '<div class="text-center resend-key">' +
            '<img src="/assets/images/loading-image.gif" style="display: none"/>'+
            '<a href="javascript:sendAuthKey();" style="text-decoration: underline">Lấy lại mã xác thực</a>' +
            '</div>'+
            '</div>',
            title: '',
            buttons: {
                success: {
                    label: 'Đồng ý',
                    className: 'btn-success',
                    callback: function() {
                        token = $('#txtToken').val();
                        if(token == ''){
                            $('#ajaxMsg4').html('Bạn phải nhập Mã xác thực.');
                            return false;
                        }
                        $.post('/user/check-auth-key', {
                            auth_key: token, _token: '{{csrf_token()}}'
                        }, function(result){
                            if(result.success){
                                $('.modal').modal('hide');
                                registerPackage();
                            }else{
                                $('#ajaxMsg4').html(result.message);
                            }
                        }, 'json');
                        return false;
                    }
                },
                danger: {
                    label: "Bỏ qua",
                    className: "btn-danger",
                    callback: function() {
                        $('.modal').modal('hide');
                    }
                },
            }
        });
    }

    function sendAuthKey(){
        $('.resend-key a').hide();
        $('.resend-key img').show();
        $.post('/user/auth-key', {
            _token: '{{csrf_token()}}'
        }, function(result){
            $('.resend-key a').show();
            $('.resend-key img').hide();
            if(!result.success){
                $('#ajaxMsg3').addClass('text-danger').removeClass('text-success').html(result.message);
            }else{
                $('#ajaxMsg3').addClass('text-success').removeClass('text-danger').html('Mã xác thực đã được gửi về số điện thoại của Quý khách. Vui lòng nhập mã xác thực và nhấn nút Đồng ý.');
            }
        })
    }

    function registerPackage(){
        $.post('/user/register-package', {
            _token: '{{csrf_token()}}'
        }, function (result) {
            bootbox.alert(
                    '<div style="font-size: 14px; text-align: center"><p>'+result.message+'</p></div>'
                    , function(){
                        @if(Session::has('return_url'))
                        window.location.href = '{{Session::get('return_url')}}'
                        @else
                        location.reload();
                        @endif
                    });
            setTimeout(function(){
                @if(Session::has('return_url'))
                window.location.href = '{{Session::get('return_url')}}'
                @else
                location.reload();
                @endif
    }, 5000);
        })
    }

    function confirmCancel(){
        bootbox.dialog({
            message: '<p><strong>Bạn đang sử dụng dịch vụ English360. Nếu hủy dịch vụ, bạn sẽ mất quyền sử dụng một số tính năng hữu ích trên english360?</strong></p>'+
                    '<p>- Dịch vụ miễn phí 3G/GPRS</p>'+
                    '<p>- Sử dụng tất cả các tính năng của English360</p>'+
                    '<p>- Miễn phí 1 ngày sử dụng </p>',
            title: 'Hủy dịch vụ',
            buttons: {
                success: {
                    label: 'Đồng ý Hủy',
                    className: 'btn-danger',
                    callback: function() {
                        cancelPackage();
                    }
                },
                danger: {
                    label: "Bỏ qua",
                    className: "btn-default",
                    callback: function() {
                        $('.modal').modal('hide');
                    }
                },
            }
        });
    }

    function cancelPackage(){
        $.post('/user/cancel-package', {
            _token: '{{csrf_token()}}'
        }, function (result) {
            bootbox.alert(
                    '<div style="font-size: 14px; text-align: center"><p>'+result.message+'</p></div>'
                    , function(){
                        location.reload();
                    });
            setTimeout(function(){
                location.reload();
            }, 5000);
        })
    }
</script>
@endsection