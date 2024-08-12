<?php
    class bill {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function selectBillByIdUser($status) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $sql = "SELECT * FROM BILLS WHERE idUser = " . $_SESSION['account_login']['idUser'] . " AND statusBill = $status";
            return $this->db->selectAll($sql);
        }

        public function selectDetailBill ($idBill) {
            $sql = "SELECT *
            FROM BILLDETAIL JOIN IMAGEPRODUCTS ON BILLDETAIL.IDPRODUCT = IMAGEPRODUCTS.IDPRODUCT
            JOIN PRODUCTS ON PRODUCTS.IDPRODUCT = BILLDETAIL.IDPRODUCT
            JOIN BILLS ON BILLDETAIL.IDBILL = BILLS.IDBILL
            WHERE BILLDETAIL.idBill = $idBill
            GROUP BY BILLDETAIL.IDPRODUCT";
            return $this->db->selectAll($sql);
        }

        public function selectByCondition ($sql) {
            return $this->db->selectAll($sql);
        }

        public function selectBillShow ($idBill) {
            $sql = "SELECT *
            FROM BILLS JOIN BILLDETAIL ON BILLS.IDBILL = BILLDETAIL.IDBILL
            JOIN PRODUCTS ON BILLDETAIL.IDPRODUCT = PRODUCTS.IDPRODUCT
            JOIN IMAGEPRODUCTS ON PRODUCTS.IDPRODUCT = IMAGEPRODUCTS.IDPRODUCT
            WHERE BILLS.IDBILL = $idBill
            GROUP BY PRODUCTS.idProduct, billdetail.size";
            return $this->db->selectAll($sql);
        }

        public function insertBill ($idUser, $receiver, $shippingAddress, $phoneNumber, $total, $paymentMethod, $products, $cart) {
            // insert bill
            $sql = "INSERT INTO BILLS (idUser, receiver, shippingAddress, phoneNumber, totalBill, paymentMethod) VALUES ($idUser, '$receiver', '$shippingAddress', '$phoneNumber', $total, '$paymentMethod')";
            $idBill = $this->db->insert($sql);

            // insert bill detail
            $sql = "SELECT *
            FROM CARTDETAIL JOIN CARTS ON CARTS.IDCART = CARTDETAIL.IDCART
            WHERE ";
            foreach ($products as $key => $value) {
                $id = $value['id'];
                $size = $value['size'];
                $subSql = "(CARTDETAIL.IDPRODUCT = $id AND CARTDETAIL.SIZE = $size)";
                if ($key === 0) {
                    $sql .= $subSql;
                }
                else {
                    $sql .= " OR " . $subSql;
                }
            }
            $result = $this->db->selectAll($sql);
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $idProduct = $row['idProduct'];
                $size = $row['size'];
                $quantity = $row['quantity'];
                $total = $row['totalProduct'];
                $price = $total / $quantity;
                $sql = "INSERT INTO BILLDETAIL (idBill, idProduct, size, quantity, total) VALUES ($idBill, $idProduct, $size, $quantity, $total)";
                $this->db->insert($sql);

                $products = $row;

                // delete cart
                $cart->deleteProductCart($idProduct, $quantity, $price);
            }

            return print_r($products);
        }

        public function updateStatus ($idBill, $status) {
            if ($status == 0) {
                $sql = "SELECT *
                FROM BILLS JOIN BILLDETAIL ON BILLS.IDBILL = BILLDETAIL.IDBILL
                WHERE BILLS.IDBILL = $idBill";
                $result = $this->db->selectAll($sql);
                while ($row = $result->fetch_assoc()) {
                    $sql = "UPDATE SIZEPRODUCTS SET QUANTITYREMAIN = QUANTITYREMAIN + " . $row['quantity'] . " WHERE IDPRODUCT = " . $row['idProduct'] . " AND SIZE = '" . $row['size'] . "'";
                    $this->db->update($sql);
                }
                $sql = "UPDATE BILLS SET statusBill = $status WHERE idBill = $idBill";
                return $this->db->update($sql);
            }
            if ($status == 2) {
                $sql = "UPDATE BILLS SET statusBill = $status, approvalTime = NOW() WHERE idBill = $idBill";
                return $this->db->update($sql);
            }
            if ($status == 3) {
                $sql = "UPDATE BILLS SET statusBill = $status, deliveryTime = NOW() WHERE idBill = $idBill";
                return $this->db->update($sql);
            }
            if ($status == 4) {
                $sql = 'UPDATE PRODUCTS JOIN BILLDETAIL ON PRODUCTS.IDPRODUCT = BILLDETAIL.IDPRODUCT
                SET QUANTITYSOLD = QUANTITYSOLD + BILLDETAIL.QUANTITY
                WHERE BILLDETAIL.IDBILL = ' . $idBill;
                $this->db->update($sql);
                $sql = "UPDATE BILLS SET statusBill = $status, completionTime = NOW() WHERE idBill = $idBill";
                return $this->db->update($sql);
            }
            $sql = "UPDATE BILLS SET statusBill = $status WHERE idBill = $idBill";
            return $this->db->update($sql);
        }

        public function getQuantityBillNeedApproval () {
            $sql = "SELECT * FROM BILLS WHERE statusBill = 1";
            $result = $this->db->selectAll($sql);
            return $result->num_rows;
        }

        public function getRevenueToday () {
            $sql = "SELECT SUM(totalBill) AS revenueToday
            FROM BILLS
            WHERE DATE(orderTime) = CURDATE()
            AND statusBill > 1";
            $result = $this->db->selectAll($sql);
            $revenue = $result->fetch_assoc();
            if ($revenue['revenueToday'] == null) {
                return "0đ";
            }
            require_once __DIR__ . '/../handle.php';
            return convertPrice ($revenue['revenueToday']);
        }

        public function getInfoBill ($idBill) {
            $sql = "SELECT * FROM BILLS WHERE idBill = $idBill";
            return $this->db->selectAll($sql)->fetch_assoc();
        }
    }
?>