<?php

namespace App\Helpers;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    public static function encode($payload):string
    {
        try {
            $payload['exp']=Carbon::now()->addMinute(5)->timestamp;

            $secretKey = config("auth.jwt_secret");
            $jwt = JWT::encode($payload, $secretKey, 'HS256');
            
            return $jwt;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function decode($jwt)
    {
        try {
            $secretKey = config("auth.jwt_secret");
            $decodedJWT = JWT::decode($jwt, new Key($secretKey, 'HS256'));

            return $decodedJWT;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
