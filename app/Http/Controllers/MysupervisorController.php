<?php

namespace App\Http\Controllers;

use App\Models\SupervisorAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MysupervisorController extends Controller
{
    public function mysupervisor()
    {
        // Hakikisha mwanafunzi ameingia
        if (!Auth::guard('student')->check()) {
            return redirect()->route('login');
        }

        // Mwanafunzi aliye-login
        $student = Auth::guard('student')->user();

        /*
        |--------------------------------------------------------------------------
        | GET SUPERVISOR ASSIGNMENTS
        |--------------------------------------------------------------------------
        | Tunachukua assignments za mwanafunzi huyu tu.
        |
        | status = active
        |
        */
        $assignments = SupervisorAssignment::with('supervisor')
            ->where('student_id', $student->id)
            ->where('status', 'active')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SEPARATE CORE AND PRINCIPAL
        |--------------------------------------------------------------------------
        */

        $coreSupervisor = $assignments
            ->where('supervisor_type', 'core')
            ->first();

        $principalSupervisor = $assignments
            ->where('supervisor_type', 'principal')
            ->first();

        return view('mysupervisor', compact(
            'student',
            'coreSupervisor',
            'principalSupervisor'
        ));
    }
}
