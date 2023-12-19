<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print Exam Result</title>
    <style type="text/css">
        @page {
            size: 8.3in 11.7in
        }

        @page {
            size: A4;
        }

        .margin-bottom {
            margin-bottom: 3px;
        }

        .table-bg {
            border-collapse: collapse;
            width: 100%;
            font-size: 15px;
            text-align: center;
        }

        .th {
            border: 1px solid #000;
            padding: 10px;
        }

        .td {
            border: 1px solid #000;
            padding: 3px;
        }

        .text-container {
            text-align: left;
            padding-left: 5px;
        }

        @media print {
            @page {
                margin: 0px;
                margin-left: 20px;
                margin-right: 20px;
            }
        }
    </style>
</head>

<body>
    <div id=page>
        <table style="width:100%; text-align:center;">
            <tr>
                <td width="5%"></td>
                <td width="15%"><img src="{{ $getSetting->getLogo() }}" style="width: 110px;"></td>
                <td align="left">
                    <h1>{!! $getSetting->school_name !!} </h1>
                </td>
            </tr>
        </table>

        @if(!empty($getExam) && !empty($getStudent) )
        <table style="width: 100%;">
            <tr>
                <td width="5%"></td>
                <td width="70%">
                    <table class="margin-bottom" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td width="27%">Name of Student: </td>
                                <td style="border-bottom: 1px solid; width: 100%;"> {{ $getStudent->name }}
                                    {{ $getStudent->last_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="margin-bottom" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td width="23%">Admission No: </td>
                                <td style="border-bottom: 1px solid; width: 100%;"> {{ $getStudent->admission_number }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="margin-bottom" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td width="23%">Class: </td>
                                <td style="border-bottom: 1px solid; width: 100%;">
                                    @if (!empty($getClass))
                                        {{ $getClass->class_name }}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="margin-bottom" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td width="11%">Term: </td>
                                <td style="border-bottom: 1px solid; width: 40%;"> {{ $getExam->name }}</td>
                                <td width="18%">Export date: </td>
                                <td style="border-bottom: 1px solid; width: 60%;">
                                    {{ \Illuminate\Support\Carbon::now()->format('d-m-Y H:i:s') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="5%"></td>
                <td width="20%" valign="top">
                    @if ($getStudent->profile_pic)
                        <img src="{{ asset(env('UPLOAD_PATH') . '/profile/student/' . $getStudent->profile_pic) }}"
                            alt="Profile Pic" style="border-radius: 6px; " height="100px" width="100px">
                    @else
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset(env('UPLOAD_PATH') . '/profile/' . 'no_avatar.jpg') }}" alt="Profile Pic"
                                style="border-radius: 6px; " height="100px" width="100px">
                        </div>
                    @endif
                    <br>
                    Gender : {{ $getStudent->gender }}
                </td>
            </tr>
        </table>

        <br>
        <div class="res-tab">
            <table class="table-bg">
                <thead>
                    <tr>
                        <th class="th">Subject Name</th>
                        <th class="th">Class Work</th>
                        <th class="th">Test Work</th>
                        <th class="th">Home Work</th>
                        <th class="th">Exam</th>
                        <th class="th">Total Score</th>
                        <th class="th">Passing Marks</th>
                        <th class="th">Full Marks</th>
                        <th class="th">Result</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($getExamMark))
                        @php
                            $total_score = 0;
                            $full_marks = 0;
                            $result_validation = 0;
                        @endphp
                        @foreach ($getExamMark as $exam)
                            @php
                                $total_score += $exam['total_score'];
                                $full_marks += $exam['full_marks'];
                            @endphp
                            <tr>
                                <td class="td" style="width: 300px; text-align: left;">{{ $exam['subject_name'] }}
                                </td>
                                <td class="td">{{ $exam['class_work'] }}</td>
                                <td class="td">{{ $exam['test_work'] }}</td>
                                <td class="td">{{ $exam['home_work'] }}</td>
                                <td class="td">{{ $exam['exam'] }}</td>
                                <td class="td">{{ $exam['total_score'] }}</td>
                                <td class="td">{{ $exam['passing_marks'] }}</td>
                                <td class="td">{{ $exam['full_marks'] }}</td>
                                <td class="td">
                                    @if ($exam['total_score'] >= $exam['passing_marks'])
                                        <span style="color: green; font-weight: bold">Pass</span>
                                    @else
                                        @php
                                            $result_validation = 1;
                                        @endphp
                                        <span style="color: red; font-weight: bold">Fail</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="td" colspan="2">
                                <b>Grand Total:
                                    @if ($full_marks != 0)
                                        {{ $total_score }}/{{ $full_marks }}
                                    @else
                                        0
                                    @endif
                                </b>
                            </td>
                            <td class="td" colspan="2">
                                @php
                                    if ($full_marks != 0) {
                                        $percentage = ($total_score * 100) / $full_marks;
                                    } else {
                                        $percentage = 0;
                                    }

                                    $getGrade = App\Models\MarksGradeModel::getGrade($percentage);
                                @endphp
                                <b>Percentage: {{ round($percentage, 2) }}%</b>
                            </td>
                            <td class="td" colspan="2">
                                <b>Grade: {{ $getGrade }}</b>
                            </td>
                            <td class="td" colspan="3">
                                <b>
                                    Result:
                                    @if ($result_validation == 0)
                                        <span style="color: green; font-weight: bold">Pass</span>
                                    @else
                                        <span style="color: red; font-weight: bold">Fail</span>
                                    @endif
                                </b>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="100%" class="td" style="text-align: center">
                                <h2 style="color: red">{{ $message }}</h2>
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>

        <div>
            <p>{{ $getSetting->exam_description }}</p>
        </div>

        <table class="margin-bottom" style="width: 100%;">
            <tbody>
                <tr>
                    <td width="15%">Signature: </td>
                    <td style="border-bottom: 1px solid; width: 100%;"></td>
                </tr>
            </tbody>
        </table>
        @endif
    </div>



    <script type="text/javascript">
        @if (!empty($getExamMark))
            window.print();
        @endif
    </script>
</body>

</html>
