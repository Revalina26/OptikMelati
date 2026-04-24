<div class="form-box">

<h2>Edit Produk</h2>

<form method="post" enctype="multipart/form-data">

    <input type="text" name="name" value="<?= $product['name']; ?>" required>

    <input type="number" name="price" value="<?= $product['price']; ?>" required>

    <input type="number" name="stock" value="<?= $product['stock']; ?>" required>

    <select name="category" required>
        <option value="Frame" <?= $product['category']=='Frame'?'selected':''; ?>>Frame</option>
        <option value="Lensa" <?= $product['category']=='Lensa'?'selected':''; ?>>Lensa</option>
        <option value="Sunglasses" <?= $product['category']=='Sunglasses'?'selected':''; ?>>Sunglasses</option>
    </select>

    <img src="uploads/<?= $product['image']; ?>" width="120">

    <input type="file" name="image">

    <button type="submit">Update</button>
    <a href="index.php?page=admin">Batal</a>

</form>

</div>
