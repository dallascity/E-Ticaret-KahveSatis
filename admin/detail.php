<?php
$sayfa = "Siparişler";
include "inc/header.php";
$id = intval($_GET['id']);
$uid = intval($_GET['user_id']);
$totaldetailprice = [];
$totaldetailcount = [];
$detailpromotion = null;
$cargoprice = null;

?>
    <div class="container">

<div class="row justify-content-center">
    <div class="col-md-12">
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <th class="text-center">Ürün resmi</th>
                <th class="text-center">Ürün ismi</th>
                <th class="text-center">Paket tipi</th>
                <th class="text-center">Ürün Adeti</th>
                <th class="text-center">Ürün fiyatı</th>
                <th class="text-center">Ürün Toplam Fiyatı</th>
            </thead>

            <tbody>

                <?php
                try {

                    $query = $db->prepare(
                        "SELECT photo,photo_type,name,d.count,d.price,d.totalprice,o.promotions,d.weight,weight_type,o.cargoprice FROM orderdetail as d
                INNER JOIN orders as o INNER JOIN products as p 
                ON d.order_id = o.order_id and d.products_id = p.product_id 
                WHERE d.order_id = :oid"
                    );
                    $query->bindParam(':oid', $id);
                    $query->execute();
                    $order = $query->fetchAll();
                    foreach ($order as $row) {
                        $detailpromotion = $row['promotions'];
                        $totaldetailprice[] = $row['totalprice'];
                        $totaldetailcount[] = $row['count'];
                        $cargoprice = $row['cargoprice'];
                ?>
                        <tr>
                            <td class="text-center"><img src="<?= $row['photo_type'] == true ? '../assets/gallery/' . $row['photo'] : $row['photo'] ?>" alt="Photo" width="70"></td>
                            <td class="text-center"><?= $row['name'] ?></td>
                            <td class="text-center"><?= ($row['weight'] == 1) ? $row['weight'] . 'Kilogram' : $row['weight'] . $row['weight_type']  ?></td>
                            <td class="text-center"><?= $row['count'] ?></td>
                            <td class="text-center"><?= ($row['price'] == 0) ? "-" : $row['price'] . "TL" ?></td>
                            <td class="text-center"><?= ($row['totalprice'] == 0) ? "Aktif Kampanya 3000 TL üzeri alışveriş hediyesi" : $row['totalprice'] . "TL" ?></td>
                        </tr>
                <?php

                    }
                    $discount = 0;
                    $totaldetailprice = array_sum($totaldetailprice);
                    $totaldetailcount = array_sum($totaldetailcount);
                    if ($detailpromotion != null) {
                        if ($totaldetailprice > 3000) {
                            $discount = $totaldetailprice * 0.25;
                            $decdetail = $totaldetailprice - $discount;
                            $cargoprice = 0;
                            $show = "(Kupon %25 indirim)";
                        } else if ($totaldetailprice > 2000) {
                            $discount = $totaldetailprice * 0.20;
                            $decdetail = $totaldetailprice - $discount;
                            $cargoprice = 0;
                            $show = "(Kupon %20 indirim)";
                        } else if ($totaldetailprice > 1500) {
                            $discount = $totaldetailprice * 0.15;
                            $decdetail = $totaldetailprice - $discount;
                            $cargoprice = 0;
                            $show = "(Kupon %15 indirim)";
                        } else if ($totaldetailprice > 1000) {
                            $discount = $totaldetailprice * 0.10;
                            $decdetail = $totaldetailprice - $discount;
                            $cargoprice = 0;
                            $show = "(Kupon %10 indirim)";
                        } 
                    }
                    else{
                        $decdetail = $totaldetailprice;
                        $show = "(Kupon yok)";
                    }
                    $query = $db->prepare("SELECT * FROM orders INNER JOIN users on orders.user_id = users.id WHERE user_id = :uid");
                    $query->bindParam(':uid', $uid);
                    $query->execute();
                    $order = $query->fetch(PDO::FETCH_ASSOC);
         
               
                } catch (Exception $e) {
                    echo $e->getMessage();
                } ?>

            </tbody>
            <tfoot>
                <tr>
                <th colspan="1" class="text-end"> Kampanya Kodu <span> <?php echo ($detailpromotion == null)? "-" : $detailpromotion;  ?></span></th>
                <th colspan="2" class="">
                İsim:
                        <?= $order['name'] ?>
                        <br>
                        soyisim:
                      <?= $order['surname'] ?>
                        <br>
                        şehir:
                      <?= $order['city'] ?>
                        adres:
                      <?= $order['adress'] ?>
                        <br>
                        mail:
                      <?= $order['mail'] ?>
                        <br>
                        telefon:
                      <?= $order['phone'] ?>
                        <br>
              
                <th colspan="1" class="text-end">Toplam Ürün <span> <?= $totaldetailcount ?></span></th>
                    <th colspan="1">
                    <th colspan="1">

                        Ürün Toplam Fiyat:
                        <span><?= $totaldetailprice ?></span>
                        <br>
                        Kargo Fiyatı:
                        <span><?= $cargoprice ?></span>
                        <br>
                        İndirim Tutarı <?= $show ?>:
                        <span><?= $discount ?></span>
                        <br>
                        Toplam:
                        <span id='sumtotal'><?= $decdetail+$cargoprice ?></span>
                    </th>
                    <th colspan="1"> <a class="btn btn-primary" href="order.php"> Geri dön</a> </th>
                </tr>

            </tfoot>




        </table>
    </div>
</div>
<?php
include "inc/footer.php";
?>