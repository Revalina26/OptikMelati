<div class="page-title">
    <div class="title-left">
        <h1>Data Produk</h1>
        <div class="breadcrumb"><a href="index.php?page=admin" style="text-decoration: none; color: inherit;">General</a> &gt; <span>Data Produk</span></div>
    </div>
    <a href="index.php?page=add_product" class="btn-create"><span class="icon">+</span> Tambah Produk</a>
</div>

<div class="data-section">
    <table class="modern-table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
            <tr>
                <td class="client-info">
                    <img src="uploads/<?= htmlspecialchars($p['image']) ?>" class="avatar" alt="<?= htmlspecialchars($p['name']) ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($p['name']) ?>&background=random'">
                    <div>
                        <div class="client-name"><?= htmlspecialchars($p['name']) ?></div>
                    </div>
                </td>
                <td><?= htmlspecialchars($p['category']) ?></td>
                <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($p['stock']) ?></td>
                <td>
                    <span class="status-badge status-paid">
                        <a href="index.php?page=edit_product&id=<?= $p['id'] ?>" style="color: inherit; text-decoration: none;">Edit</a>
                    </span>
                    <span class="status-badge status-overdue" style="margin-left: 5px;">
                        <a href="index.php?page=delete_product&id=<?= $p['id'] ?>" style="color: inherit; text-decoration: none;" onclick="return confirm('Hapus produk ini?');">Hapus</a>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
