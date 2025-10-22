@extends('layout.master')
@section('title', 'Resource Statistics')
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
            <div class="col-12">
                <h4 class="main-title fw-bold">Resource Statistics - {{ $resource->name }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
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
                        <a href="{{ route('course.course_detail', ['course_id' => encrypt($resource->lesson->course->id)]) }}" class="f-s-14 f-w-500">{{ $resource->lesson->course->name }}</a>
                    </li>
                    <li>
                        <a href="{{ route('course.lesson.lesson_list', ['course_id' => encrypt($resource->lesson->course->id)]) }}" class="f-s-14 f-w-500">Lessons</a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Resource Statistics</a>
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
                    
                    <div style="max-width: 250px; margin: 0 auto;">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Students Table -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Student Progress Details</h5>
                    </div>

                    <div class="table-responsive">
                        <table id="studentTable" class="table table-striped align-middle display">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Completed Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('user.profile', ['user_id' => encrypt($student->user->id), 'shared' => 0]) }}" 
                                                style="cursor: pointer; text-decoration: none; color: inherit;" 
                                                class="d-flex align-items-center gap-2">
                                                
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $student->user->image ? asset('storage/uploads/profile_picture/' . $student->user->image) : asset('assets/images/avtar/4.png') }}"
                                                        alt="avatar" class="rounded-circle me-2" width="35" height="35">
                                                    {{ "@" . $student->user->username ?? '-' }}
                                                </div>
                                            </a>
                                        </td>
                                        <td>{{ $student->user->name ?? '-' }}</td>
                                        <td>{{ $student->user->email ?? '-' }}</td>
                                        <td>
                                            @if($student->progress_percentage == 100)
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-warning text-dark">In Progress</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($student->progress_percentage == 100 && $student->userProgressions->where('resource_id', $resource->id)->where('status', 1)->first())
                                                {{ $student->userProgressions->where('resource_id', $resource->id)->where('status', 1)->first()->updated_at->format('d M Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
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
    <!-- chartjs js -->
    <script src="{{asset('assets/vendor/chartjs/chart.js')}}"></script>
    
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
        });

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

        // DataTable initialization
        $(document).ready(function () {
            $('#studentTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                ordering: true,
                searching: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search students...",
                    lengthMenu: "Show _MENU_ entries"
                }
            });
        });

        // document.querySelectorAll('.remove-student-btn').forEach(button => {
        //     button.addEventListener('click', function () {
        //         const form = this.closest('form');
        //         const username = this.getAttribute('data-username') || 'this student';

        //         Swal.fire({
        //             title: 'Are you sure?',
        //             text: `This student, @${username}, will be removed from the course and their progress will be lost. This action cannot be undone.`,
        //             icon: 'warning',
        //             showCancelButton: true,
        //             confirmButtonColor: '#d33',
        //             cancelButtonColor: '#6c757d',
        //             confirmButtonText: 'Yes, remove!',
        //             reverseButtons: true,
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 form.submit();
        //             }
        //         });
        //     });
        // });
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
    <script src="{{asset('assets/js/ticket.js')}}"></script>
@endsection
