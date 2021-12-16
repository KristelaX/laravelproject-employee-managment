@extends('layouts.layout')
@section('content')
    <head>
    <title>Salary Calculation</title>
<style>
    #salary-window {
        background-color: #eee;
        width: 700px;
        height: 500px;
        border: 1px dotted black;
        
    }
</style>
    </head>
    <body>

    <div class="col-lg-4 col-lg-offset-4">
        <h1 id="greeting">Salary Calculation</h1>

        <div class="col-lg-12">
            <input type="text" id="text" class="form-control col-lg-12" autofocus="" >
            <br>
            <button  class="btn btn-primary" onclick="retrieveSalary()">
                {{ __('Calculate') }}
            </button>
        </div>
        <br><br>
        <div id="salary-window" class="col-lg-12">

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        
        $(document).ready(function() {
            document.getElementById("salary-window").style.display = "none"; 
        });
    
        function retrieveSalary()
        {
            var grossSalary = $('#text').val();
            if (grossSalary >0) {
            $.ajax({
                url: "{{ url('admin/llogaritpagen') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:'POST',
                dataType: "JSON",
                data:{  _token:"{{ csrf_token() }}",
                    paga : grossSalary,},
                success:function(data)
                {
                    document.getElementById("salary-window").style.display = "inherit"; 
                        $('#salary-window').append('<p>Elementet e Pages</p><hr><br><p>Paga Neto : <b>'+data.nettSalary
                        + '</b> <br><p> TAP :  <b>' +data.PIT+
                        '</b><br><p>Sigurime Shoqerore Punonjesi : <b>'+data.SocialInsuranceEmployee+
                        '</b><br><p>Sigurime shendetesore punonjesi : <b>' + data.HealInsuranceEmployee+
                        '</b><br><p>Sigurime shoqerore Punedhenesi : <b>' + data.SocialInsuranceEmployeer+
                        '</b><br><p>Sigurime shendetesore punedhenesi : <b>' + data.HealInsuranceEmployee+'<br>');
                    
                }
            });
            }
        }

    </script>
    @endsection