$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminLokasyonAjaxSorgu",
    //timeout:3000,
    dataType: "json",
    error: function (a, b) {
        if (b == "timeout")
            reset();
        alertify.alert(jsDil.InternetBaglanti);
        return false;
    },
    statusCode: {
        404: function () {
            reset();
            alertify.alert(jsDil.InternetBaglanti);
            return false;
        }
    }
});
$(document).ready(function () {
    LokasyonTable = $('#adminLokasyonTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    //araç işlemleri
    $(document).on('click', 'tbody#adminLokasyonRow > tr > td > a', function (e) {
        var i = $(this).find("i");
        i.removeClass("fa-bus");
        i.addClass("fa-spinner fa-spin");
        var turTipText = $(this).parent().parent().find('td:eq(5)').text();
        $("#turTipSubView").text(turTipText);
        var aracID = $(this).attr('value');
        var aracPlaka = $(this).text();
        var turID = $(this).attr('data-tur');
        var turTipID = $(this).attr('data-turtip');
        var turGidisDonus = $(this).attr('data-turgidisdonus');
        var kurumAd = $(this).parent().parent().find('td:eq(3)').text();
        var kurumID = $(this).parent().parent().find('td:eq(3)').attr('value');
        var kurumLocation = $(this).parent().parent().find('td:eq(3)').attr('data-kurumlocation');
        svControl('svAdd', 'aracDetay', '');
        i.removeClass("fa-spinner fa-spin");
        i.addClass("fa fa-bus");
        var haritadeger = 0;
        setInterval(function () {
            $.ajax({
                data: {"aracID": aracID, "turID": turID, "turTipID": turTipID, "turGidisDonus": turGidisDonus, "tip": "aracLokasyonDetail"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap) {
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
                            var aracLokasyon = cevap.aracLokasyon[0].aracLokasyon;
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


