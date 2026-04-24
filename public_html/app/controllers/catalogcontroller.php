<?php
require_once BASE_PATH . "/app/models/Product.php";

class CatalogController {

public function index() {

        $limit = 6;
        $page = $_GET['p'] ?? 1;
        $offset = ($page - 1) * $limit;

        $search = $_GET['search'] ?? null;
        $sort = $_GET['sort'] ?? null;
        $category = $_GET['category'] ?? null;   // ← TAMBAHKAN INI

        $products = Product::getAll($limit, $offset, $search, $sort, $category);
        $totalRows = Product::countAll($search, $category);
        $totalPages = ceil($totalRows / $limit);

        require_once BASE_PATH . "/views/layouts/header.php";
        require_once BASE_PATH . "/views/catalog.php";
        require_once BASE_PATH . "/views/layouts/footer.php";
    }
}