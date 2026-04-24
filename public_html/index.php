<?php
session_start();

define('BASE_PATH', __DIR__);

require_once "config/config.php";
require_once "app/core/Database.php";

$page = $_GET['page'] ?? 'home';

switch ($page) {

    case 'home':
        require_once "app/controllers/HomeController.php";
        (new HomeController)->index();
        break;

    case 'catalog':
        require_once "app/controllers/CatalogController.php";
        (new CatalogController)->index();
        break;

    case 'admin':
        require_once "app/controllers/AdminController.php";
        ob_clean(); 
        (new AdminController)->index();
        exit;

    case 'admin_products':
        require_once "app/controllers/AdminController.php";
        ob_clean(); 
        (new AdminController)->products_page();
        exit;

    case 'admin_transactions':
        require_once "app/controllers/AdminController.php";
        ob_clean(); 
        (new AdminController)->transactions();
        exit;

    case 'admin_add_transaction':
        require_once "app/controllers/AdminController.php";
        ob_clean(); 
        (new AdminController)->add_transaction();
        exit;

    case 'admin_edit_transaction':
        require_once "app/controllers/AdminController.php";
        ob_clean(); 
        (new AdminController)->edit_transaction();
        exit;

    case 'admin_print_transaction':
        require_once "app/controllers/AdminController.php";
        ob_clean(); 
        (new AdminController)->print_transaction();
        exit;

    case 'admin_add_online_transaction':
        require_once "app/controllers/AdminController.php";
        ob_clean(); 
        (new AdminController)->add_online_transaction();
        exit;

    case 'admin_edit_online_transaction':
        require_once "app/controllers/AdminController.php";
        ob_clean(); 
        (new AdminController)->edit_online_transaction();
        exit;

    case 'admin_toggle_online_status':
        require_once "app/controllers/AdminController.php";
        ob_clean(); 
        (new AdminController)->toggle_online_status();
        exit;

    case 'admin_customers':
        require_once "app/controllers/AdminController.php";
        ob_clean(); 
        (new AdminController)->customers();
        exit;

    case 'admin_bookings':
        require_once "app/controllers/AdminController.php";
        ob_clean(); 
        (new AdminController)->bookings();
        exit;

    case 'admin_laporan':
        require_once "app/controllers/AdminController.php";
        ob_clean(); 
        (new AdminController)->laporan();
        exit;

    case 'admin-login':
        require_once "app/controllers/AuthController.php";
        (new AuthController)->adminLogin();
        break;

    case 'sales_data':
        require_once "app/controllers/AdminController.php";
        (new AdminController)->sales_data();
        break;

    case 'add_product':
        require_once "app/controllers/AdminController.php";
        (new AdminController)->add_product();
        break;

    case 'login':
        require_once "app/controllers/AuthController.php";
        (new AuthController)->login();
        break;

    case 'logout':
        require_once "app/controllers/AuthController.php";
        (new AuthController)->logout();
        break;

    case 'register':
        require_once "app/controllers/AuthController.php";
        (new AuthController)->register();
        break;

    case 'edit_product':
        require_once "app/controllers/AdminController.php";
        (new AdminController)->edit_product();
        break;

    case 'delete_product':
        require_once "app/controllers/AdminController.php";
        (new AdminController)->delete_product();
        break;

    default:
        echo "404 - Halaman tidak ditemukan";
}