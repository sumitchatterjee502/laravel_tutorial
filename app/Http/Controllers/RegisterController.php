<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\RegisterService;
use App\Http\Services\LoginService;
use App\Http\Requests\RegisterRequest;
use Validator;


class RegisterController extends BaseController
{

    private RegisterService $registerService;
    private LoginService $loginService;
   /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(RegisterService $registerService, LoginService $loginService){
        $this->registerService = $registerService;
        $this->loginService = $loginService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        //$register = new RegisterService();
        $inputData = $request->all();
        $outputData = $this->registerService->register($inputData);
            
        return $this->sendResponse($outputData, $outputData['responseMessage']);      
   
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);

        $inputData = $request->all();

        $outputData = $this->loginService->userLogin($inputData);

        return $this->sendResponse($outputData, $outputData['responseMessage']);
    }
}
