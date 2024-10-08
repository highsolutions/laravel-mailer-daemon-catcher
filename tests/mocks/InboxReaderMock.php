<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\tests\mocks;

use HighSolutions\LaravelMailerDaemonCatcher\Contracts\InboxReaderContract;
use HighSolutions\LaravelMailerDaemonCatcher\Models\MailerDaemonMessage;
use Illuminate\Support\Collection;

class InboxReaderMock implements InboxReaderContract
{
	
	public $messages = [];
	protected $stubPath = 'tests/stubs/messages.php';

	public function __construct()
	{
		$this->messages = $this->initMessagesFromStub();
	}

	public function fetchMessages() : Collection
	{
		return collect($this->messages);
	}

	protected function initMessagesFromStub()
	{
		if(! file_exists($this->stubPath))
			return [];

		$messages = include $this->stubPath;
		if(! is_array($messages))
			return [];

		$return = [];
		foreach($messages as $message) {
			$return []= (new MailerDaemonMessage)->fill($message);
		}
		
		@unlink($this->stubPath);

		return $return;
	}

	public function addMessages($data)
	{
        $this->ensureDirectoryExists(dirname($this->stubPath));
        
		file_put_contents($this->stubPath, "<?php\n\nreturn " . var_export($data, true) . ";\n");
	}

    protected function ensureDirectoryExists($directory)
    {
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

}
