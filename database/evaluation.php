<?php

    class evaluation {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function selectByIdBill ($idBill) {
            $sql = "SELECT * FROM evaluation WHERE idBill = $idBill";
            return $this->db->selectAll($sql);
        }

        public function insert ($idProduct, $idBill, $content, $star) {
            $sql = "INSERT INTO evaluation (idProduct, idBill, content, rating) VALUES ($idProduct, $idBill, '$content', $star)";
            return $this->db->insert($sql);
        }
    }

?>