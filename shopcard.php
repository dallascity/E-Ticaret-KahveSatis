<?php
$sayfa = "sepet";
include "inc/header.php";
$cargoprice = 54.99;
$discount = 0;
$sumtotalPrice = isset($_SESSION['shopcart']) ? $shopCart['summary']['total_price'] : 0;


if (isset($_SESSION['promotion']) && isset($_SESSION['shopcart'])) {
    $promotion = $_SESSION['promotion'];
    if ($totalPrice > 3000) {
        $discount = $totalPrice * 0.25;
        $sumtotalPrice = $totalPrice - $discount;
        $cargoprice = 0;
    } else if ($totalPrice > 2000) {
        $discount = $totalPrice * 0.20;
        $sumtotalPrice = $totalPrice - $discount;
        $cargoprice = 0;
    } else if ($totalPrice > 1500) {
        $discount = $totalPrice * 0.15;
        $sumtotalPrice = $totalPrice - $discount;
        $cargoprice = 0;
    } else if ($totalPrice > 1000) {
        $discount = $totalPrice * 0.10;
        $sumtotalPrice = $totalPrice - $discount;
        $cargoprice = 0;
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
                    <th class="text-center">Paket</th>
                    <th class="text-center">Fiyatı</th>
                    <th class="text-center">Adeti</th>
                    <th class="text-center">Toplam</th>
                    <th class="text-center">Sepetten Çıkar</th>
                </thead>

                <tbody>
                    <form method="POST">
                    <?php
                    try {
                        if (isset($products)) :
                            foreach ($products as $row) { ?>
                                <tr>
                                    <td class="text-center"><img src="<?= $row->photo_type == true ? 'assets/gallery/' . $row->photo : $row->photo ?>" alt="Photo" width="70"></td>
                                    <td class="text-center"><?= $row->name ?></td>
                                    <td class="text-center"><?= $row->weight . " " . $row->weight_type ?></td>
                                    <td class="text-center"><?= $row->price ?></td>
                                    <td class="text-center">
                                        <button class='incCount btn btn-sm btn-success' id="<?= $row->product_id ?>" class="btn btn-sm btn-success"><span class="fa fa-plus"></span></button>
                                        <input type="text" class="itemcount" value="<?= $row->count ?>" readonly>
                                        <button class='decCount btn btn-sm btn-danger' id="<?= $row->product_id ?>" class="btn btn-sm btn-danger"><span class="fa fa-minus"></span></button>
                                    </td>
                                    <td class="text-center"><?= $row->total_price ?></td>
                                    <td class="text-center">
                                        <button id='<?= $row->product_id ?>' class="btn btn-danger btn-sm removeCartBtn">Sepetten Çıkar</button>
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
                    <tr>
                        <th> Promosyon Kodu:
                            <input type="text" name="promocode" id="promoCode" maxlength="10" placeholder="Zorunlu değil">
                            <button class="btn btn-success promotionBtn  ">Aktif Et</button>
                        </th>
                        <th colspan="4" class="text-end">Toplam Ürün <span class="color-danger"> <?= $totalCount ?></span></th>
                        <th colspan="1">
                        <th colspan="1">

                            Ürün Toplam Fiyat:
                            <span class="color-danger"><?= $totalPrice ?></span>
                            <br>
                            Kargo Fiyatı:
                            <span class="color-danger"><?= $cargoprice ?></span>
                            <br>
                            İndirim Tutarı:
                            <span class="color-danger"><?= $discount ?></span>
                            <br>
                            Toplam:
                            <span class="color-danger" id='sumtotal'><?= $sumtotalPrice ?></span>
                        </th>
                        </th>
                        <th colspan="2" class="text-end"><button type='submit' class="btn btn-success">Sepeti Onayla</button></th>
                    </tr>
                    </form>
                </tfoot>



            </table>
        </div>
    </div>
</body>
<?php
include "inc/footer.php";
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