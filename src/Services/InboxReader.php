<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\Services;

use HighSolutions\LaravelMailerDaemonCatcher\Contracts\InboxReaderContract;
use HighSolutions\LaravelMailerDaemonCatcher\Models\MailerDaemonMessage;
use Illuminate\Support\Collection;
use Webklex\IMAP\Facades\Client;

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
		$client = Client::account('default');
		$client->connect();

		return $client;
	}

	protected function findMessages($client)
	{
		$return = [];

		$folders = $client->getFolders();
		
		foreach($folders as $folder){
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
		}

		return $return;
	}

	protected function isMailerDaemonMessage($message)
	{
		$senderEmail = $message->from[0]->mail;
		return stripos($senderEmail, 'Mailer-Daemon@') !== false;
	}

}
