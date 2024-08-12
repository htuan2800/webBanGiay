<?php

    class cart {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function selectById ($id) {
            $sql = "SELECT * FROM carts WHERE idUser = $id";
            return $this->db->selectAll($sql);
        }

        public function selectCartDetailById ($id) {
            $sql = "SELECT *
            FROM cartdetail JOIN carts ON cartdetail.idCart = carts.idCart
            JOIN products ON cartDetail.idProduct = products.idProduct
            JOIN imageProducts ON products.idProduct = imageProducts.idProduct
            JOIN sizeproducts ON sizeproducts.idProduct = cartdetail.idProduct
            WHERE idUser = $id
            AND sizeproducts.size = cartdetail.size
            GROUP BY imageProducts.idProduct, cartdetail.size
            ORDER BY cartdetail.updateAt DESC";
            return $this->db->selectAll($sql);
        }

        public function selectProductToBuy ($products, $idUser) {
            $sql = "SELECT imageproducts.image, products.productName, cartdetail.size, cartdetail.quantity, cartdetail.totalProduct
                    FROM cartdetail JOIN carts ON carts.idCart = cartdetail.idCart
                    JOIN products on products.idProduct = cartdetail.idProduct
                    JOIN imageproducts ON cartdetail.idProduct = imageproducts.idProduct
                    WHERE ";
            foreach ($products as $key => $value) {
                $id = $value['id'];
                $size = $value['size'];
                $subSql = "(cartdetail.idProduct = $id AND cartdetail.size = $size)";
                if ($key === 0) {
                    $sql .= $subSql;
                }
                else {
                    $sql .= " OR " . $subSql;
                }
            }
            $sql .= " AND carts.idUser = $idUser GROUP BY cartdetail.idProduct, cartdetail.size";
            return $this->db->selectAll($sql);
        }

        public function insertCart ($idProduct, $size, $quantity, $price) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $idUser = $_SESSION['account_login']['idUser'];
            $sql = "update carts set quantityProduct = quantityProduct + $quantity,total = total + $price * $quantity where idUser = $idUser";
            $this->db->update($sql);
            $sql = "SELECT *
                    FROM carts
                    ORDER BY updateAt DESC
                    LIMIT 1";
            $cart = $this->db->selectAll($sql);
            $result = $cart->fetch_assoc();
            $id = $result['idCart'];
            $sql = "SELECT * FROM cartDetail WHERE idProduct = $idProduct AND size = '$size'";
            $result = $this->db->selectAll($sql);
            if ($result->num_rows > 0) {
                $sql = "UPDATE cartDetail SET totalProduct = $price * (quantity + $quantity), quantity = quantity + $quantity WHERE idProduct = $idProduct AND size = '$size'";
                return $this->db->update($sql);
            }
            $sql = "INSERT INTO cartDetail (idCart, idProduct, size, quantity, totalProduct) VALUES ($id, $idProduct, '$size', $quantity, $price * $quantity)";
            return $this->db->insert($sql);
        }

        public function deleteProductCart ($idProduct, $quantity, $price) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $idUser = $_SESSION['account_login']['idUser'];
            $sql = "update carts set quantityProduct = quantityProduct - $quantity, total = total - $price * $quantity where idUser = $idUser";
            
            $this->db->update($sql);
            $sql = "SELECT *
                    FROM carts
                    ORDER BY updateAt DESC
                    LIMIT 1";
            $cart = $this->db->selectAll($sql);
            $result = $cart->fetch_assoc();
            $id = $result['idCart'];
            $sql = "DELETE FROM cartDetail WHERE idProduct = $idProduct AND idCart = $id";
            return $this->db->delete($sql);
        }

        public function updateQuantityProductToCartDetail ($idProduct, $quantity, $price) {
            $sql = "UPDATE cartDetail SET quantity = $quantity, totalProduct = $price * $quantity WHERE idProduct = $idProduct";
            return $this->db->update($sql);
        }
    }
?>