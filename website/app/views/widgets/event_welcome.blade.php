<script>
    $(function(){
        bootbox.dialog({
            @if($show == 'welcome')
            title: '<div class="text-center">CHÚC MỪNG!</div>',
            message: '<div class="text-center"> <p>Bạn đã nhận được học bổng của English360, khóa học hoàn toàn miễn phí trong 15 ngày.</p>'+
            '<p>Chúc bạn có khoảng thời gian học tập thú vị cùng English360.</p></div>',
            @else
            title: '<div class="text-center">THÔNG BÁO</div>',
            message: '<div class="text-center"> <p>Khóa học bổng của English360 đã kết thúc. Bạn hãy tiếp tục đăng ký để nhận được các ưu đãi sau:</p>'+
            '<p>- Được tham gia tất cả các bài học của English360</p>' +
            '<p>- Được miễn phí 1 ngày học tiếp theo</p>'+
            '<p>Soạn tin DK E gửi 9317 để đăng ký.</p></div>',
            @endif
        });
    })
</script>