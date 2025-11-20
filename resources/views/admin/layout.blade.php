{{-- filepath: resources/views/admin/layout.blade.php --}}
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
        }

        /* === SIDEBAR === */
        .sidebar {
            width: 240px;
            background: linear-gradient(180deg, #0b5b57 60%, #0e736e 100%);
            color: #fff;
            min-height: 100vh;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            border-right: 3px solid #f7a61c;
            box-shadow: 4px 0 20px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: width .25s cubic-bezier(.4,2,.6,1), box-shadow .25s;
            z-index: 999;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-profile {
            text-align: center;
            padding: 32px 0 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            transition: all .25s;
        }

        /* 1. Inisial admin, latar oranye, tanpa icon file */
        .sidebar-profile-circle {
            width: 60px; height: 60px;
            border-radius: 50%;
            background: #f7a61c;
            color: #fff;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 8px auto;
            font-size: 1.7rem;
            letter-spacing: 1px;
            text-decoration: none; /* 2. Hilangkan underline */
            transition: width .25s, height .25s, font-size .25s;
            user-select: none;
        }
        .sidebar.collapsed .sidebar-profile-circle {
            width: 38px; height: 38px;
            font-size: 1.1rem;
        }

        .sidebar-profile-name {
            font-size: 1rem;
            font-weight: 600;
            transition: opacity .2s;
        }

        .sidebar-profile-email {
            font-size: 0.85rem;
            color: #e0f0ef;
            transition: opacity .2s;
        }

        .sidebar.collapsed .sidebar-profile-name,
        .sidebar.collapsed .sidebar-profile-email {
            opacity: 0;
            pointer-events: none;
        }

        .sidebar .nav-link {
            color: #ffffff;
            font-weight: 500;
            padding: 10px 18px;
            border-radius: 8px;
            margin: 6px 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background .2s, color .2s;
            position: relative;
        }

        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }

        .sidebar .nav-link i {
            font-size: 1.25rem;
            min-width: 28px;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        /* 7. Tooltip hover untuk sidebar collapsed */
        .sidebar.collapsed .nav-link::after {
            content: attr(data-label);
            position: absolute;
            left: calc(100% + 4px);
            top: 50%;
            transform: translateY(-50%) scale(0.95);
            background: #0b5b57; /* Warna hijau utama, tanpa gradasi */
            color: #fff;
            padding: 6px 18px;
            border-radius: 10px;
            opacity: 0;
            pointer-events: none;
            white-space: nowrap;
            font-size: 1rem;
            font-weight: 600;
            box-shadow: 0 4px 18px rgba(0,0,0,0.18);
            transition: 
                opacity .28s cubic-bezier(.4,2,.6,1), 
                transform .28s cubic-bezier(.4,2,.6,1),
                box-shadow .28s cubic-bezier(.4,2,.6,1);
            z-index: 9999;
            border-left: 4px solid #f7a61c; /* Oranye */
        }
        .sidebar.collapsed .nav-link:hover::after {
            opacity: 1;
            transform: translateY(-50%) scale(1.07) translateX(6px);
            box-shadow: 0 4px 18px rgba(247,166,28,0.18); /* Oranye transparan */
            background: #f7a61c; /* Oranye penuh */
            color: #fff;
        }

        .sidebar-logout {
            border-top: 1px solid rgba(255,255,255,0.25);
            padding: 1rem;
        }

        /* 5. Logout button: collapsed = icon merah saja */
        .btn-logout {
            width: 100%;
            background: #dc3545 !important;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px;
            font-weight: 600;
            transition: background 0.3s, color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-logout:hover {
            background: #b52a37 !important;
        }
        .sidebar.collapsed .btn-logout {
            background: #dc3545 !important;
            color: #fff;
            width: 38px;
            height: 38px;
            padding: 0;
            border-radius: 50%;
            justify-content: center;
            font-size: 1.2rem;
        }
        .sidebar.collapsed .btn-logout span {
            display: none;
        }

        /* === HEADER === */
        .header-app {
            background: #0b5b57;
            color: #fff;
            padding: 14px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* 3. Icon sidebar toggle & judul oranye */
        .header-sidebar-toggle {
            cursor: pointer;
            font-size: 1.3rem;
            background: rgba(255,255,255,0.15);
            padding: 6px 10px;
            border-radius: 8px;
            transition: background .2s, color .2s, transform .5s cubic-bezier(.4,2,.6,1);
            color: #f7a61c;
            display: flex;
            align-items: center;
        }
        .header-sidebar-toggle:hover {
            background: rgba(255,255,255,0.3);
            color: #f7a61c;
        }
        .header-sidebar-toggle.rotating {
            animation: rotateIcon .6s cubic-bezier(.4,2,.6,1);
        }
        @keyframes rotateIcon {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }
        .header-sidebar-toggle i {
            animation: rotateIcon 2.5s linear infinite;
        }

        .header-title {
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #fff; /* Ubah ke putih */
            transition: color .2s;
        }

        .header-profile-circle {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: #f7a61c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            text-decoration: none; /* 2. Hilangkan underline */
            font-size: 1.1rem;
            letter-spacing: 1px;
            user-select: none;
        }

        /* === CONTENT === */
        .content-area {
            margin-left: 240px;
            min-height: 100vh;
            background: #fdfdfb;
            transition: margin-left .25s ease;
        }

        .sidebar.collapsed ~ .content-area {
            margin-left: 70px;
        }

        main.flex-fill {
            padding: 30px;
        }

        /* === FOOTER === */
        .footer-app {
            background: #f5f5f5;      /* Abu terang */
            color: #0b5b57;
            padding: 40px 0 30px;
            text-align: center;
            border-top: 1.5px solid #e0e0e0;
        }

        .footer-brand {
            font-size: 1.4rem;
            font-weight: 700;
            color: #0b5b57;           /* Hijau */
            margin-bottom: 5px;
        }

        .footer-app small {
            color: #4b7977;
        }

        /* === RESPONSIVE === */
        @media (max-width: 900px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }
            .content-area {
                margin-left: 0;
            }
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
            <a href="{{ route('admin.profile') }}" class="header-profile-circle">
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
