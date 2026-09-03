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
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    private const RESOURCES = [
        'dashboard',
        'registrations',
        'checkins',
        'event-feedback',
        'referrals',
        'leaderboard',
        'communications',
        'influencers',
        'stalls',
        'admin-management',
    ];

    /**
     * List all admins with their current permissions.
     */
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isSuperAdmin()) {
            abort(403, 'Only super admins can manage permissions.');
        }

        $admins = User::where('role', 'admin')
            ->orderBy('name')
            ->get();

        // Pre-seed default permissions for admins without any
        foreach ($admins as $admin) {
            if ($admin->permissions->isEmpty()) {
                $defaults = ['dashboard', 'registrations', 'communications'];
                foreach ($defaults as $r) {
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

        if (!$admin->isAdmin()) {
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

        if (!$admin->isAdmin()) {
            return back()->with('error', 'User is not an admin.');
        }

        // Prevent modifying another super admin
        $superAdminEmails = array_map('strtolower', config('event.super_admin_emails', []));
        if (in_array(strtolower($admin->email), $superAdminEmails, true)) {
            return back()->with('error', 'Cannot modify permissions of a super admin.');
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
            // Remove existing permissions
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
