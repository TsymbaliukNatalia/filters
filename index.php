<?php
require_once "Product.php";
require_once "Colour.php";
require_once "Size.php";


// масив зі значеннями для фільтрації
$filters = array();
// присвоюємо значення в масив, якщо вони передані з форми
if (isset($_GET["colour"])) {
    $filters["colour"] = $_GET["colour"];
}
if (isset($_GET["size"])) {
    $filters["size"] = $_GET["size"];
}

// визначаємо яку сторінку ми показуємо на екрані
if (isset($_GET['page']) && !empty($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$listProduct = Product::getList($filters, $page);
$coloursList = Colour::getListColour();
$sizesList = Size::getListSize();

// визначаємо кількість сторінок для відображення
$total = Product::getTotalProduct($filters);
$pages = ceil($total / Product::$numb);

// формуємо строку для передачі фільтрів в get при переході на іншу сторінку
$str_filter = "";
if (!empty($filters)) {
    $str_filter .= "&";
    foreach ($filters as $key => $item) {
        foreach ($item as $value) {
            $str_filter .= $key . "%5B%5D=" . $value . "&";
        }
    }
    $str_filter .= "submit=Відправити";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div>
                <form action="" method="GET" enctype="multipart/form-data">
                    <div class="filters_box">
                        <fieldset>
                            <legend>Виберіть колір :</legend>
                            <?php foreach ($coloursList as $colour => $item) { ?>
                                <div class="colour_list">
                                    <input type="checkbox" id="<?= $item[1] ?>" name="colour[]" value="<?= $item[1] ?>">
                                    <label for="<?= $item[1] ?>"><?= $item[1] ?></label>
                                </div>
                            <?php }; ?>
                        </fieldset>
                        <fieldset>
                            <legend>Виберіть розмір :</legend>
                            <?php foreach ($sizesList as $size => $item) { ?>
                                <div class="size_list">
                                    <input type="checkbox" id="<?= $item[1] ?>" name="size[]" value="<?= $item[1] ?>">
                                    <label for="<?= $item[1] ?>"><?= $item[1] ?></label>
                                </div>
                            <?php }; ?>
                        </fieldset>
                    </div>
                    <div class="submit_filters_box">
                        <input type="submit" name="submit" value="Відправити">
                    </div>
                </form>
            </div>
            <div class="list_product">
                <table>
                    <tr>
                        <th>Назва</th>
                        <th>Колір</th>
                        <th>Розмір</th>
                        <th></th>
                    </tr>
                    <?php foreach ($listProduct as $item) : ?>
                        <tr>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['colour'] ?></td>
                            <td><?= $item['size'] ?></td>
                            <td>
                                <button><a href="edit.php?id=<?= $item['id'] ?>">Редагувати</a></button>
                                <button><a href="delete.php?id=<?= $item['id'] ?>">Видалити</a></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div class="add_box">
                    <p>Додати нову позицію на склад  <button id="add_button"><a href="add.php">+</a></button></p>
                </div>
            </div>
        </div>
    </div>
    <div class="pagination_box">
        <table>
            <tr>
                <?php for ($page = 1; $page <= $pages; $page++) { ?>
                    <td><button data-page="<?=$page?>"><a href="http://site/filters/?page=<?= $page . $str_filter ?>"><?= $page ?></a></button></td>
                <?php } ?>
            </tr>
        </table>
    </div>
    <script src="script.js"></script>
</body>

</html>