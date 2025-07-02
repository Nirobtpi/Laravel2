<?php

use App\Http\Controllers\DbQueryController;
use App\Http\Controllers\ModelConventionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

route::get('book',[StudentController::class,'index']);
route::get('users',[StudentController::class,'users'])->name('users');
route::get('view/{id}',[StudentController::class,'view'])->name('view');
Route::get('update/{id}',[StudentController::class,'update'])->name('update');
Route::put('user/{id}',[StudentController::class,'updateUser'])->name('updateUser');
Route::get('students',[StudentController::class,'stData'])->name('students');
Route::get('student/update/{id}',[StudentController::class,'updateStudent'])->name('updateStudent');
Route::put('student/update/{id}',[StudentController::class,'studentUpdate'])->name('studentUpdate');


Route::get('view/{id}/author',[StudentController::class,'authorView'])->name('authorView');
Route::get('union',[StudentController::class,'UnionItem'])->name('UnionItem');

Route::get('db',[DbQueryController::class,'insertData']);
Route::get('db/showdata',[DbQueryController::class,'showData']);
Route::get('db/updatedata/{id}',[DbQueryController::class,'updateData']);
Route::get('db/deletedata/{id}',[DbQueryController::class,'deleteData']);

Route::resource('user',UserController::class);
Route::resource('model',ModelConventionController::class);
Route::resource('role',RoleController::class);
