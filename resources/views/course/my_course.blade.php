@extends('layout.master')
@section('title', 'My Courses')
@section('css')
    <!-- nouislider js css -->
    {{-- <link rel="stylesheet" href="{{asset('assets/vendor/nouislider/nouislider.min.css')}}"> --}}

    <!-- apexcharts css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/apexcharts/apexcharts.css')}}">

@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">My Courses</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                        <span>
                            <i class="ph-duotone ph-book f-s-16"></i> Course
                        </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">My Courses</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <!-- Product start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="product-header d-flex justify-content-between gap-3 align-items-center">
                            <div class="d-flex align-items-center">
                                <a class="me-3 toggle-btn d-inline-block d-lg-none" role="button"><i class="ti ti-align-justified f-s-24"></i></a>
                                <form class="app-form app-icon-form d-inline-block" id="search-form" action="#">
                                    <div class="position-relative">
                                        <input type="search" 
                                            name="search" 
                                            class="form-control" 
                                            placeholder="Search courses..." 
                                            aria-label="Search"
                                            value="{{ request('search') }}">
                                        <i class="ti ti-search text-dark"></i>
                                        @if(request('search'))
                                            <button type="button" class="btn btn-sm btn-clear-search position-absolute end-0 top-50 translate-middle-y me-4">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <div>
                                <button class="btn btn-secondary product-view3">III</button>
                                <button class="btn btn-secondary product-view2">II</button>
                                <button class="btn btn-secondary product-view1">I</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="course-tab-1 col-12 d-block d-lg-none">
                <div class="card" >
                    <div class="card-body">
                        <div class="tab-wrapper">
                            <ul class="profile-app-tabs">
                                <li class="tab-link fw-medium f-s-16 f-w-600 active" data-tab="1" data-tab-type="created">
                                    <i class="ti ti-clipboard-data fw-bold"></i> Created Course
                                </li>
                                <li class="tab-link fw-medium f-s-16 f-w-600" data-tab="2" data-tab-type="joined">
                                    <i class="ti ti-photo-heart fw-bold"></i> Joined Course
                                </li>
                            </ul>

                        </div>

                    </div>
                </div>
            </div> --}}

            <!-- Filters start -->
            <div class="col-xxl-3 col-lg-4 product-box productbox d-none d-lg-block">
                {{-- <div class="card course-tab-2" >
                    <div class="card-body">
                        <div class="tab-wrapper">
                            <ul class="profile-app-tabs">
                                <li class="tab-link fw-medium f-s-16 f-w-600 active" data-tab="1" data-tab-type="created">
                                    <i class="ti ti-clipboard-data fw-bold"></i> Created Course
                                </li>
                                <li class="tab-link fw-medium f-s-16 f-w-600" data-tab="2" data-tab-type="joined">
                                    <i class="ti ti-photo-heart fw-bold"></i> Joined Course
                                </li>
                            </ul>

                        </div>

                    </div>
                </div> --}}

                <div class="card">
                    <div class="card-header">
                        <h5>Filters</h5>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="accordion accordion-flush app-accordion accordion-light-primary" id="accordion-flush-sort-by">
                            <form id="filter-form">
                                <!-- Course created / joined -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-heading-one">
                                        <button class="accordion-button bg-none p-1" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse_one" aria-expanded="true" aria-controls="collapse_one">
                                            <span class="m-0 mt-1">Courses</span>
                                        </button>
                                    </h2>
                                    <div id="collapse_one" class="accordion-collapse collapse show"
                                        aria-labelledby="flush-heading-one" data-bs-parent="#accordion-flush-sort-by">
                                        <div>
                                            <label class="check-box m-3">
                                                <input type="radio" name="tab-link" value="created" class="tab-link" data-tab="1" data-tab-type="created" checked>
                                                <span class="radiomark outline-secondary"></span>
                                                <span class="text-secondary">Created Course</span>
                                            </label>
                                            <label class="check-box m-3">
                                                <input type="radio" name="tab-link" value="joined" class="tab-link" data-tab="2" data-tab-type="joined">
                                                <span class="radiomark outline-secondary"></span>
                                                <span class="text-secondary">Joined Course</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sort By -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-heading-two">
                                        <button class="accordion-button bg-none p-1" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse_two" aria-expanded="true" aria-controls="collapse_two">
                                            <span class="m-0 mt-1">Sort By</span>
                                        </button>
                                    </h2>
                                    <div id="collapse_two" class="accordion-collapse collapse show"
                                        aria-labelledby="flush-heading-two" data-bs-parent="#accordion-flush-sort-by">
                                        <div>
                                            <label class="check-box m-3">
                                                <input type="radio" name="sort" value="most_popular">
                                                <span class="radiomark outline-secondary"></span>
                                                <span class="text-secondary">Most Popular</span>
                                            </label>
                                            <label class="check-box m-3">
                                                <input type="radio" name="sort" value="least_popular">
                                                <span class="radiomark outline-secondary"></span>
                                                <span class="text-secondary">Least Popular</span>
                                            </label>
                                            <label class="check-box m-3">
                                                <input type="radio" name="sort" value="newest">
                                                <span class="radiomark outline-secondary"></span>
                                                <span class="text-secondary">Newest</span>
                                            </label>
                                            <label class="check-box m-3">
                                                <input type="radio" name="sort" value="oldest">
                                                <span class="radiomark outline-secondary"></span>
                                                <span class="text-secondary">Oldest</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- Topics -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-heading-three">
                                        <button class="accordion-button bg-none p-1" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse_three" aria-expanded="true" aria-controls="collapse_three">
                                            <span class="m-0 mt-1">Topics</span>
                                        </button>
                                    </h2>
                                    <div id="collapse_three" class="accordion-collapse collapse show"
                                        aria-labelledby="flush-heading-three" data-bs-parent="#accordion-flush-sort-by">
                                        <div class="accordion-body p-2">
                                            @foreach ($topics as $topic)
                                                <div class="p-2 d-flex align-items-center gap-2">
                                                    <label class="check-box">
                                                        <input type="checkbox" name="topics[]" value="{{ $topic->id }}">
                                                        <span class="checkmark outline-secondary ms-2"></span>
                                                    </label>
                                                    <a href="#" class="f-s-15 f-w-500 text-secondary">{{ $topic->desc }}</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- Ratings -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-heading-four">
                                        <button class="accordion-button bg-none p-1" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse_four" aria-expanded="true" aria-controls="collapse_four">
                                            <span class="m-0 mt-1">Ratings</span>
                                        </button>
                                    </h2>
                                    <div id="collapse_four" class="accordion-collapse collapse show"
                                        aria-labelledby="flush-heading-four" data-bs-parent="#accordion-flush-sort-by">
                                        <div class="accordion-body p-2">
                                            @for ($rating = 1; $rating <= 5; $rating++)
                                                <div class="p-2 d-flex align-items-center gap-2">
                                                    <label class="check-box">
                                                        <input type="checkbox" name="ratings[]" value="{{ $rating }}">
                                                        <span class="checkmark outline-secondary ms-2"></span>
                                                    </label>
                                                    {{ $rating }}
                                                    <div class="d-flex align-items-center">
                                                        @for ($i = 0; $i < $rating; $i++)
                                                            <i class="ti ti-star-filled text-warning"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div>
                            <div class="text-end m-3">
                                <a href="#" role="button" class="btn btn-sm btn-outline-primary btn-clear-all mt-2 btn-primary">Clear all</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Filters end -->

            <!-- Product box start -->
            <div class="col-xxl-9 col-lg-8">
                <div class="product-wrapper-grid">
                    <!-- Partial content here -->
                </div>
            </div>
            <!-- Product box end -->

        </div>
        <!-- Product end -->
    </div>

    <style>
        .swal2-toast {
            width: auto !important;
            max-width: 100% !important;
            padding: 0.625em !important;
        }
    </style>
@endsection

@section('script') 

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toast notifications
        @if(session('success'))
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: "{{ session('success') }}",
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    width: 'auto',
                });
            }, 100);
        @endif
    
        @if(session('error'))
            setTimeout(() => {
                Swal.fire({
                    icon: 'error',
                    title: "{{ session('error') }}",
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    width: 'auto',
                });
            }, 100);
        @endif
    });

    $(document).ready(function() {

        let currentTabType = 'created'; // default

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this, args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }

        // Function to fetch filtered courses
        function fetchCourses() {
            const formData = {
                search: $('input[name="search"]').val(),
                topics: $('input[name="topics[]"]:checked').map(function() {
                    return this.value;
                }).get(),
                ratings: $('input[name="ratings[]"]:checked').map(function() {
                    return this.value;
                }).get(),
                sort: $('input[name="sort"]:checked').val(),
                type: currentTabType,
                _token: '{{ csrf_token() }}'
            };
    
            // Show loading indicator
            $('.product-wrapper-grid').html(`
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);
    
            $.ajax({
                url: '{{ route("course.my_course") }}',
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('.product-wrapper-grid').html(response.courses);
                    
                    // Show message if no results
                    if ($('.col-xxl-4').length === 0) {
                        $('.product-wrapper-grid').html(`
                            <div class="col-12 text-center py-5">
                                <i class="ti ti-alert-circle f-s-24 text-muted mb-2"></i>
                                <h5 class="text-muted">No courses found matching your criteria</h5>
                            </div>
                        `);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    $('.product-wrapper-grid').html(`
                        <div class="col-12 text-center py-5">
                            <i class="ti ti-alert-circle f-s-24 text-danger mb-2"></i>
                            <h5 class="text-danger">Error loading courses</h5>
                            <button class="btn btn-sm btn-outline-danger mt-2" onclick="fetchCourses()">
                                Retry
                            </button>
                        </div>
                    `);
                }
            });
        }

        // Tabs switching logic (fixed)
        $(document).on('click', '.tab-link', function() {
            const tabId = $(this).data('tab');
            currentTabType = $(this).data('tab-type'); // Update currentTabType

            $('.tab-link').removeClass('active');
            $(this).addClass('active');

            $('.tab-pane').removeClass('active');
            $('#tab-' + tabId).addClass('active');

            fetchCourses(); // Re-fetch courses for selected tab
        });

    
        // Initialize on page load
        fetchCourses();
    
        // Event listeners for all filters
        $('input[name="search"]').on('input', debounce(fetchCourses, 500));
        $('input[name="topics[]"], input[name="ratings[]"], input[name="sort"]').on('change', fetchCourses);
    
        // Clear all filters
        $(document).on('click', '.btn-clear-all', function(e) {
            e.preventDefault();
            $('input[type="checkbox"], input[type="radio"]').prop('checked', false);
            $('input[name="search"]').val('');
            fetchCourses();
        });
    });
</script>


<!--customizer-->
<div id="customizer"></div>

<!-- nouislider js -->
{{-- <script src="{{asset('assets/vendor/nouislider/nouislider.min.js')}}"></script> --}}
{{-- <script src="{{asset('assets/vendor/nouislider/wNumb.min.js')}}"></script> --}}

<!-- Tooltip js  -->
<script src="{{asset('assets/js/tooltips_popovers.js')}}"></script>

<!-- sweetalert js-->
<script src="{{asset('assets/vendor/sweetalert/sweetalert.js')}}"></script>

<!-- js -->
{{-- <script src="{{asset('assets/js/product.js')}}"></script> --}}
<script src="{{asset('assets/js/course/my_course.js')}}"></script>
{{-- <script src="{{asset('assets/js/range_slider.js')}}"></script> --}}
@endsection

