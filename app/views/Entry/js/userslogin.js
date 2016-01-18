$.ajaxSetup({
    type: "post",
    url: SITE_URL + "Language",
    //timeout:3000,
    dataType: "json",
    error: function (a, b) {
        if (b == "timeout")
            alert("Ajax İsteği Zaman Aşımına Uğradı");
    },
    statusCode: {
        404: function () {
            alert("Ajax dosyası bulunamadı");
        }
    }
});
$(document).ready(function () {

    $("select#kullaniciLanguage").change(function () {
        var lang = $(this).val();
        $.ajax({
            data: {"lang": lang},
            success: function (cevap) {
                if (cevap.hata) {
                    //alert(cevap.hata);
                } else {
                    window.location.reload();
                }
            }
        });
    });

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

    var loginDeger = $("#sonucDeger").val();
    if (loginDeger != undefined) {//front
        if (loginDeger != "") {
            reset();
            alertify.alert(loginDeger);
            return false;
        }
    }

});
 