$(document).ready(function () {
    $.ajax({
        type: "post",
        url: "http://localhost/SProject/AdminBildirimAjax",
        //timeout:3000,
        dataType: "json",
        data: {"tip": "adminBildirim"},
        success: function (cevap) {
            if (cevap.hata) {
                reset();
                alertify.alert(jsDil.Hata);
                return false;
            } else {
                if (cevap.Bildir) {
                    var ilkDeger = $("#bildirim > li > a").first().attr('data-id');
                    if (ilkDeger == undefined) {
                        ilkDeger = 0;
                    }
                    var length = cevap.Bildir.ID.length;
                    for (var i = 0; i < length; i++) {
                        if (cevap.Bildir.ID[i] > ilkDeger) {
                            if (cevap.Bildir.Okundu[i] != 1) {//okunmadı
                                $("#bildirim").append('<li style="background-color: #ddd"><a data-id="' + cevap.Bildir.ID[i] + '" href="http://localhost/SProject/adminweb/' + cevap.Bildir.Url[i] + '"><div class="notify-icon notify-icon-' + cevap.Bildir.Renk[i] + ' col-md-2"> <i class="' + cevap.Bildir.Icon[i] + '"></i></div><div class="notify col-md-10"><small>' + cevap.Bildir.Tarih[i] + '</small><p>' + cevap.Bildir.Text[i] + '</p></div></a></li>');
                            } else {
                                $("#bildirim").append('<li><a data-id="' + cevap.Bildir.ID[i] + '" href="http://localhost/SProject/adminweb/' + cevap.Bildir.Url[i] + '"><div class="notify-icon notify-icon-' + cevap.Bildir.Renk[i] + ' col-md-2"> <i class="' + cevap.Bildir.Icon[i] + '"></i></div><div class="notify col-md-10"><small>' + cevap.Bildir.Tarih[i] + '</small><p>' + cevap.Bildir.Text[i] + '</p></div></a></li>');
                            }
                        }
                    }
                    if (cevap.BildirCount > 0) {
                        $("#bildirimCount").text(cevap.BildirCount);
                    }
                } else {
                    var ilkDeger = $("#bildirim > li > a").first().attr('data-id');
                    if (ilkDeger == undefined) {
                        $("#bildirim").text(jsDil.BildirimYok);
                    }
                }
            }
        }
    });
    setInterval(function () {
        $.ajax({
            type: "post",
            url: "http://localhost/SProject/AdminBildirimAjax",
            //timeout:3000,
            dataType: "json",
            data: {"tip": "adminBildirim"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.Bildir) {
                        var ilkDeger = $("#bildirim > li > a").first().attr('data-id');
                        if (ilkDeger == undefined) {
                            ilkDeger = 0;
                        }
                        var length = cevap.Bildir.ID.length;
                        for (var i = 0; i < length; i++) {
                            if (cevap.Bildir.ID[i] > ilkDeger) {
                                if (cevap.Bildir.Okundu[i] != 1) {//okunmadı
                                    $("#bildirim").append('<li style="background-color: #ddd"><a data-id="' + cevap.Bildir.ID[i] + '" href="http://localhost/SProject/adminweb/' + cevap.Bildir.Url[i] + '"><div class="notify-icon notify-icon-' + cevap.Bildir.Renk[i] + ' col-md-2"> <i class="' + cevap.Bildir.Icon[i] + '"></i></div><div class="notify col-md-10"><small>' + cevap.Bildir.Tarih[i] + '</small><p>' + cevap.Bildir.Text[i] + '</p></div></a></li>');
                                } else {
                                    $("#bildirim").append('<li><a data-id="' + cevap.Bildir.ID[i] + '" href="http://localhost/SProject/adminweb/' + cevap.Bildir.Url[i] + '"><div class="notify-icon notify-icon-' + cevap.Bildir.Renk[i] + ' col-md-2"> <i class="' + cevap.Bildir.Icon[i] + '"></i></div><div class="notify col-md-10"><small>' + cevap.Bildir.Tarih[i] + '</small><p>' + cevap.Bildir.Text[i] + '</p></div></a></li>');
                                }
                            }
                        }
                        if (cevap.BildirCount > 0) {
                            $("#bildirimCount").text(cevap.BildirCount);
                        }
                    } else {
                        var ilkDeger = $("#bildirim > li > a").first().attr('data-id');
                        if (ilkDeger == undefined) {
                            $("#bildirim").text(jsDil.BildirimYok);
                        }
                    }
                }
            }
        });
    }, 300000000);
});


