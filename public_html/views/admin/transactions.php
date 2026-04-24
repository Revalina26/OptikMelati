<div class="page-title">
    <div class="title-left">
        <h1>Riwayat Transaksi</h1>
        <div class="breadcrumb"><a href="index.php?page=admin" style="text-decoration: none; color: inherit;">General</a> &gt; <span>Transaksi</span></div>
    </div>
    <div class="title-right">
        <a href="index.php?page=admin_add_transaction" class="btn-add">+ Tambah Transaksi</a>
    </div>
</div>

<style>
.btn-add {
    background: #d32f2f;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: 0.3s;
    display: inline-block;
}
.btn-add:hover {
    background: #b71c1c;
}
.title-right {
    display: flex;
    align-items: center;
}
.page-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
</style>

<h3 style="margin-bottom: 15px; color:#444;">Transaksi Toko</h3>
<div class="data-section">
    <table class="modern-table">
        <colgroup>
            <col style="width: 12%;">
            <col style="width: 12%;">
            <col style="width: 22%;">
            <col style="width: 25%;">
            <col style="width: 15%;">
            <col style="width: 14%;">
        </colgroup>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>ID Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Keterangan (Frame/Lensa)</th>
                <th>Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($invoices)): ?>
                <?php foreach ($invoices as $inv): ?>
                <tr>
                    <td><?= htmlspecialchars($inv['tanggal']) ?></td>
                    <td>#<?= htmlspecialchars($inv['id']) ?></td>
                    <td><?= htmlspecialchars($inv['nama']) ?><br><small><?= htmlspecialchars($inv['no_hp']) ?></small></td>
                    <td><?= htmlspecialchars($inv['frame']) ?> / <?= htmlspecialchars($inv['lensa']) ?></td>
                    <td>
                        Rp <?= number_format($inv['jumlah'], 0, ',', '.') ?><br>
                        <small style="<?= $inv['sisa'] > 0 ? 'color:#d32f2f;' : 'color:#2e7d32;' ?>">Sisa: Rp <?= number_format($inv['sisa'], 0, ',', '.') ?></small>
                    </td>
                    <td>
                        <a href="index.php?page=admin_edit_transaction&id=<?= $inv['id'] ?>" class="btn-action btn-edit">Edit</a>
                        <a href="index.php?page=admin_print_transaction&id=<?= $inv['id'] ?>" target="_blank" class="btn-action btn-print">Cetak</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data nota penjualan toko.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px; margin-bottom: 15px;">
    <h3 style="color:#444; margin: 0;">Transaksi Online</h3>
    <a href="index.php?page=admin_add_online_transaction" class="btn-add">+ Tambah Transaksi</a>
</div>
<div class="data-section">
    <table class="modern-table">
        <colgroup>
            <col style="width: 12%;">
            <col style="width: 12%;">
            <col style="width: 22%;">
            <col style="width: 25%;">
            <col style="width: 15%;">
            <col style="width: 14%;">
        </colgroup>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>ID Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Keterangan</th>
                <th>Pembayaran</th>
                <th>Aksi</th>   
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($bookings)): ?>
                <?php foreach ($bookings as $b): ?>
                <tr>
                    <td><?= htmlspecialchars(date('Y-m-d', strtotime($b['created_at']))) ?></td>
                    <td>#<?= htmlspecialchars($b['id']) ?></td>
                    <td><?= htmlspecialchars($b['name']) ?><br><small><?= htmlspecialchars($b['phone']) ?></small></td>
                    <td><?= htmlspecialchars($b['message']) ?></td>
                    <td>
                        <?php 
                        $payInfo = trim($b['payment_info'] ?: '');
                        if ($payInfo === '') {
                            echo '-';
                        } elseif (stripos($payInfo, 'Rp') === 0) {
                            echo htmlspecialchars($payInfo);
                        } else {
                            echo 'Rp ' . htmlspecialchars($payInfo);
                        }
                        ?>
                    </td>
                    <td>
                        <a href="index.php?page=admin_edit_online_transaction&id=<?= $b['id'] ?>" class="btn-action btn-edit">Edit</a>
                        <?php if ($b['status'] !== 'Selesai'): ?>
                            <a href="index.php?page=admin_toggle_online_status&id=<?= $b['id'] ?>&status=Selesai" class="btn-action" style="background:#e8f5e9; color:#2e7d32; border:1px solid #c8e6c9;">Tandai Selesai</a>
                        <?php else: ?>
                            <a href="index.php?page=admin_toggle_online_status&id=<?= $b['id'] ?>&status=Belum" class="btn-action" style="background:#ffebee; color:#c62828; border:1px solid #ffcdd2;">Tandai Belum</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data transaksi online.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
.btn-action {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    margin-right: 5px;
    transition: 0.3s;
}
.btn-edit {
    background: #e3f2fd;
    color: #1565c0;
    border: 1px solid #bbdefb;
}
.btn-edit:hover { background: #bbdefb; }
.btn-print {
    background: #f5f5f5;
    color: #444;
    border: 1px solid #ccc;
}
.btn-print:hover { background: #e0e0e0; }
</style>
