// Document Ready
var z = 1;
var MultipleMapArray = new Array();
var arac = new Array();
var kurum = new Array();
//gidiş değerleri
var binmeyen = new Array();
var binen = new Array();
//dönüş değerleri
var inmeyen = new Array();
var inen = new Array();
var MultipleMapindex;
$(document).ready(function () {
// Sayfa Scroll Olayı
    $("html").niceScroll({
        scrollspeed: 100,
        mousescrollstep: 38,
        cursorwidth: 6,
        cursorborder: 0,
        cursorcolor: '#808080',
        autohidemode: true,
        zindex: 9999999999,
        horizrailenabled: false,
        cursorborderradius: 3,
    });
    // Form Enable / Disable Kontrolleri
    $(document).on("click", "#editForm", function (e) {
        e.preventDefault();
        $(document).find(".dsb").prop("disabled", false);
        $(document).find(".edit-group").css("display", "none");
        $(document).find(".submit-group").fadeIn();
        checkIt();
        var edtislemler = $(this).attr("data-Editislem");
        editControl(edtislemler);
    });
    $(document).on("click", ".vzg", function (e) {
        e.preventDefault();
        $(document).find(".dsb").prop("disabled", true);
        $(document).find(".submit-group").css("display", "none");
        $(document).find(".edit-group").fadeIn();
        checkIt();
        var vzgislemler = $(this).attr("data-Vzgislem");
        vzgControl(vzgislemler);
    });
    $(document).on("click", ".save", function (e) {
        e.preventDefault();
        var saveislemler = $(this).attr("data-Saveislem");
        saveControl(saveislemler);
    });
    // End Form Enable / Dissable Kontrolleri

    // Sol Menu Navigasyon Kontrolü   
    $(".sidebar-menu").find(".active").removeClass("active");
    $("#" + activeMenu).find("a").click();
    $(".sidebar-menu").find(".activeli").removeClass("activeli");
    $("#" + activeMenu).find("#" + activeLink).addClass("activeli");
    // End Sol Menu Navigasyon Kontrolü

    //subview kontrolü. Class'a Göre
    $(document).on("click", ".svToggle", function (e) {
        e.preventDefault();
        if ($(this).attr("data-index") == 'index') {
            MultipleMapindex = $(this).parent().parent().index();
        }
        var dtype = $(this).attr("data-type");
        var dclass = $(this).attr("data-class");
        var dislemler = $(this).attr("data-islemler");
        svControl(dtype, dclass, dislemler);
    });
});
// End Document Ready
var isMap = false;
var isSingle = true;
var svDiv;
// Subview Kontrolü
function svControl(dtype, dclass, dislemler) {
    var effect = 'slide';
    var options = {direction: 'right'};
    var duration = 500;
    var h = $(window).height();
    var hh = $(document).find("header").height();
    var th = h - hh;
    svDiv = $("#" + dclass);
//Subview açılıyor
    if (dtype != 'svClose') {
        switch (dislemler) {
            default :
                $("#" + dclass).height(th);
                $("#" + dclass).css("z-index", z);
                $("#" + dclass).attr("data-z", z);
                $('[data-z="' + (z - 1) + '"]').css("display", "none");
                $('#' + dclass).toggle(effect, options, duration);
                z++;
                break;
        }
        if (returnCevap == true) {
            $("#" + dclass).height(th);
            $("#" + dclass).css("z-index", z);
            $("#" + dclass).attr("data-z", z);
            $('[data-z="' + (z - 1) + '"]').css("display", "none");
            $('#' + dclass).toggle(effect, options, duration);
            z++;
            if (isMap == true) {
                var mh = $("#mapHeader").height();
                var sh = th - mh;
                $("#multiple_lokasyon_map").height(sh);
                if (isSingle == true) {
                    $("#saveMap").css("display", "block");
                    initialize();
                    google.maps.event.addDomListener(window, 'load', initialize);
                } else {
                    $("#saveMap").css("display", "none");
                    multipleMapping(MultipleMapArray, MultipleMapindex);
                    google.maps.event.addDomListener(window, 'load', multipleMapping);
                }
            }
        }
    }//Subview kapanıyor
    else if (dtype != 'svOpen') {
        switch (dislemler) {
            case 'adminHaritaKaydet' :
                var returnCevap = saveMap();
                break;
            default :
                $("#" + dclass).height(th);
                $("#" + dclass).css("z-index", z);
                $('[data-z="' + (z - 2) + '"]').css("display", "block");
                svDiv = $('[data-z="' + (z - 2) + '"]');
                $('#' + dclass).toggle(effect, options, duration);
                z--;
                break;
        }
        if (returnCevap == true) {
            $("#" + dclass).height(th);
            $("#" + dclass).css("z-index", z);
            $('[data-z="' + (z - 2) + '"]').css("display", "block");
            svDiv = $('[data-z="' + (z - 2) + '"]');
            $('#' + dclass).toggle(effect, options, duration);
            z--;
        }
    }
    if (z > 1) {
        $(".wrapper").find("aside").css("display", "none");
        setSvHeight();
    } else {
        $(".wrapper").find("aside").css("display", "block");
    }
}

$(window).resize(function () {
    setSvHeight();
});
// Subview Yükseklik Ayarlama
function setSvHeight() {
    if (z > 1) {
        var hh = $(".header").height();
        svDiv.height($(window).height() - hh);
    }

    if (isMap == true) {
        var mh = $("#mapHeader").height();
        var hh = $(".header").height();
        var sh = $(window).height() - (mh + hh);
        $("#multiple_map").height(sh);
    }
}



// End Subview Kontrolü

//Edit Kontrol
function editControl(edtislemler) {
    switch (edtislemler) {
        case 'adminAracDetailEdit' :
            $.AdminIslemler.adminAracDetailDuzenle();
            break;
        default :
            break;
    }
}
//End Edit Kontrol

//Vazgeç Kontrol
function vzgControl(vzgislemler) {
    switch (vzgislemler) {
        case 'adminAracDetailVazgec' :
            $.AdminIslemler.adminAracDetailVazgec();
            break;
        default :
            break;
    }
}
//End Vezgeç Kontrol

//Kaydet Kontrol
function saveControl(saveislemler) {
    switch (saveislemler) {
        case 'adminAracDetailKaydet' :
            $.AdminIslemler.adminAracDetailKaydet();
            break;
        default :
            break;
    }
}
//End Kaydet Kontrol 

// CheckBox Kontrolü
function checkIt() {
    $("input[type='checkbox'], input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });
}
// End CheckBox Kontrolü    

// Form disable işlemleri
function disabledForm() {
    $(document).find(".dsb").prop("disabled", true);
    $(document).find(".submit-group").css("display", "none");
    $(document).find(".edit-group").fadeIn();
    checkIt();
}
// End form disable işlemleri

// Lokasyon Seçme İşlemleri
var map;
var markers = [];
var ttl = "";
var lastLocation;
var lastAdress = "";
var incomeLocation;
var mapEvent;
function saveMap() {
    var say = incomeLocation.results[0].address_components.length;
    for (var i = 0, max = say; i < max; i++) {
        var key = incomeLocation.results[0].address_components[i].types[0];
        var value = incomeLocation.results[0].address_components[i].long_name;
        $('input[name="' + key + '"]').val(value);
    }
    $('input[name="KurumLokasyon"]').val(mapEvent.latLng.k + "," + mapEvent.latLng.D);
    lastLocation = new google.maps.LatLng(mapEvent.latLng.k, mapEvent.latLng.D);
    return true;
}

function initialize() {
    if (navigator.geolocation) {

        var mapOptions = {
            zoom: 16
        };
        var map = new google.maps.Map(document.getElementById('multiple_map'),
                mapOptions);
        //son eklenen locationu haritada görme
        var posValue = $('input.locationInput').val();
        var posSplitValue = posValue.split(",");
        if (posValue != '') {
            var pos = new google.maps.LatLng(posSplitValue[0],
                    posSplitValue[1]);
            var infowindow = new google.maps.InfoWindow({
                map: map,
                position: pos,
                content: lastAdress
            });
        }
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = new google.maps.LatLng(position.coords.latitude,
                    position.coords.longitude);
            var infowindow = new google.maps.InfoWindow({
                map: map,
                position: pos,
                content: 'Sizin Konumunuz'
            });
            map.setCenter(pos);
        }, function () {
            handleNoGeolocation(true);
        });
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
                url: "http://maps.googleapis.com/maps/api/geocode/json?latlng=" + event.latLng.k + "," + event.latLng.D + "&sensor=true",
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
        // Sets the map on all markers in the array.
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

    } else {
        document.getElementById('google_canvas').innerHTML = 'Konumunuz bulunmadı.';
    }
}
// End Lokasyon Seçme İşlemleri

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
    var hh = $(".wrapper").height();
    var hd = $("#hd").height();
    var kmh = $("#kmHeader").height();
    var h = hd + kmh;
    var sh = hh - h;
    $("#multiple_lokasyon_map").height(sh);
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
                icons.push('../Plugins/mapView/driver.png');
                //arac bilgiler
                lokasyonlar.push([arac[1], arac[2]]);
                title.push(arac[0]);
                idler.push(arac[3]);
                markerTur.push(2);
                //binen yolcular varsa
                if (binenLength > 0) {
                    for (var binenicon = 0; binenicon < binenLength; binenicon++) {
                        if (binen[binenicon][4] != 1) {//öğrenci
                            icons.push('../Plugins/mapView/green_student.png');
                            lokasyonlar.push([binen[binenicon][1], binen[binenicon][2]]);
                            title.push(binen[binenicon][0]);
                            idler.push(binen[binenicon][3]);
                            markerTur.push(0);
                        } else {//personel
                            icons.push('../Plugins/mapView/employee_green.png');
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
                            icons.push('../Plugins/mapView/red_student.png');
                            lokasyonlar.push([binmeyen[binmeyenicon][1], binmeyen[binmeyenicon][2]]);
                            title.push(binmeyen[binmeyenicon][0]);
                            idler.push(binmeyen[binmeyenicon][3]);
                            markerTur.push(1);
                        } else {//personel
                            icons.push('../Plugins/mapView/employee_red.png');
                            lokasyonlar.push([binmeyen[binmeyenicon][1], binmeyen[binmeyenicon][2]]);
                            title.push(binmeyen[binmeyenicon][0]);
                            idler.push(binmeyen[binmeyenicon][3]);
                            markerTur.push(1);
                        }
                    }
                }
                icons.push('../Plugins/mapView/build.png');
                lokasyonlar.push([kurum[2], kurum[3]]);
                title.push(kurum[0]);
                idler.push(kurum[1]);
                markerTur.push(3);
            }
            iconsLength = icons.length;
        }
        if (aracLength != 0) {//araç bilgiler
            icons.push('../Plugins/mapView/driver.png');
            //arac bilgiler
            lokasyonlar.push([arac[1], arac[2]]);
            title.push(arac[0]);
            idler.push(arac[3]);
            markerTur.push(2);
            //binen yolcular varsa
            if (binenLength > 0) {
                for (var binenicon = 0; binenicon < binenLength; binenicon++) {
                    if (binen[binenicon][4] != 1) {//öğrenci
                        icons.push('../Plugins/mapView/green_student.png');
                        lokasyonlar.push([binen[binenicon][1], binen[binenicon][2]]);
                        title.push(binen[binenicon][0]);
                        idler.push(binen[binenicon][3]);
                        markerTur.push(0);
                    } else {//personel
                        icons.push('../Plugins/mapView/employee_green.png');
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
                        icons.push('../Plugins/mapView/red_student.png');
                        lokasyonlar.push([binmeyen[binmeyenicon][1], binmeyen[binmeyenicon][2]]);
                        title.push(binmeyen[binmeyenicon][0]);
                        idler.push(binmeyen[binmeyenicon][3]);
                        markerTur.push(1);
                    } else {//personel
                        icons.push('../Plugins/mapView/employee_red.png');
                        lokasyonlar.push([binmeyen[binmeyenicon][1], binmeyen[binmeyenicon][2]]);
                        title.push(binmeyen[binmeyenicon][0]);
                        idler.push(binmeyen[binmeyenicon][3]);
                        markerTur.push(1);
                    }
                }
            }
            icons.push('../Plugins/mapView/build.png');
            lokasyonlar.push([kurum[2], kurum[3]]);
            title.push(kurum[0]);
            idler.push(kurum[1]);
            markerTur.push(3);
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
        var newPos = new google.maps.LatLng(arac[1], arac[2]);
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
        var degerler = 0;
        var interval = setInterval(function () {
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
                    hesapRoute();
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
    $("#multiple_lokasyon_map").height(sh);
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
                icons.push('../Plugins/mapView/driver.png');
                //arac bilgiler
                lokasyonlar.push([arac[1], arac[2]]);
                title.push(arac[0]);
                idler.push(arac[3]);
                markerTur.push(2);
                //inmeyen yolcular varsa
                if (inmeyenLength > 0) {
                    for (var inmeyenicon = 0; inmeyenicon < inmeyenLength; inmeyenicon++) {
                        if (inmeyen[inmeyenicon][4] != 1) {//öğrenci
                            icons.push('../Plugins/mapView/red_student.png');
                            lokasyonlar.push([inmeyen[inmeyenicon][1], inmeyen[inmeyenicon][2]]);
                            title.push(inmeyen[inmeyenicon][0]);
                            idler.push(inmeyen[inmeyenicon][3]);
                            markerTur.push(1);
                        } else {//personel
                            icons.push('../Plugins/mapView/employee_red.png');
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
                            icons.push('../Plugins/mapView/green_student.png');
                            lokasyonlar.push([inen[inenicon][1], inen[inenicon][2]]);
                            title.push(inen[inenicon][0]);
                            idler.push(inen[inenicon][3]);
                            markerTur.push(0);
                        } else {//personel
                            icons.push('../Plugins/mapView/employee_green.png');
                            lokasyonlar.push([inen[inenicon][1], inen[inenicon][2]]);
                            title.push(inen[inenicon][0]);
                            idler.push(inen[inenicon][3]);
                            markerTur.push(1);
                        }
                    }
                }
                icons.push('../Plugins/mapView/build.png');
                lokasyonlar.push([kurum[2], kurum[3]]);
                title.push(kurum[0]);
                idler.push(kurum[1]);
                markerTur.push(3);
            }
            iconsLength = icons.length;
        }
        if (aracLength != 0) {//araç bilgiler
            icons.push('../Plugins/mapView/driver.png');
            //arac bilgiler
            lokasyonlar.push([arac[1], arac[2]]);
            title.push(arac[0]);
            idler.push(arac[3]);
            markerTur.push(2);
            //inmeyen yolcular varsa
            if (inmeyenLength > 0) {
                for (var inmeyenicon = 0; inmeyenicon < inmeyenLength; inmeyenicon++) {
                    if (inmeyen[inmeyenicon][4] != 1) {//öğrenci
                        icons.push('../Plugins/mapView/red_student.png');
                        lokasyonlar.push([inmeyen[inmeyenicon][1], inmeyen[inmeyenicon][2]]);
                        title.push(inmeyen[inmeyenicon][0]);
                        idler.push(inmeyen[inmeyenicon][3]);
                        markerTur.push(1);
                    } else {//personel
                        icons.push('../Plugins/mapView/employee_red.png');
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
                        icons.push('../Plugins/mapView/green_student.png');
                        lokasyonlar.push([inen[inenicon][1], inen[inenicon][2]]);
                        title.push(inen[inenicon][0]);
                        idler.push(inen[inenicon][3]);
                        markerTur.push(0);
                    } else {//personel
                        icons.push('../Plugins/mapView/employee_green.png');
                        lokasyonlar.push([inen[inenicon][1], inen[inenicon][2]]);
                        title.push(inen[inenicon][0]);
                        idler.push(inen[inenicon][3]);
                        markerTur.push(1);
                    }
                }
            }
            icons.push('../Plugins/mapView/build.png');
            lokasyonlar.push([kurum[2], kurum[3]]);
            title.push(kurum[0]);
            idler.push(kurum[1]);
            markerTur.push(3);
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
        var newPos = new google.maps.LatLng(arac[1], arac[2]);
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
        var degerler = 0;
        var interval = setInterval(function () {
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
                    hesapRoute();
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