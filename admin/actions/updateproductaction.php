<?php
try {
    if (isset($_POST['update'])) {
        $product = $_POST['product'];
        $description = $_POST['description'];
        $weight = $_POST['weight'];
        $weightType = $_POST['weight_type'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $status = $fetch['status'];
        $photo = $fetch['photo'];
        $photostatus = $fetch['photo_type'];
        
        $error = null;
        
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
                if (($phototype == 'url' || $phototype == 'URL') && ($_POST['photoUrl'] != "") ) {
                    if ($photostatus == true) unlink('../assets/gallery/' . $fetch['photo']);
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
                    } else if (file_exists('../assets/gallery/' . strtolower($_FILES['photoDoc']['name']))) {
                        $error .= "Aynı resim ismi mevcut";
                        errorAlert($error);
                    } else if ($_FILES['photoDoc']['size'] > (1024 * 1024 * 2)) {
                        $error .= "Resmin boyutu 2MB'dan büyük olamaz";
                        errorAlert($error);
                    } else if (!in_array($_FILES['photoDoc']['type'], array('image/png', 'image/jpeg', 'image/jpg'))) {
                        $error .= "Hata, resim türü png veya jpeg formatında olmalıdır.";
                        errorAlert($error);
                    } else {
                    
                        if ($photostatus == 1 && $_FILES['photoDoc']['name'] != "") {
                            unlink('../assets/gallery' . $fetch['resim']);
                        }
                        copy($_FILES['photoDoc']['tmp_name'], '../assets/gallery/' . mb_strtolower($_FILES['photoDoc']['name']));
                        $photo = mb_strtolower($_FILES['photoDoc']['name']);
                        $photostatus = true;
                 
                    }
                } else if ($photo == "" || $photo == null) {
                    $error = "Resmin URL'si veya Dosya yüklenmedi";
                    errorAlert($error);
                } 
            }
        } else {
            $error = "Boş bırakılmış alanlar var";
            errorAlert($error);
        }
       
       
        $control = $db->prepare("SELECT product_id FROM products WHERE name=:product");
        $control->bindParam(':product', $product);
        $control->execute();
        $cnt = $control->fetch();
        if ($cnt['product_id'] != null) {
            if ($cnt['product_id'] != $id) {
                $error = "Oluşturulmuş bir menü ismini tekrar oluşturamazsın";
                errorAlert($error);
           
             }
        }  
        if ($error == null || $error == "") {
            var_dump($photo, $product, $description, $price, $weight, $weightType, $stock, $status, $photostatus,$phototype);
            $query = $db->prepare('UPDATE products 
            SET photo = :photo, 
                name = :name, 
                description = :description,
                price = :price,
                weight = :weight,
                weight_type = :weight_type,
                stock = :stock,
                status = :status,
                photo_type = :photo_type 
            WHERE product_id = :product_id');

            $query->bindParam(':photo', $photo);
            $query->bindParam(':name', $product);
            $query->bindParam(':description', $description);
            $query->bindParam(':price', $price);
            $query->bindParam(':weight', $weight);
            $query->bindParam(':weight_type', $weightType);
            $query->bindParam(':stock', $stock);
            $query->bindParam(':status', $status,PDO::PARAM_BOOL);
            $query->bindParam(':photo_type', $photostatus,PDO::PARAM_BOOL);
            $query->bindParam(':product_id', $id);
            $query->execute();
      
            successAlert("Ürün Başarıyla Güncellendi","İşlem başarılı yönlendiriliyorsunuz","index.php");
        }
    }
} catch (PDOException $e) {
    $error = $e->getMessage();
    errorAlert($error);
}
