<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use Illuminate\Support\Facades\Hash;

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

//Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::middleware(['Admin'])->group(function () {
        // routes for admin pages
            // this route is only accessible to users with the "admin" role
        Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('admin/offices', [DashboardController::class, 'adminOffice'])->name('admin.offices');
        Route::post('admin/addOffice', [DashboardController::class, 'addOffice'])->name('admin.addOffices');;
        Route::get('admin/docType', [DashboardController::class, 'docTypes'])->name('admin.docTypes');;
        Route::post('admin/addDocType', [DashboardController::class, 'addDocType'])->name('admin.addDoctypes');;
        Route::post('admin/delOffice/{id}', [DashboardController::class, 'deleteOffice'])->name('admin.deleteOffice');
        Route::post('admin/enableOffice/{id}', [DashboardController::class, 'enableOffice'])->name('admin.enableOffice');
        Route::post('admin/delDocType/{id}', [DashboardController::class, 'deleteDocType'])->name('admin.deleteDocType');
        Route::post('admin/enableDocType/{id}', [DashboardController::class, 'enableDocType'])->name('admin.enableDocType');
        Route::get('admin/user-management', [UserController::class, 'index'])->name('user');
        Route::get('admin/types-of-reports', [DashboardController::class, 'typesOfReports'])->name('admin.reports');
        Route::post('admin/add-reports', [DashboardController::class, 'addTypeOfReport'])->name('admin.addReport');
        Route::post('admin/delete-report/{id}', [DashboardController::class, 'deleteTypeOfReport']);
        Route::post('admin/enable-report/{id}', [DashboardController::class, 'enableTypeOfReport']);
        Route::get('/user-profile', [ProfileController::class, 'create']);
        Route::post('admin/details', [ProfileController::class, 'store']);
        Route::get('admin/user-management', [UserManagementController::class, 'index'])->name('admin.user-management');
        Route::post('admin/add-user', [UserManagementController::class, 'store'])->name('admin.addUser');
        Route::get('/admin/{id}/edit', [UserManagementController::class, 'edit'])->name('admin.edit');
        Route::put('admin/update-user/{id}', [UserManagementController::class, 'update'])->name('admin.update-user');
        Route::post('/disable-user/{id}', [UserManagementController::class, 'disableUser'])->name('admin.disable-user');
        Route::post('/enable-user/{id}', [UserManagementController::class, 'enableUser'])->name('admin.enable-user');
    });
});

Route::middleware(['auth'])->group(function () {

    //Documents Controller
    Route::get('add-document', [DocumentsController::class, 'showOffices'])->name('add-document');
    Route::get('download/{token}', [DocumentsController::class, 'fileGenerator'])->name('download');
    Route::post('add-documents', [DocumentsController::class, 'store'])->name('add-documents');
    // Route::get('add-document', [DocumentsController::class, 'store']);
    Route::get('documents', [DocumentsController::class, 'userDocs']);
    Route::get('/documents/completed', [DocumentsController::class, 'completedDocs']);
    Route::get('/documents/circulating', [DocumentsController::class, 'circulatingDocs']);
    Route::get('/documents/sentBack', [DocumentsController::class, 'sentBackDocs']);

    //Qr Controllers
    Route::get('qrinfo/{referenceNo}', [QrController::class, 'qrInfo']);
    Route::get('forward/{referenceNo}', [QrController::class, 'forward']);
    Route::post('qrinfo/forward/{referenceNo}', [QrController::class, 'forwardDoc']);
    Route::get('receive/{referenceNo}', [QrController::class, 'receive']);
    Route::post('qrinfo/received/{referenceNo}', [QrController::class, 'receiveDoc']);
    Route::post('qrinfo/send-back/{referenceNo}', [QrController::class, 'sendBack']);
    Route::post('qrinfo/fix-issue/{referenceNo}', [QrController::class, 'fixIssue']);
    Route::post('qrinfo/process/{referenceNo}' , [QrController::class, 'processDoc']);
    Route::get('/search', [QrController::class, 'search']);
    Route::get('/altSearch', [QrController::class, 'altSearch']);
    Route::post('/qrinfo/rejected/{referenceNo}', [QrController::class, 'rejectDocument'])->name('document.reject');
    Route::post('/qrinfo/return-to-sender/{referenceNo}', [QrController::class, 'returnToSender']);
    Route::post('/qrinfo/resolve/{referenceNo}', [QrController::class, 'resolveDoc']);
    Route::post('/qrinfo/resubmit/{referenceNo}', [QrController::class, 'resubmitDoc']);
    Route::post('/qrinfo/approved-and-kept/{referenceNo}', [QrController::class, 'approveAndKeep']);
    Route::post('/qrinfo/approved-and-return/{referenceNo}', [QrController::class, 'approveAndReturn']);
    Route::post('/qrinfo/reject-return-to-previous/{referenceNo}', [QrController::class, 'rejectedReturnToPrevious']);
    Route::post('/qrinfo/reject-return-to-sender/{referenceNo}', [QrController::class, 'rejectedReturnToSender']);

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('offices', [DashboardController::class, 'adminOffice']);
    Route::post('addOffice', [DashboardController::class, 'addOffice']);
    Route::get('docType', [DashboardController::class, 'docTypes']);
    Route::post('addDocType', [DashboardController::class, 'addDocType']);
    Route::delete('delOffice/{id}', [DashboardController::class, 'deleteOffice'])->middleware('password.confirm');
    Route::delete('delDocType/{id}', [DashboardController::class, 'deleteDocType']);

    Route::get('searchByDate', [SearchController::class, 'dateFilter']);
    Route::get('filterByRcvOffice', [SearchController::class, 'rcvOfficeFilter']);
    Route::post('/filters/search',[ DocumentsController::class, 'searchTest'])->name('document.search');

    Route::get('/getLiveUpdate', [DocumentsController::class, 'getOfficeByUser']);
    Route::get('/', [HomeController::class, 'index']);
});
// Route::post('/check-password', function(Request $request) {
//     dd('passswordchecking');
//     // Get the password from the request
//     $password = $request->input('password');

//     // Check if the password is valid (replace this with your own password validation code)
//     $valid = $password === 'mysecretpassword';

//     // Return a JSON response with the validation result
//     return response()->json(['valid' => $valid]);
//   });
// Route::group(['middleware' => 'auth'], function () {
// 	Route::get('dashboard', function () {
// 		return view('dashboard');
// 	})->name('dashboard');

// 	// Route::get('billing', function () {
// 	// 	return view('billing');
// 	// })->name('billing');

// 	// Route::get('profile', function () {
// 	// 	return view('profile');
// 	// })->name('profile');

//     // Route::get('/logout', [SessionsController::class, 'destroy']);
// 	// Route::get('/user-profile', [InfoUserController::class, 'create']);
// 	// Route::post('/user-profile', [InfoUserController::class, 'store']);
//     Route::get('/login', function () {
// 		return view('dashboard');
// 	})->name('sign-up');
// });
Route::get('/logout', [SessionsController::class, 'destroy'])->name('logout');
Route::get('/register', [RegisterController::class, 'create']);
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/login', [SessionsController::class, 'create']);
Route::post('/session', [SessionsController::class, 'authenticate']);
Route::get('/login/forgot-password', [ResetController::class, 'create']);
Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
//Search Controllers
Route::get('index', [SearchController::class, 'search']);
Route::get('tracking', [SearchController::class, 'search']);
Route::get('index', [DocumentsController::class, 'index'])->name('index');

Route::get('/coming', function () {
    return view('unused.coming');
});

Auth::routes();

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
