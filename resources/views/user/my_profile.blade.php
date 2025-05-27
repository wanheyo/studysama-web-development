
@extends('layout.master')
@section('title', 'Profile')
@section('css')
    <!--font-awesome-css-->
    <link rel="stylesheet" href="{{asset('assets/vendor/fontawesome/css/all.css')}}">

    <!-- glight css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/glightbox/glightbox.min.css')}}">

    <!-- filepond css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/filepond/filepond.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/filepond/image-preview.min.css')}}">

    <!-- slick css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick-theme.css')}}">
@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Profile</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                      <span>
                        <i class="ph-duotone  ph-stack f-s-16"></i> Profile
                      </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="f-s-14 f-w-500">My Profile</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <div class="row">
            {{-- left column --}}
            <div class="col-lg-3">
                <!-- profile tabs -->
                <div class="card" >
                    <div class="card-body">
                        <div class="tab-wrapper">
                            <ul class="profile-app-tabs ">
                                <li class="tab-link fw-medium f-s-16 f-w-600 active" data-tab="1"><i class="ti ti-user fw-bold"></i>
                                    Profile</li>
                                {{-- <li class="tab-link fw-medium f-s-16 f-w-600" data-tab="2"><i
                                        class="ti ti-timeline fw-bold"></i>
                                    Activities
                                    <span class="badge rounded-pill bg-warning badge-notification">
                            10+
                            <span class="visually-hidden">unread messages</span> --}}
                                </li>
                                <li class="tab-link fw-medium f-s-16 f-w-600" data-tab="2"><i
                                        class="ti ti-clipboard-data fw-bold"></i> Created Course</li>
                                <li class="tab-link fw-medium f-s-16 f-w-600" data-tab="3"><i
                                        class="ti ti-photo-heart fw-bold"></i> Joined Course</li>
                                <li class="tab-link fw-medium f-s-16  f-w-600" data-tab="4"><i class="ti ti-users fw-bold"></i>
                                    Follower</li>
                                <li class="tab-link fw-medium f-s-16  f-w-600" data-tab="5"><i class="ti ti-users fw-bold"></i>
                                    Following</li>
                                <li class="tab-link fw-medium f-s-16  f-w-600" data-tab="6"><i class="ti ti-chart-radar fw-bold"></i>
                                    Level Progression</li>
                                <li class="app-divider-v dashed p-0 m-2"></li>
                                <li><i class="ti ti-help fs-5 pe-2"></i><span
                                        class="flex-grow-1">Help</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>

                {{-- <div class="card d-lg-block d-none">
                    <div class="card-header">
                        <h5>Friends</h5>
                    </div>
                    <div class="card-body profile-friends">
                        <div class="d-flex align-items-center">
                            <div class="h-40 w-40 d-flex-center b-r-50 overflow-hidden bg-dark">
                                <img src="{{asset('../assets/images/avtar/2.png')}}" alt="image" class="img-fluid">
                            </div>
                            <div class="flex-grow-1 ps-2">
                                <div class="fw-medium"> Bette Hagenes</div>
                                <div class="text-muted f-s-12">Wed Developer</div>
                            </div>
                            <a href="#" class="btn btn-light-secondary icon-btn b-r-22"> <i class="ti ti-user-check"></i> </a>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="h-40 w-40 d-flex-center b-r-50 overflow-hidden bg-primary">
                                <img src="{{asset('../assets/images/avtar/10.png')}}" alt="image" class="img-fluid">
                            </div>
                            <div class="flex-grow-1 ps-2">
                                <div class="fw-medium"> Fleta Walsh</div>
                                <div class="text-muted f-s-12">Wed Designer</div>
                            </div>
                            <a href="#" class="btn btn-light-secondary icon-btn b-r-22"> <i class="ti ti-user-check"></i> </a>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="h-40 w-40 d-flex-center b-r-50 overflow-hidden bg-success">
                                <img src="{{asset('../assets/images/avtar/14.png')}}" alt="image" class="img-fluid">
                            </div>
                            <div class="flex-grow-1 ps-2">
                                <div class="fw-medium"> Lenora</div>
                                <div class="text-muted f-s-12">UI/UX designer</div>
                            </div>
                            <a href="#" class="btn btn-light-secondary icon-btn b-r-22"> <i class="ti ti-user-check"></i> </a>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="h-40 w-40 d-flex-center b-r-50 overflow-hidden bg-warning">
                                <img src="{{asset('../assets/images/avtar/16.png')}}" alt="image" class="img-fluid">
                            </div>
                            <div class="flex-grow-1 ps-2">
                                <div class="fw-medium"> Fleta Walsh </div>
                                <div class="text-muted f-s-12">React Developer</div>
                            </div>
                            <a href="#" class="btn btn-light-secondary icon-btn b-r-22"> <i class="ti ti-user-check"></i> </a>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="h-40 w-40 d-flex-center b-r-50 overflow-hidden bg-danger">
                                <img src="{{asset('../assets/images/avtar/13.png')}}" alt="image" class="img-fluid">
                            </div>
                            <div class="flex-grow-1 ps-2">
                                <div class="fw-medium"> Emery McKenzie</div>
                                <div class="text-muted f-s-12">Wed Developer</div>
                            </div>
                            <a href="#" class="btn btn-light-secondary icon-btn b-r-22"> <i class="ti ti-user-check"></i> </a>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="h-40 w-40 d-flex-center b-r-50 overflow-hidden bg-info">
                                <img src="{{asset('../assets/images/avtar/1.png')}}" alt="image" class="img-fluid">
                            </div>
                            <div class="flex-grow-1 ps-2">
                                <div class="fw-medium"> Bette Hagenes</div>
                                <div class="text-muted f-s-12">Wed Designer</div>
                            </div>
                            <a href="#" class="btn btn-light-secondary icon-btn b-r-22"> <i class="ti ti-user-check"></i> </a>
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="h-45 w-45 d-flex-center b-r-50 overflow-hidden bg-danger">
                                <img src="{{asset('../assets/images/avtar/16.png')}}" alt="" class="img-fluid">
                            </div>
                            <div class="flex-grow-1 ps-2 pe-2">
                                <div class="f-w-600">Heli Walsh</div>
                                <div class="text-muted f-s-12">3 Week</div>
                            </div>
                            <div><i class="ti ti-dots-vertical"></i></div>
                        </div>
                        <div class="post-div">
                            <div class="row g-2 my-2">
                                <div class="col-6">
                                    <a href="{{asset('../assets/images/profile-app/19.jpg')}}" class="glightbox" data-glightbox="type: image; zoomable: true;">
                                        <img src="{{asset('../assets/images/profile-app/19.jpg')}}" class="w-100 rounded" alt="">
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{asset('../assets/images/profile-app/27.jpg')}}" class="glightbox" data-glightbox="type: image; zoomable: true;">
                                        <img src="{{asset('../assets/images/profile-app/27.jpg')}}" class="w-100 rounded" alt="">
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{asset('../assets/images/profile-app/28.jpg')}}" class="glightbox" data-glightbox="type: image; zoomable: true;">
                                        <img src="{{asset('../assets/images/profile-app/28.jpg')}}" class="w-100 rounded" alt="">
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{asset('../assets/images/profile-app/29.jpg')}}" class="glightbox" data-glightbox="type: image; zoomable: true;">
                                        <img src="{{asset('../assets/images/profile-app/29.jpg')}}" class="w-100 rounded" alt="">
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{asset('../assets/images/profile-app/30.jpg')}}" class="glightbox img-hover-zoom" data-glightbox="type: image; zoomable: true;">
                                        <img src="{{asset('../assets/images/profile-app/30.jpg')}}" class="w-100 rounded" alt="">
                                    </a>
                                </div>
                            </div>
                            <p class="test-muted">There's nothing like fresh flowers!......🌸🌼🌻</p>
                            <div class="post-icon">
                                <i class="ti ti-heart"></i>
                                <i class="ti ti-brand-hipchat"></i>
                                <i class="ti ti-send"></i>
                                <p class="text-secondary">2k Likes</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            {{-- right column --}}
            <div class="col-lg-9">
                <!-- profile content -->
                <div class="content-wrapper">
                    
                    <!-- tab 1 -->
                    <div id="tab-1" class="tabs-content active">
                        <div class="profile-content">

                            <!-- story section -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="profile-container">
                                        <div class="image-details">
                                            <div class="profile-image"></div>
                                            <div class="profile-pic">
                                                <div class="avatar-upload">
                                                    <div class="avatar-preview">
                                                        <div id="imgPreview">
                                                            <img alt="avatar" class="b-r-50 h-100 w-100 object-cover rounded-circle"
                                                                 src="{{ auth()->user()->image 
                                                                    ? asset('storage/uploads/profile_picture/' . auth()->user()->image) 
                                                                    : asset('assets/images/avtar/woman.jpg') }}">
                                                        </div>
                                                    </div>                                        
                                                </div>
                                            </div>
                                        </div>
                                        <div class="person-details">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <h5 class="f-w-600">{{auth()->user()->username }}
                                                    {{-- <img src="{{asset('../assets/images/profile-app/01.png')}}" class="w-20 h-20" alt="instagram-check-mark"> --}}
                                                    
                                                </h5>
                                                <span class="badge bg-primary">Level {{ auth()->user()->userPoints?->level ?? '0' }}</span>
                                            </div>
                                            
                                            <p>{{auth()->user()->email }}</p>
                                            <div class="details">
                                                <div>
                                                    <h4 class="text-primary">{{ auth()->user()->total_follower }}</h4>
                                                    <p class="text-secondary">Follower</p>
                                                </div>
                                                <div>
                                                    <h4 class="text-primary">{{ $user_follow->where('status', 1)->count() }}</h4>
                                                    <p class="text-secondary">Following</p>
                                                </div>
                                                <div>
                                                    <h4 class="text-primary">{{ $courses->where('role_id', 1)->count() }}</h4>
                                                    <p class="text-secondary">Created Courses</p>
                                                </div>
                                                <div>
                                                    <h4 class="text-primary">{{ $courses->where('role_id', 3)->count() }}</h4>
                                                    <p class="text-secondary">Joined Courses</p>
                                                </div>
                                            </div>
                                            <div class="my-2">
                                                <button type="button" class="btn btn-primary b-r-22" id="editButton" onclick="window.location='{{ route('user.edit_profile') }}'">
                                                    <i class="ti ti-edit"></i> Edit Profile
                                                </button>

                                                <div class="btn-group dropdown-icon-none">
                                                    <button class="btn btn-light-primary icon-btn b-r-22 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        :
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#"><i class="ti ti-share"></i> Share profile</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header">
                                    <h5>About Me</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted f-s-13">{{ auth()->user()->bio }}</p>
                                    <div class="about-list">
                                        <div>
                                            <span class="fw-medium"><i class="ti ti-user"></i> Full name</span>
                                            <span class="float-end f-s-13 text-secondary">{{ auth()->user()->name }}</span>
                                        </div>
                                        <div>
                                            <span class="fw-medium"><i class="ti ti-mail"></i> Email</span>
                                            <span class="float-end f-s-13 text-secondary">{{ auth()->user()->email }}</span>
                                        </div>
                                        <div>
                                            <span class="fw-medium"><i class="ti ti-phone"></i> Contact</span>
                                            <span class="float-end f-s-13 text-secondary">{{ auth()->user()->phone_num ?? '-' }}</span>
                                        </div>
                                        <div>
                                            <span class="fw-medium"><i class="ti ti-calendar"></i> Joined at</span>
                                            <span class="float-end f-s-13 text-secondary">{{ auth()->user()->created_at->diffForHumans() ?? '-' }}</span>
                                        </div>
                                        {{-- <div>
                                            <span class="fw-medium"><i class="ti ti-notebook"></i> Biography</span>
                                            <span class="float-end f-s-13 text-secondary">{{ auth()->user()->bio ?? '-' }}</span>
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

                                        @if ($user->socialLinks->where('status', 1)->count())
                                            <div class="mt-4">
                                                <h6 class="text-muted">Social Links</h6>
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($user->socialLinks->where('status', 1) as $social)
                                                        <li class="mb-2 d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <i class="{{ $icons[$social->name] ?? 'ti ti-world' }} text-primary me-2"></i>
                                                                <a href="{{ $social->link }}" target="_blank" class="text-decoration-none text-secondary">
                                                                    {{ ucfirst($social->name) }}
                                                                </a>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a href="{{ $social->link }}" target="_blank" class="btn btn-sm btn-outline-primary">Go here</a>
                                                                <button type="button" class="btn btn-sm btn-outline-secondary copy-link" data-link="{{ $social->link }}">
                                                                    <i class="ti ti-copy"></i>
                                                                </button>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                document.querySelectorAll('.copy-link').forEach(button => {
                                                    button.addEventListener('click', function () {
                                                        const link = this.getAttribute('data-link');
                                                        navigator.clipboard.writeText(link).then(() => {
                                                            this.innerHTML = '<i class="ti ti-check"></i>';
                                                            setTimeout(() => {
                                                                this.innerHTML = '<i class="ti ti-copy"></i>';
                                                            }, 1500);
                                                        });
                                                    });
                                                });
                                            });
                                        </script>                                        
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>

                    <!-- tab 2 -->
                    <div id="tab-2" class="tabs-content">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <h5 class="mb-0">Created Courses</h5>
                            </div>                            

                            <div class="card-body">
                                <div class="row">
                                    @forelse ($courses->where('role_id', 1) as $course)
                                        <div class="col-xxl-4 col-md-6 col-sm-6 mb-4">
                                            <div class="card overflow-hidden h-100 border border-secondary rounded">
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
                                        <div class="col-12 text-center h-50">
                                            <p class="text-secondary">No courses found.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- tab 3 -->
                    <div id="tab-3" class="tabs-content">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <h5 class="mb-0">Joined Courses</h5>
                            </div>                            

                            <div class="card-body">
                                <div class="row">
                                    @forelse ($courses->where('role_id', 3) as $course)
                                        <div class="col-xxl-4 col-md-6 col-sm-6 mb-4">
                                            <div class="card overflow-hidden h-100 border border-secondary rounded">
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
                                        <div class="col-12 text-center h-50">
                                            <p class="text-secondary">No courses found.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- tab 4 -->
                    <div id="tab-4" class="tabs-content">
                        <div class="row profile-friend-box">
                            <div class="col-12">
                                <div class="card equal-card">
                                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap mb-3">
                                        <h5>Follower</h5>
                                        <h4 class="text-primary">{{ auth()->user()->total_follower }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <ul class="friend-list">
                                            @forelse ($followers as $follower)
                                                <li class="d-flex align-items-center position-relative justify-content-between">
                                                    {{-- Profile Link Section --}}
                                                    <div class="d-flex align-items-center gap-2" style="text-decoration: none; color: inherit;">
                                                        <a href="{{ route('user.profile', ['user_id' => encrypt($follower->id), 'shared' => 0]) }}" class="d-flex align-items-center">
                                                            <div class="h-50 w-50 d-flex-center b-r-50 overflow-hidden position-relative bg-danger" style="width: 50px; height: 50px;">
                                                                <img src="{{ $follower->image 
                                                                            ? asset('storage/uploads/profile_picture/' . $follower->image) 
                                                                            : asset('assets/images/avtar/1.png') }}" alt="image" class="img-fluid">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h6 class="mb-0 fw-medium text-ellipsis">{{ '@' . $follower->username }}</h6>
                                                                <p class="text-muted mb-0">{{ $follower->name }}</p>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    {{-- Follow Button --}}
                                                    {{-- <form method="POST" action="{{ route('user.update_follow', ['user_followed_id' => Crypt::encrypt($follower->id)]) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary b-r-5 me-2 d-flex align-items-center">
                                                            <i class="ti ti-user-check me-2"></i><span>Follow</span>
                                                        </button>
                                                    </form> --}}
                                                </li>
                                            @empty
                                                <div class="col-12 text-center h-50">
                                                    <p class="text-secondary">No followers found.</p>
                                                </div>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- tab 5 -->
                    <div id="tab-5" class="tabs-content">
                        <div class="row profile-friend-box">
                            <div class="col-12">
                                <div class="card equal-card">
                                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap mb-3">
                                        <h5>Following</h5>
                                        <h4 class="text-primary">{{ $user_follow->where('status', 1)->count() }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <ul class="friend-list">
                                            @forelse ($following as $following)
                                                <li class="d-flex align-items-center position-relative justify-content-between">
                                                    {{-- Profile Link Section --}}
                                                    <div class="d-flex align-items-center gap-2" style="text-decoration: none; color: inherit;">
                                                        <a href="{{ route('user.profile', ['user_id' => encrypt($following->id), 'shared' => 0]) }}" class="d-flex align-items-center">
                                                            <div class="h-50 w-50 d-flex-center b-r-50 overflow-hidden position-relative bg-danger" style="width: 50px; height: 50px;">
                                                                <img src="{{ $following->image 
                                                                            ? asset('storage/uploads/profile_picture/' . $following->image) 
                                                                            : asset('assets/images/avtar/1.png') }}" alt="image" class="img-fluid">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h6 class="mb-0 fw-medium text-ellipsis">{{ '@' . $following->username }}</h6>
                                                                <p class="text-muted mb-0">{{ $following->name }}</p>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    {{-- Follow Button --}}
                                                    {{-- <form method="POST" action="{{ route('user.update_follow', ['user_followed_id' => Crypt::encrypt($following->id)]) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary b-r-5 me-2 d-flex align-items-center">
                                                            <i class="ti ti-user-check me-2"></i><span>Follow</span>
                                                        </button>
                                                    </form> --}}
                                                </li>
                                            @empty
                                                <div class="col-12 text-center h-50">
                                                    <p class="text-secondary">No following found.</p>
                                                </div>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- tab 6 -->
                    <div id="tab-6" class="tabs-content ">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <h5>Level Progression</h5>
                                    {{-- <span class="badge bg-primary">Level {{ auth()->user()->userPoints?->level ?? '0' }} | {{ auth()->user()->userPoints?->xp ?? '0' }} XP</span> --}}
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center px-lg-5 px-3 py-3 gap-5 mb-3">
                                <div class="text-center">
                                    <p class="text-secondary">Level</p>
                                    <h4 class="text-primary">{{ auth()->user()->userPoints?->level ?? '0' }}</h4>
                                </div>
                                <div class="text-center">
                                    <p class="text-secondary">Total XP</p>
                                    <h4 class="text-primary">{{ auth()->user()->userPoints?->xp ?? '0' }}</h4>
                                </div>
                                <div class="text-center">
                                    <p class="text-secondary">Total Points</p>
                                    <h4 class="text-primary">{{ auth()->user()->userPoints?->total_points ?? '0' }}</h4>
                                </div>
                                <div class="text-center">
                                    <p class="text-secondary">Streak</p>
                                    <h4 class="text-primary">{{ auth()->user()->userPoints?->current_streak ?? '0' }}</h4>
                                </div>
                            </div>

                            @php
                                function xpForLevel($level) {
                                    return 100 * ($level - 1) * $level / 2;
                                }

                                function formatNumber($n) {
                                    if ($n >= 1e9) return number_format($n / 1e9, 1) . 'b';
                                    if ($n >= 1e6) return number_format($n / 1e6, 1) . 'm';
                                    if ($n >= 1e3) return number_format($n / 1e3, 1) . 'k';
                                    return $n;
                                }

                                $userPoints = auth()->user()->userPoints;

                                $currentXP = $userPoints->xp ?? 0;
                                $currentLevel = $userPoints->level ?? 0;

                                $nextLevel = $currentLevel + 1;
                                $xpToNextLevel = xpForLevel($nextLevel) - $currentXP;
                                $xpForNextLevel = $currentXP + $xpToNextLevel;
                                $xpForCurrentLevel = $xpForNextLevel - (100 * ($currentLevel - 1) * $currentLevel / 2);

                                $totalXPRequired = $currentXP + $xpToNextLevel;
                                $progressPercent = $totalXPRequired > 0
                                    ? min(round(($currentXP / $totalXPRequired) * 100), 100)
                                    : 0;
                            @endphp

                            <div class="card-body">
                                <div class="col-12 d-flex align-items-center gap-2 mb-3">
                                    <span>Lvl {{ formatNumber($currentLevel) }} ({{ formatNumber($xpForCurrentLevel) }} XP)</span>
                                    <div class="progress flex-grow-1 mx-2" style="height: 20px; min-width: 150px;">
                                        <div class="progress-bar bg-success progress-bar-striped" 
                                            role="progressbar" 
                                            style="width: {{ $progressPercent }}%;" 
                                            aria-valuenow="{{ $progressPercent }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                            {{ $progressPercent }}% ({{ formatNumber($currentXP) }} XP)
                                        </div>
                                    </div>
                                    <span>Lvl {{ formatNumber($nextLevel) }} ({{ formatNumber($xpForNextLevel) }} XP)</span>
                                </div>
                                @if( $user->userPoints )
                                    <div id="pie1" class="mt-3 mb-3"></div>
                                @else
                                    <div class="alert alert-light-border-warning d-flex align-items-center justify-content-between"
                                        role="alert">
                                        <p class="mb-0">
                                            <i class="ti ti-alert-triangle f-s-18 me-2"></i>No activity data available. Please complete some activities to see your progress.
                                        </p>
                                        {{-- <i class="ti ti-x" data-bs-dismiss="alert"></i> --}}
                                    </div>

                                @endif

                                <h6 class="text-muted">Recent Activity</h6>

                                <div id="user-points-container">
                                    @include('user.partials.user_activity_log')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    document.addEventListener('DOMContentLoaded', function() {
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

        var options = {
            series: [{{ $mcq->total_xp ?? 0 }}, {{ $flashcard->total_xp ?? 0 }}, {{ $wsp->total_xp ?? 0 }}],
            chart: {
                fontFamily: 'Montserrat, system-ui',
                height: 340,
                type: 'pie',
            },
            tooltip: {
                x: {
                    show: false,
                },
                style: {
                    fontSize: '16px',
                },
            },
            labels: ['MCQ Quiz', 'Flashcard', 'Word Search Puzzle'],
            colors: [
                getLocalStorageItem('color-primary', '#0d6efd'),
                getLocalStorageItem('color-success', '#198754'),
                getLocalStorageItem('color-warning', '#ffc107')
            ],
            legend: {
            position: 'bottom'
        },
            responsive: [{
                breakpoint: 1366,
                options: {
                    chart: {

                        height: 250
                    },
                    legend: {
                    show: false,
                    },
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#pie1"), options);
        chart.render();

        document.addEventListener('click', function (e) {
            if (e.target.matches('.pagination a')) {
                e.preventDefault();
                const url = e.target.getAttribute('href');

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('user-points-container').innerHTML = data;
                    window.history.pushState({}, '', url); // optional: update URL
                })
                .catch(error => console.error('Pagination error:', error));
            }
        });
    });


</script>

<!--customizer-->
<div id="customizer"></div>

<!-- Glight js -->
<script src="{{asset('assets/vendor/glightbox/glightbox.min.js')}}"></script>

<!-- filepond -->
<script src="{{asset('assets/vendor/filepond/file-encode.min.js')}}"></script>
<script src="{{asset('assets/vendor/filepond/validate-size.min.js')}}"></script>
<script src="{{asset('assets/vendor/filepond/validate-type.js')}}"></script>
<script src="{{asset('assets/vendor/filepond/exif-orientation.min.js')}}"></script>
<script src="{{asset('assets/vendor/filepond/image-preview.min.js')}}"></script>
<script src="{{asset('assets/vendor/filepond/filepond.min.js')}}"></script>

<!-- slick-file -->
<script src="{{asset('assets/vendor/slick/slick.min.js')}}"></script>
<script src="{{asset('assets/vendor/shepherdjs/shepherd.js')}}"></script>

<!-- apexcharts-->
<script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>

<!-- js -->
<script src="{{asset('assets/js/profile.js')}}"></script>
<script src="{{asset('assets/js/pie_charts.js')}}"></script>

@endsection
