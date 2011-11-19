<?php
	function pluralize($number, $string){
		if ($number > 1 || $number == 0){
			return "{$string}s";
		} else {
			return $string;
		}
	}

	function get_shopify_api_key(){
		return '1530c5d5970a56fb6b7c3820df0cdea7';
	}

	function get_shopify_api_secret(){
		return 'ac9979b65a71a7654f22e3f85d38fefd';
	}

/*
	function appcall($method, $path, $params = array(), &$response_headers = array()){
		$baseurl = 'http://fog-smudel.localhost';
		//$url = $baseurl.ltrim($path, '/');
		$url = $baseurl.$path;
		$query = in_array($method, array('GET','DELETE')) ? $params : array();
		$payload = in_array($method, array('POST','PUT')) ? stripslashes(json_encode($params)) : array();
		$request_headers = in_array($method, array('POST','PUT')) ? array("Content-Type: application/json; charset=utf-8", 'Expect:') : array();

		$response = curl_http_api_request_($method, $url, $query, $payload, $request_headers, $response_headers);
		$response = json_decode($response, true);

		if (isset($response['errors']) or ($response_headers['http_status_code'] >= 400))
			throw new ShopifyApiException(compact('method', 'path', 'params', 'response_headers', 'response', 'shops_myshopify_domain', 'shops_token'));

		return (is_array($response) and (count($response) > 0)) ? array_shift($response) : $response;
	}
	*/
?>
