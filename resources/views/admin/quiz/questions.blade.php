@extends('layouts.app')

@section('title', 'Questions — ArihantPLUS')

@push('styles')
    <style>
        .quiz-page {
            padding: 32px 24px;
            max-width: 900px;
            margin: 0 auto
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px
        }

        .page-header h1 {
            font-size: 24px;
            font-weight: 700
        }

        .q-table {
            width: 100%;
            border-collapse: collapse
        }

        .q-table th,
        .q-table td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 14px
        }

        .q-table th {
            color: var(--muted);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase
        }

        .q-text {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .q-options {
            display: flex;
            gap: 4px;
            flex-wrap: wrap
        }

        .q-opt {
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11px;
            background: rgba(255, 255, 255, 0.06)
        }

        .q-opt.correct {
            background: rgba(40, 180, 100, 0.15);
            color: #8ff0b3
        }

        .q-actions {
            display: flex;
            gap: 6px
        }

        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 100;
            align-items: center;
            justify-content: center
        }

        .modal-overlay.active {
            display: flex
        }

        .modal {
            background: #170b22;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 32px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto
        }

        .modal h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px
        }

        .form-group {
            margin-bottom: 16px
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 6px
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            padding: 10px 14px;
            color: #fff;
            font-size: 14px
        }

        .form-group textarea {
            min-height: 80px;
            resize: vertical
        }

        .option-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px
        }

        .option-input {
            display: flex;
            align-items: center;
            gap: 8px
        }

        .option-input input[type="radio"] {
            accent-color: var(--purple-1);
            width: 18px;
            height: 18px
        }

        .option-input input[type="text"] {
            flex: 1
        }

        .btn-row {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px
        }
    </style>
@endpush

@section('content')
    <div class="quiz-page">
        <div class="page-header">
            <div>
                <h1>{{ config('quiz.quiz_types.' . $type, $type) }} — Questions</h1>
                <p style="color:var(--muted);font-size:13px;margin-top:4px">{{ $questions->count() }} questions in bank</p>
            </div>
            <div style="display:flex;gap:10px">
                <a href="{{ route('admin.quiz.index') }}" class="btn btn-ghost">← Back</a>
                @if(!$activeSession)
                    <button onclick="openModal()" class="btn btn-primary">+ Add Question</button>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div
                style="background:rgba(40,180,100,0.1);border:1px solid rgba(40,180,100,0.3);border-radius:12px;padding:14px 20px;margin-bottom:20px;color:#8ff0b3">
                {{ session('success') }}</div>
        @endif

        @if($activeSession)
            <div
                style="background:rgba(255,180,0,0.08);border:1px solid rgba(255,180,0,0.3);border-radius:12px;padding:16px 20px;margin-bottom:20px;color:#ffd700">
                ⚠️ Quiz is currently active. Question editing is locked.
            </div>
        @else
            <table class="q-table">
                <thead>
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Question</th>
                        <th>Options</th>
                        <th style="width:80px">Correct</th>
                       
                        <th style="width:140px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questions as $q)
                        <tr>
                            <td>{{ $q->order }}</td>
                            <td class="q-text" title="{{ $q->question_text }}">{{ $q->question_text }}</td>
                            <td>
                                <div class="q-options">
                                    @foreach($q->options as $i => $opt)
                                        <span class="q-opt {{ $i === $q->correct_option ? 'correct' : '' }}">{{ chr(65 + $i) }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td style="font-weight:700;color:#8ff0b3">{{ chr(65 + $q->correct_option) }}</td>
                           
                            <td>
                                <div class="q-actions">
                                    <button
                                        onclick="editQuestion({{ $q->id }}, '{{ addslashes($q->question_text) }}', {{ json_encode($q->options) }}, {{ $q->correct_option }})"
                                        class="btn btn-ghost" style="font-size:12px;padding:6px 12px">Edit</button>
                                    <form method="POST" action="{{ route('admin.quiz.destroy', [$type, $q->id]) }}"
                                        style="display:inline" onsubmit="return confirm('Delete?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn"
                                            style="font-size:12px;padding:6px 12px;background:rgba(220,60,60,0.1);border:1px solid rgba(220,60,60,0.3);color:#f87171">Del</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;color:var(--muted);padding:40px">No questions yet. Click "Add
                                Question" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="questionModal">
        <div class="modal">
            <h2 id="modalTitle">Add Question</h2>
            <form method="POST" id="questionForm">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @csrf
                <div class="form-group">
                    <label>Question Text</label>
                    <textarea name="question_text" id="qText" required></textarea>
                </div>
                <div class="form-group">
                    <label>Options (select the correct one)</label>
                    <div class="option-inputs">
                        <div class="option-input"><input type="radio" name="correct_option" value="0" checked><input
                                type="text" name="options[]" placeholder="Option A" required></div>
                        <div class="option-input"><input type="radio" name="correct_option" value="1"><input type="text"
                                name="options[]" placeholder="Option B" required></div>
                        <div class="option-input"><input type="radio" name="correct_option" value="2"><input type="text"
                                name="options[]" placeholder="Option C" required></div>
                        <div class="option-input"><input type="radio" name="correct_option" value="3"><input type="text"
                                name="options[]" placeholder="Option D" required></div>
                    </div>
                </div>
                <div class="form-group">
                </div>
                <div class="btn-row">
                    <button type="button" onclick="closeModal()" class="btn btn-ghost">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Question</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('questionModal').classList.add('active'); document.getElementById('modalTitle').textContent = 'Add Question'; document.getElementById('questionForm').action = '{{ route("admin.quiz.questions", $type) }}';
            document.getElementById('formMethod').value = 'POST'; document.getElementById('qText').value = ''; document.querySelectorAll('#questionForm input[name="options[]"]').forEach(i => i.value = ''); document.getElementById('qTimeLimit').value = '';
        }
        function closeModal() { document.getElementById('questionModal').classList.remove('active'); }
        function editQuestion(id, text, options, correct, timeLimit) {
            document.getElementById('modalTitle').textContent = 'Edit Question';
            document.getElementById('questionForm').action = '/admin/quiz/{{ $type }}/questions/' + id;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('qText').value = text;
            const inputs = document.querySelectorAll('#questionForm input[name="options[]"]');
            options.forEach((opt, i) => { if (inputs[i]) inputs[i].value = opt; });
            document.getElementById('qTimeLimit').value = timeLimit || '';
            document.querySelector(`input[name="correct_option"][value="${correct}"]`).checked = true;
            document.getElementById('questionModal').classList.add('active');
        }
    </script>
@endsection