<div class="modal fade" id="regModal" tabindex="-1" role="dialog" aria-labelledby="regModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if(isset($timeout))
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                @endif
                <h4 class="modal-title text-danger">Nhập số điện thoại để đăng ký dịch vụ (2.000đ/ngày, tự động gia hạn)</h4>
            </div>
            <div class="modal-body" style="overflow: hidden">
                <form class="">
                    <div class="form-group">
                        <label for="popupregPhone" class="text-danger" id="popregMsg"></label>
                        <input type="text" class="form-control" id="popupregPhone" placeholder="Số điện thoại MobiFone">
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-primary" onclick="sendKey()">Đăng ký</button>
                        <br>
                        <p>Nếu bạn đã có tài khoản, vui lòng <a href="/user/login" style="text-decoration: underline;">Đăng nhập tại đây</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="regKeyModal" tabindex="-1" role="dialog" aria-labelledby="regModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if(isset($timeout))
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                @endif
                <h4 class="modal-title text-danger" id="exampleModalLabel">Mã xác thực đã được gửi về số điện thoại của bạn</h4>
            </div>
            <div class="modal-body" style="overflow: hidden">
                <form>
                    <div class="form-group">
                        <label for="popupregKey" class="text-danger" id="popregkeyMsg"></label>
                        <input type="password" class="form-control" id="popupregKey" placeholder="Nhập mã xác thực">
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-primary" onclick="checkKey()">Đăng ký</button>
                        <button type="button" class="btn btn-success btnResend" onclick="resendKey()">Lấy lại mã xác thực</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        @if(isset($timeout))
        setTimeout(function () {
            $('#regModal').modal('show');
        }, {{$timeout}});
        @else
        $('#regModal').modal({
            backdrop: 'static',
            keyboard: false
        })
        $('#popregMsg').modal({
            backdrop: 'static',
            keyboard: false
        })
        $('#regModal').modal('show');
        @endif

        $('#regModal').on('shown.bs.modal', function () {
            $('#popupregPhone').focus();
            $.post('/ajax/add-popup-number', {

            },function () {

            }, 'json');
        })
    })

    function sendKey() {
        phone = $('#popupregPhone').val();
        if(phone == '')
                $('#popregMsg').html('Vui lòng nhập số điện thoại.');
        $.post('/user/send-auth-key', {
            phone: phone, _token: '{{csrf_token()}}', check_exist:1
        }, function(result){
            console.log(result);
            if(result.success){
                $('.modal').modal('hide');
                $('#regKeyModal').modal('show');
            }else{
                $('#popregMsg').html(result.message);
                $('#popupregPhone').focus();
            }
        }, 'json')
    }
    
    function resendKey() {
        $('#btnResend').hide();
        $.post('/user/send-auth-key', {
            _token: '{{csrf_token()}}',check_exist:1
        }, function (result) {
            $('#btnResend').show();
            if(result.success){
//                $('.modal').modal('hide');
//                $('#regKeyModal').modal('show');
            }else{
                $('#popregkeyMsg').html(result.message);
//                $('#popupregKey').focus();
            }
        }, 'json')
    }
    
    function checkKey() {
        auth_key = $('#popupregKey').val();
        if(auth_key == '')
            $('#popregMsg').html('Vui lòng nhập mã xác thực.');
        $.post('/user/check-auth-key-and-package', {
            auth_key: auth_key, _token : '{{ csrf_token() }}'
        }, function(result) {
            if(result.success){
                location.reload();
            }else{
                $('#popregkeyMsg').html(result.message);
                $('#popupregKey').focus();
            }
        }, 'json');
    }
</script>