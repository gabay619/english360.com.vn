@extends('layouts.private')

@section('content')
<!--TAB CONTENT-->
<div class="content_tab_text">
    <div class="list_bhdl block">
        <ul class="ul_block_list_cate">
            @if(count($listLession) > 0)
            @foreach($listLession as $aLession)
            <li>
                <div class="item4">
                    <button class="delete_btn" data-id="{{$aLession['id']}}" data-type="{{$aLession['type']}}"><i class="fa fa-fw"></i>Xóa</button>
                    <a title="" href="{{$aLession['url']}}">
                        <span class="img_mask img_mask_item4">
                            <img src="{{$aLession['avatar']}}">
                        </span>
                        <label class="mini_date">{{$aLession['date']}}</label>
                        <label class="mini_tags">{{$aLession['cate']}}</label><br>
                        <strong class="title_item5">{{$aLession['name']}}</strong>
                    </a>
                </div>
            </li>
            @endforeach
            @else
                <li>
                    <div class="item4">
                        <strong class="title_item5">Bạn chưa lưu bài học nào.</strong>
                    </div>
                </li>
            @endif
        </ul>
        @if($totalPage > 1)
        <ul class="pagination">
            <li>
                <a href="?page=1">Đầu</a>
            </li>
            @for($i = 1; $i<=$totalPage; $i++)
                @if($page+5>=$i && $page-5 <= $i)
                <li @if($i==$page) class="active" @endif>
                    <a href="?page={{$i}}">{{$i}}</a>
                </li>
                @endif
            @endfor
            <li>
                <a href="?page={{$totalPage}}">Cuối</a>
            </li>
        </ul>
        @endif
    </div>
</div>
<script>
    $(function () {
        $('.delete_btn').click(function(){
            if(!confirm('Bạn muốn xóa bài học đã lưu này?'))
                return false;
            id = $(this).attr('data-id');
            type = $(this).attr('data-type');
            $parent = $(this).parent().parent();
            $.post('/user/delete-save-lession', {
                id:id, type:type
            }, function(result){
                if(result.success){
                    $parent.remove();
                }else{
                    alert(result.message);
                }
            }, 'json')
        })
    })
</script>
@endsection