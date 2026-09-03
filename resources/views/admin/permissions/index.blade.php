@extends('layouts.app')

@section('title', 'Manage Admin Permissions')

@push('styles')
    <style>
        .admin-page {
            min-height: 100vh;
            padding: 40px 24px;
            background: var(--bg-soft)
        }

        .admin-wrap {
            max-width: 1200px;
            margin: 0 auto
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 12px
        }

        .admin-header h1 {
            font-size: 24px;
            font-weight: 700
        }

        .admin-section {
            background: linear-gradient(160deg, rgba(22, 12, 30, 0.9) 0%, rgba(8, 4, 12, 0.96) 100%);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 24px
        }

        .admin-section h2 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 16px
        }

        .perm-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px
        }

        .perm-table th {
            padding: 12px;
            text-align: left;
            color: var(--muted);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08)
        }

        .perm-table td {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            color: var(--ink);
            vertical-align: top
        }

        .perm-table tr:last-child td {
            border-bottom: none
        }

        .perm-cell {
            font-weight: 600;
            font-size: 14px
        }

        .perm-email {
            color: var(--muted);
            font-size: 12px
        }

        .badge-role {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 4px
        }

        .badge-admin {
            background: rgba(100, 180, 255, 0.15);
            color: #8cd4ff
        }

        .check-group {
            display: flex;
            gap: 14px;
            flex-wrap: wrap
        }

        .check-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--muted)
        }

        .check-item input[type="checkbox"] {
            accent-color: var(--purple-1);
            width: 14px;
            height: 14px;
            cursor: pointer
        }

        .btn {
            padding: 10px 20px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            font-size: 13px
        }

        .btn-primary {
            background: var(--purple-1);
            color: #fff
        }

        .btn-sm {
            padding: 7px 14px;
            font-size: 12px
        }

        .no-perms {
            color: var(--muted);
            text-align: center;
            padding: 40px;
            font-size: 14px
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center
        }

        .modal-overlay.active {
            display: flex
        }

        .modal {
            background: rgba(22, 12, 30, 0.98);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 18px;
            padding: 28px;
            max-width: 650px;
            width: 90%;
            max-height: 85vh;
            overflow-y: auto
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px
        }

        .modal-header h2 {
            font-size: 18px;
            font-weight: 700
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--muted);
            font-size: 22px;
            cursor: pointer;
            padding: 4px 8px
        }

        .perm-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px
        }

        .perm-section {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 16px
        }

        .perm-section-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: capitalize;
            margin-bottom: 10px;
            color: var(--purple-1)
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px
        }

        .alert-success {
            background: rgba(40, 180, 100, 0.1);
            border: 1px solid rgba(40, 180, 100, 0.2);
            color: #8ff0b3
        }

        .alert-error {
            background: rgba(220, 60, 60, 0.1);
            border: 1px solid rgba(220, 60, 60, 0.2);
            color: #ff9e9e
        }
    </style>
@endpush

@section('content')
    <div class="admin-page">
        <div class="admin-wrap">
            <div class="admin-header">
                <h1>Admin Permission Management</h1>
                <a href="{{ route('admin.dashboard') }}" class="btn"
                    style="background:rgba(255,255,255,0.06);color:var(--muted);font-size:13px">← Back to Dashboard</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <div class="admin-section">
                <h2>Admin Users & Permissions</h2>
                <p style="color:var(--muted);font-size:13px;margin-bottom:20px">
                    Click <strong>Edit Permissions</strong> to grant or revoke view, create, edit, delete, and export access
                    per page.
                </p>

                <div style="overflow-x:auto">
                    <table class="perm-table">
                        <thead>
                            <tr>
                                <th>Admin</th>
                                <th>Dashboard</th>
                                <th>Registrations</th>
                                <th>Check-Ins</th>
                                <th>Event Feedback</th>
                                <th>Referrals</th>
                                <th>Leaderboard</th>
                                <th>Influencers</th>
                                <th>Stalls</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($admins as $admin)
                                <tr>
                                    <td>
                                        <div class="perm-cell">{{ $admin->name }}</div>
                                        <div class="perm-email">{{ $admin->email }}</div>
                                        <span class="badge-role badge-admin">Admin</span>
                                    </td>
                                    @foreach(['dashboard', 'registrations', 'checkins', 'event-feedback', 'referrals', 'leaderboard', 'influencers', 'stalls'] as $res)
                                        <td>
                                            @php
                                                $p = $admin->permissions->firstWhere('resource', $res);
                                             @endphp
                                            <span style="font-size:11px;color:{{ $p && $p->view ? '#8ff0b3' : 'var(--muted)' }}">
                                                {{ $p && $p->view ? '&#10003; View' : 'View' }}
                                            </span>
                                        </td>
                                    @endforeach
                                    <td>
                                        <button class="btn btn-primary btn-sm edit-perm-btn" data-admin="{{ $admin->id }}"
                                            data-name="{{ $admin->name }}">Edit Permissions</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="no-perms">No admin users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Permission Edit Modal -->
    <div class="modal-overlay" id="permModal">
        <div class="modal">
            <div class="modal-header">
                <h2 id="modalTitle">Edit Permissions</h2>
                <button class="modal-close" id="modalClose">&times;</button>
            </div>
            <form id="permForm" method="POST">
                @csrf
                <div class="perm-grid" id="permGrid">
                    @php $idx = 0; @endphp
                    @foreach($allResources as $resource)
                        <div class="perm-section">
                            <div class="perm-section-title">{{ $resource }}</div>
                            <input type="hidden" name="permissions[{{ $idx }}][resource]" value="{{ $resource }}">
                            <div class="check-group">
                                <label class="check-item"><input type="checkbox" name="permissions[{{ $idx }}][view]" value="1"
                                        checked> View</label>
                                <label class="check-item"><input type="checkbox" name="permissions[{{ $idx }}][create]"
                                        value="1"> Create</label>
                                <label class="check-item"><input type="checkbox" name="permissions[{{ $idx }}][edit]" value="1">
                                    Edit</label>
                                <label class="check-item"><input type="checkbox" name="permissions[{{ $idx }}][delete]"
                                        value="1"> Delete</label>
                                <label class="check-item"><input type="checkbox" name="permissions[{{ $idx }}][export]"
                                        value="1"> Export</label>
                            </div>
                        </div>
                        @php $idx++; @endphp
                    @endforeach
                </div>
                <div style="display:flex;gap:10px;margin-top:20px;justify-content:flex-end">
                    <button type="button" class="btn" style="background:rgba(255,255,255,0.06);color:var(--muted)"
                        id="modalCancel">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Permissions</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>

    <script>
        const modal = document.getElementById('permModal');
        const form = document.getElementById('permForm');
        const modalTitle = document.getElementById('modalTitle');
        const permGrid = document.getElementById('permGrid');

        function closeModal() {
            modal.classList.remove('active');
        }

        function openModal(adminId, adminName) {
            modalTitle.textContent = 'Edit Permissions — ' + adminName;
            form.action = '/admin/permissions/' + adminId;

            // Uncheck all first
            permGrid.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);

            // Fetch existing permissions via AJAX
            fetch('/admin/permissions/' + adminId + '/edit-data')
                .then(r => r.json())
                .then(data => {
                    if (data.permissions) {
                        data.permissions.forEach(p => {
                            // Find the index for this resource
                            const sections = permGrid.querySelectorAll('.perm-section');
                            sections.forEach(section => {
                                const hidden = section.querySelector('input[type="hidden"]');
                                if (hidden && hidden.value === p.resource) {
                                    section.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                                        const action = cb.name.match(/\[(\w+)\]$/)?.[1];
                                        if (action && p[action]) cb.checked = true;
                                    });
                                }
                            });
                        });
                    }
                })
                .catch(() => { });

            modal.classList.add('active');
        }

        document.getElementById('modalClose').addEventListener('click', closeModal);
        document.getElementById('modalCancel').addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });

        document.querySelectorAll('.edit-perm-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                openModal(btn.dataset.admin, btn.dataset.name);
            });
        });
    </script>
@endsection