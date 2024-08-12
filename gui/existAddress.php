<?php
    require_once '../database/database.php';
    require_once '../database/user.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $db = new database();
    $user = new user($db);

    if (isset($_POST['idAddress'])) {
        $idAddress = $_POST['idAddress'];
        $result = $user->selectDetailAddressByIdAddress($idAddress);

        $name = $result['name'];
        $phoneNumber = $result['phoneNumber'];
        $address = $result['address'];
        $result = [
            'name' => $name,
            'phoneNumber' => $phoneNumber,
            'address' => $address
        ];

        echo json_encode($result);
        exit();
    }
    $result = $user->selectAddressById($_SESSION['account_login']['idUser']);
?>

<div class="form-floating mb-5">
    <select class="form-select" id="floatingSelect" aria-label="Floating label select example">

        <?php
            $name = "";
            $phoneNumber = "";
            $address = "";
            foreach ($result as $key => $value) {
                if ($key == 0) {
                    if ($value['status'] == 1) {
                        $name = $value['name'];
                        $phoneNumber = $value['phoneNumber'];
                        $address = $value['address'];
        ?>
        <option value="<?php echo $value['idAddress']; ?>" selected>Mặc định</option>
        <?php
                    }else {
        ?>
        <option value="0" selected>Chọn địa chỉ</option>
        <?php
                }}
                else {
        ?>
        <option value="<?php echo $value['idAddress']; ?>">
            <?php echo "Địa chỉ: " . $value['address'] . ", Người nhận: " . $value['name'] . ", Số điện thoại: " . $value['phoneNumber']; ?>
        </option>
        <?php
            }
        }
        ?>
    </select>
    <label for="floatingSelect">Chọn địa chỉ giao hàng</label>
</div>

<div class="form-floating mb-5">
    <input type="text" class="form-control" id="recipient-name" placeholder="Người nhận" value="<?php echo $name; ?>"
        disabled>
    <label for="floatingInput">Người nhận</label>
</div>
<div class="form-floating mb-5">
    <input type="text" class="form-control" id="address" placeholder="Địa chỉ" value="<?php echo $address; ?>"
        disabled>
    <label for="floatingInput">Địa chỉ</label>
</div>
<div class="form-floating mb-3">
    <input type="text" class="form-control" id="phone-number" placeholder="Số điện thoại"
        value="<?php echo $phoneNumber; ?>" disabled>
    <label for="floatingPassword">Số điện thoại</label>
</div>