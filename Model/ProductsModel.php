<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class ProductModel extends Database
{
    public function createProduct($name, $size, $price, $weight, $width, $length, $sku, $height)
    {
        return $this->create("insert into products (name, size, price, weight, width, length, sku,  height) values ('$name', '$size', '$price', '$weight', '$width', '$length', '$sku', '$height' )");
    }

    public function deleteSelectedProducts($sku)
    {
        $query = "DELETE FROM products WHERE sku = '$sku'";
        return $this->delete($query);
    }

    public function getProducts($limit)
    {
        return $this->select("SELECT * FROM products ORDER BY id ASC LIMIT ?", ["i", $limit]);
    }
}
