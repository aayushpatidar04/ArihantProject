@extends('layouts.app')

@section('title', 'Finbridge Registrations — Admin')

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
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px
        }

        .filter-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap
        }

        .filter-bar input,
        .filter-bar select {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 10px 14px;
            color: #fff;
            font-size: 13px;
            outline: none
        }

        .filter-bar input {
            width: 240px
        }

        .filter-bar button {
            padding: 10px 20px;
            border-radius: 12px;
            background: var(--purple-1);
            color: #fff;
            border: none;
            font-weight: 600;
            cursor: pointer
        }

        .admin-section {
            background: linear-gradient(160deg, rgba(22, 12, 30, 0.9) 0%, rgba(8, 4, 12, 0.96) 100%);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 18px;
            padding: 24px;
            overflow-x: auto
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06)
        }

        th {
            color: var(--muted);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em
        }

        td {
            color: var(--ink)
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600
        }

        .badge-paid {
            background: rgba(40, 180, 100, 0.15);
            color: #8ff0b3
        }

        .badge-pending {
            background: rgba(255, 180, 0, 0.15);
            color: #ffd700
        }

        .badge-checkin {
            background: rgba(184, 102, 247, 0.15);
            color: var(--purple-1)
        }

        .pagination {
            margin-top: 20px
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(6px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s;
            display: none
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1
        }

        .modal-box {
            max-width: 480px;
            width: 100%;
            background: linear-gradient(165deg, #1a0f28 0%, #0d0614 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 22px;
            padding: 32px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.8)
        }

        .modal-box h2 {
            font-family: 'Sora', sans-serif;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 6px
        }

        .modal-box label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 6px
        }

        .modal-box input,
        .modal-box select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 14px;
            outline: none;
            margin-bottom: 16px
        }

        .masked-info {
            background: rgba(255, 255, 255, 0.03);
            border: 1px dashed rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 16px
        }

        .masked-info p {
            margin: 4px 0;
            font-size: 13px;
            color: var(--muted)
        }
    </style>
@endpush

@section('content')
    <div class="admin-page">
        <div class="admin-wrap">
            <div class="admin-header">
                <h1>All Registrations</h1>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                    @permission('registrations', 'export')
                        <a href="{{ route('admin.export', request()->query()) }}" class="btn btn-primary"
                            style="font-size:13px;padding:9px 16px">
                            <i class="fas fa-file-excel" style="margin-right:6px;"></i> Export Excel
                        </a>
                    @endpermission
                    <a href="{{ route('admin.dashboard') }}" style="color:var(--purple-1);font-size:14px">← Back</a>
                </div>
            </div>

            <form class="filter-bar" method="GET" action="{{ route('admin.finbridge-registrations') }}">
                <input type="text" name="search" placeholder="Search name, email, phone..."
                    value="{{ request('search') }}">
                <select name="status">
                    <option value="" style="color: #000;">All Status</option>
                    <option value="pending" style="color: #000;" {{ request('status') == 'pending' ? 'selected' : '' }}>
                        Pending</option>
                    <option value="confirmed" style="color: #000;" {{ request('status') == 'confirmed' ? 'selected' : '' }}>
                        Confirmed</option>
                </select>
                <button type="submit">Filter</button>
            </form>

            <div class="admin-section">
                <table>
                    <thead>
                        <tr>
                            <th>Reg # / Code</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $r)
                            <tr>
                                <td>
                                    <strong>{{ $r->registration_number }}</strong><br>
                                    <span style="color:var(--muted);font-size:11px">{{ $r->referral_code }}</span>
                                </td>
                                <td>
                                    @if (auth()->check() && auth()->user()->canViewPii())
                                        {{ $r->full_name }}@else{{ \App\Models\User::maskName($r->full_name) }}
                                    @endif
                                </td>
                                <td>
                                    @if($r->is_existing_client)
                                        <span class="badge"
                                            style="background:rgba(40,180,100,0.15);color:#8ff0b3">Existing</span>
                                    @else
                                        <span class="badge"
                                            style="background:rgba(100,160,255,0.15);color:#8cd4ff">New</span>
                                    @endif
                                </td>
                                <td>
                                    @if (auth()->check() && auth()->user()->canViewPii())
                                        {{ $r->email }}@else{{ \App\Models\User::maskEmail($r->email) }}
                                    @endif
                                </td>
                                <td>
                                    @if (auth()->check() && auth()->user()->canViewPii())
                                        {{ $r->phone }}@else{{ \App\Models\User::maskPhone($r->phone) }}
                                    @endif
                                </td>
                                <td>
                                    @if ($r->status === 'confirmed')
                                        <span class="badge badge-checkin">Confirmed</span>
                                    @else
                                        <span class="badge badge-pending">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $r->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="text-align:center;color:var(--muted);padding:40px">
                                    @canAction('registrations', 'view')
                                    No registrations found.
                                @else
                                    You do not have permission to view registrations.
                                    @endcanAction
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pagination">{{ $registrations->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
    </div>

@endsection
