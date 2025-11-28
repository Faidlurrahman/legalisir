<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            background: #fdfdfb;
            font-family: 'Poppins', Arial, sans-serif;
            color: #1c1c1c;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 220px;
            background: #fff;
            color: #0b5b57;
            min-height: 100vh;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            box-shadow: 4px 0 24px rgba(0,0,0,0.10);
            border-top-right-radius: 18px;
            border-bottom-right-radius: 18px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: width .25s cubic-bezier(.4,2,.6,1), box-shadow .25s;
            z-index: 999;
        }
        .sidebar.collapsed { width: 64px; }
        .sidebar-profile {
            text-align: center;
            padding: 24px 0 16px;
            border-bottom: 1px solid #f0f0f0;
            transition: all .25s;
        }
        .sidebar-profile-circle {
            width: 48px; height: 48px;
            border-radius: 50%;
            background: #0b5b57;
            color: #fff;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 6px auto;
            font-size: 1.3rem;
            letter-spacing: 1px;
            user-select: none;
        }
        .sidebar.collapsed .sidebar-profile-circle {
            width: 32px; height: 32px;
            font-size: 0.95rem;
        }
        .sidebar-profile-name {
            font-size: 0.95rem;
            font-weight: 600;
            transition: opacity .2s;
        }
        .sidebar-profile-email {
            font-size: 0.82rem;
            color: #0b5b57;
            transition: opacity .2s, color .2s;
        }
        .sidebar.collapsed .sidebar-profile-name,
        .sidebar.collapsed .sidebar-profile-email {
            opacity: 0;
            pointer-events: none;
        }
        .sidebar .nav-link {
            color: #0b5b57;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 8px;
            margin: 5px 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background .2s, color .2s;
            position: relative;
            font-size: 0.98rem;
        }
        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active {
            background: #0b5b57 !important;
            color: #fff !important;
        }
        .sidebar .nav-link i {
            font-size: 1.15rem;
            min-width: 24px;
            color: #0b5b57 !important;
            transition: color .2s;
        }
        .sidebar .nav-link:hover i,
        .sidebar .nav-link.active i {
            color: #fff !important;
        }
        .sidebar.collapsed .nav-link { justify-content: center; }
        .sidebar.collapsed .nav-link span { display: none; }
        .sidebar.collapsed .nav-link::after {
            content: attr(data-label);
            position: absolute;
            left: calc(100% + 4px);
            top: 50%;
            transform: translateY(-50%) scale(0.95);
            background: #0b5b57;
            color: #fff;
            padding: 5px 14px;
            border-radius: 8px;
            opacity: 0;
            pointer-events: none;
            white-space: nowrap;
            font-size: 0.98rem;
            font-weight: 600;
            box-shadow: 0 4px 18px rgba(0,0,0,0.13);
            transition: opacity .28s, transform .28s, box-shadow .28s;
            z-index: 9999;
        }
        .sidebar.collapsed .nav-link:hover::after {
            opacity: 1;
            transform: translateY(-50%) scale(1.07) translateX(6px);
            box-shadow: 0 4px 18px rgba(26,168,151,0.18);
        }
        .sidebar-logout {
            border-top: 1px solid #f0f0f0;
            padding: 0.8rem;
        }
        .btn-logout {
            width: 100%;
            background: transparent !important;
            color: #dc3545 !important;
            border: none;
            border-radius: 8px;
            padding: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-size: 0.98rem;
            transition: background 0.2s, color 0.2s;
        }
        .btn-logout i { color: #dc3545 !important; }
        .btn-logout:hover, .btn-logout:focus {
            background: rgba(220,53,69,0.08) !important;
            color: #b52a37 !important;
        }
        .btn-logout:hover i, .btn-logout:focus i { color: #b52a37 !important; }
        .sidebar.collapsed .btn-logout {
            width: 32px; height: 32px; padding: 0; border-radius: 50%; justify-content: center; font-size: 1.1rem;
        }
        .sidebar.collapsed .btn-logout span { display: none; }

        /* --- HEADER --- */
        .header-app {
            background: #fff;
            color: #0b5b57;
            padding: 10px 28px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 0;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom-left-radius: 18px;
            border-bottom-right-radius: 18px;
        }
        .header-left {
            display: flex;
            align-items: center;
            margin-right: auto;
            gap: 8px;
        }
        .header-sidebar-toggle {
            cursor: pointer;
            font-size: 1.15rem;
            background: #e6f7f5;
            padding: 5px 8px;
            border-radius: 8px;
            transition: background .2s, color .2s, transform .5s cubic-bezier(.4,2,.6,1);
            color: #0b5b57;
            display: flex;
            align-items: center;
            animation: rotateIcon 2s linear infinite;
        }
        @keyframes rotateIcon {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }
        .header-sidebar-toggle i { color: #0b5b57 !important; }
        .header-sidebar-toggle:hover { background: #0b5b57 !important; color: #fff !important; }
        .header-sidebar-toggle:hover i { color: #fff !important; }
        .header-title {
            font-size: 1.08rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #0b5b57;
            transition: color .2s;
        }
        .header-profile-circle {
            width: 32px; height: 32px;
            border-radius: 50% !important;
            background: #0b5b57 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #fff !important;
            cursor: pointer;
            text-decoration: none !important;
            font-size: 1rem;
            letter-spacing: 1px;
            user-select: none;
            transition: box-shadow .18s;
        }
        .header-profile-circle:focus {
            outline: none;
            box-shadow: 0 0 0 2px #0b5b5733;
        }

        /* --- CONTENT --- */
        .content-area {
            margin-left: 220px;
            min-height: 100vh;
            background: #fdfdfb;
            transition: margin-left .25s ease;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .sidebar.collapsed ~ .content-area { margin-left: 64px; }
        main.flex-fill { padding: 22px; flex: 1; }

        /* --- FOOTER --- */
        .footer-app {
            background: #f5f5f5;
            color: #0b5b57;
            padding: 28px 0 18px;
            text-align: center;
            border-top: 1.5px solid #e0e0e0;
            margin-top: auto;
        }
        .footer-brand {
            font-size: 1.2rem;
            font-weight: 700;
            color: #0b5b57;
            margin-bottom: 4px;
        }
        .footer-app small { color: #4b7977; }

        /* --- RESPONSIVE --- */
        @media (max-width: 900px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
                border-radius: 0;
                box-shadow: none;
            }
            .content-area { margin-left: 0; }
            .header-app { padding: 8px 10px; }
            .footer-app { padding: 18px 0 10px; }
        }
    </style>
</head>
<body>
@if (!isset($isLoginPage) || !$isLoginPage)
<div class="layout-main">
    {{-- SIDEBAR --}}
    <nav class="sidebar" id="sidebar">
        <div>
            <div class="sidebar-profile">
                <div class="sidebar-profile-circle">
                    {{ strtoupper(substr(session('admin_name', 'A'),0,1)) }}
                </div>
                <div class="sidebar-profile-name">{{ session('admin_name', 'Admin') }}</div>
                <div class="sidebar-profile-email">{{ session('admin_email', 'admin@example.com') }}</div>
            </div>
            <ul class="nav flex-column mt-3">
                <li>
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}" data-label="Dashboard">
                        <i class="fa fa-house-user"></i><span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('formLegalisir') ? 'active' : '' }}" 
                       href="{{ route('formLegalisir') }}" data-label="Input Legalisir">
                        <i class="fa fa-file-signature"></i><span>Input Legalisir</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('admin.data') ? 'active' : '' }}" 
                       href="{{ route('admin.data') }}" data-label="Data Legalisir">
                        <i class="fa fa-folder-open"></i><span>Data Legalisir</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('admin.laporan') ? 'active' : '' }}" 
                       href="{{ route('admin.laporan') }}" data-label="Laporan">
                        <i class="fa fa-clipboard-list"></i><span>Laporan</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-logout">
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">@csrf
                <button type="button" class="btn-logout" data-bs-toggle="modal" data-bs-target="#confirmLogoutModal">
                    <i class="fa fa-sign-out-alt"></i> <span>Logout</span>
                </button>
            </form>
        </div>
    </nav>

    {{-- CONTENT --}}
    <div class="content-area">
        {{-- HEADER --}}
        <header class="header-app">
            <div class="header-left">
                <div class="header-sidebar-toggle" onclick="toggleSidebar()" title="Perkecil / Perbesar Sidebar">
                    <i class="fa fa-bars"></i>
                </div>
                <div class="header-title">DISDUKCAPIL KOTA CIREBON</div>
            </div>
            <!-- Profile Logo: langsung ke profile -->
            <a href="{{ route('admin.profile') }}" class="header-profile-circle" style="text-decoration:none;">
                {{ strtoupper(substr(session('admin_name', 'A'),0,1)) }}
            </a>
        </header>

        <main class="flex-fill">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="footer-app">
            <div class="footer-brand">LEGALISIR AKTA PENDUDUK</div>
            <small>&copy; {{ date('Y') }} Dinas Kependudukan dan Pencatatan Sipil Kota Cirebon</small>
        </footer>
    </div>
</div>

{{-- MODAL LOGOUT --}}
<div class="modal fade" id="confirmLogoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content text-center p-3">
      <div class="modal-body">
        <div class="mb-2 fw-semibold">Apakah Anda Yakin?</div>
        <div class="mb-3 small text-muted">Anda akan keluar dari aplikasi.</div>
        <div class="d-flex justify-content-center gap-2">
          <button type="button" class="btn btn-danger btn-sm" id="btnLogoutYes">YA</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">BATAL</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.querySelector('.header-sidebar-toggle');
    const collapsed = sidebar.classList.toggle('collapsed');
    localStorage.setItem('sidebar-collapsed', collapsed ? '1' : '');

    // 6. Animasi icon berputar
    if (toggleBtn) {
        toggleBtn.classList.add('rotating');
        setTimeout(() => toggleBtn.classList.remove('rotating'), 600);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    if(localStorage.getItem('sidebar-collapsed') === '1') sidebar.classList.add('collapsed');
    document.getElementById('btnLogoutYes')?.addEventListener('click', () => document.getElementById('logout-form').submit());
});
</script>
@else
    @yield('content')
@endif
@stack('scripts')
</body>
</html>