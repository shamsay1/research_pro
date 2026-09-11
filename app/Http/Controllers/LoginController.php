<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function showlogin(){
        return view('login');
    }

public function dashboard()
{
    /*
    |--------------------------------------------------------------------------
    | CHECK LOGGED IN USER
    |--------------------------------------------------------------------------
    */

    $user = null;
    $role = null;
    $guard = null;

    // System User: Admin / Supervisor / Teacher
    if (Auth::guard('web')->check()) {

        $user = Auth::guard('web')->user();
        $role = $user->role;
        $guard = 'web';

    }

    // Student
    elseif (Auth::guard('student')->check()) {

        $user = Auth::guard('student')->user();
        $role = 'student';
        $guard = 'student';

    }

    // Hakuna aliye-login
    else {

        return redirect()->route('login');

    }


    /*
    |--------------------------------------------------------------------------
    | DEFAULT VALUES
    |--------------------------------------------------------------------------
    */

    $researchProjects = 0;
    $registeredStudents = 0;
    $supervisors = 0;
    $completedResearch = 0;

    $recentResearch = collect();

    $completed = 0;
    $inProgress = 0;
    $pending = 0;

    $completedPercentage = 0;
    $inProgressPercentage = 0;
    $pendingPercentage = 0;


    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */

    if ($role === 'admin') {

        /*
        |--------------------------------------------------------------------------
        | TOTAL RESEARCH PROJECTS
        |--------------------------------------------------------------------------
        */

        $researchProjects = DB::table('research_proposals')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL STUDENTS
        |--------------------------------------------------------------------------
        */

        $registeredStudents = DB::table('students')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL SUPERVISORS
        |--------------------------------------------------------------------------
        */

        $supervisors = DB::table('system_users')
            ->where('role', 'supervisors')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | COMPLETED RESEARCH
        |--------------------------------------------------------------------------
        |
        | Tunatumia completed kama status kuu ya completion.
        | approved pia inahesabiwa kama completed.
        |
        */

        $completedResearch = DB::table('research_proposals')
            ->whereIn('status', ['completed', 'approved'])
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RECENT RESEARCH PROJECTS
        |--------------------------------------------------------------------------
        */

        $recentResearch = DB::table('research_proposals')
            ->join(
                'students',
                'research_proposals.student_id',
                '=',
                'students.id'
            )
            ->select(
                'research_proposals.id',
                'research_proposals.title',
                'research_proposals.status',
                'research_proposals.created_at',
                'students.firstname',
                'students.lastname'
            )
            ->orderBy(
                'research_proposals.created_at',
                'desc'
            )
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RESEARCH STATUS
        |--------------------------------------------------------------------------
        */

        $completed = DB::table('research_proposals')
            ->whereIn('status', ['completed', 'approved'])
            ->count();


        $inProgress = DB::table('research_proposals')
            ->whereIn('status', [
                'under_review',
                'in_progress'
            ])
            ->count();


        $pending = DB::table('research_proposals')
            ->whereIn('status', [
                'pending',
                'correction'
            ])
            ->count();

    }


    /*
    |--------------------------------------------------------------------------
    | SUPERVISOR DASHBOARD
    |--------------------------------------------------------------------------
    */

    elseif ($role === 'supervisors') {

        /*
        |--------------------------------------------------------------------------
        | GET STUDENTS ASSIGNED TO THIS SUPERVISOR
        |--------------------------------------------------------------------------
        */

        $studentIds = DB::table('supervisor_assignments')
            ->where('teacher_id', $user->id)
            ->where('status', 'active')
            ->pluck('student_id')
            ->unique();


        /*
        |--------------------------------------------------------------------------
        | MY STUDENTS
        |--------------------------------------------------------------------------
        */

        $registeredStudents = $studentIds->count();


        /*
        |--------------------------------------------------------------------------
        | RESEARCH PROJECTS FOR MY STUDENTS
        |--------------------------------------------------------------------------
        */

        $researchProjects = DB::table('research_proposals')
            ->whereIn(
                'student_id',
                $studentIds
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SUPERVISOR COUNT
        |--------------------------------------------------------------------------
        */

        $supervisors = 1;


        /*
        |--------------------------------------------------------------------------
        | COMPLETED RESEARCH
        |--------------------------------------------------------------------------
        */

        $completedResearch = DB::table('research_proposals')
            ->whereIn(
                'student_id',
                $studentIds
            )
            ->whereIn(
                'status',
                ['completed', 'approved']
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RECENT STUDENT RESEARCH
        |--------------------------------------------------------------------------
        */

        $recentResearch = DB::table('research_proposals')
            ->join(
                'students',
                'research_proposals.student_id',
                '=',
                'students.id'
            )
            ->whereIn(
                'research_proposals.student_id',
                $studentIds
            )
            ->select(
                'research_proposals.id',
                'research_proposals.title',
                'research_proposals.status',
                'research_proposals.created_at',
                'students.firstname',
                'students.lastname'
            )
            ->orderBy(
                'research_proposals.created_at',
                'desc'
            )
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RESEARCH STATUS
        |--------------------------------------------------------------------------
        */

        $completed = DB::table('research_proposals')
            ->whereIn(
                'student_id',
                $studentIds
            )
            ->whereIn(
                'status',
                ['completed', 'approved']
            )
            ->count();


        $inProgress = DB::table('research_proposals')
            ->whereIn(
                'student_id',
                $studentIds
            )
            ->whereIn(
                'status',
                [
                    'under_review',
                    'in_progress'
                ]
            )
            ->count();


        $pending = DB::table('research_proposals')
            ->whereIn(
                'student_id',
                $studentIds
            )
            ->whereIn(
                'status',
                [
                    'pending',
                    'correction'
                ]
            )
            ->count();

    }


    /*
    |--------------------------------------------------------------------------
    | STUDENT DASHBOARD
    |--------------------------------------------------------------------------
    */

    elseif ($role === 'student') {

        /*
        |--------------------------------------------------------------------------
        | STUDENT ID
        |--------------------------------------------------------------------------
        */

        $studentId = $user->id;


        /*
        |--------------------------------------------------------------------------
        | STUDENT PROFILE
        |--------------------------------------------------------------------------
        */

        $registeredStudents = 1;


        /*
        |--------------------------------------------------------------------------
        | MY RESEARCH PROJECTS
        |--------------------------------------------------------------------------
        */

        $researchProjects = DB::table('research_proposals')
            ->where(
                'student_id',
                $studentId
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | MY SUPERVISOR
        |--------------------------------------------------------------------------
        */

        $supervisors = DB::table('supervisor_assignments')
            ->where(
                'student_id',
                $studentId
            )
            ->where(
                'status',
                'active'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | COMPLETED RESEARCH
        |--------------------------------------------------------------------------
        */

        $completedResearch = DB::table('research_proposals')
            ->where(
                'student_id',
                $studentId
            )
            ->whereIn(
                'status',
                ['completed', 'approved']
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | MY RECENT RESEARCH PROJECTS
        |--------------------------------------------------------------------------
        */

        $recentResearch = DB::table('research_proposals')
            ->where(
                'student_id',
                $studentId
            )
            ->select(
                'id',
                'title',
                'status',
                'created_at'
            )
            ->orderBy(
                'created_at',
                'desc'
            )
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | MY RESEARCH STATUS
        |--------------------------------------------------------------------------
        */

        $completed = DB::table('research_proposals')
            ->where(
                'student_id',
                $studentId
            )
            ->whereIn(
                'status',
                ['completed', 'approved']
            )
            ->count();


        $inProgress = DB::table('research_proposals')
            ->where(
                'student_id',
                $studentId
            )
            ->whereIn(
                'status',
                [
                    'under_review',
                    'in_progress'
                ]
            )
            ->count();


        $pending = DB::table('research_proposals')
            ->where(
                'student_id',
                $studentId
            )
            ->whereIn(
                'status',
                [
                    'pending',
                    'correction'
                ]
            )
            ->count();

    }


    /*
    |--------------------------------------------------------------------------
    | UNKNOWN ROLE
    |--------------------------------------------------------------------------
    */

    else {

        abort(
            403,
            'Unauthorized role.'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CALCULATE RESEARCH STATUS PERCENTAGES
    |--------------------------------------------------------------------------
    */

    $totalResearch =
        $completed +
        $inProgress +
        $pending;


    if ($totalResearch > 0) {

        $completedPercentage =
            round(
                ($completed / $totalResearch) * 100
            );


        $inProgressPercentage =
            round(
                ($inProgress / $totalResearch) * 100
            );


        $pendingPercentage =
            round(
                ($pending / $totalResearch) * 100
            );

    }


    /*
    |--------------------------------------------------------------------------
    | RETURN DASHBOARD
    |--------------------------------------------------------------------------
    */

    return view(
        'dashboard',
        compact(
            'user',
            'role',
            'guard',

            'researchProjects',
            'registeredStudents',
            'supervisors',
            'completedResearch',

            'recentResearch',

            'completed',
            'inProgress',
            'pending',

            'completedPercentage',
            'inProgressPercentage',
            'pendingPercentage'
        )
    );
}



    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');


    // =====================================================
    // SYSTEM USER LOGIN
    // Admin / Supervisor / Teacher
    // =====================================================

    if (Auth::guard('web')->attempt($credentials)) {

        $request->session()->regenerate();

        $user = Auth::guard('web')->user();

        // ADMIN
        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }

        // SUPERVISOR
        if ($user->role === 'supervisors') {
            return redirect()->route('dashboard');
        }

        // TEACHER
        if ($user->role === 'teacher') {
            return redirect()->route('dashboard');
        }

        // =================================================
        // ROLE HAITAMBULIKI
        // =================================================

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()
            ->withInput($request->only('email'))
            ->with(
                'error',
                'Huna ruhusa ya kuingia kwenye mfumo.'
            );
    }


    // =====================================================
    // STUDENT LOGIN
    // =====================================================

    if (Auth::guard('student')->attempt($credentials)) {

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }


    // =====================================================
    // LOGIN FAILED
    // =====================================================

    return back()
        ->withInput($request->only('email'))
        ->with(
            'error',
            'Incorrect email or password.'
        );
}


    

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        Auth::guard('student')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login1');
    }

}
