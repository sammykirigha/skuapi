<?php
class ProductController extends BaseController
{
	/**
	 * "/product/list" Endpoint - Get list of products
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
				$strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
				$strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
			}
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
			$this->sendOutput(
				json_encode(array('error' => $strErrorDesc)),
				array('Content-Type: application/json', $strErrorHeader)
			);
		}
	}

	public function deleteSelectedProducts($sku)
	{
		$strErrorDesc = '';
		$requestMethod = $_SERVER["REQUEST_METHOD"];
		$productModel = new ProductModel();

		echo strtoupper($requestMethod);

		try {
			if (strtoupper($requestMethod) == 'delete') {
				$productModel->deleteSelectedProducts($sku);
				$responseData = json_encode("deleted successfully ");
			} else {
				$strErrorDesc = 'Method not supported';
				$strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		// send output
		if (!$strErrorDesc) {
			$this->sendOutput(
				$responseData,
				array('Content-Type: application/json', 'HTTP/1.1 200 OK')
			);
		} else {
			$this->sendOutput(
				json_encode(array('error' => $strErrorDesc)),
				array('Content-Type: application/json', $strErrorHeader)
			);
		}
	}

	public function createProducts()
	{
		$strErrorDesc = '';
		$requestMethod = $_SERVER["REQUEST_METHOD"];
		$productModel = new ProductModel();
		try {
			if (strtoupper($requestMethod) == 'POST') {
				$productModel = new ProductModel();
				$weight = null;
				$width = null;
				$length = null;
				$height = null;
				$size = null;

				$sku = $_POST["sku"];
				$name = $_POST["name"];
				$price = $_POST["price"];

				if (isset($_POST["weight"]))
					$weight = $_POST["weight"];
				if (isset($_POST["width"]))
					$width = $_POST["width"];
				if (isset($_POST["length"]))
					$length = $_POST["length"];
				if (isset($_POST["height"]))
					$height = $_POST["height"];
				if (isset($_POST["size"]))
					$size = $_POST["size"];

				$productModel->createProduct($name, $size, $price, $weight, $width, $length, $sku, $height);
				$responseData = json_encode("product created");
				if (!$responseData) {
					return json_decode("sku must be unique");
				}
			} else {
				$strErrorDesc = 'Method not supported';
				$strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}


		// send output
		if (!$strErrorDesc) {
			$this->sendOutput(
				$responseData,
				array('Content-Type: application/json', 'HTTP/1.1 200 OK')
			);
		} else {
			$this->sendOutput(
				json_encode(array('error' => $strErrorDesc)),
				array('Content-Type: application/json', $strErrorHeader)
			);
		}
	}

	function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}
