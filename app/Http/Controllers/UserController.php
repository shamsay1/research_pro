<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\ResearchProposal;
use App\Models\Student;
use App\Models\SupervisorAssignment;
use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $staff = SystemUser::where('role','!=','admin')->latest()->get();

        return view('supervisors', compact('staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname'   => 'required|string|max:100',
            'middlename'  => 'nullable|string|max:100',
            'lastname'    => 'required|string|max:100',
            'email'       => 'required|email|unique:users,email',
            'phone'       => 'required|string|max:20',
            'password'    => 'required|string|',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = 'active';

        SystemUser::create($validated);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff registered successfully.');
    }

    public function edit(SystemUser $user)
    {
        return view('staff.edit', compact('user'));
    }

    public function update(Request $request, SystemUser $user)
    {
        $validated = $request->validate([
            'firstname'   => 'required|string|max:100',
            'middlename'  => 'nullable|string|max:100',
            'lastname'    => 'required|string|max:100',
            'email'       => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone'       => 'required|string|max:20',
            'reg_number'  => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'reg_number')->ignore($user->id),
            ],
            'role'        => 'required|in:teacher,supervisor,admin',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:6|confirmed',
            ]);

            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff updated successfully.');
    }

    public function block(SystemUser $user)
    {
        $user->update(['status' => 'inactive']);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff blocked successfully.');
    }

    public function unblock(SystemUser $user)
    {
        $user->update(['status' => 'active']);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff unblocked successfully.');
    }

    public function destroy(SystemUser $user)
    {
        $user->delete();

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff deleted successfully.');
    }

   

    public function index1()
{
    $assignments = SupervisorAssignment::with([
        'student',
        'supervisor'
    ])
    ->latest()
    ->get()
    ->groupBy('teacher_id');

    $students = Student::whereDoesntHave('supervisorAssignments', function ($query) {
        $query->where('status', 'active');
    })->get();

    $teachers = SystemUser::where('role', 'supervisors')
        ->where('status', 'active')
        ->orderBy('firstname')
        ->get();

    return view(
        'supervisorassign',
        compact(
            'assignments',
            'students',
            'teachers'
        )
    );
}


    /*
    |--------------------------------------------------------------------------
    | VIEW STUDENT RESEARCH
    |--------------------------------------------------------------------------
    */

    public function clearAll()
{
    $user = Auth::guard('web')->user();

    Notification::where('supervisor_id', $user->id)
        ->where('is_read', 0)
        ->update([
            'is_read' => 1
        ]);

    return back();
}

    public function researchDetails($studentId)
    {
        /*
        |--------------------------------------------------------------------------
        | GET STUDENT
        |--------------------------------------------------------------------------
        */

        $student = Student::findOrFail($studentId);


        /*
        |--------------------------------------------------------------------------
        | GET SUPERVISOR ASSIGNMENT
        |--------------------------------------------------------------------------
        */

        $assignment = SupervisorAssignment::with([
            'student',
            'supervisor'
        ])
        ->where(
            'student_id',
            $studentId
        )
        ->where(
            'status',
            'active'
        )
        ->first();


        /*
        |--------------------------------------------------------------------------
        | IF STUDENT HAS NO SUPERVISOR
        |--------------------------------------------------------------------------
        */

        if (!$assignment) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'This student has no active supervisor.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | GET RESEARCH
        |--------------------------------------------------------------------------
        */

        $research = ResearchProposal::where(
            'student_id',
            $studentId
        )
        ->latest()
        ->first();


        /*
        |--------------------------------------------------------------------------
        | NO RESEARCH
        |--------------------------------------------------------------------------
        */

        if (!$research) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'This student has not submitted any research yet.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | GET CORRECTIONS / SUPERVISOR RESPONSES
        |--------------------------------------------------------------------------
        |
        | Kama table yako inaitwa research_corrections
        |
        */

        $corrections = DB::table(
            'research_corrections'
        )
        ->where(
            'research_proposal_id',
            $research->id
        )
        ->orderBy(
            'created_at',
            'asc'
        )
        ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN DETAILS PAGE
        |--------------------------------------------------------------------------
        */

        return view(
            'research-details1',
            compact(
                'student',
                'assignment',
                'research',
                'corrections'
            )
        );
    }


public function store1(Request $request)
{
    $validated = $request->validate([
        'student_id' => [
            'required',
            'exists:students,id',
        ],

        'core_teacher_id' => [
            'required',
            'exists:system_users,id',
        ],

        'principal_teacher_id' => [
            'required',
            'exists:system_users,id',
            'different:core_teacher_id',
        ],
    ], [

        'student_id.required' =>
            'Please select a student.',

        'core_teacher_id.required' =>
            'Please select the Core Supervisor.',

        'principal_teacher_id.required' =>
            'Please select the Principal Supervisor.',

        'principal_teacher_id.different' =>
            'Core Supervisor and Principal Supervisor must be different.',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Check existing assignments
    |--------------------------------------------------------------------------
    */

    $existing = SupervisorAssignment::where(
        'student_id',
        $validated['student_id']
    )->get();


    // Kama tayari ana Core
    if ($existing->where('supervisor_type', 'core')->count() > 0) {

        return back()
            ->withErrors([
                'student_id' =>
                    'This student already has a Core Supervisor.'
            ])
            ->withInput();
    }


    // Kama tayari ana Principal
    if ($existing->where('supervisor_type', 'principal')->count() > 0) {

        return back()
            ->withErrors([
                'student_id' =>
                    'This student already has a Principal Supervisor.'
            ])
            ->withInput();
    }


    /*
    |--------------------------------------------------------------------------
    | Create both supervisors
    |--------------------------------------------------------------------------
    */

    DB::transaction(function () use ($validated) {

        // CORE SUPERVISOR
        SupervisorAssignment::create([
            'student_id'      => $validated['student_id'],
            'teacher_id'      => $validated['core_teacher_id'],
            'supervisor_type' => 'core',
            'status'          => 'active',
        ]);


        // PRINCIPAL SUPERVISOR
        SupervisorAssignment::create([
            'student_id'      => $validated['student_id'],
            'teacher_id'      => $validated['principal_teacher_id'],
            'supervisor_type' => 'principal',
            'status'          => 'active',
        ]);

    });


    return redirect()
        ->route('supervisor.assignments.index')
        ->with(
            'success',
            'Student has been assigned a Core Supervisor and a Principal Supervisor successfully.'
        );
}
    public function students()
    {
        $supervisor = Auth::user();

        $assignments = SupervisorAssignment::with('student')
            ->where('teacher_id', $supervisor->id)
            ->where('status', 'active')
            ->latest()
            ->get();

        return view(
            'viewstudent',
            compact('supervisor', 'assignments')
        );
    }
}