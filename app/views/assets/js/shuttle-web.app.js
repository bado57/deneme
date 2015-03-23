// Document Ready
var z = 1;
$(document).ready(function () {
    // Form Enable / Disable Kontrolleri
    $(document).on("click", "#editForm", function () {
        $(document).find(".dsb").prop("disabled", false);
        $(document).find(".edit-group").css("display", "none");
        $(document).find(".submit-group").fadeIn();
        checkIt();
    });

    $(document).on("click", ".vzg", function () {
        $(document).find(".dsb").prop("disabled", true);
        $(document).find(".submit-group").css("display", "none");
        $(document).find(".edit-group").fadeIn();
        checkIt();
    });
    // End Form Enable / Dissable Kontrolleri

    // Sol Menu Navigasyon Kontrolü   
    $(".sidebar-menu").find(".active").removeClass("active");
    $("#" + activeMenu).find("a").click();
    $(".sidebar-menu").find(".activeli").removeClass("activeli");
    $("#" + activeMenu).find("#" + activeLink).addClass("activeli");
    // End Sol Menu Navigasyon Kontrolü


    //subview kontrolü.Class Göre
    $(document).on("click", ".svToggle", function () {
        var dtype = $(this).attr("data-type");
        var dclass = $(this).attr("data-class");
        svControl(dtype, dclass);
    });
});
// End Document Ready

// Subview Kontrolü
function svControl(dtype, dclass) {
    var effect = 'slide';
    var options = {direction: 'right'};
    var duration = 500;
    var h = $("." + dtype).parent().height();
    var hh = $(document).find("header").height();
    switch (dtype) {
        case "svAdd":
            $("#" + dclass).height(h);
            $("#" + dclass).css("top", hh);
            z++;
            $("#" + dclass).css("z-index", z);
            $('#' + dclass).toggle(effect, options, duration);
            break;
        case "svDetail":
            $("." + dtype).height(h);
            $("." + dtype).css("top", hh);
            z++;
            $("." + dtype).css("z-index", z);
            $("." + dtype).toggle(effect, options, duration);
            break;
        default:
            break;
    }
}
// End Subview Kontrolü

// CheckBox Kontrolü
function checkIt() {
    $("input[type='checkbox'], input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });
}
// End CheckBox Kontrolü    

function disabledForm() {
    $(document).find(".dsb").prop("disabled", true);
    $(document).find(".submit-group").css("display", "none");
    $(document).find(".edit-group").fadeIn();
    checkIt();
}

// Lokasyon Seçme İşlemleri
var map;
var markers = [];
var ttl = "";
var lastLocation;
var lastAdress = "";
$(document).ready(function () {
    $(document).on("click", "#openMap", function () {
        $(".addKurumForm").css("display", "none");
        $(".KurumAdresForm").fadeIn();
        $(".mapDiv").fadeIn();
        initialize();
        google.maps.event.addDomListener(window, 'load', initialize);
    });
    $(document).on("click", "#setLocation", function () {
        $(".addKurumForm").fadeIn();
        $(".KurumAdresForm").fadeIn();
        $(".mapDiv").css("display", "none");
    });
    $(document).on("click", "#ignoreLocation", function () {
        $(".addKurumForm").fadeIn();
        $(".KurumAdresForm").fadeIn();
        $(".mapDiv").css("display", "none");
    });
});

function initialize() {
    if (navigator.geolocation) {

        var mapOptions = {
            zoom: 16
        };

        var map = new google.maps.Map(document.getElementById('map_div'),
                mapOptions);

        //son eklenen locationu haritada görme
        var posValue = $('input[name="KurumLokasyon"]').val();
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
                    var say = cevap.results[0].address_components.length;
                    for (var i = 0, max = say; i < max; i++) {
                        var key = cevap.results[0].address_components[i].types[0];
                        var value = cevap.results[0].address_components[i].long_name;
                        $('input[name="' + key + '"]').val(value);
                    }
                    $('input[name="KurumLokasyon"]').val(event.latLng.k + "," + event.latLng.D);
                    lastLocation = new google.maps.LatLng(event.latLng.k, event.latLng.D);
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

        var iconsLength = icons.length;

        var map = new google.maps.Map(document.getElementById('multiple_map'), {
            zoom: 8,
            center: new google.maps.LatLng(gelen[index][1], gelen[index][2]),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            streetViewControl: true,
            panControl: true,
            draggable: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.RIGHT_BOTTOM
            }
        });

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
        

        function autoCenter() {
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0; i < markers.length; i++) {
                bounds.extend(markers[i].position);
            }
            map.fitBounds(bounds);
        }
        autoCenter();

    } else {
        document.getElementById('google_canvas').innerHTML = 'Konumunuz bulunmadı.';
    }
}

//End çoklu mapping işlemleri