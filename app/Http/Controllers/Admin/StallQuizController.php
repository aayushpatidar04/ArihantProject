<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stall;
use App\Models\StallQuiz;
use App\Models\StallQuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StallQuizController extends Controller
{
    /**
     * Create or update the quiz itself.
     */
    public function store(Request $request, Stall $stall)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Only one active quiz per stall.
        if ($request->boolean('is_active')) {
            $stall->quizzes()
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $quiz = $stall->quizzes()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with(
            'success',
            'Quiz created successfully.'
        );
    }

    /**
     * Update existing quiz.
     */
    public function update(Request $request, Stall $stall)
    {
        $quiz = $stall->quizzes()->firstOrFail();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('is_active')) {
            $stall->quizzes()
                ->where('id', '!=', $quiz->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $quiz->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with(
            'success',
            'Quiz updated successfully.'
        );
    }

    /**
     * Add a question with its options.
     */
    public function storeQuestion(Request $request, Stall $stall)
    {
        $validated = $request->validate([
            'quiz_id' => [
                'required',
                'integer',
                'exists:stall_quizzes,id',
            ],

            'question' => [
                'required',
                'string',
                'max:2000',
            ],

            'points' => [
                'required',
                'integer',
                'min:1',
                'max:1000',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'options' => [
                'required',
                'array',
                'min:2',
            ],

            'options.*.text' => [
                'required',
                'string',
                'max:1000',
            ],

            'correct_option' => [
                'required',
                'integer',
            ],
        ]);

        $quiz = $stall->quizzes()
            ->where('id', $validated['quiz_id'])
            ->firstOrFail();

        $options = $validated['options'];

        if (
            !array_key_exists(
                $validated['correct_option'],
                $options
            )
        ) {
            return back()
                ->withErrors([
                    'correct_option' =>
                        'Please select a valid correct answer.',
                ])
                ->withInput();
        }

        DB::transaction(function () use ($quiz, $validated, $options) {
            $nextOrder = $quiz->questions()->max('sort_order') ?? 0;

            $question = $quiz->questions()->create([
                'question' => $validated['question'],
                'points' => $validated['points'],
                'sort_order' => $nextOrder + 1,
                'is_active' => $validated['is_active'] ?? true,
            ]);

            foreach ($options as $index => $option) {
                $question->options()->create([
                    'option_text' => $option['text'],
                    'is_correct' =>
                        (int) $validated['correct_option'] === (int) $index,
                    'sort_order' => $index + 1,
                ]);
            }
        });

        return back()->with(
            'success',
            'Quiz question added successfully.'
        );
    }

    /**
     * Update a question and its options.
     */
    public function updateQuestion(
        Request $request,
        Stall $stall,
        StallQuizQuestion $question
    ) {
        $validated = $request->validate([
            'question' => [
                'required',
                'string',
                'max:2000',
            ],

            'points' => [
                'required',
                'integer',
                'min:1',
                'max:1000',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'options' => [
                'required',
                'array',
                'min:2',
            ],

            'options.*.id' => [
                'nullable',
                'integer',
            ],

            'options.*.text' => [
                'required',
                'string',
                'max:1000',
            ],

            'correct_option' => [
                'required',
                'integer',
            ],
        ]);

        // Security: make sure question belongs to this stall.
        if ($question->quiz->stall_id !== $stall->id) {
            abort(404);
        }

        $options = $validated['options'];

        if (
            !array_key_exists(
                $validated['correct_option'],
                $options
            )
        ) {
            return back()
                ->withErrors([
                    'correct_option' =>
                        'Please select a valid correct answer.',
                ])
                ->withInput();
        }

        DB::transaction(function () use ($question, $validated, $options) {
            $question->update([
                'question' => $validated['question'],
                'points' => $validated['points'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            // For simplicity and safety, recreate options.
            $question->options()->delete();

            foreach ($options as $index => $option) {
                $question->options()->create([
                    'option_text' => $option['text'],
                    'is_correct' =>
                        (int) $validated['correct_option'] === (int) $index,
                    'sort_order' => $index + 1,
                ]);
            }
        });

        return back()->with(
            'success',
            'Quiz question updated successfully.'
        );
    }

    /**
     * Delete question.
     */
    public function destroyQuestion(
        Stall $stall,
        StallQuizQuestion $question
    ) {
        if ($question->quiz->stall_id !== $stall->id) {
            abort(404);
        }

        $question->delete();

        return back()->with(
            'success',
            'Quiz question deleted successfully.'
        );
    }
}