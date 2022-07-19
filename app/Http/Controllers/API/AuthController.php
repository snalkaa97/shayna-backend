<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;


class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', 
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'email_verified_at' => null,
                    'first_name' => $user->name,
                    'last_name' => $user->last_name,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                    'api_token' => $token
                ]
            ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'email_verified_at' => null,
                'first_name' => $user->name,
                'last_name' => $user->last_name,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'api_token' => $token
            ] 
        ]);
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'logout' => true,
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ]);
    }

    public function verify_token(Request $request){
        return response()
            ->json([
            'user' => [
                'id' => auth()->user()->id,
                'email' => auth()->user()->email,
                'email_verified_at' => null,
                'first_name' => auth()->user()->name,
                'last_name' => null,
                'created_at' => auth()->user()->created_at,
                'updated_at' => auth()->user()->updated_at,
                'api_token' => $request->bearerToken()
            ] 
        ]);
    }
}
