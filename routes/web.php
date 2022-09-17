<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	// Route::get('billing', function () {
	// 	return view('billing');
	// })->name('billing');

	// Route::get('profile', function () {
	// 	return view('profile');
	// })->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	// Route::get('/user-profile', [InfoUserController::class, 'create']);
	// Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/', [HomeController::class, 'home']);

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');

Route::get('/coming', function () {
    return view('unused.coming');
});

//Search Controllers
Route::get('index', [SearchController::class, 'search']);
Route::get('tracking', [SearchController::class, 'search']);


//Comments Controller
Route::post('qrinfo/{referenceNo}/comment', [App\Http\Controllers\CommentsController::class, 'store']);


//Profile Controller
Route::get('/user-profile', [ProfileController::class, 'create']);
Route::post('/details', [ProfileController::class, 'store']);


//User Controller
Route::get('user-management', [UserController::class, 'index'])->name('user');


//Documents Controller
Route::get('index', [DocumentsController::class, 'index'])->name('docs');
Route::get('add-document', [DocumentsController::class, 'showOffices'])->name('offices');
Route::get('download/{token}', [DocumentsController::class, 'fileGenerator'])->name('download');
Route::post('add-documents', [DocumentsController::class, 'store']);
Route::get('documents', [DocumentsController::class, 'userDocs']);


//Qr Controllers
Route::get('qrinfo/{referenceNo}', [QrController::class, 'qrInfo']);
Route::get('forward/{referenceNo}', [QrController::class, 'forward']);
Route::post('qrinfo/forwarded/{referenceNo}', [QrController::class, 'update']);
Route::get('receive/{referenceNo}', [QrController::class, 'receive']);
Route::post('qrinfo/received/{referenceNo}', [QrController::class, 'receiveDoc']);
Route::post('qrinfo/send-back/{referenceNo}', [QrController::class, 'sendBack']);
Route::post('qrinfo/fix-issue/{referenceNo}', [QrController::class, 'fixIssue']);


Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('offices', [DashboardController::class, 'adminOffice']);
Route::post('addOffice', [DashboardController::class, 'addOffice']);
Route::get('docType', [DashboardController::class, 'docTypes']);
Route::post('addDocType', [DashboardController::class, 'addDocType']);
Route::delete('delOffice/{id}', [DashboardController::class, 'deleteOffice']);
Route::delete('delDocType/{id}', [DashboardController::class, 'deleteDocType']);

Route::get('searchByDate', [SearchController::class, 'dateFilter']);
Route::get('filterByRcvOffice', [SearchController::class, 'rcvOfficeFilter']);

Route::get('findCityWithStateID/{id}', [DocumentsController::class, 'getOfficeByUser']);
