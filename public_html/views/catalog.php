<div class="main-content">

    <div class="container">

        <h2 class="catalog-title">Katalog Produk</h2>
        <p class="catalog-sub">Temukan kacamata dan lensa impian Anda di sini.</p>

        <!-- 🔹 SEARCH & FILTER -->
        <div class="catalog-top">

            <form method="GET" class="search-box">
                <input type="hidden" name="page" value="catalog">
                <input type="text" name="search" placeholder="Cari produk..." value="<?= $_GET['search'] ?? '' ?>">
            </form>

            <div class="filter-buttons">
                <a href="index.php?page=catalog&category=Frame" class="filter-btn">Frame</a>
                <a href="index.php?page=catalog&category=Lensa" class="filter-btn">Lensa</a>
                <a href="index.php?page=catalog&category=Sunglasses" class="filter-btn">Sunglasses</a>
            </div>

        </div>

        <!-- 🔹 PRODUK -->
        <div class="catalog-grid">

        <?php if (!empty($products)): ?>

            <?php foreach($products as $product): ?>
                <div class="product-card">

                    <div class="product-image">
                        <span class="badge">
                            <?= strtoupper($product['category']) ?>
                        </span>
                        <img src="uploads/<?= $product['image'] ?>" alt="">
                    </div>

                    <div class="product-body">
                        <h3><?= $product['name'] ?></h3>

                        <div class="price-stock">
                            <div>
                                <small>Harga</small>
                                <h4>Rp <?= number_format($product['price']) ?></h4>
                            </div>
                        </div>

                        <button class="buy-btn">🛒 Beli Sekarang</button>
                    </div>

                </div>
            <?php endforeach; ?>

        <?php else: ?>

            <div class="product-card empty-card">
                <div class="product-image"></div>
                <div class="product-body">
                    <h3>Produk Belum Tersedia</h3>
                    <p>Produk akan segera hadir.</p>
                </div>
            </div>

        <?php endif; ?>

        </div>

    </div>

</div>