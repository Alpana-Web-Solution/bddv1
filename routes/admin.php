<?php
    // Administrator Dashboard
Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');

Route::get('/certificate', [App\Http\Controllers\CertificateController::class,'edit'])->name('certificate');
Route::get('/certificate/preview', [App\Http\Controllers\CertificateController::class,'preview'])
->name('certificate.preview');
Route::post('/certificate/update', [App\Http\Controllers\CertificateController::class,'update'])
->name('certificate.update');

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

    // Requisition donation CRUD
Route::resource('requisition.donation', App\Http\Controllers\Admin\RequisitionDonationController::class);

    // Search in database for donor.
Route::get('requisition/{requisition}/donorsearch', App\Http\Controllers\Admin\RequisitionDonorSearchController::class)
->name('requisition.donorsearch.index');

    // Only use for commenting
Route::resource('requisition.comment', App\Http\Controllers\Admin\RequisitionCommentController::class)
->except(['edit']);

    // Settings Update
Route::get('settings',[App\Http\Controllers\Admin\SettingsController::class,'index'])
->name('settings');
Route::post('settings/store',[App\Http\Controllers\Admin\SettingsController::class,'store'])
->name('settings.store');

    // Requisition SEO
Route::put('requisition/{requisition}/seo',[App\Http\Controllers\Admin\RequisitionController::class,'seoUpdate'])
->name('requisition.seo');

Route::resource('requisition', App\Http\Controllers\Admin\RequisitionController::class);

    // Send email to user asking for blood donation.
Route::post('usermanager/{usermanager}/sendmail', [App\Http\Controllers\Admin\UserManagerController::class,'sendMail'])
->name('usermanager.sendmail');

    // User Manager Reset password sent emails.
Route::post('usermanager/{usermanager}/resetpassword', [App\Http\Controllers\Admin\UserManagerController::class,'resetPassword'])
->name('usermanager.resetpassword');

    // Usermanager
Route::resource('usermanager', App\Http\Controllers\Admin\UserManagerController::class);