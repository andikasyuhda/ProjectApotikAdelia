<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ADELY - Adelia Electronic Pharmacy System')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        :root {
            --primary-pink: #FF6B9D;
            --light-pink: #FF8FB3;
            --lighter-pink: #FFB3C9;
            --very-light-pink: #FFC9DC;
            --deep-pink: #E91E63;
            --dark-pink: #AD1457;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --bg-main: #FFF5F8;
            --bg-card: #FFFFFF;
            --text-primary: #1E293B;
            --text-secondary: #64748B;
            --text-muted: #94A3B8;
            --border-color: #FFE0ED;
            --sidebar-expanded: 270px;
            --sidebar-collapsed: 75px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Inter', 'Roboto', sans-serif;
            background: var(--bg-main);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-expanded);
            background: linear-gradient(180deg, var(--primary-pink) 0%, var(--deep-pink) 100%);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 100;
            box-shadow: 4px 0 12px rgba(233, 30, 99, 0.08);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar-toggle {
            position: absolute;
            right: -15px;
            top: 28px;
            width: 30px;
            height: 30px;
            background: var(--bg-card);
            border: 2px solid var(--primary-pink);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 101;
        }

        .sidebar-toggle:hover {
            background: var(--primary-pink);
            transform: scale(1.1);
        }

        .sidebar-toggle:hover svg {
            color: white;
        }

        .sidebar-toggle svg {
            width: 16px;
            height: 16px;
            color: var(--primary-pink);
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-toggle svg {
            transform: rotate(180deg);
        }

        .sidebar-header {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 80px;
        }

        .sidebar-logo {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .sidebar-logo svg {
            width: 28px;
            height: 28px;
            color: var(--primary-pink);
        }

        .sidebar-brand {
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .sidebar-brand {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar-brand h1 {
            font-size: 20px;
            font-weight: 700;
            color: white;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
        }

        .sidebar-brand p {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 12px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 16px;
            margin-bottom: 6px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            transform: translateX(4px);
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: white;
            border-radius: 0 4px 4px 0;
        }

        .nav-icon {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }

        .nav-text {
            white-space: nowrap;
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar.collapsed .nav-item {
            justify-content: center;
            padding: 13px;
        }

        /* Tooltip for collapsed sidebar */
        .nav-item[title]::after {
            content: attr(title);
            position: absolute;
            left: 100%;
            margin-left: 10px;
            padding: 8px 12px;
            background: var(--dark-pink);
            color: white;
            font-size: 13px;
            border-radius: 8px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 1000;
        }

        .sidebar.collapsed .nav-item:hover[title]::after {
            opacity: 1;
        }

        .sidebar-footer {
            padding: 16px 12px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .user-info:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--lighter-pink), var(--very-light-pink));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-pink);
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .user-details {
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .user-details {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .user-details h3 {
            font-size: 14px;
            font-weight: 600;
            color: white;
            margin-bottom: 2px;
        }

        .user-details p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-expanded);
            padding: 32px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed);
        }

        .page-header {
            margin-bottom: 32px;
        }

        .page-header h2 {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-pink), var(--deep-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 6px;
        }

        .page-header p {
            font-size: 15px;
            color: var(--text-secondary);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--bg-card);
            padding: 28px;
            border-radius: 20px;
            border: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-pink), var(--light-pink));
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(255, 107, 157, 0.15);
            border-color: var(--primary-pink);
        }

        .stat-info h3 {
            font-size: 14px;
            color: var(--text-secondary);
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info p {
            font-size: 42px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-pink), var(--deep-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-pink), var(--light-pink));
            box-shadow: 0 8px 24px rgba(255, 107, 157, 0.25);
        }

        .stat-icon svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        /* Content Card */
        .content-card {
            background: var(--bg-card);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            padding: 28px;
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }

        .content-card:hover {
            box-shadow: 0 8px 24px rgba(255, 107, 157, 0.08);
        }

        .content-card h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        /* Table */
        .medicine-table {
            background: var(--bg-card);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .table-header {
            display: grid;
            grid-template-columns: 2.5fr 1fr 1.2fr 1.8fr 0.8fr;
            padding: 18px 24px;
            background: linear-gradient(135deg, var(--primary-pink), var(--light-pink));
            font-weight: 600;
            font-size: 13px;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-row {
            display: grid;
            grid-template-columns: 2.5fr 1fr 1.2fr 1.8fr 0.8fr;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            align-items: center;
            transition: all 0.3s ease;
        }

        .table-row:last-child {
            border-bottom: none;
        }

        .table-row:hover {
            background: linear-gradient(90deg, rgba(255, 107, 157, 0.03), transparent);
        }

        .medicine-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .medicine-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--lighter-pink), var(--very-light-pink));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .medicine-icon svg {
            width: 24px;
            height: 24px;
            color: var(--primary-pink);
        }

        .medicine-name {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .stock-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .stock-unit {
            font-size: 13px;
            color: var(--text-muted);
            margin-left: 4px;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-badge.aman {
            background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
            color: #065F46;
        }

        .status-badge.sedang {
            background: linear-gradient(135deg, #FEF3C7, #FDE68A);
            color: #92400E;
        }

        .status-badge.rendah {
            background: linear-gradient(135deg, #FEE2E2, #FECACA);
            color: #991B1B;
        }

        .location-text {
            font-size: 14px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: linear-gradient(135deg, #DBEAFE, #BFDBFE);
            color: var(--primary-pink);
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 157, 0.25);
        }

        .btn-delete {
            background: linear-gradient(135deg, #FEE2E2, #FECACA);
            color: var(--danger);
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        }

        /* Search */
        .search-box {
            position: relative;
            margin-bottom: 24px;
        }

        .search-box input {
            width: 100%;
            padding: 14px 14px 14px 46px;
            border: 2px solid var(--border-color);
            border-radius: 14px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: var(--bg-card);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 4px rgba(255, 107, 157, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        /* Form */
        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 4px rgba(255, 107, 157, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-pink), var(--deep-pink));
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(255, 107, 157, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 157, 0.4);
        }

        .btn-secondary {
            background: var(--bg-main);
            color: var(--text-secondary);
            border: 2px solid var(--border-color);
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: var(--border-color);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(26, 41, 128, 0.6);
            backdrop-filter: blur(8px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .modal.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: var(--bg-card);
            border-radius: 24px;
            max-width: 540px;
            width: 100%;
            padding: 36px;
            margin: 20px;
            box-shadow: 0 24px 64px rgba(26, 41, 128, 0.3);
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header h2 {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-pink), var(--deep-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 28px;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .modal-actions button {
            flex: 1;
        }

        .empty-state {
            padding: 80px 20px;
            text-align: center;
            color: var(--text-muted);
        }

        .empty-state svg {
            margin: 0 auto 20px;
            opacity: 0.3;
        }

        /* Guest Layout */
        .guest-content {
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, var(--primary-pink), var(--deep-pink));
        }

        @media (max-width: 968px) {
            .sidebar {
                width: var(--sidebar-collapsed);
            }

            .sidebar .sidebar-brand,
            .sidebar .nav-text,
            .sidebar .user-details {
                display: none;
            }

            .main-content {
                margin-left: var(--sidebar-collapsed);
                padding: 20px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .table-header,
            .table-row {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .table-header {
                display: none;
            }
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .toast {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15), 0 2px 10px rgba(0, 0, 0, 0.1);
            transform: translateX(120%);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 320px;
            max-width: 450px;
            border-left: 4px solid;
        }

        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toast.hide {
            transform: translateX(120%);
            opacity: 0;
        }

        .toast.success {
            border-left-color: var(--success);
        }

        .toast.error {
            border-left-color: var(--danger);
        }

        .toast.warning {
            border-left-color: var(--warning);
        }

        .toast-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast.success .toast-icon {
            background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
            color: #065F46;
        }

        .toast.error .toast-icon {
            background: linear-gradient(135deg, #FEE2E2, #FECACA);
            color: #991B1B;
        }

        .toast.warning .toast-icon {
            background: linear-gradient(135deg, #FEF3C7, #FDE68A);
            color: #92400E;
        }

        .toast-icon svg {
            width: 22px;
            height: 22px;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            font-size: 15px;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .toast-message {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        .toast-close {
            width: 32px;
            height: 32px;
            border: none;
            background: var(--bg-main);
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .toast-close:hover {
            background: var(--border-color);
            color: var(--text-primary);
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: currentColor;
            opacity: 0.3;
            border-radius: 0 0 0 14px;
            animation: progress 4s linear forwards;
        }

        @keyframes progress {
            from { width: 100%; }
            to { width: 0%; }
        }

        /* Floating Action Button */
        .fab {
            position: fixed;
            bottom: 32px;
            right: 32px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-pink), var(--deep-pink));
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(233, 30, 99, 0.4);
            z-index: 100;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fabPulse 2s ease-in-out infinite;
        }

        .fab:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 12px 32px rgba(233, 30, 99, 0.5);
        }

        .fab svg {
            width: 28px;
            height: 28px;
            transition: transform 0.3s ease;
        }

        @keyframes fabPulse {
            0%, 100% { box-shadow: 0 8px 24px rgba(233, 30, 99, 0.4); }
            50% { box-shadow: 0 8px 32px rgba(233, 30, 99, 0.6), 0 0 0 8px rgba(233, 30, 99, 0.1); }
        }

        /* Micro-animations */
        .btn-icon {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .btn-icon:hover {
            transform: translateY(-3px) scale(1.05) !important;
        }

        .btn-icon:active {
            transform: translateY(0) scale(0.95) !important;
        }

        .btn-primary, .btn-secondary {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .btn-primary:active, .btn-secondary:active {
            transform: scale(0.97) !important;
        }

        .table-row {
            transition: all 0.2s ease !important;
        }

        .table-row:hover {
            transform: translateX(4px);
            background: linear-gradient(90deg, rgba(255, 107, 157, 0.05), transparent) !important;
        }

        .stat-card, .content-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        /* Skeleton Loading */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 8px;
        }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Mobile Responsiveness Improvements */
        @media (max-width: 768px) {
            .fab {
                bottom: 20px;
                right: 20px;
                width: 54px;
                height: 54px;
            }

            .page-header h2 {
                font-size: 24px !important;
            }

            .stats-grid {
                grid-template-columns: 1fr !important;
            }

            .medicine-table .table-header {
                display: none;
            }

            .medicine-table .table-row {
                display: flex;
                flex-direction: column;
                gap: 10px;
                padding: 16px;
                border-radius: 12px;
                margin-bottom: 12px;
                background: white;
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            }

            .search-box input {
                font-size: 16px;
            }

            .modal-content {
                margin: 16px;
                padding: 24px;
                max-height: 90vh;
                overflow-y: auto;
            }

            .action-buttons {
                justify-content: flex-start;
                margin-top: 12px;
            }

            .pagination-wrapper {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 16px !important;
            }

            .sidebar {
                width: var(--sidebar-collapsed) !important;
            }

            .sidebar .sidebar-brand,
            .sidebar .nav-text,
            .sidebar .user-details {
                display: none !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer">
        @if(session('success'))
        <div class="toast success" data-auto-dismiss="true">
            <div class="toast-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="toast-content">
                <div class="toast-title">Berhasil!</div>
                <div class="toast-message">{{ session('success') }}</div>
            </div>
            <button class="toast-close" onclick="closeToast(this)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="toast-progress"></div>
        </div>
        @endif
        @if(session('error'))
        <div class="toast error" data-auto-dismiss="true">
            <div class="toast-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M15 9l-6 6M9 9l6 6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="toast-content">
                <div class="toast-title">Error!</div>
                <div class="toast-message">{{ session('error') }}</div>
            </div>
            <button class="toast-close" onclick="closeToast(this)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="toast-progress"></div>
        </div>
        @endif
        @if(session('warning'))
        <div class="toast warning" data-auto-dismiss="true">
            <div class="toast-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="toast-content">
                <div class="toast-title">Peringatan!</div>
                <div class="toast-message">{{ session('warning') }}</div>
            </div>
            <button class="toast-close" onclick="closeToast(this)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="toast-progress"></div>
        </div>
        @endif
    </div>

    <div class="app-container">
        @auth
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-toggle" onclick="toggleSidebar()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="sidebar-brand">
                    <h1>ADELY</h1>
                    <p>Adelia Electronic Pharmacy</p>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" 
                   class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   title="Dashboard">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="14" y="3" width="7" height="7" rx="1" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="14" y="14" width="7" height="7" rx="1" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="3" y="14" width="7" height="7" rx="1" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="nav-text">Dashboard</span>
                </a>

                <a href="{{ route('medicines.index') }}" 
                   class="nav-item {{ request()->routeIs('medicines.index') ? 'active' : '' }}"
                   title="Daftar Obat">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="nav-text">Daftar Obat</span>
                </a>

                <a href="{{ route('medicines.create') }}" 
                   class="nav-item {{ request()->routeIs('medicines.create') ? 'active' : '' }}"
                   title="Tambah Obat">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="nav-text">Tambah Obat</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                    @csrf
                    <button type="submit" class="nav-item" title="Logout" style="width: 100%; background: none; border: none; text-align: left;">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="nav-text">Logout</span>
                    </button>
                </form>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <h3>{{ Auth::user()->name }}</h3>
                        <p>Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            @yield('content')
        </main>
        @else
        <!-- Guest Content -->
        <div class="guest-content">
            @yield('content')
        </div>
        @endauth
    </div>

    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
            
            // Save state to localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        }

        // Toast notification functions
        function closeToast(btn) {
            const toast = btn.closest('.toast');
            toast.classList.remove('show');
            toast.classList.add('hide');
            setTimeout(() => toast.remove(), 400);
        }

        function showToast(type, title, message) {
            const container = document.getElementById('toastContainer');
            const icons = {
                success: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                error: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                warning: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round"/></svg>'
            };
            
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerHTML = `
                <div class="toast-icon">${icons[type]}</div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="closeToast(this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="toast-progress"></div>
            `;
            
            container.appendChild(toast);
            requestAnimationFrame(() => toast.classList.add('show'));
            
            setTimeout(() => {
                toast.classList.remove('show');
                toast.classList.add('hide');
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        }

        // Restore sidebar state on page load and show toasts
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
            }

            // Show toasts with animation
            document.querySelectorAll('.toast[data-auto-dismiss]').forEach((toast, index) => {
                setTimeout(() => {
                    toast.classList.add('show');
                    setTimeout(() => {
                        toast.classList.remove('show');
                        toast.classList.add('hide');
                        setTimeout(() => toast.remove(), 400);
                    }, 4000);
                }, index * 100);
            });
        });
    </script>
    @stack('scripts')

    <!-- Floating Action Button -->
    @auth
    @if(Request::is('medicines') || Request::is('medicines/*'))
    <a href="{{ route('medicines.create') }}" class="fab" title="Tambah Obat Baru">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </a>
    @endif
    @endauth
</body>
</html>
