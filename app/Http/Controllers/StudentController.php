<?php

namespace App\Http\Controllers;

use App\Student;
use App\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    /**
     * display all students
     */
    public function index(Request $request)
    {
        $students = Student::where('purpose', 'training')
            ->paginate(20);

        return view('students.index')
            ->with(compact(['students']));
    }

    /**
     * handle excel submit
     */
    public function submitExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'excel' => 'required|file|mimes:csv,txt'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
        }

        try {
            $purpose = 'training';

            if ($request->has('dataPurpose')) {
                if ($request->dataPurpose == 'testing') {
                    $purpose = 'testing';
                } else {
                    $purpose = 'training';
                }
            }

            $csv = $this->readCSV($request->file('excel')->getRealPath());

            DB::beginTransaction();

            switch ($purpose) {
                case 'testing':
                    DB::table('scores')
                        ->join('students', 'scores.student_id', '=', 'students.id')
                        ->select('scores.*')
                        ->where('students.purpose', '=', 'testing')
                        ->delete();

                    Student::where('purpose', 'testing')->delete();

                    break;
                case 'training':
                    DB::table('scores')
                        ->join('students', 'scores.student_id', '=', 'students.id')
                        ->select('scores.*')
                        ->where('students.purpose', '=', 'training')
                        ->delete();

                    Student::where('purpose', 'training')->delete();
                    break;
                default:
                    Score::query()->delete();
                    Student::query()->delete();
                    break;
            }

            $iter = 1;
            $csv = array_slice($csv, 1);
            if ($purpose == 'testing') {
                shuffle($csv);
            }

            foreach ($csv as $index => $line) {
                if ($line == false) {
                    continue;
                }

                if ($iter > 200 && $purpose == 'testing') {
                    continue;
                }

                if (
                    ($line[0] != NULL && $line[0] != "") && 
                    ($line[1] != NULL && $line[1] != "") && 
                    ($line[2] != NULL && $line[2] != "") && 
                    ($line[3] != NULL && $line[3] != "") && 
                    ($line[4] != NULL && $line[4] != "") && 
                    ($line[5] != NULL && $line[5] != "") && 
                    ($line[6] != NULL && $line[6] != "") && 
                    ($line[7] != NULL && $line[7] != "") && 
                    ($line[8] != NULL && $line[8] != "") && 
                    ($line[9] != NULL && $line[9] != "") && 
                    ($line[10] != NULL && $line[10] != "") && 
                    ($line[11] != NULL && $line[11] != "" && (float) $line[11] <= 4 && (float) $line[11] >= 0) && 
                    ($line[12] != NULL && $line[12] != "" && (float) $line[12] <= 4 && (float) $line[12] >= 0) && 
                    ($line[13] != NULL && $line[13] != "" && (float) $line[13] <= 4 && (float) $line[13] >= 0) && 
                    ($line[14] != NULL && $line[14] != "" && (float) $line[14] <= 4 && (float) $line[14] >= 0) && 
                    ($line[15] != NULL && $line[15] != "" && (float) $line[15] <= 4 && (float) $line[15] >= 0) && 
                    ($line[16] != NULL && $line[16] != "" && (float) $line[16] <= 4 && (float) $line[16] >= 0) && 
                    ($line[17] != NULL && $line[17] != "" && (int) $line[17] <= 24 && (int) $line[17] >= 0) && 
                    ($line[18] != NULL && $line[18] != "" && (int) $line[18] <= 24 && (int) $line[18] >= 0) && 
                    ($line[19] != NULL && $line[19] != "" && (int) $line[19] <= 24 && (int) $line[19] >= 0) && 
                    ($line[20] != NULL && $line[20] != "" && (int) $line[20] <= 24 && (int) $line[20] >= 0) && 
                    ($line[21] != NULL && $line[21] != "" && (int) $line[21] <= 24 && (int) $line[21] >= 0) && 
                    ($line[22] != NULL && $line[22] != "" && (int) $line[22] <= 24 && (int) $line[22] >= 0) && 
                    ($line[23] != NULL && $line[23] != "") 

                ) {
                    $student = DB::table('students')
                    ->insertGetId([
                        'study_program' => $line[0],
                        'year_class' => (int) $line[1],
                        'born_data' => json_encode([
                            'born_place' => $this->filterBornPlace($line[2]),
                            'born_date' => $line[3]
                        ]),
                        'religion' => $line[4],
                        'gender' => $this->filterGender($line[5]),
                        'address' => $line[6],
                        'parent_data' => json_encode([
                            'father_education' => $this->filterEducation($line[7]),
                            'mother_education' => $this->filterEducation($line[8]),
                            'father_job' => $line[9],
                            'mother_job' => $line[10]
                        ]),
                        'purpose' => $purpose,
                        'dump' => json_encode($line)
                    ]);

                    DB::table('scores')
                    ->insert([
                        'student_id' => $student,
                        'gpa' => json_encode([
                            'first' => $this->filterGpa((float) $line[11]),
                            'second' => $this->filterGpa((float) $line[12]),
                            'third' => $this->filterGpa((float) $line[13]),
                            'fourth' => $this->filterGpa((float) $line[14]),
                            'fifth' => $this->filterGpa((float) $line[15]),
                            'sixth' => $this->filterGpa((float) $line[16])
                        ]),
                        'course_credit' => json_encode([
                            'first' => $this->filterCourseCredit((int) $line[17]),
                            'second' => $this->filterCourseCredit((int) $line[18]),
                            'third' => $this->filterCourseCredit((int) $line[19]),
                            'fourth' => $this->filterCourseCredit((int) $line[20]),
                            'fifth' => $this->filterCourseCredit((int) $line[21]),
                            'sixth' => $this->filterCourseCredit((int) $line[22])
                        ]),
                        'status' => json_encode([
                            'numeric' => $this->filterStatus($line[23]),
                            'text' => $line[23]
                        ]),
                        'dump' => json_encode($line)
                    ]);
                }

            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            abort(403, $e->getMessage());
        }

        Session::flash('message', 'Data stored');

        if ($purpose == 'training') {
            return redirect()
                ->route('student.index');
        } else if ($purpose == 'testing') {
            return redirect()
                ->route('student.test.excel');
        } else {
            return redirect()
                ->back();
        }
    }

    /**
     * test form
     */
    public function test(Request $request)
    {
        $statistics = $this->getStatistics();

        if (isset($request->_token)) {
            $all = [
                'positive' => $statistics['all']['positive'] + 1,
                'negative' => $statistics['all']['negative'] + 1,
                'total' => $statistics['all']['total'] + 2,
            ];

            $bornPlace = [
                'result' => $request->born_place,
                'positive' => ($statistics['bornPlace'][$request->born_place]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['bornPlace'][$request->born_place]['negative'] + 1) / $all['negative'],
                'total' => $statistics['bornPlace'][$request->born_place]['total'] + 2
            ];

            $gender = [
                'result' => $request->gender,
                'positive' => ($statistics['gender'][$request->gender]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['gender'][$request->gender]['negative'] + 1) / $all['negative'],
                'total' => $statistics['gender'][$request->gender]['total'] + 2
            ];

            $gpa1 = [
                'result' => $request->gpa_1,
                'positive' => ($statistics['gpa1'][$request->gpa_1]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['gpa1'][$request->gpa_1]['negative'] + 1) / $all['negative'],
                'total' => $statistics['gpa1'][$request->gpa_1]['total'] + 2
            ];

            $gpa2 = [
                'result' => $request->gpa_2,
                'positive' => ($statistics['gpa2'][$request->gpa_2]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['gpa2'][$request->gpa_2]['negative'] + 1) / $all['negative'],
                'total' => $statistics['gpa2'][$request->gpa_2]['total'] + 2
            ];

            $gpa3 = [
                'result' => $request->gpa_3,
                'positive' => ($statistics['gpa3'][$request->gpa_3]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['gpa3'][$request->gpa_3]['negative'] + 1) / $all['negative'],
                'total' => $statistics['gpa3'][$request->gpa_3]['total'] + 2
            ];
            
            $gpa4 = [
                'result' => $request->gpa_4,
                'positive' => ($statistics['gpa4'][$request->gpa_4]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['gpa4'][$request->gpa_4]['negative'] + 1) / $all['negative'],
                'total' => $statistics['gpa4'][$request->gpa_4]['total'] + 2
            ];
            
            $gpa5 = [
                'result' => $request->gpa_5,
                'positive' => ($statistics['gpa5'][$request->gpa_5]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['gpa5'][$request->gpa_5]['negative'] + 1) / $all['negative'],
                'total' => $statistics['gpa5'][$request->gpa_5]['total'] + 2
            ];
            
            $gpa6 = [
                'result' => $request->gpa_6,
                'positive' => ($statistics['gpa6'][$request->gpa_6]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['gpa6'][$request->gpa_6]['negative'] + 1) / $all['negative'],
                'total' => $statistics['gpa6'][$request->gpa_6]['total'] + 2
            ];

            $cc1 = [
                'result' => $request->cc_1,
                'positive' => ($statistics['cc1'][$request->cc_1]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['cc1'][$request->cc_1]['negative'] + 1) / $all['negative'],
                'total' => $statistics['cc1'][$request->cc_1]['total'] + 2
            ];
            
            $cc2 = [
                'result' => $request->cc_2,
                'positive' => ($statistics['cc2'][$request->cc_2]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['cc2'][$request->cc_2]['negative'] + 1) / $all['negative'],
                'total' => $statistics['cc2'][$request->cc_2]['total'] + 2
            ];

            $cc3 = [
                'result' => $request->cc_3,
                'positive' => ($statistics['cc3'][$request->cc_3]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['cc3'][$request->cc_3]['negative'] + 1) / $all['negative'],
                'total' => $statistics['cc3'][$request->cc_3]['total'] + 2
            ];

            $cc4 = [
                'result' => $request->cc_4,
                'positive' => ($statistics['cc4'][$request->cc_4]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['cc4'][$request->cc_4]['negative'] + 1) / $all['negative'],
                'total' => $statistics['cc4'][$request->cc_4]['total'] + 2
            ];

            $cc5 = [
                'result' => $request->cc_5,
                'positive' => ($statistics['cc5'][$request->cc_5]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['cc5'][$request->cc_5]['negative'] + 1) / $all['negative'],
                'total' => $statistics['cc5'][$request->cc_5]['total'] + 2
            ];

            $cc6 = [
                'result' => $request->cc_6,
                'positive' => ($statistics['cc6'][$request->cc_6]['positive'] + 1) / $all['positive'],
                'negative' => ($statistics['cc6'][$request->cc_6]['negative'] + 1) / $all['negative'],
                'total' => $statistics['cc6'][$request->cc_6]['total'] + 2
            ];

            $result = [
                'all' => $all,
                'bornPlace' => $bornPlace,
                'gender' => $gender,
                'gpa1' => $gpa1,
                'gpa2' => $gpa2,
                'gpa3' => $gpa3,
                'gpa4' => $gpa4,
                'gpa5' => $gpa5,
                'gpa6' => $gpa6,
                'cc1' => $cc1,
                'cc2' => $cc2,
                'cc3' => $cc3,
                'cc4' => $cc4,
                'cc5' => $cc5,
                'cc6' => $cc6,
                'p' => [
                    'positive' => ($bornPlace['positive'] * 
                        $gender['positive'] *
                        $gpa1['positive'] * 
                        $gpa2['positive'] * 
                        $gpa3['positive'] * 
                        $gpa4['positive'] * 
                        $gpa5['positive'] * 
                        $gpa6['positive'] *
                        $cc1['positive'] *
                        $cc2['positive'] *
                        $cc3['positive'] *
                        $cc4['positive'] *
                        $cc5['positive'] *
                        $cc6['positive']) *
                        ($all['positive'] / $all['total']),
                    'negative' => $bornPlace['negative'] * 
                        $gender['negative'] * 
                        $gpa1['negative'] * 
                        $gpa2['negative'] * 
                        $gpa3['negative'] * 
                        $gpa4['negative'] * 
                        $gpa5['negative'] * 
                        $gpa6['negative'] *
                        $cc1['negative'] *
                        $cc2['negative'] *
                        $cc3['negative'] *
                        $cc4['negative'] *
                        $cc5['negative'] *
                        $cc6['negative'] *
                        ($all['negative'] / $all['total'])
                ]
            ];

            $decision = [
                'positive' => round(($result['p']['positive'] / ($result['p']['positive'] + $result['p']['negative'])) * 100, 2),
                'negative' => round(($result['p']['negative'] / ($result['p']['positive'] + $result['p']['negative'])) * 100, 2)
            ];

            return view('students.test')
                ->with('result', $result)
                ->with('decision', $decision);
        } else {
            return view('students.test');
        }
    }

    /**
     * test based on excel
     */
    public function testExcel()
    {
        $students = Student::where('purpose', 'testing')
            ->paginate(20);

        $gpaMapper = [
            1 => 'first', 
            2 => 'second', 
            3 => 'third'
        ];

        $courseCreditMapper = [
            1 => 'first',
            2 => 'second',
            3 => 'third'
        ];

        foreach ($students as $student) {
            $student->result = $this->calculateResult(
                $student->bornData()->born_place == 1 ? 'first': 'second',
                $student->gender == 1 ? 'first': 'second',
                $gpaMapper[$student->score->gpa()->first],
                $gpaMapper[$student->score->gpa()->second],
                $gpaMapper[$student->score->gpa()->third],
                $gpaMapper[$student->score->gpa()->fourth],
                $gpaMapper[$student->score->gpa()->fifth],
                $gpaMapper[$student->score->gpa()->sixth],
                $courseCreditMapper[$student->score->courseCredit()->first],
                $courseCreditMapper[$student->score->courseCredit()->second],
                $courseCreditMapper[$student->score->courseCredit()->third],
                $courseCreditMapper[$student->score->courseCredit()->fourth],
                $courseCreditMapper[$student->score->courseCredit()->fifth],
                $courseCreditMapper[$student->score->courseCredit()->sixth]
            );

            $student->prediction = $student->result['decision']['positive'] >= $student->result['decision']['negative'] ? 'Lulus' : 'Belum Lulus';
        }

        return view('students.testExcel')
            ->with('students', $students);
    }

    /**
     * statistic view
     */
    public function statistic()
    {
        return view('students.statistic')
            ->with('statistics', $this->getStatistics());
    }

    /**
     * read csv file
     * 
     * @param string $csvFile
     * 
     * @return array $lines
     */
    protected function readCSV($csvFile)
    {
        $fileHandle = fopen($csvFile, 'r');
        while (!feof($fileHandle)) {
            $lines[] = fgetcsv($fileHandle, 0);
        }
        fclose($fileHandle);

        return $lines;
    }

    /**
     * filter gpa
     * 
     * @param float $gpa
     * 
     * @return int
     */
    protected function filterGpa($gpa)
    {
        if ($gpa >= 3.00) {
            return 3;
        } else if ($gpa < 3.00 && $gpa >= 2.00) {
            return 2;
        } else {
            return 1;
        }
    }

    /**
     * filter bornPlace
     * 
     * @param string $bornPlace
     * 
     * @return int
     */
    protected function filterBornPlace($bornPlace)
    {
        $bornPlace = strtolower($bornPlace);
        $bornPlace = trim($bornPlace);

        if ($bornPlace == 'jakarta') {
            return 2;
        } else {
            return 1;
        }
    }

    /**
     * filter status
     * 
     * @param string $status
     * 
     * @return int
     */
    protected function filterStatus($status)
    {
        switch (trim(strtolower($status))) {
            case 'lulus':
                return 1;
            case 'belum lulus':
                return 2;
            default:
                return 0;
        }
    }

    /**
     * filter gender
     * 
     * @param string $gender
     * 
     * @return int
     */
    protected function filterGender($gender)
    {
        $gender = strtolower($gender);
        $gender = trim($gender);

        if ($gender == 'pria') {
            return 1;
        } else {
            return 2;
        }
    }

    /**
     * filter course credit
     * 
     * @param int $courseCredit
     * 
     * @return int
     */
    protected function filterCourseCredit($courseCredit)
    {
        if ($courseCredit < 18) {
            return 1;
        } else if ($courseCredit >= 18 && $courseCredit <= 21) {
            return 2;
        } else if ($courseCredit > 21 && $courseCredit <= 24) {
            return 3;
        } else {
            return 0;
        }
    }

    /**
     * filter education
     * 
     * @param string $education
     * 
     * @return int
     */
    protected function filterEducation($education)
    {
        $education = strtolower($education);
        $education = trim($education);

        if (strpos($education, 'putus sekolah') !== false) {
            return 1;
        } else if (strpos($education, 'sd') !== false) {
            return 2;
        } else if (strpos($education, 'smp') !== false) {
            return 3;
        } else if (strpos($education, 'sma') !== false) {
            return 4;
        } else if (strpos($education, 'd3') !== false) {
            return 5;
        } else if (strpos($education, 's1') !== false) {
            return 6;
        } else if (strpos($education, 's2') !== false) {
            return 7;
        } else if (strpos($education, 's3') !== false) {
            return 8;
        } else if (strpos($education, 'profesi') !== false) {
            return 9;
        } else {
            return 0;
        }
    }

    /**
     * generate base query for all data
     * 
     * @return Illuminate\Support\Facades\DB
     */
    protected function baseQuery()
    {
        return DB::table('students AS s')
            ->join('scores AS sc', 's.id', '=', 'sc.student_id')
            ->select('sc.status AS status')
            ->where('s.purpose', '=', 'training');
    }

    /**
     * get statistics for all data
     * 
     * @return array $totalData
     */
    protected function getStatistics()
    {
        $totalData = [
            'all' => [
                'positive' => $this->baseQuery()
                    ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                    ->count(),
                'negative' => $this->baseQuery()
                    ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                    ->count(),
                'total' => $this->baseQuery()
                    ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                    ->count()
            ],
            'bornPlace' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(s.born_data, "$.born_place") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(s.born_data, "$.born_place") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(s.born_data, "$.born_place") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ],
                'second' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(s.born_data, "$.born_place") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(s.born_data, "$.born_place") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(s.born_data, "$.born_place") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ]
            ],
            'gender' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->where('gender', '=', 1)
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->where('gender', '=', 1)
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->where('gender', '=', 1)
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],  
                'second' => [
                    'positive' => $this->baseQuery()
                        ->where('gender', '=', 2)
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->where('gender', '=', 2)
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->where('gender', '=', 2)
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ]  
            ],
            'gpa1' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.first") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.first") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.first") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
                'second' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.first") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.first") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.first") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
                'third' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.first") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.first") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.first") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
            ],
            'gpa2' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.second") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.second") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.second") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
                'second' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.second") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.second") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.second") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
                'third' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.second") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.second") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.second") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
            ],
            'gpa3' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.third") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.third") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.third") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
                'second' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.third") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.third") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.third") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
                'third' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.third") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.third") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.third") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
            ],
            'gpa4' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fourth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fourth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fourth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
                'second' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fourth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fourth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fourth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
                'third' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fourth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fourth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fourth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
            ],
            'gpa5' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fifth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fifth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fifth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
                'second' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fifth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fifth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fifth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
                'third' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fifth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fifth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.fifth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
            ],
            'gpa6' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.sixth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.sixth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.sixth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
                'second' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.sixth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.sixth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.sixth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
                'third' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.sixth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.sixth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.gpa, "$.sixth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count(),
                ],
            ],
            'cc1' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.first") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.first") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.first") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ],
                'second' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.first") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.first") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.first") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ],
                'third' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.first") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.first") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.first") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ]
            ],
            'cc2' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.second") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.second") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.second") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ],
                'second' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.second") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.second") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.second") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ],
                'third' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.second") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.second") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.second") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ]
            ],
            'cc3' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.third") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.third") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.third") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ],
                'second' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.third") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.third") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.third") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ],
                'third' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.third") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.third") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.third") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ]
            ],
            'cc4' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fourth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fourth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fourth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ],
                'second' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fourth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fourth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fourth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ],
                'third' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fourth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fourth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fourth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ]
            ],
            'cc5' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fifth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fifth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fifth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ],
                'second' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fifth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fifth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fifth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ],
                'third' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fifth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fifth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.fifth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ]
            ],
            'cc6' => [
                'first' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.sixth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.sixth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.sixth") = 1')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ],
                'second' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.sixth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.sixth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.sixth") = 2')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ],
                'third' => [
                    'positive' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.sixth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 1')
                        ->count(),
                    'negative' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.sixth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") = 2')
                        ->count(),
                    'total' => $this->baseQuery()
                        ->whereRaw('JSON_EXTRACT(sc.course_credit, "$.sixth") = 3')
                        ->whereRaw('JSON_EXTRACT(sc.status, "$.numeric") != 0')
                        ->count()
                ]
            ],
        ];

        return $totalData;
    }

    /**
     * generate calculation array
     * 
     * @param string $bornPlace
     * @param string $gender
     * @param string $gpa1
     * @param string $gpa2
     * @param string $gpa3
     * @param string $gpa4
     * @param string $gpa5
     * @param string $gpa6
     * @param string $cc1
     * @param string $cc2
     * @param string $cc3
     * @param string $cc4
     * @param string $cc5
     * @param string $cc6
     * 
     * @return array
     */
    protected function calculateResult($bornPlace, $gender, $gpa1, $gpa2, $gpa3, $gpa4, $gpa5, $gpa6, $cc1, $cc2, $cc3, $cc4, $cc5, $cc6)
    {
        $statistics = $this->getStatistics();

        $all = [
            'positive' => $statistics['all']['positive'] + 1,
            'negative' => $statistics['all']['negative'] + 1,
            'total' => $statistics['all']['total'] + 2,
        ];

        $bornPlace = [
            'result' => $bornPlace,
            'positive' => ($statistics['bornPlace'][$bornPlace]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['bornPlace'][$bornPlace]['negative'] + 1) / $all['negative'],
            'total' => $statistics['bornPlace'][$bornPlace]['total'] + 2
        ];

        $gender = [
            'result' => $gender,
            'positive' => ($statistics['gender'][$gender]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['gender'][$gender]['negative'] + 1) / $all['negative'],
            'total' => $statistics['gender'][$gender]['total'] + 2
        ];

        $gpa1 = [
            'result' => $gpa1,
            'positive' => ($statistics['gpa1'][$gpa1]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['gpa1'][$gpa1]['negative'] + 1) / $all['negative'],
            'total' => $statistics['gpa1'][$gpa1]['total'] + 2
        ];

        $gpa2 = [
            'result' => $gpa2,
            'positive' => ($statistics['gpa2'][$gpa2]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['gpa2'][$gpa2]['negative'] + 1) / $all['negative'],
            'total' => $statistics['gpa2'][$gpa2]['total'] + 2
        ];

        $gpa3 = [
            'result' => $gpa3,
            'positive' => ($statistics['gpa3'][$gpa3]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['gpa3'][$gpa3]['negative'] + 1) / $all['negative'],
            'total' => $statistics['gpa3'][$gpa3]['total'] + 2
        ];

        $gpa4 = [
            'result' => $gpa4,
            'positive' => ($statistics['gpa4'][$gpa4]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['gpa4'][$gpa4]['negative'] + 1) / $all['negative'],
            'total' => $statistics['gpa4'][$gpa4]['total'] + 2
        ];

        $gpa5 = [
            'result' => $gpa5,
            'positive' => ($statistics['gpa5'][$gpa5]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['gpa5'][$gpa5]['negative'] + 1) / $all['negative'],
            'total' => $statistics['gpa5'][$gpa5]['total'] + 2
        ];

        $gpa6 = [
            'result' => $gpa6,
            'positive' => ($statistics['gpa6'][$gpa6]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['gpa6'][$gpa6]['negative'] + 1) / $all['negative'],
            'total' => $statistics['gpa6'][$gpa6]['total'] + 2
        ];

        $cc1 = [
            'result' => $cc1,
            'positive' => ($statistics['cc1'][$cc1]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['cc1'][$cc1]['negative'] + 1) / $all['negative'],
            'total' => $statistics['cc1'][$cc1]['total'] + 2
        ];

        $cc2 = [
            'result' => $cc2,
            'positive' => ($statistics['cc2'][$cc2]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['cc2'][$cc2]['negative'] + 1) / $all['negative'],
            'total' => $statistics['cc2'][$cc2]['total'] + 2
        ];

        $cc3 = [
            'result' => $cc3,
            'positive' => ($statistics['cc3'][$cc3]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['cc3'][$cc3]['negative'] + 1) / $all['negative'],
            'total' => $statistics['cc3'][$cc3]['total'] + 2
        ];

        $cc4 = [
            'result' => $cc4,
            'positive' => ($statistics['cc4'][$cc4]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['cc4'][$cc4]['negative'] + 1) / $all['negative'],
            'total' => $statistics['cc4'][$cc4]['total'] + 2
        ];

        $cc5 = [
            'result' => $cc5,
            'positive' => ($statistics['cc5'][$cc5]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['cc5'][$cc5]['negative'] + 1) / $all['negative'],
            'total' => $statistics['cc5'][$cc5]['total'] + 2
        ];

        $cc6 = [
            'result' => $cc6,
            'positive' => ($statistics['cc6'][$cc6]['positive'] + 1) / $all['positive'],
            'negative' => ($statistics['cc6'][$cc6]['negative'] + 1) / $all['negative'],
            'total' => $statistics['cc6'][$cc6]['total'] + 2
        ];

        $result = [
            'all' => $all,
            'bornPlace' => $bornPlace,
            'gender' => $gender,
            'gpa1' => $gpa1,
            'gpa2' => $gpa2,
            'gpa3' => $gpa3,
            'gpa4' => $gpa4,
            'gpa5' => $gpa5,
            'gpa6' => $gpa6,
            'cc1' => $cc1,
            'cc2' => $cc2,
            'cc3' => $cc3,
            'cc4' => $cc4,
            'cc5' => $cc5,
            'cc6' => $cc6,
            'p' => [
                'positive' => ($bornPlace['positive'] *
                $gender['positive'] *
                $gpa1['positive'] *
                $gpa2['positive'] *
                $gpa3['positive'] *
                $gpa4['positive'] *
                $gpa5['positive'] *
                $gpa6['positive'] *
                $cc1['positive'] *
                $cc2['positive'] *
                $cc3['positive'] *
                $cc4['positive'] *
                $cc5['positive'] *
                $cc6['positive']) *
                ($all['positive'] / $all['total']),
                'negative' => $bornPlace['negative'] *
                $gender['negative'] *
                $gpa1['negative'] *
                $gpa2['negative'] *
                $gpa3['negative'] *
                $gpa4['negative'] *
                $gpa5['negative'] *
                $gpa6['negative'] *
                $cc1['negative'] *
                $cc2['negative'] *
                $cc3['negative'] *
                $cc4['negative'] *
                $cc5['negative'] *
                $cc6['negative'] *
                ($all['negative'] / $all['total'])
            ]
        ];

        $decision = [
            'positive' => round(($result['p']['positive'] / ($result['p']['positive'] + $result['p']['negative'])) * 100, 2),
            'negative' => round(($result['p']['negative'] / ($result['p']['positive'] + $result['p']['negative'])) * 100, 2)
        ];

        return [
            'result' => $result,
            'decision' => $decision
        ];
    }
}
