{{-- filepath: resources/views/admin/layout.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin-login.css') }}" rel="stylesheet">
    <style>
        body { background: #f8f9fa; font-family: 'Poppins', Arial, sans-serif; }
        .layout-main {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 240px;
            background: linear-gradient(180deg, #f7fbfd 80%, #e3f6fc 100%);
            color: #23272f;
            min-height: 100vh;
            box-shadow: 2px 0 16px rgba(56,178,172,0.08);
            position: fixed;
            left: 0; top: 0; bottom: 0;
            z-index: 200;
            padding-bottom: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar-profile {
            margin-bottom: 2rem;
            padding-top: 32px;
            padding-bottom: 16px;
            border-bottom: 1px solid #b6e0f2;
            text-align: center;
        }
        .sidebar-profile-circle {
            width: 60px; height: 60px;
            border-radius: 50%;
            background: rgb(0, 119, 62);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; font-weight: 600;
            margin: 0 auto 8px auto;
            box-shadow: 0 2px 8px rgba(56,178,172,0.12);
        }
        .sidebar-profile-name {
            font-size: 1.04rem;
            font-weight: 600;
            color: #23272f;
            margin-bottom: 1px;
            letter-spacing: 0.2px;
        }
        .sidebar-profile-email {
            font-size: 0.93rem;
            color: #3b4a5a;
            margin-bottom: 0;
            font-weight: 400;
        }
        .sidebar .nav-link {
            color: #23272f;
            font-weight: 500;
            border-radius: 8px;
            transition: background .2s, color .2s, font-weight .2s;
            font-size: 0.98rem;
            padding: 9px 16px;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: rgba(0, 119, 62, 0.13);
            color: rgb(0, 119, 62);
            font-weight: 600;
            letter-spacing: 0.2px;
            text-decoration: none !important;
        }
        .sidebar-logout {
            margin-top: 2rem;
            border-top: 1px solid #b6e0f2;
            padding-top: 1.5rem;
        }
        .sidebar .btn-logout {
            width: 100%;
            background: linear-gradient(90deg, rgb(0, 119, 62) 60%, #fbbf24 100%);
            color: #fff;
            font-weight: 500;
            border-radius: 8px;
            padding: 9px 0;
            margin-top: 8px;
            transition: background .2s, box-shadow .2s;
            box-shadow: 0 2px 8px rgba(248,113,113,0.12);
            font-size: 0.97rem;
        }
        .sidebar .btn-logout:hover {
            background: linear-gradient(90deg, rgb(0, 119, 62) 60%, #f59e42 100%);
            box-shadow: 0 4px 16px rgba(248,113,113,0.18);
        }
        .content-area {
            flex: 1 1 auto;
            margin-left: 240px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #f8f9fa;
        }
        .header-app {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 28px 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 56px;
            position: sticky;
            top: 0;
            z-index: 101;
        }
        .header-title {
            font-size: 1.08rem;
            font-weight: 600;
            color: rgb(0, 119, 62);
            letter-spacing: 0.5px;
        }
        .header-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .header-profile-circle {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: rgb(0, 119, 62);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.05rem; font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(56,178,172,0.12);
            transition: box-shadow .2s;
        }
        .header-profile-circle:hover {
            box-shadow: 0 4px 16px rgba(56,178,172,0.18);
        }
        main.flex-fill {
            flex: 1 1 auto;
            padding: 28px 18px;
            background: #f8f9fa;
            min-height: 0;
            font-size: 0.99rem;
        }
        .footer-app {
            background: #fff;
            border-top: 1px solid #e2e8f0;
            color: #23272f;
            margin-top: 0;
            font-family: 'Poppins', Arial, sans-serif;
            padding: 38px 0 28px 0;
            box-shadow: 0 2px 16px rgba(56,178,172,0.08);
            border-radius: 0 0 16px 16px;
        }
        .footer-brand {
            font-size: 1.35rem;
            font-weight: 700;
            color: rgb(0, 119, 62);
            letter-spacing: 1px;
        }
        .footer-desc {
            font-size: 0.89rem;
            color: #b6e0f2;
            margin-bottom: 10px;
            font-weight: 400;
        }
        .footer-link {
            color: #23272f;
            font-weight: 500;
            text-decoration: none;
            font-size: 1.08rem;
            letter-spacing: 0.2px;
            transition: background .2s, color .2s, font-weight .2s;
            padding: 8px 18px;
            border-radius: 8px;
            background: #f7fbfd;
        }
        .footer-link + .footer-link { margin-left: 8px; }
        .footer-link:hover, .footer-link.active {
            background: #38b2ac22;
            color: #007C89;
            font-weight: 600;
            text-decoration: underline;
        }
        .footer-maps {
            background: #23272f;
            border-radius: 8px;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            color: #1e293b;
            box-shadow: 0 2px 8px rgba(56,178,172,0.08);
            overflow: hidden;
        }
        .footer-maps iframe {
            border: none;
            width: 100%;
            height: 80px;
            border-radius: 8px;
            filter: grayscale(10%) contrast(1.1);
        }
        .footer-address {
            font-size: 0.95rem;
            color: #b6e0f2;
            margin-top: 8px;
            font-weight: 500;
            letter-spacing: 0.2px;
        }
        @media (max-width: 900px) {
            .layout-main { flex-direction: column; }
            .sidebar { position: static; width: 100%; min-height: auto; }
            .content-area { margin-left: 0; min-height: auto; }
            main.flex-fill { padding: 14px 4px; }
            .header-app { padding: 10px 8px 10px 8px; }
            .footer-maps iframe { height: 60px; }
            .footer-menu { margin-top: 12px; justify-content: center; }
            .footer-brand { text-align: center; margin-bottom: 8px; }
        }
    </style>
</head>
<body>
    @if (!isset($isLoginPage) || !$isLoginPage)
        <div class="layout-main">
            {{-- SIDEBAR --}}
            <nav class="sidebar p-3">
                <div>
                    <div class="sidebar-profile">
                        <div class="sidebar-profile-circle mb-2">
                            {{ strtoupper(substr(session('admin_name', 'A'),0,1)) }}
                        </div>
                        <div class="sidebar-profile-name mb-1">
                            {{ session('admin_name', 'Admin') }}
                        </div> 
                        <div class="sidebar-profile-email mb-2">
                            {{ session('admin_email', 'admin@example.com') }}
                        </div>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fa fa-home me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('admin.data') ? 'active' : '' }}" href="{{ route('admin.data') }}">
                                <i class="fa fa-database me-2"></i>Data Legalisir
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('admin.laporan') ? 'active' : '' }}" href="{{ route('admin.laporan') }}">
                                <i class="fa fa-file-alt me-2"></i>Laporan
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link {{ request()->routeIs('formLegalisir') ? 'active' : '' }}" href="{{ route('formLegalisir') }}">
                                <i class="fa fa-plus me-2"></i>Input Legalisir
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="sidebar-logout">
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">@csrf
                        <button type="submit" class="btn btn-logout">
                            <i class="fa fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </nav>
            <div class="content-area">
                {{-- HEADER --}}
                <header class="header-app">
                    <div class="header-title">
                        DISDUKCAPIL KOTA CIREBON
                    </div>
                    <div class="header-profile">
                        <a href="{{ route('admin.profile') }}" title="Profile">
                            <div class="header-profile-circle">
                                <i class="fa fa-user"></i>
                            </div>
                        </a>
                    </div>
                </header>
                <main class="flex-fill">
                    @yield('content')
                </main>
                {{-- FOOTER --}}
                <footer class="footer-app">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-12 d-flex flex-column justify-content-center align-items-center py-2">
                                <div class="footer-brand text-center">
                                    LEGALISIR AKTA PENDUDUK
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4" style="font-size:1.08rem; color:#3b4a5a; font-weight:500; letter-spacing:0.2px;">
                            &copy; {{ date('Y') }} Disdukcapil. All rights reserved.
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    @else
        @yield('content')
    @endif
    @stack('scripts')
</body>
</html>
