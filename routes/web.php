<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadDocumentController;


Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/create-subadmin', [AdminController::class, 'show_create_subadmin_form'])
        ->name('admin.create.subadmin.form');
    Route::post('/create-subadmin', [AdminController::class, 'createSubAdmin'])
        ->name('create.subadmin');

    // Subadmin listing
    Route::get('/admin/subadmins', [AdminController::class, 'listSubAdmins'])
        ->name('admin.subadmins');
    Route::get('/admin/subadmins/{id}/edit', [AdminController::class, 'editSubAdmin'])->name('admin.edit.subadmin');
    Route::post('/admin/subadmins/{id}/update', [AdminController::class, 'updateSubAdmin'])->name('admin.update.subadmin');
    Route::delete('/admin/subadmins/{id}', [AdminController::class, 'deleteSubAdmin'])->name('admin.delete.subadmin');
});


// Admin routes
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard')->middleware('is_admin');
});

Route::middleware(['auth', 'is_subadmin'])->group(function () {
    Route::get('/subadmin/dashboard', function () {
        return view('subadmin.dashboard');
    })->name('subadmin.dashboard');
});


Route::middleware(['auth', 'is_subadmin'])->group(function () {
    Route::get('/subadmin/leads/create', [LeadController::class, 'create'])->name('subadmin.leads.create');
    Route::post('/subadmin/leads', [LeadController::class, 'store'])->name('subadmin.leads.store');

    Route::get('/subadmin/leads/{lead}/edit', [LeadController::class, 'edit'])->name('subadmin.leads.edit');
    Route::post('/subadmin/leads/{lead}', [LeadController::class, 'update'])->name('subadmin.leads.update'); // better use PUT

    Route::get('/subadmin/leads/{lead}', [LeadController::class, 'show'])->name('subadmin.leads.show'); // ✅ GET instead of POST

    Route::delete('/subadmin/leads/{lead}', [LeadController::class, 'destroy'])->name('subadmin.leads.destroy');
});


Route::middleware(['auth'])->group(function () {
    // Subadmin: View all leads
    Route::get('subadmin/leads', [LeadController::class, 'index'])->name('subadmin.leads.index');
    Route::get('subadmin/leads/{lead}/documents/create', [LeadDocumentController::class, 'create'])
        ->name('subadmin.leads.documents.create');
    Route::post('subadmin/leads/{lead}/documents', [LeadDocumentController::class, 'store'])
        ->name('subadmin.leads.documents.store');

    Route::get('/leads/documents', [LeadDocumentController::class, 'index'])
        ->name('subadmin.leads.documents.index');


    Route::get('subadmin/leads/{lead}/documents', [LeadDocumentController::class, 'show'])
        ->name('subadmin.leads.documents.show');
});




Route::post('/admin/logout', function () {
    Auth::logout();
    return redirect()->route('admin.login');
})->name('admin.logout');

Route::get('/', function () {
    return view('welcome');
});
