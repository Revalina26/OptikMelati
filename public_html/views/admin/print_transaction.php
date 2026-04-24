<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Penjualan - <?= htmlspecialchars($invoice['no_nota'] ?: $invoice['id']) ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #fff;
            color: #000;
            margin: 0;
            padding: 20px;
        }
        .nota-container {
            width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 20px 30px;
            background-color: #fcf9c5; /* Yellowish receipt background */
            box-sizing: border-box;
        }
        .header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .header-icon {
            font-size: 60px;
            margin-right: 20px;
            line-height: 1;
        }
        .header-text {
            flex: 1;
            text-align: center;
        }
        .header-text h1 {
            margin: 0;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .header-text p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .nota-title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            text-decoration: underline;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }
        
        .main-content {
            display: flex;
            justify-content: space-between;
        }
        
        .left-col {
            width: 45%;
        }
        .right-col {
            width: 50%;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
            font-size: 15px;
        }
        .info-label {
            width: 130px;
        }
        .info-value {
            flex: 1;
            border-bottom: 1px dotted #000;
        }

        table.lens-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: 1px solid #000;
        }
        table.lens-table th, table.lens-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }
        .add-row, .pd-row {
            border: 1px solid #000;
            padding: 8px;
            font-size: 14px;
        }
        .pd-row {
            display: flex;
        }
        .pd-label {
            width: 50px;
            font-weight: bold;
        }

        .payment-section {
            margin-top: 30px;
            margin-left: 50%;
        }
        .payment-row {
            display: flex;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .payment-label {
            width: 120px;
        }
        .payment-value {
            flex: 1;
            border-bottom: 1px dotted #000;
        }

        .footer {
            margin-top: 40px;
            font-size: 13px;
            font-style: italic;
            font-weight: bold;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }
            .nota-container {
                box-shadow: none;
                border: 2px solid #000;
                width: 100%;
                max-width: 800px;
                /* Background colors usually don't print unless enabled by user, 
                   but we add this to be safe */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body onload="window.print()">

<div class="nota-container">
    <div class="header">
        <div class="header-icon">👓</div>
        <div class="header-text">
            <h1>OPTIK MELATI</h1>
            <p>Jl. Suryo Kusumo Jepang - Mejobo Kudus<br>Hp. 0822 2684 6262</p>
        </div>
    </div>

    <div class="nota-title">NOTA PENJUALAN</div>

    <div class="info-row" style="margin-bottom: 20px;">
        <div class="info-label">ID Transaksi</div>
        <div class="info-value">: <?= htmlspecialchars($invoice['id']) ?></div>
    </div>

    <div class="main-content">
        <div class="left-col">
            <div class="info-row">
                <div class="info-label">Tanggal</div>
                <div class="info-value">: <?= htmlspecialchars($invoice['tanggal']) ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Nama Ny/Tn/Sdr</div>
                <div class="info-value">: <?= htmlspecialchars($invoice['nama']) ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">No. Hp.</div>
                <div class="info-value">: <?= htmlspecialchars($invoice['no_hp']) ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Resep Dari</div>
                <div class="info-value">: <?= htmlspecialchars($invoice['resep_dari']) ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Frame</div>
                <div class="info-value">: <?= htmlspecialchars($invoice['frame']) ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Kaca / Lensa</div>
                <div class="info-value">: <?= htmlspecialchars($invoice['lensa']) ?></div>
            </div>
        </div>

        <div class="right-col">
            <div style="text-align: center; font-size:13px; margin-bottom:5px;">(adaptasi ukuran awal)</div>
            <table class="lens-table">
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
                <tr>
                    <td><?= !empty($invoice['r_sph']) ? htmlspecialchars($invoice['r_sph']) : '' ?></td>
                    <td><?= !empty($invoice['r_cyl']) ? htmlspecialchars($invoice['r_cyl']) : '' ?></td>
                    <td><?= !empty($invoice['r_as']) ? htmlspecialchars($invoice['r_as']) : '' ?></td>
                    <td><?= !empty($invoice['l_sph']) ? htmlspecialchars($invoice['l_sph']) : '' ?></td>
                    <td><?= !empty($invoice['l_cyl']) ? htmlspecialchars($invoice['l_cyl']) : '' ?></td>
                    <td><?= !empty($invoice['l_as']) ? htmlspecialchars($invoice['l_as']) : '' ?></td>
                </tr>
            </table>
            <div class="add-row">
                <strong>Add :</strong> <?= htmlspecialchars($invoice['add_lens']) ?>
            </div>
            <div class="pd-row">
                <div class="pd-label">PD.</div>
                <div style="flex:1;">
                    <div style="display:flex; justify-content:space-between;">
                        <span>U. Jauh</span>
                        <span style="border-bottom:1px solid #000; width:150px; text-align:center;"><?= htmlspecialchars($invoice['pd_jauh']) ?></span>
                        <span>m</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-top:5px;">
                        <span>U. Dekat</span>
                        <span style="border-bottom:1px solid #000; width:150px; text-align:center;"><?= htmlspecialchars($invoice['pd_dekat']) ?></span>
                        <span>m</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="payment-section">
        <div class="payment-row">
            <div class="payment-label">Jumlah</div>
            <div class="payment-value">Rp. <?= number_format($invoice['jumlah'], 0, ',', '.') ?></div>
        </div>
        <div class="payment-row">
            <div class="payment-label">Uang Muka</div>
            <div class="payment-value">Rp. <?= number_format($invoice['uang_muka'], 0, ',', '.') ?> <?= $invoice['metode_dp'] ? '('.htmlspecialchars($invoice['metode_dp']).')' : '' ?></div>
        </div>
        <div class="payment-row">
            <div class="payment-label">Sisa</div>
            <div class="payment-value">Rp. <?= number_format($invoice['sisa'], 0, ',', '.') ?></div>
        </div>
    </div>

    <div class="footer">
        Perhatian :<br>
        Barang yang sudah dibeli tidak dapat dikembalikan
    </div>
</div>

</body>
</html>
