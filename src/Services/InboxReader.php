<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\Services;


use HighSolutions\LaravelMailerDaemonCatcher\Contracts\InboxReaderContract;
use HighSolutions\LaravelMailerDaemonCatcher\Models\MailerDaemonMessage;
use Illuminate\Support\Collection;
use Webklex\IMAP\Client;

class InboxReader implements InboxReaderContract
{
	
	public function fetchMessages() : Collection
	{
		$client = $this->connect();
		$messages = $this->findMessages($client);
		return collect($messages);
	}

	protected function connect()
	{
		$client = new Client([
		    'host'          => config('mail.host'),
		    'port'          => 993,
		    'encryption'    => config('mail.encryption'),
		    'validate_cert' => true,
		    'username'      => config('mail.username'),
		    'password'      => config('mail.password'),
		    'protocol'      => 'imap'
		]);

		$client->connect();

		return $client;
	}

	protected function findMessages($client)
	{
		$return = [];

		$folder = $client->getFolder('INBOX');

		$messages = $folder->query()
			->unseen()
			->whereText('Daemon')
			->get();

		foreach($messages as $message)
		{
			if(! $this->isMailerDaemonMessage($message))
				continue;

			$return []= MailerDaemonMessage::createFromIMAP($message);
		}

		return $return;
	}

	protected function isMailerDaemonMessage($message)
	{
		$senderEmail = $message->from[0]->mail;
		return stripos($senderEmail, 'Mailer-Daemon@') !== false;
	}

}
