<?php

namespace App\Http\Controllers;

use App\Models\ResearchCorrection;
use App\Models\ResearchProposal;
use App\Models\SupervisorAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
| CREATE DIRECTORY IF NOT EXISTS
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
| SAVE DOCUMENT PATH
|--------------------------------------------------------------------------
*/

$documentPath =
    'images/research_proposals/' .
    $fileName;


/*
|--------------------------------------------------------------------------
| CREATE NEW RESEARCH
|--------------------------------------------------------------------------
|
| IMPORTANT:
|
| Hatuangalii kama mwanafunzi ana research nyingine.
|
| Kila submission mpya inakuwa ResearchProposal mpya.
|
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
        'required',
        'string',
        'min:5',
        'max:5000',
    ],

    'attachment' => [
        'nullable',
        'file',
        'mimes:pdf,doc,docx,jpg,jpeg,png',
        'max:10240', // 10MB
    ],

], [

    'comment.required' =>
        'Please write the correction comment.',

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

            "Dear {$student->firstname},\n\n" .

            "Your supervisor has reviewed your research proposal and requested some corrections.\n\n" .

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
    
}