<?php defined('SYSPATH') or die('No direct script access.');

class Controller_App extends Controller_Master {

	public $template = 'template/default';

	public function action_index()
	{
		$view = View::factory('app/index');
		$this->template->content = $view->render();
	}

	public function action_welcome(){
		$view = new View('app/home');
		$this->template->content = 'test';
		$this->response->body($view->render());
	}

} // End Welcome
