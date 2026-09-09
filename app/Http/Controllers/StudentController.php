<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SupervisorAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
     public function index()
    {
        $staff = Student::paginate(10);

        return view('students', compact('staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname'   => 'required|string|max:100',
            'middlename'  => 'nullable|string|max:100',
            'lastname'    => 'required|string|max:100',
            'email'       => 'required|email|unique:users,email',
            'phone'       => 'required|string|max:20',
            'reg_number'  => 'required|string',
            'password'    => 'required|string|',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Student::create($validated);

        return redirect()
            ->route('student.index')
            ->with('success', 'Student registered successfully.');
    }

    public function update(Request $request, Student $user)
{
    $validated = $request->validate([
        'firstname' => [
            'required',
            'string',
            'max:255',
        ],

        'middlename' => [
            'nullable',
            'string',
            'max:255',
        ],

        'lastname' => [
            'required',
            'string',
            'max:255',
        ],

        'email' => [
            'required',
            'email',
            'max:255',
            'unique:students,email,' . $user->id,
        ],

        'phone' => [
            'nullable',
            'string',
            'max:30',
        ],

        'reg_number' => [
            'required',
            'string',
            'max:100',
            'unique:students,reg_number,' . $user->id,
        ],
    ]);

    $user->update($validated);

    return redirect()
        ->back()
        ->with('success', 'Student information updated successfully.');
}
    

    public function block(Student $user)
    {
        $user->update(['status' => 'inactive']);

        return redirect()
            ->route('student.index')
            ->with('success', 'Staff blocked successfully.');
    }

    public function unblock(Student $user)
    {
        $user->update(['status' => 'active']);

        return redirect()
            ->route('student.index')
            ->with('success', 'Staff unblocked successfully.');
    }

    public function destroy(Student $user)
    {
        $user->delete();

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff deleted successfully.');
    }
      
}
