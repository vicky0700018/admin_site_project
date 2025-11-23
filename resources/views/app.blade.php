<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --dark: #1e1e2c;
            --light: #f8f9fa;
            --gray: #6c757d;
            --danger: #e5383b;
            --sidebar-width: 250px;
            --header-height: 70px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: #333;
            line-height: 1.6;
        }

        /* Layout */
        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--dark);
            color: white;
            transition: var(--transition);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-header h3 {
            font-weight: 600;
            font-size: 1.5rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            transition: var(--transition);
            cursor: pointer;
            color: #aaa;
            text-decoration: none;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .menu-item.active {
            background: var(--primary);
            color: white;
        }

        .menu-item i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
        }

        /* Header */
        .header {
            background: white;
            height: var(--header-height);
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 0.75rem;
        }

        /* Content Area */
        .content {
            padding: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            
            .sidebar-header h3, .menu-item span {
                display: none;
            }
            
            .menu-item i {
                margin-right: 0;
                font-size: 1.3rem;
            }
            
            .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 0 1rem;
            }
            
            .content {
                padding: 1rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3>{{ auth()->user()->role === 'admin' ? 'Admin Panel' : 'SubAdmin Panel' }}</h3>
            </div>
            <div class="sidebar-menu">
                <!-- Dashboard link changes based on role -->
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('subadmin.dashboard') }}" 
                   class="menu-item {{ request()->routeIs(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'subadmin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Show Users tab ONLY if Admin -->
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.subadmins') }}" 
                       class="menu-item {{ request()->routeIs('admin.subadmins') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                @endif

               <!-- Leads visible ONLY to Subadmin -->
    @if(auth()->user()->role === 'subadmin')
        <a href="{{ route('subadmin.leads.index') }}" class="menu-item {{ request()->routeIs('subadmin.leads.index') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <span>Leads</span>
        </a>
    @endif
                <a href="{{ route('subadmin.leads.documents.index') }}" class="menu-item">
                    <i class="fas fa-file-alt"></i>
                    <span>Documents</span>
                </a>

                <!-- Logout -->
                <a href="{{ route('admin.logout') }}" class="menu-item"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div></div>
                <div class="user-info">
                    <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <div>
                        <strong>{{ auth()->user()->name }}</strong>
                        <div style="font-size: 0.8rem; color: var(--gray);">
                            {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Subadmin' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>