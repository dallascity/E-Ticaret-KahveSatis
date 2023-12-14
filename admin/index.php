<?php
$sayfa = "Ürünler";
include "inc/header.php";

?>
<style>
.aciklama {
    max-width: 200px; 
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; 
}
</style>
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
                        <div class="card-header">
                            <a href="addproduct.php" class="btn btn-primary ">
                                Ürün Ekle
                            </a>
                        </div>
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <table id="myDataTable" class="table table-striped" role="grid" data-toggle="data-table">
                                    <thead>
                                        <tr class="ligth">
                                            <th>Ürün_id</th>
                                            <th>Görsel</th>
                                            <th>Ürün</th>
                                            <th>Açıklama</th>
                                            <th>Fiyat</th>
                                            <th>Birim</th>
                                            <th>Stok</th>
                                            <th>Durum</th>
                                            <th style="min-width: 100px">Seçenekler</th>
                                        </tr>
                                    </thead>
                                    <tbody id="">
                                        <?php
                                        try {
                                            $query = "SELECT * FROM products ORDER BY product_id";
                                            $result = $db->query($query);
                                            $fetch = $result->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($fetch as $row) {
                                        ?>
                                                <tr id="rank-<?= $row['product_id'] ?>">
                                                    <td><?= $row['product_id'] ?></td>
                                                    <td class="text-center">
                                                        <img class="bg-soft-primary rounded img-fluid me-3 custom-image" src="<?= $row['photo_type'] == 1 ? '../assets/gallery/' . $row['photo'] : $row['photo'] ?>" alt="productphoto">
                                                    </td>

                                                    <td> <?= $row['name'] ?> </td>
                                                    <td class="aciklama"> <?= $row['description'] ?> </td>
                                                    <td> <?= $row['price'] . "TL" ?> </td>
                                                    <td> <?= $row['weight'] . " " . $row['weight_type'] ?> </td>
                                                    <td> <?= $row['stock'] ?> </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input <?= $row['status'] == 1 ? 'checked' : '' ?> id='<?= $row['product_id'] ?>' name="ap" type="checkbox" id='' class="btn btn-succes" data-toggle="switchbutton" data-onlabel="Açık" data-offlabel="Kapalı">
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="flex align-items-center list-user-action">
                                                            <a href="" class="btn btn-sm btn-icon btn-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add" href="#">
                                                                <span class="btn-inner">
                                                                    <i class="fa fa-edit text-center"></i>
                                                                </span>
                                                            </a>

                                                            <a onclick="" class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#">
                                                                <span class="btn-inner">
                                                                    <i class="fa fa-trash text-center"></i>
                                                                </span>
                                                            </a>
                                                        </div>
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


</div>


<?php
include "inc/footer.php";


?>






<script>
    $(document).ready(function() {
        const elements = document.getElementsByName('ap');
        $(elements).change(function(event) {

            var id = $(this).attr("id");
            var status = ($(this).is(':checked')) ? 'true' : 'false';
            $.ajax({
                url: 'actions/ap.php',
                method: 'POST',
                data: {
                    id: id,
                    table: 'products',
                    status: status
                },
                success: function(result) {
                    console.log(result);
                },
                error: function() {
                    alert('Hata');
                }
            });
        });



    });


    function confirmAndDelete(id, table, sira, url, kat) {
        const silinecekSatir = $("#rank-" + id);
        const siranumarasi = sira;
        const silinecektablo = $(this).parents('tr');
        Swal.fire({
            title: 'Silmek istediğine emin misin?',
            text: "Menünün içindeki ürünler silinecektir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'İptal',
            confirmButtonText: 'Evet, Sil!'
        }).then((result) => {
            if (result.isConfirmed) {

                var data = {
                    id: id,
                    table: table,
                    sira: sira,
                    url: url,
                    kat: kat

                };


                $.ajax({
                    url: 'actions/deleteproduct.php',
                    method: 'POST',
                    data: data,
                    success: function(response) {


                        updateSiraNumbers(sira);
                        silinecekSatir.remove(); // Veya: silinecekSatir.detach();


                        Swal.fire(
                            'Silindi!',
                            'Menü kaldırıldı.',
                            'success'
                        );

                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        console.log(status);
                        console.log(xhr);

                        Swal.fire(
                            'Hata!',
                            'Bir hata ile karşılaşıldı sayfayı yenileyip tekrar deneyin.',
                            'error'
                        );
                    }
                });
            }
        });
    }

    function updateSiraNumbers(sira) {
        $("#myDataTable tr").each(function() {
            var rowSira = parseInt($(this).find('td:first').text().trim(), 10);
            if (rowSira > sira) {
                $(this).find('td:first').text(rowSira - 1);
            }
        });
    }
</script>