<ul class="pagination">
    <li class="prev {{$stpage<=1 ? 'disabled' : ''}}"><a href="{{Common::cpagerparm("page")}}page={{$stpage<=1 ? 1 : $stpage-1}}">Trước</a></li>
    @for($i=1;$i<=$totalpage;$i++)
        @if($stpage >= ($i-$maxshowpage) && $stpage <= ($i+$maxshowpage))
            @if($i==$stpage)
                <li class="active"><a href="#">{{$i}}</a></li>
            @else
                <li><a href="{{Common::cpagerparm("page")}}page={{$i}}">{{$i}}</a></li>
            @endif
        @endif
    @endfor
    <li class="next {{$stpage>=$totalpage ? 'disabled': ''}}"><a href="{{Common::cpagerparm("page")}}page={{$stpage>=$totalpage ? $totalpage : $stpage+1}}">Tiếp</a></li>
</ul>