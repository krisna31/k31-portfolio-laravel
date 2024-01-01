<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Web\NoteController;
use App\Http\Controllers\Web\ProfileController;
use App\Models\Portfolio;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Portfolio', [
        'portfolio' => Portfolio::with('skillSets', 'contactMeLinks')->where('is_use', 1)->first(),
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::group(['prefix' => 'breeze'], function () {
        Route::get('/', function () {
            return Inertia::render('Welcome');
        })->name('welcome');

        Route::resources([
            'notes' => NoteController::class,
        ]);
    });

});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::get('/auth/{provider}/redirect', [AuthenticatedSessionController::class, 'providerRedirect']);

// Route::get('/auth/{provider}/callback', [AuthenticatedSessionController::class, 'providerCallback']);

// require __DIR__.'/auth.php';

// Route::get('/login', function () {
//     return redirect(route('filament.admin.auth.login'));
// })->name('login');
