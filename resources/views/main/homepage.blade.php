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
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded shadow-sm">
                    <div>
                        <h4 class="mb-1 text-dark fw-bold">Welcome back, {{ $user->name }} 👋</h4>
                        <p class="mb-0 text-muted">Ready to level up your learning experience!</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-white text-primary border border-primary px-4 py-3 rounded-pill">
                            {{ \Carbon\Carbon::now()->format('l, d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-8">
                
                <div class="card border-0 shadow-sm bg-primary text-white mb-4 overflow-hidden position-relative">
                    <div class="position-absolute top-0 end-0 p-3 opacity-25">
                        <i class="ti ti-robot" style="font-size: 8rem; transform: rotate(15deg);"></i>
                    </div>
                    
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="fw-bold mb-1 text-white"><i class="iconoir-flare me-2"></i>StudySama AI</h4>
                                <p class="mb-0 opacity-75">Generate quizzes, flashcards, and puzzles instantly.</p>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <a href="{{ route('ai.mcq') }}" class="text-decoration-none">
                                    <div class="card border-0 bg-white text-dark hover-effect h-100">
                                        <div class="card-body p-3 d-flex align-items-center">
                                            <div class="bg-primary-subtle text-primary rounded p-2 me-3">
                                                <i class="iconoir-task-list fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">MCQ Quiz</h6>
                                                <small class="text-muted">Test knowledge</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4">
                                <a href="{{ route('ai.flashcard') }}" class="text-decoration-none">
                                    <div class="card border-0 bg-white text-dark hover-effect h-100">
                                        <div class="card-body p-3 d-flex align-items-center">
                                            <div class="bg-success-subtle text-success rounded p-2 me-3">
                                                <i class="iconoir-credit-cards fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">Flashcards</h6>
                                                <small class="text-muted">Quick revision</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4">
                                <a href="{{ route('ai.word_search_puzzle') }}" class="text-decoration-none">
                                    <div class="card border-0 bg-white text-dark hover-effect h-100">
                                        <div class="card-body p-3 d-flex align-items-center">
                                            <div class="bg-warning-subtle text-warning rounded p-2 me-3">
                                                <i class="iconoir-puzzle fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">Word Search</h6>
                                                <small class="text-muted">Fun recall</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-light-border-warning d-flex align-items-start mb-4 shadow-sm" role="alert">
                    <i class="ti ti-alert-triangle text-black fs-5 me-2"></i>
                    <div class="text-muted">
                        <strong>Note:</strong> AI-generated content is for educational purposes. Always verify with trusted sources. Happy learning!
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body text-center p-4">
                        <div class="mb-3 position-relative d-inline-block">
                            {{-- <div class="rounded-circle border border-3 border-primary p-1 d-inline-block">
                                <img src="{{ $user->image ? asset('storage/'.$user->image) : asset('assets/images/user/1.png') }}" 
                                    class="rounded-circle" width="80" height="80" alt="User">
                            </div> --}}
                            <a href="{{ route('user.profile', ['user_id' => encrypt($user->id), 'shared' => 0]) }}" 
                                    style="cursor: pointer; text-decoration: none; color: inherit;" 
                                    class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="h-80 w-80 d-flex-center b-r-22 overflow-hidden me-2">
                                            <img src="{{ $user->image ? asset('storage/uploads/profile_picture/' . $user->image) : asset('assets/images/avtar/woman.jpg') }}" 
                                                alt="Tutor Avatar" class="img-fluid">
                                        </div>
                                    </div>
                                    {{-- <div>
                                        <h6 class="mb-0">{{ "@" . $log->user->username ?? 'User Deleted' }}</h6>
                                    </div> --}}
                                </div>
                            </a>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary text-white border shadow-sm">
                                Lvl {{ $user->userPoints?->level ?? '1' }}
                            </span>
                        </div>
                        
                        <h5 class="fw-bold mb-0">
                            <a href="{{ route('user.profile', ['user_id' => encrypt($user->id), 'shared' => 0]) }}" 
                                    style="cursor: pointer; text-decoration: none; color: inherit;" 
                                    class="">
                                {{ '@' . $user->username }}
                            </a>
                        </h5>
                        <p class="text-muted small">{{ $user->email }}</p>

                        <hr class="my-4 opacity-10">

                        <div class="row g-3">
                            <div class="col-4">
                                <div class="p-2 rounded bg-primary-subtle">
                                    <div class="text-primary mb-1"><i class="ti ti-award fs-4"></i></div>
                                    <h6 class="fw-bold mb-0">{{ $user->userPoints?->level ?? '0' }}</h6>
                                    <small class="text-muted" style="font-size: 10px;">Level</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 rounded bg-danger-subtle">
                                    <div class="text-danger mb-1"><i class="ti ti-arrow-big-up-lines fs-4"></i></div>
                                    <h6 class="fw-bold mb-0">{{ $user->userPoints?->xp ?? '0' }}</h6>
                                    <small class="text-muted" style="font-size: 10px;">XP</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 rounded bg-success-subtle">
                                    <div class="text-success mb-1"><i class="ti ti-coin fs-4"></i></div>
                                    <h6 class="fw-bold mb-0">{{ $user->userPoints?->total_points ?? '0' }}</h6>
                                    <small class="text-muted" style="font-size: 10px;">Points</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('ai.leaderboard') }}" class="btn btn-outline-primary w-100 rounded-pill">
                                <i class="ti ti-trophy me-1"></i> View Leaderboard
                            </a>
                        </div>
                    </div>
                </div>

                {{-- <div class="card bg-dark text-white border-0 shadow-sm">
                    <div class="card-body p-4 bg-gradient-dark rounded position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 p-2 opacity-10">
                            <i class="ti ti-bulb" style="font-size: 6rem;"></i>
                        </div>
                        <h5 class="fw-bold">Keep it up! 🔥</h5>
                        <p class="small opacity-75 mb-3">You are on a {{ $user->userPoints?->current_streak ?? '0' }} day streak. Complete one lesson today to keep it going!</p>
                        <div class="progress bg-secondary" style="height: 6px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 70%"></div>
                        </div>
                        <small class="d-block mt-2 text-end text-warning">Daily Goal: 70%</small>
                    </div>
                </div> --}}

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
                                                <div class="d-flex justify-content-between align-items-center">
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

                                                    <span class="badge bg-{{ $course->progress < 100 ? 'warning' : 'success' }}" data-bs-placement="top" data-bs-toggle="tooltip"
                                                        title="">{{ $course->progress < 100 ? 'In Progress' : 'Completed' }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div class="progress w-100 h-20" role="progressbar" aria-valuenow="{{ $course->progress }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    <div class="progress-bar bg-{{ $course->progress < 100 ? 'warning' : 'success' }} progress-bar-striped" style="width: {{ $course->progress }}%">{{ $course->progress }}%</div>
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
