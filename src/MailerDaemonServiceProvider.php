<?php

namespace HighSolutions\LaravelMailerDaemonCatcher;

use Illuminate\Support\ServiceProvider;
use HighSolutions\LaravelMailerDaemonCatcher\Commands\CatchCommand;
use HighSolutions\LaravelMailerDaemonCatcher\Services\MailerDaemonService;

class MailerDaemonServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->_commandsRegister();
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
            return new $class(new MailerDaemonService);
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
