<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\salesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return redirect('/login');});


Route::middleware('auth', 'verified', 'admin')->group(function () {
    Route::post('/dashboard', [adminController::class, 'generateSalesFileMatchTable'])->name('dashboard.post');
    Route::get('/dashboard', [adminController::class, 'showSalesFileMatches'])->name('dashboard.get');
    Route::get('/admin/create', [adminController::class, 'create'])->name('admin.create');
    Route::post('/admin/offer-source', [adminController::class, 'store'])->name('admin.offersource');
    Route::post('/admin/offer-name', [adminController::class, 'store'])->name('admin.offername');
    Route::get('/admin/files', [adminController::class, 'files'])->name('admin.files'); 
    Route::post('/admin/fileupload', [adminController::class, 'fileUpload'])->name('admin.fileupload'); 
    Route::get('/offers/edit/{id}/{id2}', [adminController::class, 'PassKey'])->name('offers.edit');
    Route::get('/offers/edit/ok', [adminController::class, 'EditOffer'])->name('offers.ok');
    Route::get('/offers/delete/{id}/{id2}', [adminController::class, 'DeleteOffer'])->name('offers.delete');
    Route::get('/users', [adminController::class, 'index'])->name('users.index');
    Route::patch('/users/assign-source/{id}', [adminController::class, 'storeAssignedSource'])->name('users.store-assigned-source');
    Route::get('/users/delete/{id}', [adminController::class, 'deleteUser'])->name('users.delete');
});

Route::middleware('auth', 'verified', 'salesman')->group(function () {
   
    Route::get('/dashboard2', [salesController::class, 'SalesDashboard'])->name('dashboard2');
    Route::post('/dashboard2/create', [salesController::class, 'SaveSales'])->name('salesman.store');
    Route::get('/dashboard2/search', [salesController::class, 'SearchSales'])->name('sales.filter');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
