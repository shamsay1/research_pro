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


Route::middleware(['auth.check:web,student'])->group(function () {
        Route::get(
            '/dashboard',
            [LoginController::class, 'dashboard']
        )->name('dashboard');
         Route::resource('/student',StudentController::class);
         Route::get(
    '/supervisor-assignments',
    [UserController::class, 'index1']
    )->name('supervisor.assignments.index');
    Route::resource(
                '/staff',
                UserController::class
            );
    Route::get(
    '/supervisor/students',
        [UserController::class, 'students']
    )->name('supervisor.students');
    Route::get(
    '/supervisor/research',
    [ResearchProposalController::class, 'supervisorResearch']
    )->name('supervisor.research');
    Route::get( '/admin/chats', [ChatController::class, 'adminChats'] )->name('admin.chats');
       Route::get( '/admin/research-report', [ResearchReportController::class, 'index'] )->name('admin.research.report'); 
       Route::get(
    '/admin/research/{studentId}',
    [UserController::class, 'researchDetails']
)->name('admin.research.details');
Route::get(
    '/researches',
    [ResearchProposalController::class, 'index']
)->name('student.research');
Route::get(
        '/student/research/responses',
        [ResearchProposalController::class, 'responses']
    )->name('student.research.responses');
Route::get( '/chates/chat', [ChatController::class, 'studentChat'] )->name('student.chat'); 
  Route::get(
    '/settings',
    [SettingsController::class, 'index']
)->name('settings');      
});

    // Route::middleware(['auth.check:web', 'role:supervisors'])->group(function () {
    //     Route::get(
    //         '/dashboard',
    //         [LoginController::class, 'dashboard']
    //     )->name('dashboard');
    //      Route::get(
    // '/supervisor/students',
    //     [UserController::class, 'students']
    // )->name('supervisor.students');
    // Route::get(
    // '/supervisor/research',
    // [ResearchProposalController::class, 'supervisorResearch']
    // )->name('supervisor.research');
        


    // });












        
       
        Route::patch(
    '/staff/{user}/block',
    [UserController::class, 'block']
)->name('staff.block');

Route::patch(
    '/staff/{user}/unblock',
    [UserController::class, 'unblock']
)->name('staff.unblock');





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




// ===============================
// SUPERVISOR STUDENTS
// ===============================




// ===============================
// STAFF
// ===============================


Route::put('/student/{user}', [StudentController::class, 'update'])
    ->name('student.update');

// ===============================
// STUDENT RESEARCH
// ===============================


Route::get('/students/template', [UserController::class, 'downloadTemplate'])
    ->name('students.template');
Route::post('/students/import', [UserController::class, 'import'])
    ->name('students.import');
Route::post(
    '/student/research',
    [ResearchProposalController::class, 'store']
)->name('student.research.store');



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



Route::post(
    '/supervisor-assignments',
    [UserController::class, 'store1']
)->name('supervisor.assignments.store');

Route::put(
    '/supervisor-assignments/{assignment}',
    [UserController::class, 'update']
)->name('supervisor.assignments.update');


Route::put(
    '/settings/password',
    [SettingsController::class, 'updatePassword']
)->name('settings.password');




Route::middleware('auth:student')->group(function () { 
Route::post( '/student/chat/send', [ChatController::class, 'sendMessage'] )->name('student.chat.send'); });
 
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
Route::put(
    '/admin/students/{student}/supervisor',
    [UserController::class, 'updateSupervisor']
)->name('admin.supervisor.update');
Route::delete(
    '/admin/research/{research}',
    [ResearchProposalController::class, 'destroy']
)->name('admin.research.destroy');
Route::get('/forgotpassword',[UserController::class,'forgot'])->name('forgot');
Route::post('/forgot-password/send-token', [UserController::class, 'sendToken'])
    ->name('forgot.password.send');

Route::get('/forgot-password/verify', [UserController::class, 'showVerifyToken'])
    ->name('forgot.password.verify');

Route::post('/forgot-password/verify', [UserController::class, 'verifyToken'])
    ->name('forgot.password.verify.token');

Route::get('/forgot-password/reset', [UserController::class, 'showResetPassword'])
    ->name('forgot.password.reset');

Route::post('/forgot-password/reset', [UserController::class, 'resetPassword'])
    ->name('forgot.password.update');
 Route::put('/settings/profile', [UserController::class, 'updateProfile'])
        ->name('settings.profile');
// =============================== // STUDENT // =============================== 
// Route::resource( '/student', StudentController::class );
