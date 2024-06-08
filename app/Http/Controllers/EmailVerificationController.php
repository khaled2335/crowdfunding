<?php

namespace App\Http\Controllers;
    use App\Models\User;
    use Illuminate\Support\Facades\Notification;
    use App\Notifications\EmailVerificationNotification;
    use App\Http\Requests\emailverifictionrequest;
    
    use Ichtrojan\Otp\Otp;
    use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
   
      private $otp;

        public function __construct()
        {
            $this->otp = new Otp;
        }
        
        public function email_verification(emailverifictionrequest $request) {
            $otp2 = $this->otp->validate($request->email, $request->otp);
          
            if (!$otp2->status) {
                return response()->json(['error' => $otp2], 401);
            }
        
            $user = User::where('email', $request->email)->first();
            $user->email_verified_at = now();
            $user->save();
            $success['success'] = true;
            return response()->json($success, 200);
        }
       public function resend_verification_code(Request $request , $id) {

            // $request->user()->notify(new EmailVerificationNotification());
            User::find($id)->notify(new EmailVerificationNotification());
            $success['success'] = true;
            return response()->json($success, 200);
       } 
}
