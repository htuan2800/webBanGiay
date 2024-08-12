<div class="page-inner info-staff">
    <h3 class="page-title">Thông tin nhân viên</h3>

    <div class="staff-tools">
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

    <div class="table-staff">
        <?php
            require_once __DIR__ . "/../../admin/gui/tableStaff.php";
        ?>
    </div>

    <div class="pagination">
        <ul class="pagination">

            <li class="page-item">
                <a class="page-link previous disabled" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            <?php
                $sql = "SELECT * FROM users
                WHERE STATUS = 1
                AND IDROLE = 2";
                $users = $user->selectByCondition($sql);
                $count = $users->num_rows;
                $page = ceil($count / $itemOfPage);
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
        </ul>
    </div>

</div>