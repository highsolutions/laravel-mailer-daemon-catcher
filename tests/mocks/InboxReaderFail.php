<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\tests\mocks;

use HighSolutions\LaravelMailerDaemonCatcher\Contracts\InboxReaderContract;
use Illuminate\Support\Collection;

class InboxReaderFail implements InboxReaderContract
{

	public function fetchMessages() : Collection
	{
		throw new \Exception;
	}

}
