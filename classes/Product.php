<?php
/**
 * Created by PhpStorm.
 * User: mshuktomov
 * Date: 06.11.2020
 * Time: 16:27
 */

require_once 'DB.php';

class Product
{

    public $mysqli;

    public $id;
    public $name;
    public $price;

    public $per_page = 3; //количество товаров на странице
    public $total_rows; //общее количество товаров
    public $num_pages; //количество страниц пагинации

    public $sort; //сортировка
    public $order; //порядок (убывание, возрастание)

    public $out_msg = '';

    public function __construct(){
        $connect_db = new DB;
        $this->mysqli = $connect_db->connectDb();
    }

    public function addProduct($name, $price){
        if(!empty($name) && !empty($price)) {
            $this->name = trim(strip_tags($name));
            $this->price = (int)$price;
            if (!$this->mysqli->query("INSERT INTO products ( name, price	) VALUES ('" . $this->name . "', '" . $this->price . "')")) {
                $this->out_msg .= $this->mysqli->errno . ' - ' . $this->mysqli->error . PHP_EOL;
                return false;
            } else {
                $this->id = $this->mysqli->insert_id;
                $this->out_msg .= 'Товар ' . $this->name . ' (цена: '. $this->price .'руб.)' . ' успешно добавлен. ID товара: #' . $this->id . PHP_EOL ;
            }
            return true;
        }else{
            return false;
        }
    }
    public function getProductsList($page = 1, $sort = 'id', $order = 'desc'){
        
        $count_result = $this->mysqli->query('SELECT COUNT(*) FROM products');

        if($count_row = $count_result->fetch_row()){
            $this->total_rows = (int)$count_row[0];
        }
        $this->num_pages = (int)ceil($this->total_rows/$this->per_page);

        if($this->total_rows < 1){
            $this->out_msg .= 'В каталоге отсутствуют товары' . PHP_EOL;
        }
        if($page > $this->num_pages)
            $page = 1;

        $limit = $this->per_page * ($page - 1);

        if($sort != 'price')$this->sort = 'id';
        else $this->sort = 'price';
        if($order !='asc')$this->order = 'desc';
        else $this->order = 'asc';

        if(!$result = $this->mysqli->query("SELECT * FROM products ORDER BY " . $this->sort . " " . $this->order . " LIMIT " . $limit . "," . $this->per_page )){
            $this->out_msg .= $this->mysqli->errno . ' - ' . $this->mysqli->error . PHP_EOL;
            return false;
        }
        while ($row = $result->fetch_assoc()) {
            $products_list[] = $row;
        }
        return $products_list;
    }

}