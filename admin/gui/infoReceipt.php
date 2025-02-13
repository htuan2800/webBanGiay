<div class="page-inner info-receipt">
    <h3 class="page-title">Thông tin phiếu nhập</h3>

    <div class="product-tools">
        <div class="show">
            <span>Hiển thị </span>
            <select name="itemOfPage" id="itemOfPage" class="form-control">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span>phiếu nhập</span>
        </div>

        <!-- <div class="search">
            <input type="text" placeholder="Tìm kiếm" class="form-control" />
        </div> -->
    </div>

    <div class="table-product">
        <?php
        include_once __DIR__ . "/tableReceipt.php";
        ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalReceipt" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered ">

        </div>
    </div>

</div>