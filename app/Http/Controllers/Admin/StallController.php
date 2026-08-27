<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stall;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StallController extends Controller
{
    /**
     * Display all stalls.
     */
    public function index()
    {
        $stalls = Stall::withCount('visits')
            ->latest()
            ->paginate(15);

        return view('admin.stalls.index', compact('stalls'));
    }

    /**
     * Show the create stall form.
     */
    public function create()
    {
        return view('admin.stalls.create');
    }

    /**
     * Store a new stall.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $stall = Stall::create($validated);

        $service = new QrCodeService();
        $service->generateStallQr($stall);

        return redirect()
            ->route('admin.stalls.index')
            ->with('success', 'Stall created successfully. Its unique QR code has also been generated.');
    }

    /**
     * Show stall details.
     */
    public function show(Stall $stall)
    {
        $stall->load([
            'quizzes.questions.options',
            'feedbackQuestions.options',
        ]);
        $visit_count = $stall->loadCount('visits');

        return view('admin.stalls.show', compact('stall', 'visit_count'));
    }

    /**
     * Show edit form.
     */
    public function edit(Stall $stall)
    {
        return view('admin.stalls.edit', compact('stall'));
    }

    /**
     * Update a stall.
     */
    public function update(Request $request, Stall $stall)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($stall->name !== $validated['name']) {
            $validated['slug'] = $this->generateUniqueSlug(
                $validated['name'],
                $stall->id
            );
        }

        $validated['is_active'] = $request->boolean('is_active');

        $stall->update($validated);

        return redirect()
            ->route('admin.stalls.index')
            ->with('success', 'Stall updated successfully.');
    }

    /**
     * Delete a stall.
     */
    public function destroy(Stall $stall)
    {
        $stall->delete();

        return redirect()
            ->route('admin.stalls.index')
            ->with('success', 'Stall deleted successfully.');
    }

    /**
     * Generate a unique slug.
     */
    protected function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Stall::where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function scan(string $token)
    {
        $stall = Stall::where('qr_token', $token)
            ->where('is_active', true)
            ->firstOrFail();

        return redirect()->route('stalls.show', $stall->slug);
    }
}