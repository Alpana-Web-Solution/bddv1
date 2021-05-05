<?php

// Dashboard Route
Route::get('/dashboard', App\Http\Controllers\User\DashboardController::class)
->name('user.dashboard');

Route::resource('donation', App\Http\Controllers\User\DonationController::class);

Route::post('requisition/{requisition}/donation',[App\Http\Controllers\RequisitionController::class,'donation'])
->name('requisition.donation');
// Requisition is accable to everyone.
Route::resource('requisition', App\Http\Controllers\RequisitionController::class)
->withOutMiddleware(['auth'])->except(['edit']);

Route::resource('/requisition.comment', App\Http\Controllers\RequisitionCommentController::class)
->only(['store','destroy']);

// Profile route
Route::get('/profile',[App\Http\Controllers\User\ProfileController::class, 'edit'])
->name('user.profile');

Route::post('/profile/update',[App\Http\Controllers\User\ProfileController::class, 'update'])
->name('user.profile.update');