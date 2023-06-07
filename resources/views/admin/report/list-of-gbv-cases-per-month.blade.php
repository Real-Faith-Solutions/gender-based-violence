@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6" style="display: flex; align-items: center;">
            <h1 class="text-gray-800">List of GBV Cases Per Month</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            @if(str_contains(Request::url(), 'sort-list-of-gbv-cases-per-month') == true)
            <li class="breadcrumb-item"><a href="{{ env('APP_URL') }}admin/report/list-of-gbv-cases-per-month">List of GBV Cases Per Month</a></li>
            <li class="breadcrumb-item active">Sort Result by Date</li>
            @else
            <li class="breadcrumb-item">List of GBV Cases Per Month</li>
            @endif
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Search option -->
<section class="content-header">
  <div class="container-fluid">
    <div class="card shadow mb-3">
      <div class="card-header">
        <span class="card-title h6 font-weight-bold text-primary">Sort Result by Date</span>
      </div>
      <div class="row m-3">
            <form action="javascript:void(0);" id="search_gbv_cases_per_month_form" onsubmit="sortListOfGBVCasesPerMonth()">
                @csrf
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Date From:</span>
                  </div>
                  <input type="date" name="date_from_sort_gbv_cases_per_month" id="date_from_sort_gbv_cases_per_month" class="form-control" value="{{ (!empty($date_from_sort_gbv_cases_per_month)) ? $date_from_sort_gbv_cases_per_month : '' }}" required/>
                  <div class="input-group-prepend">
                    <span class="input-group-text">Date To:</span>
                  </div>
                  <input type="date" name="date_to_sort_gbv_cases_per_month" id="date_to_sort_gbv_cases_per_month" class="form-control" value="{{ (!empty($date_to_sort_gbv_cases_per_month)) ? $date_to_sort_gbv_cases_per_month : '' }}" required/>
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" id="search_gbv_cases_per_month"><i class="fas fa-search fa-sm"></i></button>
                  </div>
                </div>    
            </form>
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
                <span class="card-title h6 font-weight-bold text-primary">List of GBV Cases Per Month Table</span>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table class="table table-hover table-striped mt-3 no-footer" id="generalTable">
                  <thead class="thead-dark">
                      <tr>
                        <th><i class="bi bi-arrow-up"></i> Case No</th>
                        <th><i class="bi bi-arrow-up"></i> Date of Intake</th>
                        <th><i class="bi bi-arrow-up"></i> Type of GBV Cases</th>
                      </tr>
                  </thead>
                  <tbody class="font-weight-light">
                    @if(count($cases_paginator) === 0)
                        <tr>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                        </tr>
                    @else
                      @foreach($cases_paginator as $casesdetails)

                        <tr>
                          <td>{{$casesdetails->case_no ?? '-'}}</td>
                          <td>{{$casesdetails->date_of_intake ?? '-'}}</td>
                          <td>{{$casesdetails->nature_of_incidence ?? '-'}}</td>
                          {{-- Uncomment if preferred a list view 
                            <td>
                            @foreach(explode('|',$casesdetails->nature_of_incidence) as $nature_of_incidence_item)
                            @if(!empty($nature_of_incidence_item))
                            <li>{{ $nature_of_incidence_item }}</li>
                            @endif
                            @endforeach 
                            </td>
                          --}}
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
