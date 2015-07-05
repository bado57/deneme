$.ajaxSetup({
    type: "post",
    url: "http://192.168.1.26/SProject/SoforMobilDuyuruAjax",
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
var ogrenci = new Array();
var ogrenciID = new Array();
var isci = new Array();
var isciID = new Array();
var veli = new Array();
var veliID = new Array();
var sofor = new Array();
var soforID = new Array();
var hostes = new Array();
var hostesID = new Array();
var yonetici = new Array();
var yoneticiID = new Array();
ons.ready(function () {
    duyuruNavigator.on('prepush', function (event) {
        modal.show();
    });
    $(document).on('pageinit', '#duyurutur', function () {
        var kisiid = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        $.ajax({
            data: {"firma_id": firma_id, "kisiid": kisiid, "tip": "soforTurDuyuru"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: jsDil.Hata});
                    return false;
                } else {
                    if (cevap.TurDuyuru) {
                        $("#turHeader").show();
                        $("#turList").show();
                        var turlength = cevap.TurDuyuru.length;
                        var onsList = $("#turList");
                        $("#turToplam").text(turlength);
                        for (var c = 0; c < turlength; c++) {
                            var elmy = $('<ons-list-item modifier="chevron" onclick="$.SoforIslemler.soforTurList(' + cevap.TurDuyuru[c].ID + ',' + cevap.TurDuyuru[c].Tip + ',' + cevap.TurDuyuru[c].BID + ')">'
                                    + '<ons-row><ons-col width="20px"></ons-col>'
                                    + '<ons-col class="person-name">' + cevap.TurDuyuru[c].Ad + '</ons-col></ons-row></ons-list-item>');
                            elmy.appendTo(onsList);
                            ons.compile(elmy[0]);
                        }
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#duyuruyolcu', function () {
        var page = duyuruNavigator.getCurrentPage();
        var turid = page.options.turid;
        var turtip = page.options.turtip;
        var bolgeid = page.options.bolgeid;
        var firma_id = $("input[name=firmaId]").val();
        $.ajax({
            data: {"bolgeid": bolgeid, "turtip": turtip, "firma_id": firma_id,
                "turid": turid, "tip": "soforDuyuruYolcu"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: jsDil.Hata});
                    return false;
                } else {
                    if (turtip == 0) {
                        $("#turYolcuHeader").show();
                        $("#turYolcuList").show();
                        $("#yolcuChechk").show();
                        var yolculength = cevap.TurYolcu.length;
                        var onsList = $("#turYolcuList");
                        $("#yolcuToplam").text(yolculength);
                        for (var a = 0; a < yolculength; a++) {
                            var elm = $('<ons-list-item modifier="tappable">'
                                    + '<label class="checkbox checkbox--noborder checkbox--list-item">'
                                    + '<input data-tip="0" type="checkbox" checked="checked" value="' + cevap.TurYolcu[a].Id + '">'
                                    + '<div class="checkbox__checkmark checkbox--noborder__checkmark checkbox--list-item__checkmark"></div>'
                                    + cevap.TurYolcu[a].Ad + '</label></ons-list-item>');
                            elm.appendTo(onsList);
                            ons.compile(elm[0]);
                        }

                        if (cevap.TurVeli) {
                            $("#turVeliHeader").show();
                            $("#turVeliList").show();
                            $("#veliChechk").show();
                            var velilength = cevap.TurVeli.length;
                            var onsVeliList = $("#turVeliList");
                            $("#veliToplam").text(velilength);
                            for (var v = 0; v < velilength; v++) {
                                var elm = $('<ons-list-item modifier="tappable">'
                                        + '<label class="checkbox checkbox--noborder checkbox--list-item">'
                                        + '<input type="checkbox" checked="checked" value="' + cevap.TurVeli[v].Id + '">'
                                        + '<div class="checkbox__checkmark checkbox--noborder__checkmark checkbox--list-item__checkmark"></div>'
                                        + cevap.TurVeli[v].Ad + '</label></ons-list-item>');
                                elm.appendTo(onsVeliList);
                                ons.compile(elm[0]);
                            }
                        }
                    } else if (turtip == 1) {
                        $("#turYolcuHeader").show();
                        $("#turYolcuList").show();
                        $("#yolcuChechk").show();
                        var yolculength = cevap.TurYolcu.length;
                        var onsList = $("#turYolcuList");
                        $("#yolcuToplam").text(yolculength);
                        for (var a = 0; a < yolculength; a++) {
                            var elm = $('<ons-list-item modifier="tappable">'
                                    + '<label class="checkbox checkbox--noborder checkbox--list-item">'
                                    + '<input data-tip="1" type="checkbox" checked="checked" value="' + cevap.TurYolcu[a].Id + '">'
                                    + '<div class="checkbox__checkmark checkbox--noborder__checkmark checkbox--list-item__checkmark"></div>'
                                    + cevap.TurYolcu[a].Ad + '</label></ons-list-item>');
                            elm.appendTo(onsList);
                            ons.compile(elm[0]);
                        }
                    } else {
                        $("#turYolcuHeader").show();
                        $("#turYolcuList").show();
                        $("#yolcuChechk").show();
                        var yolculength = cevap.TurYolcu.length;
                        var onsList = $("#turYolcuList");
                        $("#yolcuToplam").text(yolculength);
                        for (var a = 0; a < yolculength; a++) {
                            if (cevap.TurYolcu[a].Tip == 0) {
                                var elm = $('<ons-list-item modifier="tappable">'
                                        + '<label class="checkbox checkbox--noborder checkbox--list-item">'
                                        + '<input data-tip="0" type="checkbox" checked="checked" value="' + cevap.TurYolcu[a].Id + '">'
                                        + '<div class="checkbox__checkmark checkbox--noborder__checkmark checkbox--list-item__checkmark"></div>'
                                        + cevap.TurYolcu[a].Ad + '</label></ons-list-item>');
                            } else {
                                var elm = $('<ons-list-item modifier="tappable">'
                                        + '<label class="checkbox checkbox--noborder checkbox--list-item">'
                                        + '<input data-tip="1" type="checkbox" checked="checked" value="' + cevap.TurYolcu[a].Id + '">'
                                        + '<div class="checkbox__checkmark checkbox--noborder__checkmark checkbox--list-item__checkmark"></div>'
                                        + cevap.TurYolcu[a].Ad + '</label></ons-list-item>');
                            }
                            elm.appendTo(onsList);
                            ons.compile(elm[0]);
                        }

                        if (cevap.TurVeli) {
                            $("#turVeliHeader").show();
                            $("#turVeliList").show();
                            $("#veliChechk").show();
                            var velilength = cevap.TurVeli.length;
                            var onsVeliList = $("#turVeliList");
                            $("#veliToplam").text(velilength);
                            for (var v = 0; v < velilength; v++) {
                                var elm = $('<ons-list-item modifier="tappable">'
                                        + '<label class="checkbox checkbox--noborder checkbox--list-item">'
                                        + '<input type="checkbox" checked="checked" value="' + cevap.TurVeli[v].Id + '">'
                                        + '<div class="checkbox__checkmark checkbox--noborder__checkmark checkbox--list-item__checkmark"></div>'
                                        + cevap.TurVeli[v].Ad + '</label></ons-list-item>');
                                elm.appendTo(onsVeliList);
                                ons.compile(elm[0]);

                            }
                        }
                    }


                    var soforlength = cevap.TurSofor.length;
                    if (soforlength > 1) {
                        var id = $("input[name=id]").val();
                        $("#turSoforHeader").show();
                        $("#turSoforList").show();
                        $("#soforChechk").show();
                        var soforsayi = soforlength - 1;
                        var onsListS = $("#turSoforList");
                        $("#soforToplam").text(soforsayi);
                        for (var b = 0; b < soforlength; b++) {
                            if (cevap.TurSofor[b].Id != id) {
                                var elms = $('<ons-list-item modifier="tappable">'
                                        + '<label class="checkbox checkbox--noborder checkbox--list-item">'
                                        + '<input type="checkbox" checked="checked" value="' + cevap.TurSofor[b].Id + '">'
                                        + '<div class="checkbox__checkmark checkbox--noborder__checkmark checkbox--list-item__checkmark"></div>'
                                        + cevap.TurSofor[b].Ad + '</label></ons-list-item>');
                                elms.appendTo(onsListS);
                                ons.compile(elms[0]);
                            } else {
                                $("input[name=soforAd]").val(cevap.TurSofor[b].Ad);
                            }
                        }
                    }

                    if (cevap.TurHostes) {
                        $("#turHostesHeader").show();
                        $("#turHostesList").show();
                        $("#hostesChechk").show();
                        var hosteslength = cevap.TurHostes.length;
                        var onsListH = $("#turHostesList");
                        $("#hostesToplam").text(hosteslength);
                        for (var d = 0; d < hosteslength; d++) {
                            var elmh = $('<ons-list-item modifier="tappable">'
                                    + '<label class="checkbox checkbox--noborder checkbox--list-item">'
                                    + '<input type="checkbox" checked="checked" value="' + cevap.TurHostes[d].Id + '">'
                                    + '<div class="checkbox__checkmark checkbox--noborder__checkmark checkbox--list-item__checkmark"></div>'
                                    + cevap.TurHostes[d].Ad + '</label></ons-list-item>');
                            elmh.appendTo(onsListH);
                            ons.compile(elmh[0]);
                        }
                    }


                    var yoneticilength = cevap.TurYonet.length;
                    var onsListY = $("#turYoneticiList");
                    $("#yoneticiToplam").text(yoneticilength);
                    $("#turYoneticiHeader").show();
                    $("#turYoneticiList").show();
                    $("#yoneticiChechk").show();
                    for (var c = 0; c < yoneticilength; c++) {
                        var elmy = $('<ons-list-item modifier="tappable">'
                                + '<label class="checkbox checkbox--noborder checkbox--list-item">'
                                + '<input type="checkbox" checked="checked"  value="' + cevap.TurYonet[c].Id + '">'
                                + '<div class="checkbox__checkmark checkbox--noborder__checkmark checkbox--list-item__checkmark"></div>'
                                + cevap.TurYonet[c].Ad + ' ' + cevap.TurYonet[c].Soyad + '</label></ons-list-item>');
                        elmy.appendTo(onsListY);
                        ons.compile(elmy[0]);
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#duyurugonder', function () {
        var toplamKisi = ogrenci.length + isci.length + veli.length + sofor.length + hostes.length + yonetici.length;
        if (toplamKisi > 0) {
            $("input[name=toplamKisi]").val(toplamKisi + ' ' + jsDil.Kisi);
        }
    });
    $(document).on('pageinit', '#duyurugecmis', function () {
        modal.hide();
    });
    $(document).on('pageinit', '#gelenduyuru', function () {
        var soforid = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        $.ajax({
            data: {"firma_id": firma_id, "soforid": soforid, "tip": "duyuruGelen"},
            success: function (cevap) {
                if (cevap.hata) {
                    modal.hide();
                    ons.notification.alert({message: jsDil.Hata});
                    return false;
                } else {
                    if (cevap.GelenDuyuru) {
                        var lengthduyuru = cevap.GelenDuyuru.length;
                        var onsListD = $("#gelenduyuruList");
                        for (var d = 0; d < lengthduyuru; d++) {
                            var myDate = cevap.GelenDuyuru[d].Tarih.split(" ");
                            var myDate1 = myDate[0].split("-");
                            var newDate = myDate1[2] + '/' + myDate1[1] + '/' + myDate1[0];
                            if (cevap.GelenDuyuru[d].Okundu != 1) {//Okunmadı
                                var elmy = $('<ons-list-item class="timeline-li" modifier="tappable" style="background-color:#ddd" id="gelenDuyuruItem" data-id="' + cevap.GelenDuyuru[d].ID + '">'
                                        + '<ons-row><ons-col width="50px"><img src="http://192.168.1.26/SProject/Plugins/mapView/' + cevap.GelenDuyuru[d].Tip + '.png" class="timeline-image"></ons-col>'
                                        + '<ons-col><div class="timeline-date">' + newDate + '--' + myDate[1] + '</div><div class="timline-from"><span class="timeline-name">' + cevap.GelenDuyuru[d].Ad + '</span>'
                                        + '</div><div class="timeline-message">' + cevap.GelenDuyuru[d].Text + '</div>'
                                        + '</ons-col></ons-row></ons-list-item>');
                                elmy.appendTo(onsListD);
                                ons.compile(elmy[0]);
                            } else {
                                var elmy = $('<ons-list-item class="timeline-li" modifier="tappable" id="gelenDuyuruItem" data-id="' + cevap.GelenDuyuru[d].ID + '">'
                                        + '<ons-row><ons-col width="50px"><img src="http://192.168.1.26/SProject/Plugins/mapView/' + cevap.GelenDuyuru[d].Tip + '.png" class="timeline-image"></ons-col>'
                                        + '<ons-col><div class="timeline-date">' + newDate + '--' + myDate[1] + '</div><div class="timline-from"><span class="timeline-name">' + cevap.GelenDuyuru[d].Ad + '</span>'
                                        + '</div><div class="timeline-message">' + cevap.GelenDuyuru[d].Text + '</div>'
                                        + '</ons-col></ons-row></ons-list-item>');
                                elmy.appendTo(onsListD);
                                ons.compile(elmy[0]);
                            }
                        }
                        modal.hide();
                    } else {
                        var elmy = $('<ons-list-item class="timeline-li" modifier="tappable">'
                                + '<ons-row><ons-col width="50px"><img src="http://192.168.1.26/SProject/Plugins/mapView/3.png" class="timeline-image"></ons-col>'
                                + '<ons-col><div class="timline-from"><span class="timeline-name">' + jsDil.DuyuruYok + '</span></div>'
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
        var soforid = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        $.ajax({
            data: {"firma_id": firma_id, "soforid": soforid, "tip": "duyuruGonderilen"},
            success: function (cevap) {
                if (cevap.hata) {
                    modal.hide();
                    ons.notification.alert({message: jsDil.Hata});
                    return false;
                } else {
                    if (cevap.GonderilenDuyuru) {
                        var lengthduyuru = cevap.GonderilenDuyuru.length;
                        var onsListD = $("#gonderilenduyuruList");
                        for (var d = 0; d < lengthduyuru; d++) {
                            var myDate = cevap.GonderilenDuyuru[d].Tarih.split(" ");
                            var myDate1 = myDate[0].split("-");
                            var newDate = myDate1[2] + '/' + myDate1[1] + '/' + myDate1[0];
                            var elmy = $('<ons-list-item class="timeline-li" modifier="tappable" id="gelenDuyuruItem" data-id="' + cevap.GonderilenDuyuru[d].ID + '">'
                                    + '<ons-row><ons-col width="50px"><img src="http://192.168.1.26/SProject/Plugins/mapView/3.png" class="timeline-image"></ons-col>'
                                    + '<ons-col><div class="timeline-date">' + newDate + '--' + myDate[1] + '</div><div class="timline-from"><span class="timeline-name">' + cevap.GonderilenDuyuru[d].Hedef + ' ' + jsDil.Kisi + '</span>'
                                    + '</div><div class="timeline-message">' + cevap.GonderilenDuyuru[d].Text + '</div>'
                                    + '</ons-col></ons-row></ons-list-item>');
                            elmy.appendTo(onsListD);
                            ons.compile(elmy[0]);
                        }
                        modal.hide();
                    } else {
                        var elmy = $('<ons-list-item class="timeline-li" modifier="tappable">'
                                + '<ons-row><ons-col width="50px"><img src="http://192.168.1.26/SProject/Plugins/mapView/3.png" class="timeline-image"></ons-col>'
                                + '<ons-col><div class="timline-from"><span class="timeline-name">' + jsDil.DuyuruYok + '</span></div>'
                                + '</ons-col></ons-row></ons-list-item>');
                        elmy.appendTo(onsListD);
                        ons.compile(elmy[0]);
                        modal.hide();
                    }
                }
            }
        });
    });
});
$(document).on('click', '#yolcuSign', function () {
    var chechked = $(this).prop("checked");
    var listy = $("#turYolcuList> ons-list-item").length;
    if (chechked != false) {//hepsi chechked edilecek
        for (var y = 0; y < listy; y++) {
            $("#turYolcuList> ons-list-item:eq(" + y + ")>label>input").prop("checked", true);
        }
    } else {
        for (var y = 0; y < listy; y++) {
            $("#turYolcuList> ons-list-item:eq(" + y + ")>label>input").prop("checked", false);
        }
    }
});
$(document).on('click', '#veliSign', function () {
    var chechked = $(this).prop("checked");
    var listv = $("#turVeliList> ons-list-item").length;
    if (chechked != false) {//hepsi chechked edilecek
        for (var y = 0; y < listv; y++) {
            $("#turVeliList> ons-list-item:eq(" + y + ")>label>input").prop("checked", true);
        }
    } else {
        for (var y = 0; y < listv; y++) {
            $("#turVeliList> ons-list-item:eq(" + y + ")>label>input").prop("checked", false);
        }
    }
});
$(document).on('click', '#soforSign', function () {
    var chechked = $(this).prop("checked");
    var lists = $("#turSoforList> ons-list-item").length;
    if (chechked != false) {//hepsi chechked edilecek
        for (var y = 0; y < lists; y++) {
            $("#turSoforList> ons-list-item:eq(" + y + ")>label>input").prop("checked", true);
        }
    } else {
        for (var y = 0; y < lists; y++) {
            $("#turSoforList> ons-list-item:eq(" + y + ")>label>input").prop("checked", false);
        }
    }
});
$(document).on('click', '#hostesSign', function () {
    var chechked = $(this).prop("checked");
    var listh = $("#turHostesList> ons-list-item").length;
    if (chechked != false) {//hepsi chechked edilecek
        for (var y = 0; y < listh; y++) {
            $("#turHostesList> ons-list-item:eq(" + y + ")>label>input").prop("checked", true);
        }
    } else {
        for (var y = 0; y < listh; y++) {
            $("#turHostesList> ons-list-item:eq(" + y + ")>label>input").prop("checked", false);
        }
    }
});
$(document).on('click', '#yoneticiSign', function () {
    var chechked = $(this).prop("checked");
    var listy = $("#turYoneticiList> ons-list-item").length;
    if (chechked != false) {//hepsi chechked edilecek
        for (var y = 0; y < listy; y++) {
            $("#turYoneticiList> ons-list-item:eq(" + y + ")>label>input").prop("checked", true);
        }
    } else {
        for (var y = 0; y < listy; y++) {
            $("#turYoneticiList> ons-list-item:eq(" + y + ")>label>input").prop("checked", false);
        }
    }
});
$(document).on('click', '#gelenDuyuruItem', function () {
    modal.show();
    var gelenduyuruid = $(this).attr('data-id');
    var firma_id = $("input[name=firmaId]").val();
    $(this).css('background-color', '#fff');
    $.ajax({
        data: {"firma_id": firma_id, "gelenduyuruid": gelenduyuruid, "tip": "gelenOkundu"},
        success: function (cevap) {
            if (cevap.hata) {
                ons.notification.alert({message: jsDil.Hata});
                return false;
            } else {
                modal.hide();
            }
        }
    });
});
$.SoforIslemler = {
    soforTurList: function (id, tip, bid) {
        duyuruNavigator.pushPage('duyuruyolcu.html', {animation: 'slide', turid: id, turtip: tip, bolgeid: bid});
    },
    soforDuyuruSec: function (id, tip, bid) {
        modal.show();
        ogrenci = [];
        ogrenciID = [];
        isci = [];
        isciID = [];
        veli = [];
        veliID = [];
        sofor = [];
        soforID = [];
        hostes = [];
        hostesID = [];
        yonetici = [];
        yoneticiID = [];
        //yolcu
        var listy = $("#turYolcuList> ons-list-item").length;
        for (var y = 0; y < listy; y++) {
            var chechked = $("#turYolcuList> ons-list-item:eq(" + y + ")>label>input").prop("checked");
            if (chechked != false) {
                var chechkedtext = $("#turYolcuList> ons-list-item:eq(" + y + ") > label").text();
                var chechkedid = $("#turYolcuList> ons-list-item:eq(" + y + ") > label > input").val();
                var chechkedtip = $("#turYolcuList> ons-list-item:eq(" + y + ") > label > input").attr("data-tip");
                if (chechkedtip != 1) {
                    ogrenci.push(chechkedtext);
                    ogrenciID.push(chechkedid);
                } else {
                    isci.push(chechkedtext);
                    isciID.push(chechkedid);
                }
            }
        }
        //veli
        var listv = $("#turVeliList> ons-list-item").length;
        if (listv > 0) {
            for (var v = 0; v < listv; v++) {
                var chechked = $("#turVeliList> ons-list-item:eq(" + v + ")>label>input").prop("checked");
                if (chechked != false) {
                    var chechkedtext = $("#turVeliList> ons-list-item:eq(" + v + ") > label").text();
                    var chechkedid = $("#turVeliList> ons-list-item:eq(" + v + ") > label > input").val();
                    veli.push(chechkedtext);
                    veliID.push(chechkedid);
                }
            }
        }
        //şoför
        var lists = $("#turSoforList> ons-list-item").length;
        for (var s = 0; s < lists; s++) {
            var chechked = $("#turSoforList> ons-list-item:eq(" + s + ")>label>input").prop("checked");
            if (chechked != false) {
                var chechkedtext = $("#turSoforList> ons-list-item:eq(" + s + ") > label").text();
                var chechkedid = $("#turSoforList> ons-list-item:eq(" + s + ") > label > input").val();
                sofor.push(chechkedtext);
                soforID.push(chechkedid);
            }
        }

        //hostes
        var listh = $("#turHostesList> ons-list-item").length;
        if (listh > 0) {
            for (var h = 0; h < listh; h++) {
                var chechked = $("#turHostesList> ons-list-item:eq(" + h + ")>label>input").prop("checked");
                if (chechked != false) {
                    var chechkedtext = $("#turHostesList> ons-list-item:eq(" + h + ") > label").text();
                    var chechkedid = $("#turHostesList> ons-list-item:eq(" + h + ") > label > input").val();
                    hostes.push(chechkedtext);
                    hostesID.push(chechkedid);
                }
            }
        }

        //yönetici
        var listh = $("#turYoneticiList> ons-list-item").length;
        if (listh > 0) {
            for (var a = 0; a < listh; a++) {
                var chechked = $("#turYoneticiList> ons-list-item:eq(" + a + ")>label>input").prop("checked");
                if (chechked != false) {
                    var chechkedtext = $("#turYoneticiList> ons-list-item:eq(" + a + ") > label").text();
                    var chechkedid = $("#turYoneticiList> ons-list-item:eq(" + a + ") > label > input").val();
                    yonetici.push(chechkedtext);
                    yoneticiID.push(chechkedid);
                }
            }
        }

        var toplamKisi = ogrenci.length + isci.length + veli.length + sofor.length + hostes.length + yonetici.length;
        if (toplamKisi > 0) {
            duyuruNavigator.pushPage('duyurugonder.html', {animation: 'slide'});
            modal.hide();
        } else {
            modal.hide();
            ons.notification.alert({message: jsDil.KisiSec});
            return false;
        }
    },
    soforDuyuruGonder: function () {
        var soforid = $("input[name=id]").val();
        var soforAd = $("input[name=soforAd]").val();
        var firma_id = $("input[name=firmaId]").val();
        var text = $("#duyuruText").val();
        if (text != '') {
            modal.show();
            var lang = $("input[name=lang]").val();
            var kisi = $("input[name=toplamKisi]").val();
            var hedef = kisi.split(' ');
            $.ajax({
                data: {"ogrenci[]": ogrenci, "ogrenciID[]": ogrenciID, "isci[]": isci, "isciID[]": isciID,
                    "veli[]": veli, "veliID[]": veliID, "sofor[]": sofor, "soforID[]": soforID, "hostes[]": hostes,
                    "hostesID[]": hostesID, "yonetici[]": yonetici, "yoneticiID[]": yoneticiID,
                    "firma_id": firma_id, "soforid": soforid, "soforAd": soforAd, "text": text, "lang": lang,
                    "hedef": hedef[0], "tip": "duyuruGonder"},
                success: function (cevap) {
                    if (cevap.hata) {
                        modal.hide();
                        ons.notification.alert({message: jsDil.Hata});
                        return false;
                    } else {
                        modal.hide();
                        ons.notification.alert({message: jsDil.DuyuruGonder});
                        //duyuruNavigator.pushPage('duyurutur.html', {animation: 'slide'});
                        return false;
                    }
                }
            });
        } else {
            ons.notification.alert({message: jsDil.BosMesaj});
            return false;
        }
    }
}

