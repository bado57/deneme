$.ajaxSetup({
    type: "post",
    url: "http://192.168.1.68/SProject/SoforMobilAracAjax",
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
    aracNavigator.on('prepush', function (event) {
        modal.show();
    });
    $(document).on('pageinit', '#aracdetay', function () {
        var page = aracNavigator.getCurrentPage();
        var aracid = page.options.aracID;
        var firma_id = $("input[name=firmaId]").val();
        $.ajax({
            data: {"firma_id": firma_id, "aracid": aracid, "tip": "aracDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: jsDil.Hata});
                    return false;
                } else {
                    $("#aracPlaka").text(cevap.Detay.Plaka);
                    $("input[name=aracID]").val(aracid);
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
                    if (cevap.Detay.Durum != 1) {
                        $("#aracIDurum").addClass("fa fa-toggle-off");
                        $("#aracDurum").text(jsDil.Pasif);
                    } else {
                        $("#aracIDurum").addClass("fa fa-toggle-on");
                        $("#aracDurum").text(jsDil.Aktif);
                    }
                    if (cevap.Detay.Aciklama) {
                        $("#aracAciklama").text(cevap.Detay.Aciklama);
                    } else {
                        $("#aracListAciklama").hide();
                    }

                    if (cevap.Tur) {
                        $("#aracTurSoforHeader").show();
                        $("#aracTurSoforList").show();
                        var turlength = cevap.Tur.length;
                        var onsList = $("#aracTurSoforList");
                        $("#turToplam").text(turlength);
                        for (var a = 0; a < turlength; a++) {
                            var elm = $('<ons-list-item>'
                                    + '<ons-row><ons-col width="20px"></ons-col>'
                                    + '<ons-col class="person-name">' + cevap.Tur[a].Ad + '</ons-col></ons-row></ons-list-item>');
                            elm.appendTo(onsList);
                            ons.compile(elm[0]);
                        }
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#aracyolcu', function () {
        var firma_id = $("input[name=firmaId]").val();
        var aracid = $("input[name=aracID]").val();
        $.ajax({
            data: {"aracid": aracid, "firma_id": firma_id, "tip": "soforAracYolcu"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: jsDil.Hata});
                    return false;
                } else {
                    $("#aracSoforList").show();
                    $("#aracSoforHeader").show();
                    var soforlength = cevap.Sofor.length;
                    var onsListS = $("#aracSoforList");
                    $("#soforToplam").text(soforlength);
                    for (var b = 0; b < soforlength; b++) {
                        var elms = $('<ons-list-item modifier="chevron" onclick="$.SoforIslemler.soforYolcuList(' + cevap.Sofor[b].Id + ',0)">'
                                + '<ons-row><ons-col width="20px"></ons-col>'
                                + '<ons-col class="person-name">' + cevap.Sofor[b].Ad + '</ons-col></ons-row></ons-list-item>');
                        elms.appendTo(onsListS);
                        ons.compile(elms[0]);
                    }

                    if (cevap.TurHostes) {
                        $("#aracHostesHeader").show();
                        $("#aracHostesList").show();
                        var hosteslength = cevap.TurHostes.length;
                        var onsListH = $("#aracHostesList");
                        $("#hostesToplam").text(hosteslength);
                        for (var d = 0; d < hosteslength; d++) {
                            var elmh = $('<ons-list-item modifier="chevron" onclick="$.SoforIslemler.soforYolcuList(' + cevap.TurHostes[d].Id + ',1)">'
                                    + '<ons-row><ons-col width="20px"></ons-col>'
                                    + '<ons-col class="person-name">' + cevap.TurHostes[d].Ad + '</ons-col></ons-row></ons-list-item>');
                            elmh.appendTo(onsListH);
                            ons.compile(elmh[0]);
                        }
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#aracyonetici', function () {
        var firma_id = $("input[name=firmaId]").val();
        var aracid = $("input[name=aracID]").val();
        $.ajax({
            data: {"aracid": aracid, "firma_id": firma_id, "tip": "soforAracYonetici"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: jsDil.Hata});
                    return false;
                } else {
                    $("#aracSYoneticiHeader").show();
                    $("#aracYoneticiList").show();
                    var yoneticilength = cevap.Yonetici.length;
                    var onsListY = $("#aracYoneticiList");
                    $("#yoneticiToplam").text(yoneticilength);
                    for (var c = 0; c < yoneticilength; c++) {
                        var elmy = $('<ons-list-item modifier="chevron" onclick="$.SoforIslemler.soforYoneticiList(' + cevap.Yonetici[c].Id + ')">'
                                + '<ons-row><ons-col width="20px"></ons-col>'
                                + '<ons-col class="person-name">' + cevap.Yonetici[c].Ad + ' ' + cevap.Yonetici[c].Soyad + '</ons-col></ons-row></ons-list-item>');
                        elmy.appendTo(onsListY);
                        ons.compile(elmy[0]);
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#kullanicidetay', function () {
        var page = aracNavigator.getCurrentPage();
        var kisiid = page.options.kisiID;
        var kisitip = page.options.tip;
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
                        $("input[name=inputtur]").val(0);
                        $("input[name=yolcuid]").val(kisiid);
                        $("#kdetayAd").text(cevap.Detay.Ad + ' ' + cevap.Detay.Soyad);
                        $("#kdetayIcon").addClass("fa fa-bus");
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
                    } else {
                        $("input[name=inputtur]").val(1);
                        $("input[name=yolcuid]").val(kisiid);
                        $("#kdetayAd").text(cevap.Detay.Ad + ' ' + cevap.Detay.Soyad);
                        $("#kdetayIcon").addClass("fa fa-info");
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
    $(document).on('pageinit', '#yoneticidetay', function () {
        var page = aracNavigator.getCurrentPage();
        var kisiid = page.options.kisiID;
        var firma_id = $("input[name=firmaId]").val();
        $.ajax({
            data: {"firma_id": firma_id, "kisiid": kisiid, "tip": "soforYoneticiDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    ons.notification.alert({message: jsDil.Hata});
                    return false;
                } else {
                    $("#ydetayAd").text(cevap.Detay.Ad + ' ' + cevap.Detay.Soyad);
                    if (cevap.Detay.Tel) {
                        $("#ydetayTel").text(cevap.Detay.Tel);
                        $("a#ydetayTel").attr("href", "tel:" + cevap.Detay.Tel);
                    } else {
                        $("#ydetayListTel").hide();
                    }
                    $("#ydetaymail").text(cevap.Detay.Mail);
                    if (cevap.Detay.Adres) {
                        $("input[name=ydetaylocation]").val(cevap.Detay.Lokasyon);
                        $("#ydetayadres").text(cevap.Detay.Adres);
                    } else {
                        $("#ydetayListAdres").hide();
                    }
                    modal.hide();
                }
            }
        });
    });
    $(document).on('pageinit', '#soforYDetayMap', function () {
        var lokasyon = $("input[name=ydetaylocation]").val();
        var adres = $("#ydetayadres").text();
        Mobileinitialize(lokasyon, adres);
        var wh = $(window).height();
        var fh = 0;
        var mh = wh - fh;
        $('#sofor_map').css("height", mh);
        google.maps.event.addDomListener(window, 'load', Mobileinitialize);
        modal.hide();
    });
    $(document).on('pageinit', '#aractakvim', function () {
        var currentLangCode = $("input[name=lang]").val();
        $("#takvimPlaka").text($("#aracPlaka").text());
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
            return $("input[name=aracID]").val();
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
    $(document).on('pageinit', '#kullanicitakvim', function () {
        var currentLangCode = $("input[name=lang]").val();
        $("#takvimKullanici").text($("#kdetayAd").text());
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
                        "yolcutip": getCustomTip, "firma_id": GetCustomFValue, "tip": "yolcuTakvim"},
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
            return $("input[name=yolcuid]").val();
        }
        function GetCustomFValue()
        {
            return $("input[name=firmaId]").val();
        }
        function getCustomTip()
        {
            return $("input[name=inputtur]").val();
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
        aracNavigator.pushPage('kullanicidetay.html', {animation: 'slide', kisiID: deger, tip: tip});
    },
    soforYoneticiList: function (deger) {
        aracNavigator.pushPage('yoneticidetay.html', {animation: 'slide', kisiID: deger});
    }
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
                    icons.push('http://192.168.1.23/SProject/Plugins/mapView/green_student.png');
                    lokasyonlar.push([turList[inmeyenicon][1], turList[inmeyenicon][2]]);
                    title.push(turList[inmeyenicon][0]);
                    idler.push(turList[inmeyenicon][3]);
                } else {//personel
                    icons.push('http://192.168.1.23/SProject/Plugins/mapView/employee_green.png');
                    lokasyonlar.push([turList[inmeyenicon][1], turList[inmeyenicon][2]]);
                    title.push(turList[inmeyenicon][0]);
                    idler.push(turList[inmeyenicon][3]);
                }
            }
            icons.push('http://192.168.1.23/SProject/Plugins/mapView/build.png');
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

