<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Artisan;

class BehaviorControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;
    
    /**
     * Create a user, setup a few behaviors for that user, signin and return a token
     */
    public function setUp(){

        parent::setUp();
        $this->user = factory(\App\User::class)->create(['password' => bcrypt('foo')]);
        $this->behaviors = factory(\App\Behavior::class, 3)->create(['user_id' => $this->user]);
        $this->token = JWTAuth::fromUser($this->user);

        //this is SO important since we are making multiple requests
        $this->refreshApplication(); 

    }

    public function testGetAllBehaviors() {

        $this->json('GET', '/api/behaviors?token=' . $this->token )
            ->assertStatus(200)
            ->assertJson ([
                'behaviors' => []
            ]);

    }

    public function testGetBehavior() {

        //get the id of the first behavior in the collection
        $behavior = $this->behaviors[0]->id;
        $this->json('GET', "/api/behavior/{$behavior}?token=" . $this->token )
            ->assertStatus(200)
            ->assertJson ([
                'behavior' => []
            ]);
            
    }

    public function testPostNewBehavior() {
      
        $behavior = ['breakfast' => 'eggs', 'daily_routine' => 'work', 'feeling' => 'good'];

        $this->json( 'POST', '/api/behavior?token=' . $this->token, $behavior )
            ->assertStatus(201)
            ->assertJsonFragment([
                'breakfast' => 'eggs',
                'daily_routine' => 'work',
                'feeling' => 'good'
            ]);

    }

    public function testUpdateBehavior() {
        //get the id of the first behavior in the collection
        $behavior = $this->behaviors[0]->id;
        $this->json('PUT', "/api/behavior/{$behavior}?token=" . $this->token, ['breakfast' => 'eggs', 'daily_routine' => 'work', 'feeling' => 'good'])
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $behavior,
                'breakfast' => 'eggs'
            ]);

    }

    public function testDeleteBehavior() {
        //get the id of the first behavior in the collection
        $behavior = $this->behaviors[0]->id;
        $this->json('DELETE', "/api/behavior/{$behavior}?token=" . $this->token )
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Behavior record deleted'
            ]);

    }

}
