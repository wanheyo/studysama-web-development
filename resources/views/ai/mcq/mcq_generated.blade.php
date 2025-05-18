@extends('layout.master')
@section('title', 'AI MCQ Quiz Generator')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">{{ $title ?? 'StudySama Quiz' }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="{{ route('ai.mcq') }}" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone ph-star-four f-s-16"></i> StudySama AI
                            </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('ai.mcq') }}" class="f-s-14 f-w-500">
                            <span>MCQ Quiz</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">MCQ Quiz - {{ $title ?? 'StudySama Quiz' }}</a>
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
                            <i class="ti ti-brain me-2"></i>{{ $title ?? 'StudySama Quiz' }}
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

                        @if(!empty($questions))
                            <div class="quiz-stats mb-4 d-flex justify-content-between">
                                <div class="progress w-100 mt-2">
                                    <div id="quiz-progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                                </div>
                                <span class="ms-3 badge bg-info p-2">
                                    <span id="current-question">1</span>/<span id="total-questions">{{ count($questions) }}</span>
                                </span>
                            </div>

                            <div class="quiz-container">
                                @foreach($questions as $index => $question)
                                    <div class="question-card" id="question-{{ $index }}" style="{{ $index > 0 ? 'display: none;' : '' }}">
                                        <div class="question-header mb-3">
                                            <h4 class="card-title">Question {{ $index + 1 }}</h4>
                                            <p class="fw-bold">{{ $question['question'] }}</p>
                                        </div>
                                        
                                        <div class="options-container">
                                            @foreach($question['options'] as $optionIndex => $option)
                                                <div class="option-item mb-3">
                                                    <div class="form-check">
                                                        <label class="form-check form-check-label w-100">
                                                            <input 
                                                                class="form-check-input question-option me-2" 
                                                                type="radio" 
                                                                name="user_answers[{{ $index }}]" 
                                                                value="{{ $optionIndex }}"
                                                                data-question="{{ $index }}"
                                                            >
                                                            {{ $option }}
                                                        </label>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="navigation-buttons d-flex justify-content-between mt-4">
                                            @if($index > 0)
                                                <button type="button" class="btn btn-secondary prev-btn" data-question="{{ $index }}">
                                                    <i class="ti ti-arrow-left me-1"></i>Previous
                                                </button>
                                            @else
                                                <div></div>
                                            @endif
                                            
                                            @if($index < count($questions) - 1)
                                                <button type="button" class="btn btn-primary next-btn" data-question="{{ $index }}">
                                                    Next<i class="ti ti-arrow-right ms-1"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-success" id="finish-quiz">
                                                    <i class="ti ti-check me-1"></i>Finish Quiz
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Hidden form to store quiz data -->
                            <form id="quiz-data-form">
                                @csrf
                                <input type="hidden" name="quiz_time" id="quiz-time-input" value="0">
                                <input type="hidden" name="topic" value="{{ $topic ?? 'Quiz' }}">
                                
                                @foreach($questions as $index => $question)
                                    <input type="hidden" name="questions[{{ $index }}]" value="{{ $question['question'] }}">
                                    
                                    @foreach($question['options'] as $optionIndex => $option)
                                        <input type="hidden" name="options[{{ $index }}][{{ $optionIndex }}]" value="{{ $option }}">
                                    @endforeach
                                    
                                    <input type="hidden" name="correct_answers[{{ $index }}]" value="{{ $question['answer'] }}">
                                @endforeach
                            </form>
                        @else
                            <div class="alert alert-info">
                                <p>No questions were generated. Please try again with a different topic.</p>
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
        <div class="modal fade" id="quizResultModal" tabindex="-1" aria-labelledby="quizResultModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="quizResultModalLabel">Quiz Results</h5>
                        <button aria-label="Close" class="btn-close m-0" data-bs-dismiss="modal" type="button"></button>
                        {{-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="result-summary text-center mb-4">
                            <h3>Your Score</h3>
                            <div class="score-circle mx-auto mb-3">
                                <span id="score-percentage">0%</span>
                            </div>
                            <p>You answered <span id="correct-count">0</span> out of <span id="total-count">{{ count($questions ?? []) }}</span> questions correctly</p>
                            <p>Time taken: <span id="time-taken">00:00</span></p>
                        </div>
                        
                        <div class="accordion" id="resultAccordion">
                            @if(!empty($questions))
                                @foreach($questions as $index => $question)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-{{ $index }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}" aria-expanded="false" aria-controls="collapse-{{ $index }}">
                                                Question {{ $index + 1 }}
                                                <span class="ms-auto result-icon" id="result-icon-{{ $index }}"></span>
                                            </button>
                                        </h2>
                                        <div id="collapse-{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $index }}" data-bs-parent="#resultAccordion">
                                            <div class="accordion-body">
                                                <p class="fw-bold">{{ $question['question'] }}</p>
                                                
                                                <div class="options-result">
                                                    @foreach($question['options'] as $optionIndex => $option)
                                                        <div class="option-item" id="result-q{{ $index }}-option{{ $optionIndex }}">
                                                            {{ $option }}
                                                            @if($optionIndex == $question['answer'])
                                                                <span class="correct-answer-icon ms-2">
                                                                    <i class="ti ti-check-circle text-success"></i>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                                
                                                <div class="explanation mt-3" id="explanation-{{ $index }}">
                                                    <span class="fw-bold">Correct Answer:</span> 
                                                    {{ $question['options'][$question['answer']] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('ai.mcq') }}" class="btn btn-secondary">
                            <i class="ti ti-home me-1"></i>Return Home
                        </a>
                        {{-- <a href="{{ route('ai.mcq') }}" class="btn btn-primary">
                            <i class="ti ti-refresh me-1"></i>Try Another Quiz
                        </a> --}}
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
    
    .score-circle {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: conic-gradient(var(--bs-primary) 0%, #f0f0f0 0%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: bold;
        color: var(--bs-primary);
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        position: relative;
        z-index: 1;
    }
    
    .score-circle::after {
        content: '';
        position: absolute;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: white;
        z-index: -1;
    }
    
    .options-result .option-item {
        cursor: default;
    }
    
    .options-result .selected-option {
        background-color: rgba(var(--bs-danger-rgb), 0.1);
        border-color: var(--bs-danger);
    }
    
    .options-result .correct-option {
        background-color: rgba(var(--bs-success-rgb), 0.1);
        border-color: var(--bs-success);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .result-icon {
        margin-left: 10px;
        font-size: 18px;
    }

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

    .swal2-toast {
        width: auto !important;
        max-width: 100% !important;
        padding: 0.625em !important;
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

        let totalSeconds = 0;
        let timerInterval;
        const minutesDisplay = document.getElementById('minutes');
        const secondsDisplay = document.getElementById('seconds');
        const quizTimeInput = document.getElementById('quiz-time-input');
        
        function startTimer() {
            timerInterval = setInterval(function() {
                totalSeconds++;
                const minutes = Math.floor(totalSeconds / 60);
                const seconds = totalSeconds % 60;
                
                minutesDisplay.textContent = minutes < 10 ? '0' + minutes : minutes;
                secondsDisplay.textContent = seconds < 10 ? '0' + seconds : seconds;
                
                quizTimeInput.value = totalSeconds;
            }, 1000);
        }
        
        function stopTimer() {
            clearInterval(timerInterval);
        }
        
        // Quiz navigation
        const totalQuestions = {{ count($questions ?? []) }};
        const progressBar = document.getElementById('quiz-progress-bar');
        const currentQuestionDisplay = document.getElementById('current-question');
        let currentQuestionIndex = 0;
        
        function updateProgress() {
            const progress = ((currentQuestionIndex + 1) / totalQuestions) * 100;
            progressBar.style.width = progress + '%';
            currentQuestionDisplay.textContent = currentQuestionIndex + 1;
        }

        // Background music control
        const musicToggleBtn = document.getElementById('toggle-music');
        const musicText = document.getElementById('music-text');
        const backgroundMusic = document.getElementById('background-music');
        
        musicToggleBtn.addEventListener('click', function() {
            if (backgroundMusic.paused) {
                backgroundMusic.volume = 0.5; // Set volume to 50%
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
        
        function showQuestion(index) {
            // Hide all questions
            document.querySelectorAll('.question-card').forEach(card => {
                card.style.display = 'none';
            });
            
            // Show the selected question
            document.getElementById('question-' + index).style.display = 'block';
            currentQuestionIndex = index;
            updateProgress();
        }
        
        // Next button click handler
        document.querySelectorAll('.next-btn').forEach(button => {
            button.addEventListener('click', function() {
                const currentQuestion = parseInt(this.getAttribute('data-question'));
                showQuestion(currentQuestion + 1);
            });
        });
        
        // Previous button click handler
        document.querySelectorAll('.prev-btn').forEach(button => {
            button.addEventListener('click', function() {
                const currentQuestion = parseInt(this.getAttribute('data-question'));
                showQuestion(currentQuestion - 1);
            });
        });
        
        // Handle radio button selection
        document.querySelectorAll('.question-option').forEach(option => {
            option.addEventListener('change', function() {
                const questionIndex = parseInt(this.getAttribute('data-question'));
                const optionValue = this.value;
                
                // Store the user's answer (no need to re-select as it's already selected)
            });
        });
        
        // Finish quiz button
        const finishQuizButton = document.getElementById('finish-quiz');
        if (finishQuizButton) {
            
            finishQuizButton.addEventListener('click', function() {

                const questions = document.querySelectorAll('.options-container');
                let allAnswered = true;

                questions.forEach(function (question) {
                    const radios = question.querySelectorAll('.question-option');
                    const isChecked = Array.from(radios).some(radio => radio.checked);

                    if (!isChecked) {
                        allAnswered = false;
                        question.classList.add('border', 'border-danger', 'p-3', 'rounded');
                    } else {
                        question.classList.remove('border', 'border-danger', 'p-3', 'rounded');
                    }
                });

                if (!allAnswered) {
                    alert('Please answer all questions before submitting.');
                    return;
                }

                // If all questions are answered, proceed
                document.querySelectorAll('.question-option').forEach(function(radio) {
                    radio.disabled = true;
                });
                stopTimer();
                showResults();
            });
        }
        
        // Calculate and show results
        function showResults() {
            let correctCount = 0;
            const userAnswers = [];
            const correctAnswers = [];
            
            // Collect all answers
            document.querySelectorAll('input[name^="user_answers"]').forEach(input => {
                if (input.checked) {
                    const questionIndex = input.name.match(/\d+/)[0];
                    userAnswers[questionIndex] = parseInt(input.value);
                }
            });
            
            // Collect all correct answers
            document.querySelectorAll('input[name^="correct_answers"]').forEach(input => {
                const questionIndex = input.name.match(/\d+/)[0];
                correctAnswers[questionIndex] = parseInt(input.value);
            });
            
            // Calculate score
            for (let i = 0; i < totalQuestions; i++) {
                const resultIcon = document.getElementById(`result-icon-${i}`);
                if (!resultIcon) continue;
                
                if (userAnswers[i] !== undefined) {
                    // Mark selected option
                    const selectedOptionElement = document.getElementById(`result-q${i}-option${userAnswers[i]}`);
                    if (selectedOptionElement) {
                        selectedOptionElement.classList.add('selected-option');
                    }
                    
                    // Check if correct
                    if (userAnswers[i] === correctAnswers[i]) {
                        correctCount++;
                        resultIcon.innerHTML = '<i class="ti ti-check text-success"></i>';
                        if (selectedOptionElement) {
                            selectedOptionElement.classList.add('correct-option');
                            selectedOptionElement.classList.remove('selected-option');
                        }
                    } else {
                        resultIcon.innerHTML = '<i class="ti ti-x text-danger"></i>';
                        // Also highlight the correct option
                        const correctOptionElement = document.getElementById(`result-q${i}-option${correctAnswers[i]}`);
                        if (correctOptionElement) {
                            correctOptionElement.classList.add('correct-option');
                        }
                    }
                } else {
                    // Not answered
                    resultIcon.innerHTML = '<i class="ti ti-minus text-warning"></i>';
                    // Highlight the correct option
                    const correctOptionElement = document.getElementById(`result-q${i}-option${correctAnswers[i]}`);
                    if (correctOptionElement) {
                        correctOptionElement.classList.add('correct-option');
                    }
                }
            }
            
            // Update score display
            const scorePercentage = Math.round((correctCount / totalQuestions) * 100);
            const scorePercentageElement = document.getElementById('score-percentage');
            if (scorePercentageElement) {
                scorePercentageElement.textContent = scorePercentage + '%';
            }
            
            const correctCountElement = document.getElementById('correct-count');
            if (correctCountElement) {
                correctCountElement.textContent = correctCount;
            }
            
            // Update score circle
            const scoreCircle = document.querySelector('.score-circle');
            if (scoreCircle) {
                scoreCircle.style.background = `conic-gradient(var(--bs-primary) ${scorePercentage}%, #f0f0f0 0%)`;
            }
            
            // Update time taken
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;
            const formattedTime = `${minutes < 10 ? '0' + minutes : minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
            
            const timeTakenElement = document.getElementById('time-taken');
            if (timeTakenElement) {
                timeTakenElement.textContent = formattedTime;
            }

            // Show celebration confetti
            createConfetti();
            
            // Play celebration sound
            const celebrationSound = new Audio("{{ asset('assets/audio/success_2.mp3') }}");
            celebrationSound.volume = 0.5;
            celebrationSound.play();
            
            // Show the modal
            const resultModal = new bootstrap.Modal(document.getElementById('quizResultModal'));
            resultModal.show();
        }
        
        // Start the quiz
        if (totalQuestions > 0) {
            startTimer();
            updateProgress();
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
    });

    window.addEventListener('beforeunload', function (e) {
        e.preventDefault(); // Modern browsers ignore this, but still required
        e.returnValue = 'The question will be reset, and your progress will be lost.';
    });
</script>

<!--typed js-->
<script src="{{ asset('assets/vendor/typed/typed.umd.js') }}"></script>

<!--customizer-->
<div id="customizer"></div>

@endsection
