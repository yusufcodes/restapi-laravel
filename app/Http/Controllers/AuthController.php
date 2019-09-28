<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        // Validating the input by the user
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        // Retrieving the user's input
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        // Creating a new User model
        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
            ]);

        // Actions to perform if storing the user was successful
        if ($user->save())
        {
            // Add a property 'signin' to the User model
            $user->signin = [
                'href' => 'api/v1/user/signin',
                'method' => 'POST',
                'params' => 'email, password'
            ];

            // Creating and returning a json response back
            $response = [
                'msg' => 'User created',
                'user' => $user
            ];

            return response()->json($response, 201);
        }

        // Actions to perform if creating a user was not successful
        $response = [
            'msg' => 'Error in creating user'
        ];

        return response()->json($response, 404);
    }

    public function signin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $email = $request->input('email');
        $password = $request->input('password');
        $user = [
            'name' => 'Name',
            'email' => $email,
            'password' => $password
        ];

        $response = [
            'msg' => 'User signed in',
            'user' => $user
        ];

        return response()->json($response, 200);
    }
}
