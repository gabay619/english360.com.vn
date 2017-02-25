<script>
    bootbox.dialog({
        message: '<div style="overflow: hidden" id="chkLession">' +
        @foreach($allType as $key=>$aType)
                '<label class="col-sm-6"><input type="checkbox" value="{{$key}}" @if(in_array($key,$checked)) checked @endif/> {{$aType}}</label>'+
        @endforeach
                '</div>',
        title: 'Chọn chuyên mục bạn quan tâm',
        buttons: {
            success: {
                label: 'Lưu',
                className: 'btn-success',
                callback: function() {
                    select = [];
                    $('#chkLession input').each(function(){
                        if($(this).is(':checked'))
                            select[select.length] = $(this).val();
                    });
                    $.post('/ajax/reg-lession', {
                        select:select
                    }, function(result){
                        console.log(select);
                    })
                    $('.modal').modal('hide');
                }
            },
//                danger: {
//                    label: "Bỏ qua",
//                    className: "btn-danger",
//                    callback: function() {
//                        $('.modal').modal('hide');
//                    }
//                },
        }
    });
</script>