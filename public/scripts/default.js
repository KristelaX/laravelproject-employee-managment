window.onload = function () {
    initNumberInputs();
};

function showMessage() {
    $panel = $('<div></div>')
            .addClass('alert')
            .addClass('alert-danger')
            .addClass('floating')
            .html('Rekordi eshte fshire.');
    $('#page-wrapper').append($panel);
    $panel.fadeIn(400);
    setTimeout(
            function () {
                $panel.fadeOut(400);
            },
            4000
            );
}

function initNumberInputs() {
    $('.number_input').autoNumeric('init', {vMin: "0.00", vMax: "99999999999999999.99"});
    $('.negative_input').autoNumeric('init', {vMin: "-99999999999999999.99", vMax: "99999999999999999.99"});
}

function handleRowDelete(row, data, dataIndex, callback) {
    $(row).find('.dataTable_delete').click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        bootbox.confirm("Jeni i sigurt qe deshironi ta fshini kete rekord?", function (result) {
            if (result)
            {
                var $url_deleted = $(row).find('.dataTable_delete').attr("href");
                $.ajax({
                    url: $url_deleted,
                    type: 'POST',
                    contentType: "application/json; charset=UTF-8",
                    dataType: "json",
                    traditional: true,
                    success: function (response) {
                        showMessage();
                       
                    },
                    complete: function (response) {
                        $(row).rowslide(function () {
                       /*  table.fnDeleteRow(row);*/
                       });
                       if (callback && typeof callback == 'function')
                           callback();
                    }
                });
            }
        });
    });
}
function invoiceDelete(row, data, dataIndex, callback) {
    $(row).find('.dataTable_delete').click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        bootbox.confirm("Jeni i sigurt qe deshironi ta fshini kete rekord?", function (result) {
            if (result)
            {
                var $url_deleted = $(row).find('.dataTable_delete').attr("href");
                $.ajax({
                    url: $url_deleted,
                    type: 'POST',
                    contentType: "application/json; charset=UTF-8",
                    dataType: "json",
                    traditional: true,
                    success: function (response) {
                        if(response.is_successfull) { 
							console.log("response.is_successfull"+response.is_successfull);
                            showMessage();
                            $(row).rowslide(function () {
                            /*  table.fnDeleteRow(row);*/
                            });
                            if (callback && typeof callback == 'function')
                                callback();
                        } else {
							bootbox.alert(response.message);
                        }
                    }
                });
            }
        });
    });
}
