@extends('layout.master')
@section('title', 'Lessons')
@section('css')
    <!-- apexcharts css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/apexcharts/apexcharts.css')}}">
@endsection
@section('main-content')

    @php
        $isTutor = auth()->user()
            ->userCourses()
            ->where('course_id', $course->id)
            ->where('role_id', 1)
            ->exists();
    @endphp

    <div class="container-fluid">

        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Lessons - {{ $course->name }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone ph-book f-s-16"></i> Course
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('course.find_course') }}" class="f-s-14 f-w-500">Find Courses</a>
                    </li>
                    <li>
                        <a href="{{ route('course.course_detail', ['course_id' => encrypt($course->id)]) }}" class="f-s-14 f-w-500">{{ $course->name }}</a>
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
                            @if ($isTutor)
                                <div id="reorder-actions">
                                    <button id="reorder-btn" class="btn btn-light-primary b-r-22" type="button">
                                    <i class="ti ti-edit"></i> Reorder
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="horizontal-tab-wrapper">
                            <ul id="lesson-list" class="filemenu-list mt-3 tabs">
                                @if ($lessons->isNotEmpty())
                                    @foreach ($lessons as $index => $lesson)
                                        @php
                                            $totalResourcesForLesson = $lesson->resources->count();
                                            $checkedCount = $lesson->resources->sum(function ($resource) {
                                                return $resource->userProgressions->where('status', 1)->count();
                                            });
                                            $isCompleted = $totalResources > 0 && $checkedCount === $totalResourcesForLesson;
                                        @endphp

                                        <li class="tab-link d-flex align-items-center justify-content-between {{ $index == 0 ? 'active' : '' }}"
                                            data-tab="{{ $lesson->id }}" data-id="{{ $lesson->id }}">
                                            <div class="d-flex align-items-center">
                                                @if (!$isTutor && $isCompleted)
                                                    <i class="ti ti-circle-check-filled fs-5 pe-2 lesson-status-icon"
                                                    data-lesson="{{ $lesson->id }}"></i>
                                                @else
                                                    <i class="ti ti-folder-filled fs-5 pe-2 lesson-status-icon"
                                                    data-lesson="{{ $lesson->id }}"></i>
                                                @endif
                                                <span class="flex-grow-1">{{ $lesson->name }}</span>
                                            </div>

                                            <div>{{ $totalResourcesForLesson }}</div>
                                            <i class="ti ti-menu-order ms-2 drag-handle" aria-hidden="true"></i>
                                        </li>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted my-4">
                                        <i class="ti ti-folder-off fs-2"></i>
                                        <p class="mt-2">No lesson have been added to this course yet.</p>
                                    </div>
                                @endif
                                

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
                                @if ($isTutor)
                                    <li data-bs-target="#lessonAddModal" data-bs-toggle="modal" class="my-3 border border-dashed rounded-pill hover-effect d-flex align-items-center gap-2">
                                        <i class="ti ti-folder-plus fs-5 pe-2"></i>
                                        <span class="flex-grow-1">Create New Lesson</span>
                                    </li>
                                @endif
                                {{-- <li><i class="ti ti-certificate{{ $courseProgress >= 100 ? '' : '-off' }} fs-5 pe-2"></i> <span
                                        class="flex-grow-1">Certificate</span>
                                </li> --}}
                                <li data-bs-toggle="modal" data-bs-target="#helpModal" style="cursor: pointer;" class="d-flex align-items-center gap-2">
                                    <i class="ti ti-help fs-5"></i>
                                    <span class="flex-grow-1">Help</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-3">Course Overview</h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <div id="course-progress-chart"
                                data-total-resources="{{ $totalResources }}"
                                data-checked-resources="{{ $totalChecked }}"
                                data-progress="{{ $courseProgress }}"
                                data-bs-placement="top" data-bs-toggle="tooltip" title="Course Progress Percentage">
                            </div>
                        </div>
                        <div class="file-manager-sidebar mb-4"> 
                            <div class="d-flex align-items-center position-relative">
                                <span class="text-light-primary h-40 w-40 d-flex-center b-r-10 position-absolute">
                                    <i class="ph-bold ph-folder f-s-20"></i>
                                </span>
                                <div class="flex-grow-1 ms-5">
                                    <h6 class="mb-0">Lesson</h6>
                                    <p id="lesson-status"
                                    class="text-{{ $totalCompletedLessons == $totalLessons ? 'success' : 'secondary' }} mb-0">
                                        {{ $totalCompletedLessons == $totalLessons ? 'Completed' : 'Uncompleted' }}
                                    </p>
                                </div>
                                <p id="lesson-count" class="text-secondary f-w-500 mb-0">
                                    {{ $totalCompletedLessons ?? 0 }} / {{ $totalLessons ?? 0}}
                                </p>
                            </div>
                        </div>

                        <div class="file-manager-sidebar mb-4">
                            <div class="d-flex align-items-center position-relative">
                                <span class="text-light-success h-40 w-40 d-flex-center b-r-10 position-absolute">
                                    <i class="ph-bold ph-file f-s-22"></i>
                                </span>
                                <div class="flex-grow-1 ms-5">
                                    <h6 class="mb-0">Resource</h6>
                                    <p id="resource-status"
                                    class="text-{{ $totalCompletedResources == $totalResources ? 'success' : 'secondary' }} mb-0">
                                        {{ $totalCompletedResources == $totalResources ? 'Completed' : 'Uncompleted' }}
                                    </p>
                                </div>
                                <p id="resource-count" class="text-secondary f-w-500 mb-0">
                                    {{ $totalCompletedResources ?? 0 }} / {{ $totalResources ?? 0 }}
                                </p>
                            </div>
                        </div>

                        {{-- <div class="file-manager-sidebar mb-4">
                            <div class="d-flex align-items-center position-relative">
                                <span class="text-light-danger h-40 w-40 d-flex-center b-r-10 position-absolute">
                                    <i class="ph-bold  ph-chat-circle-dots f-s-20"></i>
                                </span>
                                <div class="flex-grow-1 ms-5  ">
                                    <h6 class="mb-0">Comment</h6>
                                    <p class="text-secondary mb-0">Completed</p>
                                </div>
                                <p class="text-secondary f-w-500 mb-0">{{ $totalComments ?? 0 }} Made</p>
                            </div>
                        </div> --}}
                    </div>
                </div>

                {{-- <div class="card">
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
                </div> --}}
            </div>
            <div class="col-lg-8 col-xxl-9">
                <div class="content-wrapper">
                    <!-- tab-1  -->
                    @if ($lessons->isNotEmpty())
                        @foreach ($lessons as $index => $lesson)
                            <div class="tabs-content {{ $index == 0 ? 'active' : '' }}" id="tab-{{ $lesson->id }}">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5>Resources</h5>
                                            @if ($isTutor)
                                                <div class="d-flex flex-column flex-md-row gap-2">
                                                    <button class="btn btn-light-primary b-r-22"
                                                            data-bs-target="#lessonEditModal"
                                                            data-bs-toggle="modal"
                                                            data-lesson-id="{{ $lesson->id }}"
                                                            data-lesson-name="{{ $lesson->name }}"
                                                            data-lesson-desc="{{ $lesson->desc }}"
                                                            data-lesson-learn-outcome="{{ $lesson->learn_outcome }}"
                                                            type="button"><i class="ti ti-edit"></i> Edit Lesson
                                                    </button>
                                                    <button class="btn btn-primary b-r-22"
                                                            data-bs-target="#resourceAddModal"
                                                            data-bs-toggle="modal"
                                                            onclick="prepareResourceModal({{ $lesson->id }})"
                                                            type="button"><i class="ti ti-file-upload"></i> Add New Resource
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="card-body p-4 lesson-container" id="newFolder" data-lesson="{{ $lesson->id }}">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="card border">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <div class="col-10">
                                                                @php
                                                                    $totalResources = $lesson->resources->count();
                                                                    $checkedCount = $lesson->resources->sum(function ($resource) {
                                                                        return $resource->userProgressions->where('status', 1)->count();
                                                                    });

                                                                    // avoid division by zero
                                                                    $percentage = $totalResources > 0 ? round(($checkedCount / $totalResources) * 100, 1) : 0;
                                                                @endphp

                                                                <h4 class="mb-4"><i class="ti {{ $percentage == 100 ? 'ti-circle-check-filled' : '' }} fs-5 lesson-progress-icon"></i> {{ $lesson->name }}</h4>

                                                                {{-- <div class="progress w-100 h-15 lesson-progress-bar"
                                                                    role="progressbar"
                                                                    aria-valuenow="{{ $percentage }}"
                                                                    aria-valuemin="0"
                                                                    aria-valuemax="100"
                                                                    data-lesson="{{ $lesson->id }}">
                                                                    <div class="progress-bar bg-primary progress-bar-striped text-white" 
                                                                        style="width: {{ $percentage }}%">
                                                                        {{ $percentage }}%
                                                                    </div>
                                                                </div> --}}
                                                            </div>

                                                            <div class="col-2 text-end">
                                                                <span class="badge bg-primary text-white px-3 py-2 b-r-22 lesson-progress"
                                                                    data-lesson="{{ $lesson->id }}">
                                                                    {{ $checkedCount }} / {{ $totalResources }} Completed
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-body resource-details-content">
                                                        <div class="mb-3">
                                                            <h6><i class="ti ti-file-text me-2"></i>Description</h6>
                                                            <p class="text-secondary f-s-16">{{ $lesson->desc ?? 'This is lesson ' . $lesson->name }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6><i class="ti ti-bulb me-2"></i>Learning Outcome</h6>
                                                            <p class="text-secondary f-s-16">{{ $lesson->learn_outcome ?? 'No learning outcome included' }}</p>
                                                        </div>
                                                        {{-- <div class="mb-3">
                                                            <h6>Progress</h6>
                                                            <div class="progress w-100" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                                <div class="progress-bar bg-primary progress-bar-striped text-white" style="width: 12.5%"> 12.5% </div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($lesson->resources->isNotEmpty())
                                                @foreach ($lesson->resources as $resource)
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                                                        <div class="card hover-effect card-light-{{ $resource->category == 1 ? 'info' : 'success' }}">
                                                            <div class="card-body position-relative">
                                                                <div class="dropdown folder-dropdown" style="position: absolute; right: 15px; top: 15px;">
                                                                    {{-- just once for testing --}}
                                                                    {{-- @dump($resource->progression) --}}

                                                                    @php
                                                                        // progressions is always a collection (empty if none)
                                                                        $progression = $resource->userProgressions->first();
                                                                        $isChecked = $progression && $progression->status == 1;
                                                                    @endphp

                                                                    @if (!$isTutor)
                                                                        <i class="ti {{ $isChecked ? 'ti-circle-check-filled' : 'ti-circle' }} 
                                                                                fs-3 toggle-progression 
                                                                                text-{{ $resource->category == 1 ? 'info' : 'success' }}"
                                                                            data-resource="{{ $resource->id }}"
                                                                            data-course="{{ $course->id }}"
                                                                            data-category="{{ $resource->category }}"
                                                                            data-lesson="{{ $lesson->id }}"
                                                                            style="cursor: pointer;">
                                                                        </i>
                                                                    @endif

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
                                                                        {{-- VIDEO FILES --}}
                                                                        @elseif(in_array(strtolower($resource->resourceFile->type), ['mp4', 'mov', 'avi', 'mkv', 'wmv', 'webm']))
                                                                            <div class="thumbnail-image-wrapper position-relative overflow-hidden">
                                                                                <video src="{{ asset('storage/uploads/resource_file/' . $resource->resourceFile->name) }}" class="w-100" style="height: 180px; object-fit: cover;" muted></video>
                                                                                <div class="position-absolute top-50 start-50 translate-middle text-white">
                                                                                    <i class="ph-bold ph-play-circle" style="font-size: 3rem; opacity: 0.85;"></i>
                                                                                </div>
                                                                                <div class="thumbnail-badge">
                                                                                    <i class="ph-bold ph-film-strip" style="color: white;"></i> {{ strtoupper($resource->resourceFile->type) }}
                                                                                </div>
                                                                            </div>

                                                                        {{-- AUDIO FILES --}}
                                                                        @elseif(in_array(strtolower($resource->resourceFile->type), ['mp3', 'wav', 'm4a', 'aac', 'flac']))
                                                                            <div class="thumbnail-image-wrapper d-flex flex-column align-items-center justify-content-center p-3">
                                                                                <i class="ph-bold ph-speaker-high text-white mb-2" style="font-size: 2rem;"></i>
                                                                                <span class="text-white small">Audio File</span>
                                                                                <div class="thumbnail-badge">
                                                                                    <i class="ph-bold ph-music-note" style="color: white;"></i> {{ strtoupper($resource->resourceFile->type) }}
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
                                                                    {{-- <span><i class="ti ti-eye"></i> {{ $resource->total_visit ?? 0 }}</span>
                                                                    <span><i class="ti ti-download"></i> {{ $resource->resourceFile->total_download ?? 0 }}</span> --}}
                                                                    <span><i class="ti ti-circle-check"></i> {{ $resource->studentProgressions->where('status', 1)->count() ?? 0 }}/{{ $lesson->course->userCourses->where('status', 1)->count() ?? 0 }}</span>
                                                                    {{-- <span><i class="ti ti-message"></i> {{ $resource->comments->count() }}</span> --}}
                                                                    <span><i class="ti ti-message"></i> {{ $resource->forumPosts->count() ?? 0 }}</span>
                                                                </div>

                                                                <button type="button" class="btn btn-light-{{ $resource->category == 1 ? 'info' : 'success' }} icon-btn b-r-22 hover-icon-white" 
                                                                        data-bs-target="#resourceDetailModal" 
                                                                        data-bs-toggle="modal"
                                                                        data-lesson-id="{{ $lesson->id }}"
                                                                        data-resource-id="{{ $resource->id }}"
                                                                        data-resource-id-encrypted="{{ Crypt::encrypt($resource->id) }}"
                                                                        data-resource-name="{{ $resource->name }}"
                                                                        data-resource-description="{{ $resource->desc ?? '' }}"
                                                                        data-resource-category="{{ $resource->category }}"
                                                                        data-resource-type="{{ $resource->resourceFile ? $resource->resourceFile->type : 'link' }}"
                                                                        data-resource-file-name ="{{ $resource->resourceFile ? $resource->resourceFile->name : '' }}"
                                                                        data-resource-path="{{ $resource->resourceFile ? asset('storage/uploads/resource_file/' . $resource->resourceFile->name) : $resource->link }}"
                                                                        data-resource-views="{{ $resource->total_visit ?? 0 }}"
                                                                        data-resource-downloads="{{ $resource->resourceFile->total_download ?? 0 }}"
                                                                        data-resource-comments="{{ $resource->comments->count() }}"
                                                                        data-resource-created="{{ $resource->created_at->format('M d, Y') }}"
                                                                        data-resource-ischecked="{{ $isChecked ? '1' : '0' }}"
                                                                        data-resource-forums="{{ $resource->forumPosts->count() ?? 0 }}"
                                                                        data-resource-total-completed="{{ $resource->studentProgressions->where('status', 1)->count() ?? 0 }}"
                                                                        data-resource-total-students="{{ $lesson->course->userCourses->where('status', 1)->count() ?? 0 }}">
                                                                    <i class="ti ti-chevron-up text-{{ $resource->category == 1 ? 'info' : 'success' }}"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="text-center text-muted my-4">
                                                    <i class="ti ti-folder-off fs-2"></i>
                                                    <p class="mt-2">No resources have been added to this lesson yet.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
                            <div class="text-center text-muted">
                                <i class="ti ti-folder-off fs-2"></i>
                                <p class="mt-2">No lesson have been added to this course yet.</p>
                            </div>
                        </div>
                    @endif



                    <!-- resourceDetailModal modal start -->
                    <div aria-hidden="true" aria-labelledby="resourceDetailModalLabel" class="modal fade" id="resourceDetailModal" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title text-white" id="resourceDetailModalLabel">Resource Details</h5>
                                    <button aria-label="Close" class="btn-close btn-close-white m-0" data-bs-dismiss="modal" type="button"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <div class="row g-0">
                                        <!-- Left Column - Preview and Actions -->
                                        <div class="col-lg-5 border-end">
                                            <div class="p-4">
                                                <!-- Resource Preview -->
                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-4" 
                                                    id="resourcePreview">
                                                    <!-- Preview will be inserted here by JavaScript -->
                                                </div>
                                                
                                                <!-- Action Buttons -->
                                                <div class="d-grid gap-2 mb-4">
                                                    <a id="downloadBtn" href="#" class="btn btn-primary btn-lg" download>
                                                        <i class="ti ti-download me-2"></i> Download Resource
                                                    </a>
                                                    
                                                    <div class="row g-2">
                                                        @if ($isTutor)
                                                            <div class="col-6">
                                                                <button class="btn btn-outline-primary w-100" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#resourceEditModal"
                                                                        data-resource-id="">
                                                                    <i class="ti ti-edit me-1"></i> Edit
                                                                </button>
                                                            </div>
                                                            <div class="col-6">
                                                                <button class="btn btn-outline-info w-100" id="resourceDetailModalForumBtn">
                                                                    <i class="ti ti-message-circle me-1"></i> Forum
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="col-6">
                                                                <button class="btn btn-outline-success w-100" id="resourceDetailModalCompleteBtn">
                                                                    <i class="ti ti-circle-check me-1"></i> Complete
                                                                </button>
                                                            </div>
                                                            <div class="col-6">
                                                                <button class="btn btn-outline-info w-100" id="resourceDetailModalForumBtn">
                                                                    <i class="ti ti-message-circle me-1"></i> Forum
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <!-- Stats Card -->
                                                <div class="card shadow-sm border">
                                                    <div class="card-header bg-light">
                                                        <h6 class="fw-semibold">
                                                            <i class="ti ti-chart-bar me-2"></i>Resource Statistics
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row text-center">
                                                            <div class="col-6 border-end">
                                                                <div class="py-2">
                                                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                                                        <i class="ti ti-circle-check fs-4 text-success me-2"></i>
                                                                        <div>
                                                                            <span class="fs-4 fw-bold text-dark" id="completedCount">0</span>
                                                                            <span class="text-muted mx-1">/</span>
                                                                            <span class="fs-5 text-muted" id="studentsCount">0</span>
                                                                        </div>
                                                                    </div>
                                                                    <p class="text-muted mb-0 small">Students Completed</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="py-2">
                                                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                                                        <i class="ti ti-message-circle fs-4 text-info me-2"></i>
                                                                        <span class="fs-4 fw-bold text-dark" id="forumsCount">0</span>
                                                                        {{-- <span class="fs-4 fw-bold text-dark" id="commentsCount">0</span> --}}
                                                                    </div>
                                                                    <p class="text-muted mb-0 small">Forum Discussions</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Right Column - Details -->
                                        <div class="col-lg-7">
                                            <div class="p-4">
                                                <!-- Resource Information -->
                                                <div class="mb-4">
                                                    <h3 id="resourceName" class="mb-3 fw-bold">Resource Name</h3>
                                                    
                                                    <div class="d-flex align-items-center text-muted mb-4">
                                                        <i class="ti ti-clock me-2"></i>
                                                        <small id="resourceCreated">Uploaded on Jan 1, 2023</small>
                                                    </div>
                                                    
                                                    <div class="card border">
                                                        <div class="card-body">
                                                            <h6 class="fw-semibold mb-3">
                                                                <i class="ti ti-file-text me-2"></i>Description
                                                            </h6>
                                                            <p id="resourceDescription" class="text-muted mb-0 lh-lg">
                                                                No description available
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Additional Info Section (Optional - can be populated via JS) -->
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="card border">
                                                            <div class="card-body p-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div>
                                                                        <p class="text-muted mb-0 small">Resource Category</p>
                                                                        <h6 class="mb-0 fw-semibold" id="resourceCategory"></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card border">
                                                            <div class="card-body p-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div>
                                                                        <p class="text-muted mb-0 small">Resource Type</p>
                                                                        <h6 class="mb-0 fw-semibold" id="resourceType"></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Help Text -->
                                                <div class="alert alert-info mt-4 d-flex align-items-start" role="alert">
                                                    <i class="ti ti-info-circle me-2 mt-1"></i>
                                                    <div class="small">
                                                        <strong>Need help?</strong> Click the Forum button to discuss this resource with other students and instructors.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>                            
                    <!-- resourceDetailModal modal end  -->

                    <!--lessonAddModal modal start-->
                    <div aria-hidden="true" aria-labelledby="lessonAddModalLabel" class="modal fade"
                        id="lessonAddModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h1 class="modal-title fs-5 text-white" id="lessonAddModalLabel">New Lesson</h1>
                                    <button aria-label="Close" class="btn-close m-0"
                                            data-bs-dismiss="modal"
                                            type="button"></button>
                                </div>
                                <form id="lessonForm" method="POST" action="{{ route('course.lesson.add_lesson.post', $course->id) }}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="resent-form">
                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- Updated Form inside Modal -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Lesson Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="name" placeholder="Title" type="text" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Description (Optional)</label>
                                                        <textarea class="form-control" name="desc" placeholder="Description"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Learning Outcome (Optional)</label>
                                                        <textarea class="form-control" name="learn_outcome" placeholder="Learning Outcomes"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        {{-- <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button> --}}
                                        <button class="btn btn-light-primary" id="lessonadd" type="submit">Add New Lesson</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--lessonAddModal modal end -->

                    <!--lessonEditModal modal start-->
                    <div aria-hidden="true" aria-labelledby="lessonEditModalLabel" class="modal fade"
                    id="lessonEditModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h1 class="modal-title fs-5 text-white" id="lessonEditModalLabel">Edit Lesson</h1>
                                    <button aria-label="Close" class="btn-close m-0"
                                            data-bs-dismiss="modal"
                                            type="button"></button>
                                </div>
                                <form id="updateLessonForm" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="resent-form">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="formFieldsWrapper">
                                                        <div class="mb-3">
                                                            <label class="form-label">Lesson Name <span class="text-danger">*</span></label>
                                                            <input class="form-control" id="editLessonName" name="name" placeholder="Title" type="text" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Description (Optional)</label>
                                                            <textarea class="form-control" id="editLessonDesc" name="desc" placeholder="Description"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Learning Outcome (Optional)</label>
                                                            <textarea class="form-control" id="editLessonLearnOutcome" name="learn_outcome" placeholder="Learning Outcomes"></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Delete confirmation section - updated -->
                                                    <div id="deleteConfirmWrapper" class="w-100 d-none mb-3">
                                                        <label class="form-label">Type the lesson name to confirm deletion:</label>
                                                        <input type="text" id="deleteConfirmInput" class="form-control" placeholder="Type lesson name here...">
                                                        <small class="text-danger d-none" id="deleteConfirmError">Name does not match. Try again.</small>
                                                        <!-- The Confirm Delete button will be added here programmatically -->
                                                    </div>
                                                    
                                                    <!-- Hidden delete flag field -->
                                                    {{-- <input type="hidden" name="delete" id="deleteFlag" value="0"> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- The Confirm Delete button will be added here programmatically -->
                                        <button type="button" class="btn btn-danger d-none" id="confirmDeleteBtn">Confirm Delete</button>
                                        <button type="button" class="btn btn-danger" id="deleteLessonBtn">Delete Lesson</button>
                                        <button type="button" class="btn btn-secondary d-none" id="cancelDeleteBtn">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--lessonEditModal modal end -->

                    <!--resourceAddModal modal start-->
                    <div aria-hidden="true" aria-labelledby="resourceAddModalLabel" class="modal fade" id="resourceAddModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h1 class="modal-title fs-5 text-white" id="resourceAddModalLabel">New Resource</h1>
                                    <button aria-label="Close" class="btn-close m-0" data-bs-dismiss="modal" type="button"></button>
                                </div>
                                <form id="resourceForm" method="POST" action="{{ route('resource.add_resource') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="resent-form">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="hidden" name="lesson_id" id="lesson_id" value="">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Resource Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" id="name" name="name" placeholder="Resource name" type="text" required>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Description (Optional)</label>
                                                        <textarea class="form-control" id="desc" name="desc" placeholder="Description" rows="3"></textarea>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Category <span class="text-danger">*</span></label>
                                                        <select class="form-select" id="category" name="category" required>
                                                            <option value="">Select Category</option>
                                                            <option value="1">Note</option>
                                                            <option value="2">Assignment</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Resource Type <span class="text-danger">*</span></label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="resource_type" id="type_file" value="file" checked>
                                                            <label class="form-check-label" for="type_file">
                                                                Upload File
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="resource_type" id="type_link" value="link">
                                                            <label class="form-check-label" for="type_link">
                                                                Provide Link/URL
                                                            </label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3" id="file_upload_section">
                                                        <label class="form-label">Upload File <span class="text-danger">*</span></label>
                                                        <div class="dropzone-container border rounded p-3">
                                                            <input type="file" name="file" id="file" class="form-control">
                                                            <input type="hidden" name="file_name" id="file_name">
                                                            <input type="hidden" name="file_type" id="file_type">
                                                            <div class="text-center text-muted mt-2">
                                                                <small>Supported formats: jpg, jpeg, png, gif, bmp, tiff, doc, docx, pdf, txt, rtf, odt, zip, rar, 7z, mp4, mov, avi, mkv, wmv, webm, mp3, wav, m4a, aac, flac (Max: 100MB)</small>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3" id="link_section" style="display: none;">
                                                        <label class="form-label">Resource Link/URL <span class="text-danger">*</span></label>
                                                        <input class="form-control" id="link" name="link" placeholder="https://example.com/resource" type="url">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="upload-progress mt-3" id="uploadProgress" style="display: none;">
                                            <div class="progress-box bg-light-success w-100 p-3 rounded">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div class="left d-flex align-items-center">
                                                        <b class="me-1 ms-1" id="uploadPercent">0%</b> Uploading...
                                                    </div>
                                                    <div class="right">
                                                        <span class="badge text-bg-success" id="uploadTimeRemaining">Estimating...</span>
                                                    </div>
                                                </div>
                                                <div class="progress w-100" style="height: 6px;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-success" id="uploadProgressBar" style="width: 0%"></div>
                                                </div>
                                            </div>

                                            <div class="alert alert-info mt-2 mb-0 d-flex align-items-center" role="alert">
                                                <i class="ph ph-info me-2"></i>
                                                <div>
                                                    Upload in progress — <strong>do not close</strong> this window or modal until the upload is complete.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                                        <button class="btn btn-primary" type="submit">Add Resource</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--resourceAddModal modal end -->

                    <!--resourceEditModal modal start-->
                    <div aria-hidden="true" aria-labelledby="resourceEditModalLabel" class="modal fade" id="resourceEditModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h1 class="modal-title fs-5 text-white" id="resourceEditModalLabel">Edit Resource</h1>
                                    <button aria-label="Close" class="btn-close m-0" data-bs-dismiss="modal" type="button"></button>
                                </div>
                                <form id="updateResourceForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="modal-body">
                                        <div class="resent-form">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="resourceEditFormWrapper">
                                                        <input type="hidden" name="resource_id" id="edit_resource_id" value="">
                                                        <input type="hidden" name="file_id" id="edit_file_id" value="">
                                                        <input type="hidden" name="delete" id="delete_flag" value="0">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Resource Name <span class="text-danger">*</span></label>
                                                            <input class="form-control" id="editResourceName" name="name" placeholder="Resource name" type="text" required>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Description (Optional)</label>
                                                            <textarea class="form-control" id="editResourceDescription" name="desc" placeholder="Description" rows="3"></textarea>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Category <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="editResourceCategory" name="category" required>
                                                                <option value="">Select Category</option>
                                                                <option value="1">Note</option>
                                                                <option value="2">Assignment</option>
                                                            </select>
                                                        </div>

                                                        {{-- <div class="light-border-warning" role="alert">Upload link/file disable for edit for data integrity purpose, please create new resource.</div> --}}
                                                        <div class="alert alert-light-border-warning d-flex align-items-center justify-content-between"
                                                            role="alert">
                                                            <p class="mb-0">
                                                                <i class="ti ti-alert-triangle f-s-18 me-2"></i>You can't change the file/url to ensure data integrity. Please upload a new one to make changes.
                                                            </p>
                                                            <i class="ti ti-x" data-bs-dismiss="alert"></i>
                                                        </div>
                                                        {{-- <div class="mb-3">
                                                            <label class="form-label">Resource Type <span class="text-danger">*</span></label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="resource_type" id="resourceType_file" value="file" checked>
                                                                <label class="form-check-label" for="resourceType_file">
                                                                    Upload File
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="resource_type" id="resourceType_link" value="link">
                                                                <label class="form-check-label" for="resourceType_link">
                                                                    Provide Link/URL
                                                                </label>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mb-3" id="resource_file_upload_section">
                                                            <label class="form-label">Upload File <span class="text-muted">(Leave empty to keep existing file)</span></label>
                                                            <div class="dropzone-container border rounded p-3">
                                                                <input type="file" name="file" id="edit_resource_file" class="form-control">
                                                                <div class="text-center text-muted mt-2">
                                                                    <small>Supported formats: jpg, jpeg, png, gif, bmp, tiff, doc, docx, pdf, txt, rtf, odt, zip, rar, 7z (Max: 5MB)</small>
                                                                    <div class="input-group mt-3">
                                                                        <span class="input-group-text b-r-left text-bg-primary" id="basic-addon1">Existing file</span>
                                                                        <input type="text" class="form-control b-r-right" placeholder="No file uploaded" aria-label="Existing file"
                                                                            aria-describedby="basic-addon1" id="existing_file_info" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mb-3" id="resource_link_section" style="display: none;">
                                                            <label class="form-label">Resource Link/URL <span class="text-danger">*</span></label>
                                                            <input class="form-control" id="editResourceLink" name="link" placeholder="https://example.com/resource" type="url">
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" id="deleteResourceBtn">Delete Resource</button>
                                        <button type="button" class="btn btn-danger d-none" id="confirmDeleteResourceBtn">Confirm Delete</button>
                                        <button type="button" class="btn btn-secondary d-none" id="cancelDeleteResourceBtn">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="saveResourceChangesBtn">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--resourceEditModal modal end -->

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
            </div>
        </div>
        <!-- File manager end -->

        <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="helpModalLabel">Lesson Help</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            <li> 1. Lorem ipsum dolor sit amet.</li>
                            <li> 2. Unde reprehenderit nulla fugiat ut.</li>
                            <li> 3. Error velit quisquam quam exercitationem.</li>
                            <li> 4. Veritatis delectus atque itaque reprehenderit.</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

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


            /* Modal styles */
            .web-preview {
                background-color: #f8f9fa;
                border-radius: 8px;
                padding: 20px;
                text-align: center;
            }
            
            #resourcePreview {
                border: 1px solid #e9ecef;
                border-radius: 8px;
                background-color: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            #commentsList {
                scrollbar-width: thin;
                scrollbar-color: #dee2e6 #f8f9fa;
            }
            
            #commentsList::-webkit-scrollbar {
                width: 6px;
            }
            
            #commentsList::-webkit-scrollbar-track {
                background: #f8f9fa;
            }
            
            #commentsList::-webkit-scrollbar-thumb {
                background-color: #dee2e6;
                border-radius: 6px;
            }

            .swal2-toast {
                width: auto !important;
                max-width: 100% !important;
                padding: 0.625em !important;
            }

            .dropzone-container {
                min-height: 100px;
                border: 2px dashed #ddd;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                transition: border-color 0.3s;
                cursor: pointer;
            }
            
            .dropzone-container:hover, .dropzone-container.border-primary {
                border-color: #3085d6 !important;
            }
            
            .dropzone-container input[type="file"] {
                width: 100%;
                padding: 10px;
            }

            #lesson-list .drag-handle { display: none; }

            /* show handles only in reorder mode */
            #lesson-list.reorder-active .drag-handle { display: inline-block; cursor: grab; }

            .sortable-ghost { opacity: 0.6; background: #f8f9fa; }
        </style>

    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function() {
            // Toggle between file upload and link sections
            $('input[name="resource_type"]').change(function() {
                if ($(this).val() === 'file') {
                    $('#file_upload_section').show();
                    $('#link_section').hide();
                    $('#link').removeAttr('required');
                    $('#file').attr('required', 'required');
                } else {
                    $('#file_upload_section').hide();
                    $('#link_section').show();
                    $('#file').removeAttr('required');
                    $('#link').attr('required', 'required');
                }
            });

            // When a file is selected, capture file name and type
            $('#file').change(function() {
                if (this.files && this.files[0]) {
                    var file = this.files[0];
                    $('#file_name').val(file.name);
                    $('#file_type').val(file.type);
                }
            });

            // Make the dropzone area support drag and drop
            const dropzoneContainer = document.querySelector('.dropzone-container');
            const fileInput = document.querySelector('#file');

            if (dropzoneContainer) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropzoneContainer.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropzoneContainer.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropzoneContainer.addEventListener(eventName, unhighlight, false);
                });

                function highlight() {
                    dropzoneContainer.classList.add('border-primary');
                }

                function unhighlight() {
                    dropzoneContainer.classList.remove('border-primary');
                }

                dropzoneContainer.addEventListener('drop', handleDrop, false);

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    fileInput.files = files;
                    
                    // Trigger change event on file input
                    const event = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(event);
                }
            }

            // Reset form when modal is closed
            $('#resourceAddModal').on('hidden.bs.modal', function() {
                $('#resourceForm')[0].reset();
                $('#file_upload_section').show();
                $('#link_section').hide();
                // Remove any validation styling
                $('.is-invalid').removeClass('is-invalid');
            });
        });

        function prepareResourceModal(lessonId) {
            // Set the lesson_id in the form
            $('#lesson_id').val(lessonId);
        }

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

            // Upload progress handling
            const resourceForm = document.getElementById('resourceForm');
            const uploadProgress = document.getElementById('uploadProgress');
            const progressBar = document.getElementById('uploadProgressBar');
            const percentLabel = document.getElementById('uploadPercent');
            const timeRemaining = document.getElementById('uploadTimeRemaining');
            const modal = document.getElementById('resourceAddModal');

            let uploadStartTime = null;

            // Prevent closing modal during upload
            modal.addEventListener('hide.bs.modal', function (e) {
                if (uploadProgress.style.display === 'block') {
                    e.preventDefault();
                    alert('Upload in progress. Please wait until it completes.');
                }
            });

            resourceForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(resourceForm);
                const actionUrl = resourceForm.action;

                // Show progress UI
                uploadProgress.style.display = 'block';
                progressBar.style.width = '0%';
                percentLabel.textContent = '0%';
                timeRemaining.textContent = 'Estimating...';
                uploadStartTime = Date.now();

                const xhr = new XMLHttpRequest();
                xhr.open('POST', actionUrl, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.upload.addEventListener('progress', function (event) {
                    if (event.lengthComputable) {
                        const percent = Math.round((event.loaded / event.total) * 100);
                        progressBar.style.width = percent + '%';
                        percentLabel.textContent = percent + '%';

                        const elapsed = (Date.now() - uploadStartTime) / 1000; // seconds
                        const speed = event.loaded / elapsed; // bytes per second
                        const remainingBytes = event.total - event.loaded;
                        const remainingSeconds = remainingBytes / speed;
                        if (remainingSeconds > 0 && remainingSeconds < 3600) {
                            const mins = Math.ceil(remainingSeconds / 60);
                            timeRemaining.textContent = `${mins} min${mins > 1 ? 's' : ''}`;
                        } else {
                            timeRemaining.textContent = 'Almost done...';
                        }
                    }
                });

                xhr.onload = function () {
                    uploadProgress.style.display = 'none';
                    progressBar.style.width = '0%';

                    if (xhr.status === 200) {
                        // Success
                        window.location.reload();
                    } else {
                        alert('Upload failed. Please try again.');
                    }
                };

                xhr.onerror = function () {
                    uploadProgress.style.display = 'none';
                    alert('An error occurred during upload.');
                };

                xhr.send(formData);
            });


            // Edit lesson modal
            const lessonEditModal = document.getElementById('lessonEditModal');
            let currentLessonName = '';

            lessonEditModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Extract data from button
                const lessonId = button.getAttribute('data-lesson-id');
                currentLessonName = button.getAttribute('data-lesson-name');
                const lessonDesc = button.getAttribute('data-lesson-desc');
                const lessonOutcome = button.getAttribute('data-lesson-learn-outcome');

                // Populate form fields - Using currentLessonName instead of undefined lessonName
                document.getElementById('editLessonName').value = currentLessonName || '';
                document.getElementById('editLessonDesc').value = lessonDesc || '';
                document.getElementById('editLessonLearnOutcome').value = lessonOutcome || '';

                // Set form action dynamically for update functionality
                const updateLessonform = document.getElementById('updateLessonForm');
                updateLessonform.action = `/course/course_detail/update_lesson/${lessonId}`; 
                updateLessonform.method = 'POST';
                
                // Store the lesson ID for delete functionality
                updateLessonform.dataset.lessonId = lessonId;

                // Reset UI elements
                document.getElementById('deleteConfirmInput').value = '';
                document.getElementById('deleteConfirmWrapper').classList.add('d-none');
                document.getElementById('deleteConfirmError').classList.add('d-none');
                document.getElementById('formFieldsWrapper').classList.remove('d-none');

                document.getElementById('deleteLessonBtn').classList.remove('d-none');
                document.getElementById('cancelDeleteBtn').classList.add('d-none');
                document.getElementById('saveChangesBtn').classList.remove('d-none');

                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

                // Add event listener for the new button
                confirmDeleteBtn.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent any default action
                    
                    const input = document.getElementById('deleteConfirmInput');
                    const error = document.getElementById('deleteConfirmError');
                    
                    if (input.value.trim() === currentLessonName.trim()) {
                        submitDeleteForm();
                    } else {
                        error.classList.remove('d-none');
                    }
                });
            });

            // Handle delete click
            document.getElementById('deleteLessonBtn').addEventListener('click', function () {
                // Remove required attribute before hiding
                document.getElementById('editLessonName').removeAttribute('required');

                // Hide form fields
                document.getElementById('formFieldsWrapper').classList.add('d-none');
                
                // Hide save changes button
                document.getElementById('saveChangesBtn').classList.add('d-none');

                // Show delete confirm
                document.getElementById('deleteConfirmWrapper').classList.remove('d-none');

                // Toggle buttons
                this.classList.add('d-none');
                document.getElementById('confirmDeleteBtn').classList.remove('d-none');
                document.getElementById('cancelDeleteBtn').classList.remove('d-none');
            });

            // Handle delete confirmation (enter key)
            document.getElementById('deleteConfirmInput').addEventListener('keyup', function (e) {
                const input = this;
                const error = document.getElementById('deleteConfirmError');

                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault(); // Prevent form submission/page refresh
                    
                    if (input.value.trim() === currentLessonName.trim()) {
                        submitDeleteForm();
                    } else {
                        error.classList.remove('d-none');
                    }
                }
            });

            // Cancel delete mode
            document.getElementById('cancelDeleteBtn').addEventListener('click', function () {
                // Show form fields
                document.getElementById('formFieldsWrapper').classList.remove('d-none');
                
                // Show save changes button
                document.getElementById('saveChangesBtn').classList.remove('d-none');

                // Re-add required attribute
                document.getElementById('editLessonName').setAttribute('required', 'required');

                // Hide confirm input
                document.getElementById('deleteConfirmWrapper').classList.add('d-none');
                document.getElementById('confirmDeleteBtn').classList.add('d-none');
                document.getElementById('deleteConfirmError').classList.add('d-none');

                // Toggle buttons
                this.classList.add('d-none');
                document.getElementById('deleteLessonBtn').classList.remove('d-none');
            });

            // Function to submit delete form with the separate route
            function submitDeleteForm() {
                const lessonId = document.getElementById('updateLessonForm').dataset.lessonId;
                
                // Create a new form for deletion
                const deleteForm = document.createElement('form');
                deleteForm.method = 'POST';
                deleteForm.action = `/course/course_detail/delete_lesson/${lessonId}`;
                deleteForm.style.display = 'none';
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                document.querySelector('input[name="_token"]')?.value;
                
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    deleteForm.appendChild(csrfInput);
                }
                
                // Append form to body, submit it, then remove it
                document.body.appendChild(deleteForm);
                deleteForm.submit();
                document.body.removeChild(deleteForm);
            }

            // Resource detail modal
            const resourceModal = document.getElementById('resourceDetailModal');
            let commentFormSubmitHandler = null; // Store the reference to the event handler
            
            resourceModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                console.log('relatedTarget:', button); // Check if null or undefined

                // Extract all data attributes
                const resourceData = {
                    lessonId: button.getAttribute('data-lesson-id'),
                    id: button.getAttribute('data-resource-id'),
                    idEncrypted: button.getAttribute('data-resource-id-encrypted'),
                    name: button.getAttribute('data-resource-name'),
                    description: button.getAttribute('data-resource-description'),
                    category: button.getAttribute('data-resource-category'),
                    type: button.getAttribute('data-resource-type'),
                    fileName: button.getAttribute('data-resource-file-name'),
                    path: button.getAttribute('data-resource-path'),
                    // views: button.getAttribute('data-resource-views'),
                    // downloads: button.getAttribute('data-resource-downloads'),
                    comments: button.getAttribute('data-resource-comments'),
                    forums: button.getAttribute('data-resource-forums'),
                    created: button.getAttribute('data-resource-created'),
                    isChecked: button.getAttribute('data-resource-ischecked') === '1',
                    totalCompleted: parseInt(button.getAttribute('data-resource-total-completed') || '0'),
                    totalStudents: parseInt(button.getAttribute('data-resource-total-students') || '0'),
                };
                
                // Update modal header
                resourceModal.querySelector('.modal-title').textContent = resourceData.name;
                
                // Update stats
                // document.getElementById('viewsCount').textContent = resourceData.views;
                // document.getElementById('downloadsCount').textContent = resourceData.downloads;
                document.getElementById('completedCount').textContent = resourceData.totalCompleted;
                document.getElementById('studentsCount').textContent = resourceData.totalStudents;
                // document.getElementById('commentsCount').textContent = resourceData.comments;
                document.getElementById('forumsCount').textContent = resourceData.forums;
                
                // Update resource info
                document.getElementById('resourceName').textContent = resourceData.name;
                document.getElementById('resourceDescription').textContent = resourceData.description || 'No description available';
                document.getElementById('resourceCreated').textContent = `Uploaded on ${resourceData.created}`;
                document.getElementById('resourceType').textContent = resourceData.type || 'N/A';
                document.getElementById('resourceCategory').textContent = resourceData.category == '1' ? 'Note' : (resourceData.category == '2' ? 'Assignment' : 'N/A');
                
                // Set download link
                const downloadBtn = document.getElementById('downloadBtn');
                downloadBtn.href = resourceData.path;
                downloadBtn.download = resourceData.name + '.' + resourceData.type;
                downloadBtn.innerHTML = `<i class="ti ti-download me-1"></i> Download`;

                // Set forum button
                const forumBtn = document.getElementById('resourceDetailModalForumBtn');
                forumBtn.setAttribute('data-resource-id-encrypted', resourceData.idEncrypted);

                // Determine color scheme based on category
                const colorScheme = resourceData.category == '1' ? 'info' : (resourceData.category == '2' ? 'success' : 'secondary');

                // document.getElementById('resourceCategory').classList.add(`text-${colorScheme}`);

                // Update modal header color
                // const modalHeader = resourceModal.querySelector('.modal-header');
                // modalHeader.className = `modal-header bg-${colorScheme}`;
                // const resourceStatsHeader = resourceModal.querySelector('.card-header');
                // resourceStatsHeader.className = `card-header bg-${colorScheme}`;
                const resourceCategoryBadge = document.getElementById('resourceCategory');
                resourceCategoryBadge.className = `mb-0 fw-semibold text-${colorScheme}`; // Add text-white class to the badge(`text-${colorScheme}`);

                // Set edit button
                const editBtn = document.querySelector('#resourceDetailModal button[data-bs-target="#resourceEditModal"]');

                if (editBtn) {
                    editBtn.setAttribute('data-resource-id', resourceData.id);
                    editBtn.setAttribute('data-resource-name', resourceData.name);
                    editBtn.setAttribute('data-resource-description', resourceData.description);
                    editBtn.setAttribute('data-resource-category', resourceData.category);
                    editBtn.setAttribute('data-resource-type', resourceData.type);
                    editBtn.setAttribute('data-resource-file-name', resourceData.fileName);
                    editBtn.setAttribute('data-resource-path', resourceData.path);
                    editBtn.setAttribute('data-resource-views', resourceData.views);
                    editBtn.setAttribute('data-resource-downloads', resourceData.downloads);
                    editBtn.setAttribute('data-resource-comments', resourceData.comments);
                    editBtn.setAttribute('data-resource-created', resourceData.created);
                }
                
                // Set complete button state
                const completeBtn = document.getElementById('resourceDetailModalCompleteBtn');

                if(completeBtn){
                    completeBtn.textContent = resourceData.isChecked ? 'Mark as Incomplete' : 'Mark as Complete';

                    completeBtn.setAttribute('data-lesson', resourceData.lessonId);
                    completeBtn.setAttribute('data-resource', resourceData.id);
                    completeBtn.setAttribute('data-course', '{{ $course->id }}');
                    completeBtn.setAttribute('data-category', resourceData.category);

                    completeBtn.classList.toggle('btn-light-success', !resourceData.isChecked);
                    completeBtn.classList.toggle('btn-success', resourceData.isChecked);

                    // Update button label & icon based on isChecked
                    // if (resourceData.isChecked) {
                    //     completeBtn.innerHTML = `Mark as Incomplete <i class="ti ti-circle-check-filled"></i>`;
                    // } else {
                    //     completeBtn.innerHTML = `Mark as Complete <i class="ti ti-circle"></i>`;
                    // }

                    // Attach lesson & resource IDs to the button for later toggle
                    // completeBtn.setAttribute('data-lesson-id', resourceData.lessonId);
                    // completeBtn.setAttribute('data-resource-id', resourceData.id);

                    completeBtn.addEventListener('click', function() {
                        const lessonId = this.getAttribute('data-lesson');
                        const resourceId = this.getAttribute('data-resource');
                        const courseId = this.getAttribute('data-course');
                        const category = this.getAttribute('data-category');
                        
                        let isChecked = this.textContent.includes('Incomplete');
                        let newStatus = isChecked ? 0 : 1;

                        fetch("{{ route('resource.toggle_progression') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                resource_id: resourceId,
                                course_id: courseId,
                                status: newStatus
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // Update icon color instantly
                                if (newStatus === 1) {
                                    this.textContent = 'Mark as Incomplete';
                                    this.classList.remove('btn-light-success');
                                    this.classList.add('btn-success');
                                } else {
                                    this.textContent = 'Mark as Complete';
                                    this.classList.remove('btn-success');
                                    this.classList.add('btn-light-success');
                                }

                                // Update the toggle icon in the lesson too
                                const toggleIcon = document.querySelector(`.toggle-progression[data-resource="${resourceId}"][data-lesson="${lessonId}"]`);
                                if (toggleIcon) {
                                    if (newStatus === 1) {
                                        toggleIcon.classList.add('ti-circle-check-filled');
                                        toggleIcon.classList.remove('ti-circle');
                                    } else {
                                        toggleIcon.classList.add('ti-circle');
                                        toggleIcon.classList.remove('ti-circle-check-filled');
                                    }
                                }

                                const modalBtn = document.getElementById('resourceDetailModalCompleteBtn');
                                if (modalBtn && modalBtn.dataset.resource === String(resourceId) && modalBtn.dataset.lesson === String(lessonId)) 
                                {
                                    if (newStatus === 1) {
                                        modalBtn.textContent = 'Mark as Incomplete';
                                        modalBtn.classList.remove('btn-light-success');
                                        modalBtn.classList.add('btn-success');
                                    } else {
                                        modalBtn.textContent = 'Mark as Complete';
                                        modalBtn.classList.remove('btn-success');
                                        modalBtn.classList.add('btn-light-success');
                                    }
                                }

                                // after fetch success inside your toggle handler
                                const triggerBtn = document.querySelector(`[data-resource-id="${resourceId}"]`);
                                if (triggerBtn) {
                                    triggerBtn.setAttribute('data-resource-ischecked', newStatus);
                                }

                                // const lessonContainer = this.closest('.lesson-container');
                                const lessonContainer = document.querySelector(`.lesson-container[data-lesson="${lessonId}"]`);
                                const lessonBadge = lessonContainer?.querySelector('.lesson-progress');
                                const lessonBadgeIcon = lessonContainer?.querySelector('.lesson-progress-icon');
                                // const lessonBar = lessonContainer?.querySelector('.lesson-progress-bar .progress-bar');

                                if (lessonBadge) {
                                    let [checked, total] = lessonBadge.textContent.trim()
                                        .replace('Completed', '') // strip trailing text
                                        .split('/')
                                        .map(x => parseInt(x));

                                    if (newStatus === 1) {
                                        checked++;
                                    } else {
                                        checked--;
                                    }

                                    // Clamp between 0 and total
                                    checked = Math.max(0, Math.min(checked, total));

                                    // Update badge
                                    lessonBadge.textContent = `${checked} / ${total} Completed`;

                                    if (lessonBadgeIcon) {
                                        if (checked === total && total > 0) {
                                            lessonBadgeIcon.classList.remove('ti-folder-filled');
                                            lessonBadgeIcon.classList.add('ti-circle-check-filled');
                                        } else {
                                            lessonBadgeIcon.classList.remove('ti-circle-check-filled');
                                            lessonBadgeIcon.classList.add('ti-folder-filled');
                                        }
                                    }

                                    // Update progress bar
                                    let percentage = total > 0 ? Math.round((checked / total) * 100) : 0;
                                    // lessonBar.style.width = percentage + '%';
                                    // lessonBar.textContent = percentage + '%';
                                    // lessonBar.parentElement.setAttribute('aria-valuenow', percentage);

                                    // --- Update lesson tab icon dynamically (now inside the same scope)
                                    const lessonIcon = document.querySelector(
                                        `.lesson-status-icon[data-lesson="${lessonId}"]`
                                    );
                                    if (lessonIcon) {
                                        if (checked === total && total > 0) {
                                            lessonIcon.classList.remove('ti-folder-filled');
                                            lessonIcon.classList.add('ti-circle-check-filled');
                                        } else {
                                            lessonIcon.classList.remove('ti-circle-check-filled');
                                            lessonIcon.classList.add('ti-folder-filled');
                                        }
                                    }

                                    // update course chart
                                    if (window.courseProgressChart) {
                                        window.courseProgressChart.updateSeries([data.course.percentage]);
                                    }
                                } 

                                // ✅ Update lesson summary
                                let lessonStatus = document.getElementById("lesson-status");
                                lessonStatus.textContent = (data.overview.completedLessons === data.overview.totalLessons) ? "Completed" : "Uncompleted";
                                lessonStatus.className = `text-${data.overview.completedLessons === data.overview.totalLessons ? 'success' : 'secondary'} mb-0`;

                                document.getElementById("lesson-count").textContent =
                                    `${data.overview.completedLessons} / ${data.overview.totalLessons}`;

                                // ✅ Update resource summary
                                let resourceStatus = document.getElementById("resource-status");
                                resourceStatus.textContent = (data.overview.completedResources === data.overview.totalResources) ? "Completed" : "Uncompleted";
                                resourceStatus.className = `text-${data.overview.completedResources === data.overview.totalResources ? 'success' : 'secondary'} mb-0`;

                                document.getElementById("resource-count").textContent =
                                    `${data.overview.completedResources} / ${data.overview.totalResources}`;
                            }
                        });
                    })
                }

                // Handle preview based on type
                const previewContainer = document.getElementById('resourcePreview');
                previewContainer.innerHTML = '';
                
                if (resourceData.type === 'link') {
                    if (resourceData.path.includes('youtube.com') || resourceData.path.includes('youtu.be')) {
                        // YouTube embed
                        const videoId = resourceData.path.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/)[1];
                        previewContainer.innerHTML = `
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/${videoId}" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen></iframe>
                            </div>
                        `;

                        downloadBtn.innerHTML = '<i class="ti ti-link me-1"></i> Open On YouTube';
                    } else {
                        // Regular website link
                        previewContainer.innerHTML = `
                            <div class="web-preview h-100 d-flex flex-column align-items-center justify-content-center p-3 rounded" 
                                style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                <i class="ph-bold ph-globe text-primary mb-2" style="font-size: 3rem;"></i>
                                <h5 class="mb-2">External Link</h5>
                                <div style="width: 100%; max-width: 250px;">
                                    <a href="${resourceData.path}" 
                                    target="_blank" 
                                    class="text-truncate d-block small"
                                    style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; color: #0d6efd; text-decoration: none;">
                                    ${resourceData.path}
                                    </a>
                                </div>
                                <small class="text-muted mt-2">Click to open in new tab</small>
                            </div>
                        `;

                        downloadBtn.innerHTML = '<i class="ti ti-link me-1"></i> Open Link';
                    }
                } else if (['jpg', 'jpeg', 'png', 'gif', 'svg'].includes(resourceData.type.toLowerCase())) {
                    // Image preview
                    previewContainer.innerHTML = `
                        <div class="text-center">
                            <img src="${resourceData.path}" 
                                class="img-fluid rounded" 
                                style="max-height: 250px;"
                                alt="${resourceData.name}">
                        </div>
                    `;
                } else if (resourceData.type.toLowerCase() === 'pdf') {
                    // PDF preview
                    previewContainer.innerHTML = `
                        <div class="ratio ratio-16x9">
                            <iframe src="${resourceData.path}#view=fitH" 
                                    class="w-100 h-100"></iframe>
                        </div>
                    `;
                } else if (['mp4', 'mov', 'avi', 'mkv', 'webm', 'wmv'].includes(resourceData.type.toLowerCase())) {
                    // ---- VIDEO PREVIEW ----
                    previewContainer.innerHTML = `
                        <div class="ratio ratio-16x9">
                            <video controls preload="metadata" class="w-100 rounded shadow-sm">
                                <source src="${resourceData.path}" type="video/${resourceData.type.toLowerCase()}">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    `;
                    downloadBtn.innerHTML = '<i class="ti ti-player-play me-1"></i> Watch Video';

                } else if (['mp3', 'wav', 'm4a', 'aac', 'flac'].includes(resourceData.type.toLowerCase())) {
                    // ---- AUDIO PREVIEW ----
                    previewContainer.innerHTML = `
                        <div class="text-center py-4">
                            <audio controls preload="metadata" class="w-100 rounded shadow-sm" style="max-width: 400px;">
                                <source src="${resourceData.path}" type="audio/${resourceData.type.toLowerCase()}">
                                Your browser does not support the audio element.
                            </audio>
                            <p class="mt-2 mb-0 fw-semibold">${resourceData.name}</p>
                            <small class="text-muted">${resourceData.type.toUpperCase()} Audio</small>
                        </div>
                    `;
                    downloadBtn.innerHTML = '<i class="ti ti-music me-1"></i> Play Audio';
                } else {
                    // Default file preview
                    previewContainer.innerHTML = `
                        <div class="text-center py-4">
                            <i class="ph-bold ph-file text-primary" style="font-size: 3rem;"></i>
                            <h5 class="mt-2">${resourceData.name}</h5>
                            <p class="text-muted">${resourceData.type.toUpperCase()} File</p>
                        </div>
                    `;
                }

                // Set resource ID for comment form
                // document.getElementById('commentResourceId').value = resourceData.id;
                
                // // Clear existing comments immediately
                // const commentsList = document.getElementById('commentsList');
                // commentsList.innerHTML = '';
                
                // // Show a loading spinner
                // commentsList.innerHTML = `
                //     <div class="text-center py-4">
                //         <div class="spinner-border text-primary" role="status">
                //             <span class="visually-hidden">Loading...</span>
                //         </div>
                //         <p class="mt-2 text-muted">Loading comments...</p>
                //     </div>
                // `;

                // // Load comments for this specific resource
                // loadComments(resourceData.id);
                
                // // Remove any existing event listener on comment form before adding a new one
                // const commentForm = document.getElementById('commentForm');
                // if (commentFormSubmitHandler) {
                //     commentForm.removeEventListener('submit', commentFormSubmitHandler);
                // }
                
                // Create new event handler for this specific resource
                commentFormSubmitHandler = function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const currentResourceId = formData.get('resource_id');
                    
                    // Show loading indicator on the button
                    const submitBtn = commentForm.querySelector('button[type="submit"]');
                    const originalBtnText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Posting...';
                    
                    fetch('/course/comment/store_comment', {
                        method: 'POST',
                        credentials: 'include', // Crucial for cookies
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            // 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') // If using Sanctum
                        },
                        body: JSON.stringify({
                            resource_id: currentResourceId,
                            content: formData.get('content')
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data && data.success) {
                            // Clear input field
                            const commentInput = document.querySelector('#commentForm input[name="content"]');
                            const commentContent = commentInput.value;
                            commentInput.value = '';
                            
                            // Update counts
                            const commentsCount = document.getElementById('commentsCount');
                            const currentCount = parseInt(commentsCount.textContent) || 0;
                            const newCount = currentCount + 1;
                            commentsCount.textContent = newCount;
                            
                            // Remove "no comments" message if it exists
                            const noComments = document.getElementById('noComments');
                            if (noComments) {
                                noComments.remove();
                            }
                            
                            // Add the new comment to the list
                            const commentsList = document.getElementById('commentsList');
                            
                            // Get current user info from the form area
                            const userImg = commentForm.querySelector('img').src;
                            
                            // Use the correct property names from the backend response
                            const commentText = data.comment ? data.comment.content : commentContent;
                            const commentId = data.comment ? data.comment.id : new Date().getTime();
                            const userName = data.comment ? data.comment.user_name : "Current User";
                            const userImage = data.comment ? data.comment.user_image : userImg;
                            const createdAt = data.comment ? data.comment.created_at : 'Just now';
                            
                            const newCommentHtml = `
                                <div class="d-flex mb-3" id="comment-${commentId}">
                                    <img src="${userImage}" 
                                        class="rounded-circle me-3" width="40" height="40" alt="User">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1">${userName}</h6>
                                            <small class="text-muted mr-2"> ${createdAt}</small>
                                        </div>
                                        <p class="mb-1">${commentText}</p>
                                        
                                    </div>
                                </div>
                            `;
                            
                            // Prepend to show newest comments at the top
                            commentsList.insertAdjacentHTML('afterbegin', newCommentHtml);
                            
                            // Add highlight animation to new comment
                            setTimeout(() => {
                                const newComment = document.getElementById(`comment-${commentId}`);
                                if (newComment) {
                                    newComment.style.transition = 'background-color 1s ease';
                                    newComment.style.backgroundColor = '#f0f8ff';
                                    setTimeout(() => {
                                        newComment.style.backgroundColor = 'transparent';
                                    }, 1500);
                                }
                            }, 100);
                        } else {
                            // Show error if the server returned success: false
                            alert('Failed to post comment. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to post comment. Please try again.');
                    })
                    .finally(() => {
                        // Restore button state
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    });
                };
                
                // Add the new event listener
                commentForm.addEventListener('submit', commentFormSubmitHandler);
            });

            document.getElementById('resourceDetailModalForumBtn').addEventListener('click', function() {
                const encryptedId = this.getAttribute('data-resource-id-encrypted');
                if (encryptedId) {
                    window.location.href = "{{ route('resource.forum', ':id') }}".replace(':id', encryptedId);
                }
            });

            
            // Handle modal close - optional cleanup
            resourceModal.addEventListener('hidden.bs.modal', function() {
                // Clear comments when modal is closed to avoid confusion
                document.getElementById('commentsList').innerHTML = '';
            });
            
            // Function to load comments for a specific resource
            function loadComments(resourceId) {
                fetch(`/course/comment/resource/${resourceId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('commentsCount').textContent = data.comments.length;

                        const commentsList = document.getElementById('commentsList');
                        commentsList.innerHTML = ''; // Clear loading spinner

                        if (data.comments && data.comments.length > 0) {
                            // Sort comments by most recent first (if needed)
                            data.comments.sort((a, b) => {
                                // Assuming created_at is a string that can be compared
                                return new Date(b.created_at_raw || b.created_at) - new Date(a.created_at_raw || a.created_at);
                            });
                            
                            data.comments.forEach(comment => {
                                const commentHtml = `
                                    <div class="d-flex mb-3" id="comment-${comment.id}">
                                        <img src="${comment.user_image}" 
                                            class="rounded-circle me-3" width="40" height="40" alt="User">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1">${comment.user_name}</h6>
                                                <small class="text-muted mr-2"> ${comment.created_at}</small>
                                            </div>
                                            <p class="mb-1">${comment.content}</p>
                                            
                                        </div>
                                    </div>
                                `;
                                commentsList.insertAdjacentHTML('beforeend', commentHtml);
                            });
                        } else {
                            // Show "No comments" message if empty
                            commentsList.innerHTML = `
                                <div class="text-center py-3" id="noComments">
                                    <i class="ti ti-message-off fs-5 text-muted"></i>
                                    <p class="text-muted mt-2">No comments yet</p>
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading comments:', error);
                        const commentsList = document.getElementById('commentsList');
                        commentsList.innerHTML = `
                            <div class="text-center py-3 text-danger">
                                <i class="ti ti-alert-circle fs-5"></i>
                                <p class="mt-2">Failed to load comments</p>
                            </div>
                        `;
                    });
            }

            // Handle resource edit modal
            const resourceEditModal = document.getElementById('resourceEditModal');
            if (!resourceEditModal) return;

            // Initialize modal when shown
            resourceEditModal.addEventListener('shown.bs.modal', function(event) {
                const button = event.relatedTarget;
                if (!button) return;
                
                // Extract all data attributes
                const resourceData = {
                    id: button.getAttribute('data-resource-id'),
                    name: button.getAttribute('data-resource-name'),
                    description: button.getAttribute('data-resource-description'),
                    category: button.getAttribute('data-resource-category'),
                    type: button.getAttribute('data-resource-type'),
                    fileId: button.getAttribute('data-resource-file-id'),
                    fileName: button.getAttribute('data-resource-file-name'),
                    path: button.getAttribute('data-resource-path'),
                    link: button.getAttribute('data-resource-link'),
                    views: button.getAttribute('data-resource-views'),
                    downloads: button.getAttribute('data-resource-downloads')
                };
                
                // Update modal header
                resourceEditModal.querySelector('.modal-title').textContent = "Edit Resource: " + resourceData.name;
                
                // Fill hidden fields
                document.getElementById('edit_resource_id').value = resourceData.id || '';
                document.getElementById('edit_file_id').value = resourceData.fileId || '';
                document.getElementById('delete_flag').value = '0'; // Reset delete flag
                
                // Fill basic inputs
                document.getElementById('editResourceName').value = resourceData.name || '';
                document.getElementById('editResourceDescription').value = resourceData.description || '';
                document.getElementById('editResourceCategory').value = resourceData.category || '';
                
                // Reset UI for delete
                document.getElementById('deleteResourceBtn').classList.remove('d-none');
                document.getElementById('confirmDeleteResourceBtn').classList.add('d-none');
                document.getElementById('cancelDeleteResourceBtn').classList.add('d-none');
                document.getElementById('saveResourceChangesBtn').classList.remove('d-none');
                
                // Determine and set resource type
                // if (resourceData.type === 'link') {
                //     // Select link radio
                //     document.getElementById('resourceType_link').checked = true;
                    
                //     // Show/hide appropriate sections
                //     document.getElementById('resource_file_upload_section').style.display = 'none';
                //     document.getElementById('resource_link_section').style.display = 'block';
                    
                //     // Set link value
                //     document.getElementById('editResourceLink').value = resourceData.link || resourceData.path || '';
                // } else {
                //     // Default to file type
                //     document.getElementById('resourceType_file').checked = true;
                    
                //     // Show/hide appropriate sections
                //     document.getElementById('resource_file_upload_section').style.display = 'block';
                //     document.getElementById('resource_link_section').style.display = 'none';
                    
                //     // Show file name as information
                //     document.getElementById('existing_file_info').value = resourceData.fileName || 'No file uploaded';
                // }
                
                // Set form action URL
                const updateResourceForm = document.getElementById('updateResourceForm');
                updateResourceForm.action = `/course/resource/update_resource/${resourceData.id}`;
            });
            
            // Handle resource type radio change
            // document.querySelectorAll('input[name="resource_type"]').forEach(radio => {
            //     radio.addEventListener('change', function() {
            //         if (this.value === 'file') {
            //             document.getElementById('resource_file_upload_section').style.display = 'block';
            //             document.getElementById('resource_link_section').style.display = 'none';
            //         } else if (this.value === 'link') {
            //             document.getElementById('resource_file_upload_section').style.display = 'none';
            //             document.getElementById('resource_link_section').style.display = 'block';
            //         }
            //     });
            // });
            
            // Handle delete button click
            const deleteResourceBtn = document.getElementById('deleteResourceBtn');
            const confirmDeleteResourceBtn = document.getElementById('confirmDeleteResourceBtn');
            const cancelDeleteResourceBtn = document.getElementById('cancelDeleteResourceBtn');
            const saveResourceChangesBtn = document.getElementById('saveResourceChangesBtn');
            
            deleteResourceBtn.addEventListener('click', function() {
                // Show confirmation and hide regular buttons
                this.classList.add('d-none');
                confirmDeleteResourceBtn.classList.remove('d-none');
                cancelDeleteResourceBtn.classList.remove('d-none');
                saveResourceChangesBtn.classList.add('d-none');
            });
            
            // Handle cancel delete
            cancelDeleteResourceBtn.addEventListener('click', function() {
                // Restore regular buttons
                deleteResourceBtn.classList.remove('d-none');
                confirmDeleteResourceBtn.classList.add('d-none');
                cancelDeleteResourceBtn.classList.add('d-none');
                saveResourceChangesBtn.classList.remove('d-none');
            });
            
            // Handle confirm delete
            confirmDeleteResourceBtn.addEventListener('click', function() {
                // Set delete flag and submit form
                document.getElementById('delete_flag').value = '1';
                document.getElementById('updateResourceForm').submit();
            });

            

            const list = document.getElementById('lesson-list');
            const actions = document.getElementById('reorder-actions');
            let sortable = null;

            function attachInitialListener() {
                const btn = document.getElementById('reorder-btn');
                if (btn) btn.addEventListener('click', enterReorder);
            }

            function enterReorder() {
                // show UI
                list.classList.add('reorder-active');
                actions.innerHTML = `
                    <button id="save-order-btn" class="btn btn-success b-r-22 me-2" type="button">
                        <i class="ti ti-check"></i>
                    </button>
                    <button id="cancel-order-btn" class="btn btn-danger b-r-22" type="button">
                        <i class="ti ti-x"></i>
                    </button>
                `;

                // init Sortable once
                if (!sortable) {
                sortable = new Sortable(list, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    onStart: function () { /* optional: do something */ },
                });
                }

                // attach listeners to newly created buttons
                document.getElementById('save-order-btn').addEventListener('click', saveOrder);
                document.getElementById('cancel-order-btn').addEventListener('click', exitReorder);
            }

            function exitReorder() {
                // hide UI
                list.classList.remove('reorder-active');

                // destroy sortable to clean up
                if (sortable) {
                    try { sortable.destroy(); } catch (e) { console.warn('sortable destroy error', e); }
                    sortable = null;
                }

                // restore actions HTML and reattach listener
                actions.innerHTML = `
                    <button id="reorder-btn" class="btn btn-light-primary b-r-22" type="button">
                        <i class="ti ti-edit"></i> Reorder
                    </button>
                    `;
                attachInitialListener();
            }

            function saveOrder() {
                const ids = Array.from(list.querySelectorAll("li[data-id]")).map((li, index) => ({
                    id: li.dataset.id,
                    order_index: index + 1
                }));

                console.log("Sending new order:", ids);

                fetch("{{ route('course.lesson.reorder_lesson') }}", {
                    method: "POST",
                    headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ lessons: ids })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        console.log("Order updated successfully!");
                    } else {
                        console.error("Update failed:", data);
                    }
                    exitReorder();
                })
                .catch(err => {
                    console.error("Error:", err);
                    exitReorder();
                });
            }

            // start: attach listener to existing reorder button
            attachInitialListener();

            // Debug helpers (optional):
            // console.log('lesson-list exists?', !!list, 'reorder-actions exists?', !!actions);

            document.querySelectorAll('.toggle-progression').forEach(icon => {
                icon.addEventListener('click', function () {
                    let resourceId = this.dataset.resource;
                    let courseId   = this.dataset.course;
                    let lessonId   = this.dataset.lesson;
                    let isChecked = this.classList.contains('ti-circle-check-filled') ? 1 : 0;
                    let newStatus = isChecked ? 0 : 1;

                    fetch("{{ route('resource.toggle_progression') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            resource_id: resourceId,
                            course_id: courseId,
                            status: newStatus
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Update icon color instantly
                            if (newStatus === 1) {
                                this.classList.add('ti-circle-check-filled');
                                this.classList.remove('ti-circle');
                                // this.classList.remove('text-muted');
                                // this.classList.add(`text-${this.dataset.category == 1 ? 'info' : 'success'}`);
                            } else {
                                this.classList.add('ti-circle');
                                this.classList.remove('ti-circle-check-filled');
                                // this.classList.remove('text-info', 'text-success');
                                // this.classList.add('text-muted');
                            }

                            const modalBtn = document.getElementById('resourceDetailModalCompleteBtn');
                            if (modalBtn && modalBtn.dataset.resource === String(resourceId) && modalBtn.dataset.lesson === String(lessonId)) 
                            {
                                if (newStatus === 1) {
                                    modalBtn.textContent = 'Mark as Incomplete';
                                    modalBtn.classList.remove('btn-light-success');
                                    modalBtn.classList.add('btn-success');
                                } else {
                                    modalBtn.textContent = 'Mark as Complete';
                                    modalBtn.classList.remove('btn-success');
                                    modalBtn.classList.add('btn-light-success');
                                }
                            }

                            // after fetch success inside your toggle handler
                            const triggerBtn = document.querySelector(`[data-resource-id="${resourceId}"]`);
                            if (triggerBtn) {
                                triggerBtn.setAttribute('data-resource-ischecked', newStatus);
                            }

                            // const lessonContainer = this.closest('.lesson-container');
                            const lessonContainer = document.querySelector(`.lesson-container[data-lesson="${lessonId}"]`);
                            const lessonBadge = lessonContainer?.querySelector('.lesson-progress');
                            const lessonBadgeIcon = lessonContainer?.querySelector('.lesson-progress-icon');
                            // const lessonBar = lessonContainer?.querySelector('.lesson-progress-bar .progress-bar');

                            if (lessonBadge) {
                                let [checked, total] = lessonBadge.textContent.trim()
                                    .replace('Completed', '') // strip trailing text
                                    .split('/')
                                    .map(x => parseInt(x));

                                if (newStatus === 1) {
                                    checked++;
                                } else {
                                    checked--;
                                }

                                // Clamp between 0 and total
                                checked = Math.max(0, Math.min(checked, total));

                                // Update badge
                                lessonBadge.textContent = `${checked} / ${total} Completed`;

                                // Update badge
                                lessonBadge.textContent = `${checked} / ${total} Completed`;

                                if (lessonBadgeIcon) {
                                    if (checked === total && total > 0) {
                                        lessonBadgeIcon.classList.remove('ti-folder-filled');
                                        lessonBadgeIcon.classList.add('ti-circle-check-filled');
                                    } else {
                                        lessonBadgeIcon.classList.remove('ti-circle-check-filled');
                                        lessonBadgeIcon.classList.add('ti-folder-filled');
                                    }
                                }

                                // Update progress bar
                                let percentage = total > 0 ? Math.round((checked / total) * 100) : 0;
                                // lessonBar.style.width = percentage + '%';
                                // lessonBar.textContent = percentage + '%';
                                // lessonBar.parentElement.setAttribute('aria-valuenow', percentage);

                                // --- Update lesson tab icon dynamically (now inside the same scope)
                                const lessonIcon = document.querySelector(
                                    `.lesson-status-icon[data-lesson="${lessonId}"]`
                                );
                                if (lessonIcon) {
                                    if (checked === total && total > 0) {
                                        lessonIcon.classList.remove('ti-folder-filled');
                                        lessonIcon.classList.add('ti-circle-check-filled');
                                    } else {
                                        lessonIcon.classList.remove('ti-circle-check-filled');
                                        lessonIcon.classList.add('ti-folder-filled');
                                    }
                                }

                                // update course chart
                                if (window.courseProgressChart) {
                                    window.courseProgressChart.updateSeries([data.course.percentage]);
                                }
                            }

                            // ✅ Update lesson summary
                            let lessonStatus = document.getElementById("lesson-status");
                            lessonStatus.textContent = (data.overview.completedLessons === data.overview.totalLessons) ? "Completed" : "Uncompleted";
                            lessonStatus.className = `text-${data.overview.completedLessons === data.overview.totalLessons ? 'success' : 'secondary'} mb-0`;

                            document.getElementById("lesson-count").textContent =
                                `${data.overview.completedLessons} / ${data.overview.totalLessons}`;

                            // ✅ Update resource summary
                            let resourceStatus = document.getElementById("resource-status");
                            resourceStatus.textContent = (data.overview.completedResources === data.overview.totalResources) ? "Completed" : "Uncompleted";
                            resourceStatus.className = `text-${data.overview.completedResources === data.overview.totalResources ? 'success' : 'secondary'} mb-0`;

                            document.getElementById("resource-count").textContent =
                                `${data.overview.completedResources} / ${data.overview.totalResources}`;
                        }
                    });
                });
            });

            // let progress = document.querySelector("#course-progress-chart").dataset.progress;
            let progress = parseFloat(document.querySelector("#course-progress-chart").dataset.progress) || 0;

            var options = {
                series: [progress],
                chart: {
                    type: 'radialBar',
                    offsetY: -20,
                    sparkline: { enabled: true }
                },
                colors: ['rgba(var(--primary),1)'],
                plotOptions: {
                    radialBar: {
                        startAngle: -90,
                        endAngle: 90,
                        track: {
                            background: "#e7e7e7",
                            strokeWidth: '97%',
                            margin: 5,
                            dropShadow: {
                                enabled: true,
                                top: 2,
                                left: 0,
                                color: '#999',
                                opacity: 1,
                                blur: 2,
                            }
                        },
                        dataLabels: {
                            name: { show: false },
                            value: {
                                offsetY: -4,
                                fontSize: '22px'
                            }
                        }
                    }
                },
                grid: { padding: { top: -20 } },
                labels: ['Overall Progress'],
            };

            window.courseProgressChart = new ApexCharts(
                document.querySelector("#course-progress-chart"),
                options
            );
            window.courseProgressChart.render();
        });

    </script>    

    <!--customizer-->
    <div id="customizer"></div>

    <!-- apexcharts-->
    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>

    <!-- Tooltip js  -->
    <script src="{{asset('assets/js/tooltips_popovers.js')}}"></script>

    <!-- sweetalert js-->
    <script src="{{asset('assets/vendor/sweetalert/sweetalert.js')}}"></script>

    <!-- draggable js  -->
    <script src="{{asset('assets/vendor/sortable/Sortable.min.js')}}"></script>

    <!--js-->
    {{-- <script src="{{asset('assets/js/filemanager.js')}}"></script> --}}
    <script src="{{asset('assets/js/course/lesson/lesson_list.js')}}"></script>

@endsection
