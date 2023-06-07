@extends('layout')

@section('content')
<br/><br/><br/>
<center>
    <h1 class="display-1">Users Records</h1><p class="lead">This is a simple intro for the RSB Hands-on.</p><hr/><br/><br/>

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
            <th>Full Name</th>
            <th>Email</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($allUsers as $user)
        <tr class="mx-md-n5">
            <td>{{$user->name ?? 0}}</td>
            <td>{{$user->email ?? 0}}</td>
            <td>{{$user->created_at ?? 0}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
