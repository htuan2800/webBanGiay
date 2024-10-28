<?php

    class evalution {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getEvalutionByProduct($id) {
            $sql = "SELECT * FROM evaluation
            JOIN Bills ON evaluation.idBill = Bills.idBill
            JOIN users ON Bills.idUser = users.idUser
            WHERE idProduct = $id";
            return $this->db->selectAll($sql);
        }

        public function getCountEvalutionByProduct($id) {
            $sql = "SELECT COUNT(*) FROM evaluation WHERE idProduct = $id";
            return $this->db->selectAll($sql)->fetch_assoc()['COUNT(*)'];
        }

        public function getAverageRating($id) {
            $sql = "SELECT AVG(rating) FROM evaluation WHERE idProduct = $id";
            $rating = floor($this->db->selectAll($sql)->fetch_assoc()["AVG(rating)"]);
            return $rating;
        }
    }

?>