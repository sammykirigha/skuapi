<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");

require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);


if((isset($uri[3]) && $uri[3] == 'products')) {
    
    require PROJECT_ROOT_PATH . "/Controller/Api/ProductController.php";
    //  products Routes
    $productFeedController = new ProductController();
    if((isset($uri[4]) && $uri[4] == 'create-product')){
        $productFeedController->createProducts();
    }else  if ((isset($uri[4]) && $uri[4] == 'list')) {
        $productFeedController->listAction();
    }else  if (((isset($uri[4]) && $uri[4] == 'delete') && isset($uri[5]))) {
        $productFeedController->deleteSelectedProducts($uri[5]);
    } else {
        header("HTTP/1.1 404 Not Found");
        exit();
    }
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}
