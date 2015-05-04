$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminTurAjaxSorgu",
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
$(document).ready(function () {

    TurTable = $('#adminTurTable').dataTable({
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
                    $("input[name=adminKurumDetailLocation]").val(cevap.adminKurumDetail['a465db00f313bd4781af6805a8d6fb31']);
                    if (cevap.adminKurumTurDetail) {
                        var KurumTurSayi = cevap.adminKurumTurDetail.length;
                        if (KurumTurSayi != 0) {
                            $("#KurumDetailDeleteBtn").hide();
                        } else {
                            $("#KurumDetailDeleteBtn").show();
                        }

                        var turCount = cevap.adminKurumTurDetail.length;
                        for (var i = 0; i < turCount; i++) {
                            if (cevap.adminKurumTurDetail[i].KurumTurTip != 1) {
                                TurTip = 'Öğrenci';
                            } else {
                                TurTip = 'İşçi';
                            }

                            if (cevap.adminKurumTurDetail[i].KurumTurAktiflik != 0) {
                                var addRow = "<tr><td>"
                                        + "<a class='svToggle' data-type='svOpen' data-islemler='adminKurumMultiMap' data-class='map' data-index='index' data-toggle='tooltip' data-placement='top' title='' value='" + cevap.adminKurumTurDetail[i].KurumTurID + "'>"
                                        + "<i class='fa fa-map-marker'></i> " + cevap.adminKurumTurDetail[i].KurumDetailTurAdi + "</a></td>"
                                        + "<td class='hidden-xs' >" + TurTip + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.adminKurumTurDetail[i].KurumTurAcikla + "</td></tr>";
                                KurumTurTable.DataTable().row.add($(addRow)).draw();
                            } else {
                                var addRow = "<tr><td>"
                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.adminKurumTurDetail[i].KurumTurID + "'>"
                                        + "<i class='fa fa-map-marker' style='color:red'></i> " + cevap.adminKurumTurDetail[i].KurumDetailTurAdi + "</a></td>"
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
    //tur bölge select change
    $('#TurSelectBolge').on('change', function () {
        var turBolgeID = $('select#TurSelectBolge option[value!="0"]:selected').val();
        if (turBolgeID) {
            var SelectKurumOptions = new Array();
            $.ajax({
                data: {"turBolgeID": turBolgeID, "tip": "turKurumSelect"},
                success: function (cevap) {
                    if (cevap.hata) {
                        alert(cevap.hata);
                    } else {
                        if (cevap.kurumSelect) {
                            var kurumlength = cevap.kurumSelect.KurumSelectID.length;
                            SelectKurumOptions[0] = {label: 'Seçiniz', title: 'Seçiniz', value: '-1'};
                            for (var b = 0; b < kurumlength; b++) {
                                SelectKurumOptions[b + 1] = {label: cevap.kurumSelect.KurumSelectAd[b], title: cevap.kurumSelect.KurumSelectAd[b], id: cevap.kurumSelect.KurumSelectTip[b], location: cevap.kurumSelect.KurumSelectLokasyon[b], value: cevap.kurumSelect.KurumSelectID[b]};
                            }
                        }
                        $('#TurSelectKurum').multiselect('refresh');
                        $('#TurSelectKurum').multiselect('dataprovider', SelectKurumOptions);
                    }
                }
            });
        }
        $('#TurSelectKurum').multiselect('refresh');
        $('#TurSelectKurum').multiselect('dataprovider', SelectKurumOptions);
    });
    //tur araç focus
    $('#TurArac').multiselect({
        onDropdownShow: function (event) {
            var turBolgeID = $('select#TurSelectBolge option[value!="0"]:selected').val();
            if (turBolgeID) {
                var turKurumID = $('select#TurSelectKurum option[value!="-1"]:selected').val();
                if (turKurumID) {
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
                                                    SelectAracOptions[i] = {label: cevap.pasifArac[i].turAracPlaka, title: cevap.pasifArac[i].turAracPlaka, value: cevap.pasifArac[i].turAracID, kapasite: cevap.pasifArac[i].turAracKapasite};
                                                }
                                                $('#TurArac').multiselect('refresh');
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
                } else {
                    alert("Lütfen Kurum Seçiniz");
                }
            } else {
                alert("Lütfen Bölge Seçiniz");
            }
        }
    });
    //tur kurum focus
    $('#TurSelectKurum').multiselect({
        onDropdownShow: function (event) {
            var turBolgeID = $('select#TurSelectBolge option[value!="0"]:selected').val();
            if (!turBolgeID) {
                alert("Lütfen Bölge Seçiniz");
            }
        },
        onChange: function (option, checked, select) {
            var turKurumID = $('select#TurSelectKurum option[value!="-1"]:selected').val();
            var turKurumTip = $('select#TurSelectKurum option[value!="-1"]:selected').attr('id');
            if (turKurumID) {
                $.ajax({
                    data: {"turKurumID": turKurumID, "turKurumTip": turKurumTip, "tip": "turKurumSelectKisi"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            alert(cevap.hata);
                        } else {
                            MultipleMapArray = [];
                            var kurumLocation = $('select#TurSelectKurum option[value!="-1"]:selected').attr('location');
                            var kurumName = $('select#TurSelectKurum option[value!="-1"]:selected').attr('title');
                            var LocationKurumBolme = kurumLocation.split(",");
                            MultipleMapArray[0] = Array(kurumName, LocationKurumBolme[0], LocationKurumBolme[1]);
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

                            isMap = true;
                            isSingle = false;
                            multipleTurMapping(MultipleMapArray, MultipleMapindex, ayiriciIndex, sofor);
                            google.maps.event.addDomListener(window, 'load', multipleTurMapping);
                        }
                    }
                });
            }
        }
    });
    //tur şoför focus
    $('#TurSofor').multiselect({
        onDropdownShow: function (event) {
            var turBolgeID = $('select#TurSelectBolge option[value!="0"]:selected').val();
            if (turBolgeID) {
                var turKurumID = $('select#TurSelectKurum option[value!="-1"]:selected').val();
                if (turKurumID) {
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
                                    $.ajax({
                                        data: {"turBolgeID": turBolgeID, "turKurumID": turKurumID, "turGunID[]": turGunID, "turSaat1ID": turSaat1ID, "turSaat2ID": turSaat2ID, "aracID": aracID, "tip": "turSoforSelect"},
                                        success: function (cevap) {
                                            if (cevap.hata) {
                                                alert(cevap.hata);
                                            } else {
                                                var SelectSoforOptions = new Array();
                                                if (cevap.pasifSofor) {
                                                    var length = cevap.pasifSofor.length;
                                                    for (var i = 0; i < length; i++) {
                                                        SelectSoforOptions[i] = {label: cevap.pasifSofor[i].turSoforAd + ' ' + cevap.pasifSofor[i].turSoforSoyad, title: cevap.pasifSofor[i].turSoforAd + ' ' + cevap.pasifSofor[i].turSoforSoyad, location: cevap.pasifSofor[i].turSoforLocation, value: cevap.pasifSofor[i].turSoforID};
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
                } else {
                    alert("Lütfen Kurum Seçiniz");
                }
            } else {
                alert("Lütfen Bölge Seçiniz");
            }
        },
        onChange: function (option, checked, select) {
            if (kayitDeger == 0) {
                var soforLocation = $('select#TurSofor option[value!="-1"]:selected').attr('location');
                if (soforLocation) {
                    var diziIndex = MultipleMapArray.length;
                    sofor = 1;
                    var soforName = $('select#TurSofor option[value!="-1"]:selected').attr('title');
                    var soforID = $('select#TurSofor option[value!="-1"]:selected').attr('value');
                    var LocationSoforBolme = soforLocation.split(",");
                    MultipleMapArray[diziIndex] = Array(soforName, LocationSoforBolme[0], LocationSoforBolme[1], soforID);
                    isMap = true;
                    isSingle = false;
                    multipleTurMapping(MultipleMapArray, MultipleMapindex, ayiriciIndex, sofor);
                    google.maps.event.addDomListener(window, 'load', multipleTurMapping);
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
});
$.AdminIslemler = {
    adminTurYeni: function () {
        $("input[name=TurAdi]").val(' ');
        $("textarea[name=Aciklama]").val(' ');
        var SelectAracOptions = new Array();
        var SelectSaat1Options = new Array();
        var SelectSaat2Options = new Array();
        var SelectSoforOptions = new Array();
        $('#TurArac').multiselect('dataprovider', SelectAracOptions);
        $('#TurSaat1').multiselect('dataprovider', SelectSaat1Options);
        $('#TurSaat2').multiselect('dataprovider', SelectSaat2Options);
        $('#TurSofor').multiselect('dataprovider', SelectSoforOptions);
        $.ajax({
            data: {"tip": "turBolgeEkleSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    if (cevap.adminTurBolgee) {
                        var length = cevap.adminTurBolgee.length;
                        for (var i = 0; i < length; i++) {
                            $("#TurSelectBolge").append('<option value="' + cevap.adminTurBolgee[i] + '">' + cevap.adminTurBolge[i] + '</option>');
                        }
                    }
                    $('#TurSelectGun').multiselect('refresh');
                    $('#TurSelectTip').multiselect('refresh');
                    $('#TurSaat1').multiselect();
                    $('#TurSaat2').multiselect();
                    $('#TurSelectBolge').multiselect();
                    $('#TurSelectKurum').multiselect();
                    $('#TurArac').multiselect('refresh');
                    $('#TurSofor').multiselect('refresh');
                    var selectLength = $('#TurSelectBolge > option').length;
                    if (!selectLength) {
                        alert("Lütfen Öncelikle Bölge İşlemlerine Gidip Yeni Bölge Oluşturunuz");
                    }
                }
            }
        });
        return true;
    },
    adminTurKaydet: function () {
        if (locations.length < 2) {
            alert("Lütfen Turlarınızı Oluşturunuz");
        } else {
            var turGidis = $("input[name=TurGidis]").val();
            var turDonus = $("input[name=TurDonus]").val();
            var turID = $("input[name=TurID]").val();
            if (turGidis == '' || turDonus == '') {
                var turAdi = $("input[name=TurAdi]").val();
                if (turAdi) {
                    var bolgeID = $('select#TurSelectBolge option[value!="0"]:selected').val();
                    if (bolgeID) {
                        var bolgead = $("#TurSelectBolge option:selected").text();
                        var kurumId = $('select#TurSelectKurum option[value!="-1"]:selected').val();
                        if (kurumId) {
                            var kurumad = $("#TurSelectKurum option:selected").attr('label');
                            var kurumTip = $('#TurSelectKurum option:selected').attr('id');
                            var kurumLocation = $('#TurSelectKurum option:selected').attr('location');
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
                                            var soforID = $('select#TurSofor option:selected').val();
                                            if (soforID) {
                                                var soforAd = $("select#TurSofor option:selected").attr('label');
                                                var turTip = $("select#TurSelectTip option:selected").val();
                                                var turAciklama = $("textarea[name=Aciklama]").val();
                                                $.ajax({
                                                    data: {"turID": turID, "turAdi": turAdi, "bolgeID": bolgeID, "bolgead": bolgead, "kurumad": kurumad, "kurumId": kurumId,
                                                        "kurumTip": kurumTip, "kurumLocation": kurumLocation, "turGun[]": turGun, "turSaat1": turSaat1, "turSaat2": turSaat2,
                                                        "aracID": aracID, "aracPlaka": aracPlaka, "turGidis": turGidis, "turDonus": turDonus,
                                                        "soforID": soforID, "soforAd": soforAd, "turTip": turTip, "turAciklama": turAciklama,
                                                        "turOgrenciID[]": KisiOgrenciID, "turOgrenciAd[]": KisiOgrenciAd, "turOgrenciLocation[]": KisiOgrenciLocation, "turKisiIsciID[]": KisiIsciID,
                                                        "turKisiIsciAd[]": KisiIsciAd, "turKisiIsciLocation[]": KisiIsciLocation, "tip": "turKaydet"},
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
                                                                var turTurutipi;
                                                                if (kurumTip == 0) {
                                                                    turTurutipi = 'Öğrenci';
                                                                } else if (kurumTip == 1) {
                                                                    turTurutipi = 'İşçi';
                                                                } else {
                                                                    turTurutipi = 'Öğrenci/Personel';
                                                                }
                                                                var turCount = $('#smallTur').text();
                                                                turCount++;
                                                                $('#smallTur').text(turCount);
                                                                var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.turID + "'>"
                                                                        + "<i class='glyphicon glyphicon-refresh' style='color:red;'></i> " + turAdi + "</a></td>"
                                                                        + "<td class='hidden-xs'>" + bolgead + "</td>"
                                                                        + "<td class='hidden-xs'>" + kurumad + "</td>"
                                                                        + "<td class='hidden-xs'>" + turTurutipi + "</td>"
                                                                        + "<td class='hidden-xs'>" + turAciklama + "</td>";
                                                                TurTable.DataTable().row.add($(addRow)).draw();
                                                                svControl('svClose', 'tur', '');
                                                            } else {
                                                                //işlemlerde eksik varsa kalıyor sayfa
                                                                disabledForm();
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
    adminTurVazgec: function () {
        return true;
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
    }
}


