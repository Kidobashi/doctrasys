<style>
    .wrapper {
    display: flex;
    width: 100%;
    align-items: stretch;
    }
    .wrapper {
    display: flex;
    align-items: stretch;
}

#sidebar {
    min-width: 250px;
    max-width: 250px;
}

#sidebar.active {
    margin-left: -250px;
}

#sidebar {
    min-width: 250px;
    max-width: 250px;
    min-height: 100vh;
}

a[data-toggle="collapse"] {
    position: relative;
}

.dropdown-toggle::after {
    display: block;
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
}

@media (max-width: 768px) {
    #sidebar {
        margin-left: -250px;
    }
    #sidebar {
        margin-left: 0;
    }
}

@import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";


body {
    font-family: 'Poppins', sans-serif;
    background: #fafafa;
}

p {
    font-family: 'Poppins', sans-serif;
    font-size: 1.1em;
    font-weight: 300;
    line-height: 1.7em;
    color: #999;
}

a, a:hover, a:focus {
    color: inherit;
    text-decoration: none;
    transition: all 0.3s;
}

#sidebar {
    /* don't forget to add all the previously mentioned styles here too */
    background: #04426E;
    color: #fff;
    transition: all 0.3s;
}

#sidebar .sidebar-header {
    padding: 20px;
    background: #04426E;
}

#sidebar ul.components {
    padding: 20px 0;
    border-bottom: 1px solid #47748b;
}

#sidebar ul p {
    color: #fff;
    padding: 10px;
}

#sidebar ul li a {
    padding: 10px;
    font-size: 1.1em;
    display: block;
}
#sidebar ul li a:hover {
    color: #7386D5;
    background: #fff;
}

#sidebar ul li.active > a, a[aria-expanded="true"] {
    color: #fff;
    background: #6d7fcc;
}
ul ul a {
    font-size: 0.9em !important;
    padding-left: 30px !important;
    background: #04426E;
}
</style>
<div id="content" style="position: absolute; left: 250px; top: 80px;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">



        </div>
    </nav>
</div>
<div class="wrapper">
    <nav id="sidebar" class="p-3">
        <h5 class="sidebar-brand d-flex align-items-center justify-content-center"">
            <div class="sidebar-brand-icon text-center">
                <a href="{{ url('/dashboard') }}">
                <span>
                <img class="p-1" src="{{ asset('images/cmulogo.png') }}" width="40">
                CMU Document Tracking System</span>
                </a>
            </div>
            <button type="button" id="sidebarCollapse" class="btn btn-info" style="position: relative; left:2.9vw;">
                <i class="fas fa-align-right"></i>
                <span></span>
            </button>
        </h5>
        <ul class="list-unstyled components">
            <li class="nav-item {{ request()->is('/dashboard') ? 'active' : ''}}">
                <a class="nav-link " href="{{ url('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item {{ request()->is('profile') ? 'active' : ''}}">
                <a class="nav-link " href="{{ url('user-profile') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>User Profile</span></a>
            </li>
            <li class="nav-item {{ request()->is('/user-management') ? 'active' : ''}}">
                <a class="nav-link" href="href="{{ url('user-management') }}"">
                    <i class="fas fa-fw fa-globe"></i>
                    <span>User Management</span></a>
            </li>
            <li class="nav-item {{ request()->is('/offices') ? 'active' : ''}}">
                <a class="nav-link" href="{{ url('offices') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Offices</span></a>
            </li>
            <li class="nav-item {{ request()->is('/doctype') ? 'active' : ''}}">
                <a class="nav-link" href="{{ url('docType') }}">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Document Type</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="fas fa-fw fa-user"></i>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
</div>
<script>
    $(document).ready(function () {

    $('#sidebarCollapse').on('click', function () {
    $('#sidebar').toggleClass('active');
    });
});
</script>
