<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\Services;

use HighSolutions\LaravelMailerDaemonCatcher\Contracts\InboxReaderContract;

class MailerDaemonService
{
	
	protected $inbox;

	public function __construct(InboxReaderContract $inbox)
	{
		$this->inbox = $inbox;
	}

	public function checkNewMessages()
	{
		return $this->inbox->fetchMessages();
	}

}
