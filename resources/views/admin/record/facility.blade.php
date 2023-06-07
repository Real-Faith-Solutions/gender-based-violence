@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="text-gray-800">Facility</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Record</a></li>
            <li class="breadcrumb-item active">Facility</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card shadow">
            <div class="card-header">
                <span class="card-title h6 font-weight-bold text-primary">Facility table</span>
                <!--<button class="btn btn-success btn-xs" style="margin-left: 77%" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Add</button>-->
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="example1" class="table table-borderless table-striped table-sm" style="border-radius: 3px; overflow: hidden;">
                <thead class="thead-dark">
                <tr>
                    <th>Description</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th width="auto"></th>
                </tr>
                </thead>
                <tbody class="font-weight-light">
                @foreach($facility as $recipient)
                    <tr class="mx-md-n5">
                    <td>{{$recipient->description ?? 0}}</td>
                    <td>{{$recipient->purpose ?? 0}}</td>
                    <td>{{$recipient->status ?? 0}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Description</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th width="auto"></th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
