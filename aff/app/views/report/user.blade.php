@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Báo cáo user
            </h1>
        </div>
    </div>
    @datepicker($start, $end, '/report/user')
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Email</th>
                        <th>Thời gian</th>
                        <th>Nguồn</th>
                        <th>Thời hạn khóa học</th>
                        <th>Ghi chú</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allUser as $user)
                        <tr>
                            <td>{{$user['email']}}</td>
                            <td>{{date('d/m/Y H:i',$user['aff']['datecreate'])}}</td>
                            <td>{{isset($user['aff']['sub_id']) ? $user['aff']['sub_id'] : ''}}</td>
                            <td>{{isset($user->pkg_expired) ? ($user->pkg_expired > time() ? date('d/m/Y',$user->pkg_expired ) : 'Hết hạn ('.date('d/m/Y',$user->pkg_expired ).')') : 'Chưa ĐK'}}</td>
                            <td>
                                <div>{{$user->pub_description or ''}}</div>
                                <button type="button" class="btn btn-sm btn-default btnEditDescription pull-right"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-sm btn-default btnSubmitDescription pull-right" style="display: none" data-uid="{{$user->_id}}"><i class="fa fa-check"></i></button>
                            </td>
                            <td><a class="btn btn-primary btm-sm" href="/report/history/{{$user->_id}}">Lịch sử</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{$allUser->appends(['start' => $start, 'end'=>$end])->links()}}
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('.btnEditDescription').click(function(){
                content = $(this).parent().find('div').html();
                htmlx = '<input type="text" value="'+content+'" class="form-control" />';
                $(this).parent().find('div').html(htmlx);
                $(this).parent().find('.btnSubmitDescription').show();
                $(this).hide();
            });
            $('.btnSubmitDescription').click(function () {
                $parent = $(this).parent();
                content = $(this).parent().find('div input').val();
                id = $(this).attr('data-uid');
                $.post('/user/edit-pub-description', {
                    content:content, id:id, _token: '{{csrf_token()}}'
                }, function(re){
                    if(re.success){
                        $parent.find('div').html(content);
                    }else{
                        $parent.find('div').html('');
                        alert('re.message');
                    }
                    $parent.find('.btnSubmitDescription').hide();
                    $parent.find('.btnEditDescription').show();
                });
//                alert(content);
            })
        })
    </script>
@endsection