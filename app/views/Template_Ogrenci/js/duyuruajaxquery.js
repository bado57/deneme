var SITE_URL = "http://192.168.1.30/SProject/";
$.ajaxSetup({
    type: "post",
    url: SITE_URL + "OgrenciMobilDuyuruAjax",
    //timeout:3000,
    dataType: "json",
    error: function (a, b) {
        if (b == "timeout")
            ons.notification.alert({message: jsDil.InternetBaglanti});
        return false;
    },
    statusCode: {
        404: function () {
            ons.notification.alert({message: jsDil.InternetBaglanti});
            return false;
        }
    }
});
var veli = new Array();
var veliID = new Array();
var yonetici = new Array();
var yoneticiID = new Array();
var duyuruayarDeger;
ons.ready(function () {
    duyuruNavigator.on('prepush', function (event) {
        modal.show();
    });
    $(document).on('pageinit', '#duyuruyolcu', function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"ogr_id": ogr_id, "firma_id": firma_id,
                "lang": lang, "tip": "ogrDuyuruYolcu"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    $("input[name=ogrAd]").val(cevap.Ogr);
                    if (cevap.Yolcu != "") {
                        $("#veliHeader").show();
                        $("#veliList").show();
                        $("#veliChechk").show();
                        var velilength = cevap.Yolcu.length;
                        var onsList = $("#veliList");
                        $("#veliToplam").text(velilength);
                        for (var a = 0; a < velilength; a++) {
                            var elm = $('<ons-list-item modifier="tappable">'
                                    + '<label class="checkbox checkbox--noborder checkbox--list-item">'
                                    + '<input data-tip="0" type="checkbox" checked="checked" value="' + cevap.Yolcu[a].Id + '">'
                                    + '<div class="checkbox__checkmark checkbox--noborder__checkmark checkbox--list-item__checkmark"></div>'
                                    + cevap.Yolcu[a].Ad + '</label></ons-list-item>');
                            elm.appendTo(onsList);
                            ons.compile(elm[0]);
                        }

                        var yoneticilength = cevap.Yonet.length;
                        var onsListY = $("#yoneticiList");
                        $("#yoneticiToplam").text(yoneticilength);
                        $("#yoneticiHeader").show();
                        $("#yoneticiList").show();
                        $("#yoneticiChechk").show();
                        for (var c = 0; c < yoneticilength; c++) {
                            var elmy = $('<ons-list-item modifier="tappable">'
                                    + '<label class="checkbox checkbox--noborder checkbox--list-item">'
                                    + '<input type="checkbox" checked="checked"  value="' + cevap.Yonet[c].Id + '">'
                                    + '<div class="checkbox__checkmark checkbox--noborder__checkmark checkbox--list-item__checkmark"></div>'
                                    + cevap.Yonet[c].Ad + ' ' + cevap.Yonet[c].Soyad + '</label></ons-list-item>');
                            elmy.appendTo(onsListY);
                            ons.compile(elmy[0]);
                        }
                        $("#duyuruYzbtn").show();
                    } else {
                        var yoneticilength = cevap.Yonet.length;
                        var onsListY = $("#yoneticiList");
                        $("#yoneticiToplam").text(yoneticilength);
                        $("#yoneticiHeader").show();
                        $("#yoneticiList").show();
                        $("#yoneticiChechk").show();
                        for (var c = 0; c < yoneticilength; c++) {
                            var elmy = $('<ons-list-item modifier="tappable">'
                                    + '<label class="checkbox checkbox--noborder checkbox--list-item">'
                                    + '<input type="checkbox" checked="checked"  value="' + cevap.Yonet[c].Id + '">'
                                    + '<div class="checkbox__checkmark checkbox--noborder__checkmark checkbox--list-item__checkmark"></div>'
                                    + cevap.Yonet[c].Ad + ' ' + cevap.Yonet[c].Soyad + '</label></ons-list-item>');
                            elmy.appendTo(onsListY);
                            ons.compile(elmy[0]);
                        }
                        $("#duyuruYzbtn").show();
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#duyurugonder', function () {
        var toplamKisi = veli.length + yonetici.length;
        if (toplamKisi > 0) {
            $("input[name=toplamKisi]").val(toplamKisi + ' ' + jsDil.Kisi);
        }
    });
    $(document).on('pageinit', '#duyurugecmis', function () {
        modal.hide();
    });
    $(document).on('pageinit', '#gelenduyuru', function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"firma_id": firma_id, "ogr_id": ogr_id,
                "lang": lang, "tip": "duyuruGelen"},
            success: function (cevap) {
                if (cevap.hata) {
                    modal.hide();
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    if (cevap.GelenDuyuru[0]) {
                        var lengthduyuru = cevap.GelenDuyuru[0].length;
                        var onsListD = $("#gelenduyuruList");
                        for (var d = 0; d < lengthduyuru; d++) {
                            var myDate = cevap.GelenDuyuru[0][d].Tarih.split(" ");
                            var myDate1 = myDate[0].split("-");
                            var newDate = myDate1[2] + '/' + myDate1[1] + '/' + myDate1[0];
                            if (cevap.GelenDuyuru[0][d].Okundu != 1) {//Okunmadı
                                var elmy = $('<ons-list-item class="timeline-li" modifier="tappable" style="background-color:#ddd" id="gelenDuyuruItem" data-id="' + cevap.GelenDuyuru[0][d].ID + '">'
                                        + '<ons-row><ons-col width="50px"><img src="' + SITE_URL + 'Plugins/kullanicilar/' + cevap.GelenDuyuru[0][d].Tip + '.png" class="timeline-image"></ons-col>'
                                        + '<ons-col><div class="timeline-date">' + newDate + '--' + myDate[1] + '</div><div class="timline-from"><span class="timeline-name">' + cevap.GelenDuyuru[0][d].Ad + '</span>'
                                        + '</div><div class="timeline-message">' + cevap.GelenDuyuru[0][d].Text + '</div>'
                                        + '</ons-col></ons-row></ons-list-item>');
                                elmy.appendTo(onsListD);
                                ons.compile(elmy[0]);
                            } else {
                                var elmy = $('<ons-list-item class="timeline-li" modifier="tappable" id="gelenDuyuruItem" data-id="' + cevap.GelenDuyuru[0][d].ID + '">'
                                        + '<ons-row><ons-col width="50px"><img src="' + SITE_URL + 'Plugins/kullanicilar/' + cevap.GelenDuyuru[0][d].Tip + '.png" class="timeline-image"></ons-col>'
                                        + '<ons-col><div class="timeline-date">' + newDate + '--' + myDate[1] + '</div><div class="timline-from"><span class="timeline-name">' + cevap.GelenDuyuru[0][d].Ad + '</span>'
                                        + '</div><div class="timeline-message">' + cevap.GelenDuyuru[0][d].Text + '</div>'
                                        + '</ons-col></ons-row></ons-list-item>');
                                elmy.appendTo(onsListD);
                                ons.compile(elmy[0]);
                            }
                        }
                        modal.hide();
                    } else {
                        var onsListD = $("#gelenduyuruList");
                        var elmy = $('<ons-list-item class="timeline-li" modifier="tappable">'
                                + '<ons-row><ons-col width="50px"><img src="' + SITE_URL + 'Plugins/kullanicilar/3.png" class="timeline-image"></ons-col>'
                                + '<ons-col><div class="timline-from"><span class="timeline-name">' + cevap.GelenDuyuru[1][0].Result + '</span></div>'
                                + '</ons-col></ons-row></ons-list-item>');
                        elmy.appendTo(onsListD);
                        ons.compile(elmy[0]);
                        modal.hide();
                    }
                }
            }
        });
    });
    $(document).on('pageinit', '#gonderilenduyuru', function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"firma_id": firma_id, "ogr_id": ogr_id,
                "lang": lang, "tip": "duyuruGonderilen"},
            success: function (cevap) {
                if (cevap.hata) {
                    modal.hide();
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    if (cevap.GonderilenDuyuru[0]) {
                        var lengthduyuru = cevap.GonderilenDuyuru[0].length;
                        var onsListD = $("#gonderilenduyuruList");
                        for (var d = 0; d < lengthduyuru; d++) {
                            var myDate = cevap.GonderilenDuyuru[0][d].Tarih.split(" ");
                            var myDate1 = myDate[0].split("-");
                            var newDate = myDate1[2] + '/' + myDate1[1] + '/' + myDate1[0];
                            var elmy = $('<ons-list-item class="timeline-li" modifier="tappable" data-id="' + cevap.GonderilenDuyuru[0][d].ID + '">'
                                    + '<ons-row><ons-col width="50px"><img src="' + SITE_URL + 'Plugins/kullanicilar/6.png" class="timeline-image"></ons-col>'
                                    + '<ons-col><div class="timeline-date">' + newDate + '--' + myDate[1] + '</div><div class="timline-from"><span class="timeline-name">' + cevap.GonderilenDuyuru[0][d].Hedef + ' ' + jsDil.Kisi + '</span>'
                                    + '</div><div class="timeline-message">' + cevap.GonderilenDuyuru[0][d].Text + '</div>'
                                    + '</ons-col></ons-row></ons-list-item>');
                            elmy.appendTo(onsListD);
                            ons.compile(elmy[0]);
                        }
                        modal.hide();
                    } else {
                        var onsListD = $("#gonderilenduyuruList");
                        var elmy = $('<ons-list-item class="timeline-li" modifier="tappable">'
                                + '<ons-row><ons-col width="50px"><img src="' + SITE_URL + 'Plugins/kullanicilar/3.png" class="timeline-image"></ons-col>'
                                + '<ons-col><div class="timline-from"><span class="timeline-name">' + cevap.GonderilenDuyuru[1][0].Result + '</span></div>'
                                + '</ons-col></ons-row></ons-list-item>');
                        elmy.appendTo(onsListD);
                        ons.compile(elmy[0]);
                        modal.hide();
                    }
                }
            }
        });
    });
    $(document).on('pageinit', '#duyuruayar', function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"ogr_id": ogr_id, "firma_id": firma_id,
                "lang": lang, "tip": "duyuruayar"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    duyuruayarDeger = cevap.Detay.Deger;
                    $('#duyral' + cevap.Detay.Deger).attr('checked', true);
                    modal.hide();
                }
            }
        });
    });
});
$(document).on('click', '#veliSign', function () {
    var chechked = $(this).prop("checked");
    var listy = $("#veliList> ons-list-item").length;
    if (chechked != false) {//hepsi chechked edilecek
        for (var y = 0; y < listy; y++) {
            $("#veliList> ons-list-item:eq(" + y + ")>label>input").prop("checked", true);
        }
    } else {
        for (var y = 0; y < listy; y++) {
            $("#veliList> ons-list-item:eq(" + y + ")>label>input").prop("checked", false);
        }
    }
});
$(document).on('click', '#yoneticiSign', function () {
    var chechked = $(this).prop("checked");
    var listy = $("#yoneticiList> ons-list-item").length;
    if (chechked != false) {//hepsi chechked edilecek
        for (var y = 0; y < listy; y++) {
            $("#yoneticiList> ons-list-item:eq(" + y + ")>label>input").prop("checked", true);
        }
    } else {
        for (var y = 0; y < listy; y++) {
            $("#yoneticiList> ons-list-item:eq(" + y + ")>label>input").prop("checked", false);
        }
    }
});
$(document).on('click', '#gelenDuyuruItem', function () {
    var gelenduyuruid = $(this).attr('data-id');
    var firma_id = $("input[name=firmaId]").val();
    var lang = $("input[name=lang]").val();
    var color = $(this).css('backgroundColor');
    $(this).css('background-color', 'rgba(0, 0, 0, 0)');
    if (color != 'rgba(0, 0, 0, 0)') {
        $.ajax({
            data: {"firma_id": firma_id, "lang": lang,
                "gelenduyuruid": gelenduyuruid, "tip": "gelenOkundu"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    modal.hide();
                }
            }
        });
    }

});
$.OgrenciIslemler = {
    ogrDuyuruSec: function () {
        modal.show();
        veli = [];
        veliID = [];
        yonetici = [];
        yoneticiID = [];
        //yolcu
        var listy = $("#veliList> ons-list-item").length;
        for (var y = 0; y < listy; y++) {
            var chechked = $("#veliList> ons-list-item:eq(" + y + ")>label>input").prop("checked");
            if (chechked != false) {
                var chechkedtext = $("#veliList> ons-list-item:eq(" + y + ") > label").text();
                var chechkedid = $("#veliList> ons-list-item:eq(" + y + ") > label > input").val();
                var chechkedtip = $("#veliList> ons-list-item:eq(" + y + ") > label > input").attr("data-tip");
                if (chechkedtip != 1) {
                    veli.push(chechkedtext);
                    veliID.push(chechkedid);
                } else {
                    isci.push(chechkedtext);
                    isciID.push(chechkedid);
                }
            }
        }
        //yönetici
        var listh = $("#yoneticiList> ons-list-item").length;
        if (listh > 0) {
            for (var a = 0; a < listh; a++) {
                var chechked = $("#yoneticiList> ons-list-item:eq(" + a + ")>label>input").prop("checked");
                if (chechked != false) {
                    var chechkedtext = $("#yoneticiList> ons-list-item:eq(" + a + ") > label").text();
                    var chechkedid = $("#yoneticiList> ons-list-item:eq(" + a + ") > label > input").val();
                    yonetici.push(chechkedtext);
                    yoneticiID.push(chechkedid);
                }
            }
        }

        var toplamKisi = veli.length + yonetici.length;
        if (toplamKisi > 0) {
            duyuruNavigator.pushPage('duyurugonder.html', {animation: 'slide'});
            modal.hide();
        } else {
            modal.hide();
            ons.notification.alert({message: jsDil.KisiSec});
            return false;
        }
    },
    ogrDuyuruGonder: function () {
        var ogr_id = $("input[name=id]").val();
        var ogrAd = $("input[name=ogrAd]").val();
        var firma_id = $("input[name=firmaId]").val();
        var text = $("#duyuruText").val();
        if (text != '') {
            modal.show();
            var lang = $("input[name=lang]").val();
            var kisi = $("input[name=toplamKisi]").val();
            var hedef = kisi.split(' ');
            $.ajax({
                data: {"veli[]": veli, "veliID[]": veliID,
                    "yonetici[]": yonetici, "yoneticiID[]": yoneticiID,
                    "firma_id": firma_id, "ogr_id": ogr_id, "ogrAd": ogrAd,
                    "text": text, "lang": lang,
                    "hedef": hedef[0], "tip": "duyuruGonder"},
                success: function (cevap) {
                    if (cevap.hata) {
                        modal.hide();
                        ons.notification.alert({message: cevap.hata});
                        return false;
                    } else {
                        $("input[name=toplamKisi]").val("");
                        $("#duyuruText").val("");
                        modal.hide();
                        ons.notification.alert({message: cevap.result});
                        return false;
                    }
                }
            });
        } else {
            ons.notification.alert({message: jsDil.BosMesaj});
            return false;
        }
    },
    duyrAyarKaydet: function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        var chechked = $("input#duyral1").prop("checked");
        if (chechked != false) {
            duyuruVal = 1;
        } else {
            duyuruVal = 0;
        }
        $.ajax({
            data: {"ogr_id": ogr_id, "firma_id": firma_id, "lang": lang,
                "duyuruVal": duyuruVal, "duyuruayarDeger": duyuruayarDeger,
                "tip": "duyrayarkaydet"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    ons.notification.alert({message: cevap.update});
                    modal.hide();
                    duyuruNavigator.popPage();
                }
            }
        });
    }
}

