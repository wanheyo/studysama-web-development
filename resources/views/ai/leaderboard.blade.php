@extends('layout.master')
@section('title', 'StudySama AI')
@section('css')

@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Leaderboard</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone ph-star-four f-s-16"></i> StudySama AI
                            </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Leaderboard</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- leaderboard start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Leaderboard Rankings</h5>
                        <p class="f-m-light">Who's leading the study race? Check out our top performers!</p>
                    </div>
                    <div class="card-body">
                        
                        <!-- Tabs for different leaderboard types -->
                        <ul class="nav nav-tabs tab-primary bg-primary p-2" id="leaderboardTabs" role="tablist">
                            <li class="nav-item flex-grow-1" role="presentation">
                                <button class="nav-link w-100 active" id="overall-tab" data-bs-toggle="tab" data-bs-target="#overall" type="button" role="tab" aria-controls="overall" aria-selected="true">
                                    <i class="ph-duotone ph-trophy pe-1 ps-1"></i> Overall XP
                                </button>
                            </li>
                            <li class="nav-item flex-grow-1" role="presentation">
                                <button class="nav-link w-100" id="mcq-tab" data-bs-toggle="tab" data-bs-target="#mcq" type="button" role="tab" aria-controls="mcq" aria-selected="false">
                                    <i class="ph-duotone ph-check-square pe-1 ps-1"></i> MCQ Champions
                                </button>
                            </li>
                            <li class="nav-item flex-grow-1" role="presentation">
                                <button class="nav-link w-100" id="flashcard-tab" data-bs-toggle="tab" data-bs-target="#flashcard" type="button" role="tab" aria-controls="flashcard" aria-selected="false">
                                    <i class="ph-duotone ph-cards pe-1 ps-1"></i> Flashcard Masters
                                </button>
                            </li>
                            <li class="nav-item flex-grow-1" role="presentation">
                                <button class="nav-link w-100" id="wsp-tab" data-bs-toggle="tab" data-bs-target="#wsp" type="button" role="tab" aria-controls="wsp" aria-selected="false">
                                    <i class="ph-duotone ph-puzzle-piece pe-1 ps-1"></i> Word Search Puzzle Stars
                                </button>
                            </li>
                        </ul>

                        <!-- Tab contents -->
                        <div class="tab-content pt-4" id="leaderboardTabContent">
                            <!-- Overall XP Leaderboard -->
                            <div class="tab-pane fade show active" id="overall" role="tabpanel" aria-labelledby="overall-tab">
                                <div id="overall-pagination" class="mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="80">Rank</th>
                                                <th scope="col">Student</th>
                                                <th scope="col" class="text-center">Level</th>
                                                <th scope="col" class="text-end">XP</th>
                                                <th scope="col" class="text-end">Points</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($userXP as $index => $user)
                                                <tr class="{{ $index < 3 ? 'leaderboard-top-' . ($index + 1) : '' }}">
                                                    <td>
                                                        @if($index === 0)
                                                            <div class="leaderboard-medal gold">1</div>
                                                        @elseif($index === 1)
                                                            <div class="leaderboard-medal silver">2</div>
                                                        @elseif($index === 2)
                                                            <div class="leaderboard-medal bronze">3</div>
                                                        @else
                                                            <span class="leaderboard-rank">{{ $index + 1 }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="user-avatar me-2">
                                                                @if($user->image)
                                                                    <img src="{{ $user->image ? asset('storage/uploads/profile_picture/' . $user->image) : asset('assets/images/avtar/woman.jpg') }}" alt="{{ $user->username }}" class="avatar rounded-circle">
                                                                @else
                                                                    <div class="avatar-placeholder rounded-circle">{{ substr($user->username, 0, 1) }}</div>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ $user->username }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary">Level {{ $user->level }}</span>
                                                    </td>
                                                    <td class="text-end fw-bold">{{ number_format($user->xp) }} XP</td>
                                                    <td class="text-end">{{ number_format($user->total_points) }}</td>
                                                </tr>
                                            @endforeach
                                            @if(count($userXP) === 0)
                                                <tr>
                                                    <td colspan="5" class="text-center">No data available</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- MCQ XP Leaderboard -->
                            <div class="tab-pane fade" id="mcq" role="tabpanel" aria-labelledby="mcq-tab">
                                <div id="mcq-pagination" class="mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="80">Rank</th>
                                                <th scope="col">Student</th>
                                                <th scope="col" class="text-end">XP</th>
                                                <th scope="col" class="text-end">Points</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($mcqLeaderboard as $index => $user)
                                                <tr class="{{ $index < 3 ? 'leaderboard-top-' . ($index + 1) : '' }}">
                                                    <td>
                                                        @if($index === 0)
                                                            <div class="leaderboard-medal gold">1</div>
                                                        @elseif($index === 1)
                                                            <div class="leaderboard-medal silver">2</div>
                                                        @elseif($index === 2)
                                                            <div class="leaderboard-medal bronze">3</div>
                                                        @else
                                                            <span class="leaderboard-rank">{{ $index + 1 }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="user-avatar me-2">
                                                                @if($user->image)
                                                                    <img src="{{ $user->image ? asset('storage/uploads/profile_picture/' . $user->image) : asset('assets/images/avtar/woman.jpg') }}" alt="{{ $user->username }}" class="avatar rounded-circle">
                                                                @else
                                                                    <div class="avatar-placeholder rounded-circle">{{ substr($user->username, 0, 1) }}</div>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ $user->username }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end fw-bold">{{ number_format($user->total_xp) }} XP</td>
                                                    <td class="text-end">{{ number_format($user->total_points) }}</td>
                                                </tr>
                                            @endforeach
                                            @if(count($mcqLeaderboard) === 0)
                                                <tr>
                                                    <td colspan="4" class="text-center">No MCQ activity data available</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Flashcard XP Leaderboard -->
                            <div class="tab-pane fade" id="flashcard" role="tabpanel" aria-labelledby="flashcard-tab">
                                <div id="flashcard-pagination" class="mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="80">Rank</th>
                                                <th scope="col">Student</th>
                                                <th scope="col" class="text-end">XP</th>
                                                <th scope="col" class="text-end">Points</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($flashcardLeaderboard as $index => $user)
                                                <tr class="{{ $index < 3 ? 'leaderboard-top-' . ($index + 1) : '' }}">
                                                    <td>
                                                        @if($index === 0)
                                                            <div class="leaderboard-medal gold">1</div>
                                                        @elseif($index === 1)
                                                            <div class="leaderboard-medal silver">2</div>
                                                        @elseif($index === 2)
                                                            <div class="leaderboard-medal bronze">3</div>
                                                        @else
                                                            <span class="leaderboard-rank">{{ $index + 1 }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="user-avatar me-2">
                                                                @if($user->image)
                                                                    <img src="{{ $user->image ? asset('storage/uploads/profile_picture/' . $user->image) : asset('assets/images/avtar/woman.jpg') }}" alt="{{ $user->username }}" class="avatar rounded-circle">
                                                                @else
                                                                    <div class="avatar-placeholder rounded-circle">{{ substr($user->username, 0, 1) }}</div>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ $user->username }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end fw-bold">{{ number_format($user->total_xp) }} XP</td>
                                                    <td class="text-end">{{ number_format($user->total_points) }}</td>
                                                </tr>
                                            @endforeach
                                            @if(count($flashcardLeaderboard) === 0)
                                                <tr>
                                                    <td colspan="4" class="text-center">No flashcard activity data available</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Word Search Puzzle XP Leaderboard -->
                            <div class="tab-pane fade" id="wsp" role="tabpanel" aria-labelledby="wsp-tab">
                                <div id="wsp-pagination" class="mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="80">Rank</th>
                                                <th scope="col">Student</th>
                                                <th scope="col" class="text-end">XP</th>
                                                <th scope="col" class="text-end">Points</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($wspLeaderboard as $index => $user)
                                                <tr class="{{ $index < 3 ? 'leaderboard-top-' . ($index + 1) : '' }}">
                                                    <td>
                                                        @if($index === 0)
                                                            <div class="leaderboard-medal gold">1</div>
                                                        @elseif($index === 1)
                                                            <div class="leaderboard-medal silver">2</div>
                                                        @elseif($index === 2)
                                                            <div class="leaderboard-medal bronze">3</div>
                                                        @else
                                                            <span class="leaderboard-rank">{{ $index + 1 }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="user-avatar me-2">
                                                                @if($user->image)
                                                                    <img src="{{ $user->image ? asset('storage/uploads/profile_picture/' . $user->image) : asset('assets/images/avtar/woman.jpg') }}" alt="{{ $user->username }}" class="avatar rounded-circle">
                                                                @else
                                                                    <div class="avatar-placeholder rounded-circle">{{ substr($user->username, 0, 1) }}</div>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ $user->username }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end fw-bold">{{ number_format($user->total_xp) }} XP</td>
                                                    <td class="text-end">{{ number_format($user->total_points) }}</td>
                                                </tr>
                                            @endforeach
                                            @if(count($wspLeaderboard) === 0)
                                                <tr>
                                                    <td colspan="4" class="text-center">No workshop activity data available</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- leaderboard end -->
    </div>

    <style>
        .swal2-toast {
            width: auto !important;
            max-width: 100% !important;
            padding: 0.625em !important;
        }

        /* Leaderboard Styling */
        .leaderboard-medal {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #fff;
            margin: 0 auto;
        }
        
        .leaderboard-medal.gold {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            box-shadow: 0 2px 5px rgba(255, 215, 0, 0.5);
        }
        
        .leaderboard-medal.silver {
            background: linear-gradient(135deg, #C0C0C0, #A9A9A9);
            box-shadow: 0 2px 5px rgba(192, 192, 192, 0.5);
        }
        
        .leaderboard-medal.bronze {
            background: linear-gradient(135deg, #CD7F32, #8B4513);
            box-shadow: 0 2px 5px rgba(205, 127, 50, 0.5);
        }
        
        .leaderboard-rank {
            display: block;
            text-align: center;
            font-weight: 500;
        }
        
        .leaderboard-top-1 {
            background-color: rgba(255, 215, 0, 0.1);
        }
        
        .leaderboard-top-2 {
            background-color: rgba(192, 192, 192, 0.1);
        }
        
        .leaderboard-top-3 {
            background-color: rgba(205, 127, 50, 0.1);
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }
        
        .avatar-placeholder {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #6c757d;
            color: white;
            font-weight: bold;
        }
        
        .card-title {
            display: flex;
            align-items: center;
        }
        
        .card-title::before {
            content: '';
            display: inline-block;
            width: 24px;
            height: 24px;
            margin-right: 10px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9H4.5a2.5 2.5 0 0 1 0-5H6'/%3E%3Cpath d='M18 9h1.5a2.5 2.5 0 0 0 0-5H18'/%3E%3Cpath d='M4 22h16'/%3E%3Cpath d='M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22'/%3E%3Cpath d='M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22'/%3E%3Cpath d='M18 2H6v7a6 6 0 0 0 12 0V2Z'/%3E%3C/svg%3E");
            background-size: contain;
        }
        
        .nav-tabs .nav-link.active {
            /* border-bottom: 3px solid #0d6efd; */
            font-weight: 600;
        }
        
        /* Pagination styling */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .pagination-btn {
            margin: 0 5px;
            padding: 5px 12px;
            border-radius: 4px;
            background-color: #f0f0f0;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .pagination-btn.active {
            background-color: #0d6efd;
            color: white;
        }
        
        .pagination-btn:hover:not(.active) {
            background-color: #e0e0e0;
        }
    </style>
@endsection

@section('script')

<script>
    document.addEventListener("DOMContentLoaded", function () {
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

        // Pagination setup
        const itemsPerPage = 10;
        const paginateData = (data, container, page = 1) => {
            const totalItems = data.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            
            // Create pagination controls
            let paginationHTML = '<div class="pagination-container">';
            
            if (totalPages > 1) {
                for (let i = 1; i <= totalPages; i++) {
                    paginationHTML += `<div class="pagination-btn ${i === page ? 'active' : ''}" data-page="${i}">${i}</div>`;
                }
            }
            
            paginationHTML += '</div>';
            document.getElementById(container).innerHTML = paginationHTML;
            
            // Add event listeners to pagination buttons
            document.querySelectorAll(`#${container} .pagination-btn`).forEach(button => {
                button.addEventListener('click', function() {
                    const newPage = parseInt(this.getAttribute('data-page'));
                    paginateData(data, container, newPage);
                    
                    // Update table display
                    const startIndex = (newPage - 1) * itemsPerPage;
                    const endIndex = Math.min(startIndex + itemsPerPage, totalItems);
                    
                    const tableBody = document.querySelector(`#${container.replace('pagination', '')}`).querySelector('tbody');
                    const rows = tableBody.querySelectorAll('tr');
                    
                    // Hide all rows first
                    rows.forEach(row => {
                        row.style.display = 'none';
                    });
                    
                    // Show only the rows for current page
                    for (let i = startIndex; i < endIndex && i < rows.length; i++) {
                        rows[i].style.display = '';
                    }
                });
            });
            
            // Initial display - show only first page items
            const tableBody = document.querySelector(`#${container.replace('pagination', '')}`).querySelector('tbody');
            if (tableBody) {
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach((row, index) => {
                    if (index >= itemsPerPage) {
                        row.style.display = 'none';
                    }
                });
            }
        };
        
        // Initialize pagination for each tab
        const overallData = Array.from(document.querySelectorAll('#overall tbody tr'));
        const mcqData = Array.from(document.querySelectorAll('#mcq tbody tr'));
        const flashcardData = Array.from(document.querySelectorAll('#flashcard tbody tr'));
        const wspData = Array.from(document.querySelectorAll('#wsp tbody tr'));
        
        paginateData(overallData, 'overall-pagination');
        paginateData(mcqData, 'mcq-pagination');
        paginateData(flashcardData, 'flashcard-pagination');
        paginateData(wspData, 'wsp-pagination');
        
        // Add confetti animation for top performers when hovering over their rows
        const confetti = (element) => {
            const colors = ['#FFD700', '#C0C0C0', '#CD7F32', '#0d6efd', '#20c997', '#fd7e14'];
            
            const createParticle = (x, y) => {
                const particle = document.createElement('div');
                particle.style.position = 'absolute';
                particle.style.width = '6px';
                particle.style.height = '6px';
                particle.style.borderRadius = '50%';
                particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                particle.style.top = `${y}px`;
                particle.style.left = `${x}px`;
                
                const rect = element.getBoundingClientRect();
                const targetX = rect.left + rect.width * Math.random();
                const targetY = rect.top + rect.height * Math.random();
                
                const animation = particle.animate([
                    { transform: 'translate(0, 0)', opacity: 1 },
                    { transform: `translate(${targetX - x}px, ${targetY - y}px)`, opacity: 0 }
                ], {
                    duration: 1000 + Math.random() * 1000,
                    easing: 'cubic-bezier(0.1, 0.8, 0.2, 1)'
                });
                
                document.body.appendChild(particle);
                
                animation.onfinish = () => {
                    particle.remove();
                };
            };
            
            const rect = element.getBoundingClientRect();
            for (let i = 0; i < 15; i++) {
                setTimeout(() => {
                    createParticle(
                        rect.left + Math.random() * rect.width,
                        rect.top + Math.random() * rect.height
                    );
                }, i * 50);
            }
        };
        
        // Add confetti effect to top 3 rows
        document.querySelectorAll('.leaderboard-top-1, .leaderboard-top-2, .leaderboard-top-3').forEach(row => {
            row.addEventListener('mouseenter', () => {
                confetti(row);
            });
        });
    });
</script>

<!--customizer-->
<div id="customizer"></div>

<!--typed js-->
<script src="{{ asset('assets/vendor/typed/typed.umd.js') }}"></script>

<!-- sweetalert js-->
<script src="{{asset('assets/vendor/sweetalert/sweetalert.js')}}"></script>

@endsection
