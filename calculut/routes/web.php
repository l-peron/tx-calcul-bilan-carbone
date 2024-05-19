<?php

use App\Http\Controllers\Connexion;
use App\Http\Middleware\Authentication;
use Illuminate\Support\Facades\Route;

Route::get('/auth',[Connexion::class,'auth'])->name('auth_route');
Route::get('/logout',[Connexion::class,'logout'])->name('logout_route');

/*
Route::get('/', function () {
    return view('welcome');
})->middleware(Authentication::class);

Route::get('/{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*')->middleware(Authentication::class);
*/
