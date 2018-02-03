<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{

    use DatabaseMigrations;
    use WithoutMiddleware;


    /**
     * Test Register
     *
     * @return void
     */
    public function testRegister() {

        $this->post('/api/user', ['name' => 'john', 'email' => 'bar@gmail.com', 'password' => 'foo'])
            ->assertStatus(201);
            
    }

    /**
     * Test Login
     *
     * @return void
     */
    public function testLogin() {

        $user = factory(\App\User::class)->create(['password' => bcrypt('foo')]);
        $response = $this->post('/api/user/signin', ['email' => $user->email, 'password' => 'foo']);
        $content = json_decode($response->getContent());
        $this->assertObjectHasAttribute('token', $content);

    }


}
