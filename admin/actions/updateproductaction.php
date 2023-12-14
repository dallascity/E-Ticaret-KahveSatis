<?php
try {
    if (isset($_POST['update'])) {
        $product = $_POST['product'];
        $description = $_POST['description'];
        $weight = $_POST['weight'];
        $weightType = $_POST['weight_type'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $photo = null;
        $status = false;
        $photostatus = false;
        $error = null;
        $phototype = null;
        // var_dump($photo, $product, $description, $price, $weight, $weightType, $stock, $status, $photostatus);
        // exit;

        if (isset($_POST['phototype'])) $phototype = $_POST['phototype'];
        if (isset($_POST["status"])) $status = true;
   
   

        if ($product != null &&  $weight != null && $price != null &&  $stock != null) {

            $product = htmlspecialchars(removeExtraSpaces(mb_strtoupper($product)), ENT_QUOTES, 'UTF-8');
            $description = htmlspecialchars(removeExtraSpaces($description), ENT_QUOTES, 'UTF-8');
            $weight = htmlspecialchars(removeExtraSpaces($weight), ENT_QUOTES, 'UTF-8');
            $price = htmlspecialchars(removeExtraSpaces($price), ENT_QUOTES, 'UTF-8');
            $stock = htmlspecialchars(removeExtraSpaces($stock), ENT_QUOTES, 'UTF-8');
            $stock = preg_replace('/\s+/', '', $stock);
            $price = preg_replace('/\s+/', '', $price);
            $weight = preg_replace('/\s+/', '', $weight);

            if (!preg_match('/^[\p{L}\s]+$/u', $product)) {
                $error = "Ürün adı sadece harf içermelidir.";
                errorAlert($error);
            } else if (preg_match('/[<>\/&()=?\"\'*@\£½{}\\\]/', $description)) {
                $error = "Açıklamada yasaklı karakterler kullanılıyor yasaklı karakterler (<>\/&()=?\"\'*@\£½{}\\\).";
                errorAlert($error);
            } else if (!preg_match('/^[0-9]+(\.[0-9]+)?$/', $weight && $weight > 0) ) {
                $error = "Ağırlık değeri sadece pozitif sayı ve nokta içerebilir.";
                errorAlert($error);
            } else if (!preg_match('/^[0-9]+(\.[0-9]+)?$/', $price  && $price > 0)) {
                $error = "Fiyat sadece pozitif sayı ve nokta içerebilir.";
                errorAlert($error);
            } else if (!ctype_digit($stock) && $stock >= 0) {
                $error = "Stok değeri sadece pozitif sayı içermelidir.";
                errorAlert($error);    
            } 
            else if (!in_array($weightType, $birim)) {
                $error = "Geçersiz bir birim türü";
                errorAlert($error);
            }
            else {

                if ($phototype == 'url' || $phototype == 'URL') {
                    $photostatus = false;
                    $photo = $_POST['photoUrl'];
                    $photo = trim($photo);
                    $photo = htmlspecialchars($photo);
                    if ($photo == null || $photo == "") {
                        $error = "Resmin URL alanı boş bırakılamaz";
                        errorAlert($error);
                    }
                } else if ($phototype == 'dosya' && $_FILES["photoDoc"]['name'] != "" && $_FILES["photoDoc"]['name'] != null) {


                    if ($_FILES["photoDoc"]['error'] != 0) {
                        $error .= "Resim yüklenirken hata gerçekleşti";
                        errorAlert($error);
                    } else if (file_exists('../../assets/gallery/' . strtolower($_FILES['photoDoc']['name']))) {
                        $error .= "Aynı resim ismi mevcut";
                        errorAlert($error);
                    } else if ($_FILES['photoDoc']['size'] > (1024 * 1024 * 2)) {
                        $error .= "Resmin boyutu 2MB'dan büyük olamaz";
                        errorAlert($error);
                    } else if (!in_array($_FILES['photoDoc']['type'], array('image/png', 'image/jpeg', 'image/jpg'))) {
                        $error .= "Hata, resim türü png veya jpeg formatında olmalıdır.";
                        errorAlert($error);
                    } else {
                        copy($_FILES['photoDoc']['tmp_name'], '../../assets/gallery/' . mb_strtolower($_FILES['photoDoc']['name']));
                        $photo = mb_strtolower($_FILES['photoDoc']['name']);
                        $photostatus = true;
                    }
                } else if ($photo == "" || $photo == null) {
                    $error = "Resmin URL'si veya Dosya yüklenmedi";
                    errorAlert($error);
                } else {
                    $error = "Resim seçeneğini belirtilmedi";
                    errorAlert($error);
                }
            }
        } else {
            $error = "Boş bırakılmış alanlar var";
            errorAlert($error);
        }

        $control = $db->prepare("SELECT name FROM products WHERE name=:product");
        $control->bindParam(':product', $product);
        $control->execute();
        if ($control->rowCount() == 1) {
            $error = "Oluşturulmuş ayni isimde ürün zaten var";
            errorAlert($error);
        } else if ($error == null || $error == "") {
   
            $query = $db->prepare('INSERT INTO products (photo, name, description ,price, weight, weight_type, stock, status, photo_type) VALUES (:photo, :name, :description ,:price, :weight , :weight_type , :stock, :status, :photo_type)');

            $query->bindParam(':photo', $photo);
            $query->bindParam(':name', $product);
            $query->bindParam(':description', $description);
            $query->bindParam(':price', $price);
            $query->bindParam(':weight', $weight);
            $query->bindParam(':weight_type', $weightType);
            $query->bindParam(':stock', $stock);
            $query->bindParam(':status', $status);
            $query->bindParam(':photo_type', $photostatus);
            $query->execute();
      
  

            successAlert("Ürün Eklendi","","index.php");
        }
    }
} catch (PDOException $e) {
    $error = $e->getMessage();
    errorAlert($error);
}
