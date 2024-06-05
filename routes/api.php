<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminconttroller;
use App\Http\Controllers\projectcontroller;
use App\Http\Controllers\commentcontroller;
use App\Http\Controllers\rewardcontroller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [adminconttroller::class , 'loginn'])->name('login.login')->middleware('logintokin');
Route::post('logoutt', [adminconttroller::class , 'logoutt'])->name('logoutt.user')->middleware('logintokin');
Route::get('index', [adminconttroller::class , 'index'])->name('index.user');


Route::post('update/{id}', [adminconttroller::class , 'update'])->name('user.update');
Route::get('show/{id}', [adminconttroller::class , 'show'])->name('user.show');
Route::post('delete/{id}', [adminconttroller::class , 'delete'])->name('user.delete');

Route::post('registeration', [adminconttroller::class , 'registiration'])->name('user.registiration');
Route::post('adduser', [adminconttroller::class , 'adduser'])->name('user.add');
Route::post('userphoto/{id}', [adminconttroller::class , 'userphoto'])->name('user.userphoto');


//#############################Projects_routes###############################/ 
Route::get('getproject/{id}', [projectcontroller::class , 'getproject'])->name('user.getproject');
Route::get('justproject/{id}', [projectcontroller::class , 'justproject'])->name('user.justproject');
Route::post('addproject/{user}', [projectcontroller::class , 'addproject'])->name('user.addproject');
Route::post('editproject/{id}', [projectcontroller::class , 'editproject'])->name('project.editproject');
Route::post('deleteproject/{id}', [projectcontroller::class , 'deleteproject'])->name('user.deleteproject');
Route::get('decrease', [projectcontroller::class , 'decrease'])->name('date.decrease');
Route::get('allproject', [projectcontroller::class , 'allproject'])->name('project.allproject');
Route::get('collectedmoney', [projectcontroller::class , 'collectedmoney'])->name('project.collectedmoney');
Route::post('acceptince/{id}', [projectcontroller::class , 'acceptince'])->name('project.acceptince');
Route::post('investing/{id}', [projectcontroller::class , 'investing'])->name('project.investing');

//#############################Projects_routes###############################/ 

//#############################backer_routes###############################/ 
Route::get('backer/{id}', [projectcontroller::class , 'backer'])->name('project.backer');
Route::get('userbacker/{id}', [projectcontroller::class , 'userbacker'])->name('user.backer');
Route::post('backproject/{user}/{project}', [projectcontroller::class , 'backproject'])->name('backproject');
Route::get('allbacker', [projectcontroller::class , 'allbacker'])->name('allbacker.backer');
Route::get('count_project_backer/{id}', [projectcontroller::class , 'count_project_backer'])->name('allbacker');


//#############################backer_routes###############################/ 

//#############################complaints_routes###############################/ 
Route::get('allcomplain', [projectcontroller::class , 'allcomplain'])->name('allcomplain.backer');
Route::post('addcomplain/{user}', [projectcontroller::class , 'addcomplain'])->name('addcomplain');
Route::get('complaintuser/{id}', [projectcontroller::class , 'complaintuser'])->name('addcomplaintuser');
Route::post('deletecomplaint/{id}', [projectcontroller::class , 'deletecomplaint'])->name('deletecomplaint');
//#############################complaints_routes###############################/ 

//#############################comments_routes###############################/ 
Route::get('allcomments', [commentcontroller::class , 'allcomments'])->name('allcomments');
Route::get('usercomment/{id}', [commentcontroller::class , 'usercomment'])->name('usercomment');
Route::get('projectcomment/{id}', [commentcontroller::class , 'projectcomment'])->name('projectcomment');
Route::post('commenting/{user}/{project}', [commentcontroller::class , 'commenting'])->name('commenting');
Route::post('deletecomment/{id}', [commentcontroller::class , 'deletecomment'])->name('deletecomment');
Route::get('search_comment', [commentcontroller::class , 'search_comment'])->name('search_comment');

//#############################comments_routes###############################/ 

//#############################paypal_routes###############################/ 
Route::get('payment/{user}/{project}/{reward}', [commentcontroller::class , 'payment'])->name('payment');
Route::get('cancel', [commentcontroller::class , 'cancel'])->name('payment.cancel');
Route::get('payment/success', [commentcontroller::class , 'success'])->name('payment.success');

//#############################reward_routes###############################/ 
Route::post('rewarding/{project}', [rewardcontroller::class , 'rewarding'])->name('rewarding.add');
Route::get('allreward', [rewardcontroller::class , 'allreward'])->name('allreward.view'); 
Route::post('deletereward/{id}', [rewardcontroller::class , 'deletereward'])->name('deletereward.view'); 

##################################search route###############################
Route::get('search_user', [adminconttroller::class , 'search_user'])->name('search_user.view'); 
Route::get('search_project', [projectcontroller::class , 'search_project'])->name('search_project.view'); 
Route::get('search_backer', [projectcontroller::class , 'search_backer'])->name('search_backer.view'); 
Route::get('search_complaint', [projectcontroller::class , 'search_complaint'])->name('search_complaint.view'); 
Route::get('search_reward', [rewardcontroller::class , 'search_reward'])->name('search_reward.view'); 
##################################investor route###############################
