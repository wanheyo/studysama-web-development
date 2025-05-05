<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Multipurpose, super flexible, powerful, clean modern responsive bootstrap 5 admin template"
          name="description">
    <meta content="admin template, axelit admin template, dashboard template, flat admin template, responsive admin template, web app"
          name="keywords">
    <meta content="la-themes" name="author">
    <link href="{{asset('../assets/images/logo/favicon.png')}}" rel="icon" type="image/x-icon">
    <link href="{{asset('../assets/images/logo/favicon.png')}}" rel="shortcut icon" type="image/x-icon">

    <title>axelit - Premium Admin Template</title>

    <!--font-awesome-css-->
    <link href="{{ asset('assets/vendor/fontawesome/css/all.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">

    <!-- iconoir icon css  -->
    <link href="{{ asset('assets/vendor/ionio-icon/css/iconoir.css') }}" rel="stylesheet">

    <!--animation-css-->
    <link href="{{ asset('assets/vendor/animation/animate.min.css') }}" rel="stylesheet">

    <!-- devicon css -->
    <link href="{{ asset('assets/vendor/devicon/devicon.min.css') }}" rel="stylesheet">

    <!-- tabler icons-->
    <link href="{{ asset('assets/vendor/tabler-icons/tabler-icons.css') }}" rel="stylesheet" type="text/css">

    <!--flag Icon css-->
    <link href="{{ asset('assets/vendor/flag-icons-master/flag-icon.css') }}" rel="stylesheet" type="text/css">

    <!-- Bootstrap css-->
    <link href="{{ asset('assets/vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

    <!-- aos css-->
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">

    <!-- slick css -->
    <link href="{{ asset('assets/vendor/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/slick/slick-theme.css') }}" rel="stylesheet">

    @vite(['public/assets/scss/style.scss'])

</head>

<body class="bg-white landing-page">
<!-- Landing page start -->
<div class="app-wrapper flex-column">

    <!-- cursor  -->
    <div class="circle-cursor">
    </div>

    <!-- cursor -->

    <div class="landing-wrapper">
        <!-- Header start -->
        <div class="navbar navbar-expand-lg sticky-top landing-nav_main px-3 position-fixed w-100">
            <div class="container-fluid">
                <a class="navbar-brand logo" href="{{ route('landing') }}">
                    <img alt="#" src="{{asset('../assets/images/logo/axelit-white.png')}}">
                </a>

                <button aria-controls="landing_nav" aria-expanded="false" aria-label="Toggle navigation"
                        class="navbar-toggler"
                        data-bs-target="#landing_nav" data-bs-toggle="collapse" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="landing_nav">

                    <ul class="navbar-nav m-auto">

                        <li class="nav-item">
                            <a class="nav-link active" href="#Demo">Demo</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#Cards">Cards</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#Features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#Elements">Elements</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="mailto:teqlathemes@gmail.com" target="_blank">Support</a>
                        </li>
                    </ul>
                    <a class="btn btn-danger rounded" href="https://forms.gle/hYrBdsJYsqqWe5pKA" target="_blank">Hire
                        Us</a>
                    <a class="btn btn-primary ms-2 rounded" href="https://themeforest.net/user/la-themes"
                       target="_blank">Buy
                        Now</a>

                </div>
            </div>
        </div>

        <!-- Header end -->

        <!-- landing first section start -->

        <section class="landing-section p-0">
            <div class="container-fluid">
                <div class="row landing-content ">

                    <div class="col-lg-6 offset-lg-3 position-relative">
                        <div class="landing-heading text-center">
                            <h1> Power Up Your <br> <span id="highlight-typed"></span> With Axelit <br></h1>
                            <img alt="shape" class="img-fluid landing-vector-shape"
                                 src="{{asset('../assets/images/landing/vector-shaps.png')}}">
                            <p>Axelit Comes with so many sidebar option , <br> layouts like RTl & many more ...!</p>
                            <div class="mg-t-60">
                                <a class="btn btn-primary py-3 px-4 b-r-50 btn-lg" href="{{ route('index') }}"
                                   role="button"
                                   target="_blank">Check Now</a>
                                <a class="btn btn-danger py-3 px-4 b-r-50 btn-lg ms-2" href="https://phpstack-1384472-5121645.cloudwaysapps.com/document/laravel/axelit/"
                                   role="button"
                                   target="_blank">Document</a>
                            </div>
                        </div>
                    </div>


                    <div class="col-12">
                        <div class="landing-img">
                            <div class="img-box">

                                <div>
                                    <img alt="img" class="box-img-1" src="{{asset('../assets/images/landing/banner-img.gif')}}">
                                </div>

                                <div>
                                    <img alt="img" class="box-img-4 " src="{{asset('../assets/images/landing/banner-img-1.gif')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- landing first section end -->
    </div>

    <!-- Demos section start -->
    <section class="demos-section" id="Demo">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 offset-xl-3">
                    <div class="landing-title text-md-center">
                        <h2 class=""><span class="highlight-title">150+</span> pages</h2>
                        <p>All pages created with unlimited features that will reduce the cost, efforts and your
                            time.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-8 offset-xl-2">
                    <div class="demos-tab-section ">

                        <ul class="nav nav-tabs app-tabs-dark" id="v-bg" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button aria-controls="dashboard-tab-pane" aria-selected="true" class="nav-link active"
                                        data-bs-target="#dashboard-tab-pane" data-bs-toggle="tab" id="dashboard-tab"
                                        role="tab"
                                        type="button">
                                    <i class="ti ti-home pe-2 ps-1"></i> Dashboard
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button aria-controls="apps-tab-pane" aria-selected="false" class="nav-link"
                                        data-bs-target="#apps-tab-pane"
                                        data-bs-toggle="tab" id="apps-tab" role="tab" tabindex="-1"
                                        type="button">
                                    <i class="ti ti-server pe-2 ps-1"></i> Apps
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button aria-controls="ui-tab-pane" aria-selected="false" class="nav-link"
                                        data-bs-target="#ui-tab-pane"
                                        data-bs-toggle="tab"
                                        id="ui-tab" role="tab" tabindex="-1" type="button">
                                    <i class="ti ti-first-aid-kit pe-2 ps-1"></i> UI Kits
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button aria-controls="advance-ui-tab-pane" aria-selected="false" class="nav-link"
                                        data-bs-target="#advance-ui-tab-pane" data-bs-toggle="tab" id="advance-ui-tab"
                                        role="tab"
                                        tabindex="-1" type="button">
                                    <i class="ti ti-briefcase pe-2 ps-1"></i> Advance UI
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button aria-controls="icons-tab-pane" aria-selected="false" class="nav-link"
                                        data-bs-target="#icons-tab-pane"
                                        data-bs-toggle="tab" id="icons-tab" role="tab" tabindex="-1"
                                        type="button">
                                    <i class="ti ti-icons pe-2 ps-2"></i> Icons
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button aria-controls="table-tab-pane" aria-selected="false" class="nav-link"
                                        data-bs-target="#table-tab-pane"
                                        data-bs-toggle="tab" id="table-tab" role="tab" tabindex="-1"
                                        type="button">
                                    <i class="ti ti-table pe-2 ps-2"></i> Tables
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button aria-controls="forms-tab-pane" aria-selected="false" class="nav-link"
                                        data-bs-target="#forms-tab-pane"
                                        data-bs-toggle="tab" id="forms-tab" role="tab" tabindex="-1"
                                        type="button">
                                    <i class="ti ti-forms pe-2 ps-2"></i> Forms
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button aria-controls="ready-touse-tab-pane" aria-selected="false" class="nav-link"
                                        data-bs-target="#ready-touse-tab-pane" data-bs-toggle="tab" id="ready-touse-tab"
                                        role="tab"
                                        tabindex="-1" type="button">
                                    <i class="ti ti-table-import pe-2 ps-2"></i> Ready To Use
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button aria-controls="auth-tab-pane" aria-selected="false" class="nav-link"
                                        data-bs-target="#auth-tab-pane"
                                        data-bs-toggle="tab" id="auth-tab" role="tab" tabindex="-1"
                                        type="button">
                                    <i class="ti ti-news pe-2 ps-2"></i> Auth Pages
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button aria-controls="error-tab-pane" aria-selected="false" class="nav-link"
                                        data-bs-target="#error-tab-pane"
                                        data-bs-toggle="tab" id="error-tab" role="tab" tabindex="-1"
                                        type="button">
                                    <i class="ti ti-news pe-2 ps-2"></i> Error Pages
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12">


                    <div class="tab-content mt-3">
                        <!-- Dashboard tab start -->
                        <div class="tab-pane fade show active" id="dashboard-tab-pane" role="tabpanel" tabindex="0">
                            <div class="row justify-content-center">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">

                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/project-dashboard.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Project</h6>
                                                <a class="btn btn-light-success icon-btn b-r-22" href="{{ route('index') }}"
                                                   role="button" target="_blank">
                                                    <i class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img"
                                                 class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/ecommerce-dashboard.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Ecommerce</h6>

                                                <a class="btn btn-light-primary icon-btn b-r-22"
                                                   href="{{route('ecommerce_dashboard')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Dashboard tab end -->

                        <!--  Apps tab start -->
                        <div class="tab-pane fade" id="apps-tab-pane" role="tabpanel" tabindex="0">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/calander.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Calender</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('calendar')}}"
                                                   role="button" target="_blank">
                                                    <i class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/profile.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Profile</h6>
                                                <a class="btn btn-light-success icon-btn b-r-22" href="{{route('profile')}}"
                                                   role="button" target="_blank">
                                                    <i class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/team.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Team</h6>
                                                <a class="btn btn-light-danger icon-btn b-r-22" href="{{route('team')}}"
                                                   role="button" target="_blank">

                                                    <i class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/chat.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Chat</h6>
                                                <a class="btn btn-light-warning icon-btn b-r-22" href="{{route('chat')}}"
                                                   role="button" target="_blank">
                                                    <i class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/email.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Email</h6>
                                                <a class="btn btn-light-danger icon-btn b-r-22" href="{{route('email')}}"
                                                   role="button" target="_blank">
                                                    <i class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/ecommerce.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Ecommerce</h6>
                                                <a class="btn btn-light-warning icon-btn b-r-22" href="{{route('product')}}"
                                                   role="button" target="_blank">
                                                    <i class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/todo.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Todo</h6>
                                                <a class="btn btn-light-success icon-btn b-r-22" href="{{route('to_do')}}"
                                                   role="button" target="_blank">
                                                    <i class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/file-manager.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">File manager</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('file_manager')}}"
                                                   role="button" target="_blank">
                                                    <i class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/blog.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Blog</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('blog')}}"
                                                   role="button" target="_blank">
                                                    <i class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  Apps tab end -->

                        <!--UI Kits tab  -->
                        <div class="tab-pane fade" id="ui-tab-pane" role="tabpanel" tabindex="0">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">

                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/alert.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Alert</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('alert')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/badges.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Badges</h6>
                                                <a class="btn btn-light-success icon-btn b-r-22" href="{{route('badges')}}" role="button"
                                                   target="_blank">

                                                    <i class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/buttons.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Buttons</h6>
                                                <a class="btn btn-light-warning icon-btn b-r-22" href="{{route('buttons')}}" role="button"
                                                   target="_blank">

                                                    <i class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/dropdown.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Dropdown</h6>
                                                <a class="btn btn-light-danger icon-btn b-r-22" href="{{route('dropdown')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/avtar.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Avtar</h6>
                                                <a class="btn btn-light-danger icon-btn b-r-22" href="{{route('avatar')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/accordions.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Accordions</h6>
                                                <a class="btn btn-light-warning  icon-btn b-r-22" href="{{route('accordions')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/progress.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Progress</h6>
                                                <a class="btn btn-light-success icon-btn b-r-22" href="{{route('progress')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/notification.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Notifications</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('notifications')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--UI Kits end  -->

                        <!--Advance UI tab  -->
                        <div class="tab-pane fade" id="advance-ui-tab-pane" role="tabpanel" tabindex="0">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/modal.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Modals</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('modals')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/sweet-alert.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Sweetalert</h6>
                                                <a class="btn btn-light-success icon-btn b-r-22" href="{{route('sweetalert')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/animation.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Animation</h6>
                                                <a class="btn btn-light-danger icon-btn b-r-22" href="{{route('animation')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/video-embaded.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Video embaded</h6>
                                                <a class="btn btn-light-warning icon-btn b-r-22" href="{{route('video_embed')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/tour.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Tour</h6>
                                                <a class="btn btn-light-danger icon-btn b-r-22" href="{{route('tour')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/slider.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Slider</h6>
                                                <a class="btn btn-light-warning icon-btn b-r-22" href="{{route('slick_slider')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/rating.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Rating</h6>
                                                <a class="btn btn-light-success icon-btn b-r-22" href="{{route('ratings')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/count-down.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Count Down</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('count_down')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Advance UI end  -->

                        <!-- Icons tab start -->
                        <div class="tab-pane fade" id="icons-tab-pane" role="tabpanel" tabindex="0">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">

                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/font-awesome.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Fontawesome Icons</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('fontawesome')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/flag.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Flag Icons</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('flag_icons')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/animated.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Animated Icons</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('animated_icon')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/weather.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Whether Icons</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('weather_icon')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Icons tab end -->

                        <!-- Table tab start -->
                        <div class="tab-pane fade" id="table-tab-pane" role="tabpanel" tabindex="0">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/basic-table.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Basic Table</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('basic_table')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/data-table.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Data Table</h6>
                                                <a class="btn btn-light-success icon-btn b-r-22" href="{{route('data_table')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/list-js.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">List Js</h6>
                                                <a class="btn btn-light-danger icon-btn b-r-22" href="{{route('list_table')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/advance-table.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Advance Table</h6>
                                                <a class="btn btn-light-warning icon-btn b-r-22" href="{{route('advance_table')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Table tab end -->

                        <!-- form tab start -->
                        <div class="tab-pane fade" id="forms-tab-pane" role="tabpanel" tabindex="0">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/base-input.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Basic input</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('base_inputs')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/form-validation.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Form Validation</h6>
                                                <a class="btn btn-light-success icon-btn b-r-22" href="{{route('form_validation')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/checkbox.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Checkbox & Radio</h6>
                                                <a class="btn btn-light-warning icon-btn b-r-22" href="{{route('checkbox_radio')}}" role="button"
                                                   target="_blank">
                                                    <i class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/input-mask.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Input Mask</h6>
                                                <a class="btn btn-light-danger icon-btn b-r-22" href="{{route('input_masks')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/floating-lable.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Floating Labels</h6>
                                                <a class="btn btn-light-danger icon-btn b-r-22" href="{{route('floating_labels')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/select.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Select</h6>
                                                <a class="btn btn-light-warning icon-btn b-r-22" href="{{route('select')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/range-slider.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Range Slider</h6>
                                                <a class="btn btn-light-success icon-btn b-r-22" href="{{route('range_slider')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/clip-board.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Clipboard</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('clipboard')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/file-upload.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">File Upload</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('file_upload')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/duel-list-box.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Dual Listbox</h6>
                                                <a class="btn btn-light-danger icon-btn b-r-22" href="{{route('dual_list_boxes')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/default-form.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Default Forms</h6>
                                                <a class="btn btn-light-success icon-btn b-r-22" href="{{route('default_forms')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- form tab end -->

                        <!-- Ready to use tab start -->
                        <div class="tab-pane fade" id="ready-touse-tab-pane" role="tabpanel" tabindex="0">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">

                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/form-wizard.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Form Wizards</h6>
                                                <a class="btn btn-light-secondary icon-btn b-r-22" href="{{route('form_wizards')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/form-wizard-1.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Form Wizards 1</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('form_wizard_1')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/form-wizard-2.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Form Wizards 2</h6>
                                                <a class="btn btn-light-danger icon-btn b-r-22" href="{{route('form_wizard_2')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/ready-to-use-form.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Ready To Use Form</h6>
                                                <a class="btn btn-light-warning icon-btn b-r-22" href="{{route('ready_to_use_form')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ti ti-chevrons-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/ready-to-use-table.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Ready To Use table</h6>
                                                <a class="btn btn-light-success icon-btn b-r-22" href="{{route('ready_to_use_table')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ready to use tab end -->

                        <!-- Auth page tab start -->
                        <div class="tab-pane fade" id="auth-tab-pane" role="tabpanel" tabindex="0">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/auth-1.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Sign In</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('sign_in')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/auth-2.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Sign In With Bgimage</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('sign_in_1')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/auth-3.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Sign-up</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('sign_up')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/auth-4.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Sign Up With Bgimage</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('sign_up_1')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/auth-5.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Password Create</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('password_create')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/auth-6.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Password reset</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('password_reset')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/auth-7.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Lock Screen</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('lock_screen')}}" role="button"
                                                   target="_blank">

                                                    <i class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/auth-8.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Tow Step Verification</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('two_step_verification')}}" role="button"
                                                   target="_blank">

                                                    <i
                                                            class="ti ti-chevrons-right"></i>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Auth page tab end -->

                        <!-- Error tab start -->
                        <div class="tab-pane fade" id="error-tab-pane" role="tabpanel" tabindex="0">
                            <div class="row">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">

                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/error-400.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Bad Request</h6>
                                                <a class="btn btn-light-danger icon-btn b-r-22" href="{{route('error_400')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ph-bold  ph-caret-right f-s-18 f-w-900"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/error-403.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Forbidden</h6>
                                                <a class="btn btn-light-success icon-btn b-r-22" href="{{route('error_403')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ph-bold  ph-caret-right f-s-18 f-w-900"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/error-404.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Not Found</h6>
                                                <a class="btn btn-light-primary icon-btn b-r-22" href="{{route('error_404')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ph-bold  ph-caret-right f-s-18 f-w-900"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/error-500.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Internal Server</h6>
                                                <a class="btn btn-light-warning icon-btn b-r-22" href="{{route('error_500')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ph-bold  ph-caret-right f-s-18 f-w-900"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card demo-card">
                                        <div class="card-body">
                                            <img alt="demo-img" class="img-fluid b-r-8"
                                                 src="{{asset('../assets/images/landing/error-503.jpg')}}">
                                            <div class="demo-box">
                                                <h6 class="m-0 f-w-500 f-s-18">Service Unavailable</h6>
                                                <a class="btn btn-light-info icon-btn b-r-22" href="{{route('error_503')}}" role="button"
                                                   target="_blank">
                                                    <i
                                                            class="ph-bold  ph-caret-right f-s-18 f-w-900"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Error tab end -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Demos section end  -->

    <!-- Features section start -->
    <section class="features-section" id="Features">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 offset-xl-3">
                    <div class="landing-title text-md-center">
                        <h2 class=""> Core <span class="highlight-title">features</span></h2>
                        <p class="text-secondary">Admin features, developers can easily customize the appearance and
                            behavior of
                            their applications,
                            ensuring a consistent and visually appealing experience across different devices and screen
                            sizes.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <ul class="row features-list">

                        <li class="col-6 col-md-3 col-xl-2">
                            <div class="features-icon">

                                <i class="ti ti-brand-bootstrap f-s-36 text-primary"></i>
                                <div class="features-content">
                                    <h5>Bootstrap</h5>
                                    <span class="badge bg-light-info mt-1">Framework </span>
                                </div>

                            </div>
                        </li>

                        <li class="col-6 col-md-3 col-xl-2">
                            <div class="features-icon">
                                <i class="ti ti-circle-letter-w f-s-36 text-primary"></i>
                                <div class="features-content">
                                    <h5> W3C</h5>
                                    <span class="badge bg-light-success mt-1">Validation</span>
                                </div>

                            </div>
                        </li>

                        <li class="col-6 col-md-3 col-xl-2">
                            <div class="features-icon">

                                <i class="ti ti-brand-sass f-s-36 text-primary"></i>

                                <div class="features-content">
                                    <h5>SASS</h5>
                                    <span class="badge bg-light-danger mt-1">Professional grade</span>
                                </div>

                            </div>
                        </li>
                        <li class="col-6 col-md-3 col-xl-2">
                            <div class="features-icon">

                                <i class="ti ti-chart-pie f-s-36 text-primary"></i>
                                <div class="features-content">
                                    <h5>Apex Chart</h5>
                                    <span class="badge bg-light-secondary mt-1">Charts</span>
                                </div>

                            </div>
                        </li>
                        <li class="col-6 col-md-3 col-xl-2">
                            <div class="features-icon">

                                <i class="ti ti-package f-s-36 text-primary"></i>
                                <div class="features-content">
                                    <h5>Webpack</h5>
                                    <span class="badge bg-light-primary mt-1">Module bundler</span>
                                </div>
                            </div>

                        </li>


                        <li class="col-6 col-md-3 col-xl-2">

                            <div class="features-icon">
                                <i class="ti ti-map-2 f-s-36 text-primary"></i>

                                <div class="features-content">
                                    <h5>Google Map</h5>
                                    <span class="badge bg-light-warning mt-1">Maps</span>
                                </div>
                            </div>
                        </li>

                        <li class="col-6 col-md-3 col-xl-2">
                            <div class="features-icon">
                                <i class="ti ti-chart-radar f-s-36 text-primary"></i>
                                <div class="features-content">
                                    <h5>Chart js</h5>
                                    <span class="badge bg-light-warning mt-1">Charts</span>
                                </div>
                            </div>
                        </li>

                        <li class="col-6 col-md-3 col-xl-2">
                            <div class="features-icon">
                                <i class="ti ti-brand-google f-s-36 text-primary"></i>
                                <div class="features-content">
                                    <h5>Goggle Fonts</h5>
                                    <span class="badge bg-light-dark mt-1">Fonts</span>
                                </div>

                            </div>
                        </li>
                        <li class="col-6 col-md-3 col-xl-2">
                            <div class="features-icon">
                                <i class="ti ti-briefcase f-s-36 text-primary"></i>
                                <div class="features-content">
                                    <h5>Ui kits</h5>
                                    <span class="badge bg-light-primary mt-1">Components</span>
                                </div>
                            </div>
                        </li>
                        <li class="col-6 col-md-3 col-xl-2">
                            <div class="features-icon">

                                <i class="ti ti-apps f-s-36 text-primary"></i>
                                <div class="features-content">
                                    <h5>Apps</h5>
                                    <span class="badge bg-light-success mt-1">Apps</span>
                                </div>
                            </div>
                        </li>

                        <li class="col-6 col-md-3 col-xl-2">
                            <div class="features-icon">

                                <i class="ti ti-brand-npm f-s-36 text-primary"></i>
                                <div class="features-content">
                                    <h5>NPM</h5>
                                    <span class="badge bg-light-danger mt-1">Pkg Manager</span>
                                </div>

                            </div>
                        </li>

                        <li class="col-6 col-md-3 col-xl-2">
                            <div class="features-icon">

                                <i class="ti ti-calendar-plus f-s-36 text-primary"></i>
                                <div class="features-content">
                                    <h5>Fullcalendar</h5>
                                    <span class="badge bg-light-info mt-1">Event Calendar</span>
                                </div>

                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Features section end -->

    <!-- Faq section start -->
    <section class="faq-section">
        <div class="container">

            <div class="row">
                <div class="col-xl-6 offset-xl-3">
                    <div class="landing-title text-md-center">
                        <h2>Inquired <span class="highlight-title"> Queries</span></h2>
                        <p class="text-light">After reading the instructions, I had a few inquired queries about the
                            process
                            and decided to reach out
                            to customer support for clarification.</p>
                    </div>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12 col-sm-6 mb-3">
                            <div class="card-boxs">
                                <div class="icon-boxs">
                                    <i class="ti ti-book-2"></i>
                                </div>
                                <div class="box-content">
                                    <h4>Digitize Your Documents</h4>
                                    <p>Efficiently Arranged and Current</p>
                                    <a class="btn btn-primary" href="https://phpstack-1384472-5121645.cloudwaysapps.com/document/laravel/axelit/" role="button" target="_blank">Check
                                        Document</a>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-6">
                            <div class="card-boxs">
                                <div class="icon-boxs">
                                    <i class="ti ti-headphones"></i>
                                </div>
                                <div class="box-content">
                                    <h4>Committed Assistance</h4>
                                    <p>Require assistance? Send us a ticket. We're here to help!</p>
                                    <a class="btn btn-primary" href="mailto:teqlathemes@gmail.com" role="button"
                                       target="_blank">Get
                                        Support</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="landing-accordion">
                        <div class="accordion app-accordion accordion-flush accordion-light-dark app-accordion-plus"
                             id="nestingExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button aria-controls="nestingExample" aria-expanded="true" class="accordion-button"
                                            data-bs-target="#nestingcollapseOne" data-bs-toggle="collapse"
                                            type="button">
                                        What is the role of an admin??
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse show" data-bs-parent="#nestingExample"
                                     id="nestingcollapseOne">
                                    <div class="accordion-body">
                                        <p>Admins are responsible for managing and overseeing the smooth operation of a
                                            system, platform,
                                            or organization.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button aria-controls="nestingcollapseTwo" aria-expanded="false"
                                            class="accordion-button collapsed"
                                            data-bs-target="#nestingcollapseTwo" data-bs-toggle="collapse"
                                            type="button">
                                        How do I add or remove users?
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" data-bs-parent="#nestingExample"
                                     id="nestingcollapseTwo">
                                    <div class="accordion-body">
                                        <p>
                                            Depending on the system, user management can usually be done through the
                                            admin dashboard. Look
                                            for the <strong>"User Management"</strong> or <strong>"Admin
                                            Settings"</strong> section, where
                                            you can add or remove users and
                                            assign roles.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button aria-expanded="false" class="accordion-button collapsed"
                                            data-bs-target="#nestingcollapseFour"
                                            data-bs-toggle="collapse" type="button">
                                        What security measures should I implement?
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" data-bs-parent="#nestingExample"
                                     id="nestingcollapseFour">
                                    <div class="accordion-body">
                                        <p>
                                            Admins should prioritize security by enforcing strong password policies,
                                            implementing two-factor
                                            authentication, regularly updating software, and monitoring system logs for
                                            any suspicious
                                            activities.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button aria-expanded="false" class="accordion-button collapsed"
                                            data-bs-target="#nestingcollapseFive"
                                            data-bs-toggle="collapse" type="button">
                                        How can I troubleshoot common issues?
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" data-bs-parent="#nestingExample"
                                     id="nestingcollapseFive">
                                    <div class="accordion-body">
                                        <p>
                                            Document and follow a systematic approach to troubleshooting. Check error
                                            logs, consult
                                            documentation, and involve relevant stakeholders if needed.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button aria-expanded="false" class="accordion-button collapsed"
                                            data-bs-target="#nestingcollapseSix"
                                            data-bs-toggle="collapse" type="button">
                                        How can I stay informed about updates and patches?
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" data-bs-parent="#nestingExample"
                                     id="nestingcollapseSix">
                                    <div class="accordion-body">
                                        <p>
                                            Subscribe to official newsletters, forums, or mailing lists related to the
                                            software or system
                                            you're administering. Regularly check the official website for announcements
                                            and security
                                            patches. Stay informed about the latest industry trends and best practices.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button aria-expanded="false" class="accordion-button collapsed"
                                            data-bs-target="#nestingcollapseSeven"
                                            data-bs-toggle="collapse" type="button">
                                        What is the process for system upgrades?
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" data-bs-parent="#nestingExample"
                                     id="nestingcollapseSeven">
                                    <div class="accordion-body">
                                        <p>
                                            Before upgrading, thoroughly review release notes, test the upgrade in a
                                            non-production
                                            environment, and ensure compatibility with existing plugins or integrations.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button aria-expanded="false" class="accordion-button collapsed"
                                            data-bs-target="#nestingcollapseEight"
                                            data-bs-toggle="collapse" type="button">
                                        How do I handle user access permissions?
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" data-bs-parent="#nestingExample"
                                     id="nestingcollapseEight">
                                    <div class="accordion-body">
                                        <p>
                                            Website design projects can vary depending on their scale and
                                            complexity—making it hard to
                                            generalize about project timelines. Ideally, a typical website design
                                            project should take
                                            between 6 and 12 weeks.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Faq section end -->

    <!-- Cards Sections start -->
    <section class="card-section" id="Cards">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="landing-title">
                        <h2>Sophisticated <span class="highlight-title"> Cards</span></h2>
                        <p>Cards offer enhanced design flexibility and interactive capabilities,
                            incorporating dynamic elements
                            like animations, real-time updates, or embedded multimedia to provide a richer and more
                            engaging user
                            experience in a concise card format.</p>
                    </div>
                    <ul class="card-details-list">
                        <li>200+ Cards Collection</li>
                        <li>Basic Components Included</li>
                        <li>Advanced Functionality</li>
                        <li>Customization and Personalization</li>
                        <li>Responsive Card Design</li>
                        <li>Styleguide Included</li>
                    </ul>
                </div>
                <div class="col-8">
                    <div class="card-section-right">
                        <div class="slider-container">
                            <div class="slider-container-box">
                                <div class="slider-slideUp">
                                    <img alt="card-img" class="img-fluid" src="{{asset('../assets/images/landing/landing-bg.png')}}">
                                </div>
                                <div class="slider-slideUp">
                                    <img alt="card-img" class="img-fluid" src="{{asset('../assets/images/landing/landing-bg.png')}}">
                                </div>
                                <div class="slider-slideUp">
                                    <img alt="card-img" class="img-fluid" src="{{asset('../assets/images/landing/landing-bg.png')}}">
                                </div>
                            </div>
                            <div class="slider-container-box slider-left">
                                <div class="slider-slideDown">
                                    <img alt="card-img" class="img-fluid"
                                         src="{{asset('../assets/images/landing/landing-bg-1.png')}}">
                                </div>
                                <div class="slider-slideDown">
                                    <img alt="card-img" class="img-fluid"
                                         src="{{asset('../assets/images/landing/landing-bg-1.png')}}">
                                </div>
                                <div class="slider-slideDown">
                                    <img alt="card-img" class="img-fluid"
                                         src="{{asset('../assets/images/landing/landing-bg-1.png')}}">
                                </div>
                            </div>
                            <div class="slider-container-box">
                                <div class="slider-slideUp">
                                    <img alt="card-img" class="img-fluid"
                                         src="{{asset('../assets/images/landing/landing-bg-2.png')}}">
                                </div>
                                <div class="slider-slideUp">
                                    <img alt="card-img" class="img-fluid"
                                         src="{{asset('../assets/images/landing/landing-bg-2.png')}}">
                                </div>
                                <div class="slider-slideUp">
                                    <img alt="card-img" class="img-fluid"
                                         src="{{asset('../assets/images/landing/landing-bg-2.png')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Cards Sections end  -->


    <!-- Element section start  -->
    <section class="element-section" id="Elements">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 offset-xl-3">
                    <div class="landing-title text-md-center">
                        <h2><span class="highlight-title">Elements</span> of axelit</h2>
                        <p>offer a responsive and user-friendly interface, streamlining the design and
                            development of web
                            applications by providing a robust set of pre-built components and templates.</p>
                    </div>
                </div>
            </div>

            <div class="row gy-3">
                <div class="col-sm-6 col-lg-4">
                    <div class="element-card">
                        <div>
                            <div class="element-icons icons-primary">
                                <i class="ti ti-playstation-circle"></i>
                            </div>

                            <div class="element-content">
                                <h4>Buttons</h4>
                                <p>Apply Custom button styles to forms, dialogs, and various elements, featuring support
                                    for multiple
                                    sizes and states.</p>
                                <a class="link-btn link-primary mt-3 " href="{{route('buttons')}}" role="button">View Buttons
                                    <i
                                            class="ti ti-chevrons-right mt-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="element-card">
                        <div class="">
                            <div class="element-icons icons-secondary">
                                <i class="ti ti-cards"></i>
                            </div>
                            <div class="element-content">
                                <h4>Cards</h4>
                                <p>Create stylish cards with Admin Element for organized content presentation and a
                                    sleek user
                                    interface.</p>
                                <a class="link-btn link-primary mt-3" href="{{route('cards')}}" role="button">View Cards <i
                                        class="ti ti-chevrons-right mt-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="element-card">
                        <div>
                            <div class="element-icons icons-dark">
                                <i class="ti ti-list-details"></i>
                            </div>
                            <div class="element-content">
                                <h4>List</h4>
                                <p>Easily design lists with Admin Element intuitive elements for structured content
                                    display, enhancing
                                    user experience.</p>
                                <a class="link-btn link-primary mt-3" href="{{route('list')}}" role="button">View List <i
                                        class="ti ti-chevrons-right mt-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-lg-4">
                    <div class="element-card">
                        <div class="">
                            <div class="element-icons icons-secondary">
                                <i class="ti ti-alert-circle"></i>
                            </div>
                            <div class="element-content">
                                <h4>Alerts</h4>
                                <p>Create alerts using Admin Elements intuitive elements to effectively communicate
                                    messages.</p>
                                <a class="link-btn link-primary mt-3" href="{{route('alert')}}" role="button">View Alerts <i
                                        class="ti ti-chevrons-right mt-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="element-card">
                        <div class="">
                            <div class="element-icons icons-dark">
                                <i class="ti ti-cooker"></i>
                            </div>
                            <div class="element-content">
                                <h4>Accordions</h4>
                                <p>Create collapsible accordion in Admin for organized content presentation, optimizing
                                    user
                                    interaction.</p>
                                <a class="link-btn link-primary mt-3" href="{{route('accordions')}}" role="button">View
                                    Accordions <i
                                            class="ti ti-chevrons-right mt-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="element-card">
                        <div class="">
                            <div class="element-icons icons-primary">
                                <i class="ti ti-circle-chevron-down"></i>
                            </div>
                            <div class="element-content">
                                <h4>Dropdown</h4>
                                <p>Create dropdown using Admin Elements for enhanced user interaction and intuitive
                                    navigation.</p>
                                <a class="link-btn link-primary mt-3" href="{{route('dropdown')}}" role="button">View Dropdown
                                    <i
                                            class="ti ti-chevrons-right mt-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="element-card">
                        <div class="">
                            <div class="element-icons icons-dark">
                                <i class="ti ti-line-dotted"></i>
                            </div>
                            <div class="element-content">
                                <h4>Dividers</h4>
                                <p>Create dividers effortlessly with Admin Elements utilities, enhancing content
                                    organization. </p>
                                <a class="link-btn link-primary mt-3" href="{{route('divider')}}" role="button">View Dividers
                                    <i
                                            class="ti ti-chevrons-right mt-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="element-card">
                        <div class="">
                            <div class="element-icons icons-primary">
                                <i class="ti ti-chart-candle"></i>
                            </div>
                            <div class="element-content">
                                <h4>Progress</h4>
                                <p>Utilize Progress components for visually appealing representation of task completion
                                    and data
                                    loading. </p>
                                <a class="link-btn link-primary mt-3" href="{{route('progress')}}" role="button">View Progress
                                    <i
                                            class="ti ti-chevrons-right mt-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="element-card">
                        <div class="">
                            <div class="element-icons icons-secondary">
                                <i class="ti ti-bell-ringing"></i>
                            </div>
                            <div class="element-content">
                                <h4>Notifications</h4>
                                <p>Employ Admin notification Elements for streamlined user alerts, enhancing
                                    interactivity and user
                                    experience. </p>
                                <a class="link-btn link-primary mt-3" href="{{route('notifications')}}" role="button">View
                                    Notifications <i
                                            class="ti ti-chevrons-right mt-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--Element section end  -->

    <!-- Dark Mode section -->
    <section class="dark-section">
        <div class="container">


            <div class="row">
                <div class="col-xl-6 offset-xl-3">
                    <div class="landing-title text-md-center">
                        <h2>Discover Our <span class="highlight-title"> Dark Layout</span></h2>
                        <p class="text-light">Embrace the elegance of the dark layout, where simplicity meets
                            sophistication.
                            Navigate effortlessly through your admin tasks with style.</p>
                    </div>
                </div>
                <div class="col-12 ">

                    <div class="slider-container">
                        <div class="slider-container-box">
                            <div class="slider-slideLeft">
                                <img alt="" class="img-fluid" src="{{asset('../assets/images/landing/dark-layout.png')}}">
                            </div>
                        </div>
                        <div class="slider-container-box slider-left">
                            <div class="slider-slideRight">
                                <img alt="" class="img-fluid" src="{{asset('../assets/images/landing/dark-layout-1.png')}}">
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-12 text-center">
                    <button class="btn btn-lg btn-primary mt-5" id="darkDemoBtn" type="button">Check Now<i
                            class="ti ti-chevrons-right ms-2"></i></button>
                </div>
            </div>
        </div>
    </section>
    <!-- Dark Mode section -->

    <!-- Customization  options section start -->
    <section class="options-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 offset-xl-3">
                    <div class="landing-title text-md-center">
                        <h2><span class="highlight-title">Customization</span> and preview</h2>
                        <p>Allow users to personalize settings or design elements in real-time, providing
                            an instant preview of
                            the changes before finalizing, ensuring a seamless and tailored experience</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-7">
                    <div class="card  sidebar-option-card">
                        <div class="card-body p-0">
                            <div class="">

                                <div class="">
                                    <h2 class="text-white f-w-600">Customize your <br> <span
                                            class="text-dark">sidebar</span> with ease</h2>
                                </div>
                                <div class="text-end">
                                    <img alt="layout-img" class="img-fluid mt-3"
                                         src="{{asset('../assets/images/landing/layout.png')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5">
                    <div class="card equal-card color-hint-card">
                        <div class="card-body">
                            <div class="marquee-animated">
                                <p>Preview variant colors for perfect customization!</p>
                            </div>
                            <div>
                                <img alt="" class="img-fluid" src="{{asset('../assets/images/landing/color-hint.gif')}}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card speed-performance-card">
                        <div class="card-body text-center">
                            <h3 class="text-dark f-w-600"><span class="text-success">Quick </span> Response</h3>
                            <div class="mt-5">
                                <img alt="" class="img-fluid" src="{{asset('../assets/images/landing/speed-performance.png')}}">
                            </div>

                            <div class="performance-content ">
                                <div class="text-end">
                                    <img alt="img" class="arrow-shape" src="{{asset('../assets/images/landing/arrow-shape.png')}}">
                                </div>
                                <div class="performance-number">
                                    <p class="f-w-500 f-s-18 text-dark">Performance</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 ">
                    <div class="card equal-card layout-option-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4 position-relative">
                                    <h3 class="text-light mt-3">One-Click and change your <span
                                            class="text-primary f-w-600">Layout.</span></h3>
                                    <svg class="text-brand absolute hidden md:block -left-12 xl:-left-24 -bottom-32 xl:-bottom-44 transition ease-in-out transform-gpu"
                                         fill="" height="132" viewBox="0 0 98 132"
                                         width="98"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M46.9684 132C46.3582 132 45.7557 132 45.1494 131.951C44.6766 131.926 44.2134 131.808 43.7861 131.603C43.3589 131.398 42.976 131.111 42.6593 130.758C42.3426 130.405 42.0982 129.993 41.9403 129.545C41.7824 129.098 41.7139 128.623 41.7388 128.149C41.7637 127.675 41.8815 127.21 42.0854 126.781C42.2893 126.353 42.5753 125.969 42.9272 125.651C43.2791 125.333 43.6899 125.088 44.1362 124.93C44.5825 124.771 45.0556 124.702 45.5283 124.727C59.2502 125.488 80.2707 113.551 88.494 95.2532C90.3887 91.0295 92.8253 83.1715 87.7777 78.0241C85.4623 75.6671 82.4724 74.3669 79.3953 73.7016C78.8117 74.5912 78.1978 75.458 77.546 76.3057C70.2663 85.7757 55.3659 99.5491 44.1982 98.6861C40.3329 98.3896 37.2785 96.4051 35.3686 92.9076C33.7959 90.0412 33.8528 86.6729 35.5278 83.4262C36.8428 80.8829 39.1126 78.3929 42.2807 76.0282C50.4888 69.8924 63.7825 65.2924 75.5111 65.95C79.9145 56.9515 80.4943 46.5046 76.269 41.2051C74.1355 38.5211 70.2057 34.8601 60.7584 34.0465C57.9495 33.8716 55.1304 33.9607 52.3381 34.3127C48.954 44.6038 40.4238 53.7999 32.5492 57.6548C25.6295 61.0421 19.7141 60.046 16.7317 54.9936C13.4121 49.3672 14.837 44.8052 16.6104 41.9654C21.4042 34.3089 34.9517 29.8381 46.4605 27.8993C46.8775 25.1558 46.5865 22.3509 45.6155 19.7523C43.6866 14.8102 39.3741 10.826 33.7846 8.82636C26.1677 6.10057 16.1709 6.92552 4.8781 11.2328C4.43594 11.401 3.96514 11.4803 3.49246 11.466C3.01978 11.4517 2.55454 11.3441 2.12329 11.1494C1.25236 10.7562 0.572784 10.032 0.234084 9.13617C-0.104616 8.24033 -0.0747715 7.24622 0.317165 6.3725C0.709101 5.49878 1.43098 4.81707 2.32397 4.47729C15.4206 -0.510484 26.8195 -1.33547 36.2062 2.02519C43.7549 4.72817 49.6286 10.2292 52.3192 17.1178C53.5254 20.2528 54.0299 23.6155 53.7971 26.9678C56.3162 26.7255 58.8507 26.6861 61.3761 26.85C70.5506 27.6408 77.2656 30.8607 81.9039 36.7039C87.5693 43.8358 87.6603 56.1151 82.8893 67.1666C86.6655 68.1971 90.111 70.1919 92.8898 72.9565C98.8621 79.0391 99.6276 88.0187 95.0385 98.2223C87.5883 114.893 66.7497 132 46.9684 132ZM70.8423 73.1922C69.8684 73.2568 68.9665 73.3519 68.1707 73.4583C60.4022 74.4848 52.1373 77.6934 46.6008 81.822C43.6298 84.0383 40.5641 87.3648 41.6744 89.4253C42.4096 90.7597 43.3266 91.3755 44.7514 91.4858C50.6972 91.961 62.3766 83.6885 70.8423 73.196V73.1922ZM44.0504 35.6889C34.8987 37.6619 25.622 41.2165 22.742 45.8165C21.9841 47.0482 21.3928 48.6639 22.9617 51.3213C24.163 53.359 27.5091 52.1044 29.4266 51.173C34.8722 48.5157 40.7611 42.4938 44.058 35.6927L44.0504 35.6889Z"
                                              fill="#ebc33f"></path>
                                    </svg>
                                </div>
                                <div class="col-sm-8 z-1">
                                    <img alt="layout-img" class="img-fluid mt-4"
                                         src="{{asset('../assets/images/landing/layout-option.png')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Customization  options section end -->


    <!-- wrapper Section  -->
    <section class="box-wrapper-section p-0">
        <div class="container-fluid box-wrapper">
            <ul class="box-wrapper-list">
                <li> Fully Customizable</li>
                <li>Google Font</li>
                <li>10+ Apps</li>
                <li>Fully Customizable</li>
                <li>100+ Custom Elements</li>
                <li>Mobile Responsive design</li>
                <li>150+ Pages</li>
                <li>Creative Card Design</li>
                <li>4+ Icons Set</li>
                <li>Quick Response</li>
                <li>Multiple Sidebar Options</li>

                <li> Fully Customizable</li>
                <li>Google Font</li>
                <li>10+ Apps</li>
                <li>Fully Customizable</li>
                <li>100+ Custom Elements</li>
                <li>Mobile Responsive design</li>
                <li>150+ Pages</li>
                <li>Creative Card Design</li>
                <li>4+ Icons Set</li>
                <li>Quick Response</li>
                <li>Multiple Sidebar Options</li>
            </ul>
        </div>
    </section>

    <!-- wrapper Section -->

    <!-- Purchase Plans section start  -->
    <section class="plans-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 offset-xl-3">
                    <div class="landing-title text-md-center">
                        <h2>Purchase <span class="highlight-title">Plans</span></h2>
                        <p>Include information on how users can navigate your platform, select a plan, and
                            complete the
                            transaction.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-7 col-xl-8">
                    <div class="card pricing-cards mb-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-5 col-xl-6">
                                    <div>
                                        <img alt="img" class="w-120" src="{{asset('../assets/images/landing/wallet.png')}}">
                                        <div>
                                            <p class="badge bg-light-success f-s-16 mt-3">Basic Plans</p>
                                            <h1 class="text-success-dark f-w-700 mt-3">$14.00</h1>
                                            <p class="text-success  txt-ellipsis-3 f-w-500 f-s-16"> Essential features
                                                at
                                                the best
                                                value. Get started today with our budget-friendly pricing! </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-xl-6 ">
                                    <div class="pricing-details">
                                        <div class="price-title">
                                            <h3 class="text-success-dark  f-w-600 txt-ellipsis-1">Basic Plans List</h3>
                                            <ul class="pricing-list-menu">
                                                <li class="pricing-listitem text-success f-w-500"><i
                                                        class="ph-bold  ph-check text-success me-2"></i>6 Month support
                                                </li>
                                                <li class="pricing-listitem text-success f-w-500"><i
                                                        class="ph-bold  ph-check text-success me-2"></i>Single end
                                                    product use
                                                </li>
                                                <li class="pricing-listitem text-success f-w-500"><i
                                                        class="ph-bold  ph-check text-success me-2"></i>Future upgrades
                                                    included
                                                </li>
                                                <li class="pricing-listitem text-success f-w-500"><i
                                                        class="ph-bold  ph-check text-success me-2"></i>Free for use in
                                                    end products
                                                </li>
                                            </ul>
                                            <div class="text-center price-btn">
                                                <a class="btn btn-lg btn-success rounded" href="https://themeforest.net/user/la-themes"
                                                   target="_blank">Buy
                                                    Plans</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-5 col-xl-4">
                    <div class="card pricing-cards active mb-0">
                        <div class="card-body p-0">
                            <div class="pricing-details">
                                <div class="price-title">
                                    <p class="text-primary-dark">Business Plans</p>
                                    <h2>$499.00</h2>
                                    <ul class="pricing-list-menu">
                                        <li class="pricing-listitem text-primary-dark f-w-500"><i
                                                class="ph-bold  ph-check text-success me-2"></i>6 Month support
                                        </li>
                                        <li class="pricing-listitem text-primary-dark f-w-500"><i
                                                class="ph-bold  ph-check text-success me-2"></i>Single end product use
                                        </li>
                                        <li class="pricing-listitem text-primary-dark f-w-500"><i
                                                class="ph-bold  ph-check text-success me-2"></i>Future upgrades included
                                        </li>
                                        <li class="pricing-listitem text-primary-dark f-w-500"><i
                                                class="ph-bold  ph-check text-success me-2"></i>Free for use in end
                                            products
                                        </li>
                                    </ul>
                                    <div class="text-center price-btn">
                                        <a class="btn btn-lg btn-primary rounded" href="https://themeforest.net/user/la-themes" target="_blank">Buy
                                            Plans</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Purchase Plans section end  -->

    <!-- footer -->
    <section class="landing-footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footer-content text-center">
                        <img alt="logo" src="{{asset('../assets/images/logo/4.png')}}">
                        <h1>Build a <span class="highlight-title"> Startling </span> site</h1>
                        <p class="txt-ellipsis-3">Purchase The axelit & Craft Your Site Super Faster And powerful.
                            Discover the axelit
                            Admin Theme.
                            If you enjoy our template, please take a moment to rate us</p>
                        <div class="footer-btn">
                            <a class="btn btn-primary btn-lg" href="https://themeforest.net/user/la-themes"
                               target="_blank">Buy Now</a>
                            <a class="btn btn-danger btn-lg" href="mailto:teqlathemes@gmail.com"
                               target="_blank">Need Help ?</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- footer -->
</div>
<!-- Landing page end -->


<!-- tap on top -->
<div class="go-top">
    <span class="progress-value">
      <i class="ti ti-arrow-up"></i>
    </span>
</div>


<!-- latest jquery-->
<script src="{{asset('assets/js/jquery-3.6.3.min.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>

<!-- phosphor js -->
<script src="{{asset('assets/vendor/phosphor/phosphor.js')}}"></script>

<!-- aos js-->
<script src="{{asset('assets/vendor/aos/aos.js')}}"></script>

<!--typed js-->
<script src="{{asset('assets/vendor/typed/typed.umd.js')}}"></script>

<!-- slick-file -->
<script src="{{asset('assets/vendor/slick/slick.min.js')}}"></script>

<!--js-->
<script src="{{asset('assets/js/landing.js')}}"></script>


</body>

</html>
