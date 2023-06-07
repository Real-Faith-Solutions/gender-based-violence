@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6" style="display: flex; align-items: center;">
            <h1 class="text-gray-800">List of Cases per Status Report</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">List of Cases per Status Report</li>
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
                <span class="card-title h6 font-weight-bold text-primary">List of Cases per Status Report Table</span>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table class="table table-hover table-striped mt-3 no-footer" id="generalTable">
                  <thead class="thead-dark">
                      <tr>
                        <th>Case No</th>
                        <th><i class="bi bi-arrow-up"></i> Case Status</th>
                      </tr>
                  </thead>
                  <tbody class="font-weight-light">
                    @if(count($cases_paginator) === 0)
                        <tr>
                          <td>-</td>
                          <td>-</td>
                        </tr>
                    @else
                      @foreach($cases_paginator as $casesdetails)

                        <tr>
                          <td>{{$casesdetails->case_no ?? '-'}}</td>
                          <td>{{ $casesdetails->cm_case_status }}</td>
                        </tr>
                        
                      @endforeach
                    @endif  
                  </tbody>
              </table>
            </div>
            @if(count($cases_paginator) != 0)
              {{ $cases_paginator->links() }}
            @endif
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
