<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
	<div class="app-brand demo">
		<a href="{{route('admin.dashboard')}}" class="app-brand-link">
			<span class="app-brand-logo demo">
				<div class="logo-icon me-2" style="width: 32px; height: 32px; background: var(--accent-red); border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; color: white;">
					<i class="bi bi-play-fill fs-5"></i>
				</div>
			</span>
			<span class="app-brand-text demo menu-text fw-bold ms-1 text-white">{{ config('app.name', 'ax india') }}</span>
		</a>

		<a href="javascript:void(0);"
			class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
			<i class="bx bx-chevron-left bx-sm align-middle"></i>
		</a>
	</div>

	<div class="menu-inner-shadow"></div>

	<ul class="menu-inner py-1">
		<li class="menu-item {{ request()->is('admin/dashboard') ? 'active' : ''}}">
			<a href="{{route('admin.dashboard')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-home-circle"></i>
				<div data-i18n="Dashboard">Dashboard</div>
			</a>
		</li>

		<li class="menu-item {{ request()->is('admin/users*') ? 'active' : ''}}">
			<a href="{{route('admin.users.index')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-group"></i>
				<div data-i18n="User">Users</div>
			</a>
		</li>

		<li class="menu-item {{ request()->is('admin/moderation*') ? 'active' : ''}}">
			<a href="{{route('admin.moderation.index')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-video-off"></i>
				<div data-i18n="Moderation">Video Moderation</div>
			</a>
		</li>

		<li class="menu-item {{ request()->is('admin/categories*') ? 'active' : ''}}">
			<a href="{{route('admin.categories.index')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-category"></i>
				<div data-i18n="Categories">Categories</div>
			</a>
		</li>

		<li class="menu-item {{ request()->is('admin/advertisements*') ? 'active' : ''}}">
			<a href="{{route('admin.advertisements.index')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-briefcase"></i>
				<div data-i18n="Advertisements">Advertisements</div>
			</a>
		</li>

		<li class="menu-item {{ request()->is('admin/verifications*') ? 'active' : ''}}">
			<a href="{{route('admin.verifications.index')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-badge-check"></i>
				<div data-i18n="Verifications">Creator Verifications</div>
			</a>
		</li>

		<li class="menu-item {{ request()->is('admin/reports*') ? 'active' : ''}}">
			<a href="{{route('admin.reports.index')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-flag"></i>
				<div data-i18n="Reports">Reports</div>
			</a>
		</li>

		<li class="menu-item {{ request()->is('admin/payments*') ? 'active' : ''}}">
			<a href="{{route('admin.payments.index')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-dollar-circle"></i>
				<div data-i18n="Payments">Subscriptions & Payments</div>
			</a>
		</li>
		
	</ul>
</aside>