<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResetCodePassword;
use App\Mail\SendCodeResetPassword;
use Mail;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;
use App\Models\User;
use Hash;

class ForgotPasswordController extends BaseController
{
    public function forget(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);
        if ($validator->fails()) 
        {    
            return $this->sendError($validator->errors()->first(),500);
        } 
		
		$user = User::firstWhere('email',$request->email);
		if($user != null)
		{
			$data['code'] = mt_rand(9000, 9999);
			$data['email'] = $request->email;
			$user->update(['email_code'=>$data['code'] ]);
		    Mail::to($user->email)->send(new SendCodeResetPassword($user->email_code));	
			$success = [$data];
	        return $this->sendResponse($success, trans('passwords.sent'));
		}else{
		 return $this->sendError('User does not exitsts');

		}

    }
	
	public function code_verify(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'code' => 'required|min:4',
			'email' => 'required|email|exists:users',
        ]);
	 	if($validator->fails()) 
        {    
			return $this->sendError($validator->errors()->first());
        } 
		//$user = User::firstWhere(['email_code'=>$request->code]);
		
		 $user = User::where('email', $request->email)
                ->where('email_code', $request->code)
                ->first();
			
		if($user != null)
		{
	        return response()->json(['success'=>true,'message'=>'Code or Email Verified']);



		}else{
			return $this->sendError('Code is Invalid');
		}
	}
	
	public function update_reset_password(Request $request)
    {
		try{
        $validator = Validator::make($request->all(),[
			'email' => 'required|exists:users',
            'password' => 'required|string|min:8',
			'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) 
        {    
		return response()->json(['message'=>$validator->errors()->first()],500);
        } 

		$user =User::firstWhere('email',$request->email);

        if($user != null){
		 $user->update([
			 'password'=>Hash::make($request['password']),
			'email_code'=> null
		 ]);

		return response()->json(['user'=>$user,'message'=>'successfully password reset']);

        }
        else
        {
		return response()->json(['message'=>'User does not exitsts']);

        }
		}catch(\Eception $e){
           return $this->sendError($e->getMessage());    
        }
        
    }
}
