<?php
require_once __DIR__ . "\\..\\..\\database\\database.php";
require_once __DIR__ . "\\..\\..\\database\\user.php";
require_once __DIR__ . "\\..\\..\\database\\role.php";

$db = new database();
$user = new user($db);
$role = new role($db);

$result = $user->getAllCustomer();

if (isset($_POST['block-customer'])) {
    $idCustomer = $_POST['id'];
    $user->blockUser($idCustomer);
}
if (isset($_POST['unblock-customer'])) {
    $idCustomer = $_POST['id'];
    $user->unblockUser($idCustomer);
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$task = $role->selectTaskById($_SESSION['account_login']['idRole'], 1);


?>

<div class="page-inner info-customer">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thông tin khách hàng</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Số điện thoại</th>
                                    <!-- <th>Email</th> -->
                                    <th>Avatar</th>
                                    <?php
                                    $check = false;
                                    foreach ($task as $key => $value) {
                                        if ($value['idTask'] == 3) {
                                            $check = true;
                                            ?>
                                            <th>Tình trạng</th>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['fullName']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['phoneNumber'] ?? "Không có"; ?>
                                        </td>
                                        <!-- <td>
                                        <?php echo $row['email'] ?? "Không có"; ?>
                                    </td> -->
                                        <td>
                                            <?php
                                            if (strncmp($row['avatar'], "https", 5) == 0) {
                                                $avatar = $row['avatar'];
                                            } else {
                                                $avatar = "./." . $row['avatar'] . "?" . time();
                                            }
                                            ?>
                                            <img src="<?php echo $avatar; ?>" width="100px" height="100px" alt=""
                                                class="img-fluid" data-id="<?php echo $row['idUser']; ?>">
                                        </td>

                                        <?php
                                        if ($check) {
                                            ?>
                                            <td>
                                                <?php
                                                if ($row['status'] == 1) {
                                                    echo "<button class='btn btn-success'>Được hoạt động</button>";
                                                } else {
                                                    echo "<button class='btn btn-danger'>Khóa hoạt động</button>";
                                                }
                                                ?>
                                            </td>

                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
            pageLength: 5,
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select class="form-select"><option value=""></option></select>'
                        )
                            .appendTo($(column.footer()).empty())
                            .on("change", function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                column
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append(
                                    '<option value="' + d + '">' + d + "</option>"
                                );
                            });
                    });
            },
        });
    });
</script>