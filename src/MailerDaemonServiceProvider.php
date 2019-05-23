<?php

namespace HighSolutions\LaravelMailerDaemonCatcher;

use HighSolutions\LaravelMailerDaemonCatcher\Commands\CatchCommand;
use HighSolutions\LaravelMailerDaemonCatcher\Contracts\InboxReaderContract;
use HighSolutions\LaravelMailerDaemonCatcher\Services\InboxReader;
use HighSolutions\LaravelMailerDaemonCatcher\Services\MailerDaemonService;
use Illuminate\Support\ServiceProvider;

class MailerDaemonServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->_serviceRegister();

        $this->_commandsRegister();
    }

    private function _serviceRegister()
    {
        $this->app->singleton(InboxReaderContract::class, function ($app) {
            return new InboxReader;
        });
    }

    private function _commandsRegister()
    {
        foreach ($this->commandsList() as $name => $class) {
            $this->initCommand($name, $class);
        }
    }

    protected function commandsList()
    {
        return [
            'catch' => CatchCommand::class,
        ];
    }

    private function initCommand($name, $class)
    {
        $this->app->singleton($class, function ($app) use ($class) {
            return new $class(new MailerDaemonService(resolve(InboxReaderContract::class)));
        });

        $this->commands($class);
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }
}
