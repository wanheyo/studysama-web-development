<div class="leaderboard-category">
    <!-- Podium -->
    <div class="podium">
        @foreach(['first', 'second', 'third'] as $position)
            <div class="podium-place {{ $position }}-place d-flex flex-column justify-content-end">
                @if(isset($topThree[$loop->index]))
                    <img src="{{ asset($topThree[$loop->index]->image ?? 'assets/images/user-default.png') }}" 
                        class="user-avatar mx-auto mb-2" alt="avatar">
                    <h5 class="mb-0 text-white">{{ $topThree[$loop->index]->username }}</h5>
                    <div class="text-white">{{ number_format($topThree[$loop->index]->{$xpField}) }} XP</div>
                @else
                    <div class="text-muted py-3">Empty</div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- List -->
    <ul class="leaderboard-list">
        @forelse($leaderboard->slice(3)->take(10) as $user)
            <li class="leaderboard-item">
                <div class="rank-badge bg-light text-dark">
                    {{ $loop->iteration + 3 }}
                </div>
                <img src="{{ asset($user->image ?? 'assets/images/user-default.png') }}" 
                    class="user-avatar" alt="avatar">
                <div class="flex-grow-1">
                    <h6 class="mb-0">{{ $user->username }}</h6>
                    <small class="text-muted">Level {{ $user->level ?? 1 }}</small>
                </div>
                <div class="text-primary fw-bold">
                    {{ number_format($user->{$xpField}) }} XP
                </div>
            </li>
        @empty
            <li class="text-center py-4 text-muted">No entries yet - be the first!</li>
        @endforelse
    </ul>
</div>