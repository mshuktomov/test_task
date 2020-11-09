<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/Product.php');
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Тестовое задание для PHP разработчиков. Страница добавления товара">
    <meta name="author" content="">
    <title>Тестовое задание для PHP разработчиков. Страница добавления товара</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container mt-5">

        <h1>Тестовое задание для PHP разработчиков. Страница добавления товара</h1>
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['name']) && !empty($_POST['price'])) {

                $product = new Product();

                if ($product->addProduct($_POST['name'], $_POST['price'])) {
                    ?>
                    <div class="row">
                        <div class="alert alert-primary" role="alert">
                            <?= $product->out_msg ?>
                        </div>
                    </div>
                    <?
                }
            }
        }
        ?>

        <div class="row mb-5">

            <form class="text-center border border-light p-5" method='post' action="">

                <p class="h4 mb-4">Форма добавления товара</p>

                <input type="text" name='name' id="product__name" class="form-control mb-4" placeholder="Наименование товара" required>
                <input type="text" name='price' id="product__price" class="form-control mb-4" placeholder="Цена, руб." required>

                <button class="btn btn-primary my-4" type="submit">Добавить</button>

                <p><a class='' href="/index.php">Вернуться к списку товаров</a></p>

            </form>
        </div>
    </div>
</body>
</html>
