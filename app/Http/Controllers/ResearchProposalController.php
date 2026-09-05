<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\ResearchCorrection;
use App\Models\ResearchProposal;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SupervisorAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ResearchProposalController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();

        $research = ResearchProposal::where(
            'student_id',
            $student->id
        )->latest()->first();

        return view(
            'research',
            compact('student', 'research')
        );
    }


public function store(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | GET LOGGED IN STUDENT
    |--------------------------------------------------------------------------
    */

    $student = Auth::guard('student')->user();

    if (!$student) {

        return redirect()
            ->route('student.login')
            ->with('error', 'Please login first.');
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([

        'title' => [
            'required',
            'string',
            'max:255'
        ],

        'document' => [
            'required',
            'file',
            'mimes:pdf,doc,docx',
        ],

    ]);


    /*
    |--------------------------------------------------------------------------
    | CHECK FILE
    |--------------------------------------------------------------------------
    */

    if (!$request->hasFile('document')) {

        return back()
            ->with('error', 'Please select a research document.')
            ->withInput();
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE UNIQUE FILE NAME
    |--------------------------------------------------------------------------
    */

    $file = $request->file('document');

    $fileName =
        time() . '_' .
        uniqid() . '_' .
        $file->getClientOriginalName();


    /*
    |--------------------------------------------------------------------------
    | RESEARCH DIRECTORY
    |--------------------------------------------------------------------------
    */

    $directory = public_path(
        'images/research_proposals'
    );


    /*
    |--------------------------------------------------------------------------
    | CREATE DIRECTORY
    |--------------------------------------------------------------------------
    */

    if (!file_exists($directory)) {

        mkdir(
            $directory,
            0755,
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MOVE FILE
    |--------------------------------------------------------------------------
    */

    $file->move(
        $directory,
        $fileName
    );


    /*
    |--------------------------------------------------------------------------
    | DOCUMENT PATH
    |--------------------------------------------------------------------------
    */

    $documentPath =
        'images/research_proposals/' .
        $fileName;


    /*
    |--------------------------------------------------------------------------
    | CREATE RESEARCH
    |--------------------------------------------------------------------------
    */

    $research = ResearchProposal::create([

        'student_id' => $student->id,

        'title' => $validated['title'],

        'document' => $documentPath,

        'status' => 'pending',

    ]);


    /*
    |--------------------------------------------------------------------------
    | FIND ONLY CORE SUPERVISOR OF THIS STUDENT
    |--------------------------------------------------------------------------
    |
    | We are looking for:
    |
    | 1. This particular student
    | 2. supervisor_type = core
    | 3. status = active
    |
    | Then we join system_users to get supervisor details.
    |
    |--------------------------------------------------------------------------
    */

    $principal = DB::table('supervisor_assignments')
        ->join(
            'system_users',
            'system_users.id',
            '=',
            'supervisor_assignments.teacher_id'
        )
        ->where(
            'supervisor_assignments.student_id',
            $student->id
        )
        ->where(
            'supervisor_assignments.supervisor_type',
            'core'
        )
        ->where(
            'supervisor_assignments.status',
            'active'
        )
        ->select(
            'system_users.id',
            'system_users.firstname',
            'system_users.middlename',
            'system_users.lastname',
            'system_users.email'
        )
        ->first();


    /*
    |--------------------------------------------------------------------------
    | NOTIFY ONLY THIS STUDENT'S CORE SUPERVISOR
    |--------------------------------------------------------------------------
    */

    if ($research && $principal) {


        /*
        |--------------------------------------------------------------------------
        | STUDENT FULL NAME
        |--------------------------------------------------------------------------
        */

        $studentName = trim(
            $student->firstname . ' ' .
            $student->middlename . ' ' .
            $student->lastname
        );


        /*
        |--------------------------------------------------------------------------
        | SUPERVISOR FULL NAME
        |--------------------------------------------------------------------------
        */

        $supervisorName = trim(
            $principal->firstname . ' ' .
            $principal->middlename . ' ' .
            $principal->lastname
        );


        /*
        |--------------------------------------------------------------------------
        | DATABASE NOTIFICATION
        |--------------------------------------------------------------------------
        */

        Notification::create([

            'title' =>
                'New Research Submission',

            'message' =>
                'Student ' .
                $studentName .
                ' has submitted a new research proposal: "' .
                $research->title .
                '".',

            'supervisor_id' =>
                $principal->id,

            'is_read' =>
                false,

        ]);


        /*
        |--------------------------------------------------------------------------
        | EMAIL NOTIFICATION
        |--------------------------------------------------------------------------
        */

        if (!empty($principal->email)) {

            try {

                Mail::raw(

                    "Dear {$supervisorName},\n\n" .

                    "A new research proposal has been submitted by your assigned student and requires your review.\n\n" .

                    "Student Name: " .
                    $studentName .
                    "\n\n" .

                    "Research Title: " .
                    $research->title .
                    "\n\n" .

                    "Submission Date: " .
                    $research->created_at
                        ->format('d M Y, h:i A') .
                    "\n\n" .

                    "Current Status: Pending Review\n\n" .

                    "Please login to the Research Management System to review the student's research proposal.\n\n" .
                    "click the link http://127.0.0.1:8000/".
                    "\n".
                    "Regards,\n" .
                    "Research Management System",

                    function ($message) use ($principal) {

                        $message
                            ->to($principal->email)
                            ->subject(
                                'New Research Proposal Submitted'
                            );
                    }

                );

            } catch (\Throwable $e) {

                echo 'error';
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SUCCESS
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('student.research')
        ->with(
            'success',
            'Your research proposal has been submitted successfully.'
        );
}

    public function supervisorResearch()
{
    $supervisor = Auth::guard('web')->user();

    $assignments = SupervisorAssignment::with([
        'student.researchProposals' => function ($query) {
            $query->latest();
        }
    ])
    ->where('teacher_id', $supervisor->id)
    ->get();


    return view(
        'reviewr',
        compact(
            'supervisor',
            'assignments'
        )
    );
}


    public function show(ResearchProposal $research)
{
    $supervisor = Auth::guard('web')->user();


    /*
    |--------------------------------------------------------------------------
    | Check if this student belongs to this supervisor
    |--------------------------------------------------------------------------
    */

    $assignment = SupervisorAssignment::where(
        'teacher_id',
        $supervisor->id
    )
    ->where(
        'student_id',
        $research->student_id
    )
    ->first();


    if (!$assignment) {
        abort(403, 'You are not assigned to this student.');
    }


    /*
    |--------------------------------------------------------------------------
    | Load relationships
    |--------------------------------------------------------------------------
    */

    $research->load([
        'student',
        'corrections.supervisor'
    ]);


    return view(
        'research-details',
        compact(
            'supervisor',
            'research'
        )
    );
}

    public function approve(ResearchProposal $research)
{
    /*
    |--------------------------------------------------------------------------
    | GET SUPERVISOR
    |--------------------------------------------------------------------------
    */

    $supervisor = Auth::guard('web')->user();


    /*
    |--------------------------------------------------------------------------
    | CHECK ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    $assignment = SupervisorAssignment::where(
        'teacher_id',
        $supervisor->id
    )
    ->where(
        'student_id',
        $research->student_id
    )
    ->first();


    if (!$assignment) {

        abort(
            403,
            'You are not assigned to this student.'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE RESEARCH
    |--------------------------------------------------------------------------
    */

    $research->update([

        'status' => 'approved'

    ]);


    /*
    |--------------------------------------------------------------------------
    | GET STUDENT
    |--------------------------------------------------------------------------
    */

    $student = $research->student;


    /*
    |--------------------------------------------------------------------------
    | SEND EMAIL
    |--------------------------------------------------------------------------
    */

    if (
        $student &&
        !empty($student->email)
    ) {

        try {

            Mail::raw(

                "Dear {$student->name},\n\n" .

                "Your research proposal has been approved by your supervisor.\n\n" .

                "Research Title: {$research->title}\n" .

                "Status: Approved\n\n" .

                "Congratulations. You may now proceed with the next stage of your research.\n\n" .

                "Regards,\n" .
                "Research Management System",

                function ($message) use ($student) {

                    $message
                        ->to($student->email)
                        ->subject(
                            'Research Proposal Approved'
                        );

                }

            );

        } catch (\Throwable $e) {

            /*
            | Email failure should not cancel approval
            */

            echo $e;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route(
            'supervisor.research.show',
            $research->id
        )
        ->with(
            'success',
            'Research proposal has been approved successfully.'
        );
}

    public function requestCorrection(
Request $request,
ResearchProposal $research
) {

$supervisor = Auth::guard('web')->user();


if (!$supervisor) {

    return redirect()
        ->route('login')
        ->with('error', 'Please login first.');

}

$validated = $request->validate([

    'comment' => [
        'nullable',
        'string',
    ],

    'attachment' => [
        'nullable',
        'file',
        'mimes:pdf,doc,docx,jpg,jpeg,png',
        'max:10000',
    ],

], [

    'comment.min' =>
        'Correction comment must be at least 5 characters.',

    'comment.max' =>
        'Correction comment cannot exceed 5000 characters.',

    'attachment.file' =>
        'The uploaded attachment is not valid.',

    'attachment.mimes' =>
        'Attachment must be PDF, DOC, DOCX, JPG, JPEG or PNG.',

    'attachment.max' =>
        'Attachment cannot be larger than 10MB.',

]);

$assignment = SupervisorAssignment::where(
    'teacher_id',
    $supervisor->id
)
->where(
    'student_id',
    $research->student_id
)
->where(
    'status',
    'active'
)
->first();


if (!$assignment) {

    abort(
        403,
        'You are not assigned to this student.'
    );

}



$attachmentPath = null;


if ($request->hasFile('attachment')) {

    $file = $request->file('attachment');


    /*
    | Create directory if it does not exist
    */

    $directory = public_path(
        'images/research_corrections'
    );


    if (!file_exists($directory)) {

        mkdir(
            $directory,
            0755,
            true
        );

    }


    /*
    | Create unique file name
    */

    $fileName =
        time() . '_' .
        uniqid() . '_' .
        $file->getClientOriginalName();


    /*
    | Move file
    */

    $file->move(
        $directory,
        $fileName
    );


    /*
    | Save relative path
    */

    $attachmentPath =
        'images/research_corrections/' .
        $fileName;

}


/*
|--------------------------------------------------------------------------
| CREATE CORRECTION
|--------------------------------------------------------------------------
*/

$correction = ResearchCorrection::create([

    'research_proposal_id' =>
        $research->id,

    'supervisor_id' =>
        $supervisor->id,

    'comment' =>
        $validated['comment'],

    'documentary' =>
        $attachmentPath,

    'status' =>
        'pending',

]);


/*
|--------------------------------------------------------------------------
| CHANGE RESEARCH STATUS
|--------------------------------------------------------------------------
*/

$research->update([

    'status' =>
        'correction',

]);


/*
|--------------------------------------------------------------------------
| GET STUDENT
|--------------------------------------------------------------------------
*/

$student = $research->student;


/*
|--------------------------------------------------------------------------
| SEND EMAIL
|--------------------------------------------------------------------------
*/

if (
    $student &&
    !empty($student->email)
) {

    try {

        $attachmentMessage = '';

        if ($attachmentPath) {

            $attachmentMessage =
                "\n\nThe supervisor has also attached a document/image with the correction instructions.";

        }


        Mail::raw(

            "Dear {$student->firstname} {$student->middlename} {$student->lastname},\n\n" .

            "Your supervisor has reviewed your research submittion and requested some corrections.\n\n" .

            "Research Title: {$research->title}\n\n" .

            $attachmentMessage .

            "\n\nPlease login to the Research Management System, review the supervisor's comments and attachment, make the required corrections, and resubmit your research proposal.\n\n" .

            "Current Status: Correction Required\n\n" .
            "Click the link http://127.0.0.1:8000/",

            function ($message) use ($student) {

                $message
                    ->to($student->email)
                    ->subject(
                        'Correction Required for Your Research Proposal'
                    );

            }

        );

    } catch (\Throwable $e) {

        echo $e;

    }

}


/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/

return redirect()
    ->route(
        'supervisor.research.show',
        $research->id
    )
    ->with(
        'success',
        'Correction has been sent to the student successfully.'
    );


}
public function adminAddCorrection(
    Request $request,
    ResearchProposal $research
) {
    /*
    |--------------------------------------------------------------------------
    | CHECK ADMIN LOGIN
    |--------------------------------------------------------------------------
    */

    $admin = Auth::guard('web')->user();

    if (!$admin || $admin->role !== 'admin') {

        abort(403, 'Unauthorized action.');

    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([

        'comment' => [
            'nullable',
            'string',
            'min:5',
            'max:5000',
        ],

        'attachment' => [
            'nullable',
            'file',
            'mimes:pdf,doc,docx,jpg,jpeg,png',
            'max:10000',
        ],

    ], [

        'comment.required' =>
            'Please enter a correction comment.',

        'comment.min' =>
            'Correction comment must be at least 5 characters.',

        'comment.max' =>
            'Correction comment cannot exceed 5000 characters.',

        'attachment.required' =>
            'Please upload a correction document.',

        'attachment.file' =>
            'The uploaded document is not valid.',

        'attachment.mimes' =>
            'Document must be PDF, DOC, DOCX, JPG, JPEG or PNG.',

        'attachment.max' =>
            'Document cannot be larger than 10MB.',

    ]);


    /*
    |--------------------------------------------------------------------------
    | UPLOAD DOCUMENT
    |--------------------------------------------------------------------------
    */

    $attachmentPath = null;

    if ($request->hasFile('attachment')) {

        $file = $request->file('attachment');

        $directory = public_path(
            'images/research_corrections'
        );

        if (!file_exists($directory)) {

            mkdir(
                $directory,
                0755,
                true
            );

        }

        $fileName =
            time() . '_' .
            uniqid() . '_' .
            $file->getClientOriginalName();

        $file->move(
            $directory,
            $fileName
        );

        $attachmentPath =
            'images/research_corrections/' .
            $fileName;
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE CORRECTION
    |--------------------------------------------------------------------------
    */

    $correction = ResearchCorrection::create([

        'research_proposal_id' =>
            $research->id,

        /*
        | Admin does not have a separate admin_id
        | in research_corrections.
        |
        | We therefore store the logged-in admin
        | in supervisor_id because the current table
        | requires this field.
        */

        'supervisor_id' =>
            $admin->id,

        'comment' =>
            $validated['comment'],

        'documentary' =>
            $attachmentPath,

        'status' =>
            'pending',

    ]);


    /*
    |--------------------------------------------------------------------------
    | CHANGE RESEARCH STATUS
    |--------------------------------------------------------------------------
    */

    $research->update([

        'status' =>
            'correction',

    ]);


    /*
    |--------------------------------------------------------------------------
    | GET STUDENT
    |--------------------------------------------------------------------------
    */

    $student = $research->student;


    /*
    |--------------------------------------------------------------------------
    | SEND EMAIL TO STUDENT
    |--------------------------------------------------------------------------
    */

    if (
        $student &&
        !empty($student->email)
    ) {

        try {

            Mail::raw(

                "Dear {$student->firstname} {$student->middlename} {$student->lastname},\n\n" .

                "The administrator has reviewed your research proposal and requested some corrections.\n\n" .

                "Research Title: {$research->title}\n\n" .

                "Administrator Comment:\n" .
                $validated['comment'] .
                "\n\n" .

                "A correction document has also been attached to the research record.\n\n" .

                "Please login to the Research Management System, review the administrator's comment and attached document, make the required corrections, and resubmit your research proposal.\n\n" .

                "Current Status: Correction Required\n\n" .

                "Thank you.",

                function ($message) use ($student) {

                    $message
                        ->to($student->email)
                        ->subject(
                            'Correction Required for Your Research Proposal'
                        );

                }

            );

        } catch (\Throwable $e) {

            // Do not stop the correction process
            // if email fails.

        }

    }


    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->back()
        ->with(
            'success',
            'Comment and correction document have been added successfully.'
        );
}


    public function download($id)
{
    $research = ResearchProposal::findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | Change status when supervisor starts reviewing
    |--------------------------------------------------------------------------
    */

    if ($research->status === 'pending') {

        $research->update([
            'status' => 'under_review',
        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Get actual file path
    |--------------------------------------------------------------------------
    */

    $path = public_path(
        'images/research_proposals/' .
        basename($research->document)
    );


    if (!file_exists($path)) {

        return back()->with(
            'error',
            'Research document could not be found.'
        );

    }


    return response()->download(
        $path,
        basename($path)
    );
}

    public function responses()
{
    $student = Auth::guard('student')->user();

    $researches = ResearchProposal::with([
        'corrections.supervisor'
    ])
    ->where('student_id', $student->id)
    ->latest()
    ->get();

    return view(
        'respond',
        compact('researches')
    );
}
public function responses1($id)
{
    $student = Student::findOrFail($id);

    $researches = ResearchProposal::with([
        'corrections.supervisor'
    ])
    ->where('student_id', $student->id)
    ->latest()
    ->get();

    return view(
        'respond',
        compact('researches')
    );
}

    public function printStudentResearchReport(Student $student)
{
    /*
    |--------------------------------------------------------------------------
    | Load student research history
    |--------------------------------------------------------------------------
    */

    $student->load([
        'researchProposals' => function ($query) {
            $query->with([
                'corrections' => function ($query) {
                    $query->with('supervisor')
                          ->orderBy('created_at', 'asc');
                }
            ])
            ->orderBy('created_at', 'asc');
        },

        'supervisorAssignments.supervisor',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Research collection
    |--------------------------------------------------------------------------
    */

    $researches = $student->researchProposals;


    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

    $totalResearch = $researches->count();

    $pendingResearch = $researches
        ->filter(function ($research) {
            return strtolower($research->status ?? '') === 'pending';
        })
        ->count();

    $correctionResearch = $researches
        ->filter(function ($research) {
            return strtolower($research->status ?? '') === 'correction';
        })
        ->count();

    $approvedResearch = $researches
        ->filter(function ($research) {
            return strtolower($research->status ?? '') === 'approved';
        })
        ->count();


    /*
    |--------------------------------------------------------------------------
    | Total corrections
    |--------------------------------------------------------------------------
    */

    $totalCorrections = $researches
        ->sum(function ($research) {
            return $research->corrections->count();
        });


    /*
    |--------------------------------------------------------------------------
    | Supervisors
    |--------------------------------------------------------------------------
    |
    | Get supervisors from supervisor assignments.
    |
    */

    $supervisors = collect();

    foreach ($student->supervisorAssignments as $assignment) {

        if ($assignment->teacher) {

            $supervisors->push([
                'name' => trim(
                    $assignment->teacher->firstname . ' ' .
                    $assignment->teacher->middlename . ' ' .
                    $assignment->teacher->lastname
                ),

                'type' => ucfirst(
                    $assignment->supervisor_type ?? 'Supervisor'
                ),

                'status' => $assignment->status ?? 'active',
            ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Fallback:
    | If assignment relationship does not contain teacher,
    | collect supervisors from corrections.
    |--------------------------------------------------------------------------
    */

    if ($supervisors->isEmpty()) {

        foreach ($researches as $research) {

            foreach ($research->corrections as $correction) {

                if ($correction->supervisor) {

                    $supervisors->push([
                        'name' => trim(
                            $correction->supervisor->firstname . ' ' .
                            $correction->supervisor->middlename . ' ' .
                            $correction->supervisor->lastname
                        ),

                        'type' => 'Supervisor',

                        'status' => 'active',
                    ]);
                }
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Remove duplicate supervisors
    |--------------------------------------------------------------------------
    */

    $supervisors = $supervisors
        ->unique(function ($item) {
            return strtolower($item['name']);
        })
        ->values();


    /*
    |--------------------------------------------------------------------------
    | Overall status
    |--------------------------------------------------------------------------
    */

    $overallStatus = 'No Research';

    if ($researches->count()) {

        $statuses = $researches
            ->pluck('status')
            ->map(function ($status) {
                return strtolower($status ?? '');
            });

        if ($statuses->contains('approved')) {

            $overallStatus = 'Approved';

        } elseif ($statuses->contains('correction')) {

            $overallStatus = 'Correction Required';

        } elseif ($statuses->contains('pending')) {

            $overallStatus = 'Pending';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Progress percentage
    |--------------------------------------------------------------------------
    */

    $progressPercentage = 0;

    if ($totalResearch > 0) {

        $progressPercentage = round(
            ($approvedResearch / $totalResearch) * 100
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Generate PDF
    |--------------------------------------------------------------------------
    */

    $pdf = Pdf::loadView(
        'print',
        compact(
            'student',
            'researches',
            'supervisors',
            'totalResearch',
            'pendingResearch',
            'correctionResearch',
            'approvedResearch',
            'totalCorrections',
            'overallStatus',
            'progressPercentage'
        )
    );


    /*
    |--------------------------------------------------------------------------
    | PDF settings
    |--------------------------------------------------------------------------
    */

    $pdf->setPaper('A4', 'portrait');

    $pdf->setOptions([
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true,
        'defaultFont' => 'DejaVu Sans',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Download / open PDF
    |--------------------------------------------------------------------------
    */

    $fileName =
        'Research_Report_' .
        str_replace(
            ' ',
            '_',
            strtoupper(
                $student->firstname . '_' .
                $student->lastname
            )
        ) .
        '.pdf';


    return $pdf->stream($fileName);
}
    
}