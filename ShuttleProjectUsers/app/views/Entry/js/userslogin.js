$(document).ready(function () {
    $("#loginForm").validate({
        rules: {
            usersloginkadi: {
                required: true
            },
            usersloginsifre: {
                required: true
            },
            loginselected: {
                selectcheck: true
            }
        }
    });

    jQuery.validator.addMethod('selectcheck', function (value) {
        return (value != '0');
    }, "Kullanıcı Türü Seçimi gereklidir.");
});