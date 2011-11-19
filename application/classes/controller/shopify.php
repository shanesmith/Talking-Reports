<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Shopify extends Controller_Master {

	public $template = 'template/default';
	public $shopify_api_key = '1530c5d5970a56fb6b7c3820df0cdea7';
	public $shopify_api_secret = 'ac9979b65a71a7654f22e3f85d38fefd';

	public function action_get_daily_order_count(){
		$session = Session::instance()->as_array();

		$shopify = shopify_api_client($session['Shopify.shop'], $session['Shopify.token'], $this->shopify_api_key, $this->shopify_api_secret);

		try {
			//Get daily sales - orders since 00:00:00 until 11:59:59
			$from_date = date('Y-m-d');
			$to_date = date('Y-m-d');

			$today_order_count = $shopify('GET', "/admin/orders/count.json?created_at_min={$from_date}T00:00:00-05:00");

			echo json_encode(array('response' => $today_order_count)); exit();
		} catch (ShopifyApiException $e) {
			print_r($e);
		}
		exit();
	}
}
?>
