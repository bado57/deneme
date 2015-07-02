$.ajaxSetup({
    type: "post",
    url: "http://192.168.1.26/SProject/SoforMobilTurAjax",
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
var turList = new Array();
var kurum = new Array();
ons.ready(function () {
    turNavigator.on('prepush', function (event) {
        modal.show();
    });
    $(document).on('pageinit', '#turdetay', function () {
        var page = turNavigator.getCurrentPage();
        var turid = page.options.turID;
        var firma_id = $("input[name=firmaId]").val();
        $.ajax({
            data: {"firma_id": firma_id, "turid": turid, "tip": "soforTurDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: jsDil.Hata});
                    return false;
                } else {
                    $("input[name=turListItem]").val(turid);
                    $("#detayTurAd").text(cevap.Detay.Ad);
                    if (cevap.Detay.Aktiflik != 0) {
                        $("#turListAktif").addClass("fa fa-toggle-on");
                        $("#detayAktif").text(jsDil.Aktif);
                    } else {
                        $("#turListAktif").addClass("fa fa-toggle-off");
                        $("#detayAktif").text(jsDil.Pasif);
                    }
                    $("#detayBolge").text(cevap.Detay.Bolge);
                    $("input[name=turListBolge]").val(cevap.Detay.BolgeID);
                    $("#detayKurum").text(cevap.Detay.Kurum);
                    $("input[name=turKurumID]").val(cevap.Detay.KurumID);
                    $("input[name=turKurumLoc]").val(cevap.Detay.KurumLoc);
                    $("input[name=turListTip]").val(cevap.Detay.Tip);
                    if (cevap.Detay.Tip == 0) {
                        $("#detayTip").text(jsDil.OServis);
                    } else if (cevap.Detay.Tip == 1) {
                        $("#detayTip").text(jsDil.PServis);
                    } else {
                        $("#detayTip").text(jsDil.OPServis);
                    }
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
                    if (cevap.Gidis.ID > 0) {
                        $("#gidisPlaka").text(cevap.Gidis.Plaka);
                        $("input[name=aracGDetayID]").val(cevap.Gidis.PlakaID);
                        $("#gidisSofor").text(cevap.Gidis.Sofor);
                        $("input[name=soforGDetayID]").val(cevap.Gidis.SoforID);
                        if (cevap.Gidis.Hostes > 0) {
                            $("#gidisHostes").text(cevap.Gidis.Hostes);
                            $("input[name=hostesGDetayID]").val(cevap.Gidis.HostesID);
                        } else {
                            $("#detayGidisHostes").hide();
                        }
                        var saat1;
                        if (cevap.Gidis.Bslngc.length == 1) {
                            saat1 = '00:00'
                        } else if (cevap.Gidis.Bslngc.length == 2) {
                            saat1 = '00:' + cevap.Gidis.Bslngc;
                        } else if (cevap.Gidis.Bslngc.length == 3) {
                            var ilkHarf1 = cevap.Gidis.Bslngc.slice(0, 1);
                            var sondaikiHarf1 = cevap.Gidis.Bslngc.slice(1, 3);
                            saat1 = '0' + ilkHarf1 + ':' + sondaikiHarf1;
                        } else {
                            var ilkikiHarf1 = cevap.Gidis.Bslngc.slice(0, 2);
                            var sondaikiHarf1 = cevap.Gidis.Bslngc.slice(2, 4);
                            saat1 = ilkikiHarf1 + ':' + sondaikiHarf1;
                        }

                        var saat2;
                        if (cevap.Gidis.Bts.length == 1) {
                            saat2 = '00:00'
                        } else if (cevap.Gidis.Bts.length == 2) {
                            saat2 = '00:' + cevap.Gidis.Bts;
                        } else if (cevap.Gidis.Bts.length == 3) {
                            var ilkHarf1 = cevap.Gidis.Bts.slice(0, 1);
                            var sondaikiHarf1 = cevap.Gidis.Bts.slice(1, 3);
                            saat2 = '0' + ilkHarf1 + ':' + sondaikiHarf1;
                        } else {
                            var ilkikiHarf1 = cevap.Gidis.Bts.slice(0, 2);
                            var sondaikiHarf1 = cevap.Gidis.Bts.slice(2, 4);
                            saat2 = ilkikiHarf1 + ':' + sondaikiHarf1;
                        }
                        $("#gidisSaat").text(saat1 + ' - ' + saat2);
                    } else {
                        $("#GidisHeader").css({"display": "none"});
                        $("#GidisDetay").css({"display": "none"});
                    }

                    if (cevap.Donus.ID > 0) {
                        $("#donusPlaka").text(cevap.Donus.Plaka);
                        $("input[name=aracDDetayID]").val(cevap.Donus.PlakaID);
                        $("#donusSofor").text(cevap.Donus.Sofor);
                        $("input[name=soforDDetayID]").val(cevap.Donus.SoforID);
                        if (cevap.Donus.Hostes > 0) {
                            $("#donusHostes").text(cevap.Donus.Hostes);
                            $("input[name=hostesDDetayID]").val(cevap.Donus.HostesID);
                        } else {
                            $("#detayDonusHostes").hide();
                        }

                        var saat1;
                        if (cevap.Donus.Bslngc.length == 1) {
                            saat1 = '00:00'
                        } else if (cevap.Donus.Bslngc.length == 2) {
                            saat1 = '00:' + cevap.Donus.Bslngc;
                        } else if (cevap.Donus.Bslngc.length == 3) {
                            var ilkHarf1 = cevap.Donus.Bslngc.slice(0, 1);
                            var sondaikiHarf1 = cevap.Donus.Bslngc.slice(1, 3);
                            saat1 = '0' + ilkHarf1 + ':' + sondaikiHarf1;
                        } else {
                            var ilkikiHarf1 = cevap.Donus.Bslngc.slice(0, 2);
                            var sondaikiHarf1 = cevap.Donus.Bslngc.slice(2, 4);
                            saat1 = ilkikiHarf1 + ':' + sondaikiHarf1;
                        }

                        var saat2;
                        if (cevap.Donus.Bts.length == 1) {
                            saat2 = '00:00'
                        } else if (cevap.Donus.Bts.length == 2) {
                            saat2 = '00:' + cevap.Donus.Bts;
                        } else if (cevap.Donus.Bts.length == 3) {
                            var ilkHarf1 = cevap.Donus.Bts.slice(0, 1);
                            var sondaikiHarf1 = cevap.Donus.Bts.slice(1, 3);
                            saat2 = '0' + ilkHarf1 + ':' + sondaikiHarf1;
                        } else {
                            var ilkikiHarf1 = cevap.Donus.Bts.slice(0, 2);
                            var sondaikiHarf1 = cevap.Donus.Bts.slice(2, 4);
                            saat2 = ilkikiHarf1 + ':' + sondaikiHarf1;
                        }
                        $("#donusSaat").text(saat1 + ' - ' + saat2);
                    } else {
                        $("#DonusHeader").css({"display": "none"});
                        $("#DonusDetay").css({"display": "none"});
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#turyolcu', function () {
        var bolgeid = $("input[name=turListBolge]").val();
        var turtip = $("input[name=turListTip]").val();
        var turid = $("input[name=turListItem]").val();
        var firma_id = $("input[name=firmaId]").val();
        $.ajax({
            data: {"bolgeid": bolgeid, "turtip": turtip, "firma_id": firma_id,
                "turid": turid, "tip": "soforTurYolcu"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: jsDil.Hata});
                    return false;
                } else {
                    if (turtip == 0) {
                        var yolculength = cevap.TurYolcu.length;
                        var onsList = $("#turYolcuList");
                        $("#yolcuToplam").text(yolculength);
                        for (var a = 0; a < yolculength; a++) {
                            var elm = $('<ons-list-item modifier="chevron" onclick="$.SoforIslemler.soforYolcuList(' + cevap.TurYolcu[a].Id + ',0)">'
                                    + '<ons-row><ons-col width="20px"></ons-col>'
                                    + '<ons-col class="person-name">' + cevap.TurYolcu[a].Ad + '</ons-col></ons-row></ons-list-item>');
                            elm.appendTo(onsList);
                            ons.compile(elm[0]);
                        }
                    } else if (turtip == 1) {
                        var yolculength = cevap.TurYolcu.length;
                        var onsList = $("#turYolcuList");
                        $("#yolcuToplam").text(yolculength);
                        for (var a = 0; a < yolculength; a++) {
                            var elm = $('<ons-list-item modifier="chevron" onclick="$.SoforIslemler.soforYolcuList(' + cevap.TurYolcu[a].Id + ',1)">'
                                    + '<ons-row><ons-col width="20px"></ons-col>'
                                    + '<ons-col class="person-name">' + cevap.TurYolcu[a].Ad + '</ons-col></ons-row></ons-list-item>');
                            elm.appendTo(onsList);
                            ons.compile(elm[0]);
                        }
                    } else {
                        var yolculength = cevap.TurYolcu.length;
                        var onsList = $("#turYolcuList");
                        $("#yolcuToplam").text(yolculength);
                        for (var a = 0; a < yolculength; a++) {
                            if (cevap.TurYolcu[a].Tip == 0) {
                                var elm = $('<ons-list-item modifier="chevron" onclick="$.SoforIslemler.soforYolcuList(' + cevap.TurYolcu[a].Id + ',0)">'
                                        + '<ons-row><ons-col width="20px"></ons-col>'
                                        + '<ons-col class="person-name">' + cevap.TurYolcu[a].Ad + '</ons-col></ons-row></ons-list-item>');
                            } else {
                                var elm = $('<ons-list-item modifier="chevron" onclick="$.SoforIslemler.soforYolcuList(' + cevap.TurYolcu[a].Id + ',1)">'
                                        + '<ons-row><ons-col width="20px"></ons-col>'
                                        + '<ons-col class="person-name">' + cevap.TurYolcu[a].Ad + '</ons-col></ons-row></ons-list-item>');
                            }
                            elm.appendTo(onsList);
                            ons.compile(elm[0]);
                        }
                    }


                    var soforlength = cevap.TurSofor.length;
                    var onsListS = $("#turSoforList");
                    $("#soforToplam").text(soforlength);
                    for (var b = 0; b < soforlength; b++) {
                        var elms = $('<ons-list-item modifier="chevron" onclick="$.SoforIslemler.soforYolcuList(' + cevap.TurSofor[b].Id + ',2)">'
                                + '<ons-row><ons-col width="20px"></ons-col>'
                                + '<ons-col class="person-name">' + cevap.TurSofor[b].Ad + '</ons-col></ons-row></ons-list-item>');
                        elms.appendTo(onsListS);
                        ons.compile(elms[0]);
                    }

                    if (cevap.TurHostes) {
                        var hosteslength = cevap.TurHostes.length;
                        var onsListH = $("#turHostesList");
                        $("#hostesToplam").text(hosteslength);
                        for (var d = 0; d < hosteslength; d++) {
                            var elmh = $('<ons-list-item modifier="chevron" onclick="$.SoforIslemler.soforYolcuList(' + cevap.TurHostes[d].Id + ',4)">'
                                    + '<ons-row><ons-col width="20px"></ons-col>'
                                    + '<ons-col class="person-name">' + cevap.TurHostes[d].Ad + '</ons-col></ons-row></ons-list-item>');
                            elmh.appendTo(onsListH);
                            ons.compile(elmh[0]);
                        }
                    } else {
                        $("#turHostesHeader").hide();
                        $("#turHostesList").hide();
                    }


                    var yoneticilength = cevap.TurYonet.length;
                    var onsListY = $("#turYoneticiList");
                    $("#yoneticiToplam").text(yoneticilength);
                    for (var c = 0; c < yoneticilength; c++) {
                        var elmy = $('<ons-list-item modifier="chevron" onclick="$.SoforIslemler.soforYolcuList(' + cevap.TurYonet[c].Id + ',3)">'
                                + '<ons-row><ons-col width="20px"></ons-col>'
                                + '<ons-col class="person-name">' + cevap.TurYonet[c].Ad + ' ' + cevap.TurYonet[c].Soyad + '</ons-col></ons-row></ons-list-item>');
                        elmy.appendTo(onsListY);
                        ons.compile(elmy[0]);
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#yolcudetay', function () {
        var page = turNavigator.getCurrentPage();
        var kisiid = page.options.kisiID;
        var kisitip = page.options.kisiTip;
        var firma_id = $("input[name=firmaId]").val();
        $.ajax({
            data: {"firma_id": firma_id, "kisiid": kisiid,
                "kisitip": kisitip, "tip": "soforYolcuDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: jsDil.Hata});
                    return false;
                } else {
                    if (kisitip == 0) {
                        $("#kdetayAd").text(cevap.Detay.Ad + ' ' + cevap.Detay.Soyad);
                        $("#kdetaytur").text(jsDil.Ogrenci);
                        $("#kdetayIcon").addClass("fa fa-mortar-board");
                        if (cevap.Detay.Tel) {
                            $("#kdetayTel").text(cevap.Detay.Tel);
                            $("a#kdetayTel").attr("href", "tel:" + cevap.Detay.Tel);
                        } else {
                            $("#kdetayListTel").hide();
                        }
                        $("#kdetaymail").text(cevap.Detay.Mail);
                        if (cevap.Detay.Adres) {
                            $("input[name=kdetaylocation]").val(cevap.Detay.Lokasyon);
                            $("#kdetayadres").text(cevap.Detay.Adres);
                        } else {
                            $("#kdetayListAdres").hide();
                        }

                        if (cevap.DetayVeli) {
                            var velilength = cevap.DetayVeli.length;
                            var onsListV = $("#vdetaylist");
                            for (var c = 0; c < velilength; c++) {
                                var elmv = $('<ons-list-item><ons-row><ons-col width="40px"><i class="fa fa-user"></i></ons-col><ons-col class="coldty">' + cevap.DetayVeli[c].Ad + ' ' + cevap.DetayVeli[c].Soyad + '</ons-col></ons-row></ons-list-item>'
                                        + '<ons-list-item id="vdetayListTel"><ons-row><ons-col width="40px"><i class="fa fa-phone-square"></i></ons-col><ons-col class="coldty"><a href="tel:' + cevap.DetayVeli[c].Tel + '">' + cevap.DetayVeli[c].Tel + '</a></ons-col></ons-row></ons-list-item>'
                                        + '<ons-list-item id="vdetayListMail"><ons-row><ons-col width="40px"><i class="fa fa-envelope"></i></ons-col><ons-col class="coldty">' + cevap.DetayVeli[c].Mail + '</ons-col></ons-row></ons-list-item>');
                                elmv.appendTo(onsListV);
                                ons.compile(elmv[0]);
                                if (cevap.DetayVeli[c].Tel) {
                                    ons.compile(elmv[1]);
                                } else {
                                    $("#vdetayListTel").hide();
                                }
                                ons.compile(elmv[2]);
                            }
                        } else {
                            $("#vdetayheader").hide();
                            $("#vdetaylist").hide();
                        }

                    } else {
                        $("#vdetayheader").hide();
                        $("#vdetaylist").hide();
                        $("#kdetayAd").text(cevap.Detay.Ad + ' ' + cevap.Detay.Soyad);
                        if (kisitip == 1) {
                            $("#kdetaytur").text(jsDil.Personel);
                            $("#kdetayIcon").addClass("fa fa-briefcase");
                        } else if (kisitip == 2) {
                            $("#kdetaytur").text(jsDil.Sofor);
                            $("#kdetayIcon").addClass("fa fa-bus");
                        } else if (kisitip == 3) {
                            $("#kdetaytur").text(jsDil.Yonetici);
                            $("#kdetayIcon").addClass("fa fa-sitemap");
                        } else {
                            $("#kdetaytur").text(jsDil.Hostes);
                            $("#kdetayIcon").addClass("fa fa-info");
                        }
                        if (cevap.Detay.Tel) {
                            $("#kdetayTel").text(cevap.Detay.Tel);
                            $("a#kdetayTel").attr("href", "tel:" + cevap.Detay.Tel);
                        } else {
                            $("#kdetayListTel").hide();
                        }
                        $("#kdetaymail").text(cevap.Detay.Mail);
                        if (cevap.Detay.Adres) {
                            $("input[name=kdetaylocation]").val(cevap.Detay.Lokasyon);
                            $("#kdetayadres").text(cevap.Detay.Adres);
                        } else {
                            $("#kdetayListAdres").hide();
                        }
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#sofordetay', function () {
        var page = turNavigator.getCurrentPage();
        var tip = page.options.gidistip;
        if (tip != 1) {
            var kisiid = $("input[name=soforGDetayID]").val();
        } else {
            var kisiid = $("input[name=soforDDetayID]").val();
        }
        var firma_id = $("input[name=firmaId]").val();
        $.ajax({
            data: {"firma_id": firma_id, "kisiid": kisiid, "tip": "soforDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: jsDil.Hata});
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
    $(document).on('pageinit', '#detayMap', function () {
        var lokasyon = $("input[name=sofordetaylocation]").val();
        var adres = $("#sofordetayadres").text();
        Mobileinitialize(lokasyon, adres);
        var wh = $(window).height();
        var fh = 0;
        var mh = wh - fh;
        $('#sofor_map').css("height", mh);
        google.maps.event.addDomListener(window, 'load', Mobileinitialize);
        modal.hide();
    });
    $(document).on('pageinit', '#hostesdetay', function () {
        var page = turNavigator.getCurrentPage();
        var tip = page.options.gidistip;
        if (tip != 1) {
            var kisiid = $("input[name=hostesGDetayID]").val();
        } else {
            var kisiid = $("input[name=hostesDDetayID]").val();
        }
        var firma_id = $("input[name=firmaId]").val();
        $.ajax({
            data: {"firma_id": firma_id, "kisiid": kisiid, "tip": "hostesDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: jsDil.Hata});
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
        Mobileinitialize(lokasyon, adres);
        var wh = $(window).height();
        var fh = 0;
        var mh = wh - fh;
        $('#sofor_map').css("height", mh);
        google.maps.event.addDomListener(window, 'load', Mobileinitialize);
        modal.hide();
    });
    $(document).on('pageinit', '#soforDetayMap', function () {
        var lokasyon = $("input[name=kdetaylocation]").val();
        var adres = $("#kdetayadres").text();
        Mobileinitialize(lokasyon, adres);
        var wh = $(window).height();
        var fh = 0;
        var mh = wh - fh;
        $('#sofor_map').css("height", mh);
        google.maps.event.addDomListener(window, 'load', Mobileinitialize);
        modal.hide();
    });
    $(document).on('pageinit', '#aracdetay', function () {
        var page = turNavigator.getCurrentPage();
        var tip = page.options.gidistip;
        if (tip != 1) {
            var aracid = $("input[name=aracGDetayID]").val();
        } else {
            var aracid = $("input[name=aracDDetayID]").val();
        }
        var firma_id = $("input[name=firmaId]").val();
        $.ajax({
            data: {"firma_id": firma_id, "aracid": aracid, "tip": "aracDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: jsDil.Hata});
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
    $(document).on('pageinit', '#turDetayMap', function () {
        var turtip = $("input[name=turListTip]").val();
        var turid = $("input[name=turListItem]").val();
        var firma_id = $("input[name=firmaId]").val();
        $.ajax({
            data: {"firma_id": firma_id, "turtip": turtip,
                "turid": turid, "tip": "turDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: jsDil.Hata});
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
    $(document).on('pageinit', '#sofortakvim', function () {
        var currentLangCode = $("input[name=lang]").val();
        $("#takvimSofor").text($("#sofordetayAd").text());
        $('#calendar').fullCalendar('refetchEvents');
        $('#calendar').fullCalendar('refresh');
        $('#calendar').fullCalendar({
            header: {
                right: ''
            },
            defaultDate: '2015-03-02',
            defaultView: 'agendaWeek',
            weekNumbers: false,
            editable: false,
            weekdaysShort: true,
            height: 'auto',
            lang: currentLangCode,
            allDaySlot: true,
            slotDuration: "00:15:01",
            axisFormat: 'HH:mm',
            timeFormat: {
                agenda: 'HH:mm'
            },
            events: function (start, end, timezone, callback) {
                $.ajax({
                    data: {start: '2015-03-02', end: '2015-03-09', "id": GetCustomValue(),
                        "firma_id": GetCustomFValue, "tip": "soforTakvim"},
                    success: function (doc) {
                        callback(doc);
                        modal.hide();
                    }
                });
            },
            eventColor: '#009933',
            loading: function (bool) {
                modal.show();
            }
        });
        function GetCustomValue()
        {
            return $("input[name=soforDetayID]").val();
        }
        function GetCustomFValue()
        {
            return $("input[name=firmaId]").val();
        }
        for (var i = 0; i < 7; i++) {
            var days = $(".fc-day-header").eq(i).text();
            var kelime = days.substr(0, days.indexOf(' '));
            if (kelime) {
                //var sonkelime=kelime.replace(/,\s*$/, "");
                $(".fc-day-header").eq(i).text(kelime);
            }
        }
    });
    $(document).on('pageinit', '#hostestakvim', function () {
        var currentLangCode = $("input[name=lang]").val();
        $("#takvimHostes").text($("#hostesdetayAd").text());
        $('#calendar').fullCalendar('refetchEvents');
        $('#calendar').fullCalendar('refresh');
        $('#calendar').fullCalendar({
            header: {
                right: ''
            },
            defaultDate: '2015-03-02',
            defaultView: 'agendaWeek',
            weekNumbers: false,
            editable: false,
            weekdaysShort: true,
            height: 'auto',
            lang: currentLangCode,
            allDaySlot: true,
            slotDuration: "00:15:01",
            axisFormat: 'HH:mm',
            timeFormat: {
                agenda: 'HH:mm'
            },
            events: function (start, end, timezone, callback) {
                $.ajax({
                    data: {start: '2015-03-02', end: '2015-03-09', "id": GetCustomValue(),
                        "firma_id": GetCustomFValue, "tip": "hostesTakvim"},
                    success: function (doc) {
                        callback(doc);
                        modal.hide();
                    }
                });
            },
            eventColor: '#009933',
            loading: function (bool) {
                modal.show();
            }
        });
        function GetCustomValue()
        {
            return $("input[name=hostesDetayID]").val();
        }
        function GetCustomFValue()
        {
            return $("input[name=firmaId]").val();
        }
        for (var i = 0; i < 7; i++) {
            var days = $(".fc-day-header").eq(i).text();
            var kelime = days.substr(0, days.indexOf(' '));
            if (kelime) {
                //var sonkelime=kelime.replace(/,\s*$/, "");
                $(".fc-day-header").eq(i).text(kelime);
            }
        }
    });
    $(document).on('pageinit', '#aractakvim', function () {
        var currentLangCode = $("input[name=lang]").val();
        $("#takvimArac").text($("#aracPlaka").text());
        $('#calendar').fullCalendar('refetchEvents');
        $('#calendar').fullCalendar('refresh');
        $('#calendar').fullCalendar({
            header: {
                right: ''
            },
            defaultDate: '2015-03-02',
            defaultView: 'agendaWeek',
            weekNumbers: false,
            editable: false,
            weekdaysShort: true,
            height: 'auto',
            lang: currentLangCode,
            allDaySlot: true,
            slotDuration: "00:15:01",
            axisFormat: 'HH:mm',
            timeFormat: {
                agenda: 'HH:mm'
            },
            events: function (start, end, timezone, callback) {
                $.ajax({
                    data: {start: '2015-03-02', end: '2015-03-09', "id": GetCustomValue(),
                        "firma_id": GetCustomFValue, "tip": "soforAracTakvim"},
                    success: function (doc) {
                        callback(doc);
                        modal.hide();
                    }
                });
            },
            eventColor: '#009933',
            loading: function (bool) {
                modal.show();
            }
        });
        function GetCustomValue()
        {
            return $("input[name=aracDetayID]").val();
        }
        function GetCustomFValue()
        {
            return $("input[name=firmaId]").val();
        }
        for (var i = 0; i < 7; i++) {
            var days = $(".fc-day-header").eq(i).text();
            var kelime = days.substr(0, days.indexOf(' '));
            if (kelime) {
                //var sonkelime=kelime.replace(/,\s*$/, "");
                $(".fc-day-header").eq(i).text(kelime);
            }
        }
    });
});
$.SoforIslemler = {
    soforYolcuList: function (deger, tip) {
        turNavigator.pushPage('yolcudetay.html', {animation: 'slide', kisiID: deger, kisiTip: tip});
    },
}
// Lokasyon Seçme İşlemleri
var map;
var markers = [];
function Mobileinitialize(lokasyon, adres) {
    var mapOptions = {
        zoom: 16
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

    var marker = new google.maps.Marker({
        position: pos,
        map: map
    });

    markers.push(marker);
}

function turLokasyon() {
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
    var wh = $(window).height();
    var fh = 0;
    var mh = wh - fh;
    $("#multiple_lokasyon_map").height(mh);
    var directionsDisplay = [];
    var directionsService = [];
    var infobox;
    var inmeyenLength = turList.length;
    if (navigator.geolocation) {
        if (inmeyenLength > 0) {
            for (var inmeyenicon = 0; inmeyenicon < inmeyenLength; inmeyenicon++) {
                if (turList[inmeyenicon][4] != 1) {//öğrenci
                    icons.push('http://192.168.1.26/SProject/Plugins/mapView/green_student.png');
                    lokasyonlar.push([turList[inmeyenicon][1], turList[inmeyenicon][2]]);
                    title.push(turList[inmeyenicon][0]);
                    idler.push(turList[inmeyenicon][3]);
                } else {//personel
                    icons.push('http://192.168.1.26/SProject/Plugins/mapView/employee_green.png');
                    lokasyonlar.push([turList[inmeyenicon][1], turList[inmeyenicon][2]]);
                    title.push(turList[inmeyenicon][0]);
                    idler.push(turList[inmeyenicon][3]);
                }
            }
            icons.push('http://192.168.1.26/SProject/Plugins/mapView/build.png');
            lokasyonlar.push([kurum[2], kurum[3]]);
            title.push(kurum[0]);
            idler.push(kurum[1]);
        }

        iconsLength = icons.length;
        var mapOptions = {
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: true,
            scaleControl: true,
            streetViewControl: false,
            mapTypeControl: true
        };
        var newPos = new google.maps.LatLng(kurum[2], kurum[3]);
        var map = new google.maps.Map(document.getElementById('multiple_lokasyon_map'),
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
        }
        //total Km
        function totalKm(result) {
            var total = 0;
            var myroute = result.routes[0];
            for (var i = 0; i < myroute.legs.length; i++) {
                total += myroute.legs[i].distance.value;
            }
            total = total / 1000.0;
            //document.getElementById('totalKm').innerHTML = total + ' Km';
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

