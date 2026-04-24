<div class="page-title">
    <div class="title-left">
        <h1>Data Pembeli</h1>
        <div class="breadcrumb"><a href="index.php?page=admin" style="text-decoration: none; color: inherit;">General</a> &gt; <span>Data Pembeli</span></div>
    </div>
</div>

<div class="data-section">
    <table class="modern-table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Sumber</th>
                <th>Nama Pelanggan</th>
                <th>Detail Transaksi</th>
                <th>Jumlah / Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customersData as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['tanggal']) ?></td>
                <td>
                    <span class="status-badge <?= $c['sumber'] === 'Toko' ? 'status-paid' : 'status-draft' ?>">
                        <?= htmlspecialchars($c['sumber']) ?>
                    </span>
                </td>
                <td class="client-info">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($c['nama']) ?>&background=random" class="avatar" alt="<?= htmlspecialchars($c['nama']) ?>">
                    <div>
                        <div class="client-name"><?= htmlspecialchars($c['nama']) ?></div>
                        <small><?= htmlspecialchars($c['no_hp']) ?></small>
                    </div>
                </td>
                <td><?= htmlspecialchars($c['detail']) ?></td>
                <td><?= htmlspecialchars($c['jumlah']) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($customersData)): ?>
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data pembeli.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
.status-badge {
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.85rem;
    color: white;
}
.status-paid { background: #2e7d32; }
.status-draft { background: #1565c0; }
.client-info {
    display: flex;
    align-items: center;
    gap: 10px;
}
.client-name {
    font-weight: 600;
}
</style>
