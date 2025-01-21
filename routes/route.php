<?php
use App\Controllers\ConvertController;
use Support\Route;
use Support\View;
use Support\AuthMiddleware; //<-- Penambahan Middleware atau session login

// handleMiddleware();
Route::get('/',function(){
    return view('home');
});
Route::post('/converts',[ConvertController::class,'convert']);