<?php
require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);


if ((isset($uri[3]) && $uri[3] == 'user')) {
    require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
    //  Users Routes
    $userFeedController = new UserController();
    if ((isset($uri[4]) && $uri[4] == 'list')) {
        $userFeedController->listAction();
    } else {
        header("HTTP/1.1 404 Not Found");
        exit();
    }
} else if ((isset($uri[3]) && $uri[3] == 'products')) {
    require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
    //  Users Routes
    $userFeedController = new UserController();
    if ((isset($uri[4]) && $uri[4] == 'all')) {
        $userFeedController->listAction();
    } else {
        header("HTTP/1.1 404 Not Found");
        exit();
    }
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}
 
 


// Products Routes
