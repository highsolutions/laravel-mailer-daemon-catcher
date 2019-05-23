<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\Test\mocks;

use HighSolutions\LaravelMailerDaemonCatcher\Contracts\InboxReaderContract;
use Illuminate\Support\Collection;
use Webklex\IMAP\Exceptions\ConnectionFailedException;

class InboxReaderFail implements InboxReaderContract
{

	public function fetchMessages() : Collection
	{
		throw new ConnectionFailedException;
	}

}
