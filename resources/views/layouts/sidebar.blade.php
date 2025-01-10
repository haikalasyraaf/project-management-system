<nav class="w-100 nav nav-pills flex-column pt-3" id="menu">
    <a href="{{ route('dashboard.index') }}" class="nav-link align-middle {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
        <i class="sidebar-icon" data-feather="home"></i>
        <span class="ms-3 d-none d-sm-inline">Dashboard</span>
    </a>
    @if(auth()->user()->role->hasPermissionTo('view-project'))
        <a href="{{ route('project.index') }}" class="nav-link align-middle {{ request()->routeIs('project.index', 'project.create', 'project.edit', 'expense.index', 'expense.create', 'expense.edit') ? 'active' : '' }}">
            <i class="sidebar-icon" data-feather="server"></i>
            <span class="ms-3 d-none d-sm-inline">Project</span>
        </a>
    @endif
    @if(auth()->user()->role->hasPermissionTo('view-invoice'))
        <a href="{{ route('invoice.index') }}" class="nav-link align-middle {{ request()->routeIs('invoice.index', 'invoice.create', 'invoice.show') ? 'active' : '' }}">
            <i class="sidebar-icon" data-feather="clipboard"></i>
            <span class="ms-3 d-none d-sm-inline">Invoice</span>
        </a>
    @endif
    @if(auth()->user()->role->name == 'Admin')
        <a href="{{ route('user.index') }}" class="nav-link align-middle {{ request()->routeIs('user.index', 'user.create', 'user.edit') ? 'active' : '' }}">
            <i class="sidebar-icon" data-feather="users"></i>
            <span class="ms-3 d-none d-sm-inline">User</span>
        </a>
    @endif
    @if(auth()->user()->role->name == 'Admin')
        <a href="{{ route('role.index') }}" class="nav-link align-middle {{ request()->routeIs('role.index') ? 'active' : '' }}">
            <i class="sidebar-icon" data-feather="shield"></i>
            <span class="ms-3 d-none d-sm-inline">Role</span>
        </a>
    @endif
</nav>