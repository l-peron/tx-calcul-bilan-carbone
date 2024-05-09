<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth',[\App\Http\Controllers\Connexion::class,'auth'])->name('auth_route');
Route::get('/logout',[\App\Http\Controllers\Connexion::class,'logout'])->name('logout_route');

Route::get('/{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');