<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Behavior;
use Tymon\JWTAuth\Facades\JWTAuth;

class BehaviorController extends Controller
{

    /**
     * Post a new Behavior
     *
     * @param Request $request
     * @return void
     */
    public function postBehavior( Request $request ) {

        $user = JWTAuth::parseToken()->toUser();

        $behavior = new Behavior();
        $behavior->breakfast = $request->input('breakfast');
        $behavior->daily_routine = $request->input('daily_routine');
        $behavior->feeling = $request->input('feeling');

        //attach the user_id to behaviors by using the relationship set up in User Model
        $user->behaviors()->save($behavior);

        return response()->json([ 
            'behavior' => $behavior, 
            'user' => $user 
        ], 201);

    }

    /**
     * Return all the Behaviors for logged in user
     *
     * @return void
     */
    public function getAllBehaviors() {

        $user = JWTAuth::parseToken()->toUser();

        $behaviors = $user->behaviors()->get();
        
        $response = [
            'behaviors' => $behaviors
        ];

        return response()->json( $response, 200 );

    }

    /**
     * Get a  singlBehavior
     *
     * @param Behavior $behavior
     * @return void
     * */
    public function getBehavior( Behavior $behavior ) { //implicit route / model binding


        if( !$behavior ){
            return response()->json( [ 'error' => 'Behavior record not found' ], 404 );
        }

        return response()->json([ 'behavior' => $behavior ], 200);
        
    }

    /**
     * Update a Behavior record
     *
     * @param Request $request
     * @param Behavior $behavior
     * @return void
     */
    public function updateBehavior( Request $request, Behavior $behavior ) { //implicit route / model binding

        
        if( !$behavior ){
            return response()->json( [ 'error' => 'Behavior record not found' ], 404 );
        }

        $behavior->breakfast = $request->input('breakfast');
        $behavior->daily_routine = $request->input('daily_routine');
        $behavior->feeling = $request->input('feeling');

        $behavior->update();

        return response()->json([ 
            'behavior' => $behavior 
        ], 200);

    }

    /**
     * Delete a Behavior
     *
     * @param Behavior $behavior
     * @return void
     */
    public function deleteBehavior ( Behavior $behavior ) {

        $behavior->delete();

        return response()->json( [ 
            'message' => 'Behavior record deleted'
        ], 200 );

    }
}
