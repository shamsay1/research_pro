@extends('layout.app')

@section('content')

<style>
.page-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:20px;
}

.page-header h4{
    margin:0;
    font-size:22px;
    font-weight:700;
    color:#0f172a;
}

.page-header p{
    margin:5px 0 0;
    font-size:14px;
    color:#64748b;
}

.supervisor-card{
    background:#fff;
    border-radius:12px;
    padding:20px;
    box-shadow:0 2px 10px rgba(0,0,0,.06);
}

.supervisor-header{
    display:flex;
    align-items:center;
    gap:15px;
    padding-bottom:18px;
    margin-bottom:10px;
    border-bottom:1px solid #e2e8f0;
}

.supervisor-avatar{
    width:55px;
    height:55px;
    border-radius:50%;
    background:#eff6ff;
    color:#2563eb;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
}

.supervisor-name{
    font-size:18px;
    font-weight:700;
    color:#0f172a;
}

.supervisor-role{
    font-size:13px;
    color:#64748b;
    margin-top:3px;
}

.student-count{
    margin-left:auto;
    padding:7px 12px;
    border-radius:20px;
    background:#eff6ff;
    color:#2563eb;
    font-size:12px;
    font-weight:600;
}

.student-table{
    width:100%;
    border-collapse:collapse;
}

.student-table th{
    background:#f8fafc;
    padding:13px;
    text-align:left;
    font-size:12px;
    color:#475569;
    font-weight:600;
    border-bottom:1px solid #e2e8f0;
}

.student-table td{
    padding:13px;
    font-size:13px;
    color:#334155;
    border-bottom:1px solid #f1f5f9;
}

.student-table tbody tr:hover{
    background:#f8fafc;
}

.student-info{
    display:flex;
    align-items:center;
    gap:10px;
}

.student-avatar{
    width:36px;
    height:36px;
    border-radius:50%;
    background:#f1f5f9;
    color:#475569;
    display:flex;
    align-items:center;
    justify-content:center;
}

.student-name{
    font-weight:600;
    color:#0f172a;
}

.student-reg{
    font-size:11px;
    color:#64748b;
    margin-top:2px;
}

.status-badge{
    display:inline-block;
    padding:5px 10px;
    border-radius:20px;
    font-size:11px;
    font-weight:600;
}

.status-active{
    background:#dcfce7;
    color:#15803d;
}

.empty-state{
    text-align:center;
    padding:50px 20px;
    color:#64748b;
}

.empty-state i{
    font-size:45px;
}

@media(max-width:768px){

    .page-header{
        flex-direction:column;
        align-items:flex-start;
        gap:8px;
    }

    .supervisor-card{
        padding:12px;
    }

    .supervisor-header{
        align-items:flex-start;
    }

    .student-count{
        margin-left:auto;
        white-space:nowrap;
    }

    .table-responsive{
        overflow-x:auto;
    }
}
</style>


{{-- PAGE HEADER --}}

<div class="page-header">

    <div>

        <h4>
            My Students
        </h4>

        <p>
            Students assigned to you
        </p>

    </div>

</div>


{{-- SUPERVISOR INFORMATION --}}

<div class="supervisor-card">

    <div class="supervisor-header">

        <div class="supervisor-avatar">

            <i class="bi bi-person-workspace"></i>

        </div>

        <div>

            <div class="supervisor-name">

                {{ $supervisor->firstname }}
                {{ $supervisor->middlename }}
                {{ $supervisor->lastname }}

            </div>

            <div class="supervisor-role">
                Supervisor
            </div>

        </div>

        <div class="student-count">

            {{ $assignments->count() }}

            {{ $assignments->count() == 1
                ? 'Student'
                : 'Students' }}

        </div>

    </div>


    {{-- STUDENTS --}}

    @if($assignments->count())

        <div class="table-responsive">

            <table class="student-table">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Student</th>

                        <th>Registration Number</th>

                        <th>Email</th>

                        <th>Phone</th>

                        <th>Status</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($assignments as $index => $assignment)

                        @php
                            $student = $assignment->student;
                        @endphp

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>


                            <td>

                                <div class="student-info">

                                    <div class="student-avatar">

                                        <i class="bi bi-person"></i>

                                    </div>

                                    <div>

                                        <div class="student-name">

                                            {{ $student->firstname }}
                                            {{ $student->middlename }}
                                            {{ $student->lastname }}

                                        </div>

                                    </div>

                                </div>

                            </td>


                            <td>

                                {{ $student->reg_number }}

                            </td>


                            <td>

                                {{ $student->email ?? '-' }}

                            </td>


                            <td>

                                {{ $student->phone ?? '-' }}

                            </td>


                            <td>

                                <span class="status-badge status-active">

                                    {{ ucfirst($assignment->status) }}

                                </span>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="empty-state">

            <i class="bi bi-people"></i>

            <h5 class="mt-3">
                No Students Assigned
            </h5>

            <p>
                You currently have no students assigned to you.
            </p>

        </div>

    @endif

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: '{{ session('success') }}',
    confirmButtonText: 'OK'
});
</script>
@endif
@endsection