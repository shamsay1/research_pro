<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MysupervisorController;
use App\Http\Controllers\ResearchProposalController;
use App\Http\Controllers\ResearchReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// ===============================
// LOGIN
// ===============================

Route::get(
    '/',
    [LoginController::class, 'showlogin']
)->name('login1');

Route::post(
    '/login',
    [LoginController::class, 'login']
)->name('login');

Route::post(
    '/logout',
    [LoginController::class, 'logout']
)->name('logout');


// ===============================
// DASHBOARD
// ===============================

Route::get(
    '/dashboard',
    [LoginController::class, 'dashboard']
)->name('dashboard');


// ===============================
// SUPERVISOR STUDENTS
// ===============================

Route::get(
    '/supervisor/students',
    [UserController::class, 'students']
)->name('supervisor.students');


// ===============================
// STAFF
// ===============================

Route::resource(
    '/staff',
    UserController::class
);

Route::patch(
    '/staff/{user}/block',
    [UserController::class, 'block']
)->name('staff.block');

Route::patch(
    '/staff/{user}/unblock',
    [UserController::class, 'unblock']
)->name('staff.unblock');


// ===============================
// STUDENT RESEARCH
// ===============================

Route::get(
    '/student/research',
    [ResearchProposalController::class, 'index']
)->name('student.research');

Route::post(
    '/student/research',
    [ResearchProposalController::class, 'store']
)->name('student.research.store');

Route::get(
    '/supervisor/research',
    [ResearchProposalController::class, 'supervisorResearch']
)->name('supervisor.research');

Route::get(
    '/supervisor/research/{research}',
    [ResearchProposalController::class, 'show']
)->name('supervisor.research.show');


// Approve research
Route::patch(
    '/supervisor/research/{research}/approve',
    [ResearchProposalController::class, 'approve']
)->name('supervisor.research.approve');


// Request correction
Route::post(
    '/supervisor/research/{research}/correction',
    [ResearchProposalController::class, 'requestCorrection']
)->name('supervisor.research.correction');
Route::post(
    '/admin/research/{research}/add-correction',
    [ResearchProposalController::class, 'adminAddCorrection']
)
->name('admin.research.addCorrection');
Route::get(
    '/supervisor/research/{research}/download',
    [ResearchProposalController::class, 'download']
)->name('supervisor.research.download');
Route::get(
        '/student/research/responses',
        [ResearchProposalController::class, 'responses']
    )->name('student.research.responses');
Route::get(
        '/student/research/responses1/{id}',
        [ResearchProposalController::class, 'responses1']
    )->name('student.research.responses1');



// ===============================
// STUDENT BLOCK / UNBLOCK
// ===============================

Route::patch(
    '/student/{user}/block',
    [StudentController::class, 'block']
)->name('student.block');

Route::patch(
    '/student/{user}/unblock',
    [StudentController::class, 'unblock']
)->name('student.unblock');


// ===============================
// SUPERVISOR ASSIGNMENTS
// ===============================

Route::get(
    '/supervisor-assignments',
    [UserController::class, 'index1']
)->name('supervisor.assignments.index');

Route::post(
    '/supervisor-assignments',
    [UserController::class, 'store1']
)->name('supervisor.assignments.store');

Route::put(
    '/supervisor-assignments/{assignment}',
    [UserController::class, 'update']
)->name('supervisor.assignments.update');
Route::get(
    '/settings',
    [SettingsController::class, 'index']
)->name('settings');

Route::put(
    '/settings/password',
    [SettingsController::class, 'updatePassword']
)->name('settings.password');
Route::get( '/student/chat', [ChatController::class, 'studentChat'] )->name('student.chat'); 

Route::resource('/student',StudentController::class);
Route::get( '/admin/research-report', [ResearchReportController::class, 'index'] )->name('admin.research.report');
Route::get(
    '/admin/research/{studentId}',
    [UserController::class, 'researchDetails']
)->name('admin.research.details');
Route::middleware('auth:student')->group(function () { 
Route::post( '/student/chat/send', [ChatController::class, 'sendMessage'] )->name('student.chat.send'); });
Route::get( '/admin/chats', [ChatController::class, 'adminChats'] )->name('admin.chats'); // Fungua chat ya student mmoja 
Route::get( '/admin/chat/{studentId}', [ChatController::class, 'adminChat'] )->name('admin.chat'); 
// Admin send message 
Route::post('/notifications/clear-all', [
    UserController::class,
    'clearAll'
])->name('notifications.clearAll');
Route::post( '/admin/chat/{studentId}/send', [ChatController::class, 'adminSendMessage'] )->name('admin.chat.send');
 Route::get(
    '/admin/research/student/{student}/print',
    [ResearchProposalController::class, 'printStudentResearchReport']
)->name('admin.research.student.print');
Route::get(
        '/supervisorsall',
        [MysupervisorController::class, 'mysupervisor']
    )->name('supervisors1');
// =============================== // STUDENT // =============================== 
// Route::resource( '/student', StudentController::class );
