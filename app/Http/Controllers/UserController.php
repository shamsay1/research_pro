<?php

namespace App\Http\Controllers;

use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Models\Notification;
use App\Models\ResearchCorrection;
use App\Models\ResearchProposal;
use App\Models\Student;
use App\Models\SupervisorAssignment;
use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Validators\ValidationException;
class UserController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $staff = SystemUser::query()
        ->where('role', '!=', 'admin')

        ->when($search, function ($query) use ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('firstname', 'like', "%{$search}%")
                  ->orWhere('middlename', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");

            });

        })

        ->latest()
        ->paginate(10)
        ->withQueryString();


    /*
    |--------------------------------------------------------------------------
    | AJAX REQUEST
    |--------------------------------------------------------------------------
    */

    if ($request->ajax()) {

        return view(
            'partials.staff_rows',
            compact('staff')
        )->render();

    }


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

  

    public function update(Request $request, $id)
{
    $staff = SystemUser::findOrFail($id);

    $validated = $request->validate([
        'firstname'  => 'required|string|max:100',
        'middlename' => 'nullable|string|max:100',
        'lastname'   => 'required|string|max:100',

        'phone' => 'required|string|max:30',
         'role' => 'required',
        'email' => 'required|email',

    ]);

    $staff->update($validated);

    return redirect()
        ->back()
        ->with('success', 'Data updated successfully.');
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
    | GET ALL ACTIVE SUPERVISOR ASSIGNMENTS
    |--------------------------------------------------------------------------
    */

    $assignments = SupervisorAssignment::with([
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
    ->orderBy(
        'created_at',
        'asc'
    )
    ->get();


    /*
    |--------------------------------------------------------------------------
    | IF STUDENT HAS NO SUPERVISOR
    |--------------------------------------------------------------------------
    */

    if ($assignments->isEmpty()) {

        return redirect()
            ->back()
            ->with(
                'error',
                'This student has no active supervisor.'
            );

    }


    /*
    |--------------------------------------------------------------------------
    | GET LATEST RESEARCH
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
    */

    $corrections = ResearchCorrection::with('supervisor')
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
            'assignments',
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
            'Please select the Co-Supervisor.',

        'principal_teacher_id.required' =>
            'Please select the Principal Supervisor.',

        'principal_teacher_id.different' =>
            'Co-Supervisor and Principal Supervisor must be different.',
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
                    'This student already has a Co-Supervisor.'
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
            'Student has been assigned a Co-Supervisor and a Principal Supervisor successfully.'
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
    public function downloadTemplate()
{
    return Excel::download(
        new StudentExport,
        'student_import_template.xlsx'
    );
}

    public function import(Request $request) { 
        // ===================================================== // VALIDATE FILE // ===================================================== 
        $request->validate( [ 'student_file' => 
        [ 'required', 'file', 'mimes:xlsx,xls,csv', 'max:5120', ], ], 
        [ 'student_file.required' => 'Please select a student file to upload.', 
        'student_file.file' => 'The uploaded item must be a valid file.', 
        'student_file.mimes' => 'Only Excel (.xlsx, .xls) or CSV files are allowed.', 
        'student_file.max' => 'The student file must not be larger than 5MB.', ] ); 
        try { 
            // ===================================================== // IMPORT FILE // ===================================================== 
            Excel::import( new StudentImport, $request->file('student_file') ); 
            // ===================================================== // SUCCESS // =====================================================
             return redirect() ->back() ->with( 'success', 'Students imported successfully.' ); } 
             catch (ValidationException $e) { 
                // ===================================================== // EXCEL VALIDATION ERRORS // ===================================================== 
                $failures = $e->failures(); $errors = []; foreach ($failures as $failure) { $row = $failure->row(); $attribute = $failure->attribute(); foreach ($failure->errors() as $error) { $errors[] = "Row {$row} - {$attribute}: {$error}"; } } 
                return redirect() ->back() ->with('import_errors', $errors); } catch (\Throwable $e) { 
                    // ===================================================== // GENERAL ERROR // ===================================================== 
                    Log::error( 'Student import failed', [ 'error' => $e->getMessage(), 'file' => $request->file('student_file') ? $request->file('student_file')->getClientOriginalName() : null, ] ); 
                    return redirect() ->back() ->with( 'error', 'Students could not be imported. Please check your file and try again.' ); } }

        public function updateSupervisor(Request $request, $studentId)
{
    $request->validate([
        'supervisor_id'   => 'required|exists:system_users,id',
        'supervisor_type' => 'required|in:principal,core',
    ]);

    // Hakikisha supervisor anayechaguliwa ni active supervisor
    $supervisor = SystemUser::where('id', $request->supervisor_id)
        ->where('role', 'supervisors')
        ->where('status', 'active')
        ->first();

    if (!$supervisor) {
        return back()->with(
            'error',
            'Selected user is not an active supervisor.'
        );
    }

    // Zuia supervisor mmoja kuwa Principal na Co-Supervisor
    $alreadyAssigned = SupervisorAssignment::where('student_id', $studentId)
        ->where('teacher_id', $request->supervisor_id)
        ->where('supervisor_type', '!=', $request->supervisor_type)
        ->where('status', 'active')
        ->exists();

    if ($alreadyAssigned) {
        return back()->with(
            'error',
            'This supervisor is already assigned to this student in another supervisor role.'
        );
    }

    // Tafuta assignment iliyopo kwa aina husika
    $assignment = SupervisorAssignment::where('student_id', $studentId)
        ->where('supervisor_type', $request->supervisor_type)
        ->first();

    if ($assignment) {

        // Update existing assignment
        $assignment->update([
            'teacher_id' => $request->supervisor_id,
            'status'     => 'active',
            'created_at' => now('Africa/Dar_es_Salaam'),
            'updated_at' => now('Africa/Dar_es_Salaam'),
        ]);

    } else {

        // Create new assignment
        SupervisorAssignment::create([
            'student_id'      => $studentId,
            'teacher_id'      => $request->supervisor_id,
            'supervisor_type' => $request->supervisor_type,
            'status'          => 'active',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }

    return back()->with(
        'success',
        ucfirst($request->supervisor_type) .
        ' supervisor updated successfully on ' .
        now()->format('d M Y, h:i A') . '.'
    );
}
    public function forgot(){
        return view('forgotpassword');
    }

    public function sendToken(Request $request)
    {
        $request->validate([
            'user_type' => 'required|in:student,staff',
            'email' => 'required|email',
        ], [
            'user_type.required' => 'Please select account type.',
            'email.required' => 'Please enter your email.',
            'email.email' => 'Please enter a valid email address.',
        ]);


        $email = strtolower(trim($request->email));


        /*
        |--------------------------------------------------------------------------
        | FIND USER
        |--------------------------------------------------------------------------
        */

        if ($request->user_type === 'student') {

            $user = Student::where('email', $email)->first();

            if (!$user) {

                return back()
                    ->withInput()
                    ->with('error', 'Email not found in student accounts.');

            }

        } else {

            $user = SystemUser::where('email', $email)
                ->whereIn('role', ['admin', 'supervisors'])
                ->first();

            if (!$user) {

                return back()
                    ->withInput()
                    ->with('error', 'Email not found in admin/supervisor accounts.');

            }
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE 4 DIGIT TOKEN
        |--------------------------------------------------------------------------
        */

        $token = (string) random_int(1000, 9999);


        /*
        |--------------------------------------------------------------------------
        | DELETE OLD TOKEN
        |--------------------------------------------------------------------------
        */

        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();


        /*
        |--------------------------------------------------------------------------
        | SAVE TOKEN
        |--------------------------------------------------------------------------
        |
        | We hash the token in database for security.
        |
        */

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | SAVE TEMPORARY INFORMATION IN SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'password_reset_email' => $email,
            'password_reset_type' => $request->user_type,
        ]);


        /*
        |--------------------------------------------------------------------------
        | SEND EMAIL
        |--------------------------------------------------------------------------
        */

        $fullName = trim(
            $user->firstname . ' ' .
            $user->middlename . ' ' .
            $user->lastname
        );


        try {

            Mail::html(
                view('passwordreset', [
                    'name' => $fullName,
                    'token' => $token,
                ])->render(),

                function ($message) use ($email) {

                    $message
                        ->to($email)
                        ->subject('Password Reset Token - IPA Research Tracking System');

                }
            );

        } catch (\Throwable $e) {

    DB::table('password_reset_tokens')
        ->where('email', $email)
        ->delete();

    return back()
        ->withInput()
        ->with(
            'error',
            'Email sending failed: ' . $e->getMessage()
        );
        }


        /*
        |--------------------------------------------------------------------------
        | REDIRECT TO TOKEN PAGE
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('forgot.password.verify')
            ->with(
                'success',
                'A 4-digit verification token has been sent to your email.'
            );
    }



    public function showVerifyToken()
    {
        if (!session()->has('password_reset_email')) {

            return redirect()
                ->route('forgot.password')
                ->with('error', 'Please request a password reset token first.');

        }


        return view('verifytokens');
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFY TOKEN
    |--------------------------------------------------------------------------
    */

    public function verifyToken(Request $request)
    {
        $request->validate([
            'token' => [
                'required',
                'digits:4',
            ],
        ], [
            'token.required' => 'Please enter the verification token.',
            'token.digits' => 'Token must contain exactly 4 digits.',
        ]);


        $email = session('password_reset_email');


        if (!$email) {

            return redirect()
                ->route('forgot')
                ->with('error', 'Your password reset session has expired.');

        }


        /*
        |--------------------------------------------------------------------------
        | GET TOKEN
        |--------------------------------------------------------------------------
        */

        $reset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();


        if (!$reset) {

            return back()
                ->with('error', 'Invalid or expired token.');

        }


        /*
        |--------------------------------------------------------------------------
        | TOKEN EXPIRATION - 10 MINUTES
        |--------------------------------------------------------------------------
        */

        if (
            Carbon::parse($reset->created_at)
                ->addMinutes(10)
                ->isPast()
        ) {

            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->delete();

            return redirect()
                ->route('forgot')
                ->with(
                    'error',
                    'Your token has expired. Please request a new token.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK TOKEN
        |--------------------------------------------------------------------------
        */

        if (!Hash::check($request->token, $reset->token)) {

            return back()
                ->withInput()
                ->with('error', 'Incorrect token. Please check your email.');

        }


        /*
        |--------------------------------------------------------------------------
        | TOKEN VERIFIED
        |--------------------------------------------------------------------------
        */

        session([
            'password_reset_verified' => true,
        ]);


        return redirect()
            ->route('forgot.password.reset')
            ->with(
                'success',
                'Token verified successfully. You can now reset your password.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW RESET PASSWORD PAGE
    |--------------------------------------------------------------------------
    */

    public function showResetPassword()
    {
        if (
            !session()->has('password_reset_email') ||
            !session('password_reset_verified')
        ) {

            return redirect()
                ->route('forgot.password')
                ->with(
                    'error',
                    'Please verify your token first.'
                );
        }


        return view('resetpassword');
    }


    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'password.required' => 'Please enter your new password.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);


        $email = session('password_reset_email');
        $type = session('password_reset_type');


        if (!$email || !$type || !session('password_reset_verified')) {

            return redirect()
                ->route('forgot.password')
                ->with(
                    'error',
                    'Your password reset session has expired.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE STUDENT PASSWORD
        |--------------------------------------------------------------------------
        */

        if ($type === 'student') {

            $user = Student::where('email', $email)->first();


            if (!$user) {

                return redirect()
                    ->route('forgot.password')
                    ->with('error', 'Student account was not found.');

            }


            $user->password = Hash::make($request->password);
            $user->save();


        } else {

            /*
            |--------------------------------------------------------------------------
            | UPDATE ADMIN / SUPERVISOR PASSWORD
            |--------------------------------------------------------------------------
            */

            $user = SystemUser::where('email', $email)
                ->whereIn('role', ['admin', 'supervisors'])
                ->first();


            if (!$user) {

                return redirect()
                    ->route('forgot.password')
                    ->with(
                        'error',
                        'Admin/Supervisor account was not found.'
                    );

            }


            $user->password = Hash::make($request->password);
            $user->save();
        }


        /*
        |--------------------------------------------------------------------------
        | DELETE USED TOKEN
        |--------------------------------------------------------------------------
        */

        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();


        /*
        |--------------------------------------------------------------------------
        | CLEAR RESET SESSION
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'password_reset_email',
            'password_reset_type',
            'password_reset_verified',
        ]);


        /*
        |--------------------------------------------------------------------------
        | BACK TO LOGIN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('login1')
            ->with(
                'success',
                'Your password has been reset successfully. You can now login.'
            );
    }
    public function updateProfile(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | CHECK STUDENT
        |--------------------------------------------------------------------------
        */

        if (Auth::guard('student')->check()) {

            $user = Auth::guard('student')->user();

            $validated = $request->validate([

                'firstname' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'middlename' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

                'lastname' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('students', 'email')
                        ->ignore($user->id),
                ],

                'phone' => [
                    'nullable',
                    'string',
                    'max:30',
                ],
            ], [

                'firstname.required' => 'First name is required.',

                'lastname.required' => 'Last name is required.',

                'email.required' => 'Email address is required.',

                'email.email' => 'Please enter a valid email address.',

                'email.unique' => 'This email is already being used by another student.',
            ]);


            /*
            |--------------------------------------------------------------------------
            | UPDATE STUDENT
            |--------------------------------------------------------------------------
            */

            $user->firstname = $validated['firstname'];
            $user->middlename = $validated['middlename'] ?? null;
            $user->lastname = $validated['lastname'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'] ?? null;

            $user->save();


            return back()->with(
                'success',
                'Your profile has been updated successfully.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK ADMIN / SUPERVISOR
        |--------------------------------------------------------------------------
        */

        if (Auth::guard('web')->check()) {

            $user = Auth::guard('web')->user();

            $validated = $request->validate([

                'firstname' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'middlename' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

                'lastname' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('system_users', 'email')
                        ->ignore($user->id),
                ],

                'phone' => [
                    'nullable',
                    'string',
                    'max:30',
                ],
            ], [

                'firstname.required' => 'First name is required.',

                'lastname.required' => 'Last name is required.',

                'email.required' => 'Email address is required.',

                'email.email' => 'Please enter a valid email address.',

                'email.unique' => 'This email is already being used by another system user.',
            ]);


            /*
            |--------------------------------------------------------------------------
            | UPDATE SYSTEM USER
            |--------------------------------------------------------------------------
            */

            $user->firstname = $validated['firstname'];
            $user->middlename = $validated['middlename'] ?? null;
            $user->lastname = $validated['lastname'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'] ?? null;

            $user->save();


            return back()->with(
                'success',
                'Your profile has been updated successfully.'
            );
        }
    }
}