<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller 
{
    
    /**
     * Register a new User
     *
     * @param Request $request
     * @return void
     */
    public function register( Request $request ) {

        $this->validate( $request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required'
        ]);

        $user = new User([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => bcrypt( $request->input('password') )
        ]);

        $user->save();

        return response()->json([
            'message' => 'successfully created User!'
        ], 201);
        
    }

    /**
     * Login in a registered User and issue token
     *
     * @param Request $request
     * @return void
     */
    public function signin( Request $request ) {

        $this->validate( $request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);
    
        $creds = $request->only( 'email', 'password' ); 

        try{
            //if we do not receive a value back our creds are do not match
            if( ! $token = JWTAuth::attempt( $creds ) ) {
                return response()->json([ 
                    'error' => 'Invalid Credentials'
                ], 401);
            }
        } catch( JWTException $e ) {
            //if we can not create a token return an error
            return response()->json([ 
                'error' => 'Could not create token!'
            ], 500);

        }

        //if we are creds match $token will be set, lets return it
        return response()->json([ 
            'token' => $token
        ], 200);

    }

}