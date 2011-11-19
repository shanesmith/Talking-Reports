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

		Twilio::instance()->call('+16138182762', "http://" . $_SERVER['SERVER_NAME'] . Kohana::$base_url . "/twilio/main");

	}

	private function menu_options() {
		$gather = $this->twiml->gather(array('numDigits' => 1));

		$gather->say("Press 1 to listen to a live feed of your sales.");

		$gather->say("Press 9 to go to hell.");
	}

	public function action_main() {

		if ($this->request->post('Digits')) {

			switch ($this->request->post('Digits')) {
				case '1':
					$this->twiml->redirect(Kohana::$base_url . '/twilio/feed');
					break;

				case '9':
					$this->twiml->redirect(Kohana::$base_url . '/twilio/hell');
					break;

				default:
					$this->twiml->say("What the hell, that wasn't even a choice, try again numb nuts.");
					$this->menu_options();
					break;
			}


		} else {

			$this->twiml->say("Welcome to Talking Reports!");
			$this->menu_options();

		}

	}

	public function action_feed() {

		if ($this->request->post('Digits')) {

			if ($this->request->post('Digits') == '#') {
				$this->twiml->redirect(Kohana::$base_url . "/twilio/main");
			}
			else {
				$this->twiml->say("Huh? If you want to quit, press the pound key.");
				$this->twiml->redirect(Kohana::$base_url . "/twilio/feed");
			}

		} else {

			$this->twiml->say("feed");

			$gather = $this->twiml->gather(array('numDigits' => 1, 'timeout' => 3));

			if (rand(1,5) == 5) {
				$gather->say("Cha-Ching.");
			}

		}

	}

	public function action_hell() {

		if ($this->request->post('Digits')) {

			$this->twiml->say("Go to hell.", array('loop' => $this->request->post('Digits')));

			$this->twiml->redirect(Kohana::$base_url . "/twilio/main");

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
