@extends('layout.app')

@section('content')

<style>
.page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
.page-header h4{margin:0;font-size:22px;font-weight:700;color:#0f172a}
.page-header p{margin:5px 0 0;font-size:18px;color:#64748b}
.btn-add{border:0;background:#2563eb;color:#fff;padding:10px 16px;border-radius:7px;font-size:18px;font-weight:600}
.btn-add:hover{background:#1d4ed8;color:#fff}
.staff-card{background:#fff;border-radius:12px;padding:20px;box-shadow:0 2px 10px rgba(0,0,0,.06)}
.table-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;gap:12px}
.search-box{position:relative;width:280px}
.search-box i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748b}
.search-box input{width:100%;height:40px;border:1px solid #dbe3ec;border-radius:7px;padding-left:38px;font-size:13px;background:#f8fafc;outline:0}

th{background:#f8fafc;color:#475569;font-size:18px;font-weight:600;padding:13px 12px;border-top:1px solid #e2e8f0;border-bottom:1px solid #e2e8f0;white-space:nowrap}
td{font-size:17px;color:#334155;padding:13px 12px;vertical-align:middle;border-bottom:1px solid #f1f5f9;white-space:nowrap}
tbody tr:hover{background:#f8fafc}
.staff-info{display:flex;align-items:center;gap:11px}
.staff-avatar{width:38px;height:38px;border-radius:50%;background:#eff6ff;color:#2563eb;display:flex;align-items:center;justify-content:center;font-size:17px}
.staff-name{font-size:15px;font-weight:600;color:#0f172a}
.role-badge,.status-badge{display:inline-block;padding:5px 10px;border-radius:20px;font-size:11px;font-weight:600}
.role-badge{background:#eff6ff;color:#2563eb}
.status-active{background:#dcfce7;color:#15803d}
.status-inactive{background:#fee2e2;color:#dc2626}
.action-btn{width:34px;height:34px;border:0;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-size:15px;margin:0 2px}
.action-view{background:#eff6ff;color:#2563eb}
.action-edit{background:#fff7ed;color:#ea580c}
.action-delete{background:#fef2f2;color:#dc2626}
.action-block{background:#fef2f2;color:#dc2626}
.action-unblock{background:#dcfce7;color:#15803d}
.form-control,.form-select{height:42px;border:1px solid #dbe3ec;border-radius:7px;background:#f8fafc;font-size:13px}
@media(max-width:768px){.page-header,.table-top{flex-direction:column;align-items:stretch}.search-box{width:100%}.staff-card{padding:15px}}
</style>

<div class="page-header">
    <div>
        <h4>Manage Student</h4>
        <p>Manage Student members in the system</p>
    </div>

    <div class="d-flex gap-2">

        <!-- Download Template -->
        <a href="{{ route('students.template') }}" class="btn btn-outline-success">
            <i class="bi bi-download me-1"></i>
            Download Template
        </a>

        <!-- Import Staff -->
        <button
            type="button"
            class="btn btn-outline-primary"
            data-bs-toggle="modal"
            data-bs-target="#importStaffModal"
        >
            <i class="bi bi-upload me-1"></i>
            Import Student
        </button>

        <!-- Add Staff -->
        <button
            class="btn-add"
            data-bs-toggle="modal"
            data-bs-target="#addStaffModal"
        >
            <i class="bi bi-person-plus-fill me-1"></i>
            Add Student
        </button>

    </div>
</div>
<!-- Import Staff Modal -->
<div class="modal fade" id="importStaffModal" tabindex="-1" aria-labelledby="importStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="importStaffModalLabel">
                    <i class="bi bi-upload me-2"></i>
                    Import Staff
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>       
            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="modal-body">

                    <div class="text-center mb-3">
                        <i class="bi bi-file-earmark-excel-fill"
                           style="font-size: 45px; color: #198754;"></i>

                        <h6 class="mt-2">Upload Staff File</h6>

                        <p class="text-muted small mb-0">
                            Choose an Excel or CSV file containing staff members.
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="staff_file" class="form-label">
                            Select File
                        </label>

                        <input
                            type="file"
                            name="student_file"
                            id="staff_file"
                            class="form-control"
                            accept=".xlsx,.xls,.csv"
                            required
                        >

                        <div class="form-text">
                            Allowed formats: XLSX, XLS, CSV
                        </div>
                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        <i class="bi bi-upload me-1"></i>
                        Import Staff
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>



<div class="staff-card">

    <div class="table-top">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="staffSearch" placeholder="Search staff...">
        </div>

        <div style="font-size:11px;color:#64748b">
            Total Student: <strong>{{ $staff->count() }}</strong>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-stried table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Reg Number</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody id="staffTable">

            @forelse($staff as $index => $user)

                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>
                        <div class="staff-info">
                            <div class="staff-avatar">
                                <i class="bi bi-person"></i>
                            </div>

                            <div class="staff-name">
                                {{ $user->firstname }}
                                {{ $user->middlename }}
                                {{ $user->lastname }}
                            </div>
                        </div>
                    </td>

                    <td>{{ $user->phone }}</td>

                    <td>{{ $user->email }}</td>

                    <td>{{ $user->reg_number }}</td>

                    <td>
                        <span class="role-badge">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    <td>
                        <span class="status-badge {{ $user->status === 'active' ? 'status-active' : 'status-inactive' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>

                    <td class="text-center">

                        <button type="button"
                            class="action-btn action-edit"
                            title="Edit"
                            data-bs-toggle="modal"
                            data-bs-target="#editStudentModal{{ $user->id }}">

                        <i class="bi bi-pencil"></i>

                    </button>
                    <div class="modal fade"
     id="editStudentModal{{ $user->id }}"
     tabindex="-1"
     aria-labelledby="editStudentModalLabel{{ $user->id }}"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header">

                <h5 class="modal-title"
                    id="editStudentModalLabel{{ $user->id }}">

                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Student Information

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>

            </div>


            {{-- FORM --}}
            <form action="{{ route('student.update', $user->id) }}"
                  method="POST">

                @csrf

                @method('PUT')


                <div class="modal-body">

                    <div class="row g-3">

                        {{-- FIRSTNAME --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                First Name
                            </label>

                            <input type="text"
                                   name="firstname"
                                   class="form-control"
                                   value="{{ old('firstname', $user->firstname) }}"
                                   required>

                        </div>


                        {{-- MIDDLENAME --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Middle Name
                            </label>

                            <input type="text"
                                   name="middlename"
                                   class="form-control"
                                   value="{{ old('middlename', $user->middlename) }}">

                        </div>


                        {{-- LASTNAME --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Last Name
                            </label>

                            <input type="text"
                                   name="lastname"
                                   class="form-control"
                                   value="{{ old('lastname', $user->lastname) }}"
                                   required>

                        </div>


                        {{-- EMAIL --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ old('email', $user->email) }}"
                                   required>

                        </div>


                        {{-- PHONE --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Phone
                            </label>

                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   value="{{ old('phone', $user->phone) }}">

                        </div>


                        {{-- REG NUMBER --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Registration Number
                            </label>

                            <input type="text"
                                   name="reg_number"
                                   class="form-control"
                                   value="{{ old('reg_number', $user->reg_number) }}"
                                   required>

                        </div>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        <i class="bi bi-x-circle me-1"></i>
                        Cancel

                    </button>


                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-check-circle me-1"></i>
                        Update Student

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

                        {{-- @if($user->status === 'active')

                            <form action="{{ route('student.block', $user->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Block this staff?')">
                                @csrf
                                @method('PATCH')

                                <button class="action-btn action-block" title="Block">
                                    <i class="bi bi-lock"></i>
                                </button>
                            </form>

                        @else

                            <form action="{{ route('student.unblock', $user->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Unblock this staff?')">
                                @csrf
                                @method('PATCH')

                                <button class="action-btn action-unblock" title="Unblock">
                                    <i class="bi bi-unlock"></i>
                                </button>
                            </form>

                        @endif --}}

                        <form action="{{ route('staff.destroy', $user->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Delete this staff?')">
                            @csrf
                            @method('DELETE')

                            <button class="action-btn action-delete" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="8" class="text-center py-4">
                        No Student found
                    </td>
                </tr>

            @endforelse

            </tbody>
        </table>
        <div>
            {{ $staff->links() }}
        </div>
    </div>
</div>


{{-- ADD STAFF MODAL --}}
<div class="modal fade" id="addStaffModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-plus-fill me-2"></i>
                    Add Student
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('student.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">First Name</label>
                            <input type="text"
                                   name="firstname"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Middle Name</label>
                            <input type="text"
                                   name="middlename"
                                   class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Last Name</label>
                            <input type="text"
                                   name="lastname"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Registration Number</label>
                            <input type="text"
                                   name="reg_number"
                                   class="form-control"
                                   required>
                        </div>

                        

                        <div class="col-md-12">
                            <label class="form-label">Password</label>

                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   value="12345"
                                   required>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>
                        Save Student
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- SUCCESS MESSAGE --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: @json(session('success')),
        confirmButtonText: 'OK'
    });
</script>
@endif


{{-- ERROR MESSAGE --}}
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: @json(session('error')),
        confirmButtonText: 'OK'
    });
</script>
@endif


{{-- IMPORT VALIDATION ERRORS --}}
@if(session('import_errors'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Import Errors',
        html: `
            <div style="text-align: left;">
                <ul style="padding-left: 20px; margin-bottom: 0;">
                    @foreach(session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        `,
        confirmButtonText: 'OK',
        width: '600px'
    });
</script>
@endif


{{-- NORMAL FORM VALIDATION ERRORS --}}
@if($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Please correct the following errors',
        html: `
            <div style="text-align: left;">
                <ul style="padding-left: 20px; margin-bottom: 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        `,
        confirmButtonText: 'OK',
        width: '600px'
    });
</script>
@endif
<script>
document.getElementById('staffSearch').addEventListener('keyup', function () {
    const search = this.value.toLowerCase();

    document.querySelectorAll('#staffTable tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(search) ? '' : 'none';
    });
});
</script>

@endsection