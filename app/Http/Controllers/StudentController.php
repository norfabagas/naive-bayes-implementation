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
        $students = Student::paginate(20);

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
            $csv = $this->readCSV($request->file('excel')->getRealPath());

            DB::beginTransaction();

            Score::query()->delete();
            Student::query()->delete();

            foreach (array_slice($csv, 1) as $line) {
                if ($line == false) {
                    continue;
                }

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
                    ])
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
                    ])
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            abort(403, $e->getMessage());
        }

        Session::flash('message', 'Data stored');

        return redirect()
            ->route('student.index');
    }

    /**
     * test form
     */
    public function test(Request $request)
    {
        return view('students.test');
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
}
