<?php

class brand
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertBrand($nameCollection, $logo)
    {
        require_once __DIR__ . "/../handle.php";

        $sql = "Insert into brands (brandName,imageLogo) values(' $nameCollection','')";
        $idCollection = $this->db->insert($sql);
        $upload = uploadsLogoCollection($logo, $idCollection);
        $sql = "Update brands set imageLogo ='$upload' where idBrand =$idCollection";
        return $this->db->update($sql);
    }

    public function selectAll()
    {
        $sql = "SELECT *
            FROM brands";
        $result = $this->db->selectAll($sql);
        return $result;
    }

    public function countSubBrand($idBrand)
    {
        $sql = "SELECT COUNT(*) FROM subBrands WHERE idBrand = $idBrand";
        $result = $this->db->selectAll($sql);
        $count = $result->fetch_array()[0];
        return (int)$count;
    }
    public function selectByCondition($sql)
    {
        return $this->db->selectAll($sql);
    }
    public function pagination($itemOfPage, $valueSearch)
    {
        $sql = "SELECT * FROM brands ";
        if ($valueSearch != "") {
            $sql .= "  where brandName like '%$valueSearch%'";
        }
        $items = $this->db->selectAll($sql)->num_rows;
        $page = ceil($items / $itemOfPage);
        return $page;
    }


    public function selectById($idBrand)
    {
        $sql = "SELECT * FROM brands WHERE idBrand = $idBrand";
        $result = $this->db->selectAll($sql);
        while ($row = $result->fetch_assoc()) {
            return $row;
        }
    }

    public function selectSubBrandById($idBrand)
    {
        $sql = "SELECT * FROM subBrands WHERE idBrand = $idBrand";
        $result = $this->db->selectAll($sql);
        return $result;
    }


    //update
    public function updateBrand($idCollection, $brandName, $img)
    {
        $sql = "Update brands set brandName ='$brandName'";
        if ($img) {
            require_once __DIR__ . "/../handle.php";
            $upload = uploadsLogoCollection($img, $idCollection);

            $sql .= ", imageLogo ='$upload' ";
        }
        $sql .= " WHERE IDBRAND = $idCollection";
        echo $sql;
        return $this->db->update($sql);
    }

    function insertSubBrand($idBrand, $nameSubBrand)
    {
        $sql = "insert into subbrands (idBrand,subBrandName) values ($idBrand,'$nameSubBrand')";
        echo $sql;
        return $this->db->insert($sql);
    }
}



function getSubBrandById($idBrand)
{
    require_once "./database.php";
    $db = new database();
    $brands = new brand($db);
    $result = $brands->selectSubBrandById($idBrand);
    $arr = [];
    while ($row = $result->fetch_assoc()) {
        $arr[] = $row;
    }
    return $arr;
}



if (isset($_GET['getSubBrandById'])) {
    $idBrand = $_GET['idBrand'];
    echo json_encode(getSubBrandById($idBrand));
}
