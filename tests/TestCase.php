<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\tests;

use HighSolutions\LaravelMailerDaemonCatcher\Contracts\InboxReaderContract;
use HighSolutions\LaravelMailerDaemonCatcher\MailerDaemonServiceProvider;
use HighSolutions\LaravelMailerDaemonCatcher\tests\mocks\InboxReaderMock;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            MailerDaemonServiceProvider::class,
        ];
    }

    public function setUp(): void
    {
    	parent::setUp();

        app()->bind(InboxReaderContract::class, InboxReaderMock::class);

        config([
        	'imap' => include 'vendor/webklex/laravel-imap/src/config/imap.php',
	    ]);
    }

}
