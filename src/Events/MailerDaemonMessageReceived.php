<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\Events;

use HighSolutions\LaravelMailerDaemonCatcher\Models\MailerDaemonMessage;
use Illuminate\Queue\SerializesModels;

class MailerDaemonMessageReceived
{
    use SerializesModels;

	public $message;

	public function __construct(MailerDaemonMessage $message)
	{
		$this->message = $message;
	}

}
