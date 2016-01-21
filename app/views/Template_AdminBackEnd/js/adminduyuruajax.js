$(document).ready(function () {

    $.ajax({
        type: "post",
        url: SITE_URL + "AdminDuyuruAjax",
        //timeout:3000,
        dataType: "json",
        data: {"tip": "adminDuyuru"},
        success: function (cevap) {
            if (cevap.hata) {
                reset();
                alertify.alert(jsDil.Hata);
                return false;
            } else {
                if (cevap.Duyur) {
                    var ilkDeger = $("#duyuru > li > a").first().attr('data-id');
                    if (ilkDeger == undefined) {
                        ilkDeger = 0;
                    }
                    var length = cevap.Duyur.ID.length;
                    if (length > 0) {
                        var str = jsDil.DuyuruYok;
                        if (str) {
                            str = str.replace(jsDil.DuyuruYok, "");
                        }
                    }
                    for (var i = 0; i < length; i++) {
                        var myDate = cevap.Duyur.Tarih[i].split(" ");
                        var myDate1 = myDate[0].split("-");
                        var newDate = myDate1[2] + '/' + myDate1[1] + '/' + myDate1[0];
                        if (cevap.Duyur.ID[i] > ilkDeger) {
                            if (cevap.Duyur.Okundu[i] != 1) {//okunmadı
                                $("#duyuru").append('<li style="background-color: #ddd"><a id="duyuruIsaret" data-id="' + cevap.Duyur.ID[i] + '" href="' + SITE_URL + '"AdminWeb/duyuruliste"><div class="notify-icon notify-icon-success col-md-2"> <i class="fa fa-bullhorn"></i></div><div class="notify col-md-10"><small>' + newDate + '--' + myDate[1] + '</small><p>' + cevap.Duyur.Text[i] + '</p></div></a></li>');
                            } else {
                                $("#duyuru").append('<li><a id="duyuruIsaret" data-id="' + cevap.Duyur.ID[i] + '"  href="' + SITE_URL + '"AdminWeb/duyuruliste"><div class="notify-icon notify-icon-success col-md-2"> <i class="fa fa-bullhorn"></i></div><div class="notify col-md-10"><small>' + newDate + '--' + myDate[1] + '</small><p>' + cevap.Duyur.Text[i] + '</p></div></a></li>');
                            }
                        }
                    }
                    if (cevap.DuyurCount > 0) {
                        $("#duyuruCount").text(cevap.DuyurCount);
                    }
                } else {
                    var ilkDeger = $("#duyuru > li > a").first().attr('data-id');
                    if (ilkDeger == undefined) {
                        $("#duyuru").text(jsDil.DuyuruYok);
                    }
                }
            }
        }
    });

    setInterval(function () {
        $.ajax({
            type: "post",
            url: SITE_URL + "AdminDuyuruAjax",
            //timeout:3000,
            dataType: "json",
            data: {"tip": "adminDuyuru"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.Duyur) {
                        var ilkDeger = $("#duyuru > li > a").first().attr('data-id');
                        if (ilkDeger == undefined) {
                            ilkDeger = 0;
                        }
                        var length = cevap.Duyur.ID.length;
                        if (length > 0) {
                            var str = jsDil.DuyuruYok;
                            if (str) {
                                str = str.replace(jsDil.DuyuruYok, "");
                            }
                        }
                        for (var i = 0; i < length; i++) {
                            var myDate = cevap.Duyur.Tarih[i].split(" ");
                            var myDate1 = myDate[0].split("-");
                            var newDate = myDate1[2] + '/' + myDate1[1] + '/' + myDate1[0];
                            if (cevap.Duyur.ID[i] > ilkDeger) {
                                if (cevap.Duyur.Okundu[i] != 1) {//okunmadı
                                    $("#duyuru").append('<li style="background-color: #ddd"><a id="duyuruIsaret" data-id="' + cevap.Duyur.ID[i] + '" href="' + SITE_URL + '"AdminWeb/duyuruliste"><div class="notify-icon notify-icon-success col-md-2"> <i class="fa fa-bullhorn"></i></div><div class="notify col-md-10"><small>' + newDate + '--' + myDate[1] + '</small><p>' + cevap.Duyur.Text[i] + '</p></div></a></li>');
                                } else {
                                    $("#duyuru").append('<li><a id="duyuruIsaret" data-id="' + cevap.Duyur.ID[i] + '"  href="' + SITE_URL + '"AdminWeb/duyuruliste"><div class="notify-icon notify-icon-success col-md-2"> <i class="fa fa-bullhorn"></i></div><div class="notify col-md-10"><small>' + newDate + '--' + myDate[1] + '</small><p>' + cevap.Duyur.Text[i] + '</p></div></a></li>');
                                }
                            }
                        }
                        if (cevap.DuyurCount > 0) {
                            $("#duyuruCount").text(cevap.DuyurCount);
                        }
                    } else {
                        var ilkDeger = $("#duyuru > li > a").first().attr('data-id');
                        if (ilkDeger == undefined) {
                            $("#duyuru").text(jsDil.DuyuruYok);
                        }
                    }
                }
            }
        });
    }, 2000000);

    $(document).on("click", "#duyuruIsaret", function (e) {
        e.preventDefault();
        var ID = $(this).attr("data-id");
        $.ajax({
            type: "post",
            url: SITE_URL + "AdminDuyuruAjax",
            //timeout:3000,
            dataType: "json",
            data: {"ID": ID, "tip": "adminOkundu"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    var length = $('ul#duyuru li').length;
                    var href;
                    for (var t = 0; t < length; t++) {
                        var attrValueId = $("ul#duyuru >li > a").eq(t).attr('data-id');
                        if (attrValueId == ID) {
                            $('ul#duyuru >li').eq(t).css({"background-color": "#fff"});
                            href = $("ul#duyuru >li > a").eq(t).attr('data-href');
                        }
                    }
                    window.location.href = (SITE_URL + 'AdminWeb/duyuruliste');
                }
            }
        });
    });

    $(document).on("click", "#duyuruTikla", function (e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: SITE_URL + "AdminDuyuruAjax",
            //timeout:3000,
            dataType: "json",
            data: {"tip": "adminGoruldu"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    $("#duyuruCount").text("");
                }
            }
        });
    });

    $(document).on("click", "#tumunuDuyuruOkundu", function (e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: SITE_URL + "AdminDuyuruAjax",
            //timeout:3000,
            dataType: "json",
            data: {"tip": "tumunuOkundu"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    $("#duyuruMenu").addClass("open");
                    var length = $('ul#duyuru li').length;
                    for (var t = 0; t < length; t++) {
                        $('ul#duyuru >li').eq(t).css({"background-color": "#fff"});
                    }
                }
            }
        });
    });

    $(document).on("click", "#tumunuGosterDuyuru", function (e) {
        e.preventDefault();
        window.location.href = (SITE_URL + 'AdminWeb/duyuruliste');
    });

    $("#duyuru").scroll(function () {
        var sonDeger = $("#duyuru > li:last >a").attr('data-id');
        $('div#duyuruloadmoreajaxloader').show();
        $('div#duyuruloadmoreajaxloaderText').hide();
        if ($("#duyuru").scrollTop() + $("#duyuru").height() == $("#duyuru")[0].scrollHeight) {
            $.ajax({
                type: "post",
                url: SITE_URL + "AdminDuyuruAjax",
                //timeout:3000,
                dataType: "json",
                data: {"sonDeger": sonDeger, "tip": "loaderDocument"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.Duyur) {
                            var length = cevap.Duyur.ID.length;
                            for (var i = 0; i < length; i++) {
                                var myDate = cevap.Duyur.Tarih[i].split(" ");
                                var myDate1 = myDate[0].split("-");
                                var newDate = myDate1[2] + '/' + myDate1[1] + '/' + myDate1[0];
                                if (cevap.Duyur.Okundu[i] != 1) {//okunmadı
                                    $("#duyuru").append('<li style="background-color: #ddd"><a id="duyuruIsaret" data-id="' + cevap.Duyur.ID[i] + '" href="' + SITE_URL + '"AdminWeb/duyuruliste"><div class="notify-icon notify-icon-success col-md-2"> <i class="fa fa-bullhorn"></i></div><div class="notify col-md-10"><small>' + newDate + '--' + myDate[1] + '</small><p>' + cevap.Duyur.Text[i] + '</p></div></a></li>');
                                } else {
                                    $("#duyuru").append('<li><a id="duyuruIsaret" data-id="' + cevap.Duyur.ID[i] + '"  href="' + SITE_URL + '"AdminWeb/duyuruliste"><div class="notify-icon notify-icon-success col-md-2"> <i class="fa fa-bullhorn"></i></div><div class="notify col-md-10"><small>' + newDate + '--' + myDate[1] + '</small><p>' + cevap.Duyur.Text[i] + '</p></div></a></li>');
                                }
                            }
                            $('div#duyuruloadmoreajaxloader').hide();
                            if (cevap.DuyurCount > 0) {
                                $("#duyuruCount").text(cevap.DuyurCount);
                            }
                        } else {

                            $('div#duyuruloadmoreajaxloader').hide();
                            $('div#duyuruloadmoreajaxloaderText').show();
                        }
                    }
                }
            });
        } else {
            $('div#duyuruloadmoreajaxloader').hide();
            $('div#duyuruloadmoreajaxloaderText').hide();
        }
    });
});


