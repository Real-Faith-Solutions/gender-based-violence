@extends('layout')

@section('content')
<br/><br/><br/>
<center>
    <h1 class="display-1">Forbes Top Records</h1><p class="lead">This is a simple intro for the RSB Hands-on.</p><hr/><br/><br/>

    <form method="post" action="csv-search">
        @csrf
        <div class="row">
            <div class="form-group col-md-4" style="display: inline-block; vertical-align: middle;">
                <select class="form-control" name="type">
                    <option>Year</option>
                    <option>Rank</option>
                    <option>Recipient</option>
                    <option>Country</option>
                    <option>Career</option>
                    <option>Title</option>
                </select>
            </div>
            <div class="form-group col-md-5" style="display: inline-block;">
                <input class="form-control" type="text" name="search" placeholder="Search here..."/>
            </div>
            <button type="submit" class="btn btn-primary font-weight-light col-md-1" style="display: inline-block;">search</button>
        </div>
    </form>
</center>
<table class="table table-striped table-dark font-weight-light mx-md-n5">
    <thead class="thead-dark">
        <tr>
            <th>Record No.</th>
            <th>Year</th>
            <th>Rank</th>
            <th>Recipient</th>
            <th>Country</th>
            <th>Career</th>
            <th>Tied</th>
            <th>Title</th>
        </tr>
    </thead>
    <tbody>
        @foreach($recipients as $recipient)
        <tr class="mx-md-n5">
            <td>{{$recipient->id ?? 0}}</td>
            <td>{{$recipient->year ?? 0}}</td>
            <td>{{$recipient->rank ?? 0}}</td>
            <td>{{$recipient->recipient ?? ''}}</td>
            <td>{{$recipient->country ?? ''}}</td>
            <td>{{$recipient->career ?? ''}}</td>
            <td>{{$recipient->tied ?? 0}}</td>
            <td>{{$recipient->title ?? ''}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
