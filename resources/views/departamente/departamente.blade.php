<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dynamic Treeview for Departments</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link href="http://www.expertphp.in/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="http://demo.expertphp.in/css/jquery.treeview.css" />
    <script src="http://demo.expertphp.in/js/jquery.js"></script>
    <script src="http://demo.expertphp.in/js/jquery-treeview.js"></script>
    <script type="text/javascript" src="http://demo.expertphp.in/js/demo.js"></script>
</head>
<body>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Manage Category TreeView
            <p style="text-align: right" ><button><a href="/admin/crud" >Go back</a></button></p>
        </div>
        <div class="panel-body">
            <div class="row">
<div class="container">
    {!! $tree !!}
</div>
            </div>
            <br>
<div>

    <h3>Add New Department</h3>
<br>
    <form method="POST" action="{{ route('admin.add_newdepartament') }}">
        @csrf

        <div class="form-group row">
            <label for="dep_name" class="col-md-2 col-form-label text-md-right">{{ __('Departamenti i ri:') }}</label>

            <div class="col-md-4">
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"  required autofocus>

                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="departamenti" class="col-md-2 col-form-label text-md-right">{{ __('Department:') }}</label>

            <div class="col-md-4">
                <select  name="departamenti" id="departamenti" class="form-control{{ $errors->has('departamenti') ? ' is-invalid' : '' }}" required autofocus>
                    <option value="0">Departament i ri </option>
                    @foreach($alldep as $row)
                        <option value="{{ $row->dep_id }}">{{ $row->dep_name }}</option>
                    @endforeach

                </select>
                @if ($errors->has('departanenti'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('departamenti') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="manager" class="col-md-2 col-form-label text-md-right">{{ __('Manager:') }}</label>

            <div class="col-md-4">
                <select  name="manager" id="manager" class="form-control{{ $errors->has('manager') ? ' is-invalid' : '' }}" required autofocus>
                    @foreach($man as $man)
                        <option value="{{ $man->id }}">{{ $man->name }}</option>
                    @endforeach

                </select>
                @if ($errors->has('manager'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('manager') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="location" class="col-md-2 col-form-label text-md-right">{{ __('Location:') }}</label>

            <div class="col-md-4">
                <input id="location" type="text" class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" name="location"  required autofocus>

                @if ($errors->has('location'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                @endif
            </div>
        </div>


        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Save') }}
                </button>
            </div>
        </div>
    </form>

</div>
        </div>
    </div>
</div>

</body>
</html>