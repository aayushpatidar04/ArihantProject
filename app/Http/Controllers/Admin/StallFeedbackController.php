<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stall;
use App\Models\StallFeedbackQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StallFeedbackController extends Controller
{
    public function store(Request $request, Stall $stall)
    {
        $validated = $request->validate([
            'question' => [
                'required',
                'string',
                'max:2000',
            ],

            'type' => [
                'required',
                'in:text,rating,single_choice,multiple_choice',
            ],

            'is_required' => [
                'nullable',
                'boolean',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'options' => [
                'nullable',
                'array',
            ],

            'options.*' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        if (
            in_array(
                $validated['type'],
                ['single_choice', 'multiple_choice']
            )
        ) {
            $options = collect($validated['options'] ?? [])
                ->filter(fn($value) => filled($value))
                ->values();

            if ($options->count() < 2) {
                return back()
                    ->withErrors([
                        'options' =>
                            'Choice-based feedback must have at least 2 options.',
                    ])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($stall, $validated) {
            $nextOrder =
                $stall->feedbackQuestions()->max('sort_order') ?? 0;

            $question = $stall->feedbackQuestions()->create([
                'question' => $validated['question'],
                'type' => $validated['type'],
                'is_required' =>
                    $validated['is_required'] ?? false,
                'sort_order' => $nextOrder + 1,
                'is_active' =>
                    $validated['is_active'] ?? true,
            ]);

            if (
                in_array(
                    $validated['type'],
                    ['single_choice', 'multiple_choice']
                )
            ) {
                $options = collect($validated['options'] ?? [])
                    ->filter(fn($value) => filled($value))
                    ->values();

                foreach ($options as $index => $option) {
                    $question->options()->create([
                        'option_text' => $option,
                        'sort_order' => $index + 1,
                    ]);
                }
            }
        });

        return back()->with(
            'success',
            'Feedback question added successfully.'
        );
    }

    public function update(
        Request $request,
        Stall $stall,
        StallFeedbackQuestion $question
    ) {
        if ($question->stall_id !== $stall->id) {
            abort(404);
        }

        $validated = $request->validate([
            'question' => [
                'required',
                'string',
                'max:2000',
            ],

            'type' => [
                'required',
                'in:text,rating,single_choice,multiple_choice',
            ],

            'is_required' => [
                'nullable',
                'boolean',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'options' => [
                'nullable',
                'array',
            ],

            'options.*' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        if (
            in_array(
                $validated['type'],
                ['single_choice', 'multiple_choice']
            )
        ) {
            $options = collect($validated['options'] ?? [])
                ->filter(fn($value) => filled($value))
                ->values();

            if ($options->count() < 2) {
                return back()
                    ->withErrors([
                        'options' =>
                            'Choice-based feedback must have at least 2 options.',
                    ])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($question, $validated) {
            $question->update([
                'question' => $validated['question'],
                'type' => $validated['type'],
                'is_required' =>
                    $validated['is_required'] ?? false,
                'is_active' =>
                    $validated['is_active'] ?? true,
            ]);

            $question->options()->delete();

            if (
                in_array(
                    $validated['type'],
                    ['single_choice', 'multiple_choice']
                )
            ) {
                $options = collect($validated['options'] ?? [])
                    ->filter(fn($value) => filled($value))
                    ->values();

                foreach ($options as $index => $option) {
                    $question->options()->create([
                        'option_text' => $option,
                        'sort_order' => $index + 1,
                    ]);
                }
            }
        });

        return back()->with(
            'success',
            'Feedback question updated successfully.'
        );
    }

    public function destroy(
        Stall $stall,
        StallFeedbackQuestion $question
    ) {
        if ($question->stall_id !== $stall->id) {
            abort(404);
        }

        $question->delete();

        return back()->with(
            'success',
            'Feedback question deleted successfully.'
        );
    }
}