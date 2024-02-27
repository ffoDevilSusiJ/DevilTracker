<?php

use App\Http\Controllers\Auth\JoinController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Mail\InviteLinkController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['auth'])->group(function () {

    Route::namespace('Workspace')->group(function () {
        Route::get('/', [WorkspaceController::class,'showDashboard'])->name('dashboard');
    });

    Route::namespace('Project')->group(function () {
        Route::get('/project/{id}', function ($id) {
            return redirect()->route('project', ['id' => $id, 'view' => 'info']);
        });
        Route::get('/project/{id}/{view}', [WorkspaceController::class,'showProject'])->name('project');

        Route::get('/create', [ProjectController::class,'showForm']);
        Route::post('/create', [ProjectController::class,'store'])->name('project.store');

        Route::delete('/project/{id}/', [ProjectController::class,'destroy'])->name('project.destroy');

    });
    Route::namespace('Member')->group(function () {
        Route::post('/project/{id}/members', [MemberController::class, 'store'])->name('member.store');;
        Route::delete('/project/{project_id}/member/{member_id}', [MemberController::class, 'destroy'])->name('member.destroy');;
    });
    
     Route::namespace('Invite')->group(function () {
        Route::post('/invite', [InviteLinkController::class, 'store']);
        Route::get('/invite/{token}', [InviteLinkController::class, 'confirmLink']);
    });
    
    Route::namespace('Task')->group(function () {
        Route::post('/task', [TaskController::class, 'store']);
        Route::post('/task/{task_id}/status', [TaskController::class, 'status']);

    });
    
});
Route::namespace('Auth')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
    
});

Route::namespace('Auth')->group(function () {
    Route::get('/join', [JoinController::class,'index'])->name('index');
    Route::post('/join', [JoinController::class, 'store'])->name('join.store');
});

Route::namespace('Auth')->group(function () {
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
});

