@extends('layout.master')
@section('title', 'AI Flashcard Generator')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">{{ $title ?? 'StudySama Flashcard' }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="{{ route('ai.flashcard') }}" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone ph-star-four f-s-16"></i> StudySama AI
                            </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('ai.flashcard') }}" class="f-s-14 f-w-500">
                            <span>Flashcard</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Flashcard - {{ $title ?? 'StudySama Flashcard' }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="ti ti-brain me-2"></i>{{ $title ?? 'StudySama Flashcard' }}
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="audio-controls me-3">
                                <button id="toggle-music" class="btn btn-sm btn-outline-secondary">
                                    <i class="ti ti-music me-1"></i><span id="music-text">Play Music</span>
                                </button>
                                <audio id="background-music" loop>
                                    <source src="{{ asset('assets/audio/study_background.mp3') }}" type="audio/mp3">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                            <div class="quiz-timer">
                                <span class="badge bg-warning p-2">
                                    <i class="ti ti-clock me-1"></i>Time: <span id="minutes">00</span>:<span id="seconds">00</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(!empty($flashcards))
                            <div class="quiz-stats mb-4 d-flex justify-content-between">
                                <div class="progress w-100 mt-2">
                                    <div id="quiz-progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                                </div>
                                <span class="ms-3 badge bg-info p-2">
                                    <span id="current-flashcard">1</span>/<span id="total-flashcards">{{ count($flashcards) }}</span>
                                </span>
                            </div>

                            <div class="quiz-container">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        @foreach($flashcards as $index => $flashcard)
                                            <div class="flashcard-wrapper" id="flashcard-{{ $index }}" style="{{ $index > 0 ? 'display: none;' : '' }}">
                                                <div class="flip-card mb-4">
                                                    <div class="flip-card-inner" id="flip-card-inner-{{ $index }}">
                                                        <div class="flip-card-front rounded">
                                                            <div class="card border h-100 d-flex flex-column justify-content-between rounded hover-effect">
                                                                <div class="card-header bg-primary text-white">
                                                                    <h5 class="card-title mb-3 text-center text-white">Flashcard {{ $index + 1 }}</h5>
                                                                </div>
                                                                <div class="card-body d-flex align-items-center justify-content-center">
                                                                    <i class="ti ti-question-mark icon-bg"></i>
                                                                    <div class="flashcard-text">{{ $flashcard['frontside'] }}</div>
                                                                </div>
                                                                <div class="card-footer bg-primary">
                                                                    <button type="button" class="btn btn-outline-success w-100 flip-btn rounded" data-index="{{ $index }}">
                                                                        <i class="ti ti-refresh me-1"></i>Flip Card
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flip-card-back rounded">
                                                            <div class="card border h-100 d-flex flex-column justify-content-between rounded hover-effect">
                                                                <div class="card-header bg-success text-white">
                                                                    <h5 class="card-title mb-3 text-center success text-white">Answer for Flashcard {{ $index + 1 }}</h5>
                                                                </div>
                                                                <div class="card-body d-flex align-items-center justify-content-center">
                                                                    <i class="ti ti-check icon-bg"></i>
                                                                    <div class="flashcard-text">{{ $flashcard['backside'] }}</div>
                                                                </div>
                                                                <div class="card-footer bg-success">
                                                                    <button type="button" class="btn btn-outline-warning w-100 flip-btn rounded" data-index="{{ $index }}">
                                                                        <i class="ti ti-refresh me-1"></i>Flip Back
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="navigation-buttons d-flex justify-content-between mt-4">
                                                    @if($index > 0)
                                                        <button type="button" class="btn btn-secondary prev-btn" data-index="{{ $index }}">
                                                            <i class="ti ti-arrow-left me-1"></i>Previous
                                                        </button>
                                                    @else
                                                        <div></div>
                                                    @endif
                                                    
                                                    <div class="flashcard-controls">
                                                        <div class="form-check form-check-inline mb-0">
                                                            <input class="form-check-input" type="checkbox" id="mark-known-{{ $index }}" value="{{ $index }}">
                                                            <label class="form-check-label" for="mark-known-{{ $index }}">Mark as Known</label>
                                                        </div>
                                                    </div>
                                                    
                                                    @if($index < count($flashcards) - 1)
                                                        <button type="button" class="btn btn-primary next-btn" data-index="{{ $index }}">
                                                            Next<i class="ti ti-arrow-right ms-1"></i>
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-success" id="finish-flashcards">
                                                            <i class="ti ti-check me-1"></i>Finish
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <p>No flashcards were generated. Please try again with a different topic.</p>
                                <a href="{{ route('ai.mcq') }}" class="btn btn-primary mt-3">
                                    <i class="ti ti-arrow-left me-1"></i>Go Back
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Results Modal -->
        <div class="modal fade" id="flashcardResultModal" tabindex="-1" aria-labelledby="flashcardResultModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="flashcardResultModalLabel">Study Session Complete!</h5>
                        <button aria-label="Close" class="btn-close m-0" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <div class="result-summary text-center mb-4">
                            <div class="celebration-animation mb-3">
                                <i class="ti ti-trophy text-warning" style="font-size: 64px;"></i>
                            </div>
                            <h3>Great Job!</h3>
                            <p>You've completed your flashcard study session</p>
                            <p>Time taken: <span id="time-taken">00:00</span></p>
                            <div class="mt-3">
                                <p>Cards marked as known: <span id="known-count">0</span> out of <span id="total-count">{{ count($flashcards ?? []) }}</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('ai.mcq') }}" class="btn btn-secondary">
                            <i class="ti ti-home me-1"></i>Return Home
                        </a>
                        <button type="button" class="btn btn-primary" id="restart-session">
                            <i class="ti ti-refresh me-1"></i>Restart Session
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keyboard Shortcut Modal -->
        <div class="modal fade" id="keyboardShortcutModal" tabindex="-1" aria-labelledby="keyboardShortcutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="keyboardShortcutModalLabel">Keyboard Shortcuts</h5>
                        <button aria-label="Close" class="btn-close m-0" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Key</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><kbd>Space</kbd></td>
                                                <td>Flip card</td>
                                            </tr>
                                            <tr>
                                                <td><kbd>→</kbd></td>
                                                <td>Next card</td>
                                            </tr>
                                            <tr>
                                                <td><kbd>←</kbd></td>
                                                <td>Previous card</td>
                                            </tr>
                                            <tr>
                                                <td><kbd>K</kbd></td>
                                                <td>Toggle "Mark as known"</td>
                                            </tr>
                                            <tr>
                                                <td><kbd>S</kbd></td>
                                                <td>Swipe to next card</td>
                                            </tr>
                                            <tr>
                                                <td><kbd>A</kbd></td>
                                                <td>Swipe to previous card</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<style>
    .quiz-container {
        min-height: 400px;
    }
    
    .question-card {
        animation: fadeIn 0.5s;
    }

    /* Flip Card Styles */
    .flip-card {
        perspective: 1000px;
        height: 300px;
        margin-bottom: 20px;
    }
    
    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.8s;
        transform-style: preserve-3d;
    }
    
    .flipped {
        transform: rotateY(180deg);
    }
    
    .flip-card-front, .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        /* border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); */
    }
    
    /* Card swipe animations */
    .swipe-left-out {
        animation: swipeLeftOut 0.5s forwards;
    }
    
    .swipe-right-out {
        animation: swipeRightOut 0.5s forwards;
    }
    
    .swipe-left-in {
        animation: swipeLeftIn 0.5s forwards;
    }
    
    .swipe-right-in {
        animation: swipeRightIn 0.5s forwards;
    }
    
    @keyframes swipeLeftOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(-100%); opacity: 0; }
    }
    
    @keyframes swipeRightOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    
    @keyframes swipeLeftIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes swipeRightIn {
        from { transform: translateX(-100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    .flip-card-back {
        transform: rotateY(180deg);
    }
    
    .flashcard-text {
        font-size: 1.2rem;
        padding: 15px;
    }
    
    .celebration-animation {
        animation: bounce 1s ease infinite;
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
        40% {transform: translateY(-30px);}
        60% {transform: translateY(-15px);}
    }
    
    .option-item {
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }
    
    .option-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }
    
    .keyboard-shortcut-badge {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        cursor: pointer;
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .swal2-toast {
        width: auto !important;
        max-width: 100% !important;
        padding: 0.625em !important;
    }

    /* Confetti animation for completion */
    .confetti {
        position: fixed;
        width: 10px;
        height: 10px;
        background-color: #f2d74e;
        border-radius: 0;
        top: -10px;
        z-index: 9999;
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
                    timer: 2000,
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
                    timer: 2000,
                    timerProgressBar: true,
                    width: 'auto',
                });
            }, 100);
        @endif

        // Add keyboard shortcut badge to page
        const shortcutBadge = document.createElement('div');
        shortcutBadge.className = 'keyboard-shortcut-badge';
        shortcutBadge.innerHTML = '<i class="ti ti-keyboard"></i>';
        shortcutBadge.addEventListener('click', function() {
            const shortcutModal = new bootstrap.Modal(document.getElementById('keyboardShortcutModal'));
            shortcutModal.show();
        });
        document.body.appendChild(shortcutBadge);

        // Initialize timer
        let totalSeconds = 0;
        let timerInterval;
        const minutesDisplay = document.getElementById('minutes');
        const secondsDisplay = document.getElementById('seconds');
        
        function startTimer() {
            timerInterval = setInterval(function() {
                totalSeconds++;
                const minutes = Math.floor(totalSeconds / 60);
                const seconds = totalSeconds % 60;
                
                minutesDisplay.textContent = minutes < 10 ? '0' + minutes : minutes;
                secondsDisplay.textContent = seconds < 10 ? '0' + seconds : seconds;
            }, 1000);
        }
        
        function stopTimer() {
            clearInterval(timerInterval);
        }
        
        // Flashcard navigation and progress tracking
        const totalFlashcards = {{ count($flashcards ?? []) }};
        const progressBar = document.getElementById('quiz-progress-bar');
        const currentFlashcardDisplay = document.getElementById('current-flashcard');
        let currentFlashcardIndex = 0;
        let isDoneUpdateXP = false;
        
        function updateProgress() {
            const progress = ((currentFlashcardIndex + 1) / totalFlashcards) * 100;
            progressBar.style.width = progress + '%';
            currentFlashcardDisplay.textContent = currentFlashcardIndex + 1;
        }
        
        // Background music control
        const musicToggleBtn = document.getElementById('toggle-music');
        const musicText = document.getElementById('music-text');
        const backgroundMusic = document.getElementById('background-music');
        
        musicToggleBtn.addEventListener('click', function() {
            if (backgroundMusic.paused) {
                backgroundMusic.volume = 0.5; // Set volume to 0%
                backgroundMusic.play();
                musicText.textContent = 'Pause Music';
                musicToggleBtn.classList.remove('btn-outline-secondary');
                musicToggleBtn.classList.add('btn-outline-success');
            } else {
                backgroundMusic.pause();
                musicText.textContent = 'Play Music';
                musicToggleBtn.classList.remove('btn-outline-success');
                musicToggleBtn.classList.add('btn-outline-secondary');
            }
        });
        
        // Card flip functionality
        document.querySelectorAll('.flip-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const index = this.dataset.index;
                const flipCardInner = document.getElementById('flip-card-inner-' + index);
                flipCardInner.classList.toggle('flipped');
                
                // Play flip sound
                const flipSound = new Audio("{{ asset('assets/audio/card_flip.mp3') }}");
                flipSound.volume = 0.5;
                flipSound.play();
            });
        });

        // Next button click handler
        document.querySelectorAll('.next-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const index = parseInt(this.dataset.index);
                const currentCard = document.getElementById('flashcard-' + index);
                const nextCard = document.getElementById('flashcard-' + (index + 1));
                
                // Apply swipe animation
                currentCard.classList.add('swipe-left-out');
                
                setTimeout(() => {
                    currentCard.style.display = 'none';
                    currentCard.classList.remove('swipe-left-out');
                    
                    // Prepare next card
                    nextCard.style.display = 'block';
                    nextCard.classList.add('swipe-left-in');
                    
                    setTimeout(() => {
                        nextCard.classList.remove('swipe-left-in');
                    }, 500);
                    
                    currentFlashcardIndex = index + 1;
                    updateProgress();
                    
                    // Ensure the next card is showing the front side
                    const nextFlipCardInner = document.getElementById('flip-card-inner-' + (index + 1));
                    if (nextFlipCardInner.classList.contains('flipped')) {
                        nextFlipCardInner.classList.remove('flipped');
                    }
                }, 500);
            });
        });

        // Previous button click handler
        document.querySelectorAll('.prev-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const index = parseInt(this.dataset.index);
                const currentCard = document.getElementById('flashcard-' + index);
                const prevCard = document.getElementById('flashcard-' + (index - 1));
                
                // Apply swipe animation
                currentCard.classList.add('swipe-right-out');
                
                setTimeout(() => {
                    currentCard.style.display = 'none';
                    currentCard.classList.remove('swipe-right-out');
                    
                    // Prepare previous card
                    prevCard.style.display = 'block';
                    prevCard.classList.add('swipe-right-in');
                    
                    setTimeout(() => {
                        prevCard.classList.remove('swipe-right-in');
                    }, 500);
                    
                    currentFlashcardIndex = index - 1;
                    updateProgress();
                    
                    // Ensure the previous card is showing the front side
                    const prevFlipCardInner = document.getElementById('flip-card-inner-' + (index - 1));
                    if (prevFlipCardInner.classList.contains('flipped')) {
                        prevFlipCardInner.classList.remove('flipped');
                    }
                }, 500);
            });
        });
        
        // Finish button handler
        const finishBtn = document.getElementById('finish-flashcards');
        if (finishBtn) {
            finishBtn.addEventListener('click', function() {
                stopTimer();
                showResults();
            });
        }

        // Calculate XP
        const xpEarned = 50; // 100% = 50 XP
        const maxXp = 50; 
        const pointsEarned = 5; // 0.2 point per 10%
        
        // Calculate and show results
        function showResults() {
            // Count marked as known cards
            let knownCount = 0;
            document.querySelectorAll('input[id^="mark-known-"]').forEach(checkbox => {
                if (checkbox.checked) {
                    knownCount++;
                }
            });
            
            // Update known count in modal
            document.getElementById('known-count').textContent = knownCount;
            document.getElementById('total-count').textContent = totalFlashcards;
            
            // Update time taken
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;
            const formattedTime = `${minutes < 10 ? '0' + minutes : minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
            document.getElementById('time-taken').textContent = formattedTime;
            
            // Show celebration confetti
            createConfetti();
            
            // Play celebration sound
            const celebrationSound = new Audio("{{ asset('assets/audio/success_2.mp3') }}");
            celebrationSound.volume = 0.5;
            celebrationSound.play();

            if(!isDoneUpdateXP) {

                isDoneUpdateXP = true;
                // Update XP and points
                fetch("{{ route('user.update_points') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({
                        user_activity_log_id: "{{ $user_activity_log_id }}",
                        activity_type: "flashcard",
                        xp_earned: xpEarned,
                        max_xp: maxXp,
                        points_earned: pointsEarned,
                        topic: "{{ $topic ?? 'Flashcard' }}", // Adjust if topic is dynamic
                        // file_name: "{{ '' }}" // Optional
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log("XP and points updated:", data);

                    const resultSummary = document.querySelector(".result-summary");

                    // Clear old feedback if needed
                    resultSummary.querySelectorAll(".xp-feedback").forEach(e => e.remove());

                    // XP & Points display
                    const xpElement = document.createElement("p");
                    xpElement.classList.add("xp-feedback");
                    xpElement.innerHTML = `<strong>XP Earned:</strong> ${xpEarned}/${maxXp} XP`;

                    const pointsElement = document.createElement("p");
                    pointsElement.classList.add("xp-feedback");
                    pointsElement.innerHTML = `<strong>Points:</strong> +${pointsEarned}`; 

                    resultSummary.appendChild(xpElement);
                    resultSummary.appendChild(pointsElement);

                    // Level Progress display
                    const progressPercent = Math.min(
                        Math.round((data.xp / (data.xp + data.xp_to_next_level)) * 100), 100
                    );

                    const nextLvlXp = data.xp + data.xp_to_next_level;
                    const currentLvlXp = nextLvlXp - (100 * (data.level - 1) * data.level / 2);

                    const levelContainer = document.createElement("div");
                    levelContainer.classList.add("d-flex", "align-items-center", "justify-content-between", "mt-3", "xp-feedback");

                    levelContainer.className = "row mt-3 xp-feedback align-items-center";

                    levelContainer.innerHTML = `
                        <!-- Column 1: Label -->
                        <div class="col-12 col-md-3 fw-bold mb-2 mb-md-0">
                            Level Progress:
                        </div>

                        <!-- Column 2: Full progress bar with level values -->
                        <div class="col-12 col-md-9 d-flex align-items-center gap-2">
                            <span>Lvl ${formatNumber(data.level)} (${formatNumber(currentLvlXp)} XP)</span>
                            <div class="progress flex-grow-1 mx-2" style="height: 20px; min-width: 150px;">
                                <div class="progress-bar bg-success progress-bar-striped" 
                                    role="progressbar" 
                                    style="width: ${progressPercent}%;" 
                                    aria-valuenow="${progressPercent}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                    ${progressPercent}% (${formatNumber(data.xp)} XP)
                                </div>
                            </div>
                            <span>Lvl ${formatNumber(data.next_level)} (${formatNumber(nextLvlXp)} XP)</span>
                        </div>
                    `;
                    resultSummary.appendChild(levelContainer);
                })
                .catch(error => {
                    console.error("Error updating points:", error);
                });
            }
            
            // Show the modal
            const resultModal = new bootstrap.Modal(document.getElementById('flashcardResultModal'));
            resultModal.show();
        }
        
        // Restart session button
        document.getElementById('restart-session').addEventListener('click', function() {
            location.reload();
        });

        function formatNumber(n) {
            if (n >= 1e9) return (n / 1e9).toFixed(1).replace(/\.0$/, '') + 'b';
            if (n >= 1e6) return (n / 1e6).toFixed(1).replace(/\.0$/, '') + 'm';
            if (n >= 1e3) return (n / 1e3).toFixed(1).replace(/\.0$/, '') + 'k';
            return n;
        }

        // Create confetti animation
        function createConfetti() {
            const colors = ['#f44336', '#e91e63', '#9c27b0', '#673ab7', '#3f51b5', '#2196f3', '#03a9f4', '#00bcd4', '#009688', '#4CAF50', '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800', '#FF5722'];
            
            for (let i = 0; i < 100; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
                confetti.style.animationDelay = Math.random() * 5 + 's';
                document.body.appendChild(confetti);
                
                // Remove confetti after animation
                setTimeout(() => {
                    confetti.remove();
                }, 8000);
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // If a modal is open, don't process keyboard shortcuts
            if (document.querySelector('.modal.show')) return;
            
            switch(e.key) {
                case ' ': // Space key to flip card
                    e.preventDefault();
                    document.querySelector(`#flip-card-inner-${currentFlashcardIndex}`).classList.toggle('flipped');
                    break;
                case 'ArrowRight': // Right arrow for next card
                    if (currentFlashcardIndex < totalFlashcards - 1) {
                        const nextBtn = document.querySelector(`#flashcard-${currentFlashcardIndex} .next-btn`);
                        if (nextBtn) nextBtn.click();
                    }
                    break;
                case 'ArrowLeft': // Left arrow for previous card
                    if (currentFlashcardIndex > 0) {
                        const prevBtn = document.querySelector(`#flashcard-${currentFlashcardIndex} .prev-btn`);
                        if (prevBtn) prevBtn.click();
                    }
                    break;
                case 'k':
                case 'K': // K key to toggle "Mark as Known"
                    const checkbox = document.getElementById(`mark-known-${currentFlashcardIndex}`);
                    if (checkbox) checkbox.checked = !checkbox.checked;
                    break;
                case 'm':
                case 'M': // M key to toggle music
                    musicToggleBtn.click();
                    break;
                case 's':
                case 'S': // S key to swipe to next card with touch simulation
                    if (currentFlashcardIndex < totalFlashcards - 1) {
                        simulateSwipe('left');
                    }
                    break;
                case 'a':
                case 'A': // A key to swipe to previous card with touch simulation
                    if (currentFlashcardIndex > 0) {
                        simulateSwipe('right');
                    }
                    break;
            }
        });
        
        // Function to simulate swipe
        function simulateSwipe(direction) {
            if (direction === 'left' && currentFlashcardIndex < totalFlashcards - 1) {
                document.querySelector(`#flashcard-${currentFlashcardIndex} .next-btn`).click();
            } else if (direction === 'right' && currentFlashcardIndex > 0) {
                document.querySelector(`#flashcard-${currentFlashcardIndex} .prev-btn`).click();
            }
        }

        // Start the flashcard session
        if (totalFlashcards > 0) {
            startTimer();
            updateProgress();
        }

        // Add pulse animation to keyboard shortcut badge
        setInterval(() => {
            shortcutBadge.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                shortcutBadge.classList.remove('animate__animated', 'animate__pulse');
            }, 1000);
        }, 5000);

        // Confirm before leaving the page
        window.addEventListener('beforeunload', function (e) {
            e.preventDefault();
            e.returnValue = 'Your flashcard progress will be lost. Are you sure you want to leave?';
        });
    });
</script>

<!-- CSS animations for confetti -->
<style>
    .confetti {
        animation: confetti-fall 8s ease-in forwards;
        transform: rotate(0deg);
    }
    
    @keyframes confetti-fall {
        0% {
            transform: translateY(0) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(100vh) rotate(720deg);
            opacity: 0;
        }
    }
</style>

<!--typed js-->
<script src="{{ asset('assets/vendor/typed/typed.umd.js') }}"></script>

<!--customizer-->
<div id="customizer"></div>