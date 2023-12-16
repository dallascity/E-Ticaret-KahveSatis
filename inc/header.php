<?php
include "db.php";
include "inc/function.php";
session_start();
ob_start();
if ($sayfa != "login" && $sayfa != "register") {
    if (!(isset($_SESSION["oturum"]) )) {
        route("login.php");
    }
}
if(isset($_SESSION['shopcart'])){
    $shopCart=$_SESSION['shopcart'];
    $totalCount=$shopCart['summary']['total_count'];
    $totalPrice=$shopCart['summary']['total_price'];
    $products = $shopCart['products'];

}
else{
    $totalCount=0;
    $totalPrice=0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>

    <title>Kahve Dükkanı</title>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-coffee" aria-hidden="true"></i>
                <span class="ms-2" style="font-family: 'Roboto Condensed', sans-serif;">Kahve Dükkanı</span>
            </a>

            <div class="d-flex align-items-center">
                <?php if (!isset($_SESSION['name']) && !isset($_SESSION['surname'])) : ?>
                    <a href="login.php" class="btn btn-outline-light me-3">Giriş</a>
                    <a href="register.php" class="btn btn-outline-light">Kayıt Ol</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['authority']) && $_SESSION['authority'] == 1) : ?>
                    <a href="admin/index.php" class="btn btn-outline-light">Admin Panel</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['name']) && isset($_SESSION['surname'])) : ?>
                    <div class="dropdown me-3">
                        <button class="btn dropdown-toggle text-light" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>
                            <?= $_SESSION['name'] . " " . $_SESSION['surname'] ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#">Hesap Bilgileri</a></li>
                            <li><a class="dropdown-item" href="#">Siparişlerim</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="actions/logout.php">Çıkış Yap</a></li>
                        </ul>
                    </div>
                    <div class="position-relative">
                        <a href="shopcard.php" class="btn btn-outline-light me-3">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                        <span class="cart-price position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?=$totalPrice."TL"?>
                            <span class="visually-hidden">Sepet Tutarı</span>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

</head>