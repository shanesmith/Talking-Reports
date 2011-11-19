<?php
require Kohana::find_file('vendor', 'twilio/Twilio');

//require Kohana::find_file('vendor', 'shopify/lib/shopify_api', 'php');
require Kohana::find_file('vendor', 'shopify', 'php');

abstract class Controller_Master extends Controller_Template {
	
	public $template = 'template/default'; 	//Default template
	public $shopify_api_key = '1530c5d5970a56fb6b7c3820df0cdea7';
	public $shopify_api_secret = 'ac9979b65a71a7654f22e3f85d38fefd';

	public function before()
	{
		//Set local var to what the template should be
		$template = $this->template;

		//Shopify
		$shopify_api_key = $this->shopify_api_key;
		$shopify_api_secret = $this->shopify_api_secret;

		parent::before();
	}
}

?>
