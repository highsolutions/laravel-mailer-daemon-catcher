<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\tests\unit;

use Carbon\Carbon;
use HighSolutions\LaravelMailerDaemonCatcher\Contracts\InboxReaderContract;
use HighSolutions\LaravelMailerDaemonCatcher\Events\MailerDaemonMessageReceived;
use HighSolutions\LaravelMailerDaemonCatcher\tests\TestCase;
use HighSolutions\LaravelMailerDaemonCatcher\tests\mocks\InboxReaderFail;
use Illuminate\Support\Facades\Event;

class CatchCommandTest extends TestCase
{

    protected function execute($params = [])
    {
        return $this->artisan('mailer-daemon:catch', $params);
    }

    protected function getInbox()
    {
    	return resolve(InboxReaderContract::class);
    }

    /** @test */
    public function nothing_happened_when_empty_mailbox()
    {
    	Event::fake();

        $this->execute();

        Event::assertNotDispatched(MailerDaemonMessageReceived::class);
    }

    /** @test */
    public function one_message_in_inbox()
    {
    	$this->getInbox()->addMessages([
    		[
	    		'from' => 'john@example.com',
	    		'to' => 'jane@example.com',
	    		'date' => Carbon::parse('2019-05-23 13:38:10'),
	    		'subject' => 'Test message',
	    		'body' => 'Some plain text content'
	    	],
	    ]);

    	Event::fake();

        $this->execute();

        Event::assertDispatched(MailerDaemonMessageReceived::class, function ($event) {
        	$message = $event->message;
        	return $message->from == 'john@example.com' &&
        		$message->to == 'jane@example.com' &&
        		$message->date->format('Y-m-d H:i:s') == '2019-05-23 13:38:10' &&
        		$message->subject == 'Test message' &&
        		$message->body == 'Some plain text content';
        });
    }

    /** @test */
    public function two_messages_in_inbox()
    {
    	$this->getInbox()->addMessages([
    		[
	    		'from' => 'john@example.com',
	    	],
    		[
	    		'from' => 'jane@example.com',
	    	],
	    ]);

    	Event::fake();

        $this->execute();

        Event::assertDispatched(MailerDaemonMessageReceived::class, 2);
    }

    /** @test */
    public function no_error_when_email_config_is_invalid()
    {
        app()->bind(InboxReaderContract::class, InboxReaderFail::class);

        $this->execute()        
            ->expectsOutput('Couldn\'t connect to the e-mail inbox. Please check your e-mail configuration.')
            ->assertExitCode(0);
    }

}
