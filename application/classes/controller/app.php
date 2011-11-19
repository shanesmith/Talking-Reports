<?php defined('SYSPATH') or die('No direct script access.');

class Controller_App extends Controller_Master {

	public $template = 'template/default';
	public $shopify_api_key = '1530c5d5970a56fb6b7c3820df0cdea7';
	public $shopify_api_secret = 'ac9979b65a71a7654f22e3f85d38fefd';
	public static $shopify_token = 'd555c4d994b096b633be31b9644d05ae';
	public static $shopify_shop = 'hudson-dickinson-and-rohan4127.myshopify.com';

	public function action_index()
	{
		$view = View::factory('app/index');
		$this->template->content = 'index page';
		$this->template->content = $view->render();
	}

	public function action_welcome(){
		$view = new View('app/home');
		$this->template->content = 'test1';
		$this->response->body($view->render());
	}

	public function action_authorize(){
		$request = $this->request;
		if ($request->post()){
			//POST from the app/index page
			$shop_name = $request->post('shop_name');

			if (empty($shop_name)){
				$request->redirect('app/index');
			}else{
				//Shopify install URL
				$url = shopify_app_install_url($shop_name, $this->shopify_api_key);

				$request->redirect($url);
				exit();
			}
		}else{
			//GET from Shopify
			//Validate install
			$request = $this->request;

			//Grab data from GET
			$shop = $request->query('shop');
			$token = $request->query('t');
			$timestamp = $request->query('timestamp');
			$signature = $request->query('signature');

			$app_installed = shopify_is_app_installed($shop, $token, $timestamp, $signature, $this->shopify_api_secret);

			if (!$app_installed){
				$content = 'The app is not installed';
			}else{
				//Store info in session
				$session = Session::instance();
				$session->set('Shopify.shop', $shop);
				$session->set('Shopify.token', $token);
				$session->set('Shopify.signature', $signature);

				//Redirect to dashboard
				$request->redirect('app/dashboard');
			}
			die();
		}

		$view = View::factory('app/authorize');
		$this->template->content = $view->render();
	}

	public function action_dashboard(){
		$session = Session::instance()->as_array();
		$key = get_shopify_api_key();
		$secret = get_shopify_api_secret();
		$shop = self::$shopify_shop;
		$token = self::$shopify_token;

		$shopify = shopify_api_client($shop, $token, $key, $secret);

		try {
			echo Controller_App::get_daily_sales();
			//Daily orders
			$daily_orders = $this->get_daily_orders();

			$grand_total = 0;
			foreach($daily_orders as $k => $order){
				$qty = $order['line_items'][0]['quantity'];
				$price = $order['line_items'][0]['price'];
				$total_before_tax = $order['total_line_items_price'];
				$total_price = $order['total_price'];
				$id = $order['id'];

/*
				echo $id . "<br />";
				echo Controller_App::get_orders_since($id);
				echo '<br />';
				*/

				$grand_total += $total_price;
			}

			//echo $grand_total;

			
			//Daily count of orders
			//$order_count = Controller_App::get_daily_orders_count();
			$last_order = Controller_App::get_last_order_id();
			exit();

			//Daily count of open orders
			$open_orders_count = $this->_get_daily_orders_count('status', 'open');

			//Daily count of closed orders
			$closed_orders_count = $this->_get_daily_orders_count('status', 'closed');
			//print_r($closed_orders_count);

			//Get products
			$products = $shopify('GET', '/admin/products.json', array('published_status' => 'published'));
			//print_r($products);

			//echo "You have {$today_order_count} orders today";
			die();
		} catch (ShopifyApiException $e) {
			echo '<pre>';
			print_r($e);
			echo '</pre>';
		}

		$view = View::factory('app/dashboard');
		$view->shop_name = $session['Shopify.shop'];
		$this->template->content = $view->render();
	}

	public static function get_daily_sales(){
		$orders = Controller_App::get_daily_orders();

		$grand_total = 0;
		foreach($orders as $k => $order){
			$qty = $order['line_items'][0]['quantity'];
			$price = $order['line_items'][0]['price'];
			$total_before_tax = $order['total_line_items_price'];
			$total_price = $order['total_price'];
			$id = $order['id'];

			$grand_total += $total_price;
		}

		echo $grand_total;

	}

	public static function get_daily_orders($method = '', $param = ''){
		$session = Session::instance()->as_array();
		$key = get_shopify_api_key();
		$secret = get_shopify_api_secret();
		$shop = self::$shopify_shop;
		$token = self::$shopify_token;

		$shopify = shopify_api_client($shop, $token, $key, $secret);

		try {
			//Get daily sales - orders since 00:00:00 until 11:59:59
			$from_date = date('Y-m-d');
			$to_date = date('Y-m-d');

			$api_url = "/admin/orders.json?created_at_min={$from_date}T00:00:00-05:00";

			if ($method !== ''){
				$api_url .= "&{$method}={$param}";
			}

			$today_orders = $shopify('GET', $api_url);

			return $today_orders;

			return json_encode(array('response' => $today_orders));
		} catch (ShopifyApiException $e) {
			echo '<pre>';
			print_r($e);
			echo '</pre>';
		}
	}

	public static function get_last_order_id(){
		$session = Session::instance()->as_array();
		$key = get_shopify_api_key();
		$secret = get_shopify_api_secret();
		$shop = self::$shopify_shop;
		$token = self::$shopify_token;

		$shopify = shopify_api_client($shop, $token, $key, $secret);

		try {
			//Get daily sales - orders since 00:00:00 until 11:59:59
			$from_date = date('Y-m-d');
			$to_date = date('Y-m-d');

			$api_url = "/admin/orders.json?limit=1";


			$last_order = $shopify('GET', $api_url);

			return $last_order[0]['id'];

		} catch (ShopifyApiException $e) {
			echo '<pre>';
			print_r($e);
			echo '</pre>';
		}
	}

	public static function get_orders_since($id){
		$session = Session::instance()->as_array();
		$key = get_shopify_api_key();
		$secret = get_shopify_api_secret();
		$shop = self::$shopify_shop;
		$token = self::$shopify_token;

		$shopify = shopify_api_client($shop, $token, $key, $secret);

		try {

			$id = '96433502';
			$api_url = "/admin/orders/count.json?since_id={$id}";
			$last_order = $shopify('GET', $api_url);

			return $last_order;

		} catch (ShopifyApiException $e) {
			echo '<pre>';
			print_r($e);
			echo '</pre>';
		}
	}

	public static function get_daily_orders_count($method = '', $param = ''){
		$session = Session::instance()->as_array();
		$key = get_shopify_api_key();
		$secret = get_shopify_api_secret();
		$shop = self::$shopify_shop;
		$token = self::$shopify_token;

		$shopify = shopify_api_client($shop, $token, $key, $secret);

		try {
			//Get daily sales - orders since 00:00:00 until 11:59:59
			$from_date = date('Y-m-d');
			$to_date = date('Y-m-d');

			$api_url = "/admin/orders/count.json?created_at_min={$from_date}T00:00:00-05:00";

			if ($method !== ''){
				$api_url .= "&{$method}={$param}";
			}

			$today_order_count = $shopify('GET', $api_url);

			return $today_order_count;

		} catch (ShopifyApiException $e) {
			echo '<pre>';
			print_r($e);
			echo '</pre>';
		}
	}

} // End Welcome
