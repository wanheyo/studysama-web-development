@extends('layout.master')
@section('title', 'Course Statistics')
@section('css')
    <!-- slick css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick-theme.css')}}">

    <!-- Data Table css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/datatable2/buttons.dataTables.min.css')}}">
@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Course Statistics</h4>
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
                        <a href="#" class="f-s-14 f-w-500">Course Statistics</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <div class="container-fluid py-3">
            {{-- <h4 class="mb-4">{{ $course->name }} - Tutor Statistics</h4> --}}

            <div class="row">
                <!-- Summary Cards -->
                <div class="col-md-4 mb-3">
                    <div class="card bg-light-primary shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="text-primary">Total Students</h5>
                            <h2>{{ $totalStudents }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card bg-light-success shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="text-success">Completed</h5>
                            <h2>{{ $completedStudents }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card bg-light-warning shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="text-warning">In Progress</h5>
                            <h2>{{ $inProgressStudents }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="mb-3">Course Progress Overview</h5>
                    
                    <!-- ✅ Size-controlled container -->
                    <div style="max-width: 250px; margin: 0 auto;">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Students Table -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Student Progress Details</h5>
                    <div class="table-responsive">
                        <table class="table align-middle table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Student</th>
                                    <th>Email</th>
                                    <th>Progress (%)</th>
                                    <th>Status</th>
                                    <th>Joined Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->user->name ?? '-' }}</td>
                                        <td>{{ $student->user->email ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress w-75 me-2" style="height: 10px;">
                                                    <div class="progress-bar {{ $student->progress_percentage == 100 ? 'bg-success' : 'bg-info' }}"
                                                        role="progressbar"
                                                        style="width: {{ $student->progress_percentage }}%;">
                                                    </div>
                                                </div>
                                                <small>{{ $student->progress_percentage }}%</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($student->progress_percentage == 100)
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-warning text-dark">In Progress</span>
                                            @endif
                                        </td>
                                        <td>{{ $student->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('progressChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress'],
                datasets: [{
                    data: [{{ $completedStudents }}, {{ $inProgressStudents }}],
                    backgroundColor: ['#28a745', '#ffc107'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // allow manual sizing
                plugins: { 
                    legend: { position: 'bottom' } 
                }
            }
        });
    </script>


    <!--customizer-->
    <div id="customizer"></div>

    <!-- slick-file -->
    <script src="{{asset('assets/vendor/slick/slick.min.js')}}"></script>

    <!-- data table js-->
    <script src="{{asset('assets/vendor/datatable/jquery.dataTables.min.js')}}"></script>

    <!-- api js -->
    <script src="{{asset('assets/js/ticket.js')}}"></script>
@endsection
