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








Route::prefix('user')->middleware(['guest', 'web'])->group(function () {

Route::get('registerationform', [adminconttroller::class , 'registirationform'])->name('user.registirationform');
//Route::post('registeration', [adminconttroller::class , 'registiration'])->name('user.registiration');








});
Route::prefix('admin')->group(function () {
    Route::get(' dashboard', [adminconttroller::class , 'admin'])->name('admin.only');

});

Route::get('loginform', [adminconttroller::class , 'loginform'])->name('loginform.user');
