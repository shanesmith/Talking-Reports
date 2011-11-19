<?php defined('SYSPATH') or die('No direct script access.');

class Controller_App extends Controller_Master {

	public $template = 'template/default';
	public $shopify_api_key = '1530c5d5970a56fb6b7c3820df0cdea7';
	public $shopify_api_secret = 'ac9979b65a71a7654f22e3f85d38fefd';

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
		$view = View::factory('app/dashboard');
		$view->shop_name = $session['Shopify.shop'];
		$this->template->content = $view->render();
	}

} // End Welcome
