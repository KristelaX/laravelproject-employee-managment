@extends('layouts.layout')
@section('content')


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	
<style>
.report-title {
    color: #0078cc;
	float: right;
	padding-top: 5px;
}
</style>

<div id="tabs">
    <ul id="report_tabs" class="nav nav-tabs" role="tablist" style="padding-top: 30px;">
        <li class="active"><a  href="#tabs_1"><strong>Ngarko Raport</strong></a></li>
        <li><a href="#tabs_2"><strong>Informacion</strong></a></li>
    </ul>
   <div id="tabs_1">
        <div class="row">
            <div class="col-lg-12">
             
                <div class="panel-group" id="accordion">
                    <div class="panel">
                        <div class="panel-heading">
							<h4 class="panel-title">
                                <button class="btn btn-primary" onClick="openFiltersView('Blank_A4_' , 5)"
                                        data-toggle="collapse" data-parent="#accordion" href="#accordionOne" id="accordion">Hap Filtrat</button>
                            <strong><span class="report-title">"Historiku i shitjeve raport"</span></strong>
							</h4>
							<div id="accordionOne" class="panel-collapse collapse">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <div id="pdfHiddenDiv" style="border: 1px solid black;  display: none;" ></div>
   </div>
    <div id="tabs_2">
        <div style="padding: 30px">
            <table style="width: 500px; padding-top: 30px">
                <tr>
                    <td>Autori i Raportit:</td>
                    <td>"kristela"</td>
                </tr>
                <tr>
                    <td>Data e Raportit:</td>
                    <td><?= date("d-m-Y H:i:s")?> </td>
                </tr>
                <tr>
                    <td>Titulli i Raportit:</td>
                    <td>Historiku i shtijeve</td>
                </tr>
                <tr>
                    <td>Pershkrim:</td>
                    <td>SPI report</td>
                </tr>

            </table>

        </div>
    </div>

</div>

 <div id="notRights_div" class="navbar-brand" style="width: 350px; text-align: right;">

</div>


<script type='text/javascript'>
    var formClicked = 0;
    $(function() {
        $( "#tabs" ).tabs();
    });

    function openFiltersView(file, id)
    {

        if(formClicked == 0)
        {
			
		var url2 = '{{ route("admin.showviewraportiishitjes", ":id") }}';
		url2 = url2.replace(':id', id );
            $.ajax({
                url: url2,
                success: function(data) {
					var form = $(data);
					var loginFormID = form.find("#loginFormID");
					//console.log(loginFormID.length);
					if(loginFormID.length >0)
					{
						location.reload();
					}
					else
					{
						$("#accordionOne").html("");
						$('#accordionOne').append(data);
					}
                    formClicked = 1;
                }
            });

        }


    }

    function loadPDF(url, params)
    {
        $("#pdfHiddenDiv").empty();

        $.ajax({
            url: url,
            cache: true,
            mimeType: 'application/pdf',
            data: params,
            success: function ()
            {
                //alert('test success');
                $('#pdfHiddenDiv').css({'display': 'inline'});
                $("#pdfHiddenDiv").html();
                console.log('helo');
                // display cached data
                //if(!isIE)
                $("#pdfHiddenDiv").append('<embed  width="100%" height="700" type="application/pdf" src="' + url + '" ></embed>');
                //else
                // $("#pdfHiddenDiv").append("<object  width='200' height='100' type='application/pdf'><param name='src' value='"+url+"' /></object>");
            },
            error:function(jqXHR, textStatus, errorThrown)
            {
               // alert('test error '+textStatus + " " + errorThrown);
                $("#pdfHiddenDiv").empty();
            }
        });
    }

    $("#report_tabs li").click(function (e) {
        e.preventDefault();
        var self = this;
        var $active = $(this).parent().find("li.active")
        $active.removeClass("active");
        $active.find("span.badge").remove();
        $(this).addClass("active");
        var url = $(this).attr("data-url");
        table.ajax.url(url).load(function (json) {
            $(self).find("a").prepend(
                $("<span>").addClass("badge").addClass("pull-right").text(json.data.length)
            );
        });
    });
    $(document).ready(function ()
    {
       // alert(jQuery.fn.jquery);
        $.support.cors = true;
    });
</script>



    @endsection
