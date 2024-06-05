<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Project;
use App\Models\Backer;
use App\Models\Complain;
use Illuminate\Http\Request;
use App\Http\Resources\BackerResource;

class projectcontroller extends Controller
{
      public function allproject()
    {
        $allprojects = Project::get();
        return response()->json($allprojects);
    }
    
    
    public function getproject($id)
    {
        $data = User::with('projects')->find($id);
    
        // $titlss=$data->projects; 
        // foreach ($titlss as $titles ){
        //     echo $titles->title . '<br>'; 
        //     echo $titles->user_id . '<br>'; 
        // }
        if ($data) {
            return response()->json( $data);
        }
        else {
            return response()->json(['massege'=>' fail (wronge id)']);
        }
        
    }
    public function justproject($id)
    {
        $data = Project::find($id) ;
       
        return response()->json($data);
        
    }
    public function addproject( Request $request,$user)
    {
        $request->validate([
            'end_date'=>'required|numeric|between:1,60',
            'photos'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'second_photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'videos' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm|max:30240',
            ]);
        #project_photo
        $image_name = rand() . '.' .$request->photos->getClientOriginalExtension(); 
        $request->photos->move(public_path('/images/projectphoto'),$image_name);
        #second_project_photo
        $secondeimage_name = rand() . '.' .$request->second_photo->getClientOriginalExtension(); 
        $request->second_photo->move(public_path('/images/projectsecondphoto'),$secondeimage_name);
        #project_video
        $video = rand() . '.' .$request->videos->getClientOriginalExtension(); 
        $request->videos->move(public_path('/videos'),$video);

        $the_user = User::find($user);
        $project = new Project;
        $project->user_id = $the_user->id;
        $project->title= $request->title;
        $project->description= $request->description;
        $project->photos = asset('images/projectphoto/' . $image_name); 
        $project->second_photo = asset('images/projectsecondphoto/' . $secondeimage_name); 
        $project->videos = asset('videos/' . $video); 
        $project->goal_amount= $request->goal_amount;
        $project->end_date = $request->end_date;
        $project->category = $request->category;
        $res = $project->save();
        
          return response()->json(['message'=>'project added succfully','user_data' => $project]);
        
           
 }
    public function editproject(Request $request,$id)
{ 
    $project = Project::find($id);
    if ( $project->acceptans == 0) {
       
    $request->validate([
        'end_date'=>'numeric|between:1,60',
        'photos'=>'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        'second_photo'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'videos' => 'mimes:mp4,ogx,oga,ogv,ogg,webm',
        ]);
    #project_photo
    $image_name = rand() . '.' .$request->photos->getClientOriginalExtension(); 
    $request->photos->move(public_path('/images/projectphoto'),$image_name);
    #second_project_photo
    $secondeimage_name = rand() . '.' .$request->second_photo->getClientOriginalExtension(); 
    $request->second_photo->move(public_path('/images/projectsecondphoto'),$secondeimage_name);
    #project_video
    $video = rand() . '.' .$request->videos->getClientOriginalExtension(); 
    $request->videos->move(public_path('/videos'),$video);

    $project = Project::find($id);
    $project->title= $request->title;
    $project->description= $request->description;
    $project->photos = asset('images/projectphoto/' . $image_name); 
    $project->second_photo = asset('images/projectsecondphoto/' . $secondeimage_name); 
     $project->videos = asset('videos/' . $video); 
    $project->goal_amount= $request->goal_amount;
    $project->end_date = $request->end_date;
    $project->category = $request->category;
    $res = $project->save();
    return response()->json(['message'=>'project updated succfully','user_data' => $project]);

}

}

    function acceptince($id) {
        $project = Project::find($id);
        $project->acceptans = 1;
        $project->save();
        return response()->json(['message'=>'project updated succfully']);
    }
    function investing($id) {
        $project = Project::find($id);
        $project->investing = 1;
        $project->save();
        return response()->json(['message'=>'project updated succfully']);
    }

     public function deleteproject($id)
     {
        $data = Project::find($id);
        $image_path = public_path('/images/projectphoto/'.$data->photos);
        $secondeimage_path = public_path('/images/projectsecondphoto/'.$data->second_photo);
        $videoo = public_path('videos/'.$data->videos);
    
        if (file_exists($image_path)) {

           unlink($image_path);
        }
        if (file_exists($secondeimage_path)) {

           unlink($secondeimage_path);
        }
        if (file_exists($videoo)) {

           unlink($videoo);
        }
        if($data){
            $data->delete();
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
     public function decrease()
    {
        $projects = Project::where('acceptans', 1)->get();
        

            foreach ($projects as $project) {
                $project->end_date -=1;
                $project->save();
            }
            return response()->json([
                    'status' => 'success',
                    'message' => 'Number decreased successfully!',
                ]);
        }
        
     public function collectedmoney()
{
    $projects = Project::get();

    foreach ($projects as $project) {
        // Get backers for this project
        $backers = Backer::where('project_id', $project->id)->where('pledge_amount', '>', 0)->get();

        // Calculate total collected money for this project
        $collected_money = $backers->sum('pledge_amount');

        // Update or create project record with collected money
        $project->update(['collected_money' => $collected_money]);
       
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Collected money stored successfully!',
    ]);
}
   public function backer($id)
{
    $data = Backer::with('projects_backer')->find($id);
    if ($data) {
        return response()->json( $data );
    }
    else {
        return response()->json(['massege'=>' fail (wronge id)']);
    }
}
public function userbacker($id)
{
    $data = Backer::with('user_backer')->find($id);
    if ($data) {
        return response()->json( $data );
    }
    else {
        return response()->json(['massege'=>' fail (wronge id)']);
    }
} 

public function allbacker()
{
    // Retrieve all backer data along with corresponding project titles and user names
    $backersWithProjectAndUserName = Backer::join('projects', 'backers.project_id', '=', 'projects.id')
        ->join('users', 'backers.user_id', '=', 'users.id')
        ->join('rewards', 'backers.reward_id', '=', 'rewards.id')
        ->select('backers.*', 'projects.title as project_title', 'users.name as user_name', 'rewards.reward_name as reward_name')
        ->get();

    // Return the integrated data as a JSON response
    return response()->json($backersWithProjectAndUserName);
}

public function count_project_backer($id)
{
    // Retrieve the project along with its backers
    $project = Project::with('backers')->find($id);
    
    // Count the number of backers
    $num_backers = $project->backers->count();
    
    // Add the number of backers to the project object
    $project->backers_count = $num_backers;
    $project->save();
    // Return the project data with the count of backers as JSON response
    return response()->json($project);
}

public function allcomplain()
{
    $allbacker = Complain::join('users' , 'complaints.user_id' , '=' , 'users.id')
    ->select('complaints.*' , 'users.name as user_name')->get();
    return response()->json($allbacker);
}

public function addcomplain(Request $request ,$user )
{
    $the_user = User::find($user);
    $complain = new Complain;
    $complain->complaint_title = $request->complaint_title;
    $complain->description = $request->description;
    $complain->user_id =$the_user->id;
    $res = $complain->save();
    return response()->json(['message'=>'project added succfully','user_data' => $complain]);
}
public function complaintuser($id)
{
    $complaint_user = Complain::with('users_complaint')->find($id);
    if ($complaint_user) {
        return response()->json( $complaint_user );
    }
    else {
        return response()->json(['massege'=>' fail (wronge id)']);
    }
}
public function deletecomplaint($id)
{
    $complaint = Complain::find($id);
    if ($complaint->is_solved == 'Not_solved') {
        
        $complaint->delete();
        return response()->json(['massege'=>' complaint deleted successfully']);
    }
}
public function search_project(Request $request)
{
  
    $search = $request->search;
    $project = Project::where(function($query) use ($search){
        $query->where('title' , 'like' , "%$search%")
        ->orwhere('description' , 'like' ,"%$search%" )
        ->orwhere('acceptans' , 'like' ,"%$search%" )
        ->orwhere('goal_amount' , 'like' ,"%$search%" )
        ->orwhere('end_date' , 'like' ,"%$search%" )
        ->orwhere('category' , 'like' ,"%$search%" )
        ;})->get();
        return response()->json($project);
}

public function search_backer(Request $request)
{
  
    $search = $request->search;
    $backer = Backer::join('projects', 'backers.project_id', '=', 'projects.id')
    ->join('users', 'backers.user_id', '=', 'users.id')
    ->join('rewards', 'backers.reward_id', '=', 'rewards.id')
    ->select('backers.*', 'projects.title as project_title', 'users.name as user_name', 'rewards.reward_name as reward_name')
    ->where(function($query) use ($search){
        $query->where('users.name' , 'like' , "%$search%")
        ->orwhere('pledge_amount' , 'like' ,"%$search%" )
        ->orwhere('pledge_date' , 'like' ,"%$search%" )
        ->orwhere('projects.title' , 'like' ,"%$search%" )
        ->orwhere('rewards.reward_name' , 'like' ,"%$search%" );})
        ->get();
        return response()->json($backer);
}

public function search_complaint(Request $request)
{
  
    $search = $request->search;
    $complaint = Complain::join('users', 'complaints.user_id', '=', 'users.id')
    ->select('complaints.*', 'users.name as user_name')
    ->where(function($query) use ($search){
        $query->where('description' , 'like' , "%$search%")
        ->orwhere('complaint_title' , 'like' ,"%$search%" )
        ->orwhere('complaints_date' , 'like' ,"%$search%" )
        ->orwhere('users.name' , 'like' ,"%$search%" )
        ->orwhere('is_solved' , 'like' ,"%$search%" );})
        ->get();
        return response()->json($complaint);
}














}