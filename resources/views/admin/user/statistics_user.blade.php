@extends('layout.master')
@section('title', 'User Statistics')
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
                <h4 class="main-title">User Statistics</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                            <a href="#" class="f-s-14 f-w-500">
                        <span>
                            <i class="ph-duotone ph-users f-s-16"></i> User
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

        <!-- User Statistics Overview start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <h5>User Statistics Overview</h5>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center px-lg-5 px-3 py-3 gap-5 mb-3 flex-wrap">
                        <div class="text-center">
                            <p class="text-secondary">Total Users</p>
                            <h4 class="text-primary">{{ $users->count() }}</h4>
                        </div>
                        <div class="text-center">
                            <p class="text-secondary">Active Users</p>
                            <h4 class="text-success">{{ $users->where('status', 1)->count() ?? '0' }}</h4>
                        </div>
                        <div class="text-center">
                            <p class="text-secondary">Under Review</p>
                            <h4 class="text-warning">{{ $users->where('status', 2)->count() ?? '0'}}</h4>
                        </div>
                        {{-- <div class="text-center">
                            <p class="text-secondary">Avg Followers</p>
                            <h4 class="text-info">{{ number_format($avgStats->avg_followers ?? 0, 1) }}</h4>
                        </div> --}}
                        {{-- <div class="text-center">
                            <p class="text-secondary">Avg Rating</p>
                            <h4 class="text-warning">{{ number_format($avgStats->avg_rating ?? 0, 1) }}/5</h4>
                        </div> --}}
                    </div>
                    {{-- <div class="card-body px-0">
                        <div id="role-pie-chart" class="mt-3 mb-5"></div>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- User Registration Trends start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <h5>User Registration Trends</h5>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div id="user-registration-chart" class="m-3"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <!-- Top Users by Followers start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <h5>Top Users by Followers</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th>Followers</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topUsers as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if($user->image)
                                                    <img src="{{ asset('storage/'.$user->image) }}" 
                                                         alt="{{ $user->name }}" 
                                                         class="rounded-circle" 
                                                         width="32" height="32">
                                                @else
                                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                                         style="width: 32px; height: 32px;">
                                                        <span class="text-white text-sm">{{ substr($user->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-medium">{{ $user->name }}</div>
                                                    <small class="text-muted">{{ $user->username }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $user->role == 'Tutor' ? 'primary' : 'secondary' }}">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($user->total_follower) }}</td>
                                        <td>
                                            @if($user->average_rating)
                                                <span class="text-warning">
                                                    {{ number_format($user->average_rating, 1) }}/5
                                                </span>
                                            @else
                                                <span class="text-muted">No rating</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @elseif($user->status == 2)
                                                <span class="badge bg-warning">Under Review</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Top Users end --> --}}
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
        $roleSeries = [];
        $roleLabels = [];

        foreach ($roleDistribution as $role) {
            $roleSeries[] = $role->user_count;
            $roleLabels[] = $role->role;
        }

        $registrationLabels = $monthlyUsers->pluck('label');
        $registrationData = $monthlyUsers->pluck('total');
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

            // Role Distribution Pie Chart
            var roleOptions = {
                series: {!! json_encode($roleSeries) !!},
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
                labels: {!! json_encode($roleLabels) !!},
                colors: [
                    getLocalStorageItem('color-primary', '#0d6efd'),
                    getLocalStorageItem('color-success', '#198754'),
                    getLocalStorageItem('color-warning', '#ffc107'),
                    getLocalStorageItem('color-info', '#0dcaf0'),
                    '#20c997', '#6610f2', '#e83e8c'
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

            var roleChart = new ApexCharts(document.querySelector("#role-pie-chart"), roleOptions);
            roleChart.render();

            // User Registration Trend Line Chart
            var registrationOptions = {
                series: [{
                    name: "New Users",
                    data: {!! json_encode($registrationData) !!}
                }],
                chart: {
                    fontFamily: 'Montserrat, system-ui',
                    height: 350,
                    type: 'line',
                    zoom: { enabled: false }
                },
                colors: ['rgba(var(--primary),1)'],
                dataLabels: { enabled: false },
                stroke: { 
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: {!! json_encode($registrationLabels) !!},
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
                markers: {
                    size: 6,
                    colors: ['rgba(var(--primary),1)'],
                    strokeColors: '#fff',
                    strokeWidth: 2,
                    hover: {
                        size: 8,
                    }
                }
            };

            var registrationChart = new ApexCharts(document.querySelector("#user-registration-chart"), registrationOptions);
            registrationChart.render();
        });
    </script>

    <!--customizer-->
    <div id="customizer"></div>

    <!-- apexcharts-->
    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>

    <!-- js-->
    <script src="{{asset('assets/js/product_list.js')}}"></script>
@endsection