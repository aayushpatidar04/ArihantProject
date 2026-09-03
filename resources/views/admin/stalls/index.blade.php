@extends('layouts.app')

@section('title', 'Manage Stalls — Admin')

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
        align-items: center;
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
    }

    .admin-card {
        background: linear-gradient(
            160deg,
            rgba(22, 12, 30, 0.9),
            rgba(8, 4, 12, 0.96)
        );
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 20px;
        overflow: hidden;
    }

    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 16px 18px;
        text-align: left;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        vertical-align: middle;
    }

    th {
        color: var(--muted);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.018);
    }

    td {
        font-size: 13px;
        color: #ded7e6;
    }

    .stall-name {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .stall-name strong {
        color: var(--ink);
        font-size: 14px;
    }

    .stall-name small {
        color: var(--muted-2);
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

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 11px;
        border-radius: 9px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.04);
        color: #e9defa;
        font-size: 12px;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .action-btn:hover {
        border-color: rgba(184, 102, 247, 0.55);
        background: rgba(184, 102, 247, 0.12);
    }

    .action-delete:hover {
        border-color: rgba(255, 90, 90, 0.5);
        background: rgba(255, 80, 80, 0.1);
        color: #ffaaaa;
    }

    .empty-state {
        text-align: center;
        padding: 65px 20px;
    }

    .empty-state h3 {
        margin-bottom: 8px;
        font-size: 20px;
    }

    .empty-state p {
        color: var(--muted);
        margin-bottom: 22px;
        font-size: 14px;
    }

    .pagination-wrap {
        margin-top: 24px;
    }

    @media (max-width: 640px) {
        .admin-page {
            padding: 28px 16px 50px;
        }

        .admin-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .admin-header .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="admin-page">
    <div class="admin-wrap">

        <div class="admin-header">
            <div>
                <h1>Manage Stalls</h1>
                <p>Create and manage event stalls and their unique QR codes.</p>
            </div>
            <div>
                @permission('stalls', 'create')
 <a href="{{ route('admin.stalls.create') }}" class="btn btn-primary" style="margin-right: 15px;">
                    + Create Stall
                </a>
 @endpermission
                <a href="{{ route('admin.dashboard') }}" style="color:var(--purple-1);font-size:14px">← Back to Dashboard</a>
            </div>
        </div>

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

        <div class="admin-card">
            @if($stalls->count())
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Stall</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Visits</th>
                                <th>QR</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($stalls as $stall)
                                <tr>
                                    <td>
                                        <div class="stall-name">
                                            <strong>{{ $stall->name }}</strong>
                                            <small>{{ $stall->slug }}</small>
                                        </div>
                                    </td>

                                    <td>
                                        {{ $stall->location ?: '—' }}
                                    </td>

                                    <td>
                                        @if($stall->is_active)
                                            <span class="badge badge-active">Active</span>
                                        @else
                                            <span class="badge badge-inactive">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $stall->visits_count }}
                                    </td>

                                    <td>
                                        <a
                                            href="{{ route('admin.stalls.show', $stall) }}"
                                            class="action-btn"
                                        >
                                            View QR
                                        </a>
                                    </td>

                                    <td>
                                        <div class="action-buttons">
                                            <a
                                                href="{{ route('admin.stalls.show', $stall) }}"
                                                class="action-btn"
                                            >
                                                View
                                            </a>

                                            <a
                                                @permission('stalls', 'edit') href="{{ route('admin.stalls.edit', $stall) }}"
                                                class="action-btn"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                @permission('stalls', 'delete') action="{{ route('admin.stalls.destroy', $stall) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this stall? All related visit records may also be deleted.')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="action-btn action-delete"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <h3>No Stalls Created Yet</h3>
                    <p>Create your first event stall and generate its unique QR code.</p>

                    <a
                        href="{{ route('admin.stalls.create') }}"
                        class="btn btn-primary"
                    >
                        Create First Stall
                    </a>
                </div>
            @endif
        </div>

        @if($stalls->hasPages())
            <div class="pagination-wrap">
                {{ $stalls->links() }}
            </div>
        @endif

    </div>
</div>
@endsection 