<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\Test;

use HighSolutions\LaravelMailerDaemonCatcher\MailerDaemonServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            MailerDaemonServiceProvider::class,
        ];
    }

}
