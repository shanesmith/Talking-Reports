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

		//$who = '+16138182762';
		$who = '+16138182762';

		Twilio::instance()->call($who, "http://" . $_SERVER['SERVER_NAME'] . Kohana::$base_url . "/twilio/main");

	}

	private function menu_options() {
		$gather = $this->twiml->gather(array('numDigits' => 1));

		$gather->say("Press 1 to listen to a live feed of your sales.");

		$gather->say("Press 2 to get a count of your sales for today.");

		$gather->say("Press 9 to go to hell.");
	}

	public function action_main() {

		if ($this->request->post('Digits')) {

			switch ($this->request->post('Digits')) {
				case '1':
					$this->redirect("feed");
					break;

				case '2':
					$this->redirect("daycount");
					break;

				case '9':
					$this->redirect("hell");
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

		$session = Session::instance();

		if (!$session->get('last-order-id')) {
			$session-set('last-order-id', Controller_App::get_last_order_id());
		}

		if ($this->request->post('Digits')) {

			if ($this->request->post('Digits') == '6') {
				$this->redirect("main");
			}
			else {
				$this->twiml->say("Huh? If you want to quit, press 6.");
				$this->redirect("feed");
			}

		} else {

			$gather = $this->twiml->gather(array('numDigits' => 1, 'timeout' => 3));

			$count = Controller_App::get_orders_since($session->get('last-order-id'));

			//if ($count != 0) {
				$last_order_id = Controller_App::get_last_order_id();
				$gather->say($count . " new order! " + $last_order_id);
				$session->set('last-order-id', $last_order_id);
			//}

			$this->redirect("feed");

		}

	}

	public function action_hell() {

		if ($this->request->post('Digits')) {

			$this->twiml->say("Go to hell.", array('loop' => $this->request->post('Digits')));

			$this->redirect("main");

		} else {

			$this->twiml->gather(array('numDigits' => 1))->say('How many times would you like to go to hell?');

		}

	}

	public function action_daycount() {

		$count = Controller_App::get_daily_orders_count();

		$this->twiml->say("Your current sales count for today is: " . $count);

		$this->redirect("main");

	}

	private function redirect($where) {
		$this->twiml->redirect(Kohana::$base_url . "/twilio/" . $where);
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
