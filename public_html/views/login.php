<div class="login-container">
    <div class="login-box">
        <div class="login-header">
            <h2>Portal Admin</h2>
            <p>Masuk ke dashboard Anda</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="alert alert-error">
                <strong>Error!</strong> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-login-submit">Login</button>
        </form>

        <div class="login-footer">
            <p>Belum punya akun? <a href="index.php?page=register">Daftar di sini</a></p>
        </div>
    </div>
</div>