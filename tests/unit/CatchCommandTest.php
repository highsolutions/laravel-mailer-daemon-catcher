<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\Test\unit;

use HighSolutions\LaravelMailerDaemonCatcher\Events\MailerDaemonMessageReceived;
use HighSolutions\LaravelMailerDaemonCatcher\Test\TestCase;
use Illuminate\Support\Facades\Event;

class CatchCommandTest extends TestCase
{

    protected function execute($params = [])
    {
        return $this->artisan('mailer-daemon:catch', $params);
    }

    /** @test */
    public function nothing_happened_when_empty_mailbox()
    {
    	Event::fake();

        $this->execute();

        Event::assertNotDispatched(MailerDaemonMessageReceived::class);
    }

}
