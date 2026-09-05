<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        Student Research Progress Report
    </title>

    <style>

        @page {
            margin: 35px 40px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .header {
            border-bottom: 3px solid #1f4e79;
            padding-bottom: 14px;
            margin-bottom: 22px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-left {
            width: 70%;
            vertical-align: top;
        }

        .header-right {
            width: 30%;
            text-align: right;
            vertical-align: top;
        }

        .system-title {
            font-size: 19px;
            font-weight: bold;
            color: #1f4e79;
            margin-bottom: 3px;
        }

        .report-title {
            font-size: 13px;
            font-weight: bold;
            color: #374151;
        }

        .report-subtitle {
            color: #6b7280;
            font-size: 9px;
            margin-top: 3px;
        }

        .report-date {
            font-size: 9px;
            color: #6b7280;
        }


        /* =====================================================
           STUDENT PROFILE
        ===================================================== */

        .section-title {
            background: #1f4e79;
            color: white;
            padding: 8px 10px;
            font-size: 11px;
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 10px;
        }

        .profile-table {
            width: 100%;
            border-collapse: collapse;
        }

        .profile-table td {
            border: 1px solid #d9e1e8;
            padding: 8px;
        }

        .profile-label {
            width: 25%;
            background: #f3f6f9;
            color: #6b7280;
            font-weight: bold;
        }

        .profile-value {
            width: 25%;
            font-weight: bold;
        }


        /* =====================================================
           STATISTICS
        ===================================================== */

        .stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 7px;
            margin-left: -7px;
        }

        .stat-box {
            border: 1px solid #d9e1e8;
            padding: 10px;
            text-align: center;
            width: 20%;
        }

        .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #1f4e79;
        }

        .stat-label {
            font-size: 8px;
            color: #6b7280;
            text-transform: uppercase;
        }


        /* =====================================================
           STATUS
        ===================================================== */

        .status-box {
            border: 1px solid #d9e1e8;
            padding: 12px;
            margin-top: 10px;
        }

        .status-title {
            font-weight: bold;
            font-size: 10px;
            color: #6b7280;
        }

        .status-value {
            font-size: 14px;
            font-weight: bold;
            margin-top: 4px;
            color: #1f4e79;
        }

        .progress-container {
            width: 100%;
            height: 9px;
            background: #e5e7eb;
            margin-top: 8px;
        }

        .progress-bar {
            height: 9px;
            background: #1f4e79;
        }


        /* =====================================================
           SUPERVISORS
        ===================================================== */

        .supervisor-table {
            width: 100%;
            border-collapse: collapse;
        }

        .supervisor-table th {
            background: #f3f6f9;
            border: 1px solid #d9e1e8;
            padding: 7px;
            text-align: left;
            font-size: 9px;
        }

        .supervisor-table td {
            border: 1px solid #d9e1e8;
            padding: 7px;
        }


        /* =====================================================
           RESEARCH SUMMARY
        ===================================================== */

        .research-card {
            border: 1px solid #d9e1e8;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .research-card-header {
            background: #f3f6f9;
            padding: 10px;
            border-bottom: 1px solid #d9e1e8;
        }

        .research-number {
            color: #6b7280;
            font-size: 8px;
            text-transform: uppercase;
        }

        .research-title {
            font-size: 13px;
            font-weight: bold;
            color: #1f4e79;
            margin-top: 3px;
        }

        .research-body {
            padding: 10px;
        }

        .research-info {
            width: 100%;
            border-collapse: collapse;
        }

        .research-info td {
            padding: 6px;
            border-bottom: 1px solid #edf0f3;
        }

        .research-info .label {
            width: 25%;
            color: #6b7280;
            font-weight: bold;
        }


        /* =====================================================
           STATUS BADGES
        ===================================================== */

        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 8px;
            font-weight: bold;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        .badge-correction {
            background: #fde2e2;
            color: #991b1b;
        }

        .badge-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-default {
            background: #e5e7eb;
            color: #374151;
        }


        /* =====================================================
           CORRECTIONS
        ===================================================== */

        .correction-title {
            font-size: 10px;
            font-weight: bold;
            color: #92400e;
            margin-top: 10px;
            margin-bottom: 6px;
        }

        .correction {
            border-left: 3px solid #d97706;
            background: #fffbeb;
            padding: 8px;
            margin-top: 6px;
        }

        .correction-meta {
            font-size: 8px;
            color: #6b7280;
        }

        .comment {
            margin-top: 5px;
            font-size: 9px;
        }

        .response {
            margin-top: 5px;
            font-size: 8px;
            color: #374151;
        }


        /* =====================================================
           EMPTY
        ===================================================== */

        .empty {
            border: 1px dashed #cbd5e1;
            padding: 15px;
            text-align: center;
            color: #6b7280;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {
            margin-top: 25px;
            border-top: 1px solid #d9e1e8;
            padding-top: 8px;
            font-size: 8px;
            color: #6b7280;
        }

        .footer-table {
            width: 100%;
        }

        .footer-right {
            text-align: right;
        }


        /* =====================================================
           PAGE BREAK
        ===================================================== */

        .page-break {
            page-break-before: always;
        }

    </style>

</head>


<body>


{{-- =========================================================
     HEADER
========================================================= --}}

<div class="header">

    <table class="header-table">

        <tr>

            <td class="header-left">

                <div class="system-title">
                    RESEARCH MANAGEMENT SYSTEM
                </div>

                <div class="report-title">
                    Student Research Progress Summary
                </div>

                <div class="report-subtitle">
                    Complete academic research history and supervision summary
                </div>

            </td>


            <td class="header-right">

                <div class="report-date">
                    Generated:
                </div>

                <strong>
                    {{ now()->format('d M Y h:i A') }}
                </strong>

            </td>

        </tr>

    </table>

</div>



{{-- =========================================================
     STUDENT INFORMATION
========================================================= --}}

<div class="section-title">
    STUDENT INFORMATION
</div>


<table class="profile-table">

    <tr>

        <td class="profile-label">
            Full Name
        </td>

        <td class="profile-value">

            {{ $student->firstname }}
            {{ $student->middlename }}
            {{ $student->lastname }}

        </td>

        <td class="profile-label">
            Registration Number
        </td>

        <td class="profile-value">
            {{ $student->reg_number }}
        </td>

    </tr>


    <tr>

        <td class="profile-label">
            Email
        </td>

        <td class="profile-value">
            {{ $student->email }}
        </td>

        <td class="profile-label">
            Phone
        </td>

        <td class="profile-value">
            {{ $student->phone }}
        </td>

    </tr>


    <tr>

        <td class="profile-label">
            Student Status
        </td>

        <td class="profile-value">
            {{ ucfirst($student->status) }}
        </td>

        <td class="profile-label">
            Overall Research Status
        </td>

        <td class="profile-value">
            {{ $overallStatus }}
        </td>

    </tr>

</table>



{{-- =========================================================
     STATISTICS
========================================================= --}}

<div class="section-title">
    RESEARCH SUMMARY
</div>


<table class="stats-table">

    <tr>

        <td class="stat-box">

            <div class="stat-number">
                {{ $totalResearch }}
            </div>

            <div class="stat-label">
                Total Research
            </div>

        </td>


        <td class="stat-box">

            <div class="stat-number">
                {{ $pendingResearch }}
            </div>

            <div class="stat-label">
                Pending
            </div>

        </td>


        <td class="stat-box">

            <div class="stat-number">
                {{ $correctionResearch }}
            </div>

            <div class="stat-label">
                Correction
            </div>

        </td>


        <td class="stat-box">

            <div class="stat-number">
                {{ $approvedResearch }}
            </div>

            <div class="stat-label">
                Approved
            </div>

        </td>


        <td class="stat-box">

            <div class="stat-number">
                {{ $totalCorrections }}
            </div>

            <div class="stat-label">
                Corrections
            </div>

        </td>

    </tr>

</table>



{{-- =========================================================
     OVERALL PROGRESS
========================================================= --}}

<div class="status-box">

    <div class="status-title">
        OVERALL RESEARCH PROGRESS
    </div>

    <div class="status-value">
        {{ $progressPercentage }}%
        —
        {{ $overallStatus }}
    </div>

    <div class="progress-container">

        <div
            class="progress-bar"
            style="width: {{ $progressPercentage }}%;"
        ></div>

    </div>

</div>



{{-- =========================================================
     SUPERVISORS
========================================================= --}}

<div class="section-title">
    SUPERVISOR INFORMATION
</div>


@if($supervisors->count())

<table class="supervisor-table">

    <thead>

        <tr>

            <th>
                Supervisor
            </th>

            <th>
                Type
            </th>

            <th>
                Status
            </th>

        </tr>

    </thead>


    <tbody>

        @foreach($supervisors as $supervisor)

        <tr>

            <td>
                {{ $supervisor['name'] }}
            </td>

            <td>
                {{ $supervisor['type'] }}
            </td>

            <td>
                {{ ucfirst($supervisor['status']) }}
            </td>

        </tr>

        @endforeach

    </tbody>

</table>

@else

<div class="empty">
    No supervisor information available.
</div>

@endif



{{-- =========================================================
     RESEARCH HISTORY
========================================================= --}}

<div class="section-title">
    RESEARCH HISTORY
</div>


@if($researches->count())


@foreach($researches as $index => $research)

@php

    $status = strtolower(
        $research->status ?? 'pending'
    );

@endphp


<div class="research-card">


    {{-- =====================================================
         RESEARCH HEADER
    ====================================================== --}}

    <div class="research-card-header">

        <div class="research-number">
            RESEARCH {{ $index + 1 }}
        </div>

        <div class="research-title">
            {{ $research->title }}
        </div>

    </div>



    {{-- =====================================================
         RESEARCH BODY
    ====================================================== --}}

    <div class="research-body">


        <table class="research-info">

            <tr>

                <td class="label">
                    Submitted
                </td>

                <td>

                    {{ $research->created_at
                        ? $research->created_at->format('d M Y h:i A')
                        : 'N/A'
                    }}

                </td>

            </tr>


            <tr>

                <td class="label">
                    Last Updated
                </td>

                <td>

                    {{ $research->updated_at
                        ? $research->updated_at->format('d M Y h:i A')
                        : 'N/A'
                    }}

                </td>

            </tr>


            <tr>

                <td class="label">
                    Current Status
                </td>

                <td>

                    @if($status === 'approved')

                        <span class="badge badge-approved">
                            APPROVED
                        </span>

                    @elseif($status === 'correction')

                        <span class="badge badge-correction">
                            CORRECTION REQUIRED
                        </span>

                    @elseif($status === 'pending')

                        <span class="badge badge-pending">
                            PENDING
                        </span>

                    @else

                        <span class="badge badge-default">
                            {{ strtoupper($status) }}
                        </span>

                    @endif

                </td>

            </tr>


            <tr>

                <td class="label">
                    Number of Corrections
                </td>

                <td>
                    {{ $research->corrections->count() }}
                </td>

            </tr>

        </table>



        {{-- =================================================
             CORRECTIONS
        ================================================== --}}

        @if($research->corrections->count())

            <div class="correction-title">
                SUPERVISOR FEEDBACK & CORRECTIONS
            </div>


            @foreach(
                $research->corrections->sortBy('created_at')
                as $correction
            )

                <div class="correction">

                    <strong>
                        Correction #{{ $loop->iteration }}
                    </strong>


                    <div class="correction-meta">

                        Supervisor:

                        @if($correction->supervisor)

                            {{ $correction->supervisor->firstname }}
                            {{ $correction->supervisor->middlename }}
                            {{ $correction->supervisor->lastname }}

                        @else

                            Unknown Supervisor

                        @endif

                        |

                        Date:

                        {{ $correction->created_at
                            ? $correction->created_at->format('d M Y h:i A')
                            : 'N/A'
                        }}

                    </div>


                    @if($correction->comment)

                        <div class="comment">

                            <strong>
                                Comment:
                            </strong>

                            {{ $correction->comment }}

                        </div>

                    @else

                        <div class="comment">

                            <strong>
                                Comment:
                            </strong>

                            No written comment provided.

                        </div>

                    @endif


                    @php

                        $previousCorrection =
                            $research->corrections
                                ->filter(function ($item) use ($correction) {

                                    return
                                        $item->created_at &&
                                        $correction->created_at &&
                                        $item->created_at
                                            ->lt($correction->created_at);

                                })
                                ->sortByDesc('created_at')
                                ->first();


                        $responseFrom =
                            $previousCorrection
                                ? $previousCorrection->created_at
                                : $research->created_at;

                    @endphp


                    @if(
                        $responseFrom &&
                        $correction->created_at
                    )

                        <div class="response">

                            Supervisor response:

                           {{ \Carbon\Carbon::parse($responseFrom)
    ->diffForHumans($correction->created_at, [
        'parts' => 3,
        'short' => false,
        'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE
    ])
}}

                            after

                            {{ $previousCorrection
                                ? 'previous correction'
                                : 'research submission'
                            }}

                        </div>

                    @endif

                </div>

            @endforeach

        @else

            <div class="empty" style="margin-top: 10px;">

                No correction recorded for this research.

            </div>

        @endif


    </div>

</div>


@endforeach


@else


<div class="empty">
    No research records found for this student.
</div>


@endif



{{-- =========================================================
     FOOTER
========================================================= --}}

<div class="footer">

    <table class="footer-table">

        <tr>

            <td>

                Research Management System

            </td>

            <td class="footer-right">

                Confidential Student Academic Record

            </td>

        </tr>

    </table>

</div>


</body>

</html>