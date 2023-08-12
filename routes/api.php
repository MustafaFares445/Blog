<?php

use App\Http\Controllers\AdminDashboard\AdminNotificationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
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

Route::resource('/category' , CategoryController::class);

Route::prefix('/author')->middleware('auth:author')->group(function (){
    Route::resource('/post' , PostController::class)->only('store' , 'update');
});

Route::resource('/post' , PostController::class)->except('store' , 'update');



Route::prefix('/author')->middleware(['auth:author' , 'checkAuthor'])->group(function (){

    Route::put('/updatePost/{post}' , [\App\Http\Controllers\UpdatePost::class , 'updateDetails']);
    Route::put('/updatePostCategory' , [\App\Http\Controllers\UpdatePost::class , 'updateCategory']);
    Route::put('/updatePostTag' , [\App\Http\Controllers\UpdatePost::class , 'updateTag']);
    Route::put('/updatePostPhotos' , [\App\Http\Controllers\UpdatePost::class , 'updatePhotos']);

});

Route::get('/unauthorized' , function (){
   return response()->json(['message' => "unauthorized" , 401]);
})->name('login');


Route::controller(AdminNotificationController::class)->prefix('admin/notifications')->group(function (){
    Route::get('/all' , ' index');
    Route::get('/unread' , ' unread');
    Route::post('/markRead/All' , 'markReadAll');
    Route::delete('/delete/All' , 'deleteAll');
    Route::delete('/delete/{id}' , 'delete');
})->middleware('auth:admin');

require 'auth.php';
