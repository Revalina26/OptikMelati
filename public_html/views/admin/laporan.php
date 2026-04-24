<div class="page-title">
    <div class="title-left">
        <h1>Laporan Transaksi Perbulan</h1>
        <div class="breadcrumb"><a href="index.php?page=admin" style="text-decoration: none; color: inherit;">General</a> &gt; <span>Laporan</span></div>
    </div>
</div>

<style>
.filter-form {
    background: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.filter-form form {
    display: flex;
    align-items: flex-end;
    gap: 15px;
    flex-wrap: wrap;
}
.filter-form .form-group {
    margin-bottom: 0;
}
.filter-form label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #555;
    margin-bottom: 6px;
}
.filter-form select {
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    min-width: 150px;
}
.filter-form button {
    padding: 10px 25px;
    background: #1976d2;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}
.filter-form button:hover {
    background: #1565c0;
}
</style>

<div class="filter-form">
    <form method="GET">
        <input type="hidden" name="page" value="admin_laporan">
        <div class="form-group">
            <label>Bulan</label>
            <select name="bulan" required>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= ($bulan == $i) ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Tahun</label>
            <select name="tahun" required>
                <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                    <option value="<?= $y ?>" <?= ($tahun == $y) ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <button type="submit">Tampilkan</button>
    </form>
</div>

<?php
$totalPendapatanToko = 0;
$totalPendapatanOnline = 0;
$jumlahTransaksiToko = 0;
$jumlahTransaksiOnline = 0;

if (!empty($filteredInvoices)) {
    foreach ($filteredInvoices as $inv) {
        $totalPendapatanToko += (float)$inv['jumlah'];
    }
    $jumlahTransaksiToko = count($filteredInvoices);
}

if (!empty($filteredBookings)) {
    foreach ($filteredBookings as $b) {
        $payInfo = isset($b['payment_info']) ? trim($b['payment_info']) : '';
        $payNum = preg_replace('/[^0-9]/', '', $payInfo);
        if ($payNum !== '') {
            $totalPendapatanOnline += (float)$payNum;
        }
    }
    $jumlahTransaksiOnline = count($filteredBookings);
}

$totalKeseluruhan = $totalPendapatanToko + $totalPendapatanOnline;
?>

<!-- Ringkasan -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="summary-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px;">
        <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">Total Pendapatan Toko</div>
        <div style="font-size: 24px; font-weight: bold;">Rp <?= number_format($totalPendapatanToko, 0, ',', '.') ?></div>
        <div style="font-size: 12px; opacity: 0.8; margin-top: 5px;"><?= $jumlahTransaksiToko ?> transaksi</div>
    </div>
    <div class="summary-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: 10px;">
        <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">Total Pendapatan Online</div>
        <div style="font-size: 24px; font-weight: bold;">Rp <?= number_format($totalPendapatanOnline, 0, ',', '.') ?></div>
        <div style="font-size: 12px; opacity: 0.8; margin-top: 5px;"><?= $jumlahTransaksiOnline ?> transaksi</div>
    </div>
    <div class="summary-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: 10px;">
        <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">Total Keseluruhan</div>
        <div style="font-size: 24px; font-weight: bold;">Rp <?= number_format($totalKeseluruhan, 0, ',', '.') ?></div>
        <div style="font-size: 12px; opacity: 0.8; margin-top: 5px;"><?= $jumlahTransaksiToko + $jumlahTransaksiOnline ?> transaksi</div>
    </div>
</div>

<!-- Transaksi Toko -->
<h3 style="margin-bottom: 15px; color:#444;">Transaksi Toko (Pembelian Langsung)</h3>
<div class="data-section">
    <table class="modern-table">
        <colgroup>
            <col style="width: 10%;">
            <col style="width: 10%;">
            <col style="width: 20%;">
            <col style="width: 25%;">
            <col style="width: 20%;">
            <col style="width: 15%;">
        </colgroup>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>ID</th>
                <th>Pelanggan</th>
                <th>Keterangan (Frame/Lensa)</th>
                <th>Pembayaran</th>
            </tr>
        </thead>
<tbody>
    <?php if (!empty($filteredBookings)): ?>
        <?php foreach ($filteredBookings as $b): ?>
        <?php 
            // Mengambil angka dari payment_info
            $payInfo = isset($b['payment_info']) ? trim($b['payment_info']) : '';
            $payNum = preg_replace('/[^0-9]/', '', $payInfo);
            $payAmount = $payNum !== '' ? (float)$payNum : 0;
        ?>
        <tr>
            <td><?= isset($b['created_at']) ? date('d-m-Y', strtotime($b['created_at'])) : '-' ?></td>
            
            <td><?= htmlspecialchars($b['name'] ?? 'N/A') ?><br><small><?= htmlspecialchars($b['phone'] ?? '-') ?></small></td>
            
            <td><?= htmlspecialchars($b['message'] ?? '-') ?></td>
            
            <td>
                <?= isset($b['created_at']) ? date('d-m-Y', strtotime($b['created_at'])) : '-' ?>
                <br>
                <small>By WhatsApp</small>
            </td>

            <td>Rp <?= number_format($payAmount, 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" style="text-align: center;">Tidak ada transaksi online pada periode ini.</td>
        </tr>
    <?php endif; ?>
</tbody>
        <?php if (!empty($filteredInvoices)): ?>
        <tfoot>
            <tr style="font-weight: bold; background: #f5f5f5;">
            </tr>
        </tfoot>
        <?php endif; ?>
    </table>
</div>

<!-- Transaksi Online -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px; margin-bottom: 15px;">
    <h3 style="color:#444; margin: 0;">Transaksi Online (Booking)</h3>
</div>
<div class="data-section">
    <table class="modern-table">
        <colgroup>
            <col style="width: 12%;">
            <col style="width: 18%;">
            <col style="width: 20%;">
            <col style="width: 15%;">
            <col style="width: 20%;">
            <col style="width: 15%;">
        </colgroup>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Jadwal</th>
                <th>Pembayaran</th>
            </tr>
        </thead>
<tbody>
    <?php if (!empty($filteredBookings)): ?>
        <?php foreach ($filteredBookings as $b): ?>
        <?php 
            // Mengambil angka dari payment_info
            $payInfo = isset($b['payment_info']) ? trim($b['payment_info']) : '';
            $payNum = preg_replace('/[^0-9]/', '', $payInfo);
            $payAmount = $payNum !== '' ? (float)$payNum : 0;
        ?>
        <tr>
            <td><?= isset($b['created_at']) ? date('d-m-Y', strtotime($b['created_at'])) : '-' ?></td>
            
            <td><?= htmlspecialchars($b['name'] ?? 'N/A') ?><br><small><?= htmlspecialchars($b['phone'] ?? '-') ?></small></td>
            
            <td><?= htmlspecialchars($b['message'] ?? '-') ?></td>
            
            <td>
                <?= isset($b['created_at']) ? date('d-m-Y', strtotime($b['created_at'])) : '-' ?>
                <br>
                <small>By WhatsApp</small>
            </td>

            <td>Rp <?= number_format($payAmount, 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" style="text-align: center;">Tidak ada transaksi online pada periode ini.</td>
        </tr>
    <?php endif; ?>
</tbody>
        <?php if (!empty($filteredBookings)): ?>
        <tfoot>
            <tr style="font-weight: bold; background: #f5f5f5;">
            </tr>
        </tfoot>
        <?php endif; ?>
    </table>
</div>