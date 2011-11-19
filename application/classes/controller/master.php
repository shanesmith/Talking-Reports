<?php
require Kohana::find_file('vendor', 'twilio/twilio');

abstract class Controller_Master extends Controller_Template
	{
		public $template = 'template/default'; 	//Default template

		require Kohana::find_file();

		public function before()
		{
			//Set local var to what the template should be
			$template = $this->template;

			parent::before();
		}
	}

?>
