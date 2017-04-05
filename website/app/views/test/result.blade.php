@extends('layouts.private_not_aside', array(
    'breadcrumb'=>'Kiểm tra trình độ',
    'breadcrumbUrl' => '/test'
))
@section('content')

        <div class="row">
            <div class="col-sm-12">
                <h4 class="title_1">Kết quả bài kiểm tra</h4>
                <label class="mini_date">{{date('d/m/Y H:i', $testResult->datecreate)}}</label>
            </div>
            <div class="col-sm-8">
                <div style="border: 1px solid #ccc; padding: 20px; margin-bottom: 20px" class="text-center">
                   <h3 style="color: #db2727"><strong>{{$testResult->point}}/24</strong></h3>
                </div>
                <div style="border: 1px solid #ccc; padding: 20px; margin-bottom: 20px">
                    {{$testLevel->content}}
                </div>
            </div>
            <div class="col-sm-4">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Điểm</th>
                        <th>Trình độ</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allLevel as $aLv)
                    <tr>
                        <td>{{$aLv->start}} - {{$aLv->end}}</td>
                        <td>{{$aLv->name}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    <style>
        th {
            font-weight: bold;
        }
    </style>
@endsection