<ul>
    @foreach($list as $item)
        <li><a href="{{$item->getDetailUrl()}}">{{$item->name}}</a></li>
    @endforeach
</ul>