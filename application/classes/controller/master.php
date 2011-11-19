<?php
require Kohana::find_file('vendor', 'twilio/Twilio');

require Kohana::find_file('vendor', 'shopify/lib/shopify_api', 'php');

abstract class Controller_Master extends Controller_Template {
	
	public $template = 'template/default'; 	//Default template

	public function before()
	{
		//Set local var to what the template should be
		$template = $this->template;

		parent::before();
	}
}

?>
