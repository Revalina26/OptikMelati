<?php
require_once BASE_PATH . "/app/models/Product.php";
require_once BASE_PATH . "/app/models/Sale.php";
require_once BASE_PATH . "/app/models/user.php";
require_once BASE_PATH . "/app/models/Booking.php";
require_once BASE_PATH . "/app/models/Invoice.php";

class AdminController {

    /* ================= DASHBOARD ================= */
    public function index()
    {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }

        // Redirect ke halaman laporan secara default
        header("Location: index.php?page=admin_laporan");
        exit;
    }

    /* ================= TRANSACTIONS ================= */
    public function transactions() {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }
        $bookings = Booking::getAll();
        $invoices = Invoice::getAll();
        $content = BASE_PATH . "/views/admin/transactions.php";
        require BASE_PATH . "/views/admin/layout.php";
    }

    public function add_transaction() {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                Invoice::create($_POST);
                $success = "Transaksi berhasil disimpan!";
            } catch (Exception $e) {
                $error = "Gagal menyimpan transaksi: " . $e->getMessage();
            }
            
            $content = BASE_PATH . "/views/admin/add_transaction.php";
            require BASE_PATH . "/views/admin/layout.php";
            return;
        }

        $content = BASE_PATH . "/views/admin/add_transaction.php";
        require BASE_PATH . "/views/admin/layout.php";
    }

    public function edit_transaction() {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?page=admin_transactions");
            exit;
        }

        $invoice = Invoice::getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                Invoice::update($id, $_POST);
                $success = "Transaksi berhasil diperbarui!";
                $invoice = Invoice::getById($id); // Reload updated data
            } catch (Exception $e) {
                $error = "Gagal memperbarui transaksi: " . $e->getMessage();
            }
        }

        $content = BASE_PATH . "/views/admin/edit_transaction.php";
        require BASE_PATH . "/views/admin/layout.php";
    }

    public function print_transaction() {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID Transaksi tidak ditemukan.";
            exit;
        }

        $invoice = Invoice::getById($id);
        if (!$invoice) {
            echo "Data Transaksi tidak ditemukan.";
            exit;
        }

        require BASE_PATH . "/views/admin/print_transaction.php";
    }

    public function add_online_transaction() {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $name = $_POST['name'] ?? '';
                $phone = $_POST['phone'] ?? '';
                $message = $_POST['message'] ?? '';
                $payment_info = $_POST['payment_info'] ?? '';
                
                Booking::create($name, $phone, $message, $payment_info);
                $success = "Transaksi Online (Booking) berhasil ditambahkan!";
            } catch (Exception $e) {
                $error = "Gagal menambahkan transaksi: " . $e->getMessage();
            }
        }

        $content = BASE_PATH . "/views/admin/add_online_transaction.php";
        require BASE_PATH . "/views/admin/layout.php";
    }

    public function edit_online_transaction() {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?page=admin_transactions");
            exit;
        }

        $booking = Booking::getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $name = $_POST['name'] ?? '';
                $phone = $_POST['phone'] ?? '';
                $message = $_POST['message'] ?? '';
                $payment_info = $_POST['payment_info'] ?? '';

                Booking::update($id, $name, $phone, $message, $payment_info);
                $success = "Transaksi Online berhasil diperbarui!";
                $booking = Booking::getById($id); // Reload data
            } catch (Exception $e) {
                $error = "Gagal memperbarui transaksi: " . $e->getMessage();
            }
        }

        $content = BASE_PATH . "/views/admin/edit_online_transaction.php";
        require BASE_PATH . "/views/admin/layout.php";
    }

    public function toggle_online_status() {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }

        $id = $_GET['id'] ?? null;
        $status = $_GET['status'] ?? null;

        if ($id && $status) {
            Booking::updateStatus($id, $status);
        }

        header("Location: index.php?page=admin_transactions");
        exit;
    }

    /* ================= PRODUCTS ================= */
    public function products_page() {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }
        $products = Product::getAllAdmin();
        $content = BASE_PATH . "/views/admin/products.php";
        require BASE_PATH . "/views/admin/layout.php";
    }

    /* ================= CUSTOMERS ================= */
    public function customers() {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }
        
        $invoices = Invoice::getAll();
        $bookings = Booking::getAll();
        
        $customersData = [];
        
        foreach ($invoices as $inv) {
            $customersData[] = [
                'tanggal' => $inv['tanggal'],
                'nama' => $inv['nama'],
                'no_hp' => $inv['no_hp'],
                'detail' => $inv['frame'] . ' / ' . $inv['lensa'],
                'jumlah' => 'Rp ' . number_format($inv['jumlah'], 0, ',', '.'),
                'sumber' => 'Toko'
            ];
        }
        
        foreach ($bookings as $b) {
            $payInfo = trim($b['payment_info'] ?: '');
            if ($payInfo === '') {
                $payOutput = '-';
            } elseif (stripos($payInfo, 'Rp') === 0) {
                $payOutput = $payInfo;
            } else {
                $payOutput = 'Rp ' . $payInfo;
            }
            
            $customersData[] = [
                'tanggal' => date('Y-m-d', strtotime($b['created_at'])),
                'nama' => $b['name'],
                'no_hp' => $b['phone'],
                'detail' => $b['message'],
                'jumlah' => $payOutput,
                'sumber' => 'Online'
            ];
        }
        
        usort($customersData, function($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        $content = BASE_PATH . "/views/admin/customers.php";
        require BASE_PATH . "/views/admin/layout.php";
    }

    /* ================= BOOKINGS ================= */
    public function bookings() {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }
        $bookings = Booking::getAll();
        $content = BASE_PATH . "/views/admin/bookings.php";
        require BASE_PATH . "/views/admin/layout.php";
    }

    /* ================= LAPORAN TRANSAKSI PERBULAN ================= */
    public function laporan() {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }
        
        $bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('n');
        $tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');
        
        // Ambil transaksi toko berdasarkan bulan dan tahun
        $invoices = Invoice::getAll();
        $filteredInvoices = [];
        foreach ($invoices as $inv) {
            $invMonth = (int)date('n', strtotime($inv['tanggal']));
            $invYear = (int)date('Y', strtotime($inv['tanggal']));
            if ($invMonth === $bulan && $invYear === $tahun) {
                $filteredInvoices[] = $inv;
            }
        }
        
        // Ambil transaksi online (bookings) berdasarkan bulan dan tahun
        $bookings = Booking::getAll();
        $filteredBookings = [];
        foreach ($bookings as $b) {
            $bMonth = (int)date('n', strtotime($b['created_at']));
            $bYear = (int)date('Y', strtotime($b['created_at']));
            if ($bMonth === $bulan && $bYear === $tahun) {
                $filteredBookings[] = $b;
            }
        }
        
        $data = [
            'filteredInvoices' => $filteredInvoices,
            'filteredBookings' => $filteredBookings,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];
        
        extract($data);
        
        $content = BASE_PATH . "/views/admin/laporan.php";
        require BASE_PATH . "/views/admin/layout.php";
    }

    /* ================= DELETE ================= */
    public function delete_product()
    {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }

        $id = $_GET['id'] ?? null;

        if ($id) {
            Product::delete($id);
        }

        header("Location: index.php?page=admin");
        exit;
    }

    /* ================= ADD ================= */
    public function add_product()
    {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = $_POST['name'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $category = $_POST['category'];

            $imageName = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

                $uploadDir = BASE_PATH . "/uploads/";

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $imageName = time() . "_" . basename($_FILES['image']['name']);
                $targetPath = $uploadDir . $imageName;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $error = "Gagal upload gambar!";
                }
            } else {
                $error = "File gambar tidak terdeteksi!";
            }

            if (empty($error)) {
                Product::create($name, $price, $stock, $imageName, $category);
                header("Location: index.php?page=admin");
                exit;
            }
        }

        $content = BASE_PATH . "/views/admin/add_product.php";
        require BASE_PATH . "/views/admin/layout.php";
    }

    /* ================= EDIT ================= */
    public function edit_product()
    {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=admin-login");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?page=admin");
            exit;
        }

        $product = Product::getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = $_POST['name'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $category = $_POST['category'];

            $imageName = $product['image'];

            if (!empty($_FILES['image']['name'])) {

                $imageName = time() . "_" . $_FILES['image']['name'];

                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    "uploads/" . $imageName
                );
            }

            Product::updateWithImage($id, $name, $price, $stock, $category, $imageName);

            header("Location: index.php?page=admin");
            exit;
        }

        $content = BASE_PATH . "/views/admin/edit_product.php";
        require BASE_PATH . "/views/admin/layout.php";
    }

    /* ================= HELPER ================= */
    private function isAdmin()
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

    private function getTotalRevenue()
    {
        return Sale::getTotalRevenue();
    }

    private function getTotalOrders()
    {
        return Sale::countOrders();
    }

    private function getLowStock()
    {
        return Product::countLowStock();
    }

    private function getProducts()
    {
        return Product::getAll();
    }
}