<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Presensi Al Asy\'ariyyah') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        
:root {
            --primary: #0d9488;
            --primary-dark: #0f766e;
            --primary-light: #14b8a6;
            --primary-hover: #0d9488;
            --primary-gradient-from: #0d9488;
            --primary-gradient-to: #0f766e;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --light: #f8fafc;
            --white: #ffffff;
            --gray: #94a3b8;
            --border: #e2e8f0;
            --sidebar-width: 260px;
            --topbar-height: 64px;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
        }

        /* Admin body class */
        body.admin-dashboard {
            background: #f0f2f5;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Firefox Scrollbar */
        * {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        /* Shimmer Loading Animation */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 8px;
        }

        /* Page transitions */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in {
            animation: fadeInUp 0.4s ease forwards;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-gradient-from) 0%, var(--primary-gradient-to) 100%);
            color: white;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            overflow: hidden;
            overscroll-behavior: contain; /* Mencegah scroll chaining ke halaman utama */
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 8px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
        }

        .logo-text {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.2;
        }

        .logo-subtitle {
            font-size: 10px;
            color: rgba(255,255,255,0.7);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-menu {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
            overscroll-behavior: contain; /* Mencegah scroll chaining */
        }

        .menu-section {
            margin-bottom: 20px;
        }

        .menu-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,0.5);
            padding: 8px 12px;
            margin-bottom: 4px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 4px;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .menu-item.active {
            background: rgba(255,255,255,0.2);
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .menu-item i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .menu-item span {
            flex: 1;
        }

        .menu-badge {
            background: var(--danger);
            color: white;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--warning);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: white;
        }

        .user-role {
            font-size: 11px;
            color: rgba(255,255,255,0.6);
            text-transform: capitalize;
        }

        .logout-btn {
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.1);
            border: none;
            border-radius: 8px;
            color: rgba(255,255,255,0.7);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: var(--danger);
            color: white;
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
            cursor: pointer;
        }

        .user-dropdown-menu {
            position: absolute;
            bottom: 100%;
            left: 0;
            right: 0;
            margin-bottom: 8px;
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 8px;
            display: none;
        }

        .user-dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            color: var(--dark);
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background: var(--light);
            color: var(--primary);
        }

        /* Main Content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            position: sticky;
            top: 0;
            height: var(--topbar-height);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .menu-toggle {
            display: none;
            width: 40px;
            height: 40px;
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            color: var(--dark);
        }

        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
        }

        .breadcrumb {
            font-size: 12px;
            color: var(--gray);
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-icon-btn {
            width: 40px;
            height: 40px;
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary);
            position: relative;
        }

        .topbar-icon-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 18px;
            height: 18px;
            background: var(--danger);
            color: white;
            font-size: 10px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .topbar-date {
            font-size: 13px;
            color: var(--gray);
            padding: 8px 16px;
            background: var(--light);
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .page-content {
            flex: 1;
            padding: 24px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .menu-toggle {
                display: flex;
            }

            .topbar-date {
                display: none;
            }
            .schedule-card-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Cards */
        .card {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark);
        }

        /* Stats Grid - ONLY for non-admin pages */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        /* Target ONLY non-admin pages: santri dashboard, etc */
        body:not(.admin-body) .stat-card {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.06), 0 2px 6px rgba(0,0,0,0.04);
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .stat-icon.blue { background: #dbeafe; color: var(--primary); }
        .stat-icon.green { background: #d1fae5; color: var(--success); }
        .stat-icon.red { background: #fee2e2; color: var(--danger); }
        .stat-icon.yellow { background: #fef3c7; color: var(--warning); }
        .stat-icon.purple { background: #ede9fe; color: #7c3aed; }

        .stat-content h3 {
            font-size: 22px;
            font-weight: 700;
            color: var(--dark);
            line-height: 1.15;
            margin: 0 0 2px 0;
        }

        .stat-content p {
            font-size: 11px;
            color: var(--gray);
            margin: 0;
        }

        /* Tables */
        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            padding: 14px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--gray);
            background: var(--light);
            border-bottom: 1px solid var(--border);
        }

        .data-table td {
            padding: 16px;
            font-size: 14px;
            color: var(--dark);
            border-bottom: 1px solid var(--border);
        }

        .data-table tbody tr:hover {
            background: var(--light);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .badge-primary { background: #dbeafe; color: var(--primary); }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: var(--light);
            color: var(--dark);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--border);
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        /* Forms */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            background: white;
            cursor: pointer;
        }

        /* Alert */
        .alert {
            padding: 14px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .alert.fading {
            opacity: 0;
            transform: translateY(-8px);
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
            height: 0;
            overflow: hidden;
            border-width: 0;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Pagination */
        .pagination {
            display: flex;
            gap: 8px;
            margin-top: 20px;
        }

        .pagination a, .pagination span {
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            text-decoration: none;
            border: 1px solid var(--border);
            color: var(--dark);
        }

        /* Notification */
        .notification-wrapper {
            position: relative;
        }

        .notification-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            min-width: 280px;
            z-index: 1000;
            overflow: hidden;
        }

        .notification-dropdown.show {
            display: block;
        }

        .notification-header {
            padding: 12px 16px;
            font-weight: 600;
            border-bottom: 1px solid var(--border);
            background: #f8fafc;
        }

        .notification-item {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border);
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-empty {
            padding: 20px;
            text-align: center;
            color: var(--gray);
        }

        .pagination a:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination .active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Schedule card override - dashboard uses inline styles */
        @media (max-width: 768px) {
            .schedule-card-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="{{ Request::is('admin/*') ? 'admin-dashboard' : '' }}">
    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <aside class="sidebar">
<div class="sidebar-header">
                <div class="sidebar-logo">
                    <img src="{{ asset('images/alasyariyyah logo.png') }}" alt="Logo" style="width:48px; height:48px; object-fit:contain;" onerror="this.style.display='none';">
                    <div class="logo-text">
                        Al Asy'ariyyah
                    </div>
                </div>
                <div class="logo-subtitle">Madrasah Diniyah Salafiyah</div>
            </div>
        
         <nav class="sidebar-menu">
              @auth
                  @if (auth()->user()->role === 'admin')
                      <div class="menu-section">
                          <div class="menu-title">Menu Utama</div>
                          
                          <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                              <i class="fas fa-home"></i>
                              <span>Dashboard</span>
                          </a>
                          
                          <a href="{{ route('presensi.index') }}" class="menu-item {{ request()->routeIs('presensi.*') ? 'active' : '' }}">
                              <i class="fas fa-clipboard-check"></i>
                              Presensi
                          </a>
                          
                          <a href="{{ route('santri.index') }}" class="menu-item {{ request()->routeIs('santri.*') ? 'active' : '' }}">
                              <i class="fas fa-users"></i>
                              <span>Data Santri</span>
                          </a>
                      </div>
                      
                      <div class="menu-section">
                          <div class="menu-title">Laporan & Statistik</div>
                          
                          <a href="{{ route('rekap.presensi') }}" class="menu-item {{ request()->routeIs('rekap.presensi') ? 'active' : '' }}">
                              <i class="fas fa-chart-bar"></i>
                              Rekap Presensi
                          </a>
                          
                          <a href="{{ route('rekap.denda') }}" class="menu-item {{ request()->routeIs('rekap.denda') ? 'active' : '' }}">
                              <i class="fas fa-money-check-alt"></i>
                              <span>Rekap Denda</span>
                          </a>
                          
                          <a href="{{ route('statistik.index') }}" class="menu-item {{ request()->routeIs('statistik.*') ? 'active' : '' }}">
                              <i class="fas fa-chart-bar"></i>
                              <span>Statistik</span>
                          </a>
                          
                           <a href="{{ route('laporan.presensi') }}" class="menu-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                               <i class="fas fa-file-alt"></i>
                               Laporan
                           </a>
                        </div>
                        
                         <div class="menu-section">
                             <div class="menu-title">Manajemen</div>
                             
                             <a href="{{ route('jam-pelajaran.index') }}" class="menu-item {{ request()->routeIs('jam-pelajaran.*') ? 'active' : '' }}">
                                 <i class="fas fa-clock"></i>
                                 <span>Jam Pelajaran</span>
                             </a>
                             
                             <a href="{{ route('profile.edit') }}" class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                 <i class="fas fa-cog"></i>
                                 <span>Pengaturan</span>
                             </a>
                             
                             <a href="{{ route('users.index') }}" class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                 <i class="fas fa-users-cog"></i>
                                 <span>Kelola Pengguna</span>
                             </a>
                         </div>
                   @elseif (auth()->user()->role === 'petugas')
                       <div class="menu-section">
                           <div class="menu-title">Menu Utama</div>
                           
                           <a href="{{ route('petugas.dashboard') }}" class="menu-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                               <i class="fas fa-tachometer-alt"></i>
                               Dashboard
                           </a>
                           
                           <a href="{{ route('petugas.presensi.index') }}" class="menu-item {{ request()->routeIs('petugas.presensi.*') ? 'active' : '' }}">
                               <i class="fas fa-clipboard-check"></i>
                               Presensi Santri
                           </a>
                            
                            <a href="{{ route('petugas.profile.edit') }}" class="menu-item {{ request()->routeIs('petugas.profile*') ? 'active' : '' }}">
                                <i class="fas fa-user-cog"></i>
                                <span>Pengaturan</span>
                            </a>
                        </div>
@elseif (auth()->user()->role === 'santri')
     <div class="menu-section">
         <div class="menu-title">Menu Utama</div>
         
         <a href="{{ route('santri.dashboard') }}" class="menu-item {{ request()->routeIs('santri.dashboard') ? 'active' : '' }}">
             <i class="fas fa-home"></i>
             Dashboard Saya
         </a>
         
         <a href="{{ route('santri.attendance') }}" class="menu-item {{ request()->routeIs('santri.attendance') ? 'active' : '' }}">
             <i class="fas fa-history"></i>
             Riwayat Presensi Saya
         </a>
         
         <a href="{{ route('santri.fine') }}" class="menu-item {{ request()->routeIs('santri.fine') ? 'active' : '' }}">
             <i class="fas fa-money-bill-wave"></i>
             Rekap Denda Saya
         </a>
         
         <a href="{{ route('santri.ranking') }}" class="menu-item {{ request()->routeIs('santri.ranking') ? 'active' : '' }}">
             <i class="fas fa-trophy"></i>
             Ranking Kehadiran
         </a>
         
<a href="{{ route('santri.statistics') }}" class="menu-item {{ request()->routeIs('santri.statistics') ? 'active' : '' }}">
               <i class="fas fa-chart-bar"></i>
               Statistik Kehadiran
           </a>
          
           <a href="{{ route('santri.profile.edit') }}" class="menu-item {{ request()->routeIs('santri.profile*') ? 'active' : '' }}">
               <i class="fas fa-user-cog"></i>
               Pengaturan
           </a>
        </div>
@endif
              @endauth
              
              @guest
                  <div class="menu-section">
                      <div class="menu-title">Menu Utama</div>
                      
                      <a href="{{ route('login') }}" class="menu-item {{ request()->routeIs('login') ? 'active' : '' }}">
                          <i class="fas fa-home"></i>
                          <span>Dashboard</span>
                      </a>
                  </div>
              @endguest
          </nav>
         
<div class="sidebar-footer">
    <div class="user-info" style="display: flex; align-items: center; gap: 10px; padding: 10px;">
        <div class="user-avatar">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <div class="user-details">
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-role">{{ Auth::user()->role }}</div>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="margin-left: auto;">
            @csrf
            <button type="submit" style="background: none; border: none; cursor: pointer; color: #94a3b8; padding: 6px; border-radius: 6px; transition: all 0.2s;" onmouseover="this.style.color='#ef4444'; this.style.background='#fef2f2'" onmouseout="this.style.color='#94a3b8'; this.style.background='none'" title="Keluar">
                <i class="fas fa-sign-out-alt" style="font-size: 14px;"></i>
            </button>
        </form>
    </div>
</div>
      </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                </div>
            </div>
            
            <div class="topbar-right">
                
                <div class="topbar-date">
                    <i class="fas fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::now()->locale('id')->dayName }}, {{ \Carbon\Carbon::now()->format('d M Y') }}
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="page-content">
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
            @endif
            
            @yield('content')
        </main>
    </div>

<script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            const icon = event.currentTarget.querySelector('i.fa-chevron-up');
            dropdown.classList.toggle('show');
            icon.style.transform = dropdown.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0)';
        }

        // Close user dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const userDropdown = document.querySelector('.user-dropdown');
            const dropdownMenu = document.getElementById('userDropdown');
            if (dropdownMenu && !userDropdown.contains(e.target)) {
                dropdownMenu.classList.remove('show');
                const icon = userDropdown.querySelector('i.fa-chevron-up');
                if (icon) icon.style.transform = 'rotate(0)';
            }
        });

        // Close sidebar when clicking overlay
        document.querySelector('.sidebar-overlay')?.addEventListener('click', function() {
            toggleSidebar();
        });

        // Prevent scroll propagation from sidebar to main page
        const sidebarMenu = document.querySelector('.sidebar-menu');
        if (sidebarMenu) {
            sidebarMenu.addEventListener('wheel', function(e) {
                const atTop = this.scrollTop <= 0 && e.deltaY < 0;
                const atBottom = this.scrollTop + this.clientHeight >= this.scrollHeight && e.deltaY > 0;
                if (atTop || atBottom) {
                    e.preventDefault();
                }
            }, { passive: false });
        }

        function autoHideAlerts() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.classList.add('fading');
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 4000);
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', autoHideAlerts);
        } else {
            autoHideAlerts();
        }

        // No real-time clock update - keep static date

        // Floating Toast Notification
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container');
            if (!toastContainer) return;
            const icons = { success: 'fa-check-circle', error: 'fa-exclamation-circle', warning: 'fa-exclamation-triangle', info: 'fa-info-circle' };
            const colors = { success: '#10b981', error: '#ef4444', warning: '#f59e0b', info: '#3b82f6' };
            const toast = document.createElement('div');
            toast.style.cssText = `background:white;border-left:4px solid ${colors[type]||colors.success};padding:14px 20px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.15);display:flex;align-items:center;gap:10px;min-width:280px;max-width:400px;animation:slideInRight 0.3s ease;position:relative;margin-bottom:8px;`;
            toast.innerHTML = `<i class="fas ${icons[type]||icons.success}" style="color:${colors[type]||colors.success};font-size:18px;"></i><span style="font-size:13px;color:#1e293b;">${message}</span>`;
            toastContainer.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity 0.3s'; setTimeout(() => toast.remove(), 300); }, 3000);
        }
        // Toast animation style
        const toastStyle = document.createElement('style');
        toastStyle.textContent = '@keyframes slideInRight{from{transform:translateX(100%);opacity:0}to{transform:translateX(0);opacity:1}}';
        document.head.appendChild(toastStyle);
    </script>
    <div id="toast-container" style="position:fixed;top:20px;right:20px;z-index:9999;display:flex;flex-direction:column;"></div>
    @stack('scripts')
</body>
</html>






