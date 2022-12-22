<?php
namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterService{

    public function register($data){

        $input = $data;
        $input['password'] = bcrypt($input['password']); 
        try{
            $user = User::create($input);
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
       

        try{
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;
            $responseData = [
                'error' => false,
                "responseCode" => 200,
                "responseMessage" => "Success",
                "responseData" => $success
            ];

            return $responseData;
            
        }

        catch(Exception $e){
            $responseData = [
                'error' => true,
                "responseCode" => 500,
                "responseMessage" => 'Token creation failed',
                "responseData" => $e->getMessage()
            ];

            return $responseData;
            exit;
        }
        
    }
}