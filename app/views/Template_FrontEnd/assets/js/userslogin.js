$(document).ready(function () {
    var loginDeger = $("#sonucDeger").val();
    if (loginDeger != "undefined") {//front
        if (loginDeger != "") {//front
            reset();
            alertify.alert(loginDeger);
            return false;
        }
    }
});
 