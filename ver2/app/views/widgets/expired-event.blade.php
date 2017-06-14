<script>
    $(function(){
        bootbox.dialog({
            title: 'THÔNG BÁO',
            message: '<div class="text-center"> ' +
            '<p>Thời gian sử dụng miễn phí đã kết thúc.</p>'+
                    @if(!empty(Auth::user()->phone))
            '<p>Bấm vào <a href="/user/package">ĐÂY</a> để đăng ký và sử dụng dịch vụ.</p>'+
                    @else
            '<p>Soạn DK E gửi 9317 để tiếp tục sử dụng (Chỉ áp dụng cho thuê bao MobiFone)</p>'+
                 @endif
            '</div>',
        });
    })
</script>