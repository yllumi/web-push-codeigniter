<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Minishlink\WebPush\VAPID;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class Push extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		$this->load->view('push/index');
	}

	public function vapid()
	{
		$vapid = VAPID::createVapidKeys();
		$this->output
			 ->set_content_type('application/json')
			 ->set_output(json_encode($vapid));
	}

	public function send()
	{
		$data = json_decode($this->input->raw_input_stream, true);
		
		$publicKey = $data['publicKey'];
		$privateKey = $data['privateKey'];
		$subscription = $data['subscription'];
		$payload = $data['payload'];

		// Decode json subscription
		$subscription = json_decode($subscription, true);
		if(json_last_error() != JSON_ERROR_NONE)
		{
			$this->output
				 ->set_content_type('application/json')
				 ->set_output(json_encode([
					'status' => 'failed',
					'message' => "Subscription JSON tidak valid."
				]));

			return;
		}

		$auth = [
            'VAPID' => [
                'subject' => base_url(),
                'publicKey' => $publicKey,
                'privateKey' => $privateKey,
            ],
        ];

		$notification = [
            'subscription' => Subscription::create($subscription),
            'payload' => $payload,
        ];

        $webPush = new WebPush($auth);

        $webPush->sendNotification(
            $notification['subscription'],
            $notification['payload']
        );

        foreach ($webPush->flush() as $report) {
            $endpoint = $report->getRequest()->getUri()->__toString();

        	$this->output->set_content_type('application/json');
            if ($report->isSuccess()) {
				$this->output->set_output(json_encode([
					'status' => 'success',
					'message' => "Message sent successfully."
				]));
            } else {
            	$this->output->set_output(json_encode([
					'status' => 'failed',
					'message' => "Message failed to sent: {$report->getReason()}"
				]));
            }

            return;
        }
	}
}
