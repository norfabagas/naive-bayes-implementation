@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Data Training</div>
    <div class="card-body">
        <div class="row">
            <form method="POST" enctype="multipart/form-data" action="{{ route('student.submitExcel') }}">
                {{ csrf_field() }}

                @error('excel')
                <div class="form-group">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ $message }}
                    </div>
                </div>
                @enderror

                <div class="form-group form-inline">
                    <label for="input" class="col-md-3">File Excel</label>
                    <input class="form-control col-md-6 @error('excel') is-invalid @enderror mr-2" type="file" name="excel" />
                    <input type="submit" class="btn btn-success btn-md" />
                </div>
            </form>
        </div>
        <hr>
        <table class="table table-responsive table-hover">
            <tr>
                <th>{{ __('Study Programme') }}</th>
                <th>{{ __('Year Class') }}</th>
                <th>{{ __('Born Place') }}</th>
                <th>{{ __('Born Date') }}</th>
                <th>{{ __('Father Education') }}</th>
                <th>{{ __('Mother Education') }}</th>
                <th>{{ __('Father Job') }}</th>
                <th>{{ __('Mother Job') }}</th>
                <th>{{ __('GPA #1') }}</th>
                <th>{{ __('GPA #2') }}</th>
                <th>{{ __('GPA #3') }}</th>
                <th>{{ __('GPA #4') }}</th>
                <th>{{ __('GPA #5') }}</th>
                <th>{{ __('GPA #6') }}</th>
                <th>{{ __('Course Credit #1') }}</th>
                <th>{{ __('Course Credit #2') }}</th>
                <th>{{ __('Course Credit #3') }}</th>
                <th>{{ __('Course Credit #4') }}</th>
                <th>{{ __('Course Credit #5') }}</th>
                <th>{{ __('Course Credit #6') }}</th>
                <th>{{ __('Status') }}</th>
            </tr>
            @foreach ($students as $student)
            <tr>
                <td>{{ $student->study_program }}</td>
                <td>{{ $student->year_class }}</td>
                <td>{{ $student->bornData()->born_place == 1 ? 'Jakarta' : 'Luar Jakarta' }}</td>
                <td>{{ $student->bornData()->born_date }}</td>
                <td>{{ $student->parentData()->father_education }}</td>
                <td>{{ $student->parentData()->mother_education }}</td>
                <td>{{ $student->parentData()->father_job }}</td>
                <td>{{ $student->parentData()->father_job }}</td>
                <td>{{ $student->score->gpa()->first }}</td>
                <td>{{ $student->score->gpa()->second }}</td>
                <td>{{ $student->score->gpa()->third }}</td>
                <td>{{ $student->score->gpa()->fourth }}</td>
                <td>{{ $student->score->gpa()->fifth }}</td>
                <td>{{ $student->score->gpa()->sixth }}</td>
                <td>{{ $student->score->courseCredit()->first }}</td>
                <td>{{ $student->score->courseCredit()->second }}</td>
                <td>{{ $student->score->courseCredit()->third }}</td>
                <td>{{ $student->score->courseCredit()->fourth }}</td>
                <td>{{ $student->score->courseCredit()->fifth }}</td>
                <td>{{ $student->score->courseCredit()->sixth }}</td>
                <td>{{ $student->score->status()->text }}</td>
            </tr>
            @endforeach
        </table>
        <div class="d-flex justify-content-center">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection