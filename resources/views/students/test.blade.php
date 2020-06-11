@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Test') }}</div>
    <div class="card-body">
        <form method="GET" action="{{ url()->current() }}">
            {{ csrf_field() }}

            <h5>{{ __('Personal Information') }}</h5>
            <hr>

            <div class="form-row">
                <div class="col-md-8">
                    <label>{{ __('Study Programme') }}</label>
                    <input class="form-control" type="text" name="study_programme" value="TEKNIK INFORMATIKA" required readonly>
                </div>

                <div class="col-md-4">
                    <label>{{ __('Year Class') }}</label>
                    <input class="form-control" type="number" name="year_class" min="0" max="2100" required>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="col-md-6">
                    <label>{{ __('Born Place') }}</label>
                    <select name="born_place" class="form-control" required="true">
                        <option value="" selected>-Select-</option>
                        <option value="1">{{ __('Outside the City') }}</option>
                        <option value="2">{{ __('In the City') }}</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>{{ __('Born Date') }}</label>
                    <input class="form-control" type="date" name="born_date" required>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="col-md-6">
                    <label>{{ __('Religion') }}</label>
                    <select name="religion" class="form-control" required>
                        <option value="" selected>-Select-</option>
                        <option value="Islam">{{ __('Islam') }}</option>
                        <option value="Protestan">{{ __('Protestan') }}</option>
                        <option value="Katolik">{{ __('Katolik') }}</option>
                        <option value="Hindu">{{ __('Hindu') }}</option>
                        <option value="Budha">{{ __('Budha') }}</option>
                        <option value="Other">{{ __('Other') }}</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>{{ __('Gender') }}</label>
                    <select name="gender" class="form-control" required>
                        <option value="" selected>-Select-</option>
                        <option value="1">{{ __('Male') }}</option>
                        <option value="2">{{ __('Female') }}</option>
                    </select>
                </div>
            </div>

            <br>

            <h5>{{ __('Parent Information') }}</h5>
            <hr>

            <div class="form-row">
                <div class="col-md-6">
                    <label>{{ __('Father Education') }}</label>
                    <select name="father_education" class="form-control" required>
                        <option value="" selected>-Select-</option>
                        <option value="1">{{ __('Dropout') }}</option>
                        <option value="2">{{ __('SD') }}</option>
                        <option value="3">{{ __('SMP') }}</option>
                        <option value="4">{{ __('SMA') }}</option>
                        <option value="5">{{ __('D3') }}</option>
                        <option value="6">{{ __('S1') }}</option>
                        <option value="7">{{ __('S2') }}</option>
                        <option value="8">{{ __('S3') }}</option>
                        <option value="9">{{ __('Profesi') }}</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>{{ __('Mother Education') }}</label>
                    <select name="mother_education" class="form-control" required>
                        <option value="" selected>-Select-</option>
                        <option value="1">{{ __('Dropout') }}</option>
                        <option value="2">{{ __('SD') }}</option>
                        <option value="3">{{ __('SMP') }}</option>
                        <option value="4">{{ __('SMA') }}</option>
                        <option value="5">{{ __('D3') }}</option>
                        <option value="6">{{ __('S1') }}</option>
                        <option value="7">{{ __('S2') }}</option>
                        <option value="8">{{ __('S3') }}</option>
                        <option value="9">{{ __('Profesi') }}</option>
                    </select>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="col-md-6">
                    <label>{{ __('Father Job') }}</label>
                    <input type="text" name="father_job" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>{{ __('Mother Job') }}</label>
                    <input type="text" name="mother_job" class="form-control" required>
                </div>
            </div>

            <br>

            <h5>{{ __('Student Education') }}</h5>
            <hr>

            <div class="form-row">
                <div class="col-md-4">
                    <label>{{ __('GPA #1') }}</label>
                    <select name="gpa_1" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="3">{{ __('GPA >= 3') }}</option>
                        <option value="2">{{ __('2 <= GPA < 3') }}</option>
                        <option value="1">{{ __('GPA < 2') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('GPA #2') }}</label>
                    <select name="gpa_2" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="3">{{ __('GPA >= 3') }}</option>
                        <option value="2">{{ __('2 <= GPA < 3') }}</option>
                        <option value="1">{{ __('GPA < 2') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('GPA #3') }}</label>
                    <select name="gpa_3" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="3">{{ __('GPA >= 3') }}</option>
                        <option value="2">{{ __('2 <= GPA < 3') }}</option>
                        <option value="1">{{ __('GPA < 2') }}</option>
                    </select>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="col-md-4">
                    <label>{{ __('GPA #4') }}</label>
                    <select name="gpa_4" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="3">{{ __('GPA >= 3') }}</option>
                        <option value="2">{{ __('2 <= GPA < 3') }}</option>
                        <option value="1">{{ __('GPA < 2') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('GPA #5') }}</label>
                    <select name="gpa_5" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="3">{{ __('GPA >= 3') }}</option>
                        <option value="2">{{ __('2 <= GPA < 3') }}</option>
                        <option value="1">{{ __('GPA < 2') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('GPA #6') }}</label>
                    <select name="gpa_6" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="3">{{ __('GPA >= 3') }}</option>
                        <option value="2">{{ __('2 <= GPA < 3') }}</option>
                        <option value="1">{{ __('GPA < 2') }}</option>
                    </select>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="col-md-4">
                    <label>{{ __('Course Credit #1') }}</label>
                    <select name="cc_1" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="3">{{ __('21 < Course Credit <= 24') }}</option>
                        <option value="2">{{ __('18 <= Course Credit <= 21') }}</option>
                        <option value="1">{{ __('Course Credit < 18') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('Course Credit #2') }}</label>
                    <select name="cc_2" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="3">{{ __('21 < Course Credit <= 24') }}</option>
                        <option value="2">{{ __('18 <= Course Credit <= 21') }}</option>
                        <option value="1">{{ __('Course Credit < 18') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('Course Credit #3') }}</label>
                    <select name="cc_3" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="3">{{ __('21 < Course Credit <= 24') }}</option>
                        <option value="2">{{ __('18 <= Course Credit <= 21') }}</option>
                        <option value="1">{{ __('Course Credit < 18') }}</option>
                    </select>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="col-md-4">
                    <label>{{ __('Course Credit #4') }}</label>
                    <select name="cc_4" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="3">{{ __('21 < Course Credit <= 24') }}</option>
                        <option value="2">{{ __('18 <= Course Credit <= 21') }}</option>
                        <option value="1">{{ __('Course Credit < 18') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('Course Credit #5') }}</label>
                    <select name="cc_5" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="3">{{ __('21 < Course Credit <= 24') }}</option>
                        <option value="2">{{ __('18 <= Course Credit <= 21') }}</option>
                        <option value="1">{{ __('Course Credit < 18') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('Course Credit #6') }}</label>
                    <select name="cc_6" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="3">{{ __('21 < Course Credit <= 24') }}</option>
                        <option value="2">{{ __('18 <= Course Credit <= 21') }}</option>
                        <option value="1">{{ __('Course Credit < 18') }}</option>
                    </select>
                </div>
            </div>

            <hr>
            <div class="col text-center">
                <input type="submit" value="Submit" class="btn btn-success btn-lg">
            </div>
        </form>
    </div>
</div>
@endsection