<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
     public function index()
    {
        $staff = Student::latest()->get();

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

    public function edit(Student $user)
    {
        return view('staff.edit', compact('user'));
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
