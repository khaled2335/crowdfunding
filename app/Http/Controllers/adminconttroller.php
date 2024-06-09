<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailVerificationNotification;
use App\Http\Requests\emailverifictionrequest;
use Otp;
class adminconttroller extends Controller
{
    private $otp;
    public function _constract()
    {
         $this->middleware('auth')->except(['registirationform','registiration','loginform']);
       
    }
    
    
    public function index()
    {
       $data = User::get();
       return response()->json($data);
    }
   public function show($id)
   {
      $data = User::find($id);
      if ($data) {
        
        return response()->json(
          
                $data,
            
        );
    }
    else {
        return response()->json([
            'status' => 'error',
            'message' => 'user not found (id is wrong)',
        ]);
    }


   }
    public function registiration(Request $request)
    {
     

        $request->validate([
            'name'=>'required',
            'last_name'=>'required',
            'email'=>'required |  email ',
            'password'=>'required|min:6',
            
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
         $res = $user->save();
        Notification::send($user ,new EmailVerificationNotification() );
       
        if ($res) {

            //   $user->notify( new EmailVerificationNotification());
           return response()->json(['massege'=>'regestration successfully']);
        }
        else {
            return response()->json(['massege'=>'regestration fail']);
        }
        
         }

       public function registirationform(){
            
            return view('registerform');



         } 
    public function registirationweb(Request $request)
    {
     

        $request->validate([
            'name'=>'required',
            'last_name'=>'required',
            'email'=>'required |  email',
            'password'=>'required|min:6',
            
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $res = $user->save();
        if ($res) {
           return view('dashboard');
        }
        else {
            return response()->json(['massege'=>'regestration fail']);
        }
        
          
    }

    public function userphoto(Request $request , $id)
    {
        $image_name = rand() . '.' .$request->profile_photo->getClientOriginalExtension(); 
        $request->profile_photo->move(public_path('/images/usersphotos'),$image_name);
        $user = User::findOrFail($id);
        $user->profile_photo = asset('images/usersphotos/' . $image_name); 
        $res = $user->save();
        if ($res) {
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user,
            ]);}
    }

    public function loginn(Request $request)
    {
        $user = $request->only('email' ,'password');
        $token=Auth::guard('logintokin')->attempt($user);
         $user = Auth::guard('logintokin')->user(); 
         $user->remember_token = $token;
         $user->save();
        
            if ( auth()->guard('logintokin')) {
                
                return response()->json( ['token'=>$token ,'data'=>auth()->guard('logintokin')->user()]); 
            }
         
           
        }
    public function loginform(Request $request)
    {
        return view('loginform');
         
           
        }
        public function loginnweb(Request $request)
        {
            // Retrieve email and password from the request
                // Validate the user's login credentials
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                // Authentication successful, redirect to the dashboard or any other page
                return redirect()->intended('/dashboard');
            } else {
                // Authentication failed, redirect back with an error message
                return redirect()->back()->withInput()->withErrors(['email' => 'Invalid email or password']);
            }
        }
  
    public function adduser(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->address = $request->address;
        $user->National_id = $request->National_id;
        $res= $user->save();
        if ($res) {
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user,
            ]);}
      

    }
    public function update(Request $request ,$id)
    {
       
        $user = User::findOrFail($id);
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->address = $request->address;
        $user->National_id = $request->National_id;
        $res = $user->save();

        if ($res) {
           return response()->json(['massege'=>'updated successfully' , $user  ]);
        }
        return response()->json(['massege'=>'fail']);

        
        
    }
public function logout()
{
    session()->flush();
    Auth::logout();
    return view('loginform');;
}


public function delete($id)
{
   $user = User::find($id);
   if($user){
    $user->delete();
   return response()->json([
    'status' => 'success',
    'message' => 'user deleted successfully',
]);
}
else {
return response()->json([
    'status' => 'error',
    'message' => 'user not found (id is wrong)',
]);

}


}

public function search_user(Request $request)
{
  
    $search = $request->search;
    $user = User::where(function($query) use ($search){
        $query->where('name' , 'like' , "%$search%")
        ->orwhere('last_name' , 'like' ,"%$search%" )
        ->orwhere('email' , 'like' ,"%$search%" )
        ->orwhere('phone' , 'like' ,"%$search%" )
        ->orwhere('role' , 'like' ,"%$search%" )
        ->orwhere('created_at' , 'like' ,"%$search%" )
        ;})->get();
        return response()->json($user);
}










































}