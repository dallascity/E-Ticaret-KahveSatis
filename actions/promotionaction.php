<?php
include "../inc/db.php";
include "../inc/function.php";
session_start();
try {
    $error = null;
    if (isset($_SESSION['promotion'])) {
        $error = "Zaten kampanya kodunuz aktif";
        errorAlert($error);
    }

    if (isset($_POST['process'])) {
        if ($error == null) {
            $promotion = $_POST['promotion'];
            $promotion = htmlspecialchars(trim($promotion));

            $control = $db->prepare("SELECT promotions FROM promotions WHERE promotions=:pro and status= true and count > 0 and finish_date >=CURRENT_DATE()");
            $control->bindParam(':pro', $promotion,PDO::PARAM_STR);
            $control->execute();
            if ($control->rowCount() == 1) {
                $id = $_SESSION['id'];
                $inorderhavepromotion = $db->prepare("SELECT * FROM orders WHERE user_id=:id and promotions=:pro");
                $inorderhavepromotion->bindParam(':id', $id);
                $inorderhavepromotion->bindParam(':pro', $promotion,PDO::PARAM_STR);
                $inorderhavepromotion->execute();
                if ($inorderhavepromotion->rowCount() >= 1) {
                    errorAlert("Bu kampanya kodunu önceden kullanmışsınız");
                } else {
                    successAlert("Başarılı","Kampanya kodunuz otumunuzda aktif edildi",'shopcard.php');
                    $_SESSION["promotion"] = $promotion;
                }
            } else {
                errorAlert("Kampanya kodu geçersiz");
            }
        }
    } else {
        route("../index.php");
    }
} catch (PDOException $e) {
    errorAlert($e->getMessage());
}
