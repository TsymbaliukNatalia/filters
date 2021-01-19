<?php 
require_once "Product.php";
require_once "Colour.php";
require_once "Size.php";



$delete_flag = false;

if (!empty($_GET) && isset($_GET["id"])) {
    $id = $_GET["id"];
    $delete_product = Product::getProductById($_GET["id"]);
    $delete_size = new Size($delete_product["size_id"]);
    $name = Product::getClothesNameById($delete_product["clothes_id"])["name"];
    $colour = Colour::getColourById($delete_product["colour_id"])["name"];
    $size = $delete_size->description;
    $str = $name." ".$colour." ".$size;
}
if(isset($_POST["delete"])){
    $delete_flag = Product::deleteProduct($_POST["id"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete product</title>
    <style>
        a {
            text-decoration: none;
            color: black;
        }
        #hiden_checkbox {
            display: none;
        }
        button{
            outline: none;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <?php if(!$delete_flag) {?>
    <p>Ви впевнені що хочете видалити дану позицію?</p>
    <p>"<?=$str?>"</p>
    <form action="delete.php" method="post">
        <input type="checkbox" name="id" id="hiden_checkbox" value="<?=$id?>" checked>
        <button><a href="index.php">Повернутися на головну сторінку</a></button>
        <button type="submit" name="delete" value="Видалити">Видалити</button>
    </form>
    <?php } else {?>
        <p>Позицію видалено!</p>
        <button><a href="index.php">Повернутися на головну сторінку</a></button>
    <?php } ?>
    
    
</body>
</html>