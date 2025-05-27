<ul class="app-timeline-box">
    @forelse ($user_points as $user_point)
        @php
            $type = match ($user_point->activity_type) {
                'mcq' => 'Multiple Choice Question (MCQ)',
                'flashcard' => 'Flashcard',
                'wsp' => 'Word Search Puzzle',
                default => 'Unknown Activity',
            };

            $typeColor = match ($user_point->activity_type) {
                'mcq' => 'info',
                'flashcard' => 'success',
                'wsp' => 'warning',
                default => 'secondary',
            };

            $typeIcon = match ($user_point->activity_type) {
                'mcq' => 'ti ti-clipboard-list',
                'flashcard' => 'ti ti-cards',
                'wsp' => 'ti ti-puzzle',
                default => 'ti ti-alert-triangle',
            };
        @endphp
        <li class="timeline-section">
            <div class="timeline-icon">
                <span class="text-light-{{ $typeColor }} h-35 w-35 d-flex-center b-r-50 {{ $user_point->completed_at ? '' : 'dashed-2-danger' }}">
                    <i class="ti {{ $typeIcon }} f-s-20"></i>
                </span>
            </div>
            <div class="timeline-content bg-light-{{ $typeColor }} b-1-{{ $user_point->completed_at ? $typeColor : 'danger' }} {{ $user_point->completed_at ? '' : 'dashed-2-danger' }} px-3">
                <div class="d-flex justify-content-between align-items-center timeline-flex">
                    <div class="d-flex align-items-center gap-1">
                        <h6 class="mt-2 text-{{ $typeColor }}-dark">{{ $type }}</h6>
                        <i class="ti {{ $user_point->completed_at ? '' : 'ti-alert-triangle' }} f-s-20"></i>
                    </div>
                    @if($user_point->completed_at)
                        <p class="text-dark">{{ \Carbon\Carbon::parse($user_point->completed_at)->diffForHumans() }}</p>
                    @else
                        <p class="text-dark">{{ \Carbon\Carbon::parse($user_point->created_at)->diffForHumans() }}</p>
                    @endif
                </div>
                <p class="mt-2 text-dark">
                    @if($user_point->completed_at)
                        Successfully completed {{ $type }} with topic of <strong class="text-{{ $typeColor }}">{{ $user_point->topic }}</strong>, 
                        earning {{ $user_point->xp_earned }}/{{ $user_point->max_xp }} XP 
                        and {{ $user_point->points_earned }} points. 
                        {{-- <a class="text-primary" href="#">[more info]</a> --}}
                    @else
                        {{ ucfirst($type) }} with topic of <strong class="text-{{ $typeColor }}">{{ $user_point->topic }}</strong> is <strong class="text-danger">unfinished</strong>. No XP or points awarded.
                    @endif
                </p>
            </div>
        </li>
    @empty
        <p class="text-center text-secondary">No activity yet</p>
    @endforelse
</ul>

<div class="mt-3">
    @if ($user_points->hasPages())
        <ul class="pagination app-pagination">
            {{-- Previous Page Link --}}
            @if ($user_points->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link b-r-left">Previous</a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link b-r-left" href="{{ $user_points->previousPageUrl() }}">Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($user_points->getUrlRange(1, $user_points->lastPage()) as $page => $url)
                <li class="page-item {{ $user_points->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            {{-- Next Page Link --}}
            @if ($user_points->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $user_points->nextPageUrl() }}">Next</a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link">Next</a>
                </li>
            @endif
        </ul>
    @endif
</div>