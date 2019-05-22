Laravel Mailer Daemon Cather
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
        "HighSolutions/laravel-mailer-daemon-catcher": "*"
    }
```

And run `composer update` to install the package.

Then, if you are using Laravel <= 5.4, update `config/app.php` by adding an entry for the service provider:

```php
'providers' => [
    // ...
    HighSolutions\LaravelMailderDaemonCatcher\MailerDaemonServiceProvider::class,
];
```


Configuration
------------

| Name                             | Description                                                                                | Default                                              |
|----------------------------------|--------------------------------------------------------------------------------------------|------------------------------------------------------|


Usage
------------

Testing
---------

Run the tests with:

``` bash
vendor/bin/phpunit
```

Changelog
---------

1.0.0
* Basic version

Credits
-------

This package is developed by [HighSolutions](https://highsolutions.org), software house from Poland in love in Laravel.
