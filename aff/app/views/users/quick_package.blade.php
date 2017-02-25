@extends('layouts.detail')

@section('content')
    <div class="content_left pd_20">
        <div class="block">
            <div class="block_detail">
                <div class="breadcrum">
                    <ul class="ul_breadcrum">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="">Đăng ký</a></li>
                    </ul>
                </div>
                <div class="individual_control_page">
                    <div class="vertical_tab individual_tab block" id="step1">
                        <p><strong>Hãy đăng ký dịch vụ để được hưởng ƯU ĐÃI:</strong></p>
                        <p>- Sử dụng không giới hạn các tính năng của English360</p>
                        <p>- Miễn phí 3G/GPRS</p>
                        <p>- Miễn phí 1 ngày sử dụng cho thuê bao đăng ký lần đầu</p>
                        <p id="phoneMss" style="width: 70%"></p>
                        <p style="width: 70%">
                            <input type="text" placeholder="Nhập số điện thoại MobiFone" autofocus class="input_3 form-control" id="txtPhoneQuick">
                        </p>
                        <p>Nếu đã có tài khoản, vui lòng <a href="/user/login" style="text-decoration: underline">đăng nhập</a> tại đây</p>
                        <p><button class="btn_x btn_blue btn_padding bold" type="button" onclick="sendAuthKey()">Đăng ký</button></p>
                        <p style="border: 1px solid #ccc; padding: 15px;text-align: center"> Bằng việc đăng ký sử dụng dịch vụ, bạn đã chấp nhận các <a href="/trang/dieu-khoan.html" style="text-decoration: underline">Điều khoản</a> của English360 </p>
                    </div>
                    <div class="vertical_tab individual_tab block" id="step2" style="display: none">
                        <p>Mã xác thực đã được gửi về số điện thoại của quý khách. Vui lòng nhập mã xác thực và nhấn nút Đồng ý</p>
                        <p><input type="text" placeholder="Nhập mã xác thực" class="input_3 form-control" style="width: 50%" id="txtTokenQuick"></p>
                        <p id="tokenMss" style="width: 70%"></p>
                        <p><a href="javascript:sendAuthKey()" style="text-decoration: underline">Lấy lại mã xác thực</a></p>
                        <p><button class="btn_x btn_blue btn_padding bold" type="button" onclick="checkAuthKey()">Đồng ý</button></p>
                        <p>(Cước dịch vụ 2.000đ/ngày, gia hạn hàng ngày)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('#txtPhoneQuick').keyup(function () {
                $('#txtPhoneQuick').parent().removeClass('has-error')
            })
            $('#txtTokenQuick').keyup(function () {
                $('#txtTokenQuick').parent().removeClass('has-error')
            })
        })
        function sendAuthKey() {
            phone = $('#txtPhoneQuick').val();
            $.post('/user/send-auth-key', {
                phone: phone, _token : '{{ csrf_token() }}', check_exist: 1
            }, function (re) {
                if(re.success){
                    $('#step1').hide();
                    $('#step2').show();
                    $('#txtTokenQuick').focus()
                }else{
                    $('#txtPhoneQuick').parent().addClass('has-error')
                    $('#phoneMss').addClass('alert alert-danger').html(re.message);
                }
            })

        }
        
        function checkAuthKey() {
            token = $('#txtTokenQuick').val();
            $.post('/user/check-auth-key-and-package', {
                auth_key: token, _token : '{{ csrf_token() }}'
            }, function(re) {
                if(re.success){
                    $.blockUI({ message: '<h1>Đang chuyển trang, xin đợi một lát...</h1>' });
                    setTimeout(function () {
                        window.location.href = '{{Input::get('return_url','/')}}'
                    },5000)
                }else{
                    $('#txtTokenQuick').parent().addClass('has-error')
                    $('#tokenMss').addClass('alert alert-danger').html(re.message);
                }
            }, 'json');
        }
    </script>
@endsection