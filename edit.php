<?php
require_once "Product.php";
require_once "Colour.php";
require_once "Size.php";

$listProduct = Product::getProductNames();
$coloursList = Colour::getListColour();
$sizesList = Size::getListSize();

// прапорець що позначає чи збережено зміни
$edit_flag = false;

// перевіряємо чи переданий id для пошуку
// якщо так дістаємо строку з конкретним товаром і його характеристиками
if (!empty($_GET) && isset($_GET["id"])) {
    $edit_product = Product::getProductById($_GET["id"]);
}

// якщо форму відправлено, записуємо дані з неї у масив,
// який потім передається для зміни
if (isset($_POST["edit"])) {
    $product_for_update["clothes_id"] = $_POST["name"];
    $product_for_update["colour_id"] = $_POST["colour"];
    $product_for_update["size_id"] = $_POST["size"];
    $product_for_update["id"] = $_POST["id"];
    // якщо функція зміни відпрацювала без збоїв, міняємо прапорець на значення true
    $edit_flag = Product::updateProduct($product_for_update);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit product</title>
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
    <?php if ($edit_flag == false) { ?>
        <form action="edit.php" method="POST">
            <div>
                <input type="checkbox" name="id" id="hiden_checkbox" value="<?= $edit_product["id"] ?>" checked>
                <label for="name_product">
                    <select name="name" id="name_product">
                        <?php foreach ($listProduct as $item) { ?>
                            <?php if ($item["id"] == $edit_product["clothes_id"]) { ?>
                                <option value="<?= $item["id"] ?>" selected>
                                    <?= $item["name"] ?>
                                </option>
                            <?php } else { ?>
                                <option value="<?= $item["id"] ?>">
                                    <?= $item["name"] ?>
                                </option>
                        <?php }
                        }; ?>
                    </select>
                </label>
                <label for="colour">
                    <select name="colour" id="colour">
                        <?php foreach ($coloursList as $item) { ?>
                            <?php if ($item["id"] == $edit_product["colour_id"]) { ?>
                                <option value="<?= $item["id"] ?>" selected>
                                    <?= $item["name"] ?>
                                </option>
                            <?php } else { ?>
                                <option value="<?= $item["id"] ?>">
                                    <?= $item["name"] ?>
                                </option>
                        <?php }
                        }; ?>
                    </select>
                </label>
                <label for="size">
                    <select name="size" id="size">
                        <?php foreach ($sizesList as $item) { ?>
                            <?php if ($item["id"] == $edit_product["size_id"]) { ?>
                                <option value="<?= $item["id"] ?>" selected>
                                    <?= $item["description"] ?>
                                </option>
                            <?php } else { ?>
                                <option value="<?= $item["id"] ?>">
                                    <?= $item["description"] ?>
                                </option>
                        <?php }
                        }; ?>
                    </select>
                </label>
            </div>
            <br>
            <div>
                <button><a href="index.php">Повернутися на головну сторінку</a></button>
                <button type="submit" name="edit" value="Зберегти зміни">Зберегти зміни</button>
            </div>
        </form>
    <?php } else { ?>
        <p>Зміни збережено!</p>
        <button><a href="index.php">Повернутися на головну сторінку</a></button>
    <?php } ?>

</body>

</html>