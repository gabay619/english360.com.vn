@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Thông tin tài khoản
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-lg-6">
            @include('layouts._messages')
            {{Form::open(array('url'=>'/user/setting'))}}
                <div class="form-group">
                    <label>Họ và tên</label>
                    {{Form::text('fullname', Auth::user()->fullname, array('class'=>'form-control'))}}
                </div>
                <div class="form-group">
                    <label>Ngày sinh</label>
                    {{Form::text('birthday', Auth::user()->birthday, array('class'=>'form-control datepicker', 'placeholder'=>'dd/mm/yyyy'))}}
                </div>
                <div class="form-group">
                    <label>Số CMND</label>
                    {{Form::text('cmnd', Auth::user()->cmnd, array('class'=>'form-control'))}}
                </div>
                <div class="form-group">
                    <label>Ngày cấp CMND</label>
                    {{Form::text('cmnd_ngaycap', Auth::user()->cmnd_ngaycap, array('class'=>'form-control datepicker', 'placeholder'=>'dd/mm/yyyy'))}}
                </div>
                <div class="form-group">
                    <label>Nơi cấp CMND</label>
                    {{Form::text('cmnd_noicap', Auth::user()->cmnd_noicap, array('class'=>'form-control', 'placeholder'=>'Tỉnh/Thành phố'))}}
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label>
                    {{Form::text('phone', Auth::user()->phone, array('class'=>'form-control'))}}
                </div>
                <div class="form-group">
                    <label>Email</label>
                    {{Form::text('email', Auth::user()->email, array('class'=>'form-control','disabled'))}}
                </div>
                {{Form::submit('Cập nhật', array('class'=>'btn btn-primary'))}}
            {{Form::close()}}
            @if(!empty(Auth::user()->password))
                <p style="margin-top: 10px"><a style="text-decoration: underline" href="/user/change-password">Đổi mật khẩu</a></p>
            @endif
        </div>
    </div>

@endsection