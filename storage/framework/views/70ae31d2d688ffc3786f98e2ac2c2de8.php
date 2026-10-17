

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startPush('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.css" rel="stylesheet">
<style>
    :root {
        --primary-emerald: #059669;
        --primary-teal: #0d9488;
        --primary-sage: #65a30d;
        --secondary-white: #ffffff;
        --secondary-gray: #f3f4f6;
        --secondary-stone: #e5e7eb;
        --accent-mint: #a7f3d0;
        --accent-olive: #bef264;
        --text-dark: #1f2937;
        --text-light: #6b7280;
        --card-glass-bg: rgba(255, 255, 255, 0.88);
        --card-glass-border: rgba(255, 255, 255, 0.6);
        --card-glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
    }

    /* Stat Cards */
    .admin-stat-card {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        background: var(--secondary-white) !important;
        border-radius: 14px !important;
        border: 1px solid var(--secondary-stone) !important;
        height: 88px !important;
        padding: 0.85rem 1rem !important;
        gap: 0.75rem !important;
        position: relative !important;
        overflow: hidden !important;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
        box-sizing: border-box !important;
        cursor: default;
    }

    .admin-stat-card::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        height: 3px !important;
        background: linear-gradient(90deg, var(--primary-emerald), var(--primary-teal)) !important;
        opacity: 0.85;
        transition: opacity 0.3s ease;
    }

    .admin-stat-card:hover::before {
        opacity: 1;
    }

    /* Glow sweep effect */
    .admin-stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
        transform: skewX(-15deg);
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .admin-stat-card:hover::after {
        opacity: 1;
        animation: glowSweep 0.7s ease-in-out forwards;
    }

    .admin-stat-card:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 8px 24px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04) !important;
        border-color: rgba(5, 150, 105, 0.15) !important;
    }

    .admin-stat-icon {
        flex-shrink: 0 !important;
        width: 44px !important;
        height: 44px !important;
        border-radius: 12px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 17px !important;
        transition: transform 0.3s ease;
    }

    .admin-stat-card:hover .admin-stat-icon {
        transform: scale(1.08);
    }

    .admin-stat-data {
        flex: 1 !important;
        min-width: 0 !important;
    }

    .admin-stat-data h3 {
        font-size: 20px !important;
        font-weight: 700 !important;
        margin: 0 !important;
        color: var(--text-dark) !important;
        line-height: 1.2 !important;
    }

    .admin-stat-data p {
        font-size: 11px !important;
        color: var(--text-light) !important;
        margin: 3px 0 0 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        font-weight: 500;
    }

    /* Gradient backgrounds for icons */
    .bg-primary-soft { background: linear-gradient(135deg, #dcfce7, var(--accent-mint)) !important; color: var(--primary-emerald) !important; }
    .bg-success-soft { background: linear-gradient(135deg, #dcfce7, #bbf7d0) !important; color: #15803d !important; }
    .bg-warning-soft { background: linear-gradient(135deg, #fef3c7, #fde68a) !important; color: #92400e !important; }
    .bg-danger-soft { background: linear-gradient(135deg, #fee2e2, #fecaca) !important; color: #b91c1c !important; }
    .bg-info-soft { background: linear-gradient(135deg, #cffafe, #a5f3fc) !important; color: #0891b2 !important; }
    .bg-purple-soft { background: linear-gradient(135deg, #f3e8ff, #e9d5ff) !important; color: #7c3aed !important; }
    .bg-sickness-soft { background: linear-gradient(135deg, #ffedd5, #fed7aa) !important; color: #c2410c !important; }
    .bg-permission-soft { background: linear-gradient(135deg, #dbeafe, #bfdbfe) !important; color: #1d4ed8 !important; }

    /* Section Divider */
    .section-divider {
        border: none;
        border-top: 1px dashed var(--secondary-stone);
        margin: 1rem 0 1.5rem 0;
    }

    /* Glassmorphism section cards */
    .section-card {
        background: var(--card-glass-bg);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        border: 1px solid var(--card-glass-border);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        box-shadow: var(--card-glass-shadow);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .section-card:hover {
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
        transform: translateY(-1px);
    }
    .section-card h5 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.85rem;
        display: flex;
        align-items: center;
        gap: 8px;
        letter-spacing: -0.01em;
    }
    .section-card h5 i { font-size: 0.85rem; }

    /* Info Box */
    .info-box {
        background: var(--secondary-gray);
        border-radius: 10px;
        padding: 0.75rem;
        text-align: center;
        border: 1px solid var(--secondary-stone);
        height: 100%;
        transition: transform 0.2s;
    }
    .info-box:hover { transform: translateY(-2px); }
    .info-box i {
        font-size: 1.15rem;
        margin-bottom: 3px;
    }
    .info-box h4 {
        font-size: 1.15rem;
        font-weight: 700;
        margin: 2px 0;
        color: var(--text-dark);
    }
    .info-box small {
        font-size: 0.68rem;
        color: var(--text-light);
    }

    /* Activity item with icon badge */
    .activity-item {
        padding: 0.55rem 0.75rem;
        border-radius: 10px;
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .activity-item:hover {
        background: var(--secondary-gray);
        border-left-color: var(--primary-emerald);
    }

    /* Status badge with icon inside activity */
    .activity-icon-badge {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 13px;
        font-weight: 600;
    }

    .rank-item {
        padding: 0.5rem 0.65rem;
        border-bottom: 1px solid var(--secondary-stone);
        transition: background 0.15s, transform 0.15s;
    }
    .rank-item:last-child { border-bottom: none; }
    .rank-item:hover {
        background: var(--secondary-gray);
        transform: translateX(3px);
    }

    /* Alternating rank row */
    .rank-item:nth-child(even) { background: #f9fafb; border-radius: 8px; }
    .rank-item:nth-child(even):hover { background: #eef1f5; }

    .rank-badge {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 11px;
        flex-shrink: 0;
        color: white;
    }
    .rank-1 { background: linear-gradient(135deg, #fbbf24, #f59e0b); box-shadow: 0 2px 6px rgba(251,191,36,0.3); }
    .rank-2 { background: linear-gradient(135deg, #9ca3af, #6b7280); box-shadow: 0 2px 6px rgba(107,114,128,0.3); }
    .rank-3 { background: linear-gradient(135deg, #cd7c2e, #b45309); box-shadow: 0 2px 6px rgba(180,83,9,0.3); }

    /* Mini progress bar */
    .progress-mini-full {
        height: 5px;
        width: 100%;
        border-radius: 3px;
        background: #e5e7eb;
    }
    .progress-mini-full .progress-bar { border-radius: 3px; transition: width 0.6s ease; }

    .activity-bar {
        height: 4px;
        width: 100%;
        border-radius: 2px;
        background: #e5e7eb;
        margin-top: 4px;
    }
    .activity-bar .progress-bar { border-radius: 2px; transition: width 0.6s ease; }

    .countdown-badge {
        background: linear-gradient(135deg, var(--primary-emerald), var(--primary-teal));
        color: white;
        padding: 0.2rem 0.6rem;
        border-radius: 10px;
        font-size: 0.65rem;
        font-weight: 600;
        display: inline-block;
    }
    .badge-mini {
        font-size: 0.65rem;
        padding: 0.15rem 0.45rem;
        border-radius: 8px;
    }

    /* Status summary row */
    .status-summary {
        font-size: 0.68rem;
        font-weight: 600;
        padding: 0.18rem 0.5rem;
        border-radius: 6px;
    }

    /* Compact chip list — inline wrap, no scroll */
    .tidak-hadir-row {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        align-items: center;
    }
    .th-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: var(--secondary-white);
        border: 1px solid var(--secondary-stone);
        border-radius: 8px;
        padding: 2px 8px;
        font-size: 0.72rem;
        line-height: 1.4;
    }
    .th-name {
        color: var(--text-dark);
        font-weight: 600;
        max-width: 140px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: block;
    }
    .th-badge {
        font-size: 0.62rem;
        font-weight: 700;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        flex-shrink: 0;
    }
    .th-alpha { background: #fee2e2; color: #b91c1c; }
    .th-izin  { background: #fef3c7; color: #92400e; }
    .th-sakit { background: #cffafe; color: #0891b2; }

    /* Summary footer card */
    .summary-footer-card {
        background: var(--secondary-white);
        border-radius: 14px;
        border: 1px solid var(--secondary-stone);
        padding: 1.15rem 1.25rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .summary-footer-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-emerald), var(--primary-teal));
    }
    .summary-footer-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }

    /* Empty state illustration */
    .empty-illustration {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }

    /* Header gradient improvements */
    .dashboard-header {
        background: linear-gradient(135deg, #059669 0%, #0d9488 50%, #0f766e 100%);
        border-radius: 16px;
        padding: 1.75rem 2rem;
        margin-bottom: 1.25rem;
        position: relative;
        overflow: hidden;
    }
    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    .dashboard-header::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: -30px;
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    /* New decorative elements for header */
    .dashboard-header .header-decoration {
        position: absolute;
        bottom: -20px;
        right: 20%;
        width: 160px;
        height: 160px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        animation: float 7s ease-in-out infinite 1s;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0) translateX(0); }
        50% { transform: translateY(-20px) translateX(10px); }
    }

    /* Stat card group wrapper */
    .stat-card-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }
    .stat-card-col {
        flex: 0 0 calc(50% - 0.25rem);
        max-width: calc(50% - 0.25rem);
        padding: 0 0.125rem;
        box-sizing: border-box;
    }

    /* Animated number counter */
    @keyframes countUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .stat-number {
        animation: countUp 0.5s ease forwards;
    }

    /* Section Label badge */
    .section-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-light);
        margin-bottom: 0.5rem;
        padding: 0.25rem 0.6rem;
        background: var(--secondary-gray);
        border-radius: 6px;
    }

    /* Schedule kelas header - tab style */
    .schedule-kelas-header {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 0.5rem;
        padding: 0.2rem 0.65rem;
        border-radius: 20px;
        background: var(--secondary-gray);
        width: fit-content;
    }
    .schedule-kelas-header small {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-light);
    }
    .schedule-kelas-header .badge {
        font-size: 0.55rem;
        font-weight: 600;
        padding: 0.1rem 0.4rem;
        border-radius: 10px;
    }

    /* Warna aksen per kelas */
    .schedule-kelas-header.safin { background: #dcfce7; color: #065f46; border: 1px solid #a7f3d0; }
    .schedule-kelas-header.muqo  { background: #f3e8ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .schedule-kelas-header.safin .badge { background: #059669; color: white; }
    .schedule-kelas-header.muqo .badge  { background: #7c3aed; color: white; }

    /* Schedule tab header */
    .schedule-tabs {
        display: flex;
        gap: 0;
        margin-bottom: 0.5rem;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--secondary-stone);
        background: var(--secondary-gray);
    }
    .schedule-tab-btn {
        flex: 1;
        padding: 0.3rem 0.4rem;
        text-align: center;
        font-size: 0.68rem;
        font-weight: 700;
        color: var(--text-light);
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 3px;
        white-space: nowrap;
    }
    .schedule-tab-btn:first-child { border-radius: 10px 0 0 10px; }
    .schedule-tab-btn:last-child { border-radius: 0 10px 10px 0; }
    .schedule-tab-btn.active {
        background: var(--primary-emerald);
        color: white;
    }
    .schedule-tab-btn.active .badge-tab {
        background: rgba(255,255,255,0.25);
        color: white;
    }
    .schedule-tab-btn:hover:not(.active) {
        background: rgba(255,255,255,0.4);
    }
    .badge-tab {
        font-size: 0.5rem;
        padding: 0.05rem 0.3rem;
        border-radius: 8px;
        background: rgba(0,0,0,0.06);
        color: var(--text-dark);
    }

    /* Timeline axis visual */
    .timeline-axis-wrapper {
        position: relative;
        margin-bottom: 0.5rem;
        padding: 0 4px;
    }
    .timeline-axis {
        position: relative;
        height: 26px;
    }
    .timeline-ruler-line {
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        height: 1px;
        background: var(--secondary-stone);
    }
    .timeline-hour-mark {
        position: absolute;
        top: 1px;
        transform: translateX(-50%);
        text-align: center;
    }
    .timeline-hour-mark .tl-dot {
        display: block;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--secondary-stone);
        margin: 0 auto 2px;
    }
    .timeline-hour-mark.tl-active .tl-dot {
        background: var(--primary-emerald);
        width: 7px;
        height: 7px;
    }
.timeline-hour-mark small {
        font-size: 0.48rem;
        color: var(--text-light);
    }
    .timeline-now-indicator small {
        font-size: 0.45rem;
        font-weight: 700;
        color: var(--primary-emerald);
    }
    .timeline-now-indicator {
        position: absolute;
        top: 0;
        transform: translateX(-50%);
        z-index: 2;
        text-align: center;
    }
    .timeline-now-line {
        width: 1.5px;
        height: 16px;
        background: var(--primary-emerald);
        margin: 0 auto;
        border-radius: 1px;
        animation: pulse-now 2s ease-in-out infinite;
    }
    .timeline-now-indicator small {
        font-size: 0.4rem;
        font-weight: 700;
        color: var(--primary-emerald);
    }
    @keyframes pulse-now {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    .schedule-icon-badge {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 11px;
        font-weight: 600;
        background: linear-gradient(135deg, #dcfce7, var(--accent-mint));
        color: var(--primary-emerald);
        transition: transform 0.2s;
    }
    .schedule-card-item:hover .schedule-icon-badge {
        transform: scale(1.1);
    }
    .schedule-card-item.active .schedule-icon-badge {
        background: linear-gradient(135deg, #15803d, #166534) !important;
        color: white !important;
    }

    /* Mapel icon variants */
    .schedule-icon-badge.i-shalom  { color: var(--primary-emerald); }
    .schedule-icon-badge.i-quran   { color: #7c3aed; background: linear-gradient(135deg, #ede9fe, #ddd6fe); }
    .schedule-icon-badge.i-fiqih   { color: #0891b2; background: linear-gradient(135deg, #cffafe, #a5f3fc); }
    .schedule-icon-badge.i-hadits  { color: #b45309; background: linear-gradient(135deg, #ffedd5, #fed7aa); }
    .schedule-icon-badge.i-tajwid  { color: #db2777; background: linear-gradient(135deg, #fce7f3, #fbcfe8); }
    .schedule-icon-badge.i-akhlak  { color: #ea580c; background: linear-gradient(135deg, #ffedd5, #fed7aa); }
    .schedule-icon-badge.i-mtk     { color: #2563eb; background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
    .schedule-icon-badge.i-ipa     { color: #0d9488; background: linear-gradient(135deg, #ccfbf1, #99f6e4); }
    .schedule-icon-badge.i-bahasa  { color: #65a30d; background: linear-gradient(135deg, #dcfce7, var(--accent-mint)); }
    .schedule-icon-badge.i-inggris { color: #dc2626; background: linear-gradient(135deg, #fee2e2, #fecaca); }
    .schedule-icon-badge.i-adab    { color: #9333ea; background: linear-gradient(135deg, #f3e8ff, #e9d5ff); }
    .schedule-icon-badge.i-tafsir  { color: #00897b; background: linear-gradient(135deg, #ccfbf1, #99f6e4); }
    .schedule-icon-badge.i-sirah   { color: #e65100; background: linear-gradient(135deg, #ffedd5, #fed7aa); }

    .schedule-judul {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .schedule-meta {
        display: flex;
        align-items: center;
        gap: 0.2rem;
        margin-top: 0.05rem;
    }
    .schedule-time-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.1rem;
        padding: 0.05rem 0.3rem;
        border-radius: 4px;
        font-size: 0.55rem;
        font-weight: 600;
        background: rgba(226,232,240,0.8);
        color: var(--text-dark);
        flex-shrink: 0;
    }
    .schedule-card-item.active .schedule-time-badge {
        background: rgba(255,255,255,0.3);
        color: #065f46;
    }
    .schedule-guru {
        font-size: 0.62rem;
        color: var(--text-light);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .schedule-card-item.active .schedule-judul {
        color: #065f46;
    }
    .schedule-bar {
        height: 2px;
        width: 100%;
        border-radius: 2px;
        background: #e5e7eb;
        overflow: hidden;
        margin-top: 0.1rem;
    }
    .schedule-bar-fill {
        height: 100%;
        border-radius: 2px;
        background: linear-gradient(90deg, var(--primary-emerald), var(--primary-teal));
        transition: width 0.6s ease;
    }
    .schedule-bar-fill.active { width: 100%; }
    .schedule-bar-fill:not(.active) { width: 0%; }

    /* Schedule section card header */
    .schedule-section-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.3rem;
        flex-wrap: wrap;
        gap: 4px;
    }
    .schedule-section-title h5 {
        font-size: 0.82rem;
        margin: 0;
    }
    .schedule-total-badge {
        font-size: 0.5rem;
        font-weight: 600;
        padding: 0.08rem 0.35rem;
        border-radius: 6px;
        white-space: nowrap;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--gray);
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 18px;
        margin-bottom: 8px;
        color: var(--dark);
    }

    /* Schedule card item */
    .schedule-card-item {
        background: var(--secondary-gray);
        border-radius: 10px;
        padding: 0.6rem 0.75rem;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }
    .schedule-card-item:hover {
        background: #eef1f5;
    }
    .schedule-card-item.active {
        background: linear-gradient(135deg, var(--accent-mint), #bbf7d0) !important;
        border-left-color: var(--primary-emerald) !important;
    }
    .card-top {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .card-body {
        flex: 1;
        min-width: 0;
    }
    .schedule-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        font-size: 0.55rem;
        font-weight: 700;
        color: var(--primary-emerald);
        background: rgba(5,150,105,0.12);
        padding: 0.1rem 0.4rem;
        border-radius: 6px;
        margin-bottom: 0.25rem;
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .stat-card-col {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .section-card {
            padding: 1rem;
        }
        .dashboard-header {
            padding: 1.25rem 1.25rem;
        }
        .schedule-card-grid {
            display: grid !important;
            grid-template-columns: 1fr;
            gap: 0.5rem !important;
        }
        .schedule-tab-btn {
            font-size: 0.58rem;
            padding: 0.25rem 0.3rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- KILO: BEGIN CONTENT -->
    <?php
        use Carbon\Carbon;
        use App\Models\Absensi;
        use App\Models\Santri;
        use App\Models\User;
    ?>

    <!-- Welcome Header -->
    <div class="dashboard-header text-white position-relative overflow-hidden" style="border-radius:16px; padding:1.75rem 2rem; margin-bottom:1.25rem; background:linear-gradient(135deg, #059669 0%, #0d9488 50%, #0f766e 100%);">
        <div class="header-decoration"></div>
        <div class="position-relative" style="z-index:2;">
            <h1 class="mb-1" style="font-size:1.6rem; font-weight:700; color:white; margin-bottom:0.35rem;">Selamat Datang, Admin</h1>
            <p class="mb-3 opacity-90" style="font-size:0.9rem; color:rgba(255,255,255,0.8); margin-bottom:1rem;">Semoga hari ini menjadi hari yang produktif untuk memantau kehadiran santri.</p>
            <div class="d-flex align-items-center flex-wrap gap-3">
                <div class="me-3" style="display:flex; align-items:center; gap:0.5rem; color:rgba(255,255,255,0.9);">
                    <i class="fas fa-calendar-alt"></i> <?php echo e(Carbon::now()->format('l, d F Y')); ?>

                </div>
                <div class="countdown-badge" style="display:inline-flex; align-items:center; gap:0.25rem;">
                    <i class="fas fa-clock"></i> <span id="time-display"><?php echo e(Carbon::now()->format('H:i:s')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- Section Label                             -->
    <!-- ========================================== -->
    <div class="section-label mb-2"><i class="fas fa-tachometer-alt"></i> Ringkasan Statistik</div>

    <!-- Statistik Cards - Baris 1: Total Santri, Denda -->
    <div class="stat-card-row">
        <div class="stat-card-col">
            <div class="admin-stat-card">
                <div class="admin-stat-icon bg-primary-soft"><i class="fas fa-users"></i></div>
                <div class="admin-stat-data">
                    <h3 class="stat-number"><?php echo e($totalSantri ?? 0); ?></h3>
                    <p>Total Santri</p>
                </div>
            </div>
        </div>
        <div class="stat-card-col">
            <div class="admin-stat-card">
                <div class="admin-stat-icon bg-warning-soft"><i class="fas fa-money-bill-wave"></i></div>
                <div class="admin-stat-data">
                    <h3 class="stat-number">Rp <?php echo e(number_format($totalDendaBulan ?? 0, 0, ',', '.')); ?></h3>
                    <p>Denda Bulan Ini</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards - Baris 2: Hadir, Alpha, Sakit, Izin -->
    <div class="stat-card-row">
        <div class="stat-card-col">
            <div class="admin-stat-card">
                <div class="admin-stat-icon bg-success-soft"><i class="fas fa-check-circle"></i></div>
                <div class="admin-stat-data">
                    <h3 class="stat-number"><?php echo e($totalHadirHariIni ?? 0); ?></h3>
                    <p>Hadir</p>
                </div>
            </div>
        </div>
        <div class="stat-card-col">
            <div class="admin-stat-card">
                <div class="admin-stat-icon bg-danger-soft"><i class="fas fa-user-times"></i></div>
                <div class="admin-stat-data">
                    <h3 class="stat-number"><?php echo e($totalAlphaHariIni ?? 0); ?></h3>
                    <p>Alpha</p>
                </div>
            </div>
        </div>
        <div class="stat-card-col">
            <div class="admin-stat-card">
                <div class="admin-stat-icon bg-sickness-soft"><i class="fas fa-notes-medical"></i></div>
                <div class="admin-stat-data">
                    <h3 class="stat-number"><?php echo e($totalSakitHariIni ?? 0); ?></h3>
                    <p>Sakit</p>
                </div>
            </div>
        </div>
        <div class="stat-card-col">
            <div class="admin-stat-card">
                <div class="admin-stat-icon bg-permission-soft"><i class="fas fa-clipboard-check"></i></div>
                <div class="admin-stat-data">
                    <h3 class="stat-number"><?php echo e($totalIzinHariIni ?? 0); ?></h3>
                    <p>Izin</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Hari Ini -->
    <div class="row g-2 mb-2">
        <div class="col">
            <div class="section-card" style="padding: 0.85rem 1rem;">
                <div class="schedule-section-title">
                    <h5 class="mb-0"><i class="fas fa-calendar-day text-primary-emerald me-1"></i> Jadwal Hari Ini</h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-emerald text-white schedule-total-badge">
                            <i class="fas fa-list me-1" style="font-size:0.5rem;"></i><?php echo e(count($jadwalHariIni ?? [])); ?> Jadwal
                        </span>
                        <span style="font-size:0.65rem; color:var(--text-light);">
                            <i class="fas fa-clock me-1"></i><span id="jadwal-time"><?php echo e(Carbon::now()->format('H:i')); ?></span> WIB
                        </span>
                    </div>
                </div>
                <?php if(!empty($jadwalHariIni)): ?>
                    <?php
                        $grouped = [];
                        foreach ($jadwalHariIni as $j) {
                            $kelas = $j['kelas'] ?? 'Umum';
                            if (!isset($grouped[$kelas])) $grouped[$kelas] = [];
                            $grouped[$kelas][] = $j;
                        }
                        // Sort setiap kelas berdasarkan jam_mulai
                        foreach ($grouped as $kelas => $items) {
                            usort($grouped[$kelas], function($a, $b) {
                                return strtotime($a['jam_mulai']) - strtotime($b['jam_mulai']);
                            });
                        }
                    ?>
                    <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $kelasKey = strtolower($kelas);
                            $isSafin = str_contains($kelasKey, 'safin');
                            $isMuqo = str_contains($kelasKey, 'muqo');
                            $headerClass = $isSafin ? 'safin' : ($isMuqo ? 'muqo' : '');
                        ?>
                        <!-- Tab Header Kelas -->
                        <div class="schedule-tabs">
                            <button class="schedule-tab-btn active"><?php echo e(strtoupper($kelas)); ?></button>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($idx === 0): ?>
                                    <?php if($item['active'] ?? false): ?>
                                        <button class="schedule-tab-btn"><i class="fas fa-circle" style="font-size:0.4rem;"></i> Live</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge-tab ms-auto"><?php echo e(count($items)); ?> sesi</span>
                        </div>
                        <!-- Timeline Axis -->
                        <div class="timeline-axis-wrapper">
                            <div class="timeline-axis">
                                <div class="timeline-ruler-line"></div>
                                <?php
                                    $hourStart = 6;
                                    $hourEnd = 14;
                                    $now = Carbon::now();
                                ?>
                                <?php for($h = $hourStart; $h <= $hourEnd; $h++): ?>
                                    <?php
                                        $isActive = ($now->hour == $h && $now->minute < 30) || ($now->hour == $h - 1 && $now->minute >= 30);
                                        $leftPct = (($h - $hourStart) / ($hourEnd - $hourStart)) * 100;
                                    ?>
                                    <div class="timeline-hour-mark <?php echo e($isActive ? 'tl-active' : ''); ?>" style="left:<?php echo e($leftPct); ?>%;">
                                        <div class="tl-dot"></div>
                                        <small><?php echo e(str_pad($h, 2, '0', STR_PAD_LEFT)); ?>:00</small>
                                    </div>
                                <?php endfor; ?>
                                <!-- Now indicator -->
                                <?php
                                    $nowLeftPct = (($now->hour + $now->minute / 60 - $hourStart) / ($hourEnd - $hourStart)) * 100;
                                ?>
                                <div class="timeline-now-indicator" style="left:<?php echo e($nowLeftPct); ?>%;">
                                    <div class="timeline-now-line"></div>
                                    <small><?php echo e($now->format('H:i')); ?></small>
                                </div>
                            </div>
                        </div>
                        <!-- Card Grid -->
                        <div class="schedule-card-grid">
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jadwal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // Tentukan ikon berdasarkan nama mapel
                                    $nama = strtolower($jadwal['nama'] ?? '');
                                    $icon = 'fa-book'; // default
                                    if(str_contains($nama, 'shalat') || str_contains($nama, 'sholat')) $icon = 'fa-mosque';
                                    elseif(str_contains($nama, 'quran') || str_contains($nama, 'tilawah') || str_contains($nama, 'tahfidz')) $icon = 'fa-book-quran';
                                    elseif(str_contains($nama, 'fiqih') || str_contains($nama, 'fikih')) $icon = 'fa-scale-balanced';
                                    elseif(str_contains($nama, 'hadits')) $icon = 'fa-scroll';
                                    elseif(str_contains($nama, 'tajwid')) $icon = 'fa-spell-check';
                                    elseif(str_contains($nama, 'akhlaq') || str_contains($nama, 'adab')) $icon = 'fa-heart-handshake';
                                    elseif(str_contains($nama, 'mtk') || str_contains($nama, 'matematika')) $icon = 'fa-calculator';
                                    elseif(str_contains($nama, 'ipa')) $icon = 'fa-flask';
                                    elseif(str_contains($nama, 'bahasa')) $icon = 'fa-language';
                                    elseif(str_contains($nama, 'inggris')) $icon = 'fa-language';
                                    elseif(str_contains($nama, 'sirah') || str_contains($nama, 'sejarah')) $icon = 'fa-landmark';
                                    elseif(str_contains($nama, 'tafsir')) $icon = 'fa-comment';
                                    $iconClass = 'i-' . str_replace(['fa-', 'fa-solid-'], '', $icon);
                                ?>
                                <div class="schedule-card-item <?php echo e($jadwal['active'] ?? false ? 'active' : ''); ?>">
                                    <?php if($jadwal['active'] ?? false): ?>
                                        <div class="schedule-status-badge">â— Live</div>
                                    <?php endif; ?>
                                    <div class="card-top">
                                        <div class="schedule-icon-badge">
                                            <i class="fas <?php echo e($icon); ?> <?php echo e($iconClass); ?>"></i>
                                        </div>
                                        <div class="card-body">
                                            <div class="schedule-judul" title="<?php echo e($jadwal['nama']); ?>"><?php echo e($jadwal['nama']); ?></div>
                                            <div class="schedule-meta">
                                                <span class="schedule-time-badge"><i class="fas fa-clock me-1" style="font-size:0.4rem;"></i><?php echo e($jadwal['jam_mulai']); ?> - <?php echo e($jadwal['jam_selesai']); ?></span>
                                            </div>
                                            <div class="schedule-meta">
                                                <small class="schedule-guru"><i class="fas fa-chalkboard-teacher me-1"></i><?php echo e($jadwal['ustadz'] ?? '-'); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="schedule-bar"><div class="schedule-bar-fill <?php echo e($jadwal['active'] ?? false ? 'active' : ''); ?>"></div></div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="text-center py-2">
                        <div class="empty-illustration" style="width:56px; height:56px; margin:0 auto 0.5rem;">
                            <i class="fas fa-calendar-xmark" style="font-size:1.3rem; color:#94a3b8;"></i>
                        </div>
                        <p class="text-muted mb-0" style="font-size:0.75rem; color:#94a3b8;">
                            <i class="fas fa-smile me-1"></i>Libur hari ini! ðŸŽ‰
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <hr class="section-divider">

    <!-- Row: Chart Bulanan + Distribusi Status -->
    <div class="row g-2 mb-3">
        <div class="col-lg-8">
            <div class="section-card">
                <h5><i class="fas fa-chart-line text-primary-emerald"></i> Statistik Kehadiran Bulanan</h5>
                <div id="attendanceChart" style="height: 220px;"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="section-card">
                <h5><i class="fas fa-chart-pie text-primary-emerald"></i> Distribusi Status</h5>
                <div id="statusChart" style="height: 220px;"></div>
            </div>
        </div>
    </div>


    <!-- BUILD: admin-dashboard-KILO-2026-05-21 -->
    </div>  <!-- close container/row from parent -->
    <?php $__env->stopSection(); ?>

    <?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
<script>
    setInterval(function() {
        var now = new Date();
        document.getElementById('time-display').textContent = now.toLocaleTimeString('id-ID');
        document.getElementById('jadwal-time').textContent = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
    }, 1000);

    var attendanceOptions = {
        series: [{
            name: 'Hadir',
            data: <?php echo json_encode($chartData['hadir'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]); ?>

        }, {
            name: 'Alpha',
            data: <?php echo json_encode($chartData['alpha'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]); ?>

        }, {
            name: 'Izin',
            data: <?php echo json_encode($chartData['izin'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]); ?>

        }, {
            name: 'Sakit',
            data: <?php echo json_encode($chartData['sakit'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]); ?>

        }],
        chart: { type: 'area', height: 220, toolbar: { show: false }, zoom: { enabled: false }},
        colors: ['#059669', '#ef4444', '#f59e0b', '#0891b2'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.2, opacityTo: 0.02 } },
        markers: { size: 0, hover: { size: 4 } },
        xaxis: {
            categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'],
            labels: { style: { fontSize: '10px', colors: '#94a3b8' } }
        },
        yaxis: { labels: { style: { fontSize: '10px', colors: '#94a3b8' } } },
        grid: { show: true, borderColor: '#f1f5f9', strokeDashArray: 3 },
        tooltip: { theme: 'light' },
        legend: { position: 'top', horizontalAlign: 'left', fontSize: '10px', fontFamily: 'Poppins', markers: { width: 8, height: 8 } }
    };
    new ApexCharts(document.querySelector("#attendanceChart"), attendanceOptions).render();

    var statusOptions = {
        series: [<?php echo json_encode($stats['hadir'] ?? 0, 15, 512) ?>, <?php echo json_encode($stats['alpha'] ?? 0, 15, 512) ?>, <?php echo json_encode($stats['izin'] ?? 0, 15, 512) ?>, <?php echo json_encode($stats['sakit'] ?? 0, 15, 512) ?>],
        chart: { type: 'donut', height: 220 },
        labels: ['Hadir', 'Alpha', 'Izin', 'Sakit'],
        colors: ['#059669', '#ef4444', '#f59e0b', '#0891b2'],
        legend: { position: 'bottom', horizontalAlign: 'center', fontSize: '11px', fontFamily: 'Poppins', markers: { width: 10, height: 10 } },
        plotOptions: { pie: { donut: { size: '55%' } } },
        dataLabels: { enabled: false }
    };
    new ApexCharts(document.querySelector("#statusChart"), statusOptions).render();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJEK BOSS\sistem-presensi\sistem-presensi\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>