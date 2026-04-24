<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Optik Melati</title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="page-wrapper">
    <header class="main-header">
        <div class="container header-wrapper">

            <!-- LOGO -->
            <div class="logo">
                <span>OPTIK MELATI</span>
            </div>

            <!-- MENU (digeser ke kanan) -->
            <nav class="main-nav" style="margin-left: auto; margin-right: 20px;">
                <a href="home">HOME</a>
                <a href="catalog">CATALOG</a>
            </nav>

            <!-- ICON SVG -->
            <div class="header-icons">

                <!-- Admin Menu Hamburger -->
                <div class="admin-menu-toggle">
                    <button class="hamburger-btn" id="hamburgerBtn" aria-label="Menu Admin">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <div class="admin-menu-dropdown" id="adminMenuDropdown">
                        <div class="dropdown-label">Portal Admin</div>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                            <a href="index.php?page=admin" class="menu-item">Dashboard</a>
                            <a href="index.php?page=logout" class="menu-item logout">Logout</a>
                        <?php else: ?>
                            <a href="index.php?page=admin-login" class="menu-item">Login Admin</a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>
    </header>

    <main class="main-content">

<!-- admin menu toggle script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('hamburgerBtn');
        const dropdown = document.getElementById('adminMenuDropdown');

        if (btn && dropdown) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropdown.classList.toggle('show');
            });

            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });
        }
    });
</script>

<style>
    /* 1. Logo Cantik */
    .logo span {
        font-family: 'Poppins', sans-serif;
        font-size: 24px !important;
        font-weight: 900 !important;
        background: linear-gradient(135deg, #1976d2 0%, #00d2ff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-transform: uppercase;
    }

    /* 2. Dasar Dropdown (Harus disembunyikan dulu) */
    .admin-menu-dropdown {
        display: none; /* Sembunyi */
        position: absolute;
        right: 0;
        top: 40px; /* Jarak dari tombol */
        background: white;
        min-width: 180px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-radius: 8px;
        z-index: 9999;
        padding: 10px 0;
    }

    /* 3. KUNCI UTAMA: Memunculkan Dropdown */
    .admin-menu-dropdown.show {
        display: block !important; /* Muncul saat class 'show' aktif via JS */
    }

    .menu-item {
        padding: 10px 20px;
        display: block;
        color: #333;
        text-decoration: none;
        font-size: 14px;
    }

    .menu-item:hover {
        background: #f5f5f5;
        color: #1976d2;
    }

    .dropdown-label {
        padding: 5px 20px;
        font-size: 11px;
        font-weight: bold;
        color: #999;
        text-transform: uppercase;
    }
</style>