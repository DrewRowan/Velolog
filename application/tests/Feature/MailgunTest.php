<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\MailgunService;
use App\User;

class MailgunTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddSubscriber()
    {
        $mailgunService = new MailgunService();
        $user = factory(User::class)->create();

        $response = $mailgunService->addSubscriber($user);

        $this->assertEquals($response->getMessage(), 'Mailing list member has been created');
    }
}
