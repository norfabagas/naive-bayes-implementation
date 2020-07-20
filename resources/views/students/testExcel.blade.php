@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Data Pengujian') }}</div>
    <div class="card-body">
        <div class="row">
            <form method="POST" enctype="multipart/form-data" action="{{ route('student.submitExcel') }}">
                {{ csrf_field() }}

                <input type="hidden" name="dataPurpose" value="testing">

                @error('excel')
                <div class="form-group">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ $message }}
                    </div>
                </div>
                @enderror

                <div class="form-group form-inline">
                    <label for="input" class="col-md-3">{{ __('Unggah File Excel') }}</label>
                    <input class="form-control col-md-6 @error('excel') is-invalid @enderror mr-2" type="file" name="excel" />
                    <input type="submit" class="btn btn-success btn-md" />
                </div>
            </form>
        </div>

        <hr>
        <h4>{{ __('Data Pengujian') }}</h4>
        <table class="table table-responsive table-hover">
            <tr>
                <th>{{ __('No') }}</th>
                <th>{{ __('Program Studi') }}</th>
                <th>{{ __('Tahun Ajaran') }}</th>
                <th>{{ __('Tempat Lahir') }}</th>
                <th>{{ __('Tanggal Lahir') }}</th>
                <th>{{ __('Agama') }}</th>
                <th>{{ __('Jenis Kelamin') }}</th>
                <th>{{ __('Pendidikan Ayah') }}</th>
                <th>{{ __('Pendidikan Ibu') }}</th>
                <th>{{ __('Pekerjaan Ayah') }}</th>
                <th>{{ __('Pekerjaan Ibu') }}</th>
                <th>{{ __('IP #1') }}</th>
                <th>{{ __('IP #2') }}</th>
                <th>{{ __('IP #3') }}</th>
                <th>{{ __('IP #4') }}</th>
                <th>{{ __('IP #5') }}</th>
                <th>{{ __('IP #6') }}</th>
                <th>{{ __('Jumlah SKS #1') }}</th>
                <th>{{ __('Jumlah SKS #2') }}</th>
                <th>{{ __('Jumlah SKS #3') }}</th>
                <th>{{ __('Jumlah SKS #4') }}</th>
                <th>{{ __('Jumlah SKS #5') }}</th>
                <th>{{ __('Jumlah SKS #6') }}</th>
                <th>{{ __('Status') }}</th>
            </tr>
            @foreach($students as $index => $student)
            <tr>
                <td>{{ $students->firstItem() + $index }}</td>
                <td>{{ $student->study_program }}</td>
                <td>{{ $student->year_class }}</td>
                <td>{{ $student->bornData()->born_place == 1 ? 'Luar Kota' : 'Dalam Kota' }}</td>
                <td>{{ $student->bornData()->born_date }}</td>
                <td>{{ $student->religion }}</td>
                <td>{{ $student->dump()[5] }}</td>
                <td>{{ $student->dump()[7] }}</td>
                <td>{{ $student->dump()[8] }}</td>
                <td>{{ $student->dump()[9] }}</td>
                <td>{{ $student->dump()[10] }}</td>
                <td>{{ $student->dump()[11] }}</td>
                <td>{{ $student->dump()[12] }}</td>
                <td>{{ $student->dump()[13] }}</td>
                <td>{{ $student->dump()[14] }}</td>
                <td>{{ $student->dump()[15] }}</td>
                <td>{{ $student->dump()[16] }}</td>
                <td>{{ (int) $student->dump()[17] }}</td>
                <td>{{ (int) $student->dump()[18] }}</td>
                <td>{{ (int) $student->dump()[19] }}</td>
                <td>{{ (int) $student->dump()[20] }}</td>
                <td>{{ (int) $student->dump()[21] }}</td>
                <td>{{ (int) $student->dump()[22] }}</td>
                <td>{{ $student->score->status()->text }}</td>
            </tr>
            @endforeach
        </table>

        <div class="d-flex justify-content-center">
            {{ $students->appends(request()->input())->links() }}
        </div>

        @if(isset($_GET['prediction']) && $_GET['prediction'] == 'true')
        <hr>
        <h4>{{ __('Hasil Prediksi') }}</h4>
        <table class="table table-responsive table-hover">
            <tr>
                <th>{{ __('No') }}</th>
                <th>{{ __('Program Studi') }}</th>
                <th>{{ __('Tahun Ajaran') }}</th>
                <th>{{ __('Tempat Lahir') }}</th>
                <th>{{ __('Tanggal Lahir') }}</th>
                <th>{{ __('Agama') }}</th>
                <th>{{ __('Jenis Kelamin') }}</th>
                <th>{{ __('Pendidikan Ayah') }}</th>
                <th>{{ __('Pendidikan Ibu') }}</th>
                <th>{{ __('Pekerjaan Ayah') }}</th>
                <th>{{ __('Pekerjaan Ibu') }}</th>
                <th>{{ __('IP #1') }}</th>
                <th>{{ __('IP #2') }}</th>
                <th>{{ __('IP #3') }}</th>
                <th>{{ __('IP #4') }}</th>
                <th>{{ __('IP #5') }}</th>
                <th>{{ __('IP #6') }}</th>
                <th>{{ __('Jumlah SKS #1') }}</th>
                <th>{{ __('Jumlah SKS #2') }}</th>
                <th>{{ __('Jumlah SKS #3') }}</th>
                <th>{{ __('Jumlah SKS #4') }}</th>
                <th>{{ __('Jumlah SKS #5') }}</th>
                <th>{{ __('Jumlah SKS #6') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Hasil Prediksi') }}</th>
            </tr>
            @foreach ($students as $index => $student)
            <tr class="{{ $student->score->status()->text == $student->prediction ? '' : 'table-danger' }}">
                <td>{{ $students->firstItem() + $index }}</td>
                <td>{{ $student->study_program }}</td>
                <td>{{ $student->year_class }}</td>
                <td>{{ $student->bornData()->born_place == 1 ? 'Luar Kota' : 'Dalam Kota' }}</td>
                <td>{{ $student->bornData()->born_date }}</td>
                <td>{{ $student->religion }}</td>
                <td>{{ $student->gender }}</td>
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
                <td>{{ $student->prediction }}</td>
            </tr>
            @endforeach
        </table>
        <div class="d-flex justify-content-center">
            {{ $students->appends(request()->input())->links() }}
        </div>
        @else
        <div class="d-flex justify-content-center">
            <a href="{{ request()->fullUrlWithQuery(['prediction' => 'true']) }}" class="btn btn-lg btn-primary">{{ __('Eksekusi') }}</a>
        </div>
        @endif
    </div>
</div>
@endsection