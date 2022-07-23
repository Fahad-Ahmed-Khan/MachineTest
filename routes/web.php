<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::post('/user',[UserController::class,'setUser'])->name('set.user');
Route::group(['middleware' => ['check.user']], function(){
    Route::get('/test',[HomeController::class,'test'])->middleware('check.user')->name('test');
    Route::get('/result',[\App\Http\Controllers\ResultController::class,'index'])->middleware('check.user')->name('results');

    Route::get('/question',[HomeController::class,'getNextQuestion'])->name('next.question');
    Route::post('/answer',[HomeController::class,'checkAns'])->name('submit.answer');
    Route::post('/skip',[HomeController::class,'skipQuestion'])->name('skip.question');
    Route::get('/logout',[UserController::class,'logout'])->name('logout');

});

