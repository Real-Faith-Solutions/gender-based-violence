@extends('layout')

@section('content')
<br/><br/><br/>
<div class="jumbotron">
    <center>
        <h1 class="display-1">Restricted!</h1>
        <p class="lead">Sorry this page is restricted from {{ Auth::user()->role }} account.</p>
        <hr class="my-4">
    </center>
</div>
@endsection