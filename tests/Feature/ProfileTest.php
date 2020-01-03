<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

    }

    /** @test */

    public function a_user_can_be_retrieved()
    {

        $user = factory(User::class)->create();

        $response = $this->get('/api/user/' . $user->id . '?api_token=' . $this->user->api_token);

        $response->assertJson([

            'data' => [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]

        ]);

    }

}


