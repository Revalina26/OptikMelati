<div class="page-title">
    <div class="title-left">
        <h1>Dashboard Laporan</h1>
        <div class="breadcrumb"><a href="index.php?page=admin" style="text-decoration: none; color: inherit;">General</a> &gt; <span>Overview Bulanan</span></div>
    </div>
</div>

<h2 style="margin-top: 10px; margin-bottom: 25px; color:#444;">Laporan Transaksi Per Bulan</h2>

<?php if (empty($monthlyStats)): ?>
    <div style="background: #fff; border-radius: 12px; padding: 30px; text-align: center; color: #666;">
        Belum ada data transaksi yang tercatat.
    </div>
<?php else: ?>
    <?php foreach ($monthlyStats as $monthKey => $stats): ?>
    <?php 
        $totalRev = $stats['toko_revenue'] + $stats['online_revenue'];
        $totalOrd = $stats['toko_orders'] + $stats['online_orders'];
        
        // Translating month name to Indonesian
        $months = ['January'=>'Januari', 'February'=>'Februari', 'March'=>'Maret', 'April'=>'April', 'May'=>'Mei', 'June'=>'Juni', 'July'=>'Juli', 'August'=>'Agustus', 'September'=>'September', 'October'=>'Oktober', 'November'=>'November', 'December'=>'Desember'];
        $engMonth = date('F', strtotime($monthKey . '-01'));
        $year = date('Y', strtotime($monthKey . '-01'));
        $monthName = $months[$engMonth] . ' ' . $year;
    ?>
    <div class="monthly-card" style="background: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 25px; border-left: 5px solid #d32f2f;">
        <h3 style="margin-top: 0; color: #333; border-bottom: 1px solid #f0f0f0; padding-bottom: 15px; margin-bottom: 20px; font-size: 1.25rem;">
            Bulan: <?= htmlspecialchars($monthName) ?>
        </h3>
        
        <div class="monthly-grid" style="display: flex; gap: 25px; flex-wrap: wrap;">
            
            <!-- Box Pendapatan -->
            <div style="flex: 1; min-width: 250px; background: #fafafa; padding: 20px; border-radius: 10px; border: 1px solid #eee;">
                <h4 style="margin: 0 0 10px 0; color: #666; font-size: 0.95rem; display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 1.2rem;">💰</span> Total Pendapatan
                </h4>
                <div style="font-size: 1.8rem; font-weight: 700; color: #2e7d32; margin-bottom: 15px;">
                    Rp <?= number_format($totalRev, 0, ',', '.') ?>
                </div>
                
                <div style="font-size: 0.9rem; color: #555; background: #fff; padding: 12px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>🏢 Transaksi Toko:</span>
                        <span style="font-weight: 600;">Rp <?= number_format($stats['toko_revenue'], 0, ',', '.') ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>🌐 Transaksi Online:</span>
                        <span style="font-weight: 600;">Rp <?= number_format($stats['online_revenue'], 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>

            <!-- Box Transaksi -->
            <div style="flex: 1; min-width: 250px; background: #fafafa; padding: 20px; border-radius: 10px; border: 1px solid #eee;">
                <h4 style="margin: 0 0 10px 0; color: #666; font-size: 0.95rem; display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 1.2rem;">📋</span> Total Transaksi
                </h4>
                <div style="font-size: 1.8rem; font-weight: 700; color: #1565c0; margin-bottom: 15px;">
                    <?= $totalOrd ?> Transaksi
                </div>
                
                <div style="font-size: 0.9rem; color: #555; background: #fff; padding: 12px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>🏢 Transaksi Toko:</span>
                        <span style="font-weight: 600;"><?= $stats['toko_orders'] ?> Transaksi</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>🌐 Transaksi Online:</span>
                        <span style="font-weight: 600;"><?= $stats['online_orders'] ?> Transaksi</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
