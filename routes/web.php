<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ManagePlayersController;
use App\Http\Controllers\OfficialsRegistrationController;
use App\Http\Controllers\UserEventController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ManageScoreController;

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('events', EventController::class);

    Route::resource('officials_registration', OfficialsRegistrationController::class);

    Route::get('/user-events', [UserEventController::class, 'index'])
        ->name('user.events')->middleware('auth');

    Route::get('/events-Score', [UserEventController::class, 'AddScore'])
        ->name('user.events.score')->middleware('auth');

    Route::post('/events-score/save', [UserEventController::class, 'SaveScore'])
        ->name('user.events.save_score')->middleware('auth');

    Route::get('/manage-scores', [ManageScoreController::class, 'index'])
        ->name('admin.manage_scores.index');

    Route::post('/manage-scores/{id}/update-status', [ManageScoreController::class, 'updateStatus'])
        ->name('admin.manage_scores.update_status');

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('events/{eventId}/participants', [NotificationController::class, 'getParticipants']);

    Route::post('events/{eventId}/send-email', [NotificationController::class, 'sendEmail']);
});

Route::get('/', function () {
    return view('user.index');
})->name('clashsports');

Route::get('login', function () {
    return view('user.auth.login');
})->name('user.auth.login');

Route::get('faq', function () {
    return view('user.auth.faq');
})->name('user.auth.faq');

Route::get('donation', function () {
    return view('user.auth.donation');
})->name('user.auth.donation');

Route::get('join-now/{id}', [ManagePlayersController::class, 'JoinNow'])
    ->name('user.auth.joinNow');

Route::post('join-now/{id}', [ManagePlayersController::class, 'StripeCheckout'])
    ->name('stripe.checkout.joinNow');

Route::get('stripe/checkout/success', [ManagePlayersController::class, 'StripeCheckoutSuccess'])
    ->name('stripe.checkout.success');

Route::post('login', [ManagePlayersController::class, 'login'])
    ->name('userPost.auth.login');

Route::get('events', [ManagePlayersController::class, 'index'])
    ->name('clashsports.events');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
