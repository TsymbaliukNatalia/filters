<?php
require_once "Product.php";
require_once "Colour.php";
require_once "Size.php";

$listProduct = Product::getProductNames();
$coloursList = Colour::getListColour();
$sizesList = Size::getListSize();

// прапорець що позначає чи збережено зміни
$add_flag = false;

// якщо форму відправлено, записуємо дані з неї у масив,
// який потім передається для створення нового запису
if (isset($_POST["add"])) {
    $product_for_add["clothes_id"] = $_POST["name"];
    $product_for_add["colour_id"] = $_POST["colour"];
    $product_for_add["size_id"] = $_POST["size"];
    // якщо функція додавання нового елемента відпрацювала без збоїв, міняємо прапорець на значення true
    $add_flag = Product::addProduct($product_for_add);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add product</title>
    <style>
        a {
            text-decoration: none;
            color: black;
        }
        button{
            outline: none;
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <?php if ($add_flag == false) { ?>
        <form action="add.php" method="POST">
            <div>
                <label for="name_product">
                    <select name="name" id="name_product">
                        <?php foreach ($listProduct as $item) { ?>
                                <option value="<?= $item["id"] ?>">
                                    <?= $item["name"] ?>
                                </option>
                        <?php }; ?>
                    </select>
                </label>
                <label for="colour">
                    <select name="colour" id="colour">
                        <?php foreach ($coloursList as $item) { ?>
                                <option value="<?= $item["id"] ?>">
                                    <?= $item["name"] ?>
                                </option>
                        <?php }; ?>
                    </select>
                </label>
                <label for="size">
                    <select name="size" id="size">
                        <?php foreach ($sizesList as $item) { ?>
                                <option value="<?= $item["id"] ?>">
                                    <?= $item["description"] ?>
                                </option>
                        <?php }; ?>
                    </select>
                </label>
            </div>
            <br>
            <div>
                <button><a href="index.php">Повернутися на головну сторінку</a></button>
                <button type="submit" name="add" value="Зберегти зміни">Зберегти зміни</button>
            </div>
        </form>
    <?php } else { ?>
        <p>Зміни збережено!</p>
        <button><a href="index.php">Повернутися на головну сторінку</a></button>
    <?php } ?>

</body>

</html>