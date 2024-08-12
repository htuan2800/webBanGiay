<?php
    if (!function_exists('customErrorHandler')) {
        function customErrorHandler($errno, $errstr, $errfile, $errline) {
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        }
    
        set_error_handler("customErrorHandler");
    }
    
    set_error_handler("customErrorHandler");
    
    try {
        include_once "./database/database.php";
        include_once "./database/user.php";
    } catch (ErrorException $e) {
        try {
            include_once "../database/database.php";
            include_once "../database/user.php";
        } catch (ErrorException $e) {
            echo "Failed to include autoload file: " . $e->getMessage() . "\n";
        }
    }
    restore_error_handler();

    $db = new Database();
    $user = new user($db);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // add address
    if (isset ($_POST["type"]) && $_POST["type"] == "add-address") {
        $idUser = $_SESSION['account_login']['idUser'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $user->insertAddress($idUser, $name, $address, $phone);
    }

    // update address
    if (isset ($_POST["type"]) && $_POST["type"] == "update-address") {
        $id = $_SESSION['account_login']['idUser'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $oldName = $_POST['oldName'];
        $oldAddress = $_POST['oldAddress'];
        $oldPhone = $_POST['oldPhone'];
        $user->updateAddress($id, $name, $address, $phone, $oldName, $oldAddress, $oldPhone);
    }

    // delete address
    if (isset ($_POST["delete-address"])) {
        $id = $_SESSION['account_login']['idUser'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $user->deleteAddress($id, $name, $address, $phone);
    }

    // set default
    if (isset ($_POST["set-default"])) {
        $id = $_SESSION['account_login']['idUser'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $user->updateDefaultAddress($id, $name, $address, $phone);
    }

    // show address
    $userAddress = $user->selectAddressById($_SESSION['account_login']['idUser']);
?>

<div class="address row">
    <div class="title col-lg-12 col-md-12 col-sm-12">
        <h1>Địa chỉ</h1>
        <button>Thêm địa chỉ</button>
    </div>

    <div class="show-address col-lg-12 col-md-12 col-sm-12">
        <?php
            if ($userAddress->num_rows == 0) {
        ?>
        <div class="no-address">
            Chưa có địa chỉ giao hàng nào
        </div>

        <?php
            }
            else {
        ?>
        <table>
            <thead>
                <tr>
                    <th>Tên người nhận</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Xóa</th>
                    <th>Sửa</th>
                    <th>Thiết lập mặc định</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    while ($row = $userAddress->fetch_assoc()) {
                ?>
                <tr>
                    <td class="name"><?php echo $row['name']; ?></td>
                    <td class="address"><?php echo $row['address']; ?></td>
                    <td class="phone"><?php echo $row['phoneNumber']; ?></td>
                    <td><i class="remove fa-solid fa-trash"></i></td>
                    <td><i class="update fa-solid fa-pen-to-square"></i></td>
                    <td>
                        <?php
                            if ($row['status'] == 0) {
                        ?>
                        <i class="set-default fa-solid fa-map-location-dot"></i>

                        <?php
                            }
                            else {
                        ?>

                        <span style="color: green; font-weight: bold; font-size: 18px;">Mặc định</span>

                        <?php
                            }
                        ?>
                    </td>
                </tr>

                <?php
                    }
                ?>
            </tbody>
        </table>
        <?php
            }
        ?>
    </div>
</div>