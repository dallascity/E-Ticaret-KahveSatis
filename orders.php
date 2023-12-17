<?php
$sayfa = "sepet";
include "inc/header.php";

?>
<style>
    .color-danger {
        color: red
    }

    .itemcount {
        width: 50px;
        text-align: center;
    }

    td {
        vertical-align: middle;
    }
</style>

<body>

    <div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <th class="text-center">Sipariş numarası</th>
                    <th class="text-center">Sipariş Tarihi</th>
                    <th class="text-center">Teslim Adresi</th>
                    <th class="text-center">Kampanya kodu</th>
                    <th class="text-center">Ürün Adeti</th>
                    <th class="text-center">Ürünlerin fiyatı</th>
                    <th class="text-center">Kargo Ücreti</th>
                    <th class="text-center">İndirim tutarı</th>
                    <th class="text-center">Toplam</th>
                    <th class="text-center">Durum</th>
                    <th class="text-center">Detaylar</th>
                </thead>

                <tbody>
                 
                    <?php
                    try {
                        
                        $query = $db->prepare("SELECT * FROM orders INNER JOIN users on orders.user_id = users.id WHERE user_id = :uid");
                        $query->bindParam(':uid', $_SESSION['id']);
                        $query->execute();
                        $order = $query->fetchAll();
                                foreach ($order as $row){
                                ?>
                                <tr>
                                    <td class="text-center"><?= $row['order_id'] ?></td>
                                    <td class="text-center"><?= $row['create_date'] ?></td>
                                    <td class="text-center"><?= $row['adress'] ?></td>
                                    <td class="text-center"><?php echo ($row['promotions'] == null) ? "-" : $row['promotions']; ?></td>
                                    <td class="text-center"><?= $row['totalcount'] ?></td>
                                    <td class="text-center"><?= $row['price'] ?></td>
                                    <td class="text-center"><?= $row['cargoprice'] ?></td>
                                    <td class="text-center"><?= $row['decprice'] ?></td>
                                    <td class="text-center"><?= $row['totalprice'] ?></td>
                                    <td class="text-center"><?php echo ($row['status'] == 1) ? "Onaylandı" : "Teslim Edildi"; ?></td>
                                    <td class="text-center">
                                        <a href="detail.php?id=<?=$row['order_id']?>" class="btn btn-danger btn-sm">Sipariş Detay</a>
                                    </td>
                                </tr>
                    <?php

                        }
                    }catch (Exception $e) {
                        echo $e->getMessage();
                    } ?>

                </tbody>



            </table>
        </div>
    </div>
</body>


<script>
  
</script>