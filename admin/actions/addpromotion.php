<?php
include "../../inc/db.php";
include "../../inc/function.php";
try {
    if (isset($_POST['insert'])) {
        $currentDate = date("Y-m-d");
        $count = $_POST['limit'];
        $endDate = $_POST['endDate'];
        $error = null;
    
        if ($endDate == "0") {
            $error = "Tarih boş bırakılamaz";
            errorAlert($error);
        } else if (!empty($count)) {

            if (!preg_match('/^[0-9]+$/', $count)) {
                $error = "Lütfen limide tam sayı giriniz";
                errorAlert($error);
            } else if ($currentDate > $endDate) {
                $error = "Geçmiş tarihi yapamazsınız";
                errorAlert($error);
            }
            if ($error == null) {

                $control = $db->prepare('SELECT promotions FROM promotions');
                $control->execute();
                $promotions = $control->fetchAll(PDO::FETCH_COLUMN);
                $createdpromotion = promotionCode(); 
                while (in_array($createdpromotion, $promotions)) {
                    $createdpromotion = promotionCode();
                }
                $status = true;
                $query = $db->prepare('INSERT INTO promotions (promotions,create_date,finish_date, count, status) VALUES (:promotions,:created,:finish,:count,:status)');

                $query->bindParam(':promotions', $createdpromotion);
                $query->bindParam(':created', $currentDate);
                $query->bindParam(':finish', $endDate);
                $query->bindParam(':count', $count);
                $query->bindParam(':status', $status,PDO::PARAM_BOOL);

                $query->execute();

                successAlert("Kampanya kodu hazır","Kampanya kodunuz oluşturulmuştur","promotions.php");
                
            }
        } else {
            $error = "Boş bırakılmış alanlar var";
            errorAlert($error);
        }
    }
} catch (PDOException $e) {
    $error = $e->getMessage();
    errorAlert($e);
}

function promotionCode()
{
    $promotionCode = '';

    while (strlen($promotionCode) <= 10) {
        $promotionCode .= rand(0, 9);
        $promotionCode .= rand(0, 9);
        for ($i = 0; $i < 3; $i++) {
            $promotionCode .= 'T';
        }
        if (strlen($promotionCode) >= 10) {
            $promotionCode = substr($promotionCode, 0, 10);
            break;
        }
    }

    return $promotionCode;
}
