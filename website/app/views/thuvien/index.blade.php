<ul>
    @foreach($list as $item)
        <li><a href="{{$item->getArticleUrl($type)}}">{{$item->name}}</a></li>
    @endforeach
</ul>