<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\GuestbookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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
    // return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/send', [GuestbookController::class, 'store'])->name('send.guestbook');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('registration');
Route::post('registration', [AuthController::class, 'register'])->name('register'); 

Route::group(['middleware' => ['auth']], function() {
	
	Route::get('logout', [AuthController::class, 'logout'])->name('logout');
	Route::get('/changePassword', [AuthController::class, 'changePasswordForm'])->name('change.password.form');
	Route::post('/changePassword', [AuthController::class, 'changePassword'])->name('change.password');
	
	Route::get('/admin/provinces/import', [ProvinceController::class, 'import']);
	Route::post('/admin/provinces/check_name', [ProvinceController::class, 'check_name']);
	Route::post('/admin/provinces/check_code', [ProvinceController::class, 'check_code']);

	Route::get('/admin/cities/import', [CityController::class, 'import']);
	Route::post('/admin/cities/check_name', [CityController::class, 'check_name']);
	Route::post('/admin/cities/check_code', [CityController::class, 'check_code']);

	Route::get('dashboard', [AuthController::class, 'dashboard']); 
});


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group( function () {
    Route::resource('guestbooks', GuestbookController::class);
    Route::resource('provinces', ProvinceController::class);
    Route::resource('cities', CityController::class);
    Route::resource('users', UserController::class);
});