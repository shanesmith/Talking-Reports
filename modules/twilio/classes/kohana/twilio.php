<?php

class Kohana_Twilio {

	protected $client;

	protected $config;

	protected static $instance;

	private function __construct() {

		$this-> config = Kohana::$config->load("twilio");

		$this->client = new Services_Twilio($this->config["AccountSid"], $this->config["AuthToken"]);

	}

	public static function instance() {
		if (!isset(self::$instance)) {
			self::$instance = new Kohana_Twilio();
		}
		return self::$instance;
	}


	public function call($number, $url) {

		$this->client->account->calls->create(
			$this->config['AppNumber'],
			$number,
			$url
		);

	}

}
