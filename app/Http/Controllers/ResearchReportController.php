<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchProposal;
use App\Models\SupervisorAssignment;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class ResearchReportController extends Controller
{
    /**
     * ============================================================
     * ADMIN RESEARCH REPORT
     * ============================================================
     */
    public function index(Request $request)
{
    $search = $request->input('search');

    /* --------------------------------------------------------------------------
    | Research Proposals
    | -------------------------------------------------------------------------- */
    $query = ResearchProposal::with([
        'student',
        'student.supervisorAssignments.supervisor',
        'corrections.supervisor'
    ])
    ->orderBy('created_at', 'asc');

    /* --------------------------------------------------------------------------
    | Search
    | -------------------------------------------------------------------------- */
    if ($search) {
        $query->where(function ($q) use ($search) {

            $q->where(
                'title',
                'like',
                '%' . $search . '%'
            )

            ->orWhereHas('student', function ($studentQuery) use ($search) {

                $studentQuery
                    ->where(
                        'firstname',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'lastname',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'reg_number',
                        'like',
                        '%' . $search . '%'
                    );
            });
        });
    }

    /* --------------------------------------------------------------------------
    | Pagination
    | -------------------------------------------------------------------------- */
    $researches = $query
        ->paginate(50)
        ->withQueryString();

    /* --------------------------------------------------------------------------
    | Group Research By Student
    | -------------------------------------------------------------------------- */
    $groupedResearches = $researches
        ->getCollection()
        ->groupBy('student_id');

    /* --------------------------------------------------------------------------
    | Statistics
    | -------------------------------------------------------------------------- */
    $totalResearch = ResearchProposal::count();

    $pendingResearch = ResearchProposal::where(
        'status',
        'pending'
    )->count();

    $correctionResearch = ResearchProposal::where(
        'status',
        'correction'
    )->count();

    $approvedResearch = ResearchProposal::where(
        'status',
        'approved'
    )->count();

    /* --------------------------------------------------------------------------
    | Return Report View
    | -------------------------------------------------------------------------- */
    return view(
        'report',
        compact(
            'researches',
            'groupedResearches',
            'search',
            'totalResearch',
            'pendingResearch',
            'correctionResearch',
            'approvedResearch'
        )
    );
}

    public function studentReport($studentId)
{
    $student = Student::findOrFail($studentId);

    /*
    |--------------------------------------------------------------------------
    | Get supervisors assigned to this student
    |--------------------------------------------------------------------------
    */
    $assignments = SupervisorAssignment::with('supervisor')
        ->where('student_id', $student->id)
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Get student researches
    |--------------------------------------------------------------------------
    */
    $researches = ResearchProposal::with([
        'student',
        'corrections.supervisor'
    ])
    ->where('student_id', $student->id)
    ->orderBy('created_at', 'asc')
    ->get();

    /*
    |--------------------------------------------------------------------------
    | Generate PDF
    |--------------------------------------------------------------------------
    */
    $pdf = Pdf::loadView('print', [
        'student' => $student,
        'researches' => $researches,
        'assignments' => $assignments,
    ]);

    $pdf->setPaper('A4', 'portrait');

    return $pdf->stream(
        'research-report-' . $student->reg_number . '.pdf'
    );
}
}