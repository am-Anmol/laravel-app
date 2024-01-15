<?php

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
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', function () {
    return view('ajax-users-listing');
})->name('home');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/users', function () {
    return view('users');
})->name('users');

Route::post('/users/store', [UserController::class,'store'])->name('users.store');
Route::get('/users/show', [UserController::class,'show'])->name('users.show');
Route::get('/admin/show', [UserController::class,'admin_show'])->name('admin.show');
Route::get('/users/search', [UserController::class,'search'])->name('users.search');
// Route::get('/users/ajax-show', function () {
//     return view('ajax-users-listing');
// })->name('users.ajax-show');

Route::get('/users/ajshow', [UserController::class,'ajax_show'])->name('users.ajshow');
Route::get('/users/ajsearch', [UserController::class,'ajax_search'])->name('users.ajsearch');

Route::get('/users/{id}/edit', [UserController::class,'edit'])->name('users.edit');
Route::get('/users/export', [UserController::class,'export'])->name('users.export');

Route::post('/users/import', [UserController::class,'import'])->name('users.import');

Route::get('/users/excel-import', function(){
    return view('import-users');
})->name('users.excel-import');


Route::post('/users/{id}', [UserController::class,'update'])->name('users.update');




//Domain 1: abc.anmol.com
//Domain 2: xyz.anmol.com


//Route::pattern('domain', '(abc.anmol.com | xyz.anmol.com)');

// Route::pattern('domain', '(abc.anmol.com | xyz.anmol.com)', function () {
//     Route::group(['domain' => '{domain}'], function() {
//         Route::get('/', function($domain) {
//             return 'welcome , you are visting this' . $domain;
//         });
//     })
// });


// Route::group(['domain' => '{domain}'], function() {
//     Route::get('/', function($domain) {
//         return 'welcome , you are visting this' . $domain;
//     });
// });




