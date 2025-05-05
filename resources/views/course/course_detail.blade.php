@extends('layout.master')
@section('title', 'Course Details')
@section('css')
    <!-- slick css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick-theme.css')}}">

    <!-- glightbox css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/glightbox/glightbox.min.css')}}">

    <!-- Toatify css-->
    <link rel="stylesheet" href="{{asset('assets/vendor/notifications/toastify.min.css')}}">
@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Course Details</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a class="f-s-14 f-w-500" href="#">
                      <span>
                        <i class="ph-duotone  ph-stack f-s-16"></i> Course
                      </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('course.find_course') }}" class="f-s-14 f-w-500">Find Courses</a>
                    </li>
                    <li class="active">
                        <a class="f-s-14 f-w-500" href="#">Course Details</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <!-- Product Details start -->
        <div class="row">
            <div class="col-lg-9 order-xxl-2">    
                <div class="card">
                    <div class="card-body">
                        <div class="product-details-contentbox">
                            <div class="course-image mb-3">
                                <img src="{{ asset($course->image ? 'storage/uploads/course_picture/' . $course->image : '../assets/images/ecommerce/1280x720.png') }}" 
                                     alt="Course Image"
                                     style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover; border-radius: 1.5rem 1.5rem 1.5rem 1.5rem;">
                            </div>
                            <h4>{{ $course->name ?? 'N/A' }}</h4>

                            <div class="mt-4 product-details">
                                @foreach ($topics as $topic)
                                    <h6 class="mb-3"><span class="badge bg-primary">#{{ $topic->name }}</span></h6>
                                @endforeach
                            </div>

                            <div class="product-details-btn row align-items-center mt-4">
                                <div class="col-12 col-md-6 text-start mb-3 mb-md-0">
                                    <p class="mb-1">
                                        <strong><i class="iconoir-group"></i> Total Joined:</strong> {{ $course->total_joined }}
                                    </p>
                                    <p class="mb-0">
                                        <strong><i class="iconoir-calendar"></i> Created by </strong>
                                        <a href="" class="text-info text-decoration-none">
                                            {{"@" . $tutor->username }}
                                        </a>: 
                                        {{ $course->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="col-12 col-md-6 text-md-end text-center">
                                    @php
                                        $isJoined = $user_courses->contains(function ($course) {
                                            return $course->user_id == auth()->id() && $course->status == 1;
                                        });


                                        $isTutor = $tutor->id == auth()->id();
                                    @endphp

                                    {{-- @if($isJoined && !$isTutor)
                                        <a class="btn btn-danger rounded px-4 py-2" href="{{ route('checkout') }}" role="button">
                                            Leave Course
                                        </a>
                                    @elseif($isTutor)
                                        <a class="btn btn-primary rounded px-4 py-2" href="{{ route('checkout') }}" role="button">
                                            Edit Course
                                        </a>
                                    @else
                                        <form id="join-leave-form" action="{{ route('course.join_leave_course') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <input type="hidden" name="status" value="{{ $isJoined ? 0 : 1 }}">
                                            <button type="submit" class="btn {{ $isJoined ? 'btn-danger' : 'btn-success' }} rounded px-4 py-2">
                                                {{ $isJoined ? 'Leave Course' : 'Join Course' }}
                                            </button>
                                        </form>                                    
                                    @endif --}}
                                    @if($isTutor)
                                        <a class="btn btn-secondary px-4 py-2" href="" role="button">
                                            Edit Course
                                        </a>
                                        <a href="{{ route('course.lesson.lesson_list', ['course_id' => $course->id]) }}" class="btn btn-primary">View Course</a>
                                    @else
                                        <form id="join-leave-form" action="{{ route('course.join_leave_course') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <input type="hidden" name="status" value="{{ $isJoined ? 0 : 1 }}">
                                            
                                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                @if($isJoined)
                                                    <!-- When joined - View Course goes to view route, dropdown has Leave option -->
                                                    <a href="{{ route('course.lesson.lesson_list', ['course_id' => $course->id]) }}" class="btn btn-primary">View Course</a>
                                                    
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <button type="submit" class="dropdown-item leave-course-btn">Leave Course</button>
                                                            </li>
                                                            <li><button type="submit" class="dropdown-item">Report Course</button></li>
                                                        </ul>
                                                    </div>
                                                @else
                                                    <!-- When not joined - Join Course submits the form, dropdown has Report option -->
                                                    <button type="submit" class="btn btn-success">Join Course</button>
                                                    
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Report Course</a></li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>                                                

                            <div class="app-divider-v dotted pb-2"></div>

                            <div class="mt-4">
                                <h5>Description :</h5>
                                <div class="mt-3">
                                    <p>{{ $course->desc ?? 'No description available' }}</p>
                                </div>
                            </div>

                            @php
                                $totalRatings = $user_courses->whereNotNull('rating')->count();
                                $ratingCounts = [
                                    5 => $user_courses->where('rating', 5)->count(),
                                    4 => $user_courses->where('rating', 4)->count(),
                                    3 => $user_courses->where('rating', 3)->count(),
                                    2 => $user_courses->where('rating', 2)->count(),
                                    1 => $user_courses->where('rating', 1)->count(),
                                ];
                            @endphp

                            <div class="mt-4">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="me-2">
                                        <i class="ti ti-star-filled f-s-30 text-warning"></i>
                                    </div>
                                    <div>
                                        <h5 class="m-0">{{ rtrim(rtrim(number_format($course->average_rating, 1, '.', ''), '0'), '.') }} out of 5</h5>
                                        <p class="mb-0 text-secondary f-s-13">Based on ({{ $totalRatings }}) ratings</p>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    @foreach([5, 4, 3, 2, 1] as $star)
                                        @php
                                            $count = $ratingCounts[$star];
                                            $percentage = $totalRatings > 0 ? ($count / $totalRatings) * 100 : 0;
                                        @endphp
                                        <div class="d-flex align-items-center mt-3">
                                            <h6 class="mb-0">{{ $star }}</h6>
                                            <i class="ti ti-star-filled text-warning f-s-9"></i>
                                            <div class="progress w-100 ms-2 me-2" role="progressbar" aria-valuemax="100" aria-valuemin="0" aria-valuenow="{{ round($percentage) }}">
                                                <div class="progress-bar 
                                                    {{ $star == 5 ? 'bg-primary' : ($star == 4 ? 'bg-secondary' : ($star == 3 ? 'bg-success' : ($star == 2 ? 'bg-warning' : 'bg-danger'))) }} 
                                                    progress-bar-striped" style="width: {{ round($percentage) }}%">
                                                </div>
                                            </div>
                                            <h6>({{ number_format($count) }})</h6>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            {{-- <div class="product-details-btn text-end mt-4">
                                <a class="btn btn-success rounded" href="{{route('checkout')}}" role="button">Join Course</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Comments</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($course_comments as $comment)
                            <div class="blogcomment-box mb-3">
                                <div class="d-flex justify-content-between ">
                                    <div class="h-40 w-40 d-flex-center b-r-10 overflow-hidden comment-img">
                                        <img src="{{ $comment->image ? asset('storage/uploads/profile_picture/' . $comment->image) : asset('assets/images/avtar/4.png') }}" alt="avtar" class="bg-warning img-fluid">
                                    </div>
                                    <div class="commentdiv">
                                        <h6 class="mb-0 text-dark f-w-600">{{ $comment->username }} 
                                            @if ($comment->uc_status == 1)
                                                <span class="badge bg-primary">Member</span>
                                            @elseif ($comment->uc_status == 0)
                                                <span class="badge bg-secondary">Ex-Member</span>
                                            @else
                                                <span class="badge bg-light text-dark">Unknown</span>
                                            @endif
                                        </h6>
                                        <span class="text-muted f-s-12"> {{ \Carbon\Carbon::parse($comment->comment_updated_at)->diffForHumans() }}</span>

                                        <!-- Star Rating -->
                                        <div class="my-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $comment->rating)
                                                    <i class="ti ti-star-filled text-warning"></i>
                                                @else
                                                    <i class="ti ti-star text-secondary"></i>
                                                @endif
                                            @endfor
                                        </div>
                
                                        <!-- Comment Text -->
                                        <p class="text-muted mb-0">{{ $comment->comment_review }}</p>
                                    </div>
                                    <div>
                                        <div class="btn-group dropdown-icon-none">
                                            <a class="icon-btn dropdown-toggle p-2" role="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="ti ti-share"></i> Share </a></li>
                                                <li><a class="dropdown-item" href="#"><i class="ti ti-edit"></i> Edit </a></li>
                                                <li><a class="dropdown-item" href="#"><i class="ti ti-trash"></i> Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <h5 class="mb-3">Leave a Review</h5>
                        @if($isJoined && !$isTutor)
                            <form id="review-form" method="POST" action="{{ route('course.update_review') }}">
                                @csrf
                                <input type="hidden" name="user_course_id" value="{{ $user_review?->id ?? $user_courses->where('user_id', auth()->user()->id)->first()?->id }}">
                                <input type="hidden" name="action" id="action" value="update">
                                
                                <div class="mb-3">
                                    {{-- <label class="form-label">Your Rating</label> --}}
                                    <div id="star-rating" class="d-flex align-items-center gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button type="button" class="star-btn btn p-0 border-0 bg-transparent" data-rating="{{ $i }}">
                                                <i class="ti {{ ($user_review && $user_review->rating >= $i) ? 'ti-star-filled text-warning' : 'ti-star text-secondary' }}" style="font-size: 2rem;"></i>
                                            </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating-input" value="{{ $user_review->rating ?? '' }}">
                                </div>
                            
                                <div class="mb-3">
                                    <textarea class="form-control" name="comment_review" rows="3" placeholder="Enter Your Comment (optional)">{{ $user_review->comment_review ?? '' }}</textarea>
                                </div>
                            
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-primary rounded">
                                        <i class="ti ti-send"></i> {{ $user_review ? 'Update Review' : 'Submit Review' }}
                                    </button>
                            
                                    @if($user_review)
                                        <button type="button" id="delete-review-btn" class="btn btn-danger rounded">
                                            <i class="ti ti-trash"></i> Delete Review
                                        </button>
                                    @endif
                                </div>
                            </form>
                        @else
                            <div class="alert alert-outline-info">
                                @if($isTutor)
                                    <i class="ti ti-info-circle"></i> Tutors cannot review their own courses.
                                @else
                                    <i class="ti ti-info-circle"></i> You must join the course before submitting a review.
                                @endif
                            </div>
                        @endif                   

                        
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
                            
                                // Delete review confirmation
                                document.getElementById('delete-review-btn')?.addEventListener('click', function () {
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: "Do you really want to delete your review?",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        cancelButtonColor: '#6c757d',
                                        confirmButtonText: 'Yes, delete it!',
                                        reverseButtons: true
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.getElementById('action').value = 'delete';
                                            document.getElementById('review-form').submit();
                                        }
                                    });
                                });
                        
                                // Course leaving confirmation
                                document.querySelectorAll('.leave-course-btn').forEach(button => {
                                    button.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        Swal.fire({
                                            title: 'Leave Course?',
                                            text: "Are you sure you want to leave this course?",
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#6c757d',
                                            confirmButtonText: 'Yes, leave course',
                                            reverseButtons: true
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // Find the closest form and submit it
                                                this.closest('form').submit();
                                            }
                                        });
                                    });
                                });
                            
                                // Star rating system
                                const stars = document.querySelectorAll('.star-btn');
                                const ratingInput = document.getElementById('rating-input');
                            
                                stars.forEach((star, index) => {
                                    star.addEventListener('click', () => {
                                        const rating = star.getAttribute('data-rating');
                                        ratingInput.value = rating;
                            
                                        // Reset all stars
                                        stars.forEach((s, idx) => {
                                            const icon = s.querySelector('i');
                                            if (idx < rating) {
                                                icon.classList.remove('ti-star', 'text-secondary');
                                                icon.classList.add('ti-star-filled', 'text-warning');
                                            } else {
                                                icon.classList.remove('ti-star-filled', 'text-warning');
                                                icon.classList.add('ti-star', 'text-secondary');
                                            }
                                        });
                                    });
                                });
                            });
                        </script>                             
                    </div>
                </div>
            </div>

            <style>
                /* EXTRA PROTECTION */
                .swal2-toast {
                    width: auto !important;
                    max-width: 100% !important;
                    padding: 0.625em !important;
                }
            </style>

            {{-- <div class="col-md-6 col-xxl-3 order-md-1 order-xxl-3"> --}}
            <div class="col-lg-3 order-md-1 order-xxl-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Your Tutor</h5>
                    </div>
                    <div class="card-body">
                        <div class="profile-container mb-5">
                            <div class="image-details">
                                <div class="profile-image"></div>
                                <div class="profile-pic">
                                    <div class="avatar-upload">
                                        <div class="avatar-preview">
                                            <div id="imgPreview">
                                                <img alt="avatar" class="b-r-50 h-100 w-100 object-cover rounded-circle"
                                                     src="{{ $tutor->image 
                                                        ? asset('storage/uploads/profile_picture/' . auth()->user()->image) 
                                                        : asset('assets/images/avtar/woman.jpg') }}">
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="person-details">
                                <h5 class="f-w-600">{{ $tutor->username }}
                                    <img src="{{asset('assets/images/profile-app/01.png')}}" class="w-20 h-20" alt="instagram-check-mark">
                                </h5>
                                <p>{{ $tutor->email }}</p>
                                {{-- <div class="details">
                                    <div>
                                        <h4 class="text-primary">{{ $tutor->total_follower }}</h4>
                                        <p class="text-secondary small">Follower</p>
                                    </div>
                                </div> --}}
                                <div class="my-2">
                                    <button type="button" class="btn btn-primary b-r-22" id="followButton"> <i class="ti ti-user"></i>
                                        View Profile</button>
                                </div>
                            </div>
                        </div>
                        <h5 class="mb-3">About me</h5>
                        <p class="text-muted f-s-13">{{ $tutor->bio }}</p>
                        <div class="about-list">
                            <div>
                                <span class="fw-medium"><i class="ti ti-user"></i> Name</span>
                                <span class="float-end f-s-13 text-secondary">{{ $tutor->name }}</span>
                            </div>
                            <div>
                                <span class="fw-medium"><i class="ti ti-mail"></i> Email</span>
                                <span class="float-end f-s-13 text-secondary">{{ $tutor->email }}</span>
                            </div>
                            <div>
                                <span class="fw-medium"><i class="ti ti-phone"></i> Contact</span>
                                <span class="float-end f-s-13 text-secondary">{{ $tutor->phone_num ?? '-' }}</span>
                            </div>
                            {{-- <div>
                                <span class="fw-medium"><i class="ti ti-notebook"></i> Biography</span>
                                <span class="float-end f-s-13 text-secondary">{{ $tutor->bio ?? '-' }}</span>
                            </div> --}}

                            @php
                                $icons = [
                                    'linkedin' => 'ti ti-brand-linkedin',
                                    'github' => 'ti ti-brand-github',
                                    'facebook' => 'ti ti-brand-facebook',
                                    'instagram' => 'ti ti-brand-instagram',
                                    'twitter' => 'ti ti-brand-twitter',
                                ];
                            @endphp

                            @if ($tutor->socialLinks->where('status', 1)->count())
                                <div class="mt-4">
                                    <h6 class="text-muted">Social Links</h6>
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($tutor->socialLinks->where('status', 1) as $social)
                                            <li class="mb-2 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="{{ $icons[$social->name] ?? 'ti ti-world' }} text-primary me-2"></i>
                                                    <a href="{{ $social->link }}" target="_blank" class="text-decoration-none text-secondary">
                                                        {{ ucfirst($social->name) }}
                                                    </a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Details end -->
    </div>
@endsection

@section('script') 
<!--customizer-->
<div id="customizer"></div>

<!-- slick-file -->
<script src="{{asset('assets/vendor/slick/slick.min.js')}}"></script>

<!-- glightbox-file -->
<script src="{{asset('assets/vendor/glightbox/glightbox.min.js')}}"></script>

<!-- sweetalert js-->
<script src="{{asset('assets/vendor/sweetalert/sweetalert.js')}}"></script>

<!--js-->
<script src="{{asset('assets/js/product_details.js')}}"></script>
@endsection

