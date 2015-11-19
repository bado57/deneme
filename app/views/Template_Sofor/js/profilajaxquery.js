$.ajaxSetup({
    type: "post",
    url: "http://192.168.1.198/SProject/SoforMobilProfilAjax",
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
var lastindex; // Önceki tabın indexi
var currentindex; // Mevcut tabın indexi
var lastpage = "info.html"; // Hangi sayfadan geldi ?
var currentpage = "info.html"; // Şu an hangi sayfada ?
var currentpageindex; // Şu an hangi sayfanın indexi
var lastpageindex; // Önceki sayfanın indexi

ons.ready(function () {
    profileNavigator.on('prepush', function (event) {
        modal.show();
    });
    $(document).on('pageinit', '#editpage', function () {
        var adSoyad = $("#genelAd").text();
        var parcalama = adSoyad.split(" ");
        var telefon = $("#genelTelefon").text();
        var email = $("#genelEmail").text();
        SoforProfil = [];
        SoforProfil.push(parcalama, telefon, email);
        $("input[name=editAd]").val(parcalama[0]);
        $("input[name=editSoyad]").val(parcalama[1]);
        $("input[name=editTelefon]").val(telefon);
        $("input[name=editEmail]").val(email);
        modal.hide();
    });
    $(document).on('pageinit', '#lockpage', function () {
        $("input[name=eskiSifre]").val('');
        $("input[name=yeniSifre]").val('');
        $("input[name=yeniSifreTekrar]").val('');
        modal.hide();
    });
    $(document).on('pageinit', '#mappage', function () {
        var mobilEnlem = $("input[name=enlem]").val();
        var mobilBoylam = $("input[name=boylam]").val();
        Mobileinitialize(mobilEnlem, mobilBoylam);
        var wh = $(window).height();
        var fh = 0;
        var mh = wh - fh;
        $('#sofor_map').css("height", mh);
        google.maps.event.addDomListener(window, 'load', Mobileinitialize);
        modal.hide();
    });
});

var SoforProfil = [];
$.SoforIslemler = {
    soforEdtEkle: function () {
        modal.show();
        var sofor_id = $("input[name=id]").val();
        var firma_id = $("input[name=firmaId]").val();
        var ad = $("input[name=editAd]").val().trim();
        var soyad = $("input[name=editSoyad]").val().trim();
        var telefon = $("input[name=editTelefon]").val().trim();
        var email = $("input[name=editEmail]").val().trim();
        var eskiAd = SoforProfil[0][0].trim();
        var eskiSoyad = SoforProfil[0][1].trim();
        if (SoforProfil[0][0].trim() == ad && SoforProfil[0][1].trim() == soyad && SoforProfil[1].trim() == telefon && SoforProfil[2].trim() == email) {
            ons.notification.alert({message: jsDil.DegisiklikYok});
            return false;
        } else {
            if (ad != '') {
                if (soyad != '') {
                    if (telefon != '') {
                        if (email != '') {
                            var result = ValidateEmail(email);
                            if (!result) {
                                ons.notification.alert({message: jsDil.FormatEmail});
                                return false;
                            } else {
                                $.ajax({
                                    data: {"firma_id": firma_id, "eskiAd": eskiAd, "eskiSoyad": eskiSoyad,
                                        "ad": ad, "soyad": soyad, "telefon": telefon,
                                        "email": email, "sofor_id": sofor_id, "tip": "soforProfilKaydet"},
                                    success: function (cevap) {
                                        if (cevap.hata) {
                                            ons.notification.alert({message: jsDil.Hata});
                                        } else {
                                            $("#genelAd").text(ad + ' ' + soyad);
                                            $("#genelTelefon").text(telefon);
                                            $("#genelEmail").text(email);
                                        }
                                        modal.hide();
                                        profileNavigator.popPage();
                                    }
                                });
                            }
                        } else {
                            ons.notification.alert({message: jsDil.BosEmail});
                            return false;
                        }
                    } else {
                        ons.notification.alert({message: jsDil.BosEmail});
                        return false;
                    }
                } else {
                    ons.notification.alert({message: jsDil.BosSoyad});
                    return false;
                }
            } else {
                ons.notification.alert({message: jsDil.BosAd});
                return false;
            }
        }

    },
    soforSfreEkle: function () {
        modal.show();
        var sofor_id = $("input[name=id]").val();
        var language = $("input[name=lang]").val();
        var firma_id = $("input[name=firmaId]").val();
        var kadi = $("#genelKadi").text();
        var eskisifre = $("input[name=eskiSifre]").val().replace(/\s+/g, '');
        var yenisifre = $("input[name=yeniSifre]").val().replace(/\s+/g, '');
        var yenisifretkrar = $("input[name=yeniSifreTekrar]").val().replace(/\s+/g, '');
        if (eskisifre != '') {
            if (yenisifre != '') {
                if (yenisifretkrar != '') {
                    if (yenisifre.length > 6) {
                        if (yenisifre != eskisifre) {
                            if (yenisifre == yenisifretkrar) {
                                $.ajax({
                                    data: {"firma_id": firma_id, "eskisifre": eskisifre, "yenisifre": yenisifre,
                                        "yenisifretkrar": yenisifretkrar, "sofor_id": sofor_id,
                                        "language": language, "kadi": kadi, "tip": "soforSifreKaydet"},
                                    success: function (cevap) {
                                        if (cevap.hata) {
                                            ons.notification.alert({message: cevap.hata});
                                            return false;
                                        } else {
                                            ons.notification.alert({message: jsDil.SifreDegis});
                                        }
                                        modal.hide();
                                        profileNavigator.popPage();
                                    }
                                });
                            } else {
                                modal.hide();
                                ons.notification.alert({message: jsDil.SifreUyusma});
                                return false;
                            }
                        } else {
                            modal.hide();
                            ons.notification.alert({message: jsDil.SifreDegistir});
                            return false;
                        }
                    } else {
                        modal.hide();
                        ons.notification.alert({message: jsDil.SifreKarekter});
                        return false;
                    }
                } else {
                    modal.hide();
                    ons.notification.alert({message: jsDil.BosYeniSifreTekrar});
                    return false;
                }
            } else {
                modal.hide();
                ons.notification.alert({message: jsDil.BosYeniSifre});
                return false;
            }
        } else {
            modal.hide();
            ons.notification.alert({message: jsDil.BosEskiSifre});
            return false;
        }
    },
    soforMailUnut: function () {
        var email = $("input[name=emailUnut]").val();
        if (email != '') {
            ons.notification.confirm({
                message: jsDil.MailGonder,
                callback: function (idx) {
                    switch (idx) {
                        case 1:
                            modal.show();
                            var sofor_id = $("input[name=id]").val();
                            var firma_id = $("input[name=firmaId]").val();
                            $.ajax({
                                data: {"firma_id": firma_id, "sofor_id": sofor_id,
                                    "email": email, "tip": "soforSifreUnuttum"},
                                success: function (cevap) {
                                    if (cevap.hata) {
                                        ons.notification.alert({message: jsDil.Hata});
                                        return false;
                                    } else {
                                        ons.notification.alert({message: jsDil.SifreGonderme});
                                    }
                                    modal.hide();
                                    profileNavigator.popPage();
                                }
                            });
                            break;
                    }
                }
            });
        } else {
            ons.notification.alert({message: jsDil.MailYok});
            return false;
        }
    },
    soforMapSave: function () {
        var cevap = saveMap();
        if (cevap) {
            var firma_id = $("input[name=firmaId]").val();
            var id = $("input[name=id]").val();
            var ulke = $("input[name=country]").val();
            var il = $("input[name=administrative_area_level_1]").val();
            var ilce = $("input[name=administrative_area_level_2]").val();
            var semt = $("input[name=locality]").val();
            var mahalle = $("input[name=neighborhood]").val();
            var sokak = $("input[name=route]").val();
            var postakodu = $("input[name=postal_code]").val();
            var caddeno = $("input[name=street_number]").val();
            var lokasyon = $("input[name=soforLokasyon]").val();
            if (lokasyon) {
                $.ajax({
                    data: {"firma_id": firma_id, "ulke": ulke, "il": il, "ilce": ilce, "mahalle": mahalle,
                        "sokak": sokak, "postakodu": postakodu,
                        "semt": semt, "caddeno": caddeno, "lokasyon": lokasyon, "detayAdres": ttl,
                        "id": id, "tip": "soforHaritaKaydet"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            ons.notification.alert({message: jsDil.Hata});
                            return false;
                        } else {
                            $("input[name=location]").val(lokasyon);
                            $("#genelAdres").text(ttl);
                            modal.hide();
                            profileNavigator.popPage();
                        }
                    }
                });
            } else {
                ons.notification.alert({message: jsDil.HaritaIsaret});
                return false;
            }

        }
    },
}
// Lokasyon Seçme İşlemleri
var map;
var markers = [];
var ttl = "";
var lastLocation;
var lastAdress = "";
var incomeLocation;
var mapEvent;
//harita kaydetme
function saveMap() {
    var say = incomeLocation.results[0].address_components.length;
    for (var i = 0, max = say; i < max; i++) {
        var key = incomeLocation.results[0].address_components[i].types[0];
        var value = incomeLocation.results[0].address_components[i].long_name;
        $('input[name="' + key + '"]').val(value);
    }
    $('input[name="soforLokasyon"]').val(mapEvent.latLng.lat() + "," + mapEvent.latLng.lng());
    lastLocation = new google.maps.LatLng(mapEvent.latLng.lat(), mapEvent.latLng.lng());
    return true;
}

function Mobileinitialize(Mobileenlem, Mobileboylam) {

    var mapOptions = {
        zoom: 16
    };

    var map = new google.maps.Map(document.getElementById('sofor_map'),
            mapOptions);

    //son eklenen locationu haritada görme
    var posValue = $("input[name=location]").val();
    if (posValue != '') {
        var posSplitValue = posValue.split(",");
        var pos = new google.maps.LatLng(posSplitValue[0],
                posSplitValue[1]);
        var infowindow = new google.maps.InfoWindow({
            map: map,
            position: pos,
            content: $("#genelAdres").text()
        });
    }
    //enlem boylam buraya gelecek
    var pos = new google.maps.LatLng(Mobileenlem,
            Mobileboylam);
    var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
        content: jsDil.Konum
    });
    map.setCenter(pos);

    var marker = new google.maps.Marker({
        position: lastLocation,
        map: map
    });

    markers.push(marker);

    google.maps.event.addListener(marker, 'click', function () {
        var infowindow = new google.maps.InfoWindow({
            map: map,
            position: pos,
            content: lastAdress
        });
    });

    google.maps.event.addListener(map, 'click', function (event) {
        if (lastLocation != null) {
            setAllMap(null);
        }
        $.ajax({
            type: "get",
            url: "http://maps.googleapis.com/maps/api/geocode/json?latlng=" + event.latLng.lat() + "," + event.latLng.lng() + "&sensor=true",
            //timeout:3000,
            dataType: "json",
            success: function (cevap) {
                ttl = cevap.results[0].formatted_address;
                placeMarker(event.latLng);
                incomeLocation = cevap;
                mapEvent = event;
                lastAdress = ttl;
            }
        });
    });

    function setAllMap(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }

    function placeMarker(location) {
        setAllMap(null);
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title: ttl
        });

        var infowindow = new google.maps.InfoWindow({
            content: ttl
        });

        infowindow.open(map, marker);
        markers.push(marker);
    }
}

