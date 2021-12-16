@extends('layouts.layout')
@section('content')
    <style>
        .alert{ background-color: red; }
    </style>
    @if(Session::has('message'))
        <div class="alert">{{ Session::get('message') }}</div>
    @endif
    @foreach($departament as $d)
        <button type="button" name="delete"  class="btn btn-danger btn-xs"><a onclick="return confirm('Are you sure you want to delete this departament?')" href="{{url('admin/delete/departament/')}}/{{$d->dep_id}}" >Delete</a></button>

        <button type="button" name="update"  class="btn btn-warning btn-xs"><a href="{{ url('admin/edit_dep_form/') }}/{{$d->dep_id}}">update</a></button>

        <br><hr>
        <div class="row">
            <div class="col-md-10 col-sm-10 col-xs-10">
                <div class="x_panel">
                    <div class="x_content">

                        <table id="departamentetable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Adresa</th>
                                <th>Type</th>
                                <th>Departamenti</th>

                            </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <script src=" https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

        <script type="text/javascript" >

            $('#departamentetable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "{{ url('/admin/show/user/of/dep/') }}",
                    type: "POST",
                    dataType: "json",
                    data:{  _token:"{{ csrf_token() }}",
                        id_id:"{{ $d->dep_id }}"
                    }
                },

                columns: [
                    { 'data': 'id' },
                    { 'data': 'name' },
                    { 'data': 'last_name' },
                    { 'data': 'email' },
                    { 'data': 'adresa' },
                    { 'data': 'is_admin' },
                    { 'data': 'dep_fk' },

                ],
            } );

        </script>
    @endforeach
@endsection
