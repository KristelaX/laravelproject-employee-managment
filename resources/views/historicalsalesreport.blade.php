
<script type="text/javascript" src="{{url('/scripts/json.js')}}"></script>
<script type="text/javascript" src="{{url('/scripts/common.js')}}"></script>
<script type="text/javascript" src="{{url('/scripts/bootstrap-bootbox.js')}}"></script>
<script type="text/javascript" src="{{url('/scripts/select2.js')}}"></script>

<style>
    .select2-container {
        width: 100%;
    }
</style>
<div class="row" style="padding-top: 10px; padding_left: 30px;">

	<div class="form-group col-lg-2">
            <label for="date">Data</label>
            <input type="text" class="form-control global_filter data-calendar " name="date" value="<?= date("d/m/Y")?>"
                       id="date"  placeholder="Nga" />
    </div>		   
	<?php
		$report_url = "http://127.0.0.1:8080/test2/index_laravel.jsp?report=".$report_name."&action=topdf";
		$report_url_exp = "http://127.0.0.1:8080/test2/index_laravel.jsp?report=".$report_name."&action=toxls";
	?>
</div>
<button id="applyFilters" class="btn btn-primary" onClick="openReport('<?php echo $report_url;?>','pdf')"> Apliko Filtrat</button>
<button class="btn btn-success" onClick="openReport('<?php echo $report_url_exp;?>','xls')"> Eksport</button>

<script type='text/javascript'>

    function openReport(url, source)
    {
		var report_title_value = '<?php echo $report_name; ?>';
        var report_title = {parameter:"report_title", value:report_title_value};

		var date_start_from_fld = $("#date").val();

		if(date_start_from_fld == "")
		{
            bootbox.alert("Ju lutem plotesoni zgjidhni daten");
			return;
		}
		
		var dayFrom = date_start_from_fld.substring(0, 2); 
		var monthFrom = date_start_from_fld.substring(3, 5); 
		var yearFrom = date_start_from_fld.substring(6, 11); 
		var date_start_from_value = yearFrom+'-'+monthFrom+'-'+dayFrom;
		var date = {parameter:"date", value:date_start_from_value};
		
        var  params =  base64_encode(JSON_forReports.encode([date, report_title])) ;
		
		var dataToPost = {params:  params, url: url};
		var url2 = '{{ route("admin.shfaqraportiishitjes", ":id") }}';
		url2 = url2.replace(':id', source );

        $.ajax({
			method:"POST",
			url: url2,
			data: {  _token:"{{ csrf_token() }}",
			params:  params, 
			url1: url,},
            success: function (filepath)
            {
				if(source == 'pdf')
				{
					/**************************added JSON.parse() because extra character were added********/
					$("#pdfHiddenDiv").empty();
					$('#pdfHiddenDiv').css({"display": 'block', "width":"100%" ,"height":"700px"});
					var variablename = new PDFObject({ url:JSON.parse(filepath) }).embed("pdfHiddenDiv");         
				}
				else
				{
					window.open(JSON.parse(filepath));
				} 
          
			},
            error:function(jqXHR, textStatus, errorThrown)
            {
				// alert('test error '+textStatus + " " + errorThrown);
				$("#pdfHiddenDiv").empty();
            }
        });
    }
			
    </script>


