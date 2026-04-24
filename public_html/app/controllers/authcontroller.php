<?php
require_once BASE_PATH . "/app/models/User.php";

class AuthController {

    public function login() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = User::findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {

                $_SESSION['user'] = $user;

                if ($user['role'] === 'admin') {
                    header("Location: index.php?page=admin");
                } else {
                    header("Location: index.php?page=home");
                }
                exit;

            } else {
                $error = "Username atau password salah!";
            }
        }

        require_once BASE_PATH . "/views/layouts/header.php";
        require_once BASE_PATH . "/views/login.php";
        require_once BASE_PATH . "/views/layouts/footer.php";
    }


    public function adminLogin() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = User::findByUsername($username);

            if ($user && password_verify($password, $user['password']) && $user['role'] === 'admin') {

                $_SESSION['user'] = $user;
                header("Location: index.php?page=admin");
                exit;

            } else {
                $error = "Login admin gagal!";
            }
        }

        require_once BASE_PATH . "/views/layouts/header.php";
        require_once BASE_PATH . "/views/login.php";
        require_once BASE_PATH . "/views/layouts/footer.php";
    }


    public function register() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            require_once BASE_PATH . "/app/core/Database.php";
            $db = Database::connect();

            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $check = $db->prepare("SELECT id FROM users WHERE username = ?");
            $check->execute([$username]);

            if ($check->rowCount() > 0) {
                $error = "Username sudah digunakan!";
            } else {

                $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
                $stmt->execute([$username, $password]);

                header("Location: index.php?page=login");
                exit;
            }
        }

        require_once BASE_PATH . "/views/layouts/header.php";
        require_once BASE_PATH . "/views/register.php";
        require_once BASE_PATH . "/views/layouts/footer.php";
    }


    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit;
    }
}