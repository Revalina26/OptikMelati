<div class="page-title">
    <div class="title-left">
        <h1>Tambah Transaksi Online (Konsultasi / Booking)</h1>
        <div class="breadcrumb"><a href="index.php?page=admin" style="text-decoration: none; color: inherit;">General</a> &gt; <a href="index.php?page=admin_transactions">Transaksi</a> &gt; <span>Tambah Online</span></div>
    </div>
</div>

<div class="form-box nota-box">
    <?php if (!empty($error)): ?>
        <div class="alert error"><?= $error ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="alert success"><?= $success ?></div>
    <?php endif; ?>

    <form action="index.php?page=admin_add_online_transaction" method="post" class="nota-form">
        <div class="form-row">
            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input type="text" name="name" placeholder="Masukkan nama pelanggan" required>
            </div>
            <div class="form-group">
                <label>No. HP (WhatsApp)</label>
                <input type="text" name="phone" placeholder="Contoh: 081234567890" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Pesan / Keterangan / Detail Konsultasi</label>
                <textarea name="message" rows="5" placeholder="Ketikkan detail keluhan, pesanan, atau tanggal konsultasi di sini..." style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem; outline: none; transition: 0.3s; font-family: inherit; resize: vertical;" required></textarea>
            </div>
            <div class="form-group">
                <label>Info Pembayaran (Manual)</label>
                <textarea name="payment_info" rows="5" placeholder="Contoh: Total Rp 300.000, DP Rp 150.000 (BCA)" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem; outline: none; transition: 0.3s; font-family: inherit; resize: vertical;"></textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Simpan Transaksi Online</button>
            <a href="index.php?page=admin_transactions" class="btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<style>
.nota-box {
    background: #fff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    max-width: 800px;
    margin-bottom: 30px;
}
.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}
.form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
}
.form-group label {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 6px;
    color: #444;
}
.form-group input, .form-group textarea {
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 0.95rem;
    outline: none;
    transition: 0.3s;
}
.form-group input:focus, .form-group textarea:focus {
    border-color: #d32f2f;
    box-shadow: 0 0 0 3px rgba(211,47,47,0.1);
}

.form-actions {
    margin-top: 30px;
    display: flex;
    justify-content: flex-end;
    gap: 15px;
}
.btn-primary {
    background: #d32f2f;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}
.btn-primary:hover { background: #b71c1c; }
.btn-secondary {
    background: #f5f5f5;
    color: #333;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    transition: 0.3s;
    border: 1px solid #ddd;
}
.btn-secondary:hover { background: #e0e0e0; }
.alert { padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; }
.alert.error { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
.alert.success { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
</style>
