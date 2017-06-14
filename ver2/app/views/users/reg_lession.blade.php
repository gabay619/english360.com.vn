@extends('layouts.private')
@section('content')
    <!--TAB CONTENT-->
    <div class="content_tab_text">
    <p><strong class="notice_1 uppercase color_red mgb10">Đăng ký nhận bài học qua email</strong></p>
    {{--@if($showEmail)--}}
            {{--<div style="clear: both"></div>--}}
            {{--<div class="emailbox form-inline" style="padding: 0 0 10px 0;">--}}
                {{--<div class="form-group">--}}
                    {{--<input type="text" class="form-control" value="{{Auth::user()->email}}" placeholder="Nhập email của bạn" id="txtEmailLession">--}}
                {{--</div>--}}
                {{--<button class="btn btn-primary" type="button" onclick="regEmailLession()">Đăng ký email</button>--}}
            {{--</div>--}}
        {{--@endif--}}
        <div style="clear: both"></div>
        <div style="overflow: hidden" id="chkLession">
            @if(count($checked) > 0)
            <p style="background: #ccc;padding: 10px"><b>Các chuyên mục bạn đã đăng ký:</b></p>
            @else
            <p style="background: #ccc;padding: 10px"><b>Chọn chuyên mục bạn quan tâm:</b></p>
            @endif
        @foreach($allType as $key=>$aType)
            <label class="col-sm-6"><input type="checkbox" value="{{$key}}" @if(in_array($key,$checked)) checked @endif/> {{$aType}}</label>
        @endforeach
                <label class="col-sm-6"><input type="checkbox" value="all" id="checkAllType"/> Tất cả</label>
        </div>
        <div class="text-center" style="margin-top: 20px">
            <button class="btn btn-primary" type="button" onclick="regLession()"><i class="glyphicon glyphicon-ok"></i> Lưu</button>
        <p><i>Để dừng nhận bài học mới qua email, vui lòng click vào <a href="javascript:removeRegLession()" style="text-decoration: underline">đây</a></i></p>
        </div>
    </div>
    <script>
            $(function () {
                $('#checkAllType').click(function () {
                    $('#chkLession input').not(this).prop('checked', this.checked);
                })
            })

            function regLession() {
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
                    showMss(result.message);
//                    if(result.success){
//                        location.reload();
//                    }
                    console.log(select);
                })
            }
            @if($showEmail)
            function regEmailLession() {
                email = $('#txtEmailLession').val();
                $.post('/ajax/reg-email-lession', {
                    email: email
                }, function (re) {
                    if(re.success){
                        showMss('Cập nhật email thành công');
                    }else  if(typeof re.verify !== 'undefined'){
                        showMss(re.mss);
                        $('.emailbox').hide();
                    }
                },'json');
            }
            @endif

            function removeRegLession() {
                $.post('/ajax/reg-lession', {
                    select:[]
                }, function(result){
                    if(result.success){
                        showMss('Bạn đã hủy nhận bài học mới.');
                        location.reload();
                    }else{
                        showMss(result.message);
                    }
                    console.log(select);
                })
            }
    </script>
@endsection