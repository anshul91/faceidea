function validate_user_ajx() {

    $.ajax({
        url: BASE_URL + "adminUsers/validate_login", // json datasource
        type: "post", // method  , by default get
        data: $("#frm_login").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $(".loader").css("display", "block");
            $("#validation_msg").text("");
        },
        success: function (data) {
            if (typeof data == 'object') {
                if (data.status == 1) {					
                    showDismissableAlert(data.msg, data.msg_type, 'validation_msg');
					window.location.href = data.resp_url;
                }
                $("[name='csrf_token_name']").attr('value', data.csrf_token_name);
                showDismissableAlert(data.msg, data.msg_type, 'validation_msg');
                
            } else {
                showDismissableAlert("Invalid Response found", 'error', 'validation_msg');
            }
        },
        complete: function () {
            $(".loader").css("display", "none");
        },
        error: function (data) {
            console.log("Error: " + data);
        }
    });
}

function register_firm_ajx() {

    $.ajax({
        url: BASE_URL + "adminUsers/register_firm", // json datasource
        type: "post", // method  , by default get
        data: $("#frm_register").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $(".loader").css("display", "block");
            $("#validation_msg").text("");
        },
        success: function (data) {
            if (typeof data == 'object') {

                if (data.status == 1) {
                    showDismissableAlert(data.msg, data.msg_type, 'validation_msg');
                    return;
                }
//                $("[name='csrf_token_name']").attr('value', data.csrf_token_name);
                showDismissableAlert(data.msg, data.msg_type, 'validation_msg');
                $("#firm_name").focus();
            } else {
                showDismissableAlert("Invalid Response found", 'error', 'validation_msg');
            }
        },
        complete: function () {
            $(".loader").css("display", "none");
        },
        error: function (data) {
            console.log("Error: " + JSON.stringify(data));
        }
    });
}

function verify_link_ajx() {

    $.ajax({
        url: BASE_URL + "adminUsers/verify_link", // json datasource
        type: "post", // method  , by default get
        data: {'csrf_token_name': $("#csrf_token_name").val()},
        dataType: 'json',
        success: function (data) {
            if (typeof data == 'object') {
                if (data.status == 1) {
                    showDismissableAlert(data.msg, data.msg_type, 'response_div');

                }
                $("[name='csrf_token_name']").attr('value', data.csrf_token_name);
                showDismissableAlert(data.msg, data.msg_type, 'response_div');
            } else {
                showDismissableAlert("Invalid Response found", 'error', 'response_div');
            }
        },
        error: function (data) {
            console.log("Error: " + JSON.stringify(data));
        }
    });
}

function update_firm_detail(){
	 // Create an FormData object 
        var formData =$("#frm_firm_detail").submit(function(e){
            return ;
        });
      //formData[0] contain form data only 
      // You can directly make object via using form id but it require all ajax operation inside $("form").submit(<!-- Ajax Here   -->)
        var formData = new FormData(formData[0]);  
    $.ajax({
        url: BASE_URL + "adminUsers/update_firm_detail", // json datasource
        type: "post", // method  , by default get
        data: formData,
        dataType: 'json',
		mimeType:"multipart/form-data",
		contentType: false,
        cache: false,
        processData:false,
        success: function (data) {
            if (typeof data == 'object') {                
				showDismissableAlert(data.msg, data.msg_type, 'response_div');   
				
				if(data.logo!=='' && data.logo != undefined){
					$(".logo_div").attr("src",BASE_URL+"assets/img/"+data.logo);
					// $("#firm_logo_div").attr("src",BASE_URL+"assets/img/"+data.logo);
				}
                
                
            } else {
                showDismissableAlert("Invalid Response found", 'error', 'response_div');
            }
			
				$('html, body').animate({
					scrollTop: $(".page-wrapper").offset().top
				}, 2000);
			$("[name='csrf_token_name']").attr('value', data.csrf_token_name);
        },
        error: function (data) {
			
                showDismissableAlert("Something Unexpected Happened! Try Again Later!", 'error', 'response_div');
            console.log("Error: " + JSON.stringify(data));
        }
    });
}