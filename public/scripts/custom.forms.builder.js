function initializeFields() {
    $("[name=\"autocomplete_select[]\"]").select2({
        multiple: true,
        minimumInputLength: 3,
        placeholder: 'Search',
        ajax: { }
    });  
    
    $("[name=\"combobox[]\"]").multiselect({
        enableFiltering: true,
        maxHeight: 250,
        templates: {
            divider: "<div class=\"divider\" data-role=\"divider\"></div>"
        }
    });
}

function getOptionMenu(item, saveCallback) {
    var $panel = $("<div></div>")
        .addClass("panel")
        .addClass("panel-default")
        .addClass("form-option-panel")
        .attr("data-field-option", item.FieldId);

    
    var $body = $("<div></div>")
        .addClass("panel-body");

    // label
    $body.append(
        $("<div></div>")
            .addClass("form-group")
            .css("margin-bottom", "0")
            .append($("<label></label>").text("Label"))
            .append(
                $("<input>")
                    .attr("type", "text")
                    .attr("data-option", "label")
                    .addClass("form-control")
                    .addClass("input-sm")
                    .val(item.Options.Label)
            )
    );
    
    // Tooltip
    $body.append(
        $("<div></div>")
            .addClass("form-group")
            .css("margin-bottom", "0")
            .append($("<label></label>").text("Tooltip"))
            .append(
                $("<input>")
                    .attr("type", "text")
                    .attr("data-option", "tooltip")
                    .addClass("form-control")
                    .addClass("input-sm")
                    .val(item.Options.Tooltip)
            )
    );

    // field name
    $body.append(
        $("<div></div>")
            .addClass("form-group")
            .css("margin-bottom", "0")
            .append($("<label></label>").text("Field name"))
            .append(
                $("<input>")
                    .attr("type", "text")
                    .attr("data-option", "field-name")
                    .addClass("form-control")
                    .addClass("input-sm")
                    .val(item.Options.FieldName)
            )
    );

    // is required
    $body.append(
        $("<div></div>")
            .css({"margin-bottom": "0", "margin-top": "3px"})
            .append(
                $("<input>")
                    .attr("type", "checkbox")
                    .attr("data-option", "required")
            ).append(
                $("<label></label>")
                    .css({"padding-top": "2px", "padding-left": "2px" })
                    .text(" Required")
            )
    );

    // column Span
    if (item.Options.HasColumnSpan) {
        $body.append(
            $("<div></div>")
                .addClass("form-group")
                .css("margin-bottom", "0")
                .append($("<label></label>").text("Column span"))
                .append(
                    $("<input>")
                        .attr("type", "text")
                        .attr("data-option", "column-span")
                        .addClass("form-control")
                        .addClass("input-sm")
                        .val(item.Options.ColumnSpan)
                )        
        );
    }

    // row span
    if (item.Options.HasRowSpan) {
        $body.append(
            $("<div></div>")
                .addClass("form-group")
                .css("margin-bottom", "0")
                .append($("<label></label>").text("Row span"))
                .append(
                    $("<input>")
                        .attr("type", "text")
                        .attr("data-option", "row-span")
                        .addClass("form-control")
                        .addClass("input-sm")
                        .val(item.Options.RowSpan)
                )
        );
    }

    // retreive action
    if (item.Options.HasRetrieveAction) {
        $body.append(
            $("<div></div>")
                .addClass("form-group")
                .css("margin-bottom", "0")
                .append($("<label></label>").text("Retrieve action"))
                .append(
                    $("<input>")
                        .attr("type", "text")
                        .attr("data-option", "retrieve-action")
                        .addClass("form-control")
                        .addClass("input-sm")
                        .val(item.Options.RetrieveAction)
                )
        );
    }
    
    // new record action
    if (item.Options.HasNewRecordAction) {
        $body.append(
            $("<div></div>")
                .addClass("form-group")
                .css("margin-bottom", "0")
                .append($("<label></label>").text("New record action"))
                .append(
                    $("<input>")
                        .attr("type", "text")
                        .attr("data-option", "new-record-action")
                        .addClass("form-control")
                        .addClass("input-sm")
                        .val(item.Options.NewRecordAction)
                )
        );
    }    
    
    // save action
    if (item.Options.HasSaveAction) {
        $body.append(
            $("<div></div>")
                .addClass("form-group")
                .css("margin-bottom", "0")
                .append($("<label></label>").text("Save action"))
                .append(
                    $("<input>")
                        .attr("type", "text")
                        .attr("data-option", "save-action")
                        .addClass("form-control")
                        .addClass("input-sm")
                        .val(item.Options.SaveAction)
                )
        );
    }    
    
    // autocomplete action
    if (item.Options.HasAutocompleteAction) {
        $body.append(
            $("<div></div>")
                .addClass("form-group")
                .css("margin-bottom", "0")
                .append($("<label></label>").text("Autocomplete action"))
                .append(
                    $("<input>")
                        .attr("type", "text")
                        .attr("data-option", "autocomplete-action")
                        .addClass("form-control")
                        .addClass("input-sm")
                        .val(item.Options.AutocompleteAction)
                )
        );
    }

    // browse action
    if (item.Options.HasBrowseAction) {
        $body.append(
            $("<div></div>")
                .addClass("form-group")
                .css("margin-bottom", "0")
                .append($("<label></label>").text("Browse action"))
                .append(
                    $("<input>")
                        .attr("type", "text")
                        .attr("data-option", "browse-action")
                        .addClass("form-control")
                        .addClass("input-sm")
                        .val(item.Options.BrowseAction)
                )
        );
    }
    
    // browse action
    if (item.Options.HasLoadAction) {
        $body.append(
            $("<div></div>")
                .addClass("form-group")
                .css("margin-bottom", "0")
                .append($("<label></label>").text("Load action"))
                .append(
                    $("<input>")
                        .attr("type", "text")
                        .attr("data-option", "load-action")
                        .addClass("form-control")
                        .addClass("input-sm")
                        .val(item.Options.LoadAction)
                )
        );
    }
    
    $body.append(
        $("<div></div>")
            .addClass("form-group")
            .addClass("validation-result")
            .css("margin-bottom", "0")
            .hide()
    );
    
    // buttons
    $body.append(
        $("<div></div>").addClass("form-group")
            .css({"margin-bottom": "0", "margin-top": "10px" })
            .append(
                $("<input>").attr("type", "button")
                    .addClass("form-control")
                    .addClass("input-sm")
                    .val("Save")
                    .click(function() {
                        $body.find(".validation-result")
                            .children().remove()
                            .slideUp();
                        setOptions($body, item);
                        errors = validate(item);
                        if (errors.length === 0) {
                            applyOptions($panel.closest("[data-field-index]"), item);
                            var index = parseInt($panel.closest("[data-field-index]").attr("[data-field-index]"));
                            saveCallback(item, index);
                            $panel.remove();
                        } else {
                            $.each(errors, function (i) {
                                $body.find(".validation-result").append(
                                    $("<div>").text(errors[i])
                                );
                            });
                            $body.find(".validation-result").slideDown();
                        }
                    })
            ).append(
                $("<input>").attr("type", "button")
                    .addClass("form-control")
                    .addClass("input-sm")
                    .val("Cancel")
                    .click(function() {
                        $panel.remove();
                    })
            )
    );
    
    $panel.append($body);
    return $panel;
}

function applyOptions(element, item) {
    for (var i = 0; i < 4; i++)
        element.removeClass("colspan" + i);
    element.addClass("colspan" + item.Options.ColumnSpan);
    
    for (var i = 0; i < 6; i++) 
        element.removeClass("rowspan" + i);
    element.addClass("rowspan" + item.Options.RowSpan);
    
    element.children("label").first().text(item.Options.Label);
    element.children("input").first().removeClass("rowspan" + i);
    element.children("input").first().addClass("rowspan" + item.Options.RowSpan);
}

function setOptions(element, item) {
    item.Options.Tooltip = element.find("[data-option=\"tooltip\"]").val();
    item.Options.Label = element.find("[data-option=\"label\"]").val();
    item.Options.FieldName = element.find("[data-option=\"field-name\"]").val();
    item.Options.Required = element.find("[data-option=\"required\"]").is(":checked");
    
    if (item.Options.HasColumnSpan)
        item.Options.ColumnSpan = element.find("[data-option=\"column-span\"]").val();
    
    if (item.Options.HasRowSpan)
        item.Options.RowSpan = element.find("[data-option=\"row-span\"]").val();
    
    if (item.Options.HasRetrieveAction)
        item.Options.RetrieveAction = element.find("[data-option=\"retrieve-action\"]").val();
    
    if (item.Options.HasNewRecordAction)
        item.Options.NewRecordAction = element.find("[data-option=\"new-record-action\"]").val();
    
    if (item.Options.HasSaveAction)
        item.Options.SaveAction = element.find("[data-option=\"save-action\"]").val();
    
    if (item.Options.HasAutocompleteAction)
        item.Options.AutocompleteAction = element.find("[data-option=\"autocomplete-action\"]").val();
    
    if (item.Options.HasBrowseAction)
        item.Options.BrowseAction = element.find("[data-option=\"browse-action\"]").val();
    
    if (item.Options.HasLoadAction)
        item.Options.LoadAction = element.find("[data-option=\"load-action\"]").val();
}

function validate(item) {
    var errors = [];
    if (item.Options.Tooltip === null || item.Options.Tooltip.length === 0)
        errors.push("The tooltip can not be empty.");
    
    if (item.Options.Label === null || item.Options.Label.length === 0)
        errors.push("The label can not be empty.");
    
    if (item.Options.FieldName === null || item.Options.FieldName.length === 0)
        errors.push("The field name can not be empty.");
    
    if (item.Options.HasColumnSpan) {
        if (item.Options.ColumnSpan === null || item.Options.ColumnSpan.toString().length === 0)
            errors.push("The column span should have a value.");
        else {
            var colSpan = parseInt(item.Options.ColumnSpan.toString());
            if (colSpan > 4 && colspan < 0)
                errors.push("The column span should be between 0 and 4.");
        }
    }
    
    if (item.Options.HasRowSpan) {
        if (item.Options.RowSpan === null || item.Options.RowSpan.toString().length === 0)
            errors.push("The row span should have a value.");
        else {
            var rowSpan = parseInt(item.Options.RowSpan.toString());
            if (rowSpan > 5 && rowSpan < 0)
                errors.push("The row span should be between 0 and 5.");
        }
    }
    
    if (item.Options.HasRetrieveAction)
        if (item.Options.RetrieveAction === null || item.Options.RetrieveAction.length === 0)
            errors.push("Retrieve action can not be empty.");
    
    if (item.Options.HasNewRecordAction)
        if (item.Options.NewRecordAction === null || item.Options.NewRecordAction.length === 0)
            errors.push("New record action can not be empty.");
    
    if (item.Options.HasSaveAction)
        if (item.Options.SaveAction === null || item.Options.SaveAction.length === 0)
            errors.push("Save action can not be empty.");
    
    if (item.Options.HasAutocompleteAction)
        if (item.Options.AutocompleteAction === null || item.Options.AutocompleteAction.length === 0)
            errors.push("Autocomplete action can not be empty.");
    
    if (item.Options.HasBrowseAction)
        if (item.Options.BrowseAction === null || item.Options.BrowseAction.length === 0)
            errors.push("Browse action can not be empty.");
    
    if (item.Options.HasLoadAction)
        if (item.Options.LoadAction === null || item.Options.LoadAction.length === 0)
            errors.push("Load action can not be empty.");
    
    return errors;
}