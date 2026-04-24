<!-- HERO SECTION -->

<section class="hero-banner">
    <img src="assets/img/gallery1.jpg" class="hero-bg">
    
    <div class="hero-content">
        <h2>
            KOLEKSI KACAMATA <br>
            TERBAIK DAN TERKINI
        </h2>

        <p>
            Temukan kacamata premium untuk dewasa dan anak-anak 
            dengan kualitas terbaik dan harga terjangkau.
        </p>

        <a href="https://wa.me/6282226846262" target="_blank" class="hero-btn">
            KONSULTASI SEKARANG
        </a>
    </div>

</section>

<!-- FITUR SECTION -->
<section class="features">

    <div class="feature-card">
        <div class="icon blue">🛡️</div>
        <h3>Kualitas Premium</h3>
        <p>Hanya menggunakan material terbaik untuk bingkai dan lensa.</p>
    </div>

    <div class="feature-card">
        <div class="icon orange">⚡</div>
        <h3>Harga Terjangkau</h3>
        <p>Penghematan hingga 50% dibandingkan dengan toko lainnya.</p>
    </div>

    <div class="feature-card">
        <div class="icon green">✔️</div>
        <h3>Garansi Pembelian</h3>
        <p>Jaminan kualitas untuk setiap pembelian produk kami.</p>
    </div>

    <div class="feature-card">
        <div class="icon purple">📞</div>
        <h3>Free Konsultasi</h3>
        <p>Tim kami siap membantu Anda dengan pertanyaan dan konsultasi.</p>
    </div>

</section>

<!-- CATEGORY SECTION -->
<section class="categories">

    <h2 class="shop-title">Kategori Pilihan</h2>
    <p>Temukan berbagai pilihan kacamata dan lensa yang sesuai dengan kebutuhan Anda.</p>

    <div class="shop-grid">

        <div class="shop-card">
            <img src="assets/images/men.jpg" alt="Men">
            <div class="shop-overlay">
                <h3>MEN</h3>
            </div>
        </div>

        <div class="shop-card">
            <img src="assets/images/women.jpg" alt="Women">
            <div class="shop-overlay">
                <h3>WOMEN</h3>
            </div>
        </div>

        <div class="shop-card">
            <img src="assets/images/kids.jpg" alt="Kids">
            <div class="shop-overlay">
                <h3>KIDS</h3>
            </div>
        </div>
    </div>
</section>

</section>


<!-- KONSULTASI SECTION -->
<section id="konsultasi" class="contact-section fade-section">
    <div class="container">
        <h2>Konsultasi Gratis</h2>
        <p>Butuh bantuan memilih kacamata atau memiliki pertanyaan? Hubungi kami melalui WhatsApp untuk konsultasi cepat.</p>
        <a href="https://wa.me/6282226846262" target="_blank" class="btn-primary">Chat via WhatsApp</a>
    </div>
</section> 

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('hamburgerBtn');
    const dropdown = document.getElementById('adminMenuDropdown');

    if (!btn || !dropdown) return;

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });

    // ❌ HAPUS event document click (ini penyebab utama bug)
});
</script>


