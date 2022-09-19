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

		try {
			if (strtoupper($requestMethod) == 'DELETE') {
				$productModel->deleteSelectedProducts($sku);
				$responseData = json_encode("deleted successfully ");
			} else {
				$strErrorDesc = 'Method not supported';
				$strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
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
				$sku ="";
				$name ="";
				$price ="";

				$input = (array) json_decode(file_get_contents('php://input'), TRUE);
				if (! $this->validatePost($input)) {
					return $this->unprocessableEntityResponse();
				}

				

				if (isset($input["sku"]))
					$sku = $input["sku"];
				if (isset($input["name"]))
					$name = $input["name"];
				if (isset($input["price"]))
					$price = $input["price"];
				if (isset($input["weight"]))
					$weight = $input["weight"];
				if (isset($input["width"]))
					$width = $input["width"];
				if (isset($input["length"]))
					$length = $input["length"];
				if (isset($input["height"]))
					$height = $input["height"];
				if (isset($input["size"]))
					$size = $input["size"];

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

	}


	private function validatePost($input)
	{
		if (! isset($input['sku'])) {
		return false;
		}
		if (! isset($input['name'])) {
		return false;
		}

		return true;
	}

	  private function unprocessableEntityResponse()
		{
			$response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
			$response['body'] = json_encode([
			'error' => 'Invalid input'
			]);
			return $response;
		}
}
