@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Đổi mật khẩu
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-lg-6">
            @include('layouts._messages')
            {{Form::open(array('url'=>'/user/change-password'))}}
            <div class="form-group">
                <label>Mật khẩu cũ</label>
                {{Form::password('old_password', array('class'=>'form-control'))}}
            </div>
            <div class="form-group">
                <label>Mật khẩu mới</label>
                {{Form::password('password', array('class'=>'form-control'))}}
            </div>
            <div class="form-group">
                <label>Xác nhận mật khẩu mới</label>
                {{Form::password('password_confirmation', array('class'=>'form-control'))}}
            </div>
            {{Form::submit('Cập nhật', array('class'=>'btn btn-primary'))}}
            {{Form::close()}}
        </div>
    </div>
@endsection