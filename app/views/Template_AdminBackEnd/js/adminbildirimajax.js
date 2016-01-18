$(document).ready(function () {
    $.ajax({
        type: "post",
        url: SITE_URL + "AdminBildirimAjax",
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
                    if (length > 0) {
                        var str = jsDil.BildirimYok;
                        if (str) {
                            str = str.replace(jsDil.BildirimYok, "");
                        }
                    }
                    for (var i = 0; i < length; i++) {
                        var myDate = cevap.Bildir.Tarih[i].split(" ");
                        var myDate1 = myDate[0].split("-");
                        var newDate = myDate1[2] + '/' + myDate1[1] + '/' + myDate1[0];
                        if (cevap.Bildir.ID[i] > ilkDeger) {
                            if (cevap.Bildir.Okundu[i] != 1) {//okunmadı
                                $("#bildirim").append('<li style="background-color: #ddd"><a id="bildirimIsaret" data-id="' + cevap.Bildir.ID[i] + '" data-href="' + cevap.Bildir.Url[i] + '" href="' + SITE_URL + '"AdminWeb/' + cevap.Bildir.Url[i] + '"><div class="notify-icon notify-icon-' + cevap.Bildir.Renk[i] + ' col-md-2"> <i class="' + cevap.Bildir.Icon[i] + '"></i></div><div class="notify col-md-10"><small>' + newDate + '--' + myDate[1] + '</small><p>' + cevap.Bildir.Text[i] + '</p></div></a></li>');
                            } else {
                                $("#bildirim").append('<li><a id="bildirimIsaret" data-id="' + cevap.Bildir.ID[i] + '" data-href="' + cevap.Bildir.Url[i] + '" href=""' + SITE_URL + '"AdminWeb/' + cevap.Bildir.Url[i] + '"><div class="notify-icon notify-icon-' + cevap.Bildir.Renk[i] + ' col-md-2"> <i class="' + cevap.Bildir.Icon[i] + '"></i></div><div class="notify col-md-10"><small>' + newDate + '--' + myDate[1] + '</small><p>' + cevap.Bildir.Text[i] + '</p></div></a></li>');
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
            url: SITE_URL + "AdminBildirimAjax",
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
                        if (length > 0) {
                            var str = jsDil.BildirimYok;
                            if (str) {
                                str = str.replace(jsDil.BildirimYok, "");
                            }
                        }

                        for (var i = 0; i < length; i++) {
                            var myDate = cevap.Bildir.Tarih[i].split(" ");
                            var myDate1 = myDate[0].split("-");
                            var newDate = myDate1[2] + '/' + myDate1[1] + '/' + myDate1[0];
                            if (cevap.Bildir.ID[i] < ilkDeger) {
                                if (cevap.Bildir.Okundu[i] != 1) {//okunmadı
                                    $("#bildirim").append('<li style="background-color: #ddd"><a id="bildirimIsaret" data-href="' + cevap.Bildir.Url[i] + '" data-id="' + cevap.Bildir.ID[i] + '" href=""' + SITE_URL + '"AdminWeb/' + cevap.Bildir.Url[i] + '"><div class="notify-icon notify-icon-' + cevap.Bildir.Renk[i] + ' col-md-2"> <i class="' + cevap.Bildir.Icon[i] + '"></i></div><div class="notify col-md-10"><small>' + newDate + '--' + myDate[1] + '</small><p>' + cevap.Bildir.Text[i] + '</p></div></a></li>');
                                } else {
                                    $("#bildirim").append('<li><a id="bildirimIsaret" data-id="' + cevap.Bildir.ID[i] + '" data-href="' + cevap.Bildir.Url[i] + '"  href=""' + SITE_URL + '"AdminWeb/' + cevap.Bildir.Url[i] + '"><div class="notify-icon notify-icon-' + cevap.Bildir.Renk[i] + ' col-md-2"> <i class="' + cevap.Bildir.Icon[i] + '"></i></div><div class="notify col-md-10"><small>' + newDate + '--' + myDate[1] + '</small><p>' + cevap.Bildir.Text[i] + '</p></div></a></li>');
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
    }, 2000000);

    $(document).on("click", "#bildirimIsaret", function (e) {
        e.preventDefault();
        var ID = $(this).attr("data-id");
        $.ajax({
            type: "post",
            url: SITE_URL + "AdminBildirimAjax",
            //timeout:3000,
            dataType: "json",
            data: {"ID": ID, "tip": "adminOkundu"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    var length = $('ul#bildirim li').length;
                    var href;
                    for (var t = 0; t < length; t++) {
                        var attrValueId = $("ul#bildirim >li > a").eq(t).attr('data-id');
                        if (attrValueId == ID) {
                            $('ul#bildirim >li').eq(t).css({"background-color": "#fff"});
                            href = $("ul#bildirim >li > a").eq(t).attr('data-href');
                        }
                    }
                    window.location.href = (SITE_URL + 'AdminWeb/' + href);
                }
            }
        });
    });

    $(document).on("click", "#bildirimTikla", function (e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: SITE_URL + "AdminBildirimAjax",
            //timeout:3000,
            dataType: "json",
            data: {"tip": "adminGoruldu"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    $("#bildirimCount").text("");
                }
            }
        });
    });

    $(document).on("click", "#tumunuOkundu", function (e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: SITE_URL + "AdminBildirimAjax",
            //timeout:3000,
            dataType: "json",
            data: {"tip": "tumunuOkundu"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    var length = $('ul#bildirim li').length;
                    for (var t = 0; t < length; t++) {
                        $('ul#bildirim >li').eq(t).css({"background-color": "#fff"});
                    }
                }
            }
        });
    });

    $(document).on("click", "#tumunuGoster", function (e) {
        e.preventDefault();
        window.location.href = (SITE_URL + 'AdminWeb/tumbildirimliste');
    });

    $("#bildirim").scroll(function () {
        var sonDeger = $("#bildirim > li:last >a").attr('data-id');
        $('div#loadmoreajaxloader').show();
        $('div#loadmoreajaxloaderText').hide();
        if ($("#bildirim").scrollTop() + $("#bildirim").height() == $("#bildirim")[0].scrollHeight) {
            $.ajax({
                type: "post",
                url: SITE_URL + "AdminBildirimAjax",
                //timeout:3000,
                dataType: "json",
                data: {"sonDeger": sonDeger, "tip": "loaderDocument"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.Bildir) {
                            var length = cevap.Bildir.ID.length;
                            for (var i = 0; i < length; i++) {
                                var myDate = cevap.Bildir.Tarih[i].split(" ");
                                var myDate1 = myDate[0].split("-");
                                var newDate = myDate1[2] + '/' + myDate1[1] + '/' + myDate1[0];
                                if (cevap.Bildir.Okundu[i] != 1) {//okunmadı
                                    $("#bildirim").append('<li style="background-color: #ddd"><a id="bildirimIsaret" data-id="' + cevap.Bildir.ID[i] + '" data-href="' + cevap.Bildir.Url[i] + '" href="' + SITE_URL + '"AdminWeb/' + cevap.Bildir.Url[i] + '"><div class="notify-icon notify-icon-' + cevap.Bildir.Renk[i] + ' col-md-2"> <i class="' + cevap.Bildir.Icon[i] + '"></i></div><div class="notify col-md-10"><small>' + newDate + '--' + myDate[1] + '</small><p>' + cevap.Bildir.Text[i] + '</p></div></a></li>');
                                } else {
                                    $("#bildirim").append('<li><a id="bildirimIsaret" data-id="' + cevap.Bildir.ID[i] + '" data-href="' + cevap.Bildir.Url[i] + '" href="' + SITE_URL + '"AdminWeb/' + cevap.Bildir.Url[i] + '"><div class="notify-icon notify-icon-' + cevap.Bildir.Renk[i] + ' col-md-2"> <i class="' + cevap.Bildir.Icon[i] + '"></i></div><div class="notify col-md-10"><small>' + newDate + '--' + myDate[1] + '</small><p>' + cevap.Bildir.Text[i] + '</p></div></a></li>');
                                }
                            }
                            $('div#loadmoreajaxloader').hide();
                            if (cevap.BildirCount > 0) {
                                $("#bildirimCount").text(cevap.BildirCount);
                            }
                        } else {

                            $('div#loadmoreajaxloader').hide();
                            $('div#loadmoreajaxloaderText').show();
                        }
                    }
                }
            });
        } else {
            $('div#loadmoreajaxloader').hide();
            $('div#loadmoreajaxloaderText').hide();
        }
    });
});


