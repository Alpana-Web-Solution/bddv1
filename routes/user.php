<?php
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