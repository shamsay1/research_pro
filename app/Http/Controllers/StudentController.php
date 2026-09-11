<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SupervisorAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
     public function index(Request $request)
{
    $search = $request->input('search');

    $staff = Student::query()
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                  ->orWhere('middlename', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('reg_number', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        })
        ->paginate(5)
        ->withQueryString();

    // AJAX request
    if ($request->ajax()) {
        return view('partials.students_table', compact('staff'))->render();
    }

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

   public function update(Request $request, Student $student)
{
    $validated = $request->validate([
        'firstname' => ['required', 'string', 'max:255'],
        'middlename' => ['nullable', 'string', 'max:255'],
        'lastname' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'phone' => ['nullable', 'string', 'max:30'],
        'reg_number' => ['required', 'string', 'max:100'],
    ]);

    $student->firstname = $validated['firstname'];
    $student->middlename = $validated['middlename'] ?? null;
    $student->lastname = $validated['lastname'];
    $student->email = $validated['email'];
    $student->phone = $validated['phone'] ?? null;
    $student->reg_number = $validated['reg_number'];

    $student->save();

    return redirect()
        ->route('student.index')
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
