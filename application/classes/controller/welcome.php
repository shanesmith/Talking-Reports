<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Master {

	public $template = 'template/default';

	public function action_index()
	{
		$view = View::factory('welcome/test');
		$view->message = 'my message :-)';
		//$this->response->body($view->render());
		$this->template->content = $view->render();
		//$this->response->body('hello, world! - test');
	}

	public function action_foo(){
		$view = new View('default');
		$this->response->body($view->render());
	}

} // End Welcome
