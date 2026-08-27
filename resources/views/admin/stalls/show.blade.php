@extends('layouts.app')

@section('title', $stall->name . ' — Stall')

@push('styles')
    <style>
        .admin-page {
            min-height: 100vh;
            padding: 40px 24px 70px;
            background: var(--bg-soft);
        }

        .admin-wrap {
            max-width: 1200px;
            margin: 0 auto;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 28px;
        }

        .admin-header h1 {
            font-size: 30px;
            margin-bottom: 6px;
        }

        .admin-header p {
            color: var(--muted);
            font-size: 14px;
            margin: 0;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .admin-card {
            background: linear-gradient(160deg,
                    rgba(22, 12, 30, 0.9),
                    rgba(8, 4, 12, 0.96));
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 22px;
        }

        .card-header {
            padding: 20px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .card-header h2 {
            margin: 0;
            font-size: 18px;
        }

        .card-header p {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .card-body {
            padding: 22px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .info-item label {
            display: block;
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 6px;
        }

        .info-item div {
            color: var(--ink);
            font-size: 14px;
        }

        .description {
            margin-top: 20px;
        }

        .description label {
            display: block;
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 7px;
        }

        .description-text {
            color: #ded7e6;
            font-size: 14px;
            line-height: 1.7;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-active {
            background: rgba(40, 180, 100, 0.12);
            color: #8ff0b3;
            border: 1px solid rgba(40, 180, 100, 0.22);
        }

        .badge-inactive {
            background: rgba(255, 180, 70, 0.1);
            color: #ffd08a;
            border: 1px solid rgba(255, 180, 70, 0.2);
        }

        .qr-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: center;
        }

        .qr-preview {
            text-align: center;
        }

        .qr-preview img {
            width: 100%;
            max-width: 300px;
            padding: 12px;
            background: #08040c;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 16px;
        }

        .qr-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 15px;
        }

        .token-box {
            margin-top: 15px;
        }

        .token-box label {
            display: block;
            color: var(--muted);
            font-size: 11px;
            margin-bottom: 7px;
            text-transform: uppercase;
        }

        .token-input {
            display: flex;
        }

        .token-input input {
            flex: 1;
            min-width: 0;
            padding: 11px 12px;
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 9px 0 0 9px;
            background: rgba(255, 255, 255, .04);
            color: #ddd;
            outline: none;
            font-size: 12px;
        }

        .token-input button {
            border-radius: 0 9px 9px 0;
        }

        .btn-small {
            padding: 8px 12px !important;
            font-size: 12px !important;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 7px;
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 11px 13px;
            border-radius: 9px;
            border: 1px solid rgba(255, 255, 255, .1);
            background: rgba(255, 255, 255, .04);
            color: var(--ink);
            outline: none;
            font-size: 13px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(184, 102, 247, .55);
        }

        textarea.form-control {
            min-height: 90px;
            resize: vertical;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ded7e6;
            font-size: 13px;
        }

        .quiz-question {
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 14px;
            margin-bottom: 14px;
            overflow: hidden;
        }

        .question-header {
            padding: 15px 17px;
            background: rgba(255, 255, 255, .025);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
        }

        .question-title {
            color: var(--ink);
            font-size: 14px;
            font-weight: 600;
            line-height: 1.5;
        }

        .question-meta {
            color: var(--muted);
            font-size: 11px;
            margin-top: 5px;
        }

        .question-body {
            padding: 15px 17px;
        }

        .option-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 11px;
            border: 1px solid rgba(255, 255, 255, .06);
            border-radius: 8px;
            margin-bottom: 7px;
            color: #ded7e6;
            font-size: 13px;
        }

        .option-correct {
            border-color: rgba(40, 180, 100, .3);
            background: rgba(40, 180, 100, .06);
        }

        .correct-label {
            margin-left: auto;
            color: #8ff0b3;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .question-actions {
            display: flex;
            gap: 7px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 10px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, .1);
            background: rgba(255, 255, 255, .04);
            color: #e9defa;
            font-size: 11px;
            cursor: pointer;
            transition: .2s ease;
        }

        .action-btn:hover {
            border-color: rgba(184, 102, 247, .55);
            background: rgba(184, 102, 247, .12);
        }

        .action-delete:hover {
            border-color: rgba(255, 90, 90, .5);
            background: rgba(255, 80, 80, .1);
            color: #ffaaaa;
        }

        .feedback-item {
            padding: 15px 17px;
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 13px;
            margin-bottom: 12px;
        }

        .feedback-question {
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
        }

        .feedback-meta {
            color: var(--muted);
            font-size: 11px;
            margin-top: 5px;
        }

        .feedback-options {
            margin-top: 12px;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-state h3 {
            margin-bottom: 7px;
            font-size: 17px;
        }

        .empty-state p {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 18px;
        }

        .section-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .alert {
            margin-bottom: 20px;
        }

        .error-list {
            color: #ffaaaa;
            font-size: 12px;
            margin: 8px 0 0;
            padding-left: 18px;
        }

        @media (max-width: 800px) {

            .qr-layout,
            .info-grid,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .admin-page {
                padding: 28px 16px 50px;
            }

            .admin-header {
                flex-direction: column;
            }

            .header-actions {
                width: 100%;
            }

            .header-actions .btn {
                flex: 1;
            }
        }
    </style>
@endpush

@section('content')

    <div class="admin-page">
        <div class="admin-wrap">

            {{-- Header --}}
            <div class="admin-header">
                <div>
                    <h1>{{ $stall->name }}</h1>
                    <p>
                        Manage stall information, QR code, quiz and feedback.
                    </p>
                </div>

                <div class="header-actions">
                    <a href="{{ route('admin.stalls.index') }}" class="btn btn-light">
                        ← Back
                    </a>
                    
                    <a
                        href="{{ route('admin.stalls.visits.index', $stall) }}"
                        class="btn btn-primary"
                    >
                        View Visits & Responses
                        @if(isset($visit_count))
                            ({{ $visit_count }})
                        @endif
                    </a>

                    <a href="{{ route('admin.stalls.edit', $stall) }}" class="btn btn-primary">
                        Edit Stall
                    </a>
                </div>
            </div>

            {{-- Messages --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <strong>Please fix the following:</strong>

                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ========================================================= --}}
            {{-- STALL INFORMATION --}}
            {{-- ========================================================= --}}

            <div class="admin-card">
                <div class="card-header">
                    <div>
                        <h2>Stall Information</h2>
                        <p>Basic information about this stall.</p>
                    </div>
                </div>

                <div class="card-body">

                    <div class="info-grid">

                        <div class="info-item">
                            <label>Name</label>
                            <div>{{ $stall->name }}</div>
                        </div>

                        <div class="info-item">
                            <label>Slug</label>
                            <div>{{ $stall->slug }}</div>
                        </div>

                        <div class="info-item">
                            <label>Location</label>
                            <div>{{ $stall->location ?: '—' }}</div>
                        </div>

                        <div class="info-item">
                            <label>Status</label>

                            @if($stall->is_active)
                                <span class="badge badge-active">
                                    Active
                                </span>
                            @else
                                <span class="badge badge-inactive">
                                    Inactive
                                </span>
                            @endif
                        </div>

                    </div>

                    <div class="description">
                        <label>Description</label>

                        <div class="description-text">
                            @if($stall->description)
                                {!! nl2br(e($stall->description)) !!}
                            @else
                                <span style="color:var(--muted)">
                                    No description available.
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- QR --}}
            {{-- ========================================================= --}}

            <div class="admin-card">
                <div class="card-header">
                    <div>
                        <h2>Stall QR Code</h2>
                        <p>Unique QR code for this stall.</p>
                    </div>
                </div>

                <div class="card-body">

                    <div class="qr-layout">

                        <div class="qr-preview">

                            @if($stall->qr_image_path)

                                <img src="{{ Storage::url($stall->qr_image_path) }}" alt="{{ $stall->name }} QR Code">

                                <div class="qr-actions">

                                    <a href="{{ Storage::url($stall->qr_image_path) }}" target="_blank"
                                        class="btn btn-light btn-small">
                                        Open QR
                                    </a>

                                    <a href="{{ Storage::url($stall->qr_image_path) }}"
                                        download="stall-{{ $stall->slug }}-qr.png" class="btn btn-primary btn-small">
                                        Download QR
                                    </a>

                                </div>

                            @else

                                <div class="empty-state">
                                    <h3>No QR Code</h3>
                                    <p>
                                        QR code has not been generated yet.
                                    </p>
                                </div>

                            @endif

                        </div>

                        <div>

                            @if($stall->qr_token)

                                <div class="token-box">

                                    <label>QR Token</label>

                                    <div class="token-input">

                                        <input id="qr-token" type="text" value="{{ $stall->qr_token }}" readonly>

                                        <button type="button" class="btn btn-light btn-small" onclick="copyQrToken()">
                                            Copy
                                        </button>

                                    </div>

                                </div>

                            @endif

                            <div style="margin-top:20px;color:var(--muted);font-size:13px;line-height:1.7">
                                This QR code uniquely identifies
                                <strong style="color:var(--ink)">
                                    {{ $stall->name }}
                                </strong>.
                                Participant visit tracking will be connected
                                to this QR in the next stage.
                            </div>

                        </div>

                    </div>

                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- QUIZ --}}
            {{-- ========================================================= --}}

            <div class="admin-card">

                <div class="card-header">

                    <div>
                        <h2>Stall Quiz</h2>
                        <p>
                            Create questions, options and define the correct answer.
                        </p>
                    </div>

                </div>

                <div class="card-body">

                    @php
                        $quiz = $stall->quizzes->first();
                    @endphp

                    {{-- Quiz doesn't exist --}}
                    @if(!$quiz)

                        <form method="POST" action="{{ route('admin.stalls.quiz.store', $stall) }}">
                            @csrf

                            <div class="form-grid">

                                <div class="form-group">
                                    <label>Quiz Title *</label>

                                    <input type="text" name="title" class="form-control" placeholder="e.g. Test Your Knowledge"
                                        required>
                                </div>

                                <div class="form-group">

                                    <label>Status</label>

                                    <label class="checkbox-row">

                                        <input type="checkbox" name="is_active" value="1" checked>

                                        Active quiz

                                    </label>

                                </div>

                                <div class="form-group full">

                                    <label>Description</label>

                                    <textarea name="description" class="form-control"
                                        placeholder="Optional quiz description"></textarea>

                                </div>

                            </div>

                            <button class="btn btn-primary">
                                Create Quiz
                            </button>

                        </form>

                    @else

                        {{-- Quiz settings --}}
                        <form method="POST" action="{{ route('admin.stalls.quiz.update', $stall) }}" style="margin-bottom:30px">
                            @csrf
                            @method('PUT')

                            <div class="form-grid">

                                <div class="form-group">
                                    <label>Quiz Title *</label>

                                    <input type="text" name="title" class="form-control" value="{{ $quiz->title }}" required>
                                </div>

                                <div class="form-group">

                                    <label>Status</label>

                                    <label class="checkbox-row">

                                        <input type="checkbox" name="is_active" value="1" {{ $quiz->is_active ? 'checked' : '' }}>

                                        Active quiz

                                    </label>

                                </div>

                                <div class="form-group full">

                                    <label>Description</label>

                                    <textarea name="description" class="form-control">{{ $quiz->description }}</textarea>

                                </div>

                            </div>

                            <button class="btn btn-primary btn-small">
                                Save Quiz Settings
                            </button>

                        </form>

                        {{-- Existing questions --}}
                        <div style="margin-bottom:20px">

                            <h3 style="font-size:16px;margin-bottom:14px">
                                Quiz Questions
                            </h3>

                            @forelse($quiz->questions as $question)

                                <div class="quiz-question">

                                    <div class="question-header">

                                        <div>

                                            <div class="question-title">
                                                {{ $loop->iteration }}.
                                                {{ $question->question }}
                                            </div>

                                            <div class="question-meta">
                                                {{ $question->points }} points
                                                ·

                                                @if($question->is_active)
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </div>

                                        </div>

                                        <div class="question-actions">

                                            <button type="button" class="action-btn"
                                                onclick="toggleEditQuestion({{ $question->id }})">
                                                Edit
                                            </button>

                                            <form method="POST"
                                                action="{{ route('admin.stalls.quiz.questions.destroy', [$stall, $question]) }}"
                                                onsubmit="return confirm('Delete this question?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="action-btn action-delete">
                                                    Delete
                                                </button>
                                            </form>

                                        </div>

                                    </div>

                                    <div class="question-body">

                                        @foreach($question->options as $option)

                                            <div class="
                                                            option-row
                                                            {{ $option->is_correct ? 'option-correct' : '' }}
                                                        ">

                                                <span>
                                                    {{ chr(65 + $loop->index) }}.
                                                </span>

                                                <span>
                                                    {{ $option->option_text }}
                                                </span>

                                                @if($option->is_correct)
                                                    <span class="correct-label">
                                                        Correct Answer
                                                    </span>
                                                @endif

                                            </div>

                                        @endforeach

                                    </div>

                                    {{-- Edit question --}}
                                    <div id="edit-question-{{ $question->id }}"
                                        style="display:none;padding:20px;border-top:1px solid rgba(255,255,255,.07)">

                                        <form method="POST"
                                            action="{{ route('admin.stalls.quiz.questions.update', [$stall, $question]) }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-group">

                                                <label>Question</label>

                                                <textarea name="question" class="form-control"
                                                    required>{{ $question->question }}</textarea>

                                            </div>

                                            <div class="form-group">

                                                <label>Points</label>

                                                <input type="number" name="points" class="form-control"
                                                    value="{{ $question->points }}" min="1" required>

                                            </div>

                                            @foreach($question->options as $index => $option)

                                                <div class="form-group">

                                                    <label>
                                                        Option {{ chr(65 + $index) }}
                                                    </label>

                                                    <div style="display:flex;gap:10px;align-items:center">

                                                        <input type="text" name="options[{{ $index }}][text]"
                                                            value="{{ $option->option_text }}" class="form-control" required>

                                                        <label class="checkbox-row" style="white-space:nowrap">

                                                            <input type="radio" name="correct_option" value="{{ $index }}" {{ $option->is_correct ? 'checked' : '' }} required>

                                                            Correct

                                                        </label>

                                                    </div>

                                                </div>

                                            @endforeach

                                            <label class="checkbox-row" style="margin-bottom:15px">

                                                <input type="checkbox" name="is_active" value="1" {{ $question->is_active ? 'checked' : '' }}>

                                                Active question

                                            </label>

                                            <button class="btn btn-primary btn-small">
                                                Save Question
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            @empty

                                <div class="empty-state">

                                    <h3>No Questions Yet</h3>

                                    <p>
                                        Add the first question for this stall.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                        {{-- Add question --}}
                        <div style="
                                    border-top:1px solid rgba(255,255,255,.07);
                                    padding-top:25px;
                                ">

                            <h3 style="font-size:16px;margin-bottom:16px">
                                Add Question
                            </h3>

                            <form method="POST" action="{{ route('admin.stalls.quiz.questions.store', $stall) }}">
                                @csrf

                                <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

                                <div class="form-group">

                                    <label>Question *</label>

                                    <textarea name="question" class="form-control" placeholder="Enter question"
                                        required></textarea>

                                </div>

                                <div class="form-group">

                                    <label>Points *</label>

                                    <input type="number" name="points" class="form-control" value="10" min="1" required>

                                </div>

                                <div id="new-options" style="margin-bottom:18px">

                                    @for($i = 0; $i < 4; $i++)

                                        <div class="form-group">

                                            <label>
                                                Option {{ chr(65 + $i) }}
                                            </label>

                                            <input type="text" name="options[{{ $i }}][text]" class="form-control"
                                                placeholder="Enter option {{ chr(65 + $i) }}" required>

                                        </div>

                                    @endfor

                                </div>

                                <div class="form-group">

                                    <label>
                                        Correct Answer *
                                    </label>

                                    <select name="correct_option" class="form-select" required>

                                        <option value="" style="color: black;">
                                            Select correct option
                                        </option>

                                        <option value="0" style="color: black;">Option A</option>
                                        <option value="1" style="color: black;">Option B</option>
                                        <option value="2" style="color: black;">Option C</option>
                                        <option value="3" style="color: black;">Option D</option>

                                    </select>

                                </div>

                                <label class="checkbox-row" style="margin-bottom:18px">

                                    <input type="checkbox" name="is_active" value="1" checked>

                                    Active question

                                </label>

                                <button class="btn btn-primary">
                                    + Add Question
                                </button>

                            </form>

                        </div>

                    @endif

                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- FEEDBACK --}}
            {{-- ========================================================= --}}

            <div class="admin-card">

                <div class="card-header">

                    <div>
                        <h2>Stall Feedback</h2>
                        <p>
                            Create dynamic feedback questions for participants.
                        </p>
                    </div>

                </div>

                <div class="card-body">

                    @forelse($stall->feedbackQuestions as $question)

                        <div class="feedback-item">

                            <div style="display:flex;justify-content:space-between;gap:15px">

                                <div>

                                    <div class="feedback-question">
                                        {{ $loop->iteration }}.
                                        {{ $question->question }}
                                    </div>

                                    <div class="feedback-meta">

                                        Type:
                                        {{ str_replace('_', ' ', ucfirst($question->type)) }}

                                        ·

                                        {{ $question->is_required ? 'Required' : 'Optional' }}

                                        ·

                                        {{ $question->is_active ? 'Active' : 'Inactive' }}

                                    </div>

                                </div>

                                <div class="question-actions">

                                    <button type="button" class="action-btn" onclick="toggleEditFeedback({{ $question->id }})">
                                        Edit
                                    </button>

                                    <form method="POST"
                                        action="{{ route('admin.stalls.feedback.questions.destroy', [$stall, $question]) }}"
                                        onsubmit="return confirm('Delete this feedback question?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="action-btn action-delete">
                                            Delete
                                        </button>
                                    </form>

                                </div>

                            </div>

                            @if($question->options->count())

                                <div class="feedback-options">

                                    @foreach($question->options as $option)

                                        <div class="option-row">

                                            {{ $option->option_text }}

                                        </div>

                                    @endforeach

                                </div>

                            @endif

                            {{-- Edit feedback --}}
                            <div id="edit-feedback-{{ $question->id }}" style="display:none;margin-top:18px">

                                <form method="POST"
                                    action="{{ route('admin.stalls.feedback.questions.update', [$stall, $question]) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">

                                        <label>Question</label>

                                        <textarea name="question" class="form-control"
                                            required>{{ $question->question }}</textarea>

                                    </div>

                                    <div class="form-group">

                                        <label>Type</label>

                                        <select name="type" class="form-select feedback-type"
                                            onchange="toggleFeedbackOptions(this)">

                                            <option value="text"{{ $question->type === 'text' ? 'selected' : '' }} style="color: black;">
                                                Text
                                            </option>

                                            <option value="rating"{{ $question->type === 'rating' ? 'selected' : '' }} style="color: black;">
                                                Rating
                                            </option>

                                            <option value="single_choice"{{ $question->type === 'single_choice' ? 'selected' : '' }} style="color: black;">
                                                Single Choice
                                            </option>

                                            <option value="multiple_choice"{{ $question->type === 'multiple_choice' ? 'selected' : '' }} style="color: black;">
                                                Multiple Choice
                                            </option>

                                        </select>

                                    </div>

                                    <div class="feedback-edit-options"
                                        style="{{ in_array($question->type, ['single_choice', 'multiple_choice']) ? '' : 'display:none' }}">

                                        @foreach($question->options as $option)

                                            <div class="form-group">

                                                <label>Option {{ $loop->iteration }}</label>

                                                <input type="text" name="options[]" class="form-control"
                                                    value="{{ $option->option_text }}">

                                            </div>

                                        @endforeach

                                        <div class="form-group">
                                            <label>Add another option</label>

                                            <input type="text" name="options[]" class="form-control">
                                        </div>

                                    </div>

                                    <label class="checkbox-row" style="margin-bottom:10px">

                                        <input type="checkbox" name="is_required" value="1" {{ $question->is_required ? 'checked' : '' }}>

                                        Required

                                    </label>

                                    <label class="checkbox-row" style="margin-bottom:15px">

                                        <input type="checkbox" name="is_active" value="1" {{ $question->is_active ? 'checked' : '' }}>

                                        Active

                                    </label>

                                    <button class="btn btn-primary btn-small">
                                        Save Feedback
                                    </button>

                                </form>

                            </div>

                        </div>

                    @empty

                        <div class="empty-state">

                            <h3>No Feedback Questions Yet</h3>

                            <p>
                                Add questions that participants should answer
                                after visiting this stall.
                            </p>

                        </div>

                    @endforelse

                    {{-- Add feedback question --}}

                    <div style="
                            border-top:1px solid rgba(255,255,255,.07);
                            padding-top:25px;
                            margin-top:25px;
                        ">

                        <h3 style="font-size:16px;margin-bottom:16px">
                            Add Feedback Question
                        </h3>

                        <form method="POST" action="{{ route('admin.stalls.feedback.questions.store', $stall) }}">
                            @csrf

                            <div class="form-grid">

                                <div class="form-group full">

                                    <label>Question *</label>

                                    <textarea name="question" class="form-control" placeholder="How was your experience?"
                                        required></textarea>

                                </div>

                                <div class="form-group">

                                    <label>Question Type *</label>

                                    <select name="type" class="form-select" onchange="toggleNewFeedbackOptions(this)"
                                        required>

                                        <option value="text" style="color: black;">
                                            Text
                                        </option>

                                        <option value="rating" style="color: black;">
                                            Rating
                                        </option>

                                        <option value="single_choice" style="color: black;">
                                            Single Choice
                                        </option>

                                        <option value="multiple_choice" style="color: black;">
                                            Multiple Choice
                                        </option>

                                    </select>

                                </div>

                                <div class="form-group">

                                    <label>Settings</label>

                                    <label class="checkbox-row">

                                        <input type="checkbox" name="is_required" value="1">

                                        Required question

                                    </label>

                                </div>

                            </div>

                            <div id="new-feedback-options" style="display:none;margin-bottom:18px">

                                @for($i = 0; $i < 4; $i++)

                                    <div class="form-group">

                                        <label>
                                            Option {{ chr(65 + $i) }}
                                        </label>

                                        <input type="text" name="options[]" class="form-control" placeholder="Enter option">

                                    </div>

                                @endfor

                            </div>

                            <button class="btn btn-primary">
                                + Add Feedback Question
                            </button>

                        </form>

                    </div>

                </div>
            </div>

            {{-- System Information --}}

            <div class="admin-card">

                <div class="card-header">
                    <div>
                        <h2>System Information</h2>
                        <p>Record information for this stall.</p>
                    </div>
                </div>

                <div class="card-body">

                    <div class="info-grid">

                        <div class="info-item">

                            <label>Created At</label>

                            <div>
                                {{ $stall->created_at?->format('d M Y, h:i A') ?? '—' }}
                            </div>

                        </div>

                        <div class="info-item">

                            <label>Last Updated</label>

                            <div>
                                {{ $stall->updated_at?->format('d M Y, h:i A') ?? '—' }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            function copyQrToken() {
                const input = document.getElementById('qr-token');

                if (!input) {
                    return;
                }

                navigator.clipboard.writeText(input.value)
                    .then(() => {
                        alert('QR token copied.');
                    });
            }

            function toggleEditQuestion(id) {
                const element = document.getElementById('edit-question-' + id);

                if (!element) {
                    return;
                }

                element.style.display =
                    element.style.display === 'none'
                        ? 'block'
                        : 'none';
            }

            function toggleEditFeedback(id) {
                const element = document.getElementById('edit-feedback-' + id);

                if (!element) {
                    return;
                }

                element.style.display =
                    element.style.display === 'none'
                        ? 'block'
                        : 'none';
            }

            function toggleNewFeedbackOptions(select) {
                const container =
                    document.getElementById('new-feedback-options');

                if (!container) {
                    return;
                }

                if (
                    select.value === 'single_choice' ||
                    select.value === 'multiple_choice'
                ) {
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            }

            function toggleFeedbackOptions(select) {
                const form = select.closest('form');

                if (!form) {
                    return;
                }

                const container =
                    form.querySelector('.feedback-edit-options');

                if (!container) {
                    return;
                }

                if (
                    select.value === 'single_choice' ||
                    select.value === 'multiple_choice'
                ) {
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            }
        </script>
    @endpush

@endsection