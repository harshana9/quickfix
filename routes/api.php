<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Common Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\BreakdownController;
use App\Http\Controllers\PHPMailerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MerchantAlertController;
use App\Http\Controllers\EmailCarbonCopyPersonController;
use App\Http\Controllers\SheduleController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\AutofillController;
use App\Http\Controllers\ReportController;

//Public Routes
Route::post('login', [AuthController::class, 'login']);

//Testing
//Route::post("sendmail", [PHPMailerController::class, "testEmail"]);
//Route::post("kert", [testController::class, "kernel_auto_email"]);

//Protected Routes
Route::group(['middleware'=>['auth:sanctum']], function()
{

    //Authentication
    Route::post('logout', [AuthController::class, 'logout']);

    //User
    Route::post('user/create', [UserController::class, 'register'])->middleware('restrictRole:admin');
    Route::get('user/view', [UserController::class, 'retrive'])->middleware('restrictRole:admin');
    Route::get('user/view/{id}', [UserController::class, 'find'])->middleware('restrictRole:admin');
    Route::put('user/update/{id}', [UserController::class, 'update']);
    Route::delete('user/delete/{id}', [UserController::class, 'delete'])->middleware('restrictRole:admin');
    Route::put('user/reset_password/{id}', [UserController::class, 'reset_password'])->middleware('restrictRole:admin');
    Route::put('user/update_role/{id}', [UserController::class, 'update_role'])->middleware('restrictRole:admin');

    //Vendor
    Route::post('vendor/create', [VendorController::class, 'create'])->middleware('restrictRole:admin');
    Route::get('vendor/view', [VendorController::class, 'retrive']);
    Route::get('vendor/view/{id}', [VendorController::class, 'find']);
    Route::put('vendor/update/{id}', [VendorController::class, 'update'])->middleware('restrictRole:admin');
    Route::delete('vendor/delete/{id}', [VendorController::class, 'delete'])->middleware('restrictRole:admin');

    //Product
    Route::post('product/create', [ProductController::class, 'create'])->middleware('restrictRole:admin');
    Route::get('product/view', [ProductController::class, 'retrive']);
    Route::get('product/view/{id}', [ProductController::class, 'find']);
    Route::get('product/view/byvendor/{id}', [ProductController::class, 'retrive_by_vendor']);
    Route::put('product/update/{id}', [ProductController::class, 'update'])->middleware('restrictRole:admin');
    Route::delete('product/delete/{id}', [ProductController::class, 'delete'])->middleware('restrictRole:admin');

    //Status
    Route::post('status/create', [StatusController::class, 'create'])->middleware('restrictRole:admin');
    Route::get('status/view', [StatusController::class, 'retrive']);
    Route::get('status/view/{id}', [StatusController::class, 'find']);
    Route::put('status/update/{id}', [StatusController::class, 'update'])->middleware('restrictRole:admin');
    Route::delete('status/delete/{id}', [StatusController::class, 'delete'])->middleware('restrictRole:admin');

    //Breakdown
    Route::post('breakdown/create', [BreakdownController::class, 'create'])->middleware('restrictRole:user');
    Route::get('breakdown/search/{page_size}/{status}', [BreakdownController::class, 'retrive_all'])->middleware('restrictRole:user');
    Route::get('breakdown/search/{page_size}/{status}/{keyword}/', [BreakdownController::class, 'retrive'])->middleware('restrictRole:user');
    Route::get('breakdown/view/{id}', [BreakdownController::class, 'find'])->middleware('restrictRole:user');
    Route::get('breakdown/log_history/{breakdown_id}', [BreakdownController::class, 'log_history']);
    Route::put('breakdown/update/{id}', [BreakdownController::class, 'update'])->middleware('restrictRole:user');
    Route::delete('breakdown/delete/{id}', [BreakdownController::class, 'delete'])->middleware('restrictRole:user');
    Route::put('breakdown/status_update/{id}', [BreakdownController::class, 'status_update'])->middleware('restrictRole:user');

    //CCPerson
    Route::post('ccperson/create', [EmailCarbonCopyPersonController::class, 'create'])->middleware('restrictRole:admin');
    Route::get('ccperson/view', [EmailCarbonCopyPersonController::class, 'retrive']);
    Route::get('ccperson/view/{id}', [EmailCarbonCopyPersonController::class, 'find']);
    Route::put('ccperson/update/{id}', [EmailCarbonCopyPersonController::class, 'update'])->middleware('restrictRole:admin');
    Route::delete('ccperson/delete/{id}', [EmailCarbonCopyPersonController::class, 'delete'])->middleware('restrictRole:admin');

    //Supervisor
    Route::get('supervisor/auth_queue/{page_size}', [SupervisorController::class, 'retrive_all'])->middleware('restrictRole:supervisor');
    Route::get('supervisor/auth_queue/find/{id}', [SupervisorController::class, 'find'])->middleware('restrictRole:supervisor');
    Route::put('supervisor/auth/{id}', [SupervisorController::class, 'auth'])->middleware('restrictRole:supervisor');
    //Route::delete('ccperson/delete/{id}', [SupervisorController::class, 'delete'])->middleware('restrictRole:supervisor');

    //Autofill Data
    Route::get('autofill/mid/{mid}', [AutofillController::class, 'find_by_mid'])->middleware('restrictRole:user');
    Route::get('autofill/tid/{tid}', [AutofillController::class, 'find_by_tid'])->middleware('restrictRole:user');

    //Reports
    Route::get('reports/frequents/pdf', [ReportController::class, 'generatePDF'])->middleware('restrictRole:user');
    
    //Optional Manual Tasks
    Route::get('manual/merchant_alert/{id}', [MerchantAlertController::class, 'status_update_email'])->middleware('restrictRole:user');
    Route::get('manual/vendor_alert/{id}', [MerchantAlertController::class, 'status_update_email_to_vendor'])->middleware('restrictRole:user');
    Route::get('manual/late_alert', [SheduleController::class, 'two_day_late_email'])->middleware('restrictRole:user');
});