<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\JwtHelper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $userArr=[
                "id"=> $user->id,
                "name"=> $user->name,
                "email"=> $user->email,
                "email_verified_at"=> $user->email_verified_at,
        ];

        return JwtHelper::encode($userArr);
        
    }

    public function user(Request $request)
    {
        return Auth::user();
    }

    public function encode(Request $request)
    {
        
        $payload=[
            "exp"=>"1683715242",
            "uba kawda"=>"Chethana",
            "wayasa kiyada"=>"18",
            "uba koheda"=>"Lankawe",
        ];
        
        $secretKey="buduambo";
        
       $jwt = JWT::encode($payload, $secretKey, 'HS256');

       return $jwt;
       
    }

    public function decode(Request $request)
    {
        
        try {
            $secretKey="buduambo";
            $decodedJWT = JWT::decode($request->jwt,new Key($secretKey, 'HS256'));
            
           return $decodedJWT;
        } catch(SignatureInvalidException $ex){
            return "මේක හොර අත්සනක්";
        } catch(ExpiredException $ex){
            return "අඩෝ මේක පරණයි නේ";
        }  catch (\Throwable $th) {
            return $th->getMessage();
        }
       
    }
}
