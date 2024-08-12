<div class="page-inner info-order-delivery">
    <h3 class="page-title">Đơn hàng cần giao</h3>

    <div class="order-delivery-tools">
        <div class="show">
            <span>Hiển thị </span>
            <select name="itemOfPage" id="itemOfPage" class="form-control">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span>dòng</span>
        </div>

        <div class="search">
            <input type="text" placeholder="Tìm kiếm" class="form-control" />
        </div>
    </div>

    <div class="table-order-delivery">
        <?php
            require_once __DIR__ . "/../../admin/gui/tableOrderdelivery.php";
        ?>
    </div>

    <div class="pagination">
        <ul class="pagination">

            <?php
                $sql = "SELECT * FROM bills
                WHERE STATUSBILL = 2 OR STATUSBILL = 3";
                $bills = $bill->selectByCondition($sql);
                $count = $bills->num_rows;
                $page = ceil($count / $itemOfPage);
            ?>

            <?php
                if ($page > 0) {
            ?>

            <li class="page-item">
                <a class="page-link previous disabled" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            <?php
                
                for ($i = 1; $i <= $page; $i++) {
                    if ($i == 1) {
            ?>

            <li class="page-item active"><a class="page-link" href="#"><?= $i ?></a></li>

            <?php
                }
                else {
            ?>

            <li class="page-item"><a class="page-link" href="#"><?= $i ?></a></li>

            <?php
                }
            }
            ?>

            <?php
                if ($page == 1) {
            ?>

            <li class="page-item">
                <a class="page-link next disabled" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>

            <?php
                }
                else {
            ?>

            <li class="page-item">
                <a class="page-link next" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>

            <?php
                }
            ?>

            <?php
                }
            ?>
        </ul>
    </div>

</div>
<!-- Modal -->
<div class="modal fade" id="show-bill" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">

    </div>
</div>