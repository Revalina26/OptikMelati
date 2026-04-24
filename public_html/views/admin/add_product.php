<div class="form-box">

<h2>Tambah Produk</h2>

<?php if (!empty($error)): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<form action="index.php?page=add_product" method="post" enctype="multipart/form-data">

    <input type="text" name="name" placeholder="Nama Produk" required>

    <input type="number" name="price" placeholder="Harga" required>

    <input type="number" name="stock" placeholder="Stok" required>

    <select name="category" required>
        <option disabled selected>Pilih Kategori</option>
        <option value="Frame">Frame</option>
        <option value="Lensa">Lensa</option>
        <option value="Sunglasses">Sunglasses</option>
    </select>

    <input type="file" name="image" id="imageInput" required>

    <img id="previewImg" style="max-width:150px; display:none; margin-top:10px;">

    <button type="submit">Simpan</button>
    <a href="index.php?page=admin">Batal</a>

</form>

</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(e){
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev){
        const img = document.getElementById('previewImg');
        img.src = ev.target.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(file);
});
</script>
