<?php
// Proteksi: hanya admin yang bisa akses
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Koneksi database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/* ==========================
   TAB CONTROL
========================== */
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';

/* ==========================
   STATISTIK
========================== */
$revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) as total FROM sales"));
$totalRevenue = $revenue['total'] ?? 0;

$totalSalesCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM sales"))['total'];
$lowStockCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products WHERE stock < 5"))['total'];

$allProducts = mysqli_query($conn, "SELECT * FROM products");

/* ==========================
   TAMBAH PRODUK
========================== */
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $imageName = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    
    if (!empty($imageName)) {
        $uploadDir = BASE_PATH . "/upload/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        move_uploaded_file($tmp, $uploadDir . $imageName);
    } else {
        $imageName = null;
    }

    $query = "INSERT INTO products 
        (name, category, price, stock, description, image)
        VALUES
        ('$name', '$category', '$price', '$stock', '$description', '$imageName')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Produk berhasil ditambahkan!";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
    }
    
    header("Location: index.php?page=admin&tab=products");
    exit();
}

/* ==========================
   HAPUS PRODUK
========================== */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $query = "DELETE FROM products WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Produk berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
    }
    
    header("Location: index.php?page=admin&tab=products");
    exit();
}

/* ==========================
   EDIT PRODUK
========================== */
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if (!empty($_FILES['image']['name'])) {
        $imageName = $_FILES['image']['name'];
        $uploadDir = BASE_PATH . "/upload/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
        
        $query = "UPDATE products SET 
            name = '$name',
            category = '$category',
            price = '$price',
            stock = '$stock',
            description = '$description',
            image = '$imageName'
            WHERE id = $id";
    } else {
        $query = "UPDATE products SET 
            name = '$name',
            category = '$category',
            price = '$price',
            stock = '$stock',
            description = '$description'
            WHERE id = $id";
    }

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Produk berhasil diperbarui!";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
    }

    header("Location: index.php?page=admin&tab=products");
    exit();
}
?>

<!-- HTML Dashboard Admin -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .admin-container {
            display: flex;
            min-height: calc(100vh - 150px);
            background: #f5f5f5;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar h2 {
            margin-bottom: 30px;
            font-size: 20px;
            text-align: center;
        }

        .sidebar nav ul {
            list-style: none;
        }

        .sidebar nav ul li {
            margin-bottom: 10px;
        }

        .sidebar nav ul li a {
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar nav ul li a:hover,
        .sidebar nav ul li a.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            color: #333;
        }

        /* Statistics */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #667eea;
        }

        .stat-card h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
        }

        /* Tab Navigation */
        .tab-nav {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .tab-nav a {
            padding: 10px 20px;
            background: #f5f5f5;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .tab-nav a:hover {
            background: #e0e0e0;
        }

        .tab-nav a.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        /* Tab Content */
        .tab-content {
            display: none;
            animation: fadeIn 0.3s;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Form Styles */
        .form-container {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        /* Button Styles */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-danger {
            background: #ff6b6b;
            color: white;
        }

        .btn-danger:hover {
            background: #ee5a52;
        }

        .btn-secondary {
            background: #f5f5f5;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #f5f5f5;
            border-bottom: 2px solid #ddd;
        }

        table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        table tbody tr:hover {
            background: #f9f9f9;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-buttons a,
        .action-buttons button {
            padding: 6px 12px;
            font-size: 12px;
        }

        /* Alert Messages */
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .modal-footer {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .close-btn {
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #aaa;
        }

        .close-btn:hover {
            color: #000;
        }

        @media (max-width: 768px) {
            .admin-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body style="background: #f5f5f5;">
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>⚙️ Admin Panel</h2>
            <nav>
                <ul>
                    <li><a href="index.php?page=admin&tab=dashboard" class="<?= $tab === 'dashboard' ? 'active' : '' ?>">📊 Dashboard</a></li>
                    <li><a href="index.php?page=admin&tab=products" class="<?= $tab === 'products' ? 'active' : '' ?>">📦 Kelola Produk</a></li>
                    <li><a href="index.php?page=admin&tab=add-product" class="<?= $tab === 'add-product' ? 'active' : '' ?>">➕ Tambah Produk</a></li>
                </ul>
                <hr style="border-color: rgba(255,255,255,0.2); margin: 20px 0;">
                <p style="font-size: 12px; text-transform: uppercase; opacity: 0.7; margin-bottom: 10px;">General</p>
                <ul>
                    <li><a href="index.php?page=admin&tab=laporan" class="<?= $tab === 'laporan' ? 'active' : '' ?>">📑 Laporan Transaksi Perbulan</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Dashboard Admin</h1>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Dashboard Tab -->
            <div id="dashboard" class="tab-content <?= $tab === 'dashboard' ? 'active' : '' ?>">
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Penjualan</h3>
                        <div class="value"><?= $totalSalesCount ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Revenue</h3>
                        <div class="value">Rp<?= number_format($totalRevenue, 0, ',', '.') ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Stok Rendah</h3>
                        <div class="value"><?= $lowStockCount ?></div>
                    </div>
                </div>
            </div>

            <!-- Products Tab -->
            <div id="products" class="tab-content <?= $tab === 'products' ? 'active' : '' ?>">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($product = mysqli_fetch_assoc($allProducts)): ?>
                                <tr>
                                    <td><?= $product['id'] ?></td>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td><?= htmlspecialchars($product['category']) ?></td>
                                    <td>Rp<?= number_format($product['price'], 0, ',', '.') ?></td>
                                    <td>
                                        <span style="color: <?= $product['stock'] < 5 ? 'red' : 'green' ?>">
                                            <?= $product['stock'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-secondary" onclick="editProduct(<?= $product['id'] ?>)">Edit</button>
                                            <a href="index.php?page=admin&tab=products&delete=<?= $product['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add Product Tab -->
            <div id="add-product" class="tab-content <?= $tab === 'add-product' ? 'active' : '' ?>">
                <div class="form-container">
                    <h2>Tambah Produk Baru</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="name" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Kategori</label>
                                <input type="text" name="category" required>
                            </div>
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="number" name="price" step="0.01" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Stok</label>
                                <input type="number" name="stock" required>
                            </div>
                            <div class="form-group">
                                <label>Gambar Produk</label>
                                <input type="file" name="image" accept="image/*" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" required></textarea>
                        </div>

                        <button type="submit" name="add" class="btn btn-primary">Tambah Produk</button>
                        <a href="index.php?page=admin&tab=products" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>

            <!-- Laporan Transaksi Perbulan Tab -->
            <div id="laporan" class="tab-content <?= $tab === 'laporan' ? 'active' : '' ?>">
                <div class="form-container">
                    <h2>Laporan Transaksi Perbulan</h2>
                    <form method="GET">
                        <input type="hidden" name="page" value="admin">
                        <input type="hidden" name="tab" value="laporan">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="bulan" required>
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?= $i ?>" <?= (isset($_GET['bulan']) && $_GET['bulan'] == $i) ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" required>
                                    <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                                        <option value="<?= $y ?>" <?= (isset($_GET['tahun']) && $_GET['tahun'] == $y) ? 'selected' : '' ?>><?= $y ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
                    </form>
                </div>

                <?php
                if (isset($_GET['bulan']) && isset($_GET['tahun'])) {
                    $bulan = (int)$_GET['bulan'];
                    $tahun = (int)$_GET['tahun'];
                    
                    // Query untuk mengambil transaksi berdasarkan bulan dan tahun
                    $query = "SELECT * FROM transactions WHERE MONTH(created_at) = ? AND YEAR(created_at) = ? ORDER BY created_at DESC";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "ii", $bulan, $tahun);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    
                    $totalPendapatan = 0;
                    $jumlahTransaksi = 0;
                ?>
                <div class="table-container" style="margin-top: 20px;">
                    <h3>Transaksi Bulan <?= date('F', mktime(0, 0, 0, $bulan, 1)) ?> <?= $tahun ?></h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($transaksi = mysqli_fetch_assoc($result)): ?>
                                <?php 
                                $totalPendapatan += $transaksi['total_amount'];
                                $jumlahTransaksi++;
                                ?>
                                <tr>
                                    <td><?= $transaksi['id'] ?></td>
                                    <td><?= date('d-m-Y', strtotime($transaksi['created_at'])) ?></td>
                                    <td><?= htmlspecialchars($transaksi['customer_name'] ?? 'Tidak ada') ?></td>
                                    <td>Rp<?= number_format($transaksi['total_amount'], 0, ',', '.') ?></td>
                                    <td><?= htmlspecialchars($transaksi['status'] ?? 'Completed') ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot>
                            <tr style="font-weight: bold; background: #f5f5f5;">
                                <td colspan="3">Total</td>
                                <td>Rp<?= number_format($totalPendapatan, 0, ',', '.') ?></td>
                                <td><?= $jumlahTransaksi ?> Transaksi</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <div class="modal-header">Edit Produk</div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="editId">
                
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="name" id="editName" required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="category" id="editCategory" required>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="price" id="editPrice" step="0.01" required>
                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stock" id="editStock" required>
                </div>

                <div class="form-group">
                    <label>Gambar Produk (Biarkan kosong jika tidak ingin mengubah)</label>
                    <input type="file" name="image" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" id="editDescription" required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                    <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editProduct(id) {
            // Fetch product data via AJAX
            fetch('get_product.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editId').value = data.id;
                    document.getElementById('editName').value = data.name;
                    document.getElementById('editCategory').value = data.category;
                    document.getElementById('editPrice').value = data.price;
                    document.getElementById('editStock').value = data.stock;
                    document.getElementById('editDescription').value = data.description;
                    document.getElementById('editModal').classList.add('active');
                })
                .catch(error => console.error('Error:', error));
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                modal.classList.remove('active');
            }
        }
    </script>
</body>
</html>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar h2 {
            margin-bottom: 30px;
            font-size: 24px;
            text-align: center;
        }

        .sidebar nav ul {
            list-style: none;
        }

        .sidebar nav ul li {
            margin-bottom: 10px;
        }

        .sidebar nav ul li a {
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar nav ul li a:hover,
        .sidebar nav ul li a.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            color: #333;
        }

        /* Statistics */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #667eea;
        }

        .stat-card h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
        }

        /* Tab Navigation */
        .tab-nav {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .tab-nav a {
            padding: 10px 20px;
            background: #f5f5f5;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .tab-nav a:hover {
            background: #e0e0e0;
        }

        .tab-nav a.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        /* Tab Content */
        .tab-content {
            display: none;
            animation: fadeIn 0.3s;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Form Styles */
        .form-container {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        /* Button Styles */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-danger {
            background: #ff6b6b;
            color: white;
        }

        .btn-danger:hover {
            background: #ee5a52;
        }

        .btn-secondary {
            background: #f5f5f5;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #f5f5f5;
            border-bottom: 2px solid #ddd;
        }

        table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        table tbody tr:hover {
            background: #f9f9f9;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-buttons a,
        .action-buttons button {
            padding: 6px 12px;
            font-size: 12px;
        }

        /* Alert Messages */
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .modal-footer {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .close-btn {
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #aaa;
        }

        .close-btn:hover {
            color: #000;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <nav>
                <ul>
                    <li><a href="admin.php?tab=dashboard" class="<?= $tab === 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>
                    <li><a href="admin.php?tab=products" class="<?= $tab === 'products' ? 'active' : '' ?>">Produk</a></li>
                    <li><a href="admin.php?tab=add-product" class="<?= $tab === 'add-product' ? 'active' : '' ?>">Tambah Produk</a></li>
                    <li><a href="../index.php">Kembali ke Toko</a></li>
                </ul>
                <hr style="border-color: rgba(255,255,255,0.2); margin: 20px 0;">
                <p style="font-size: 12px; text-transform: uppercase; opacity: 0.7; margin-bottom: 10px;">General</p>
                <ul>
                    <li><a href="admin.php?tab=laporan" class="<?= $tab === 'laporan' ? 'active' : '' ?>">Laporan Transaksi Perbulan</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Dashboard Admin</h1>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Dashboard Tab -->
            <div id="dashboard" class="tab-content <?= $tab === 'dashboard' ? 'active' : '' ?>">
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Penjualan</h3>
                        <div class="value"><?= $totalSalesCount ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Revenue</h3>
                        <div class="value">Rp<?= number_format($totalRevenue, 0, ',', '.') ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Stok Rendah</h3>
                        <div class="value"><?= $lowStockCount ?></div>
                    </div>
                </div>
            </div>

            <!-- Products Tab -->
            <div id="products" class="tab-content <?= $tab === 'products' ? 'active' : '' ?>">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($product = mysqli_fetch_assoc($allProducts)): ?>
                                <tr>
                                    <td><?= $product['id'] ?></td>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td><?= htmlspecialchars($product['category']) ?></td>
                                    <td>Rp<?= number_format($product['price'], 0, ',', '.') ?></td>
                                    <td>
                                        <span style="color: <?= $product['stock'] < 5 ? 'red' : 'green' ?>">
                                            <?= $product['stock'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-secondary" onclick="editProduct(<?= $product['id'] ?>)">Edit</button>
                                            <a href="admin.php?tab=products&delete=<?= $product['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add Product Tab -->
            <div id="add-product" class="tab-content <?= $tab === 'add-product' ? 'active' : '' ?>">
                <div class="form-container">
                    <h2>Tambah Produk Baru</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="name" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Kategori</label>
                                <input type="text" name="category" required>
                            </div>
                            <div class="form-group">
                                <label>Harga</label>
                                <input type="number" name="price" step="0.01" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Stok</label>
                                <input type="number" name="stock" required>
                            </div>
                            <div class="form-group">
                                <label>Gambar Produk</label>
                                <input type="file" name="image" accept="image/*" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" required></textarea>
                        </div>

                        <button type="submit" name="add" class="btn btn-primary">Tambah Produk</button>
                        <a href="admin.php?tab=products" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>

            <!-- Laporan Transaksi Perbulan Tab -->
            <div id="laporan" class="tab-content <?= $tab === 'laporan' ? 'active' : '' ?>">
                <div class="form-container">
                    <h2>Laporan Transaksi Perbulan</h2>
                    <form method="GET">
                        <input type="hidden" name="tab" value="laporan">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="bulan" required>
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?= $i ?>" <?= (isset($_GET['bulan']) && $_GET['bulan'] == $i) ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" required>
                                    <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                                        <option value="<?= $y ?>" <?= (isset($_GET['tahun']) && $_GET['tahun'] == $y) ? 'selected' : '' ?>><?= $y ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
                    </form>
                </div>

                <?php
                if (isset($_GET['bulan']) && isset($_GET['tahun'])) {
                    $bulan = (int)$_GET['bulan'];
                    $tahun = (int)$_GET['tahun'];
                    
                    // Query untuk mengambil transaksi berdasarkan bulan dan tahun
                    $query = "SELECT * FROM transactions WHERE MONTH(created_at) = ? AND YEAR(created_at) = ? ORDER BY created_at DESC";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "ii", $bulan, $tahun);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    
                    $totalPendapatan = 0;
                    $jumlahTransaksi = 0;
                ?>
                <div class="table-container" style="margin-top: 20px;">
                    <h3>Transaksi Bulan <?= date('F', mktime(0, 0, 0, $bulan, 1)) ?> <?= $tahun ?></h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($transaksi = mysqli_fetch_assoc($result)): ?>
                                <?php 
                                $totalPendapatan += $transaksi['total_amount'];
                                $jumlahTransaksi++;
                                ?>
                                <tr>
                                    <td><?= $transaksi['id'] ?></td>
                                    <td><?= date('d-m-Y', strtotime($transaksi['created_at'])) ?></td>
                                    <td><?= htmlspecialchars($transaksi['customer_name'] ?? 'Tidak ada') ?></td>
                                    <td>Rp<?= number_format($transaksi['total_amount'], 0, ',', '.') ?></td>
                                    <td><?= htmlspecialchars($transaksi['status'] ?? 'Completed') ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot>
                            <tr style="font-weight: bold; background: #f5f5f5;">
                                <td colspan="3">Total</td>
                                <td>Rp<?= number_format($totalPendapatan, 0, ',', '.') ?></td>
                                <td><?= $jumlahTransaksi ?> Transaksi</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <div class="modal-header">Edit Produk</div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="editId">
                
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="name" id="editName" required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="category" id="editCategory" required>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="price" id="editPrice" step="0.01" required>
                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stock" id="editStock" required>
                </div>

                <div class="form-group">
                    <label>Gambar Produk (Biarkan kosong jika tidak ingin mengubah)</label>
                    <input type="file" name="image" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" id="editDescription" required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                    <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editProduct(id) {
            // Fetch product data via AJAX
            fetch('../get_product.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editId').value = data.id;
                    document.getElementById('editName').value = data.name;
                    document.getElementById('editCategory').value = data.category;
                    document.getElementById('editPrice').value = data.price;
                    document.getElementById('editStock').value = data.stock;
                    document.getElementById('editDescription').value = data.description;
                    document.getElementById('editModal').classList.add('active');
                })
                .catch(error => console.error('Error:', error));
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                modal.classList.remove('active');
            }
        }
    </script>
</body>
</html>

