<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginService{

    public function userLogin($data){
        $email = $data['email'];
        $password = $data['password'];

        try{
            if(Auth::attempt(['email' => $email, 'password' => $password])){
                try{
                    $user = Auth::user();
                    $success['token'] =  $user->createToken('MyApp')-> accessToken;
                    $success['name'] =  $user->name;

                    $responseData = [
                        'error' => false,
                        "responseCode" => 200,
                        "responseMessage" => "Login Successfully",
                        "responseData" => $success
                    ];
        
                    return $responseData;
                }

                catch(\Illuminate\Database\QueryException $ex){
                    $responseData = [
                        'error' => true,
                        "responseCode" => 500,
                        "responseMessage" => $ex->errorInfo[2],
                        "responseData" => $ex->errorInfo
                    ];
                    return $responseData;
                    exit;
                }
                
            }else{
                $responseData = [
                    'error' => true,
                    "responseCode" => 404,
                    "responseMessage" => "Login Failed | User not found",
                    "responseData" => []
                ];
    
                return $responseData;
            }
        }
        catch(Exception $e){
            $responseData = [
                'error' => true,
                "responseCode" => 404,
                "responseMessage" => $e->getMessage(),
                "responseData" => []
            ];

            return $responseData;
            exit;
        }
    }
}