<?php

namespace App\Services;

use App\User;
use Mailgun\Mailgun;

class MailgunService {

    private $mailgun_secret;
    private $mailgun_subscriber_list;
    private $mailgun_client;

    public function __construct()
    {
        $this->mailgun_secret = env('MAILGUN_SECRET', '');
        $this->mailgun_subscriber_list = env('MAILGUN_SUBSCRIBER_LIST', '');

        $this->mailgun_client = Mailgun::create($this->mailgun_secret);
    }

    public function addSubscriber(User $user)
    {
        $vars = array("user_id" => $user->id);

        $result = $this->mailgun_client
        ->mailingList()
        ->member()
        ->create(
            $this->mailgun_subscriber_list,
            $user->email,
            $user->name,
            $vars
        );

        return $result;
    }
}