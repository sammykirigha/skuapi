<?php
class ProductController extends BaseController
{
    /**
     * "/user/list" Endpoint - Get list of users
     */
    public function listAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
		$productModel = new ProductModel();
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                
 
                $intLimit = 15;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
 
                $arrProducts = $productModel->getProducts($intLimit);
                $responseData = json_encode($arrProducts);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }elseif(strtoupper($requestMethod) == 'POST'){
          $productModel = new ProductModel();

          
		  $sku = $_POST["sku"];
		  $name = $_POST["name"];
          $size = $_POST["size"];
          $price = $_POST["price"];
          $weight = $_POST["weight"];
          $width = $_POST["width"];
          $length = $_POST["length"];

		  $productCreated = $productModel->createProduct($sku,$name,$size,$price, $weight, $width, $length);
		  $responseData = json_encode(($productCreated));
		} else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
 
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}