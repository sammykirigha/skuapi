<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class ProductModel extends Database
{
    public function createProduct($name,$size, $price, $weight, $width, $length, $sku )
    {
          return $this->create("insert into products (name, size, price, weight, width, length) values ('$name', '$size', '$price', '$weight', '$width', '$length', '$sku)");
    }

	 public function getProducts($limit)
    {
        return $this->select("SELECT * FROM products ORDER BY user_id ASC LIMIT ?", ["i", $limit]);
    }
}