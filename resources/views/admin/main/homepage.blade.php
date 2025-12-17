@extends('layout.master')
@section('title', 'Admin - Dashboard')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/apexcharts/apexcharts.css') }}">
@endsection

@section('main-content')
    <div class="container-fluid py-4">
        
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded shadow-sm">
                    <div>
                        <h4 class="mb-1 text-dark fw-bold">Welcome back, {{ $user->name }} 👋</h4>
                        <p class="mb-0 text-muted">Here is what's happening in your system today.</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-white text-primary border border-primary px-4 py-3 rounded-pill">
                            {{ \Carbon\Carbon::now()->format('l, d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            
            <div class="col-sm-6 col-xl-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted fw-medium">Total Users</span>
                            <div class="bg-primary-subtle text-primary rounded p-2">
                                <i class="ti ti-users fs-4"></i>
                            </div>
                        </div>
                        <h2 class="mb-1 fw-bold">{{ $users->count() }}</h2>
                        <span class="badge bg-success-subtle text-success">
                            <i class="ti ti-arrow-up"></i> Active
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted fw-medium">AI Tokens Used</span>
                            <div class="bg-danger-subtle text-danger rounded p-2">
                                <i class="ti ti-cpu fs-4"></i>
                            </div>
                        </div>
                        @php
                            $todayTokens = $user_activity_logs->where('created_at', '>=', \Carbon\Carbon::today())->sum('token_used');
                            $totalTokens = $user_activity_logs->sum('token_used');
                        @endphp
                        <h2 class="mb-1 fw-bold">{{ number_format($totalTokens) }}</h2>
                        <small class="text-muted">
                            <span class="text-danger fw-bold">+{{ number_format($todayTokens) }}</span> used today
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted fw-medium">Total Courses</span>
                            <div class="bg-success-subtle text-success rounded p-2">
                                <i class="ti ti-book fs-4"></i>
                            </div>
                        </div>
                        <h2 class="mb-1 fw-bold">{{ $courses->count() }}</h2>
                        <div class="d-flex gap-2 mt-2">
                            <span class="badge bg-warning text-dark border">
                                {{ $courses->where('status', 2)->count() }} Pending
                            </span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                {{ $courses->where('status', 1)->count() }} Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-muted fw-medium">Pending Reports</span>
                            <div class="bg-warning-subtle text-warning rounded p-2">
                                <i class="ti ti-flag fs-4"></i>
                            </div>
                        </div>
                        @php
                            $pendingReportCount = $pending_reports->count();
                        @endphp
                        <h2 class="mb-1 fw-bold">{{ $pendingReportCount }}</h2>
                        @if($pendingReportCount > 0)
                            <small class="text-danger fw-medium">Requires Attention</small>
                        @else
                            <small class="text-success fw-medium">All caught up!</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-8">
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold text-dark">📚 Courses Awaiting Approval</h5>
                        <a href="{{ route('course.admin.find_course') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light-primary">
                                    <tr>
                                        <th class="ps-4">Course Name</th>
                                        <th>Tutor</th>
                                        <th>Date Submitted</th>
                                        {{-- <th class="text-end pe-4">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($courses->where('status', 2)->take(5) as $course)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold text-dark">{{ $course->name }}</div>
                                                <small class="text-muted">{{ Str::limit($course->desc ?? 'No description', 40) }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    {{-- @if($course->tutor_image)
                                                        <img src="{{ asset('storage/'.$course->tutor_image) }}" class="rounded-circle me-2" width="30" height="30" alt="avatar">
                                                    @else
                                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" style="width:30px; height:30px; font-size:12px;">
                                                            {{ strtoupper(substr($course->tutor_username, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <span>{{ $course->tutor_username }}</span> --}}

                                                    <a href="{{ route('user.profile', ['user_id' => encrypt($course->tutor_id), 'shared' => 0]) }}" 
                                                            style="cursor: pointer; text-decoration: none; color: inherit;" 
                                                            class="d-flex align-items-center gap-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <div class="h-35 w-35 d-flex-center b-r-22 overflow-hidden me-2">
                                                                    <img src="{{ $course->tutor_image ? asset('storage/uploads/profile_picture/' . $course->tutor_image) : asset('assets/images/avtar/woman.jpg') }}" 
                                                                        alt="Tutor Avatar" class="img-fluid">
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ "@" . $course->tutor_username ?? 'User Deleted' }}</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($course->created_at)->format('d M, Y') }}</td>
                                            {{-- <td class="text-end pe-4">
                                                <a href="#" class="btn btn-primary btn-sm px-3 rounded-pill">Review</a>
                                            </td> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="ti ti-check-circle fs-1 mb-2 d-block text-success"></i>
                                                    No courses currently waiting for approval.
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold text-dark">🚩 Recent Reports</h5>
                        <a href="{{ route('main.admin.report_pending') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light-primary">
                                    <tr>
                                        <th class="ps-4">Type</th>
                                        <th>Reported By</th>
                                        <th>Reason</th>
                                        {{-- <th class="text-end pe-4">Status</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pending_reports->take(5) as $report)
                                        <tr>
                                            <td class="ps-4">
                                                <span class="badge bg-primary" style="font-size: 0.7rem;">
                                                    {{ str_replace('_', ' ', $report->reported_type) }}
                                                </span>
                                            </td>
                                            <td>
                                                {{-- {{ $report->user->username ?? 'Unknown' }} --}}

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
                                                <span class="d-inline-block text-truncate" style="max-width: 200px;">
                                                    {{ $report->reason ?? 'No reason provided' }}
                                                </span>
                                            </td>
                                            {{-- <td class="text-end pe-4">
                                                <a href="{{ route('main.admin.report_pending') }}" class="btn btn-sm btn-primary fw-bold border rounded-pill">Resolve</a>
                                            </td> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="ti ti-shield-check fs-1 mb-2 d-block text-success"></i>
                                                    No pending reports. Great job!
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">🤖 Recent AI Activity</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($user_activity_logs->sortByDesc('created_at')->take(5) as $log)
                                <li class="list-group-item border-bottom-0 py-3">
                                    <div class="d-flex align-items-start">
                                        <a href="{{ route('user.profile', ['user_id' => encrypt($log->user->id), 'shared' => 0]) }}" 
                                                style="cursor: pointer; text-decoration: none; color: inherit;" 
                                                class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="h-35 w-35 d-flex-center b-r-22 overflow-hidden me-2">
                                                        <img src="{{ $log->user->image ? asset('storage/uploads/profile_picture/' . $log->user->image) : asset('assets/images/avtar/woman.jpg') }}" 
                                                            alt="Tutor Avatar" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-0 text-dark" style="font-size: 0.9rem;">
                                                    <a href="{{ route('user.profile', ['user_id' => encrypt($log->user->id), 'shared' => 0]) }}" 
                                                            style="cursor: pointer; text-decoration: none; color: inherit;" 
                                                            class="d-flex align-items-center gap-2">
                                                        {{ '@' . $log->user->username ?? 'Unknown User' }}
                                                    </a>
                                                    {{-- User ID: {{ $log->user_id }} --}}
                                                    
                                                </h6>
                                                <small class="text-muted" style="font-size: 0.75rem;">
                                                    {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                                                </small>
                                            </div>
                                            <small class="text-muted d-block mt-1">
                                                Used <strong>{{ $log->token_used }}</strong> tokens
                                            </small>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center py-4 text-muted">
                                    No recent activity logs found.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-top text-center py-3">
                        <a href="#" class="text-decoration-none fw-bold text-primary">View Full Logs</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/js/tooltips_popovers.js')}}"></script>
@endsection