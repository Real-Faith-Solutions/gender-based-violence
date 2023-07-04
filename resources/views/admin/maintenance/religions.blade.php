@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6" style="display: flex; align-items: center;">
            <h1 class="text-gray-800">Religions</h1>
            <button type="button" class="btn-orange rounded p-2 m-3" data-bs-toggle="modal" data-bs-target="#modalReligions">
                Add new
            </button>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ env('APP_URL') }}admin/maintenance/directory">Directories</a></li>
            <li class="breadcrumb-item active">Religions</li>
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
              <span class="card-title h6 font-weight-bold text-primary">Religions Table</span>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover mt-3 no-footer">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col"></th>
                        <th scope="col">Items</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($religions as $item)
                            <tr>
                                <td>
                                    <a href="javascript:void(0);" class="text-orange-icon" data-bs-toggle="modal" data-bs-target="#modalReligionsEdit" onclick="editReligion('{{$item->item_name}}',{{$item->id}})"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0);" class="text-orange-icon" onclick="deleteReligion({{$item->id}})"><i class="fa fa-trash"></i></a>
                                </td>
                                <td>{{$item->item_name ? : '-'}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

<!--  Start of modal Religion -->

<div class="modal fade" id="modalReligions" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <form class="modal-dialog modal-md" method="POST" id="modalReligionsForm" action="javascript:void(0);" onsubmit="submitForm()">
    @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Add Religions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height:10px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-3 mb-0">Item Name</div>
            <div class="col-sm-9 text-secondary">
                <div class="input-group">
                    <input class="form-control" type="text" name="item_name" required />
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-orange rounded">Save Changes</button>
      </div>
      <center id="error-form" class="col mt-3 mb-3">
      {{-- Result portion for Errors in Form from submit form using Sweet Alert script below --}}
      </center>
    </div>
  </form>
</div>

<!--  End of modal Religion -->

<!--  Start of modal Edit Religion -->

<div class="modal fade" id="modalReligionsEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <form class="modal-dialog modal-md" method="POST" id="modalReligionsEditForm" action="javascript:void(0);" onsubmit="submitEditForm()">
    @method('put')
    @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Edit Religions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-3 mb-0">Item Name</div>
            <div class="col-sm-9 text-secondary">
                <div class="input-group">
                    <input class="form-control" type="text" name="item_name" id="edit_item_name" required />
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-orange rounded" id="edit_save_button">Save Changes</button>
      </div>
      <center id="edit-error-form" class="col mt-3 mb-3">
      {{-- Result portion for Errors in Form from submit form using Sweet Alert script below --}}
      </center>
    </div>
  </form>
</div>

<!--  End of modal Edit Religion -->

<!-- Start of Javascript -->

<!-- Start Auto changed Item Input box and edit submit onlick value -->

<script>
function editReligion($item, $id){

  $('#edit_item_name').val($item);
  $('#modalReligionsEditForm').attr('onsubmit', 'submitEditForm('+$id+')');

}
</script>

<!-- End Auto changed Item Input box and edit submit onlick value -->

<!-- Start of Submit Form using Sweet Alert -->

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
              url: '{{ env('APP_URL') }}api/v1/religions/add',
              data: $("#modalReligionsForm").serialize(),
              success: function(response) {

                  if (response === 'The Religion name was successfully added'){
                      Swal.fire('Saved!', '<center>The Religion name was successfully added</center>', 'success');
                      location.assign('{{ env('APP_URL') }}admin/maintenance/religions');
                  }else{
                      Swal.fire('<center>The Religion name was not added!</center>', '', 'error');

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

<!-- End of Submit Form using Sweet Alert -->

<!-- Start of Submit Edit Form using Sweet Alert -->

<script>
function submitEditForm($id){

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
              url: '{{ env('APP_URL') }}api/v1/religions/update/'+$id,
              data: $("#modalReligionsEditForm").serialize(),
              success: function(response) {

                  if (response === 'The Religion name was successfully modified'){
                      Swal.fire('Saved!', '<center>The Religion name was successfully modified</center>', 'success');
                      location.assign('{{ env('APP_URL') }}admin/maintenance/religions');
                  }else{
                      Swal.fire('<center>The Religion name was not modified!</center>', '', 'error');

                      html = "";
                      $.each(response, function( index, value ) {
                          html += '<p class="d-flex justify-content-center text-danger">'+ value +'</p>';
                      });
                      html += '<hr>';

                      $('#edit-error-form').empty().prepend(html);
                  }
              }
          });
      } else if (result.isDenied) {

          Swal.fire('Changes are not saved', '', 'info')
      }
  });

}
</script>

<!-- End of Submit Edit Form using Sweet Alert -->

<!-- Start of delete using Sweet Alert modal -->

<script>
    function deleteReligion($id){
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
                    url: '{{ env('APP_URL') }}api/v1/religions/delete/'+$id,
                    data: {
                        _method: 'delete',
                    },
                    success: function(response) {

                        if (response === 'The Religion name was successfully deleted'){
                            Swal.fire('Deleted!', '<center>The Religion name was successfully deleted.</center>', 'success');
                            location.reload();
                        }else{
                            Swal.fire('The Religion name was not deleted!', '', 'error');
                        }
                    }
                });

            }else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });
    }
</script>

<!-- End of delete using Sweet Alert modal  -->

<!-- End of Javascript -->

@endsection
