<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\Contracts;

use Illuminate\Support\Collection;

interface InboxReaderContract
{

	public function fetchMessages() : Collection;

}
