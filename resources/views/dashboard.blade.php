@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="fs-4 fw-bold me-2">Dashboard</h1>
    </div>

    <div class="card p-4 shadow-lg mb-3">
        <div class="row">
            <div class="col-md">
                <div class="box1 p-2 rounded mb-3">
                    <h6>Total Cases Received</h6>
                    <h3>0</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md">
            <div class="card mb-3">
                <div class="card-body shadow-lg">
                    <p class="card-title">Total GBV Cases Reporting per Province</p>
                    <hr/>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Province</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="100">No record</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md">
            <div class="card mb-3">
                <div class="card-body shadow-lg">
                    <p class="card-title">Total GBV Cases Reporting per Municipality</p>
                    <hr/>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="100">No record</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md">
            <div class="card mb-3">
                <div class="card-body shadow-lg">
                    <p class="card-title">Total GBV Cases per Ehtnicity</p>
                    <hr/>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Ehtnicity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="100">No record</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4 shadow-lg mb-3">
        <div class="row">
            <div class="col-md">
                <div class="box2 p-2 rounded mb-3">
                    <h6>Total GBV Cases Received</h6>
                    <h3>0</h3>
                </div>
            </div>

            <div class="col-md">
                <div class="box3 p-2 rounded mb-3">
                    <h6>% of Case Received</h6>
                    <h3>0</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card-group shadow-lg rounded mb-3">
        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>0</h3>
                <p>1-14 YEARS OLD</p>
                <div class="progress">
                    <div class="progress-bar bg-success fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>0</h3>
                <p>15-30 YEARS OLD</p>
                <div class="progress">
                    <div class="progress-bar bg-primary fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>0</h3>
                <p>31-59 YEARS OLD</p>
                <div class="progress">
                    <div class="progress-bar bg-info fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>0</h3>
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
                <h3>0</h3>
                <p>PANTAWID PAMILYA PROGRAM</p>
                <div class="progress">
                    <div class="progress-bar bg-success fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>0</h3>
                <p>SUSTAINABLE LIVELIHOOD PROGRAM</p>
                <div class="progress">
                    <div class="progress-bar bg-primary fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>0</h3>
                <p>SOLO PARENTS</p>
                <div class="progress">
                    <div class="progress-bar bg-info fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="inner">
                <i class="bi bi-people fs-1 float-end"></i>
                <h3>0</h3>
                <p>INTERNALLY DISPPLACED</p>
                <div class="progress">
                    <div class="progress-bar bg-danger fs-small" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-sm">
            <div class="card p-3 mb-3 shadow-lg">
                Total Case per Form of Violence
                <hr />
                <p>No record</p>
            </div>

            <div class="card p-3 mb-5 shadow-lg">
                Total Case per Type of Intervention
                <hr />
                <p>
                <br/><br/><br/><br/><br/><br/>
                <br/><br/><br/><br/><br/><br/>
                </p>
            </div>
        </div>

        <div class="col-sm">
            <div class="card p-3 mb-3 shadow-lg">
                GBV Cases Reporting per Month
                <hr />
                <div class="text-center">
                    <div class="form-check form-check-inline">
                        <input disabled class="legend-danger" id="inlineCheckbox2" />
                        <label class="form-check-label" for="inlineCheckbox2">No of cases</label>
                    </div>
                    <br/><br/><br/><br/><br/><br/>
                    <br/><br/><br/><br/><br/><br/>
                </div>
            </div>

            <div class="card p-3 mb-3 shadow-lg">
                % of GBV Cases per Sex
                <hr />
                <div class="text-center">
                    <div class="form-check form-check-inline">
                        <input disabled class="legend-success" id="inlineCheckbox1" />
                        <label class="form-check-label" for="inlineCheckbox1">Male</label>
                        <input disabled class="legend-danger" id="inlineCheckbox2" />
                        <label class="form-check-label" for="inlineCheckbox2">Female</label>
                        <input disabled class="legend-info" id="inlineCheckbox3" />
                        <label class="form-check-label" for="inlineCheckbox3">Others</label>
                    </div>
                        <br/><br/><br/><br/><br/><br/>
                        <br/><br/><br/><br/><br/><br/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
