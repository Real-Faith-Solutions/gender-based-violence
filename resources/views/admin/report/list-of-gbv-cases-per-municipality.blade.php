@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6" style="display: flex; align-items: center;">
            <h1 class="text-gray-800">List of GBV Cases per Municipality</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">List of GBV Cases per Municipality</li>
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
                <span class="card-title h6 font-weight-bold text-primary">List of GBV Cases per Municipality Table</span>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table class="table table-hover table-striped mt-3 no-footer" id="generalTable">
                  <thead class="thead-dark">
                      <tr>
                        <th><i class="bi bi-arrow-up"></i> Province</th>
                        <th><i class="bi bi-arrow-up"></i> Municipality</th>
                        <th><i class="bi bi-arrow-up"></i> Total Cases</th>
                      </tr>
                  </thead>
                  <tbody class="font-weight-light">
                    @if(count($extracted_municipality_per_province) === 0)
                        <tr>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                        </tr>
                    @else
                      @foreach($extracted_municipality_per_province as $municipality_per_province_item)

                        <tr>
                          <td>{{$municipality_per_province_item->province ?? '-'}}</td>
                          <td>{{$municipality_per_province_item->city ?? '-'}}</td>
                          @if(str_contains(Auth::user()->role, "Service Provider") == true)
                          @if(App\Http\Controllers\ProfileController::userScopingStatus() === 'National Level')

                          <td>{{ App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('province','=',$municipality_per_province_item->province)->where('city','=',$municipality_per_province_item->city)->count() }}</td>
                          @elseif(App\Http\Controllers\ProfileController::userScopingStatus() === 'Regional Level')

                          <td>{{ App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',$municipality_per_province_item->province)->where('city','=',$municipality_per_province_item->city)->count() }}</td>
                          @elseif(App\Http\Controllers\ProfileController::userScopingStatus() === 'Provincial Level')

                          <td>{{ App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',$municipality_per_province_item->province)->where('city','=',$municipality_per_province_item->city)->count() }}</td>
                          @elseif(App\Http\Controllers\ProfileController::userScopingStatus() === 'Municipal Level')

                          <td>{{ App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',$municipality_per_province_item->province)->where('city','=',$municipality_per_province_item->city)->count() }}</td>
                          @elseif(App\Http\Controllers\ProfileController::userScopingStatus() === 'Barangay Level')

                          <td>{{ App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('barangay','=',Auth::user()->user_barangay)->where('province','=',$municipality_per_province_item->province)->where('city','=',$municipality_per_province_item->city)->count() }}</td>
                          @endif
                          @else
                          @if(App\Http\Controllers\ProfileController::userScopingStatus() === 'National Level')

                          <td>{{ App\Models\Cases::where('province','=',$municipality_per_province_item->province)->where('city','=',$municipality_per_province_item->city)->count() }}</td>
                          @elseif(App\Http\Controllers\ProfileController::userScopingStatus() === 'Regional Level')

                          <td>{{ App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',$municipality_per_province_item->province)->where('city','=',$municipality_per_province_item->city)->count() }}</td>
                          @elseif(App\Http\Controllers\ProfileController::userScopingStatus() === 'Provincial Level')

                          <td>{{ App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',$municipality_per_province_item->province)->where('city','=',$municipality_per_province_item->city)->count() }}</td>
                          @elseif(App\Http\Controllers\ProfileController::userScopingStatus() === 'Municipal Level')

                          <td>{{ App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',$municipality_per_province_item->province)->where('city','=',$municipality_per_province_item->city)->count() }}</td>
                          @elseif(App\Http\Controllers\ProfileController::userScopingStatus() === 'Barangay Level')

                          <td>{{ App\Models\Cases::where('region','=',Auth::user()->user_region)->where('barangay','=',Auth::user()->user_barangay)->where('province','=',$municipality_per_province_item->province)->where('city','=',$municipality_per_province_item->city)->count() }}</td>
                          @endif
                          @endif
                        </tr>
                        
                      @endforeach
                    @endif  
                  </tbody>
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
