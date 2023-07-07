@extends('layout')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="fs-4 fw-bold me-2">Dashboard</h1>
    </div>


    <div class="card p-4 shadow-lg mb-3">
        <div class="row">
            <div class="col-md">
                <div class="box1 p-2 rounded mb-3">
                    <h6>Total Cases Received</h6>
                    <h3>{{ $count_cases }}</h3>
                </div>
            </div>

            <div class="col-md">
                <div class="box2 p-2 rounded mb-3">
                    <h6>Total GBV Cases - Ongoing</h6>
                    <h3>{{ $count_ongoing_cases }}</h3>
                </div>
            </div>

            <div class="col-md">
                <div class="box3 p-2 rounded mb-3">
                    <h6>Total GBV Cases - Completed/Closed</h6>
                    <h3>{{ $count_completed_and_closed_cases }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4 shadow-lg mb-3">
        <div class="row justify-content-center mb-4">
            <h6>Total GBV Cases Reporting per Province @if(!empty($region_name_for_sort_province)) for <span class="text-danger">{{ $region_name_for_sort_province }}</span> @endif</h6>
        </div>
        <div class="row justify-content-center">
            <form action="" id="search_province_by_date_and_region">
                @csrf
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Date From:</span>
                    </div>
                    <input type="date" name="date_from_sort_province" class="form-control" value="{{ (!empty($date_from_sort_province)) ? $date_from_sort_province : '' }}" required/>

                    <div class="input-group-prepend">
                        <span class="input-group-text">Date To:</span>
                    </div>
                    <input type="date" name="date_to_sort_province" class="form-control" value="{{ (!empty($date_to_sort_province)) ? $date_to_sort_province : '' }}" required/>

                    <div class="input-group-prepend">
                        <span class="input-group-text">Region:</span>
                    </div>
                    <select class="form-control" name="region_name_for_sort_province" id="region_name_for_sort_province" required>
                        <option value="">Select</option>
                        @foreach($regions as $region)
                        <option value="{{ $region->region }}" {{ ($region_name_for_sort_province == $region->region) ? 'selected' : '' }}>{{ $region->region }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" id="search_province"><i class="fas fa-search fa-sm"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row justify-content-center">
            <canvas id="provinceChart" style="width:100%; max-width:800px;">{{-- PROVINCE BARCHART --}}</canvas>
            <script>
            @if(str_contains(Auth::user()->role, "Service Provider") == true)
                @if(!empty($date_from_sort_province) && !empty($date_to_sort_province) && !empty($region_name_for_sort_province))

                var xValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{ $extracted_province->province }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @endif
                @else

                var xValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{ $extracted_province->province }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('city','=',Auth::user()->user_municipality)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @endif
                @endif
            @else
                @if(!empty($date_from_sort_province) && !empty($date_to_sort_province) && !empty($region_name_for_sort_province))

                var xValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{ $extracted_province->province }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @endif
                @else

                var xValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{ $extracted_province->province }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('city','=',Auth::user()->user_municipality)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_province_from_sorted_list_of_province as $extracted_province) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('province','=',$extracted_province->province)->count() }}", @endforeach];
                @endif
                @endif
            @endif

                var barColors = '#92a8d1';
                new Chart("provinceChart", {
                    type: "bar",
                    data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                    }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: ""
                        },
                        scales: {
                        xAxes: [{ticks: {min: 10, max: yValues}}]
                        }
                    }
                });

            </script>
        </div>
    </div>
    <div class="card p-4 shadow-lg mb-3">
        <div class="row justify-content-center mb-4">
            <h6>Total GBV Cases Reporting per Municipality @if(!empty($province_name_for_sort_municipality)) for <span class="text-danger">{{ $province_name_for_sort_municipality }}</span> @endif</h6>
        </div>
        <div class="row justify-content-center">
            <form action="" id="search_municipality_by_date_and_province">
                @csrf
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Date From:</span>
                    </div>
                    <input type="date" name="date_from_sort_municipality" class="form-control" value="{{ (!empty($date_from_sort_municipality)) ? $date_from_sort_municipality : '' }}" required/>

                    <div class="input-group-prepend">
                        <span class="input-group-text">Date To:</span>
                    </div>
                    <input type="date" name="date_to_sort_municipality" class="form-control" value="{{ (!empty($date_to_sort_municipality)) ? $date_to_sort_municipality : '' }}" required/>

                    <div class="input-group-prepend">
                        <span class="input-group-text">Province:</span>
                    </div>
                    <select class="form-control" name="province_name_for_sort_municipality" id="province_name_for_sort_municipality" required>
                        <option value="case-no">Select</option>
                        @foreach($provinces as $province)
                        <option value="{{ $province->province }}" {{ ($province_name_for_sort_municipality == $province->province) ? 'selected' : '' }}>{{ $province->province }}</option>
                        @endforeach
                    </select>

                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" id="search_municipality"><i class="fas fa-search fa-sm"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row justify-content-center">
            <canvas id="municipalityChart" style="width:100%; max-width:800px;">{{-- MUNICIPALITY BARCHART --}}</canvas>
            <script>
            @if(str_contains(Auth::user()->role, "Service Provider") == true)
                @if(!empty($date_from_sort_municipality) && !empty($date_to_sort_municipality) && !empty($province_name_for_sort_municipality))

                var xValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{ $extracted_municipality->city }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @endif
                @else

                var xValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{ $extracted_municipality->city }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('barangay','=',Auth::user()->user_barangay)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @endif
                @endif
            @else
                @if(!empty($date_from_sort_municipality) && !empty($date_to_sort_municipality) && !empty($province_name_for_sort_municipality))

                var xValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{ $extracted_municipality->city }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @endif
                @else

                var xValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{ $extracted_municipality->city }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_municipality_from_sorted_list_of_municipality as $extracted_municipality) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('barangay','=',Auth::user()->user_barangay)->where('city','=',$extracted_municipality->city)->count() }}", @endforeach];
                @endif
                @endif
            @endif

                var barColors = '#92a8d1';
                new Chart("municipalityChart", {
                type: "bar",
                data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
                },
                options: {
                    legend: {display: false},
                    title: {
                    display: true,
                    text: ""
                    },
                    scales: {
                    xAxes: [{ticks: {min: 10, max: yValues}}]
                    }
                }
                });
            </script>
        </div>
    </div>
    <div class="card p-4 shadow-lg mb-3">
        <div class="row justify-content-center mb-4">
            <h6>Total GBV Cases Reporting per Barangay @if(!empty($city_name_for_sort_barangay)) for <span class="text-danger">{{ $city_name_for_sort_barangay }}</span> @endif</h6>
        </div>
        <div class="row justify-content-center">
            <form action="" id="search_barangay_by_date_and_province">
                @csrf
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Date From:</span>
                    </div>
                    <input type="date" name="date_from_sort_barangay" class="form-control" value="{{ (!empty($date_from_sort_barangay)) ? $date_from_sort_barangay : '' }}" required/>

                    <div class="input-group-prepend">
                        <span class="input-group-text">Date To:</span>
                    </div>
                    <input type="date" name="date_to_sort_barangay" class="form-control" value="{{ (!empty($date_to_sort_barangay)) ? $date_to_sort_barangay : '' }}" required/>

                    <div class="input-group-prepend">
                        <span class="input-group-text">City:</span>
                    </div>
                    <select class="form-control" name="city_name_for_sort_barangay" id="city_name_for_sort_barangay" required>
                        <option value="case-no">Select</option>
                        @foreach($cities as $city)
                        <option value="{{ $city->city }}" {{ ($city_name_for_sort_barangay == $city->city) ? 'selected' : '' }}>{{ $city->city }}</option>
                        @endforeach
                    </select>

                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" id="search_barangay"><i class="fas fa-search fa-sm"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row justify-content-center">
            <canvas id="barangayChart" style="width:100%; max-width:800px;">{{-- BARANGAY BARCHART --}}</canvas>
            <script>
            @if(str_contains(Auth::user()->role, "Service Provider") == true)
                @if(!empty($date_from_sort_barangay) && !empty($date_to_sort_barangay) && !empty($city_name_for_sort_barangay))

                var xValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{ $extracted_barangay->barangay }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @endif
                @else

                var xValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{ $extracted_barangay->barangay }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @endif
                @endif
            @else
                @if(!empty($date_from_sort_barangay) && !empty($date_to_sort_barangay) && !empty($city_name_for_sort_barangay))

                var xValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{ $extracted_barangay->barangay }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @endif
                @else

                var xValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{ $extracted_barangay->barangay }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_barangay_from_sorted_list_of_barangay as $extracted_barangay) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',$extracted_barangay->barangay)->count() }}", @endforeach];
                @endif
                @endif
            @endif

                var barColors = '#92a8d1';
                new Chart("barangayChart", {
                type: "bar",
                data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
                },
                options: {
                    legend: {display: false},
                    title: {
                    display: true,
                    text: ""
                    },
                    scales: {
                    xAxes: [{ticks: {min: 10, max: yValues}}]
                    }
                }
                });
            </script>
        </div>
    </div>
    <div class="card p-4 shadow-lg mb-3">
        <div class="row justify-content-center mb-4">
            <h6>Total GBV Cases Reporting per Ethnicity @if(!empty($date_from_sort_ethnicity) && !empty($date_to_sort_ethnicity)) from <span class="text-danger">{{ $date_from_sort_ethnicity }}</span> to <span class="text-danger">{{ $date_to_sort_ethnicity }}</span>@endif</h6>
        </div>
        <div class="row justify-content-center">
            <form action="" id="search_ethnicity_by_date">
                @csrf
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Date From:</span>
                    </div>
                    <input type="date" name="date_from_sort_ethnicity" class="form-control" value="{{ (!empty($date_from_sort_ethnicity)) ? $date_from_sort_ethnicity : '' }}" required/>

                    <div class="input-group-prepend">
                        <span class="input-group-text">Date To:</span>
                    </div>
                    <input type="date" name="date_to_sort_ethnicity" class="form-control" value="{{ (!empty($date_to_sort_ethnicity)) ? $date_to_sort_ethnicity : '' }}" required/>

                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" id="search_ethnicity"><i class="fas fa-search fa-sm"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row justify-content-center">
            <canvas id="ethnicityChart" style="width:100%; max-width:800px;">{{-- ETHNICITY BARCHART --}}</canvas>
            <script>
            @if(str_contains(Auth::user()->role, "Service Provider") == true)
                @if(!empty($date_from_sort_ethnicity) && !empty($date_to_sort_ethnicity))

                var xValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{ $extracted_ethnicity->ethnicity }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @endif
                @else

                var xValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{ $extracted_ethnicity->ethnicity }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @endif
                @endif
            @else
                @if(!empty($date_from_sort_ethnicity) && !empty($date_to_sort_ethnicity))

                var xValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{ $extracted_ethnicity->ethnicity }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @endif
                @else

                var xValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{ $extracted_ethnicity->ethnicity }}", @endforeach];
                @if(App\Http\Controllers\ProfileController::userScopingStatus() == 'National Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Regional Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Provincial Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Municipal Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @elseif(App\Http\Controllers\ProfileController::userScopingStatus() == 'Barangay Level')

                var yValues = [@foreach($extracted_ethnicity_from_sorted_list_of_ethnicity as $extracted_ethnicity) "{{  App\Models\Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('ethnicity','=',$extracted_ethnicity->ethnicity)->count() }}", @endforeach];
                @endif
                @endif
            @endif

                var barColors = '#92a8d1';
                new Chart("ethnicityChart", {
                type: "bar",
                data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
                },
                options: {
                    legend: {display: false},
                    title: {
                    display: true,
                    text: ""
                    },
                    scales: {
                    xAxes: [{ticks: {min: 10, max: yValues}}]
                    }
                }
                });
            </script>
        </div>
    </div>

    <div class="card-group shadow-lg rounded mb-3">
        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>{{ $cases_data->whereIn('age', [1, 2, 3 ,4 ,5 ,6 ,7 ,8 , 9, 10, 11, 12, 13, 14])->count() ?? 0 }}</h3>
                <p>1-14 YEARS OLD</p>
                <div class="progress">
                    <div class="progress-bar bg-success fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>{{ $cases_data->whereIn('age', [15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30])->count() ?? 0 }}</h3>
                <p>15-30 YEARS OLD</p>
                <div class="progress">
                    <div class="progress-bar bg-primary fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>{{ $cases_data->whereIn('age', [31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59])->count() ?? 0 }}</h3>
                <p>31-59 YEARS OLD</p>
                <div class="progress">
                    <div class="progress-bar bg-info fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>{{ $cases_data->whereIn('age', [61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 88, 87, 88, 89, 90])->count() ?? 0 }}</h3>
                <p>60 AND ABOVE</p>
                <div class="progress">
                    <div class="progress-bar bg-danger fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-group shadow-lg rounded mb-3">
        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>{{ $cases_data->whereIn('type_of_client', ['Walk-In'])->count() ?? 0 }}</h3>
                <p>Walk-In</p>
                <div class="progress">
                    <div class="progress-bar bg-success fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>{{ $cases_data->whereIn('type_of_client', ['Referral'])->count() ?? 0 }}</h3>
                <p>Referral</p>
                <div class="progress">
                    <div class="progress-bar bg-primary fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>{{ $cases_data->whereIn('type_of_client', ['Reach out'])->count() ?? 0 }}</h3>
                <p>Reach Out</p>
                <div class="progress">
                    <div class="progress-bar bg-info fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>{{ $cases_data->whereIn('type_of_client', ['Text / Call'])->count() ?? 0 }}</h3>
                <p>Text/Call</p>
                <div class="progress">
                    <div class="progress-bar bg-danger fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>{{ $cases_data->whereIn('type_of_client', ['Online Platforms'])->count() ?? 0 }}</h3>
                <p>Online/Platform</p>
                <div class="progress">
                    <div class="progress-bar bg-primary fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4 shadow-lg mb-3">
        <div class="card-header mb-3">
            <center><span class="card-title h6">% of GBV Cases per Sex</span></center>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="box2 p-2 rounded mb-3">
                    <h6>Male</h6>
                    <h3>{{ $cases_data->whereIn('sex', ['Male'])->count() ?? 0 }}</h3>
                </div>
            </div>

            <div class="col-md">
                <div class="box3 p-2 rounded mb-3">
                    <h6>Female</h6>
                    <h3>{{ $cases_data->whereIn('sex', ['Female'])->count() ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4 shadow-lg mb-3">
        <div class="card-header mb-3">
            <center><span class="card-title h6">Total Case per Form of Violence</span></center>
        </div>
        <div class="row justify-content-center">
            <div class="card p-4">
                <div class="inner">
                    <i class="bi bi-people fs-1 float-end"></i>
                    <h3>{{ $intimate_partner_violence }}</h3>
                    <p>Intimate partner violence</p>
                    <div class="progress">
                        <div class="progress-bar bg-success fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <div class="card p-4">
                <div class="inner">
                    <i class="bi bi-people fs-1 float-end"></i>
                    <h3>{{ $rape }}</h3>
                    <p>Rape</p>
                    <div class="progress">
                        <div class="progress-bar bg-danger fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <div class="card p-4">
                <div class="inner">
                    <i class="bi bi-people fs-1 float-end"></i>
                    <h3>{{ $trafficking_in_person }}</h3>
                    <p>Trafficking in Person</p>
                    <div class="progress">
                        <div class="progress-bar bg-secondary fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <div class="card p-4">
                <div class="inner">
                    <i class="bi bi-people fs-1 float-end"></i>
                    <h3>{{ $sexual_harassment }}</h3>
                    <p>Sexual Harassment</p>
                    <div class="progress">
                        <div class="progress-bar bg-primary fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="card p-4">
                <div class="inner">
                    <i class="bi bi-people fs-1 float-end"></i>
                    <h3>{{ $child_abuse_exploitation_and_discrimination }}</h3>
                    <p>Child Abuse, Exploitation and Discrimination</p>
                    <div class="progress">
                        <div class="progress-bar bg-info fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4 shadow-lg mb-3">
        <div class="card-header mb-3">
            <center><span class="card-title h6">Total Case per Form of Intervention</span></center>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="box1 p-2 rounded mb-3">
                    <h6>Temporary Shelter</h6>
                    <h3>{{ $cases_data->whereIn('im_type_of_service', ['Temporary Shelter'])->count() ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md">
                <div class="box2 p-2 rounded mb-3">
                    <h6>Medical Services</h6>
                    <h3>{{ $cases_data->whereIn('im_type_of_service', ['Medical Services'])->count() ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md">
                <div class="box3 p-2 rounded mb-3">
                    <h6>Legal, Safety and Security</h6>
                    <h3>{{ $cases_data->whereIn('im_type_of_service', ['Legal, Safety and Security'])->count() ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md">
                <div class="box4 p-2 rounded mb-3">
                    <h6>Others</h6>
                    <h3>{{ $cases_data->whereIn('im_type_of_service', ['Others'])->count() ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4 shadow-lg mb-3">
        <div class="row justify-content-center mb-4">
            <h6>GBV Cases Reporting per Month for year <span class="text-danger">{{ (empty($year)) ? date("Y") : $year }}</span></h6>
        </div>
        <div class="row justify-content-center">
            <center>
                <form action="" id="search_user_by_last_name_form">
                    @csrf
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Select Year:</span>
                        </div>
                        <select class="form-control" name="year" id="year_select" style="width:auto" required>
                            <option value="">Select</option>
                            @foreach($extract_years_from_date_of_intake as $extracted_year)
                            <option value="{{ $extracted_year }}" {{ ($year == $extracted_year) ? 'selected' : '' }}>{{ $extracted_year }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">
                            <span class="input-group-text">or Input Year:</span>
                        </div>
                        <input class="form-control" name="year" id="year_input" value="{{ $year }}" required />
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" id="search_year"><i class="fas fa-search fa-sm"></i></button>
                        </div>
                    </div>
                </form>
            </center>
        </div>
        <div class="row justify-content-center">
            <canvas id="casemonthChart" style="width:100%; max-width:800px;">{{-- CASES PER MONTH BARCHART --}}</canvas>
            <script>
                var xValues = ["January","February","March","April","May","June","July","August","September","October","November","December", ];
                var yValues = [{{ $january }}, {{ $febuary }}, {{ $march }}, {{ $april }}, {{ $may }}, {{ $june }}, {{ $july }}, {{ $august }}, {{ $september }}, {{ $october }}, {{ $november}}, {{ $december }}];
                var barColors = '#92a8d1';
                new Chart("casemonthChart", {
                type: "bar",
                data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
                },
                options: {
                    legend: {display: false},
                    title: {
                    display: true,
                    text: ""
                    },
                    scales: {
                    xAxes: [{ticks: {min: 10, max: yValues}}]
                    }
                }
                });
            </script>
        </div>
    </div>
</div>
@endsection
