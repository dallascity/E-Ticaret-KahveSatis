<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ins">
                               Kampanya Kodu Oluştur
                            </button>

                        </div>
                        <div class="modal fade" id="ins" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-flex align-items-center justify-content-center modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kampanya Kodu Oluşturucu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
    <form id="insertform" action="promotions.php" method="post">
        <div class="mb-3">
            <label for="discountSelect" class="form-label">İndirim Yüzdesi</label>
            <select class="form-select" id="discount" aria-label="Discount Select" name="discount" required>
                <option selected disabled>Seçiniz</option>
                <?php foreach($percent as $p){
                    echo "<option value='$p'>$p</option>";
                }    
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="limitInput" class="form-label">Limit</label>
            <input type="number" class="form-control" id="limit" name="limit" placeholder="Limit miktarı" required>
        </div>
        <div class="mb-3">
            <label for="endDateInput" class="form-label">Bitiş Tarihi</label>
            <input type="date" class="form-control" id="endDate" name="endDate" required>
        </div>
        <button type="button" id="insert" class="btn btn-primary">Oluştur</button>
    </form>
</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>