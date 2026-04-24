<h2>Daftar Akun</h2>

<?php if(isset($error)): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="POST">

    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit">Daftar</button>

</form>

<p>Sudah punya akun? 
    <a href="index.php?page=login">Login di sini</a>
</p>