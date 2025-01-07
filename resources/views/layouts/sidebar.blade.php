<nav class="w-100 nav nav-pills flex-column pt-3" id="menu">
    <a href="{{ route('dashboard') }}" class="nav-link align-middle {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="sidebar-icon" data-feather="home"></i>
        <span class="ms-3 d-none d-sm-inline">Dashboard</span>
    </a>
    <a href="#" class="nav-link align-middle">
        <i class="sidebar-icon" data-feather="server"></i>
        <span class="ms-3 d-none d-sm-inline">Project</span>
    </a>
    <a href="#" class="nav-link align-middle">
        <i class="sidebar-icon" data-feather="clipboard"></i>
        <span class="ms-3 d-none d-sm-inline">Invoice</span>
    </a>
    <a href="{{ route('user.index') }}" class="nav-link align-middle {{ request()->routeIs('user.index') ? 'active' : '' }}">
        <i class="sidebar-icon" data-feather="users"></i>
        <span class="ms-3 d-none d-sm-inline">User</span>
    </a>
    <a href="#" class="nav-link align-middle">
        <i class="sidebar-icon" data-feather="file-text"></i>
        <span class="ms-3 d-none d-sm-inline">Report</span>
    </a>
    <a href="#" class="nav-link align-middle">
        <i class="sidebar-icon" data-feather="settings"></i>
        <span class="ms-3 d-none d-sm-inline">Settings</span>
    </a>
</nav>