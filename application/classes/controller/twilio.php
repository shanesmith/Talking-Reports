<?php

class Controller_Twilio extends Controller_Master {

	public function index() {

		

	}

	public function callme() {

		Twilio::instance()->call('+16138182762', "http://63.141.238.195/twilio/answered");

	}

	public function answered() {

		$this->response->say("woot");

	}



	public function before() {

		$this->reponse = new Twilio_Response();

		return parent::before();

	}

	public function after() {

		if ($this->auto_respond === TRUE) {
			$this->request->headers['Content-Type'] = File::mime_by_ext('xml');
			$this->request->response = $this->response . "";
		}

		parent::after();

	}

}
