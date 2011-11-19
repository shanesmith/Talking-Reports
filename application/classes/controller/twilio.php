<?php

class Controller_Twilio extends Controller {

	/**
	 * @var Twilio_Response
	 */
	protected $twiml;

	protected $auto_respond = true;

	public function action_index() {

		die("nuthin...");

	}

	public function action_callme() {

		Twilio::instance()->call('+16138182762', "http://63.141.238.195/twilio/main");

	}

	public function action_main() {

		if ($this->request->post()) {

			switch ($this->request->post('Digits')) {
				case '1':
					return $this->action_feed();
				case '9':
						return $this->action_hell();
				default:
					$this->twiml->say("What the hell, that wasn't even a choice, try again numb nuts.");
			}


		} else {

			$this->twiml->say("Welcome to Talking Reports!");

		}



		$gather = $this->twiml->gather(array('numDigits' => 1));

		$gather->say("Press 1 to listen to a live feed of your sales.");

		$gather->say("Press 9 to go to hell.");

	}

	public function action_feed() {

	}

	public function action_hell() {

		if ($this->request->post()) {

			$this->twiml->say("Go to hell.", array('loop' => $this->request->post('Digits')));

			$this->twiml->redirect("/twilio/main");

		} else {

			$this->twiml->gather(array('numDigits' => 1))->say('How many times would you like to go to hell?');

		}

	}

	public function before() {

		parent::before();

		$this->twiml = new Twilio_Response();

	}

	public function after() {

		if ($this->auto_respond === TRUE) {
			$this->response->headers('Content-Type', File::mime_by_ext('xml'));
			$this->response->body((string)$this->twiml);
		}

		parent::after();

	}

}
