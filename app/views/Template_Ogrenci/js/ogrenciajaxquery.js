var SITE_URL = "http://192.168.1.30/SProject/";
$.ajaxSetup({
    type: "post",
    url: SITE_URL + "OgrenciMobilDetayAjax",
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
var bildayarDeger;
var bildDegisiklik = new Array();
var turBildirim = new Array();
var refreshInterval;
var Interval;
var MultipleMapArray = new Array();
var arac = new Array();
var turList = new Array();
var kurum = new Array();
//gidiş değerleri
var binmeyen = new Array();
var binen = new Array();
//dönüş değerleri
var inmeyen = new Array();
var inen = new Array();
var MultipleMapindex;
var haritaGostermeDeger = 0;
ons.ready(function () {
    ogrenciNavigator.on('prepush', function (event) {
        modal.show();
    });
    $(document).on('pageinit', '#islemlistepage', function () {
        modal.hide();
    });
    $(document).on('pageinit', '#veliListe', function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"ogr_id": ogr_id, "firma_id": firma_id,
                "lang": lang, "tip": "veliListe"},
            success: function (cevap) {
                if (cevap.hata) {
                    modal.hide();
                    ons.notification.alert({message: cevap.hata});
                } else {
                    if (cevap.result[0]) {
                        $("#veliListNone").hide();
                        $("#ogrVeliList").show();
                        var onsList = $("#ogrVeliList");
                        var velilength = cevap.result[0].length;
                        for (var a = 0; a < velilength; a++) {
                            var elm = $('<ons-list-item modifier="chevron" onclick="$.OgrenciIslemler.ogrVeliList(' + cevap.result[0][a].ID + ')">'
                                    + '<ons-row><ons-col width="40px"><i class="fa fa-user"></i></ons-col>'
                                    + '<ons-col class="coldty">' + cevap.result[0][a].Ad + '</ons-col></ons-row></ons-list-item>');
                            elm.appendTo(onsList);
                            ons.compile(elm[0]);
                        }
                    } else {
                        $("#veliListNo").text(cevap.result[1][0].Yok);
                    }
                }
                modal.hide();
            }
        });
    });
    $(document).on('pageinit', '#veliProfilListe', function () {
        var page = ogrenciNavigator.getCurrentPage();
        var id = page.options.veliID;
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"id": id, "ogr_id": ogr_id, "firma_id": firma_id,
                "lang": lang, "tip": "veliDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    modal.hide();
                    ons.notification.alert({message: cevap.hata});
                } else {
                    $("#profilAd").text(cevap.result[0][0].Ad);
                    $("#profilTelefon").text(cevap.result[0][0].Phone);
                    $("a#profilTelefon").attr("href", "tel:" + cevap.result[0][0].Phone);
                    $("#profilEmail").text(cevap.result[0][0].Email);
                    $("#profilAdres").text(cevap.result[0][0].Adres);
                    $("input[name=profilLoc]").val(cevap.result[0][0].Loc);
                    if (cevap.result[0][0].Stts != 0) {
                        $("#veliStatus").addClass("fa fa-toggle-on");
                        $("#profilDurum").text(cevap.result[0][0].Status);
                    } else {
                        $("#veliStatus").addClass("fa fa-toggle-off");
                        $("#profilDurum").text(cevap.result[0][0].Status);
                    }
                }
                modal.hide();
            }
        });
    });
    $(document).on('pageinit', '#mappage', function () {
        var loc = $("input[name=profilLoc]").val();
        var locarr = loc.split(',');
        var mobilEnlem = locarr[0];
        var mobilBoylam = locarr[1];
        Mobileinitialize(mobilEnlem, mobilBoylam);
        var wh = $(window).height();
        var fh = 0;
        var mh = wh - fh;
        $('#veli_map').css("height", mh);
        google.maps.event.addDomListener(window, 'load', Mobileinitialize);
        modal.hide();
    });
    $(document).on('pageinit', '#kurumListe', function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"ogr_id": ogr_id, "firma_id": firma_id,
                "lang": lang, "tip": "kurumListe"},
            success: function (cevap) {
                if (cevap.hata) {
                    modal.hide();
                    ons.notification.alert({message: cevap.hata});
                } else {
                    if (cevap.result[0]) {
                        $("#kurumListNone").hide();
                        $("#ogrKurumList").show();
                        var onsList = $("#ogrKurumList");
                        var kurumlength = cevap.result[0].length;
                        for (var a = 0; a < kurumlength; a++) {
                            var elm = $('<ons-list-item modifier="chevron" onclick="$.OgrenciIslemler.ogrKurumList(' + cevap.result[0][a].ID + ')">'
                                    + '<ons-row><ons-col width="40px"><i class="fa fa-building-o"></i></ons-col>'
                                    + '<ons-col class="coldty">' + cevap.result[0][a].Ad + '</ons-col></ons-row></ons-list-item>');
                            elm.appendTo(onsList);
                            ons.compile(elm[0]);
                        }
                    } else {
                        $("#kurumListNo").text(cevap.result[1][0].Yok);
                    }
                }
                modal.hide();
            }
        });
    });
    $(document).on('pageinit', '#kurumDetay', function () {
        var page = ogrenciNavigator.getCurrentPage();
        var id = page.options.kurumID;
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"id": id, "ogr_id": ogr_id, "firma_id": firma_id,
                "lang": lang, "tip": "kurumDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    modal.hide();
                    ons.notification.alert({message: cevap.hata});
                } else {
                    $("#kurumAd").text(cevap.result[0].Ad);
                    $("#kurumTelefon").text(cevap.result[0].Phone);
                    $("a#kurumTelefon").attr("href", "tel:" + cevap.result[0].Phone);
                    $("#kurumEmail").text(cevap.result[0].Email);
                    $("#kurumWebSite").text(cevap.result[0].WebSite);
                    $("#kurumAdres").text(cevap.result[0].Adres);
                    $("input[name=kurumLoc]").val(cevap.result[0].Loc);
                }
                modal.hide();
            }
        });
    });
    $(document).on('pageinit', '#kurummappage', function () {
        var lokasyon = $("input[name=kurumLoc]").val();
        var adres = $("#kurumAdres").text();
        MobileeInitialize(lokasyon, adres, 2);
        var wh = $(window).height();
        var fh = 0;
        var mh = wh - fh;
        $('#sofor_map').css("height", mh);
        google.maps.event.addDomListener(window, 'load', MobileeInitialize);
        modal.hide();
    });
    $(document).on('pageinit', '#turListe', function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"ogr_id": ogr_id, "firma_id": firma_id,
                "lang": lang, "tip": "turListe"},
            success: function (cevap) {
                if (cevap.hata) {
                    modal.hide();
                    ons.notification.alert({message: cevap.hata});
                } else {
                    if (cevap.result[0]) {
                        $("#turListNone").hide();
                        $("#turList").show();
                        var onsList = $("#turList");
                        var turlength = cevap.result[0].length;
                        for (var a = 0; a < turlength; a++) {
                            var elm = $('<ons-list-item modifier="chevron" onclick="$.OgrenciIslemler.turList(' + cevap.result[0][a].ID + ')">'
                                    + '<ons-row><ons-col width="40px"><i class="fa fa-refresh"></i></ons-col>'
                                    + '<ons-col class="coldty">' + cevap.result[0][a].Ad + "  ( " + cevap.result[0][a].Kurum + " )" + '</ons-col></ons-row></ons-list-item>');
                            elm.appendTo(onsList);
                            ons.compile(elm[0]);
                        }
                    } else {
                        $("#turListNo").text(cevap.result[1][0].Yok);
                    }
                }
                modal.hide();
            }
        });
    });
    $(document).on('pageinit', '#turDetayListe', function () {
        var page = ogrenciNavigator.getCurrentPage();
        var id = page.options.turID;
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"id": id, "ogr_id": ogr_id, "firma_id": firma_id,
                "lang": lang, "tip": "turDetayListe"},
            success: function (cevap) {
                if (cevap.hata) {
                    modal.hide();
                    ons.notification.alert({message: cevap.hata});
                } else {
                    $("input[name=turListItem]").val(cevap.Detay.ID);
                    $("input[name=turListTip]").val(cevap.Detay.Tip);
                    $("#detayTurAd").text(cevap.Detay.Ad);
                    if (cevap.Detay.Aktiflik != 0) {
                        $("#turListAktif").addClass("fa fa-toggle-on");
                        $("#detayAktif").text(jsDil.Aktif);
                    } else {
                        $("#turListAktif").addClass("fa fa-toggle-off");
                        $("#detayAktif").text(jsDil.Pasif);
                    }
                    $("#detayKurum").text(cevap.Detay.Kurum);
                    $("input[name=turKurumID]").val(cevap.Detay.KurumID);
                    $("input[name=turKurumLoc]").val(cevap.Detay.KurumLoc);
                    if (cevap.Detay.Aciklama) {
                        $("#detayAciklama").text(cevap.Detay.Aciklama);
                    } else {
                        $("#detayListAciklama").hide();
                    }
                    $("#detayKm").text(cevap.Detay.Km);
                    var gunText = "";
                    if (cevap.Detay.Pzt != 0) {
                        gunText += jsDil.Pzt + '-';
                    }
                    if (cevap.Detay.Sli != 0) {
                        gunText += jsDil.Sli + '-';
                    }
                    if (cevap.Detay.Crs != 0) {
                        gunText += jsDil.Crs + '-';
                    }
                    if (cevap.Detay.Prs != 0) {
                        gunText += jsDil.Prs + '-';
                    }
                    if (cevap.Detay.Cma != 0) {
                        gunText += jsDil.Cma + '-';
                    }
                    if (cevap.Detay.Cmt != 0) {
                        gunText += jsDil.Cmt + '-';
                    }
                    if (cevap.Detay.Pzr != 0) {
                        gunText += jsDil.Pzr + '-';
                    }
                    //var gunTextt = gunText.substring(0, gunText.Length - 1);
                    $("#detayGunler").text(gunText.slice(0, -1));
                    if (cevap.Detay.Gidis != "") {
                        $("#turDetayList").show();
                        var onsList = $("#turDetayList");
                        var elm = $('<ons-list-item modifier="chevron" onclick="$.OgrenciIslemler.turDetayList(0)">'
                                + '<ons-row><ons-col width="40px"><i class="fa fa-arrow-right"></i></ons-col>'
                                + '<ons-col class="coldty">' + cevap.Detay.Gidis + '</ons-col></ons-row></ons-list-item>');
                        elm.appendTo(onsList);
                        ons.compile(elm[0]);
                    }
                    if (cevap.Detay.Donus != "") {
                        $("#turDetayList").show();
                        var onsList = $("#turDetayList");
                        var elm = $('<ons-list-item modifier="chevron" onclick="$.OgrenciIslemler.turDetayList(1)">'
                                + '<ons-row><ons-col width="40px"><i class="fa fa-arrow-left"></i></ons-col>'
                                + '<ons-col class="coldty">' + cevap.Detay.Donus + '</ons-col></ons-row></ons-list-item>');
                        elm.appendTo(onsList);
                        ons.compile(elm[0]);
                    }
                }
                modal.hide();
            }
        });
    });
    $(document).on('pageinit', '#turDetayMap', function () {
        var turtip = $("input[name=turListTip]").val();
        var turid = $("input[name=turListItem]").val();
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"firma_id": firma_id, "turtip": turtip,
                "turid": turid, "ogr_id": ogr_id, "lang": lang,
                "tip": "turDetayMap"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    turList = [];
                    kurum = [];
                    var kurumAd = $("#detayKurum").text();
                    var kurumID = $("input[name=turKurumID]").val();
                    var kurumLocation = $("input[name=turKurumLoc]").val();
                    var kurumLoc = kurumLocation.split(",");
                    kurum = Array(kurumAd, kurumID, kurumLoc[0], kurumLoc[1]);
                    var length = cevap.Tur.ID.length;
                    for (var a = 0; a < length; a++) {
                        var kisiAd = cevap.Tur.Ad[a];
                        var kisiLoc = cevap.Tur.Loc[a].split(",");
                        var kisiID = cevap.Tur.ID[a];
                        var kisiTip = cevap.Tur.Tip[a];
                        turList[a] = Array(kisiAd, kisiLoc[0], kisiLoc[1], kisiID, kisiTip);
                    }
                    turLokasyon();
                    google.maps.event.addDomListener(window, 'load', turLokasyon);
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#turGidDon', function () {
        var page = ogrenciNavigator.getCurrentPage();
        var turgd = page.options.turgd;
        var turtip = $("input[name=turListTip]").val();
        var turid = $("input[name=turListItem]").val();
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"turtip": turtip, "turid": turid, "turgd": turgd,
                "ogr_id": ogr_id, "firma_id": firma_id,
                "lang": lang, "tip": "turGDListe"},
            success: function (cevap) {
                if (cevap.hata) {
                    modal.hide();
                    ons.notification.alert({message: cevap.hata});
                } else {
                    $("input[name=turGidisDonusID]").val(cevap.Detay.GDID);
                    if (turgd != 1) {//Gidiş
                        $("input[name=turGidisDonus]").val(0);
                        $("#turgidisBaslik").show();
                        $("#turdonusBaslik").hide();
                    } else {//Dönüş
                        $("input[name=turGidisDonus]").val(1);
                        $("#turdonusBaslik").show();
                        $("#turgidisBaslik").hide();
                    }
                    $("#giddonPlaka").text(cevap.Detay.AracPlaka);
                    $("input[name=aracGDID]").val(cevap.Detay.AracID);
                    $("#giddonSofor").text(cevap.Detay.SoforAd);
                    $("input[name=soforGDID]").val(cevap.Detay.SoforID);
                    if (cevap.Detay.HostesID > 0) {
                        $("#giddonHostes").text(cevap.Detay.HostesAd);
                        $("input[name=hostesGDID]").val(cevap.Detay.HostesID);
                    } else {
                        $("#detayGidisHostes").hide();
                    }
                    var saat1;
                    if (cevap.Detay.Bslngc.length == 1) {
                        saat1 = '00:00'
                    } else if (cevap.Detay.Bslngc.length == 2) {
                        saat1 = '00:' + cevap.Detay.Bslngc;
                    } else if (cevap.Detay.Bslngc.length == 3) {
                        var ilkHarf1 = cevap.Detay.Bslngc.slice(0, 1);
                        var sondaikiHarf1 = cevap.Detay.Bslngc.slice(1, 3);
                        saat1 = '0' + ilkHarf1 + ':' + sondaikiHarf1;
                    } else {
                        var ilkikiHarf1 = cevap.Detay.Bslngc.slice(0, 2);
                        var sondaikiHarf1 = cevap.Detay.Bslngc.slice(2, 4);
                        saat1 = ilkikiHarf1 + ':' + sondaikiHarf1;
                    }

                    var saat2;
                    if (cevap.Detay.Bts.length == 1) {
                        saat2 = '00:00'
                    } else if (cevap.Detay.Bts.length == 2) {
                        saat2 = '00:' + cevap.Detay.Bts;
                    } else if (cevap.Detay.Bts.length == 3) {
                        var ilkHarf1 = cevap.Detay.Bts.slice(0, 1);
                        var sondaikiHarf1 = cevap.Detay.Bts.slice(1, 3);
                        saat2 = '0' + ilkHarf1 + ':' + sondaikiHarf1;
                    } else {
                        var ilkikiHarf1 = cevap.Detay.Bts.slice(0, 2);
                        var sondaikiHarf1 = cevap.Detay.Bts.slice(2, 4);
                        saat2 = ilkikiHarf1 + ':' + sondaikiHarf1;
                    }
                    $("#giddonSaat").text(saat1 + ' - ' + saat2);
                }
                modal.hide();
            }
        });
    });
    $(document).on('pageinit', '#aracdetay', function () {
        var aracid = $("input[name=aracGDID]").val();
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"ogr_id": ogr_id, "firma_id": firma_id, "lang": lang,
                "aracid": aracid, "tip": "aracDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    $("#aracPlaka").text(cevap.Detay.Plaka);
                    $("input[name=aracDetayID]").val(aracid);
                    if (cevap.Detay.Marka) {
                        $("#aracMarka").text(cevap.Detay.Marka);
                    } else {
                        $("#aracListMarka").hide();
                    }
                    if (cevap.Detay.Yil) {
                        $("#aracYil").text(cevap.Detay.Yil);
                    } else {
                        $("#aracListYil").hide();
                    }
                    $("#aracKapasite").text(cevap.Detay.Kapasite);
                    $("#aracKm").text(cevap.Detay.Km);
                    if (cevap.Detay.Aciklama) {
                        $("#aracAciklama").text(cevap.Detay.Aciklama);
                    } else {
                        $("#aracListAciklama").hide();
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#sofordetay', function () {
        var kisiid = $("input[name=soforGDID]").val();
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"kisiid": kisiid, "ogr_id": ogr_id,
                "firma_id": firma_id, "lang": lang, "tip": "soforDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    $("#sofordetayAd").text(cevap.Detay.Ad + ' ' + cevap.Detay.Soyad);
                    $("input[name=soforDetayID]").val(kisiid);
                    if (cevap.Detay.Tel) {
                        $("#sofordetayTel").text(cevap.Detay.Tel);
                        $("a#sofordetayTel").attr("href", "tel:" + cevap.Detay.Tel);
                    } else {
                        $("#sofordetayListTel").hide();
                    }
                    $("#sofordetaymail").text(cevap.Detay.Mail);
                    if (cevap.Detay.Adres) {
                        $("input[name=sofordetaylocation]").val(cevap.Detay.Lokasyon);
                        $("#sofordetayadres").text(cevap.Detay.Adres);
                    } else {
                        $("#sofordetayListAdres").hide();
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#soforDetayMap', function () {
        var lokasyon = $("input[name=sofordetaylocation]").val();
        var adres = $("#sofordetayadres").text();
        MobileeInitialize(lokasyon, adres, 0);
        var wh = $(window).height();
        var fh = 0;
        var mh = wh - fh;
        $('#sofor_map').css("height", mh);
        google.maps.event.addDomListener(window, 'load', MobileeInitialize);
        modal.hide();
    });
    $(document).on('pageinit', '#hostesdetay', function () {
        var kisiid = $("input[name=hostesGDID]").val();
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"ogr_id": ogr_id, "firma_id": firma_id, "lang": lang,
                "kisiid": kisiid, "tip": "hostesDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    $("#hostesdetayAd").text(cevap.Detay.Ad + ' ' + cevap.Detay.Soyad);
                    $("input[name=hostesDetayID]").val(kisiid);
                    if (cevap.Detay.Tel) {
                        $("#hostesdetayTel").text(cevap.Detay.Tel);
                        $("a#hostesdetayTel").attr("href", "tel:" + cevap.Detay.Tel);
                    } else {
                        $("#hostesdetayListTel").hide();
                    }
                    $("#hostesdetaymail").text(cevap.Detay.Mail);
                    if (cevap.Detay.Adres) {
                        $("input[name=hostesdetaylocation]").val(cevap.Detay.Lokasyon);
                        $("#hostesdetayadres").text(cevap.Detay.Adres);
                    } else {
                        $("#hostesdetayListAdres").hide();
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#hostesDetayMap', function () {
        var lokasyon = $("input[name=hostesdetaylocation]").val();
        var adres = $("#hostesdetayadres").text();
        MobileeInitialize(lokasyon, adres, 1);
        var wh = $(window).height();
        var fh = 0;
        var mh = wh - fh;
        $('#sofor_map').css("height", mh);
        google.maps.event.addDomListener(window, 'load', MobileeInitialize);
        modal.hide();
    });
    $(document).on('pageinit', '#turbildirimmesafe', function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        var giddon = $("input[name=turGidisDonus]").val();
        $.ajax({
            data: {"ogr_id": ogr_id, "firma_id": firma_id, "lang": lang,
                "giddon": giddon, "tip": "bilmesafayar"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    bildayarDeger = cevap.Detay.Deger;
                    $('#bildayar' + cevap.Detay.Deger).attr('checked', true);
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#haftaliktakvim', function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        var giddon = $("input[name=turGidisDonus]").val();
        var turid = $("input[name=turListItem]").val();
        var enlem = $("input[name=enlem]").val();
        var boylam = $("input[name=boylam]").val();
        var turtip = $("input[name=turListTip]").val();
        $.ajax({
            data: {"ogr_id": ogr_id, "firma_id": firma_id, "lang": lang,
                "giddon": giddon, "turid": turid,
                "enlem": enlem, "boylam": boylam, "turtip": turtip, "tip": "haftlktkvim"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    $("#haftabasbit").text(" (" + cevap.result.IlkGun + "   /   " + cevap.result.SonGun + ")");
                    bildDegisiklik = [];
                    if (cevap.result.Pzt != 1) {//geliyor o gün
                        $('#tkvimPzt').attr('checked', true);
                        bildDegisiklik.push(0);
                    } else {
                        $('#tkvimPzt').attr('checked', false);
                        bildDegisiklik.push(1);
                    }
                    if (cevap.result.Sli != 1) {//geliyor o gün
                        $('#tkvimSli').attr('checked', true);
                        bildDegisiklik.push(0);
                    } else {
                        $('#tkvimSli').attr('checked', false);
                        bildDegisiklik.push(1);
                    }
                    if (cevap.result.Crs != 1) {//geliyor o gün
                        $('#tkvimCrs').attr('checked', true);
                        bildDegisiklik.push(0);
                    } else {
                        $('#tkvimCrs').attr('checked', false);
                        bildDegisiklik.push(1);
                    }
                    if (cevap.result.Prs != 1) {//geliyor o gün
                        $('#tkvimPrs').attr('checked', true);
                        bildDegisiklik.push(0);
                    } else {
                        $('#tkvimPrs').attr('checked', false);
                        bildDegisiklik.push(1);
                    }
                    if (cevap.result.Cma != 1) {//geliyor o gün
                        $('#tkvimCma').attr('checked', true);
                        bildDegisiklik.push(0);
                    } else {
                        $('#tkvimCma').attr('checked', false);
                        bildDegisiklik.push(1);
                    }
                    if (cevap.result.Cmt != 1) {//geliyor o gün
                        $('#tkvimCmt').attr('checked', true);
                        bildDegisiklik.push(0);
                    } else {
                        $('#tkvimCmt').attr('checked', false);
                        bildDegisiklik.push(1);
                    }
                    if (cevap.result.Pzr != 1) {//geliyor o gün
                        $('#tkvimPzr').attr('checked', true);
                        bildDegisiklik.push(0);
                    } else {
                        $('#tkvimPzr').attr('checked', false);
                        bildDegisiklik.push(1);
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#turbildirim', function () {
        $("#bilYaziBnInGid").hide();
        $("#bilYaziBnInDon").hide();
        $("#bilYaziBtsGid").hide();
        $("#bilYaziBtsDon").hide();
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        var giddon = $("input[name=turGidisDonus]").val();
        $.ajax({
            data: {"ogr_id": ogr_id, "firma_id": firma_id, "lang": lang,
                "giddon": giddon, "tip": "turbildirim"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    if (giddon != 1) {//gidiş
                        $("#bilYaziBnInGid").show();
                        $("#bilYaziBtsGid").show();
                    } else {
                        $("#bilYaziBnInDon").show();
                        $("#bilYaziBtsDon").show();
                    }
                    turBildirim = [];
                    if (cevap.result.Basla != 0) {
                        $('#bilBasla').attr('checked', true);
                        turBildirim.push(1);
                    } else {
                        $('#bilBasla').attr('checked', false);
                        turBildirim.push(0);
                    }
                    if (cevap.result.Yaklas != 0) {
                        $('#bildYaklas').attr('checked', true);
                        turBildirim.push(1);
                    } else {
                        $('#bildYaklas').attr('checked', false);
                        turBildirim.push(0);
                    }
                    if (cevap.result.BinInBin != 0) {
                        $('#bildInmeBinme').attr('checked', true);
                        turBildirim.push(1);
                    } else {
                        $('#bildInmeBinme').attr('checked', false);
                        turBildirim.push(0);
                    }
                    if (cevap.result.Bitti != 0) {
                        $('#bildBitis').attr('checked', true);
                        turBildirim.push(1);
                    } else {
                        $('#bildBitis').attr('checked', false);
                        turBildirim.push(0);
                    }
                    modal.hide();
                }
            }
        });
        modal.hide();
    });
    $(document).on('pageinit', '#aracLocTurListe', function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        $.ajax({
            data: {"ogr_id": ogr_id, "firma_id": firma_id,
                "lang": lang, "tip": "aracLocTurListe"},
            success: function (cevap) {
                if (cevap.hata) {
                    modal.hide();
                    ons.notification.alert({message: cevap.hata});
                } else {
                    if (cevap.result[0]) {
                        $("#aktifTurListNone").hide();
                        $("#turAktifList").show();
                        var onsList = $("#turAktifList");
                        var elm = $('<ons-list-item modifier="chevron" onclick="$.OgrenciIslemler.turAktifList()">'
                                + '<ons-row><ons-col width="40px"><i class="fa fa-refresh"></i></ons-col>'
                                + '<ons-col class="coldty">' + cevap.result[0].TurAd + "  ( " + cevap.result[0].KurumAd + " )" + '</ons-col></ons-row></ons-list-item>');
                        elm.appendTo(onsList);
                        ons.compile(elm[0]);
                        $("input[name=aktifTurAracId]").val(cevap.result[0].AracID);
                        $("input[name=aktifTurAracPlaka]").val(cevap.result[0].AracPlaka);
                        $("input[name=aktifTurId]").val(cevap.result[0].TurID);
                        $("input[name=aktifTurTip]").val(cevap.result[0].TurTip);
                        $("input[name=aktifTurKurumId]").val(cevap.result[0].KurumID);
                        $("input[name=aktifTurKurumAd]").val(cevap.result[0].KurumAd);
                        $("input[name=aktifTurKurumLoc]").val(cevap.result[0].KurumLoc);
                        $("input[name=aktifTurSfrID]").val(cevap.result[0].SoforID);
                        $("input[name=aktifTurSfrAd]").val(cevap.result[0].SoforAd);
                        $("input[name=aktifTurSfrLoc]").val(cevap.result[0].SoforLoc);
                        $("input[name=aktifTurKm]").val(cevap.result[0].TurKm);
                        $("input[name=aktifTurGidDon]").val(cevap.result[0].GidDon);
                    } else {
                        $("#aktifTurListNo").text(cevap.result[1][0].Yok);
                    }
                }
                modal.hide();
            }
        });
    });
    $(document).on('pageinit', '#aracLokasyon', function () {
        haritaGostermeDeger = 0;
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        var turGidisDonus = $("input[name=aktifTurGidDon]").val();
        if (turGidisDonus != 1) {
            $("#anlikLocGidDon").text(jsDil.GidisTur);
        } else {
            $("#anlikLocGidDon").text(jsDil.DonusTur);
        }
        var aracID = $("input[name=aktifTurAracId]").val();
        var aracPlaka = $("input[name=aktifTurAracPlaka]").val();
        var turID = $("input[name=aktifTurId]").val();
        var turTipID = $("input[name=aktifTurTip]").val();
        var kurumAd = $("input[name=aktifTurKurumAd]").val();
        var kurumID = $("input[name=aktifTurKurumId]").val();
        var kurumLocation = $("input[name=aktifTurKurumLoc]").val();
        var haritadeger = 0;
        refreshInterval = setInterval(function () {
            $.ajax({
                data: {"ogr_id": ogr_id, "firma_id": firma_id,
                    "lang": lang, "aracID": aracID, "turID": turID, "turTipID": turTipID,
                    "turGidisDonus": turGidisDonus, "tip": "aracLokasyonDetail"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap) {
                            modal.hide();
                            //gidiş değerleri
                            binen = [];
                            binmeyen = [];
                            //dönüş değerleri
                            inen = [];
                            inmeyen = [];
                            //ortak değerler
                            kurum = [];
                            arac = [];

                            var kurumLoc = kurumLocation.split(",");
                            kurum = Array(kurumAd, kurumID, kurumLoc[0], kurumLoc[1]);
                            var aracLokasyon = cevap.aracLokasyon;
                            var aracLoc = aracLokasyon.split(",");
                            var aracTrim = aracPlaka.trim();
                            arac = Array(aracTrim, aracLoc[0], aracLoc[1], aracID);
                            if (cevap.turBinemeyen) {//gidiş işlemleri
                                var length = cevap.turBinemeyen.TurBinmeyenAd.length;
                                for (var a = 0; a < length; a++) {
                                    var kisiAd = cevap.turBinemeyen.TurBinmeyenAd[a];
                                    var kisiLoc = cevap.turBinemeyen.TurBinmeyenLocation[a].split(",");
                                    var kisiID = cevap.turBinemeyen.TurBinmeyenID[a];
                                    var kisiTip = cevap.turBinemeyen.TurBinmeyenTip[a];
                                    binmeyen[a] = Array(kisiAd, kisiLoc[0], kisiLoc[1], kisiID, kisiTip);
                                }
                                if (cevap.turBinen) {
                                    var length1 = cevap.turBinen.TurBinenAd.length;
                                    for (var b = 0; b < length1; b++) {
                                        var kisiBinenAd = cevap.turBinen.TurBinenAd[b];
                                        var kisiBinenLoc = cevap.turBinen.TurBinenLocation[b].split(",");
                                        var kisiBinenID = cevap.turBinen.TurBinenID[b];
                                        var kisiBinenTip = cevap.turBinen.TurBinenTip[b];
                                        binen[b] = Array(kisiBinenAd, kisiBinenLoc[0], kisiBinenLoc[1], kisiBinenID, kisiBinenTip);
                                    }
                                }
                                if (haritadeger == 0) {
                                    haritadeger++;
                                    aracLokasyonGidisMapping();
                                    google.maps.event.addDomListener(window, 'load', aracLokasyonGidisMapping);
                                }
                            } else if (cevap.turInemeyen) {//dönüş işlemleri
                                var length = cevap.turInemeyen.TurInmeyenAd.length;
                                for (var a = 0; a < length; a++) {
                                    var kisiAd = cevap.turInemeyen.TurInmeyenAd[a];
                                    var kisiLoc = cevap.turInemeyen.TurInmeyenLocation[a].split(",");
                                    var kisiID = cevap.turInemeyen.TurInmeyenID[a];
                                    var kisiTip = cevap.turInemeyen.TurInmeyenTip[a];
                                    inmeyen[a] = Array(kisiAd, kisiLoc[0], kisiLoc[1], kisiID, kisiTip);
                                }
                                if (cevap.turInen) {
                                    var length1 = cevap.turInen.TurInenAd.length;
                                    for (var b = 0; b < length1; b++) {
                                        var kisiInenAd = cevap.turInen.TurInenAd[b];
                                        var kisiInenLoc = cevap.turInen.TurInenLocation[b].split(",");
                                        var kisiInenID = cevap.turInen.TurInenID[b];
                                        var kisiInenTip = cevap.turInen.TurInenTip[b];
                                        inen[b] = Array(kisiInenAd, kisiInenLoc[0], kisiInenLoc[1], kisiInenID, kisiInenTip);
                                    }
                                }
                                if (haritadeger == 0) {
                                    haritadeger++;
                                    aracLokasyonDonusMapping();
                                    google.maps.event.addDomListener(window, 'load', aracLokasyonDonusMapping);
                                }
                            }
                        }
                    }
                }
            });
        }, 2000);
    });
});
$.OgrenciIslemler = {
    ogrVeliList: function (deger) {
        ogrenciNavigator.pushPage('veliprofilliste.html', {animation: 'slide', veliID: deger});
    },
    ogrKurumList: function (deger) {
        ogrenciNavigator.pushPage('kurumdetay.html', {animation: 'slide', kurumID: deger});
    },
    turList: function (deger) {
        ogrenciNavigator.pushPage('turdetayliste.html', {animation: 'slide', turID: deger});
    },
    turDetayList: function (turgd) {
        ogrenciNavigator.pushPage('turgiddon.html', {animation: 'slide', turgd: turgd});
    },
    bildAyarKaydet: function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        var giddon = $("input[name=turGidisDonus]").val();
        var listv = $("#ogrBildAyarList> ons-list-item").length;
        for (var v = 0; v < listv; v++) {
            var chechked = $("#ogrBildAyarList> ons-list-item:eq(" + v + ")>label>input").prop("checked");
            if (chechked != false) {
                var chechkedtext = $("#ogrBildAyarList> ons-list-item:eq(" + v + ") > label").text();
                var bilval = $("#ogrBildAyarList> ons-list-item:eq(" + v + ") > label > input").val();
            }
        }
        $.ajax({
            data: {"ogr_id": ogr_id, "firma_id": firma_id, "lang": lang,
                "giddon": giddon, "bilval": bilval,
                "bildayarDeger": bildayarDeger, "tip": "bilmesafayarkaydet"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: cevap.hata});
                    return false;
                } else {
                    ons.notification.alert({message: cevap.update});
                    modal.hide();
                    ogrenciNavigator.popPage();
                }
            }
        });
    },
    hftlikTakvimKaydet: function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        var giddon = $("input[name=turGidisDonus]").val();
        var turid = $("input[name=turListItem]").val();
        var turtip = $("input[name=turListTip]").val();
        var chechkedPzt = $("#tkvimPzt").prop("checked");
        if (chechkedPzt != false) {
            var Pzt = 0;
        } else {
            var Pzt = 1;
        }
        var chechkedSli = $("#tkvimSli").prop("checked");
        if (chechkedSli != false) {
            var Sli = 0;
        } else {
            var Sli = 1;
        }
        var chechkedCrs = $("#tkvimCrs").prop("checked");
        if (chechkedCrs != false) {
            var Crs = 0;
        } else {
            var Crs = 1;
        }
        var chechkedPrs = $("#tkvimPrs").prop("checked");
        if (chechkedPrs != false) {
            var Prs = 0;
        } else {
            var Prs = 1;
        }
        var chechkedCma = $("#tkvimCma").prop("checked");
        if (chechkedCma != false) {
            var Cma = 0;
        } else {
            var Cma = 1;
        }
        var chechkedCmt = $("#tkvimCmt").prop("checked");
        if (chechkedCmt != false) {
            var Cmt = 0;
        } else {
            var Cmt = 1;
        }
        var chechkedPzr = $("#tkvimPzr").prop("checked");
        if (chechkedPzr != false) {
            var Pzr = 0;
        } else {
            var Pzr = 1;
        }
        if (bildDegisiklik[0] == Pzt && bildDegisiklik[1] == Sli && bildDegisiklik[2] == Crs
                && bildDegisiklik[3] == Prs && bildDegisiklik[4] == Cma && bildDegisiklik[5] == Cmt && bildDegisiklik[6] == Pzr) {
            ons.notification.alert({message: jsDil.DegisiklikYok});
            return false;
        } else {
            $.ajax({
                data: {"ogr_id": ogr_id, "firma_id": firma_id, "lang": lang,
                    "giddon": giddon, "turid": turid, "turtip": turtip,
                    "Pzt": Pzt, "Sli": Sli,
                    "Crs": Crs, "Prs": Prs, "Cma": Cma, "Cmt": Cmt, "Pzr": Pzr,
                    "tip": "hftlikTkvimKaydet"},
                success: function (cevap) {
                    if (cevap.hata) {
                        ons.notification.alert({message: cevap.hata});
                        return false;
                    } else {
                        ons.notification.alert({message: cevap.result});
                        modal.hide();
                        ogrenciNavigator.popPage();
                    }
                }
            });
        }
    },
    turBildirimKydt: function () {
        var ogr_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var lang = $("input[name=lang]").val();
        var giddon = $("input[name=turGidisDonus]").val();
        var android_id = $("input[name=android_id]").val();
        var chechkedBsla = $("#bilBasla").prop("checked");
        if (chechkedBsla != true) {
            var Basla = 0;
        } else {
            var Basla = 1;
        }
        var chechkedYakls = $("#bildYaklas").prop("checked");
        if (chechkedYakls != true) {
            var Yaklas = 0;
        } else {
            var Yaklas = 1;
        }
        var chechkedInBin = $("#bildInmeBinme").prop("checked");
        if (chechkedInBin != true) {
            var InBin = 0;
        } else {
            var InBin = 1;
        }
        var chechkedBts = $("#bildBitis").prop("checked");
        if (chechkedBts != true) {
            var Bts = 0;
        } else {
            var Bts = 1;
        }
        if (turBildirim[0] == Basla && turBildirim[1] == Yaklas && turBildirim[2] == InBin && turBildirim[3] == Bts) {
            ons.notification.alert({message: jsDil.DegisiklikYok});
            return false;
        } else {
            $.ajax({
                data: {"ogr_id": ogr_id, "firma_id": firma_id, "lang": lang,
                    "giddon": giddon, "android_id": android_id, "Basla": Basla,
                    "Yaklas": Yaklas, "InBin": InBin,
                    "Bts": Bts, "tip": "bldrimKaydet"},
                success: function (cevap) {
                    if (cevap.hata) {
                        ons.notification.alert({message: cevap.hata});
                        return false;
                    } else {
                        ons.notification.alert({message: cevap.result});
                        modal.hide();
                        ogrenciNavigator.popPage();
                    }
                }
            });
        }
    },
    turAktifList: function () {
        ogrenciNavigator.pushPage('araclokasyon.html', {animation: 'slide'});
    },
    anlikLocStop: function () {
        clearInterval(refreshInterval);
        clearInterval(Interval);
        ogrenciNavigator.popPage();
    },
}
function Mobileinitialize(Mobileenlem, Mobileboylam) {
    var mapOptions = {
        zoom: 12,
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.TOP_CENTER
        },
        zoomControl: true,
        zoomControlOptions: {
            position: google.maps.ControlPosition.RIGHT_CENTER
        },
        scaleControl: true,
        streetViewControl: true,
        streetViewControlOptions: {
            position: google.maps.ControlPosition.LEFT_TOP
        }
    };
    var map = new google.maps.Map(document.getElementById('veli_map'),
            mapOptions);
    //enlem boylam buraya gelecek
    var pos = new google.maps.LatLng(Mobileenlem,
            Mobileboylam);
    var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
        content: jsDil.VeliKonum
    });
    map.setCenter(pos);
}
function MobileeInitialize(lokasyon, adres, tip) {
    var mapOptions = {
        zoom: 12,
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.TOP_CENTER
        },
        zoomControl: true,
        zoomControlOptions: {
            position: google.maps.ControlPosition.RIGHT_CENTER
        },
        scaleControl: true,
        streetViewControl: true,
        streetViewControlOptions: {
            position: google.maps.ControlPosition.LEFT_TOP
        }
    };

    var map = new google.maps.Map(document.getElementById('sofor_map'),
            mapOptions);

    //son eklenen locationu haritada görme
    if (lokasyon != '') {
        var posSplitValue = lokasyon.split(",");
        var pos = new google.maps.LatLng(posSplitValue[0],
                posSplitValue[1]);
        var infowindow = new google.maps.InfoWindow({
            map: map,
            position: pos,
            content: adres
        });
        if (tip == 0) {//şoför
            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                icon: SITE_URL + '/Plugins/mapView/driver.png'
            });
        } else if (tip == 1) {//hostes
            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                icon: SITE_URL + '/Plugins/mapView/hostes.png'
            });
        } else {//kurum
            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                icon: SITE_URL + '/Plugins/mapView/build.png'
            });
        }
    }
    //enlem boylam buraya gelecek
    var mobilEnlem = $("input[name=enlem]").val();
    var mobilBoylam = $("input[name=boylam]").val();
    var pos1 = new google.maps.LatLng(mobilEnlem,
            mobilBoylam);
    var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos1,
        content: jsDil.Konum
    });
    map.setCenter(pos);
}
function turLokasyon() {
    /*
     * Gelen tür      * 0->Öğrenci
     * 1->İşçi
     * 2->Arac
     * 3->Okul
     */
    var lokasyonlar = new Array();
    var title = new Array();
    var idler = new Array();
    var markerTur = new Array();
    var locations = new Array();
    var icons = new Array();
    var markers = new Array();
    var iconsLength;
    var map;
    var wh = $(window).height();
    var fh = 0;
    var mh = wh - fh;
    $("#multiple_lokasyon_map").height(mh);
    var directionsDisplay = [];
    var directionsService = [];
    var infobox;
    /*
     * Burada gelen seçilşmiş kişinin tipinin öğrenci ve id sii biliyorum ona göre bu kısımda fark oluşturabilirim.
     * Yani sizin öğrenciniz tur da bu ksıımda yer almaktadır şeklinde.İconunun rengini farklı yapabilirim.
     * 
     * @type @exp;turList@pro;length
     */
    var ogrid = $("input[name=id]").val();
    var inmeyenLength = turList.length;
    if (navigator.geolocation) {
        if (inmeyenLength > 0) {
            for (var inmeyenicon = 0; inmeyenicon < inmeyenLength; inmeyenicon++) {
                if (turList[inmeyenicon][4] != 1) {//öğrenci
                    if (turList[inmeyenicon][3] != ogrid) {
                        icons.push(SITE_URL + 'Plugins/mapView/green_student.png');
                        lokasyonlar.push([turList[inmeyenicon][1], turList[inmeyenicon][2]]);
                        title.push(turList[inmeyenicon][0]);
                        idler.push(turList[inmeyenicon][3]);
                    } else {
                        icons.push(SITE_URL + 'Plugins/mapView/red_student.png');
                        lokasyonlar.push([turList[inmeyenicon][1], turList[inmeyenicon][2]]);
                        title.push(turList[inmeyenicon][0]);
                        idler.push(turList[inmeyenicon][3]);
                        var newPos = new google.maps.LatLng(turList[inmeyenicon][1], turList[inmeyenicon][2]);
                    }
                } else {//personel
                    icons.push(SITE_URL + 'Plugins/mapView/employee_green.png');
                    lokasyonlar.push([turList[inmeyenicon][1], turList[inmeyenicon][2]]);
                    title.push(turList[inmeyenicon][0]);
                    idler.push(turList[inmeyenicon][3]);
                }
            }
            icons.push(SITE_URL + 'Plugins/mapView/build.png');
            lokasyonlar.push([kurum[2], kurum[3]]);
            title.push(kurum[0]);
            idler.push(kurum[1]);
        }

        iconsLength = icons.length;
        var mapOptions = {
            zoom: 12,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.TOP_CENTER
            },
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            scaleControl: true,
            streetViewControl: true,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.LEFT_TOP
            }
        };

        var map = new google.maps.Map(document.getElementById('multiple_lokasyon_map'),
                mapOptions);
        var infowindow = new google.maps.InfoWindow({
            map: map,
            position: newPos,
            content: jsDil.SizKonum
        });
        infobox = new InfoBox({
            content: document.getElementById("infobox"),
            disableAutoPan: false,
            maxWidth: 150,
            alignBottom: false,
            pixelOffset: new google.maps.Size(-140, 0),
            boxStyle: {
                background: "url('http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/examples/tipbox.gif') no-repeat",
                opacity: 1.75,
                width: "280px"
            },
            closeBoxMargin: "12px 4px 2px 2px",
            closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
            infoBoxClearance: new google.maps.Size(1, 1)
        });
        var markerImage = 'http://www.mapsmarker.com/wp-content/uploads/leaflet-maps-marker-icons/bar_coktail.png';
        var b = 0;
        var marker;
        var number = 0;
        var iconCounter = 0;
        locations = [];
        var interval = setInterval(function () {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(lokasyonlar[b][0], lokasyonlar[b][1]),
                map: map,
                icon: icons[iconCounter],
                title: title[b],
                id: idler[b],
                number: number
            });
            locations.push(new google.maps.LatLng(lokasyonlar[b][0], lokasyonlar[b][1]));
            markers.push(marker);
            (function (marker, b) {
                google.maps.event.addListener(marker, "click", function (e) {
                    $("#infobox").text(this.title);
                    infobox.open(map, marker);
                });
            })(marker, b);
            number++;
            b++;
            if (b == lokasyonlar.length) {
                clearInterval(interval);
            }
            iconCounter++;
            if (iconCounter >= iconsLength) {
                hesapRoute();
            }
        }, 200);
        function setAllMap(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }
        //hesaplama fonksiyonu
        function hesapRoute() {
            var m = locations.length;
            var index = 0;
            while (m != 0) {
                if (m < 3) {
                    var tmp_locations = new Array();
                    for (var j = index; j < locations.length; j++) {
                        tmp_locations.push(locations[index]);
                    }
                    cizRouteMap(tmp_locations);
                    m = 0;
                    index = locations.length;
                }

                if (m >= 3 && m <= 10) {
                    var tmp_locations = new Array();
                    for (var j = index; j < locations.length; j++) {
                        tmp_locations.push(locations[j]);
                    }
                    cizRouteMap(tmp_locations);
                    m = 0;
                    index = locations.length;
                }

                if (m >= 10) {
                    var tmp_locations = new Array();
                    for (var j = index; j < index + 10; j++) {
                        tmp_locations.push(locations[j]);
                    }
                    cizRouteMap(tmp_locations);
                    m = m - 9;
                    index = index + 9;
                }
            }
        }
        map.setCenter(newPos);
        //route çizdirme
        function cizRouteMap(locations) {
            var start, end;
            var waypts = [];
            for (var k = 0; k < locations.length; k++) {
                if (k >= 1 && k <= locations.length - 2) {
                    waypts.push({
                        location: locations[k],
                        stopover: true
                    });
                }
                if (k == 0)
                    start = locations[k];
                if (k == locations.length - 1)
                    end = locations[k];
            }
            var request = {
                origin: start,
                destination: end,
                waypoints: waypts,
                optimizeWaypoints: true,
                travelMode: google.maps.TravelMode.DRIVING
            };
            directionsService.push(new google.maps.DirectionsService());
            var instance = directionsService.length - 1;
            directionsDisplay.push(new google.maps.DirectionsRenderer({
                preserveViewport: true
            }));
            directionsDisplay[instance].setOptions({suppressMarkers: true});
            directionsDisplay[instance].setMap(map);
            directionsService[instance].route(request, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay[instance].setDirections(response);
                    totalKm(response);
                }
            });
        }         //total Km
        function totalKm(result) {
            var total = 0;
            var myroute = result.routes[0];
            for (var i = 0; i < myroute.legs.length; i++) {
                total += myroute.legs[i].distance.value;
            }
            total = total / 1000.0;
            document.getElementById('totalKm').innerHTML = total + ' Km';
        }
        //marker animatioın
        function toggleBounce() {

            if (marker.getAnimation() != null) {
                marker.setAnimation(null);
            } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            }
        }
        //tur animasyonu(Çok Fazla şekilde sistemsel olarak zayıflamaya yol açacağından sonra kullanılamk üzre bırakılmıştır.)
        function animateCircle() {
            var count = 0;
            window.setInterval(function () {
                count = (count + 1) % 200;
                var icons = line.get('icons');
                icons[0].offset = (count / 2) + '%';
                line.set('icons', icons);
            }, 20);
        }

    } else {
        document.getElementById('google_canvas').innerHTML = 'Konumunuz bulunmadı.';
    }
}
//araç map gidiş işlemleri
function aracLokasyonGidisMapping() {
    /*
     * Gelen tür
     * 0->Öğrenci
     * 1->İşçi
     * 2->Arac
     * 3->Okul
     */
    var lokasyonlar = new Array();
    var title = new Array();
    var idler = new Array();
    var markerTur = new Array();
    var locations = new Array();
    var icons = new Array();
    var markers = new Array();
    var iconsLength;
    var map;
    var directionsDisplay = [];
    var directionsService = [];
    var infobox;
    var aracLength = arac.length;
    var binmeyenLength = binmeyen.length;
    var binenLength = binen.length;
    if (navigator.geolocation) {
        function intervalDegerler() {
            lokasyonlar = [];
            title = [];
            idler = [];
            markerTur = [];
            locations = [];
            var aracLength = arac.length;
            var binmeyenLength = binmeyen.length;
            var binenLength = binen.length;
            icons = [];
            if (aracLength != 0) {//araç bilgiler
                icons.push(SITE_URL + '/Plugins/mapView/driver.png');
                //arac bilgiler
                lokasyonlar.push([arac[1], arac[2]]);
                title.push(arac[0]);
                idler.push(arac[3]);
                markerTur.push(2);
                //binen yolcular varsa
                if (binenLength > 0) {
                    for (var binenicon = 0; binenicon < binenLength; binenicon++) {
                        if (binen[binenicon][4] != 1) {//öğrenci
                            icons.push(SITE_URL + '/Plugins/mapView/green_student.png');
                            lokasyonlar.push([binen[binenicon][1], binen[binenicon][2]]);
                            title.push(binen[binenicon][0]);
                            idler.push(binen[binenicon][3]);
                            markerTur.push(0);
                        } else {//personel
                            icons.push(SITE_URL + '/Plugins/mapView/employee_green.png');
                            lokasyonlar.push([binen[binenicon][1], binen[binenicon][2]]);
                            title.push(binen[binenicon][0]);
                            idler.push(binen[binenicon][3]);
                            markerTur.push(1);
                        }
                    }
                }
                //binmeyen yolcular varsa
                if (binmeyenLength > 0) {
                    for (var binmeyenicon = 0; binmeyenicon < binmeyenLength; binmeyenicon++) {
                        if (binmeyen[binmeyenicon][4] != 1) {//öğrenci
                            icons.push(SITE_URL + '/Plugins/mapView/red_student.png');
                            lokasyonlar.push([binmeyen[binmeyenicon][1], binmeyen[binmeyenicon][2]]);
                            title.push(binmeyen[binmeyenicon][0]);
                            idler.push(binmeyen[binmeyenicon][3]);
                            markerTur.push(1);
                        } else {//personel
                            icons.push(SITE_URL + '/Plugins/mapView/employee_red.png');
                            lokasyonlar.push([binmeyen[binmeyenicon][1], binmeyen[binmeyenicon][2]]);
                            title.push(binmeyen[binmeyenicon][0]);
                            idler.push(binmeyen[binmeyenicon][3]);
                            markerTur.push(1);
                        }
                    }
                }
                icons.push(SITE_URL + '/Plugins/mapView/build.png');
                lokasyonlar.push([kurum[2], kurum[3]]);
                title.push(kurum[0]);
                idler.push(kurum[1]);
                markerTur.push(3);
            }
            iconsLength = icons.length;
        }
        if (aracLength != 0) {//araç bilgiler
            icons.push(SITE_URL + '/Plugins/mapView/driver.png');
            //arac bilgiler
            lokasyonlar.push([arac[1], arac[2]]);
            title.push(arac[0]);
            idler.push(arac[3]);
            markerTur.push(2);
            //binen yolcular varsa
            if (binenLength > 0) {
                for (var binenicon = 0; binenicon < binenLength; binenicon++) {
                    if (binen[binenicon][4] != 1) {//öğrenci
                        icons.push(SITE_URL + '/Plugins/mapView/green_student.png');
                        lokasyonlar.push([binen[binenicon][1], binen[binenicon][2]]);
                        title.push(binen[binenicon][0]);
                        idler.push(binen[binenicon][3]);
                        markerTur.push(0);
                    } else {//personel
                        icons.push(SITE_URL + '/Plugins/mapView/employee_green.png');
                        lokasyonlar.push([binen[binenicon][1], binen[binenicon][2]]);
                        title.push(binen[binenicon][0]);
                        idler.push(binen[binenicon][3]);
                        markerTur.push(1);
                    }
                }
            }
            //binmeyen yolcular varsa
            if (binmeyenLength > 0) {
                for (var binmeyenicon = 0; binmeyenicon < binmeyenLength; binmeyenicon++) {
                    if (binmeyen[binmeyenicon][4] != 1) {//öğrenci
                        icons.push(SITE_URL + '/Plugins/mapView/red_student.png');
                        lokasyonlar.push([binmeyen[binmeyenicon][1], binmeyen[binmeyenicon][2]]);
                        title.push(binmeyen[binmeyenicon][0]);
                        idler.push(binmeyen[binmeyenicon][3]);
                        markerTur.push(1);
                    } else {//personel
                        icons.push(SITE_URL + '/Plugins/mapView/employee_red.png');
                        lokasyonlar.push([binmeyen[binmeyenicon][1], binmeyen[binmeyenicon][2]]);
                        title.push(binmeyen[binmeyenicon][0]);
                        idler.push(binmeyen[binmeyenicon][3]);
                        markerTur.push(1);
                    }
                }
            }
            icons.push(SITE_URL + '/Plugins/mapView/build.png');
            lokasyonlar.push([kurum[2], kurum[3]]);
            title.push(kurum[0]);
            idler.push(kurum[1]);
            markerTur.push(3);
        }
        iconsLength = icons.length;

        var mapOptions = {
            zoom: 12,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.TOP_CENTER
            },
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            scaleControl: true,
            streetViewControl: true,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.LEFT_TOP
            }
        };
        var newPos = new google.maps.LatLng(arac[1], arac[2]);
        var map = new google.maps.Map(document.getElementById('multiple_aracloc_map'),
                mapOptions);
        infobox = new InfoBox({
            content: document.getElementById("infobox"),
            disableAutoPan: false,
            maxWidth: 150,
            alignBottom: false,
            pixelOffset: new google.maps.Size(-140, 0),
            boxStyle: {
                background: "url('http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/examples/tipbox.gif') no-repeat",
                opacity: 1.75,
                width: "280px"
            },
            closeBoxMargin: "12px 4px 2px 2px",
            closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
            infoBoxClearance: new google.maps.Size(1, 1)
        });
        var degerler = 0;
        Interval = setInterval(function () {
            setAllMap(null);
            markers = [];
            var marker;
            var number = 0;
            var iconCounter = 0;
            locations = [];
            if (degerler == 1) {
                intervalDegerler();
            }
            var b = 0;
            for (var i = 0; i < lokasyonlar.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(lokasyonlar[b][0], lokasyonlar[b][1]),
                    map: map,
                    icon: icons[iconCounter],
                    title: title[b],
                    id: idler[b],
                    tur: markerTur[b],
                    number: number
                });
                locations.push(new google.maps.LatLng(lokasyonlar[b][0], lokasyonlar[b][1]));
                markers.push(marker);
                (function (marker, b) {
                    google.maps.event.addListener(marker, "click", function (e) {
                        $("#infobox").text(this.title);
                        infobox.open(map, marker);
                    });
                })(marker, b);
                number++;
                b++;
                iconCounter++;
                if (iconCounter >= iconsLength) {
                    iconCounter = 0;
                    locations.shift();
                    degerler = 1;
                    if (haritaGostermeDeger == 0) {
                        hesapRoute();
                    }
                }
            }
        }, 1000);
        function setAllMap(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }
        //hesaplama fonksiyonu
        function hesapRoute() {
            var m = locations.length;
            var index = 0;
            while (m != 0) {
                if (m < 3) {
                    var tmp_locations = new Array();
                    for (var j = index; j < locations.length; j++) {
                        tmp_locations.push(locations[index]);
                    }
                    cizRouteMap(tmp_locations);
                    m = 0;
                    index = locations.length;
                }

                if (m >= 3 && m <= 10) {
                    var tmp_locations = new Array();
                    for (var j = index; j < locations.length; j++) {
                        tmp_locations.push(locations[j]);
                    }
                    cizRouteMap(tmp_locations);
                    m = 0;
                    index = locations.length;
                }

                if (m >= 10) {
                    var tmp_locations = new Array();
                    for (var j = index; j < index + 10; j++) {
                        tmp_locations.push(locations[j]);
                    }
                    cizRouteMap(tmp_locations);
                    m = m - 9;
                    index = index + 9;
                }
            }
        }
        map.setCenter(newPos);
        //route çizdirme
        function cizRouteMap(locations) {
            var start, end;
            var waypts = [];
            for (var k = 0; k < locations.length; k++) {
                if (k >= 1 && k <= locations.length - 2) {
                    waypts.push({
                        location: locations[k],
                        stopover: true
                    });
                }
                if (k == 0)
                    start = locations[k];
                if (k == locations.length - 1)
                    end = locations[k];
            }
            var request = {
                origin: start,
                destination: end,
                waypoints: waypts,
                optimizeWaypoints: true,
                travelMode: google.maps.TravelMode.DRIVING
            };
            directionsService.push(new google.maps.DirectionsService());
            var instance = directionsService.length - 1;
            directionsDisplay.push(new google.maps.DirectionsRenderer({
                preserveViewport: true
            }));
            directionsDisplay[instance].setOptions({suppressMarkers: true});
            directionsDisplay[instance].setMap(map);
            directionsService[instance].route(request, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay[instance].setDirections(response);
                    totalKm(response);
                }
            });
        }
        //total Km
        function totalKm(result) {
            var total = 0;
            var myroute = result.routes[0];
            for (var i = 0; i < myroute.legs.length; i++) {
                total += myroute.legs[i].distance.value;
            }
            total = total / 1000.0;
            document.getElementById('totalKm').innerHTML = total + ' Km';
            haritaGostermeDeger = 1;
        }
        //marker animatioın
        function toggleBounce() {

            if (marker.getAnimation() != null) {
                marker.setAnimation(null);
            } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            }
        }
        //tur animasyonu(Çok Fazla şekilde sistemsel olarak zayıflamaya yol açacağından sonra kullanılamk üzre bırakılmıştır.)
        function animateCircle() {
            var count = 0;
            window.setInterval(function () {
                count = (count + 1) % 200;
                var icons = line.get('icons');
                icons[0].offset = (count / 2) + '%';
                line.set('icons', icons);
            }, 20);
        }

    } else {
        document.getElementById('google_canvas').innerHTML = 'Konumunuz bulunmadı.';
    }
}
//End araç map gidiş işlemleri
//araç map dönüş işlemleri
function aracLokasyonDonusMapping() {
    /*
     * Gelen tür
     * 0->Öğrenci
     * 1->İşçi
     * 2->Arac
     * 3->Okul
     */
    var lokasyonlar = new Array();
    var title = new Array();
    var idler = new Array();
    var markerTur = new Array();
    var locations = new Array();
    var icons = new Array();
    var markers = new Array();
    var iconsLength;
    var map;
    var hh = $(".wrapper").height();
    var hd = $("#hd").height();
    var kmh = $("#kmHeader").height();
    var h = hd + kmh;
    var sh = hh - h;
    $("#multiple_aracloc_map").height(sh);
    var directionsDisplay = [];
    var directionsService = [];
    var infobox;
    var aracLength = arac.length;
    var inmeyenLength = inmeyen.length;
    var inenLength = inen.length;
    if (navigator.geolocation) {
        function intervalDegerler() {
            lokasyonlar = [];
            title = [];
            idler = [];
            markerTur = [];
            locations = [];
            var aracLength = arac.length;
            var inmeyenLength = inmeyen.length;
            var inenLength = inen.length;
            icons = [];
            if (aracLength != 0) {//araç bilgiler
                icons.push(SITE_URL + '/Plugins/mapView/driver.png');
                //arac bilgiler
                lokasyonlar.push([arac[1], arac[2]]);
                title.push(arac[0]);
                idler.push(arac[3]);
                markerTur.push(2);
                //inmeyen yolcular varsa
                if (inmeyenLength > 0) {
                    for (var inmeyenicon = 0; inmeyenicon < inmeyenLength; inmeyenicon++) {
                        if (inmeyen[inmeyenicon][4] != 1) {//öğrenci
                            icons.push(SITE_URL + '/Plugins/mapView/red_student.png');
                            lokasyonlar.push([inmeyen[inmeyenicon][1], inmeyen[inmeyenicon][2]]);
                            title.push(inmeyen[inmeyenicon][0]);
                            idler.push(inmeyen[inmeyenicon][3]);
                            markerTur.push(1);
                        } else {//personel
                            icons.push(SITE_URL + '/Plugins/mapView/employee_red.png');
                            lokasyonlar.push([inmeyen[inmeyenicon][1], inmeyen[inmeyenicon][2]]);
                            title.push(inmeyen[inmeyenicon][0]);
                            idler.push(inmeyen[inmeyenicon][3]);
                            markerTur.push(1);
                        }
                    }
                }
                //inen yolcular varsa
                if (inenLength > 0) {
                    for (var inenicon = 0; inenicon < inenLength; inenicon++) {
                        if (inen[inenicon][4] != 1) {//öğrenci
                            icons.push(SITE_URL + '/Plugins/mapView/green_student.png');
                            lokasyonlar.push([inen[inenicon][1], inen[inenicon][2]]);
                            title.push(inen[inenicon][0]);
                            idler.push(inen[inenicon][3]);
                            markerTur.push(0);
                        } else {//personel
                            icons.push(SITE_URL + '/Plugins/mapView/employee_green.png');
                            lokasyonlar.push([inen[inenicon][1], inen[inenicon][2]]);
                            title.push(inen[inenicon][0]);
                            idler.push(inen[inenicon][3]);
                            markerTur.push(1);
                        }
                    }
                }
                icons.push(SITE_URL + '/Plugins/mapView/build.png');
                lokasyonlar.push([kurum[2], kurum[3]]);
                title.push(kurum[0]);
                idler.push(kurum[1]);
                markerTur.push(3);
            }
            iconsLength = icons.length;
        }
        if (aracLength != 0) {//araç bilgiler
            icons.push(SITE_URL + '/Plugins/mapView/driver.png');
            //arac bilgiler
            lokasyonlar.push([arac[1], arac[2]]);
            title.push(arac[0]);
            idler.push(arac[3]);
            markerTur.push(2);
            //inmeyen yolcular varsa
            if (inmeyenLength > 0) {
                for (var inmeyenicon = 0; inmeyenicon < inmeyenLength; inmeyenicon++) {
                    if (inmeyen[inmeyenicon][4] != 1) {//öğrenci
                        icons.push(SITE_URL + '/Plugins/mapView/red_student.png');
                        lokasyonlar.push([inmeyen[inmeyenicon][1], inmeyen[inmeyenicon][2]]);
                        title.push(inmeyen[inmeyenicon][0]);
                        idler.push(inmeyen[inmeyenicon][3]);
                        markerTur.push(1);
                    } else {//personel
                        icons.push(SITE_URL + '/Plugins/mapView/employee_red.png');
                        lokasyonlar.push([inmeyen[inmeyenicon][1], inmeyen[inmeyenicon][2]]);
                        title.push(inmeyen[inmeyenicon][0]);
                        idler.push(inmeyen[inmeyenicon][3]);
                        markerTur.push(1);
                    }
                }
            }
            //inen yolcular varsa
            if (inenLength > 0) {
                for (var inenicon = 0; inenicon < inenLength; inenicon++) {
                    if (inen[inenicon][4] != 1) {//öğrenci
                        icons.push(SITE_URL + '/Plugins/mapView/green_student.png');
                        lokasyonlar.push([inen[inenicon][1], inen[inenicon][2]]);
                        title.push(inen[inenicon][0]);
                        idler.push(inen[inenicon][3]);
                        markerTur.push(0);
                    } else {//personel
                        icons.push(SITE_URL + '/Plugins/mapView/employee_green.png');
                        lokasyonlar.push([inen[inenicon][1], inen[inenicon][2]]);
                        title.push(inen[inenicon][0]);
                        idler.push(inen[inenicon][3]);
                        markerTur.push(1);
                    }
                }
            }
            icons.push(SITE_URL + '/Plugins/mapView/build.png');
            lokasyonlar.push([kurum[2], kurum[3]]);
            title.push(kurum[0]);
            idler.push(kurum[1]);
            markerTur.push(3);
        }
        iconsLength = icons.length;

        var mapOptions = {
            zoom: 12,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.TOP_CENTER
            },
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            scaleControl: true,
            streetViewControl: true,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.LEFT_TOP
            }
        };
        var newPos = new google.maps.LatLng(arac[1], arac[2]);
        var map = new google.maps.Map(document.getElementById('multiple_aracloc_map'),
                mapOptions);
        infobox = new InfoBox({
            content: document.getElementById("infobox"),
            disableAutoPan: false,
            maxWidth: 150,
            alignBottom: false,
            pixelOffset: new google.maps.Size(-140, 0),
            boxStyle: {
                background: "url('http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/examples/tipbox.gif') no-repeat",
                opacity: 1.75,
                width: "280px"
            },
            closeBoxMargin: "12px 4px 2px 2px",
            closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
            infoBoxClearance: new google.maps.Size(1, 1)
        });
        var degerler = 0;
        Interval = setInterval(function () {
            setAllMap(null);
            markers = [];
            var marker;
            var number = 0;
            var iconCounter = 0;
            locations = [];
            if (degerler == 1) {
                intervalDegerler();
            }
            var b = 0;
            for (var i = 0; i < lokasyonlar.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(lokasyonlar[b][0], lokasyonlar[b][1]),
                    map: map,
                    icon: icons[iconCounter],
                    title: title[b],
                    id: idler[b],
                    tur: markerTur[b],
                    number: number
                });
                locations.push(new google.maps.LatLng(lokasyonlar[b][0], lokasyonlar[b][1]));
                markers.push(marker);
                (function (marker, b) {
                    google.maps.event.addListener(marker, "click", function (e) {
                        $("#infobox").text(this.title);
                        infobox.open(map, marker);
                    });
                })(marker, b);
                number++;
                b++;
                iconCounter++;
                if (iconCounter >= iconsLength) {
                    iconCounter = 0;
                    locations.shift();
                    degerler = 1;
                    if (haritaGostermeDeger == 0) {
                        hesapRoute();
                    }
                }
            }
        }, 1000);
        function setAllMap(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }
        //hesaplama fonksiyonu
        function hesapRoute() {
            var m = locations.length;
            var index = 0;
            while (m != 0) {
                if (m < 3) {
                    var tmp_locations = new Array();
                    for (var j = index; j < locations.length; j++) {
                        tmp_locations.push(locations[index]);
                    }
                    cizRouteMap(tmp_locations);
                    m = 0;
                    index = locations.length;
                }

                if (m >= 3 && m <= 10) {
                    var tmp_locations = new Array();
                    for (var j = index; j < locations.length; j++) {
                        tmp_locations.push(locations[j]);
                    }
                    cizRouteMap(tmp_locations);
                    m = 0;
                    index = locations.length;
                }

                if (m >= 10) {
                    var tmp_locations = new Array();
                    for (var j = index; j < index + 10; j++) {
                        tmp_locations.push(locations[j]);
                    }
                    cizRouteMap(tmp_locations);
                    m = m - 9;
                    index = index + 9;
                }
            }
        }
        map.setCenter(newPos);
        //route çizdirme
        function cizRouteMap(locations) {
            var start, end;
            var waypts = [];
            for (var k = 0; k < locations.length; k++) {
                if (k >= 1 && k <= locations.length - 2) {
                    waypts.push({
                        location: locations[k],
                        stopover: true
                    });
                }
                if (k == 0)
                    start = locations[k];
                if (k == locations.length - 1)
                    end = locations[k];
            }
            var request = {
                origin: start,
                destination: end,
                waypoints: waypts,
                optimizeWaypoints: true,
                travelMode: google.maps.TravelMode.DRIVING
            };
            directionsService.push(new google.maps.DirectionsService());
            var instance = directionsService.length - 1;
            directionsDisplay.push(new google.maps.DirectionsRenderer({
                preserveViewport: true
            }));
            directionsDisplay[instance].setOptions({suppressMarkers: true});
            directionsDisplay[instance].setMap(map);
            directionsService[instance].route(request, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay[instance].setDirections(response);
                    totalKm(response);
                }
            });
        }
        //total Km
        function totalKm(result) {
            var total = 0;
            var myroute = result.routes[0];
            for (var i = 0; i < myroute.legs.length; i++) {
                total += myroute.legs[i].distance.value;
            }
            total = total / 1000.0;
            document.getElementById('totalKm').innerHTML = total + ' Km';
            haritaGostermeDeger = 1;
        }
        //marker animatioın
        function toggleBounce() {

            if (marker.getAnimation() != null) {
                marker.setAnimation(null);
            } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            }
        }
        //tur animasyonu(Çok Fazla şekilde sistemsel olarak zayıflamaya yol açacağından sonra kullanılamk üzre bırakılmıştır.)
        function animateCircle() {
            var count = 0;
            window.setInterval(function () {
                count = (count + 1) % 200;
                var icons = line.get('icons');
                icons[0].offset = (count / 2) + '%';
                line.set('icons', icons);
            }, 20);
        }

    } else {
        document.getElementById('google_canvas').innerHTML = 'Konumunuz bulunmadı.';
    }
}
//End araç map dönüş işlemleri
