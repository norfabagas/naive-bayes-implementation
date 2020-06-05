<div class="container">
    @if(Session::has('message'))
    <div class="alert alert-success alert-dismissable fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ Session::get('message') }}
    </div>
    @endif
    <div class="row">


        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Menu
                </div>
                <div class="card-body">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.index') }}">Index</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            @yield('content')
        </div>
    </div>
</div>