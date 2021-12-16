@extends('layouts.layout')

@section('content')
    <button type="button" name="create"  class="btn btn-danger btn-xs"><a href="{{ url('/admin/showform') }}">Create</a></button>
    <br><hr>
    <div class="row">
        <div class="col-md-10 col-sm-10 col-xs-10">
            <div class="x_panel">
                <div class="x_content">

                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Adresa</th>
                            <th>Type</th>
                            <th>Departamenti</th>
                            <th>update</th>
                            <th>delete</th>
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

            $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "{{ route('admin.showusers') }}",
                    type: "POST",
                    dataType: "json",
                    data:{ _token:"{{ csrf_token() }}"} },

                columns: [
                    { 'data': 'id' },
                    { 'data': 'name' },
                    { 'data': 'last_name' },
                    { 'data': 'email' },
                    { 'data': 'adresa' },
                    { 'data': 'is_admin' },

                    { 'data': 'dep_name' },
                    { 'data': 'action1', orderable: false, searchable: false },
                    { 'data': 'action2', orderable: false, searchable: false }
                ],
        } );

    </script>
@endsection
