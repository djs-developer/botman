<?php

use App\Http\Controllers\botmanController;
use App\Http\Controllers\startchatController;
use Illuminate\Support\Facades\Route;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Middleware\Dialogflow;
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


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('botman');
    });
    // Route::controller(startchatController::class)->group(function () {
    //     Route::match(['get', 'post'], '/botman','start');
    // });

   Route::controller(botManController::class)->group(function () {
   // print_r('ffg');
    Route::match(['get', 'post'], '/botman','handle');
});

Route::get('botdemo/chatserver1',function(){
    return view ('style');
});
 
