@extends('layout.master')
@section('title', 'Homepage')
@section('css')

    <!-- apexcharts css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/apexcharts/apexcharts.css') }}">

    <!-- slick css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick-theme.css')}}">

    <!-- filepond css -->
    <link href="{{asset('assets/vendor/filepond/filepond.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/filepond/image-preview.min.css')}}" rel="stylesheet">

@endsection
@section('main-content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Hi, {{ $user->name }} 👋</h4>
                    {{-- <div>
                        <a href="" class="btn btn-primary">View Profile</a>
                    </div> --}}
                </div>
                <p class="f-m-light">Continue your learning journey</p>
            </div>
            <div class="col-sm-6 col-lg-6 col-xxl-2 order--1-lg">
                <div class="row">
                    <div class="col-12">
                        <div class="card orders-provided-card">
                            <div class="card-body">
                                <i class="ph-bold ph-circle circle-bg-img"></i>
                                <div>
                                    <p class="f-s-18 f-w-600 text-dark txt-ellipsis-1">My Level</p>
                                    <h2 class="text-secondary-dark mb-0">{{ $user->userPoints?->level ?? '0' }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card bg-primary-300 product-sold-card">
                            <div class="card-body">
                                <div>
                                    <h5 class="text-primary-dark f-w-600">Total XP</h5>
                                    <div class="d-flex justify-content-center my-2">
                                        <i class="ti ti-arrow-big-up-lines f-s-60 text-primary-dark"></i>
                                    </div>
                                    {{-- <p class="text-dark f-w-600 mb-0 mt-2 txt-ellipsis-1"><i
                                            class="iconoir-calendar f-s-16 align-text-top me-2"></i>Oct 1 -
                                        Oct 15, 2024</p> --}}
                                </div>
                                <div>
                                    <h4 class="text-primary-dark">{{ $user->userPoints?->xp ?? '0' }} XP</h4>
                                    <p class="mb-0 text-dark f-w-500 txt-ellipsis-1">This week<span
                                            class="badge bg-white-300 text-danger-dark ms-2">77 XP</span>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-6 col-xxl-2 order--1-lg">
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-danger-300 product-sold-card">
                            <div class="card-body">
                                <div>
                                    <h5 class="text-danger-dark f-w-600 ">Streak</h5>
                                    {{-- <div id="productSold"></div> --}}
                                    <div class="d-flex justify-content-center my-2">
                                        <i class="ti ti-campfire f-s-60 text-danger-dark"></i>
                                    </div>
                                </div>
                                <div>
                                    <h4>{{ $user->userPoints?->current_streak ?? '0' }} Days</h4>
                                    <p class="mb-0 text-dark f-w-500 txt-ellipsis-1">Longest<span
                                            class="badge bg-white-300 text-danger-dark ms-2">{{ $user->userPoints?->longest_streak ?? '0' }} Days</span>
                                    </p>
                                </div>
                                {{-- <a class="bg-danger h-35 w-35 d-flex-center b-r-50 product-sold-icon"
                                   href="{{route('order_details')}}">
                                    <i class="iconoir-arrow-right f-w-600 f-s-18 animate__pulse animate__fadeOutRight  animate__infinite animate__slower"></i>
                                </a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card product-store-card">
                            <div class="card-body">
                                <i class="ph-bold  ph-circle circle-bg-img"></i>
                                <div>
                                    <p class="text-success f-s-18 f-w-600 txt-ellipsis-1">Total Points</p>
                                    <h2 class="text-success-dark mb-0">{{ $user->userPoints?->total_points ?? '0' }}</h2>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="iconoir-flare f-s-20"></i> StudySama AI</h5>
                            <a href="{{ route('ai.leaderboard') }}" class="btn btn-primary rounded">
                                Leaderboard
                            </a>
                        </div>
                        <p class="f-m-light">Learning at your own pace, with the power of AI!</p>
                        <div class="row my-3">
                            <div class="col-6 col-sm-4">
                                <a href="{{ route('ai.mcq') }}" class="text-decoration-none">
                                    <div class="card card-primary hover-effect cursor-pointer">
                                        <div class="card-body">
                                            <div class="mt-3">
                                                <h6 class="mb-0 text-truncate">MCQ</h6>
                                                <p class="mb-0">10 Questions</p>
                                            </div>
                                            <i class="iconoir-task-list icon-bg text-white"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-sm-4">
                                <a href="{{ route('ai.flashcard') }}" class="text-decoration-none">
                                    <div class="card card-success hover-effect cursor-pointer">
                                        <div class="card-body">
                                            <div class="mt-3">
                                                <h6 class="mb-0 text-truncate">Flashcard</h6>
                                                <p class="mb-0">10 Cards</p>
                                            </div>
                                            <i class="iconoir-credit-cards icon-bg text-white"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-sm-4">
                                <a href="{{ route('ai.word_search_puzzle') }}" class="text-decoration-none">
                                    <div class="card card-warning hover-effect cursor-pointer">
                                        <div class="card-body">
                                            <div class="mt-3">
                                                <h6 class="mb-0 text-truncate">Word Search Puzzle</h6>
                                                <p class="mb-0">10 Words</p>
                                            </div>
                                            <i class="iconoir-puzzle icon-bg text-white"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                        <div class="alert alert-light-border-warning d-flex align-items-center justify-content-between"
                            role="alert">
                            <p class="mb-0">
                                <i class="ti ti-alert-triangle f-s-18 me-2"></i>All generated content is for educational purposes only and may not be accurate or reliable. Always verify with trusted sources before use.
                            </p>
                            {{-- <i class="ti ti-x" data-bs-dismiss="alert"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                            <h5 class="mb-0">Joined Courses</h5>
                            <a href="{{route('course.my_course')}}" class="btn btn-primary rounded">
                                View All
                            </a>
                        </div>
                        <div class="d-flex overflow-auto gap-3" style="scroll-snap-type: x mandatory;">
                            @forelse ($courses->where('role_id', 3)->sortByDesc('created_at') as $course)
                                <div class="flex-shrink-0" style="width: 300px; scroll-snap-align: start;">
                                    <div class="card overflow-hidden h-100 border border-secondary rounded">
                                        <div class="card-body p-0 d-flex flex-column">

                                            <!-- Course Thumbnail -->
                                            <div class="product-grid">
                                                <div class="product-image">
                                                    <a href="#" class="image">
                                                        <img class="pic-1"
                                                            src="{{ asset($course->image ? 'storage/uploads/course_picture/' . $course->image : 'assets/images/ecommerce/1280x720.png') }}"
                                                            alt="Course Thumbnail"
                                                            style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover;" />
                                                    </a>
                                                    <ul class="product-links">
                                                        <li>
                                                            <a href="{{ route('course.course_detail', ['course_id' => encrypt($course->id)]) }}" 
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
                                                    <a href="{{ route('course.course_detail', ['course_id' => encrypt($course->id)]) }}"
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
                                                    <a href="{{ route('user.profile', ['user_id' => encrypt($course->tutor_id), 'shared' => 0]) }}" style="cursor: pointer; text-decoration: none; color: inherit;" class="d-flex align-items-center gap-2">
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
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center w-100 h-50">
                                    <p class="text-secondary">No courses joined yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                            <h5 class="mb-0">Created Courses</h5>
                            <a href="{{route('course.my_course')}}" class="btn btn-primary rounded">
                                View All
                            </a>
                        </div>
                        <div class="d-flex overflow-auto gap-3" style="scroll-snap-type: x mandatory;">
                            @forelse ($courses->where('role_id', 1)->sortByDesc('created_at') as $course)
                                <div class="flex-shrink-0" style="width: 300px; scroll-snap-align: start;">
                                    <div class="card overflow-hidden h-100 border border-secondary rounded">
                                        <div class="card-body p-0 d-flex flex-column">

                                            <!-- Course Thumbnail -->
                                            <div class="product-grid">
                                                <div class="product-image">
                                                    <a href="#" class="image">
                                                        <img class="pic-1"
                                                            src="{{ asset($course->image ? 'storage/uploads/course_picture/' . $course->image : 'assets/images/ecommerce/1280x720.png') }}"
                                                            alt="Course Thumbnail"
                                                            style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover;" />
                                                    </a>
                                                    <ul class="product-links">
                                                        <li>
                                                            <a href="{{ route('course.course_detail', ['course_id' => encrypt($course->id)]) }}" 
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
                                                    <a href="{{ route('course.course_detail', ['course_id' => encrypt($course->id)]) }}"
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
                                                    <a href="{{ route('user.profile', ['user_id' => encrypt($course->tutor_id), 'shared' => 0]) }}" style="cursor: pointer; text-decoration: none; color: inherit;" class="d-flex align-items-center gap-2">
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
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center w-100 h-50">
                                    <p class="text-secondary">No courses created yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <!-- slick-file -->
    <script src="{{asset('assets/vendor/slick/slick.min.js')}}"></script>

    <!-- apexcharts js-->
    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>

     <!-- Tooltips_popovers. Js -->
    <script src="{{asset('assets/js/tooltips_popovers.js')}}"></script>

    <!-- Ecommerce Dashboard js-->
    <script src="{{asset('assets/js/ecommerce_dashboard.js')}}"></script>

@endsection
