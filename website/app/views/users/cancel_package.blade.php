@extends('layouts.private')
@section('content')
<!--TAB CONTENT-->
<div class="content_tab_text">
    <p><strong>Bạn đang sử dụng dịch vụ English360. Nếu hủy dịch vụ, bạn sẽ mất quyền sử dụng một số tính năng hữu ích trên englis360?</strong></p>
    <p>- Dịch vụ miễn phí 3G/GPRS</p>
    <p>- Sử dụng tất cả các tính năng của English360</p>
    <p>- Miễn phí 1 ngày sử dụng </p>
    <br />
    <p><a href="javascript:confirmCancel()" class="btn_x btn_red btn_padding bold">Hủy dịch vụ</a></p>
</div>

<script>
    function confirmCancel(){
        if(confirm('Bạn chắc chắn hủy gói E?')){
            $.post('/user/cancel-package', {}, function (result) {
                if(result.success){
                    htmlx = '<p><strong class="text-success">'+result.message+'</strong></p>';
                    $('.content_tab_text').html(htmlx);
                }else{
                    htmlx = '<p><strong class="text-danger">'+result.message+'</strong></p>';
                    $('.content_tab_text').prepend(htmlx);
                }
            })
        }

    }
</script>
@endsection