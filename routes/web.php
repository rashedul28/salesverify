<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\salesController;
use App\Http\Controllers\salesmanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Route::middleware(['auth','verified','admin'])->group(function () {
//     Route::get('/admin/dashboard', function () {
//         return 'Admin Dashboard';
//     });
// });

// Route::middleware(['auth','verified','salesman'])->group(function () {
//     Route::get('/salesman/dashboard', function () {
//         return 'Salesman Dashboard';
//     });
// });

Route::post('/dashboard', [adminController::class, 'generateSalesFileMatchTable'])->middleware(['auth', 'verified'])->name('dashboard.post');
Route::get('/dashboard', [adminController::class, 'showSalesFileMatches'])->middleware(['auth', 'verified'])->name('dashboard.get');


Route::get('/dashboard2', [salesController::class, 'SalesDashboard'])->middleware(['auth', 'verified'])->name('dashboard2');
Route::post('/dashboard2/create', [salesController::class, 'SaveSales'])
    ->middleware(['auth', 'verified'])
    ->name('salesman.store');

Route::get('/dashboard2/search', [salesController::class, 'SearchSales'])
    ->middleware(['auth', 'verified'])
    ->name('sales.filter');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/create', [adminController::class, 'create'])->name('admin.create');

    Route::post('/admin/offer-source', [adminController::class, 'store'])->name('admin.offersource');
    Route::post('/admin/offer-name', [adminController::class, 'store'])->name('admin.offername');




    // Route::get('/salesman/create', [salesController::class, 'create'])->name('salesman.create');
    // Route::post('/salesman/store', [salesController::class, 'store'])->name('salesman.store'); 


    Route::get('/admin/files', [adminController::class, 'files'])->name('admin.files'); 
    Route::post('/admin/fileupload', [adminController::class, 'fileUpload'])->name('admin.fileupload'); 


    // Route::post("/admin/report", [adminController::class, 'generateSalesFileMatchTable'])->name('sales.generate-file-matches');   
    // Route::get("/admin/report", [adminController::class, 'showSalesFileMatches'])->name('sales.file-matches.index');  
    
    Route::get('/offers/edit/{id}/{id2}', [adminController::class, 'PassKey'])->name('offers.edit');
    Route::get('/offers/edit/ok', [adminController::class, 'EditOffer'])->name('offers.ok');
    Route::get('/offers/delete/{id}/{id2}', [adminController::class, 'DeleteOffer'])->name('offers.delete');

    Route::get('/users', [adminController::class, 'index'])->name('users.index');
    // Route::get('/users/assign-source/{id}', [adminController::class, 'assignSource'])->name('users.assign-source');
    Route::patch('/users/assign-source/{id}', [adminController::class, 'storeAssignedSource'])->name('users.store-assigned-source');
    Route::get('/users/delete/{id}', [adminController::class, 'deleteUser'])->name('users.delete');


    

});

require __DIR__.'/auth.php';
