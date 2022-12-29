<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ProfileController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('admin.login');
});

Route::get('/dashboard', function () {
    return view('admin.control-panel');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->middleware(['admin'])->group( function() {

    // show view users table
    Route::get('/users', [UsersController::class, 'showUsers'])->name('users');

    // show view create user
    Route::get('/user-new', [UsersController::class, 'newUsers'])->name('users.new');

    // create new user
    Route::post('/user-new', [UsersController::class, 'createUsers'])->name('users.create');

     // show view users edit
     Route::get('/user-edit/{id}', [UsersController::class, 'showEditForm'])->name('users.editForm');

      // form users edit
      Route::put('/user-edit/{id}', [UsersController::class, 'updateUser'])->name('users.update');

    //   delete user
    Route::delete('/user-delete/{id}', [UsersController::class,'deleteUser'])->name('users.delete');

});

Route::prefix('admin')->middleware(['auth'])->group( function() {

    Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('user.profile');

    // update profile
    Route::put('/profile/{id}', [ProfileController::class, 'updateProfile'])->name('user.profile-update');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
