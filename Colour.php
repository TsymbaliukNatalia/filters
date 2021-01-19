<?php
require_once "db.php";
class  Colour
    {
        public static function getListColour(){
            global $pdo;

            $sql = "SELECT * FROM `colour`";
            $select = $pdo->prepare($sql);
            $select->execute();
            return $select->fetchAll();
        }
        public static function getColourById($id){
            global $pdo;

            $sql = "SELECT * FROM `colour` WHERE id=?";
            $select = $pdo->prepare($sql);
            $select->execute([$id]);
            return $select->fetch(PDO::FETCH_ASSOC);
        }
 
    }

?>