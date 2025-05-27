<!-- Header Section starts -->
<header class="header-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-sm-4 d-flex align-items-center header-left p-0">
                <span class="header-toggle me-3">
                    <i class="iconoir-view-grid"></i>
                </span>
            </div>

            <div class="col-6 col-sm-8 d-flex align-items-center justify-content-end header-right p-0">

                <ul class="d-flex align-items-center">
                    
                    {{-- <li>
                        <!-- Example: index.blade.php -->
                        @auth
                        <div class="user-info">
                            <p>Welcome, {{ auth()->user()->name }}</p>
                        </div>
                        @endauth
                    </li> --}}

                    {{-- <li class="header-cloud">
                        <a aria-controls="cloudoffcanvasTops" class="head-icon"
                           data-bs-target="#cloudoffcanvasTops" data-bs-toggle="offcanvas"
                           href="#" role="button">
                            <i class="iconoir-dew-point text-primary f-s-26 me-1"></i>
                            <span class="f-w-600">26 <sup class="f-s-10">°C</sup></span>
                        </a>

                        <div aria-labelledby="cloudoffcanvasTops"
                             class="offcanvas offcanvas-end header-cloud-canvas"
                             id="cloudoffcanvasTops"
                             tabindex="-1">
                            <div class="offcanvas-body p-0">
                                <div class="cloud-body">

                                    <div class="cloud-content-box">
                                        <div class="cloud-box bg-primary-900">
                                            <p class="mb-3">Mon</p>
                                            <h6 class="mt-4 f-s-13"> +29°C</h6>
                                            <span>
                                <i class="ph-duotone  ph-cloud-fog text-white f-s-25"></i>
                              </span>
                                            <p class="f-s-13 mt-3"><i class="wi wi-raindrop"></i> 2%</p>
                                        </div>
                                        <div class="cloud-box bg-primary-800">
                                            <p class="mb-3">Tue</p>
                                            <h6 class="mt-4 f-s-13"> +29°C</h6>
                                            <span>
                                <i class="ph-duotone  ph-cloud-sun text-white f-s-25"></i>
                              </span>
                                            <p class="f-s-13 mt-3"><i class="wi wi-raindrop"></i> 2%</p>
                                        </div>
                                        <div class="cloud-box bg-primary-700">
                                            <p class="mb-3 text-light">Wed</p>
                                            <h6 class="mt-4 f-s-13"> +20°C</h6>
                                            <span>
                                <i class="ph-duotone  ph-sun-dim text-white f-s-25"></i>
                              </span>
                                            <p class="f-s-13 mt-3"><i class="wi wi-raindrop"></i> 1%</p>
                                        </div>
                                        <div class="cloud-box bg-primary-600">
                                            <p class="mb-3">Thu</p>
                                            <h6 class="mt-4 f-s-13"> +17°C</h6>
                                            <span>
                                <i class="ph-duotone  ph-sun-dim text-white f-s-25"></i>
                              </span>
                                            <p class="f-s-13 mt-3"><i class="wi wi-raindrop"></i> 1%</p>
                                        </div>
                                        <div class="cloud-box bg-primary-500">
                                            <p class="mb-3">Fri</p>
                                            <h6 class="mt-4 f-s-13"> +18°C</h6>
                                            <span>
                                <i class="ph-duotone  ph-sun-dim text-white f-s-25"></i>
                              </span>
                                            <p class="f-s-13 mt-3"><i class="wi wi-raindrop"></i> 1%</p>
                                        </div>
                                        <div class="cloud-box bg-primary-400">
                                            <p class="mb-3">Sat</p>
                                            <h6 class="mt-4 f-s-13"> +16°C</h6>
                                            <span>
                                <i class="ph-duotone  ph-sun-dim text-white f-s-25"></i>
                              </span>
                                            <p class="f-s-13 mt-3"><i class="wi wi-raindrop"></i> 1%</p>
                                        </div>
                                        <div class="cloud-box bg-primary-300">
                                            <p class="mb-3">Sun</p>
                                            <h6 class="mt-4 f-s-13"> +29°C</h6>
                                            <span class="mb-3">
                                <i class="ph-duotone  ph-sun-dim text-white f-s-25"></i>
                              </span>
                                            <p class="f-s-13 mt-3"><i class="wi wi-raindrop"></i> 1%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li> --}}

                    {{-- <li class="header-language">
                        <div class="flex-shrink-0 dropdown" id="lang_selector">
                            <a aria-expanded="false" class="d-block head-icon ps-0"
                               data-bs-toggle="dropdown"
                               href="#">
                                <div class="lang-flag lang-en ">
                          <span class="flag rounded-circle overflow-hidden">
                            <i class=""></i>
                          </span>
                                </div>
                            </a>
                            <ul class="dropdown-menu language-dropdown header-card border-0">
                                <li class="lang lang-en selected dropdown-item p-2" data-bs-placement="top"
                                    data-bs-toggle="tooltip" title="US">
                          <span class="d-flex align-items-center">
                            <i class="flag-icon flag-icon-usa flag-icon-squared b-r-10 f-s-22"></i>
                            <span class="ps-2">English</span>
                          </span>
                                </li>
                                <li class="lang lang-pt dropdown-item p-2" title="FR">
                          <span class="d-flex align-items-center">
                            <i class="flag-icon flag-icon-fra flag-icon-squared b-r-10 f-s-22"></i>
                            <span class="ps-2">Française </span>
                          </span>
                                </li>
                                <li class="lang lang-es dropdown-item p-2" title="UK">
                          <span class="d-flex align-items-center">
                            <i class="flag-icon flag-icon-gbr flag-icon-squared b-r-10 f-s-22"></i>
                            <span class="ps-2">English</span>
                          </span>
                                </li>
                                <li class="lang lang-es dropdown-item p-2" title="Ru">
                          <span class="d-flex align-items-center">
                              <i class="flag-icon flag-icon-rus flag-icon-squared b-r-10 f-s-22"></i>
                            <span class="ps-2">Русская</span>
                          </span>
                                </li>
                                <li class="lang lang-es dropdown-item p-2" title="IT">
                          <span class="d-flex align-items-center">
                            <i class="flag-icon flag-icon-ita flag-icon-squared b-r-10 f-s-22"></i>
                            <span class="ps-2">française</span>
                          </span>
                                </li>
                            </ul>
                        </div>

                    </li> --}}

                    <li class="header-searchbar">
                        <a aria-controls="offcanvasRight" class="d-block head-icon"
                            data-bs-target="#offcanvasRight" data-bs-toggle="offcanvas"
                            href="#" role="button">
                            <i class="iconoir-search"></i>
                        </a>

                        <div aria-labelledby="offcanvasRight"
                            class="offcanvas offcanvas-end header-searchbar-canvas"
                            id="offcanvasRight"
                            tabindex="-1">
                            <div class="header-searchbar-header">
                                <div class="d-flex justify-content-between mb-3">
                                    <form action="#" class="app-form app-icon-form w-100">
                                        <div class="position-relative">
                                            <input id="liveSearch" class="form-control search-filter" placeholder="Search..." type="search" autocomplete="off">
                                            <i class="ti ti-search text-dark"></i>
                                        </div>
                                    </form>
                                </div>
                                <p class="mb-0 text-secondary f-s-15 mt-2">Search result:</p>
                            </div>
                            <div class="offcanvas-body app-scroll p-0">
                                <div>
                                    <ul id="searchResults" class="search-list">
                                        <!-- AJAX results will go here -->
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </li>

                    {{-- <li class="header-apps">
                        <a aria-controls="appscanvasRights" class="d-block head-icon"
                           data-bs-target="#appscanvasRights" data-bs-toggle="offcanvas"
                           href="#" role="button">
                            <i class="iconoir-key-command"></i>
                        </a>

                        <div aria-labelledby="appscanvasRightsLabel"
                             class="offcanvas offcanvas-end header-apps-canvas"
                             id="appscanvasRights"
                             tabindex="-1">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="appscanvasRightsLabel">Shortcut</h5>
                                <div class="app-dropdown flex-shrink-0">
                                    <a aria-expanded="false" class=" p-1" data-bs-auto-close="outside"
                                       data-bs-toggle="dropdown"
                                       href="#"
                                       role="button">
                                        <i class="ph-bold  ph-faders-horizontal f-s-20"></i>
                                    </a>
                                    <ul class="dropdown-menu mb-3 p-2">
                                        <li class="dropdown-item">
                                            <a href="{{route('setting')}}" target="_blank">
                                                Privacy Settings
                                            </a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a href="{{route('setting')}}" target="_blank">
                                                Account Settings
                                            </a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a href="{{route('setting')}}" target="_blank">
                                                Accessibility
                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li class="dropdown-item border-0">
                                            <a aria-expanded="false" data-bs-toggle="dropdown" href="#"
                                               role="button">
                                                More Settings
                                            </a>
                                            <ul class="dropdown-menu sub-menu">
                                                <li class="dropdown-item">
                                                    <a href="{{route('setting')}}" target="_blank">
                                                        Backup and Restore
                                                    </a>
                                                </li>
                                                <li class="dropdown-item">
                                                    <a href="{{route('setting')}}" target="_blank">
                                                        <span>Data Usage</span>
                                                    </a>
                                                </li>
                                                <li class="dropdown-item">
                                                    <a href="{{route('setting')}}" target="_blank">
                                                        <span>Theme</span>
                                                    </a>
                                                </li>
                                                <li class="dropdown-item d-flex align-items-center justify-content-between">
                                                    <a href="{{route('setting')}}" target="_blank">
                                                        <p class="mb-0">Notification</p>
                                                    </a>
                                                    <div class="flex-shrink-0">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input  form-check-primary"
                                                                   id="notificationSwitch"
                                                                   type="checkbox">
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="offcanvas-body app-scroll">
                                <div class="row row-cols-3">
                                    <div class="d-flex-center text-center mb-3">
                                        <a href="{{route('product')}}" target="_blank">
                                                         <span class="text-light-info h-45 w-45 d-flex-center b-r-15">
                                                           <i class="ph-duotone  ph-shopping-bag-open f-s-30"></i>
                                                         </span>
                                            <p class="mb-0 f-w-500 text-info">E-shop</p>
                                        </a>
                                    </div>
                                    <div class="d-flex-center text-center mb-3">
                                        <a href="{{route('email')}}" target="_blank">
                                                        <span
                                                            class="text-light-primary h-45 w-45 d-flex-center b-r-15 position-relative">
                                                          <i class="ph-duotone  ph-envelope f-s-30"></i>
                                                            <span
                                                                class="position-absolute top-space-5 start-100 translate-middle p-1 bg-primary-dark rounded-circle animate__animated animate__fadeIn animate__infinite animate__fast"></span>
                                                        </span>
                                            <p class="mb-0 f-w-500 text-primary">Email</p>
                                        </a>
                                    </div>
                                    <div class="d-flex-center text-center mb-3">
                                        <a href="{{route('chat')}}" target="_blank">
                                                         <span
                                                             class="text-light-danger h-45 w-45 d-flex-center b-r-15 position-relative">
                                                           <i class="ph-duotone  ph-chat-circle-text f-s-30"></i>
                                                             <span
                                                                 class="position-absolute top-space-5 start-100 translate-middle badge rounded-pill bg-success badge-notification">
                                                                    99+
                                                                    <span class="visually-hidden">unread messages</span>
                                                             </span>
                                                         </span>
                                            <p class="mb-0 f-w-500 text-danger">Chat</p>
                                        </a>
                                    </div>
                                    <div class="d-flex-center text-center mb-3">
                                        <a href="{{route('project_app')}}" target="_blank">
                                                         <span
                                                             class="text-light-warning h-45 w-45 d-flex-center b-r-15">
                                                             <i class="ph-duotone ph-projector-screen-chart f-s-30"></i>
                                                         </span>
                                            <p class="mb-0 f-w-500 text-warning">Project</p>
                                        </a>
                                    </div>
                                    <div class="d-flex-center text-center mb-3">
                                        <a href="{{route('invoice')}}" target="_blank">
                                                        <span
                                                            class="text-light-secondary h-45 w-45 d-flex-center b-r-15">
                                                            <i class="ph-duotone ph-scroll f-s-30"></i>
                                                        </span>
                                            <p class="mb-0 f-w-500 text-secondary">Invoice</p>
                                        </a>
                                    </div>
                                    <div class="d-flex-center text-center mb-3">
                                        <a href="{{route('blog')}}" target="_blank">
                                                        <span class="text-light-primary h-45 w-45 d-flex-center b-r-15">
                                                            <i class="ph-duotone ph-notebook f-s-30"></i>
                                                        </span>
                                            <p class="mb-0 f-w-500 text-primary">Blog</p>
                                        </a>
                                    </div>
                                    <div class="d-flex-center text-center mb-3">
                                        <a href="{{route('profile')}}" target="_blank">
                                                        <span
                                                            class="text-light-primary h-45 w-45 d-flex-center b-r-15 position-relative">
                                                            <i class="ph-duotone ph-users-three f-s-30"></i>
                                                            <span
                                                                class="position-absolute top-space-5 start-100 translate-middle badge rounded-pill bg-danger badge-notification">
                                                                <i class="ti ti-bell-ringing"></i>
                                                            </span>
                                                        </span>
                                            <p class="mb-0 f-w-500 text-primary">Profile</p>
                                        </a>
                                    </div>
                                    <div class="d-flex-center text-center mb-3">
                                        <a href="{{route('gallery')}}" target="_blank">
                                                        <span class="text-light-success h-45 w-45 d-flex-center b-r-15">
                                                            <i class="ph-duotone ph-google-photos-logo f-s-30"></i>
                                                        </span>
                                            <p class="mb-0 f-w-500 text-success">Gallery</p>
                                        </a>
                                    </div>
                                    <div class="d-flex-center text-center mb-3">
                                        <a href="{{route('kanban_board')}}" target="_blank">
                                                        <span class="text-light-info h-45 w-45 d-flex-center b-r-15">
                                                            <i class="ph-duotone ph-selection-foreground text-info f-s-30"></i>
                                                        </span>
                                            <p class="mb-0 f-w-500 text-secondary">Task </p>
                                        </a>
                                    </div>
                                    <div class="d-flex-center text-center mb-3">
                                        <a href="{{route('calendar')}}" target="_blank">
                                                        <span class="text-light-dark h-45 w-45 d-flex-center b-r-15">
                                                            <i class="ph-duotone ph-calendar f-s-30"></i>
                                                        </span>
                                            <p class="mb-0 f-w-500 text-dark">Calen..</p>
                                        </a>
                                    </div>
                                    <div class="d-flex-center text-center mb-3">
                                        <a href="{{route('file_manager')}}" target="_blank">
                                                        <span class="text-light-danger h-45 w-45 d-flex-center b-r-15">
                                                            <i class="ph-duotone ph-folder-open f-s-30"></i>
                                                        </span>
                                            <p class="mb-0 f-w-500 text-danger">File Ma..</p>
                                        </a>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </li> --}}

                    {{-- <li class="header-cart">
                        <a aria-controls="cartcanvasRight" class="d-block head-icon position-relative"
                           data-bs-target="#cartcanvasRight"
                           data-bs-toggle="offcanvas"
                           href="#" role="button">
                            <i class="iconoir-shopping-bag"></i>
                            <span
                                class="position-absolute translate-middle badge rounded-pill bg-danger badge-notification">4</span>
                        </a>
                        <div aria-labelledby="cartcanvasRightLabel"
                             class="offcanvas offcanvas-end header-cart-canvas"
                             id="cartcanvasRight"
                             tabindex="-1">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="cartcanvasRightLabel">Cart</h5>
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas"
                                        type="button"></button>
                            </div>
                            <div class="offcanvas-body app-scroll p-0">
                                <div class="head-container">
                                    <div class="head-box">
                                        <img alt="cart" class="h-50 me-3 b-r-10"
                                             src="../assets/images/ecommerce/19.jpg">
                                        <div class="flex-grow-1">
                                            <a class="text-primary-dark mb-0 f-w-600 f-s-16"
                                               href="{{route('product_details')}}" target="_blank">
                                                Backpacks <span class="text-warning-dark"> (3<i
                                                        class="ti ti-star-filled text-warning f-s-12"></i>)</span>
                                            </a>
                                            <div>
                                                            <span class="text-secondary"><span
                                                                    class="text-dark f-w-500">size</span> : medium</span>
                                                <span class="text-secondary ms-2"><span
                                                        class="text-dark f-w-500">Color</span> :Pink</span>
                                            </div>

                                        </div>
                                        <div class="text-end">
                                            <i class="iconoir-xmark close-btn"></i>
                                            <p class="text-success f-w-500 mb-0">$600.50 x 1</p>
                                        </div>
                                    </div>
                                    <div class="head-box">
                                        <img alt="cart" class="h-50 object-fit-cover me-3 b-r-10"
                                             src="../assets/images/ecommerce/13.jpg">
                                        <div class="flex-grow-1">
                                            <a class="text-info-dark mb-0 f-w-600 f-s-16"
                                               href="{{route('product_details')}}" target="_blank">
                                                Women's Watch<span class="text-warning-dark"> (4<i
                                                        class="ti ti-star-filled text-warning f-s-12"></i>)</span>
                                            </a>
                                            <div>
                                                            <span class="text-secondary"><span
                                                                    class="text-dark f-w-500">size</span> : small</span>
                                                <span class="text-secondary ms-2"><span
                                                        class="text-dark f-w-500">Color</span> : RoseGold</span>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <i class="iconoir-xmark close-btn"></i>
                                            <p class="text-success f-w-500 mb-0">$519.10 x 2</p>
                                        </div>
                                    </div>
                                    <div class="head-box">
                                        <img alt="cart" class="h-50 object-fit-cover me-3 b-r-10"
                                             src="../assets/images/ecommerce/09.jpg">
                                        <div class="flex-grow-1">
                                            <a class="text-danger-dark mb-0 f-w-600 f-s-16"
                                               href="{{route('product_details')}}" target="_blank">Sandals<span
                                                    class="text-warning-dark"> (5<i
                                                        class="ti ti-star-filled text-warning f-s-12"></i>)</span>
                                            </a>
                                            <div>
                                                            <span class="text-secondary"><span
                                                                    class="text-dark f-w-500">size</span> : 8</span>
                                                <span class="text-secondary ms-2"><span
                                                        class="text-dark f-w-500">Color</span> :White</span>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <i class="iconoir-xmark close-btn"></i>
                                            <p class="text-success f-w-500 mb-0">$390 x 2</p>
                                        </div>
                                    </div>
                                    <div class="head-box ">
                                        <img alt="cart" class="h-50 object-fit-cover me-3 b-r-10"
                                             src="../assets/images/ecommerce/23.jpg">
                                        <div class="flex-grow-1">
                                            <a class="text-success-dark mb-0 f-w-600 f-s-16"
                                               href="{{route('product_details')}}" target="_blank">
                                                Jackets<span class="text-warning-dark"> (3<i
                                                        class="ti ti-star-filled text-warning f-s-12"></i>)</span>
                                            </a>
                                            <div>
                                                            <span class="text-secondary"><span
                                                                    class="text-dark f-w-500">size</span> : XL</span>
                                                <span class="text-secondary ms-2"><span
                                                        class="text-dark f-w-500">Color</span> :Blue</span>
                                            </div>

                                        </div>
                                        <div class="text-end">
                                            <i class="iconoir-xmark close-btn"></i>
                                            <p class="text-success f-w-500 mb-0">$300.00 x 2</p>
                                        </div>
                                    </div>
                                    <div class="head-box ">
                                        <img alt="cart" class="h-50 object-fit-cover me-3 b-r-10"
                                                 src="../assets/images/ecommerce/11.jpg">
                                        <div class="flex-grow-1">
                                            <a class="text-dark-dark mb-0 f-w-600 f-s-16"
                                               href="{{route('product_details')}}" target="_blank">
                                                Shoes<span class="text-warning-dark"> (2<i
                                                        class="ti ti-star-filled text-warning f-s-12"></i>)</span>
                                            </a>
                                            <div>
                                                            <span class="text-secondary"><span
                                                                    class="text-dark f-w-500">size</span> : 9</span>
                                                <span class="text-secondary ms-2"><span
                                                        class="text-dark f-w-500">Color</span> :White</span>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <i class="iconoir-xmark close-btn"></i>
                                            <p class="text-success f-w-500 mb-0">$450.00 x 1</p>
                                        </div>
                                    </div>
                                    <div class="hidden-massage py-4 px-3">
                                        <img alt="cart" class="img-fluid mb-3"
                                             src="{{ asset('assets/images/header/cart_empty.gif') }}">
                                        <div>
                                            <h6 class="mb-0">Your Cart is Empty</h6>
                                            <p class="text-secondary mb-0">Add some items :)</p>
                                            <a class="btn btn-light-primary btn-xs mt-2"
                                               href="{{route('product_details')}}">Shop
                                                Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="offcanvas-footer">
                                <div class="head-box-footer p-3">
                                    <div class="mb-4">
                                        <h6 class="text-muted f-w-600">Total <span class="float-end">$3,468.00</span>
                                        </h6>
                                    </div>
                                    <div class="header-cart-btn">
                                        <a class="btn btn-light-primary" href=""{{route('cart')}}" role="button"
                                           target="_blank">
                                            <i class="ti ti-eye"></i> View Cart</a>
                                        <a class="btn btn-light-success" href="{{route('checkout')}}"
                                           role="button" target="_blank">
                                            Checkout <i class="ti ti-shopping-cart"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li> --}}

                    <li class="header-dark">
                        <div class="sun-logo head-icon">
                            <i class="iconoir-sun-light"></i>
                        </div>
                        <div class="moon-logo head-icon">
                            <i class="iconoir-half-moon"></i>
                        </div>
                    </li>

                    {{-- <li class="header-notification">
                        <a aria-controls="notificationcanvasRight"
                           class="d-block head-icon position-relative"
                           data-bs-target="#notificationcanvasRight"
                           data-bs-toggle="offcanvas"
                           href="#"
                           role="button">
                            <i class="iconoir-bell"></i>
                            <span
                                class="position-absolute translate-middle p-1 bg-success border border-light rounded-circle animate__animated animate__fadeIn animate__infinite animate__slower"></span>
                        </a>
                        <div aria-labelledby="notificationcanvasRightLabel"
                             class="offcanvas offcanvas-end header-notification-canvas"
                             id="notificationcanvasRight" tabindex="-1">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="notificationcanvasRightLabel">
                                    Notification</h5>
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas"
                                        type="button"></button>
                            </div>
                            <div class="offcanvas-body notification-offcanvas-body app-scroll p-0">
                                <div class="head-container notification-head-container">
                                    <div class="notification-message head-box">
                                        <div class="message-images">
                                                          <span
                                                              class="bg-secondary h-35 w-35 d-flex-center b-r-10 position-relative">
                                                            <img alt="avtar" class="img-fluid b-r-10"
                                                                 src="{{ asset('assets/images/ai_avtar/6.jpg') }}">
                                                            <span
                                                                class="position-absolute bottom-30 end-0 p-1 bg-secondary border border-light rounded-circle notification-avtar"></span>
                                                          </span>
                                        </div>
                                        <div class="message-content-box flex-grow-1 ps-2">

                                            <a class="f-s-15 text-secondary mb-0"
                                               href="{{route('read_email')}}" target="_blank"><span
                                                    class="f-w-500 text-secondary">Gene Hart</span> wants to
                                                edit <span
                                                    class="f-w-500 text-secondary">Report.doc</span></a>
                                            <div>
                                                <a class="d-inline-block f-w-500 text-success me-1"
                                                   href="#">Approve</a>
                                                <a class="d-inline-block f-w-500 text-danger"
                                                   href="#">Deny</a>
                                            </div>
                                            <span class="badge text-light-primary mt-2"> sep 23 </span>

                                        </div>
                                        <div class="align-self-start text-end">
                                            <i class="iconoir-xmark close-btn"></i>
                                        </div>
                                    </div>
                                    <div class="notification-message head-box">
                                        <div class="message-images">
                                                        <span
                                                            class="bg-light-dark h-35 w-35 d-flex-center b-r-10 position-relative">
                                                          <i class="ph-duotone  ph-truck f-s-18"></i>
                                                        </span>
                                        </div>
                                        <div class="message-content-box flex-grow-1 ps-2">
                                            <a class="f-s-15 text-secondary mb-0" href="{{route('read_email')}}"
                                               target="_blank">Hey
                                                <span
                                                    class="f-w-500 text-secondary">Emery McKenzie</span>,
                                                get ready: Your order from <span
                                                    class="f-w-500 text-secondary">@Shopper.com</span>
                                                is out for delivery today!</a>
                                            <span class="badge text-light-info mt-2"> sep 23 </span>

                                        </div>
                                        <div class="align-self-start text-end">
                                            <i class="iconoir-xmark close-btn"></i>
                                        </div>
                                    </div>
                                    <div class="notification-message head-box">
                                        <div class="message-images">
                                                       <span
                                                           class="bg-secondary h-35 w-35 d-flex-center b-r-10 position-relative">
                                                         <img alt="" class="img-fluid b-r-10"
                                                              src="{{ asset('assets/images/ai_avtar/2.jpg') }}">
                                                         <span
                                                             class="position-absolute  end-0 p-1 bg-secondary border border-light rounded-circle notification-avtar"></span>
                                                       </span>
                                        </div>
                                        <div class="message-content-box flex-grow-1 ps-2">
                                            <a class="f-s-15 text-secondary mb-0"
                                               href="{{route('read_email')}}" target="_blank"><span
                                                    class="f-w-500 text-secondary">Simon Young</span> shared
                                                a file called <span
                                                    class="f-w-500 text-secondary">Dropdown.pdf</span></a>
                                            <span class="badge text-light-success mt-2"> 30 min</span>

                                        </div>
                                        <div class="align-self-start text-end">
                                            <i class="iconoir-xmark close-btn"></i>
                                        </div>
                                    </div>
                                    <div class="notification-message head-box">
                                        <div class="message-images">
                                                       <span
                                                           class="bg-secondary h-35 w-35 d-flex-center b-r-10 position-relative">
                                                         <img alt="" class="img-fluid b-r-10"
                                                              src="{{ asset('assets/images/ai_avtar/5.jpg') }}">
                                                         <span
                                                             class="position-absolute end-0 p-1 bg-secondary border border-light rounded-circle notification-avtar"></span>
                                                       </span>
                                        </div>
                                        <div class="message-content-box flex-grow-1 ps-2">
                                            <a class="f-s-15 text-secondary mb-0"
                                               href="{{route('read_email')}}" target="_blank"><span
                                                    class="f-w-500 text-secondary">Becky G. Hayes</span> has
                                                added a comment to <span
                                                    class="f-w-500 text-secondary">Final_Report.pdf</span></a>
                                            <span class="badge text-light-warning mt-2"> 45 min</span>
                                        </div>
                                        <div class="align-self-start text-end">
                                            <i class="iconoir-xmark close-btn"></i>
                                        </div>
                                    </div>
                                    <div class="notification-message head-box">
                                        <div class="message-images">
                                                        <span
                                                            class="bg-secondary h-35 w-35 d-flex-center b-r-10 position-relative">
                                                          <img alt="" class="img-fluid b-r-10"
                                                               src="{{ asset('assets/images/ai_avtar/1.jpg') }}">
                                                          <span
                                                              class="position-absolute  end-0 p-1 bg-secondary border border-light rounded-circle notification-avtar"></span>
                                                        </span>
                                        </div>
                                        <div class="message-content-box flex-grow-1 ps-2">
                                            <a class="f-s-15 text-secondary mb-0"
                                               href="{{route('read_email')}}" target="_blank"><span
                                                    class="f-w-600 text-secondary">Romaine Nadeau</span>
                                                invited you to join a meeting
                                            </a>
                                            <div>
                                                <a class="d-inline-block f-w-500 text-success me-1"
                                                   href="#">Join</a>
                                                <a class="d-inline-block f-w-500 text-danger" href="#">Decline</a>
                                            </div>

                                            <span class="badge text-light-secondary mt-2"> 1 hour ago </span>
                                        </div>
                                        <div class="align-self-start text-end">
                                            <i class="iconoir-xmark close-btn"></i>
                                        </div>
                                    </div>

                                    <div class="hidden-massage py-4 px-3">
                                        <img alt=""
                                             class="w-50 h-50 mb-3 mt-2"
                                             src="{{ asset('assets/images/icons/bell.png') }}">
                                        <div>
                                            <h6 class="mb-0">Notification Not Found</h6>
                                            <p class="text-secondary">When you have any notifications added
                                                here,will
                                                appear here.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li> --}}

                    @auth
                        <li class="header-level">
                            <span class="badge bg-primary">Level {{ auth()->user()->userPoints?->level ?? '0' }}</span>
                        </li>
                        

                        <li class="header-profile">
                            <a aria-controls="profilecanvasRight" class="d-block head-icon"
                            data-bs-target="#profilecanvasRight" data-bs-toggle="offcanvas"
                            href="#" role="button">
                                <img alt="avtar" class="b-r-50 h-35 w-35 bg-dark"
                                    src="{{ asset(auth()->user()->image ? 'storage/uploads/profile_picture/' . auth()->user()->image : '../assets/images/avtar/woman.jpg') }}">
                            </a>

                            <div aria-labelledby="profilecanvasRight"
                                class="offcanvas offcanvas-end header-profile-canvas"
                                id="profilecanvasRight"
                                tabindex="-1">
                                <div class="offcanvas-body app-scroll">
                                    <ul class="">
                                        <li class="d-flex gap-3 mb-3">
                                            <div class="d-flex-center">
                                                <span class="h-45 w-45 d-flex-center b-r-10 position-relative">
                                                    <img alt="" class="img-fluid b-r-10"
                                                        src="{{ asset(auth()->user()->image ? 'storage/uploads/profile_picture/' . auth()->user()->image : '../assets/images/avtar/woman.jpg') }}">
                                                </span>
                                            </div>
                                            <div class="text-center mt-2">
                                                <h6 class="mb-0">{{'@' . auth()->user()->username }} 
                                                    {{-- <img
                                                        alt="instagram-check-mark"
                                                        class="w-20 h-20"
                                                        src="/assets/images/profile-app/01.png"> --}}
                                                    </h6>
                                                <p class="f-s-12 mb-0 text-secondary">{{ auth()->user()->email }}</p>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="f-w-500" href="{{route('user.my_profile')}}">
                                                <i class="iconoir-user-love pe-1 f-s-20"></i> Profile
                                                Details
                                            </a>
                                        </li>
                                        {{-- <li>
                                            <a class="f-w-500" href="{{route('setting')}}" target="_blank">
                                                <i class="iconoir-settings pe-1 f-s-20"></i> Settings
                                            </a>
                                        </li>
                                        <li class="app-divider-v dotted py-1"></li>
                                        <li>
                                            <div class="app-dropdown dropstart">
                                                <a aria-expanded="false" class="f-w-500"
                                                data-bs-toggle="dropdown"
                                                href="{{route('setting')}}"
                                                role="button" target="_blank">
                                                    <i class="iconoir-eye-closed pe-1 f-s-20"></i> Hide
                                                    Settings
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item">Hide Comments</a></li>
                                                    <li><a class="dropdown-item">Advanced comment filtering</a>
                                                    </li>
                                                    <li><a class="dropdown-item">Hide mssage request</a></li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li><a class="dropdown-item">Separated link</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <a class="f-w-500" href="#">
                                                    <i class="iconoir-bell-notification pe-1 f-s-20"></i>
                                                    Notification
                                                </a>
                                                <div class="flex-shrink-0">
                                                    <div class="form-check form-switch">
                                                        <input checked
                                                            class="form-check-input form-check-primary"
                                                            id="basicSwitch"
                                                            type="checkbox">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <a class="f-w-500" href="#">
                                                        <i class="ph-duotone  ph-detective pe-1 f-s-20"></i>
                                                        Incognito
                                                    </a>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input form-check-primary"
                                                            id="incognitoSwitch"
                                                            type="checkbox">
                                                    </div>
                                                </div>
                                            </div>
                                        </li> --}}
                                        <li class="app-divider-v dotted py-1"></li>
                                        {{-- <li>
                                            <a class="f-w-500" href="{{route('faq')}}" target="_blank">
                                                <i class="iconoir-help-circle pe-1 f-s-20"></i> Help
                                            </a>
                                        </li> --}}
                                        <li>
                                            <a class="mb-0 text-secondary f-w-500" href="{{route('register')}}"
                                            target="_blank">
                                                <i class="iconoir-plus pe-1 f-s-20"></i> Add account
                                            </a>
                                        </li>
                                        <li>
                                            <div class="w-100">
                                                <form method="POST" action="{{ route('auth.sign_out') }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-light-danger btn-sm w-100 rounded">
                                                        <i class="ph-duotone ph-sign-out pe-1 f-s-20"></i> Log Out
                                                    </button>
                                                </form>
                                            </div>
                                            {{-- <a class="mb-0 btn btn-light-danger btn-sm justify-content-center "
                                                href="{{route('auth.sign_out')}}"
                                                role="button">
                                                <i class="ph-duotone  ph-sign-out pe-1 f-s-20"></i> Log Out
                                            </a> --}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</header>

<style>
    .offcanvas.header-profile-canvas {
        height: 240px !important;
        max-height: 100vh;
        overflow-y: auto;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('liveSearch');
        const resultsContainer = document.getElementById('searchResults');

        function highlightMatches(container, keyword) {
            if (!keyword) return;

            const regex = new RegExp(`(${keyword})`, 'gi');

            const walk = document.createTreeWalker(container, NodeFilter.SHOW_TEXT, null, false);

            while (walk.nextNode()) {
                const node = walk.currentNode;
                const parent = node.parentNode;

                if (node.nodeValue.trim() !== "" && parent) {
                    const span = document.createElement("span");
                    span.innerHTML = node.nodeValue.replace(regex, '<span class="text-primary">$1</span>');
                    parent.replaceChild(span, node);
                }
            }
        }

         // Prevent Enter key from submitting
        searchInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });

        searchInput.addEventListener('keyup', function () {
            const query = this.value.trim();

            if (query.length >= 2) {
                resultsContainer.innerHTML = `
                    <li class="search-list-item text-center py-3">
                        <span class="spinner-border text-primary spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="ms-2 text-secondary">Searching...</span>
                    </li>
                `;

                fetch(`{{ route('main.search') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.text())
                    .then(data => {
                        // Safely insert and highlight
                        resultsContainer.innerHTML = data;
                        highlightMatches(resultsContainer, query);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resultsContainer.innerHTML = `
                            <li class="search-list-item text-center py-3 text-danger">
                                An error occurred.
                            </li>
                        `;
                    });
            } else {
                resultsContainer.innerHTML = '';
            }
        });
    });
</script>





<!-- Header Section ends -->
