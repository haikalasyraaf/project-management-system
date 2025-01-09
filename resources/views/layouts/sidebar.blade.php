<nav class="w-100 nav nav-pills flex-column pt-3" id="menu">
    <a href="{{ route('dashboard.index') }}" class="nav-link align-middle {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
        <i class="sidebar-icon" data-feather="home"></i>
        <span class="ms-3 d-none d-sm-inline">Dashboard</span>
    </a>
    <a href="{{ route('project.index') }}" class="nav-link align-middle {{ request()->routeIs('project.index') ? 'active' : '' }}">
        <i class="sidebar-icon" data-feather="server"></i>
        <span class="ms-3 d-none d-sm-inline">Project</span>
    </a>
    <a href="{{ route('invoice.index') }}" class="nav-link align-middle {{ request()->routeIs('invoice.index') ? 'active' : '' }}">
        <i class="sidebar-icon" data-feather="clipboard"></i>
        <span class="ms-3 d-none d-sm-inline">Invoice</span>
    </a>
    <a href="{{ route('user.index') }}" class="nav-link align-middle {{ request()->routeIs('user.index') ? 'active' : '' }}">
        <i class="sidebar-icon" data-feather="users"></i>
        <span class="ms-3 d-none d-sm-inline">User</span>
    </a>
    <a href="{{ route('role.index') }}" class="nav-link align-middle {{ request()->routeIs('role.index') ? 'active' : '' }}">
        <i class="sidebar-icon" data-feather="users"></i>
        <span class="ms-3 d-none d-sm-inline">Role</span>
    </a>
</nav>