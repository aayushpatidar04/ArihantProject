<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminPermissionController extends Controller
{
    private const RESOURCES = [
        'dashboard',
        'registrations',
        'checkins',
        'event-feedback',
        'referrals',
        'leaderboard',
        'influencers',
        'stalls',
    ];

    /**
     * List all non-super-admins with their current permissions.
     */
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isSuperAdmin()) {
            abort(403, 'Only super admins can manage permissions.');
        }

        $superAdminEmails = array_map('strtolower', config('event.super_admin_emails', []));

        $admins = User::where('role', 'admin')
            ->where(function ($q) use ($superAdminEmails) {
                $q->whereNotIn(DB::raw('LOWER(email)'), $superAdminEmails);
            })
            ->orderBy('name')
            ->get();

        // Pre-seed default permissions for admins without any
        foreach ($admins as $admin) {
            if ($admin->permissions->isEmpty()) {
                foreach (self::RESOURCES as $r) {
                    AdminPermission::firstOrCreate(
                        ['user_id' => $admin->id, 'resource' => $r],
                        ['view' => true, 'create' => false, 'edit' => false, 'delete' => false, 'export' => false]
                    );
                }
                $admin->load('permissions');
            }
        }

        $allResources = self::RESOURCES;

        return view('admin.permissions.index', compact('admins', 'allResources'));
    }

    /**
     * AJAX endpoint: return permissions JSON for a given admin.
     */
    public function editData(User $admin)
    {
        if (!Auth::check() || !Auth::user()->isSuperAdmin()) {
            abort(403);
        }

        if (!$admin->isAdmin() || $admin->isSuperAdmin()) {
            return response()->json(['permissions' => []]);
        }

        $perms = $admin->permissions()
            ->get()
            ->map(fn($p) => [
                'resource' => $p->resource,
                'view' => (bool) $p->view,
                'create' => (bool) $p->create,
                'edit' => (bool) $p->edit,
                'delete' => (bool) $p->delete,
                'export' => (bool) $p->export,
            ])
            ->values()
            ->all();

        return response()->json(['permissions' => $perms]);
    }

    /**
     * Save permissions for a specific admin.
     */
    public function store(Request $request, User $admin)
    {
        if (!Auth::check() || !Auth::user()->isSuperAdmin()) {
            abort(403, 'Only super admins can manage permissions.');
        }

        if (!$admin->isAdmin() || $admin->isSuperAdmin()) {
            return back()->with('error', 'Cannot modify permissions for this user.');
        }

        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*.resource' => 'required|string|in:' . implode(',', self::RESOURCES),
            'permissions.*.view' => 'nullable|boolean',
            'permissions.*.create' => 'nullable|boolean',
            'permissions.*.edit' => 'nullable|boolean',
            'permissions.*.delete' => 'nullable|boolean',
            'permissions.*.export' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request, $admin) {
            AdminPermission::where('user_id', $admin->id)->delete();

            $input = $request->input('permissions', []);

            foreach ($input as $perm) {
                AdminPermission::create([
                    'user_id' => $admin->id,
                    'resource' => $perm['resource'],
                    'view' => (bool) ($perm['view'] ?? false),
                    'create' => (bool) ($perm['create'] ?? false),
                    'edit' => (bool) ($perm['edit'] ?? false),
                    'delete' => (bool) ($perm['delete'] ?? false),
                    'export' => (bool) ($perm['export'] ?? false),
                ]);
            }
        });

        return back()->with('success', "Permissions updated for {$admin->name}.");
    }
}
