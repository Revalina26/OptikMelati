<?php
// Get all sales data
$salesQuery = "SELECT s.*, p.name as product_name, p.image FROM sales s 
               LEFT JOIN products p ON s.product_id = p.id 
               ORDER BY s.created_at DESC";
$salesResult = mysqli_query($conn, $salesQuery);
$allSales = mysqli_fetch_all($salesResult, MYSQLI_ASSOC);
?>

<div class="content-section">
    <div class="section-header">
        <h3>💰 Pengelolaan Penjualan</h3>
    </div>

    <div class="sales-stats">
        <div class="stat-card">
            <div class="stat-icon">💵</div>
            <div class="stat-info">
                <h4>Total Pendapatan</h4>
                <p class="stat-value">Rp <?= number_format($totalRevenue) ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-info">
                <h4>Total Penjualan</h4>
                <p class="stat-value"><?= $totalSalesCount ?> Transaksi</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-info">
                <h4>Stok Terbatas</h4>
                <p class="stat-value"><?= $lowStockCount ?> Produk</p>
            </div>
        </div>
    </div>

    <div class="sales-table-container">
        <h4>Daftar Penjualan</h4>
        
        <?php if (empty($allSales)): ?>
            <div class="no-data">
                <p>📭 Belum ada data penjualan</p>
            </div>
        <?php else: ?>
            <table class="sales-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Pembeli</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($allSales as $sale): ?>
                        <tr>
                            <td>#<?= $sale['id'] ?></td>
                            <td>
                                <div class="product-cell">
                                    <?php if($sale['image']): ?>
                                        <img src="uploads/<?= $sale['image'] ?>" alt="">
                                    <?php endif; ?>
                                    <span><?= $sale['product_name'] ?? 'N/A' ?></span>
                                </div>
                            </td>
                            <td><?= $sale['quantity'] ?></td>
                            <td>Rp <?= number_format($sale['price']) ?></td>
                            <td class="total-price">Rp <?= number_format($sale['total_price']) ?></td>
                            <td><?= substr($sale['buyer_name'] ?? 'Anonymous', 0, 20) ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($sale['created_at'])) ?></td>
                            <td>
                                <span class="status-badge status-completed">✓ Selesai</span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<style>
.sales-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.stat-icon {
    font-size: 36px;
}

.stat-info h4 {
    margin: 0 0 8px 0;
    color: #666;
    font-size: 14px;
    text-transform: uppercase;
}

.stat-value {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #111;
}

.sales-table-container {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.sales-table-container h4 {
    margin: 0 0 20px 0;
    color: #111;
}

.sales-table {
    width: 100%;
    border-collapse: collapse;
}

.sales-table thead {
    background: #f8f9fb;
    border-bottom: 2px solid #e5e7eb;
}

.sales-table th {
    padding: 15px;
    text-align: left;
    font-weight: 600;
    color: #555;
    font-size: 14px;
    text-transform: uppercase;
}

.sales-table td {
    padding: 15px;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
}

.sales-table tbody tr:hover {
    background: #f8f9fb;
}

.product-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.product-cell img {
    width: 40px;
    height: 40px;
    border-radius: 6px;
    object-fit: cover;
}

.total-price {
    font-weight: 600;
    color: #16a34a;
    font-size: 15px;
}

.status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-completed {
    background: #dcfce7;
    color: #166534;
}

.no-data {
    text-align: center;
    padding: 40px;
    color: #999;
    font-size: 16px;
}

.content-section {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
