<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

<div class="dashboard-container">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="index.php?page=home" class="logo" style="text-decoration: none; color: inherit; cursor: pointer;">
                <span class="logo-icon">📊</span>
                <span class="logo-text">Optik Melati</span>
            </a>
        </div>
        
        <div class="user-profile">
            <img src="https://ui-avatars.com/api/?name=Admin&background=ffe0e0&color=d32f2f" alt="Admin">
            <div class="user-info">
                <h4>Admin</h4>
            </div>
            <span class="user-more">⋮</span>
        </div>

        <div class="menu-group">
            <div class="menu-label">
                <span>General</span>
                <span class="chevron">▼</span>
            </div>
            <?php $currentPage = $_GET['page'] ?? 'admin'; ?>
            <ul>
                <li class="<?= $currentPage === 'admin_products' ? 'active' : '' ?>">
                    <a href="index.php?page=admin_products">
                        <span class="icon">🛍️</span> 
                        <div class="menu-text">
                            <span class="menu-title">Data Produk</span>
                        </div>
                    </a>
                </li>
                <li class="<?= ($currentPage === 'admin' || $currentPage === 'admin_transactions' || $currentPage === 'admin_add_transaction') ? 'active' : '' ?>">
                    <a href="index.php?page=admin_transactions">
                        <span class="icon">📄</span> 
                        <div class="menu-text">
                            <span class="menu-title">Transaksi</span>
                        </div>
                    </a>
                </li>
                <li class="<?= $currentPage === 'admin_customers' ? 'active' : '' ?>">
                    <a href="index.php?page=admin_customers">
                        <span class="icon">📊</span> 
                        <div class="menu-text">
                            <span class="menu-title">Data Pembeli</span>
                        </div>
                    </a>
                </li>
                <li class="<?= $currentPage === 'admin_bookings' ? 'active' : '' ?>">
                    <a href="index.php?page=admin_bookings">
                        <span class="icon">🏦</span> 
                        <div class="menu-text">
                            <span class="menu-title">Booking</span>
                        </div>
                    </a>
                </li>
                <li class="<?= $currentPage === 'admin_laporan' ? 'active' : '' ?>">
                    <a href="index.php?page=admin_laporan">
                        <span class="icon">📑</span> 
                        <div class="menu-text">
                            <span class="menu-title">Laporan</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <header class="top-header" style="justify-content: space-between; padding: 10px 30px;">
            <button class="menu-toggle" aria-label="Toggle Menu">☰</button>
            <!-- Header items removed as requested -->
        </header>

        <?php require $content; ?>
    </main>
</div>

<script>
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');

    menuToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        sidebar.classList.toggle('sidebar-open');
    });

    document.addEventListener('click', (e) => {
        if (sidebar.classList.contains('sidebar-open') && !sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
            sidebar.classList.remove('sidebar-open');
        }
    });
</script>
</body>
</html>
