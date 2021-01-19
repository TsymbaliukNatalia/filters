<?php
require_once "db.php";
class  Size
    {
        private $id;
        private $description;
        public function __construct($id="")
        {
            if($id !== ""){
                $this->id = $id;
                global $pdo;

                $sql = "SELECT description FROM `size` WHERE id=?";
                $select = $pdo->prepare($sql);
                $select->execute([$this->id]);
                $size = $select->fetch(PDO::FETCH_ASSOC);
                $this->description = $size["description"];
            } 
        }
        public function __get($property)
        {
            return $this->$property;
        }
        
        public static function getListSize(){
            global $pdo;

            $sql = "SELECT * FROM `size`";
            $select = $pdo->prepare($sql);
            $select->execute();
            return $select->fetchAll();
        }
    }

?>