<script>
    $(function(){
        setTimeout(function () {
            bootbox.dialog({
                title: '',
                message: '<div class="text-center"> ' +
                '<img src="{{$event->bgWeb}}" style="width:100%">'+
                '<div style="position: absolute; top: 60%; margin: 0 auto; left: 0; right: 0; width: 50%">'+
                '<input type="text" class="form-control" placeholder="Nhập email" id="emailEvent" />'+
                '<button type="button" class="btn btn-success" style="margin-top:10px" onclick="regEvent()">Đồng ý</button>'+
                '</div>'+
                '</div>',
                size: 'large',
                onEscape: function() {
                    $.post('/ajax/remove-event', {

                    },function () {

                    })
                }
            });
        }, {{$event->timeout_popup*1000}})

    })
    
    function regEvent() {
        email = $('#emailEvent').val();
        if(email == ''){
            alert('Địa chỉ Email không được bỏ trống.');
            return false;
        }
        $.post('/ajax/reg-event', {
            email: email, event_id: '{{$event->_id}}'
        }, function (re) {
            if(re.success){
                bootbox.hideAll();
                $.post('/ajax/remove-event', {

                },function () {

                })
                bootbox.dialog({
                    title: 'THÔNG BÁO',
                    message: re.message
                })
            }else{
                alert(re.message);
                return false;
            }
        })
    }
</script>