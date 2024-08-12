<?php

    class brand {

        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function selectAll () {
            $sql = "SELECT *
            FROM brands";
            $result = $this->db->selectAll($sql);
            return $result;
        }

        public function countSubBrand ($idBrand) {
            $sql = "SELECT COUNT(*) FROM subBrands WHERE idBrand = $idBrand";
            $result = $this->db->selectAll($sql);
            $count = $result->fetch_array()[0];
            return (int)$count;
        }
        
        public function selectById ($idBrand) {
            $sql = "SELECT * FROM brands WHERE idBrand = $idBrand";
            $result = $this->db->selectAll($sql);
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        }

        public function selectSubBrandById ($idBrand) {
            $sql = "SELECT * FROM subBrands WHERE idBrand = $idBrand";
            $result = $this->db->selectAll($sql);
            return $result;
        }
    }

    function getSubBrandById ($idBrand) {
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

?>