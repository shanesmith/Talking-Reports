<?php defined('SYSPATH') or die('No direct script access.');

class Controller_App extends Controller_Master {

	public $template = 'template/default';

	public function action_index()
	{
		$view = View::factory('app/index');
		$this->template->content = 'index page';
		$this->template->content = $view->render();
	}

	public function action_welcome(){
		$view = new View('app/home');
		$this->template->content = 'test';
		$this->response->body($view->render());
	}

	public function action_authorize(){
		$request = $this->request;
		if ($request->post()){
			//POST from the app/index page
			$shop_name = $request->post('shop_name');

			if (empty($shop_name)){
				$this->redirect('app/index');
			}else{
				//Init Shopify
				$api = new Session($shop_name, '', $shopify_api_key, $shopify_api_secret);
			}
		}else{
			//GET from Shopify
			echo 2;
		}

		$view = View::factory('app/authorize');
		$this->template->content = $view->render();
	}

} // End Welcome
