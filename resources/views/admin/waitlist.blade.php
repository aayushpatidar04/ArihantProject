@extends('layouts.app')

@section('title', 'Waitlist — Admin')

@push('styles')
	<style>
		.admin-page { min-height: 100vh; padding: 40px 24px; background: var(--bg-soft) }
		.admin-wrap { max-width: 1200px; margin: 0 auto }
		.admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px }
		.admin-section { background: linear-gradient(160deg, rgba(22, 12, 30, 0.9) 0%, rgba(8, 4, 12, 0.96) 100%); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 18px; padding: 24px; overflow-x: auto }
		table { width: 100%; border-collapse: collapse; font-size: 13px }
		th, td { padding: 12px; text-align: left; border-bottom: 1px solid rgba(255, 255, 255, 0.06) }
		th { color: var(--muted); font-weight: 600; font-size: 12px; text-transform: uppercase }
		td { color: var(--ink) }
		.pagination { margin-top: 20px }
	</style>
@endpush

@section('content')
	<div class="admin-page">
		<div class="admin-wrap">
			<div class="admin-header">
				<h1>Waitlist Numbers</h1>
				<div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
					@permission('waitlist', 'export')
						<a href="{{ route('admin.waitlist.export') }}" class="btn btn-primary"
							style="font-size:13px;padding:9px 16px">Export CSV</a>
					@endpermission
					<a href="{{ route('admin.dashboard') }}" style="color:var(--purple-1);font-size:14px">← Back</a>
				</div>
			</div>
			<div class="admin-section">
				<table>
					<thead>
						<tr>
							<th>#</th>
							<th>Phone Number</th>
							<th>Joined At</th>
						</tr>
					</thead>
					<tbody>
						@forelse($waitlistNumbers as $waitlistNumber)
							<tr>
								<td>{{ $waitlistNumber->id }}</td>
								<td>{{ $waitlistNumber->phone_number }}</td>
								<td>{{ $waitlistNumber->created_at?->format('M d, Y h:i A') ?? '-' }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="3" style="text-align:center;color:var(--muted);padding:40px">No waitlist numbers yet.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
				<div class="pagination">{{ $waitlistNumbers->links() }}</div>
			</div>
		</div>
	</div>
@endsection
