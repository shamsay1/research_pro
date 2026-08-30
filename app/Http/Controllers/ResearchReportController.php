<?php

namespace App\Http\Controllers;

use App\Models\ResearchProposal;
use App\Models\ResearchCorrection;
use App\Models\SystemUser;
use Illuminate\Http\Request;

class ResearchReportController extends Controller
{
    /**
     * =========================================================
     * RESEARCH PROCESS REPORT
     * =========================================================
     */
  public function index(Request $request)
{
    $search = $request->input('search');

    /*
    |--------------------------------------------------------------------------
    | Query Students wenye Research
    |--------------------------------------------------------------------------
    */

    $query = ResearchProposal::with([
        'student',
        'corrections.supervisor'
    ])
    ->orderBy('created_at', 'asc');

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | Paginate Research
    |--------------------------------------------------------------------------
    */

    $researches = $query
        ->paginate(50)
        ->withQueryString();

    /*
    |--------------------------------------------------------------------------
    | Group by Student
    |--------------------------------------------------------------------------
    */

    $groupedResearches = $researches
        ->getCollection()
        ->groupBy('student_id');

    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

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
}

