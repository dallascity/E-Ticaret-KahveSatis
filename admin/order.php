<?php
$sayfa = "Siparişler";
include "inc/header.php";

?>
<div class="conatiner-fluid content-inner mt-5 py-0">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?= $sayfa ?></h4>
                        </div>
                    </div>

                    <form method="POST" action="index.php" id="data">
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <table id="myDataTable" class="table table-striped" role="grid" data-toggle="data-table">
                                    <thead>
                                        <tr class="ligth">
                                            <th>Sipariş_No</th>
                                            <th>Sipariş Tarihi</th>
                                            <th>Şehir</th>
                                            <th>Kampanya kodu</th>
                                            <th>Ürün adeti</th>
                                            <th>Kargo ücret</th>
                                            <th>İndirim tutarı</th>
                                            <th>Toplam Ücret</th>
                                            <th>Detay</th>

                                        </tr>
                                    </thead>
                                    <tbody id="">
                                        <?php
                                        try {
                                            $query = "SELECT * FROM orders INNER JOIN users on orders.user_id = users.id";
                                            $result = $db->query($query);
                                            $fetch = $result->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($fetch as $row) {
                                        ?>
                                                <tr id="rank-<?= $row['order_id'] ?>">
                                                    <td><?= $row['order_id'] ?></td>
                                                    <td><?= $row['create_date'] ?></td>
                                                    <td><?= $row['city'] ?></td>
                                                    <td><?php echo ($row['promotions'] == null) ? "-" : $row['promotions']; ?></td>
                                                    <td><?= $row['totalcount'] ?></td>
                                                    <td><?= $row['cargoprice'] ?></td>
                                                    <td><?= $row['decprice'] ?></td>
                                                    <td><?= $row['totalprice'] ?></td>
                                                    <td class="text-center">
                                             <a href="detail.php?id=<?=$row['order_id']?>&user_id=<?=$row['user_id']?>" class="btn btn-danger btn-sm"> Detay</a>
                                                       </td>
                                                    <td>


                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } catch (PDOException $e) {
                                            errorAlert($e->getMessage());
                                        }
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "inc/footer.php";
?>