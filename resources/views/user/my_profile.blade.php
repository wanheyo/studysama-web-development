
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
                          </span>
                                </li>
                                <li class="tab-link fw-medium f-s-16 f-w-600" data-tab="3"><i
                                        class="ti ti-clipboard-data fw-bold"></i> Created Course</li>
                                <li class="tab-link fw-medium f-s-16 f-w-600" data-tab="4"><i
                                        class="ti ti-photo-heart fw-bold"></i> Joined Course</li>
                                <li class="tab-link fw-medium f-s-16  f-w-600" data-tab="5"><i class="ti ti-users fw-bold"></i>
                                    Friends</li>
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="card d-lg-block d-none">
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
                </div>

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
                                            <h5 class="f-w-600">{{auth()->user()->username }}
                                                <img src="{{asset('../assets/images/profile-app/01.png')}}" class="w-20 h-20" alt="instagram-check-mark">
                                            </h5>
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
                    <div id="tab-2" class="tabs-content ">
                        <div class="card">
                            <div class="card-header">
                                <h5>Activity</h5>
                            </div>
                            <div class="card-body">
                                <ul class="app-timeline-box">
                                    <li class="timeline-section">
                                        <div class="timeline-icon">
                              <span class="text-light-primary h-35 w-35 d-flex-center b-r-50">
                                W
                              </span>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="f-s-16">
                                                <span class="text-primary f-s-16 mb-0">Wilson<span class="text-secondary ms-2">added reaction in <span class="badge text-outline-primary me-2">#product website</span>post</span></span>
                                            </div>
                                            <p class="f-w-500 text-end mt-2 mb-0">
                                                <i class="ph ph-clock me-1 align-middle"></i>09.00AM
                                            </p>
                                        </div>
                                    </li>
                                    <li class="timeline-section">
                                        <div class="timeline-icon">
                              <span class="text-light-info h-35 w-35 d-flex-center b-r-50 icon-direction">
                                <i class="ph-duotone  ph-image f-s-18"></i>
                              </span>
                                        </div>
                                        <div class="timeline-content">
                                            <p class=" f-s-16 text-info mb-0">2 image files and 2 vedios uploaded</p>

                                            <div class="app-timeline-info-text timeline-border-box me-2 ms-0 mt-3 p-3">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <a href="{{asset('../assets/images/draggable/02.jpg')}}" class="glightbox img-hover-zoom" data-glightbox="type: image; zoomable: true;">
                                                            <img src="{{asset('../assets/images/draggable/02.jpg')}}" class="w-100 rounded" alt="">
                                                        </a>

                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a href="{{asset('../assets/images/draggable/04.jpg')}}" class="glightbox img-hover-zoom" data-glightbox="type: image; zoomable: true;">
                                                            <img src="{{asset('../assets/images/draggable/04.jpg')}}" class="w-100 rounded" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a href="{{asset('../assets/images/draggable/01.jpg')}}" class="glightbox img-hover-zoom" data-glightbox="type: image; zoomable: true;">
                                                            <img src="{{asset('../assets/images/draggable/01.jpg')}}" class="w-100 rounded" alt="">
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>

                                            <p class="f-w-500 text-end mt-2 mb-0">
                                                <i class="ph ph-clock me-1 align-middle"></i>Updated at 12:45 pm
                                            </p>
                                        </div>


                                    </li>
                                    <li class="timeline-section">
                                        <div class="timeline-icon">
                              <span class="text-light-success  h-35 w-35 d-flex-center b-r-50">
                                D
                              </span>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="f-s-16">
                                                <span class="text-secondary"><span class="text-success f-s-16 mb-0">Dane Wiza</span> added reaction in <span class="badge text-outline-success me-2">#product website</span>post</span>
                                            </div>
                                            <div class="timeline-border-box me-2 ms-0 mt-3">
                                                <h6 class="mb-0">Need a feature</h6>
                                                <p class="mb-4 text-secondary">Hello everyone,
                                                    question on email marketing. What are some
                                                    tips/tricks to avoid going to promotion
                                                    spam/ junk for automated marketing emails
                                                    going to promotion spam/ junk for automated
                                                    marketing emails</p>
                                                <span class="badge text-outline-success me-2 timeline-badge">#🙂❤10Reactions</span>
                                                <span class="badge text-outline-success me-2">#✨12Replies</span>
                                            </div>
                                            <p class="f-w-500 text-end mt-2 mb-0">
                                                <i class="ph ph-clock me-1 align-middle"></i>09.00AM
                                            </p>
                                        </div>


                                    </li>
                                    <li class="timeline-section">
                                        <div class="timeline-icon">
                              <span class="text-light-danger h-35 w-35 d-flex-center b-r-50">
                                B
                              </span>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="f-s-16">
                                                <span class="text-danger f-s-16 mb-0">Betty Mante <span class="text-secondary ms-2">Request joined <span class="badge text-outline-danger me-2">#reaserchteam</span>groups</span></span>
                                            </div>
                                            <div class="mt-3">
                                                <button type="button"
                                                        class="btn btn-danger">Accept</button>
                                                <button type="button"
                                                        class="btn btn-outline-danger">Rejects</button>
                                            </div>
                                            <p class="f-w-500 text-end mt-2 mb-0">
                                                <i class="ph ph-clock me-1 align-middle"></i>4 days ago
                                            </p>
                                        </div>


                                    </li>
                                    <li class="timeline-section">
                                        <div class="timeline-icon">
                              <span class="text-light-primary h-35 w-35 d-flex-center b-r-50">
                                P
                              </span>
                                        </div>
                                        <div class="timeline-content">
                                            <div class=" f-s-16">
                                <span class="text-primary f-s-16 mb-0">Pinkie
                                <span class="text-secondary ms-2">uploaded
                                  <span class="text-dark f-w-600 me-2 ms-2">2</span>attachment <span class="badge text-outline-primary me-2">#reaserchteam</span></span>
                                </span>
                                            </div>

                                            <div class="mt-3">
                                                <button type="button"
                                                        class="btn btn-primary">Accept</button>
                                                <button type="button"
                                                        class="btn btn-outline-primary">Rejects</button>
                                            </div>
                                            <p class="f-w-500 text-end mt-2 mb-0">
                                                <i class="ph ph-clock me-1 align-middle"></i>4 days ago
                                            </p>
                                        </div>


                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- tab 3 -->
                    <div id="tab-3" class="tabs-content">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <h5 class="mb-0">Created Courses</h5>
                                
                                <form class="app-form app-icon-form d-inline-block " action="#">
                                    <div class="position-relative">
                                        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                                        <i class="ti ti-search text-dark"></i>
                                    </div>
                                </form>
                            </div>                            

                            <div class="card-body">
                                <div class="row">
                                    @forelse ($courses->where('role_id', 1) as $course)
                                        <div class="col-12 col-md-6 mb-4">
                                            <div class="card overflow-hidden h-100 border border-secondary rounded">
                                                <div class="card-body p-0">
                                                    <div class="product-content-box">
                                                        <div class="product-grid">
                                                            <div class="product-image">
                                                                <a href="#" class="image">
                                                                    <img class="pic-1" src="{{ asset($course->image ? 'storage/uploads/course_picture/' . $course->image : '../assets/images/ecommerce/1280x720.png') }}" alt="">
                                                                    <img class="images_box" src="{{ asset('../assets/images/ecommerce/1280x720.png') }}" alt="">
                                                                </a>
                                                                <ul class="product-links">
                                                                    <li><a href="{{ route('wishlist') }}" target="_blank" class="bg-danger h-30 w-30 d-flex-center b-r-20"><i class="f-s-18 ti ti-heart text-light"></i></a></li>
                                                                    <li><a href="{{ route('cart') }}" target="_blank" class="bg-primary h-30 w-30 d-flex-center b-r-20"><i class="ti ti-shopping-cart f-s-18 text-light"></i></a></li>
                                                                    <li><a href="{{ route('product_details') }}" target="_blank" class="bg-success h-30 w-30 d-flex-center b-r-20"><i class="ti ti-eye f-s-18 text-light"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="p-3">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <a href="{{ route('product_details') }}" target="_blank" class="m-0 f-s-20 f-w-500 text-truncate" title="{{ $course->name }}">
                                                                    {{ $course->name }}
                                                                </a>
                                                                <p class="text-warning m-0">4.2 <span><i class="ti ti-star-filled"></i></span></p>
                                                            </div>
                                                            <p class="text-secondary mb-0" style="min-height: 40px;">
                                                                {{ $course->desc ?? 'No description available' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center">
                                            <p class="text-secondary">No courses found.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- tab 4 -->
                    <div id="tab-4" class="tabs-content">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <h5 class="mb-0">Joined Courses</h5>
                                
                                <form class="app-form app-icon-form d-inline-block " action="#">
                                    <div class="position-relative">
                                        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                                        <i class="ti ti-search text-dark"></i>
                                    </div>
                                </form>
                            </div>                            

                            <div class="card-body">
                                <div class="row">
                                    @forelse ($courses->where('role_id', 3) as $course)
                                        <div class="col-12 col-md-6 mb-4">
                                            <div class="card overflow-hidden h-100 border border-secondary rounded">
                                                <div class="card-body p-0">
                                                    <div class="product-content-box">
                                                        <div class="product-grid">
                                                            <div class="product-image">
                                                                <a href="#" class="image">
                                                                    <img class="pic-1" src="{{ asset($course->image ? 'storage/uploads/course_picture/' . $course->image : '../assets/images/ecommerce/1280x720.png') }}" alt="">
                                                                    <img class="images_box" src="{{ asset('../assets/images/ecommerce/1280x720.png') }}" alt="">
                                                                </a>
                                                                <ul class="product-links">
                                                                    <li><a href="{{ route('wishlist') }}" target="_blank" class="bg-danger h-30 w-30 d-flex-center b-r-20"><i class="f-s-18 ti ti-heart text-light"></i></a></li>
                                                                    <li><a href="{{ route('cart') }}" target="_blank" class="bg-primary h-30 w-30 d-flex-center b-r-20"><i class="ti ti-shopping-cart f-s-18 text-light"></i></a></li>
                                                                    <li><a href="{{ route('product_details') }}" target="_blank" class="bg-success h-30 w-30 d-flex-center b-r-20"><i class="ti ti-eye f-s-18 text-light"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="p-3">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <a href="{{ route('product_details') }}" target="_blank" class="m-0 f-s-20 f-w-500 text-truncate" title="{{ $course->name }}">
                                                                    {{ $course->name }}
                                                                </a>
                                                                <p class="text-warning m-0">4.2 <span><i class="ti ti-star-filled"></i></span></p>
                                                            </div>
                                                            <p class="text-secondary mb-0" style="min-height: 40px;">
                                                                {{ $course->desc ?? 'No description available' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center">
                                            <p class="text-secondary">No courses found.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- tab 5 -->
                    <div id="tab-5" class="tabs-content">
                        <div class="row profile-friend-box">
                            <div class="col-12">
                                <div class="row">

                                    <div class="col-xxl-6 box-col">
                                        <div class="card friend-list-card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="h-45 w-45 d-flex-center b-r-50 overflow-hidden bg-dark position-absolute">
                                                        <img src="{{asset('../assets/images/avtar/2.png')}}" alt="image" class="img-fluid">
                                                    </div>
                                                    <div class="flex-grow-1 mg-s-55">
                                                        <div class="f-w-500">Fleta Walsh</div>
                                                        <div class="text-muted f-s-12">Wed Developer</div>
                                                    </div>
                                                    <a href="{{route('chat')}}" target="_blank" class="btn btn-light-success icon-btn b-r-22"> <i class="ti ti-brand-hipchat"></i> </a>
                                                </div>
                                                <div class="mt-4 friend-list-content">
                                                    <p class="mb-0">
                                                        Web Developer 👩‍💼 at <span class="text-primary f-w-500">@TechFirm</span>. Building innovative solutions for <span class="text-primary f-w-500">@PersonalProject</span>  in my free 🕐 time.
                                                    </p>
                                                    <div class="app-divider-v dashed m-0 py-3"></div>
                                                    <p class="f-s-16 text-secondary mb-0"><span class="text-dark f-w-500">14k</span> Follower <span class="text-dark f-w-500">8k</span> Following</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 box-col">
                                        <div class="card friend-list-card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="h-45 w-45 d-flex-center b-r-50 overflow-hidden bg-primary position-absolute">
                                                        <img src="{{asset('../assets/images/avtar/16.png')}}" alt="image" class="img-fluid">
                                                    </div>
                                                    <div class="flex-grow-1 mg-s-55">
                                                        <div class="fw-medium"> Bette Hagenes</div>
                                                        <div class="text-muted f-s-12">Wed Designer</div>
                                                    </div>
                                                    <a href="{{route('chat')}}" target="_blank" class="btn btn-light-success icon-btn b-r-22"> <i class="ti ti-brand-hipchat"></i> </a>
                                                </div>
                                                <div class="mt-4 friend-list-content">
                                                    <p class="mb-0">
                                                        "Transforming ideas into visually stunning 💻 websites for <span class="text-primary f-w-500">@FreelanceProject</span> during my off hours."
                                                    </p>
                                                    <div class="app-divider-v dashed m-0 py-3"></div>
                                                    <p class="f-s-16 text-secondary mb-0"><span class="text-dark f-w-500">14k</span> Follower <span class="text-dark f-w-500">8k</span> Following</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 box-col">
                                        <div class="card friend-list-card equal-card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="h-45 w-45 d-flex-center b-r-50 overflow-hidden bg-warning position-absolute">
                                                        <img src="{{asset('../assets/images/avtar/1.png')}}" alt="image" class="img-fluid">
                                                    </div>
                                                    <div class="flex-grow-1 mg-s-55">
                                                        <div class="fw-medium"> Heli Walsh</div>
                                                        <div class="text-muted f-s-12">UI/UX designer</div>
                                                    </div>
                                                    <a href="{{route('chat')}}" target="_blank" class="btn btn-light-success icon-btn b-r-22"> <i class="ti ti-brand-hipchat"></i> </a>
                                                </div>
                                                <div class="mt-3 friend-list-content">
                                                    <p class="mb-0">
                                                        "Crafting intuitive experiences, one  pixel at a time 📏📈."
                                                    </p>
                                                    <div class="app-divider-v dashed m-0 py-3"></div>
                                                    <p class="f-s-16 text-secondary mb-0"><span class="text-dark f-w-500">14k</span> Follower <span class="text-dark f-w-500">8k</span> Following</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 box-col">
                                        <div class="card friend-list-card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="h-45 w-45 d-flex-center b-r-50 overflow-hidden bg-danger  position-absolute">
                                                        <img src="{{asset('../assets/images/avtar/10.png')}}" alt="image" class="img-fluid">
                                                    </div>
                                                    <div class="flex-grow-1 mg-s-55">
                                                        <div class="fw-medium"> Lenora</div>
                                                        <div class="text-muted f-s-12">React Developer</div>
                                                    </div>
                                                    <a href="{{route('chat')}}" target="_blank" class="btn btn-light-success icon-btn b-r-22"> <i class="ti ti-brand-hipchat"></i> </a>
                                                </div>
                                                <div class="mt-3 friend-list-content">
                                                    <p class="mb-0">
                                                        "Crafting dynamic, responsive, and efficient user interfaces with the ⚡ power of React."
                                                    </p>
                                                    <div class="app-divider-v dashed m-0 py-3"></div>
                                                    <p class="f-s-16 text-secondary mb-0"><span class="text-dark f-w-500">14k</span> Follower <span class="text-dark f-w-500">8k</span> Following</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card equal-card">
                                            <div class="card-header">
                                                <h5>Friends Requests</h5>
                                            </div>
                                            <div class="card-body">
                                                <ul class="friend-list">
                                                    <li class="d-flex align-items-center position-relative">
                                                        <div class="h-50 w-50 d-flex-center b-r-50 overflow-hidden position-absolute bg-danger">
                                                            <img src="{{asset('../assets/images/avtar/1.png')}}" alt="image" class="img-fluid">
                                                        </div>
                                                        <div class="flex-grow-1 mg-s-50">
                                                            <h6 class="mb-0 fw-medium text-ellipsis"> @Bette</h6>
                                                            <p class="text-muted mb-0">Web Developer</p>
                                                        </div>
                                                        <a href="#" class="btn btn-primary b-r-5 me-2"> <i class="ti ti-user-check me-2"></i><span>Follow</span> </a>
                                                        <a href="#" class="btn btn-danger b-r-5"> <i class="ti ti-user-x me-2"></i><span>Remove</span>
                                                        </a>

                                                    </li>
                                                    <li class="d-flex align-items-center mt-3 position-relative">
                                                        <div class="h-50 w-50 d-flex-center b-r-50 overflow-hidden position-absolute bg-success">
                                                            <img src="{{asset('../assets/images/avtar/10.png')}}" alt="image" class="img-fluid">
                                                        </div>
                                                        <div class="flex-grow-1 mg-s-50">
                                                            <h6 class="mb-0 fw-medium  text-ellipsis"> @Fleta</h6>
                                                            <p class="text-muted mb-0">Web Designer</p>
                                                        </div>
                                                        <a href="#" class="btn btn-primary b-r-5 me-2"> <i class="ti ti-user-check me-2"></i><span>Follow</span> </a>
                                                        <a href="#" class="btn btn-danger b-r-5"> <i class="ti ti-user-x me-2"></i><span>Remove</span>
                                                        </a>
                                                    </li>
                                                    <li class="d-flex align-items-center mt-3 position-relative">
                                                        <div class="h-50 w-50 d-flex-center b-r-50 overflow-hidden position-absolute bg-secondary">
                                                            <img src="{{asset('../assets/images/avtar/14.png')}}" alt="image" class="img-fluid">
                                                        </div>
                                                        <div class="flex-grow-1 mg-s-50">
                                                            <h6 class="mb-0 fw-medium  text-ellipsis"> @Lenora</h6>
                                                            <p class="text-muted mb-0">UI/UX designer</p>
                                                        </div>
                                                        <a href="#" class="btn btn-primary b-r-5 me-2"> <i class="ti ti-user-check me-2"></i><span>Follow</span> </a>
                                                        <a href="#" class="btn btn-danger b-r-5"> <i class="ti ti-user-x me-2"></i><span>Remove</span>
                                                        </a>
                                                    </li>
                                                    <li class="d-flex align-items-center mt-3 position-relative">
                                                        <div class="h-50 w-50 d-flex-center b-r-50 overflow-hidden position-absolute bg-warning">
                                                            <img src="{{asset('../assets/images/avtar/12.png')}}" alt="image" class="img-fluid">
                                                        </div>
                                                        <div class="flex-grow-1 mg-s-50">
                                                            <h6 class="mb-0 fw-medium text-ellipsis"> @Olive </h6>
                                                            <p class="text-muted mb-0"> Developer</p>
                                                        </div>
                                                        <a href="#" class="btn btn-primary b-r-5 me-2"> <i class="ti ti-user-check me-2"></i><span>Follow</span> </a>
                                                        <a href="#" class="btn btn-danger b-r-5"> <i class="ti ti-user-x me-2"></i><span>Remove</span>
                                                        </a>
                                                    </li>
                                                    <li class="d-flex align-items-center mt-3 position-relative">
                                                        <div class="h-50 w-50 d-flex-center b-r-50 overflow-hidden position-absolute bg-primary">
                                                            <img src="{{asset('../assets/images/avtar/2.png')}}" alt="image" class="img-fluid">
                                                        </div>
                                                        <div class="flex-grow-1 mg-s-50">
                                                            <h6 class="mb-0 fw-medium text-ellipsis"> @Mason</h6>
                                                            <p class="text-muted mb-0"> Developer</p>
                                                        </div>
                                                        <a href="#" class="btn btn-primary b-r-5 me-2"> <i class="ti ti-user-check me-2"></i><span>Follow</span> </a>
                                                        <a href="#" class="btn btn-danger b-r-5"> <i class="ti ti-user-x me-2"></i><span>Remove</span>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- <div class="col-lg-4 col-xxl-3 col-box-4 order-lg--1">
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
                                                        : asset('../assets/images/avtar/woman.jpg') }}">
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="person-details">
                                <h5 class="f-w-600">{{ auth()->user()->name }}
                                    <img src="{{asset('../assets/images/profile-app/01.png')}}" class="w-20 h-20" alt="instagram-check-mark">
                                </h5>
                                <p>{{'@' . auth()->user()->username }}</p>
                                <div class="details">
                                    <div>
                                        <h4 class="text-primary">{{ auth()->user()->total_follower }}</h4>
                                        <p class="text-secondary">Follower</p>
                                    </div>
                                    <div>
                                        <h4 class="text-primary">{{ $user_follow->where('status', 1)->count() }}</h4>
                                        <p class="text-secondary">Following</p>
                                    </div>
                                </div>
                                <div class="my-2">
                                    <button type="button" class="btn btn-primary b-r-22" id="editButton"> <i class="ti ti-edit"></i>
                                        Edit Profile</button>
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
                                <span class="fw-medium"><i class="ti ti-briefcase"></i> Work passion</span>
                                <span class="float-end f-s-13 text-secondary">IT Section</span>
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
                                <span class="fw-medium"><i class="ti ti-cake"></i> Birth of Date</span>
                                <span class="float-end f-s-13 text-secondary">24 Oct</span>
                            </div>
                            <div>
                                <span class="fw-semibold"><i class="ti ti-map-pin"></i> Location</span>
                                <span class="float-end f-s-13 text-secondary">Via Partenope, 117</span>
                            </div>
                            <div>
                                <span class="fw-semibold"><i class="ti ti-device-laptop"></i> Website</span>
                                <span class="float-end f-s-13 text-secondary">Ninfa_devWWW.com</span>
                            </div>
                            <div>
                                <span class="fw-semibold"><i class="ti ti-brand-github"></i> Github</span>
                                <span class="float-end f-s-13 text-secondary">Ninfa_dev</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@section('script')
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

<!-- js -->
<script src="{{asset('assets/js/profile.js')}}"></script>

@endsection
