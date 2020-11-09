<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/Product.php');
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Тестовое задание для PHP разработчиков. Страница списка товаров">
        <meta name="author" content="">
        <title>Тестовое задание для PHP разработчиков. Страница списка товаров</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
    <?
    $product = new Product();

    $page = 1;
    if(!empty($_GET['page'])){
        $page = (int)$_GET['page'];
    }
    if(!empty($_GET['sort'])){
        $sort = trim(strip_tags($_GET['sort']));
    }
    if(!empty($_GET['order'])){
        $order = trim(strip_tags($_GET['order']));
    }
    $products_list = $product->getProductsList($page, $sort, $order);
    ?>
    <div class="container mt-5">
        <h1>Тестовое задание для PHP разработчиков. Страница списка товаров</h1>

        <?if(!empty($product->out_msg)):?>
            <div class="row">
                <div class="alert alert-primary col-md-12">
                    <?=$product->out_msg?>
                </div>
            </div>
        <?endif;?>
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="row mb-4">
                    <div class="form-group col-md-6">
                        <label>Сортировка товаров</label>
                        <select class="form-control" id="sort">
                            <option value="id" <?=(!isset($_GET['sort']) || $_GET['sort'] == 'id') ? 'selected' : ''?>>По ID</option>
                            <option value="price" <?=$_GET['sort'] == 'price' ? 'selected' : ''?>>По цене</option>
                        </select>

                    </div>
                    <div class="form-group col-md-6">
                        <label>Направление</label>
                        <select class="form-control" id="order">
                            <option value="desc" <?=(!isset($_GET['order']) || $_GET['order'] == 'desc') ? 'selected' : ''?>>По убыванию</option>
                            <option value="asc" <?=$_GET['order'] == 'asc' ? 'selected' : ''?>>По возрастанию</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <p class="group inner list-group-item-text">Всего товаров: <strong><?=$product->total_rows?></strong></p>
            </div>
        </div>
        <div class="row mb-5">
            <?foreach($products_list as $item):?>
                <div class="col-md-4">
                    <div class="m-1  p-3 border rounded">
                        <p>Товар #<?=$item['id']?></p>
                        <h4 class="group inner list-group-item-heading"><?=$item['name']?></h4>
                        <p class="group inner list-group-item-text">Price: <strong><?=$item['price']?></strong>&nbsp;руб.</p>
                    </div>
                </div>
            <?endforeach;?>
        </div>
        <?if($product->num_pages > 1):?>
            <?
            parse_str($_SERVER['QUERY_STRING'], $params_arr);
            $params_str = '';
            foreach($params_arr as $key => $param){
                if($key == 'page'){
                    unset($params_arr[$key]);
                    continue;
                }
                $params_str .= $key . '=' . $param . '&';
            }
            ?>
            <ul class="pagination">
                <li class="page-item<?=$page == 1 ? ' disabled' : ''?>">
                    <a class="page-link" id="prev" href="/?<?=$params_str ?>page=<?=$page-1?>">Пред.</a>
                </li>
                <?for($i = 1; $i <= $product->num_pages; $i++){
                    ?>
                    <li class="page-item<?=$i==$page?' active':''?>"><a class="page-link" id="" href="/?<?=$params_str ?>page=<?=$i?>"><?=$i?></a></li>
                    <?
                }?>
                <li class="page-item<?=$page == $product->num_pages ? ' disabled' : ''?>">
                    <a class="page-link" id="next" href="/?<?=$params_str ?>page=<?=$page+1?>">След.</a>
                </li>
            </ul>
        <?endif;?>

        <div class="row pl-3 mt-5 add__product">
            <a href="/add_product.php" class="btn btn-primary">Добавить товар</a>
        </div>
    </div>

    <script>
        $(function(){
            $('#sort, #order').change(function(){
                var url = new URL(window.location.href);
                var param = this.id;
                url.searchParams.set(param, $(this).val());
                window.location.href = url;
            });
        });
    </script>
    </body>
</html>