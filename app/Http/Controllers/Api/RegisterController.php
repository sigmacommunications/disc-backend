<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserTemporaryAddress;
use App\Models\ServiceTiming;
use App\Models\Service;
use App\Models\Notification;
use App\Models\Questions;
use App\Models\BarberService;
use App\Models\QueAnswer;
use App\Models\AdminInfo;
use Image;
use File;
use Auth;
use Validator;
use Illuminate\Support\Facades\Mail;
 use Illuminate\Support\Str;
use Carbon\Carbon;


class RegisterController extends BaseController
{
	
	public function register(Request $request)
    {
		$validator = Validator::make($request->all(), [
            //'name' => 'required|string',
            //'last_name' => 'required|string',
            'email' => 'required|email|unique:users',			
            //'phone' => 'required|numeric|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'current_role' => 'string',
			'photo' => 'image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
        ]);      
        if($validator->fails())
        {
		 return $this->sendError($validator->errors()->first());

        }
		$profile = null;
        if($request->hasFile('profile_image')) 
        {
            $file = request()->file('profile_image');
            $fileName = md5($file->getClientOriginalName() . time()) . $file->getClientOriginalExtension();
            $file->move('uploads/user/profiles/', $fileName);  
            $profile = 'uploads/user/profiles/'.$fileName;
        }
        $input = $request->except(['confirm_password'],$request->all());
        $input['password'] = bcrypt($input['password']);
        $input['profile_image'] = $profile;
		$input['email_verified_at'] = Carbon::now();
		//$input['email_code'] = mt_rand(9000, 9999);
        $user = User::create($input);

        $token =  $user->createToken('hatch_social')->plainTextToken;
		$users = User::find($user->id);
		//$users = User::with('profiles')->where('id',$user->id)->first();
		return response()->json(['success'=>true,'message'=>'User register successfully' ,'token'=>$token,'user_info'=>$users]);
    }
	
	
	public function login(Request $request)
    {   
        if(!empty($request->email) || !empty($request->password))
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
                'password' => 'required',        
            ]);  
            if($validator->fails()){
				return $this->sendError($validator->errors()->first());
            }
            $user = User::where('email',$request->email)->first();
			
            
            // if($user->email_verified_at != null)
            // {
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                    $users = Auth::user();
					
                    $token =  $users->createToken('hatch_social')->plainTextToken; 
		            return response()->json(['success'=>true,'message'=>'User Logged In successfully' ,'token'=>$token,'user_info'=>$user]);
               } 
                else{ 
				return $this->sendError('Unauthorised User');

                } 

        //     }else{
		// return $this->sendError('Email Not Verified , Check Email');

        //     }

        }else{
		return $this->sendError('Email & Password are Required');

        }
      
    }
	public function __construct()
    {
		$stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }
	
	
	public function sendOtp(Request $request)
    {
        // Validate email input
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email',
        ]);
		
		if($validator->fails())
		{
			return $this->sendError($validator->errors()->first(),500);
		}

        $user = User::where('email', $request->email)->first();

        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Save OTP to the user record
        $user->email_code = $otp;
        $user->save();

        // Send OTP via email
        Mail::raw("Your verification OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Email Verification OTP');
        });

        return response()->json([
            'message' => 'OTP sent successfully to your email.',
        ], 200);
    }
	
	
	public function requestDelete(Request $request)
	{
		$user = Auth::user();

		if ($user->deletion_scheduled_at && $user->deletion_scheduled_at->isFuture()) {
			return response()->json([
				'success' => false,
				'message' => 'Your account is already scheduled for deletion on ' . $user->deletion_scheduled_at->toDateTimeString()
			], 422);
		}

		$user->deletion_scheduled_at = now()->addDays(7);
		$user->deletion_requested_by = 'user';
		$user->save();

		Mail::to($user->email)->send(new AccountDeletionScheduled($user));

		return response()->json([
			'success' => true,
			'message' => 'Account scheduled for deletion on ' . $user->deletion_scheduled_at->toDateTimeString()
		]);
	}

	
	public function verifyOtpAndDelete(Request $request)
	{
		// Validate OTP and email
		$validator = Validator::make($request->all(),[
			'email' => 'required|email|exists:users,email',
			'otp' => 'required|digits:6',
		]);
		
		if($validator->fails())
		{
			return $this->sendError($validator->errors()->first(),500);
		}

		$user = User::where('email', $request->email)->first();

		// Check if OTP matches
		if ($user->otp != $request->otp) {
			return response()->json([
				'message' => 'Invalid OTP. Please try again.',
			], 400);
		}

		// Soft delete the user
		$user->otp = null; // Clear the OTP
		$user->deleted_at = Carbon::now();
		$user->save();

		return response()->json([
			'message' => 'User has been soft deleted successfully.',
		], 200);
	}
	
	public function admininfo()
    {
       
        try{
            $admin =AdminInfo::first();
            return response()->json(['success'=>true,'data'=>$admin]);

        }catch(\Eception $e){
            return $this->sendError($e->getMessage());

        }
    }

    public function profile(Request $request)
    {
        try{
			$olduser = User::with('liked_artist')->find(Auth::user()->id);
			$validator = Validator::make($request->all(),[
				'name' =>'string',
//				'passcode' => 'numeric',
				'phone' =>'numeric',
				'dob' =>'string',
//				'email' => 'email|unique:users,email,'.$olduser->id,
				'profile_image' => 'image|mimes:jpeg,png,jpg,bmp,gif,svg|max:2048',
			]);
			if($validator->fails())
			{
				return $this->sendError($validator->errors()->first(),500);

			}

			$olduser->name = $request->name ? $request->name : $olduser->name ;
			$olduser->phone = $request->phone ? $request->phone : $olduser->phone ;
			$olduser->isProfileCreated = 1;
			$olduser->dob = $request->dob ? $request->dob : $olduser->dob ;
			
			if($request->hasFile('profile_image'))
            {
                $image = $request->file('profile_image');
                $randomName = Str::random(40) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('users/profile_images', $randomName, 'public');            
                $olduser->profile_image = $path;	
            }
				
            $olduser->save();
            
			return response()->json(['success'=>true,'message'=>'Profile Updated Successfully','user_info'=>$olduser]);
		}
		catch(\Eception $e)
		{
			return $this->sendError($e->getMessage());
		}

    }
	// public function current_plan(Request $request)
	// {
	// 	try{
	// 	//$user= User::findOrFail(Auth::id());
	// 	$user = User::with(['goal','temporary_wallet','wallet','payments'])->where('id',Auth::user()->id)->first();

	// 	$amount = 100;
	// 	$charge = \Stripe\Charge::create([
	// 		'amount' => $amount,
	// 		'currency' => 'usd',
	// 		'customer' => $user->stripe_id,
	// 	]);
	// 	if($request->current_plan == 'basic')
	// 	{
	// 		$user->update(['current_plan' =>"premium",'card_change_limit'=>'1','created_plan'=> \Carbon\Carbon::now()]);
	// 		return response()->json(['success'=>true,'message'=>'Current Plan Updated Successfully','user_info'=>$user,'payment' => $charge]);

	// 	}
	// 	elseif($request->current_plan == 'premium')
	// 	{
	// 		$user->update(['current_plan' =>"basic",'card_change_limit'=>'0','created_plan'=> \Carbon\Carbon::now()]);

	// 	 return response()->json(['success'=>true,'message'=>'Current Plan Updated Successfully','user_info'=>$user]);
	// 	}
	// 	else
	// 	{
	// 		return $this->sendError("Invalid Body ");
	// 	}
	// 	}
	// 	catch(\Exception $e){
	//   return $this->sendError($e->getMessage());

	// 	}

	// }


}
