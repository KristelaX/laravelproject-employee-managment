<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="/css/app.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PROJECT</title>
</head>
<body>
<nav class="navbar navbar-dark sticky-top bg-dark navbar-expand-sm p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="">
       Company
    </a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#myNavbar"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="navbar-nav ">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        {{ __('Login') }}</a>
                </li>
                <li class="nav-item">
                    @if (Route::has('register'))
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                </li>
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
                            @csrf
                        </form>
                    </div>
                </li>

            @endguest

        </ul>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">
                            <span data-feather="home"></span>
                            Admin Page <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("profile.index") }}">
                            <span data-feather="file"></span>
                            My Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.showcrud') }}">

                            <span data-feather="users"></span>
                            Employees
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/showllogaritpagen') }}">
                            <span data-feather="users"></span>
                            Llogarit Pagen
                        </a>
                        <ul id="tree1">
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/showviewraport') }}">
                            <span data-feather="users"></span>
                            Raporti per shitjet
                        </a>
                        <ul id="tree1">
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/jquery-tree-view') }}">
                            <span data-feather="users"></span>
                            Departamente
                        </a>
                        <ul id="tree1">
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.chatpage') }}">
                            <span data-feather="bar-chart-2"></span>
                            Chat
                        </a>
                    </li>

                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Admin Page </h1>

            </div>
            <div>
                @yield('content')
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>

{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script type="text/javascript" src="{{url('/scripts/jquery.js')}}"></script>
	<script type="text/javascript" src="{{url('/scripts/jquery.ui.js')}}"></script>
	<script type="text/javascript" src="{{url('/scripts/jquery.validate.js')}}"></script>
	<script type="text/javascript" src="{{url('/scripts/jquery.datatables.js')}}"></script>
	<script type="text/javascript" src="{{url('/scripts/jquery.datatables.bootstrap.js')}}"></script>
	<script type="text/javascript" src="{{url('/scripts/dataTables.keyTable.js')}}"></script>
	<script type="text/javascript" src="{{url('/scripts/jquery.rowslide.js')}}"></script>
	<script type="text/javascript" src="{{url('/scripts/default.js')}}"></script>
	<script type="text/javascript" src="{{url('/scripts/jquery.slimscroll.js')}}"></script><!-- -->
	<script type="text/javascript" src="{{url('/scripts/bootstrap-combobox.js')}}"></script><!-- -->
	<script type="text/javascript" src="{{url('/scripts/bootstrap-bootbox.js')}}"></script><!-- -->
	<script type="text/javascript" src="{{url('/scripts/jquery.bootstrap-touchspin.js')}}"></script><!-- -->
	<script type="text/javascript" src="{{url('/scripts/jquery.formance.min.js')}}"></script><!-- -->
	<script type="text/javascript" src="{{url('/scripts/jquery.autoNumeric.js')}}"></script>
	<script type="text/javascript" src="{{url('/scripts/json.js')}}"></script>
	<script type="text/javascript" src="{{url('/scripts/common.js')}}"></script>
	<script type="text/javascript" src="{{url('/scripts/bootstrap-bootbox.js')}}"></script>
	<script type="text/javascript" src="{{url('/scripts/select2.js')}}"></script>			
    <script type="text/javascript" src="{{url('/scripts/pdfobject.js')}}"></script>

<script>
    feather.replace()
</script>



</body>
</html>
