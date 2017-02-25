@if(Session::has('message'))
    <p class="text-info"><b>{{ Session::get('message') }}</b></p>
@endif

@if(Session::has('error'))
    <p class="text-danger"><b>{{ Session::get('error') }}</b></p>
@endif

@if(Session::has('success'))
    <p class="text-success"><b>{{ Session::get('success') }}</b></p>
@endif

<ul>
    @foreach($errors->all() as $error)
        <li class="text-danger">{{ $error }}</li>
    @endforeach
</ul>
<?php
Session::remove('success');
Session::remove('error');
?>