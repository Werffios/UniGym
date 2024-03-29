<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return (redirect('/admin'));
});

Route::get('/login', function () {
    return (redirect('/admin'));
});

// ruta para logout
Route::get('/logout', function () {
    Auth::logout();
    return (redirect('/admin'));
});

Route::get('admin/logout', function () {
    Auth::logout();
    return (redirect('/admin'));
});
