<?php
class receipt
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function selectDetailReceipt($idReceipt)
    {
        $sql = "SELECT *
            FROM ReceiptDETAIL JOIN IMAGEPRODUCTS ON ReceiptDETAIL.IDPRODUCT = IMAGEPRODUCTS.IDPRODUCT
            JOIN PRODUCTS ON PRODUCTS.IDPRODUCT = ReceiptDETAIL.IDPRODUCT
            JOIN ReceiptS ON ReceiptDETAIL.IDReceipt = ReceiptS.IDReceipt
            WHERE ReceiptDETAIL.idReceipt = $idReceipt
            GROUP BY ReceiptDETAIL.IDPRODUCT";
        return $this->db->selectAll($sql);
    }

    public function selectByCondition($sql)
    {
        return $this->db->selectAll($sql);
    }

    public function selectReceiptShow($idReceipt)
    {
        $sql = "SELECT *
            FROM ReceiptS JOIN ReceiptDETAIL ON ReceiptS.IDReceipt = ReceiptDETAIL.IDReceipt
            JOIN PRODUCTS ON ReceiptDETAIL.IDPRODUCT = PRODUCTS.IDPRODUCT
            JOIN IMAGEPRODUCTS ON PRODUCTS.IDPRODUCT = IMAGEPRODUCTS.IDPRODUCT
            WHERE ReceiptS.IDReceipt = $idReceipt
            GROUP BY PRODUCTS.idProduct, Receiptdetail.size";
        return $this->db->selectAll($sql);
    }

    public function insertReceipt($idUser, $staff, $idSuppiler, $total)
    {
        // insert Receipt
        $sql = "INSERT INTO ReceiptS (idUser, idSupplier, staff,totalReceipt) VALUES ($idUser, $idSuppiler, '$staff', $total)";
        $idReceipt = $this->db->insert($sql);
        if (!$idReceipt) {
            return "Lỗi: Không thể tạo Receipt.";
        }
        // insert Receipt detail
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['receipt'])) {
            foreach ($_SESSION['receipt']['data'] as $key => $item) {
                $idProduct = $item['id'];
                $size = $item['size'];
                $quantity = $item['quantity'];
                $total = $item['total'];
                $price = $total / $quantity;
                $sql = "INSERT INTO ReceiptDETAIL (idReceipt, idProduct, size, quantity, total) VALUES ($idReceipt, $idProduct, $size, $quantity, $total)";
                $this->db->insert($sql);
                $sql = "UPDATE SIZEPRODUCTS SET QUANTITYREMAIN = QUANTITYREMAIN + $quantity 
                WHERE SIZEPRODUCTS.SIZE = $size AND SIZEPRODUCTS.IDPRODUCT=$idProduct";
                $this->db->update($sql);
            }
        }
        unset($_SESSION['receipt']);
        return "Thêm thành công";
    }

    public function deleteReceipt($idReceipt)
    {
        $sql = "UPDATE ReceiptS SET statusRemove = 1 WHERE idReceipt = $idReceipt";
        return $this->db->update($sql);
    }


    public function getInfoReceipt($idReceipt)
    {
        $sql = "SELECT * FROM ReceiptS 
        JOIN SUPPLIERS ON ReceiptS.IDSUPPLIER = SUPPLIERS.IDSUPPLIER 
        WHERE idReceipt = $idReceipt";
        return $this->db->selectAll($sql)->fetch_assoc();
    }
    public function getSuppliers()
    {
        $sql = "SELECT * FROM suppliers";
        $result = $this->db->selectAll($sql);
        $receipt = [];
        while ($row = $result->fetch_assoc()) {
            $receipt[] = $row;
        }
        return $receipt;
    }
    public function pagination($itemOfPage)
    {
        $sql = "SELECT * FROM receipts WHERE STATUSREMOVE = 0";
        $items = $this->db->selectAll($sql)->num_rows;
        $page = ceil($items / $itemOfPage);
        return $page;
    }
}
?>