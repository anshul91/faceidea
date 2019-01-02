var path_arr = window.location.pathname.split("/");
var BASE_URL = window.location.origin + "/" + path_arr[1] + "/"+ path_arr[2] + "/";



function onlyAlphabets(e, t) {
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        } else if (e) {
            var charCode = e.which;
        } else {
            return true;
        }
        if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 32)
            return true;
        else
            return false;
    } catch (err) {
        alert(err.Description);
    }
}

function showDismissableAlert(msg, msgType, divId) {
    var heading = "Success";

    if (msgType == '') {
        msgType = 'success';
        heading = 'Success';
    } else {
        msgType = msgType.toLowerCase();

        if (msgType == 'error') {
            msgType = 'danger';
            heading = "Error";
        }
        if (msgType == 'info') {
            msgType = 'info';
            heading = 'Info';
        }
    }

    $("#" + divId).show().css("opacity", "1");
    $("#" + divId).html("<div class='alert alert-" + msgType + "'><strong>" + heading + ": </strong> " + msg + "</div>");
    window.setTimeout(function () {
        $("#" + divId).fadeTo(500, 0).slideUp(500, function () {
            $('.alert alert-' + msgType).remove();
        });
    }, 100000);
    return;
}

/****************Fancy Alert Popup*****************
 * 
 * @param {text} msg
 * @param {text} msgType
 * @returns {Boolean}
 */

function fancyAlert(msg, msgType) {
    var msgColor = "red";
    if (msg === '') {
        return false;
    }
    if (typeof (msgType) === "string" && msgType.toLowerCase() === "success") {
        msgType = "Success";
        msgColor = "green";
        icons = 'fa fa-smile-o';
//        icons = 'fa fa-check-circle';
    } else if (msgType.toLowerCase() === 'error') {
        msgType = "Error";
        msgColor = "red";
//        icons = "fa fa-exclamation-circle";
        icons = "fa fa-frown-o";
    } else if (msgType.toLowerCase() === "info") {
        msgType = "Info";
        msgColor = "blue";
        icons = 'fa fa-info-circle';
    } else if (msgType.toLowerCase() === 'warning') {
        msgType = "Warning";
        msgColor = "orange";
        icons = 'fa fa-exclamation-triangle';

    }
    else {
        msgType = "error";
        msgColor = "red";
        icons = "fa fa-exclamation-circle";
    }
    $.alert({
        theme: 'modern',
        icon: icons,
        title: msgType,
        content: msg,
        draggable: true,
        type: msgColor,
        typeAnimated: true
    });
//    return;
}


 