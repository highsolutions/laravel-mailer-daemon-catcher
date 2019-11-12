<?php
/*
* File:     mailer-daemon.php
* Category: config
* Author:   HighSolutions
*/

return [

    /*
    |--------------------------------------------------------------------------
    | IMAP account for checking mailer daemon messages
    |--------------------------------------------------------------------------
    */
    'host'          => env('IMAP_HOST', env('MAIL_HOST', 'localhost')),
    'port'          => env('IMAP_PORT', env('MAIL_PORT', 993)),
    'encryption'    => env('IMAP_ENCRYPTION', env('MAIL_ENCRYPTION', 'ssl')),
    'validate_cert' => env('IMAP_VALIDATE_CERT', false),
    'username'      => env('IMAP_USERNAME', env('MAIL_USERNAME', '')),
    'password'      => env('IMAP_PASSWORD', env('MAIL_PASSWORD', '')),
    'protocol'      => env('IMAP_PROTOCOL', env('MAIL_PROTOCOL', 'imap')),

];
