@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="text-gray-800">Analysis Request</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Record</a></li>
            <li class="breadcrumb-item active">Analysis Request</li>
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
                <span class="card-title h6 font-weight-bold text-primary">Analysis Request table</span>
                <!--<button class="btn btn-success btn-xs" style="margin-left: 77%" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Add</button>-->
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="example1" class="table table-borderless table-striped table-sm" style="border-radius: 3px; overflow: hidden;">
                <thead class="thead-dark">
                <tr>
                    <th>Test No.</th>
                    <th>Account Name</th>
                    <th>Collected by</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Last Microbial Testing</th>
                    <th>Last Change of Filter</th>
                    <th>Last Change of UV</th>
                    <th>Collection Point</th>
                    <th>Address of Collection Point</th>
                    <th>UV Light</th>
                    <th>Chlorinator</th>
                    <th>Faucet Condition after Disinfection</th>
                    <th width="auto"></th>
                </tr>
                </thead>
                <tbody class="font-weight-light">

                </tbody>
                <tfoot>
                <tr>
                    <th>Test No.</th>
                    <th>Account Name</th>
                    <th>Collected by</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Last Microbial Testing</th>
                    <th>Last Change of Filter</th>
                    <th>Last Change of UV</th>
                    <th>Collection Point</th>
                    <th>Address of Collection Point</th>
                    <th>UV Light</th>
                    <th>Chlorinator</th>
                    <th>Faucet Condition after Disinfection</th>
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
