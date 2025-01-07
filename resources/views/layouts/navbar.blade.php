<div class="card">
    <div class="card-body py-2">
        <div class="d-flex justify-content-end align-items-center">
            <div class="text-end me-3">
                <span class="fw-bold">{{ Auth::user()->name }}</span><br>
                <span>{{ Auth::user()->role_type == 1 ? 'Admin' : 'User' }}</span>
            </div>
            <div>
                <div class="dropdown">
                    <button type="button" class="btn p-0 border-0" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </span>
                    </button>

                    <ul class="dropdown-menu">
                        <li class="text-center"><span class="dropdown-item fw-bold">Manage profile</span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i data-feather="user" class="me-2"></i>My Profile</a></li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout').submit();">
                                <i data-feather="log-out" class="me-2"></i>Logout
                            </a>
                            <form id="logout" method="POST" action="{{ route('logout') }}">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>