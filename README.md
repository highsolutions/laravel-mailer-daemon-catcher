Laravel Mailer Daemon Catcher
================

 [![License: MIT](https://img.shields.io/badge/License-MIT-brightgreen.svg?style=flat-square)](https://opensource.org/licenses/MIT)

Singalizing that sent e-mail cannot be delivered to the recipient.

![Laravel-Mailer Daemon Catcher by HighSolutions](https://raw.githubusercontent.com/highsolutions/laravel-mailer-daemon-catcher/master/intro.jpg)

Installation
------------

This package can be installed through Composer:

```bash
composer require highsolutions/laravel-mailer-daemon-catcher
```

Or by adding the following line to the `require` section of your Laravel webapp's `composer.json` file:

```javascript
    "require": {
        "highsolutions/laravel-mailer-daemon-catcher": "^2.0"
    }
```

And run `composer update` to install the package.

Usage
------------

Check IMAP inbox
========================

To check is any unseen Mailer Daemon message in the inbox, execute this command:

```bash
    php artisan mailer-daemon:catch
```

Package gets configuration from `config/mail.php`.

We recommend add this command to `app/Console/Kernel.php` for scheduling this task:

```php
	$schedule->command('mailer-daemon:catch')->hourly();
```

Handle Mailer Daemon messages
========================

When command finds new messages, it will fire a `HighSolutions\LaravelMailderDaemonCatcher\Events\MailerDaemonMessageReceived` event.

To capture this event create a listener for this event in `App/Providers/EventServiceProvider.php`:

```php
	protected $listen = [
		'HighSolutions\LaravelMailderDaemonCatcher\Events\MailerDaemonMessageReceived' => [
			'App\Listeners\MailerDaemonMessageListener',
		],
	];
```

In that example create a listener in `app/Listeners/MailerDaemonMessageListener.php` e.g.:

```php
<?php

namespace App\Listeners;

use HighSolutions\LaravelMailderDaemonCatcher\Events\MailerDaemonMessageReceived;

class MailerDaemonMessageListener
{

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \HighSolutions\LaravelMailderDaemonCatcher\Events\MailerDaemonMessageReceived  $event
     * @return void
     */
    public function handle(MailerDaemonMessageReceived $event)
    {
        // Access the message using $event->message...
    }
}
```

Testing
---------

Run the tests with:

``` bash
vendor/bin/phpunit
```

Changelog
---------

2.2.0
* Support Laravel 12.x

2.1.0
* Support multiple folders, not only INBOX
* Fix bug with reading date from emails

2.0.0
* Support Laravel 9.x, 10.x, and 11.x and Webklex/IMAP ^5.3

1.6.0
* Last version supporting Webklex/IMAP ^1.6

1.4.0
* Support Laravel 7.x and 8.x

1.3.0
* Change method to withdraw the recipient and subject method
* FIX - Error concerning connection failure catched all exceptions

1.2.0
* Add custom config for more detailed configuration

1.1.0
* Support Laravel 6.0

1.0.0
* Basic version

Credits
-------

This package is developed by [HighSolutions](https://highsolutions.org), software house from Poland in love in Laravel.
