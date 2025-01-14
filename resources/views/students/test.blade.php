@extends('layouts.app')

@section('content')

@if (isset($result))
<div class="card">
    <div class="card-header">{{ __('Hasil Pengujian') }}</div>
    <div class="card-body">
        <table class="table table-hover table-responsive">
            <thead>
                <tr>
                    <th>{{ __('Kelas') }}</th>
                    <th>{{ __('Tempat Lahir') }}</th>
                    <th>{{ __('Jenis Kelamin') }}</th>
                    <th>{{ __('IP #1') }}</th>
                    <th>{{ __('IP #2') }}</th>
                    <th>{{ __('IP #3') }}</th>
                    <th>{{ __('IP #4') }}</th>
                    <th>{{ __('IP #5') }}</th>
                    <th>{{ __('IP #6') }}</th>
                    <th>{{ __('SKS #1') }}</th>
                    <th>{{ __('SKS #2') }}</th>
                    <th>{{ __('SKS #3') }}</th>
                    <th>{{ __('SKS #4') }}</th>
                    <th>{{ __('SKS #5') }}</th>
                    <th>{{ __('SKS #6') }}</th>
                    <th>{{ __('P') }}</th>
                    <th>{{ __('Keputusan') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ __('Lulus') }}</td>
                    <td>{{ $result['bornPlace']['positive'] }}</td>
                    <td>{{ $result['gender']['positive'] }}</td>
                    <td>{{ $result['gpa1']['positive'] }}</td>
                    <td>{{ $result['gpa2']['positive'] }}</td>
                    <td>{{ $result['gpa3']['positive'] }}</td>
                    <td>{{ $result['gpa4']['positive'] }}</td>
                    <td>{{ $result['gpa5']['positive'] }}</td>
                    <td>{{ $result['gpa6']['positive'] }}</td>
                    <td>{{ $result['cc1']['positive'] }}</td>
                    <td>{{ $result['cc2']['positive'] }}</td>
                    <td>{{ $result['cc3']['positive'] }}</td>
                    <td>{{ $result['cc4']['positive'] }}</td>
                    <td>{{ $result['cc5']['positive'] }}</td>
                    <td>{{ $result['cc6']['positive'] }}</td>
                    <td>{{ $result['p']['positive'] }}</td>
                    <td>{{ $decision['positive'] }}%</td>
                </tr>
                <tr>
                    <td>{{ __('Belum Lulus') }}</td>
                    <td>{{ $result['bornPlace']['negative'] }}</td>
                    <td>{{ $result['gender']['negative'] }}</td>
                    <td>{{ $result['gpa1']['negative'] }}</td>
                    <td>{{ $result['gpa2']['negative'] }}</td>
                    <td>{{ $result['gpa3']['negative'] }}</td>
                    <td>{{ $result['gpa4']['negative'] }}</td>
                    <td>{{ $result['gpa5']['negative'] }}</td>
                    <td>{{ $result['gpa6']['negative'] }}</td>
                    <td>{{ $result['cc1']['negative'] }}</td>
                    <td>{{ $result['cc2']['negative'] }}</td>
                    <td>{{ $result['cc3']['negative'] }}</td>
                    <td>{{ $result['cc4']['negative'] }}</td>
                    <td>{{ $result['cc5']['negative'] }}</td>
                    <td>{{ $result['cc6']['negative'] }}</td>
                    <td>{{ $result['p']['negative'] }}</td>
                    <td>{{ $decision['negative'] }}%</td>
                </tr>
            </tbody>
        </table>

        <h5>{{ __('Kesimpulan') }}:</h5>
        <table class="table">
            <tr>
                <td>{{ __('Lulus') }}
                <td>
                <td>{{ $decision['positive'] }}%</td>
            </tr>
            <tr>
                <td>{{ __('Belum Lulus') }}
                <td>
                <td>{{ $decision['negative'] }}%</td>
            </tr>
        </table>

        @if ($decision['positive'] >= $decision['negative'])
        <h5>{{ __('Hasil') }}: {{ __('Lulus') }}</h5>
        @else
        <h5>{{ __('Hasil') }}: {{ __('Belum Lulus') }}</h5>
        @endif

    </div>
</div>
@endif

<div class="card">
    <div class="card-header">{{ __('Pengujian') }}</div>
    <div class="card-body">
        <form method="GET" action="{{ url()->current() }}">
            {{ csrf_field() }}

            <h5>{{ __('Informasi Mahasiswa') }}</h5>
            <hr>

            <div class="form-row">
                <div class="col-md-8">
                    <label>{{ __('Program Studi') }}</label>
                    <input class="form-control" type="text" name="study_programme" value="TEKNIK INFORMATIKA" required readonly>
                </div>

                <div class="col-md-4">
                    <label>{{ __('Tahun Ajaran') }}</label>
                    <input class="form-control" type="number" name="year_class" min="0" max="2100" required>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="col-md-6">
                    <label>{{ __('Tempat Lahir') }}</label>
                    <select name="born_place" class="form-control" required="true">
                        <option value="" selected>-Select-</option>
                        <option value="first">{{ __('Luar Kota') }}</option>
                        <option value="second">{{ __('Dalam Kota') }}</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>{{ __('Tanggal Lahir') }}</label>
                    <input class="form-control" type="date" name="born_date" required>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="col-md-6">
                    <label>{{ __('Agama') }}</label>
                    <select name="religion" class="form-control" required>
                        <option value="" selected>-Select-</option>
                        <option value="Islam">{{ __('Islam') }}</option>
                        <option value="Protestan">{{ __('Protestan') }}</option>
                        <option value="Katolik">{{ __('Katolik') }}</option>
                        <option value="Hindu">{{ __('Hindu') }}</option>
                        <option value="Budha">{{ __('Budha') }}</option>
                        <option value="Other">{{ __('Lainnya') }}</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>{{ __('Jenis Kelamin') }}</label>
                    <select name="gender" class="form-control" required>
                        <option value="" selected>-Select-</option>
                        <option value="first">{{ __('Pria') }}</option>
                        <option value="second">{{ __('Wanita') }}</option>
                    </select>
                </div>
            </div>

            <br>

            <h5>{{ __('Informasi Orang Tua') }}</h5>
            <hr>

            <div class="form-row">
                <div class="col-md-6">
                    <label>{{ __('Pendidikan Ayah') }}</label>
                    <select name="father_education" class="form-control" required>
                        <option value="" selected>-Select-</option>
                        <option value="1">{{ __('Tidak tamat') }}</option>
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
                    <label>{{ __('Pendidikan Ibu') }}</label>
                    <select name="mother_education" class="form-control" required>
                        <option value="" selected>-Select-</option>
                        <option value="1">{{ __('Tidak tamat') }}</option>
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
                    <label>{{ __('Pekerjaan Ayah') }}</label>
                    <input type="text" name="father_job" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>{{ __('Pekerjaan Ibu') }}</label>
                    <input type="text" name="mother_job" class="form-control" required>
                </div>
            </div>

            <br>

            <h5>{{ __('Pencapaian Mahasiswa') }}</h5>
            <hr>

            <div class="form-row">
                <div class="col-md-4">
                    <label>{{ __('IP #1') }}</label>
                    <select name="gpa_1" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="third">{{ __('IP >= 3') }}</option>
                        <option value="second">{{ __('2 <= IP < 3') }}</option>
                        <option value="first">{{ __('IP < 2') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('IP #2') }}</label>
                    <select name="gpa_2" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="third">{{ __('IP >= 3') }}</option>
                        <option value="second">{{ __('2 <= IP < 3') }}</option>
                        <option value="first">{{ __('IP < 2') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('IP #3') }}</label>
                    <select name="gpa_3" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="third">{{ __('IP >= 3') }}</option>
                        <option value="second">{{ __('2 <= IP < 3') }}</option>
                        <option value="first">{{ __('IP < 2') }}</option>
                    </select>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="col-md-4">
                    <label>{{ __('IP #4') }}</label>
                    <select name="gpa_4" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="third">{{ __('IP >= 3') }}</option>
                        <option value="second">{{ __('2 <= IP < 3') }}</option>
                        <option value="first">{{ __('IP < 2') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('IP #5') }}</label>
                    <select name="gpa_5" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="third">{{ __('IP >= 3') }}</option>
                        <option value="second">{{ __('2 <= IP < 3') }}</option>
                        <option value="first">{{ __('IP < 2') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('IP #6') }}</label>
                    <select name="gpa_6" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="third">{{ __('IP >= 3') }}</option>
                        <option value="second">{{ __('2 <= IP < 3') }}</option>
                        <option value="first">{{ __('IP < 2') }}</option>
                    </select>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="col-md-4">
                    <label>{{ __('SKS #1') }}</label>
                    <select name="cc_1" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="third">{{ __('21 < SKS <= 24') }}</option>
                        <option value="second">{{ __('18 <= SKS <= 21') }}</option>
                        <option value="first">{{ __('SKS < 18') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('SKS #2') }}</label>
                    <select name="cc_2" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="third">{{ __('21 < SKS <= 24') }}</option>
                        <option value="second">{{ __('18 <= SKS <= 21') }}</option>
                        <option value="first">{{ __('SKS < 18') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('SKS #3') }}</label>
                    <select name="cc_3" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="third">{{ __('21 < SKS <= 24') }}</option>
                        <option value="second">{{ __('18 <= SKS <= 21') }}</option>
                        <option value="first">{{ __('SKS < 18') }}</option>
                    </select>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="col-md-4">
                    <label>{{ __('SKS #4') }}</label>
                    <select name="cc_4" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="third">{{ __('21 < SKS <= 24') }}</option>
                        <option value="second">{{ __('18 <= SKS <= 21') }}</option>
                        <option value="first">{{ __('SKS < 18') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('SKS #5') }}</label>
                    <select name="cc_5" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="third">{{ __('21 < SKS <= 24') }}</option>
                        <option value="second">{{ __('18 <= SKS <= 21') }}</option>
                        <option value="first">{{ __('SKS < 18') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('SKS #6') }}</label>
                    <select name="cc_6" class="form-control" required>
                        <option value="" selected>---Select---</option>
                        <option value="third">{{ __('21 < SKS <= 24') }}</option>
                        <option value="second">{{ __('18 <= SKS <= 21') }}</option>
                        <option value="first">{{ __('SKS < 18') }}</option>
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