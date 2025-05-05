@extends('layout.master')
@section('title', 'Lessons')
@section('css')
    <!-- apexcharts css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/apexcharts/apexcharts.css')}}">
@endsection
@section('main-content')
    <div class="container-fluid">

        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Lessons - {{ $course->name }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone  ph-stack f-s-16"></i> Course
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('course.find_course') }}" class="f-s-14 f-w-500">Find Courses</a>
                    </li>
                    <li>
                        <a href="{{ route('course.course_detail', ['course_id' => $course->id]) }}" class="f-s-14 f-w-500">Course Details</a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Lessons</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <!-- File manager start -->
        <div class="row">
            <div class="col-lg-4 col-xxl-3">
                <div class="card">
                    <div class="card-header">
                        {{-- <h5>Lesson List</h5> --}}
                        <div class="d-flex align-items-center justify-content-between">
                            <h5>Lesson List</h5>
                            {{-- <button class="btn btn-light-primary b-r-22"
                                    data-bs-target="#folderModal"
                                    data-bs-toggle="modal"
                                    type="button">Create Lesson
                            </button> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="horizontal-tab-wrapper">
                            <ul class="filemenu-list mt-3 tabs">
                                @foreach ($lessons as $index => $lesson)
                                    <li class="tab-link {{ $index == 0 ? 'active' : '' }}" data-tab="{{ $lesson->id }}">
                                        <i class="ti ti-folder-filled fs-5 pe-2"></i> <span class="flex-grow-1">{{ $lesson->name }}</span>
                                        {{ $lesson->resources->count() }} Resources
                                    </li>
                                @endforeach

                                {{-- <li class="tab-link" data-tab="2"><i class="ti ti-star fs-5 pe-2"></i><span
                                        class="flex-grow-1">Starred</span></li>
                                <li class="tab-link" data-tab="3"><i
                                        class="ti ti-trash fs-5 pe-2 "></i><span
                                        class="flex-grow-1">Recycle Bin </span>
                                    2+
                                </li>
                                <li class="tab-link" data-tab="4"><i
                                        class="ti ti-rotate-clockwise fs-5 pe-2"></i><span
                                        class="flex-grow-1"> Recent</span></li> --}}

                                <li class="app-divider-v dashed p-0 m-2"></li>
                                <li>
                                    <i class="ti ti-send fs-5 pe-2"></i>
                                    <span class="flex-grow-1">Shared File</span>
                                </li>
                                <li><i class="ti ti-help fs-5 pe-2"></i><span
                                        class="flex-grow-1">Help</span>
                                </li>
                                <li><i class="ti ti-adjustments-alt fs-5 pe-2"></i> <span
                                        class="flex-grow-1">Settings</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Overview</h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <div id="polar2"></div>
                        </div>
                        <div class="file-manager-sidebar mb-4"> 
                            <div class="d-flex align-items-center position-relative">
                        <span class="text-light-primary h-40 w-40 d-flex-center b-r-10 position-absolute">
                          <i class="ph-bold ph-folder f-s-20"></i>
                        </span>
                                <div class="flex-grow-1 ms-5">
                                    <h6 class="mb-0">Lesson</h6>
                                    <p class="text-secondary mb-0">{{ $lessons->count() ?? 0}} Lessons</p>
                                </div>
                                <p class="text-secondary f-w-500 mb-0">37.2GB</p>
                            </div>
                        </div>
                        <div class="file-manager-sidebar mb-4">
                            <div class="d-flex align-items-center position-relative">
                        <span class="text-light-success h-40 w-40 d-flex-center b-r-10 position-absolute">
                          <i class="ph-bold  ph-file f-s-22"></i>
                        </span>
                                <div class="flex-grow-1 ms-5  ">
                                    <h6 class="mb-0">Resource</h6>
                                    <p class="text-secondary mb-0">53 Files</p>
                                </div>
                                <p class="text-secondary f-w-500 mb-0">19.1 GB</p>
                            </div>
                        </div>
                        <div class="file-manager-sidebar">
                            <div class="d-flex align-items-center position-relative">
                        <span class="text-light-danger h-40 w-40 d-flex-center b-r-10 position-absolute">
                          <i class="ph-bold  ph-chat-circle-dots f-s-20"></i>
                        </span>
                                <div class="flex-grow-1 ms-5  ">
                                    <h6 class="mb-0">Comment</h6>
                                    <p class="text-secondary mb-0">486 Chit Chat</p>
                                </div>
                                <p class="text-secondary f-w-500 mb-0">23.5 MB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5>File Upload</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class=" mb-1 text-dark">Uploading 59 photos</h6>
                            <div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-secondary">Photoes 01</p>
                                    <span class="text-primary">65%</span>
                                </div>
                                <div class="progress h-5">
                                    <div aria-valuemax="100" aria-valuemin="0"
                                         aria-valuenow="20"
                                         class="progress-bar bg-primary h-5" role="progressbar"
                                         style="width: 65%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class=" mb-1 text-dark">Uploading 7 videos</h6>
                            <div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-secondary">Museum</p>
                                    <span class="text-primary">25%</span>
                                </div>
                                <div class="progress h-5">
                                    <div aria-valuemax="100" aria-valuemin="0"
                                         aria-valuenow="20"
                                         class="progress-bar bg-primary h-5" role="progressbar"
                                         style="width: 25%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class=" mb-1 text-dark">Uploading 12 Documents</h6>
                            <div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-secondary">My Work</p>
                                    <span class="text-primary">90%</span>
                                </div>
                                <div class="progress h-5">
                                    <div aria-valuemax="100" aria-valuemin="0"
                                         aria-valuenow="20"
                                         class="progress-bar bg-primary h-5" role="progressbar"
                                         style="width: 90%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xxl-9">
                <div class="content-wrapper">
                    <!-- tab-1  -->
                    @foreach ($lessons as $index => $lesson)
                        <div class="tabs-content {{ $index == 0 ? 'active' : '' }}" id="tab-{{ $lesson->id }}">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5>Resources - {{ $lesson->name }}</h5>
                                        <button class="btn btn-light-primary b-r-22"
                                                data-bs-target="#folderModal"
                                                data-bs-toggle="modal"
                                                type="button">Create Folder
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body" id="newFolder">
                                    <div class="row">

                                        @foreach ($lesson->resources as $resource)
                                            <div class="col-sm-6 col-xl-4 col-xxl-3">
                                                <div class="card hover-effect card-light-{{ $resource->category == 1 ? 'info' : 'success' }}">
                                                    <div class="card-body position-relative">
                                                        <!-- Dropdown -->
                                                        <div class="dropdown folder-dropdown" style="position: absolute; right: 15px; top: 15px;">
                                                            <a aria-expanded="true" class="" data-bs-toggle="dropdown" role="button">
                                                                <i class="ti ti-dots-vertical"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item view-item-btn" href="#">
                                                                    <i class="ti ti-file-export text-primary"></i> view</a>
                                                                </li>
                                                                <li><a class="dropdown-item edit-folder-list" data-bs-toggle="modal" href="#" role="button">
                                                                    <i class="ti ti-edit text-success"></i> Rename</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                            
                                                        <!-- Category ribbon -->
                                                        <div class="ribbon-side side-left ribbon-{{ $resource->category == 1 ? 'info' : 'success' }}">
                                                            {{ $resource->category == 1 ? 'Note' : 'Assignment' }}
                                                        </div>
                                                
                                                        <!-- Fixed-size thumbnail container -->
                                                        <div class="thumbnail-container mt-5">
                                                            @if($resource->resourceFile)
                                                                <!-- File preview -->
                                                                @if(in_array(strtolower($resource->resourceFile->type), ['jpg', 'jpeg', 'png', 'gif', 'svg']))
                                                                    <!-- Image with fixed-size container -->
                                                                    <div class="thumbnail-image-wrapper">
                                                                        <img src="{{ asset('storage/uploads/resource_file/' . $resource->resourceFile->name) }}" 
                                                                            class="thumbnail-image" 
                                                                            alt="{{ $resource->name }}">
                                                                    </div>
                                                                    <div class="thumbnail-badge">
                                                                        <i class="ph-bold ph-file-image" style="color: white;"></i> {{ $resource->resourceFile->type }}
                                                                    </div>
                                                                @elseif(strtolower($resource->resourceFile->type) === 'pdf')
                                                                    <!-- PDF thumbnail -->
                                                                    <div class="thumbnail-image-wrapper bg-danger-light">
                                                                        <i class="ph-bold ph-file-pdf"></i>
                                                                        <span class="thumbnail-label">PDF</span>
                                                                        <div class="thumbnail-badge">
                                                                            <i class="ph-bold ph-file-pdf" style="color: white;"></i> {{ $resource->resourceFile->type }}
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <!-- Other file types -->
                                                                    <div class="thumbnail-image-wrapper bg-primary-light">
                                                                        <i class="ph-bold ph-file"></i>
                                                                        <span class="thumbnail-label"> {{ strtoupper($resource->resourceFile->type) }}</span>
                                                                        <div class="thumbnail-badge">
                                                                            <i class="ph-bold ph-file" style="color: white;"></i> {{ $resource->resourceFile->type }}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @elseif($resource->link)
                                                                <!-- Link preview -->
                                                                @if(str_contains($resource->link, 'youtube.com') || str_contains($resource->link, 'youtu.be'))
                                                                    @php
                                                                        $videoId = '';
                                                                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $resource->link, $matches)) {
                                                                            $videoId = $matches[1];
                                                                        }
                                                                    @endphp
                                                                    @if($videoId)
                                                                        <div class="thumbnail-image-wrapper">
                                                                            <img src="https://img.youtube.com/vi/{{ $videoId }}/mqdefault.jpg" 
                                                                                class="thumbnail-image" 
                                                                                alt="YouTube thumbnail">
                                                                            <div class="thumbnail-badge">
                                                                                <i class="ph-bold ph-play-circle" style="color: white;"></i> YouTube
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="web-preview">
                                                                            <i class="ph-bold ph-youtube-logo"></i>
                                                                            <span class="web-domain">YouTube Link</span>
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                    <!-- Enhanced web preview -->
                                                                    <div class="web-preview">
                                                                        @php
                                                                            $domain = parse_url($resource->link, PHP_URL_HOST);
                                                                            $cleanDomain = str_replace('www.', '', $domain);
                                                                            $favicon = "https://www.google.com/s2/favicons?domain=".$domain;
                                                                        @endphp
                                                                        <img src="{{ $favicon }}" class="web-favicon" alt="Website icon">
                                                                        <span class="web-domain">{{ $cleanDomain ?? 'Web Link' }}</span>
                                                                        <div class="web-screenshot" style="background-image: url('https://api.screenshotone.com/take?url={{ urlencode($resource->link) }}&width=400&height=225&cache=true')">
                                                                            <!-- Fallback if screenshot fails -->
                                                                            {{-- <div class="web-screenshot-fallback">
                                                                                <i class="ph-bold ph-globe"></i>
                                                                            </div> --}}
                                                                        </div>
                                                                        <div class="thumbnail-badge">
                                                                            <i class="ph-bold ph-globe" style="color: white;"></i> Website
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <!-- Default icon when no file or link -->
                                                                <div class="thumbnail-default bg-secondary-light">
                                                                    <i class="ph-bold ph-question"></i>
                                                                    <span class="thumbnail-label">UNKNOWN</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        
                                                        <!-- Resource name -->
                                                        <p class="resource-name">{{ $resource->name }}</p>
                                                    </div>
                                                    <div class="card-footer code-footer d-flex justify-content-between align-items-center">
                                                        <div class="resource-stats">
                                                            <span><i class="ti ti-eye"></i> {{ $resource->total_visit ?? 0 }}</span>
                                                            <span><i class="ti ti-download"></i> {{ $resource->resourceFile->total_download ?? 0 }}</span>
                                                            <span><i class="ti ti-message"></i> {{ $resource->comments->count() }}</span>
                                                        </div>
                                                        <button type="button" class="btn btn-light-primary icon-btn b-r-22 hover-icon-white"> 
                                                            <i class="ti ti-chevron-up text-{{ $resource->category == 1 ? 'info' : 'success' }}"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- rename modal  -->
                            <div aria-hidden="true" aria-labelledby="renameModalLabel" class="modal fade"
                                id="renameModal"
                                tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <h1 class="modal-title fs-5 text-white" id="renameModalLabel">Folder
                                                Rename</h1>
                                            <button aria-label="Close" class="btn-close m-0"
                                                    data-bs-dismiss="modal"
                                                    type="button"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="rename-form">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <form id="renameForm">
                                                            <div class="mb-3">
                                                                <label class="form-label">Folder Name</label>
                                                                <input class="form-control" id="titlename"
                                                                    placeholder="Title" type="text">
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal"
                                                    type="button">Close
                                            </button>
                                            <button class="btn btn-light-primary" id="renamekey" type="button">
                                                Save
                                                changes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- rename modal end  -->

                            <!--new-folder-add modal start-->
                            <div aria-hidden="true" aria-labelledby="folderModalLabel" class="modal fade"
                                id="folderModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <h1 class="modal-title fs-5 text-white" id="folderModalLabel">New
                                                Folder</h1>
                                            <button aria-label="Close" class="btn-close m-0"
                                                    data-bs-dismiss="modal"
                                                    type="button"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="resent-form">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <form>
                                                            <div class="mb-3">
                                                                <label class="form-label">Folder Name</label>
                                                                <input class="form-control" id="title"
                                                                    placeholder="Title" type="text">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal"
                                                    type="button">Close
                                            </button>
                                            <button class="btn btn-light-primary" id="folderadd" type="button">
                                                Add New
                                                Folder
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--new-folder-add modal end -->

                            <!-- delete-modal start  -->
                            <div aria-hidden="true" class="modal fade" id="apiDeletModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <img alt="" class="img-fluid"
                                                src="{{asset('../assets/images/icons/delete-icon.png')}}">
                                            <div class="text-center">
                                                <h4 class="text-danger f-w-600">Are You Sure?</h4>
                                                <p class="text-secondary f-s-16">You won't be able to revert
                                                    this!</p>
                                            </div>

                                            <div class="text-center mt-3">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal"
                                                        type="button">Close
                                                </button>
                                                <button class="btn btn-light-primary" id="confirmDelete"
                                                        type="button">Yes,Delet it
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- delete-modal-end-->

                            <!-- recent modal start  -->
                            <div aria-hidden="true" aria-labelledby="resentModalLabel" class="modal fade"
                                id="resentModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <h1 class="modal-title fs-5 text-white" id="resentModalLabel">New
                                                File</h1>
                                            <button aria-label="Close" class="btn-close m-0"
                                                    data-bs-dismiss="modal"
                                                    type="button"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="resent-form">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <form id="resentForm">
                                                            <div class="mb-3">
                                                                <label class="form-label">File Name</label>
                                                                <input class="form-control" id="recentname"
                                                                    placeholder="Title" type="text">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal"
                                                    type="button">Close
                                            </button>
                                            <button class="btn btn-light-primary" id="resentkey" type="button">
                                                Add New
                                                File
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- recent modal end  -->

                        </div>
                    @endforeach

                    

                    <!-- tab-2  -->
                    <div class="tabs-content" id="tab-2">
                        <div class="card documents-section">
                            <div class="card-header">
                                <h5>Starred Documents & Files</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-xl-4 col-xxl-3">
                                        <div class="card quick-access">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div class="starreddiv favBtn">
                                                        <i class="ph-bold  ph-star text-warning f-s-18 fav-icon"></i>
                                                    </div>

                                                    <div class="dropdown folder-dropdown">
                                                        <a aria-expanded="true" class=""
                                                           data-bs-toggle="dropdown"
                                                           role="button">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item view-item-btn"
                                                                   href="#"><i
                                                                        class="ti ti-file-export text-primary"></i>
                                                                    view</a></li>
                                                            <li><a class="dropdown-item edit-folder-list"
                                                                   data-bs-toggle="modal" href="#"
                                                                   role="button"><i
                                                                        class="ti ti-edit text-success"></i>
                                                                    Rename</a></li>
                                                            <li><a class="dropdown-item delete-btn"
                                                                   data-bs-toggle="modal"
                                                                   href="#" role="button"><i
                                                                        class="ti ti-trash text-danger"></i>
                                                                    Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <span class="d-block text-center mb-3">
                                                                      <img alt="" class="img-fluid"
                                                                           src="{{asset('../assets/images/icons/zip.png')}}">
                                                            </span>
                                                <p class="text-center f-w-600 mb-0">3d illustration pack</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4 col-xxl-3">
                                        <div class="card">
                                            <div class="card-body folder-card">
                                                <div class="starreddiv favBtn">
                                                    <i class="ph-star text-warning f-s-18 fav-icon ph-fill"></i>
                                                </div>

                                                <div class="dropdown folder-dropdown">
                                                    <a aria-expanded="true" class=""
                                                       data-bs-toggle="dropdown"
                                                       role="button">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item view-item-btn"
                                                               href="#"><i
                                                                    class="ti ti-file-export text-primary"></i>
                                                                view</a></li>
                                                        <li><a class="dropdown-item edit-folder-list"
                                                               data-bs-toggle="modal" href="#"
                                                               role="button"><i
                                                                    class="ti ti-edit text-success"></i> Rename</a>
                                                        </li>
                                                        <li><a class="dropdown-item delete-btn"
                                                               data-bs-toggle="modal"
                                                               href="#" role="button"><i
                                                                    class="ti ti-trash text-danger"></i> Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="fileimage">
                                                    <img alt="" class="img-fluid"
                                                         src="{{asset('../assets/images/icons/folder.png')}}">
                                                    <p class="mb-0 f-s-16 text-center">Graduation</p>
                                                </div>
                                                <div class="d-flex justify-content-between mt-2">
                                                    <p class="text-secondary mb-0 f-w-500">25.67GB</p>
                                                    <p class="text-secondary mb-0 f-w-500 text-end">50GB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- tab-3  -->
                    <div class="tabs-content" id="tab-3">
                        <div class="card documents-sections">
                            <div class="card-header">
                                <h5>Deleted Flies</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-xl-4 col-xxl-3">
                                        <div class="card">
                                            <div class="card-body folder-card">
                                                <div class="starreddiv favBtn">
                                                    <i class="ph-bold  ph-star text-warning f-s-18 fav-icon"></i>
                                                </div>

                                                <div class="dropdown folder-dropdown">
                                                    <a aria-expanded="true" class=""
                                                       data-bs-toggle="dropdown"
                                                       role="button">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item view-item-btn"
                                                               href="#"><i
                                                                    class="ti ti-file-export text-primary"></i>
                                                                view</a></li>
                                                        <li><a class="dropdown-item edit-folder-list"
                                                               data-bs-toggle="modal" href="#"
                                                               role="button"><i
                                                                    class="ti ti-edit text-success"></i> Rename</a>
                                                        </li>
                                                        <li><a class="dropdown-item delete-btn"
                                                               data-bs-toggle="modal"
                                                               href="#" role="button"><i
                                                                    class="ti ti-trash text-danger"></i> Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="fileimage">
                                                    <img alt="" class="img-fluid"
                                                         src="{{asset('../assets/images/icons/folder.png')}}">
                                                    <p class="mb-0 f-s-16 text-center">My Work</p>
                                                </div>
                                                <div class="d-flex justify-content-between mt-2">
                                                    <p class="text-secondary mb-0 f-w-500">25.67GB</p>
                                                    <p class="text-secondary mb-0 f-w-500 text-end">50GB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4 col-xxl-3">
                                        <div class="card  quick-access">
                                            <div class="card-body">

                                                <div class="d-flex justify-content-between">
                                                    <div class="starreddiv favBtn">
                                                        <i class="ph-bold  ph-star text-warning f-s-18 fav-icon"></i>
                                                    </div>

                                                    <div class="dropdown folder-dropdown">
                                                        <a aria-expanded="true" class=""
                                                           data-bs-toggle="dropdown"
                                                           role="button">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item view-item-btn"
                                                                   href="#"><i
                                                                        class="ti ti-file-export text-primary"></i>
                                                                    view</a></li>
                                                            <li><a class="dropdown-item edit-folder-list"
                                                                   data-bs-toggle="modal" href="#"
                                                                   role="button"><i
                                                                        class="ti ti-edit text-success"></i>
                                                                    Rename</a></li>
                                                            <li><a class="dropdown-item delete-btn"
                                                                   data-bs-toggle="modal"
                                                                   href="#"
                                                                   role="button"><i
                                                                        class="ti ti-trash text-danger"></i>
                                                                    Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <span class="d-block text-center mb-3">
                                  <img alt="" class="img-fluid" src="{{asset('../assets/images/icons/file.png')}}">
                                </span>
                                                <p class="text-center f-w-600 mb-0">Product.docx</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4 col-xxl-3">
                                        <div class="card">
                                            <div class="card-body folder-card">
                                                <div class="starreddiv favBtn">
                                                    <i class="ph-bold  ph-star text-warning f-s-18 fav-icon"></i>
                                                </div>

                                                <div class="dropdown folder-dropdown">
                                                    <a aria-expanded="true" class=""
                                                       data-bs-toggle="dropdown"
                                                       role="button">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item view-item-btn"
                                                               href="#"><i
                                                                    class="ti ti-file-export text-primary"></i>
                                                                view</a></li>
                                                        <li><a class="dropdown-item edit-folder-list"
                                                               data-bs-toggle="modal" href="#"
                                                               role="button"><i
                                                                    class="ti ti-edit text-success"></i> Rename</a>
                                                        </li>
                                                        <li><a class="dropdown-item delete-btn"
                                                               data-bs-toggle="modal"
                                                               href="#" role="button"><i
                                                                    class="ti ti-trash text-danger"></i> Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="fileimage">
                                                    <img alt="" class="img-fluid"
                                                         src="{{asset('../assets/images/icons/folder.png')}}">
                                                    <p class="mb-0 f-s-16 text-center">Photoes</p>
                                                </div>
                                                <div class="d-flex justify-content-between mt-2">
                                                    <p class="text-secondary mb-0 f-w-500">25.67GB</p>
                                                    <p class="text-secondary mb-0 f-w-500 text-end">50GB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- tab-4  -->
                    <div class="tabs-content" id="tab-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Recent Added</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bottom-border recent-table align-middle table-hover mb-0"
                                           id="favorites-table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Total Items</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">Last Modified</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div>
                                                    <img alt=""
                                                         class="w-20 h-20"
                                                         src="{{asset('../assets/images/icons/music.png')}}">
                                                    <span class="ms-2 table-text">Quick CV & Porthfolio</span>
                                                </div>
                                            </td>
                                            <td class="text-success f-w-500">10</td>
                                            <td>209MB</td>
                                            <td class="text-danger f-w-500">15 march,2024</td>
                                            <td class="d-flex">
                                                <div class="dropdown folder-dropdown">
                                                    <a aria-expanded="true" class=""
                                                       data-bs-toggle="dropdown"
                                                       role="button">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item view-item-btn"
                                                               href="#"><i
                                                                    class="ti ti-file-export text-primary me-2"></i>
                                                                view</a></li>
                                                        <li><a class="dropdown-item edit-folder-name"
                                                               data-bs-toggle="modal" href="#"
                                                               role="button"><i
                                                                    class="ti ti-edit text-success me-2"></i>
                                                                Rename</a></li>
                                                        <li><a class="dropdown-item delete-btn"
                                                               data-bs-toggle="modal"
                                                               href="#" role="button"><i
                                                                    class="ti ti-trash text-danger me-2"></i>
                                                                Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="starreddiv favBtn ms-3">
                                                    <i class="ph-bold  ph-star text-warning f-s-18 star-icon"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <img alt=""
                                                         class="w-20 h-20"
                                                         src="{{asset('../assets/images/icons/pdf.png')}}">
                                                    <span class="ms-2 table-text">Thesis-Brain McKnight</span>
                                                </div>
                                            </td>
                                            <td class="text-success f-w-500">15</td>
                                            <td>25MB</td>
                                            <td class="text-danger f-w-500">10 july,2024</td>
                                            <td class="d-flex">
                                                <div class="dropdown folder-dropdown">
                                                    <a aria-expanded="true" class=""
                                                       data-bs-toggle="dropdown"
                                                       role="button">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item view-item-btn"
                                                               href="#"><i
                                                                    class="ti ti-file-export text-primary me-2"></i>
                                                                view</a></li>
                                                        <li><a class="dropdown-item edit-folder-name"
                                                               data-bs-toggle="modal" href="#"
                                                               role="button"><i
                                                                    class="ti ti-edit text-success me-2"></i>
                                                                Rename</a></li>
                                                        <li><a class="dropdown-item delete-btn"
                                                               data-bs-toggle="modal"
                                                               href="#" role="button"><i
                                                                    class="ti ti-trash text-danger me-2"></i>
                                                                Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="starreddiv favBtn ms-3">
                                                    <i class="ph-bold  ph-star text-warning f-s-18 star-icon"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <img alt=""
                                                         class="w-20 h-20"
                                                         src="{{asset('../assets/images/icons/gallary.png')}}">
                                                    <span class="ms-2 table-text">Campaign plan Q4-2021</span>
                                                </div>
                                            </td>
                                            <td class="text-success f-w-500">3</td>
                                            <td>103MB</td>
                                            <td class="text-danger f-w-500">2 May,2024</td>
                                            <td class="d-flex">
                                                <div class="dropdown folder-dropdown">
                                                    <a aria-expanded="true" class=""
                                                       data-bs-toggle="dropdown"
                                                       role="button">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item view-item-btn"
                                                               href="#"><i
                                                                    class="ti ti-file-export text-primary me-2"></i>
                                                                view</a></li>
                                                        <li><a class="dropdown-item edit-folder-name"
                                                               data-bs-toggle="modal" href="#"
                                                               role="button"><i
                                                                    class="ti ti-edit text-success me-2"></i>
                                                                Rename</a></li>
                                                        <li><a class="dropdown-item delete-btn"
                                                               data-bs-toggle="modal"
                                                               href="#" role="button"><i
                                                                    class="ti ti-trash text-danger me-2"></i>
                                                                Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="starreddiv favBtn ms-3">
                                                    <i class="ph-bold  ph-star text-warning f-s-18 fav-icon"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="seller-table-footer d-flex gap-2 justify-content-between align-items-center">
                                    <p class="text-secondary text-truncate">Showing 1 to 6 of 24 order
                                        entries</p>
                                    <ul class="pagination app-pagination">
                                        <li class="page-item bg-light-secondar disabled">
                                            <a class="page-link b-r-left">Previous</a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li aria-current="page" class="page-item active">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item page-next">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- File manager end -->

        <!-- Resource card thumbnail style -->
        <style>
            /* Thumbnail container styles */
            .thumbnail-container {
                width: 100%;
                height: 140px; /* Fixed height */
                margin: 15px 0;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                overflow: hidden;
                border-radius: 8px;
                background-color: #f8f9fa;
            }
            
            /* Image thumbnail wrapper */
            .thumbnail-image-wrapper {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            /* Actual image styling */
            .thumbnail-image {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
            }
            
            /* Default thumbnail style (for non-images) */
            .thumbnail-default {
                width: 100%;
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                color: white;
                border-radius: 8px;
            }
            
            .thumbnail-default i {
                font-size: 3rem;
                margin-bottom: 8px;
            }
            
            .thumbnail-label {
                font-size: 0.8rem;
                font-weight: 600;
                text-transform: uppercase;
            }
            
            /* Badge for YouTube thumbnails */
            .thumbnail-badge {
                position: absolute;
                bottom: 8px;
                right: 8px;
                background: rgba(0,0,0,0.7);
                color: white;
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 0.7rem;
            }
            
            /* Resource name styling */
            .resource-name {
                font-size: 1rem;
                text-align: center;
                margin-top: 10px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            /* Stats styling */
            .resource-stats {
                display: flex;
                gap: 10px;
                font-size: 0.8rem;
            }
            
            .resource-stats span {
                display: flex;
                align-items: center;
                gap: 3px;
            }
        </style>
    </div>
@endsection

@section('script')
    <!--customizer-->
    <div id="customizer"></div>

    <!-- apexcharts-->
    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>

    <!-- Tooltip js  -->
    <script src="{{asset('assets/js/tooltips_popovers.js')}}"></script>

    <!--js-->
    <script src="{{asset('assets/js/filemanager.js')}}"></script>

@endsection
