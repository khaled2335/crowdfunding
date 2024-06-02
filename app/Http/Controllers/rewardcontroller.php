<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Project;
use App\Models\Backer;
use App\Models\Comment;
use App\Models\Complain;
use App\Models\Reward;
use Illuminate\Http\Request;

class rewardcontroller extends Controller
{

    public function rewarding( Request $request ,$project)
    {

        $image_name = rand() . '.' .$request->reward_photo->getClientOriginalExtension(); 
        $request->reward_photo->move(public_path('/images/rewardphoto'),$image_name);

        $reward =new  Reward;
        $reward->reward_name = $request->reward_name;
        $reward->reward_photo = asset('images/rewardphoto/' . $image_name);
        $reward->reward_description = $request->reward_description;
        $reward->reward_pledge_amount= $request->reward_pledge_amount;
        $reward->shipping= $request->shipping;
        $reward->distination = $request->distination;
        $reward->seconde_distination = $request->seconde_distination;
        $reward->distination_cost = $request->distination_cost;
        $reward->secone_distination_cost = $request->secone_distination_cost;
        $reward->estimate_delivery = $request->estimate_delivery;
        $reward->reward_quantity = $request->reward_quantity;
        $reward->project_id = Project::find($project)->id ;
        $res = $reward->save();
        return response()->json(['message'=> 'success' ,'reward'=> $reward ]);
    }

    public function allreward()
    {
       $rewards = Reward::join('projects' , 'rewards.project_id' , '=' , 'projects.id')
       ->select('rewards.*' , 'projects.title as project_name')->get();
       return response()->json( $rewards );

    }

    public function deletereward($id)
    {
        $reward = Reward::find($id);
        $image_path = public_path('/images/rewardphoto/'.$reward->reward_photo);
        if (file_exists($image_path)) {

            unlink($image_path);
         }
        $reward ->delete();
        return response()->json(['message'=> 'success reward deleted successfully' ]);
    }

    public function search_reward(Request $request)
    {
      
        $search = $request->search;
        $rewards = Reward::join('projects' , 'rewards.project_id' , '=' , 'projects.id')
        ->select('rewards.*' , 'projects.title as project_name')
        ->where(function($query) use ($search){
            $query->where('projects.title' , 'like' , "%$search%")
            ->orwhere('reward_name' , 'like' ,"%$search%" )
            ->orwhere('reward_description' , 'like' ,"%$search%" )
            ->orwhere('reward_pledge_amount' , 'like' ,"%$search%" )
            ->orwhere('shipping' , 'like' ,"%$search%" )
            ->orwhere('distination' , 'like' ,"%$search%" )
            ->orwhere('seconde_distination' , 'like' ,"%$search%" )
            ->orwhere('distination_cost' , 'like' ,"%$search%" )
            ->orwhere('secone_distination_cost' , 'like' ,"%$search%" )
            ->orwhere('estimate_delivery' , 'like' ,"%$search%" )
            ->orwhere('reward_quantity' , 'like' ,"%$search%" );})
            ->get();
            return response()->json($rewards);
    }
    







}
