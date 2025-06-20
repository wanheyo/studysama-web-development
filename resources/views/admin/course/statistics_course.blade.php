@extends('layout.master')
@section('title', 'Statistics Course')
@section('css')
    <!-- Data Table css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/datatable2/buttons.dataTables.min.css')}}">
@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Statistics</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                      <span>
                        <i class="ph-duotone ph-book f-s-16"></i> Course
                      </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Statistics</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <!-- Course List start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <h5>Course Statistics Overview</h5>
                            {{-- <span class="badge bg-primary">Level {{ auth()->user()->userPoints?->level ?? '0' }} | {{ auth()->user()->userPoints?->xp ?? '0' }} XP</span> --}}
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center px-lg-5 px-3 py-3 gap-5 mb-3">
                        <div class="text-center">
                            <p class="text-secondary">All Courses</p>
                            <h4 class="text-primary">{{ $courses->count() }}</h4>
                        </div>
                        <div class="text-center">
                            <p class="text-secondary">Active Courses</p>
                            <h4 class="text-success">{{ $courses->where('status', 1)->count() ?? '0' }}</h4>
                        </div>
                        <div class="text-center">
                            <p class="text-secondary">Under Review Courses</p>
                            <h4 class="text-warning">{{ $courses->where('status', 2)->count() ?? '0'}}</h4>
                        </div>
                        {{-- <div class="text-center">
                            <p class="text-secondary">Unactive Courses</p>
                            <h4 class="text-primary">{{ $courses->where('status', 0)->count() ?? '0'}}</h4>
                        </div> --}}
                    </div>
                    <div class="card-body px-0">
                        <div id="pie1" class="mt-3 mb-5"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <h5>Course Creation Trends</h5>
                                {{-- <span class="badge bg-primary">Level {{ auth()->user()->userPoints?->level ?? '0' }} | {{ auth()->user()->userPoints?->xp ?? '0' }} XP</span> --}}
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <div id="line-chart" class="m-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Course List end -->
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
    @php
        $series = [];
        $labels = [];

        foreach ($topicCourseCounts as $topic) {
            $series[] = $topic->course_count;
            $labels[] = $topic->name;
        }

        $linechart_labels = $monthlyCourses->pluck('label');
        $linechart_data = $monthlyCourses->pluck('total');
    @endphp

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
                series: {!! json_encode($series) !!},
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
                labels: {!! json_encode($labels) !!},
                colors: [
                    getLocalStorageItem('color-primary', '#0d6efd'),
                    getLocalStorageItem('color-success', '#198754'),
                    getLocalStorageItem('color-warning', '#ffc107'),
                    '#20c997', '#6610f2', '#e83e8c' // more colors if more topics
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

            var options = {
            series: [{
                name: "Courses",
                data: {!! json_encode($linechart_data) !!}
            }],
            chart: {
                fontFamily: 'Montserrat, system-ui',
                height: 350,
                type: 'line',
                zoom: { enabled: false }
            },
            colors: ['rgba(var(--primary),1)'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth' },
            xaxis: {
                categories: {!! json_encode($linechart_labels) !!},
                labels: {
                    style: {
                        colors: [],
                        fontSize: '14px',
                        fontWeight: 500,
                    },
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: [],
                        fontSize: '14px',
                        fontWeight: 500,
                    },
                }
            },
            grid: {
                show: true,
                borderColor: 'rgba(var(--dark),.2)',
                strokeDashArray: 2,
                xaxis: { lines: { show: false } },
                yaxis: { lines: { show: true } },
            },
            tooltip: {
                x: { show: true },
                style: { fontSize: '16px' },
            },
        };

        var chart = new ApexCharts(document.querySelector("#line-chart"), options);
        chart.render();
        });
    </script>

    <!--customizer-->
    <div id="customizer"></div>

    <!-- apexcharts-->
<script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>

    <!-- js-->
    <script src="{{asset('assets/js/product_list.js')}}"></script>
@endsection

