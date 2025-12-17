@extends('layout.master')
@section('title', 'Dismissed Report')
@section('css')
    <!-- slick css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick-theme.css')}}">

    <!-- Data Table css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/datatable2/buttons.dataTables.min.css')}}">

    <style>
        .swal2-toast {
            width: auto !important;
            max-width: 100% !important;
            padding: 0.625em !important;
        }
    </style>
@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Dismissed Report</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                      <span>
                        <i class="ph-duotone  ph-stack f-s-16"></i> Reports
                      </span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="#" class="f-s-14 f-w-500">Ticket</a>
                    </li> --}}
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Dismissed</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <!-- Ticket start -->
        <div class="row ticket-app">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card ticket-card bg-light-primary">
                            <div class="card-body">
                                <i class="ph-bold  ph-circle circle-bg-img"></i>
                                <div class="h-50 w-50 d-flex-center b-r-15 bg-white mb-3">
                                    <i class="ph-bold  ph-flag f-s-25 text-primary"></i>
                                </div>
                                <p class="f-s-16">All Dismissed Report</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="text-primary-dark">{{ $dismissed_reports->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card ticket-card bg-light-info">
                            <div class="card-body">
                                <i class="ph-bold  ph-circle circle-bg-img"></i>
                                <div class="h-50 w-50 d-flex-center b-r-15 bg-white mb-3">
                                    <i class="ph-bold  ph-users f-s-25 text-info"></i>
                                </div>
                                <p class="f-s-16">User Report</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="text-info-dark">{{ $dismissed_reports->where('reported_type', 'user')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card ticket-card bg-light-success">
                            <div class="card-body">
                                <i class="ph-bold  ph-circle circle-bg-img"></i>
                                <div class="h-50 w-50 d-flex-center b-r-15 bg-white mb-3">
                                    <i class="ph-bold  ph-book f-s-25 text-success"></i>
                                </div>
                                <p class="f-s-16">Course, Lessons and Resources Report</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="text-success-dark">{{ $dismissed_reports->where('reported_type', 'course')->count() + $dismissed_reports->where('reported_type', 'lesson')->count() + $dismissed_reports->where('reported_type', 'resource')->count()}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card ticket-card bg-light-warning">
                            <div class="card-body">
                                <i class="ph-bold  ph-circle circle-bg-img"></i>
                                <div class="h-50 w-50 d-flex-center b-r-15 bg-white mb-3">
                                    <i class="ph-bold  ph-chat-circle f-s-25 text-warning"></i>
                                </div>
                                <p class="f-s-16">Forum (Posts, Replies) Report</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="text-warning-dark">{{ $dismissed_reports->where('reported_type', 'forum_post')->count() + $dismissed_reports->where('reported_type', 'forum_reply')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card create-ticket-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="fw-semibold mb-3">Guideline Content Status</h6>
                                <table class="table table-sm table-borderless">
                                    <tbody>
                                        <tr>
                                            {{-- <td class="ps-0" style="width: 150px;">
                                                <span class="badge bg-secondary">Not Eligible</span>
                                            </td> --}}
                                            <td class="ps-2">Report type <span class="badge text-outline-primary">user</span>, <span class="badge text-outline-primary">course</span>, <span class="badge text-outline-primary">lesson</span> and <span class="badge text-outline-primary">resource</span> need 5 or more reports to be <span class="badge bg-warning text-dark"><i class="ph-bold ph-clock me-1"></i> Pending</span>, or hidden.</td>
                                        </tr>
                                        <tr>
                                            {{-- <td class="ps-0">
                                                <span class="badge bg-light-success">Not Yet Claimed</span>
                                            </td> --}}
                                            <td class="ps-2">Meanwhile, report type <span class="badge text-outline-primary">forum_post</span> and <span class="badge text-outline-primary">forum_reply</span> only need 1 or more reports to be <span class="badge bg-warning text-dark"><i class="ph-bold ph-clock me-1"></i> Pending</span>, or hidden.</td>
                                        </tr>
                                        {{-- <tr>
                                            <td class="ps-2">This to help prevent spam and abuse based on the report type. Forum post and reply are likely to receive more reports.</td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-6 mb-3 mb-md-0">
                                <h5 class="fw-semibold mb-3">Content Status Definitions</h6>
                                <table class="table table-sm table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="ps-0" style="width: 120px;">
                                                <span class="badge bg-success"><i class="ph-bold ph-check-circle me-1"></i> Active</span>
                                            </td>
                                            <td class="ps-2">Content/User is active.</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-0">
                                                <span class="badge bg-warning text-dark"><i class="ph-bold ph-clock me-1"></i> Pending</span>
                                            </td>
                                            <td class="ps-2">Content/User is inactive, but has not been deleted. Waiting for admin review.</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-0">
                                                <span class="badge bg-danger"><i class="ph-bold ph-x-circle me-1"></i> Deleted/Banned</span>
                                            </td>
                                            <td class="ps-2">Content/User has been deleted or banned.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <h5 class="ms-3 mb-2">Top Type</h5>
                <ul class="ticket-slider ">
                    <li>
                        <div class="ticket-catagory p-3">
                            <h6 class="mb-0">User</h6>
                            <span class="badge text-light-success">{{ $pending_reports->where('reported_type', 'user')->count() }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="ticket-catagory p-3">
                            <h6 class="mb-0">laptop issues</h6>
                            <span class="badge text-light-success">64</span>
                        </div>
                    </li>
                    <li>
                        <div class="ticket-catagory p-3">
                            <h6 class="mb-0">Card issues</h6>
                            <span class="badge text-light-success">52</span>
                        </div>
                    </li>
                    <li>
                        <div class="ticket-catagory p-3">
                            <h6 class="mb-0">Admin issues</h6>
                            <span class="badge text-light-success">32</span>
                        </div>
                    </li>
                    <li>
                        <div class="ticket-catagory p-3">
                            <h6 class="mb-0">laptop issues</h6>
                            <span class="badge text-light-success">20</span>
                        </div>
                    </li>
                </ul> --}}
            </div>

            <!-- start create ticket modal  -->
            <div aria-hidden="true" aria-labelledby="ticketModalLabel" class="modal fade" id="ticketModal"
                 tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h1 class="modal-title fs-5 text-white" id="ticketModalLabel">Add Ticket</h1>
                            <button aria-label="Close" class="btn-close m-0" data-bs-dismiss="modal"
                                    type="button"></button>
                        </div>
                        <div class="modal-body">
                            <div class="ticket-form">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input class="form-control" id="titlename" placeholder="Title"
                                                   type="text">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Client</label>
                                            <input class="form-control" id="clientname" placeholder="client"
                                                   type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="priority">Priority</label>
                                            <select class="form-select" id="priority">
                                                <option selected="">Select Priority</option>
                                                <option value="Medium">Medium</option>
                                                <option value="Lower">Lower</option>
                                                <option value="High">High</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="status">Status</label>
                                            <select class="form-select" id="status">
                                                <option selected="">Select Status</option>
                                                <option value="open">open</option>
                                                <option value="inprogress">inprogress</option>
                                                <option value="closed">closed</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Date</label>
                                            <input class="form-control" id="datename" name="trip-start"
                                                   type="date">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Due Date</label>
                                            <input class="form-control" id="duename" type="date">
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close
                            </button>
                            <button class="btn btn-primary" id="ticketkey" type="button">Save changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end create ticket modal  -->

            <!-- ticket table-->
            <div class="col-sm-12">
                <div class="card">
                    {{-- <div class="card-header pb-0 card-no-border">
                        <h4>Pending Reports</h4>
                    </div> --}}
                    <div class="card-body">
                        <div class="table-responsive app-scroll app-datatable-default">
                            <table class="w-100 display" id="ticketdatatable">
                                <thead>
                                    <tr>
                                        {{-- <th class="sorting_disabled">
                                            <div class="checkbox-wrapper">
                                                <label class="check-box m-0">
                                                    <input id="select-all1" type="checkbox">
                                                    <span class="checkmark outline-secondary"></span>
                                                </label>
                                            </div>
                                        </th> --}}
                                        <th>ID</th>
                                        <th>Reporter</th>
                                        <th>Type</th>
                                        <th>Reported Content</th>
                                        <th>Reason</th>
                                        {{-- <th>Report Status</th> --}}
                                        <th>Created Date</th>
                                        <th>Updated Date</th>
                                        <th>Remark</th>
                                        <th class="sorting_disabled">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dismissed_reports as $report)
                                    <tr>
                                        {{-- <td>
                                            <div class="checkbox-wrapper">
                                                <label class="check-box m-0">
                                                    <input type="checkbox" name="ids[]" value="{{ $report->id }}">
                                                    <span class="checkmark outline-secondary"></span>
                                                </label>
                                            </div>
                                        </td> --}}
                                        <td>{{ $report->id }}</td>
                                        <td>
                                            <a href="{{ route('user.profile', ['user_id' => encrypt($report->user->id), 'shared' => 0]) }}" 
                                                    style="cursor: pointer; text-decoration: none; color: inherit;" 
                                                    class="d-flex align-items-center gap-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="h-35 w-35 d-flex-center b-r-22 overflow-hidden me-2">
                                                            <img src="{{ $report->user->image ? asset('storage/uploads/profile_picture/' . $report->user->image) : asset('assets/images/avtar/woman.jpg') }}" 
                                                                alt="Tutor Avatar" class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ "@" . $report->user->username ?? 'User Deleted' }}</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge text-outline-primary">{{ class_basename($report->reported_type) }}</span>
                                        </td>
                                        <td>
                                            @if(!$report->reported)
                                                <span class="badge bg-secondary text-white px-3 py-2">
                                                    <i class="ph-bold ph-x-circle me-1"></i> Content Deleted
                                                </span>
                                            @else
                                                <div>
                                                    {{-- Content Details based on Type --}}
                                                    @if($report->reported instanceof \App\Models\User)
                                                        <div class="mb-2">
                                                            <strong class="text-muted d-block mb-1">Username:</strong>
                                                            <a class="text-info fw-medium" 
                                                            href="{{ route('user.profile', ['user_id' => encrypt($report->reported->id), 'shared' => 0]) }}">
                                                                {{ '@' . $report->reported->username }}
                                                            </a>
                                                        </div>
                                                        <div>
                                                            <strong class="text-muted d-block mb-1">Email:</strong>
                                                            <span>{{ $report->reported->email }}</span>
                                                        </div>

                                                    @elseif($report->reported instanceof \App\Models\Course)
                                                        <div>
                                                            <div class="mb-2">
                                                                <strong class="text-muted d-block mb-1">Course Title:</strong>
                                                                <span>
                                                                    <a class="text-info fw-medium" 
                                                                        href="{{ route('course.course_detail', ['course_id' => encrypt($report->reported->id)]) }}">
                                                                            {{ $report->reported->name ?? 'Unknown' }}
                                                                    </a>
                                                                </span>
                                                            </div>
                                                            <div class="mb-1 text-muted small">
                                                                <i class="ph-bold ph-book me-1"></i>Description: {{ Str::limit($report->reported->desc ?? 'No Description', 200) }}
                                                            </div>
                                                        </div>

                                                    @elseif($report->reported instanceof \App\Models\Lesson)
                                                        <div class="mb-2">
                                                            <strong class="text-muted d-block mb-1">Lesson:</strong>
                                                            <span>{{ $report->reported->name }}</span>
                                                        </div>
                                                        <div class="text-muted small">
                                                            <i class="ph-bold ph-book-open me-1"></i>in 
                                                            <a class="text-info fw-medium" 
                                                            href="{{ route('course.course_detail', ['course_id' => encrypt($report->reported->course->id)]) }}">
                                                                {{ $report->reported->course->name ?? 'Unknown' }}
                                                            </a>
                                                        </div>

                                                    @elseif($report->reported instanceof \App\Models\ForumPost)
                                                        <div class="mb-2">
                                                            <strong class="text-muted d-block mb-1">Post Title:</strong>
                                                            <span>"{{ Str::limit($report->reported->title, 40) }}"</span>
                                                        </div>
                                                        <div class="mb-2">
                                                            <strong class="text-muted d-block mb-1">Content Preview:</strong>
                                                            <span class="fst-italic">"{{ Str::limit($report->reported->content, 200) }}"</span>
                                                        </div>
                                                        <div class="text-muted small">
                                                            <i class="ph-bold ph-user me-1"></i>by 
                                                            <a class="text-info fw-medium" 
                                                            href="{{ route('user.profile', ['user_id' => encrypt($report->reported->userCourse->user->id), 'shared' => 0]) }}">
                                                                {{ '@' . $report->reported->userCourse->user->username ?? 'Unknown' }}
                                                            </a>
                                                        </div>

                                                    @elseif($report->reported instanceof \App\Models\ForumReply)
                                                        <div class="mb-2">
                                                            <strong class="text-muted d-block mb-1">Reply Content:</strong>
                                                            <span class="fst-italic">"{{ Str::limit($report->reported->content, 60) }}"</span>
                                                        </div>
                                                        <div class="mb-1 text-muted small">
                                                            <i class="ph-bold ph-user me-1"></i>by 
                                                            <a class="text-info fw-medium" 
                                                            href="{{ route('user.profile', ['user_id' => encrypt($report->reported->userCourse->user->id), 'shared' => 0]) }}">
                                                                {{ '@' . $report->reported->userCourse->user->username ?? 'Unknown' }}
                                                            </a>
                                                        </div>
                                                        <div class="mb-1 text-muted small">
                                                            <i class="ph-bold ph-chat-circle me-1"></i>in Post: {{ Str::limit($report->reported->forumPost->title ?? 'Unknown', 30) }}
                                                        </div>
                                                        <div class="text-muted small">
                                                            <i class="ph-bold ph-book-open me-1"></i>in 
                                                            <a class="text-info fw-medium" 
                                                            href="{{ route('course.course_detail', ['course_id' => encrypt($report->reported->userCourse->course->id)]) }}">
                                                                {{ $report->reported->userCourse->course->name ?? 'Unknown' }}
                                                            </a>
                                                        </div>
                                                    
                                                    @elseif($report->reported instanceof \App\Models\Resource)
                                                        <div class="mb-2">
                                                            <strong class="text-muted d-block mb-1">Resource:</strong>
                                                            <span>{{ $report->reported->name }}</span>
                                                        </div>
                                                        @if($report->reported->link)
                                                            <div class="mb-2">
                                                                <a href="{{ $report->reported->link }}" 
                                                                class="btn btn-sm btn-outline-info py-1 px-2" 
                                                                target="_blank">
                                                                    <i class="ph-bold ph-link me-1"></i> View Link
                                                                </a>
                                                            </div>
                                                        @elseif($report->reported->resourceFile)
                                                            <div class="mb-2">
                                                                <a href="{{ asset('storage/uploads/resource_file/' . $report->reported->resourceFile->name) }}" 
                                                                class="btn btn-sm btn-outline-info py-1 px-2" 
                                                                target="_blank">
                                                                    <i class="ph-bold ph-file me-1"></i> View File
                                                                </a>
                                                            </div>
                                                        @endif
                                                        <div class="mb-1 text-muted small">
                                                            <i class="ph-bold ph-book-bookmark me-1"></i>in Lesson: {{ $report->reported->lesson->name ?? 'Unknown' }}
                                                        </div>
                                                        <div class="text-muted small">
                                                            <i class="ph-bold ph-book-open me-1"></i>in 
                                                            <a class="text-info fw-medium" 
                                                            href="{{ route('course.course_detail', ['course_id' => encrypt($report->reported->lesson->course->id)]) }}">
                                                                {{ $report->reported->lesson->course->name ?? 'Unknown' }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                    
                                                    {{-- Status & Report Count --}}
                                                    <div class="mt-3 pt-2 border-top d-flex gap-2 flex-wrap">
                                                        <div>
                                                            <span class="badge 
                                                                {{ $report->reported->status == 1 ? 'bg-success' : ($report->reported->status == 2 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                                @if($report->reported->status == 1)
                                                                    <i class="ph-bold ph-check-circle me-1"></i> Active
                                                                @elseif($report->reported->status == 2)
                                                                    <i class="ph-bold ph-clock me-1"></i> Pending
                                                                @else
                                                                    <i class="ph-bold ph-x-circle me-1"></i> Deleted/Banned
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="badge 
                                                                {{ $report->reported->reports->count() >= 5 ? 'bg-danger' : ($report->reported->reports->count() > 1 ? 'bg-warning text-dark' : 'bg-secondary') }}"
                                                                data-bs-toggle="tooltip" 
                                                                title="Total reports received for this content/user">
                                                                <i class="ph-bold ph-warning-circle me-1"></i>
                                                                {{ $report->reported->reports->where('status', 1)->count() }} Report{{ $report->reported->reports->where('status', 1)->count() > 1 ? 's' : '' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            {{ Str::limit($report->reason, 60) }}
                                        </td>
                                        {{-- <td>
                                            @if($report->status == 0)
                                                <span class="badge bg-danger text-white px-3 py-2">
                                                    <i class="ph-bold ph-x-circle me-1"></i> Dismissed
                                                </span>
                                            @elseif($report->status == 1)
                                                <span class="badge bg-warning text-dark px-3 py-2">
                                                    <i class="ph-bold ph-clock me-1"></i> Pending
                                                </span>
                                            @else
                                                <span class="badge bg-success text-white px-3 py-2">
                                                    <i class="ph-bold ph-check-circle me-1"></i> Resolved
                                                </span>
                                            @endif
                                        </td> --}}
                                        <td>{{ $report->created_at->format('d M Y') }}</td>
                                        <td>{{ $report->updated_at->format('d M Y') }}</td>
                                        <td>{{ $report->remark ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm px-3 review-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#reviewReportModal"
                                                
                                                {{-- Pass Data to Modal via Attributes --}}
                                                data-id="{{ $report->id }}"
                                                data-type="{{ class_basename($report->reported_type) }}"
                                                data-reporter="{{ $report->user->name ?? 'Unknown' }}"
                                                data-reason="{{ $report->reason }}"
                                                data-content="{{ $report->reported->title ?? $report->reported->content ?? $report->reported->name ?? 'Content Deleted' }}"
                                                data-link="#"
                                                data-status="{{ $report->status }}"
                                                data-remark="{{ $report->remark }}">
                                                Review
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    {{-- Empty row removed; DataTables handles empty states automatically --}}
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ticket table end -->
        </div>
        <!-- Ticket end -->
    </div>

    <!-- delete modal   -->
    <div class="modal fade" id="apiDeletModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body app-form">
                    <img src="{{asset('assets/images/icons/delete-icon.png')}}" alt="" class="img-fluid">
                    <div class="text-center">
                        <h4 class="text-danger f-w-600">Are You Sure?</h4>
                        <p class="text-secondary f-s-16">You won't be able to revert this!</p>
                    </div>

                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="confirmDelete">Yes,Delet it</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- edit modal  -->
    <div class="modal fade" id="ticketeditModal" tabindex="-1" aria-labelledby="ticketeditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ticketeditModalLabel">Edit Ticket</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ticket-form app-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" placeholder="Performance Issue">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Client</label>
                                    <input type="text" class="form-control" placeholder="Michelle House">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select class="form-select" >
                                        <option selected="">Select Priority</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Lower">Lower</option>
                                        <option value="High">High</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select">
                                        <option selected="">Select Status</option>
                                        <option value="open">open</option>
                                        <option value="inprogress">inprogress</option>
                                        <option value="closed">closed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" name="trip-start">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Due Date</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="reviewReportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white">Review Report #<span id="modal_report_id_display"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                {{-- Form Starts Here --}}
                <form action="{{ route('main.admin.update_report_status') }}" method="POST">
                    @csrf
                    <input type="hidden" name="report_id" id="modal_report_id_input">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 border-end">
                                <h6 class="text-primary mb-3">Report Overview</h6>
                                
                                <div class="mb-3">
                                    <label class="small text-muted">Report Type</label>
                                    <div class="fw-bold" id="modal_type">Loading...</div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted">Reported Content Summary</label>
                                    <div class="p-2 rounded border" id="modal_content">
                                        Loading...
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted">Reporter's Reason</label>
                                    <div class="text-danger" id="modal_reason">Loading...</div>
                                </div>
                                
                                {{-- <div class="mt-3">
                                    <a href="#" id="modal_link" class="btn btn-outline-secondary btn-sm w-100" target="_blank">
                                        <i class="ph-bold ph-arrow-square-out"></i> View Full Content
                                    </a>
                                </div> --}}
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Take Action</h6>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Update Status <span class="text-danger">*</span></label>
                                    <select id="modal_status" class="form-select" name="status" required>
                                        <option value="" selected disabled>Choose action...</option>
                                        <option value="2">✅ Resolve (Action Taken / Hide Content)</option>
                                        {{-- <option value="0">❌ Dismiss (Reject Report / Keep Content)</option> --}}
                                        {{-- <option value="1">⏳ Keep Pending</option> --}}
                                    </select>
                                    <div class="form-text">
                                        "Resolve" usually means you validated the report. "Dismiss" means the report was false.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Admin Response / Note</label>
                                    <textarea class="form-control" name="remark" rows="4" placeholder="e.g., Content deleted for violation of TOS..." required></textarea>
                                    <div class="form-text">This note may be visible to the user or other admins.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Decision</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

<script>
    $(document).ready(function() {

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

        /* -------------------------------------------------------------------------- */
        /* 1. Slider Initialization                                                   */
        /* -------------------------------------------------------------------------- */
        $('.ticket-slider').slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [{
                    breakpoint: 768,
                    settings: { slidesToShow: 3 }
                },
                {
                    breakpoint: 576,
                    settings: { slidesToShow: 1 }
                },
            ]
        });

        /* -------------------------------------------------------------------------- */
        /* 2. DataTables Initialization                                               */
        /* -------------------------------------------------------------------------- */
        // We assign the table to a variable 'table' so we can use the API later
        var table = $('#ticketdatatable').DataTable({
            // Enable default features
            searching: true,  // Adds the search box
            paging: true,     // Adds pagination
            ordering: true,   // Adds column sorting
            info: true,       // Shows "Showing 1 to 10 of 50 entries"
            
            // Configuration options
            pageLength: 10,   // Default rows per page
            lengthMenu: [5, 10, 25, 50], // Options for "Show X entries"
            
            // Disable sorting for Checkbox (col 0) and Action (col 6)
            columnDefs: [
                { orderable: true, targets: [0, 7] } 
            ],
            
            // Customize the language (Optional)
            language: {
                search: "",
                searchPlaceholder: "Search reports..."
            }
        });

        $('body').on('click', '.review-btn', function() {
            // Get data from button attributes
            let id = $(this).data('id');
            let type = $(this).data('type');
            let content = $(this).data('content');
            let reason = $(this).data('reason');
            let link = $(this).data('link');
            let status = $(this).data('status');
            let remark = $(this).data('remark');

            // Populate Modal Fields
            $('#modal_report_id_display').text(id);
            $('#modal_report_id_input').val(id);
            $('#modal_type').text(type);
            $('#modal_content').text(content);
            $('#modal_reason').text(reason);
            $('#modal_link').attr('href', link);
            // $('#modal_status').val(status); // Reset status selection
            $('textarea[name="remark"]').val(remark);
        });

        /* -------------------------------------------------------------------------- */
        /* 3. Delete Logic (Compatible with Pagination)                               */
        /* -------------------------------------------------------------------------- */
        // We listen for clicks on the table body to handle buttons on page 2, 3, etc.
        $('#ticketdatatable tbody').on('click', '.delete-btn', function () {
            // Find the row that contains the clicked button
            var rowElement = $(this).parents('tr');
            
            // Open the confirmation modal
            $("#apiDeletModal").modal("show");

            // Handle the "Yes, Delete" click
            $("#confirmDelete").off('click').on('click', function() {
                // Use DataTables API to remove the row
                // This ensures the "Showing 1 to 10" count updates correctly
                table.row(rowElement).remove().draw();
                
                $("#apiDeletModal").modal("hide");
            });
        });

        /* -------------------------------------------------------------------------- */
        /* 4. "Create Ticket" Modal Trigger                                           */
        /* -------------------------------------------------------------------------- */
        // Just opens the modal. Since we are using DataTables with server-side data (Blade),
        // we usually reload the page after adding content, or use AJAX to add to the table.
        // For now, this just opens the UI.
        $('#create_ticket_key').on('click', function() {
            $("#ticketModal").modal("show");
        });
    });
</script>

<!--customizer-->
<div id="customizer"></div>

<!-- slick-file -->
<script src="{{asset('assets/vendor/slick/slick.min.js')}}"></script>

<!-- data table js-->
<script src="{{asset('assets/vendor/datatable/jquery.dataTables.min.js')}}"></script>

<!-- sweetalert js-->
<script src="{{asset('assets/vendor/sweetalert/sweetalert.js')}}"></script>

<!-- api js -->
{{-- <script src="{{asset('assets/js/ticket.js')}}"></script> --}}

@endsection

