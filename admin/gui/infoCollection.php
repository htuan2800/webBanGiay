<div class="page-inner info-collection">
    <h3 class="page-title">Thông tin danh mục</h3>

    <div class="product-tools">
        <div class="show">
            <span>Hiển thị </span>
            <select name="itemOfPage" id="itemOfPage" class="form-control">
                <option value="10">10</option>
                <option value="20">20</option>
              
            </select>
            <span>Danh mục </span>
        </div>

        <div class="search">
            <input type="text" placeholder="Tìm kiếm" class="form-control" />
        </div>
    </div>

    <div class="table-collection">
        <?php
            include_once __DIR__ . "/tableCollection.php";
        ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="info-collection" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="info-collectionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

        </div>
    </div>

</div>