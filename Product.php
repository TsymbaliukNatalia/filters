<?php
require_once "db.php";
    class  Product
    {
        public static $numb = 10;
        public static function getList($filters = array(),$page){
            global $pdo;
            $first_item = ($page - 1) * self::$numb;

            // запит для пустого масиву filters
            $sql = "SELECT `clothes_storage`.`id` as id, `clothes`.`id` as id_product, `clothes`.`name` as name, 
            `colour`.`name` as colour, `size`.`description` as size FROM `clothes_storage` 
            JOIN `clothes` ON `clothes_storage`.`clothes_id`=`clothes`.`id` 
            JOIN `colour` ON `colour`.`id`=`clothes_storage`.`colour_id` 
            JOIN `size` ON `size`.`id`=`clothes_storage`.`size_id`";

            // якщо переданий хоча б один фільтр
            if(!empty($filters)){
                    // масив імен фільтрів
                    $name_filters = array();
                    foreach($filters as $name=>$value){
                        $name_filters[] = $name;
                    }
                    // формуємо масив зі знаками питання для кожного з фільтрів
                    $params = array();
                    $str_params = array();
                    foreach($name_filters as $name){
                        for($i=0, $n=count($filters[$name]); $i < $n; $i++){
                            $params[$name][] = '?';
                        }
                        $str_params[$name] = implode(',',$params[$name]);
                    }
                    // формуємо запит для першого фільтра
                    $sql = "SELECT * FROM (".$sql.") t WHERE t.".$name_filters[0]." 
                    IN ( ".$str_params[$name_filters[0]]." )";
                    // якщо фільтр один, відправляємо запит і повертаємо результат
                    if(count($params) == 1){
                        $sql .= " LIMIT $first_item, ".self::$numb ;
                        $select = $pdo->prepare($sql);
                        $select->execute($filters[$name_filters[0]]);
                        $rezult = $select->fetchAll();
                        return $rezult;
                    // якщо фільтрів більше ніж один
                    } else {
                        // формуємо загальний масив з параметрами всіх фільтрів
                        $list_params = array();
                        foreach($filters as $filter){
                            foreach($filter as $value){
                                $list_params[] = $value;
                            }
                        }
                        // для кожного натупного фільтру після першого додаємо продовження запиту
                        for($i=1;$i<count($filters);$i++){
                            $sql .= " && t.".$name_filters[$i]." 
                            IN ( ".$str_params[$name_filters[$i]]." )";
                        }
                        $sql .= " LIMIT $first_item, ".self::$numb ;
                        $select = $pdo->prepare($sql);
                        // підставляємо всі параметри фільтрів на місця знаків питання по порядку
                        $select->execute($list_params);
                        $rezult = $select->fetchAll();
                        return $rezult;
                    }
                }
            $sql .= " LIMIT $first_item,  ".self::$numb ;
            $select = $pdo->prepare($sql);
            $select->execute();
            return $select->fetchAll();   
        }
        // повертає імена продуктів (id,name)
        public static function getProductNames(){
            global $pdo;
            $sql = "SELECT * FROM `clothes`";
            $select = $pdo->prepare($sql);
            $select->execute();
            return $select->fetchAll();
        }
        // повертає характеристику вибраного продукту (id,clothes_id, colour_id, size_id)
        public static function getProductById($id){
            global $pdo;
            $sql = "SELECT * FROM `clothes_storage` WHERE id=?";
            $select = $pdo->prepare($sql);
            $select->execute([$id]);
            return $select->fetch(PDO::FETCH_ASSOC);
        }

        public static function addProduct($new_property){
            global $pdo;
            $sql = "INSERT INTO `clothes_storage`(`clothes_id`, `colour_id`, `size_id`) 
            VALUES (:clothes_id,:colour_id,:size_id)";
            $add = $pdo->prepare($sql);
            $add->bindParam(':clothes_id',$new_property['clothes_id'],PDO::PARAM_INT);
            $add->bindParam(':colour_id',$new_property['colour_id'],PDO::PARAM_INT);
            $add->bindParam(':size_id',$new_property['size_id'],PDO::PARAM_INT);
            
            return $add->execute();

        }

        public static function updateProduct($new_property){
            global $pdo;
            $sql = "UPDATE `clothes_storage` SET `clothes_id`=:clothes_id,`colour_id`=:colour_id,`size_id`=:size_id WHERE id=:id";
            $update = $pdo->prepare($sql);
            $update->bindParam(':clothes_id',$new_property['clothes_id'],PDO::PARAM_INT);
            $update->bindParam(':colour_id',$new_property['colour_id'],PDO::PARAM_INT);
            $update->bindParam(':size_id',$new_property['size_id'],PDO::PARAM_INT);
            $update->bindParam(':id',$new_property['id'],PDO::PARAM_INT);
            
            return $update->execute();

        }

        public static function getClothesNameById($id){
            global $pdo;
            $sql = "SELECT * FROM `clothes` WHERE id=?";
            $select = $pdo->prepare($sql);
            $select->execute([$id]);
            return $select->fetch(PDO::FETCH_ASSOC);

        }
        public static function deleteProduct($id){
            global $pdo;
            $sql = "DELETE FROM `clothes_storage` WHERE id=?";
            $delete = $pdo->prepare($sql);
            return $delete->execute([$id]);

        }
        public static function getTotalProduct($filters=array()){
            global $pdo;
            $sql = "SELECT `clothes_storage`.`id` as id, `clothes`.`id` as id_product, `clothes`.`name` as name, 
            `colour`.`name` as colour, `size`.`description` as size FROM `clothes_storage` 
            JOIN `clothes` ON `clothes_storage`.`clothes_id`=`clothes`.`id` 
            JOIN `colour` ON `colour`.`id`=`clothes_storage`.`colour_id` 
            JOIN `size` ON `size`.`id`=`clothes_storage`.`size_id`";
            // якщо переданий хоча б один фільтр
            if(!empty($filters)){
                // масив імен фільтрів
                $name_filters = array();
                foreach($filters as $name=>$value){
                    $name_filters[] = $name;
                }
                // формуємо масив зі знаками питання для кожного з фільтрів
                $params = array();
                $str_params = array();
                foreach($name_filters as $name){
                    for($i=0, $n=count($filters[$name]); $i < $n; $i++){
                        $params[$name][] = '?';
                    }
                    $str_params[$name] = implode(',',$params[$name]);
                }
                // формуємо запит для першого фільтра
                $sql = "SELECT * FROM (".$sql.") t WHERE t.".$name_filters[0]." 
                IN ( ".$str_params[$name_filters[0]]." )";
                // якщо фільтр один, відправляємо запит і повертаємо результат
                if(count($params) == 1){
                    $select = $pdo->prepare($sql);
                    $select->execute($filters[$name_filters[0]]);
                    $rezult = $select->fetchAll();
                    return count($rezult);
                // якщо фільтрів більше ніж один
                } else {
                    // формуємо загальний масив з параметрами всіх фільтрів
                    $list_params = array();
                    foreach($filters as $filter){
                        foreach($filter as $value){
                            $list_params[] = $value;
                        }
                    }
                    // для кожного натупного фільтру після першого додаємо продовження запиту
                    for($i=1;$i<count($filters);$i++){
                        $sql .= " && t.".$name_filters[$i]." 
                        IN ( ".$str_params[$name_filters[$i]]." )";
                    }
                    $select = $pdo->prepare($sql);
                    // підставляємо всі параметри фільтрів на місця знаків питання по порядку
                    $select->execute($list_params);
                    $rezult = $select->fetchAll();
                    return count($rezult);
                }
            }
        $select = $pdo->prepare($sql);
        $select->execute();
        $rezult = $select->fetchAll();
        return count($rezult);
        }
    }
    

?>
