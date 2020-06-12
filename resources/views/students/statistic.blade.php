@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ __('Statistics') }}</div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <th>{{ __('Graduated') }}</th>
                        <th>{{ __('Not Graduated') }}</th>
                        <th>{{ __('Total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $statistics['all']['positive'] }}</td>
                        <td>{{ $statistics['all']['negative'] }}</td>
                        <td>{{ $statistics['all']['total'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<br>
<hr>
<br>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('Born Place') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('Outside the City') }}</td>
                            <td>{{ $statistics['bornPlace']['first']['positive'] }}</td>
                            <td>{{ $statistics['bornPlace']['first']['negative'] }}</td>
                            <td>{{ $statistics['bornPlace']['first']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Inside the City') }}</td>
                            <td>{{ $statistics['bornPlace']['second']['positive'] }}</td>
                            <td>{{ $statistics['bornPlace']['second']['negative'] }}</td>
                            <td>{{ $statistics['bornPlace']['second']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['bornPlace']['first']['positive'] + $statistics['bornPlace']['second']['positive'] }}</th>
                            <th>{{ $statistics['bornPlace']['first']['negative'] + $statistics['bornPlace']['second']['negative'] }}</th>
                            <th>{{ $statistics['bornPlace']['first']['total'] + $statistics['bornPlace']['second']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('Gender') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('Male') }}</td>
                            <td>{{ $statistics['gender']['first']['positive'] }}</td>
                            <td>{{ $statistics['gender']['first']['negative'] }}</td>
                            <td>{{ $statistics['gender']['first']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Female') }}</td>
                            <td>{{ $statistics['gender']['second']['positive'] }}</td>
                            <td>{{ $statistics['gender']['second']['negative'] }}</td>
                            <td>{{ $statistics['gender']['second']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['gender']['first']['positive'] + $statistics['gender']['second']['positive'] }}</th>
                            <th>{{ $statistics['gender']['first']['negative'] + $statistics['gender']['second']['negative'] }}</th>
                            <th>{{ $statistics['gender']['first']['total'] + $statistics['gender']['second']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<br>
<hr>
<br>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('GPA #1') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('GPA >= 3') }}</td>
                            <td>{{ $statistics['gpa1']['third']['positive'] }}</td>
                            <td>{{ $statistics['gpa1']['third']['negative'] }}</td>
                            <td>{{ $statistics['gpa1']['third']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('2 <= GPA < 3') }}</td>
                            <td>{{ $statistics['gpa1']['second']['positive'] }}</td>
                            <td>{{ $statistics['gpa1']['second']['negative'] }}</td>
                            <td>{{ $statistics['gpa1']['second']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('GPA < 2') }}</td>
                            <td>{{ $statistics['gpa1']['first']['positive'] }}</td>
                            <td>{{ $statistics['gpa1']['first']['negative'] }}</td>
                            <td>{{ $statistics['gpa1']['first']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['gpa1']['first']['positive'] + $statistics['gpa1']['second']['positive'] + $statistics['gpa1']['third']['positive'] }}</th>
                            <th>{{ $statistics['gpa1']['first']['negative'] + $statistics['gpa1']['second']['negative'] + $statistics['gpa1']['third']['negative'] }}</th>
                            <th>{{ $statistics['gpa1']['first']['total'] + $statistics['gpa1']['second']['total'] + $statistics['gpa1']['third']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('GPA #2') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('GPA >= 3') }}</td>
                            <td>{{ $statistics['gpa2']['third']['positive'] }}</td>
                            <td>{{ $statistics['gpa2']['third']['negative'] }}</td>
                            <td>{{ $statistics['gpa2']['third']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('2 <= GPA < 3') }}</td>
                            <td>{{ $statistics['gpa2']['second']['positive'] }}</td>
                            <td>{{ $statistics['gpa2']['second']['negative'] }}</td>
                            <td>{{ $statistics['gpa2']['second']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('GPA < 2') }}</td>
                            <td>{{ $statistics['gpa2']['first']['positive'] }}</td>
                            <td>{{ $statistics['gpa2']['first']['negative'] }}</td>
                            <td>{{ $statistics['gpa2']['first']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['gpa2']['first']['positive'] + $statistics['gpa2']['second']['positive'] + $statistics['gpa2']['third']['positive'] }}</th>
                            <th>{{ $statistics['gpa2']['first']['negative'] + $statistics['gpa2']['second']['negative'] + $statistics['gpa2']['third']['negative'] }}</th>
                            <th>{{ $statistics['gpa2']['first']['total'] + $statistics['gpa2']['second']['total'] + $statistics['gpa2']['third']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('GPA #3') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('GPA >= 3') }}</td>
                            <td>{{ $statistics['gpa3']['third']['positive'] }}</td>
                            <td>{{ $statistics['gpa3']['third']['negative'] }}</td>
                            <td>{{ $statistics['gpa3']['third']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('2 <= GPA < 3') }}</td>
                            <td>{{ $statistics['gpa3']['second']['positive'] }}</td>
                            <td>{{ $statistics['gpa3']['second']['negative'] }}</td>
                            <td>{{ $statistics['gpa3']['second']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('GPA < 2') }}</td>
                            <td>{{ $statistics['gpa3']['first']['positive'] }}</td>
                            <td>{{ $statistics['gpa3']['first']['negative'] }}</td>
                            <td>{{ $statistics['gpa3']['first']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['gpa3']['first']['positive'] + $statistics['gpa3']['second']['positive'] + $statistics['gpa3']['third']['positive'] }}</th>
                            <th>{{ $statistics['gpa3']['first']['negative'] + $statistics['gpa3']['second']['negative'] + $statistics['gpa3']['third']['negative'] }}</th>
                            <th>{{ $statistics['gpa3']['first']['total'] + $statistics['gpa3']['second']['total'] + $statistics['gpa3']['third']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('GPA #4') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('GPA >= 3') }}</td>
                            <td>{{ $statistics['gpa4']['third']['positive'] }}</td>
                            <td>{{ $statistics['gpa4']['third']['negative'] }}</td>
                            <td>{{ $statistics['gpa4']['third']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('2 <= GPA < 3') }}</td>
                            <td>{{ $statistics['gpa4']['second']['positive'] }}</td>
                            <td>{{ $statistics['gpa4']['second']['negative'] }}</td>
                            <td>{{ $statistics['gpa4']['second']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('GPA < 2') }}</td>
                            <td>{{ $statistics['gpa4']['first']['positive'] }}</td>
                            <td>{{ $statistics['gpa4']['first']['negative'] }}</td>
                            <td>{{ $statistics['gpa4']['first']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['gpa4']['first']['positive'] + $statistics['gpa4']['second']['positive'] + $statistics['gpa4']['third']['positive'] }}</th>
                            <th>{{ $statistics['gpa4']['first']['negative'] + $statistics['gpa4']['second']['negative'] + $statistics['gpa4']['third']['negative'] }}</th>
                            <th>{{ $statistics['gpa4']['first']['total'] + $statistics['gpa4']['second']['total'] + $statistics['gpa4']['third']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('GPA #5') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('GPA >= 3') }}</td>
                            <td>{{ $statistics['gpa5']['third']['positive'] }}</td>
                            <td>{{ $statistics['gpa5']['third']['negative'] }}</td>
                            <td>{{ $statistics['gpa5']['third']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('2 <= GPA < 3') }}</td>
                            <td>{{ $statistics['gpa5']['second']['positive'] }}</td>
                            <td>{{ $statistics['gpa5']['second']['negative'] }}</td>
                            <td>{{ $statistics['gpa5']['second']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('GPA < 2') }}</td>
                            <td>{{ $statistics['gpa5']['first']['positive'] }}</td>
                            <td>{{ $statistics['gpa5']['first']['negative'] }}</td>
                            <td>{{ $statistics['gpa5']['first']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['gpa5']['first']['positive'] + $statistics['gpa5']['second']['positive'] + $statistics['gpa5']['third']['positive'] }}</th>
                            <th>{{ $statistics['gpa5']['first']['negative'] + $statistics['gpa5']['second']['negative'] + $statistics['gpa5']['third']['negative'] }}</th>
                            <th>{{ $statistics['gpa5']['first']['total'] + $statistics['gpa5']['second']['total'] + $statistics['gpa5']['third']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('GPA #6') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('GPA >= 3') }}</td>
                            <td>{{ $statistics['gpa6']['third']['positive'] }}</td>
                            <td>{{ $statistics['gpa6']['third']['negative'] }}</td>
                            <td>{{ $statistics['gpa6']['third']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('2 <= GPA < 3') }}</td>
                            <td>{{ $statistics['gpa6']['second']['positive'] }}</td>
                            <td>{{ $statistics['gpa6']['second']['negative'] }}</td>
                            <td>{{ $statistics['gpa6']['second']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('GPA < 2') }}</td>
                            <td>{{ $statistics['gpa6']['first']['positive'] }}</td>
                            <td>{{ $statistics['gpa6']['first']['negative'] }}</td>
                            <td>{{ $statistics['gpa6']['first']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['gpa6']['first']['positive'] + $statistics['gpa6']['second']['positive'] + $statistics['gpa6']['third']['positive'] }}</th>
                            <th>{{ $statistics['gpa6']['first']['negative'] + $statistics['gpa6']['second']['negative'] + $statistics['gpa6']['third']['negative'] }}</th>
                            <th>{{ $statistics['gpa6']['first']['total'] + $statistics['gpa6']['second']['total'] + $statistics['gpa6']['third']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<br>
<hr>
<br>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('Course Credit #1') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('21 < CC <= 24') }}</td>
                            <td>{{ $statistics['cc1']['third']['positive'] }}</td>
                            <td>{{ $statistics['cc1']['third']['negative'] }}</td>
                            <td>{{ $statistics['cc1']['third']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('18 <= CC <= 21') }}</td>
                            <td>{{ $statistics['cc1']['second']['positive'] }}</td>
                            <td>{{ $statistics['cc1']['second']['negative'] }}</td>
                            <td>{{ $statistics['cc1']['second']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('CC < 18') }}</td>
                            <td>{{ $statistics['cc1']['first']['positive'] }}</td>
                            <td>{{ $statistics['cc1']['first']['negative'] }}</td>
                            <td>{{ $statistics['cc1']['first']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['cc1']['first']['positive'] + $statistics['cc1']['second']['positive'] + $statistics['cc1']['third']['positive'] }}</th>
                            <th>{{ $statistics['cc1']['first']['negative'] + $statistics['cc1']['second']['negative'] + $statistics['cc1']['third']['negative'] }}</th>
                            <th>{{ $statistics['cc1']['first']['total'] + $statistics['cc1']['second']['total'] + $statistics['cc1']['third']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('Course Credit #2') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('21 < CC <= 24') }}</td>
                            <td>{{ $statistics['cc2']['third']['positive'] }}</td>
                            <td>{{ $statistics['cc2']['third']['negative'] }}</td>
                            <td>{{ $statistics['cc2']['third']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('18 <= CC <= 21') }}</td>
                            <td>{{ $statistics['cc2']['second']['positive'] }}</td>
                            <td>{{ $statistics['cc2']['second']['negative'] }}</td>
                            <td>{{ $statistics['cc2']['second']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('CC < 18') }}</td>
                            <td>{{ $statistics['cc2']['first']['positive'] }}</td>
                            <td>{{ $statistics['cc2']['first']['negative'] }}</td>
                            <td>{{ $statistics['cc2']['first']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['cc2']['first']['positive'] + $statistics['cc2']['second']['positive'] + $statistics['cc2']['third']['positive'] }}</th>
                            <th>{{ $statistics['cc2']['first']['negative'] + $statistics['cc2']['second']['negative'] + $statistics['cc2']['third']['negative'] }}</th>
                            <th>{{ $statistics['cc2']['first']['total'] + $statistics['cc2']['second']['total'] + $statistics['cc2']['third']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('Course Credit #3') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('21 < CC <= 24') }}</td>
                            <td>{{ $statistics['cc3']['third']['positive'] }}</td>
                            <td>{{ $statistics['cc3']['third']['negative'] }}</td>
                            <td>{{ $statistics['cc3']['third']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('18 <= CC <= 21') }}</td>
                            <td>{{ $statistics['cc3']['second']['positive'] }}</td>
                            <td>{{ $statistics['cc3']['second']['negative'] }}</td>
                            <td>{{ $statistics['cc3']['second']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('CC < 18') }}</td>
                            <td>{{ $statistics['cc3']['first']['positive'] }}</td>
                            <td>{{ $statistics['cc3']['first']['negative'] }}</td>
                            <td>{{ $statistics['cc3']['first']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['cc3']['first']['positive'] + $statistics['cc3']['second']['positive'] + $statistics['cc3']['third']['positive'] }}</th>
                            <th>{{ $statistics['cc3']['first']['negative'] + $statistics['cc3']['second']['negative'] + $statistics['cc3']['third']['negative'] }}</th>
                            <th>{{ $statistics['cc3']['first']['total'] + $statistics['cc3']['second']['total'] + $statistics['cc3']['third']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('Course Credit #4') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('21 < CC <= 24') }}</td>
                            <td>{{ $statistics['cc4']['third']['positive'] }}</td>
                            <td>{{ $statistics['cc4']['third']['negative'] }}</td>
                            <td>{{ $statistics['cc4']['third']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('18 <= CC <= 21') }}</td>
                            <td>{{ $statistics['cc4']['second']['positive'] }}</td>
                            <td>{{ $statistics['cc4']['second']['negative'] }}</td>
                            <td>{{ $statistics['cc4']['second']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('CC < 18') }}</td>
                            <td>{{ $statistics['cc4']['first']['positive'] }}</td>
                            <td>{{ $statistics['cc4']['first']['negative'] }}</td>
                            <td>{{ $statistics['cc4']['first']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['cc4']['first']['positive'] + $statistics['cc4']['second']['positive'] + $statistics['cc4']['third']['positive'] }}</th>
                            <th>{{ $statistics['cc4']['first']['negative'] + $statistics['cc4']['second']['negative'] + $statistics['cc4']['third']['negative'] }}</th>
                            <th>{{ $statistics['cc4']['first']['total'] + $statistics['cc4']['second']['total'] + $statistics['cc4']['third']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('Course Credit #5') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('21 < CC <= 24') }}</td>
                            <td>{{ $statistics['cc5']['third']['positive'] }}</td>
                            <td>{{ $statistics['cc5']['third']['negative'] }}</td>
                            <td>{{ $statistics['cc5']['third']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('18 <= CC <= 21') }}</td>
                            <td>{{ $statistics['cc5']['second']['positive'] }}</td>
                            <td>{{ $statistics['cc5']['second']['negative'] }}</td>
                            <td>{{ $statistics['cc5']['second']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('CC < 18') }}</td>
                            <td>{{ $statistics['cc5']['first']['positive'] }}</td>
                            <td>{{ $statistics['cc5']['first']['negative'] }}</td>
                            <td>{{ $statistics['cc5']['first']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['cc5']['first']['positive'] + $statistics['cc5']['second']['positive'] + $statistics['cc5']['third']['positive'] }}</th>
                            <th>{{ $statistics['cc5']['first']['negative'] + $statistics['cc5']['second']['negative'] + $statistics['cc5']['third']['negative'] }}</th>
                            <th>{{ $statistics['cc5']['first']['total'] + $statistics['cc5']['second']['total'] + $statistics['cc5']['third']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('Course Credit #6') }}</div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Graduated') }}</th>
                            <th>{{ __('Not Graduated') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('21 < CC <= 24') }}</td>
                            <td>{{ $statistics['cc6']['third']['positive'] }}</td>
                            <td>{{ $statistics['cc6']['third']['negative'] }}</td>
                            <td>{{ $statistics['cc6']['third']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('18 <= CC <= 21') }}</td>
                            <td>{{ $statistics['cc6']['second']['positive'] }}</td>
                            <td>{{ $statistics['cc6']['second']['negative'] }}</td>
                            <td>{{ $statistics['cc6']['second']['total'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('CC < 18') }}</td>
                            <td>{{ $statistics['cc6']['first']['positive'] }}</td>
                            <td>{{ $statistics['cc6']['first']['negative'] }}</td>
                            <td>{{ $statistics['cc6']['first']['total'] }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Total') }}</th>
                            <th>{{ $statistics['cc6']['first']['positive'] + $statistics['cc6']['second']['positive'] + $statistics['cc6']['third']['positive'] }}</th>
                            <th>{{ $statistics['cc6']['first']['negative'] + $statistics['cc6']['second']['negative'] + $statistics['cc6']['third']['negative'] }}</th>
                            <th>{{ $statistics['cc6']['first']['total'] + $statistics['cc6']['second']['total'] + $statistics['cc6']['third']['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection