<div class="page-title">
    <div class="title-left">
        <h1>Booking</h1>
        <div class="breadcrumb"><a href="index.php?page=admin" style="text-decoration: none; color: inherit;">General</a> &gt; <span>Booking</span></div>
    </div>
</div>

<div class="data-section">
    <table class="modern-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal Booking</th>
                <th>Nama Pelanggan</th>
                <th>Nomor HP (WhatsApp)</th>
                <th>Pesan / Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $b): ?>
            <tr>
                <td><?= htmlspecialchars($b['id']) ?></td>
                <td><?= htmlspecialchars($b['created_at']) ?></td>
                <td class="client-info">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($b['name']) ?>&background=random" class="avatar" alt="<?= htmlspecialchars($b['name']) ?>">
                    <div class="client-name"><?= htmlspecialchars($b['name']) ?></div>
                </td>
                <td><?= htmlspecialchars($b['phone']) ?></td>
                <td><?= htmlspecialchars(substr($b['message'], 0, 50)) ?><?= strlen($b['message']) > 50 ? '...' : '' ?></td>
                <td>
                    <span class="status-badge <?= $b['status'] === 'Pending' ? 'status-unpaid' : 'status-paid' ?>">
                        <?= htmlspecialchars($b['status']) ?>
                    </span>
                </td>
                <td>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $b['phone']) ?>" target="_blank" style="text-decoration: none;">
                        <span class="status-badge status-draft" style="cursor: pointer; background: #25D366; color: white; border: none;">Hubungi WA</span>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($bookings)): ?>
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data booking / pesan WhatsApp saat ini.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
