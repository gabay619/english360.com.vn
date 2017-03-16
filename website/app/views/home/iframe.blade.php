@extends('layouts.private_not_aside', array('breadcrumb'=>'Học phí'))
@section('content')
    <div class="content_tab_text">
        <iframe src="{{$url}}" frameborder="1" width="100%" height="600px"></iframe>
    </div>
@endsection