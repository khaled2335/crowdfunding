<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminconttroller;
use App\Http\Controllers\commentcontroller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome.phone');
Route::get('crowdfunding', function(){
    return view('welcome');});
Route::prefix('user')->middleware(['auth', 'web'])->group(function () {


Route::get('edit/{id}', [adminconttroller::class , 'edit'])->name('user.edit');

});


Route::post('loginweb', [adminconttroller::class , 'loginnweb'])->name('login.login');
Route::post('registirationweb', [adminconttroller::class , 'registirationweb'])->name('user.registirationweb');
Route::get('loginform', [adminconttroller::class , 'loginform'])->name('loginform.user');
Route::get('registerationform', [adminconttroller::class , 'registirationform'])->name('user.registirationform');
Route::post('logout', [adminconttroller::class , 'logout'])->name('user.logout');




Route::prefix('user')->middleware(['guest', 'web'])->group(function () {
 
//Route::post('registeration', [adminconttroller::class , 'registiration'])->name('user.registiration');








});
Route::prefix('admin')->group(function () {
    Route::get(' dashboard', [adminconttroller::class , 'admin'])->name('admin.only');

});


