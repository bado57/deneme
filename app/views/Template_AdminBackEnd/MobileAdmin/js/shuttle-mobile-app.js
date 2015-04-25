var pageData = [];
var customID;
var map;
var markers = [];
var ttl = "";
var lastLocation;
var lastAdress = "";
var incomeLocation;
var mapEvent;
var MultipleMapArray = new Array();
var MultipleMapindex;
var mobilEnlem;
var mobilBoylam;


$(document).ready(function () {

    // Form Enable / Disable Kontrolleri
    $(document).on("click", "#editForm", function (e) {
        e.preventDefault();
        $(document).find(".dsb").prop("disabled", false);
        $(document).find(".dsbtext").prop("disabled", false).removeClass("ui-state-disabled");
        $(document).find(".dsb").parent().removeClass("ui-state-disabled");
        $(document).find(".edit-group").css("display", "none");
        $(document).find(".submit-group").css("display", "inline-block");
        var edtislemler = $(this).attr("data-Editislem");
        editControl(edtislemler);
    });
    $(document).on("click", ".vzg", function (e) {
        e.preventDefault();
        $(document).find(".dsb").prop("disabled", true);
        $(document).find(".dsbtext").prop("disabled", true).addClass("ui-state-disabled");
        $(document).find(".dsb").parent().addClass("ui-state-disabled");
        $(document).find(".submit-group").css("display", "none");
        $(document).find(".edit-group").fadeIn();
        var vzgislemler = $(this).attr("data-Vzgislem");
        vzgControl(vzgislemler);
    });
    $(document).on("click", ".save", function (e) {
        e.preventDefault();
        var saveislemler = $(this).attr("data-Saveislem");
        saveControl(saveislemler);
    });
    // End Form Enable / Dissable Kontrolleri

    //subview kontrolü. Class'a Göre
    $(document).on("click", ".jmToggle", function (e) {
        e.preventDefault();
        var dislemler = $(this).attr("data-islemler");
        jmControl(dislemler);
    });

    $(document).on("click", ".jmID", function (e) {
        e.preventDefault();
        customID = $(this).attr("value");
        var page = $(this).attr("data-destination");
        $.mobile.navigate(page);
    });

    $(document).on("click", ".jmSingleValue", function (e) {//href="#bolgeKurumLokasyonEkle"
        e.preventDefault();
        mobilEnlem = $("input[name=enlem]").val();
        mobilBoylam = $("input[name=boylam]").val();
        var page = $(this).attr("data-destination");
        $.mobile.navigate(page);
    });

    $(document).on("click", ".jmMultiValue", function (e) {
        e.preventDefault();
        var ullength = $("ul" + $(this).attr("data-parent") + " >li").length;
        for (var m = 0; m < ullength; m++) {
            var mapDeger = $("ul" + $(this).attr("data-parent") + " > li:eq(" + m + ") > a").attr('value');
            var LocationBolme = mapDeger.split(",");
            var bolgeKurumName = $("ul" + $(this).attr("data-parent") + " > li:eq(" + m + ") > a").text();
            var page = $(this).attr("data-destination");
            MultipleMapArray[m] = Array(bolgeKurumName, LocationBolme[0], LocationBolme[1]);
            MultipleMapindex = $(this).parent().index();
        }
        $.mobile.navigate(page);
    });
});

$(document).on("pageshow", ".singleMap", function () {
    console.log(mobilEnlem);
    console.log(mobilBoylam);
    Mobileinitialize(mobilEnlem, mobilBoylam);
    var wh = $(window).height();
    var fh = $('#mapFooter').height();
    var mh = wh - fh;
    $('#single_map').css("height", mh);
    google.maps.event.addDomListener(window, 'load', Mobileinitialize);

});

$(document).on("pageshow", ".multiMap", function () {
    multipleMapping(MultipleMapArray, MultipleMapindex);
    var wh = $(window).height();
    var fh = $('#multiMapFooter').height();
    var mh = wh - fh;
    $('#multiple_map').css("height", mh);
    google.maps.event.addDomListener(window, 'load', multipleMapping);

});

$(document).on("click", "#saveMap", function () {
    saveMap();
});



//ajax işlemleri
$(document).on('pageinit', '.jmRun', '[data-role="page"]', function () {
    var dislemler = $(this).attr('data-islemler');
    window["$"]["AdminIslemler"][dislemler]();

});



function jmControl(dislemler) {
//Subview açılıyor
    switch (dislemler) {
        case 'adminBolgeKaydet' :
            $.AdminIslemler.adminBolgeKaydet();
            break;
        case 'adminBolgeDetailSil' :
            $.AdminIslemler.adminBolgeDetailSil();
            break;
        default :
            break;
    }
}

// Form disable işlemleri
function disabledForm() {
    $(document).find(".dsb").prop("disabled", true);
    $(document).find(".submit-group").css("display", "none");
    $(document).find(".edit-group").fadeIn();
}

//Edit Kontrol
function editControl(edtislemler) {
    switch (edtislemler) {
        case 'adminBolgeDetailEdit' :
            $.AdminIslemler.adminBolgeDetailDuzenle();
            break;
        case 'adminKurumDetailEdit' :
            $.AdminIslemler.adminFirmaDuzenle();
            break;
        default :
            break;
    }
}
//End Edit Kontrol

//Vazgeç Kontrol
function vzgControl(vzgislemler) {
    switch (vzgislemler) {
        case 'adminBolgeDetailVazgec' :
            $.AdminIslemler.adminBolgeDetailVazgec();
            break;
        case 'adminFirmaDetailVazgec' :
            $.AdminIslemler.adminFirmaVazgec();
            break;
        default :
            break;
    }
}
//End Vezgeç Kontrol

//Kaydet Kontrol
function saveControl(saveislemler) {
    switch (saveislemler) {
        case 'adminBolgeDetailKaydet' :
            $.AdminIslemler.adminBolgeDetailKaydet();
            break;
        case 'adminFirmaDetailKaydet' :
            $.AdminIslemler.adminFirmaOzellik();
            break;
        case 'adminBolgeKurumKaydet' :
            $.AdminIslemler.adminBolgeKurumKaydet();
            break;

        default :
            break;
    }
}
//End Kaydet Kontrol

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

function Mobileinitialize(Mobileenlem, Mobileboylam) {

    var mapOptions = {
        zoom: 16
    };

    var map = new google.maps.Map(document.getElementById('single_map'),
            mapOptions);

    //son eklenen locationu haritada görme
    var posValue = $('input.locationInput').val();
    if (posValue != '') {
        var posSplitValue = posValue.split(",");
        var pos = new google.maps.LatLng(posSplitValue[0],
                posSplitValue[1]);
        var infowindow = new google.maps.InfoWindow({
            map: map,
            position: pos,
            content: lastAdress
        });
    }
    //enlem boylam buraya gelecek
    var pos = new google.maps.LatLng(Mobileenlem,
            Mobileboylam);
    var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
        content: 'Sizin Konumunuz'
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
}

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