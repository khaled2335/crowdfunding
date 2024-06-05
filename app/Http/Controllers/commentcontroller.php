<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Project;
use App\Models\Backer;
use App\Models\Comment;
use App\Models\Complain;
use App\Models\Reward;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Support\Facades\DB;


class commentcontroller extends Controller
{
    public function allcomments()
    {
        $comments = Comment::join('users' , 'comments.user_id', '=' , 'users.id')
        ->join('projects' , 'comments.project_id','=','projects.id')
        ->select('comments.*' , 'users.name as user_name' , 'projects.title as project_title' ,   'users.profile_photo as user_profile_photo'  )->get();
        return response()->json( $comments);
    }
    public function commenting(Request $request ,$user, $project)
    {
        $the_user = User::find($user);
        $the_project = Project::find($project);
        $comment = new Comment;
        $comment->comment_text = $request->comment_text;
        $comment->user_id =  $the_user->id;
        $comment->project_id = $the_project->id;
        $res = $comment->save();
        return response()->json(['message'=>'project added succfully','user_data' => $comment]);
    }
    public function usercomment($id)
    {
        $comment_user = Comment::with('user_comment')->find($id);
        if ($comment_user) {
            return response()->json( $comment_user );
        }
        else {
            return response()->json(['massege'=>' fail (wronge id)']);
        }
    }
    public function projectcomment($id)
{
    $comment_project = Comment::with('projects_comment')->find($id);
    if ($comment_project) {
        return response()->json( $comment_project );
    }
    else {
        return response()->json(['massege'=>' fail (wronge id)']);
    }
}

    public function deletecomment($id)
{
    $delete_comment = Comment::find($id);
    $delete_comment->delete();
    if ($delete_comment) {
        return response()->json( ['massege'=>' deleted successfully'] );
    }
    else {
        return response()->json(['massege'=>' fail (wronge id)']);
    }

}

public function search_comment(Request $request)
    {
        $search = $request->search;
        $comment =  $comments = Comment::join('users' , 'comments.user_id', '=' , 'users.id')
        ->join('projects' , 'comments.project_id','=','projects.id')
        ->select('comments.*' , 'users.name as user_name' , 'projects.title as project_title' )
        ->where(function($query) use ($search){
            $query->where('comment_text' , 'like' , "%$search%")
            ->orwhere('comment_date' , 'like' ,"%$search%" )
            ->orwhere('users.name' , 'like' ,"%$search%" )
            ->orwhere('projects.title' , 'like' ,"%$search%" );})
            ->get();
            return response()->json($comment);
    }
#########################paypal#########################################

public function payment(Request $request ,$user, $project ,$reward)
{
    $reward = Reward::find($reward);
    $project = Project::find($project);
    $data = [];
    $data['items'] = [
        [
            'name' => $reward->id,
            'price' => $reward->reward_pledge_amount ,
            'desc'  => $project->id ,
            'qty' => 1,
            
            
        ]
    ];
//    strip
//    
     $data['invoice_id'] = User::find($user)->id;
     $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
     $data['return_url'] = route('payment.success');
     $data['cancel_url'] = route('payment.cancel');
     $data['total'] = $reward->reward_pledge_amount ;
     
    $provider = new ExpressCheckout;
      
    $response = $provider->setExpressCheckout($data);
    
    $response = $provider->setExpressCheckout($data, true);
    // dd($response);
    return redirect($response['paypal_link']);
}


public function cancel()
{
    dd('Your payment is canceled.');
}

public function success(Request $request)
{
    $provider = new ExpressCheckout;
    $response = $provider->getExpressCheckoutDetails($request->token);

    if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
       
          dd($response);
            $backer = new Backer;
            $backer->pledge_amount = $response['PAYMENTREQUEST_0_AMT'];
            $backer->user_id = $response['PAYMENTREQUEST_0_INVNUM'];
            $backer->project_id = $response['L_PAYMENTREQUEST_0_DESC0'];
            $backer->reward_id = $response['L_PAYMENTREQUEST_0_NAME0'];
            $res = $backer->save();
            $projects = Project::get();

            foreach ($projects as $project) {
                // Get backers for this project
                $backers = Backer::where('project_id', $project->id)->get();
        
                // Calculate total collected money for this project
                $collected_money = $backers->sum('pledge_amount');
        
                // Update or create project record with collected money
                $project->update(['collected_money' => $collected_money]);
            }

            $projects = Project::all();

            // Loop through each project
            foreach ($projects as $project) {
                // Count the number of backers for this project
                $num_backers = $project->backers()->count();
                
                // Update the backers_count attribute
                $project->backers_count = $num_backers;
                $project->save();
            }

        
            dd('success payment.');
        }
    else {
        dd('Please try again later.');
    }
    
}




}











