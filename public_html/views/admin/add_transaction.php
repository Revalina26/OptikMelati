<div class="page-title">
    <div class="title-left">
        <h1>Tambah Transaksi (Nota Penjualan)</h1>
        <div class="breadcrumb"><a href="index.php?page=admin" style="text-decoration: none; color: inherit;">General</a> &gt; <a href="index.php?page=admin_transactions">Transaksi</a> &gt; <span>Tambah</span></div>
    </div>
</div>

<div class="form-box nota-box">
    <?php if (!empty($error)): ?>
        <div class="alert error"><?= $error ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="alert success"><?= $success ?></div>
    <?php endif; ?>

    <form action="index.php?page=admin_add_transaction" method="post" class="nota-form">
        <!-- Header Info -->
        <div class="form-row">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input type="text" name="nama" placeholder="Contoh: Indah .p" required>
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="no_hp" placeholder="Contoh: 0822 7551 2140" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Resep Dari</label>
                <input type="text" name="resep_dari" placeholder="Nama Dokter / Optik">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Frame</label>
                <input type="text" name="frame" placeholder="Contoh: Stylo 8181 pink">
            </div>
            <div class="form-group">
                <label>Kaca / Lensa</label>
                <input type="text" name="lensa" placeholder="Contoh: photogrey">
            </div>
        </div>

        <!-- Prescription Table -->
        <h3 class="section-title">Ukuran Lensa</h3>
        <table class="prescription-table">
            <thead>
                <tr>
                    <th colspan="3">KANAN</th>
                    <th colspan="3">KIRI</th>
                </tr>
                <tr>
                    <th>SPH</th>
                    <th>CYL</th>
                    <th>AS</th>
                    <th>SPH</th>
                    <th>CYL</th>
                    <th>AS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="r_sph" placeholder="-0.50"></td>
                    <td><input type="text" name="r_cyl"></td>
                    <td><input type="text" name="r_as"></td>
                    <td><input type="text" name="l_sph" placeholder="-0.50"></td>
                    <td><input type="text" name="l_cyl"></td>
                    <td><input type="text" name="l_as"></td>
                </tr>
                <tr>
                    <td colspan="6" class="add-row">
                        <label>Add :</label> <input type="text" name="add_lens">
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="pd-row">
                        <div class="pd-inputs">
                            <label>PD.</label>
                            <div>
                                <span>U. Jauh:</span> <input type="text" name="pd_jauh"> m<br>
                                <span>U. Dekat:</span> <input type="text" name="pd_dekat"> m
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Payment Info -->
        <h3 class="section-title">Pembayaran</h3>
        <div class="payment-section">
            <div class="form-group row-inline">
                <label>Jumlah (Rp.)</label>
                <input type="number" name="jumlah" id="jumlah" placeholder="360000" required>
            </div>
            <div class="form-group row-inline">
                <label>Uang Muka (Rp.)</label>
                <input type="number" name="uang_muka" id="uang_muka" placeholder="100000" required>
                <input type="text" name="metode_dp" placeholder="(Tunai / Transfer)" style="width: 120px; margin-left:10px;">
            </div>
            <div class="form-group row-inline">
                <label>Sisa (Rp.)</label>
                <input type="number" name="sisa" id="sisa" placeholder="260000" readonly>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Simpan Transaksi</button>
            <a href="index.php?page=admin_transactions" class="btn-secondary">Batal</a>
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
.form-group input {
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 0.95rem;
    outline: none;
    transition: 0.3s;
}
.form-group input:focus {
    border-color: #d32f2f;
    box-shadow: 0 0 0 3px rgba(211,47,47,0.1);
}
.section-title {
    margin-top: 30px;
    margin-bottom: 15px;
    font-size: 1.1rem;
    color: #d32f2f;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 8px;
}

/* Table Prescription */
.prescription-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
.prescription-table th, .prescription-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}
.prescription-table th {
    background: #f9f9f9;
    font-weight: 600;
    font-size: 0.9rem;
}
.prescription-table td input {
    width: 100%;
    box-sizing: border-box;
    border: 1px solid #ccc;
    padding: 6px;
    border-radius: 4px;
    text-align: center;
}
.add-row, .pd-row {
    text-align: left !important;
    padding: 10px 15px !important;
}
.add-row label { font-weight: 600; margin-right: 10px; }
.add-row input { width: 200px !important; display: inline-block !important; }

.pd-inputs { display: flex; align-items: center; gap: 20px; }
.pd-inputs > label { font-weight: 600; font-size:1.1rem; }
.pd-inputs span { display: inline-block; width: 70px; font-size: 0.9rem; }
.pd-inputs input { width: 100px !important; display: inline-block !important; margin-bottom: 5px; }

/* Payment Section */
.payment-section {
    background: #fdfdfd;
    padding: 15px;
    border: 1px solid #eee;
    border-radius: 8px;
}
.row-inline {
    flex-direction: row;
    align-items: center;
    margin-bottom: 10px;
    justify-content: flex-end;
}
.row-inline label {
    width: 150px;
    margin-bottom: 0;
    text-align: right;
    margin-right: 15px;
}
.row-inline input[type="number"] {
    width: 200px;
    text-align: right;
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

<script>
    // Script to auto-calculate Sisa
    const jumlahInput = document.getElementById('jumlah');
    const dpInput = document.getElementById('uang_muka');
    const sisaInput = document.getElementById('sisa');

    function calculateSisa() {
        const jumlah = parseFloat(jumlahInput.value) || 0;
        const dp = parseFloat(dpInput.value) || 0;
        sisaInput.value = jumlah - dp;
    }

    jumlahInput.addEventListener('input', calculateSisa);
    dpInput.addEventListener('input', calculateSisa);
</script>
