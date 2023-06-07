@extends('layout')

@section('content')
<br/><br/><br/>
<center>
    <h1 class="display-1">CSV-Uploader.</h1>
    <p class="lead">This is a simple intro for the RSB Hands-on.</p>
    <hr class="my-4"><br/>

    <form method="post" action="csv-upload" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <p>CSV File Here</p>
            <input type="file" name="file" class="form-control" accept=".csv" placeholder="Choose File..."/>
        </div>
        <br/><br/>
        <button type="submit" class="btn btn-primary btn-lg">UPLOAD CSV NOW</button>
    </form>
</center>
@endsection
