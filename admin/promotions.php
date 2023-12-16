<?php
$sayfa = "Kampanya";
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
            
                        <div class="card-header">
                        <!---- MODAL --->
                        <?php include "inc/promotionaddmodal.php"?>
                        <!---- MODAL --->
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <table id="myDataTable" class="table table-striped" role="grid" data-toggle="data-table">
                                    <thead>
                                        <tr class="ligth">
                                            <th>Kampanya Kodu</th>
                                            <th>Oluşturma Tarihi</th>
                                            <th>Bitiş Tarihi</th>
                                            <th>Limit</th>
                                            <th>Durum</th>
                                        </tr>
                                    </thead>
                                    <tbody id="">
                                        <?php
                                        try {
                                            $query = "SELECT * FROM promotions ORDER BY count";
                                            $result = $db->query($query);
                                            $fetch = $result->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($fetch as $row) {
                                        ?>
                                                <tr id="rank-<?= $row['promotions'] ?>">
                                                    <td><?= $row['promotions'] ?></td>
                                                    <td> <?= $row['create_date'] ?> </td>
                                                    <td> <?= $row['finish_date'] ?> </td>
                                                    <td> <?= $row['count'] ?> </td>
                                                    <td>
                                                    <label class="switch">
                                                        <input <?= $row['status'] == 1 ? 'checked' : '' ?> id='<?= $row['promotions'] ?>' name="ap" type="checkbox" id='' class="btn btn-succes" data-toggle="switchbutton" data-onlabel="Açık" data-offlabel="Kapalı">
                                                    </label>
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
                    table: 'promotions',
                    status: status,
                    column:'promotions'
                },
                success: function(result) {
                    console.log(result);
                },
                error: function() {
                    alert('Hata');
                }
            });
        });

        let insert = false;
            $('#insert').click(function() {
              
                insert = true
                var discount = $('#discount').val();
                var limit = $('#limit').val();
                var endDate = $('#endDate').val();
                if(endDate == ""){
                    endDate = "0";
                }
            
                $.ajax({
                    url: 'actions/addpromotion.php',
                    method: 'POST',
                    data: {
                        insert:insert,
                        limit: limit,
                        endDate: endDate
                    },
                    success: function(result) {
                        console.log(result);
                        $('body').append(result);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
    });
</script>


