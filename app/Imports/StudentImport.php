<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class StudentImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsEmptyRows
{
    /**
     * Import student.
     */
    
    public function model(array $row)
    {
        return new Student([
            'firstname'  => trim($row['firstname']),
            'middlename' => !empty($row['middlename'])
                ? trim($row['middlename'])
                : null,

            'lastname'   => trim($row['lastname']),
            'email'      => trim($row['email']),

            'phone'      => !empty($row['phone'])
                ? trim((string) $row['phone'])
                : null,

            'reg_number' => trim($row['reg_number']),

            // Convert password to string first
            'password'   => Hash::make((string) $row['password']),
        ]);
    }

    /**
     * Validation.
     */
    public function rules(): array
    {
        return [
            'firstname'  => 'required|string|max:255',

            'middlename' => 'nullable|string|max:255',

            'lastname'   => 'required|string|max:255',

            'email' => [
                    'required',
                    'email',
                    'unique:students,email',
                ],

            'phone'      => 'nullable|max:30',

            'reg_number' => 'required|string|max:100',

            // IMPORTANT:
            // Excel may read 12345 as an integer
            'password'   => 'required|min:4',
        ];
    }
    public function customValidationMessages()
{
    return [

        'firstname.required' =>
            'First name is required.',

        'lastname.required' =>
            'Last name is required.',

        'email.required' =>
            'Email is required.',

        'email.email' =>
            'Please provide a valid email address.',

        'email.unique' =>
            'This email is already registered.',

        'reg_number.required' =>
            'Registration number is required.',

        'reg_number.unique' =>
            'This registration number is already registered.',

        'password.required' =>
            'Password is required.',

        'password.min' =>
            'Password must be at least 4 characters.',
    ];
}
}