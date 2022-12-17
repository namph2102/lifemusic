<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
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
    return view('layouts.home');
});
Route::get('', [HomeController::class, 'index'])->name('music.trangchu');
Route::get('/home', [HomeController::class, 'index'])->name('music.home');

Route::get('/chinh-sach.html', [HomeController::class, 'chinhsach'])->name('chinhsach');
Route::get('/bao-mat.html', [HomeController::class, 'baomat'])->name('baomat');

Route::get('/home', [HomeController::class, 'index'])->name('music.home');
Route::get('/music', [HomeController::class, 'index'])->name('music.home');
Route::get('/music-{slug?}', [HomeController::class, 'index'])->name('music.home');
Route::get('/explore', [HomeController::class, 'index'])->name('music.home');
Route::get('/history', [HomeController::class, 'index'])->name('music.home');
Route::get('/album', [HomeController::class, 'index'])->name('music.home');
Route::get('/trend', [HomeController::class, 'index'])->name('music.home');
Route::get('/myapp', [HomeController::class, 'index'])->name('music.home');
Route::get('/artists', [HomeController::class, 'index'])->name('music.home');

Route::get('/form', [HomeController::class, 'form'])->name('post');

Route::get('/changepassword', [HomeController::class, 'changepassword']);

Route::get('/formlogin', [HomeController::class, 'login'])->name('post');
Route::get('/upload', [HomeController::class, 'uploadimage'])->name('uploadimage');

Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

Route::get('/albums', [HomeController::class, 'playlist'])->name('playlist');

Route::get('/comment', [HomeController::class, 'binhluan'])->name('comment');
Route::get('/checkuser', [HomeController::class, 'checkuser'])->name('checkuser');

Route::get('/uploadview', [HomeController::class, 'uploadview']);
Route::get('/updatetime', [HomeController::class, 'updatetime']);



Route::prefix('admin')->middleware('checkadmin')->group(function(){
    Route::get('/',[AdminController::class,'dashboard'])->name('users.home');
     Route::get('home',[AdminController::class,'dashboard'])->name('users.home');
    Route::get('users',[AdminController::class,'index'])->name('users.show');
    Route::get('formedit',[AdminController::class,'formusers'])->name('users.edit');
    Route::post('formedit',[AdminController::class,'formusers'])->name('users.edit');
    Route::get('formfind',[AdminController::class,'finduser'])->name('users.find');


    Route::get('songs',[AdminController::class,'showsongs'])->name('song.show');
    Route::get('songsadd',[AdminController::class,'formmusic'])->name('song.add');
    Route::post('songsadd',[AdminController::class,'formmusic'])->name('song.add');

    Route::get('songsfind',[AdminController::class,'songsfind'])->name('song.find');
    Route::post('songsfind',[AdminController::class,'songsfind'])->name('song.find');

    Route::get('singer',[AdminController::class,'singers'])->name('singer.show');
    Route::post('singer',[AdminController::class,'singers'])->name('singer.show');

    Route::get('singeredit',[AdminController::class,'singersEdit'])->name('singer.edit');
    Route::post('singeredit',[AdminController::class,'singersEdit'])->name('singer.edit');

    Route::get('singerfind',[AdminController::class,'singersfind'])->name('singer.find');
    Route::post('singerfind',[AdminController::class,'singersfind'])->name('singer.find');
});
