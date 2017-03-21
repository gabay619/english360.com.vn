<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">English360 Affiliate</a>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            @foreach($allPages as $aPage)
                <li>
                    <a href="/trang/{{$aPage->slug}}.html">{{$aPage->name}}</a>
                </li>
            @endforeach
        </ul>
    </div>
<!-- Top Menu Items -->
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
{{--@include('layouts.aside')--}}
<!-- /.navbar-collapse -->
</nav>
