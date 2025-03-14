<?php

class coupon
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM coupon
            WHERE coupon.status = 1";
        return $this->db->selectAll($sql);
    }

    public function selectByCondition($sql)
    {
        return $this->db->selectAll($sql);
    }

    public function selectProductNew()
    {
        $sql = "SELECT *
            FROM products JOIN imageProductS ON products.idProduct = imageProductS.idProduct
            WHERE products.STATUS = 1
            GROUP BY products.idProduct
            ORDER BY products.idProduct DESC LIMIT 10";
        return $this->db->selectAll($sql);
    }

    public function selectProductBestSeller()
    {
        $sql = "SELECT *
            FROM products
            JOIN imageProductS ON products.idProduct = imageProductS.idProduct
            WHERE products.STATUS = 1
            GROUP BY products.idProduct
            ORDER BY products.quantitySold DESC LIMIT 10";
        return $this->db->selectAll($sql);
    }

    public function selectCouponById($id)
    {
        $sql = "SELECT * FROM coupon
            WHERE id = $id";
        $result = $this->db->selectAll($sql);
        return $result->fetch_assoc();
    }

    public function selectSizeById($id)
    {
        $sql = "SELECT *
                    FROM sizeproducts
                    WHERE idProduct = $id
                    and STATUSSIZE = 1";
        $result = $this->db->selectAll($sql);
        $sizes = [];
        while ($row = $result->fetch_assoc()) {
            $sizes[] = $row;
        }
        return $sizes;
    }

    public function selectProductByDesignType($type)
    {
        $sql = "SELECT * FROM products JOIN imageproducts
                    ON products.idProduct = imageproducts.idProduct
                    WHERE designType = '$type'
                    GROUP BY products.idProduct
                    ORDER BY products.idProduct DESC LIMIT 4";
        $result = $this->db->selectAll($sql);
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }
    public function selectProductsByPrice($idBrand, $limit)
    {
        $sql = "SELECT *
                FROM products
                WHERE products.STATUS = 1 AND products.idBrand = $idBrand
                ORDER BY products.currentPrice DESC LIMIT $limit";

        $result = $this->db->selectAll($sql);
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }


    public function insertCoupon($code, $discount_percent, $start_date, $end_date)
    {
        $startTime = date('Y-m-d H:i:s', strtotime($start_date));
        $endTime = date('Y-m-d H:i:s', strtotime($end_date));
        $sql = "INSERT INTO coupon (code, discount_percent, start_date, end_date)
        VALUES ('$code', '$discount_percent', '$startTime', '$endTime')";
        $id = $this->db->insert($sql);
        return $id;
    }

    public function deleteCoupon($id)
    {
        $sql = "UPDATE coupon SET status = 0 WHERE id = $id";
        return $this->db->update($sql);
    }

    public function pagination($itemOfPage, $valueSearch)
    {
        $sql = "SELECT * FROM products WHERE STATUS = 1";
        if ($valueSearch != "") {
            $sql .= "  AND productName like '%$valueSearch%'";
        }
        $items = $this->db->selectAll($sql)->num_rows;
        $page = ceil($items / $itemOfPage);
        return $page;
    }

    public function updateCoupon($id, $code, $discount_percent, $start_date, $end_date)
    {
        $startTime = date('Y-m-d H:i:s', strtotime($start_date));
        $endTime = date('Y-m-d H:i:s', strtotime($end_date));

        $sql = "UPDATE coupon SET code = '$code', discount_percent = '$discount_percent', start_date = '$startTime', end_date = '$endTime' WHERE id = $id";
        return $this->db->update($sql);
    }

    public function checkCoupon($code)
    {
        $time_now = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM coupon WHERE code = '$code' AND start_date <= '$time_now' AND end_date >= '$time_now' AND status = 1";
        $result = $this->db->selectAll($sql);
        if ($result->num_rows > 0) {
            $coupon = $result->fetch_assoc();
            $_SESSION['coupon'] = [
                'id' => $coupon['id'],
                'code' => $coupon['code'],
                'discount' => $coupon['discount_percent'], 
                'start_date' => $coupon['start_date'], 
                'expiry' => $coupon['end_date']
            ];
            return 1;
        }
        return 0;
    }
}
