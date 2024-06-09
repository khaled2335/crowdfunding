<?php

namespace App\Http\Controllers;
    use App\Models\User;
    use App\Models\ChMessage;
    use Illuminate\Support\Facades\Notification;
    use App\Notifications\EmailVerificationNotification;
    use App\Http\Requests\emailverifictionrequest;
    use App\Notifications\ResetPasswordNotification;
    use App\Http\Requests\ForgetpasswwordRequest;
    use App\Http\Requests\resetpasswwordRequest;
    use Illuminate\Support\Facades\Hash;
    use Ichtrojan\Otp\Otp;
    use Illuminate\Http\Request;
    use App\Events\MessageSent;


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
################################################forget password#######################################

public function forgetPassword(ForgetpasswwordRequest $request)  {
    
        $input = $request->only('email');
        $user = User::where('email' , $input)->first();
        $user -> notify(new ResetPasswordNotification());
        $success['success'] = true;
        return response()->json($success , 200);
}


public function reset_password(resetpasswwordRequest $request) {
    $otp2 = $this->otp->validate($request->email, $request->otp);
  
    if (!$otp2->status) {
        return response()->json(['error' => $otp2], 401);
    }

    $user = User::where('email', $request->email)->first();
    $user->password = Hash::make($request->password);
    $user->save();
    $success['success'] = true;
    return response()->json($success, 200);
}























################################################ message#######################################
 public function send_message_from(Request $request , $from_id , $to_id)  {
    $send_message = new ChMessage ; 
    $send_message->from_id  = user::find($from_id)->id;
    $send_message->to_id  = user::find($to_id)->id;
    $send_message->body  = $request->body;
    $res = $send_message->save();
    if ($res) {
        
        return response()->json(['message' => 'Message sent successfully'], 200);
    } else {
        return response()->json(['error' => 'Failed to send message'], 500);
    }

}
 public function receve_message_from(Request $request ,$from_id, $to_id)  {
    
    // Fetch messages between the two users, ordered by the latest first
    $query = ChMessage::where(function($query) use ($from_id, $to_id) {
        $query->where('from_id', $from_id)
              ->where('to_id', $to_id);
    })->orWhere(function($query) use ($from_id, $to_id) {
        $query->where('from_id', $to_id)
              ->where('to_id', $from_id);
    })->latest();

    // Paginate the results
    $messages = $query->paginate($request->per_page ?? 10);

    // Prepare the response
    $totalMessages = $messages->total();
    $lastPage = $messages->lastPage();
    $response = [
        'total' => $totalMessages,
        'last_page' => $lastPage,
        'messages' => $messages->items(),
    ];

    return response()->json($response);
}

public function get_message_users()
{
    // Retrieve all messages
    $messages = ChMessage::get();

    // Group messages by sender (from_id) and recipient (to_id)
    $groupedMessages = $messages->groupBy(function ($message) {
        return $message->from_id . '-' . $message->to_id;
    });

    return response()->json(['messages' => $groupedMessages], 200);
} 

    












}

































