// Document Ready
var z = 1;
var MultipleMapArray = new Array();
var MultipleMapindex;

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
            case 'adminAracYeni' :
                var returnCevap = $.AdminIslemler.adminAracYeni();
                break;
            case 'adminAracDetailTur' :
                var returnCevap = $.AdminIslemler.adminAracDetailTur();
                break;
            case 'adminAracTakvim' :
                $("#" + dclass).height(th);
                $("#" + dclass).css("z-index", z);
                $("#" + dclass).attr("data-z", z);
                $('[data-z="' + (z - 1) + '"]').css("display", "none");
                $('#' + dclass).toggle(effect, options, duration);
                z++;
                $.AdminIslemler.adminAracTakvim();
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
            if (isMap == true) {
                var mh = $("#mapHeader").height();
                var sh = th - mh;
                $("#multiple_map").height(sh);
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
            case 'adminAracEkle' :
                var returnCevap = $.AdminIslemler.adminAracEkle();
                break;
            case 'adminAracVazgec' :
                var returnCevap = $.AdminIslemler.adminAracVazgec();
                break;
            case 'adminAracDetailSil' :
                var returnCevap = $.AdminIslemler.adminAracDetailSil();
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
        document.getElementById('google_canvas').innerHTML = 'Konumunuz bulunmadı.';
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
        document.getElementById('google_canvas').innerHTML = 'Konumunuz bulunmadı.';
    }
}

//End çoklu mapping işlemleri