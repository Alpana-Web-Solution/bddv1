<?php

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('landing');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');

Route::group(['middleware'=>'auth'],function(){

    // Dashboard Route
    Route::get('/dashboard', App\Http\Controllers\User\DashboardController::class)->name('user.dashboard');

    Route::resource('donation', App\Http\Controllers\User\DonationController::class);

    // Requisition is accable to everyone.
    Route::resource('requisition', App\Http\Controllers\RequisitionController::class)
    ->withOutMiddleware(['auth'])->except(['edit']);

    Route::resource('/requisition.comment', App\Http\Controllers\RequisitionCommentController::class)->only(['store','destroy']);

    // Profile route
    Route::get('/profile',[App\Http\Controllers\User\ProfileController::class, 'edit'])->name('user.profile');
    
    Route::post('/profile/update',[App\Http\Controllers\User\ProfileController::class, 'update'])->name('user.profile.update');
    
});
Route::name('admin.')->prefix('admin')->middleware(['admincheck'])->group(function () {
    // Administrator Dashboard
    Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');

    Route::get('/certificate', [App\Http\Controllers\CertificateController::class,'edit'])->name('certificate');
    Route::get('/certificate/preview', [App\Http\Controllers\CertificateController::class,'preview'])->name('certificate.preview');
    Route::post('/certificate/update', [App\Http\Controllers\CertificateController::class,'update'])->name('certificate.update');

    // Show donation certificate page
    Route::get('donation/{donation}/certificate/download', [App\Http\Controllers\CertificateController::class,'certificateDownload'])->name('donation.certificate.download');

    Route::resource('donation', App\Http\Controllers\Admin\DonationController::class);

    Route::resource('donor', App\Http\Controllers\Admin\DonorController::class)->only(['index','show']);

    // Edit a static page
    Route::get('/page/{slug}/edit',[App\Http\Controllers\Admin\PageController::class,'edit'])
    ->name('page.edit');
    // Update a static page
    Route::post('/page/{slug}/update',[App\Http\Controllers\Admin\PageController::class,'update'])
    ->name('page.update');

    // Pincode
    Route::resource('pincode', App\Http\Controllers\Admin\PincodeController::class);

    // Only use for commenting
    Route::resource('requisition.comment', App\Http\Controllers\Admin\RequisitionCommentController::class)
    ->except(['edit']);

    // Requisition donation *Refomat to get and post.
    Route::resource('requisition.donation', App\Http\Controllers\Admin\RequisitionDonationController::class)
    ->only(['index','store','create']);

    // Search in database for donor.
    Route::get('requisition/{requisition}/donorsearch', App\Http\Controllers\Admin\RequisitionDonorSearchController::class)->name('requisition.donorsearch.index');

    // Only use for commenting
    Route::resource('requisition.comment', App\Http\Controllers\Admin\RequisitionCommentController::class)
    ->except(['edit']);

    // Settings Update
    Route::get('settings',[App\Http\Controllers\Admin\SettingsController::class,'index'])->name('settings');
    Route::post('settings/store',[App\Http\Controllers\Admin\SettingsController::class,'store'])->name('settings.store');

    // Requisition SEO
    Route::put('requisition/{requisition}/seo',[App\Http\Controllers\Admin\RequisitionController::class,'seoUpdate'])->name('requisition.seo');

    Route::resource('requisition', App\Http\Controllers\Admin\RequisitionController::class);

    // Send email to user asking for blood donation.
    Route::post('usermanager/{usermanager}/sendmail', [App\Http\Controllers\Admin\UserManagerController::class,'sendMail'])->name('usermanager.sendmail');

    // User Manager Reset password sent emails.
    Route::post('usermanager/{usermanager}/resetpassword', [App\Http\Controllers\Admin\UserManagerController::class,'resetPassword'])->name('usermanager.resetpassword');

    // Usermanager
    Route::resource('usermanager', App\Http\Controllers\Admin\UserManagerController::class);
    
});