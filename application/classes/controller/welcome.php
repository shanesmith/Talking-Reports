<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
		$this->response->body('hello, world! - test');
	}

	public function action_foo(){
		$this->response->body('test foo bar');
	}

} // End Welcome
