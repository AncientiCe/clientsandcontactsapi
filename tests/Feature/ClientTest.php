<?php

namespace Tests\Feature;

use App\Client;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ClientTest extends TestCase
{
    public function testsClientsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'first_name' => 'Lorem',
            'email' => 'email@Ipsum.com',
        ];

        $this->json('POST', '/api/clients', $payload, $headers)
            ->assertStatus(200)
            ->assertJson([ 'id' => 1, 'first_name' => 'Lorem', 'email' => 'email@Ipsum.com' ]);
    }

    public function testsClientsAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $client = factory(Client::class)->create([
            'first_name' => 'First Client',
            'email' => 'first_email@email.cm',
        ]);

        $payload = [
            'first_name' => 'Lorem',
            'email' => 'email@Ipsum.com',
        ];

        $response = $this->json('PUT', '/api/clients/' . $client->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([ 'id' => 1, 'first_name' => 'Lorem', 'email' => 'email@Ipsum.com' ]);
    }

    public function testsClientsAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $client = factory(Client::class)->create([
            'first_name' => 'First Client',
            'email' => 'first_email@email.cm',
        ]);

        $this->json('DELETE', '/api/clients/' . $client->id, [], $headers)
            ->assertStatus(204);
    }

    public function testClientsAreListedCorrectly()
    {
        factory(Client::class)->create([
            'first_name' => 'First Client',
            'email' => 'first_email@email.cm',
        ]);

        factory(Client::class)->create([
            'first_name' => 'Second Client',
            'email' => 'second_email@email.cm',
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/clients', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [
                    'first_name' => 'First Client',
                    'email' => 'first_email@email.cm'
                ],
                [
                    'first_name' => 'Second Client',
                    'email' => 'second_email@email.cm'
                ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'first_name', 'email', 'created_at', 'updated_at'],
            ]);
    }

    public function testUserCantAccessClientsWithWrongToken()
    {
        factory(Client::class)->create();
        $user = factory(User::class)->create([ 'email' => 'user@test.com' ]);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $user->generateToken();

        $this->json('get', '/api/clients', [], $headers)->assertStatus(401);
    }

    public function testUserCantAccessClientsWithoutToken()
    {
        factory(Client::class)->create();

        $this->json('get', '/api/clients')->assertStatus(401);
    }
}
