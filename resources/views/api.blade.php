@extends('layout.master')
@section('title', 'Api')
@section('css')
    <!-- apexcharts css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/apexcharts/apexcharts.css')}}">

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/bootstrap/bootstrap.min.css')}}">

    <!-- Data Table css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/datatable2/buttons.dataTables.min.css')}}">
@endsection
@section('main-content')
    <div class="container-fluid">

        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Api</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                        <span>
                          <i class="ph-duotone  ph-stack f-s-16"></i> Apps
                        </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Api</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>API request</h5>
                    </div>
                    <div class="card-body">
                        <div class="api-chart d-flex gap-3 justify-content-end">
                            <div class="form-check ps-0">
                                <input class="form-check-input form-check-info mg-2 w-20 h-20"
                                       id="apiCheckbox" type="checkbox"
                                       value="">
                                <label class="form-check-label ms-2" for="apiCheckbox">
                                    22k successfully
                                </label>
                            </div>
                            <div class="form-check ps-0">
                                <input class="form-check-input form-check-info mg-2 w-20 h-20"
                                       id="apiCheckbox1" type="checkbox"
                                       value="">
                                <label class="form-check-label ms-2" for="apiCheckbox1">
                                    2error
                                </label>
                            </div>
                            <div class="form-check ps-0">
                                <input class="form-check-input form-check-info mg-2 w-20 h-20"
                                       id="apiCheckbox2" type="checkbox"
                                       value="">
                                <label class="form-check-label ms-2" for="apiCheckbox2">
                                    123 Total request
                                </label>
                            </div>

                        </div>
                        <div>
                            <div id="apikey"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="card api-eshop-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6>Total Users</h6>
                                    <div class="dropdown bg-light-primary h-40 w-40 d-flex-center b-r-15">
                                        <i class="ph ph-user-circle-gear f-s-20"></i>
                                    </div>
                                </div>
                                <h3>2564k</h3>
                                <p class="text-success mt-3 f-s-16 f-w-500 mb-0"><i
                                        class="ph-bold  ph-arrow-up-right text-success f-s-20"></i>92.9%
                                    <span
                                        class="text-secondary f-s-16 f-w-200">users income </span></p>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card api-eshop-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6>Members</h6>
                                    <div class="dropdown bg-light-success h-40 w-40 d-flex-center b-r-15">
                                        <i class="ph ph-users-three f-s-20"></i>
                                    </div>
                                </div>
                                <h3>1210k</h3>
                                <p class="text-success mt-3 f-s-16 f-w-500 mb-0"><i
                                        class="ph-bold  ph-arrow-up-right text-success f-s-20"></i>15.5%
                                    <span
                                        class="text-secondary f-s-16 f-w-200">members income</span></p>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card api-eshop-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6>Active Now</h6>
                                    <div class="dropdown bg-light-danger h-40 w-40 d-flex-center b-r-15">
                                        <i class="ph ph-check-circle f-s-20"></i>
                                    </div>
                                </div>
                                <h3>416k</h3>
                                <ul class="avatar-group justify-content-start">
                                    <li class="h-45 w-45 d-flex-center b-r-50 text-bg-danger b-2-light position-relative"
                                        data-bs-title="Sabrina Torres" data-bs-toggle="tooltip">
                            <span
                                class="position-absolute top-0 start-2 p-1 bg-danger border border-light rounded-circle"></span>
                                        <img alt="" class="img-fluid b-r-50 overflow-hidden"
                                             src="../assets/images/avtar/4.png">
                                    </li>
                                    <li class="h-45 w-45 d-flex-center b-r-50 text-bg-success b-2-light position-relative"
                                        data-bs-title="Sabrina Torres" data-bs-toggle="tooltip">
                            <span
                                class="position-absolute top-0 start-2 p-1 bg-success border border-light rounded-circle"></span>
                                        <img alt="" class="img-fluid b-r-50 overflow-hidden"
                                             src="../assets/images/avtar/1.png">
                                    </li>
                                    <li class="h-45 w-45 d-flex-center b-r-50 text-bg-warning b-2-light position-relative"
                                        data-bs-title="Sabrina Torres" data-bs-toggle="tooltip">
                            <span
                                class="position-absolute top-0 start-2 p-1 bg-warning border border-light rounded-circle"></span>
                                        <img alt="" class="img-fluid b-r-50 overflow-hidden"
                                             src="../assets/images/avtar/2.png">
                                    </li>
                                    <li class="h-45 w-45 d-flex-center b-r-50 text-bg-info b-2-light position-relative"
                                        data-bs-title="Sabrina Torres" data-bs-toggle="tooltip">
                            <span
                                class="position-absolute top-0 start-2 p-1 bg-info border border-light rounded-circle"></span>
                                        <img alt="" class="img-fluid b-r-50 overflow-hidden"
                                             src="../assets/images/avtar/3.png">
                                    </li>
                                    <li class="text-bg-primary h-35 w-35 d-flex-center b-r-50"
                                        data-bs-title="5 More"
                                        data-bs-toggle="tooltip">
                                        5+
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card api-eshop-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6>Developer</h6>
                                    <div class="dropdown bg-light-warning h-40 w-40 d-flex-center b-r-15">
                                        <i class="ph ph-file-arrow-down f-s-20"></i>
                                    </div>
                                </div>
                                <h3 class="mb-3">64</h3>
                                <button class="btn btn-primary" id="create_unique_key" type="button">
                                    Create API
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- modal start  -- -->
                    <div aria-hidden="true" aria-labelledby="apiModelLabel" class="modal fade" id="apiModel"
                         tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h1 class="modal-title fs-5 text-white" id="apiModelLabel">Create
                                        API</h1>
                                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"
                                            type="button"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label" for="username">API Key name</label>
                                        <input class="form-control" id="username" name="username"
                                               placeholder="Enter Your API"
                                               type="text">
                                    </div>

                                    <div class="mb-3 api_key_content d-none">
                                        <label class="form-label" for="apikey">API Key name</label>
                                        <input class="form-control" id="keygenValue" name="apikey"
                                               placeholder="Enter Your API"
                                               readonly type="text">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-light-secondary" data-bs-dismiss="modal"
                                            type="button">Close
                                    </button>
                                    <button class="btn btn-light-primary" id="keygen" type="button">Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal-end---- -->


                    <div class="col-xl-12">
                        <div class="alert alert-border-info bg-white" role="alert">
                            <h6>
                                <i class="ti ti-info-circle f-s-18 me-2 text-info"></i>
                                Review API Token
                            </h6>
                            <p class="text-secondary">
                                Here is your new api token.This is the only time the token will ever be
                                displayed, so be sure
                                not to lose it!
                            </p>
                            <div class="text-end">
                                <a class="link-primary text-d-underline" data-bs-dismiss="alert" href="">Don't
                                    allow</a>
                                <a class="link-primary text-d-underline ms-2" href="">Allow</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive app-scroll app-datatable-default">
                            <table class="w-100 display apikey-data-table table-bottom-border"
                                   id="apikeydtatable">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input id="select-all" type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </th>
                                    <th>Name</th>
                                    <th>Parent Name</th>
                                    <th>API Key</th>
                                    <th>Date</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="api_key_body">
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-primary me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/1.png">
                                            </div>
                                            Gavin Cortez
                                        </div>
                                    </td>
                                    <td class="f-w-600">Patty OFurniture</td>
                                    <td>12e8d619-5ab4-41db-b574-eb727f82d836</td>
                                    <td>1 jan 2024</td>
                                    <td>cristipola@gmailod.com</td>

                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete1"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/14.png">
                                            </div>
                                            Martena Mccray
                                        </div>
                                    </td>
                                    <td class="f-w-600">Olive Yew</td>
                                    <td>b589bd39-afa6-4dc2-a0e6-ee286d429689</td>
                                    <td>8 jan 2024</td>
                                    <td>jiji4fast@trumvia.online</td>
                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete2"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-info me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/10.png">
                                            </div>
                                            Gavin Joyce
                                        </div>
                                    </td>
                                    <td class="f-w-600">Maureen Biologist</td>
                                    <td>cab763c0-ea2c-4077-bb6c-a0c736d36f44</td>
                                    <td>14 jan 2024</td>
                                    <td>athos17@dsadsadsadas.online</td>
                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete3"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/2.png">
                                            </div>
                                            Gloria Little
                                        </div>

                                    </td>
                                    <td class="f-w-600">Maureen Biologist</td>
                                    <td>0ae33477-28bb-4dfb-aaa5-1f0f19f19572</td>
                                    <td>25 jan 2024</td>
                                    <td>tomasz@guthriedigitalmedia.com</td>
                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete4"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/8.png">
                                            </div>
                                            Jena Gaines
                                        </div>
                                    </td>
                                    <td class="f-w-600">Maureen Biologist</td>
                                    <td>d4f825d4-e76b-4e66-bf2e-66ee69a70263</td>
                                    <td>16 jan 2024</td>
                                    <td>kamenskkz@saxophonexltd.com</td>
                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete5"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/11.png">
                                            </div>
                                            Jenette Caldwell
                                        </div>
                                    </td>
                                    <td class="f-w-600">6Del Phineum
                                    </td>
                                    <td>
                                        3fefa4e0-e0f1-4167-8d36-18b753623c11
                                    </td>
                                    <td>20 jan 2024</td>
                                    <td>amybeez@hamedahmed.cloud</td>
                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete6"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/4.png">
                                            </div>
                                            Jennifer Acosta
                                        </div>
                                    </td>
                                    <td class="f-w-600">Percy Kewshun</td>
                                    <td>
                                        0c2b3bd4-5582-494e-b972-8bb1045bb235
                                    </td>
                                    <td>7 June 2024</td>
                                    <td>carling@crysalbyrd.info</td>


                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete7"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/2.png">
                                            </div>
                                            Jennifer Chang
                                        </div>
                                    </td>
                                    <td class="f-w-600">Roy L. Commishun
                                    </td>
                                    <td>
                                        ea651456-9063-4445-b852-9212ec8e93ed
                                    </td>
                                    <td>7 June 2024</td>
                                    <td>bigeminies@hamedahmed.cloud</td>


                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete8"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/3.png">
                                            </div>
                                            Michael Silva
                                        </div>
                                    </td>
                                    <td class="f-w-600">Roy L. Commishun</td>
                                    <td>
                                        c12aa92d-eaa6-4322-9b1b-bbbd1ba98e45
                                    </td>
                                    <td>14 June 2024</td>
                                    <td>stepanbykov@onlinecmail.com</td>


                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete9"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/4.png">
                                            </div>
                                            Michelle House
                                        </div>
                                    </td>
                                    <td class="f-w-600">Roy L. Commishun</td>
                                    <td>
                                        34c35f2c-e542-48b7-86ae-ee654f988241
                                    </td>
                                    <td>4 July 2024</td>
                                    <td>ali1987j@onlinecmail.com</td>

                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete10"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/10.png">
                                            </div>
                                            Olivia Liang
                                        </div>
                                    </td>
                                    <td class="f-w-600">Bridget Theriveaquai</td>
                                    <td>
                                        ecde376e-fe22-4ff9-b675-7ca0b6957dfb
                                    </td>
                                    <td>19 Aug 2024</td>
                                    <td>tjnyny@sjuanita.com</td>


                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete11"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/6.png">
                                            </div>
                                            Quinn Flynn
                                        </div>
                                    </td>
                                    <td class="f-w-600">Bridget Theriveaquai
                                    </td>
                                    <td>
                                        d234febf-c046-459c-9623-3fbb128bdcf4
                                    </td>
                                    <td>12 Sep 2024</td>
                                    <td>kostyaastonmartin@sjuanita.com</td>

                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete12"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/14.png">
                                            </div>
                                            Prescott Bartlett
                                        </div>
                                    </td>
                                    <td class="f-w-600">Frank N. Stein</td>
                                    <td>
                                        589d8184-7efe-4509-aab4-6b91e89f734c
                                    </td>
                                    <td>15 jan 2024</td>
                                    <td>nadezhdashirshova@cwrotzxks.com</td>


                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete13"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/2.png">
                                            </div>
                                            Suki Burks
                                        </div>
                                    </td>
                                    <td class="f-w-600">Frank N. Stein</td>
                                    <td>
                                        4cc1d9b9-6aea-4dad-81c3-11cce8dd43c1
                                    </td>
                                    <td>2 Sep 2024</td>
                                    <td>peter709@sellxuclone.com</td>

                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete14"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/8.png">
                                            </div>
                                            Tatyana Fitzpatrick
                                        </div>
                                    </td>
                                    <td class="f-w-600">
                                        Laura Norda
                                    </td>
                                    <td>
                                        7a4fcd62-b085-450b-9ecc-eedfaa5d141f
                                    </td>
                                    <td>19 July 2024</td>
                                    <td>gregorylisa17@boranora.com</td>


                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete15"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-wrapper">
                                            <label class="check-box m-0">
                                                <input type="checkbox">
                                                <span class="checkmark outline-secondary"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-dark me-2">
                                                <img alt="" class="img-fluid"
                                                     src="../assets/images/avtar/7.png">
                                            </div>
                                            Yuri Berry
                                        </div>
                                    </td>
                                    <td class="f-w-600">Mal Nurrisht
                                    </td>
                                    <td>
                                        04095ed9-cf5f-4233-b554-9bcc25d81c0b
                                    </td>
                                    <td>11 July 2024</td>
                                    <td>todd29@sjuanita.com</td>


                                    <td>
                                        <button class="btn btn-light-danger icon-btn b-r-4 delete-btn"
                                                id="account_delete16"
                                                type="button">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button class="btn btn-light-success icon-btn b-r-4" type="button">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- student list tabel 2-->
    </div>

    <div class="modal fade" id="apiDeletModal" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="{{asset('assets/images/icons/delete-icon.png')}}" alt="img" class="img-fluid">
                    <div class="text-center">
                        <h4 class="text-danger f-w-600">Are You Sure?</h4>
                        <p class="text-secondary f-s-16">You won't be able to revert this!</p>
                    </div>

                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="confirmDelete">Yes,Delet it</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!--customizer-->
    <div id="customizer"></div>

    <!-- apexcharts-->
    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>

    <!-- datatable js-->
    <script src="{{asset('assets/vendor/datatable/jquery.dataTables.min.js')}}"></script>

    <!-- api js -->
    <script src="{{asset('assets/js/api.js')}}"></script>
@endsection
