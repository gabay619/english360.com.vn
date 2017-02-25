<div style="clear: both"></div>
<div class="emailbox form-inline" style="margin: 0 auto; width: 300px; text-align: center;border: 1px solid #ccc;padding: 10px;">
    <p>Đăng ký nhận bài học qua email</p>
    <div class="form-group">
        <input type="text" class="form-control" value="{{$email}}" placeholder="Nhập email của bạn" id="txtEmailLession">
    </div>
    <button class="btn btn-primary" type="button" onclick="regEmailLession()">Đăng ký</button>
</div>
<script>
    $(function () {
        $('#checkAllType').click(function () {
            $('#chkLession input').not(this).prop('checked', this.checked);
        })
    })

    function regEmailLession() {
        email = $('#txtEmailLession').val();
        $.post('/ajax/reg-email-lession', {
            email: email
        }, function (re) {
            if(re.success){
                openListCate();
                $('.emailbox').hide();
            }else if(typeof re.login !== 'undefined'){
                window.location.href = '/user/register';
            }else  if(typeof re.verify !== 'undefined'){
                showMss(re.mss);
                $('.emailbox').hide();
            }else{
                htmlx = '<p class="text-danger">'+re.mss+'</p>';
                $('.emailbox').append(htmlx);
            }
        },'json');
    }

    function openListCate(){
        bootbox.dialog({
            message: '<div style="overflow: hidden" id="chkLession">' +
            @foreach($allType as $key=>$aType)
                    '<label class="col-sm-6"><input type="checkbox" value="{{$key}}" @if(in_array($key,$checked)) checked @endif/> {{$aType}}</label>'+
            @endforeach
                    '<label class="col-sm-6"><input type="checkbox" value="all" id="checkAllType" onclick="$(\'#chkLession input\').not(this).prop(\'checked\', this.checked);" /> Tất cả</label>'+
            '</div>',
            title: 'Chọn chuyên mục bạn quan tâm',
            buttons: {
                success: {
                    label: 'Lưu',
                    className: 'btn-success',
                    callback: function() {
                        select = [];
                        $('#chkLession input').each(function(){
                            if($(this).is(':checked')){
                                if($(this).val() != 'all')
                                    select[select.length] = $(this).val();
                            }
                        });
                        $.post('/ajax/reg-lession', {
                            select:select
                        }, function(result){
                            console.log(result);
                            showMss(result.message);
//                            if(result.success){
//                                location.reload();
//                            }
                        })
//                        $('.modal').modal('hide');
                    }
                },
            }
        });
    }
</script>