<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class ProductModel extends Database
{
    public function createProducts()
    {
		  $name = $_POST["name"];
          $size = $_POST["size"];
          $price = $_POST["price"];
          $weight = $_POST["weight"];
          $width = $_POST["width"];
          $length = $_POST["length"];
        return $this->create("insert into products (name, size, price, weight, width, length) values ('$name', '$size', '$price', '$weight', '$width', '$length')");
    }
}