<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Government School</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/css/admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/datatables-custom.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/utilities.css') }}">
    
    @yield('styles')
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="header-content">
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fa fa-bars"></i>
            </button>
            <div class="logo-section">
                <img src="{{ asset('admin/images/logo/school_logo.png') }}" alt="School Logo" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22%3E%3Crect width=%2260%22 height=%2260%22 fill=%22transparent%22/%3E%3Ctext x=%2230%22 y=%2234%22 text-anchor=%22middle%22 font-family=%22Poppins%22 font-size=%2220%22 fill=%22%23ffffff%22 font-weight=%22700%22%3EGS%3C/text%3E%3C/svg%3E'">
                
            </div>
            <div class="user-section">
                <div class="user-avatar">
                    <i class="fa fa-user"></i>
                </div>
                <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fa fa-sign-out-alt"></i> <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Admission Menu -->
            <li class="menu-item has-submenu {{ request()->routeIs('admin.admission.*') ? 'open' : '' }}">
                <a href="#" class="menu-link">
                    <i class="fa fa-graduation-cap"></i>
                    <span>Admission</span>
                </a>
                <ul class="submenu {{ request()->routeIs('admin.admission.*') ? 'open' : '' }}">
                    <li class="submenu-item">
                        <a href="{{ route('admin.admission.index') }}" class="{{ request()->routeIs('admin.admission.index') ? 'active' : '' }}">
                            <i class="fa fa-list"></i> Manage Admission
                        </a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{ route('admin.admission.create') }}" class="{{ request()->routeIs('admin.admission.create') ? 'active' : '' }}">
                            <i class="fa fa-plus"></i> Add New Admission
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Computer Admission Menu -->
            <li class="menu-item has-submenu {{ request()->routeIs('admin.computer_admission.*') ? 'open' : '' }}">
                <a href="#" class="menu-link">
                    <i class="fa fa-desktop"></i>
                    <span>Computer Admission</span>
                </a>
                <ul class="submenu {{ request()->routeIs('admin.computer_admission.*') ? 'open' : '' }}">
                    <li class="submenu-item">
                        <a href="{{ route('admin.computer_admission.index') }}" class="{{ request()->routeIs('admin.computer_admission.index') ? 'active' : '' }}">
                            <i class="fa fa-list"></i> Manage Computer Admission
                        </a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{ route('admin.computer_admission.reports') }}" class="{{ request()->routeIs('admin.computer_admission.reports') ? 'active' : '' }}">
                            <i class="fa fa-chart-bar"></i> Computer Admission Reports
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Saraswati Puja Committee Menu -->
            <li class="menu-item has-submenu {{ request()->routeIs('admin.saraswati_puja.*') ? 'open' : '' }}">
                <a href="#" class="menu-link">
                    <i class="fa fa-hands-praying"></i>
                    <span>Saraswati Puja Committee</span>
                </a>
                <ul class="submenu {{ request()->routeIs('admin.saraswati_puja.*') ? 'open' : '' }}">
                    <li class="submenu-item">
                        <a href="{{ route('admin.saraswati_puja.index') }}" class="{{ request()->routeIs('admin.saraswati_puja.index') ? 'active' : '' }}">
                            <i class="fa fa-list"></i> Manage Saraswati Puja Fee
                        </a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{ route('admin.saraswati_puja.reports') }}" class="{{ request()->routeIs('admin.saraswati_puja.reports') ? 'active' : '' }}">
                            <i class="fa fa-chart-bar"></i> Saraswati Puja Fee Reports
                        </a>
                    </li>
                </ul>
            </li>

            <!-- User Management Menu -->
            <li class="menu-item has-submenu {{ request()->routeIs('admin.users.*') ? 'open' : '' }}">
                <a href="#" class="menu-link">
                    <i class="fa fa-users"></i>
                    <span>User Management</span>
                </a>
                <ul class="submenu {{ request()->routeIs('admin.users.*') ? 'open' : '' }}">
                    <li class="submenu-item">
                        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                            <i class="fa fa-list"></i> Manage Users
                        </a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{ route('admin.users.create') }}" class="{{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                            <i class="fa fa-plus"></i> Add New User
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Student Management Menu -->
            <li class="menu-item has-submenu {{ request()->routeIs('admin.students.*') ? 'open' : '' }}">
                <a href="#" class="menu-link">
                    <i class="fa fa-user-graduate"></i>
                    <span>Student Management</span>
                </a>
                <ul class="submenu {{ request()->routeIs('admin.students.*') ? 'open' : '' }}">
                    <li class="submenu-item">
                        <a href="{{ route('admin.students.index') }}" class="{{ request()->routeIs('admin.students.index') ? 'active' : '' }}">
                            <i class="fa fa-list"></i> Manage Students
                        </a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{ route('admin.students.create') }}" class="{{ request()->routeIs('admin.students.create') ? 'active' : '' }}">
                            <i class="fa fa-plus"></i> Add New Student
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Collect Fees Menu -->
            <li class="menu-item {{ request()->routeIs('admin.collect_fees.*') ? 'active' : '' }}">
                <a href="{{ route('admin.collect_fees.index') }}" class="menu-link">
                    <i class="fa fa-indian-rupee-sign"></i>
                    <span>Collect Fees</span>
                </a>
            </li>

            <!-- Library Management Menu -->
            <li class="menu-item {{ request()->routeIs('admin.library.*') ? 'active' : '' }}">
                <a href="{{ route('admin.library.index') }}" class="menu-link">
                    <i class="fa fa-book"></i>
                    <span>Library Management</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fa fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <ul class="breadcrumb-list">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fa fa-home"></i> Home
                    </a>
                </li>
                @yield('breadcrumb')
            </ul>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- DataTables JS and CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    
    <!-- Admin JS -->
    <script src="{{ asset('admin/js/admin-script.js') }}"></script>
    
    @yield('scripts')
</body>
</html>
