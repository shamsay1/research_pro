<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>
        Research Management System - Student Report
    </title>

    <style>

        @page {
            size: A4 portrait;
            margin: 25px 30px;
        }


        body {

            font-family: DejaVu Sans, Arial, sans-serif;

            font-size: 11px;

            color: #222;

            margin: 0;

            padding: 0;

        }


        .header {

            text-align: center;

            margin-bottom: 20px;

        }


        .header-line {

            border-top: 2px solid #222;

            margin-top: 8px;

            margin-bottom: 8px;

        }


        .header h1 {

            font-size: 18px;

            margin: 0;

            font-weight: bold;

        }


        .header h2 {

            font-size: 14px;

            margin: 5px 0;

            font-weight: bold;

        }


        .header h3 {

            font-size: 11px;

            margin: 0;

            font-weight: normal;

        }


        .section-title {

            font-size: 12px;

            font-weight: bold;

            margin-top: 18px;

            margin-bottom: 7px;

            padding-bottom: 4px;

            border-bottom: 1px solid #222;

        }


        .info-table {

            width: 100%;

            border-collapse: collapse;

            margin-bottom: 10px;

        }


        .info-table td {

            padding: 4px 2px;

            vertical-align: top;

        }


        .info-label {

            width: 28%;

            font-weight: bold;

        }


        .supervisor-table {

            width: 100%;

            border-collapse: collapse;

            margin-bottom: 15px;

        }


        .supervisor-table th,
        .supervisor-table td {

            border: 1px solid #555;

            padding: 6px;

            text-align: left;

        }


        .supervisor-table th {

            font-weight: bold;

            background: #f2f2f2;

        }


        .research {

            margin-top: 12px;

            margin-bottom: 15px;

            page-break-inside: avoid;

        }


        .research-title {

            font-size: 12px;

            font-weight: bold;

            margin-bottom: 5px;

        }


        .research-details {

            margin-left: 10px;

            line-height: 1.6;

        }


        .correction {

            margin-top: 7px;

            margin-left: 10px;

            padding: 7px;

            border-left: 3px solid #555;

            background: #f7f7f7;

            page-break-inside: avoid;

        }


        .correction-title {

            font-weight: bold;

            margin-bottom: 4px;

        }


        .comment {

            margin-top: 5px;

        }


        .status {

            font-weight: bold;

        }


        .signatures {

            width: 100%;

            margin-top: 55px;

            border-collapse: collapse;

        }


        .signatures td {

            width: 50%;

            text-align: center;

            padding-top: 25px;

        }


        .line {

            border-top: 1px solid #222;

            width: 70%;

            margin: auto;

            padding-top: 5px;

        }


        .footer {

            margin-top: 30px;

            padding-top: 7px;

            border-top: 1px solid #777;

            text-align: center;

            font-size: 9px;

        }


        .empty {

            font-style: italic;

            color: #666;

        }

    </style>

</head>


<body>


{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="header">

    <div class="header-line"></div>
    <div style="display: flex;justify-content: center">
        <img src="{{ asset('images/ipalogo1.png') }}" width="200px" height="140px">
    </div>
    <h1>
        RESEARCH MANAGEMENT SYSTEM
    </h1>

    <h2>
        STUDENT RESEARCH PROCESS REPORT
    </h2>

    <h3>
        Complete Research Submission and Supervision
    </h3>

    <div class="header-line"></div>

</div>


{{-- ========================================================= --}}
{{-- STUDENT INFORMATION --}}
{{-- ========================================================= --}}

<div class="section-title">
    STUDENT INFORMATION
</div>


<table class="info-table">

    <tr>

        <td class="info-label">
            Full Name
        </td>

        <td>

            {{ $student->firstname ?? '' }}

            {{ $student->middlename ?? '' }}

            {{ $student->lastname ?? '' }}

        </td>

    </tr>


    <tr>

        <td class="info-label">
            Registration Number
        </td>

        <td>
            {{ $student->reg_number ?? '-' }}
        </td>

    </tr>


    <tr>

        <td class="info-label">
            Email
        </td>

        <td>
            {{ $student->email ?? '-' }}
        </td>

    </tr>


    <tr>

        <td class="info-label">
            Phone
        </td>

        <td>
            {{ $student->phone ?? '-' }}
        </td>

    </tr>


    <tr>

        <td class="info-label">
            Status
        </td>

        <td>

            {{ ucfirst($student->status ?? '-') }}

        </td>

    </tr>

</table>


{{-- ========================================================= --}}
{{-- SUPERVISOR INFORMATION --}}
{{-- ========================================================= --}}

<div class="section-title">

    SUPERVISOR INFORMATION

</div>


<table class="supervisor-table">

    <thead>

        <tr>

            <th width="35%">
                TYPE
            </th>

            <th>
                NAME
            </th>

        </tr>

    </thead>


    <tbody>


        {{-- ================================================= --}}
        {{-- CORE SUPERVISOR --}}
        {{-- ================================================= --}}

        <tr>

            <td>
                Co-Supervisor
            </td>


            <td>

               

                    {{ $coreSupervisor->supervisor->firstname ?? '' }}

                    {{ $coreSupervisor->supervisor->middlename ?? '' }}

                    {{ $coreSupervisor->supervisor->lastname ?? '' }}

                

            </td>

        </tr>


        {{-- ================================================= --}}
        {{-- PRINCIPAL SUPERVISOR --}}
        {{-- ================================================= --}}

        <tr>

            <td>
                PRINCIPAL SUPERVISOR
            </td>


            <td>

                @if(
                    isset($principalSupervisor) &&
                    $principalSupervisor &&
                    $principalSupervisor->supervisor
                )

                    {{ $principalSupervisor->supervisor->firstname ?? '' }}

                    {{ $principalSupervisor->supervisor->middlename ?? '' }}

                    {{ $principalSupervisor->supervisor->lastname ?? '' }}

                @else

                    <span class="empty">
                        Not Assigned
                    </span>

                @endif

            </td>

        </tr>


    </tbody>

</table>


{{-- ========================================================= --}}
{{-- RESEARCH SUBMISSION HISTORY --}}
{{-- ========================================================= --}}

<div class="section-title">

    RESEARCH SUBMISSION HISTORY

</div>


@if($researches && $researches->count() > 0)


    @foreach($researches as $index => $research)


        <div class="research">


            {{-- RESEARCH NUMBER AND TITLE --}}

            <div class="research-title">

                {{ $index + 1 }}.
                {{ $research->title }}

            </div>


            {{-- STUDENT SUBMISSION --}}

            <div class="research-details">

                <strong>
                    Status:
                </strong>

                <span class="status">

                    {{ ucfirst(
                        str_replace(
                            '_',
                            ' ',
                            $research->status
                        )
                    ) }}

                </span>


                <br>


                <strong>
                    Research Submitted by Student
                </strong>


                <br>


                <strong>
                    Date:
                </strong>

                {{ $research->created_at
                    ? $research->created_at->format(
                        'd M Y h:i A'
                    )
                    : '-'
                }}

            </div>


            {{-- ================================================= --}}
            {{-- SUPERVISOR CORRECTIONS --}}
            {{-- ================================================= --}}

            @if(
                $research->corrections &&
                $research->corrections->count() > 0
            )


                @foreach(
                    $research->corrections as $correction
                )


                    <div class="correction">


                        <div class="correction-title">

                            Supervisor Correction / Response

                        </div>


                        <strong>
                            Supervisor:
                        </strong>


                        @if(
                            $correction->supervisor
                        )

                            {{ $correction->supervisor->firstname ?? '' }}

                            {{ $correction->supervisor->middlename ?? '' }}

                            {{ $correction->supervisor->lastname ?? '' }}

                        @else

                            Supervisor

                        @endif


                        <br>


                        <strong>
                            Date:
                        </strong>

                        {{ $correction->created_at
                            ? $correction->created_at->format(
                                'd M Y h:i A'
                            )
                            : '-'
                        }}


                        @if($correction->comment)


                            <div class="comment">

                                <strong>
                                    Supervisor Comment:
                                </strong>

                                <br>

                                {{ $correction->comment }}

                            </div>


                        @endif


                    </div>


                @endforeach


            @endif


            {{-- ================================================= --}}
            {{-- CURRENT STATUS --}}
            {{-- ================================================= --}}

            <div class="research-details"
                 style="margin-top: 7px;">

                <strong>
                    Current Research Status
                </strong>

                <br>

                {{ ucfirst(
                    str_replace(
                        '_',
                        ' ',
                        $research->status
                    )
                ) }}

            </div>


        </div>


    @endforeach


@else


    <p class="empty">
        No research submission found for this student.
    </p>


@endif


{{-- ========================================================= --}}
{{-- SIGNATURES --}}
{{-- ========================================================= --}}

<table class="signatures">

    <tr>

        <td>

            <div class="line"></div>

            Co-Supervisor

        </td>


        <td>

            <div class="line"></div>

            Principal Supervisor

        </td>

    </tr>

</table>


{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<div class="footer">

    Generated on:

    {{ now()->format('d M Y h:i A') }}

</div>


</body>

</html>