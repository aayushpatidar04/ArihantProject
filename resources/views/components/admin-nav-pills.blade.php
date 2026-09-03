{{-- Permission-aware navigation pills for admin --}}
<div class="nav-pills">
    <a href="{{ route('admin.dashboard') }}"
        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Overview</a>

    @permission('registrations', 'view')
    <a href="{{ route('admin.registrations') }}"
        class="{{ request()->routeIs('admin.registrations*') ? 'active' : '' }}">Registrations</a>
    @endpermission

    @permission('checkins', 'view')
    <a href="{{ route('admin.checkins') }}"
        class="{{ request()->routeIs('admin.checkins') ? 'active' : '' }}">Check-Ins</a>
    @endpermission

    @permission('event-feedback', 'view')
    <a href="{{ route('admin.event-feedback') }}"
        class="{{ request()->routeIs('admin.event-feedback') ? 'active' : '' }}">Event Feedback</a>
    @endpermission

    @permission('stalls', 'view')
    <a href="{{ route('admin.stalls.index') }}"
        class="{{ request()->routeIs('admin.stalls*') ? 'active' : '' }}">Stalls</a>
    @endpermission

    @permission('referrals', 'view')
    <a href="{{ route('admin.referrals') }}"
        class="{{ request()->routeIs('admin.referrals') ? 'active' : '' }}">Referrals</a>
    @endpermission

    @permission('leaderboard', 'view')
    <a href="{{ route('admin.leaderboard') }}"
        class="{{ request()->routeIs('admin.leaderboard') ? 'active' : '' }}">Leaderboard</a>
    @endpermission

    @permission('influencers', 'view')
    <a href="{{ route('admin.influencers.index') }}"
        class="{{ request()->routeIs('admin.influencers*') ? 'active' : '' }}">Influencer</a>
    @endpermission

    @permission('admin-management', 'view')
    <a href="{{ route('admin.permissions.index') }}"
        class="{{ request()->routeIs('admin.permissions*') ? 'active' : '' }}"
        style="background:rgba(255,180,0,0.1);border-color:rgba(255,180,0,0.3);color:#ffd700">Permissions</a>
    @endpermission
</div>