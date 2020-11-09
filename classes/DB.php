<?php
/**
 * Created by PhpStorm.
 * User: mshuktomov
 * Date: 06.11.2020
 * Time: 16:35
 */

class DB{

    public $mysqli;

    public function connectDb(){
        $this->mysqli = new mysqli(
            'localhost',
            'developer_test',
            'bAOgbVGxD9',
            'developer_test'
        );

        $this->mysqli->set_charset("utf8");

        return $this->mysqli;
    }

}
