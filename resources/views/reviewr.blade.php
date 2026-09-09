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


/* =========================
   MAIN CARD
========================= */

.research-card{
    background:#fff;
    border-radius:14px;
    padding:20px;
    box-shadow:0 2px 10px rgba(0,0,0,.06);
}


/* =========================
   SUPERVISOR HEADER
========================= */

.supervisor-header{
    display:flex;
    align-items:center;
    gap:15px;
    padding-bottom:18px;
    margin-bottom:20px;
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


/* =========================
   TABLE
========================= */

.research-table{
    width:100%;
    border-collapse:collapse;
}

.research-table th{
    background:#f8fafc;
    padding:13px;
    text-align:left;
    font-size:12px;
    color:#475569;
    font-weight:600;
    border-bottom:1px solid #e2e8f0;
}

.research-table td{
    padding:13px;
    font-size:13px;
    color:#334155;
    border-bottom:1px solid #f1f5f9;
    vertical-align:middle;
}

.research-table tbody tr:hover{
    background:#f8fafc;
}


/* =========================
   STUDENT
========================= */

.student-info{
    display:flex;
    align-items:center;
    gap:10px;
}

.student-avatar{
    width:38px;
    height:38px;
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


/* =========================
   TITLE
========================= */

.research-title{
    font-weight:600;
    color:#0f172a;
    max-width:300px;
}


/* =========================
   STATUS
========================= */

.status-badge{
    display:inline-block;
    padding:5px 10px;
    border-radius:20px;
    font-size:11px;
    font-weight:600;
}

.status-pending{
    background:#fef3c7;
    color:#92400e;
}

.status-under_review{
    background:#dbeafe;
    color:#1d4ed8;
}

.status-resubmitted{
    background:#dbeafe;
    color:#1d4ed8;
}

.status-correction{
    background:#fee2e2;
    color:#dc2626;
}

.status-rejected{
    background:#fee2e2;
    color:#b91c1c;
}

.status-approved{
    background:#dcfce7;
    color:#15803d;
}

.status-completed{
    background:#dcfce7;
    color:#15803d;
}


/* =========================
   DOCUMENT BUTTON
========================= */

.document-btn{
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:7px 11px;
    border-radius:7px;
    border:1px solid #dbeafe;
    background:#eff6ff;
    color:#2563eb;
    text-decoration:none;
    font-size:12px;
    font-weight:600;
}

.document-btn:hover{
    background:#dbeafe;
    color:#1d4ed8;
}


/* =========================
   NO RESEARCH
========================= */

.no-research{
    color:#94a3b8;
    font-size:12px;
    font-style:italic;
}


/* =========================
   EMPTY
========================= */

.empty-state{
    text-align:center;
    padding:60px 20px;
    color:#64748b;
}

.empty-state i{
    font-size:50px;
}

.empty-state h5{
    margin-top:15px;
    color:#334155;
}


/* =========================
   MOBILE
========================= */

@media(max-width:768px){

    .page-header{
        flex-direction:column;
        align-items:flex-start;
        gap:8px;
    }

    .research-card{
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

    .research-table{
        min-width:1000px;
    }

}

</style>


{{-- =========================================================
    PAGE HEADER
========================================================= --}}

<div class="page-header">

    <div>

        <h4>

            My Students Research

        </h4>

        <p>

            Research proposals submitted by students assigned to you.

        </p>

    </div>

</div>



{{-- =========================================================
    MAIN CARD
========================================================= --}}

<div class="research-card">


    {{-- SUPERVISOR INFORMATION --}}

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
                : 'Students'
            }}

        </div>

    </div>



    {{-- =====================================================
        STUDENTS
    ====================================================== --}}

    @if($assignments->count())


        <div class="table-responsive">

            <table class="research-table">


                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Student
                        </th>

                        <th>
                            Registration
                        </th>

                        <th>
                            Research Title
                        </th>

                        <th>
                            Submited research
                        </th>
                        <th>
                            All researches
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Submitted
                        </th>
                        <th>Action</th>

                    </tr>

                </thead>


              <tbody>

    @foreach($assignments as $index => $assignment)

        @php

            $student = $assignment->student;

            $research = $student
                ->researchProposals
                ->first();

        @endphp

        <tr>

            {{-- NUMBER --}}
            <td>
                {{ $index + 1 }}
            </td>


            {{-- STUDENT --}}
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

                        <div class="student-reg">

                            {{ $student->email ?? '-' }}

                        </div>

                    </div>

                </div>

            </td>


            {{-- REGISTRATION --}}
            <td>

                {{ $student->reg_number }}

            </td>


            {{-- RESEARCH TITLE --}}
            <td>

                @if($research)

                    <div
                        class="research-title"
                        title="{{ $research->title }}"
                    >
                        {{ Str::limit($research->title, 20, '...') }}
                    </div>

                @else

                    <span class="no-research">
                        No research submitted
                    </span>

                @endif

            </td>


            {{-- CURRENT RESEARCH --}}
            <td>

                @if($research && $research->document)

                    <a
                        href="{{ route(
                            'supervisor.research.show',
                            $research->id
                        ) }}"
                        class="document-btn"
                    >

                        <i class="bi bi-eye"></i>

                        View current research

                    </a>

                @else

                    <span class="no-research">
                        -
                    </span>

                @endif

            </td>


            {{-- ALL RESEARCHES --}}
            <td>

                @if($research && $research->document)

                    <a
                        href="{{ route(
                            'student.research.responses1',
                            $student->id
                        ) }}"
                        class="document-btn"
                    >

                        <i class="bi bi-eye"></i>

                        All researches

                    </a>

                @else

                    <span class="no-research">
                        -
                    </span>

                @endif

            </td>


            {{-- STATUS --}}
            <td>

                @if($research)

                    <span
                        class="status-badge status-{{ $research->status }}"
                    >

                        {{ ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $research->status
                            )
                        ) }}

                    </span>

                @else

                    <span class="status-badge">
                        -
                    </span>

                @endif

            </td>


            {{-- DATE --}}
            <td>

                @if($research)

                    {{ $research->created_at->format('d M Y') }}

                @else

                    -
                    
                @endif

            </td>


            {{-- DELETE --}}
            <td>

                @if($research)

                    <form
                        action="{{ route(
                            'admin.research.destroy',
                            $research->id
                        ) }}"
                        method="POST"
                        onsubmit="return confirm(
                            'Are you sure you want to delete this research? This action cannot be undone.'
                        );"
                        style="display:inline;"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger btn-sm"
                            title="Delete Research"
                        >

                            <i class="bi bi-trash"></i>


                        </button>

                    </form>

                @else

                    <span class="text-muted">
                        -
                    </span>

                @endif

            </td>

        </tr>

    @endforeach

</tbody>

            </table>

        </div>


    @else


        {{-- NO STUDENTS --}}

        <div class="empty-state">

            <i class="bi bi-people"></i>


            <h5>

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