@include('layouts._header')
<div class="content">
    <div class="w1170">
        @yield('content')
        @include('layouts.content_right')
    </div>
</div>

@include('layouts._footer')