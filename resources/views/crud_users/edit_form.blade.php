@extends('layouts.layout')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit user') }}</div>
                    @foreach($edit_user as $edit_user )
                    <div class="card-body">
                        <form method="POST" action="{!! route('admin.edit_user_profile', ['user_id'=>$edit_user->id]) !!}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $edit_user->name }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value=" {{ $edit_user->last_name }} " required autofocus>

                                    @if ($errors->has('last_name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $edit_user->email }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="adresa" class="col-md-4 col-form-label text-md-right">{{ __('Adresa') }}</label>

                                <div class="col-md-6">
                                    <input id="adresa" type="text" class="form-control{{ $errors->has('adresa') ? ' is-invalid' : '' }}" name="adresa" value="{{ $edit_user->adresa }}" required autofocus>

                                    @if ($errors->has('adresa'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('adresa') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>

                                <div class="col-md-6">
                                    <select  name="tipi" id="tipi" class="form-control{{ $errors->has('tipi') ? ' is-invalid' : '' }}" required autofocus>
                                        <option value="1">Admin</option>
                                        <option value="0">Punonjes</option>
                                    </select>


                                    @if ($errors->has('tipi'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tipi') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="departamenti" class="col-md-4 col-form-label text-md-right">{{ __('Department') }}</label>

                                <div class="col-md-6">
                                    <select  name="departamenti" id="departamenti" class="form-control{{ $errors->has('departamenti') ? ' is-invalid' : '' }}" required autofocus>
                                            @foreach($departament as $row)

                                              <option value="{{ $row->dep_id }}"
                                                      @if ($row->dep_id == $edit_user->dep_fk)
                                              selected="selected"
                                                      @endif>{{ $row->dep_name }}</option>
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
