@extends('layouts.layout')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Departamentin') }}</div>
                    @foreach($dep_to_update as $up )
                        <div class="card-body">
                            <form method="POST" action="{!! route('admin.update_departament_info', ['depart_id'=>$up->dep_id]) !!}" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $up->dep_name }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="" class="col-md-4 col-form-label text-md-right">{{ __('Location') }}</label>

                                    <div class="col-md-6">
                                        <input id="location" type="text" class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" name="location" value=" {{ $up->location }} " required autofocus>

                                        @if ($errors->has('location'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="manager" class="col-md-4 col-form-label text-md-right">{{ __('Manaxheri') }}</label>

                                    <div class="col-md-6">
                                        <select  name="manager" id="manager" class="form-control{{ $errors->has('manager') ? ' is-invalid' : '' }}" required autofocus>
                                            @foreach($allusers as $us)

                                                <option value="{{ $us->id }}"
                                                        @if ($us->id == $up->manager_id)
                                                        selected="selected"
                                                        @endif>{{ $us->name }}</option>
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
                                    <label for="departamenti" class="col-md-4 col-form-label text-md-right">{{ __('Departmenti Kryesor') }}</label>

                                    <div class="col-md-6">
                                        <select  name="departamenti" id="departamenti" class="form-control{{ $errors->has('departamenti') ? ' is-invalid' : '' }}" required autofocus>
                                            <option value="0">Departament i Ri </option>
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

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Edit') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection
