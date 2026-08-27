@extends('layouts.app')

@section('title', $stall->name . ' — ArihantPLUS')

@push('styles')
    <style>
        .stall-show-page {
            min-height: 100vh;
            padding: 70px 24px 60px;
            background: var(--bg);
        }

        .stall-show-wrap {
            max-width: 900px;
            margin: 0 auto;
        }

        .stall-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 28px;
        }

        .stall-top h1 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .stall-top p {
            color: var(--muted);
            font-size: 14px;
            margin: 0;
            line-height: 1.6;
        }

        .visited-badge {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 13px;
            border-radius: 999px;
            background: rgba(40, 180, 100, 0.12);
            border: 1px solid rgba(40, 180, 100, 0.22);
            color: #8ff0b3;
            font-size: 11px;
            font-weight: 700;
        }

        .stall-card {
            background: linear-gradient(160deg,
                    rgba(22, 12, 30, 0.94) 0%,
                    rgba(8, 4, 12, 0.98) 100%);

            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 20px;
            padding: 26px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .section-description {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 24px;
        }

        .question {
            padding: 20px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .question:first-child {
            padding-top: 0;
        }

        .question:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .question-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 14px;
            line-height: 1.6;
        }

        .question-number {
            color: var(--purple-1);
            margin-right: 5px;
        }

        .option {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 13px;
            margin-bottom: 9px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.025);
            cursor: pointer;
            transition: .2s ease;
        }

        .option:hover {
            border-color: rgba(184, 102, 247, 0.4);
            background: rgba(184, 102, 247, 0.06);
        }

        .option input {
            accent-color: var(--purple-1);
        }

        .option span {
            font-size: 13px;
            color: #ded7e6;
        }

        .feedback-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .field-label {
            display: block;
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .rating-options {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .rating-option {
            position: relative;
        }

        .rating-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .rating-option label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 40px;
            padding: 0 12px;
            border-radius: 9px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
            color: #ded7e6;
            font-size: 13px;
            cursor: pointer;
            transition: .2s ease;
        }

        .rating-option input:checked+label {
            border-color: rgba(184, 102, 247, 0.6);
            background: rgba(184, 102, 247, 0.15);
            color: var(--purple-1);
        }

        .feedback-textarea {
            width: 100%;
            min-height: 120px;
            resize: vertical;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.09);
            background: rgba(255, 255, 255, 0.035);
            color: var(--ink);
            outline: none;
            font-size: 13px;
        }

        .feedback-textarea:focus {
            border-color: rgba(184, 102, 247, 0.5);
        }

        .submit-area {
            display: flex;
            justify-content: flex-end;
            margin-top: 22px;
        }

        .submit-btn {
            border: 0;
            padding: 12px 22px;
            border-radius: 11px;
            background: var(--purple-1);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s ease;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            opacity: .92;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--purple-1);
            text-decoration: none;
            font-size: 13px;
            margin-bottom: 25px;
        }

        .back-link:hover {
            color: var(--purple-1);
        }

        .already-submitted {
            padding: 15px;
            border-radius: 10px;
            background: rgba(40, 180, 100, 0.08);
            border: 1px solid rgba(40, 180, 100, 0.18);
            color: #8ff0b3;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .no-quiz {
            padding: 25px 10px;
            text-align: center;
            color: var(--muted);
            font-size: 13px;
        }

        @media (max-width: 640px) {
            .stall-show-page {
                padding: 45px 16px 50px;
            }

            .stall-top {
                flex-direction: column;
            }

            .stall-top h1 {
                font-size: 27px;
            }

            .stall-card {
                padding: 20px;
            }

            .submit-area {
                justify-content: stretch;
            }

            .submit-btn {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')

    <div class="stall-show-page">

        <div class="stall-show-wrap">

            <a
                href="{{ route('admin.stalls.visits.index', $stall) }}"
                class="btn btn-primary"
            >
                View Visits & Responses
                @if(isset($visit_count))
                    ({{ $visit_count }})
                @endif
            </a>
            <a href="{{ route('stalls.index') }}" class="back-link">
                ← Back to Stalls
            </a>

            {{-- Stall Header --}}
            <div class="stall-top">

                <div>

                    <h1>{{ $stall->name }}</h1>

                    @if($stall->description)

                        <p>
                            {{ $stall->description }}
                        </p>

                    @endif

                    @if($stall->location)

                        <p style="margin-top:6px;">
                            <i class="fas fa-location-dot"></i>
                            {{ $stall->location }}
                        </p>

                    @endif

                </div>

                <span class="visited-badge">
                    ✓ Stall Visited
                </span>

            </div>

            @if(session('success'))

                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>

            @endif

            @if($errors->any())

                <div class="alert alert-error mb-4">

                    Please correct the highlighted information.

                </div>

            @endif

            <form method="POST" action="{{ route('stalls.submit', $stall) }}">

                @csrf

                {{-- Quiz --}}
                <div class="stall-card">

                    <div class="section-title">
                        Stall Quiz
                    </div>

                    <div class="section-description">
                        Answer the questions below to earn additional engagement points.
                    </div>

                    @if($stall->activeQuiz && $stall->activeQuiz->is_active)

                        @foreach($stall->activeQuiz->questions as $question)

                            <div class="question">

                                <div class="question-title">

                                    <span class="question-number">
                                        Q{{ $loop->iteration }}.
                                    </span>

                                    {{ $question->question }}

                                </div>

                                @foreach($question->options as $option)

                                    <label class="option">

                                        <input type="radio" name="quiz_answers[{{ $question->id }}]" value="{{ $option->id }}" @if(
                                            $visit->quizAnswers->contains(fn($answer) =>
                                                $answer->stall_quiz_question_id == $question->id
                                                && $answer->stall_quiz_option_id == $option->id
                                            )
                                        ) checked @endif>

                                        <span>
                                            {{ $option->option_text }}
                                        </span>

                                    </label>

                                @endforeach

                            </div>

                        @endforeach

                    @else

                        <div class="no-quiz">
                            No quiz is available for this stall.
                        </div>

                    @endif

                </div>

                {{-- Feedback --}}
                <div class="stall-card">

                    <div class="section-title">
                        Your Feedback
                    </div>

                    <div class="section-description">
                        Tell us about your experience at this stall.
                    </div>

                    <div class="feedback-grid">

                        {{-- Rating --}}
                        @forelse($stall->activeFeedbackQuestions as $question)
                            @php
                                $response = $visit->feedbackResponses->firstWhere('stall_feedback_question_id', $question->id);
                                $answer = $response?->answer;
                                $selectedAnswers = is_string($answer) ? json_decode($answer, true) : $answer;
                            @endphp
                            <div>
                                <label class="field-label">
                                    {{ $question->question }}{{ $question->is_required ? ' *' : '' }}
                                </label>

                                @if($question->type === 'text')
                                    <textarea name="feedback_answers[{{ $question->id }}]" class="feedback-textarea" maxlength="1000">{{ $answer }}</textarea>
                                @elseif($question->type === 'rating')
                                    <div class="rating-options">
                                        @for($rating = 1; $rating <= 5; $rating++)
                                            <div class="rating-option">
                                                <input type="radio" id="feedback-{{ $question->id }}-{{ $rating }}" name="feedback_answers[{{ $question->id }}]" value="{{ $rating }}" @checked((string) $answer === (string) $rating)>
                                                <label for="feedback-{{ $question->id }}-{{ $rating }}">{{ $rating }}</label>
                                            </div>
                                        @endfor
                                    </div>
                                @else
                                    @foreach($question->options as $option)
                                        <label class="option">
                                            <input type="{{ $question->type === 'multiple_choice' ? 'checkbox' : 'radio' }}" name="feedback_answers[{{ $question->id }}]{{ $question->type === 'multiple_choice' ? '[]' : '' }}" value="{{ $option->id }}" @checked($question->type === 'multiple_choice' ? is_array($selectedAnswers) && in_array($option->id, $selectedAnswers) : (string) $answer === (string) $option->id)>
                                            <span>{{ $option->option_text }}</span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        @empty
                            <div class="no-quiz">No feedback questions are available for this stall.</div>
                        @endforelse

                    </div>

                </div>

                {{-- Submit --}}
                <div class="submit-area">

                    <button type="submit" class="submit-btn">
                        Submit Quiz & Feedback
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection