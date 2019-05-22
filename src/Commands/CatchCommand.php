<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\Commands;

use HighSolutions\LaravelMailerDaemonCatcher\Events\MailerDaemonMessageReceived;
use HighSolutions\LaravelMailerDaemonCatcher\Services\MailerDaemonService;
use Illuminate\Console\Command;

class CatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailer-daemon:catch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there is some mailer daemon messages';

    protected $service;

    public function __construct(MailerDaemonService $service)
    {
        parent::__construct();
        
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $messages = $this->service->checkNewMessages();
        $messages->each(function ($message) {
            event(new MailerDaemonMessageReceived($message));
        });
        $this->info('Service has found '. $messages->count() .' mailer daemon messages.');
    }
}
