@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="text-gray-800">Payment Info</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Record</a></li>
            <li class="breadcrumb-item active">Payment Info</li>
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
                <span class="card-title h6 font-weight-bold text-primary">Payment Info table</span>
                <!--<button class="btn btn-success btn-xs" style="margin-left: 77%" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Add</button>-->
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="example1" class="table table-borderless table-striped table-sm" style="border-radius: 3px; overflow: hidden;">
                <thead class="thead-dark">
                <tr>
                    <th>Payment No.</th>
                    <th>Member Name</th>
                    <th>SOA No.</th>
                    <th>Date</th>
                    <th>Amount Paid</th>
                    <th>Balance</th>
                    <th>Payment Status</th>
                    <th width="auto"></th>
                </tr>
                </thead>
                <tbody class="font-weight-light">
                @foreach($payment as $recipient)
                    <tr class="mx-md-n5">
                    <td>{{$recipient->payment_no ?? 0}}</td>
                    <td>{{$recipient->member_name ?? 0}}</td>
                    <td>{{$recipient->soa_no ?? 0}}</td>
                    <td>{{$recipient->date ?? ''}}</td>
                    <td>{{$recipient->amount_paid ?? ''}}</td>
                    <td>{{$recipient->balance ?? ''}}</td>
                    <td>{{$recipient->payment_status ?? 0}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Payment No.</th>
                    <th>Member Name</th>
                    <th>SOA No.</th>
                    <th>Date</th>
                    <th>Amount Paid</th>
                    <th>Balance</th>
                    <th>Payment Status</th>
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
