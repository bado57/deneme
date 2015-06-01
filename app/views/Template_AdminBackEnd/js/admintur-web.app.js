// Document Ready
var z = 1;
var MultipleMapArray = new Array();
var MultipleMapindex;
var ayiriciIndex = 0;
var sofor = 0;
var KisiOgrenciID = new Array();
var KisiOgrenciAd = new Array();
var KisiOgrenciLocation = new Array();
var KisiIsciID = new Array();
var KisiIsciAd = new Array();
var KisiIsciLocation = new Array();
var KisiOgrenciSira = new Array();
var KisiIsciSira = new Array();
var locations = new Array();
var routeLocations = new Array();
var kayitDeger = 0;
var kayitDegerGidis = 0;
var kayitDegerDonus = 0;
//gidis kişiler
var DetailGidisGelenAd = new Array();
var DetailGidisGelenID = new Array();
var DetailGidisGelenLocation = new Array();
var DetailGidisGelenTip = new Array();
var DetailGidisDigerKisi = new Array();
//şoör seçilmeden önce ve sonra için
var soforGidisSecimDeger = 0;
//dönüş kişiler
var DetailDonusGelenAd = new Array();
var DetailDonusGelenID = new Array();
var DetailDonusGelenLocation = new Array();
var DetailDonusGelenTip = new Array();
var DetailDonusDigerKisi = new Array();
//şoör seçilmeden önce ve sonra için
var soforDonusSecimDeger = 0;

$(document).ready(function () {

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
    $(".sidebar-menu").find(".active").removeClass("active");
    $("#" + activeMenu).addClass("active");
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
            case 'adminTurYeni' :
                var returnCevap = $.AdminIslemler.adminTurYeni();
                isMap = false;
                break;
            case 'adminTurDetayGidis' :
                var returnCevap = $.AdminIslemler.adminTurDetayGidis();
                break;
            case 'adminTurDetayDonus' :
                var returnCevap = $.AdminIslemler.adminTurDetayDonus();
                break;
            case 'adminKurumMap' :
                isMap = true;
                isSingle = false;
                MultipleMapindex = 0;
                var returnCevap = $.AdminIslemler.adminKurumMap();
                break;
            case 'adminSingleMap' :
                isMap = true;
                var returnCevap = true;
                break;
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
        }
    }//Subview kapanıyor
    else if (dtype != 'svOpen') {
        switch (dislemler) {
            case 'adminHaritaKaydet' :
                var returnCevap = saveMap();
                break;
            case 'adminTurVazgec' :
                var returnCevap = $.AdminIslemler.adminTurVazgec();
                break;
            case 'turGidisDetailSil' :
                var returnCevap = $.AdminIslemler.turGidisDetailSil();
                break;
            case 'turDonusDetailSil' :
                var returnCevap = $.AdminIslemler.turDonusDetailSil();
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
        case 'adminTurDetailEdit' :
            $.AdminIslemler.adminTurDetailDuzenle();
            break;
        case 'adminTurDetailEditDonus' :
            $.AdminIslemler.adminTurDetailDuzenleDonus();
            break;
        default :
            break;
    }
}
//End Edit Kontrol

//Vazgeç Kontrol
function vzgControl(vzgislemler) {
    switch (vzgislemler) {
        case 'turGidisDetailVazgec' :
            $.AdminIslemler.turGidisDetailVazgec();
            break;
        case 'turDonusDetailVazgec' :
            $.AdminIslemler.turDonusDetailVazgec();
            break;
        default :
            break;
    }
}
//End Vezgeç Kontrol

//Kaydet Kontrol
function saveControl(saveislemler) {
    switch (saveislemler) {
        case 'turGidisDetailKaydet' :
            $.AdminIslemler.turGidisDetailKaydet();
            break;
        case 'adminTurKaydet' :
            $.AdminIslemler.adminTurKaydet();
            break;
        case 'turDonusDetailKaydet' :
            $.AdminIslemler.turDonusDetailKaydet();
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
    $('input[name="KurumLokasyon"]').val(mapEvent.latLng.lat() + "," + mapEvent.latLng.lng());
    lastLocation = new google.maps.LatLng(mapEvent.latLng.lat(), mapEvent.latLng.lng());
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
        reset();
        alertify.alert(jsDil.KonumYok);
        return false;
    }
}
// End Lokasyon Seçme İşlemleri

//çoklu mapping işlemleri

function multipleMapping(gelen, index) {


    if (navigator.geolocation) {

        var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';
        var icons = [];
        for (var gelenicon = 0; gelenicon < gelen.length; gelenicon++) {
            if (gelenicon != index) {
                icons.push(iconURLPrefix + 'red-dot.png')
            } else {
                icons.push(iconURLPrefix + 'green-dot.png')
            }
        }
        var mapOptions = {
            zoom: 16
        };
        var iconsLength = icons.length;
        var newPos = new google.maps.LatLng(gelen[index][1],
                gelen[index][2]);
        var map = new google.maps.Map(document.getElementById('multiple_map'),
                mapOptions);

        var infowindow = new google.maps.InfoWindow({
            maxWidth: 160
        });

        var markers = new Array();

        var iconCounter = 0;
        for (var i = 0; i < gelen.length; i++) {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(gelen[i][1], gelen[i][2]),
                map: map,
                icon: icons[iconCounter]
            });

            markers.push(marker);

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(gelen[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));

            iconCounter++;

            if (iconCounter >= iconsLength) {
                iconCounter = 0;
            }
        }

        map.setCenter(newPos);

        //Tüm lokasyonları haritaya sığdırma
        /*
         function autoCenter() {
         var bounds = new google.maps.LatLngBounds();
         for (var i = 0; i < markers.length; i++) {
         bounds.extend(markers[i].position);
         }
         map.fitBounds(bounds);
         }
         autoCenter();
         */

    } else {
        reset();
        alertify.alert(jsDil.KonumYok);
        return false;
    }
}

//End çoklu mapping işlemleri

//tur çoklu harita
function multipleTurMapping(gelen, index, ayirici, sofor) {
    /*
     * Gelen tür
     * 0->Öğrenci
     * 1->İşçi
     * 2->Şoför
     * 3->Okul
     */
    //dizileri bolşaltıyoruz
    KisiOgrenciID = [];
    KisiOgrenciAd = [];
    KisiOgrenciLocation = [];
    KisiIsciID = [];
    KisiIsciAd = [];
    KisiIsciLocation = [];
    KisiOgrenciSira = [];
    KisiIsciSira = [];
    locations = [];

    var hh = $("#turForm").height();
    var sh = (hh - 50);
    $("#multiple_tur_map").height(sh);
    var directionsDisplay = [];
    var directionsService = [];
    var items = new Array();
    var markerIs = new Array();
    var infobox;
    var soforDeger = 0;
    var aracKapasite = $('select#TurArac option[value!="-1"]:selected').attr('kapasite');
    $("#totalKapasite").text(aracKapasite);
    if (navigator.geolocation) {

        var icons = [];
        icons.push('../Plugins/mapView/build.png')
        if (sofor != 0) {//şoför seçildi ve locationu varsa
            for (var gelenicon = 1; gelenicon < gelen.length - 1; gelenicon++) {
                if (ayirici == 0) {//yoksa, yani öğrencinin yanında personel yoksa
                    if (index != 1) {//öğrenci
                        icons.push('../Plugins/mapView/red_student.png');
                    } else {//personel
                        icons.push('../Plugins/mapView/employee_red.png');
                    }
                } else {//ikiside varsa
                    if (gelenicon < ayirici) {//öğrenci
                        icons.push('../Plugins/mapView/red_student.png');
                    } else {//işçi
                        icons.push('../Plugins/mapView/employee_red.png');
                    }
                }
            }//şoför için
            icons.push('../Plugins/mapView/driver.png')
            soforDeger++;
        } else {//şoför yoksa
            for (var gelenicon = 1; gelenicon < gelen.length; gelenicon++) {
                if (ayirici == 0) {//yoksa, yani öğrencinin yanında personel yoksa
                    if (index != 1) {//öğrenci
                        icons.push('../Plugins/mapView/red_student.png');
                    } else {//personel
                        icons.push('../Plugins/mapView/employee_red.png');
                    }
                } else {//ikiside varsa
                    if (gelenicon < ayirici) {//öğrenci
                        icons.push('../Plugins/mapView/red_student.png');
                    } else {//işçi
                        icons.push('../Plugins/mapView/employee_red.png');
                    }
                }
            }
        }
        var mapOptions = {
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: true,
            scaleControl: true,
            streetViewControl: false,
            mapTypeControl: true
        };
        var iconsLength = icons.length;
        var newPos = new google.maps.LatLng(gelen[0][1],
                gelen[0][2]);
        var map = new google.maps.Map(document.getElementById('multiple_tur_map'),
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

        var markers = new Array();
        var marker;
        var number = 0;
        var iconCounter = 0;
        var b = 0;
        var key;
        var tiklananNumber;
        var artanKapasite = 0;
        var kayitSira = 1;
        var interval = setInterval(function () {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(gelen[b][1], gelen[b][2]),
                map: map,
                animation: google.maps.Animation.DROP,
                icon: icons[iconCounter],
                title: gelen[b][0],
                id: gelen[b][3],
                tur: gelen[b][4],
                number: number
            });
            markers.push(marker);
            //var markerCluster = new MarkerClusterer(map, markers);
            (function (marker, b) {
                google.maps.event.addListener(marker, "click", function (e) {
                    if (kayitDeger == 1) {
                        reset();
                        alertify.alert(jsDil.DuzenlemeAktif);
                        return false;
                    } else {
                        if (soforDeger == 0) {
                            reset();
                            alertify.alert(jsDil.SoforSecim);
                            return false;
                        } else {
                            if (this.number == 0) {
                                reset();
                                alertify.alert(jsDil.KurumVaris);
                                return false;
                            } else {
                                if (this.number == gelen.length - 1) {
                                    reset();
                                    alertify.alert(jsDil.SoforNokta);
                                    return false;
                                } else {
                                    tiklananNumber = this.number;
                                    var markerIndex = markerIs.indexOf(this.number);
                                    if (markerIndex != -1) {
                                        artanKapasite--;
                                        $("#totalKisi").text(artanKapasite);
                                    }
                                    if (artanKapasite < aracKapasite) {
                                        if (markerIs.length == 0) {
                                            KisiOgrenciID = [];
                                            KisiOgrenciAd = [];
                                            KisiOgrenciLocation = [];
                                            KisiIsciID = [];
                                            KisiIsciAd = [];
                                            KisiIsciLocation = [];
                                            KisiOgrenciSira = [];
                                            KisiIsciSira = [];
                                            if (this.tur == 0) {
                                                KisiOgrenciSira.push(kayitSira++);
                                                KisiOgrenciID.push(this.id);
                                                KisiOgrenciAd.push(this.title);
                                                KisiOgrenciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                marker.setIcon('../Plugins/mapView/green_student.png');
                                            } else {
                                                KisiIsciSira(kayitSira++);
                                                KisiIsciID.push(this.id);
                                                KisiIsciAd.push(this.title);
                                                KisiIsciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                marker.setIcon('../Plugins/mapView/employee_green.png');
                                            }
                                            items = [];

                                            markerIs.push(this.number);
                                            artanKapasite++;
                                            $("#totalKisi").text(artanKapasite);
                                            key = this.number;
                                            var obj = {};
                                            obj[key] = this.getPosition().lat() + ',' + this.getPosition().lng();

                                            items.push(obj);
                                            reset();
                                            alertify.alert(jsDil.BaslangicNokta);
                                            return false;
                                        } else {
                                            tiklananNumber = this.number;
                                            var markerIndex = markerIs.indexOf(this.number);
                                            if (markerIndex == -1) {
                                                if (this.tur == 0) {
                                                    KisiOgrenciSira.push(kayitSira++);
                                                    KisiOgrenciID.push(this.id);
                                                    KisiOgrenciAd.push(this.title);
                                                    KisiOgrenciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                    marker.setIcon('../Plugins/mapView/green_student.png');
                                                } else {
                                                    KisiIsciSira.push(kayitSira++);
                                                    KisiIsciID.push(this.id);
                                                    KisiIsciAd.push(this.title);
                                                    KisiIsciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                    marker.setIcon('../Plugins/mapView/employee_green.png');
                                                }
                                                markerIs.push(this.number);
                                                artanKapasite++;
                                                $("#totalKisi").text(artanKapasite);
                                                if (items.length >= 2) {
                                                    items.pop();
                                                }
                                                var obj = {};
                                                key = this.number;
                                                obj[key] = this.getPosition().lat() + ',' + this.getPosition().lng();
                                                items.push(obj);
                                                locations = [];
                                                var obj = {};
                                                key = 0;
                                                obj[key] = gelen[0][1] + ',' + gelen[0][2];
                                                items.push(obj);
                                                var bounds = new google.maps.LatLngBounds();
                                                for (var a = 0; a < items.length; a++) {
                                                    for (var key in items[a])
                                                    {
                                                        var tmp_lat_lng = items[a][key].split(",");
                                                        locations.push(new google.maps.LatLng(tmp_lat_lng[0], tmp_lat_lng[1]));
                                                        bounds.extend(locations[locations.length - 1]);
                                                    }
                                                }
                                                directionsService = [];
                                                hesapRoute();
                                            } else {
                                                if (this.tur == 0) {
                                                    idOgrenciTurArama(this.id);
                                                    marker.setIcon('../Plugins/mapView/red_student.png');
                                                } else {
                                                    idIsciTurArama(this.id);
                                                    marker.setIcon('../Plugins/mapView/employee_red.png');
                                                }
                                                markerKeyArama(items, tiklananNumber);
                                                locations = [];
                                                var bounds = new google.maps.LatLngBounds();
                                                for (var a = 0; a < items.length; a++) {
                                                    for (var key in items[a])
                                                    {
                                                        var tmp_lat_lng = items[a][key].split(",");
                                                        locations.push(new google.maps.LatLng(tmp_lat_lng[0], tmp_lat_lng[1]));
                                                        bounds.extend(locations[locations.length - 1]);
                                                    }
                                                }
                                                directionsService = [];
                                                hesapRoute();
                                            }
                                        }
                                    } else {
                                        reset();
                                        alertify.alert(jsDil.AracFazlaKapasite);
                                        return false;
                                        console.log(KisiOgrenciID);
                                        console.log(KisiOgrenciAd);
                                        console.log(KisiOgrenciLocation);
                                        console.log(KisiOgrenciSira);
                                        console.log(KisiIsciID);
                                        console.log(KisiIsciAd);
                                        console.log(KisiIsciSira);
                                    }
                                }
                            }
                            $("#infobox").text(this.title);
                            infobox.open(map, marker);
                        }
                    }
                });
            })(marker, b);
            number++;
            b++;
            if (b == gelen.length) {
                clearInterval(interval);
            }

            iconCounter++;
            if (iconCounter >= iconsLength) {
                iconCounter = 0;
            }
        }, 200);


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
            document.getElementById('totalKm').innerHTML = total;
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

        function markerKeyArama(markerLocation, aranacak) {
            var indexNumber;
            for (var index = 0; index < markerLocation.length; index++) {
                for (var key in markerLocation[index])
                {
                    //console.log("key " + key + " has value " + markerLocation[index][key]);
                    if (key == aranacak) {
                        indexNumber = index;
                    }
                }
            }
            items.splice(indexNumber, 1);
            markerIs.splice(indexNumber, 1);
        }
        //id öğrenci arama
        function idOgrenciTurArama(aranacak) {
            var indexNumber;
            for (var index = 0; index < KisiOgrenciID.length; index++) {
                if (KisiOgrenciID[index] == aranacak) {
                    indexNumber = index;
                }
            }
            KisiOgrenciID.splice(indexNumber, 1);
            KisiOgrenciAd.splice(indexNumber, 1);
            KisiOgrenciLocation.splice(indexNumber, 1);
            KisiOgrenciSira.splice(indexNumber, 1);
        }
        //id işçi arama
        function idIsciTurArama(aranacak) {
            var indexNumber;
            for (var index = 0; index < KisiIsciID.length; index++) {
                if (KisiIsciID[index] == aranacak) {
                    indexNumber = index;
                }
            }
            KisiIsciID.splice(indexNumber, 1);
            KisiIsciAd.splice(indexNumber, 1);
            KisiIsciLocation.splice(indexNumber, 1);
            KisiIsciSira.splice(indexNumber, 1);
        }

    } else {
        reset();
        alertify.alert(jsDil.KonumYok);
        return false;
    }
}
//tur çoklu harita
function multipleHostesTurMapping(gelen, index, ayirici, hostes) {
    /*
     * Gelen tür
     * 0->Öğrenci
     * 1->İşçi
     * 2->Şoför
     * 3->Okul
     * 4->Hostes
     */
    //dizileri bolşaltıyoruz
    KisiOgrenciID = [];
    KisiOgrenciAd = [];
    KisiOgrenciLocation = [];
    KisiIsciID = [];
    KisiIsciAd = [];
    KisiIsciLocation = [];
    KisiOgrenciSira = [];
    KisiIsciSira = [];
    locations = [];
    var hh = $("#turForm").height();
    var sh = (hh - 50);
    $("#multiple_tur_map").height(sh);
    var directionsDisplay = [];
    var directionsService = [];
    var items = new Array();
    var markerIs = new Array();
    var infobox;
    var soforDeger = 0;
    var aracKapasite = $('select#TurArac option[value!="-1"]:selected').attr('kapasite');
    $("#totalKapasite").text(aracKapasite);
    if (navigator.geolocation) {
        console.log(ayirici);
        console.log(gelen.length);
        ayirici++;
        var icons = [];
        icons.push('../Plugins/mapView/build.png')
        if (hostes != 0) {//şoför seçildi ve locationu varsa
            for (var gelenicon = 1; gelenicon < gelen.length - 2; gelenicon++) {
                if (ayirici == 0) {//yoksa, yani öğrencinin yanında personel yoksa
                    if (index != 1) {//öğrenci
                        icons.push('../Plugins/mapView/red_student.png');
                    } else {//personel
                        icons.push('../Plugins/mapView/employee_red.png');
                    }
                } else {//ikiside varsa
                    if (gelenicon < ayirici) {//öğrenci
                        icons.push('../Plugins/mapView/red_student.png');
                    } else {//işçi
                        icons.push('../Plugins/mapView/employee_red.png');
                    }
                }
            }//şoför için
            icons.push('../Plugins/mapView/driver.png');
            icons.push('../Plugins/mapView/hostes.png');
            soforDeger++;
        }
        var mapOptions = {
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: true,
            scaleControl: true,
            streetViewControl: false,
            mapTypeControl: true
        };
        var iconsLength = icons.length;
        var newPos = new google.maps.LatLng(gelen[0][1],
                gelen[0][2]);
        var map = new google.maps.Map(document.getElementById('multiple_tur_map'),
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

        var markers = new Array();
        var marker;
        var number = 0;
        var iconCounter = 0;
        var b = 0;
        var key;
        var tiklananNumber;
        var artanKapasite = 0;
        var kayitSira = 1;
        var interval = setInterval(function () {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(gelen[b][1], gelen[b][2]),
                map: map,
                animation: google.maps.Animation.DROP,
                icon: icons[iconCounter],
                title: gelen[b][0],
                id: gelen[b][3],
                tur: gelen[b][4],
                number: number
            });
            markers.push(marker);
            //var markerCluster = new MarkerClusterer(map, markers);
            (function (marker, b) {
                google.maps.event.addListener(marker, "click", function (e) {
                    if (kayitDeger == 1) {
                        reset();
                        alertify.alert(jsDil.DuzenlemeAktif);
                        return false;
                    } else {
                        if (soforDeger == 0) {
                            reset();
                            alertify.alert(jsDil.SoforSecim);
                            return false;
                        } else {
                            if (this.number == 0) {
                                reset();
                                alertify.alert(jsDil.KurumVaris);
                                return false;
                            } else {
                                if (this.number == gelen.length - 2) {
                                    reset();
                                    alertify.alert(jsDil.SoforNokta);
                                    return false;
                                } else {
                                    if (this.number == gelen.length - 1) {
                                        reset();
                                        alertify.alert(jsDil.HostesNokta);
                                        return false;
                                    } else {
                                        tiklananNumber = this.number;
                                        var markerIndex = markerIs.indexOf(this.number);
                                        if (markerIndex != -1) {
                                            artanKapasite--;
                                            $("#totalKisi").text(artanKapasite);
                                        }
                                        if (artanKapasite < aracKapasite) {
                                            if (markerIs.length == 0) {
                                                KisiOgrenciID = [];
                                                KisiOgrenciAd = [];
                                                KisiOgrenciLocation = [];
                                                KisiIsciID = [];
                                                KisiIsciAd = [];
                                                KisiIsciLocation = [];
                                                KisiOgrenciSira = [];
                                                KisiIsciSira = [];
                                                if (this.tur == 0) {
                                                    KisiOgrenciSira.push(kayitSira++);
                                                    KisiOgrenciID.push(this.id);
                                                    KisiOgrenciAd.push(this.title);
                                                    KisiOgrenciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                    marker.setIcon('../Plugins/mapView/green_student.png');
                                                } else {
                                                    KisiIsciSira(kayitSira++);
                                                    KisiIsciID.push(this.id);
                                                    KisiIsciAd.push(this.title);
                                                    KisiIsciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                    marker.setIcon('../Plugins/mapView/employee_green.png');
                                                }
                                                items = [];

                                                markerIs.push(this.number);
                                                artanKapasite++;
                                                $("#totalKisi").text(artanKapasite);
                                                key = this.number;
                                                var obj = {};
                                                obj[key] = this.getPosition().lat() + ',' + this.getPosition().lng();

                                                items.push(obj);
                                                reset();
                                                alertify.alert(jsDil.BaslangicNokta);
                                                return false;
                                            } else {
                                                tiklananNumber = this.number;
                                                var markerIndex = markerIs.indexOf(this.number);
                                                if (markerIndex == -1) {
                                                    if (this.tur == 0) {
                                                        KisiOgrenciSira.push(kayitSira++);
                                                        KisiOgrenciID.push(this.id);
                                                        KisiOgrenciAd.push(this.title);
                                                        KisiOgrenciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                        marker.setIcon('../Plugins/mapView/green_student.png');
                                                    } else {
                                                        KisiIsciSira.push(kayitSira++);
                                                        KisiIsciID.push(this.id);
                                                        KisiIsciAd.push(this.title);
                                                        KisiIsciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                        marker.setIcon('../Plugins/mapView/employee_green.png');
                                                    }
                                                    markerIs.push(this.number);
                                                    artanKapasite++;
                                                    $("#totalKisi").text(artanKapasite);
                                                    if (items.length >= 2) {
                                                        items.pop();
                                                    }
                                                    var obj = {};
                                                    key = this.number;
                                                    obj[key] = this.getPosition().lat() + ',' + this.getPosition().lng();
                                                    items.push(obj);
                                                    locations = [];
                                                    var obj = {};
                                                    key = 0;
                                                    obj[key] = gelen[0][1] + ',' + gelen[0][2];
                                                    items.push(obj);
                                                    var bounds = new google.maps.LatLngBounds();
                                                    for (var a = 0; a < items.length; a++) {
                                                        for (var key in items[a])
                                                        {
                                                            var tmp_lat_lng = items[a][key].split(",");
                                                            locations.push(new google.maps.LatLng(tmp_lat_lng[0], tmp_lat_lng[1]));
                                                            bounds.extend(locations[locations.length - 1]);
                                                        }
                                                    }
                                                    directionsService = [];
                                                    hesapRoute();
                                                } else {
                                                    if (this.tur == 0) {
                                                        idOgrenciTurArama(this.id);
                                                        marker.setIcon('../Plugins/mapView/red_student.png');
                                                    } else {
                                                        idIsciTurArama(this.id);
                                                        marker.setIcon('../Plugins/mapView/employee_red.png');
                                                    }
                                                    markerKeyArama(items, tiklananNumber);
                                                    locations = [];
                                                    var bounds = new google.maps.LatLngBounds();
                                                    for (var a = 0; a < items.length; a++) {
                                                        for (var key in items[a])
                                                        {
                                                            var tmp_lat_lng = items[a][key].split(",");
                                                            locations.push(new google.maps.LatLng(tmp_lat_lng[0], tmp_lat_lng[1]));
                                                            bounds.extend(locations[locations.length - 1]);
                                                        }
                                                    }
                                                    directionsService = [];
                                                    hesapRoute();
                                                }
                                            }
                                        } else {
                                            reset();
                                            alertify.alert(jsDil.AracFazlaKapasite);
                                            return false;
                                            console.log(KisiOgrenciID);
                                            console.log(KisiOgrenciAd);
                                            console.log(KisiOgrenciLocation);
                                            console.log(KisiOgrenciSira);
                                            console.log(KisiIsciID);
                                            console.log(KisiIsciAd);
                                            console.log(KisiIsciSira);
                                        }
                                    }
                                }
                            }
                            $("#infobox").text(this.title);
                            infobox.open(map, marker);
                        }
                    }
                });
            })(marker, b);
            number++;
            b++;
            if (b == gelen.length) {
                clearInterval(interval);
            }

            iconCounter++;
            if (iconCounter >= iconsLength) {
                iconCounter = 0;
            }
        }, 200);


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
            document.getElementById('totalKm').innerHTML = total;
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

        function markerKeyArama(markerLocation, aranacak) {
            var indexNumber;
            for (var index = 0; index < markerLocation.length; index++) {
                for (var key in markerLocation[index])
                {
                    //console.log("key " + key + " has value " + markerLocation[index][key]);
                    if (key == aranacak) {
                        indexNumber = index;
                    }
                }
            }
            items.splice(indexNumber, 1);
            markerIs.splice(indexNumber, 1);
        }
        //id öğrenci arama
        function idOgrenciTurArama(aranacak) {
            var indexNumber;
            for (var index = 0; index < KisiOgrenciID.length; index++) {
                if (KisiOgrenciID[index] == aranacak) {
                    indexNumber = index;
                }
            }
            KisiOgrenciID.splice(indexNumber, 1);
            KisiOgrenciAd.splice(indexNumber, 1);
            KisiOgrenciLocation.splice(indexNumber, 1);
            KisiOgrenciSira.splice(indexNumber, 1);
        }
        //id işçi arama
        function idIsciTurArama(aranacak) {
            var indexNumber;
            for (var index = 0; index < KisiIsciID.length; index++) {
                if (KisiIsciID[index] == aranacak) {
                    indexNumber = index;
                }
            }
            KisiIsciID.splice(indexNumber, 1);
            KisiIsciAd.splice(indexNumber, 1);
            KisiIsciLocation.splice(indexNumber, 1);
            KisiIsciSira.splice(indexNumber, 1);
        }

    } else {
        reset();
        alertify.alert(jsDil.KonumYok);
        return false;
    }
}
//tur detay harita
function multipleTurDetayMap(kurumAd, kurumID, kurumLocation, soforAd, soforID, soforLocation) {
    /*
     * Gelen tür
     * 0->Öğrenci
     * 1->İşçi
     * 2->Şoför
     * 3->Okul
     */
    KisiOgrenciID = [];
    KisiOgrenciAd = [];
    KisiOgrenciLocation = [];
    KisiIsciID = [];
    KisiIsciAd = [];
    KisiIsciLocation = [];
    KisiOgrenciSira = [];
    KisiIsciSira = [];
    locations = [];
    var gelenKisiLocation = new Array();
    var gelenKisiAd = new Array();
    var gelenKisiID = new Array();
    var gelenKisiTip = new Array();
    gelenKisiLocation = DetailGidisGelenLocation.slice();
    gelenKisiAd = DetailGidisGelenAd.slice();
    gelenKisiID = DetailGidisGelenID.slice();
    gelenKisiTip = DetailGidisGelenTip.slice();
    //Turdaki locationları belirleme, diziye atama
    for (var turLoc = 0; turLoc < gelenKisiLocation.length; turLoc++) {
        var gelenLocationSplit = '';
        gelenLocationSplit = gelenKisiLocation[turLoc].split(",");
        locations.push(new google.maps.LatLng(gelenLocationSplit[0], gelenLocationSplit[1]));
    }

    gelenKisiLocation.unshift(kurumLocation);
    gelenKisiAd.unshift(kurumAd);
    gelenKisiID.unshift(kurumID);

    //diğer yolcuları parçalama
    if (DetailGidisDigerKisi.length > 0) {
        for (var digerKisi = 0; digerKisi < DetailGidisDigerKisi.length; digerKisi++) {
            var digeradSoyad = DetailGidisDigerKisi[digerKisi].digerKisiAd + '' + DetailGidisDigerKisi[digerKisi].digerKisiSoyad;
            gelenKisiAd.push(digeradSoyad);
            gelenKisiID.push(DetailGidisDigerKisi[digerKisi].digerKisiID);
            gelenKisiLocation.push(DetailGidisDigerKisi[digerKisi].digerKisiLocation);
        }
    }
    gelenKisiAd.push(soforAd);
    gelenKisiID.push(soforID);
    gelenKisiLocation.push(soforLocation);

    //gelen dizinin uzunluğu
    var diziGelenLength = gelenKisiLocation.length;

    var hh = $("#turDetayGidisForm").height();
    var sh = (hh - 50);
    $("#multiple_gidis_map").height(sh);
    var directionsDisplay = [];
    var directionsService = [];
    var items = new Array();
    var markerIs = new Array();
    var infobox;
    var map = null;
    //araç kapasitesini yazdırma
    $("#totalGidisKapasite").text(turDetayGidisAracKapasite);
    if (navigator.geolocation) {
        //okulu dizinin başına ekliyoruz
        var icons = [];
        icons.push('../Plugins/mapView/build.png');
        gelenKisiTip.unshift(3);
        //haritada olan kullancılar, yani seçili olanlar
        for (var gelenicon = 1; gelenicon < gelenKisiTip.length; gelenicon++) {
            if (gelenKisiTip[gelenicon] != 1) {//öğrenci
                icons.push('../Plugins/mapView/green_student.png');
            } else {//personel
                icons.push('../Plugins/mapView/employee_green.png');
            }
        }

        if (DetailGidisDigerKisi.length) {
            //hariada olmayan yani kurumun diğer kullancıları
            for (var digericon = 0; digericon < DetailGidisDigerKisi.length; digericon++) {
                if (DetailGidisDigerKisi[digericon].digerKisiTip != 1) {//öğrenci
                    gelenKisiTip.push(0);
                    icons.push('../Plugins/mapView/red_student.png');
                } else {//personel
                    gelenKisiTip.push(1);
                    icons.push('../Plugins/mapView/employee_red.png');
                }
            }
        }
        gelenKisiTip.push(2);
        icons.push('../Plugins/mapView/driver.png');

        var mapOptions = {
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: true,
            scaleControl: true,
            streetViewControl: false,
            mapTypeControl: true
        };
        var iconsLength = icons.length;
        var dizi = kurumLocation.split(",");
        var newPos = new google.maps.LatLng(dizi[0], dizi[1]);
        map = new google.maps.Map(document.getElementById('multiple_gidis_map'),
                mapOptions);
        infobox = new InfoBox({
            content: document.getElementById("infoboxGidis"),
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

        var markers = new Array();
        var marker;
        var number = 0;
        var iconCounter = 0;
        var b = 0;
        var split = 0;
        var key;
        //başta kullancıılar gelmekte
        var artanKapasite = DetailGidisGelenID.length;
        $("#totalGidisKisi").text(artanKapasite);
        var kayitSira = 0;
        var interval = setInterval(function () {
            var gelenLocationSplit = '';
            gelenLocationSplit = gelenKisiLocation[b].split(",");
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(gelenLocationSplit[0], gelenLocationSplit[1]),
                map: map,
                animation: google.maps.Animation.DROP,
                icon: icons[iconCounter],
                title: gelenKisiAd[b],
                id: gelenKisiID[b],
                tur: gelenKisiTip[b],
                number: number
            });
            if (b != 0) {
                if (b <= DetailGidisGelenID.length) {
                    markerIs.push(number);
                    if (gelenKisiTip[b] == 0) {
                        KisiOgrenciSira.push(kayitSira);
                        KisiOgrenciID.push(gelenKisiID[b]);
                        KisiOgrenciAd.push(gelenKisiAd[b]);
                        KisiOgrenciLocation.push(gelenLocationSplit[0] + ',' + gelenLocationSplit[1]);
                    } else {
                        KisiIsciSira.push(kayitSira);
                        KisiIsciID.push(gelenKisiID[b]);
                        KisiIsciAd.push(gelenKisiAd[b]);
                        KisiIsciLocation.push(gelenLocationSplit[0] + ',' + gelenLocationSplit[1]);
                    }
                    var obj = {};
                    key = number;
                    obj[key] = gelenLocationSplit[0] + ',' + gelenLocationSplit[1];
                    items.push(obj);
                }
            }
            markers.push(marker);

            //var markerCluster = new MarkerClusterer(map, markers);
            (function (marker, b) {
                google.maps.event.addListener(marker, "click", function (e) {
                    if (kayitDegerGidis == 0) {
                        reset();
                        alertify.alert(jsDil.DuzenlemeAktif);
                        return false;
                    } else {
                        if (this.number == diziGelenLength - 1) {
                            reset();
                            alertify.alert(jsDil.SoforNokta);
                            return false;
                        } else {
                            if (this.number == 0) {
                                reset();
                                alertify.alert(jsDil.KurumVaris);
                                return false;
                            } else {
                                var markerIndex = markerIs.indexOf(this.number);
                                if (markerIndex != -1) {
                                    artanKapasite--;
                                    $("#totalGidisKisi").text(artanKapasite);
                                }
                                if (artanKapasite < turDetayGidisAracKapasite) {
                                    if (markerIs.length == 0) {
                                        KisiOgrenciID = [];
                                        KisiOgrenciAd = [];
                                        KisiOgrenciLocation = [];
                                        KisiIsciID = [];
                                        KisiIsciAd = [];
                                        KisiIsciLocation = [];
                                        KisiOgrenciSira = [];
                                        KisiIsciSira = [];
                                        if (this.tur == 0) {
                                            KisiOgrenciSira.push(kayitSira++);
                                            KisiOgrenciID.push(this.id);
                                            KisiOgrenciAd.push(this.title);
                                            KisiOgrenciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                            marker.setIcon('../Plugins/mapView/green_student.png');
                                        } else {
                                            KisiIsciSira(kayitSira++);
                                            KisiIsciID.push(this.id);
                                            KisiIsciAd.push(this.title);
                                            KisiIsciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                            marker.setIcon('../Plugins/mapView/employee_green.png');
                                        }
                                        items = [];

                                        markerIs.push(this.number);
                                        artanKapasite++;
                                        $("#totalGidisKisi").text(artanKapasite);
                                        key = this.number;
                                        var obj = {};
                                        obj[key] = this.getPosition().lat() + ',' + this.getPosition().lng();
                                        items.push(obj);
                                        reset();
                                        alertify.alert(jsDil.BaslangicNokta);
                                        return false;
                                    } else {
                                        var markerIndex = markerIs.indexOf(this.number);
                                        if (markerIndex == -1) {//yoksa
                                            if (this.tur == 0) {
                                                KisiOgrenciSira.push(kayitSira++);
                                                KisiOgrenciID.push(this.id);
                                                KisiOgrenciAd.push(this.title);
                                                KisiOgrenciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                marker.setIcon('../Plugins/mapView/green_student.png');
                                            } else {
                                                KisiIsciSira.push(kayitSira++);
                                                KisiIsciID.push(this.id);
                                                KisiIsciAd.push(this.title);
                                                KisiIsciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                marker.setIcon('../Plugins/mapView/employee_green.png');
                                            }
                                            markerIs.push(this.number);
                                            artanKapasite++;
                                            $("#totalGidisKisi").text(artanKapasite);
                                            if (items.length >= 2) {
                                                items.pop();
                                            }
                                            var obj = {};
                                            key = this.number;
                                            obj[key] = this.getPosition().lat() + ',' + this.getPosition().lng();
                                            items.push(obj);
                                            locations = [];
                                            var obj = {};
                                            key = 0;
                                            obj[key] = dizi[0] + ',' + dizi[1];
                                            items.push(obj);
                                            var bounds = new google.maps.LatLngBounds();
                                            for (var a = 0; a < items.length; a++) {
                                                for (var key in items[a])
                                                {
                                                    var tmp_lat_lng = items[a][key].split(",");
                                                    locations.push(new google.maps.LatLng(tmp_lat_lng[0], tmp_lat_lng[1]));
                                                    bounds.extend(locations[locations.length - 1]);
                                                }
                                            }
                                            directionsService = [];
                                            hesapRoute();
                                        } else {//varsa
                                            if (this.tur == 0) {
                                                idOgrenciTurArama(this.id);
                                                marker.setIcon('../Plugins/mapView/red_student.png');
                                            } else {
                                                idIsciTurArama(this.id);
                                                marker.setIcon('../Plugins/mapView/employee_red.png');
                                            }
                                            markerKeyArama(items, this.number);
                                            locations = [];
                                            var bounds = new google.maps.LatLngBounds();
                                            for (var a = 0; a < items.length; a++) {
                                                for (var key in items[a])
                                                {
                                                    var tmp_lat_lng = items[a][key].split(",");
                                                    locations.push(new google.maps.LatLng(tmp_lat_lng[0], tmp_lat_lng[1]));
                                                    bounds.extend(locations[locations.length - 1]);
                                                }
                                            }
                                            directionsService = [];
                                            hesapRoute();
                                        }
                                    }
                                } else {
                                    reset();
                                    alertify.alert(jsDil.AracFazlaKapasite);
                                    return false;
                                    console.log(KisiOgrenciID);
                                    console.log(KisiOgrenciAd);
                                    console.log(KisiOgrenciLocation);
                                    console.log(KisiOgrenciSira);
                                    console.log(KisiIsciID);
                                    console.log(KisiIsciAd);
                                    console.log(KisiIsciSira);
                                }
                            }
                            $("#infoboxGidis").text(this.title);
                            infobox.open(map, marker);
                        }
                    }
                });
            })(marker, b);
            number++;
            b++;
            split++;
            kayitSira++;
            if (b == gelenKisiID.length) {
                clearInterval(interval);
            }

            iconCounter++;
            if (iconCounter >= iconsLength) {
                iconCounter = 0;
                //markerları bastığımda artık kurum lokasyonu ekleme
                var obj = {};
                key = 0;
                obj[key] = dizi[0] + ',' + dizi[1];
                items.push(obj);
                locations.push(new google.maps.LatLng(dizi[0], dizi[1]));
                hesapRoute();
            }
        }, 200);

        map.setCenter(newPos);
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
            document.getElementById('totalGidisKm').innerHTML = total;
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
        //merker arama
        function markerKeyArama(markerLocation, aranacak) {
            var indexNumber;
            for (var index = 0; index < markerLocation.length; index++) {
                for (var key in markerLocation[index])
                {
                    //console.log("key " + key + " has value " + markerLocation[index][key]);
                    if (key == aranacak) {
                        indexNumber = index;
                    }
                }
            }
            items.splice(indexNumber, 1);
            markerIs.splice(indexNumber, 1);
        }
        //id öğrenci arama
        function idOgrenciTurArama(aranacak) {
            var indexNumber;

            console.log(KisiOgrenciID);
            console.log(KisiOgrenciLocation);
            console.log(aranacak);
            for (var index = 0; index < KisiOgrenciID.length; index++) {
                if (KisiOgrenciID[index] == aranacak) {
                    indexNumber = index;
                }
            }
            KisiOgrenciID.splice(indexNumber, 1);
            KisiOgrenciAd.splice(indexNumber, 1);
            KisiOgrenciLocation.splice(indexNumber, 1);
            KisiOgrenciSira.splice(indexNumber, 1);
            console.log(KisiOgrenciID);
            console.log(KisiOgrenciAd);
            console.log(KisiOgrenciLocation);
            console.log(KisiOgrenciSira);

        }
        //id işçi arama
        function idIsciTurArama(aranacak) {
            var indexNumber;
            for (var index = 0; index < KisiIsciID.length; index++) {
                if (KisiIsciID[index] == aranacak) {
                    indexNumber = index;
                }
            }
            KisiIsciID.splice(indexNumber, 1);
            KisiIsciAd.splice(indexNumber, 1);
            KisiIsciLocation.splice(indexNumber, 1);
            KisiIsciSira.splice(indexNumber, 1);
        }
        //google.maps.event.addListener(map, 'click', find_closest_marker);
        function rad(x) {
            return x * Math.PI / 180;
        }
        //haversine formulüdür.İstenilen noktaya en yakın marker ı getirir.
        function find_closest_marker(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            var R = 6371; // radius of earth in km
            var distances = [];
            var closest = -1;
            for (i = 0; i < markers.length; i++) {
                var mlat = markers[i].position.lat();
                var mlng = markers[i].position.lng();
                var dLat = rad(mlat - lat);
                var dLong = rad(mlng - lng);
                var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                var d = R * c;
                distances[i] = d;
                if (closest == -1 || d < distances[closest]) {
                    closest = i;
                }
            }
        }

    } else {
        reset();
        alertify.alert(jsDil.KonumYok);
        return false;
    }
}
//tur hostes ile birlikte
function multipleTurHostesDetayMap(kurumAd, kurumID, kurumLocation, soforAd, soforID, soforLocation, hostesAd, hostesID, hostesLocation) {
    /*
     * Gelen tür
     * 0->Öğrenci
     * 1->İşçi
     * 2->Şoför
     * 3->Okul
     * 4->Hostes
     */
    KisiOgrenciID = [];
    KisiOgrenciAd = [];
    KisiOgrenciLocation = [];
    KisiIsciID = [];
    KisiIsciAd = [];
    KisiIsciLocation = [];
    KisiOgrenciSira = [];
    KisiIsciSira = [];
    locations = [];
    var gelenKisiLocation = new Array();
    var gelenKisiAd = new Array();
    var gelenKisiID = new Array();
    var gelenKisiTip = new Array();
    gelenKisiLocation = DetailGidisGelenLocation.slice();
    gelenKisiAd = DetailGidisGelenAd.slice();
    gelenKisiID = DetailGidisGelenID.slice();
    gelenKisiTip = DetailGidisGelenTip.slice();
    //Turdaki locationları belirleme, diziye atama
    for (var turLoc = 0; turLoc < gelenKisiLocation.length; turLoc++) {
        var gelenLocationSplit = '';
        gelenLocationSplit = gelenKisiLocation[turLoc].split(",");
        locations.push(new google.maps.LatLng(gelenLocationSplit[0], gelenLocationSplit[1]));
    }

    gelenKisiLocation.unshift(kurumLocation);
    gelenKisiAd.unshift(kurumAd);
    gelenKisiID.unshift(kurumID);

    //diğer yolcuları parçalama
    if (DetailGidisDigerKisi.length > 0) {
        for (var digerKisi = 0; digerKisi < DetailGidisDigerKisi.length; digerKisi++) {
            var digeradSoyad = DetailGidisDigerKisi[digerKisi].digerKisiAd + '' + DetailGidisDigerKisi[digerKisi].digerKisiSoyad;
            gelenKisiAd.push(digeradSoyad);
            gelenKisiID.push(DetailGidisDigerKisi[digerKisi].digerKisiID);
            gelenKisiLocation.push(DetailGidisDigerKisi[digerKisi].digerKisiLocation);
        }
    }
    gelenKisiAd.push(soforAd);
    gelenKisiID.push(soforID);
    gelenKisiLocation.push(soforLocation);
    gelenKisiAd.push(hostesAd);
    gelenKisiID.push(hostesID);
    gelenKisiLocation.push(hostesLocation);

    //gelen dizinin uzunluğu
    var diziGelenLength = gelenKisiLocation.length;

    var hh = $("#turDetayGidisForm").height();
    var sh = (hh - 50);
    $("#multiple_gidis_map").height(sh);
    var directionsDisplay = [];
    var directionsService = [];
    var items = new Array();
    var markerIs = new Array();
    var infobox;
    var map = null;
    $("#totalGidisKapasite").text(turDetayGidisAracKapasite);
    if (navigator.geolocation) {
        //okulu dizinin başına ekliyoruz
        var icons = [];
        icons.push('../Plugins/mapView/build.png');
        gelenKisiTip.unshift(3);
        //haritada olan kullancılar, yani seçili olanlar
        for (var gelenicon = 1; gelenicon < gelenKisiTip.length; gelenicon++) {
            if (gelenKisiTip[gelenicon] != 1) {//öğrenci
                icons.push('../Plugins/mapView/green_student.png');
            } else {//personel
                icons.push('../Plugins/mapView/employee_green.png');
            }
        }

        if (DetailGidisDigerKisi.length) {
            //hariada olmayan yani kurumun diğer kullancıları
            for (var digericon = 0; digericon < DetailGidisDigerKisi.length; digericon++) {
                if (DetailGidisDigerKisi[digericon].digerKisiTip != 1) {//öğrenci
                    gelenKisiTip.push(0);
                    icons.push('../Plugins/mapView/red_student.png');
                } else {//personel
                    gelenKisiTip.push(1);
                    icons.push('../Plugins/mapView/employee_red.png');
                }
            }
        }
        //şoför
        gelenKisiTip.push(2);
        icons.push('../Plugins/mapView/driver.png');
        //hostes
        gelenKisiTip.push(4);
        icons.push('../Plugins/mapView/hostes.png');

        var mapOptions = {
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: true,
            scaleControl: true,
            streetViewControl: false,
            mapTypeControl: true
        };
        var iconsLength = icons.length;
        var dizi = kurumLocation.split(",");
        var newPos = new google.maps.LatLng(dizi[0], dizi[1]);
        map = new google.maps.Map(document.getElementById('multiple_gidis_map'),
                mapOptions);
        infobox = new InfoBox({
            content: document.getElementById("infoboxGidis"),
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

        var markers = new Array();
        var marker;
        var number = 0;
        var iconCounter = 0;
        var b = 0;
        var split = 0;
        var key;
        //başta kullancıılar gelmekte
        var artanKapasite = DetailGidisGelenID.length;
        $("#totalGidisKisi").text(artanKapasite);
        var kayitSira = 0;
        var interval = setInterval(function () {
            var gelenLocationSplit = '';
            gelenLocationSplit = gelenKisiLocation[b].split(",");
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(gelenLocationSplit[0], gelenLocationSplit[1]),
                map: map,
                animation: google.maps.Animation.DROP,
                icon: icons[iconCounter],
                title: gelenKisiAd[b],
                id: gelenKisiID[b],
                tur: gelenKisiTip[b],
                number: number
            });
            if (b != 0) {
                if (b <= DetailGidisGelenID.length) {
                    markerIs.push(number);
                    if (gelenKisiTip[b] == 0) {
                        KisiOgrenciSira.push(kayitSira);
                        KisiOgrenciID.push(gelenKisiID[b]);
                        KisiOgrenciAd.push(gelenKisiAd[b]);
                        KisiOgrenciLocation.push(gelenLocationSplit[0] + ',' + gelenLocationSplit[1]);
                    } else {
                        KisiIsciSira.push(kayitSira);
                        KisiIsciID.push(gelenKisiID[b]);
                        KisiIsciAd.push(gelenKisiAd[b]);
                        KisiIsciLocation.push(gelenLocationSplit[0] + ',' + gelenLocationSplit[1]);
                    }
                    var obj = {};
                    key = number;
                    obj[key] = gelenLocationSplit[0] + ',' + gelenLocationSplit[1];
                    items.push(obj);
                }
            }
            markers.push(marker);

            //var markerCluster = new MarkerClusterer(map, markers);
            (function (marker, b) {
                google.maps.event.addListener(marker, "click", function (e) {
                    if (kayitDegerGidis == 0) {
                        reset();
                        alertify.alert(jsDil.DuzenlemeAktif);
                        return false;
                    } else {
                        if (this.number == diziGelenLength - 2) {
                            reset();
                            alertify.alert(jsDil.SoforNokta);
                            return false;
                        } else {
                            if (this.number == diziGelenLength - 1) {
                                reset();
                                alertify.alert(jsDil.HostesNokta);
                                return false;
                            } else {
                                if (this.number == 0) {
                                    reset();
                                    alertify.alert(jsDil.KurumVaris);
                                    return false;
                                } else {
                                    var markerIndex = markerIs.indexOf(this.number);
                                    if (markerIndex != -1) {
                                        artanKapasite--;
                                        $("#totalGidisKisi").text(artanKapasite);
                                    }
                                    if (artanKapasite < turDetayGidisAracKapasite) {
                                        if (markerIs.length == 0) {
                                            KisiOgrenciID = [];
                                            KisiOgrenciAd = [];
                                            KisiOgrenciLocation = [];
                                            KisiIsciID = [];
                                            KisiIsciAd = [];
                                            KisiIsciLocation = [];
                                            KisiOgrenciSira = [];
                                            KisiIsciSira = [];
                                            if (this.tur == 0) {
                                                KisiOgrenciSira.push(kayitSira++);
                                                KisiOgrenciID.push(this.id);
                                                KisiOgrenciAd.push(this.title);
                                                KisiOgrenciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                marker.setIcon('../Plugins/mapView/green_student.png');
                                            } else {
                                                KisiIsciSira(kayitSira++);
                                                KisiIsciID.push(this.id);
                                                KisiIsciAd.push(this.title);
                                                KisiIsciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                marker.setIcon('../Plugins/mapView/employee_green.png');
                                            }
                                            items = [];

                                            markerIs.push(this.number);
                                            artanKapasite++;
                                            $("#totalGidisKisi").text(artanKapasite);
                                            key = this.number;
                                            var obj = {};
                                            obj[key] = this.getPosition().lat() + ',' + this.getPosition().lng();
                                            items.push(obj);
                                            reset();
                                            alertify.alert(jsDil.BaslangicNokta);
                                            return false;
                                        } else {
                                            var markerIndex = markerIs.indexOf(this.number);
                                            if (markerIndex == -1) {//yoksa
                                                if (this.tur == 0) {
                                                    KisiOgrenciSira.push(kayitSira++);
                                                    KisiOgrenciID.push(this.id);
                                                    KisiOgrenciAd.push(this.title);
                                                    KisiOgrenciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                    marker.setIcon('../Plugins/mapView/green_student.png');
                                                } else {
                                                    KisiIsciSira.push(kayitSira++);
                                                    KisiIsciID.push(this.id);
                                                    KisiIsciAd.push(this.title);
                                                    KisiIsciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                    marker.setIcon('../Plugins/mapView/employee_green.png');
                                                }
                                                markerIs.push(this.number);
                                                artanKapasite++;
                                                $("#totalGidisKisi").text(artanKapasite);
                                                if (items.length >= 2) {
                                                    items.pop();
                                                }
                                                var obj = {};
                                                key = this.number;
                                                obj[key] = this.getPosition().lat() + ',' + this.getPosition().lng();
                                                items.push(obj);
                                                locations = [];
                                                var obj = {};
                                                key = 0;
                                                obj[key] = dizi[0] + ',' + dizi[1];
                                                items.push(obj);
                                                var bounds = new google.maps.LatLngBounds();
                                                for (var a = 0; a < items.length; a++) {
                                                    for (var key in items[a])
                                                    {
                                                        var tmp_lat_lng = items[a][key].split(",");
                                                        locations.push(new google.maps.LatLng(tmp_lat_lng[0], tmp_lat_lng[1]));
                                                        bounds.extend(locations[locations.length - 1]);
                                                    }
                                                }
                                                directionsService = [];
                                                hesapRoute();
                                            } else {//varsa
                                                if (this.tur == 0) {
                                                    idOgrenciTurArama(this.id);
                                                    marker.setIcon('../Plugins/mapView/red_student.png');
                                                } else {
                                                    idIsciTurArama(this.id);
                                                    marker.setIcon('../Plugins/mapView/employee_red.png');
                                                }
                                                markerKeyArama(items, this.number);
                                                locations = [];
                                                var bounds = new google.maps.LatLngBounds();
                                                for (var a = 0; a < items.length; a++) {
                                                    for (var key in items[a])
                                                    {
                                                        var tmp_lat_lng = items[a][key].split(",");
                                                        locations.push(new google.maps.LatLng(tmp_lat_lng[0], tmp_lat_lng[1]));
                                                        bounds.extend(locations[locations.length - 1]);
                                                    }
                                                }
                                                directionsService = [];
                                                hesapRoute();
                                            }
                                        }
                                    } else {
                                        reset();
                                        alertify.alert(jsDil.AracFazlaKapasite);
                                        return false;
                                        console.log(KisiOgrenciID);
                                        console.log(KisiOgrenciAd);
                                        console.log(KisiOgrenciLocation);
                                        console.log(KisiOgrenciSira);
                                        console.log(KisiIsciID);
                                        console.log(KisiIsciAd);
                                        console.log(KisiIsciSira);
                                    }
                                }
                                $("#infoboxGidis").text(this.title);
                                infobox.open(map, marker);
                            }
                        }
                    }
                });
            })(marker, b);
            number++;
            b++;
            split++;
            kayitSira++;
            if (b == gelenKisiID.length) {
                clearInterval(interval);
            }

            iconCounter++;
            if (iconCounter >= iconsLength) {
                iconCounter = 0;
                //markerları bastığımda artık kurum lokasyonu ekleme
                var obj = {};
                key = 0;
                obj[key] = dizi[0] + ',' + dizi[1];
                items.push(obj);
                locations.push(new google.maps.LatLng(dizi[0], dizi[1]));
                hesapRoute();
            }
        }, 200);

        map.setCenter(newPos);
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
            document.getElementById('totalGidisKm').innerHTML = total;
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
        //merker arama
        function markerKeyArama(markerLocation, aranacak) {
            var indexNumber;
            for (var index = 0; index < markerLocation.length; index++) {
                for (var key in markerLocation[index])
                {
                    //console.log("key " + key + " has value " + markerLocation[index][key]);
                    if (key == aranacak) {
                        indexNumber = index;
                    }
                }
            }
            items.splice(indexNumber, 1);
            markerIs.splice(indexNumber, 1);
        }
        //id öğrenci arama
        function idOgrenciTurArama(aranacak) {
            var indexNumber;

            console.log(KisiOgrenciID);
            console.log(KisiOgrenciLocation);
            console.log(aranacak);
            for (var index = 0; index < KisiOgrenciID.length; index++) {
                if (KisiOgrenciID[index] == aranacak) {
                    indexNumber = index;
                }
            }
            KisiOgrenciID.splice(indexNumber, 1);
            KisiOgrenciAd.splice(indexNumber, 1);
            KisiOgrenciLocation.splice(indexNumber, 1);
            KisiOgrenciSira.splice(indexNumber, 1);
            console.log(KisiOgrenciID);
            console.log(KisiOgrenciAd);
            console.log(KisiOgrenciLocation);
            console.log(KisiOgrenciSira);

        }
        //id işçi arama
        function idIsciTurArama(aranacak) {
            var indexNumber;
            for (var index = 0; index < KisiIsciID.length; index++) {
                if (KisiIsciID[index] == aranacak) {
                    indexNumber = index;
                }
            }
            KisiIsciID.splice(indexNumber, 1);
            KisiIsciAd.splice(indexNumber, 1);
            KisiIsciLocation.splice(indexNumber, 1);
            KisiIsciSira.splice(indexNumber, 1);
        }
        //google.maps.event.addListener(map, 'click', find_closest_marker);
        function rad(x) {
            return x * Math.PI / 180;
        }
        //haversine formulüdür.İstenilen noktaya en yakın marker ı getirir.
        function find_closest_marker(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            var R = 6371; // radius of earth in km
            var distances = [];
            var closest = -1;
            for (i = 0; i < markers.length; i++) {
                var mlat = markers[i].position.lat();
                var mlng = markers[i].position.lng();
                var dLat = rad(mlat - lat);
                var dLong = rad(mlng - lng);
                var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                var d = R * c;
                distances[i] = d;
                if (closest == -1 || d < distances[closest]) {
                    closest = i;
                }
            }
        }

    } else {
        reset();
        alertify.alert(jsDil.KonumYok);
        return false;
    }
}
//tur detay harita
function multipleTurDetayDonusMap(kurumAd, kurumID, kurumLocation, soforAd, soforID, soforLocation) {
    /*
     * Gelen tür
     * 0->Öğrenci
     * 1->İşçi
     * 2->Şoför
     * 3->Okul
     */
    KisiOgrenciID = [];
    KisiOgrenciAd = [];
    KisiOgrenciLocation = [];
    KisiIsciID = [];
    KisiIsciAd = [];
    KisiIsciLocation = [];
    KisiOgrenciSira = [];
    KisiIsciSira = [];
    locations = [];
    var gelenKisiLocation = new Array();
    var gelenKisiAd = new Array();
    var gelenKisiID = new Array();
    var gelenKisiTip = new Array();
    gelenKisiLocation = DetailDonusGelenLocation.slice();
    gelenKisiAd = DetailDonusGelenAd.slice();
    gelenKisiID = DetailDonusGelenID.slice();
    gelenKisiTip = DetailDonusGelenTip.slice();
    //Turdaki locationları belirleme, diziye atama
    for (var turLoc = 0; turLoc < gelenKisiLocation.length; turLoc++) {
        var gelenLocationSplit = '';
        gelenLocationSplit = gelenKisiLocation[turLoc].split(",");
        locations.push(new google.maps.LatLng(gelenLocationSplit[0], gelenLocationSplit[1]));
    }

    gelenKisiLocation.unshift(kurumLocation);
    gelenKisiAd.unshift(kurumAd);
    gelenKisiID.unshift(kurumID);

    //diğer yolcuları parçalama
    if (DetailDonusDigerKisi.length > 0) {
        for (var digerKisi = 0; digerKisi < DetailDonusDigerKisi.length; digerKisi++) {
            var digeradSoyad = DetailDonusDigerKisi[digerKisi].digerKisiAd + '' + DetailDonusDigerKisi[digerKisi].digerKisiSoyad;
            gelenKisiAd.push(digeradSoyad);
            gelenKisiID.push(DetailDonusDigerKisi[digerKisi].digerKisiID);
            gelenKisiLocation.push(DetailDonusDigerKisi[digerKisi].digerKisiLocation);
        }
    }
    gelenKisiAd.push(soforAd);
    gelenKisiID.push(soforID);
    gelenKisiLocation.push(soforLocation);

    //gelen dizinin uzunluğu
    var diziGelenLength = gelenKisiLocation.length;

    var hh = $("#turDetayDonusForm").height();
    var sh = (hh - 50);
    $("#multiple_donus_map").height(sh);
    var directionsDisplay = [];
    var directionsService = [];
    var items = new Array();
    var markerIs = new Array();
    var infobox;
    var map = null;
    $("#totalDonusKapasite").text(turDetayDonusAracKapasite);
    if (navigator.geolocation) {
        //okulu dizinin başına ekliyoruz
        var icons = [];
        icons.push('../Plugins/mapView/build.png');
        gelenKisiTip.unshift(3);
        //haritada olan kullancılar, yani seçili olanlar
        for (var gelenicon = 1; gelenicon < gelenKisiTip.length; gelenicon++) {
            if (gelenKisiTip[gelenicon] != 1) {//öğrenci
                icons.push('../Plugins/mapView/green_student.png');
            } else {//personel
                icons.push('../Plugins/mapView/employee_green.png');
            }
        }

        if (DetailDonusDigerKisi.length) {
            //hariada olmayan yani kurumun diğer kullancıları
            for (var digericon = 0; digericon < DetailDonusDigerKisi.length; digericon++) {
                if (DetailDonusDigerKisi[digericon].digerKisiTip != 1) {//öğrenci
                    gelenKisiTip.push(0);
                    icons.push('../Plugins/mapView/red_student.png');
                } else {//personel
                    gelenKisiTip.push(1);
                    icons.push('../Plugins/mapView/employee_red.png');
                }
            }
        }
        gelenKisiTip.push(2);
        icons.push('../Plugins/mapView/driver.png');

        var mapOptions = {
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: true,
            scaleControl: true,
            streetViewControl: false,
            mapTypeControl: true
        };
        var iconsLength = icons.length;
        var dizi = kurumLocation.split(",");
        var newPos = new google.maps.LatLng(dizi[0], dizi[1]);
        map = new google.maps.Map(document.getElementById('multiple_donus_map'),
                mapOptions);
        infobox = new InfoBox({
            content: document.getElementById("infoboxDonus"),
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

        var markers = new Array();
        var marker;
        var number = 0;
        var iconCounter = 0;
        var b = 0;
        var split = 0;
        var key;
        //başta kullancıılar gelmekte
        var artanKapasite = DetailDonusGelenID.length;
        $("#totalDonusKisi").text(artanKapasite);
        var kayitSira = 0;
        var interval = setInterval(function () {
            var gelenLocationSplit = '';
            gelenLocationSplit = gelenKisiLocation[b].split(",");
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(gelenLocationSplit[0], gelenLocationSplit[1]),
                map: map,
                animation: google.maps.Animation.DROP,
                icon: icons[iconCounter],
                title: gelenKisiAd[b],
                id: gelenKisiID[b],
                tur: gelenKisiTip[b],
                number: number
            });
            if (b != 0) {
                if (b <= DetailDonusGelenID.length) {
                    markerIs.push(number);
                    if (gelenKisiTip[b] == 0) {
                        KisiOgrenciSira.push(kayitSira);
                        KisiOgrenciID.push(gelenKisiID[b]);
                        KisiOgrenciAd.push(gelenKisiAd[b]);
                        KisiOgrenciLocation.push(gelenLocationSplit[0] + ',' + gelenLocationSplit[1]);
                    } else {
                        KisiIsciSira.push(kayitSira);
                        KisiIsciID.push(gelenKisiID[b]);
                        KisiIsciAd.push(gelenKisiAd[b]);
                        KisiIsciLocation.push(gelenLocationSplit[0] + ',' + gelenLocationSplit[1]);
                    }
                    var obj = {};
                    key = number;
                    obj[key] = gelenLocationSplit[0] + ',' + gelenLocationSplit[1];
                    items.push(obj);
                }
            }
            markers.push(marker);

            //var markerCluster = new MarkerClusterer(map, markers);
            (function (marker, b) {
                google.maps.event.addListener(marker, "click", function (e) {
                    if (kayitDegerDonus == 0) {
                        reset();
                        alertify.alert(jsDil.DuzenlemeAktif);
                        return false;
                    } else {
                        if (this.number == diziGelenLength - 1) {
                            reset();
                            alertify.alert(jsDil.SoforNokta);
                            return false;
                        } else {
                            if (this.number == 0) {
                                reset();
                                alertify.alert(jsDil.KurumVaris);
                                return false;
                            } else {
                                var markerIndex = markerIs.indexOf(this.number);
                                if (markerIndex != -1) {
                                    artanKapasite--;
                                    $("#totalDonusKisi").text(artanKapasite);
                                }
                                if (artanKapasite < turDetayDonusAracKapasite) {
                                    if (markerIs.length == 0) {
                                        KisiOgrenciID = [];
                                        KisiOgrenciAd = [];
                                        KisiOgrenciLocation = [];
                                        KisiIsciID = [];
                                        KisiIsciAd = [];
                                        KisiIsciLocation = [];
                                        KisiOgrenciSira = [];
                                        KisiIsciSira = [];
                                        if (this.tur == 0) {
                                            KisiOgrenciSira.push(kayitSira++);
                                            KisiOgrenciID.push(this.id);
                                            KisiOgrenciAd.push(this.title);
                                            KisiOgrenciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                            marker.setIcon('../Plugins/mapView/green_student.png');
                                        } else {
                                            KisiIsciSira(kayitSira++);
                                            KisiIsciID.push(this.id);
                                            KisiIsciAd.push(this.title);
                                            KisiIsciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                            marker.setIcon('../Plugins/mapView/employee_green.png');
                                        }
                                        items = [];

                                        markerIs.push(this.number);
                                        artanKapasite++;
                                        $("#totalDonusKisi").text(artanKapasite);
                                        key = this.number;
                                        var obj = {};
                                        obj[key] = this.getPosition().lat() + ',' + this.getPosition().lng();
                                        items.push(obj);
                                        reset();
                                        alertify.alert(jsDil.BaslangicNokta);
                                        return false;
                                    } else {
                                        var markerIndex = markerIs.indexOf(this.number);
                                        if (markerIndex == -1) {//yoksa
                                            if (this.tur == 0) {
                                                KisiOgrenciSira.push(kayitSira++);
                                                KisiOgrenciID.push(this.id);
                                                KisiOgrenciAd.push(this.title);
                                                KisiOgrenciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                marker.setIcon('../Plugins/mapView/green_student.png');
                                            } else {
                                                KisiIsciSira.push(kayitSira++);
                                                KisiIsciID.push(this.id);
                                                KisiIsciAd.push(this.title);
                                                KisiIsciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                marker.setIcon('../Plugins/mapView/employee_green.png');
                                            }
                                            markerIs.push(this.number);
                                            artanKapasite++;
                                            $("#totalDonusKisi").text(artanKapasite);
                                            if (items.length >= 2) {
                                                items.pop();
                                            }
                                            var obj = {};
                                            key = this.number;
                                            obj[key] = this.getPosition().lat() + ',' + this.getPosition().lng();
                                            items.push(obj);
                                            locations = [];
                                            var obj = {};
                                            key = 0;
                                            obj[key] = dizi[0] + ',' + dizi[1];
                                            items.push(obj);
                                            var bounds = new google.maps.LatLngBounds();
                                            for (var a = 0; a < items.length; a++) {
                                                for (var key in items[a])
                                                {
                                                    var tmp_lat_lng = items[a][key].split(",");
                                                    locations.push(new google.maps.LatLng(tmp_lat_lng[0], tmp_lat_lng[1]));
                                                    bounds.extend(locations[locations.length - 1]);
                                                }
                                            }
                                            directionsService = [];
                                            hesapRoute();
                                        } else {//varsa
                                            if (this.tur == 0) {
                                                idOgrenciTurArama(this.id);
                                                marker.setIcon('../Plugins/mapView/red_student.png');
                                            } else {
                                                idIsciTurArama(this.id);
                                                marker.setIcon('../Plugins/mapView/employee_red.png');
                                            }
                                            markerKeyArama(items, this.number);
                                            locations = [];
                                            var bounds = new google.maps.LatLngBounds();
                                            for (var a = 0; a < items.length; a++) {
                                                for (var key in items[a])
                                                {
                                                    var tmp_lat_lng = items[a][key].split(",");
                                                    locations.push(new google.maps.LatLng(tmp_lat_lng[0], tmp_lat_lng[1]));
                                                    bounds.extend(locations[locations.length - 1]);
                                                }
                                            }
                                            directionsService = [];
                                            hesapRoute();
                                        }
                                    }
                                } else {
                                    reset();
                                    alertify.alert(jsDil.AracFazlaKapasite);
                                    return false;
                                    console.log(KisiOgrenciID);
                                    console.log(KisiOgrenciAd);
                                    console.log(KisiOgrenciLocation);
                                    console.log(KisiOgrenciSira);
                                    console.log(KisiIsciID);
                                    console.log(KisiIsciAd);
                                    console.log(KisiIsciSira);
                                }
                            }
                            $("#infoboxDonus").text(this.title);
                            infobox.open(map, marker);
                        }
                    }
                });
            })(marker, b);
            number++;
            b++;
            split++;
            kayitSira++;
            if (b == gelenKisiID.length) {
                clearInterval(interval);
            }

            iconCounter++;
            if (iconCounter >= iconsLength) {
                iconCounter = 0;
                //markerları bastığımda artık kurum lokasyonu ekleme
                var obj = {};
                key = 0;
                obj[key] = dizi[0] + ',' + dizi[1];
                items.push(obj);
                locations.push(new google.maps.LatLng(dizi[0], dizi[1]));
                hesapRoute();
            }
        }, 200);

        map.setCenter(newPos);
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
            document.getElementById('totalDonusKm').innerHTML = total;
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
        //merker arama
        function markerKeyArama(markerLocation, aranacak) {
            var indexNumber;
            for (var index = 0; index < markerLocation.length; index++) {
                for (var key in markerLocation[index])
                {
                    //console.log("key " + key + " has value " + markerLocation[index][key]);
                    if (key == aranacak) {
                        indexNumber = index;
                    }
                }
            }
            items.splice(indexNumber, 1);
            markerIs.splice(indexNumber, 1);
        }
        //id öğrenci arama
        function idOgrenciTurArama(aranacak) {
            var indexNumber;

            console.log(KisiOgrenciID);
            console.log(KisiOgrenciLocation);
            console.log(aranacak);
            for (var index = 0; index < KisiOgrenciID.length; index++) {
                if (KisiOgrenciID[index] == aranacak) {
                    indexNumber = index;
                }
            }
            KisiOgrenciID.splice(indexNumber, 1);
            KisiOgrenciAd.splice(indexNumber, 1);
            KisiOgrenciLocation.splice(indexNumber, 1);
            KisiOgrenciSira.splice(indexNumber, 1);
            console.log(KisiOgrenciID);
            console.log(KisiOgrenciAd);
            console.log(KisiOgrenciLocation);
            console.log(KisiOgrenciSira);

        }
        //id işçi arama
        function idIsciTurArama(aranacak) {
            var indexNumber;
            for (var index = 0; index < KisiIsciID.length; index++) {
                if (KisiIsciID[index] == aranacak) {
                    indexNumber = index;
                }
            }
            KisiIsciID.splice(indexNumber, 1);
            KisiIsciAd.splice(indexNumber, 1);
            KisiIsciLocation.splice(indexNumber, 1);
            KisiIsciSira.splice(indexNumber, 1);
        }
        //google.maps.event.addListener(map, 'click', find_closest_marker);
        function rad(x) {
            return x * Math.PI / 180;
        }
        //haversine formulüdür.İstenilen noktaya en yakın marker ı getirir.
        function find_closest_marker(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            var R = 6371; // radius of earth in km
            var distances = [];
            var closest = -1;
            for (i = 0; i < markers.length; i++) {
                var mlat = markers[i].position.lat();
                var mlng = markers[i].position.lng();
                var dLat = rad(mlat - lat);
                var dLong = rad(mlng - lng);
                var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                var d = R * c;
                distances[i] = d;
                if (closest == -1 || d < distances[closest]) {
                    closest = i;
                }
            }
        }

    } else {
        reset();
        alertify.alert(jsDil.KonumYok);
        return false;
    }
}
//tur hostes ile birlikte detay harita
function multipleTurHostesDetayDonusMap(kurumAd, kurumID, kurumLocation, soforAd, soforID, soforLocation, hostesAd, hostesID, hostesLocation) {
    /*
     * Gelen tür
     * 0->Öğrenci
     * 1->İşçi
     * 2->Şoför
     * 3->Okul
     * 4->Hostes
     */
    KisiOgrenciID = [];
    KisiOgrenciAd = [];
    KisiOgrenciLocation = [];
    KisiIsciID = [];
    KisiIsciAd = [];
    KisiIsciLocation = [];
    KisiOgrenciSira = [];
    KisiIsciSira = [];
    locations = [];
    var gelenKisiLocation = new Array();
    var gelenKisiAd = new Array();
    var gelenKisiID = new Array();
    var gelenKisiTip = new Array();
    gelenKisiLocation = DetailDonusGelenLocation.slice();
    gelenKisiAd = DetailDonusGelenAd.slice();
    gelenKisiID = DetailDonusGelenID.slice();
    gelenKisiTip = DetailDonusGelenTip.slice();
    //Turdaki locationları belirleme, diziye atama
    for (var turLoc = 0; turLoc < gelenKisiLocation.length; turLoc++) {
        var gelenLocationSplit = '';
        gelenLocationSplit = gelenKisiLocation[turLoc].split(",");
        locations.push(new google.maps.LatLng(gelenLocationSplit[0], gelenLocationSplit[1]));
    }

    gelenKisiLocation.unshift(kurumLocation);
    gelenKisiAd.unshift(kurumAd);
    gelenKisiID.unshift(kurumID);

    //diğer yolcuları parçalama
    if (DetailDonusDigerKisi.length > 0) {
        for (var digerKisi = 0; digerKisi < DetailDonusDigerKisi.length; digerKisi++) {
            var digeradSoyad = DetailDonusDigerKisi[digerKisi].digerKisiAd + '' + DetailDonusDigerKisi[digerKisi].digerKisiSoyad;
            gelenKisiAd.push(digeradSoyad);
            gelenKisiID.push(DetailDonusDigerKisi[digerKisi].digerKisiID);
            gelenKisiLocation.push(DetailDonusDigerKisi[digerKisi].digerKisiLocation);
        }
    }
    gelenKisiAd.push(soforAd);
    gelenKisiID.push(soforID);
    gelenKisiLocation.push(soforLocation);
    gelenKisiAd.push(hostesAd);
    gelenKisiID.push(hostesID);
    gelenKisiLocation.push(hostesLocation);

    //gelen dizinin uzunluğu
    var diziGelenLength = gelenKisiLocation.length;

    var hh = $("#turDetayDonusForm").height();
    var sh = (hh - 50);
    $("#multiple_donus_map").height(sh);
    var directionsDisplay = [];
    var directionsService = [];
    var items = new Array();
    var markerIs = new Array();
    var infobox;
    var map = null;
    $("#totalDonusKapasite").text(turDetayDonusAracKapasite);
    if (navigator.geolocation) {
        //okulu dizinin başına ekliyoruz
        var icons = [];
        icons.push('../Plugins/mapView/build.png');
        gelenKisiTip.unshift(3);
        //haritada olan kullancılar, yani seçili olanlar
        for (var gelenicon = 1; gelenicon < gelenKisiTip.length; gelenicon++) {
            if (gelenKisiTip[gelenicon] != 1) {//öğrenci
                icons.push('../Plugins/mapView/green_student.png');
            } else {//personel
                icons.push('../Plugins/mapView/employee_green.png');
            }
        }

        if (DetailDonusDigerKisi.length) {
            //hariada olmayan yani kurumun diğer kullancıları
            for (var digericon = 0; digericon < DetailDonusDigerKisi.length; digericon++) {
                if (DetailDonusDigerKisi[digericon].digerKisiTip != 1) {//öğrenci
                    gelenKisiTip.push(0);
                    icons.push('../Plugins/mapView/red_student.png');
                } else {//personel
                    gelenKisiTip.push(1);
                    icons.push('../Plugins/mapView/employee_red.png');
                }
            }
        }
        gelenKisiTip.push(2);
        gelenKisiTip.push(4);
        icons.push('../Plugins/mapView/driver.png');
        icons.push('../Plugins/mapView/hostes.png');

        var mapOptions = {
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: true,
            scaleControl: true,
            streetViewControl: false,
            mapTypeControl: true
        };
        var iconsLength = icons.length;
        var dizi = kurumLocation.split(",");
        var newPos = new google.maps.LatLng(dizi[0], dizi[1]);
        map = new google.maps.Map(document.getElementById('multiple_donus_map'),
                mapOptions);
        infobox = new InfoBox({
            content: document.getElementById("infoboxDonus"),
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

        var markers = new Array();
        var marker;
        var number = 0;
        var iconCounter = 0;
        var b = 0;
        var split = 0;
        var key;
        //başta kullancıılar gelmekte
        var artanKapasite = DetailDonusGelenID.length;
        $("#totalDonusKisi").text(artanKapasite);
        var kayitSira = 0;
        var interval = setInterval(function () {
            var gelenLocationSplit = '';
            gelenLocationSplit = gelenKisiLocation[b].split(",");
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(gelenLocationSplit[0], gelenLocationSplit[1]),
                map: map,
                animation: google.maps.Animation.DROP,
                icon: icons[iconCounter],
                title: gelenKisiAd[b],
                id: gelenKisiID[b],
                tur: gelenKisiTip[b],
                number: number
            });
            if (b != 0) {
                if (b <= DetailDonusGelenID.length) {
                    markerIs.push(number);
                    if (gelenKisiTip[b] == 0) {
                        KisiOgrenciSira.push(kayitSira);
                        KisiOgrenciID.push(gelenKisiID[b]);
                        KisiOgrenciAd.push(gelenKisiAd[b]);
                        KisiOgrenciLocation.push(gelenLocationSplit[0] + ',' + gelenLocationSplit[1]);
                    } else {
                        KisiIsciSira.push(kayitSira);
                        KisiIsciID.push(gelenKisiID[b]);
                        KisiIsciAd.push(gelenKisiAd[b]);
                        KisiIsciLocation.push(gelenLocationSplit[0] + ',' + gelenLocationSplit[1]);
                    }
                    var obj = {};
                    key = number;
                    obj[key] = gelenLocationSplit[0] + ',' + gelenLocationSplit[1];
                    items.push(obj);
                }
            }
            markers.push(marker);

            //var markerCluster = new MarkerClusterer(map, markers);
            (function (marker, b) {
                google.maps.event.addListener(marker, "click", function (e) {
                    if (kayitDegerDonus == 0) {
                        reset();
                        alertify.alert(jsDil.DuzenlemeAktif);
                        return false;
                    } else {
                        if (this.number == diziGelenLength - 1) {
                            reset();
                            alertify.alert(jsDil.SoforNokta);
                            return false;
                        } else {
                            if (this.number == 0) {
                                reset();
                                alertify.alert(jsDil.KurumVaris);
                                return false;
                            } else {
                                var markerIndex = markerIs.indexOf(this.number);
                                if (markerIndex != -1) {
                                    artanKapasite--;
                                    $("#totalDonusKisi").text(artanKapasite);
                                }
                                if (artanKapasite < turDetayDonusAracKapasite) {
                                    if (markerIs.length == 0) {
                                        KisiOgrenciID = [];
                                        KisiOgrenciAd = [];
                                        KisiOgrenciLocation = [];
                                        KisiIsciID = [];
                                        KisiIsciAd = [];
                                        KisiIsciLocation = [];
                                        KisiOgrenciSira = [];
                                        KisiIsciSira = [];
                                        if (this.tur == 0) {
                                            KisiOgrenciSira.push(kayitSira++);
                                            KisiOgrenciID.push(this.id);
                                            KisiOgrenciAd.push(this.title);
                                            KisiOgrenciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                            marker.setIcon('../Plugins/mapView/green_student.png');
                                        } else {
                                            KisiIsciSira(kayitSira++);
                                            KisiIsciID.push(this.id);
                                            KisiIsciAd.push(this.title);
                                            KisiIsciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                            marker.setIcon('../Plugins/mapView/employee_green.png');
                                        }
                                        items = [];

                                        markerIs.push(this.number);
                                        artanKapasite++;
                                        $("#totalDonusKisi").text(artanKapasite);
                                        key = this.number;
                                        var obj = {};
                                        obj[key] = this.getPosition().lat() + ',' + this.getPosition().lng();
                                        items.push(obj);
                                        reset();
                                        alertify.alert(jsDil.BaslangicNokta);
                                        return false;
                                    } else {
                                        var markerIndex = markerIs.indexOf(this.number);
                                        if (markerIndex == -1) {//yoksa
                                            if (this.tur == 0) {
                                                KisiOgrenciSira.push(kayitSira++);
                                                KisiOgrenciID.push(this.id);
                                                KisiOgrenciAd.push(this.title);
                                                KisiOgrenciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                marker.setIcon('../Plugins/mapView/green_student.png');
                                            } else {
                                                KisiIsciSira.push(kayitSira++);
                                                KisiIsciID.push(this.id);
                                                KisiIsciAd.push(this.title);
                                                KisiIsciLocation.push(this.getPosition().lat() + ',' + this.getPosition().lng());
                                                marker.setIcon('../Plugins/mapView/employee_green.png');
                                            }
                                            markerIs.push(this.number);
                                            artanKapasite++;
                                            $("#totalDonusKisi").text(artanKapasite);
                                            if (items.length >= 2) {
                                                items.pop();
                                            }
                                            var obj = {};
                                            key = this.number;
                                            obj[key] = this.getPosition().lat() + ',' + this.getPosition().lng();
                                            items.push(obj);
                                            locations = [];
                                            var obj = {};
                                            key = 0;
                                            obj[key] = dizi[0] + ',' + dizi[1];
                                            items.push(obj);
                                            var bounds = new google.maps.LatLngBounds();
                                            for (var a = 0; a < items.length; a++) {
                                                for (var key in items[a])
                                                {
                                                    var tmp_lat_lng = items[a][key].split(",");
                                                    locations.push(new google.maps.LatLng(tmp_lat_lng[0], tmp_lat_lng[1]));
                                                    bounds.extend(locations[locations.length - 1]);
                                                }
                                            }
                                            directionsService = [];
                                            hesapRoute();
                                        } else {//varsa
                                            if (this.tur == 0) {
                                                idOgrenciTurArama(this.id);
                                                marker.setIcon('../Plugins/mapView/red_student.png');
                                            } else {
                                                idIsciTurArama(this.id);
                                                marker.setIcon('../Plugins/mapView/employee_red.png');
                                            }
                                            markerKeyArama(items, this.number);
                                            locations = [];
                                            var bounds = new google.maps.LatLngBounds();
                                            for (var a = 0; a < items.length; a++) {
                                                for (var key in items[a])
                                                {
                                                    var tmp_lat_lng = items[a][key].split(",");
                                                    locations.push(new google.maps.LatLng(tmp_lat_lng[0], tmp_lat_lng[1]));
                                                    bounds.extend(locations[locations.length - 1]);
                                                }
                                            }
                                            directionsService = [];
                                            hesapRoute();
                                        }
                                    }
                                } else {
                                    reset();
                                    alertify.alert(jsDil.AracFazlaKapasite);
                                    return false;
                                    console.log(KisiOgrenciID);
                                    console.log(KisiOgrenciAd);
                                    console.log(KisiOgrenciLocation);
                                    console.log(KisiOgrenciSira);
                                    console.log(KisiIsciID);
                                    console.log(KisiIsciAd);
                                    console.log(KisiIsciSira);
                                }
                            }
                            $("#infoboxDonus").text(this.title);
                            infobox.open(map, marker);
                        }
                    }
                });
            })(marker, b);
            number++;
            b++;
            split++;
            kayitSira++;
            if (b == gelenKisiID.length) {
                clearInterval(interval);
            }

            iconCounter++;
            if (iconCounter >= iconsLength) {
                iconCounter = 0;
                //markerları bastığımda artık kurum lokasyonu ekleme
                var obj = {};
                key = 0;
                obj[key] = dizi[0] + ',' + dizi[1];
                items.push(obj);
                locations.push(new google.maps.LatLng(dizi[0], dizi[1]));
                hesapRoute();
            }
        }, 200);

        map.setCenter(newPos);
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
            document.getElementById('totalDonusKm').innerHTML = total;
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
        //merker arama
        function markerKeyArama(markerLocation, aranacak) {
            var indexNumber;
            for (var index = 0; index < markerLocation.length; index++) {
                for (var key in markerLocation[index])
                {
                    //console.log("key " + key + " has value " + markerLocation[index][key]);
                    if (key == aranacak) {
                        indexNumber = index;
                    }
                }
            }
            items.splice(indexNumber, 1);
            markerIs.splice(indexNumber, 1);
        }
        //id öğrenci arama
        function idOgrenciTurArama(aranacak) {
            var indexNumber;
            for (var index = 0; index < KisiOgrenciID.length; index++) {
                if (KisiOgrenciID[index] == aranacak) {
                    indexNumber = index;
                }
            }
            KisiOgrenciID.splice(indexNumber, 1);
            KisiOgrenciAd.splice(indexNumber, 1);
            KisiOgrenciLocation.splice(indexNumber, 1);
            KisiOgrenciSira.splice(indexNumber, 1);

        }
        //id işçi arama
        function idIsciTurArama(aranacak) {
            var indexNumber;
            for (var index = 0; index < KisiIsciID.length; index++) {
                if (KisiIsciID[index] == aranacak) {
                    indexNumber = index;
                }
            }
            KisiIsciID.splice(indexNumber, 1);
            KisiIsciAd.splice(indexNumber, 1);
            KisiIsciLocation.splice(indexNumber, 1);
            KisiIsciSira.splice(indexNumber, 1);
        }
        //google.maps.event.addListener(map, 'click', find_closest_marker);
        function rad(x) {
            return x * Math.PI / 180;
        }
        //haversine formulüdür.İstenilen noktaya en yakın marker ı getirir.
        function find_closest_marker(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            var R = 6371; // radius of earth in km
            var distances = [];
            var closest = -1;
            for (i = 0; i < markers.length; i++) {
                var mlat = markers[i].position.lat();
                var mlng = markers[i].position.lng();
                var dLat = rad(mlat - lat);
                var dLong = rad(mlng - lng);
                var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                var d = R * c;
                distances[i] = d;
                if (closest == -1 || d < distances[closest]) {
                    closest = i;
                }
            }
        }

    } else {
        reset();
        alertify.alert(jsDil.KonumYok);
        return false;
    }
}

/*
 * eski hali
 * 
 * 
 var iconCounter = 0;
 for (var i = 0; i < gelen.length; i++) {
 var marker = new google.maps.Marker({
 position: new google.maps.LatLng(gelen[i][1], gelen[i][2]),
 map: map,
 animation: google.maps.Animation.DROP,
 icon: icons[iconCounter]
 });
 //google.maps.event.addListener(marker, 'click', toggleBounce);
 markers.push(marker);
 
 
 google.maps.event.addListener(marker, 'click', (function (marker, i) {
 return function () {
 console.log(this.getPosition().lat() + ',' + this.getPosition().lng());
 infowindow.setContent(gelen[i][0]);
 infowindow.open(map, marker);
 }
 })(marker, i));
 
 iconCounter++;
 
 if (iconCounter >= iconsLength) {
 iconCounter = 0;
 }
 }
 */