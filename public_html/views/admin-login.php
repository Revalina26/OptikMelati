<?php
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // LOGIN SEDERHANA (sementara)
    if ($username === 'admin' && $password === '123') {

        $_SESSION['user'] = [
            'username' => $username,
            'role' => 'admin'
        ];

        header("Location: index.php?page=admin");
        exit;

    } else {
        $error = "Username atau password salah!";
    }
}
?>