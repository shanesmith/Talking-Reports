<?php

class Controller_Twilio extends Controller {

	/**
	 * @var Twilio_Response
	 */
	protected $twiml;

	public function action_index() {

		die("nuthin...");

	}

	public function action_callme() {

		Twilio::instance()->call('+16138182762', "http://63.141.238.195/twilio/answered");

	}

	public function action_answered() {

		$this->twiml->say("woot");

	}

	public function before() {

		parent::before();

		$this->twiml = new Twilio_Response();

	}

	public function after() {

		if ($this->auto_respond === TRUE) {
			$this->request->headers['Content-Type'] = File::mime_by_ext('xml');
			$this->request->response = (string)$this->twiml;
		}

		parent::after();

	}

}
