@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6" style="display: flex; align-items: center;">
            <h1 class="text-gray-800">List of GBV Cases per form of Violence</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">List of GBV Cases per form of Violence</li>
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
                <span class="card-title h6 font-weight-bold text-primary">List of GBV Cases per form of Violence Table</span>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table class="table table-hover table-striped mt-3 no-footer" id="generalTable">
                  <thead class="thead-dark">
                      <tr>
                        <th><i class="bi bi-arrow-up"></i> Type of Violence</th>
                        <th><i class="bi bi-arrow-up"></i> Total Cases</th>
                      </tr>
                  </thead>
                  <tbody class="font-weight-light">
                    @if(($intimate_partner_violence + $rape + $trafficking_in_person + $sexual_harassment + $child_abuse_exploitation_and_discrimination) === 0)
                        <tr>
                          <td>-</td>
                          <td>-</td>
                        </tr>
                    @else
                        <tr>
                          <td>Intimate partner violence</td>
                          <td>{{ $intimate_partner_violence }}</td>
                        </tr>
                        <tr>
                          <td>Rape</td>
                          <td>{{ $rape }}</td>
                        </tr>
                        <tr>
                          <td>Trafficking in Person</td>
                          <td>{{ $trafficking_in_person }}</td>
                        </tr>
                        <tr>
                          <td>Sexual Harassment</td>
                          <td>{{ $sexual_harassment }}</td>
                        </tr>
                        <tr>
                          <td>Child Abuse, Exploitation and Discrimination</td>
                          <td>{{ $child_abuse_exploitation_and_discrimination }}</td>
                        </tr>
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
