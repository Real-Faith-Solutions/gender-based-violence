<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href={{ asset('images/gbv_logo_1.png') }} />
    <title>GBV Management</title>

    <!-- Google Font: Source Sans Pro -->
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Font Awesome -->

    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini">
    @include('admin.modal_forms')
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #323450;">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center my-3" href="#">
                <span>GENDER BASED VIOLENCE - IMS</span>
            </a>

            @if(str_contains(App\Models\UserRole::pluck('page_access','role_name')[Auth::user()->role], "Dashboard")  == true)
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ env('APP_URL') }}admin/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider">

            @if(str_contains(App\Models\UserRole::pluck('page_access','role_name')[Auth::user()->role], "Rights Management")  == true)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFunding" aria-expanded="true" aria-controls="collapseFunding">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Rights Management</span>
                </a>
                <div id="collapseFunding" class="collapse" aria-labelledby="headingFunding"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ env('APP_URL') }}admin/rights-management/user">Users</a>
                        <a class="collapse-item" href="{{ env('APP_URL') }}admin/rights-management/user-role">Roles</a>

                        <div class="collapse-divider"></div>
                    </div>
                </div>
            </li>
            @endif

            @if(str_contains(App\Models\UserRole::pluck('page_access','role_name')[Auth::user()->role], "Master List")  == true)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Case Folder</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ env('APP_URL') }}admin/case-folder/master-list">Master List</a>
                    </div>
                </div>
            </li>
            @endif

            @if(str_contains(App\Models\UserRole::pluck('page_access','role_name')[Auth::user()->role], "Reports")  == true)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseReports">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Reports</span>
                </a>
                <div id="collapseReports" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" style="white-space: pre-wrap;" href="{{ env('APP_URL') }}admin/report/list-of-cases-per-status-report">List of Cases per Status Report</a>
                        <a class="collapse-item" style="white-space: pre-wrap;" href="{{ env('APP_URL') }}admin/report/list-of-perpetrator-relationship-to-victim">List of Perpetrator Relationship to Victim</a>
                        <a class="collapse-item" style="white-space: pre-wrap;" href="{{ env('APP_URL') }}admin/report/list-of-gbv-cases-per-month">List of GBV Cases Per Month</a>
                        <a class="collapse-item" style="white-space: pre-wrap;" href="{{ env('APP_URL') }}admin/report/list-of-gbv-cases-per-municipality">List of GBV Cases per Municipality</a>
                        <a class="collapse-item" style="white-space: pre-wrap;" href="{{ env('APP_URL') }}admin/report/list-of-gbv-cases-per-province">List of GBV Cases per Province</a>
                        <a class="collapse-item" style="white-space: pre-wrap;" href="{{ env('APP_URL') }}admin/report/list-of-gbv-cases-per-form-of-violence">List of GBV Cases per form of Violence</a>
                    </div>
                </div>
            </li>
            @endif

            @if(str_contains(App\Models\UserRole::pluck('page_access','role_name')[Auth::user()->role], "Rights Management")  == true)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaintenance" aria-expanded="true" aria-controls="collapseMaintenance">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Maintenance</span>
                </a>
                <div id="collapseMaintenance" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ env('APP_URL') }}admin/maintenance/directory-type">Directory Types</a>
                        <a class="collapse-item" href="{{ env('APP_URL') }}admin/maintenance/directory">Directories</a>
                        <a class="collapse-item" href="{{ env('APP_URL') }}admin/maintenance/relationship-to-victim-survivor">Relationship to Victim</a>
                        <a class="collapse-item" href="{{ env('APP_URL') }}admin/maintenance/place-of-incidence">Place of Incidence</a>
                        <a class="collapse-item" href="{{ env('APP_URL') }}admin/maintenance/religions">Religions</a>
                    </div>
                </div>
            </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="col">
                                    <div class="row-md">
                                        <span class="mr-2 d-none d-lg-inline text-gray-800 medium">{{ Auth::user()->user_first_name.' '.Auth::user()->user_last_name }}</span>
                                    </div>
                                    <div class="row-sm">
                                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->role  }}
                                            @if(Auth::user()->role == 'Service Provider')
                                            <span class="mr-2 d-none d-lg-inline text-primary font-italic small">({{ Auth::user()->user_service_provider  }})</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <!-- <img class="img-profile rounded-circle" src="https://icons-for-free.com/download-icon-business+costume+male+man+office+user+icon-1320196264882354682_512.png"> -->
                                <img class="img-profile rounded-circle" src="{{ asset('profile/default_profile_photo.png') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ env('APP_URL') }}admin/profile"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ env('APP_URL') }}logout"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout</a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid p-3">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

                <footer class="main-footer p-3 d-flex justify-content-center">
                    <p class="text-center"><strong><a href="{{ env('APP_URL') }}">GBV Management System</a>.</strong> All rights reserved. Developed By <strong style="color: #000;">Real Faith Solutions.</strong></p>
                </footer>
            </div>
        </div>
        <!-- ./wrapper -->


    <!-- Third party script resources -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js" type="text/javascript" ></script>
    <!-- <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" type="text/javascript"></script> -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <!-- <script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js" type="text/javascript"></script> -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
    <!-- <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js" type="text/javascript"></script> -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- Third party script resources save to the server -->
    <!-- jQuery -->
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <!-- Ph Location drop-down list script -->
    <script src="{{ asset('js/jquery.ph-locations-v1.0.0.js') }}" type="text/javascript" ></script>

    <!-- Page level custom scripts -->
    <!--<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>-->

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script>changeRootURL('{{ env('APP_URL') }}');</script>
    <!-- Case Script -->
    <script src="{{ asset('js/case-scripts.js') }}"></script>

    <script>

        $(document).ready(function() {

            $('#generalTable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        @if(str_contains(Request::url(), 'master-list') == true)
                        
                        title: 'GBV Master List',
                        @elseif(str_contains(Request::url(), 'list-of-cases-per-status-report') == true)
                        
                        title: 'List of Cases per Status Report',
                        @elseif(str_contains(Request::url(), 'list-of-perpetrator-relationship-to-victim') == true)
                        
                        title: 'List of Perpetrator Relationship to Victim',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-month') == true)
                        
                        title: 'List of GBV Cases Per Month',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-municipality') == true)
                        
                        title: 'List of GBV Cases per Municipality',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-province') == true)
                        
                        title: 'List of GBV Cases per Province',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-form-of-violence') == true)
                        
                        title: 'List of GBV Cases per form of Violence',
                        @endif

                        attr:  {
                            title: 'Copy',
                            id: 'copyButton',
                            class: 'btn btn-orange'
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        @if(str_contains(Request::url(), 'master-list') == true)
                        
                        title: 'GBV Master List',
                        @elseif(str_contains(Request::url(), 'list-of-cases-per-status-report') == true)
                        
                        title: 'List of Cases per Status Report',
                        @elseif(str_contains(Request::url(), 'list-of-perpetrator-relationship-to-victim') == true)
                        
                        title: 'List of Perpetrator Relationship to Victim',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-month') == true)
                        
                        title: 'List of GBV Cases Per Month',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-municipality') == true)
                        
                        title: 'List of GBV Cases per Municipality',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-province') == true)
                        
                        title: 'List of GBV Cases per Province',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-form-of-violence') == true)
                        
                        title: 'List of GBV Cases per form of Violence',
                        @endif

                        attr:  {
                            title: 'Excel',
                            id: 'button',
                            class: 'btn btn-orange'
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        @if(str_contains(Request::url(), 'master-list') == true)
                        
                        title: 'GBV Master List',
                        @elseif(str_contains(Request::url(), 'list-of-cases-per-status-report') == true)
                        
                        title: 'List of Cases per Status Report',
                        @elseif(str_contains(Request::url(), 'list-of-perpetrator-relationship-to-victim') == true)
                        
                        title: 'List of Perpetrator Relationship to Victim',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-month') == true)
                        
                        title: 'List of GBV Cases Per Month',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-municipality') == true)
                        
                        title: 'List of GBV Cases per Municipality',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-province') == true)
                        
                        title: 'List of GBV Cases per Province',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-form-of-violence') == true)
                        
                        title: 'List of GBV Cases per form of Violence',
                        @endif

                        attr:  {
                            title: 'CSV',
                            id: 'button',
                            class: 'btn btn-orange'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        @if(str_contains(Request::url(), 'master-list') == true)

                        title: 'GBV Master List',
                        orientation : 'landscape',
                        pageSize : 'LEGAL',
                        exportOptions: {
                            columns: [ 1,2,3,5.18,19,21,23,25,29,30,32,33 ]
                        },
                        @elseif(str_contains(Request::url(), 'list-of-cases-per-status-report') == true)
                        
                        title: 'List of Cases per Status Report',
                        @elseif(str_contains(Request::url(), 'list-of-perpetrator-relationship-to-victim') == true)
                        
                        title: 'List of Perpetrator Relationship to Victim',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-month') == true)
                        
                        title: 'List of GBV Cases Per Month',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-municipality') == true)
                        
                        title: 'List of GBV Cases per Municipality',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-province') == true)
                        
                        title: 'List of GBV Cases per Province',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-form-of-violence') == true)
                        
                        title: 'List of GBV Cases per form of Violence',
                        @endif

                        attr:  {
                            title: 'PDF',
                            id: 'button',
                            class: 'btn btn-orange'
                        }
                    },
                    {
                        extend: 'print',
                        @if(str_contains(Request::url(), 'master-list') == true)

                        title: 'GBV Master List',
                        exportOptions: {
                            columns: [ 1,2,3,5.18,19,21,23,25,29,30,32,33 ]
                        },
                        @elseif(str_contains(Request::url(), 'list-of-cases-per-status-report') == true)
                        
                        title: 'List of Cases per Status Report',
                        @elseif(str_contains(Request::url(), 'list-of-perpetrator-relationship-to-victim') == true)
                        
                        title: 'List of Perpetrator Relationship to Victim',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-month') == true)
                        
                        title: 'List of GBV Cases Per Month',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-municipality') == true)
                        
                        title: 'List of GBV Cases per Municipality',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-province') == true)
                        
                        title: 'List of GBV Cases per Province',
                        @elseif(str_contains(Request::url(), 'list-of-gbv-cases-per-form-of-violence') == true)
                        
                        title: 'List of GBV Cases per form of Violence',
                        @endif

                        attr:  {
                            title: 'PRINT',
                            id: 'button',
                            class: 'btn btn-orange'
                        }
                    }
                ],
                
                "paging": false,
                // "pageLength": 25, 
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": true,
                "responsive": true,
            } );

            $('div.dataTables_filter input').addClass('px-2 mx-2');
            $('div.dataTables_filter input').attr('placeholder', 'Keyword here...');
        });

    </script>
    
    </body>
</html>
