<?php

namespace HighSolutions\LaravelMailerDaemonCatcher\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MailerDaemonMessage extends Model
{

	protected $fillable = ['from', 'to', 'date', 'subject', 'body'];

	public static function createFromIMAP($message)
	{
		preg_match_all('/To: (.+)\\r\\n/m', $message->getTextBody(), $recipient, PREG_SET_ORDER, 0);
		preg_match_all('/Date: (.+)\\r\\n/m', $message->getHeader(), $date, PREG_SET_ORDER, 0);
		preg_match_all('/Subject: (.+)\\r\\n/m', $message->getTextBody(), $subject, PREG_SET_ORDER, 0);

		return new static([
			'from' => $message->to[0]->mail,
			'to' => $recipient[0][1],
			'date' => Carbon::parse($date[0][1]),
			'subject' => iconv_mime_decode($subject[0][1], 0, "UTF-8"),
			'body' => $message->bodies['text']->content,
		]);
	}

}
