@extends('layout.master')
@section('title', 'Find Courses')
@section('css')
    <!-- nouislider js css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/nouislider/nouislider.min.css')}}">

    <!-- apexcharts css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/apexcharts/apexcharts.css')}}">

@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Find Courses</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                        <span>
                            <i class="ph-duotone ph-stack f-s-16"></i> Course
                        </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Find Courses</a>
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
                                <form class="app-form app-icon-form d-inline-block" id="search-form">
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

            <!-- Filters start -->
            <div class="col-xxl-3 col-lg-4 product-box productbox">
                <div class="card">
                    <div class="card-header">
                        <h5>Filters</h5>
                    </div>
                    <form id="filter-form">
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
                            <h2 class="accordion-header" id="flush-heading-seven">
                                <button class="accordion-button bg-none p-1" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse_seven" aria-expanded="true" aria-controls="collapse_seven">
                                    <span class="m-0 mt-1">Ratings</span>
                                </button>
                            </h2>
                            <div id="collapse_seven" class="accordion-collapse collapse show"
                                aria-labelledby="flush-heading-seven" data-bs-parent="#accordion-flush-sort-by">
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
            </div>
            <!-- Filters end -->

            <!-- Product box start -->
            <div class="col-xxl-9 col-lg-8">
                <div class="product-wrapper-grid">
                    <div class="row">
                        @foreach ($courses as $course)
                            <div class="col-xxl-4 col-md-6 col-sm-6 mb-4">
                                <div class="card overflow-hidden h-100">
                                    <div class="card-body p-0 d-flex flex-column">
                                        <!-- Course Thumbnail -->
                                        <div class="product-grid">
                                            <div class="product-image">
                                                <a href="#" class="image">
                                                    <img class="pic-1"
                                                        src="{{ asset($course->image ? 'storage/uploads/course_picture/' . $course->image : '../assets/images/ecommerce/1280x720.png') }}"
                                                        alt="Course Thumbnail"
                                                        style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover;" />
                                                </a>
                                                <ul class="product-links">
                                                    <li>
                                                        <a href="{{ route('course.course_detail', ['course_id' => $course->id]) }}" 
                                                            class="bg-success h-30 w-30 d-flex-center b-r-20">
                                                            <i class="ti ti-eye f-s-18 text-light"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Course Details -->
                                        <div class="p-3 flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <a href="{{ route('course.course_detail', ['course_id' => $course->id]) }}"
                                                    class="h5 mb-0 text-truncate" style="max-width: 70%;" data-bs-placement="top" data-bs-toggle="tooltip"
                                                    title="{{ $course->name }}">
                                                    {{ $course->name }}
                                                </a>
                                                <div class="d-flex align-items-center">
                                                    <span class="text-warning fw-bold me-1">
                                                        {{ number_format($course->average_rating, 1) }}
                                                    </span>
                                                    <i class="ti ti-star-filled text-warning"></i>
                                                </div>
                                            </div>

                                            <p class="text-secondary small mb-2"
                                            style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">
                                                {{ $course->desc ?? 'No description available' }}
                                            </p>

                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div>
                                                    <small class="text-muted">
                                                        <i class="ti ti-books"></i>
                                                        Topic:
                                                    </small>
                                                </div>
                                                @foreach ($course->topics as $topic)
                                                    <span class="badge bg-primary small">#{{ $topic->name }}</span>
                                                @endforeach
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div>
                                                    <small class="text-muted">
                                                        <i class="ti ti-users me-1"></i>
                                                        {{ $course->total_joined ?? 0 }} joined
                                                    </small>
                                                </div>
                                                <div>
                                                    <small class="text-muted">
                                                        <i class="ti ti-calendar me-1"></i>
                                                        {{ $course->created_at ? \Carbon\Carbon::parse($course->created_at)->format('M Y') : 'Jan 2023' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Footer: Tutor Info -->
                                        <div class="p-2 border-top bg-primary-light">
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $course->tutor_image ? asset('storage/uploads/profile_picture/' . $course->tutor_image) : asset('assets/images/avtar/woman.jpg') }}"
                                                    class="rounded-circle border"
                                                    width="32"
                                                    height="32"
                                                    style="object-fit: cover;"
                                                    alt="Tutor Avatar">
                                                <div class="text-truncate">
                                                    <small class="text-muted d-block">Tutor</small>
                                                    <span class="fw-semibold text-truncate d-block" style="max-width: 150px;">
                                                        {{ $course->tutor_username ?? 'Null' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Footer End -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Product box end -->

        </div>
        <!-- Product end -->
    </div>
@endsection

@section('script')

<script>
    $(document).ready(function() {
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
                url: '{{ route("course.find_course") }}',
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
                                <button class="btn btn-sm btn-outline-primary btn-clear-all mt-2">
                                    Clear all filters
                                </button>
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
<script src="{{asset('assets/vendor/nouislider/nouislider.min.js')}}"></script>
<script src="{{asset('assets/vendor/nouislider/wNumb.min.js')}}"></script>

<!-- Tooltip js  -->
<script src="{{asset('assets/js/tooltips_popovers.js')}}"></script>

<!-- js -->
<script src="{{asset('assets/js/product.js')}}"></script>
<script src="{{asset('assets/js/range_slider.js')}}"></script>
@endsection

