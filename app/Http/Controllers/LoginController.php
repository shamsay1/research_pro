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
            | Total Research Projects
            */

            $researchProjects = DB::table('research_proposals')
                ->count();


            /*
            | Total Students
            */

            $registeredStudents = DB::table('students')
                ->count();


            /*
            | Total Supervisors
            */

            $supervisors = DB::table('system_users')
                ->where('role', 'supervisors')
                ->count();


            /*
            | Completed Research
            */

            $completedResearch = DB::table('research_proposals')
                ->where('status', 'approved')
                ->count();


            /*
            | Recent Research
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
            | Research Status
            */

            $completed = DB::table('research_proposals')
                ->where('status', 'approved')
                ->count();

            $inProgress = DB::table('research_proposals')
                ->where('status', 'under_review')
                ->count();

            $pending = DB::table('research_proposals')
                ->where('status', 'pending')
                ->count();

        }


        /*
        |--------------------------------------------------------------------------
        | SUPERVISOR DASHBOARD
        |--------------------------------------------------------------------------
        */

        elseif ($role === 'supervisors') {

            /*
            | Students assigned to this supervisor
            */

            $registeredStudents = DB::table('supervisor_assignments')
                ->where('teacher_id', $user->id)
                ->where('status', 'active')
                ->count();


            /*
            | Research Projects assigned to this supervisor
            */

            $researchProjects = DB::table('research_proposals')
                ->join(
                    'supervisor_assignments',
                    'research_proposals.student_id',
                    '=',
                    'supervisor_assignments.student_id'
                )
                ->where(
                    'supervisor_assignments.teacher_id',
                    $user->id
                )
                ->where(
                    'supervisor_assignments.status',
                    'active'
                )
                ->count();


            /*
            | Supervisor count
            */

            $supervisors = 1;


            /*
            | Completed Research
            */

            $completedResearch = DB::table('research_proposals')
                ->join(
                    'supervisor_assignments',
                    'research_proposals.student_id',
                    '=',
                    'supervisor_assignments.student_id'
                )
                ->where(
                    'supervisor_assignments.teacher_id',
                    $user->id
                )
                ->where(
                    'supervisor_assignments.status',
                    'active'
                )
                ->where(
                    'research_proposals.status',
                    'approved'
                )
                ->count();


            /*
            | Recent Research
            */

            $recentResearch = DB::table('research_proposals')
                ->join(
                    'students',
                    'research_proposals.student_id',
                    '=',
                    'students.id'
                )
                ->join(
                    'supervisor_assignments',
                    'research_proposals.student_id',
                    '=',
                    'supervisor_assignments.student_id'
                )
                ->where(
                    'supervisor_assignments.teacher_id',
                    $user->id
                )
                ->where(
                    'supervisor_assignments.status',
                    'active'
                )
                ->select(
                    'research_proposals.id',
                    'research_proposals.title',
                    'research_proposals.status',
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
            | Research Status
            */

            $completed = DB::table('research_proposals')
                ->join(
                    'supervisor_assignments',
                    'research_proposals.student_id',
                    '=',
                    'supervisor_assignments.student_id'
                )
                ->where(
                    'supervisor_assignments.teacher_id',
                    $user->id
                )
                ->where(
                    'supervisor_assignments.status',
                    'active'
                )
                ->where(
                    'research_proposals.status',
                    'completed'
                )
                ->count();


            $inProgress = DB::table('research_proposals')
                ->join(
                    'supervisor_assignments',
                    'research_proposals.student_id',
                    '=',
                    'supervisor_assignments.student_id'
                )
                ->where(
                    'supervisor_assignments.teacher_id',
                    $user->id
                )
                ->where(
                    'supervisor_assignments.status',
                    'active'
                )
                ->where(
                    'research_proposals.status',
                    'under_review'
                )
                ->count();


            $pending = DB::table('research_proposals')
                ->join(
                    'supervisor_assignments',
                    'research_proposals.student_id',
                    '=',
                    'supervisor_assignments.student_id'
                )
                ->where(
                    'supervisor_assignments.teacher_id',
                    $user->id
                )
                ->where(
                    'supervisor_assignments.status',
                    'active'
                )
                ->where(
                    'research_proposals.status',
                    'pending'
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
            | Student ID
            */

            $studentId = $user->id;


            /*
            | Student has one profile
            */

            $registeredStudents = 1;


            /*
            | Student's Research Projects
            */

            $researchProjects = DB::table('research_proposals')
                ->where(
                    'student_id',
                    $studentId
                )
                ->count();


            /*
            | Student's Supervisor
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
            | Completed Research
            */

            $completedResearch = DB::table('research_proposals')
                ->where(
                    'student_id',
                    $studentId
                )
                ->where(
                    'status',
                    'completed'
                )
                ->count();


            /*
            | Recent Research
            */

            $recentResearch = DB::table('research_proposals')
                ->where(
                    'student_id',
                    $studentId
                )
                ->select(
                    'id',
                    'title',
                    'status'
                )
                ->orderBy(
                    'created_at',
                    'desc'
                )
                ->limit(5)
                ->get();


            /*
            | Research Status
            */

            $completed = DB::table('research_proposals')
                ->where(
                    'student_id',
                    $studentId
                )
                ->where(
                    'status',
                    'approved'
                )
                ->count();


            $inProgress = DB::table('research_proposals')
                ->where(
                    'student_id',
                    $studentId
                )
                ->where(
                    'status',
                    'under_review'
                )
                ->count();


            $pending = DB::table('research_proposals')
                ->where(
                    'student_id',
                    $studentId
                )
                ->where(
                    'status',
                    'pending'
                )
                ->count();

        }


        /*
        |--------------------------------------------------------------------------
        | UNKNOWN ROLE
        |--------------------------------------------------------------------------
        */

        else {

            abort(403, 'Unauthorized role.');

        }


        /*
        |--------------------------------------------------------------------------
        | CALCULATE PERCENTAGES
        |--------------------------------------------------------------------------
        */

        $totalResearch =
            $completed +
            $inProgress +
            $pending;


        if ($totalResearch > 0) {

            $completedPercentage =
                round(($completed / $totalResearch) * 100);

            $inProgressPercentage =
                round(($inProgress / $totalResearch) * 100);

            $pendingPercentage =
                round(($pending / $totalResearch) * 100);

        }


        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
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
        ));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');


        // =========================
        // SYSTEM USER LOGIN
        // =========================

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

            // Role haijatambuliwa
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


        // =========================
        // STUDENT LOGIN
        // =========================

        if (Auth::guard('student')->attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }


        // =========================
        // LOGIN FAILED
        // =========================

        return back()
            ->withInput($request->only('email'))
            ->with(
                'error',
                'Email au password sio sahihi.'
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
