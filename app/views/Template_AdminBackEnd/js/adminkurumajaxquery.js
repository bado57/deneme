$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminKurumAjaxSorgu",
    //timeout:3000,
    dataType: "json",
    error: function (a, b) {
        if (b == "timeout")
            alert("Ajax İsteği Zaman Aşımına Uğradı");
    },
    statusCode: {
        404: function () {
            alert("Ajax dosyası bulunamadı");
        }
    }
});
//gidiş
var turDetayGidisSaat1 = new Array();
var turDetayGidisSaat2 = new Array();
var turDetayGidisAracID = new Array();
var turDetayGidisAracPlaka = new Array();
var turDetayGidisAracKapasite = new Array();
var turDetayGidisSoforID = new Array();
var turDetayGidisSoforAd = new Array();
var SelectDetayGidisGunOptions = new Array();
var turGidisDetailEdt = new Array();
//dönüş
var turDetayDonusSaat1 = new Array();
var turDetayDonusSaat2 = new Array();
var turDetayDonusAracID = new Array();
var turDetayDonusAracPlaka = new Array();
var turDetayDonusAracKapasite = new Array();
var turDetayDonusSoforID = new Array();
var turDetayDonusSoforAd = new Array();
var SelectDetayDonusGunOptions = new Array();
var turDonusDetailEdt = new Array();
var diziSayi = 0;
$(document).ready(function () {
    NewKurumTable = $('#adminKurumTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    KurumTurTable = $('#adminKurumTurTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    //kurum işlemleri
    $(document).on('click', 'tbody#adminKurumRow > tr > td > a', function (e) {
        var s = $(this).find("i");
        s.removeClass("fa-search");
        s.addClass("fa-spinner fa-spin");
        var adminkurumRowid = $(this).attr('value');
        KurumTurTable.DataTable().clear().draw();
        $.ajax({
            data: {"adminkurumRowid": adminkurumRowid, "tip": "adminKurumDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {

                    $("input[name=KurumDetailAdi]").val(cevap.adminKurumDetail['2065df742f65c58446e8796c751fcd15']);
                    $("input[name=KurumDetailBolge]").val(cevap.adminKurumDetail['5dff8e4f44d1afe5716832b74770e3fe']);
                    $("input[name=KurumDetailTelefon]").val(cevap.adminKurumDetail['1ca4e7d1e05313c9c9ea295bd91eee63']);
                    $("input[name=KurumDetailEmail]").val(cevap.adminKurumDetail['20d22439a604859a4fcc07e250c00842']);
                    $("textarea[name=KurumDetailAdres]").val(cevap.adminKurumDetail['ffe825a3429333ccd27ec1b77b63d7b3']);
                    $("textarea[name=KurumDetailAciklama]").val(cevap.adminKurumDetail['b8ecd9075c0c9a7f7afa1784acb13c2e']);
                    $("input[name=adminKurumDetailID]").val(cevap.adminKurumDetail['3bcdc7d6f02b5b42c7be9604808e7c07']);
                    $("input[name=kurumDetayBolgeID]").val(cevap.adminKurumDetail['95d1cff7e918f5edec2758321aeca910']);
                    $("input[name=adminKurumDetailLocation]").val(cevap.adminKurumDetail['a465db00f313bd4781af6805a8d6fb31']);
                    $('select#KurumDetayTip').val(cevap.adminKurumDetail['56fa936769f2229ad81454e6014cc88c']);
                    if (cevap.adminKurumTurDetail) {
                        var KurumTurSayi = cevap.adminKurumTurDetail.length;
                        if (KurumTurSayi != 0) {
                            $("#KurumDetailDeleteBtn").hide();
                        } else {
                            $("#KurumDetailDeleteBtn").show();
                        }

                        var turCount = cevap.adminKurumTurDetail.length;
                        for (var i = 0; i < turCount; i++) {
                            if (cevap.adminKurumTurDetail[i].KurumTurTip == 0) {
                                TurTip = 'Öğrenci';
                            } else if (cevap.adminKurumTurDetail[i].KurumTurTip == 1) {
                                TurTip = 'Personel';
                            } else {
                                TurTip = 'Öğrenci/Personel';
                            }

                            if (cevap.adminKurumTurDetail[i].KurumTurAktiflik != 0) {
                                var addRow = "<tr><td>"
                                        + "<a title='' value='" + cevap.adminKurumTurDetail[i].KurumTurID + "'>"
                                        + "<i class='glyphicon glyphicon-refresh'></i> " + cevap.adminKurumTurDetail[i].KurumDetailTurAd + "</a></td>"
                                        + "<td class='hidden-xs' >" + TurTip + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.adminKurumTurDetail[i].KurumTurAcikla + "</td></tr>";
                                KurumTurTable.DataTable().row.add($(addRow)).draw();
                            } else {
                                var addRow = "<tr><td>"
                                        + "<a title='' value='" + cevap.adminKurumTurDetail[i].KurumTurID + "'>"
                                        + "<i class='glyphicon glyphicon-refresh' style='color:red'></i> " + cevap.adminKurumTurDetail[i].KurumDetailTurAd + "</a></td>"
                                        + "<td class='hidden-xs' >" + TurTip + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.adminKurumTurDetail[i].KurumTurAcikla + "</td></tr>";
                                KurumTurTable.DataTable().row.add($(addRow)).draw();
                            }

                        }
                    }
                    svControl('svAdd', 'kurumDetay', '');
                    s.removeClass("fa-spinner fa-spin");
                    s.addClass("fa-search");
                }
            }
        });
    });
    //tur işlemleri
    $(document).on('click', 'table#adminKurumTurTable > tbody > tr > td > a', function (e) {
        var s = $(this).find("i");
        s.removeClass("glyphicon glyphicon-refresh");
        s.addClass("fa fa-spinner fa-spin");
        var adminturRowid = $(this).attr('value');
        var adminturAd = $(this).text();
        var adminturAciklama = $(this).parent().parent().find('td:eq(2)').text();
        $.ajax({
            data: {"adminturRowid": adminturRowid, "tip": "adminTurDetaySecim"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    $('input[name=adminTurID]').val(adminturRowid);
                    //hem gidiş hem de dönüş vardır
                    if (cevap.turTipDetay.TurDetayTur.length == 2) {
                        var gidisIndex = '';
                        var donusIndex = '';
                        for (var a = 0; a < cevap.turTipDetay.TurDetayTur.length; a++) {
                            if (cevap.turTipDetay.TurDetayTur[a] == 0) {
                                gidisIndex = a;
                            }
                            if (cevap.turTipDetay.TurDetayTur[a] == 1) {
                                donusIndex = a;
                            }
                        }
                        //gidiş 
                        if (gidisIndex != '' || gidisIndex == 0) {
                            $('input[name=adminTurDetayGds]').val(cevap.turTipDetay.TurDetayTipID[gidisIndex]);
                            $('input[name=adminTurDetayTip]').val(cevap.turTipDetay.TurDetayTip[gidisIndex]);
                            $('input[name=TurDetayGidisAd]').val(adminturAd.trim());
                            $('input[name=TurDetayGidisBolge]').val(cevap.turTipDetay.TurDetayBolgeAd[gidisIndex]);
                            $('input[name=TurDetayGidisBolgeID]').val(cevap.turTipDetay.TurDetayBolgeID[gidisIndex]);
                            $('input[name=TurDetayGidisKurum]').val(cevap.turTipDetay.TurDetayKurumAd[gidisIndex]);
                            $('input[name=TurDetayGidisKurumID]').val(cevap.turTipDetay.TurDetayKurumID[gidisIndex]);
                            $('input[name=TurDetayGidisKurumLocation]').val(cevap.turTipDetay.TurDetayKurumLocation[gidisIndex]);
                            $('textarea[name=TurDetayGidisAciklama]').text(adminturAciklama);
                            $('input[name=GidisSoforInput]').val(cevap.turTipDetay.TurDetaySoforLocation[gidisIndex]);
                            $('input[name=GidisSoforID]').val(cevap.turTipDetay.TurDetaySoforID[gidisIndex]);
                            $('input[name=GidisSoforAd]').val(cevap.turTipDetay.TurDetaySoforAd[gidisIndex]);
                            turDetayGidisSaat1 = cevap.turTipDetay.TurDetayBsSaat[gidisIndex];
                            turDetayGidisSaat2 = cevap.turTipDetay.TurDetayBtsSaat[gidisIndex];
                            turDetayGidisAracID = cevap.turTipDetay.TurDetayAracID[gidisIndex];
                            turDetayGidisAracPlaka = cevap.turTipDetay.TurDetayAracPlaka[gidisIndex];
                            turDetayGidisAracKapasite = cevap.turTipDetay.TurDetayAracKapasite[gidisIndex];
                            turDetayGidisSoforID = cevap.turTipDetay.TurDetaySoforID[gidisIndex];
                            turDetayGidisSoforAd = cevap.turTipDetay.TurDetaySoforAd[gidisIndex];
                        }
                        //Dönüş
                        if (donusIndex != '' || donusIndex == 0) {
                            $('input[name=adminTurDetayDns]').val(cevap.turTipDetay.TurDetayTipID[donusIndex]);
                            $('input[name=adminTurDetayTip]').val(cevap.turTipDetay.TurDetayTip[donusIndex]);
                            $('input[name=TurDetayDonusAd]').val(adminturAd.trim());
                            $('input[name=TurDetayDonusBolge]').val(cevap.turTipDetay.TurDetayBolgeAd[donusIndex]);
                            $('input[name=TurDetayDonusBolgeID]').val(cevap.turTipDetay.TurDetayBolgeID[donusIndex]);
                            $('input[name=TurDetayDonusKurum]').val(cevap.turTipDetay.TurDetayKurumAd[donusIndex]);
                            $('input[name=TurDetayDonusKurumID]').val(cevap.turTipDetay.TurDetayKurumID[donusIndex]);
                            $('input[name=TurDetayDonusKurumLocation]').val(cevap.turTipDetay.TurDetayKurumLocation[donusIndex]);
                            $('textarea[name=TurDetayDonusAciklama]').text(adminturAciklama);
                            $('input[name=DonusSoforInput]').val(cevap.turTipDetay.TurDetaySoforLocation[donusIndex]);
                            $('input[name=DonusSoforID]').val(cevap.turTipDetay.TurDetaySoforID[donusIndex]);
                            $('input[name=DonusSoforAd]').val(cevap.turTipDetay.TurDetaySoforAd[donusIndex]);
                            turDetayDonusSaat1 = cevap.turTipDetay.TurDetayBsSaat[donusIndex];
                            turDetayDonusSaat2 = cevap.turTipDetay.TurDetayBtsSaat[donusIndex];
                            turDetayDonusAracID = cevap.turTipDetay.TurDetayAracID[donusIndex];
                            turDetayDonusAracPlaka = cevap.turTipDetay.TurDetayAracPlaka[donusIndex];
                            turDetayDonusAracKapasite = cevap.turTipDetay.TurDetayAracKapasite[donusIndex];
                            turDetayDonusSoforID = cevap.turTipDetay.TurDetaySoforID[donusIndex];
                            turDetayDonusSoforAd = cevap.turTipDetay.TurDetaySoforAd[donusIndex];
                        }
                    } else {
                        //ikisinden biri vardır
                        //birisi de olsa bazı alanlar ortak olması lazım
                        $('input[name=TurDetayGidisAd]').val(adminturAd.trim());
                        $('input[name=TurDetayGidisBolge]').val(cevap.turTipDetay.TurDetayBolgeAd[0]);
                        $('input[name=TurDetayGidisBolgeID]').val(cevap.turTipDetay.TurDetayBolgeID[0]);
                        $('input[name=TurDetayGidisKurum]').val(cevap.turTipDetay.TurDetayKurumAd[0]);
                        $('input[name=TurDetayGidisKurumID]').val(cevap.turTipDetay.TurDetayKurumID[0]);
                        $('input[name=TurDetayGidisKurumLocation]').val(cevap.turTipDetay.TurDetayKurumLocation[0]);
                        $('textarea[name=TurDetayGidisAciklama]').text(adminturAciklama);
                        $('input[name=TurDetayDonusAd]').val(adminturAd.trim());
                        $('input[name=TurDetayDonusBolge]').val(cevap.turTipDetay.TurDetayBolgeAd[0]);
                        $('input[name=TurDetayDonusBolgeID]').val(cevap.turTipDetay.TurDetayBolgeID[0]);
                        $('input[name=TurDetayDonusKurum]').val(cevap.turTipDetay.TurDetayKurumAd[0]);
                        $('input[name=TurDetayDonusKurumID]').val(cevap.turTipDetay.TurDetayKurumID[0]);
                        $('input[name=TurDetayDonusKurumLocation]').val(cevap.turTipDetay.TurDetayKurumLocation[0]);
                        $('textarea[name=TurDetayDonusAciklama]').text(adminturAciklama);
                        turDetayGidisAracKapasite = cevap.turTipDetay.TurDetayAracKapasite[0];
                        turDetayDonusAracKapasite = cevap.turTipDetay.TurDetayAracKapasite[0];

                        if (cevap.turTipDetay.TurDetayTur[0] == 0) {//gidiş
                            $('input[name=adminTurDetayGds]').val(cevap.turTipDetay.TurDetayTipID[0]);
                            $('input[name=adminTurDetayTip]').val(cevap.turTipDetay.TurDetayTip[0]);
                            $('input[name=GidisSoforInput]').val(cevap.turTipDetay.TurDetaySoforLocation[0]);
                            $('input[name=GidisSoforID]').val(cevap.turTipDetay.TurDetaySoforID[0]);
                            $('input[name=GidisSoforAd]').val(cevap.turTipDetay.TurDetaySoforAd[0]);
                            turDetayGidisSaat1 = cevap.turTipDetay.TurDetayBsSaat[0];
                            turDetayGidisSaat2 = cevap.turTipDetay.TurDetayBtsSaat[0];
                            turDetayGidisAracID = cevap.turTipDetay.TurDetayAracID[0];
                            turDetayGidisAracPlaka = cevap.turTipDetay.TurDetayAracPlaka[0];
                            turDetayGidisSoforID = cevap.turTipDetay.TurDetaySoforID[0];
                            turDetayGidisSoforAd = cevap.turTipDetay.TurDetaySoforAd[0];
                        } else {//dönüş
                            $('input[name=adminTurDetayDns]').val(cevap.turTipDetay.TurDetayTipID[0]);
                            $('input[name=adminTurDetayTip]').val(cevap.turTipDetay.TurDetayTip[0]);
                            $('input[name=DonusSoforInput]').val(cevap.turTipDetay.TurDetaySoforLocation[0]);
                            $('input[name=DonusSoforID]').val(cevap.turTipDetay.TurDetaySoforID[0]);
                            $('input[name=DonusSoforAd]').val(cevap.turTipDetay.TurDetaySoforAd[0]);
                            turDetayDonusSaat1 = cevap.turTipDetay.TurDetayBsSaat[0];
                            turDetayDonusSaat2 = cevap.turTipDetay.TurDetayBtsSaat[0];
                            turDetayDonusAracID = cevap.turTipDetay.TurDetayAracID[0];
                            turDetayDonusAracPlaka = cevap.turTipDetay.TurDetayAracPlaka[0];
                            turDetayDonusSoforID = cevap.turTipDetay.TurDetaySoforID[0];
                            turDetayDonusSoforAd = cevap.turTipDetay.TurDetaySoforAd[0];
                        }
                    }
                    svControl('svAdd', 'turSecim', '');
                    s.removeClass("fa fa-spinner fa-spin");
                    s.addClass("glyphicon glyphicon-refresh");
                }
            }
        });
    });
    //tur şoför focus
    $('#TurSofor').multiselect({
        onDropdownShow: function (event) {
            var turGunID = new Array();
            $('select#TurSelectGun option:selected').each(function () {
                turGunID.push($(this).val());
            });
            var turgunlength = turGunID.length;
            if (turgunlength > 0) {
                var turSaat1ID = $('select#TurSaat1 option[value!="-1"]:selected').val();
                if (turSaat1ID) {
                    var turSaat2ID = $('select#TurSaat2 option[value!="-1"]:selected').val();
                    if (turSaat2ID) {
                        var aracID = $('select#TurArac option:selected').val();
                        if (aracID) {
                            var turKurumID = $("input[name=adminKurumDetailID]").val();
                            var turBolgeID = $("input[name=kurumDetayBolgeID]").val();
                            $.ajax({
                                data: {"turBolgeID": turBolgeID, "turKurumID": turKurumID, "turGunID[]": turGunID, "turSaat1ID": turSaat1ID, "turSaat2ID": turSaat2ID, "aracID": aracID, "tip": "turSoforSelect"},
                                success: function (cevap) {
                                    if (cevap.hata) {
                                        alert(cevap.hata);
                                    } else {
                                        var SelectSoforOptions = new Array();
                                        if (cevap.pasifSofor) {
                                            var length = cevap.pasifSofor.length;
                                            SelectSoforOptions[0] = {label: 'Seçiniz', title: 'Seçiniz', value: -1};
                                            var a = 1;
                                            for (var i = 0; i < length; i++) {
                                                SelectSoforOptions[a] = {label: cevap.pasifSofor[i].turSoforAd + ' ' + cevap.pasifSofor[i].turSoforSoyad, title: cevap.pasifSofor[i].turSoforAd + ' ' + cevap.pasifSofor[i].turSoforSoyad, location: cevap.pasifSofor[i].turSoforLocation, value: cevap.pasifSofor[i].turSoforID};
                                                a++
                                            }
                                            $('#TurSofor').multiselect('refresh');
                                            $('#TurSofor').multiselect('dataprovider', SelectSoforOptions);
                                        }
                                    }
                                }
                            });
                        } else {
                            alert("Lütfen Araç Seçiniz");
                        }
                    } else {
                        alert("Lütfen Saat Seçiniz");
                    }
                } else {
                    alert("Lütfen Saat Seçiniz");
                }
            } else {
                alert("Lütfen Gün Seçiniz");
            }
        },
        onChange: function (option, checked, select) {
            if (kayitDeger == 0) {
                var soforLocation = $('select#TurSofor option[value!="-1"]:selected').attr('location');
                if (soforLocation) {
                    if (diziSayi != 0) {
                        MultipleMapArray.pop();
                        var diziIndex = MultipleMapArray.length;
                        sofor = 1;
                        var soforName = $('select#TurSofor option[value!="-1"]:selected').attr('label');
                        var soforID = $('select#TurSofor option[value!="-1"]:selected').attr('value');
                        var LocationSoforBolme = soforLocation.split(",");
                        MultipleMapArray[diziIndex] = Array(soforName, LocationSoforBolme[0], LocationSoforBolme[1], soforID);
                        isMap = true;
                        isSingle = false;
                        multipleKurumTurMapping(MultipleMapArray, MultipleMapindex, ayiriciIndex, sofor);
                        google.maps.event.addDomListener(window, 'load', multipleKurumTurMapping);
                    } else {
                        var diziIndex = MultipleMapArray.length;
                        diziSayi++;
                        sofor = 1;
                        var soforName = $('select#TurSofor option[value!="-1"]:selected').attr('label');
                        var soforID = $('select#TurSofor option[value!="-1"]:selected').attr('value');
                        var LocationSoforBolme = soforLocation.split(",");
                        MultipleMapArray[diziIndex] = Array(soforName, LocationSoforBolme[0], LocationSoforBolme[1], soforID);
                        isMap = true;
                        isSingle = false;
                        multipleKurumTurMapping(MultipleMapArray, MultipleMapindex, ayiriciIndex, sofor);
                        google.maps.event.addDomListener(window, 'load', multipleKurumTurMapping);
                    }
                }
            }
        }
    });
    //saat1 e göre saat2
    $('#TurSaat1').multiselect({
        onDropdownShow: function (event) {
            var SelectSaat1Options = new Array();
            var SelectSaat1Value = new Array(0, 15, 30, 45, 100, 115, 130, 145, 200, 215, 230, 245, 300, 315, 330, 345, 400,
                    415, 430, 445, 500, 515, 530, 545, 600, 615, 630, 645, 700, 715, 730, 745, 800, 815, 830, 845, 900, 915, 930,
                    945, 1000, 1015, 1030, 1045, 1100, 1115, 1130, 1145, 1200, 1215, 1230, 1245, 1300, 1315, 1330, 1345, 1400,
                    1415, 1430, 1445, 1500, 1515, 1530, 1545, 1600, 1615, 1630, 1645, 1700, 1715, 1730, 1745, 1800, 1815, 1830,
                    1845, 1900, 1915, 1930, 1945, 2000, 2015, 2030, 2045, 2100, 2115, 2130, 2145, 2200, 2215, 2230, 2245, 2300,
                    2315, 2330, 2345);
            var SelectSaat1Text = new Array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45',
                    '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00',
                    '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15',
                    '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30',
                    '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45',
                    '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00',
                    '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15',
                    '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');
            SelectSaat1Options[0] = {label: 'Seçiniz', title: 'Seçiniz', value: '-1'};
            var saat2Length = SelectSaat1Value.length;
            for (var b = 0; b < saat2Length; b++) {
                SelectSaat1Options[b + 1] = {label: SelectSaat1Text[b], title: SelectSaat1Text[b], value: SelectSaat1Value[b]};
            }
            $('#TurSaat1').multiselect('refresh');
            $('#TurSaat1').multiselect('dataprovider', SelectSaat1Options);
        },
        onChange: function (option, checked, select) {
            var turSaatSelect = $('select#TurSaat1 option[value!="-1"]:selected').val();
            if (turSaatSelect) {
                var turSaatIndex = $('select#TurSaat1 option:selected').index();
                var SelectSaat2Options = new Array();
                var SelectSaat2Value = new Array(0, 15, 30, 45, 100, 115, 130, 145, 200, 215, 230, 245, 300, 315, 330, 345, 400,
                        415, 430, 445, 500, 515, 530, 545, 600, 615, 630, 645, 700, 715, 730, 745, 800, 815, 830, 845, 900, 915, 930,
                        945, 1000, 1015, 1030, 1045, 1100, 1115, 1130, 1145, 1200, 1215, 1230, 1245, 1300, 1315, 1330, 1345, 1400,
                        1415, 1430, 1445, 1500, 1515, 1530, 1545, 1600, 1615, 1630, 1645, 1700, 1715, 1730, 1745, 1800, 1815, 1830,
                        1845, 1900, 1915, 1930, 1945, 2000, 2015, 2030, 2045, 2100, 2115, 2130, 2145, 2200, 2215, 2230, 2245, 2300,
                        2315, 2330, 2345);
                var SelectSaat2Text = new Array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45',
                        '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00',
                        '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15',
                        '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30',
                        '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45',
                        '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00',
                        '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15',
                        '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');
                SelectSaat2Options[0] = {label: 'Seçiniz', title: 'Seçiniz', value: '-1'};
                var saat2Length = SelectSaat2Value.length;
                for (var b = 0; b < turSaatIndex; b++) {
                    SelectSaat2Options[b + 1] = {label: SelectSaat2Text[b], title: SelectSaat2Text[b], value: SelectSaat2Value[b], disabled: true};
                }
                for (var c = turSaatIndex; c < saat2Length; c++) {
                    SelectSaat2Options[c + 1] = {label: SelectSaat2Text[c], title: SelectSaat2Text[c], value: SelectSaat2Value[c]};
                }
                $('#TurSaat2').multiselect('refresh');
                $('#TurSaat2').multiselect('dataprovider', SelectSaat2Options);
            } else {
                alert("Lütfen Saat 1 Seçiniz");
                var SelectSaat2Optionss = new Array();
                $('#TurSaat2').multiselect('dataprovider', SelectSaat2Optionss);
                $('#TurSaat2').multiselect('refresh');
            }
        }
    });
    //saat2 işlemleri
    $('#TurSaat2').multiselect({
        onDropdownShow: function (event) {
            var turSaatSelect = $('select#TurSaat1 option[value!="-1"]:selected').val();
            if (turSaatSelect) {
                $('#TurSaat1').multiselect('refresh');
            } else {
                alert("Lütfen Saat 1 Seçiniz");
            }
        }
    });
    //tur araç focus
    $('#TurArac').multiselect({
        onDropdownShow: function (event) {
            var turGunID = new Array();
            $('select#TurSelectGun option:selected').each(function () {
                turGunID.push($(this).val());
            });
            var turgunlength = turGunID.length;
            if (turgunlength > 0) {
                var turSaat1ID = $('select#TurSaat1 option[value!="-1"]:selected').val();
                if (turSaat1ID) {
                    var turSaat2ID = $('select#TurSaat2 option[value!="-1"]:selected').val();
                    if (turSaat2ID) {
                        var turKurumID = $("input[name=adminKurumDetailID]").val();
                        var turBolgeID = $("input[name=kurumDetayBolgeID]").val();
                        $.ajax({
                            data: {"turBolgeID": turBolgeID, "turKurumID": turKurumID, "turGunID[]": turGunID, "turSaat1ID": turSaat1ID, "turSaat2ID": turSaat2ID, "tip": "turAracSelect"},
                            success: function (cevap) {
                                if (cevap.hata) {
                                    alert(cevap.hata);
                                } else {
                                    var SelectAracOptions = new Array();
                                    if (cevap.pasifArac) {
                                        var length = cevap.pasifArac.length;
                                        for (var i = 0; i < length; i++) {
                                            SelectAracOptions[i] = {label: cevap.pasifArac[i].turAracPlaka, title: cevap.pasifArac[i].turAracPlaka + ' (' + cevap.pasifArac[i].turAracKapasite + ')', value: cevap.pasifArac[i].turAracID, kapasite: cevap.pasifArac[i].turAracKapasite};
                                        }
                                        $('#TurArac').multiselect();
                                        $('#TurArac').multiselect('dataprovider', SelectAracOptions);
                                    }
                                }
                            }
                        });
                    } else {
                        alert("Lütfen Saat Seçiniz");
                    }
                } else {
                    alert("Lütfen Saat Seçiniz");
                }
            } else {
                alert("Lütfen Gün Seçiniz");
            }
        }
    });
    //tur dgidiş detay saat1
    $('#TurDetayGidisSaat1').multiselect({
        onDropdownShow: function (event) {
            var turSaatSelect1 = $('select#TurDetayGidisSaat1 option[value!="-1"]:selected').val();
            var SelectSaat1Options = new Array();
            var SelectSaat1Value = new Array(0, 15, 30, 45, 100, 115, 130, 145, 200, 215, 230, 245, 300, 315, 330, 345, 400,
                    415, 430, 445, 500, 515, 530, 545, 600, 615, 630, 645, 700, 715, 730, 745, 800, 815, 830, 845, 900, 915, 930,
                    945, 1000, 1015, 1030, 1045, 1100, 1115, 1130, 1145, 1200, 1215, 1230, 1245, 1300, 1315, 1330, 1345, 1400,
                    1415, 1430, 1445, 1500, 1515, 1530, 1545, 1600, 1615, 1630, 1645, 1700, 1715, 1730, 1745, 1800, 1815, 1830,
                    1845, 1900, 1915, 1930, 1945, 2000, 2015, 2030, 2045, 2100, 2115, 2130, 2145, 2200, 2215, 2230, 2245, 2300,
                    2315, 2330, 2345);
            var SelectSaat1Text = new Array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45',
                    '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00',
                    '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15',
                    '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30',
                    '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45',
                    '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00',
                    '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15',
                    '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');
            SelectSaat1Options[0] = {label: 'Seçiniz', title: 'Seçiniz', value: '-1'};
            var saat2Length = SelectSaat1Value.length;
            for (var b = 0; b < saat2Length; b++) {
                if (SelectSaat1Value[b] == turSaatSelect1) {
                    SelectSaat1Options[b + 1] = {label: SelectSaat1Text[b], title: SelectSaat1Text[b], value: SelectSaat1Value[b], selected: true};
                } else {
                    SelectSaat1Options[b + 1] = {label: SelectSaat1Text[b], title: SelectSaat1Text[b], value: SelectSaat1Value[b]};
                }

            }
            $('#TurDetayGidisSaat1').multiselect('refresh');
            $('#TurDetayGidisSaat1').multiselect('dataprovider', SelectSaat1Options);
        },
        onChange: function (option, checked, select) {
            var turSaatSelect = $('select#TurDetayGidisSaat1 option[value!="-1"]:selected').val();
            var turSaatSelect2 = $('select#TurDetayGidisSaat2 option[value!="-1"]:selected').val();
            if (turSaatSelect) {
                var SelectSaat2Options = new Array();
                var SelectSaat2Value = new Array(0, 15, 30, 45, 100, 115, 130, 145, 200, 215, 230, 245, 300, 315, 330, 345, 400,
                        415, 430, 445, 500, 515, 530, 545, 600, 615, 630, 645, 700, 715, 730, 745, 800, 815, 830, 845, 900, 915, 930,
                        945, 1000, 1015, 1030, 1045, 1100, 1115, 1130, 1145, 1200, 1215, 1230, 1245, 1300, 1315, 1330, 1345, 1400,
                        1415, 1430, 1445, 1500, 1515, 1530, 1545, 1600, 1615, 1630, 1645, 1700, 1715, 1730, 1745, 1800, 1815, 1830,
                        1845, 1900, 1915, 1930, 1945, 2000, 2015, 2030, 2045, 2100, 2115, 2130, 2145, 2200, 2215, 2230, 2245, 2300,
                        2315, 2330, 2345);
                var SelectSaat2Text = new Array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45',
                        '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00',
                        '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15',
                        '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30',
                        '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45',
                        '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00',
                        '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15',
                        '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');
                SelectSaat2Options[0] = {label: 'Seçiniz', title: 'Seçiniz', value: '-1'};
                var saat2Length = SelectSaat2Value.length;
                for (var b = 0; b < saat2Length; b++) {
                    if (SelectSaat2Value[b] <= turSaatSelect) {
                        SelectSaat2Options[b + 1] = {label: SelectSaat2Text[b], title: SelectSaat2Text[b], value: SelectSaat2Value[b], disabled: true};
                    } else {
                        SelectSaat2Options[b + 1] = {label: SelectSaat2Text[b], title: SelectSaat2Text[b], value: SelectSaat2Value[b]};
                        if (SelectSaat2Value[b] == turDetayGidisSaat2) {
                            SelectSaat2Options[b + 1] = {label: SelectSaat2Text[b], title: SelectSaat2Text[b], value: SelectSaat2Value[b], selected: true};
                        }
                    }

                }
                $('#TurDetayGidisSaat2').multiselect('refresh');
                $('#TurDetayGidisSaat2').multiselect('dataprovider', SelectSaat2Options);
            } else {
                alert("Lütfen Saat 1 Seçiniz");
                var SelectSaat2Optionss = new Array();
                $('#TurSaat2').multiselect('dataprovider', SelectSaat2Optionss);
                $('#TurSaat2').multiselect('refresh');
            }
        }
    });
    //tur dgidiş detay saat2
    $('#TurDetayGidisSaat2').multiselect({
        onDropdownShow: function (event) {
            var turSaatSelect = $('select#TurDetayGidisSaat1 option[value!="-1"]:selected').val();
            if (turSaatSelect) {
                var SelectSaat2Options = new Array();
                var SelectSaat2Value = new Array(0, 15, 30, 45, 100, 115, 130, 145, 200, 215, 230, 245, 300, 315, 330, 345, 400,
                        415, 430, 445, 500, 515, 530, 545, 600, 615, 630, 645, 700, 715, 730, 745, 800, 815, 830, 845, 900, 915, 930,
                        945, 1000, 1015, 1030, 1045, 1100, 1115, 1130, 1145, 1200, 1215, 1230, 1245, 1300, 1315, 1330, 1345, 1400,
                        1415, 1430, 1445, 1500, 1515, 1530, 1545, 1600, 1615, 1630, 1645, 1700, 1715, 1730, 1745, 1800, 1815, 1830,
                        1845, 1900, 1915, 1930, 1945, 2000, 2015, 2030, 2045, 2100, 2115, 2130, 2145, 2200, 2215, 2230, 2245, 2300,
                        2315, 2330, 2345);
                var SelectSaat2Text = new Array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45',
                        '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00',
                        '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15',
                        '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30',
                        '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45',
                        '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00',
                        '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15',
                        '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');
                SelectSaat2Options[0] = {label: 'Seçiniz', title: 'Seçiniz', value: '-1'};
                var saat2Length = SelectSaat2Value.length;
                for (var b = 0; b < saat2Length; b++) {
                    if (SelectSaat2Value[b] <= turSaatSelect) {
                        SelectSaat2Options[b + 1] = {label: SelectSaat2Text[b], title: SelectSaat2Text[b], value: SelectSaat2Value[b], disabled: true};
                    } else {
                        SelectSaat2Options[b + 1] = {label: SelectSaat2Text[b], title: SelectSaat2Text[b], value: SelectSaat2Value[b]};
                        if (SelectSaat2Value[b] == turDetayGidisSaat2) {
                            SelectSaat2Options[b + 1] = {label: SelectSaat2Text[b], title: SelectSaat2Text[b], value: SelectSaat2Value[b], selected: true};
                        }
                    }

                }
                $('#TurDetayGidisSaat2').multiselect('refresh');
                $('#TurDetayGidisSaat2').multiselect('dataprovider', SelectSaat2Options);
            } else {
                alert("Lütfen Saat 1 Seçiniz");
                var SelectSaat2Optionss = new Array();
                $('#TurSaat2').multiselect('dataprovider', SelectSaat2Optionss);
                $('#TurSaat2').multiselect('refresh');
            }
        }
    });
    //tur gidiş araç focus
    $('#TurDetayGidisArac').multiselect({
        onDropdownShow: function (event) {
            var turGunID = new Array();
            $('select#TurDetayGidisGun option:selected').each(function () {
                turGunID.push($(this).val());
            });
            var turgunlength = turGunID.length;
            if (turgunlength > 0) {
                var turSaat1ID = $('select#TurDetayGidisSaat1 option[value!="-1"]:selected').val();
                if (turSaat1ID) {
                    var turSaat2ID = $('select#TurDetayGidisSaat2 option[value!="-1"]:selected').val();
                    if (turSaat2ID) {
                        var kurumID = $("input[name=TurDetayGidisKurumID]").val();
                        var bolgeID = $("input[name=TurDetayGidisBolgeID]").val();
                        $.ajax({
                            data: {"bolgeID": bolgeID, "kurumID": kurumID, "turGunID[]": turGunID, "turSaat1ID": turSaat1ID, "turSaat2ID": turSaat2ID, "tip": "turGidisAracSelect"},
                            success: function (cevap) {
                                if (cevap.hata) {
                                    alert(cevap.hata);
                                } else {
                                    var SelectAracOptions = new Array();
                                    var a = 1;
                                    if (cevap.pasifArac) {
                                        var length = cevap.pasifArac.length;
                                        if (turDetayGidisAracID.length > 0) {
                                            SelectAracOptions[0] = {label: turDetayGidisAracPlaka, title: turDetayGidisAracPlaka + ' (' + turDetayGidisAracKapasite + ')', value: turDetayGidisAracID, kapasite: turDetayGidisAracKapasite, selected: true};
                                            for (var i = 0; i < length; i++) {
                                                if (cevap.pasifArac[i].turAracID.indexOf(turDetayGidisAracID) == -1) {
                                                    SelectAracOptions[a] = {label: cevap.pasifArac[i].turAracPlaka, title: cevap.pasifArac[i].turAracPlaka + ' (' + cevap.pasifArac[i].turAracKapasite + ')', value: cevap.pasifArac[i].turAracID, kapasite: cevap.pasifArac[i].turAracKapasite};
                                                    a++;
                                                }
                                            }
                                        } else {
                                            for (var i = 0; i < length; i++) {
                                                SelectAracOptions[i] = {label: cevap.pasifArac[i].turAracPlaka, title: cevap.pasifArac[i].turAracPlaka + ' (' + cevap.pasifArac[i].turAracKapasite + ')', value: cevap.pasifArac[i].turAracID, kapasite: cevap.pasifArac[i].turAracKapasite};
                                            }
                                        }

                                        $('#TurDetayGidisArac').multiselect();
                                        $('#TurDetayGidisArac').multiselect('dataprovider', SelectAracOptions);
                                    } else {
                                        SelectAracOptions[0] = {label: turDetayGidisAracPlaka, title: turDetayGidisAracPlaka + ' (' + turDetayGidisAracKapasite + ')', value: turDetayGidisAracID, kapasite: turDetayGidisAracKapasite, selected: true};
                                        $('#TurDetayGidisArac').multiselect();
                                        $('#TurDetayGidisArac').multiselect('dataprovider', SelectAracOptions);
                                    }
                                }
                            }
                        });
                    } else {
                        alert("Lütfen Saat2 Seçiniz");
                    }
                } else {
                    alert("Lütfen Saat1 Seçiniz");
                }
            } else {
                alert("Lütfen Gün Seçiniz");
            }
        }
    });
    //tur detay gidis şoför focus
    $('#TurDetayGidisSofor').multiselect({
        onDropdownShow: function (event) {
            var turGunID = new Array();
            $('select#TurDetayGidisGun option:selected').each(function () {
                turGunID.push($(this).val());
            });
            var turgunlength = turGunID.length;
            if (turgunlength > 0) {
                var turSaat1ID = $('select#TurDetayGidisSaat1 option[value!="-1"]:selected').val();
                if (turSaat1ID) {
                    var turSaat2ID = $('select#TurDetayGidisSaat2 option[value!="-1"]:selected').val();
                    if (turSaat2ID) {
                        var aracID = $('select#TurDetayGidisArac option:selected').val();
                        if (aracID) {
                            var kurumID = $("input[name=TurDetayGidisKurumID]").val();
                            var bolgeID = $("input[name=TurDetayGidisBolgeID]").val();
                            $.ajax({
                                data: {"bolgeID": bolgeID, "kurumID": kurumID, "turGunID[]": turGunID, "turSaat1ID": turSaat1ID, "turSaat2ID": turSaat2ID, "aracID": aracID, "tip": "turGidisSoforSelect"},
                                success: function (cevap) {
                                    if (cevap.hata) {
                                        alert(cevap.hata);
                                    } else {
                                        var SelectSoforOptions = new Array();
                                        var soforLocation = $('input[name=GidisSoforInput]').val();
                                        var a = 1;
                                        if (cevap.pasifSofor) {
                                            var length = cevap.pasifSofor.length;
                                            if (turDetayGidisSoforID.length > 0) {
                                                SelectSoforOptions[0] = {label: turDetayGidisSoforAd, title: turDetayGidisSoforAd, location: soforLocation, value: turDetayGidisSoforID, selected: true};
                                                for (var i = 0; i < length; i++) {
                                                    if (cevap.pasifSofor[i].turSoforID.indexOf(turDetayGidisSoforID) == -1) {
                                                        SelectSoforOptions[a] = {label: cevap.pasifSofor[i].turSoforAd + ' ' + cevap.pasifSofor[i].turSoforSoyad, title: cevap.pasifSofor[i].turSoforAd + ' ' + cevap.pasifSofor[i].turSoforSoyad, location: cevap.pasifSofor[i].turSoforLocation, value: cevap.pasifSofor[i].turSoforID};
                                                        a++;
                                                    }
                                                }
                                            } else {
                                                SelectSoforOptions[0] = {label: 'Seçiniz', title: 'Seçiniz', value: -1};
                                                var a = 1;
                                                for (var i = 0; i < length; i++) {
                                                    SelectSoforOptions[a] = {label: cevap.pasifSofor[i].turSoforAd + ' ' + cevap.pasifSofor[i].turSoforSoyad, title: cevap.pasifSofor[i].turSoforAd + ' ' + cevap.pasifSofor[i].turSoforSoyad, location: cevap.pasifSofor[i].turSoforLocation, value: cevap.pasifSofor[i].turSoforID};
                                                    a++;
                                                }
                                            }
                                            $('#TurDetayGidisSofor').multiselect('refresh');
                                            $('#TurDetayGidisSofor').multiselect('dataprovider', SelectSoforOptions);
                                        } else {
                                            SelectSoforOptions[0] = {label: turDetayGidisSoforAd, title: turDetayGidisSoforAd, location: soforLocation, value: turDetayGidisSoforID};
                                            $('#TurDetayGidisSofor').multiselect('refresh');
                                            $('#TurDetayGidisSofor').multiselect('dataprovider', SelectSoforOptions);
                                        }
                                    }
                                }
                            });
                        } else {
                            alert("Lütfen Araç Seçiniz");
                        }
                    } else {
                        alert("Lütfen Saat2 Seçiniz");
                    }
                } else {
                    alert("Lütfen Saat1 Seçiniz");
                }
            } else {
                alert("Lütfen Gün Seçiniz");
            }
        },
        onChange: function (option, checked, select) {
            if (kayitDeger == 0) {
                var soforLocation = $('select#TurDetayGidisSofor option[value!="-1"]:selected').attr('location');
                if (soforLocation) {
                    //harita için
                    var kurumLocation = $('input[name=TurDetayGidisKurumLocation]').val();
                    var kurumAd = $('input[name=TurDetayGidisKurum]').val();
                    var kurumID = $('input[name=TurDetayGidisKurumID]').val();
                    var soforID = $('select#TurDetayGidisSofor option:selected').val();
                    var soforAd = $('select#TurDetayGidisSofor option:selected').attr('label');
                    multipleKurumTurDetayMap(kurumAd, kurumID, kurumLocation, soforAd, soforID, soforLocation);
                    google.maps.event.addDomListener(window, 'load', multipleKurumTurDetayMap);
                }
            }
        }
    });
    //tur donüş detay saat1
    $('#TurDetayDonusSaat1').multiselect({
        onDropdownShow: function (event) {
            var turSaatSelect1 = $('select#TurDetayDonusSaat1 option[value!="-1"]:selected').val();
            var SelectSaat1Options = new Array();
            var SelectSaat1Value = new Array(0, 15, 30, 45, 100, 115, 130, 145, 200, 215, 230, 245, 300, 315, 330, 345, 400,
                    415, 430, 445, 500, 515, 530, 545, 600, 615, 630, 645, 700, 715, 730, 745, 800, 815, 830, 845, 900, 915, 930,
                    945, 1000, 1015, 1030, 1045, 1100, 1115, 1130, 1145, 1200, 1215, 1230, 1245, 1300, 1315, 1330, 1345, 1400,
                    1415, 1430, 1445, 1500, 1515, 1530, 1545, 1600, 1615, 1630, 1645, 1700, 1715, 1730, 1745, 1800, 1815, 1830,
                    1845, 1900, 1915, 1930, 1945, 2000, 2015, 2030, 2045, 2100, 2115, 2130, 2145, 2200, 2215, 2230, 2245, 2300,
                    2315, 2330, 2345);
            var SelectSaat1Text = new Array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45',
                    '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00',
                    '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15',
                    '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30',
                    '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45',
                    '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00',
                    '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15',
                    '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');
            SelectSaat1Options[0] = {label: 'Seçiniz', title: 'Seçiniz', value: '-1'};
            var saat2Length = SelectSaat1Value.length;
            for (var b = 0; b < saat2Length; b++) {
                if (SelectSaat1Value[b] == turSaatSelect1) {
                    SelectSaat1Options[b + 1] = {label: SelectSaat1Text[b], title: SelectSaat1Text[b], value: SelectSaat1Value[b], selected: true};
                } else {
                    SelectSaat1Options[b + 1] = {label: SelectSaat1Text[b], title: SelectSaat1Text[b], value: SelectSaat1Value[b]};
                }

            }
            $('#TurDetayDonusSaat1').multiselect('refresh');
            $('#TurDetayDonusSaat1').multiselect('dataprovider', SelectSaat1Options);
        },
        onChange: function (option, checked, select) {
            var turSaatSelect = $('select#TurDetayDonusSaat1 option[value!="-1"]:selected').val();
            var turSaatSelect2 = $('select#TurDetayDonusSaat2 option[value!="-1"]:selected').val();
            if (turSaatSelect) {
                var SelectSaat2Options = new Array();
                var SelectSaat2Value = new Array(0, 15, 30, 45, 100, 115, 130, 145, 200, 215, 230, 245, 300, 315, 330, 345, 400,
                        415, 430, 445, 500, 515, 530, 545, 600, 615, 630, 645, 700, 715, 730, 745, 800, 815, 830, 845, 900, 915, 930,
                        945, 1000, 1015, 1030, 1045, 1100, 1115, 1130, 1145, 1200, 1215, 1230, 1245, 1300, 1315, 1330, 1345, 1400,
                        1415, 1430, 1445, 1500, 1515, 1530, 1545, 1600, 1615, 1630, 1645, 1700, 1715, 1730, 1745, 1800, 1815, 1830,
                        1845, 1900, 1915, 1930, 1945, 2000, 2015, 2030, 2045, 2100, 2115, 2130, 2145, 2200, 2215, 2230, 2245, 2300,
                        2315, 2330, 2345);
                var SelectSaat2Text = new Array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45',
                        '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00',
                        '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15',
                        '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30',
                        '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45',
                        '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00',
                        '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15',
                        '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');
                SelectSaat2Options[0] = {label: 'Seçiniz', title: 'Seçiniz', value: '-1'};
                var saat2Length = SelectSaat2Value.length;
                for (var b = 0; b < saat2Length; b++) {
                    if (SelectSaat2Value[b] <= turSaatSelect) {
                        SelectSaat2Options[b + 1] = {label: SelectSaat2Text[b], title: SelectSaat2Text[b], value: SelectSaat2Value[b], disabled: true};
                    } else {
                        SelectSaat2Options[b + 1] = {label: SelectSaat2Text[b], title: SelectSaat2Text[b], value: SelectSaat2Value[b]};
                        if (SelectSaat2Value[b] == turDetayDonusSaat2) {
                            SelectSaat2Options[b + 1] = {label: SelectSaat2Text[b], title: SelectSaat2Text[b], value: SelectSaat2Value[b], selected: true};
                        }
                    }

                }
                $('#TurDetayDonusSaat2').multiselect('refresh');
                $('#TurDetayDonusSaat2').multiselect('dataprovider', SelectSaat2Options);
            } else {
                alert("Lütfen Saat 1 Seçiniz");
                var SelectSaat2Optionss = new Array();
                $('#TurSaat2').multiselect('dataprovider', SelectSaat2Optionss);
                $('#TurSaat2').multiselect('refresh');
            }
        }
    });
    //tur donüş detay saat2
    $('#TurDetayDonusSaat2').multiselect({
        onDropdownShow: function (event) {
            var turSaatSelect = $('select#TurDetayDonusSaat1 option[value!="-1"]:selected').val();
            if (turSaatSelect) {
                var SelectSaat2Options = new Array();
                var SelectSaat2Value = new Array(0, 15, 30, 45, 100, 115, 130, 145, 200, 215, 230, 245, 300, 315, 330, 345, 400,
                        415, 430, 445, 500, 515, 530, 545, 600, 615, 630, 645, 700, 715, 730, 745, 800, 815, 830, 845, 900, 915, 930,
                        945, 1000, 1015, 1030, 1045, 1100, 1115, 1130, 1145, 1200, 1215, 1230, 1245, 1300, 1315, 1330, 1345, 1400,
                        1415, 1430, 1445, 1500, 1515, 1530, 1545, 1600, 1615, 1630, 1645, 1700, 1715, 1730, 1745, 1800, 1815, 1830,
                        1845, 1900, 1915, 1930, 1945, 2000, 2015, 2030, 2045, 2100, 2115, 2130, 2145, 2200, 2215, 2230, 2245, 2300,
                        2315, 2330, 2345);
                var SelectSaat2Text = new Array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45',
                        '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00',
                        '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15',
                        '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30',
                        '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45',
                        '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00',
                        '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15',
                        '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');
                SelectSaat2Options[0] = {label: 'Seçiniz', title: 'Seçiniz', value: '-1'};
                var saat2Length = SelectSaat2Value.length;
                for (var b = 0; b < saat2Length; b++) {
                    if (SelectSaat2Value[b] <= turSaatSelect) {
                        SelectSaat2Options[b + 1] = {label: SelectSaat2Text[b], title: SelectSaat2Text[b], value: SelectSaat2Value[b], disabled: true};
                    } else {
                        SelectSaat2Options[b + 1] = {label: SelectSaat2Text[b], title: SelectSaat2Text[b], value: SelectSaat2Value[b]};
                        if (SelectSaat2Value[b] == turDetayDonusSaat2) {
                            SelectSaat2Options[b + 1] = {label: SelectSaat2Text[b], title: SelectSaat2Text[b], value: SelectSaat2Value[b], selected: true};
                        }
                    }

                }
                $('#TurDetayDonusSaat2').multiselect('refresh');
                $('#TurDetayDonusSaat2').multiselect('dataprovider', SelectSaat2Options);
            } else {
                alert("Lütfen Saat 1 Seçiniz");
                var SelectSaat2Optionss = new Array();
                $('#TurSaat2').multiselect('dataprovider', SelectSaat2Optionss);
                $('#TurSaat2').multiselect('refresh');
            }
        }
    });
    //tur dönüş araç focus
    $('#TurDetayDonusArac').multiselect({
        onDropdownShow: function (event) {
            var turGunID = new Array();
            $('select#TurDetayDonusGun option:selected').each(function () {
                turGunID.push($(this).val());
            });
            var turgunlength = turGunID.length;
            if (turgunlength > 0) {
                var turSaat1ID = $('select#TurDetayDonusSaat1 option[value!="-1"]:selected').val();
                if (turSaat1ID) {
                    var turSaat2ID = $('select#TurDetayDonusSaat2 option[value!="-1"]:selected').val();
                    if (turSaat2ID) {
                        var kurumID = $("input[name=TurDetayDonusKurumID]").val();
                        var bolgeID = $("input[name=TurDetayDonusBolgeID]").val();
                        $.ajax({
                            data: {"bolgeID": bolgeID, "kurumID": kurumID, "turGunID[]": turGunID, "turSaat1ID": turSaat1ID, "turSaat2ID": turSaat2ID, "tip": "turDonusAracSelect"},
                            success: function (cevap) {
                                if (cevap.hata) {
                                    alert(cevap.hata);
                                } else {
                                    var SelectAracOptions = new Array();
                                    var a = 1;
                                    if (cevap.pasifArac) {
                                        var length = cevap.pasifArac.length;
                                        if (turDetayDonusAracID.length > 0) {
                                            SelectAracOptions[0] = {label: turDetayDonusAracPlaka, title: turDetayDonusAracPlaka + ' (' + turDetayDonusAracKapasite + ')', value: turDetayDonusAracID, kapasite: turDetayDonusAracKapasite, selected: true};
                                            for (var i = 0; i < length; i++) {
                                                if (cevap.pasifArac[i].turAracID.indexOf(turDetayDonusAracID) == -1) {
                                                    SelectAracOptions[a] = {label: cevap.pasifArac[i].turAracPlaka, title: cevap.pasifArac[i].turAracPlaka + ' (' + cevap.pasifArac[i].turAracKapasite + ')', value: cevap.pasifArac[i].turAracID, kapasite: cevap.pasifArac[i].turAracKapasite};
                                                    a++;
                                                }
                                            }
                                        } else {
                                            for (var i = 0; i < length; i++) {
                                                SelectAracOptions[i] = {label: cevap.pasifArac[i].turAracPlaka, title: cevap.pasifArac[i].turAracPlaka + ' (' + cevap.pasifArac[i].turAracKapasite + ')', value: cevap.pasifArac[i].turAracID, kapasite: cevap.pasifArac[i].turAracKapasite};
                                            }
                                        }
                                        $('#TurDetayDonusArac').multiselect('refresh');
                                        $('#TurDetayDonusArac').multiselect('dataprovider', SelectAracOptions);
                                    } else {
                                        SelectAracOptions[0] = {label: turDetayDonusAracPlaka, title: turDetayDonusAracPlaka + ' (' + turDetayDonusAracKapasite + ')', value: turDetayDonusAracID, kapasite: turDetayDonusAracKapasite, selected: true};
                                        $('#TurDetayDonusArac').multiselect('refresh');
                                        $('#TurDetayDonusArac').multiselect('dataprovider', SelectAracOptions);
                                    }
                                }
                            }
                        });
                    } else {
                        alert("Lütfen Saat2 Seçiniz");
                    }
                } else {
                    alert("Lütfen Saat1 Seçiniz");
                }
            } else {
                alert("Lütfen Gün Seçiniz");
            }
        }
    });
    //tur detay dönüş şoför focus
    $('#TurDetayDonusSofor').multiselect({
        onDropdownShow: function (event) {
            var turGunID = new Array();
            $('select#TurDetayDonusGun option:selected').each(function () {
                turGunID.push($(this).val());
            });
            var turgunlength = turGunID.length;
            if (turgunlength > 0) {
                var turSaat1ID = $('select#TurDetayDonusSaat1 option[value!="-1"]:selected').val();
                if (turSaat1ID) {
                    var turSaat2ID = $('select#TurDetayDonusSaat2 option[value!="-1"]:selected').val();
                    if (turSaat2ID) {
                        var aracID = $('select#TurDetayDonusArac option:selected').val();
                        if (aracID) {
                            var kurumID = $("input[name=TurDetayDonusKurumID]").val();
                            var bolgeID = $("input[name=TurDetayDonusBolgeID]").val();
                            $.ajax({
                                data: {"bolgeID": bolgeID, "kurumID": kurumID, "turGunID[]": turGunID, "turSaat1ID": turSaat1ID, "turSaat2ID": turSaat2ID, "aracID": aracID, "tip": "turDonusSoforSelect"},
                                success: function (cevap) {
                                    if (cevap.hata) {
                                        alert(cevap.hata);
                                    } else {
                                        var SelectSoforOptions = new Array();
                                        var soforLocation = $('input[name=DonusSoforInput]').val();
                                        var a = 1;
                                        if (cevap.pasifSofor) {
                                            var length = cevap.pasifSofor.length;
                                            if (turDetayDonusSoforID.length > 0) {
                                                SelectSoforOptions[0] = {label: turDetayDonusSoforAd, title: turDetayDonusSoforAd, location: soforLocation, value: turDetayDonusSoforID, selected: true};
                                                for (var i = 0; i < length; i++) {
                                                    if (cevap.pasifSofor[i].turSoforID.indexOf(turDetayDonusSoforID) == -1) {
                                                        SelectSoforOptions[a] = {label: cevap.pasifSofor[i].turSoforAd + ' ' + cevap.pasifSofor[i].turSoforSoyad, title: cevap.pasifSofor[i].turSoforAd + ' ' + cevap.pasifSofor[i].turSoforSoyad, location: cevap.pasifSofor[i].turSoforLocation, value: cevap.pasifSofor[i].turSoforID};
                                                        a++;
                                                    }
                                                }
                                            } else {
                                                SelectSoforOptions[0] = {label: 'Seçiniz', title: 'Seçiniz', value: -1};
                                                var a = 1;
                                                for (var i = 0; i < length; i++) {
                                                    SelectSoforOptions[a] = {label: cevap.pasifSofor[i].turSoforAd + ' ' + cevap.pasifSofor[i].turSoforSoyad, title: cevap.pasifSofor[i].turSoforAd + ' ' + cevap.pasifSofor[i].turSoforSoyad, location: cevap.pasifSofor[i].turSoforLocation, value: cevap.pasifSofor[i].turSoforID};
                                                    a++
                                                }
                                            }
                                            $('#TurDetayDonusSofor').multiselect('refresh');
                                            $('#TurDetayDonusSofor').multiselect('dataprovider', SelectSoforOptions);
                                        } else {
                                            SelectSoforOptions[0] = {label: turDetayDonusSoforAd, title: turDetayDonusSoforAd, location: soforLocation, value: turDetayDonusSoforID};
                                            $('#TurDetayDonusSofor').multiselect('refresh');
                                            $('#TurDetayDonusSofor').multiselect('dataprovider', SelectSoforOptions);
                                        }
                                    }
                                }
                            });
                        } else {
                            alert("Lütfen Araç Seçiniz");
                        }
                    } else {
                        alert("Lütfen Saat2 Seçiniz");
                    }
                } else {
                    alert("Lütfen Saat1 Seçiniz");
                }
            } else {
                alert("Lütfen Gün Seçiniz");
            }
        },
        onChange: function (option, checked, select) {
            if (kayitDeger == 0) {
                var soforLocation = $('select#TurDetayGidisSofor option[value!="-1"]:selected').attr('location');
                if (soforLocation) {
                    //harita için
                    var kurumLocation = $('input[name=TurDetayGidisKurumLocation]').val();
                    var kurumAd = $('input[name=TurDetayGidisKurum]').val();
                    var kurumID = $('input[name=TurDetayGidisKurumID]').val();
                    var soforID = $('select#TurDetayGidisSofor option:selected').val();
                    var soforAd = $('select#TurDetayGidisSofor option:selected').attr('label');
                    multipleKurumTurDetayMap(kurumAd, kurumID, kurumLocation, soforAd, soforID, soforLocation);
                    google.maps.event.addDomListener(window, 'load', multipleKurumTurDetayMap);
                }
            }
        }
    });
});
var AdminKurumKaydet = [];
var AdminKurumDetailVazgec = [];
var AdminNewKurum = [];
$.AdminIslemler = {
    adminKurumYeni: function () {
        $("input[name=KurumAdi]").val('');
        $("input[name=KurumLokasyon]").val('');
        $("input[name=KurumTelefon]").val('');
        $("input[name=KurumEmail]").val('');
        $("input[name=KurumWebSite]").val('');
        $("textarea[name=KurumAdresDetay]").val('');
        $("textarea[name=Aciklama]").val('');
        $("input[name=country]").val('');
        $("input[name=administrative_area_level_1]").val('');
        $("input[name=administrative_area_level_2]").val('');
        $("input[name=locality]").val('');
        $("input[name=neighborhood]").val('');
        $("input[name=route]").val('');
        $("input[name=postal_code]").val('');
        $("input[name=street_number]").val('');
        $('select#KurumBolgeSelect option').remove();
        $.ajax({
            data: {"tip": "adminKurumSelectBolge"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    var length = cevap.adminKurumBolge.length;
                    if (length > 0) {
                        for (var i = 0; i < length; i++) {
                            $("#KurumBolgeSelect").append('<option value="' + cevap.adminKurumBolgee[i] + '">' + cevap.adminKurumBolge[i] + '</option>');
                        }
                    }
                }
            }
        });
        return true;
    },
    adminAddKurumVazgec: function () {
        $("input[name=KurumAdi]").val('');
        $("textarea[name=KurumAciklama]").val('');
        return true;
    },
    adminKurumKaydet: function () {
        AdminKurumKaydet = [];
        var kurum_adi = $("input[name=KurumAdi]").val();
        var kurum_aciklama = $("textarea[name=KurumAciklama]").val();
        AdminKurumKaydet.push(kurum_adi);
        AdminKurumKaydet.push(kurum_adi);
        if (bolge_adi != '') {
            $.ajax({
                data: {"kurum_adi": kurum_adi, "kurum_aciklama": kurum_aciklama, "tip": "adminKurumYeniKaydet"},
                success: function (cevap) {
                    if (cevap.hata) {
                        AdminKurumKaydet = [];
                        alert(cevap.hata);
                    } else {
                        var bolgeCount = $('#smallBolge').text();
                        bolgeCount++;
                        $('#smallBolge').text(bolgeCount);
                        var addRow = ("<tr style='background-color:#F2F2F2'><td><a class='svToggle' data-type='svDetail' role='button' data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newBolgeID + "'>"
                                + "<i class='fa fa-search'></i> " + AdminBolgeKaydet[0] + "</a>"
                                + "</td><td class='hidden-xs'>0</td><td class='hidden-xs'>" + AdminBolgeKaydet[1] + "</td></tr>");
                        NewKurumTable.DataTable().row.add($(addRow)).draw();
                    }
                }
            });
            return true;
        } else {
            alert("Lütfen Kurum Adını Giriniz");
        }
    },
    adminKurumDetailSil: function () {
        var kurumdetail_id = $("input[name=adminKurumDetailID]").val();
        $.ajax({
            data: {"kurumdetail_id": kurumdetail_id, "tip": "adminKurumDetailDelete"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    disabledForm();
                    $("input[name=KurumDetailAdi]").val('');
                    $("input[name=KurumDetailBolge]").val('');
                    $("input[name=KurumDetailTelefon]").val('');
                    $("input[name=KurumDetailEmail]").val('');
                    $("textarea[name=KurumDetailAdres]").val('');
                    $("textarea[name=KurumDetailAciklama]").val('');
                    $("input[name=adminKurumDetailID]").val('');
                    var kurumCount = $('#smallKurum').text();
                    kurumCount--;
                    $('#smallKurum').text(kurumCount);
                    var length = $('tbody#adminKurumRow tr').length;
                    for (var t = 0; t < length; t++) {
                        var attrValueId = $("tbody#adminKurumRow > tr > td > a").eq(t).attr('value');
                        if (attrValueId == kurumdetail_id) {
                            var deleteRow = $('tbody#adminKurumRow > tr:eq(' + t + ')');
                            NewKurumTable.DataTable().row($(deleteRow)).remove().draw();
                        }
                    }
                }
            }
        });
        return true;
    },
    adminKurumDetailDuzenle: function () {
        //Kurum İşlemleri Değerleri
        var kurumdetail_adi = $("input[name=KurumDetailAdi]").val();
        var kurumdetail_bolge = $("input[name=KurumDetailBolge]").val();
        var kurumtip = $("#KurumDetayTip option:selected").val();
        var kurumdetail_telefon = $("input[name=KurumDetailTelefon]").val();
        var kurumdetail_email = $("input[name=KurumDetailEmail]").val();
        var kurumdetail_adres = $("textarea[name=KurumDetailAdres]").val();
        var kurumdetail_aciklama = $("textarea[name=KurumDetailAciklama]").val();
        AdminKurumDetailVazgec = [];
        AdminKurumDetailVazgec.push(kurumdetail_adi, kurumdetail_bolge, kurumdetail_telefon, kurumdetail_email, kurumdetail_adres, kurumdetail_aciklama, kurumtip);
    },
    adminKurumDetailVazgec: function () {
        $("input[name=KurumDetailAdi]").val(AdminKurumDetailVazgec[0]);
        $("input[name=KurumDetailBolge]").val(AdminKurumDetailVazgec[1]);
        $("input[name=KurumDetailTelefon]").val(AdminKurumDetailVazgec[2]);
        $("input[name=KurumDetailEmail]").val(AdminKurumDetailVazgec[3]);
        $("textarea[name=KurumDetailAdres]").val(AdminKurumDetailVazgec[4]);
        $("textarea[name=KurumDetailAciklama]").val(AdminKurumDetailVazgec[5]);
        $("#KurumDetayTip").val(AdminKurumDetailVazgec[6]);
    },
    adminKurumDetailKaydet: function () {
        var kurumdetail_adi = $("input[name=KurumDetailAdi]").val();
        var kurumdetail_bolge = $("input[name=KurumDetailBolge]").val();
        var kurumdetail_tip = $("#KurumDetayTip option:selected").val();
        var kurumdetail_tip_text = $("#KurumDetayTip option:selected").text();
        var kurumdetail_telefon = $("input[name=KurumDetailTelefon]").val();
        var kurumdetail_email = $("input[name=KurumDetailEmail]").val();
        var kurumdetail_adres = $("textarea[name=KurumDetailAdres]").val();
        var kurumdetail_aciklama = $("textarea[name=KurumDetailAciklama]").val();
        var kurumdetail_id = $("input[name=adminKurumDetailID]").val();
        if (AdminKurumDetailVazgec[0] == kurumdetail_adi && AdminKurumDetailVazgec[1] == kurumdetail_bolge && AdminKurumDetailVazgec[2] == kurumdetail_telefon && AdminKurumDetailVazgec[3] == kurumdetail_email && AdminKurumDetailVazgec[4] == kurumdetail_adres && AdminKurumDetailVazgec[5] == kurumdetail_aciklama && AdminKurumDetailVazgec[6] == kurumdetail_tip) {
            alert("Lütfen Değişiklik yaptığınıza emin olun.");
        } else {
            $.ajax({
                data: {"kurumdetail_id": kurumdetail_id, "kurumdetail_adi": kurumdetail_adi, "kurumdetail_bolge": kurumdetail_bolge, "kurumdetail_telefon": kurumdetail_telefon, "kurumdetail_email": kurumdetail_email, "kurumdetail_adres": kurumdetail_adres, "kurumdetail_aciklama": kurumdetail_aciklama, "kurumdetail_tip": kurumdetail_tip, "tip": "adminKurumDetailDuzenle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        alert(cevap.hata);
                    } else {
                        disabledForm();
                        var length = $('tbody#adminKurumRow tr').length;
                        for (var t = 0; t < length; t++) {
                            var attrValueId = $("tbody#adminKurumRow > tr > td > a").eq(t).attr('value');
                            if (attrValueId == kurumdetail_id) {
                                $("tbody#adminKurumRow > tr > td > a").eq(t).html('<i class="fa fa-search"></i> ' + kurumdetail_adi);
                                $("tbody#adminKurumRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(kurumdetail_tip_text);
                                $("tbody#adminKurumRow > tr > td > a").eq(t).parent().parent().find('td:last-child').text(kurumdetail_aciklama);
                                $('tbody#adminKurumRow > tr:eq(' + t + ') > td:eq(0)').css({"background-color": "#F2F2F2"});
                            }
                        }
                    }
                }
            });
        }
    },
    adminKurumVazgec: function () {
        return true;
    },
    adminKurumEkle: function () {
        var kurumadi = $("input[name=KurumAdi]").val();
        if (kurumadi == '') {
            alert("Kurum Adı Boş geçilemez");
        } else {
            var kurumlocation = $("input[name=KurumLokasyon]").val();
            if (kurumlocation == '') {
                alert("Kurum Lokasyonu geçilemez");
            } else {
                var bolgead = $("#KurumBolgeSelect option:selected").text();
                var bolgeId = $("#KurumBolgeSelect option:selected").val();
                var kurumtip = $("#KurumTip option:selected").val();
                var kurumTlfn = $("input[name=KurumTelefon]").val();
                var kurumEmail = $("input[name=KurumEmail]").val();
                var kurumwebsite = $("input[name=KurumWebSite]").val();
                var kurumadrsDty = $("textarea[name=KurumAdresDetay]").val();
                var kurumaciklama = $("textarea[name=Aciklama]").val();
                var kurumulke = $("input[name=country]").val();
                var kurumil = $("input[name=administrative_area_level_1]").val();
                var kurumilce = $("input[name=administrative_area_level_2]").val();
                var kurumsemt = $("input[name=locality]").val();
                var kurummahalle = $("input[name=neighborhood]").val();
                var kurumsokak = $("input[name=route]").val();
                var kurumpostakodu = $("input[name=postal_code]").val();
                var kurumcaddeno = $("input[name=street_number]").val();
                $.ajax({
                    data: {"kurumadi": kurumadi, "bolgeId": bolgeId, "kurumtip": kurumtip, "bolgead": bolgead, "kurumlocation": kurumlocation, "kurumTlfn": kurumTlfn, "kurumEmail": kurumEmail,
                        "kurumwebsite": kurumwebsite, "kurumadrsDty": kurumadrsDty, "kurumaciklama": kurumaciklama,
                        "kurumulke": kurumulke, "kurumil": kurumil, "kurumilce": kurumilce, "kurumsemt": kurumsemt,
                        "kurummahalle": kurummahalle, "kurumsokak": kurumsokak, "kurumpostakodu": kurumpostakodu,
                        "kurumcaddeno": kurumcaddeno, "tip": "adminKurumKaydet"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            alert(cevap.hata);
                        } else {
                            var kurumCount = $('#smallKurum').text();
                            kurumCount++;
                            $('#smallKurum').text(kurumCount);
                            var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                    + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newKurumID + "'>"
                                    + "<i class='fa fa-map-marker'></i> " + kurumadi + "</a></td>"
                                    + "<td class='hidden-xs' value='" + bolgeId + "'>" + bolgead + "</td>"
                                    + "<td class='hidden-xs'>0</td><td class='hidden-xs'>" + kurumaciklama + "</td></tr>";
                            NewKurumTable.DataTable().row.add($(addRow)).draw();
                        }
                    }
                });
                return true;
            }



        }
    },
    adminKurumMap: function () {
        var kurum_location = $("input[name=adminKurumDetailLocation]").val();
        var kurum_adi = $("input[name=KurumDetailAdi]").val();
        if (!kurum_location) {
            alert("Kurumunuza ait lokasyon bilgisi bulunmamaktadır");
        } else {
            var count = $('table#adminBolgeKurumTable > tbody > tr').length;
            var MapValue = $(this).attr('value');
            var LocationBolme = kurum_location.split(",");
            MultipleMapArray[0] = Array(kurum_adi, LocationBolme[0], LocationBolme[1]);
            $("#singleMapBaslik").text(kurum_adi);
            return true;
        }
    },
    adminKurumTurYeni: function () {
        var kurumad = $("input[name=KurumDetailAdi]").val();
        var turKurumID = $("input[name=adminKurumDetailID]").val();
        var bolgead = $("input[name=KurumDetailBolge]").val();
        var turKurumTip = $('select#KurumDetayTip option:selected').val();
        $("input[name=TurAdi]").val(' ');
        $("input[name=KurumTurBolgeAdi]").val(bolgead);
        $("input[name=KurumTurKurumAdi]").val(kurumad);
        $("textarea[name=Aciklama]").val(' ');
        if (turKurumID) {
            $.ajax({
                data: {"turKurumID": turKurumID, "turKurumTip": turKurumTip, "tip": "turKurumSelectKisi"},
                success: function (cevap) {
                    if (cevap.hata) {
                        alert(cevap.hata);
                    } else {
                        MultipleMapArray = [];
                        var kurumLocation = $("input[name=adminKurumDetailLocation]").val();
                        var LocationKurumBolme = kurumLocation.split(",");
                        MultipleMapArray[0] = Array(kurumad, LocationKurumBolme[0], LocationKurumBolme[1]);
                        if (cevap.kurumOKisi) {//öğrenci
                            MultipleMapindex = 0;
                            var length = cevap.kurumOKisi.length;
                            for (var countK = 0; countK < length; countK++) {
                                var OKisiMap = cevap.kurumOKisi[countK].turOKisiLocation;
                                var LocationBolme = OKisiMap.split(",");
                                var OKisiName = cevap.kurumOKisi[countK].turOKisiAd + ' ' + cevap.kurumOKisi[countK].turOKisiSoyad;
                                var OKisiID = cevap.kurumOKisi[countK].turOKisiID;
                                MultipleMapArray[countK + 1] = Array(OKisiName, LocationBolme[0], LocationBolme[1], OKisiID, 0);
                            }
                            if (cevap.kurumPKisi) {//personel
                                ayiriciIndex = countK + 1;
                                var length = cevap.kurumPKisi.length;
                                countPe = countK + 1;
                                for (var countP = 0; countP < length; countP++) {
                                    var PKisiMap = cevap.kurumPKisi[countP].turPKisiLocation;
                                    var LocationBolme = PKisiMap.split(",");
                                    var PKisiName = cevap.kurumPKisi[countP].turPKisiAd + ' ' + cevap.kurumPKisi[countP].turPKisiSoyad;
                                    var PKisiID = cevap.kurumPKisi[countP].turPKisiID;
                                    MultipleMapArray[countPe] = Array(PKisiName, LocationBolme[0], LocationBolme[1], PKisiID, 1);
                                    countPe++;
                                }
                            }
                        } else if (cevap.kurumPKisi) {//personel
                            MultipleMapindex = 1;
                            var length = cevap.kurumPKisi.length;
                            for (var countK = 0; countK < length; countK++) {
                                var PKisiMap = cevap.kurumPKisi[countK].turPKisiLocation;
                                var LocationBolme = PKisiMap.split(",");
                                var PKisiName = cevap.kurumPKisi[countK].turPKisiAd + ' ' + cevap.kurumPKisi[countK].turPKisiSoyad;
                                var PKisiID = cevap.kurumPKisi[countK].turPKisiID;
                                MultipleMapArray[countK + 1] = Array(PKisiName, LocationBolme[0], LocationBolme[1], PKisiID, 1);
                            }
                        }

                        multipleKurumTurMapping(MultipleMapArray, MultipleMapindex, ayiriciIndex, sofor);
                        google.maps.event.addDomListener(window, 'load', multipleKurumTurMapping);
                    }
                }
            });
        }
        var SelectAracOptions = new Array();
        var SelectSaat1Options = new Array();
        var SelectSaat2Options = new Array();
        var SelectSoforOptions = new Array();
        $('#TurArac').multiselect('dataprovider', SelectAracOptions);
        $('#TurSaat1').multiselect('dataprovider', SelectSaat1Options);
        $('#TurSaat2').multiselect('dataprovider', SelectSaat2Options);
        $('#TurSofor').multiselect('dataprovider', SelectSoforOptions);
        $('#TurSelectGun').multiselect('refresh');
        $('#TurSelectTip').multiselect('refresh');
        $('#TurSaat1').multiselect();
        $('#TurSaat2').multiselect();
        $('#TurArac').multiselect();
        $('#TurSofor').multiselect();
    },
    adminKurumTurVazgec: function () {
        return true;
    },
    adminKurumTurKaydet: function () {
        if (locations.length < 2) {
            alert("Lütfen Turlarınızı Oluşturunuz");
        } else {
            var turGidis = $("input[name=TurGidis]").val();
            var turDonus = $("input[name=TurDonus]").val();
            var turID = $("input[name=TurID]").val();
            if (turGidis == '' || turDonus == '') {
                var turAdi = $("input[name=TurAdi]").val();
                if (turAdi) {
                    var bolgeID = $("input[name=kurumDetayBolgeID]").val();
                    if (bolgeID) {
                        var bolgead = $("input[name=KurumDetailBolge]").val();
                        var kurumId = $("input[name=adminKurumDetailID]").val();
                        if (kurumId) {
                            var kurumad = $("input[name=KurumDetailAdi]").val();
                            var kurumTip = $('select#KurumDetayTip option:selected').val();
                            var kurumLocation = $("input[name=adminKurumDetailLocation]").val();
                            var turGun = new Array();
                            $('select#TurSelectGun option:selected').each(function () {
                                turGun.push($(this).val());
                            });
                            var turgunlength = turGun.length;
                            if (turgunlength > 0) {
                                var turSaat1 = $('select#TurSaat1 option[value!="-1"]:selected').val();
                                if (turSaat1) {
                                    var turSaat2 = $('select#TurSaat2 option[value!="-1"]:selected').val();
                                    if (turSaat2) {
                                        var aracID = $('select#TurArac option[value!="-1"]:selected').val();
                                        if (aracID) {
                                            var aracPlaka = $("select#TurArac option:selected").attr('label');
                                            var aracKapasite = $("select#TurArac option:selected").attr('kapasite');
                                            var soforID = $('select#TurSofor option:selected').val();
                                            if (soforID) {
                                                var soforAd = $("select#TurSofor option:selected").attr('label');
                                                var soforLocation = $("select#TurSofor option:selected").attr('location');
                                                var turTip = $("select#TurSelectTip option:selected").val();
                                                var turAciklama = $("textarea[name=TurAciklama]").val();
                                                var turKm = $("span#totalKm").text();
                                                $.ajax({
                                                    data: {"turID": turID, "turAdi": turAdi, "bolgeID": bolgeID, "bolgead": bolgead, "kurumad": kurumad, "kurumId": kurumId,
                                                        "kurumTip": kurumTip, "kurumLocation": kurumLocation, "turGun[]": turGun, "turSaat1": turSaat1, "turSaat2": turSaat2,
                                                        "aracID": aracID, "aracPlaka": aracPlaka, "aracKapasite": aracKapasite, "turGidis": turGidis, "turDonus": turDonus,
                                                        "soforID": soforID, "soforAd": soforAd, "soforLocation": soforLocation, "turTip": turTip, "turAciklama": turAciklama, "turKm": turKm,
                                                        "turOgrenciID[]": KisiOgrenciID, "turOgrenciAd[]": KisiOgrenciAd, "turOgrenciLocation[]": KisiOgrenciLocation, "turOgrenciSira[]": KisiOgrenciSira, "turKisiIsciID[]": KisiIsciID,
                                                        "turKisiIsciAd[]": KisiIsciAd, "turKisiIsciLocation[]": KisiIsciLocation, "turKisiIsciSira[]": KisiIsciSira, "tip": "turKaydet"},
                                                    success: function (cevap) {
                                                        if (cevap.hata) {
                                                            alert(cevap.hata);
                                                        } else {
                                                            kayitDeger = 1;
                                                            if (cevap.turGidis) {
                                                                $("input[name=TurGidis]").val(cevap.turGidis);
                                                                $('#TurSelectTip').multiselect('deselect', '0', true);
                                                                var dropdown = $('#TurSelectTip').siblings('.multiselect-container');
                                                                $('#TurSelectTip option:eq(0)').each(function () {
                                                                    var input = $('input[value="' + $(this).val() + '"]');
                                                                    input.prop('disabled', true);
                                                                    input.parent('li').addClass('disabled');
                                                                });
                                                                $('#TurSelectTip').multiselect('select', '1', true);
                                                            }
                                                            if (cevap.turDonus) {
                                                                $("input[name=TurDonus]").val(cevap.turDonus);
                                                                $('#TurSelectTip').multiselect('deselect', '1', true);
                                                                var dropdown = $('#TurSelectTip').siblings('.multiselect-container');
                                                                $('#TurSelectTip option:eq(1)').each(function () {
                                                                    var input = $('input[value="' + $(this).val() + '"]');
                                                                    input.prop('disabled', true);
                                                                    input.parent('li').addClass('disabled');
                                                                });
                                                                $('#TurSelectTip').multiselect('select', '0', true);
                                                            }
                                                            $('#TurSelectBolge').multiselect('disable');
                                                            $('#TurSelectKurum').multiselect('disable');
                                                            $('#TurSelectGun').multiselect('disable');
                                                            $("input[name=TurID]").val(cevap.turID);
                                                            var turGidisi = $("input[name=TurGidis]").val();
                                                            var turDonusu = $("input[name=TurDonus]").val();
                                                            if (turGidisi != '' && turDonusu != '') {
                                                                //iki işlemde yapıldı ise kapanıyor direkt
                                                                svControl('svClose', 'tur', '');
                                                            } else {
                                                                //işlemlerde eksik varsa kalıyor sayfa
                                                                disabledForm();
                                                                var length = $('tbody#adminKurumRow tr').length;
                                                                for (var t = 0; t < length; t++) {
                                                                    var attrValueId = $("tbody#adminKurumRow > tr > td > a").eq(t).attr('value');
                                                                    if (attrValueId == kurumId) {
                                                                        var turSayi = $("tbody#adminKurumRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text();
                                                                        turSayi++;
                                                                        $("tbody#adminKurumRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(turSayi);
                                                                        $('tbody#adminKurumRow > tr:eq(' + t + ') > td:eq(0)').css({"background-color": "#F2F2F2"});
                                                                    }
                                                                }

                                                                var turTurutipi;
                                                                if (kurumTip == 0) {
                                                                    turTurutipi = 'Öğrenci';
                                                                } else if (kurumTip == 1) {
                                                                    turTurutipi = 'İşçi';
                                                                } else {
                                                                    turTurutipi = 'Öğrenci/Personel';
                                                                }
                                                                var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.turID + "'>"
                                                                        + "<i class='glyphicon glyphicon-refresh' style='color:red;'></i> " + turAdi + "</a></td>"
                                                                        + "<td class='hidden-xs'>" + turTurutipi + "</td>"
                                                                        + "<td class='hidden-xs'>" + turAciklama + "</td>";
                                                                KurumTurTable.DataTable().row.add($(addRow)).draw();
                                                            }
                                                        }
                                                    }
                                                });
                                            } else {
                                                alert("Lütfen Şoför Seçiniz");
                                            }
                                        } else {
                                            alert("Lütfen Araç Seçiniz");
                                        }
                                    } else {
                                        alert("Lütfen Saat Seçiniz");
                                    }
                                } else {
                                    alert("Lütfen Saat Seçiniz");
                                }
                            } else {
                                alert("Lütfen Gün Seçiniz");
                            }
                        } else {
                            alert("Lütfen Kurum Seçiniz");
                        }
                    } else {
                        alert("Lütfen Bölge Seçiniz");
                    }
                } else {
                    alert("Tur Adı Boş Geçilemez");
                }
            } else {
                alert("Gidiş ve Dönüş Tur Eklemesini yapmışsınız");
            }
        }
    },
    adminKurumTurDetayGidis: function () {
        disabledForm();
        var gidisTipID = $('input[name=adminTurDetayGds]').val();
        var turTip = $('input[name=adminTurDetayTip]').val();
        var kurumID = $('input[name=TurDetayGidisKurumID]').val();
        var turID = $('input[name=adminTurID]').val();
        $.ajax({
            data: {"turID": turID, "gidisTipID": gidisTipID, "turTip": turTip, "kurumID": kurumID, "tip": "adminTurDetayGidis"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    //Saat1
                    var SelectSaat1Options = new Array();
                    var saat1;
                    if (turDetayGidisSaat1.length > 0) {
                        if (turDetayGidisSaat1.length == 1) {
                            saat1 = '00:00'
                        } else if (turDetayGidisSaat1.length == 2) {
                            saat1 = '00:' + turDetayGidisSaat1;
                        } else if (turDetayGidisSaat1.length == 3) {
                            var ilkHarf1 = turDetayGidisSaat1.slice(0, 1);
                            var sondaikiHarf1 = turDetayGidisSaat1.slice(1, 3);
                            saat1 = '0' + ilkHarf1 + ':' + sondaikiHarf1;
                        } else {
                            var ilkikiHarf1 = turDetayGidisSaat1.slice(0, 2);
                            var sondaikiHarf1 = turDetayGidisSaat1.slice(2, 4);
                            saat1 = ilkikiHarf1 + ':' + sondaikiHarf1;
                        }
                        SelectSaat1Options[0] = {label: saat1, value: turDetayGidisSaat1, disabled: true};
                        $('#TurDetayGidisSaat1').multiselect('dataprovider', SelectSaat1Options);
                    }
                    $('#TurDetayGidisSaat1').multiselect('refresh');
                    $('#TurDetayGidisSaat1').multiselect('disable');
                    //Saat2
                    var SelectSaat2Options = new Array();
                    var saat2;
                    if (turDetayGidisSaat2.length > 0) {
                        if (turDetayGidisSaat2.length == 1) {
                            saat2 = '00:00'
                        } else if (turDetayGidisSaat2.length == 2) {
                            saat2 = '00:' + turDetayGidisSaat2;
                        } else if (turDetayGidisSaat2.length == 3) {
                            var ilkHarf2 = turDetayGidisSaat2.slice(0, 1);
                            var sondaikiHarf2 = turDetayGidisSaat2.slice(1, 3);
                            saat2 = '0' + ilkHarf2 + ':' + sondaikiHarf2;
                        } else {
                            var ilkikiHarf2 = turDetayGidisSaat2.slice(0, 2);
                            var sondaikiHarf2 = turDetayGidisSaat2.slice(2, 4);
                            saat2 = ilkikiHarf2 + ':' + sondaikiHarf2;
                        }
                        SelectSaat2Options[0] = {label: saat2, value: turDetayGidisSaat2, disabled: true};
                        $('#TurDetayGidisSaat2').multiselect('dataprovider', SelectSaat2Options);
                    }
                    $('#TurDetayGidisSaat2').multiselect('refresh');
                    $('#TurDetayGidisSaat2').multiselect('disable');
                    //Araç
                    if (turDetayGidisAracPlaka.length > 0) {
                        var SelectAracOptions = new Array();
                        SelectAracOptions[0] = {label: turDetayGidisAracPlaka, value: turDetayGidisAracID, disabled: true};
                        $('#TurDetayGidisArac').multiselect('dataprovider', SelectAracOptions);
                    }
                    $('#TurDetayGidisArac').multiselect('refresh');
                    $('#TurDetayGidisArac').multiselect('disable');
                    //Şoför
                    if (turDetayGidisSoforAd.length > 0) {
                        var SelectSoforOptions = new Array();
                        SelectSoforOptions[0] = {label: turDetayGidisSoforAd, value: turDetayGidisSoforID, disabled: true};
                        $('#TurDetayGidisSofor').multiselect('dataprovider', SelectSoforOptions);
                    }
                    $('#TurDetayGidisSofor').multiselect('refresh');
                    $('#TurDetayGidisSofor').multiselect('disable');
                    //Gunler

                    if (cevap.gidis.Pzt != 0) {
                        SelectDetayGidisGunOptions[0] = {label: 'Pazartesi', title: 'Pazartesi', value: 'Pzt', selected: true};
                    } else {
                        SelectDetayGidisGunOptions[0] = {label: 'Pazartesi', title: 'Pazartesi', value: 'Pzt'};
                    }
                    if (cevap.gidis.Sli != 0) {
                        SelectDetayGidisGunOptions[1] = {label: 'Salı', title: 'Salı', value: 'Sli', selected: true};
                    } else {
                        SelectDetayGidisGunOptions[1] = {label: 'Salı', title: 'Salı', value: 'Sli'};
                    }
                    if (cevap.gidis.Crs != 0) {
                        SelectDetayGidisGunOptions[2] = {label: 'Çarşamba', title: 'Çarşamba', value: 'Crs', selected: true};
                    } else {
                        SelectDetayGidisGunOptions[2] = {label: 'Çarşamba', title: 'Çarşamba', value: 'Crs'};
                    }
                    if (cevap.gidis.Prs != 0) {
                        SelectDetayGidisGunOptions[3] = {label: 'Perşembe', title: 'Perşembe', value: 'Prs', selected: true};
                    } else {
                        SelectDetayGidisGunOptions[3] = {label: 'Perşembe', title: 'Perşembe', value: 'Prs'};
                    }
                    if (cevap.gidis.Cma != 0) {
                        SelectDetayGidisGunOptions[4] = {label: 'Cuma', title: 'Cuma', value: 'Cma', selected: true};
                    } else {
                        SelectDetayGidisGunOptions[4] = {label: 'Cuma', title: 'Cuma', value: 'Cma'};
                    }
                    if (cevap.gidis.Cmt != 0) {
                        SelectDetayGidisGunOptions[5] = {label: 'Cumartesi', title: 'Cumartesi', value: 'Cmt', selected: true};
                    } else {
                        SelectDetayGidisGunOptions[5] = {label: 'Cumartesi', title: 'Cumartesi', value: 'Cmt'};
                    }
                    if (cevap.gidis.Pzr != 0) {
                        SelectDetayGidisGunOptions[6] = {label: 'Pazar', title: 'Pazar', value: 'Pzr', selected: true};
                    } else {
                        SelectDetayGidisGunOptions[6] = {label: 'Pazar', title: 'Pazar', value: 'Pzr'};
                    }
                    $('#TurDetayGidisGun').multiselect('dataprovider', SelectDetayGidisGunOptions);
                    $('#TurDetayGidisGun').multiselect('refresh');
                    $('#TurDetayGidisGun').multiselect('disable');

                    //harita için
                    var kurumLocation = $('input[name=TurDetayGidisKurumLocation]').val();
                    var kurumAd = $('input[name=TurDetayGidisKurum]').val();
                    var kurumID = $('input[name=TurDetayGidisKurumID]').val();
                    var soforLocation = $('input[name=GidisSoforInput]').val();
                    var soforID = $('input[name=GidisSoforID]').val();
                    var soforAd = $('input[name=GidisSoforAd]').val();
                    //dizilerimizi boşaltıyoruz
                    DetailGidisGelenAd = [];
                    DetailGidisGelenID = [];
                    DetailGidisGelenLocation = [];
                    DetailGidisGelenTip = [];
                    DetailGidisDigerKisi = [];
                    for (var gidisID = 0; gidisID < cevap.gidis.KisiID.length; gidisID++) {
                        DetailGidisGelenAd.push(cevap.gidis.KisiAd[gidisID]);
                        DetailGidisGelenID.push(cevap.gidis.KisiID[gidisID]);
                        DetailGidisGelenLocation.push(cevap.gidis.KisiLocation[gidisID]);
                        DetailGidisGelenTip.push(cevap.gidis.KisiTip[gidisID]);
                    }
                    for (var gidisDigerID = 0; gidisDigerID < cevap.gidisDiger.length; gidisDigerID++) {
                        DetailGidisDigerKisi.push(cevap.gidisDiger[gidisDigerID]);
                    }

                    multipleKurumTurDetayMap(kurumAd, kurumID, kurumLocation, soforAd, soforID, soforLocation);
                    google.maps.event.addDomListener(window, 'load', multipleKurumTurDetayMap);
                }
            }
        });
        return true;
    },
    adminKurumTurDetailDuzenle: function () {
        //Tur İşlemleri Değerleri
        var turDetayAd = $('input[name=TurDetayGidisAd]').val();
        var turDetayAciklama = $('textarea[name=TurDetayGidisAciklama]').val();
        var aracID = $('select#TurDetayGidisArac option:selected').val();
        var aracText = $('select#TurDetayGidisArac option:selected').attr('label');
        var soforID = $('select#TurDetayGidisSofor option:selected').val();
        var soforText = $('select#TurDetayGidisSofor option:selected').attr('label');
        var saat1 = $('select#TurDetayGidisSaat1 option:selected').val();
        var saat1Text = $('select#TurDetayGidisSaat1 option:selected').attr('label');
        var saat2 = $('select#TurDetayGidisSaat2 option:selected').val();
        var saat2Text = $('select#TurDetayGidisSaat2 option:selected').attr('label');
        //Tur Gün
        var turGunVal = new Array();
        $('select#TurDetayGidisGun option:selected').each(function () {
            turGunVal.push($(this).val());
        });
        //Tru Gün text
        var turGunText = new Array();
        $('select#TurDetayGidisGun option:selected').each(function () {
            turGunText.push($(this).attr('label'));
        });
        turGidisDetailEdt = [];
        turGidisDetailEdt.push(turDetayAd, turDetayAciklama, aracID, aracText, soforID, soforText, saat1, saat1Text, saat2, saat2Text, turGunVal, turGunText, DetailGidisGelenID);
        //Gün ayarları
        if (turGunVal.indexOf('Pzt') != -1) {
            SelectDetayGidisGunOptions[0] = {label: 'Pazartesi', title: 'Pazartesi', value: 'Pzt', selected: true};
        } else {
            SelectDetayGidisGunOptions[0] = {label: 'Pazartesi', title: 'Pazartesi', value: 'Pzt'};
        }
        if (turGunVal.indexOf('Sli') != -1) {
            SelectDetayGidisGunOptions[1] = {label: 'Salı', title: 'Salı', value: 'Sli', selected: true};
        } else {
            SelectDetayGidisGunOptions[1] = {label: 'Salı', title: 'Salı', value: 'Sli'};
        }
        if (turGunVal.indexOf('Crs') != -1) {
            SelectDetayGidisGunOptions[2] = {label: 'Çarşamba', title: 'Çarşamba', value: 'Crs', selected: true};
        } else {
            SelectDetayGidisGunOptions[2] = {label: 'Çarşamba', title: 'Çarşamba', value: 'Crs'};
        }
        if (turGunVal.indexOf('Prs') != -1) {
            SelectDetayGidisGunOptions[3] = {label: 'Perşembe', title: 'Perşembe', value: 'Prs', selected: true};
        } else {
            SelectDetayGidisGunOptions[3] = {label: 'Perşembe', title: 'Perşembe', value: 'Prs'};
        }
        if (turGunVal.indexOf('Cma') != -1) {
            SelectDetayGidisGunOptions[4] = {label: 'Cuma', title: 'Cuma', value: 'Cma', selected: true};
        } else {
            SelectDetayGidisGunOptions[4] = {label: 'Cuma', title: 'Cuma', value: 'Cma'};
        }
        if (turGunVal.indexOf('Cmt') != -1) {
            SelectDetayGidisGunOptions[5] = {label: 'Cumartesi', title: 'Cumartesi', value: 'Cmt', selected: true};
        } else {
            SelectDetayGidisGunOptions[5] = {label: 'Cumartesi', title: 'Cumartesi', value: 'Cmt'};
        }
        if (turGunVal.indexOf('Pzr') != -1) {
            SelectDetayGidisGunOptions[6] = {label: 'Pazar', title: 'Pazar', value: 'Pzr', selected: true};
        } else {
            SelectDetayGidisGunOptions[6] = {label: 'Pazar', title: 'Pazar', value: 'Pzr'};
        }
        $('#TurDetayGidisGun').multiselect('dataprovider', SelectDetayGidisGunOptions);
        $('#TurDetayGidisGun').multiselect('refresh');
        $('#TurDetayGidisGun').multiselect('enable');
        $('#TurDetayGidisSaat1').multiselect('enable');
        $('#TurDetayGidisSaat2').multiselect('enable');
        $('#TurDetayGidisArac').multiselect('enable');
        $('#TurDetayGidisSofor').multiselect('enable');
        kayitDegerGidis = 1;
    },
    turKurumGidisDetailVazgec: function () {
        kayitDegerGidis = 0;
        //haritayı da eski haline geri getiriyorum
        //harita için
        var kurumLocation = $('input[name=TurDetayGidisKurumLocation]').val();
        var kurumAd = $('input[name=TurDetayGidisKurum]').val();
        var kurumID = $('input[name=TurDetayGidisKurumID]').val();
        var soforLocation = $('input[name=GidisSoforInput]').val();
        var soforID = $('input[name=GidisSoforID]').val();
        var soforAd = $('input[name=GidisSoforAd]').val();
        multipleKurumTurDetayMap(kurumAd, kurumID, kurumLocation, soforAd, soforID, soforLocation);
        google.maps.event.addDomListener(window, 'load', multipleKurumTurDetayMap);

        $('input[name=TurDetayGidisAd]').val(turGidisDetailEdt[0]);
        $('textarea[name=TurDetayGidisAciklama]').val(turGidisDetailEdt[1]);

        //Gün ayarları
        if (turGidisDetailEdt[10].indexOf('Pzt') != -1) {
            SelectDetayGidisGunOptions[0] = {label: 'Pazartesi', title: 'Pazartesi', value: 'Pzt', selected: true};
        } else {
            SelectDetayGidisGunOptions[0] = {label: 'Pazartesi', title: 'Pazartesi', value: 'Pzt'};
        }
        if (turGidisDetailEdt[10].indexOf('Sli') != -1) {
            SelectDetayGidisGunOptions[1] = {label: 'Salı', title: 'Salı', value: 'Sli', selected: true};
        } else {
            SelectDetayGidisGunOptions[1] = {label: 'Salı', title: 'Salı', value: 'Sli'};
        }
        if (turGidisDetailEdt[10].indexOf('Crs') != -1) {
            SelectDetayGidisGunOptions[2] = {label: 'Çarşamba', title: 'Çarşamba', value: 'Crs', selected: true};
        } else {
            SelectDetayGidisGunOptions[2] = {label: 'Çarşamba', title: 'Çarşamba', value: 'Crs'};
        }
        if (turGidisDetailEdt[10].indexOf('Prs') != -1) {
            SelectDetayGidisGunOptions[3] = {label: 'Perşembe', title: 'Perşembe', value: 'Prs', selected: true};
        } else {
            SelectDetayGidisGunOptions[3] = {label: 'Perşembe', title: 'Perşembe', value: 'Prs'};
        }
        if (turGidisDetailEdt[10].indexOf('Cma') != -1) {
            SelectDetayGidisGunOptions[4] = {label: 'Cuma', title: 'Cuma', value: 'Cma', selected: true};
        } else {
            SelectDetayGidisGunOptions[4] = {label: 'Cuma', title: 'Cuma', value: 'Cma'};
        }
        if (turGidisDetailEdt[10].indexOf('Cmt') != -1) {
            SelectDetayGidisGunOptions[5] = {label: 'Cumartesi', title: 'Cumartesi', value: 'Cmt', selected: true};
        } else {
            SelectDetayGidisGunOptions[5] = {label: 'Cumartesi', title: 'Cumartesi', value: 'Cmt'};
        }
        if (turGidisDetailEdt[10].indexOf('Pzr') != -1) {
            SelectDetayGidisGunOptions[6] = {label: 'Pazar', title: 'Pazar', value: 'Pzr', selected: true};
        } else {
            SelectDetayGidisGunOptions[6] = {label: 'Pazar', title: 'Pazar', value: 'Pzr'};
        }
        $('#TurDetayGidisGun').multiselect('dataprovider', SelectDetayGidisGunOptions);
        $('#TurDetayGidisGun').multiselect('refresh');
        $('#TurDetayGidisGun').multiselect('disable');
        //saat1
        var SelectSaat1Options = new Array();
        SelectSaat1Options[0] = {label: turGidisDetailEdt[7], value: turGidisDetailEdt[6], disabled: true};
        $('#TurDetayGidisSaat1').multiselect('dataprovider', SelectSaat1Options);
        $('#TurDetayGidisSaat1').multiselect('refresh');
        $('#TurDetayGidisSaat1').multiselect('disable');
        //saat2
        var SelectSaat2Options = new Array();
        SelectSaat2Options[0] = {label: turGidisDetailEdt[9], value: turGidisDetailEdt[8], disabled: true};
        $('#TurDetayGidisSaat2').multiselect('dataprovider', SelectSaat2Options);
        $('#TurDetayGidisSaat2').multiselect('refresh');
        $('#TurDetayGidisSaat2').multiselect('disable');
        //Araç
        var SelectAracOptions = new Array();
        SelectAracOptions[0] = {label: turGidisDetailEdt[3], value: turGidisDetailEdt[2], disabled: true};
        $('#TurDetayGidisArac').multiselect('dataprovider', SelectAracOptions);
        $('#TurDetayGidisArac').multiselect('refresh');
        $('#TurDetayGidisArac').multiselect('disable');
        //Şoför
        var SelectSoforOptions = new Array();
        SelectSoforOptions[0] = {label: turGidisDetailEdt[5], value: turGidisDetailEdt[4], disabled: true};
        $('#TurDetayGidisSofor').multiselect('dataprovider', SelectSoforOptions);
        $('#TurDetayGidisSofor').multiselect('refresh');
        $('#TurDetayGidisSofor').multiselect('disable');
    },
    turKurumGidisDetailKaydet: function () {
        //Tur Gidiş İşlemleri Değerleri
        var turGidisID = $('input[name=adminTurDetayGds]').val();
        var turDonusID = $('input[name=adminTurDetayDns]').val();
        var turID = $('input[name=adminTurID]').val();
        var turAdi = $('input[name=TurDetayGidisAd]').val();
        var turAciklama = $('textarea[name=TurDetayGidisAciklama]').val();
        var bolgeID = $('input[name=TurDetayGidisBolgeID]').val();
        var bolgead = $('input[name=TurDetayGidisBolge]').val();
        var kurumad = $('input[name=TurDetayGidisKurum]').val();
        var kurumId = $('input[name=TurDetayGidisKurumID]').val();
        var kurumLocation = $('input[name=TurDetayGidisKurumLocation]').val();
        var kurumTip = $('input[name=adminTurDetayTip]').val();
        var aracID = $('select#TurDetayGidisArac option:selected').val();
        var aracPlaka = $('select#TurDetayGidisArac option:selected').attr('label');
        var soforID = $('select#TurDetayGidisSofor option:selected').val();
        var soforAd = $('select#TurDetayGidisSofor option:selected').attr('label');
        var soforLocation = $('select#TurDetayGidisSofor option[value!="-1"]:selected').attr('location');
        var turSaat1 = $('select#TurDetayGidisSaat1 option:selected').val();
        var turSaat2 = $('select#TurDetayGidisSaat2 option:selected').val();
        var turKm = $("span#totalGidisKm").text();
        //Tur Gün
        var turGun = new Array();
        $('select#TurDetayGidisGun option:selected').each(function () {
            turGun.push($(this).val());
        });
        var farkturgun = farkArray(turGidisDetailEdt[10], turGun);
        var farkturgunlength = farkturgun.length;
        //haritada değişiklik var mı kontrolü
        var kisiID = new Array();
        var yeniID = new Array();
        yeniID = kisiID.concat(KisiOgrenciID, KisiIsciID);
        var farkturharita = farkArray(turGidisDetailEdt[12], yeniID);
        var farkharita = farkturharita.length;
        if (turGidisDetailEdt[0] == turAdi && turGidisDetailEdt[1] == turAciklama && turGidisDetailEdt[2] == aracID && turGidisDetailEdt[4] == soforID && turGidisDetailEdt[6] == turSaat1 && turGidisDetailEdt[8] == turSaat2 && farkturgunlength == 0 && farkharita == 0) {
            alert("Lütfen değişiklik yaptığınıza emin olun.");
        } else {
            var turSaat1ID = $('select#TurDetayGidisSaat1 option[value!="-1"]:selected').val();
            if (turSaat1ID) {
                var turSaat2ID = $('select#TurDetayGidisSaat2 option[value!="-1"]:selected').val();
                if (turSaat2ID) {
                    $.ajax({
                        data: {"turGidisID": turGidisID, "turDonusID": turDonusID, "turID": turID, "turAdi": turAdi, "bolgeID": bolgeID, "bolgead": bolgead, "kurumad": kurumad, "kurumId": kurumId,
                            "kurumTip": kurumTip, "kurumLocation": kurumLocation, "turGun[]": turGun, "turSaat1": turSaat1, "turSaat2": turSaat2,
                            "aracID": aracID, "aracPlaka": aracPlaka, "aracKapasite": turDetayGidisAracKapasite,
                            "soforID": soforID, "soforAd": soforAd, "soforLocation": soforLocation, "turAciklama": turAciklama, "turKm": turKm,
                            "turOgrenciID[]": KisiOgrenciID, "turOgrenciAd[]": KisiOgrenciAd, "turOgrenciLocation[]": KisiOgrenciLocation, "turOgrenciSira[]": KisiOgrenciSira, "turKisiIsciID[]": KisiIsciID,
                            "turKisiIsciAd[]": KisiIsciAd, "turKisiIsciLocation[]": KisiIsciLocation, "turKisiIsciSira[]": KisiIsciSira, "tip": "turGidisDKaydet"},
                        success: function (cevap) {
                            if (cevap.hata) {
                                alert(cevap.hata);
                            } else {
                                kayitDegerGidis = 1;
                                disabledForm();
                                $('input[name=adminTurDetayGds]').val(cevap.turGidisID);
                                $('#TurDetayGidisGun').multiselect('disable');
                                //saat1
                                $('#TurDetayGidisSaat1').multiselect('disable');
                                //saat2
                                $('#TurDetayGidisSaat2').multiselect('disable');
                                //Araç
                                $('#TurDetayGidisArac').multiselect('disable');
                                //Şoför
                                $('#TurDetayGidisSofor').multiselect('disable');

                                var length = $('table#adminKurumTurTable > tbody > tr').length;
                                for (var t = 0; t < length; t++) {
                                    var attrValueId = $("table#adminKurumTurTable > tbody > tr > td > a").eq(t).attr('value');
                                    if (attrValueId == turID) {
                                        $("table#adminKurumTurTable > tbody > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-refresh" style="color:red"></i> ' + turAdi);
                                        $("table#adminKurumTurTable > tbody > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(turAciklama);
                                        $('table#adminKurumTurTable > tbody > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                    }
                                }
                            }
                        }
                    });
                } else {
                    alert("Lütfen Saat2 Seçiniz");
                }
            } else {
                alert("Lütfen Saat1 Seçiniz");
            }
        }
    },
    kurumTurGidisDetailSil: function () {
        var turID = $('input[name=adminTurID]').val();
        var kurumTip = $('input[name=adminTurDetayTip]').val();
        $.ajax({
            data: {"turID": turID, "kurumTip": kurumTip, "tip": "turDetailDelete"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    disabledForm();

                    var kurumId = $('input[name=TurDetayGidisKurumID]').val();
                    var length = $('tbody#adminKurumRow tr').length;
                    for (var t = 0; t < length; t++) {
                        var attrValueId = $("tbody#adminKurumRow > tr > td > a").eq(t).attr('value');
                        if (attrValueId == kurumId) {
                            var turSayi = $("tbody#adminKurumRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text();
                            turSayi--;
                            $("tbody#adminKurumRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(turSayi);
                            $('tbody#adminKurumRow > tr:eq(' + t + ') > td:eq(0)').css({"background-color": "#F2F2F2"});
                        }
                    }

                    var length = $('table#adminKurumTurTable > tbody > tr').length;
                    for (var t = 0; t < length; t++) {
                        var attrValueId = $("table#adminKurumTurTable > tbody > tr > td > a").eq(t).attr('value');
                        if (attrValueId == turID) {
                            var deleteRow = $('table#adminKurumTurTable > tbody > tr:eq(' + t + ')');
                            KurumTurTable.DataTable().row($(deleteRow)).remove().draw();
                        }
                    }
                    //altta bulunan seçim pencerisini kapatma
                    svControl('svClose', 'turSecim', '');
                }
            }
        });
        return true;
    },
    adminKurumTurDetayDonus: function () {
        disabledForm();
        var donusTipID = $('input[name=adminTurDetayDns]').val();
        var turTip = $('input[name=adminTurDetayTip]').val();
        var kurumID = $('input[name=TurDetayDonusKurumID]').val();
        var turID = $('input[name=adminTurID]').val();
        $.ajax({
            data: {"turID": turID, "donusTipID": donusTipID, "turTip": turTip, "kurumID": kurumID, "tip": "adminTurDetayDonus"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    //Saat1
                    var SelectSaat1Options = new Array();
                    var saat1;
                    if (turDetayDonusSaat1.length > 0) {
                        if (turDetayDonusSaat1.length == 1) {
                            saat1 = '00:00'
                        } else if (turDetayDonusSaat1.length == 2) {
                            saat1 = '00:' + turDetayDonusSaat1;
                        } else if (turDetayDonusSaat1.length == 3) {
                            var ilkHarf1 = turDetayDonusSaat1.slice(0, 1);
                            var sondaikiHarf1 = turDetayDonusSaat1.slice(1, 3);
                            saat1 = '0' + ilkHarf1 + ':' + sondaikiHarf1;
                        } else {
                            var ilkikiHarf1 = turDetayDonusSaat1.slice(0, 2);
                            var sondaikiHarf1 = turDetayDonusSaat1.slice(2, 4);
                            saat1 = ilkikiHarf1 + ':' + sondaikiHarf1;
                        }
                        SelectSaat1Options[0] = {label: saat1, value: turDetayDonusSaat1, disabled: true};
                        $('#TurDetayDonusSaat1').multiselect('dataprovider', SelectSaat1Options);
                    }
                    $('#TurDetayDonusSaat1').multiselect('refresh');
                    $('#TurDetayDonusSaat1').multiselect('disable');
                    //Saat2
                    var SelectSaat2Options = new Array();
                    var saat2;
                    if (turDetayDonusSaat2.length > 0) {
                        if (turDetayDonusSaat2.length == 1) {
                            saat2 = '00:00'
                        } else if (turDetayDonusSaat2.length == 2) {
                            saat2 = '00:' + turDetayDonusSaat2;
                        } else if (turDetayDonusSaat2.length == 3) {
                            var ilkHarf2 = turDetayDonusSaat2.slice(0, 1);
                            var sondaikiHarf2 = turDetayDonusSaat2.slice(1, 3);
                            saat2 = '0' + ilkHarf2 + ':' + sondaikiHarf2;
                        } else {
                            var ilkikiHarf2 = turDetayDonusSaat2.slice(0, 2);
                            var sondaikiHarf2 = turDetayDonusSaat2.slice(2, 4);
                            saat2 = ilkikiHarf2 + ':' + sondaikiHarf2;
                        }
                        SelectSaat2Options[0] = {label: saat2, value: turDetayDonusSaat2, disabled: true};
                        $('#TurDetayDonusSaat2').multiselect('dataprovider', SelectSaat2Options);
                    }
                    $('#TurDetayDonusSaat2').multiselect('refresh');
                    $('#TurDetayDonusSaat2').multiselect('disable');
                    //Araç
                    if (turDetayDonusAracPlaka.length > 0) {
                        var SelectAracOptions = new Array();
                        SelectAracOptions[0] = {label: turDetayDonusAracPlaka, value: turDetayDonusAracID, disabled: true};
                        $('#TurDetayDonusArac').multiselect('dataprovider', SelectAracOptions);
                    }
                    $('#TurDetayDonusArac').multiselect('refresh');
                    $('#TurDetayDonusArac').multiselect('disable');
                    //Şoför
                    if (turDetayDonusSoforAd.length > 0) {
                        var SelectSoforOptions = new Array();
                        SelectSoforOptions[0] = {label: turDetayDonusSoforAd, value: turDetayDonusSoforID, disabled: true};
                        $('#TurDetayDonusSofor').multiselect('dataprovider', SelectSoforOptions);
                    }
                    $('#TurDetayDonusSofor').multiselect('refresh');
                    $('#TurDetayDonusSofor').multiselect('disable');
                    //Gunler

                    if (cevap.donus.Pzt != 0) {
                        SelectDetayDonusGunOptions[0] = {label: 'Pazartesi', title: 'Pazartesi', value: 'Pzt', selected: true};
                    } else {
                        SelectDetayDonusGunOptions[0] = {label: 'Pazartesi', title: 'Pazartesi', value: 'Pzt'};
                    }
                    if (cevap.donus.Sli != 0) {
                        SelectDetayDonusGunOptions[1] = {label: 'Salı', title: 'Salı', value: 'Sli', selected: true};
                    } else {
                        SelectDetayDonusGunOptions[1] = {label: 'Salı', title: 'Salı', value: 'Sli'};
                    }
                    if (cevap.donus.Crs != 0) {
                        SelectDetayDonusGunOptions[2] = {label: 'Çarşamba', title: 'Çarşamba', value: 'Crs', selected: true};
                    } else {
                        SelectDetayDonusGunOptions[2] = {label: 'Çarşamba', title: 'Çarşamba', value: 'Crs'};
                    }
                    if (cevap.donus.Prs != 0) {
                        SelectDetayDonusGunOptions[3] = {label: 'Perşembe', title: 'Perşembe', value: 'Prs', selected: true};
                    } else {
                        SelectDetayDonusGunOptions[3] = {label: 'Perşembe', title: 'Perşembe', value: 'Prs'};
                    }
                    if (cevap.donus.Cma != 0) {
                        SelectDetayDonusGunOptions[4] = {label: 'Cuma', title: 'Cuma', value: 'Cma', selected: true};
                    } else {
                        SelectDetayDonusGunOptions[4] = {label: 'Cuma', title: 'Cuma', value: 'Cma'};
                    }
                    if (cevap.donus.Cmt != 0) {
                        SelectDetayDonusGunOptions[5] = {label: 'Cumartesi', title: 'Cumartesi', value: 'Cmt', selected: true};
                    } else {
                        SelectDetayDonusGunOptions[5] = {label: 'Cumartesi', title: 'Cumartesi', value: 'Cmt'};
                    }
                    if (cevap.donus.Pzr != 0) {
                        SelectDetayDonusGunOptions[6] = {label: 'Pazar', title: 'Pazar', value: 'Pzr', selected: true};
                    } else {
                        SelectDetayDonusGunOptions[6] = {label: 'Pazar', title: 'Pazar', value: 'Pzr'};
                    }
                    $('#TurDetayDonusGun').multiselect('dataprovider', SelectDetayDonusGunOptions);
                    $('#TurDetayDonusGun').multiselect('refresh');
                    $('#TurDetayDonusGun').multiselect('disable');

                    //harita için
                    var kurumLocation = $('input[name=TurDetayDonusKurumLocation]').val();
                    var kurumAd = $('input[name=TurDetayDonusKurum]').val();
                    var kurumID = $('input[name=TurDetayDonusKurumID]').val();
                    var soforLocation = $('input[name=DonusSoforInput]').val();
                    var soforID = $('input[name=DonusSoforID]').val();
                    var soforAd = $('input[name=DonusSoforAd]').val();
                    //dizilerimizi boşaltıyoruz
                    DetailDonusGelenAd = [];
                    DetailDonusGelenID = [];
                    DetailDonusGelenLocation = [];
                    DetailDonusGelenTip = [];
                    DetailDonusDigerKisi = [];
                    for (var donusID = 0; donusID < cevap.donus.KisiID.length; donusID++) {
                        DetailDonusGelenAd.push(cevap.donus.KisiAd[donusID]);
                        DetailDonusGelenID.push(cevap.donus.KisiID[donusID]);
                        DetailDonusGelenLocation.push(cevap.donus.KisiLocation[donusID]);
                        DetailDonusGelenTip.push(cevap.donus.KisiTip[donusID]);
                    }
                    for (var donusDigerID = 0; donusDigerID < cevap.donusDiger.length; donusDigerID++) {
                        DetailDonusDigerKisi.push(cevap.donusDiger[donusDigerID]);
                    }

                    multipleKurumTurDetayDonusMap(kurumAd, kurumID, kurumLocation, soforAd, soforID, soforLocation);
                    google.maps.event.addDomListener(window, 'load', multipleKurumTurDetayDonusMap);
                }
            }
        });
        return true;
    },
    adminKurumTurDetailDuzenleDonus: function () {
        //Tur İşlemleri Değerleri
        var turDetayAd = $('input[name=TurDetayDonusAd]').val();
        var turDetayAciklama = $('textarea[name=TurDetayDonusAciklama]').val();
        var aracID = $('select#TurDetayDonusArac option:selected').val();
        var aracText = $('select#TurDetayDonusArac option:selected').attr('label');
        var soforID = $('select#TurDetayDonusSofor option:selected').val();
        var soforText = $('select#TurDetayDonusSofor option:selected').attr('label');
        var saat1 = $('select#TurDetayDonusSaat1 option:selected').val();
        var saat1Text = $('select#TurDetayDonusSaat1 option:selected').attr('label');
        var saat2 = $('select#TurDetayDonusSaat2 option:selected').val();
        var saat2Text = $('select#TurDetayDonusSaat2 option:selected').attr('label');
        //Tur Gün
        var turGunVal = new Array();
        $('select#TurDetayDonusGun option:selected').each(function () {
            turGunVal.push($(this).val());
        });
        //Tru Gün text
        var turGunText = new Array();
        $('select#TurDetayDonusGun option:selected').each(function () {
            turGunText.push($(this).attr('label'));
        });
        turDonusDetailEdt = [];
        turDonusDetailEdt.push(turDetayAd, turDetayAciklama, aracID, aracText, soforID, soforText, saat1, saat1Text, saat2, saat2Text, turGunVal, turGunText, DetailDonusGelenID);
        //Gün ayarları
        if (turGunVal.indexOf('Pzt') != -1) {
            SelectDetayDonusGunOptions[0] = {label: 'Pazartesi', title: 'Pazartesi', value: 'Pzt', selected: true};
        } else {
            SelectDetayDonusGunOptions[0] = {label: 'Pazartesi', title: 'Pazartesi', value: 'Pzt'};
        }
        if (turGunVal.indexOf('Sli') != -1) {
            SelectDetayDonusGunOptions[1] = {label: 'Salı', title: 'Salı', value: 'Sli', selected: true};
        } else {
            SelectDetayDonusGunOptions[1] = {label: 'Salı', title: 'Salı', value: 'Sli'};
        }
        if (turGunVal.indexOf('Crs') != -1) {
            SelectDetayDonusGunOptions[2] = {label: 'Çarşamba', title: 'Çarşamba', value: 'Crs', selected: true};
        } else {
            SelectDetayDonusGunOptions[2] = {label: 'Çarşamba', title: 'Çarşamba', value: 'Crs'};
        }
        if (turGunVal.indexOf('Prs') != -1) {
            SelectDetayDonusGunOptions[3] = {label: 'Perşembe', title: 'Perşembe', value: 'Prs', selected: true};
        } else {
            SelectDetayDonusGunOptions[3] = {label: 'Perşembe', title: 'Perşembe', value: 'Prs'};
        }
        if (turGunVal.indexOf('Cma') != -1) {
            SelectDetayDonusGunOptions[4] = {label: 'Cuma', title: 'Cuma', value: 'Cma', selected: true};
        } else {
            SelectDetayDonusGunOptions[4] = {label: 'Cuma', title: 'Cuma', value: 'Cma'};
        }
        if (turGunVal.indexOf('Cmt') != -1) {
            SelectDetayDonusGunOptions[5] = {label: 'Cumartesi', title: 'Cumartesi', value: 'Cmt', selected: true};
        } else {
            SelectDetayDonusGunOptions[5] = {label: 'Cumartesi', title: 'Cumartesi', value: 'Cmt'};
        }
        if (turGunVal.indexOf('Pzr') != -1) {
            SelectDetayDonusGunOptions[6] = {label: 'Pazar', title: 'Pazar', value: 'Pzr', selected: true};
        } else {
            SelectDetayDonusGunOptions[6] = {label: 'Pazar', title: 'Pazar', value: 'Pzr'};
        }
        $('#TurDetayDonusGun').multiselect('dataprovider', SelectDetayDonusGunOptions);
        $('#TurDetayDonusGun').multiselect('refresh');
        $('#TurDetayDonusGun').multiselect('enable');
        $('#TurDetayDonusSaat1').multiselect('enable');
        $('#TurDetayDonusSaat2').multiselect('enable');
        $('#TurDetayDonusArac').multiselect('enable');
        $('#TurDetayDonusSofor').multiselect('enable');
        kayitDegerDonus = 1;
    },
    turKurumDonusDetailVazgec: function () {
        kayitDegerDonus = 0;
        //haritayı da eski haline geri getiriyorum
        //harita için
        var kurumLocation = $('input[name=TurDetayDonusKurumLocation]').val();
        var kurumAd = $('input[name=TurDetayDonusKurum]').val();
        var kurumID = $('input[name=TurDetayDonusKurumID]').val();
        var soforLocation = $('input[name=DonusSoforInput]').val();
        var soforID = $('input[name=DonusSoforID]').val();
        var soforAd = $('input[name=DonusSoforAd]').val();
        multipleKurumTurDetayMap(kurumAd, kurumID, kurumLocation, soforAd, soforID, soforLocation);
        google.maps.event.addDomListener(window, 'load', multipleKurumTurDetayMap);

        $('input[name=TurDetayDonusAd]').val(turDonusDetailEdt[0]);
        $('textarea[name=TurDetayDonusAciklama]').val(turDonusDetailEdt[1]);

        //Gün ayarları
        if (turDonusDetailEdt[10].indexOf('Pzt') != -1) {
            SelectDetayDonusGunOptions[0] = {label: 'Pazartesi', title: 'Pazartesi', value: 'Pzt', selected: true};
        } else {
            SelectDetayDonusGunOptions[0] = {label: 'Pazartesi', title: 'Pazartesi', value: 'Pzt'};
        }
        if (turDonusDetailEdt[10].indexOf('Sli') != -1) {
            SelectDetayDonusGunOptions[1] = {label: 'Salı', title: 'Salı', value: 'Sli', selected: true};
        } else {
            SelectDetayDonusGunOptions[1] = {label: 'Salı', title: 'Salı', value: 'Sli'};
        }
        if (turDonusDetailEdt[10].indexOf('Crs') != -1) {
            SelectDetayDonusGunOptions[2] = {label: 'Çarşamba', title: 'Çarşamba', value: 'Crs', selected: true};
        } else {
            SelectDetayDonusGunOptions[2] = {label: 'Çarşamba', title: 'Çarşamba', value: 'Crs'};
        }
        if (turDonusDetailEdt[10].indexOf('Prs') != -1) {
            SelectDetayDonusGunOptions[3] = {label: 'Perşembe', title: 'Perşembe', value: 'Prs', selected: true};
        } else {
            SelectDetayDonusGunOptions[3] = {label: 'Perşembe', title: 'Perşembe', value: 'Prs'};
        }
        if (turDonusDetailEdt[10].indexOf('Cma') != -1) {
            SelectDetayDonusGunOptions[4] = {label: 'Cuma', title: 'Cuma', value: 'Cma', selected: true};
        } else {
            SelectDetayDonusGunOptions[4] = {label: 'Cuma', title: 'Cuma', value: 'Cma'};
        }
        if (turDonusDetailEdt[10].indexOf('Cmt') != -1) {
            SelectDetayDonusGunOptions[5] = {label: 'Cumartesi', title: 'Cumartesi', value: 'Cmt', selected: true};
        } else {
            SelectDetayDonusGunOptions[5] = {label: 'Cumartesi', title: 'Cumartesi', value: 'Cmt'};
        }
        if (turDonusDetailEdt[10].indexOf('Pzr') != -1) {
            SelectDetayDonusGunOptions[6] = {label: 'Pazar', title: 'Pazar', value: 'Pzr', selected: true};
        } else {
            SelectDetayDonusGunOptions[6] = {label: 'Pazar', title: 'Pazar', value: 'Pzr'};
        }
        $('#TurDetayDonusGun').multiselect('dataprovider', SelectDetayDonusGunOptions);
        $('#TurDetayDonusGun').multiselect('refresh');
        $('#TurDetayDonusGun').multiselect('disable');
        //saat1
        var SelectSaat1Options = new Array();
        SelectSaat1Options[0] = {label: turDonusDetailEdt[7], value: turDonusDetailEdt[6], disabled: true};
        $('#TurDetayDonusSaat1').multiselect('dataprovider', SelectSaat1Options);
        $('#TurDetayDonusSaat1').multiselect('refresh');
        $('#TurDetayDonusSaat1').multiselect('disable');
        //saat2
        var SelectSaat2Options = new Array();
        SelectSaat2Options[0] = {label: turDonusDetailEdt[9], value: turDonusDetailEdt[8], disabled: true};
        $('#TurDetayDonusSaat2').multiselect('dataprovider', SelectSaat2Options);
        $('#TurDetayDonusSaat2').multiselect('refresh');
        $('#TurDetayDonusSaat2').multiselect('disable');
        //Araç
        var SelectAracOptions = new Array();
        SelectAracOptions[0] = {label: turDonusDetailEdt[3], value: turDonusDetailEdt[2], disabled: true};
        $('#TurDetayDonusArac').multiselect('dataprovider', SelectAracOptions);
        $('#TurDetayDonusArac').multiselect('refresh');
        $('#TurDetayDonusArac').multiselect('disable');
        //Şoför
        var SelectSoforOptions = new Array();
        SelectSoforOptions[0] = {label: turDonusDetailEdt[5], value: turDonusDetailEdt[4], disabled: true};
        $('#TurDetayDonusSofor').multiselect('dataprovider', SelectSoforOptions);
        $('#TurDetayDonusSofor').multiselect('refresh');
        $('#TurDetayDonusSofor').multiselect('disable');
    },
    kurumTurDonusDetailSil: function () {
        var turID = $('input[name=adminTurID]').val();
        var kurumTip = $('input[name=adminTurDetayTip]').val();
        $.ajax({
            data: {"turID": turID, "kurumTip": kurumTip, "tip": "turDetailDelete"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    disabledForm();
                    var kurumId = $('input[name=TurDetayGidisKurumID]').val();
                    var length = $('tbody#adminKurumRow tr').length;
                    for (var t = 0; t < length; t++) {
                        var attrValueId = $("tbody#adminKurumRow > tr > td > a").eq(t).attr('value');
                        if (attrValueId == kurumId) {
                            var turSayi = $("tbody#adminKurumRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text();
                            turSayi--;
                            $("tbody#adminKurumRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(turSayi);
                            $('tbody#adminKurumRow > tr:eq(' + t + ') > td:eq(0)').css({"background-color": "#F2F2F2"});
                        }
                    }

                    var length = $('table#adminKurumTurTable > tbody > tr').length;
                    for (var t = 0; t < length; t++) {
                        var attrValueId = $("table#adminKurumTurTable > tbody > tr > td > a").eq(t).attr('value');
                        if (attrValueId == turID) {
                            var deleteRow = $('table#adminKurumTurTable > tbody > tr:eq(' + t + ')');
                            KurumTurTable.DataTable().row($(deleteRow)).remove().draw();
                        }
                    }
                    //altta bulunan seçim pencerisini kapatma
                    svControl('svClose', 'turSecim', '');
                }
            }
        });
        return true;
    },
    turKurumDonusDetailKaydet: function () {
        //Tur Gidiş İşlemleri Değerleri
        var turGidisID = $('input[name=adminTurDetayGds]').val();
        var turDonusID = $('input[name=adminTurDetayDns]').val();
        var turID = $('input[name=adminTurID]').val();
        var turAdi = $('input[name=TurDetayDonusAd]').val();
        var turAciklama = $('textarea[name=TurDetayDonusAciklama]').val();
        var bolgeID = $('input[name=TurDetayDonusBolgeID]').val();
        var bolgead = $('input[name=TurDetayDonusBolge]').val();
        var kurumad = $('input[name=TurDetayDonusKurum]').val();
        var kurumId = $('input[name=TurDetayDonusKurumID]').val();
        var kurumLocation = $('input[name=TurDetayDonusKurumLocation]').val();
        var kurumTip = $('input[name=adminTurDetayTip]').val();
        var aracID = $('select#TurDetayDonusArac option:selected').val();
        var aracPlaka = $('select#TurDetayDonusArac option:selected').attr('label');
        var soforID = $('select#TurDetayDonusSofor option:selected').val();
        var soforAd = $('select#TurDetayDonusSofor option:selected').attr('label');
        var soforLocation = $('select#TurDetayDonusSofor option[value!="-1"]:selected').attr('location');
        var turSaat1 = $('select#TurDetayDonusSaat1 option:selected').val();
        var turSaat2 = $('select#TurDetayDonusSaat2 option:selected').val();
        var turKm = $("span#totalDonusKm").text();
        //Tur Gün
        var turGun = new Array();
        $('select#TurDetayDonusGun option:selected').each(function () {
            turGun.push($(this).val());
        });
        var farkturgun = farkArray(turDonusDetailEdt[10], turGun);
        var farkturgunlength = farkturgun.length;
        //haritada değişiklik var mı kontrolü
        var kisiID = new Array();
        var yeniID = new Array();
        yeniID = kisiID.concat(KisiOgrenciID, KisiIsciID);
        var farkturharita = farkArray(turDonusDetailEdt[12], yeniID);
        var farkharita = farkturharita.length;
        console.log(turDonusDetailEdt);
        if (turDonusDetailEdt[0] == turAdi && turDonusDetailEdt[1] == turAciklama && turDonusDetailEdt[2] == aracID && turDonusDetailEdt[4] == soforID && turDonusDetailEdt[6] == turSaat1 && turDonusDetailEdt[8] == turSaat2 && farkturgunlength == 0 && farkharita == 0) {
            alert("Lütfen değişiklik yaptığınıza emin olun.");
        } else {
            var turSaat1ID = $('select#TurDetayDonusSaat1 option[value!="-1"]:selected').val();
            if (turSaat1ID) {
                var turSaat2ID = $('select#TurDetayDonusSaat2 option[value!="-1"]:selected').val();
                if (turSaat2ID) {
                    $.ajax({
                        data: {"turGidisID": turGidisID, "turDonusID": turDonusID, "turID": turID, "turAdi": turAdi, "bolgeID": bolgeID, "bolgead": bolgead, "kurumad": kurumad, "kurumId": kurumId,
                            "kurumTip": kurumTip, "kurumLocation": kurumLocation, "turGun[]": turGun, "turSaat1": turSaat1, "turSaat2": turSaat2,
                            "aracID": aracID, "aracPlaka": aracPlaka, "aracKapasite": turDetayGidisAracKapasite,
                            "soforID": soforID, "soforAd": soforAd, "soforLocation": soforLocation, "turAciklama": turAciklama, "turKm": turKm,
                            "turOgrenciID[]": KisiOgrenciID, "turOgrenciAd[]": KisiOgrenciAd, "turOgrenciLocation[]": KisiOgrenciLocation, "turOgrenciSira[]": KisiOgrenciSira, "turKisiIsciID[]": KisiIsciID,
                            "turKisiIsciAd[]": KisiIsciAd, "turKisiIsciLocation[]": KisiIsciLocation, "turKisiIsciSira[]": KisiIsciSira, "tip": "turDonusKaydet"},
                        success: function (cevap) {
                            if (cevap.hata) {
                                alert(cevap.hata);
                            } else {
                                kayitDegerDonus = 1;
                                disabledForm();
                                $('input[name=adminTurDetayDns]').val(cevap.turDonusID);
                                $('#TurDetayDonusGun').multiselect('disable');
                                //saat1
                                $('#TurDetayDonusSaat1').multiselect('disable');
                                //saat2
                                $('#TurDetayDonusSaat2').multiselect('disable');
                                //Araç
                                $('#TurDetayDonusArac').multiselect('disable');
                                //Şoför
                                $('#TurDetayDonusSofor').multiselect('disable');

                                var length = $('table#adminKurumTurTable > tbody > tr').length;
                                for (var t = 0; t < length; t++) {
                                    var attrValueId = $("table#adminKurumTurTable > tbody > tr > td > a").eq(t).attr('value');
                                    if (attrValueId == turID) {
                                        $("table#adminKurumTurTable > tbody > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-refresh" style="color:red"></i> ' + turAdi);
                                        $("table#adminKurumTurTable > tbody > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(turAciklama);
                                        $('table#adminKurumTurTable > tbody > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                    }
                                }
                            }
                        }
                    });
                } else {
                    alert("Lütfen Saat2 Seçiniz");
                }
            } else {
                alert("Lütfen Saat1 Seçiniz");
            }
        }
    }
}

