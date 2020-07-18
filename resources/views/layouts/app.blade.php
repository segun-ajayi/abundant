<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Abundant Grace Multipurpose Cooperative Society">
    <meta name="author" content="Segun Ajayi">
    <title>Abundant Grace Multipurpose Cooperative Society</title>
    <!-- Icons-->
    <link href="{{ asset('vendors/@coreui/icons/css/coreui-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/pace-progress/css/pace.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/toastr/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{asset('vendors/select2/css/select2.min.css')}}" rel="stylesheet">
    @yield('css')
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
<header class="app-header navbar">
    <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="{{ asset('img/brand/logo.png') }}" width="89" height="25" alt="CoreUI Logo">
{{--        <img class="navbar-brand-minimized" src="{{ asset('img/brand/sygnet.svg') }}" width="30" height="30" alt="CoreUI Logo">--}}
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="/members">Members</a>
        </li>
{{--        <li class="nav-item px-3">--}}
{{--            <a class="nav-link" href="/my_profile">My Profile</a>--}}
{{--        </li>--}}
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link nav-link" data-toggle="dropdown" href="/" role="button" aria-haspopup="true" aria-expanded="false">
                <img class="img-avatar" src="{{ asset('img/members/' . Auth::user()->member->pix) }}" alt="{{ Auth::user()->member->name }}">
            </a>
        </li>
        <li>
            <p class="text-muted" style="position: relative; bottom: -10px"><b>{{ Auth::user()->member->name }}</b></p>
        </li>
        <li style="margin-left: 20px">
            <a href="{{ route('logout') }}" class="btn btn-outline-primary"
               onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out"> Log out</i>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
    <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>
<div class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="nav-icon icon-speedometer"></i> Home
                    </a>
                </li>
                <li class="nav-title">Functions</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('members') }}">
                        <i class="nav-icon icon-people"></i> Members</a>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-calculator"></i> Attendance</a>
                    <ul class="nav-dropdown-items">
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="{{ route('attendance') }}">--}}
{{--                                <i class="nav-icon icon-calculator"></i> Attendance</a>--}}
{{--                        </li>--}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('markAttendance') }}">
                                <i class="nav-icon icon-check"></i> Mark Attendance</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('post') }}">
                        <i class="nav-icon icon-paper-plane"></i> Post</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('post') }}">
                        <i class="nav-icon icon-handbag"></i> Loans</a>
                </li>
                <li class="nav-title">Reports</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('analysis') }}">
                        <i class="nav-icon icon-graph"></i> Monthly Analysis</a>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-settings"></i> Settings</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('my_profile', Auth::user()->member->id) }}">
                                <i class="nav-icon icon-user"></i> My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="" data-toggle="modal" data-target="#changePassword">
                                <i class="nav-icon icon-key"></i> Change Password</a>
                        </li>
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('add_member') }}">
                                    <i class="nav-icon icon-user-follow"></i> Add Member</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('deleted_members') }}">
                                    <i class="nav-icon icon-trash"></i> Deleted Members</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('upload_member') }}">
                                    <i class="nav-icon icon-arrow-up-circle"></i> Upload Members</a>
                            </li>
                        @endif
                    </ul>
                </li>
                @if(Auth::user()->role == 'admin')
                    <li class="nav-title">Admin</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}">
                            <i class="nav-icon icon-people"></i> Excos</a>
                    </li>
                @endif
            </ul>
        </nav>
{{--        <button class="sidebar-minimizer brand-minimizer" type="button"></button>--}}
    </div>
    <main class="main">
        <!-- Breadcrumb-->
        @if(isset($pMonth))
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><h4>Posting for the month of <span style="font-weight: bolder; margin-right: 50px; color: #1abb6a">{{ $pMonth }}</span></h4></li>
                <li><button class="btn btn-primary btn-sm px-5" id="changeBtn">Change</button></li>
            </ol>
        @endif
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row justify-content-center">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
</div>
<footer class="app-footer">
    <div>
        <a href="#">Abundant Grace Co-Operative Society</a>
        <span>&copy; 2020 Abundant Grace.</span>
    </div>
    <div class="ml-auto">
        <span>Powered by</span>
        <a href="#">Abundant Grace</a>
    </div>
</footer>
<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-warning" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Post Month</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="pMonth">Choose Month</label>
                        <div class="col-md-9">
                            <select class="form-control" id="pMonth" name="pMonth">
                                <option value="">Select Month</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                    </div>
            </div>
{{--            <div class="modal-footer">--}}
{{--                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>--}}
{{--                <button id="postFine" class="btn btn-success" type="button">Fine</button>--}}
{{--            </div>--}}
        </div>
        <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
<div class="modal inmodal" id="changePassword" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-key modal-icon"></i>
                <h4 class="modal-title">Change Password</h4>
                {{--                <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>--}}
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Old Password</label> <input type="password" name="old_password" id="Cold"  placeholder="Enter old Password" class="form-control"></div>
                <div class="form-group"><label>New Password</label> <input type="password" name="password" id="Cpassword" placeholder="Enter new password" class="form-control"></div>
                <div class="form-group"><label>New Password</label> <input type="password" name="password2" id="Cpassword2" placeholder="Enter new password again" class="form-control"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" id="cpass" class="btn btn-primary">Change Password</button>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap and necessary plugins-->
<script src="{{ asset('vendors/jquery/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendors/popper.js/js/popper.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendors/pace-progress/js/pace.min.js') }}"></script>
<script src="{{ asset('vendors/perfect-scrollbar/js/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('vendors/@coreui/coreui-pro/js/coreui.min.js') }}"></script>
<!-- Plugins and scripts required by this view-->
<script src="{{ asset('vendors/toastr/js/toastr.js') }}"></script>
<script src="{{ asset('vendors/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('vendors/select2/js/select2.min.js') }}"></script>
@yield('script')
<script>
    $('#changeBtn').click(function(){
       $('#changeModal').modal('show');
    });
    $('#pMonth').change(function(){
        const data = {
            _token: "{{ @csrf_token() }}",
            pMonth: $('#pMonth').val()
        };
        $.post("{{ route('pmonth') }}", data)
            .then((resp) => {
                if (!resp.status) {
                    throw Error(resp.statusText);
                }
                toastr.success(resp.message);
                location.reload();
            }).catch((err) => {
                console.log(err);
                toastr.error(err.statusText);
        })
    });

    $('#cpass').click(function () {
        const old = $('#Cold').val();
        const modal = $('#changePassword');
        const pass = $('#Cpassword').val();
        const pass2 = $('#Cpassword2').val();
        $.post("{{ route('changePassword') }}", {
            _token: "{{ csrf_token() }}",
            old_password: old,
            password: pass,
            password_confirmation: pass2,
        }).then((data) => {
            toastr.success('Password changed successfully.');
            modal.modal('hide');
        }).catch((err) => {
            if(err.responseJSON.old_password) {
                toastr.error(err.responseJSON.old_password);
            }
            if(err.responseJSON.password) {
                toastr.error(err.responseJSON.password);
            }
        })
    })
</script>
@if(Session::has('suc'))
    <script>
        toastr.success("{{ Session::get('suc') }}");
    </script>
@endif
@if(Session::has('err'))
    <script>
        toastr.error("{{ Session::get('err') }}");
    </script>
@endif
@if(Session::has('inf'))
    <script>
        toastr.info("{{ Session::get('inf') }}");
    </script>
@endif
@if(Session::has('war'))
    <script>
        toastr.warning("{{ Session::get('war') }}");
    </script>
@endif
@if(Session::has('valerr'))
{{--    {{ dd(Session::get('valerr')) }}--}}
{{--    @foreach(Session::get('valerr') as $k => $v)--}}
        <script>
            toastr.error("{{ Session::get('valerr') }}");
        </script>
{{--    @endforeach--}}

@endif
</body>
</html>
