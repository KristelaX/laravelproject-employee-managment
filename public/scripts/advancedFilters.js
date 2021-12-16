	
// objParams, parametra qe mund ti shtojme ne request
function getAdvancedFilters(objParams)
{
	advancedSqlFilters = "";
	var filters = [];
	var postData = {};
	if(objParams && objParams.id_project) {
        postData.id_project = objParams.id_project;
	}
	$("#builder").queryBuilder("destroy");
	$.ajax({
		url: filter_url,
		method: "post",
		data: postData,
		success: function(response){
			var data = JSON.parse(response);
			//console.log(data)
			data.fields.forEach(function(field){
				var filter = {};
				filter.id = field.field_name;
				filter.label = field.label;
				switch(field.field_type){
					
					case "datetimepicker":
						filter.type = 'date';
						filter.validation = {
							format: 'yyyy-mm-dd'
						};
						filter.plugin = 'datepicker';
						filter.plugin_config = {
							format: 'yyyy-mm-dd',
							showTodayButton: true,
							showClear: true,
							useCurrent: false,
							widgetPositioning: {
								horizontal: 'right',
								vertical: 'bottom'
							}
						};
						filter.operators= ["equal", "contains", "not_equal", "less", "less_or_equal", "greater","greater_or_equal", "is_null", 
										   "is_not_null", "between", "not_between", "is_empty", "is_not_empty"];
					break;
					case "checkbox":
						filter.type="string";
						filter.input = "radio";
						filter.values = [field.extradata1, field.extradata2];
						filter.operators= ["equal", "not_equal", "is_null", "is_not_null", "is_empty", "is_not_empty"];
					break;
					case "combobox":
						filter.id = field.field_name; //id ne tabelen e combobox
						filter.type="string";
						filter.input = "select";
						filter.values = data.combo_values[field.combo_subject];
						filter.operators= ["equal", "not_equal", "is_null", "is_not_null", "is_empty", "is_not_empty"];
					break;
					default:
						filter.type = "string";
						filter.input = "text";
						filter.operators= ["equal", "not_equal", "contains", "not_contains", "is_empty", "is_not_empty", "ends_with",
										   "not_ends_with", "begins_with", "not_begins_with", "is_null", "is_not_null"]; 
				}
				filters.push(filter);
			})
			$('#builder').queryBuilder({
				filters: filters,
				  lang_code: 'en'
				//lang_code : 'alb'
		  });
		},
		error: function (jqXHR, textStatus, errorThrown) {
			bootbox.alert(errorThrown);
        }
	});
}

function applyAdvancedFilters()
{
	if(mainTable == "timelineTable") {
		applyTimelineFilters(); // callback tek funksioni ne forme
		return;
	}
	var result_sql = $('#builder').queryBuilder('getSQL', false);
	
	var result_json = $('#builder').queryBuilder('getRules');
	console.log("clicks"+JSON.stringify(result_json));
	advancedSqlFilters = result_sql.sql;
	if(advancedSqlFilters != "")
	{
		$("#"+mainTable).DataTable().ajax.reload();
		console.log("test");
		$("#adv_filters_popup").fadeOut();
	}
		

}
 
function showFilters()
{
	
	console.log("filters");
	$('#filter_id').val('0');
	$('#filter_name').val('');
	$('#filter_desc').val('');
	//$('#builder').queryBuilder('reset');
	$("#adv_filters_popup").fadeIn();
	advancedSqlFilters = "";
}

function dismissAdvFilters()
{
	//$('#builder').queryBuilder('destroy');
	$('#filter_id').val('0');
	$('#filter_name').val('');
	$('#filter_desc').val('');
	//$('#builder').queryBuilder('reset');
	advancedSqlFilters = "";
	$("#adv_filters_popup").fadeOut();
}

function resetComplex()
{
	$('#filter_id').val('0');
	$('#filter_name').val('');
	$('#filter_desc').val('');
	$('#builder').queryBuilder('reset');
	advancedSqlFilters = "";
}

function saveAdvancedFilters()
{
   var result_sql = $('#builder').queryBuilder('getSQL', false);
   var result_json = $('#builder').queryBuilder('getRules');
   //console.log(result_json);
   var f_id = 0;
   if($('#filter_id').val() != "" && $('#filter_id').val() != null)
	   f_id = parseInt($('#filter_id').val());

   if($('#filter_name').val() != "" && $('#filter_name').val() != null)
   {	
		var data = {
			filter_id: f_id,
			filter_name: $('#filter_name').val(),
			description: $('#filter_desc').val(),
			sql: encodeURIComponent(result_sql.sql),
			json: result_json,
			datecreated: "2015-11-20",
			type: "grid",
			type_name: filter_subject,
		};
		var post_data = {};
		post_data.filter_data = data;

		if(result_sql.sql.length > 0)
		{
			$.ajax({
				url: "?filterTemplateCRUD/save",
				type: 'POST',
				data: post_data,
				//dateType: "json",
				//contentType: 'application/json',
				success: function (response) {
					//bootbox.alert(response.message);
					if ( $.fn.dataTable.isDataTable( '#filters_grid' ) ) 
					{
						filters_dt.ajax.reload();
					}
				}
			});

			$("#adv_filters_popup").fadeOut();
		}
   }
   else
	   bootbox.alert("Ju lutem specifikoni nje emer per kete filter!");
}

function drawCallback() {};
var filters_dt;
function initializeFiltersGrid()
{
    if ( ! $.fn.DataTable.isDataTable( '#filters_grid' ) ) {
        //grida e filtrave te avancuar
        filters_dt = $('#filters_grid').DataTable({
            columns: [
                { "data": "filter_name" },
                { "data": "description" },
                { "data": "apply" },
                { "data": "edit" },
                { "data": "delete" }
            ],
            deferLoading: 0,
            ajax: function (data, callback, settings) {
                $.ajax({
                    url: "?filterTemplateCRUD/load",
                    type: 'POST',
                    contentType: "application/json; charset=UTF-8",
                    dataType: "json",
                    traditional: true,
                    data: JSON.stringify({
                        additionalData: {
                            conditionData: {}
                        },
                        type: 'grid',
                        type_name: filter_subject
                    }),
                    success: function (result) {
                        callback(result);
                    }
                });
            } ,
            columnDefs:[],
            iDisplayLength: 25 ,
            createdRow: handleRowDelete ,
            drawCallback: drawCallback
        });
    }


}
function showFiltersTemplates(){
	//filters_dt.ajax.reload();
	$("#adv_filters_popup_grid").fadeIn();
}

function dismissAdvFiltersGrid(){
	//$('#builder').queryBuilder('destroy');
	advancedSqlFilters = "";
	$("#adv_filters_popup_grid").fadeOut();
}

function applyFilter(target)
{
    if(mainTable == "timelineTable") {
        applyTimelineSavedFilters(target); // callback tek funksioni ne forme
        return;
    }

	var row_data = filters_dt.row($(target).parents("tr")).data();
	advancedSqlFilters = row_data.sql;
	$("#"+mainTable).DataTable().ajax.reload();
	$("#adv_filters_popup_grid").fadeOut();
}

function editFilter(target)
{
	var row_data = filters_dt.row($(target).parents("tr")).data();
	filter_sql = row_data.sql;
	filter_json = row_data.json;
	if(filter_json.length > 0){
		$('#builder').queryBuilder('setRules', JSON.parse(filter_json));
	}

	$('#filter_id').val(row_data.filter_id);
	$('#filter_name').val(row_data.filter_name);
	$('#filter_desc').val(row_data.description);
	$("#adv_filters_popup").fadeIn();
}

function deleteFilter(target)
{
	var row_data = filters_dt.row($(target).parents("tr")).data();
	if(isNaN(row_data.filter_id)){
		return;
	}
	$.ajax({
		url: "?filterTemplateCRUD/delete/",
		method: "post",
		data: {filter_id: row_data.filter_id},
		dataType: 'json',
		success: function(response){
			if(response.success == 1)
				filters_dt.ajax.reload();
			else
				bootbox.alert(response.message); //problem
		}
	});
}

function clearFilters(){

    if(mainTable == "timelineTable") {
        clearTimelineFilters(); // callback tek funksioni ne forme
        return;
    }
	advancedSqlFilters = "";
	source = "";
	$('#builder').queryBuilder('reset');
	$("#"+mainTable).DataTable().ajax.reload();
}

function reloadAdvFiltersGrid() {
    $('#filters_grid').DataTable().ajax.reload();
}

$(function () {
    initializeFiltersGrid();
});
