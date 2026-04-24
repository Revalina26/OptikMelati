<?php

class HomeController {

    public function index() {
        require_once BASE_PATH . "/views/layouts/header.php";
        require_once BASE_PATH . "/views/home.php";
        require_once BASE_PATH . "/views/layouts/footer.php";
    }

}