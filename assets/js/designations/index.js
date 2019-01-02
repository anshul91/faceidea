setTimeout(function(){
$(document).ready(function () {    
	showDesignation('csrf_token_name', $("#csrf_token_hash").val());	
});
},100);


function render_edit_designation(designation_id){
	var sendData = [];
	sendData = {
            'designation_id': designation_id,
        };
    sendData['csrf_token_name'] = $("#csrf_token_hash").val();
	
	$.ajax({
        url: BASE_URL + "AdminDesignations/render_edit_designation", // json datasource
        type: "post", // method  , by default get
        data: sendData,
        dataType: 'json',
        beforeSend: function () {
            $(".loader").css("display", "block");
            $("#validation_msg_edit").text("");
        },
        success: function (data) {
            if (typeof data == 'object') {
                if (data.status == 1) {
					$.each(data.resp,function(i,v){
						$("#"+i+"_edit").val(v);
					});
                }
                $("[name='csrf_token_name']").attr('value', data.csrf_token_name);
            } else {
                showDismissableAlert("Invalid Response found", 'error', 'validation_msg_edit');
            }
        },
        complete: function () {
            $(".loader").css("display", "none");
        },
        error: function (data) {
            showDismissableAlert("Something Unexpected Happened! Try Later", 'error', 'validation_msg_edit');
            console.log("Error: " + JSON.stringify(data));
        }
    });
}

function showDesignation(csrfname, csrfhash) {
    var sendData = [];
    sendData[csrfname] = csrfhash;
    $("#designations").dataTable().fnDestroy();
    var dataTable = $('#designations').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "scrollY": 250,
        "lengthMenu": [[10, 25, 50, 1000000], [10, 25, 50, "All"]],
        "ajax": {
            url: BASE_URL + "AdminDesignations/get_designations_list", // json datasource
            type: "post", // method  , by default get
//                asyc: false,
            data: sendData,
            error: function () {  // error handling
                $.fn.dataTable.ext.errMode = 'throw';
                $(".projectList").html("");
                $("#projectList").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found on server</th></tr></tbody>');
                $("#projectList").css("display", "none");
            },
        }, "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            var info = $(this).DataTable().page.info();
            $("td:nth-child(1)", nRow).html(info.start + iDisplayIndex + 1);
            return nRow;
        }
    });

//    }
}

function add_designation() {
    $.ajax({
        url: BASE_URL + "AdminDesignations/add_designation", // json datasource
        type: "post", // method  , by default get
        data: $("#frm_add_designation").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $(".loader").css("display", "block");
            $("#validation_msg").text("");
        },
        success: function (data) {
            if (typeof data == 'object') {
                if (data.status == 1) {
                    showDismissableAlert(data.msg, data.msg_type, 'validation_msg');
                }
                $("[name='csrf_token_name']").attr('value', data.csrf_token_name);
                showDismissableAlert(data.msg, data.msg_type, 'validation_msg');
            } else {
                showDismissableAlert("Invalid Response found", 'error', 'validation_msg');
            }
        },
        complete: function () {
            $(".loader").css("display", "none");
			showDesignation('csrf_token_name', $("#csrf_token_hash").val()) ;
        },
        error: function (data) {
            showDismissableAlert("Something Unexpected Happened! Try Later", 'error', 'validation_msg');
            console.log("Error: " + JSON.stringify(data));
        }
    });
}


function edit_designation() {
    $.ajax({
        url: BASE_URL + "AdminDesignations/edit_designation", // json datasource
        type: "post", // method  , by default get
        data: $("#frm_edit_designation").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $(".loader").css("display", "block");
            $("#validation_msg_edit").text("");
        },
        success: function (data) {
            if (typeof data == 'object') {
                if (data.status == 1) {
                    showDismissableAlert(data.msg, data.msg_type, 'validation_msg_edit');
					
                }
                $("[name='csrf_token_name']").attr('value', data.csrf_token_name);
                showDismissableAlert(data.msg, data.msg_type, 'validation_msg_edit');
            } else {
                showDismissableAlert("Invalid Response found", 'error', 'validation_msg_edit');
            }
        },
        complete: function () {
            $(".loader").css("display", "none");
			showDesignation('csrf_token_name', $("#csrf_token_hash").val()) ;
        },
        error: function (data) {
            showDismissableAlert("Something Unexpected Happened! Try Later", 'error', 'validation_msg_edit');
            console.log("Error: " + JSON.stringify(data));
        }
    });
}
function delete_designation(designation_id) {
	var sendData = [];
	sendData = {
            'designation_id': designation_id,
        };
    sendData['csrf_token_name'] = $("#csrf_token_hash").val();
	
    $.ajax({
        url: BASE_URL + "AdminDesignations/delete_designation", // json datasource
        type: "post", // method  , by default get
        data: sendData,
        dataType: 'json',
        beforeSend: function () {
            $(".loader").css("display", "block");
            $("#validation_msg_edit").text("");
        },
        success: function (data) {
            if (typeof data == 'object') {
                if (data.status == 1) {
                    showDismissableAlert(data.msg, data.msg_type, 'validation_msg_edit');
					
                }
                $("[name='csrf_token_name']").attr('value', data.csrf_token_name);
                showDismissableAlert(data.msg, data.msg_type, 'validation_msg_edit');
            } else {
                showDismissableAlert("Invalid Response found", 'error', 'validation_msg_edit');
            }
			showDesignation('csrf_token_name', $("#csrf_token_hash").val()) ;
        },
        complete: function () {
            $(".loader").css("display", "none");
        },
        error: function (data) {
            showDismissableAlert("Something Unexpected Happened! Try Later", 'error', 'validation_msg_edit');
            console.log("Error: " + JSON.stringify(data));
        }
    });
}


