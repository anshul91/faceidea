setTimeout(function(){
$(document).ready(function () {    
	showDepartments('csrf_token_name', $("#csrf_token_hash").val());	
});
},100);


function render_edit_department(department_id){
	var sendData = [];
	sendData = {
            'department_id': department_id,
        };
    sendData['csrf_token_name'] = $("#csrf_token_hash").val();
	
	$.ajax({
        url: BASE_URL + "AdminDepartments/render_edit_department", // json datasource
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

function showDepartments(csrfname, csrfhash) {
    var sendData = [];
    sendData[csrfname] = csrfhash;
    $("#departments").dataTable().fnDestroy();
    var dataTable = $('#departments').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "scrollY": 250,
        "lengthMenu": [[10, 25, 50, 1000000], [10, 25, 50, "All"]],
        "ajax": {
            url: BASE_URL + "AdminDepartments/get_department_list", // json datasource
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

function add_department() {
    $.ajax({
        url: BASE_URL + "AdminDepartments/add_department", // json datasource
        type: "post", // method  , by default get
        data: $("#frm_add_department").serialize(),
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
			showDepartments('csrf_token_name', $("#csrf_token_hash").val());
        },
        error: function (data) {
            showDismissableAlert("Something Unexpected Happened! Try Later", 'error', 'validation_msg');
            console.log("Error: " + JSON.stringify(data));
        }
    });
}



function edit_department() {
    $.ajax({
        url: BASE_URL + "AdminDepartments/edit_department", // json datasource
        type: "post", // method  , by default get
        data: $("#frm_edit_department").serialize(),
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
			showDepartments('csrf_token_name', $("#csrf_token_hash").val());
        },
        error: function (data) {
            showDismissableAlert("Something Unexpected Happened! Try Later", 'error', 'validation_msg_edit');
            console.log("Error: " + JSON.stringify(data));
        }
    });
}
function delete_department(department_id) {
	var sendData = [];
	sendData = {
            'department_id': department_id,
        };
    sendData['csrf_token_name'] = $("#csrf_token_hash").val();
	
    $.ajax({
        url: BASE_URL + "AdminDepartments/delete_department", // json datasource
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
			
        },
        complete: function () {
            $(".loader").css("display", "none");
			showDepartments('csrf_token_name', $("#csrf_token_hash").val());
        },
        error: function (data) {
            showDismissableAlert("Something Unexpected Happened! Try Later", 'error', 'validation_msg_edit');
            console.log("Error: " + JSON.stringify(data));
        }
    });
}
