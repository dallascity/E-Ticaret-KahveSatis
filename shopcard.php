<?php
$sayfa = "sepet";
include "inc/header.php";

$query = "SELECT * FROM products";
$giftcheck = $db->query($query, PDO::FETCH_OBJ)->fetch();

$cargoprice = 54.99;
$discount = 0;
$sumtotalPrice = isset($_SESSION['shopcart']) ? $shopCart['summary']['total_price'] : 0;
if (isset($_SESSION['gift'])) $gift = $_SESSION['gift'];
$show = "";

$promotion = null;




if (isset($_SESSION['promotion']) && isset($_SESSION['shopcart'])) {
    $promotion = $_SESSION['promotion'];
    if ($totalPrice > 3000) {
        $discount = $totalPrice * 0.25;
        $sumtotalPrice = $totalPrice - $discount;
        $cargoprice = 0;
        $show = "(%25 indirim)";


        if (!isset($_SESSION['gift'])) {
            $query = "SELECT * FROM products WHERE stock > 0 ORDER BY RAND() LIMIT 1";
            $giftcheck = $db->query($query, PDO::FETCH_OBJ)->fetch();

            if ($giftcheck) {
                $_SESSION['gift'] = $giftcheck;
                $gift = $_SESSION['gift'];
                $gift->count = 1;
                $gift->weight_type = "Kilogram";
                $gift->weight = 1;
            }
        }
    } else if ($totalPrice > 2000) {
        $discount = $totalPrice * 0.20;
        $sumtotalPrice = $totalPrice - $discount;
        $cargoprice = 0;
        $show = "(%20 indirim)";
    } else if ($totalPrice > 1500) {
        $discount = $totalPrice * 0.15;
        $sumtotalPrice = $totalPrice - $discount;
        $cargoprice = 0;
        $show = "(%15 indirim)";
    } else if ($totalPrice > 1000) {
        $discount = $totalPrice * 0.10;
        $sumtotalPrice = $totalPrice - $discount;
        $cargoprice = 0;
        $show = "(%10 indirim)";
    } else {
        $discount = 0;
        $sumtotalPrice = $shopCart['summary']['total_price'];
    }
}
if ($sumtotalPrice == 0 || $sumtotalPrice > 500) {
    $cargoprice = 0;
} else {
    $sumtotalPrice = $sumtotalPrice + $cargoprice;
}




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
        <?php if ($totalCount > 0) { ?>
            <h2 class="text-center">Sepetinizde <strong class="color-danger"><?= $totalCount ?></strong> adet ürün bulunmaktadır </h2>
        <?php } else { ?>
            <div class="alert alert-info"><strong>Sepetinizde henüz bir ürün bulunmamaktadıdır.Eklemek için <a href="index.php">Tıklayınız </a></strong></div>
        <?php } ?>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <th class="text-center">Ürün resmi</th>
                    <th class="text-center">Ürün adı</th>
                    <th class="text-center">Güncel Stok</th>
                    <th class="text-center">Paket</th>
                    <th class="text-center">Fiyatı</th>
                    <th class="text-center">Adeti</th>
                    <th class="text-center">Toplam</th>
                    <th class="text-center">Sepetten Çıkar</th>
                </thead>

                <tbody>

                    <?php
                    try {
                        if (isset($products)) :
                            foreach ($products as $row) {
                                $live = $db->prepare("SELECT stock FROM products WHERE product_id = :pid");
                                $live->bindParam(':pid', $row->product_id);
                                $live->execute();
                                $livestock = $live->fetch(PDO::FETCH_ASSOC)

                    ?>
                                <tr>
                                    <td class="text-center"><img src="<?= $row->photo_type == true ? 'assets/gallery/' . $row->photo : $row->photo ?>" alt="Photo" width="70"></td>
                                    <td class="text-center"><?= $row->name ?></td>
                                    <td class="text-center"><?= $livestock['stock'] ?></td>
                                    <td class="text-center"><?= $row->weight . " " . $row->weight_type ?></td>
                                    <td class="text-center"><?= $row->price ?></td>
                                    <td class="text-center">
                                        <button class='incCount btn btn-sm btn-success' id="<?= $row->product_id ?>" class="btn btn-sm btn-success"><span class="fa fa-plus"></span></button>
                                        <input type="text" class="itemcount" value="<?= $row->count ?>" readonly>
                                        <button class='decCount btn btn-sm btn-danger' id="<?= $row->product_id ?>" class="btn btn-sm btn-danger"><span class="fa fa-minus"></span></button>
                                    </td>
                                    <td class="text-center"><?= $row->total_price ?></td>
                                    <td class="text-center">
                                        <span id='<?= $row->product_id ?>' class="btn btn-danger btn-sm removeCartBtn">Sepetten Çıkar</span>
                                    </td>
                                </tr>
                    <?php

                            }
                        endif;
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    } ?>

                </tbody>
                <tfoot>
                    <?php if (isset($gift)) : ?>
                        <tr>
                            <td class="text-center"><img src="<?= $gift->photo_type == true ? 'assets/gallery/' . $gift->photo : $gift->photo ?>" alt="Photo" width="70"></td>
                            <td class="text-center"><?= $gift->name ?></td>
                            <td class="text-center"><?= $livestock['stock'] ?></td>
                            <td class="text-center"><?= $gift->weight . " " . $gift->weight_type ?></td>
                            <td class="text-center"> - </td>
                            <td class="text-center">

                                <input type="text" class="itemcount" value="<?= $gift->count ?>" readonly>

                            </td>
                            <td class="text-center">0 TL</td>
                            <td class="text-center">
                                <span class="btn btn-success btn-sm">Hediye</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <th> Kampanya Kodu:
                            <input type="text" name="promocode" id="promoCode" maxlength="10" placeholder="Zorunlu değil">
                            <button class="btn btn-success promotionBtn  ">Aktif Et</button>
                        </th>

                        <th colspan="3">
                            <?php if (isset($_SESSION['promotion'])) : ?>
                                1000 TL üzeri %10
                                <br>
                                1500 TL üzeri %15
                                <br>
                                2000 TL üzeri %20
                                <br>
                                2500 TL üzeri %25
                                <br>
                                Kampanya kodu aktif
                            <?php endif; ?>
                        </th>
                        <th colspan="2" class="text-end">Toplam Ürün <span class="color-danger"> <?= $totalCount ?></span></th>
                        <th colspan="1">

                            Ürün Toplam Fiyat:
                            <span class="color-danger"><?= $totalPrice ?></span>
                            <br>
                            Kargo Fiyatı:
                            <span class="color-danger"><?= $cargoprice ?></span>
                            <br>
                            <?php echo (isset($_SESSION['promotion'])) ? "(Kampanya Aktif)" : "(Kampanya kodunuz yok)"; ?>
                            İndirim Tutarı <?= $show ?>:
                            <span class="color-danger"><?= $discount ?></span>
                            <br>
                            Toplam:
                            <span class="color-danger" id='sumtotal'><?= $sumtotalPrice ?></span>
                        </th>
                        </th>
                        <form method="POST">
                            <th colspan="2" class="text-end"><button type='submit' name="order" class="btn btn-success">Sepeti Onayla</button></th>
                        </form>
                    </tr>

                </tfoot>



            </table>
        </div>
    </div>
</body>
<?php
include "inc/footer.php";
include "actions/buyorder.php";
?>

<script>
    $(document).ready(function() {
        function handleAction(processType, productId) {
            var url = "actions/shopcartaction.php";
            var data = {
                process: processType,
                product_id: productId,
            };

            $.post(url, data, function(response) {

                window.location.reload();
            });
        }

        $(".removeCartBtn").click(function() {
            var productId = $(this).attr("id");
            handleAction("removeCart", productId);
        });

        $(".incCount").click(function() {
            var productId = $(this).attr("id");
            handleAction("incCount", productId);
        });

        $(".decCount").click(function() {
            var productId = $(this).attr("id");
            handleAction("decCount", productId);
        });

        $('.promotionBtn').click(function() {

            var process = true
            var promotion = $('#promoCode').val();

            $.ajax({
                url: 'actions/promotionaction.php',
                method: 'POST',
                data: {
                    process: process,
                    promotion: promotion
                },
                success: function(result) {
                    $('body').append(result);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });



    })
</script>