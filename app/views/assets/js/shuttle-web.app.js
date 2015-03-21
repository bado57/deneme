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
            console.log(lastLocation);
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
                    console.log(cevap.results[0].address_components);
                    var say = cevap.results[0].address_components.length;
                    for (var i = 0, max = say; i < max; i++) {
                        console.log(cevap.results[0].address_components[i].types[0]);
                        var key = cevap.results[0].address_components[i].types[0];
                        var value = cevap.results[0].address_components[i].long_name;
                        $('input[name="'+ key +'"]').val(value);
                    }
                    $('input[name="KurumLokasyon"]').val(event.latLng.k + "," + event.latLng.D);
                    lastLocation = new google.maps.LatLng(event.latLng.k,event.latLng.D);
                    lastAdress = ttl;
                }
            });
            console.log(event.latLng);
            console.log(event.latLng.k + "-" + event.latLng.D);
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
            
            console.log(ttl);
            markers.push(marker);

        }

    } else {
        document.getElementById('google_canvas').innerHTML = 'No Geolocation Support.';
    }
}
// End Lokasyon Seçme İşlemleri