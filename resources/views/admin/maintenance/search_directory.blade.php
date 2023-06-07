@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6" style="display: flex; align-items: center;">
            <h1 class="text-gray-800">Search Directories</h1>
            <button type="button" class="btn-orange rounded p-2 m-3" data-bs-toggle="modal" data-bs-target="#modalDirectory">
                Add new
            </button>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ env('APP_URL') }}admin/maintenance/directory">Directories</a></li>
            <li class="breadcrumb-item active">Search Directories</li>
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
        <span class="card-title h6 font-weight-bold text-primary">Search Directories</span>
      </div>
      <div class="card-body table-responsive">
        <form action="javascript:void(0);" id="search_directory_by_last_name_form" onsubmit="searchDirectories()">
        @csrf
          <div class="input-group">
            <input type="text" name="directory_last_name_search" id="directory_last_name_search" class="form-control bg-light border-0 small" placeholder="Enter Last Name" aria-label="Search" aria-describedby="basic-addon2" value="{{ $query_input }}">
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit" id="search_directories"><i class="fas fa-search fa-sm"></i></button>
            </div>
          <div>
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
              <span class="card-title h6 font-weight-bold text-primary">Search Results Table</span>
            </div>
            <div class="card-body table-responsive">
              @if(count($directory_paginator) === 0)
              <center>
              <p class="d-flex justify-content-center text-danger">No results were found for your query!</p>
              </center>
              @endif
              <table class="table table-hover mt-3 no-footer">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col"></th>
                      <th scope="col"><i class="bi bi-arrow-up"></i>Directory Type</th>
                      <th scope="col"><i class="bi bi-arrow-up"></i>Full Name</th>
                      <th scope="col"><i class="bi bi-arrow-up"></i>1st Contact No. (Mobile)</th>
                      <th scope="col"><i class="bi bi-arrow-up"></i>2nd Contact No. (Mobile)</th>
                      <th scope="col"><i class="bi bi-arrow-up"></i>Email</th>
                      <th scope="col"><i class="bi bi-arrow-up"></i>Facebook</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($directory_paginator) === 0)
                    <tr>
                        <td></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    @else
                    @foreach($directory_paginator as $directory_details)
                    <tr>
                      <td>
                          <a href="{{ env('APP_URL') }}admin/maintenance/directory/edit-created-directory/{{ $directory_details->id }}" class="text-orange-icon"><i class="fa fa-edit"></i></a>
                          <a href="javascript:viod(0)" class="text-orange-icon" onclick="deleteDirectoryModal({{ $directory_details->id }})"><i class="fa fa-trash"></i></a>
                      </td>
                      <td>{{$directory_details->dir_directory_type ?? '-'}}</td>
                      <td>{{$directory_details->dir_first_name}} {{$directory_details->dir_last_name}}</td>
                      <td>{{$directory_details->dir_contact_no_1 ?? '-'}}</td>
                      <td>{{$directory_details->dir_contact_no_2 ?? '-'}}</td>
                      <td>{{$directory_details->dir_email ?? '-'}}</td>
                      <td>{{$directory_details->dir_facebook ?? '-'}}</td>
                    </tr>
                    @endforeach
                    @endif
                  </tbody>
              </table>
            </div>
            @if(count($directory_paginator) != 0)
              {{ $directory_paginator->links() }}
            @endif
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

<!--  Start of modal Directory Type  -->

<div class="modal fade" id="modalDirectory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" style="width:100%;">
    <form class="modal-content" method="POST" id="modalDirectoryForm" action="javascript:void(0);" onsubmit="submitForm()">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Add Directories</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-sm-3">First Name<span class="asterisk">*</span></div>
          <div class="col-sm-9 text-secondary">
            <div class="input-group mb-3">
              <input class="form-control" name="dir_first_name" type="text" required />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3">Middle Name<span class="asterisk">*</span></div>
          <div class="col-sm-9 text-secondary">
            <div class="input-group mb-3">
              <input class="form-control" name="dir_middle_name" type="text" required />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3">Last Name<span class="asterisk">*</span></div>
          <div class="col-sm-9 text-secondary">
            <div class="input-group mb-3">
              <input class="form-control" name="dir_last_name" type="text" required />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3">Position/Designation<span class="asterisk">*</span></div>
          <div class="col-sm-9 text-secondary">
            <div class="input-group mb-3">
              <input class="form-control" name="dir_post_desi" type="text" required />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3">Directory Type<span class="asterisk">*</span></div>
          <div class="col-sm-9 text-secondary">
            <div class="input-group mb-3">
              <div class="col-xs-2">
                <select class="form-control" style="width:auto" name="dir_directory_type" required>
                  <option value="">Select Directory</option>
                  @foreach($directory_type as $directory_name)
                  <option value="{{ $directory_name->name }}">{{ $directory_name->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3">1st Contact No. (Mobile)<span class="asterisk">*</span></div>
          <div class="col-sm-9 text-secondary">
            <div class="input-group mb-3">
              <input class="form-control" name="dir_contact_no_1" type="text" required />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3">2nd Contact No. (Mobile)</div>
          <div class="col-sm-9 text-secondary">
            <div class="input-group mb-3">
              <input class="form-control" name="dir_contact_no_2" type="text"/>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3">3rd Contact No. (Landline)</div>
          <div class="col-sm-9 text-secondary">
            <div class="input-group mb-3">
              <input class="form-control" name="dir_contact_no_3" type="text"/>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3">Email<span class="asterisk">*</span></div>
          <div class="col-sm-9 text-secondary">
            <div class="input-group mb-3">
              <input class="form-control" name="dir_email" type="email" required />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3">Facebook</div>
          <div class="col-sm-9 text-secondary">
            <div class="input-group mb-3">
              <input class="form-control" name="dir_facebook" type="text"/>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-orange rounded">Save Changes</button>
      </div>  
      <center id="error-form">
        {{-- Result portion for Errors on Form --}}
      </center>
    </form>
  </div>
</div>

<!--  End of modal Directory Type  -->

<!-- Start of Javascript -->

<!-- Start of delete User Sweet Alert modal -->

<script>
    function deleteDirectoryModal($id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: '{{ env('APP_URL') }}api/v1/directory/delete/' + $id,
                    data: {
                        _method: 'delete',
                    },
                    success: function(response) {

                        if (response === 'The Directory details was successfully deleted'){
                            Swal.fire('Deleted!', 'The Directory details was successfully deleted.', 'success');
                            location.reload();
                        }else{
                            Swal.fire('The Directory details was not deleted!', '', 'error');
                        }
                    }
                });

            }else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });
    }
</script>

<!-- End of delete User Sweet Alert modal  -->

<!-- Start of submit form using Sweet Alert -->

<script>
function submitForm(){

    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: '{{ env('APP_URL') }}api/v1/directory/add',
                data: $("#modalDirectoryForm").serialize(),
                success: function(response) {

                    if (response === 'The Directory details was successfully added'){
                        Swal.fire('Saved!', 'The Directory details was successfully added.', 'success');
                        location.reload();
                    }else{
                        Swal.fire('The Directory details was not added!', '', 'error');

                        html = "";
                        $.each(response, function( index, value ) {
                            html += '<p class="d-flex justify-content-center text-danger">'+ value +'</p>';
                        });
                        html += '<hr>';

                        $('#error-form').empty().prepend(html);
                    }
                }
            });
        } else if (result.isDenied) {

            Swal.fire('Changes are not saved', '', 'info')
        }
    });

}
</script>

<!-- End of submit form using Sweet Alert -->

<!-- End of Javascript -->

@endsection
