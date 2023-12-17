<?php
try {
    if (isset($_POST['order'])) {
        if (!empty($products)) {

            if (isset($_SESSION['promotion'])){
                $query = $db->prepare('UPDATE promotions SET count = count - 1 WHERE count > 0 AND promotions = :promotions');
                $query->bindParam(':promotions', $promotion);
                $query->execute();
                unset($_SESSION['promotion']);
            }

            $userid = $_SESSION['id'];
            foreach ($products as $row) { 
                $product_id = $row->product_id; 
                $name = $row->name;
                $count = $row->count;   
                $control = $db->prepare("SELECT stock FROM products WHERE product_id = :pid");
                $control->bindParam(':pid', $product_id);
                $control->execute();
            
                $result = $control->fetch(PDO::FETCH_ASSOC);
            
                if ($result && $result['stock'] < $count) {
                    $error = "Ürün: {$name} için stok yetersiz!";
                }
            }
            if(isset($error)){
                echo '<script>';
                echo 'Swal.fire({';
                echo '  icon: "error",';
                echo '  title: "Hata!",';
                echo '  text: "' . $error . '",';
                echo '}).then(function() {';
                echo '  window.location.href = "shopcard.php";';
                echo '});';
                echo '</script>';
            }
            else{
            $query = $db->prepare('INSERT INTO orders (user_id, promotions,price,cargoprice, decprice , totalprice,totalcount,create_date) VALUES (:uid, :promotions,:price ,:decprice ,:cargo, :total,:totalcount,CURRENT_DATE())');
            $query->bindParam(':uid', $userid);
            $query->bindParam(':promotions', $promotion);
            $query->bindParam(':price', $totalPrice);
            $query->bindParam(':cargo', $cargoprice);
            $query->bindParam(':decprice', $discount);
            $query->bindParam(':total', $sumtotalPrice);
            $query->bindParam(':totalcount', $totalCount);
            $query->execute();
            $insertid = $db->lastInsertId();
            foreach ($products as $row) {
                $product_id = $row->product_id;
                $count = $row->count;
                $productPrice = $row->price;
                $productTotalPrice = $row->total_price;
                $query = $db->prepare('INSERT INTO orderdetail (order_id, user_id, products_id, count, price, totalprice) VALUES (:oid, :uid, :pid, :count, :price, :total)');
                $query->bindParam(':oid', $insertid);
                $query->bindParam(':uid', $userid);
                $query->bindParam(':pid', $product_id);
                $query->bindParam(':count', $count);
                $query->bindParam(':price', $productPrice);
                $query->bindParam(':total', $productTotalPrice);
                $query->execute();

                $query = $db->prepare('UPDATE products SET stock = stock - :count WHERE stock > 0 AND product_id = :pid');
                $query->bindParam(':count', $count);
                $query->bindParam(':pid', $product_id);
                $query->execute();

            }
            unset($products);
            unset($_SESSION['shopcart']);
            successAlert('Siparişiniz tamamlandı','Siparişinizin durumunu siparislerim adlı kısımdan bakabilirsiniz','index.php');
             }
    
        } else {
            errorAlert("Sepette ürün yok");
        }
    }
} catch (PDOException $e) {
    errorAlert($e->getMessage());
}
