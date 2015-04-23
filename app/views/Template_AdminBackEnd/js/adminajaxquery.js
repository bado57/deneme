$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminAjaxSorgu",
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

    newBolgeTable = $('#adminBolgeTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    NewKurumTable = $('#adminKurumTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    KurumTable = $('#adminBolgeKurumTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    NewAracTable = $('#adminAracTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    KurumTurTable = $('#adminKurumTurTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    AracTurTable = $('#adminAracTurTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    AdminTable = $('#adminTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    SoforTable = $('#soforTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    //bölge işlemleri
    $(document).on('click', 'tbody#adminBolgeRow > tr > td > a', function (e) {
        var i = $(this).find("i")
        i.removeClass("fa-search");
        i.addClass("fa-spinner fa-spin");
        var adminbolgeRowid = $(this).attr('value');
        KurumTable.DataTable().clear().draw();
        $.ajax({
            data: {"adminbolgeRowid": adminbolgeRowid, "tip": "adminBolgeDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    $("input[name=BolgeDetailAdi]").val(cevap.adminBolgeDetail['5dff8e4f44d1afe5716832b74770e3fe']);
                    $("textarea[name=BolgeDetailAciklama]").val(cevap.adminBolgeDetail['5d7991851fff325b2e913c1093f8c7bb']);
                    $("input[name=adminBolgeDetailID]").val(cevap.adminBolgeDetail['95d1cff7e918f5edec2758321aeca910']);
                    if (cevap.adminBolgeKurumDetail == null) {
                        $("#BolgeDetailDeleteBtn").show();
                    } else {
                        var bolgeKurumSayi = cevap.adminBolgeKurumDetail.length;
                        if (bolgeKurumSayi != 0) {
                            $("#BolgeDetailDeleteBtn").hide();
                        } else {
                            $("#BolgeDetailDeleteBtn").show();
                        }
                        for (var kurum = 0; kurum < bolgeKurumSayi; kurum++) {
                            var addRow = "<tr><td>"
                                    + "<a class='svToggle' data-type='svOpen' data-islemler='adminBolgeMultiMap' data-class='map' data-index='index' data-value=" + cevap.adminBolgeKurumDetail[kurum][2] + " data-islemler='adminBolgeMultiMap' role='button' data-toggle='tooltip' data-placement='top' title='' value='" + cevap.adminBolgeKurumDetail[kurum][1] + "'>"
                                    + "<i class='fa fa-map-marker'></i>    " + cevap.adminBolgeKurumDetail[kurum][0] + "</a><i></i></td></tr>";
                            KurumTable.DataTable().row.add($(addRow)).draw();
                        }
                    }
                    svControl('svAdd', 'bolgeDetay', '');
                    i.removeClass("fa-spinner fa-spin");
                    i.addClass("fa-search");
                }
            }
        })
    });
    //kurum işlemleri
    $(document).on('click', 'tbody#adminKurumRow > tr > td > a', function (e) {
        var i = $(this).find("i");
        i.removeClass("fa-search");
        i.addClass("fa-spinner fa-spin");
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
                    console.log(cevap.adminKurumTurDetail);
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
                    i.removeClass("fa-spinner fa-spin");
                    i.addClass("fa-search");
                }
            }
        });
    });
    //araç işlemleri
    $(document).on('click', 'tbody#adminAracRow > tr > td > a', function (e) {
        var i = $(this).find("i");
        i.removeClass("fa-bus");
        i.addClass("fa-spinner fa-spin");
        var adminaracRowid = $(this).attr('value');
        $.ajax({
            data: {"adminaracRowid": adminaracRowid, "tip": "adminAracDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {

                    if (cevap.adminAracTur) {
                        var turCount = cevap.adminAracTur.length;
                        if (turCount > 0) {
                            $("#AracDetailDeleteBtn").hide();
                            var aktifTur = 0;
                            for (var s = 0; s < turCount; s++) {
                                if (cevap.adminAracTur[s].SelectAracTur != 0) {
                                    aktifTur++;
                                }
                            }
                            if (aktifTur != 0) {
                                if ($("#AracAktifTur").hasClass("btn-danger")) {
                                    $("#AracAktifTur").prop("disabled", false).removeClass("btn-danger").addClass("btn-success");
                                }
                            } else {
                                if ($("#AracAktifTur").hasClass("btn-success")) {
                                    $("#AracAktifTur").prop("disabled", true).removeClass("btn-success").addClass("btn-danger");
                                }
                            }
                        } else {
                            if ($("#AracAktifTur").hasClass("btn-success")) {
                                $("#AracAktifTur").prop("disabled", true).removeClass("btn-success").addClass("btn-danger");
                            }
                            $("#AracDetailDeleteBtn").show();
                        }
                    } else {
                        if ($("#AracAktifTur").hasClass("btn-success")) {
                            $("#AracAktifTur").prop("disabled", true).removeClass("btn-success").addClass("btn-danger");
                        }
                        $("#AracDetailDeleteBtn").show();
                    }

                    $("input[name=AracDetayPlaka]").val(cevap.adminAracOzellik[0].AdminAracPlaka);
                    $("input[name=AracDetayMarka]").val(cevap.adminAracOzellik[0].AdminAracMarka);
                    $("input[name=AracDetayModelYil]").val(cevap.adminAracOzellik[0].AdminAracYil);
                    $("input[name=AracDetayKapasite]").val(cevap.adminAracOzellik[0].AdminAracKapasite);
                    $("input[name=adminAracDetailDeger]").val(cevap.adminAracOzellik[0].AdminAracID);
                    $("input[name=AracDetayKm]").val(cevap.adminAracOzellik[0].AdminAracKm);
                    $("textarea[name=AracDetayAciklama]").val(cevap.adminAracOzellik[0].AdminAracAciklama);
                    $('select#AracDetayDurum').val(cevap.adminAracOzellik[0].AdminAracDurum);
                    var SelectBolgeOptions = new Array();
                    var SelectAracOptions = new Array();
                    if (cevap.adminAracSelectBolge) {
                        var bolgelength = cevap.adminAracSelectBolge.length;
                        for (var b = 0; b < bolgelength; b++) {
                            SelectBolgeOptions[b] = {label: cevap.adminAracSelectBolge[b].SelectAracBolgeAdi, title: cevap.adminAracSelectBolge[b].SelectAracBolgeAdi, value: cevap.adminAracSelectBolge[b].SelectAracBolgeID, selected: true, disabled: true};
                        }

                        if (cevap.adminAracBolge) {
                            var aracBolgeLength = cevap.adminAracBolge.length;
                            for (var z = 0; z < aracBolgeLength; z++) {
                                SelectBolgeOptions[b] = {label: cevap.adminAracBolge[z].DigerAracBolgeAdi, title: cevap.adminAracBolge[z].DigerAracBolgeAdi, value: cevap.adminAracBolge[z].DigerAracBolgeID, disabled: true};
                                b++;
                            }

                        }
                    } else {
                        if (cevap.adminAracBolge) {
                            var aracBolgeLength = cevap.adminAracBolge.length;
                            for (var b = 0; b < aracBolgeLength; b++) {
                                SelectBolgeOptions[b] = {label: cevap.adminAracBolge[b].DigerAracBolgeAdi, title: cevap.adminAracBolge[b].DigerAracBolgeAdi, value: cevap.adminAracBolge[b].DigerAracBolgeID, disabled: true};
                            }
                        }
                    }


                    if (cevap.adminAracSelectSofor) {
                        var soforselectlength = cevap.adminAracSelectSofor.length;
                        for (var t = 0; t < soforselectlength; t++) {
                            SelectAracOptions[t] = {label: cevap.adminAracSelectSofor[t].SelectAracSoforAdi, title: cevap.adminAracSelectSofor[t].SelectAracSoforAdi, value: cevap.adminAracSelectSofor[t].SelectAracSoforID, selected: true, disabled: true};
                        }
                        if (cevap.adminAracSofor) {
                            var soforlength = cevap.adminAracSofor.length;
                            for (var f = 0; f < soforlength; f++) {
                                SelectAracOptions[t] = {label: cevap.adminAracSofor[f].DigerAracSoforAdi, title: cevap.adminAracSofor[f].DigerAracSoforAdi, value: cevap.adminAracSofor[f].DigerAracSoforID, disabled: true};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.adminAracSofor) {
                            var soforlength = cevap.adminAracSofor.length;
                            for (var t = 0; t < soforlength; t++) {
                                SelectAracOptions[t] = {label: cevap.adminAracSofor[t].DigerAracSoforAdi, title: cevap.adminAracSofor[t].DigerAracSoforAdi, value: cevap.adminAracSofor[t].DigerAracSoforID, disabled: true};
                            }
                        }
                    }

                    $('#AracDetayBolgeSelect').multiselect('refresh');
                    $('#AracDetaySurucu').multiselect('refresh');
                    $('#AracDetayBolgeSelect').multiselect('dataprovider', SelectBolgeOptions);
                    $('#AracDetaySurucu').multiselect('dataprovider', SelectAracOptions);
                    svControl('svAdd', 'aracDetay', '');
                    i.removeClass("fa-spinner fa-spin");
                    i.addClass("fa fa-bus");
                }
            }
        });
    });
    //admin işlemleri
    $(document).on('click', 'tbody#adminRow > tr > td > a', function (e) {
        var i = $(this).find("i");
        i.removeClass("glyphicon glyphicon-user");
        i.addClass("fa-spinner fa-spin");
        var adminRowid = $(this).attr('value');
        $.ajax({
            data: {"adminRowid": adminRowid, "tip": "adminDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    $("input[name=AdminDetayAdi]").val(cevap.adminDetail[0].AdminListAd);
                    $("input[name=AdminDetaySoyadi]").val(cevap.adminDetail[0].AdminListSoyad);
                    $("#AdminDetayDurum").val(cevap.adminDetail[0].AdminListDurum);
                    $("input[name=KurumLokasyon]").val(cevap.adminDetail[0].AdminListLokasyon);
                    $("input[name=AdminDetayTelefon]").val(cevap.adminDetail[0].AdminListTelefon);
                    $("input[name=AdminDetayEmail]").val(cevap.adminDetail[0].AdminListMail);
                    $("textarea[name=AdminDetayAdresDetay]").val(cevap.adminDetail[0].AdminListAdres);
                    $("textarea[name=DetayAciklama]").val(cevap.adminDetail[0].AdminListAciklama);
                    $("input[name=country]").val(cevap.adminDetail[0].AdminListUlke);
                    $("input[name=administrative_area_level_1]").val(cevap.adminDetail[0].AdminListIl);
                    $("input[name=administrative_area_level_2]").val(cevap.adminDetail[0].AdminListIlce);
                    $("input[name=locality]").val(cevap.adminDetail[0].AdminListSemt);
                    $("input[name=neighborhood]").val(cevap.adminDetail[0].AdminListMahalle);
                    $("input[name=route]").val(cevap.adminDetail[0].AdminListSokak);
                    $("input[name=postal_code]").val(cevap.adminDetail[0].AdminListPostaKodu);
                    $("input[name=street_number]").val(cevap.adminDetail[0].AdminListCaddeNo);
                    $("input[name=adminDetayID]").val(cevap.adminDetail[0].AdminListID);
                    var SelectBolgeOptions = new Array();
                    if (cevap.adminBolge) {
                        var bolgelength = cevap.adminBolge.length;
                        for (var b = 0; b < bolgelength; b++) {
                            SelectBolgeOptions[b] = {label: cevap.adminBolge[b].AdminBolge, title: cevap.adminBolge[b].AdminBolge, value: cevap.adminBolge[b].AdminBolgeID, selected: true, disabled: true};
                        }


                        if (cevap.adminNoBolge) {
                            var adminBolgeLength = cevap.adminNoBolge.length;
                            for (var z = 0; z < adminBolgeLength; z++) {
                                SelectBolgeOptions[b] = {label: cevap.adminNoBolge[z].AdminBolge, title: cevap.adminNoBolge[z].AdminBolge, value: cevap.adminNoBolge[z].AdminBolgeID, disabled: true};
                                b++;
                            }
                        }
                    } else {
                        if (cevap.adminNoBolge) {
                            var adminBolgeLength = cevap.adminNoBolge.length;
                            for (var b = 0; b < adminBolgeLength; b++) {
                                SelectBolgeOptions[b] = {label: cevap.adminNoBolge[b].AdminBolge, title: cevap.adminNoBolge[b].AdminBolge, value: cevap.adminNoBolge[b].AdminBolgeID, disabled: true};
                            }
                        }
                    }


                    $('#AdminDetaySelectBolge').multiselect('refresh');
                    $('#AdminDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
                    svControl('svAdd', 'adminDetay', '');
                    i.removeClass("fa-spinner fa-spin");
                    i.addClass("glyphicon glyphicon-user");
                }
            }
        });
    });
    //Şoför işlemleri
    $(document).on('click', 'tbody#soforRow > tr > td > a', function (e) {
        var i = $(this).find("i");
        i.removeClass("glyphicon glyphicon-user");
        i.addClass("fa-spinner fa-spin");
        var soforRowid = $(this).attr('value');
        $.ajax({
            data: {"soforRowid": soforRowid, "tip": "soforDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {

                    $("input[name=SoforDetayAdi]").val(cevap.soforDetail[0].SoforListAd);
                    $("input[name=SoforDetaySoyadi]").val(cevap.soforDetail[0].SoforListSoyad);
                    $("#SoforDetayDurum").val(cevap.soforDetail[0].SoforListDurum);
                    $("input[name=KurumLokasyon]").val(cevap.soforDetail[0].SoforListLokasyon);
                    $("input[name=SoforDetayTelefon]").val(cevap.soforDetail[0].SoforListTelefon);
                    $("input[name=SoforDetayEmail]").val(cevap.soforDetail[0].SoforListMail);
                    $("textarea[name=SoforDetayAdresDetay]").val(cevap.soforDetail[0].SoforListAdres);
                    $("textarea[name=DetayAciklama]").val(cevap.soforDetail[0].SoforListAciklama);
                    $("input[name=country]").val(cevap.soforDetail[0].SoforListUlke);
                    $("input[name=administrative_area_level_1]").val(cevap.soforDetail[0].SoforListIl);
                    $("input[name=administrative_area_level_2]").val(cevap.soforDetail[0].SoforListIlce);
                    $("input[name=locality]").val(cevap.soforDetail[0].SoforListSemt);
                    $("input[name=neighborhood]").val(cevap.soforDetail[0].SoforListMahalle);
                    $("input[name=route]").val(cevap.soforDetail[0].SoforListSokak);
                    $("input[name=postal_code]").val(cevap.soforDetail[0].SoforListPostaKodu);
                    $("input[name=street_number]").val(cevap.soforDetail[0].SoforListCaddeNo);
                    $("input[name=soforDetayID]").val(cevap.soforDetail[0].SoforListID);
                    var SelectBolgeOptions = new Array();
                    var SelectSoforOptions = new Array();
                    if (cevap.soforSelectBolge) {
                        var bolgelength = cevap.soforSelectBolge.length;
                        for (var b = 0; b < bolgelength; b++) {
                            SelectBolgeOptions[b] = {label: cevap.soforSelectBolge[b].SelectSoforBolgeAdi, title: cevap.soforSelectBolge[b].SelectSoforBolgeAdi, value: cevap.soforSelectBolge[b].SelectSoforBolgeID, selected: true, disabled: true};
                        }

                        if (cevap.soforBolge) {
                            var soforBolgeLength = cevap.soforBolge.length;
                            for (var z = 0; z < soforBolgeLength; z++) {
                                SelectBolgeOptions[b] = {label: cevap.soforBolge[z].DigerSoforBolgeAdi, title: cevap.soforBolge[z].DigerSoforBolgeAdi, value: cevap.soforBolge[z].DigerSoforBolgeID, disabled: true};
                                b++;
                            }

                        }
                    } else {
                        if (cevap.soforBolge) {
                            var soforBolgeLength = cevap.soforBolge.length;
                            for (var b = 0; b < soforBolgeLength; b++) {
                                SelectBolgeOptions[b] = {label: cevap.soforBolge[b].DigerSoforBolgeAdi, title: cevap.soforBolge[b].DigerSoforBolgeAdi, value: cevap.soforBolge[b].DigerSoforBolgeID, disabled: true};
                            }
                        }
                    }


                    if (cevap.soforSelectArac) {
                        var aracselectlength = cevap.soforSelectArac.length;
                        for (var t = 0; t < aracselectlength; t++) {
                            SelectSoforOptions[t] = {label: cevap.soforSelectArac[t].SelectSoforAracPlaka, title: cevap.soforSelectArac[t].SelectSoforAracPlaka, value: cevap.soforSelectArac[t].SelectSoforAracID, selected: true, disabled: true};
                        }
                        if (cevap.soforArac) {
                            var soforlength = cevap.soforArac.length;
                            for (var f = 0; f < soforlength; f++) {
                                SelectSoforOptions[t] = {label: cevap.soforArac[f].DigerSoforAracPlaka, title: cevap.soforArac[f].DigerSoforAracPlaka, value: cevap.soforArac[f].DigerSoforAracID, disabled: true};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.soforArac) {
                            var soforlength = cevap.soforArac.length;
                            for (var t = 0; t < soforlength; t++) {
                                SelectSoforOptions[t] = {label: cevap.soforArac[t].DigerSoforAracPlaka, title: cevap.soforArac[t].DigerSoforAracPlaka, value: cevap.soforArac[t].DigerSoforAracID, disabled: true};
                            }
                        }
                    }

                    $('#SoforDetaySelectBolge').multiselect('refresh');
                    $('#SoforDetayArac').multiselect('refresh');
                    $('#SoforDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
                    $('#SoforDetayArac').multiselect('dataprovider', SelectSoforOptions);
                    svControl('svAdd', 'soforDetay', '');
                    i.removeClass("fa-spinner fa-spin");
                    i.addClass("glyphicon glyphicon-user");
                }
            }
        });
    });
    //kullanıcı işlemleri bölge select
    $('#SoforSelectBolge').on('change', function () {
        var soforBolgeID = new Array();
        $('select#SoforSelectBolge option:selected').each(function () {
            soforBolgeID.push($(this).val());
        });
        var AracOptions = new Array();
        $.ajax({
            data: {"soforBolgeID[]": soforBolgeID, "tip": "soforAracMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    if (cevap.aracMultiSelect) {
                        var araclength = cevap.aracMultiSelect.AracSelectID.length;
                        for (var i = 0; i < araclength; i++) {
                            AracOptions[i] = {label: cevap.aracMultiSelect.AracSelectPlaka[i], title: cevap.aracMultiSelect.AracSelectPlaka[i], value: cevap.aracMultiSelect.AracSelectID[i]};
                        }
                        $('#SoforAracSelect').multiselect('refresh');
                        $('#SoforAracSelect').multiselect('dataprovider', AracOptions);
                    } else {
                        $('#SoforAracSelect').multiselect('refresh');
                        $('#SoforAracSelect').multiselect('dataprovider', AracOptions);
                    }
                }
            }
        });
    });

    $('#AracDetayBolgeSelect').on('change', function () {

        var aracID = $("input[name=adminAracDetailDeger]").val();
        var aracDetailBolgeID = new Array();
        $('select#AracDetayBolgeSelect option:selected').each(function () {
            aracDetailBolgeID.push($(this).val());
        });
        var aracDetailSoforID = new Array();
        $('select#AracDetaySurucu option:selected').each(function () {
            aracDetailSoforID.push($(this).index());
        });
        if (aracDetailSoforID.length > 0) {
            $('#example-deselect').multiselect('deselect', ['1', '2']);
            $('#AracDetaySurucu').multiselect('refresh');
        }

        var SoforOptions = new Array();
        $.ajax({
            data: {"aracID": aracID, "aracDetailBolgeID[]": aracDetailBolgeID, "tip": "AracDetailMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    if (cevap.adminAracSelectSofor) {
                        var soforselectlength = cevap.adminAracSelectSofor.length;
                        for (var t = 0; t < soforselectlength; t++) {
                            SoforOptions[t] = {label: cevap.adminAracSelectSofor[t].SelectAracSoforAd + ' ' + cevap.adminAracSelectSofor[t].SelectAracSoforSoyad, title: cevap.adminAracSelectSofor[t].SelectAracSoforAd + ' ' + cevap.adminAracSelectSofor[t].SelectAracSoforSoyad, value: cevap.adminAracSelectSofor[t].SelectAracSoforID, selected: true};
                        }
                        if (cevap.adminAracSofor) {
                            var soforlength = cevap.adminAracSofor.length;
                            for (var f = 0; f < soforlength; f++) {
                                SoforOptions[t] = {label: cevap.adminAracSofor[f].DigerAracSoforAdi + ' ' + cevap.adminAracSofor[f].DigerAracSoforSoyad, title: cevap.adminAracSofor[f].DigerAracSoforAdi + ' ' + cevap.adminAracSofor[f].DigerAracSoforSoyad, value: cevap.adminAracSofor[f].DigerAracSoforID};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.adminAracSofor) {
                            var soforlength = cevap.adminAracSofor.length;
                            for (var t = 0; t < soforlength; t++) {
                                SoforOptions[t] = {label: cevap.adminAracSofor[t].DigerAracSoforAdi + ' ' + cevap.adminAracSofor[t].DigerAracSoforSoyad, title: cevap.adminAracSofor[t].DigerAracSoforAdi + ' ' + cevap.adminAracSofor[t].DigerAracSoforSoyad, value: cevap.adminAracSofor[t].DigerAracSoforID};
                            }
                        }
                    }
                    $('#AracDetaySurucu').multiselect('refresh');
                    $('#AracDetaySurucu').multiselect('dataprovider', SoforOptions);
                }
            }
        });
    });

    $('#AracBolgeSelect').on('change', function () {
        var aracBolgeID = new Array();
        $('select#AracBolgeSelect option:selected').each(function () {
            aracBolgeID.push($(this).val());
        });
        var AracSoforOptions = new Array();
        $.ajax({
            data: {"aracBolgeID[]": aracBolgeID, "tip": "AracSoforMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    if (cevap.aracYeniSoforMultiSelect) {
                        var soforlength = cevap.aracYeniSoforMultiSelect.SoforSelectID.length;
                        for (var i = 0; i < soforlength; i++) {
                            AracSoforOptions[i] = {label: cevap.aracYeniSoforMultiSelect.SoforSelectAd[i] + ' ' + cevap.aracYeniSoforMultiSelect.SoforSelectSoyad[i], title: cevap.aracYeniSoforMultiSelect.SoforSelectAd[i] + ' ' + cevap.aracYeniSoforMultiSelect.SoforSelectSoyad[i], value: cevap.aracYeniSoforMultiSelect.SoforSelectID[i]};
                        }
                        $('#AracSurucu').multiselect('refresh');
                        $('#AracSurucu').multiselect('dataprovider', AracSoforOptions);
                    } else {
                        $('#AracSurucu').multiselect('refresh');
                        $('#AracSurucu').multiselect('dataprovider', AracSoforOptions);
                    }
                }
            }
        });
    });

    $('#SoforDetaySelectBolge').on('change', function () {

        var soforID = $("input[name=soforDetayID]").val();
        var soforDetailBolgeID = new Array();
        $('select#SoforDetaySelectBolge option:selected').each(function () {
            soforDetailBolgeID.push($(this).val());
        });

        $('#AracDetaySurucu').multiselect('refresh');

        var AracOptions = new Array();
        $.ajax({
            data: {"soforID": soforID, "soforDetailBolgeID[]": soforDetailBolgeID, "tip": "SoforDetailMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    if (cevap.adminSoforSelectArac) {
                        var aracselectlength = cevap.adminSoforSelectArac.length;
                        for (var t = 0; t < aracselectlength; t++) {
                            AracOptions[t] = {label: cevap.adminSoforSelectArac[t].SelectSoforAracPlaka, title: cevap.adminSoforSelectArac[t].SelectSoforAracPlaka, value: cevap.adminSoforSelectArac[t].SelectSoforAracID, selected: true};
                        }
                        if (cevap.adminSoforArac) {
                            var araclength = cevap.adminSoforArac.length;
                            for (var f = 0; f < araclength; f++) {
                                AracOptions[t] = {label: cevap.adminSoforArac[f].DigerSoforAracPlaka, title: cevap.adminSoforArac[f].DigerSoforAracPlaka, value: cevap.adminSoforArac[f].DigerSoforAracID};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.adminSoforArac) {
                            var araclength = cevap.adminSoforArac.length;
                            for (var t = 0; t < araclength; t++) {
                                AracOptions[t] = {label: cevap.adminSoforArac[t].DigerSoforAracPlaka, title: cevap.adminSoforArac[t].DigerSoforAracPlaka, value: cevap.adminSoforArac[t].DigerSoforAracID};
                            }
                        }
                    }
                    $('#SoforDetayArac').multiselect('refresh');
                    $('#SoforDetayArac').multiselect('dataprovider', AracOptions);
                }
            }
        });
    });

    //multi select açılma eventları
    $('#AracDetayBolgeSelect').multiselect({
        onDropdownShow: function (event) {
            $('#AracDetaySurucu').show();
        },
        onDropdownHide: function (event) {
            $('#AracDetaySurucu').hide();
        }
    });

    $('#SoforDetaySelectBolge').multiselect({
        onDropdownShow: function (event) {
            $('#SoforDetayArac').show();
        },
        onDropdownHide: function (event) {
            $('#SoforDetayArac').hide();
        }
    });


});
var AdminVazgec = [];
var AdminBolgeDetailVazgec = [];
var AdminBolgeKaydet = [];
var AdminBolgeKurumHarita = [];
var AdminBolgeDetailNewKurum = [];
var AdminKurumKaydet = [];
var AdminKurumDetailVazgec = [];
var AdminNewKurum = [];
var AdminAracDetailVazgec = [];
var AdminDetailVazgec = [];
var SoforDetailVazgec = [];
$.AdminIslemler = {
    adminFirmaOzellik: function () {
        //Firma İşlemleri Değerleri
        //var firma_kod = $("input[name=FrmKod]").val();
        var firma_adi = $("input[name=FirmaAdi]").val();
        var firma_aciklama = $("textarea[name=Aciklama]").val();
        var ogrenci_chechkbox = $('#OgrenciServis').is(':checked');
        if (ogrenci_chechkbox != true) {
            ogrenci_chechkbox = 0;
        } else {
            ogrenci_chechkbox = 1;
        }
        var personel_chechkbox = $('#PersonelServis').is(':checked');
        if (personel_chechkbox != true) {
            personel_chechkbox = 0;
        } else {
            personel_chechkbox = 1;
        }
        var firma_durum = $("input[name=FirmaDurum]").val();
        var firma_adres = $("textarea[name=FirmaAdres]").val();
        var firma_telefon = $("input[name=FirmaTelefon]").val();
        var firma_email = $("input[name=FirmaEmail]").val();
        var firma_website = $("input[name=FirmaWebAdresi]").val();
        var firma_lokasyon = $("input[name=FirmaLokasyon]").val();
        var firmaulke = $("input[name=country]").val();
        var firmail = $("input[name=administrative_area_level_1]").val();
        var firmailce = $("input[name=administrative_area_level_2]").val();
        var firmasemt = $("input[name=locality]").val();
        var firmamahalle = $("input[name=neighborhood]").val();
        var firmasokak = $("input[name=route]").val();
        var firmapostakodu = $("input[name=postal_code]").val();
        var firmacaddeno = $("input[name=street_number]").val();
        $.ajax({
            data: {"firma_adi": firma_adi, "firma_aciklama": firma_aciklama, "ogrenci_chechkbox": ogrenci_chechkbox,
                "personel_chechkbox": personel_chechkbox, "firma_adres": firma_adres, "firma_telefon": firma_telefon,
                "firma_email": firma_email, "firma_website": firma_website, "firma_lokasyon": firma_lokasyon,
                "firmaulke": firmaulke, "firmail": firmail, "firmailce": firmailce,
                "firmasemt": firmasemt, "firmamahalle": firmamahalle, "firmasokak": firmasokak,
                "firmapostakodu": firmapostakodu, "firmacaddeno": firmacaddeno, "tip": "adminFirmaIslemlerKaydet"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    disabledForm();
                    alert(cevap.update);
                }
            }
        });
    },
    adminFirmaVazgec: function () {
        $("input[name=FrmKod]").val(AdminVazgec[0]);
        $("input[name=FirmaAdi]").val(AdminVazgec[1]);
        $("textarea[name=Aciklama]").val(AdminVazgec[2]);
        //hidden input
        $("input[name=FirmaDurum]").val(AdminVazgec[3]);
        $("select[name=FirmaDurum]").val(AdminVazgec[3]);
        if (AdminVazgec[4] != 1) {
            $('#OgrenciServis').prop('checked', '');
            checkIt();
        } else {
            $('#OgrenciServis').prop('checked', 'true');
            checkIt();
        }
        if (AdminVazgec[5] != 1) {
            $('#PersonelServis').prop('checked', '');
            checkIt();
        } else {
            $('#PersonelServis').prop('checked', 'true');
            checkIt();
        }
        $("textarea[name=FirmaAdres]").val(AdminVazgec[6]);
        $("input[name=FirmaTelefon]").val(AdminVazgec[7]);
        $("input[name=FirmaEmail]").val(AdminVazgec[8]);
        $("input[name=FirmaWebAdresi]").val(AdminVazgec[9]);
        $("input[name=FirmaLokasyon]").val(AdminVazgec[10]);
        $("input[name=country]").val(AdminVazgec[11]);
        $("input[name=administrative_area_level_1]").val(AdminVazgec[12]);
        $("input[name=administrative_area_level_2]").val(AdminVazgec[13]);
        $("input[name=locality]").val(AdminVazgec[14]);
        $("input[name=neighborhood]").val(AdminVazgec[15]);
        $("input[name=route]").val(AdminVazgec[16]);
        $("input[name=postal_code]").val(AdminVazgec[17]);
        $("input[name=street_number]").val(AdminVazgec[18]);
    },
    adminFirmaDuzenle: function () {

        //Firma İşlemleri Değerleri
        var firma_adi = $("input[name=FirmaAdi]").val();
        var firma_aciklama = $("textarea[name=Aciklama]").val();
        var ogrenci_chechkbox = $('#OgrenciServis').is(':checked');
        if (ogrenci_chechkbox != true) {
            ogrenci_chechkbox = 0;
        } else {
            ogrenci_chechkbox = 1;
        }
        var personel_chechkbox = $('#PersonelServis').is(':checked');
        if (personel_chechkbox != true) {
            personel_chechkbox = 0;
        } else {
            personel_chechkbox = 1;
        }
        var firma_durum = $("select[name=FirmaDurum]").val();
        var firma_adres = $("textarea[name=FirmaAdres]").val();
        var firma_telefon = $("input[name=FirmaTelefon]").val();
        var firma_email = $("input[name=FirmaEmail]").val();
        var firma_website = $("input[name=FirmaWebAdresi]").val();
        var firma_lokasyon = $("input[name=FirmaLokasyon]").val();
        var firmakurumulke = $("input[name=country]").val();
        var firmakurumil = $("input[name=administrative_area_level_1]").val();
        var firmakurumilce = $("input[name=administrative_area_level_2]").val();
        var firmakurumsemt = $("input[name=locality]").val();
        var firmakurummahalle = $("input[name=neighborhood]").val();
        var firmakurumsokak = $("input[name=route]").val();
        var firmakurumpostakodu = $("input[name=postal_code]").val();
        var firmakurumcaddeno = $("input[name=street_number]").val();
        //vazgeç için değerler
        var firma_kodu = $("input[name=FrmKod]").val();
        AdminVazgec = [];
        AdminVazgec.push(firma_kodu, firma_adi, firma_aciklama, firma_durum, ogrenci_chechkbox,
                personel_chechkbox, firma_adres, firma_telefon, firma_email, firma_website,
                firma_lokasyon, firmakurumulke, firmakurumil, firmakurumilce, firmakurumsemt,
                firmakurummahalle, firmakurumsokak, firmakurumpostakodu, firmakurumcaddeno);
    },
    adminBolgeYeni: function () {
        $("input[name=BolgeAdi]").val('');
        $("textarea[name=BolgeAciklama]").val('');
        return true;
    },
    adminBolgeKaydet: function () {
        AdminBolgeKaydet = [];
        var bolge_adi = $("input[name=BolgeAdi]").val();
        var bolge_aciklama = $("textarea[name=BolgeAciklama]").val();
        AdminBolgeKaydet.push(bolge_adi);
        AdminBolgeKaydet.push(bolge_aciklama);
        if (bolge_adi != '') {
            $.ajax({
                data: {"bolge_adi": bolge_adi, "bolge_aciklama": bolge_aciklama, "tip": "adminBolgeYeniKaydet"},
                success: function (cevap) {
                    if (cevap.hata) {
                        AdminBolgeKaydet = [];
                        alert(cevap.hata);
                    } else {
                        var bolgeCount = $('#smallBolge').text();
                        bolgeCount++;
                        $('#smallBolge').text(bolgeCount);
                        var addRow = ("<tr style='background-color:#F2F2F2'><td><a class='svToggle' data-type='svDetail' role='button' data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newBolgeID + "'>"
                                + "<i class='fa fa-search'></i> " + AdminBolgeKaydet[0] + "</a>"
                                + "</td><td class='hidden-xs'>0</td><td class='hidden-xs'>" + AdminBolgeKaydet[1] + "</td></tr>");
                        newBolgeTable.DataTable().row.add($(addRow)).draw();
                    }
                }
            });
            return true;
        } else {
            alert("Lütfen Bölge Adını Giriniz");
        }
    },
    adminAddBolgeVazgec: function () {
        $("input[name=BolgeAdi]").val('');
        $("textarea[name=BolgeAciklama]").val('');
        return true;
    },
    adminBolgeDetailDuzenle: function () {
        //Firma İşlemleri Değerleri
        var bolgedetail_adi = $("input[name=BolgeDetailAdi]").val();
        var bolgedetail_aciklama = $("textarea[name=BolgeDetailAciklama]").val();
        AdminBolgeDetailVazgec = [];
        AdminBolgeDetailVazgec.push(bolgedetail_adi, bolgedetail_aciklama);
    },
    adminBolgeDetailVazgec: function () {

        $("input[name=BolgeDetailAdi]").val(AdminBolgeDetailVazgec[0]);
        $("textarea[name=BolgeDetailAciklama]").val(AdminBolgeDetailVazgec[1]);
    },
    adminBolgeDetailSil: function () {
        var bolgedetail_id = $("input[name=adminBolgeDetailID]").val();
        $.ajax({
            data: {"bolgedetail_id": bolgedetail_id, "tip": "adminBolgeDetailDelete"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    disabledForm();
                    $("input[name=BolgeDetailAdi]").val('');
                    $("textarea[name=BolgeDetailAciklama]").val('');
                    var bolgeCount = $('#smallBolge').text();
                    bolgeCount--;
                    $('#smallBolge').text(bolgeCount);
                    var length = $('tbody#adminBolgeRow tr').length;
                    for (var t = 0; t < length; t++) {
                        var attrValueId = $("tbody#adminBolgeRow > tr > td > a").eq(t).attr('value');
                        if (attrValueId == bolgedetail_id) {
                            var deleteRow = $('tbody#adminBolgeRow > tr:eq(' + t + ')');
                            newBolgeTable.DataTable().row($(deleteRow)).remove().draw();
                        }
                    }
                }
            }
        });
        return true;
    },
    adminBolgeDetailKaydet: function () {
        var bolgedetail_adi = $("input[name=BolgeDetailAdi]").val();
        var bolgedetail_aciklama = $("textarea[name=BolgeDetailAciklama]").val();
        var bolgedetail_id = $("input[name=adminBolgeDetailID]").val();
        if (AdminBolgeDetailVazgec[0] == bolgedetail_adi && AdminBolgeDetailVazgec[1] == bolgedetail_aciklama) {
            alert("Lütfen Değişiklik yaptığınıza emin olun.");
        } else {
            $.ajax({
                data: {"bolgedetail_id": bolgedetail_id, "bolgedetail_adi": bolgedetail_adi, "bolgedetail_aciklama": bolgedetail_aciklama, "tip": "adminBolgeDetailDuzenle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        alert(cevap.hata);
                    } else {
                        disabledForm();
                        var length = $('tbody#adminBolgeRow tr').length;
                        for (var t = 0; t < length; t++) {
                            var attrValueId = $("tbody#adminBolgeRow > tr > td > a").eq(t).attr('value');
                            if (attrValueId == bolgedetail_id) {
                                $("tbody#adminBolgeRow > tr > td > a").eq(t).html('<i class="fa fa-search"></i> ' + bolgedetail_adi);
                                $('tbody#adminBolgeRow > tr:eq(' + t + ') > td:eq(0)').css({"background-color": "#F2F2F2"});
                            }
                        }
                    }
                }
            });
        }
    },
    adminBolgeKurumOpenMap: function () {
        AdminBolgeKurumHarita = [];
        //Firma İşlemleri Harita Değerleri
        var bolgkurumulke = $("input[name=country]").val();
        var bolgkurumil = $("input[name=administrative_area_level_1]").val();
        var bolgkurumilce = $("input[name=administrative_area_level_2]").val();
        var bolgkurumsemt = $("input[name=locality]").val();
        var bolgkurummahalle = $("input[name=neighborhood]").val();
        var bolgkurumsokak = $("input[name=route]").val();
        var bolgkurumpostakodu = $("input[name=postal_code]").val();
        var bolgkurumcaddeno = $("input[name=street_number]").val();
        var bolgkurumlocation = $("input[name=KurumLokasyon]").val();
        AdminBolgeKurumHarita.push(bolgkurumulke, bolgkurumil, bolgkurumilce, bolgkurumsemt, bolgkurummahalle, bolgkurumsokak, bolgkurumpostakodu, bolgkurumcaddeno, bolgkurumlocation);
    },
    adminBolgeKurumVazgec: function () {
        return true;
    },
    adminBolgeDetailYeniEkle: function () {

        var bolgeid = $("input[name=adminBolgeDetailID]").val();
        $("input[name=adminBolgeKurumEkleID]").val(bolgeid);
        //Bölge kurum İşlemleri Değerleri Temizleme
        var bolgkurumadi = $("input[name=KurumAdi]").val('');
        var bolgkurumTlfn = $("input[name=KurumTelefon]").val('');
        var bolgkurumEmail = $("input[name=KurumEmail]").val('');
        var bolgkurumwebsite = $("input[name=KurumWebSite]").val('');
        var bolgkurumadrsDty = $("textarea[name=KurumAdresDetay]").val('');
        var bolgkurumaciklama = $("textarea[name=Aciklama]").val('');
        var bolgkurumulke = $("input[name=country]").val('');
        var bolgkurumil = $("input[name=administrative_area_level_1]").val('');
        var bolgkurumilce = $("input[name=administrative_area_level_2]").val('');
        var bolgkurumsemt = $("input[name=locality]").val('');
        var bolgkurummahalle = $("input[name=neighborhood]").val('');
        var bolgkurumsokak = $("input[name=route]").val('');
        var bolgkurumpostakodu = $("input[name=postal_code]").val('');
        var bolgkurumcaddeno = $("input[name=street_number]").val('');
        var bolgkurumlocation = $("input[name=KurumLokasyon]").val('');
        return true;
    },
    adminBolgeKurumKaydet: function () {
        AdminBolgeDetailNewKurum = [];
        var bolgkurumadi = $("input[name=KurumAdi]").val();
        var bolgkurumlocation = $("input[name=KurumLokasyon]").val();
        AdminBolgeDetailNewKurum.push(bolgkurumadi);
        AdminBolgeDetailNewKurum.push(bolgkurumlocation);
        var bolgeid = $("input[name=adminBolgeDetailID]").val();
        var bolgead = $("input[name=BolgeDetailAdi]").val();
        //Bölge kurum İşlemleri Değerleri Temizleme

        var bolgkurumTlfn = $("input[name=KurumTelefon]").val();
        var bolgkurumEmail = $("input[name=KurumEmail]").val();
        var bolgkurumwebsite = $("input[name=KurumWebSite]").val();
        var bolgkurumadrsDty = $("textarea[name=KurumAdresDetay]").val();
        var bolgkurumaciklama = $("textarea[name=Aciklama]").val();
        var bolgkurumulke = $("input[name=country]").val();
        var bolgkurumil = $("input[name=administrative_area_level_1]").val();
        var bolgkurumilce = $("input[name=administrative_area_level_2]").val();
        var bolgkurumsemt = $("input[name=locality]").val();
        var bolgkurummahalle = $("input[name=neighborhood]").val();
        var bolgkurumsokak = $("input[name=route]").val();
        var bolgkurumpostakodu = $("input[name=postal_code]").val();
        var bolgkurumcaddeno = $("input[name=street_number]").val();
        if (bolgkurumadi != '' && bolgeid != '') {
            $.ajax({
                data: {"bolgeid": bolgeid, "bolgead": bolgead, "bolgkurumadi": bolgkurumadi, "bolgkurumTlfn": bolgkurumTlfn, "bolgkurumEmail": bolgkurumEmail,
                    "bolgkurumwebsite": bolgkurumwebsite, "bolgkurumadrsDty": bolgkurumadrsDty, "bolgkurumaciklama": bolgkurumaciklama,
                    "bolgkurumulke": bolgkurumulke, "bolgkurumil": bolgkurumil, "bolgkurumilce": bolgkurumilce, "bolgkurumsemt": bolgkurumsemt,
                    "bolgkurummahalle": bolgkurummahalle, "bolgkurumsokak": bolgkurumsokak, "bolgkurumpostakodu": bolgkurumpostakodu,
                    "bolgkurumcaddeno": bolgkurumcaddeno, "bolgkurumlocation": bolgkurumlocation, "tip": "adminBolgeKurumKaydet"},
                success: function (cevap) {
                    if (cevap.hata) {
                        AdminBolgeDetailNewKurum = [];
                        alert(cevap.hata);
                    } else {
                        var length = $('tbody#adminBolgeRow tr').length;
                        for (var t = 0; t < length; t++) {
                            var attrValueId = $("tbody#adminBolgeRow > tr > td > a").eq(t).attr('value');
                            if (attrValueId == bolgeid) {
                                var bolgekurumsayac = $('tbody#adminBolgeRow > tr:eq(' + t + ') > td:eq(1)').text();
                                bolgekurumsayac++;
                                $('tbody#adminBolgeRow > tr:eq(' + t + ') > td:eq(1)').text(bolgekurumsayac);
                            }
                        }
                        var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                + "<a class='svToggle' data-type='svOpen' data-islemler='adminBolgeMultiMap' data-class='map' data-index='index' role='button' data-toggle='tooltip'data-value=" + cevap.newBolgeKurumID + " data-placement='top' title='' value='" + AdminBolgeDetailNewKurum[1] + "'>"
                                + "<i class='fa fa-map-marker'></i>    " + AdminBolgeDetailNewKurum[0] + "</a><i></i></td></tr>";
                        KurumTable.DataTable().row.add($(addRow)).draw();
                        AdminBolgeDetailNewKurum = [];
                    }
                }
            });
            return true;
        } else {
            alert("Lütfen Kurum Adını Giriniz");
        }
    },
    adminBolgeMultiMapping: function () {

        var bolge_adi = $("input[name=BolgeDetailAdi]").val();
        //Tıklanılan değer indexi
        //var index = $(this).parent().index();

        //var count = $('ul#adminBolgeKurumDetail > li').length;

        var count = $('table#adminBolgeKurumTable > tbody > tr').length;
        var MapValue = $(this).attr('value');
        for (var countK = 0; countK < count; countK++) {
            //var bolgeKurumlarMap = $('ul#adminBolgeKurumDetail > li:eq(' + countK + ') > a').attr('value');
            var bolgeKurumlarMap = $('table#adminBolgeKurumTable > tbody > tr:eq(' + countK + ') > td > a').attr('value');
            var LocationBolme = bolgeKurumlarMap.split(",");
            var bolgeKurumName = $('table#adminBolgeKurumTable > tbody > tr:eq(' + countK + ') > td > a').text();
            MultipleMapArray[countK] = Array(bolgeKurumName, LocationBolme[0], LocationBolme[1]);
        }
        $("#singleMapBaslik").text(bolge_adi);
        return true;
    },
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
        var kurumdetail_telefon = $("input[name=KurumDetailTelefon]").val();
        var kurumdetail_email = $("input[name=KurumDetailEmail]").val();
        var kurumdetail_adres = $("textarea[name=KurumDetailAdres]").val();
        var kurumdetail_aciklama = $("textarea[name=KurumDetailAciklama]").val();
        AdminKurumDetailVazgec = [];
        AdminKurumDetailVazgec.push(kurumdetail_adi, kurumdetail_bolge, kurumdetail_telefon, kurumdetail_email, kurumdetail_adres, kurumdetail_aciklama);
    },
    adminKurumDetailVazgec: function () {
        $("input[name=KurumDetailAdi]").val(AdminKurumDetailVazgec[0]);
        $("input[name=KurumDetailBolge]").val(AdminKurumDetailVazgec[1]);
        $("input[name=KurumDetailTelefon]").val(AdminKurumDetailVazgec[2]);
        $("input[name=KurumDetailEmail]").val(AdminKurumDetailVazgec[3]);
        $("textarea[name=KurumDetailAdres]").val(AdminKurumDetailVazgec[4]);
        $("textarea[name=KurumDetailAciklama]").val(AdminKurumDetailVazgec[5]);
    },
    adminKurumDetailKaydet: function () {
        var kurumdetail_adi = $("input[name=KurumDetailAdi]").val();
        var kurumdetail_bolge = $("input[name=KurumDetailBolge]").val();
        var kurumdetail_telefon = $("input[name=KurumDetailTelefon]").val();
        var kurumdetail_email = $("input[name=KurumDetailEmail]").val();
        var kurumdetail_adres = $("textarea[name=KurumDetailAdres]").val();
        var kurumdetail_aciklama = $("textarea[name=KurumDetailAciklama]").val();
        var kurumdetail_id = $("input[name=adminKurumDetailID]").val();
        if (AdminKurumDetailVazgec[0] == kurumdetail_adi && AdminKurumDetailVazgec[1] == kurumdetail_bolge && AdminKurumDetailVazgec[2] == kurumdetail_telefon && AdminKurumDetailVazgec[3] == kurumdetail_email && AdminKurumDetailVazgec[4] == kurumdetail_adres && AdminKurumDetailVazgec[5] == kurumdetail_aciklama) {
            alert("Lütfen Değişiklik yaptığınıza emin olun.");
        } else {
            $.ajax({
                data: {"kurumdetail_id": kurumdetail_id, "kurumdetail_adi": kurumdetail_adi, "kurumdetail_bolge": kurumdetail_bolge, "kurumdetail_telefon": kurumdetail_telefon, "kurumdetail_email": kurumdetail_email, "kurumdetail_adres": kurumdetail_adres, "kurumdetail_aciklama": kurumdetail_aciklama, "tip": "adminKurumDetailDuzenle"},
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
            var bolgead = $("#KurumBolgeSelect option:selected").text();
            var bolgeId = $("#KurumBolgeSelect option:selected").val();
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
                data: {"kurumadi": kurumadi, "bolgeId": bolgeId, "bolgead": bolgead, "kurumlocation": kurumlocation, "kurumTlfn": kurumTlfn, "kurumEmail": kurumEmail,
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
    adminAracYeni: function () {

        $("input[name=AracPlaka]").val('');
        $("input[name=BolgeAdi]").val('');
        $("#AracDurum").val("1");
        $("input[name=AracMarka]").val('');
        $("input[name=AracYil]").val('');
        $("textarea[name=AracAciklama]").val('');
        $("input[name=AracKapasite]").val('');
        var BolgeOptions = new Array();
        $.ajax({
            data: {"tip": "adminAracEkleSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    if (cevap.adminAracBolge) {
                        var bolgelength = cevap.adminAracBolge.AdminBolgeID.length;
                        for (var i = 0; i < bolgelength; i++) {
                            BolgeOptions[i] = {label: cevap.adminAracBolge.AdminBolge[i], title: cevap.adminAracBolge.AdminBolge[i], value: cevap.adminAracBolge.AdminBolgeID[i]};
                        }
                    }
                    $('#AracBolgeSelect').multiselect('refresh');
                    $('#AracBolgeSelect').multiselect('dataprovider', BolgeOptions);
                    $('#AracSurucu').multiselect('refresh');
                    var selectLength = $('#AracBolgeSelect > option').length;
                    if (!selectLength) {
                        alert("Lütfen Öncelikle Bölge İşlemlerine Gidip Yeni Bölge Oluşturunuz");
                    }

                }

            }
        });
        return true;
    },
    adminAracEkle: function () {

        var aracPlaka = $("input[name=AracPlaka]").val().toUpperCase();
        if (aracPlaka == '') {
            alert("Plaka Boş geçilemez");
        } else {
            var select = $('select#AracBolgeSelect option:selected').val();
            if (select) {
                var aracMarka = $("input[name=AracMarka]").val();
                var aracModelYil = $("input[name=AracYil]").val();
                var aracKapasite = $("input[name=AracKapasite]").val();
                var aracAciklama = $("textarea[name=AracAciklama]").val();
                var aracDurum = $("#AracDurum option:selected").val();
                var aracDurumText = $("#AracDurum option:selected").text();
                //araç Bölge ID
                var aracBolgeID = new Array();
                $('select#AracBolgeSelect option:selected').each(function () {
                    aracBolgeID.push($(this).val());
                });
                //araç Bölge Ad
                var aracBolgeAd = new Array();
                $('select#AracBolgeSelect option:selected').each(function () {
                    aracBolgeAd.push($(this).attr('title'));
                });
                //araç Şoför Id
                var aracSoforID = new Array();
                $('select#AracSurucu option:selected').each(function () {
                    aracSoforID.push($(this).val());
                });
                //araç Şoför Ad
                var aracSoforAd = new Array();
                $('select#AracSurucu option:selected').each(function () {
                    aracSoforAd.push($(this).attr('title'));
                });
                $.ajax({
                    data: {"aracBolgeID[]": aracBolgeID, "aracBolgeAd[]": aracBolgeAd, "aracSoforID[]": aracSoforID, "aracSoforAd[]": aracSoforAd, "aracPlaka": aracPlaka, "aracMarka": aracMarka, "aracModelYil": aracModelYil,
                        "aracKapasite": aracKapasite, "aracAciklama": aracAciklama, "aracDurum": aracDurum, "tip": "adminAracKaydet"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            alert(cevap.hata);
                        } else {
                            var aracCount = $('#smallArac').text();
                            console.log(aracCount);
                            aracCount++;
                            $('#smallArac').text(aracCount);
                            if (aracDurum != 0) {
                                var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newAracID + "'>"
                                        + "<i class='fa fa-bus' style='color:green;'></i> " + aracPlaka + "</a></td>"
                                        + "<td class='hidden-xs'>" + aracMarka + "</td>"
                                        + "<td class='hidden-xs'>" + aracModelYil + "</td>"
                                        + "<td class='hidden-xs'>" + aracKapasite + "</td>"
                                        + "<td class='hidden-xs'>0</td>"
                                        + "<td class='hidden-xs'>" + aracDurumText + "</td>";
                                NewAracTable.DataTable().row.add($(addRow)).draw();
                            } else {
                                var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newAracID + "'>"
                                        + "<i class='fa fa-bus' style='color:red;'></i> " + aracPlaka + "</a></td>"
                                        + "<td class='hidden-xs'>" + aracMarka + "</td>"
                                        + "<td class='hidden-xs'>" + aracModelYil + "</td>"
                                        + "<td class='hidden-xs'>" + aracKapasite + "</td>"
                                        + "<td class='hidden-xs'>0</td>"
                                        + "<td class='hidden-xs'>" + aracDurumText + "</td>";
                                NewAracTable.DataTable().row.add($(addRow)).draw();
                            }
                            aracBolgeID = [];
                            aracBolgeAd = [];
                            aracSoforID = [];
                            aracSoforAd = [];
                        }
                    }
                });
                return true;
            } else {
                alert("Lütfen Bölge Seçiniz");
            }


        }
    },
    adminAracVazgec: function () {
        return true;
    },
    adminAracDetailDuzenle: function () {
        //Araç İşlemleri Değerleri
        var aracPlaka = $("input[name=AracDetayPlaka]").val();
        var aracMarka = $("input[name=AracDetayMarka]").val();
        var aracModelYil = $("input[name=AracDetayModelYil]").val();
        var aracKapasite = $("input[name=AracDetayKapasite]").val();
        var aracAciklama = $("textarea[name=AracDetayAciklama]").val();
        var aracDurum = $("#AracDetayDurum option:selected").val();
        //araç Bölge ID
        var aracBolgeID = new Array();
        $('select#AracDetayBolgeSelect option:selected').each(function () {
            aracBolgeID.push($(this).val());
        });
        //araç Bölge Ad
        var aracBolgeAd = new Array();
        $('select#AracDetayBolgeSelect option:selected').each(function () {
            aracBolgeAd.push($(this).attr('title'));
        });
        //araç Şoför Id
        var aracSoforID = new Array();
        $('select#AracDetaySurucu option:selected').each(function () {
            aracSoforID.push($(this).val());
        });
        //araç Şoför Ad
        var aracSoforAd = new Array();
        $('select#AracDetaySurucu option:selected').each(function () {
            aracSoforAd.push($(this).attr('title'));
        });
        //araç Seçili Olmayan Bölge ID
        var aracBolgeNID = new Array();
        $('select#AracDetayBolgeSelect option:not(:selected)').each(function () {
            aracBolgeNID.push($(this).val());
        });
        //araç Seçili Olmayan Bölge Ad
        var aracBolgeNAd = new Array();
        $('select#AracDetayBolgeSelect option:not(:selected)').each(function () {
            aracBolgeNAd.push($(this).attr('title'));
        });
        //araç Seçili Olmayan Şoför Id
        var aracSoforNID = new Array();
        $('select#AracDetaySurucu option:not(:selected)').each(function () {
            aracSoforNID.push($(this).val());
        });
        //araç Seçili Olmayan Şoför Ad
        var aracSoforNAd = new Array();
        $('select#AracDetaySurucu option:not(:selected)').each(function () {
            aracSoforNAd.push($(this).attr('title'));
        });
        var SelectBolgeOptions = new Array();
        var SelectAracOptions = new Array();
        if (aracBolgeID.length > 0) {
            var bolgelength = aracBolgeID.length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: aracBolgeAd[b], title: aracBolgeAd[b], value: aracBolgeID[b], selected: true};
            }

            if (aracBolgeNID.length > 0) {
                var aracBolgeLength = aracBolgeNID.length;
                for (var z = 0; z < aracBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: aracBolgeNAd[z], title: aracBolgeNAd[z], value: aracBolgeNID[z]};
                    b++;
                }

            }
        } else {
            if (aracBolgeNID.length > 0) {
                var aracBolgeLength = aracBolgeNID.length;
                for (var b = 0; b < aracBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: aracBolgeNAd[b], title: aracBolgeNAd[b], value: aracBolgeNID[b]};
                }

            }
        }

        if (aracSoforID.length > 0) {
            var soforselectlength = aracSoforID.length;
            for (var t = 0; t < soforselectlength; t++) {
                SelectAracOptions[t] = {label: aracSoforAd[t], title: aracSoforAd[t], value: aracSoforID[t], selected: true};
            }

            if (aracSoforNID.length > 0) {
                var soforlength = aracSoforNID.length;
                for (var f = 0; f < soforlength; f++) {
                    SelectAracOptions[t] = {label: aracSoforNAd[f], title: aracSoforNAd[f], value: aracSoforNID[f]};
                    t++;
                }
            }

        } else {
            if (aracSoforNID.length > 0) {
                var soforlength = aracSoforNID.length;
                for (var t = 0; t < soforlength; t++) {
                    SelectAracOptions[t] = {label: aracSoforNAd[t], title: aracSoforNAd[t], value: aracSoforNID[t]};
                }
            }
        }

        $('#AracDetayBolgeSelect').multiselect('refresh');
        $('#AracDetaySurucu').multiselect('refresh');
        $('#AracDetayBolgeSelect').multiselect('dataprovider', SelectBolgeOptions);
        $('#AracDetaySurucu').multiselect('dataprovider', SelectAracOptions);
        AdminAracDetailVazgec = [];
        AdminAracDetailVazgec.push(aracPlaka, aracMarka, aracModelYil, aracKapasite, aracAciklama, aracDurum, aracBolgeID, aracBolgeAd, aracBolgeNID, aracBolgeNAd, aracSoforID, aracSoforAd, aracSoforNID, aracSoforNAd);
    },
    adminAracDetailVazgec: function () {
        $("input[name=AracDetayPlaka]").val(AdminAracDetailVazgec[0]);
        $("input[name=AracDetayMarka]").val(AdminAracDetailVazgec[1]);
        $("input[name=AracDetayModelYil]").val(AdminAracDetailVazgec[2]);
        $("input[name=AracDetayKapasite]").val(AdminAracDetailVazgec[3]);
        $("textarea[name=AracDetayAciklama]").val(AdminAracDetailVazgec[4]);
        $("#AracDetayDurum").val(AdminAracDetailVazgec[5]);
        var SelectBolgeOptions = new Array();
        var SelectAracOptions = new Array();
        if (AdminAracDetailVazgec[6].length > 0) {
            var bolgelength = AdminAracDetailVazgec[6].length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: AdminAracDetailVazgec[7][b], title: AdminAracDetailVazgec[7][b], value: AdminAracDetailVazgec[6][b], selected: true, disabled: true};
            }
            if (AdminAracDetailVazgec[8].length > 0) {
                var aracBolgeLength = AdminAracDetailVazgec[8].length;
                for (var z = 0; z < aracBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: AdminAracDetailVazgec[9][z], title: AdminAracDetailVazgec[9][z], value: AdminAracDetailVazgec[8][z], disabled: true};
                    b++;
                }
            }
        } else {
            if (AdminAracDetailVazgec[8].length > 0) {
                var aracBolgeLength = AdminAracDetailVazgec[8].length;
                for (var b = 0; b < aracBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: AdminAracDetailVazgec[9][b], title: AdminAracDetailVazgec[9][b], value: AdminAracDetailVazgec[8][b], disabled: true};
                }
            }
        }


        if (AdminAracDetailVazgec[10].length > 0) {
            var soforselectlength = AdminAracDetailVazgec[10].length;
            for (var t = 0; t < soforselectlength; t++) {
                SelectAracOptions[t] = {label: AdminAracDetailVazgec[11][t], title: AdminAracDetailVazgec[11][t], value: AdminAracDetailVazgec[10][t], selected: true, disabled: true};
            }
            if (AdminAracDetailVazgec[12].length > 0) {
                var soforlength = AdminAracDetailVazgec[12].length;
                for (var f = 0; f < soforlength; f++) {
                    SelectAracOptions[t] = {label: AdminAracDetailVazgec[13][f], title: AdminAracDetailVazgec[13][f], value: AdminAracDetailVazgec[12][f], disabled: true};
                    t++;
                }
            }
        } else {
            if (AdminAracDetailVazgec[12].length > 0) {
                var soforlength = AdminAracDetailVazgec[12].length;
                for (var t = 0; t < soforlength; t++) {
                    SelectAracOptions[t] = {label: AdminAracDetailVazgec[13][t], title: AdminAracDetailVazgec[13][t], value: AdminAracDetailVazgec[12][t], disabled: true};
                }
            }
        }

        $('#AracDetayBolgeSelect').multiselect('refresh');
        $('#AracDetaySurucu').multiselect('refresh');
        $('#AracDetayBolgeSelect').multiselect('dataprovider', SelectBolgeOptions);
        $('#AracDetaySurucu').multiselect('dataprovider', SelectAracOptions);
    },
    adminAracDetailSil: function () {
        var aracdetail_id = $("input[name=adminAracDetailDeger]").val();
        $.ajax({
            data: {"aracdetail_id": aracdetail_id, "tip": "adminAracDetailDelete"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    disabledForm();
                    $("input[name=AracDetayPlaka]").val(' ');
                    $("input[name=AracDetayMarka]").val(' ');
                    $("input[name=AracDetayModelYil]").val(' ');
                    $("input[name=AracDetayKapasite]").val(' ');
                    $("textarea[name=AracDetayAciklama]").val(' ');
                    $("#AracDetayDurum option:selected").val(' ');
                    $("input[name=AracDetayKm]").val(' ');
                    var aracCount = $('#smallArac').text();
                    aracCount--;
                    $('#smallArac').text(aracCount);
                    var length = $('tbody#adminAracRow tr').length;
                    for (var t = 0; t < length; t++) {
                        var attrValueId = $("tbody#adminAracRow > tr > td > a").eq(t).attr('value');
                        if (attrValueId == aracdetail_id) {
                            var deleteRow = $('tbody#adminAracRow > tr:eq(' + t + ')');
                            NewAracTable.DataTable().row($(deleteRow)).remove().draw();
                        }
                    }
                }
            }
        });
        return true;
    },
    adminAracDetailKaydet: function () {

        var aracdetail_id = $("input[name=adminAracDetailDeger]").val();
        var aracPlaka = $("input[name=AracDetayPlaka]").val().toUpperCase();
        var aracMarka = $("input[name=AracDetayMarka]").val();
        var aracModelYil = $("input[name=AracDetayModelYil]").val();
        var aracKapasite = $("input[name=AracDetayKapasite]").val();
        var aracAciklama = $("textarea[name=AracDetayAciklama]").val();
        var aracDurum = $("#AracDetayDurum option:selected").val();
        var aracDurumText = $("#AracDetayDurum option:selected").text();
        //araç Bölge ID
        var aracBolgeID = new Array();
        $('select#AracDetayBolgeSelect option:selected').each(function () {
            aracBolgeID.push($(this).val());
        });
        //araç Bölge Ad
        var aracBolgeAd = new Array();
        $('select#AracDetayBolgeSelect option:selected').each(function () {
            aracBolgeAd.push($(this).attr('title'));
        });
        //araç Şoför Id
        var aracSoforID = new Array();
        $('select#AracDetaySurucu option:selected').each(function () {
            aracSoforID.push($(this).val());
        });
        //araç Şoför Ad
        var aracSoforAd = new Array();
        $('select#AracDetaySurucu option:selected').each(function () {
            aracSoforAd.push($(this).attr('title'));
        });
        //araç Seçili Olmayan Bölge ID
        var aracBolgeNID = new Array();
        $('select#AracDetayBolgeSelect option:not(:selected)').each(function () {
            aracBolgeNID.push($(this).val());
        });
        //araç Seçili Olmayan Bölge Ad
        var aracBolgeNAd = new Array();
        $('select#AracDetayBolgeSelect option:not(:selected)').each(function () {
            aracBolgeNAd.push($(this).attr('title'));
        });
        //araç Seçili Olmayan Şoför Id
        var aracSoforNID = new Array();
        $('select#AracDetaySurucu option:not(:selected)').each(function () {
            aracSoforNID.push($(this).val());
        });
        //araç Seçili Olmayan Şoför Ad
        var aracSoforNAd = new Array();
        $('select#AracDetaySurucu option:not(:selected)').each(function () {
            aracSoforNAd.push($(this).attr('title'));
        });
        var farkbolge = farkArray(AdminAracDetailVazgec[6], aracBolgeID);
        var farkbolgelength = farkbolge.length;
        var farkarac = farkArray(AdminAracDetailVazgec[10], aracSoforID);
        var farkaraclength = farkarac.length;
        if (AdminAracDetailVazgec[0] == aracPlaka && AdminAracDetailVazgec[1] == aracMarka && AdminAracDetailVazgec[2] == aracModelYil && AdminAracDetailVazgec[3] == aracKapasite && AdminAracDetailVazgec[4] == aracAciklama && AdminAracDetailVazgec[5] == aracDurum && farkbolgelength == 0 && farkaraclength == 0) {
            alert("Lütfen değişiklik yaptığınıza emin olun.");
        } else {
            var aracBolgeLength = $('select#AracDetayBolgeSelect option:selected').val();
            if (aracBolgeLength) {
                $.ajax({
                    data: {"aracdetail_id": aracdetail_id, "aracBolgeID[]": aracBolgeID, "aracBolgeAd[]": aracBolgeAd, "aracSoforID[]": aracSoforID, "aracSoforAd[]": aracSoforAd, "aracPlaka": aracPlaka, "aracMarka": aracMarka, "aracModelYil": aracModelYil,
                        "aracKapasite": aracKapasite, "aracAciklama": aracAciklama, "aracDurum": aracDurum, "tip": "adminAracDetailKaydet"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            alert(cevap.hata);
                        } else {

                            disabledForm();
                            var SelectBolgeOptions = new Array();
                            var SelectAracOptions = new Array();
                            if (aracBolgeID.length > 0) {
                                var bolgelength = aracBolgeID.length;
                                for (var b = 0; b < bolgelength; b++) {
                                    SelectBolgeOptions[b] = {label: aracBolgeAd[b], title: aracBolgeAd[b], value: aracBolgeID[b], disabled: true, selected: true};
                                }
                            }
                            if (aracBolgeNID.length > 0) {
                                var aracBolgeLength = aracBolgeNID.length;
                                for (var z = 0; z < aracBolgeLength; z++) {
                                    SelectBolgeOptions[b] = {label: aracBolgeNAd[z], title: aracBolgeNAd[z], value: aracBolgeNID[z], disabled: true};
                                    b++;
                                }

                            }
                            if (aracSoforID.length > 0) {
                                var soforselectlength = aracSoforID.length;
                                for (var t = 0; t < soforselectlength; t++) {
                                    SelectAracOptions[t] = {label: aracSoforAd[t], title: aracSoforAd[t], value: aracSoforID[t], disabled: true, selected: true};
                                }

                                if (aracSoforNID.length > 0) {
                                    var soforlength = aracSoforNID.length;
                                    for (var f = 0; f < soforlength; f++) {
                                        SelectAracOptions[t] = {label: aracSoforNAd[f], title: aracSoforNAd[f], value: aracSoforNID[f], disabled: true};
                                        t++;
                                    }
                                }
                            } else {
                                if (aracSoforNID.length > 0) {
                                    var soforlength = aracSoforNID.length;
                                    for (var t = 0; f < soforlength; t++) {
                                        SelectAracOptions[t] = {label: aracSoforNAd[t], title: aracSoforNAd[t], value: aracSoforNID[ts], disabled: true};
                                    }
                                }
                            }

                            $('#AracDetayBolgeSelect').multiselect('refresh');
                            $('#AracDetaySurucu').multiselect('refresh');
                            $('#AracDetayBolgeSelect').multiselect('dataprovider', SelectBolgeOptions);
                            $('#AracDetaySurucu').multiselect('dataprovider', SelectAracOptions);
                            var length = $('tbody#adminAracRow tr').length;
                            for (var t = 0; t < length; t++) {
                                var attrValueId = $("tbody#adminAracRow > tr > td > a").eq(t).attr('value');
                                if (attrValueId == aracdetail_id) {
                                    if (aracDurum != 0) {
                                        $("tbody#adminAracRow > tr > td > a").eq(t).html('<i class="fa fa-bus"></i> ' + aracPlaka);
                                        $("tbody#adminAracRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(aracMarka);
                                        $("tbody#adminAracRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(aracModelYil);
                                        $("tbody#adminAracRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(aracKapasite);
                                        $("tbody#adminAracRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(aracDurumText);
                                        $('tbody#adminAracRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                    } else {
                                        $("tbody#adminAracRow > tr > td > a").eq(t).html('<i class="fa fa-bus" style="color:red"></i> ' + aracPlaka);
                                        $("tbody#adminAracRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(aracMarka);
                                        $("tbody#adminAracRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(aracModelYil);
                                        $("tbody#adminAracRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(aracKapasite);
                                        $("tbody#adminAracRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(aracDurumText);
                                        $('tbody#adminAracRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                    }
                                }
                            }

                            aracBolgeID = [];
                            aracBolgeAd = [];
                            aracSoforID = [];
                            aracSoforAd = [];
                        }
                    }
                });
            } else {
                alert("Lütfen Bölge Seçiniz");
            }
        }
    },
    adminAracDetailTur: function () {
        AracTurTable.DataTable().clear().draw();
        var aracID = $("input[name=adminAracDetailDeger]").val();
        $.ajax({
            data: {"aracID": aracID, "tip": "adminAracDetailTur"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    if (cevap.adminAracDetailTur) {
                        var turCount = cevap.adminAracDetailTur.length;
                        for (var i = 0; i < turCount; i++) {
                            if (cevap.adminAracDetailTur[i].AracTurTip != 1) {
                                TurTip = 'Öğrenci';
                            } else {
                                TurTip = 'İşçi';
                            }

                            if (cevap.adminAracDetailTur[i].AracTurAktiflik != 0) {
                                var addRow = "<tr><td>"
                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.adminAracDetailTur[i].AracTurID + "'>"
                                        + "<i class='fa fa-map-marker'></i> " + cevap.adminAracDetailTur[i].AracDetailTurAdi + "</a></td>"
                                        + "<td class='hidden-xs' >" + TurTip + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.adminAracDetailTur[i].AracTurAcikla + "</td>"
                                        + "<td class='hidden-xs' value='" + cevap.adminAracTurBolge[i].AracTurKurumID + "'>" + cevap.adminAracTurKurum[i].AracTurKurumAdi + "</td>"
                                        + "<td class='hidden-xs' value='" + cevap.adminAracTurBolge[i].AracTurBolgeID + "'>" + cevap.adminAracTurBolge[i].AracTurBolgeAdi + "</td></tr>";
                                AracTurTable.DataTable().row.add($(addRow)).draw();
                            } else {
                                var addRow = "<tr><td>"
                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.adminAracDetailTur[i].AracTurID + "'>"
                                        + "<i class='fa fa-map-marker' style='color:red'></i> " + cevap.adminAracDetailTur[i].AracDetailTurAdi + "</a></td>"
                                        + "<td class='hidden-xs' >" + TurTip + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.adminAracDetailTur[i].AracTurAcikla + "</td>"
                                        + "<td class='hidden-xs' value='" + cevap.adminAracTurBolge[i].AracTurKurumID + "'>" + cevap.adminAracTurKurum[i].AracTurKurumAdi + "</td>"
                                        + "<td class='hidden-xs' value='" + cevap.adminAracTurBolge[i].AracTurBolgeID + "'>" + cevap.adminAracTurBolge[i].AracTurBolgeAdi + "</td></tr>";
                                AracTurTable.DataTable().row.add($(addRow)).draw();
                            }

                        }
                    }
                }
            }
        });
        return true;
    },
    adminYeni: function () {
        $("input[name=AdminAdi]").val(' ');
        $("input[name=AdminSoyadi]").val(' ');
        $("#AdminDurum").val("1");
        $("input[name=KurumLokasyon]").val(' ');
        $("input[name=AdminTelefon]").val(' ');
        $("input[name=AdminEmail]").val(' ');
        $("textarea[name=AdminAdresDetay]").val(' ');
        $("textarea[name=Aciklama]").val(' ');
        $("input[name=country]").val(' ');
        $("input[name=administrative_area_level_1]").val(' ');
        $("input[name=administrative_area_level_2]").val(' ');
        $("input[name=locality]").val(' ');
        $("input[name=neighborhood]").val(' ');
        $("input[name=route]").val(' ');
        $("input[name=postal_code]").val(' ');
        $("input[name=street_number]").val(' ');
        var BolgeOptions = new Array();
        $.ajax({
            data: {"tip": "adminEkleSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    if (cevap.adminBolge) {
                        var bolgelength = cevap.adminBolge.AdminBolgeID.length;
                        for (var i = 0; i < bolgelength; i++) {
                            BolgeOptions[i] = {label: cevap.adminBolge.AdminBolge[i], title: cevap.adminBolge.AdminBolge[i], value: cevap.adminBolge.AdminBolgeID[i]};
                        }
                    }

                    $('#AdminSelectBolge').multiselect('refresh');
                    $('#AdminSelectBolge').multiselect('dataprovider', BolgeOptions);
                    var selectLength = $('#AdminSelectBolge > option').length;
                    if (!selectLength) {
                        alert("Lütfen Öncelikle Bölge İşlemlerine Gidip Yeni Bölge Oluşturunuz");
                    }
                }

            }
        });
        return true;
    },
    adminVazgec: function () {
        return true;
    },
    adminEkle: function () {

        var adminAd = $("input[name=AdminAdi]").val();
        adminAd = adminAd.trim();
        if (adminAd == '') {
            alert("Ad Boş geçilemez");
        } else {
            if (adminAd.length < 2) {
                alert("İsim 2  karekterden az olamaz");
            } else {
                var adminSoyad = $("input[name=AdminSoyadi]").val();
                adminSoyad = adminSoyad.trim();
                if (adminSoyad == '') {
                    alert("Soyad Boş geçilemez");
                } else {
                    if (adminSoyad.length < 2) {
                        alert("Soyad 2  karekterden az olamaz");
                    } else {
                        var adminEmail = $("input[name=AdminEmail]").val();
                        if (adminEmail == ' ') {
                            alert("Eposta Boş geçilemez");
                        } else {
                            adminEmail = adminEmail.trim();
                            var result = ValidateEmail(adminEmail);
                            if (!result) {
                                alert("Lütfen uygun bir email giriniz");
                            } else {
                                var selectLength = $('#AdminSelectBolge > option').length;
                                if (selectLength) {
                                    var select = $('select#AdminSelectBolge option:selected').val();
                                    if (select) {
                                        var adminDurum = $("#AdminDurum option:selected").val();
                                        var adminLokasyon = $("input[name=KurumLokasyon]").val();
                                        var adminTelefon = $("input[name=AdminTelefon]").val();
                                        var adminAdres = $("textarea[name=AdminAdresDetay]").val();
                                        var aciklama = $("textarea[name=Aciklama]").val();
                                        var ulke = $("input[name=country]").val();
                                        var il = $("input[name=administrative_area_level_1]").val();
                                        var ilce = $("input[name=administrative_area_level_2]").val();
                                        var semt = $("input[name=locality]").val();
                                        var mahalle = $("input[name=neighborhood]").val();
                                        var sokak = $("input[name=route]").val();
                                        var postakodu = $("input[name=postal_code]").val();
                                        var caddeno = $("input[name=street_number]").val();
                                        //admin Bölge ID
                                        var adminBolgeID = new Array();
                                        $('select#AdminSelectBolge option:selected').each(function () {
                                            adminBolgeID.push($(this).val());
                                        });
                                        $.ajax({
                                            data: {"adminBolgeID[]": adminBolgeID, "adminAd": adminAd,
                                                "adminSoyad": adminSoyad, "adminDurum": adminDurum, "adminLokasyon": adminLokasyon, "adminTelefon": adminTelefon,
                                                "adminEmail": adminEmail, "adminAdres": adminAdres, "aciklama": aciklama, "ulke": ulke,
                                                "il": il, "ilce": ilce, "semt": semt, "mahalle": mahalle,
                                                "sokak": sokak, "postakodu": postakodu, "caddeno": caddeno, "tip": "adminKaydet"},
                                            success: function (cevap) {
                                                if (cevap.hata) {
                                                    alert(cevap.hata);
                                                } else {
                                                    var adminCount = $('#smallAdmin').text();
                                                    adminCount++;
                                                    $('#smallAdmin').text(adminCount);
                                                    if (adminDurum != 0) {
                                                        var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newAdminID + "'>"
                                                                + "<i class='glyphicon glyphicon-user' style='color:green;'></i> " + adminAd + "</a></td>"
                                                                + "<td class='hidden-xs'>" + adminSoyad + "</td>"
                                                                + "<td class='hidden-xs'>" + adminTelefon + "</td>"
                                                                + "<td class='hidden-xs'>" + adminEmail + "</td>"
                                                                + "<td class='hidden-xs'>" + aciklama + "</td>";
                                                        AdminTable.DataTable().row.add($(addRow)).draw();
                                                    } else {
                                                        var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newAdminID + "'>"
                                                                + "<i class='glyphicon glyphicon-user' style='color:red;'></i> " + adminAd + "</a></td>"
                                                                + "<td class='hidden-xs'>" + adminSoyad + "</td>"
                                                                + "<td class='hidden-xs'>" + adminTelefon + "</td>"
                                                                + "<td class='hidden-xs'>" + adminEmail + "</td>"
                                                                + "<td class='hidden-xs'>" + aciklama + "</td>";
                                                        AdminTable.DataTable().row.add($(addRow)).draw();
                                                    }
                                                    adminBolgeID = [];
                                                }
                                            }
                                        });
                                        return true;
                                    } else {
                                        alert("Lütfen Bölge Seçiniz");
                                    }
                                } else {
                                    alert("Lütfen Öncelikle Bölge İşlemlerine Gidip Yeni Bölge Oluşturunuz");
                                }
                            }
                        }
                    }
                }
            }
        }
    },
    adminDetailDuzenle: function () {

        //Admin İşlemleri değerleri
        var adminAd = $("input[name=AdminDetayAdi]").val();
        var adminSoyad = $("input[name=AdminDetaySoyadi]").val();
        var adminEmail = $("input[name=AdminDetayEmail]").val();
        var adminDurum = $("#AdminDetayDurum option:selected").val();
        var adminLokasyon = $("input[name=KurumLokasyon]").val();
        var adminTelefon = $("input[name=AdminDetayTelefon]").val();
        var adminAdres = $("textarea[name=AdminDetayAdresDetay]").val();
        var aciklama = $("textarea[name=DetayAciklama]").val();
        var ulke = $("input[name=country]").val();
        var il = $("input[name=administrative_area_level_1]").val();
        var ilce = $("input[name=administrative_area_level_2]").val();
        var semt = $("input[name=locality]").val();
        var mahalle = $("input[name=neighborhood]").val();
        var sokak = $("input[name=route]").val();
        var postakodu = $("input[name=postal_code]").val();
        var caddeno = $("input[name=street_number]").val();
        //admin Bölge ID
        var adminBolgeID = new Array();
        $('select#AdminDetaySelectBolge option:selected').each(function () {
            adminBolgeID.push($(this).val());
        });
        //admin Bölge Ad
        var adminBolgeAd = new Array();
        $('select#AdminDetaySelectBolge option:selected').each(function () {
            adminBolgeAd.push($(this).attr('title'));
        });
        //admin Seçili Olmayan Bölge ID
        var adminBolgeNID = new Array();
        $('select#AdminDetaySelectBolge option:not(:selected)').each(function () {
            adminBolgeNID.push($(this).val());
        });
        //admin Seçili Olmayan Bölge Ad
        var adminBolgeNAd = new Array();
        $('select#AdminDetaySelectBolge option:not(:selected)').each(function () {
            adminBolgeNAd.push($(this).attr('title'));
        });
        var SelectBolgeOptions = new Array();
        if (adminBolgeID.length > 0) {
            var bolgelength = adminBolgeID.length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: adminBolgeAd[b], title: adminBolgeAd[b], value: adminBolgeID[b], selected: true};
            }

            if (adminBolgeNID.length > 0) {
                var aracBolgeLength = adminBolgeNID.length;
                for (var z = 0; z < aracBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: adminBolgeNAd[z], title: adminBolgeNAd[z], value: adminBolgeNID[z]};
                    b++;
                }
            }
        } else {
            if (adminBolgeNID.length > 0) {
                var aracBolgeLength = adminBolgeNID.length;
                for (var b = 0; b < aracBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: adminBolgeNAd[b], title: adminBolgeNAd[b], value: adminBolgeNID[b]};
                }
            }
        }



        $('#AdminDetaySelectBolge').multiselect('refresh');
        $('#AdminDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
        AdminDetailVazgec = [];
        AdminDetailVazgec.push(adminAd, adminSoyad, adminEmail, adminDurum, adminLokasyon, adminTelefon, adminAdres, aciklama, ulke, il, ilce, semt, mahalle, sokak, postakodu, caddeno, adminBolgeID, adminBolgeAd, adminBolgeNID, adminBolgeNAd);
    },
    adminDetailVazgec: function () {

        $("input[name=AdminDetayAdi]").val(AdminDetailVazgec[0]);
        $("input[name=AdminDetaySoyadi]").val(AdminDetailVazgec[1]);
        $("input[name=AdminDetayEmail]").val(AdminDetailVazgec[2]);
        $("#AdminDetayDurum option:selected").val(AdminDetailVazgec[3]);
        $("input[name=KurumLokasyon]").val(AdminDetailVazgec[4]);
        $("input[name=AdminDetayTelefon]").val(AdminDetailVazgec[5]);
        $("textarea[name=AdminDetayAdresDetay]").val(AdminDetailVazgec[6]);
        $("textarea[name=DetayAciklama]").val(AdminDetailVazgec[7]);
        $("input[name=country]").val(AdminDetailVazgec[8]);
        $("input[name=administrative_area_level_1]").val(AdminDetailVazgec[9]);
        $("input[name=administrative_area_level_2]").val(AdminDetailVazgec[10]);
        $("input[name=locality]").val(AdminDetailVazgec[11]);
        $("input[name=neighborhood]").val(AdminDetailVazgec[12]);
        $("input[name=route]").val(AdminDetailVazgec[13]);
        $("input[name=postal_code]").val(AdminDetailVazgec[14]);
        $("input[name=street_number]").val(AdminDetailVazgec[15]);
        var SelectBolgeOptions = new Array();
        if (AdminDetailVazgec[16].length > 0) {
            var bolgelength = AdminDetailVazgec[16].length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: AdminDetailVazgec[17][b], title: AdminDetailVazgec[17][b], value: AdminDetailVazgec[16][b], selected: true, disabled: true};
            }
            if (AdminDetailVazgec[18].length > 0) {
                var adminBolgeLength = AdminDetailVazgec[18].length;
                for (var z = 0; z < adminBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: AdminDetailVazgec[19][z], title: AdminDetailVazgec[19][z], value: AdminDetailVazgec[18][z], disabled: true};
                    b++;
                }
            }
        } else {
            if (AdminDetailVazgec[18].length > 0) {
                var adminBolgeLength = AdminDetailVazgec[18].length;
                for (var b = 0; b < adminBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: AdminDetailVazgec[19][b], title: AdminDetailVazgec[19][b], value: AdminDetailVazgec[18][b], disabled: true};
                }
            }
        }


        $('#AdminDetaySelectBolge').multiselect('refresh');
        $('#AdminDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
    },
    adminDetailSil: function () {
        var admindetail_id = $("input[name=adminDetayID]").val();
        $.ajax({
            data: {"admindetail_id": admindetail_id, "tip": "adminDetailDelete"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    disabledForm();
                    $("input[name=AdminDetayAdi]").val();
                    $("input[name=AdminDetaySoyadi]").val();
                    $("input[name=AdminDetayEmail]").val();
                    $("#AdminDetayDurum option:selected").val();
                    $("input[name=KurumLokasyon]").val();
                    $("input[name=AdminDetayTelefon]").val();
                    $("textarea[name=AdminDetayAdresDetay]").val();
                    $("textarea[name=DetayAciklama]").val();
                    $("input[name=country]").val();
                    $("input[name=administrative_area_level_1]").val();
                    $("input[name=administrative_area_level_2]").val();
                    $("input[name=locality]").val();
                    $("input[name=neighborhood]").val();
                    $("input[name=route]").val();
                    $("input[name=postal_code]").val();
                    $("input[name=street_number]").val();
                    var adminCount = $('#smallAdmin').text();
                    adminCount--;
                    $('#smallAdmin').text(adminCount);
                    var length = $('tbody#adminRow tr').length;
                    for (var t = 0; t < length; t++) {
                        var attrValueId = $("tbody#adminRow > tr > td > a").eq(t).attr('value');
                        if (attrValueId == admindetail_id) {
                            var deleteRow = $('tbody#adminRow > tr:eq(' + t + ')');
                            AdminTable.DataTable().row($(deleteRow)).remove().draw();
                        }
                    }
                }
            }
        });
        return true;
    },
    adminDetailKaydet: function () {

        var admindetail_id = $("input[name=adminDetayID]").val();
        var adminAd = $("input[name=AdminDetayAdi]").val();
        var adminSoyad = $("input[name=AdminDetaySoyadi]").val();
        var adminEmail = $("input[name=AdminDetayEmail]").val();
        var adminDurum = $("#AdminDetayDurum option:selected").val();
        var adminLokasyon = $("input[name=KurumLokasyon]").val();
        var adminTelefon = $("input[name=AdminDetayTelefon]").val();
        var adminAdres = $("textarea[name=AdminDetayAdresDetay]").val();
        var aciklama = $("textarea[name=DetayAciklama]").val();
        var ulke = $("input[name=country]").val();
        var il = $("input[name=administrative_area_level_1]").val();
        var ilce = $("input[name=administrative_area_level_2]").val();
        var semt = $("input[name=locality]").val();
        var mahalle = $("input[name=neighborhood]").val();
        var sokak = $("input[name=route]").val();
        var postakodu = $("input[name=postal_code]").val();
        var caddeno = $("input[name=street_number]").val();
        //admin Bölge ID
        var adminBolgeID = new Array();
        $('select#AdminDetaySelectBolge option:selected').each(function () {
            adminBolgeID.push($(this).val());
        });
        //admin Bölge Ad
        var adminBolgeAd = new Array();
        $('select#AdminDetaySelectBolge option:selected').each(function () {
            adminBolgeAd.push($(this).attr('title'));
        });
        //admin Seçili Olmayan Bölge ID
        var adminBolgeNID = new Array();
        $('select#AdminDetaySelectBolge option:not(:selected)').each(function () {
            adminBolgeNID.push($(this).val());
        });
        //admin Seçili Olmayan Bölge Ad
        var adminBolgeNAd = new Array();
        $('select#AdminDetaySelectBolge option:not(:selected)').each(function () {
            adminBolgeNAd.push($(this).attr('title'));
        });
        var farkbolge = farkArray(AdminDetailVazgec[16], adminBolgeID);
        var farkbolgelength = farkbolge.length;
        if (AdminDetailVazgec[0] == adminAd && AdminDetailVazgec[1] == adminSoyad && AdminDetailVazgec[2] == adminEmail && AdminDetailVazgec[3] == adminDurum && AdminDetailVazgec[4] == adminLokasyon && AdminDetailVazgec[5] == adminTelefon && AdminDetailVazgec[6] == adminAdres && AdminDetailVazgec[7] == aciklama && AdminDetailVazgec[8] == ulke && AdminDetailVazgec[9] == il && AdminDetailVazgec[10] == ilce && AdminDetailVazgec[11] == semt && AdminDetailVazgec[12] == mahalle && AdminDetailVazgec[13] == sokak && AdminDetailVazgec[14] == postakodu && AdminDetailVazgec[15] == caddeno && farkbolgelength == 0) {
            alert("Lütfen değişiklik yaptığınıza emin olun.");
        } else {
            var bolgeselectLength = $('select#AdminDetaySelectBolge option:selected').val();
            if (bolgeselectLength) {
                $.ajax({
                    data: {"admindetail_id": admindetail_id, "adminBolgeID[]": adminBolgeID, "aracBolgeAd[]": adminBolgeAd, "adminAd": adminAd,
                        "adminSoyad": adminSoyad, "adminDurum": adminDurum, "adminLokasyon": adminLokasyon, "adminTelefon": adminTelefon,
                        "adminEmail": adminEmail, "adminAdres": adminAdres, "aciklama": aciklama, "ulke": ulke,
                        "il": il, "ilce": ilce, "semt": semt, "mahalle": mahalle,
                        "sokak": sokak, "postakodu": postakodu, "caddeno": caddeno, "tip": "adminDetailKaydet"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            alert(cevap.hata);
                        } else {

                            disabledForm();
                            var SelectBolgeOptions = new Array();
                            var SelectAracOptions = new Array();
                            if (adminBolgeID.length > 0) {
                                var bolgelength = adminBolgeID.length;
                                for (var b = 0; b < bolgelength; b++) {
                                    SelectBolgeOptions[b] = {label: adminBolgeAd[b], title: adminBolgeAd[b], value: adminBolgeID[b], disabled: true, selected: true};
                                }

                                if (adminBolgeNID.length > 0) {
                                    var adminBolgeLength = adminBolgeNID.length;
                                    for (var z = 0; z < adminBolgeLength; z++) {
                                        SelectBolgeOptions[b] = {label: adminBolgeNAd[z], title: adminBolgeNAd[z], value: adminBolgeNID[z], disabled: true};
                                        b++;
                                    }

                                }
                            } else {
                                if (adminBolgeNID.length > 0) {
                                    var adminBolgeLength = adminBolgeNID.length;
                                    for (var b = 0; b < adminBolgeLength; b++) {
                                        SelectBolgeOptions[b] = {label: adminBolgeNAd[b], title: adminBolgeNAd[b], value: adminBolgeNID[b], disabled: true};
                                    }
                                }
                            }



                            $('#AdminDetaySelectBolge').multiselect('refresh');
                            $('#AdminDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
                            var length = $('tbody#adminRow tr').length;
                            for (var t = 0; t < length; t++) {
                                var attrValueId = $("tbody#adminRow > tr > td > a").eq(t).attr('value');
                                if (attrValueId == admindetail_id) {
                                    if (adminDurum != 0) {
                                        $("tbody#adminRow > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-user"></i> ' + adminAd);
                                        $("tbody#adminRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(adminSoyad);
                                        $("tbody#adminRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(adminTelefon);
                                        $("tbody#adminRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(adminEmail);
                                        $("tbody#adminRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(aciklama);
                                        $('tbody#adminRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                    } else {
                                        $("tbody#adminRow > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-user" style="color:red"></i> ' + adminAd);
                                        $("tbody#adminRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(adminSoyad);
                                        $("tbody#adminRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(adminTelefon);
                                        $("tbody#adminRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(adminEmail);
                                        $("tbody#adminRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(aciklama);
                                        $('tbody#adminRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                    }
                                }
                            }

                            adminBolgeID = [];
                            adminBolgeAd = [];
                        }
                    }
                });
            } else {
                alert("Lütfen Bölge Seçiniz.");
            }

        }
    },
    soforYeni: function () {
        $("input[name=SoforAdi]").val(' ');
        $("input[name=SoforSoyadi]").val(' ');
        $("#SoforDurum").val("1");
        $("input[name=KurumLokasyon]").val(' ');
        $("input[name=SoforTelefon]").val(' ');
        $("input[name=SoforEmail]").val(' ');
        $("textarea[name=SoforAdresDetay]").val(' ');
        $("textarea[name=Aciklama]").val(' ');
        $("input[name=country]").val(' ');
        $("input[name=administrative_area_level_1]").val(' ');
        $("input[name=administrative_area_level_2]").val(' ');
        $("input[name=locality]").val(' ');
        $("input[name=neighborhood]").val(' ');
        $("input[name=route]").val(' ');
        $("input[name=postal_code]").val(' ');
        $("input[name=street_number]").val(' ');
        var BolgeOptions = new Array();
        var AracOptions = new Array();
        $.ajax({
            data: {"tip": "soforEkleSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    if (cevap.adminBolge) {
                        var bolgelength = cevap.adminBolge.AdminBolgeID.length;
                        for (var i = 0; i < bolgelength; i++) {
                            BolgeOptions[i] = {label: cevap.adminBolge.AdminBolge[i], title: cevap.adminBolge.AdminBolge[i], value: cevap.adminBolge.AdminBolgeID[i]};
                        }
                        $('#SoforSelectBolge').multiselect('refresh');
                        $('#SoforSelectBolge').multiselect('dataprovider', BolgeOptions);
                    } else {
                        $('#SoforSelectBolge').multiselect('refresh');
                        $('#SoforSelectBolge').multiselect('dataprovider', BolgeOptions);
                    }

                    $('#SoforAracSelect').multiselect('refresh');
                    $('#SoforAracSelect').multiselect('dataprovider', AracOptions);
                    var selectLength = $('#SoforSelectBolge > option').length;
                    if (!selectLength) {
                        alert("Lütfen Öncelikle Bölge İşlemlerine Gidip Yeni Bölge Oluşturunuz");
                    }
                }

            }
        });
        return true;
    },
    soforVazgec: function () {
        return true;
    },
    soforEkle: function () {

        var soforAd = $("input[name=SoforAdi]").val();
        soforAd = soforAd.trim();
        if (soforAd == '') {
            alert("Ad Boş geçilemez");
        } else {
            if (soforAd.length < 2) {
                alert("İsim 2  karekterden az olamaz");
            } else {
                var soforSoyad = $("input[name=SoforSoyadi]").val();
                soforSoyad = soforSoyad.trim();
                if (soforSoyad == '') {
                    alert("Soyad Boş geçilemez");
                } else {
                    if (soforSoyad.length < 2) {
                        alert("Soyad 2  karekterden az olamaz");
                    } else {
                        var soforEmail = $("input[name=SoforEmail]").val();
                        if (soforEmail == ' ') {
                            alert("Eposta Boş geçilemez");
                        } else {
                            soforEmail = soforEmail.trim();
                            var result = ValidateEmail(soforEmail);
                            if (!result) {
                                alert("Lütfen uygun bir email giriniz");
                            } else {
                                var selectLength = $('#SoforSelectBolge > option').length;
                                if (selectLength) {
                                    var select = $('select#SoforSelectBolge option:selected').val();
                                    if (select) {
                                        var soforDurum = $("#SoforDurum option:selected").val();
                                        var soforLokasyon = $("input[name=KurumLokasyon]").val();
                                        var soforTelefon = $("input[name=SoforTelefon]").val();
                                        var soforAdres = $("textarea[name=SoforAdresDetay]").val();
                                        var aciklama = $("textarea[name=Aciklama]").val();
                                        var ulke = $("input[name=country]").val();
                                        var il = $("input[name=administrative_area_level_1]").val();
                                        var ilce = $("input[name=administrative_area_level_2]").val();
                                        var semt = $("input[name=locality]").val();
                                        var mahalle = $("input[name=neighborhood]").val();
                                        var sokak = $("input[name=route]").val();
                                        var postakodu = $("input[name=postal_code]").val();
                                        var caddeno = $("input[name=street_number]").val();
                                        //şoför Bölge ID
                                        var soforBolgeID = new Array();
                                        $('select#SoforSelectBolge option:selected').each(function () {
                                            soforBolgeID.push($(this).val());
                                        });
                                        //şoför Bölge Adi
                                        var soforBolgeAdi = new Array();
                                        $('select#SoforSelectBolge option:selected').each(function () {
                                            soforBolgeAdi.push($(this).attr('title'));
                                        });
                                        //şöfor Arac ID
                                        var soforAracID = new Array();
                                        $('select#SoforAracSelect option:selected').each(function () {
                                            soforAracID.push($(this).val());
                                        });
                                        //şöfor Arac ID
                                        var soforAracPlaka = new Array();
                                        $('select#SoforAracSelect option:selected').each(function () {
                                            soforAracPlaka.push($(this).attr('title'));
                                        });
                                        $.ajax({
                                            data: {"soforBolgeID[]": soforBolgeID, "soforBolgeAdi[]": soforBolgeAdi, "soforAracID[]": soforAracID, "soforAracPlaka[]": soforAracPlaka, "soforAd": soforAd,
                                                "soforSoyad": soforSoyad, "soforDurum": soforDurum, "soforLokasyon": soforLokasyon, "soforTelefon": soforTelefon,
                                                "soforEmail": soforEmail, "soforAdres": soforAdres, "aciklama": aciklama, "ulke": ulke,
                                                "il": il, "ilce": ilce, "semt": semt, "mahalle": mahalle,
                                                "sokak": sokak, "postakodu": postakodu, "caddeno": caddeno, "tip": "soforKaydet"},
                                            success: function (cevap) {
                                                if (cevap.hata) {
                                                    alert(cevap.hata);
                                                } else {
                                                    var soforCount = $('#smallSofor').text();
                                                    soforCount++;
                                                    $('#smallSofor').text(soforCount);
                                                    if (soforDurum != 0) {
                                                        var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newSoforID + "'>"
                                                                + "<i class='glyphicon glyphicon-user' style='color:green;'></i> " + soforAd + "</a></td>"
                                                                + "<td class='hidden-xs'>" + soforSoyad + "</td>"
                                                                + "<td class='hidden-xs'>" + soforTelefon + "</td>"
                                                                + "<td class='hidden-xs'>" + soforEmail + "</td>"
                                                                + "<td class='hidden-xs'>" + aciklama + "</td>";
                                                        SoforTable.DataTable().row.add($(addRow)).draw();
                                                    } else {
                                                        var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newSoforID + "'>"
                                                                + "<i class='glyphicon glyphicon-user' style='color:red;'></i> " + soforAd + "</a></td>"
                                                                + "<td class='hidden-xs'>" + soforSoyad + "</td>"
                                                                + "<td class='hidden-xs'>" + soforTelefon + "</td>"
                                                                + "<td class='hidden-xs'>" + soforEmail + "</td>"
                                                                + "<td class='hidden-xs'>" + aciklama + "</td>";
                                                        SoforTable.DataTable().row.add($(addRow)).draw();
                                                    }
                                                    soforBolgeID = [];
                                                    soforAracID = [];
                                                }
                                            }
                                        });
                                        return true;
                                    } else {
                                        alert("Lütfen Bölge Seçiniz");
                                    }
                                } else {
                                    alert("Lütfen Öncelikle Bölge İşlemlerine Gidip Yeni Bölge Oluşturunuz");
                                }
                            }
                        }
                    }
                }
            }
        }
    },
    soforDetailVazgec: function () {
        $("input[name=SoforDetayAdi]").val(SoforDetailVazgec[0]);
        $("input[name=SoforDetaySoyadi]").val(SoforDetailVazgec[1]);
        $("#SoforDetayDurum").val(SoforDetailVazgec[2]);
        $("input[name=KurumLokasyon]").val(SoforDetailVazgec[3]);
        $("input[name=SoforDetayTelefon]").val(SoforDetailVazgec[4]);
        $("input[name=SoforDetayEmail]").val(SoforDetailVazgec[5]);
        $("textarea[name=SoforDetayAdresDetay]").val(SoforDetailVazgec[6]);
        $("textarea[name=DetayAciklama]").val(SoforDetailVazgec[7]);
        $("input[name=country]").val(SoforDetailVazgec[8]);
        $("input[name=administrative_area_level_1]").val(SoforDetailVazgec[9]);
        $("input[name=administrative_area_level_2]").val(SoforDetailVazgec[10]);
        $("input[name=locality]").val(SoforDetailVazgec[11]);
        $("input[name=neighborhood]").val(SoforDetailVazgec[12]);
        $("input[name=route]").val(SoforDetailVazgec[13]);
        $("input[name=postal_code]").val(SoforDetailVazgec[14]);
        $("input[name=street_number]").val(SoforDetailVazgec[15]);

        var SelectBolgeOptions = new Array();
        var SelectSoforOptions = new Array();

        if (SoforDetailVazgec[16].length > 0) {
            var bolgelength = SoforDetailVazgec[16].length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: SoforDetailVazgec[17][b], title: SoforDetailVazgec[17][b], value: SoforDetailVazgec[16][b], selected: true, disabled: true};
            }
            if (SoforDetailVazgec[18].length > 0) {
                var aracBolgeLength = SoforDetailVazgec[18].length;
                for (var z = 0; z < aracBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: SoforDetailVazgec[19][z], title: SoforDetailVazgec[19][z], value: SoforDetailVazgec[18][z], disabled: true};
                    b++;
                }
            }
        } else {
            if (SoforDetailVazgec[18].length > 0) {
                var aracBolgeLength = SoforDetailVazgec[18].length;
                for (var b = 0; b < aracBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: SoforDetailVazgec[19][b], title: SoforDetailVazgec[19][b], value: SoforDetailVazgec[18][b], disabled: true};
                }
            }
        }


        if (SoforDetailVazgec[20].length > 0) {
            var aracselectlength = SoforDetailVazgec[20].length;
            for (var t = 0; t < aracselectlength; t++) {
                SelectSoforOptions[t] = {label: SoforDetailVazgec[21][t], title: SoforDetailVazgec[21][t], value: SoforDetailVazgec[20][t], selected: true, disabled: true};
            }
            if (SoforDetailVazgec[22].length > 0) {
                var araclength = SoforDetailVazgec[21].length;
                for (var f = 0; f < araclength; f++) {
                    SelectSoforOptions[t] = {label: SoforDetailVazgec[23][f], title: SoforDetailVazgec[23][f], value: SoforDetailVazgec[22][f], disabled: true};
                    t++;
                }
            }
        } else {
            if (SoforDetailVazgec[22].length > 0) {
                var araclength = SoforDetailVazgec[22].length;
                for (var t = 0; t < araclength; t++) {
                    SelectSoforOptions[t] = {label: SoforDetailVazgec[23][t], title: SoforDetailVazgec[23][t], value: SoforDetailVazgec[22][t], disabled: true};
                }
            }
        }

        $('#SoforDetaySelectBolge').multiselect('refresh');
        $('#SoforDetayArac').multiselect('refresh');
        $('#SoforDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
        $('#SoforDetayArac').multiselect('dataprovider', SelectSoforOptions);
    },
    soforDetailDuzenle: function () {
        //Şoför İşlemleri Değerleri
        var soforDetayAd = $("input[name=SoforDetayAdi]").val();
        var soforDetaySoyad = $("input[name=SoforDetaySoyadi]").val();
        var soforDetayDurum = $("#SoforDetayDurum").val();
        var soforDetayLokasyon = $("input[name=KurumLokasyon]").val();
        var soforDetayTelefon = $("input[name=SoforDetayTelefon]").val();
        var soforDetayEmail = $("input[name=SoforDetayEmail]").val();
        var soforDetayAdres = $("textarea[name=SoforDetayAdresDetay]").val();
        var soforDetayAciklama = $("textarea[name=DetayAciklama]").val();
        var soforDetayUlke = $("input[name=country]").val();
        var soforDetayIl = $("input[name=administrative_area_level_1]").val();
        var soforDetayIlce = $("input[name=administrative_area_level_2]").val();
        var soforDetaySemt = $("input[name=locality]").val();
        var soforDetayMahalle = $("input[name=neighborhood]").val();
        var soforDetaySokak = $("input[name=route]").val();
        var soforDetayPostaKodu = $("input[name=postal_code]").val();
        var soforDetayCaddeNo = $("input[name=street_number]").val();

        //şoför Bölge ID
        var soforBolgeID = new Array();
        $('select#SoforDetaySelectBolge option:selected').each(function () {
            soforBolgeID.push($(this).val());
        });
        //şoför Bölge Ad
        var soforBolgeAd = new Array();
        $('select#SoforDetaySelectBolge option:selected').each(function () {
            soforBolgeAd.push($(this).attr('title'));
        });
        //şoför Şoför Id
        var soforAracID = new Array();
        $('select#SoforDetayArac option:selected').each(function () {
            soforAracID.push($(this).val());
        });
        //şoför Şoför Ad
        var soforAracPlaka = new Array();
        $('select#SoforDetayArac option:selected').each(function () {
            soforAracPlaka.push($(this).attr('title'));
        });
        //şoför Seçili Olmayan Bölge ID
        var soforBolgeNID = new Array();
        $('select#SoforDetaySelectBolge option:not(:selected)').each(function () {
            soforBolgeNID.push($(this).val());
        });
        //şoför Seçili Olmayan Bölge Ad
        var soforBolgeNAd = new Array();
        $('select#SoforDetaySelectBolge option:not(:selected)').each(function () {
            soforBolgeNAd.push($(this).attr('title'));
        });
        //şoför Seçili Olmayan Şoför Id
        var soforAracNID = new Array();
        $('select#SoforDetayArac option:not(:selected)').each(function () {
            soforAracNID.push($(this).val());
        });
        //şoför Seçili Olmayan Şoför Ad
        var soforAracNAd = new Array();
        $('select#SoforDetayArac option:not(:selected)').each(function () {
            soforAracNAd.push($(this).attr('title'));
        });

        var SelectBolgeOptions = new Array();
        var SelectSoforOptions = new Array();
        if (soforBolgeID.length > 0) {
            var bolgelength = soforBolgeID.length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: soforBolgeAd[b], title: soforBolgeAd[b], value: soforBolgeID[b], selected: true};
            }

            if (soforBolgeNID.length > 0) {
                var soforBolgeLength = soforBolgeNID.length;
                for (var z = 0; z < soforBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: soforBolgeNAd[z], title: soforBolgeNAd[z], value: soforBolgeNID[z]};
                    b++;
                }

            }
        } else {
            if (soforBolgeNID.length > 0) {
                var soforBolgeLength = soforBolgeNID.length;
                for (var b = 0; b < soforBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: soforBolgeNAd[b], title: soforBolgeNAd[b], value: soforBolgeNID[b]};
                }

            }
        }

        if (soforAracID.length > 0) {
            var aracselectlength = soforAracID.length;
            for (var t = 0; t < aracselectlength; t++) {
                SelectSoforOptions[t] = {label: soforAracPlaka[t], title: soforAracPlaka[t], value: soforAracID[t], selected: true};
            }

            if (soforAracNID.length > 0) {
                var araclength = soforAracNID.length;
                for (var f = 0; f < araclength; f++) {
                    SelectSoforOptions[t] = {label: soforAracNAd[f], title: soforAracNAd[f], value: soforAracNID[f]};
                    t++;
                }
            }

        } else {
            if (soforAracNID.length > 0) {
                var araclength = soforAracNID.length;
                for (var t = 0; t < araclength; t++) {
                    SelectSoforOptions[t] = {label: soforAracNAd[t], title: soforAracNAd[t], value: soforAracNID[t]};
                }
            }
        }

        $('#SoforDetaySelectBolge').multiselect('refresh');
        $('#SoforDetayArac').multiselect('refresh');
        $('#SoforDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
        $('#SoforDetayArac').multiselect('dataprovider', SelectSoforOptions);
        SoforDetailVazgec = [];
        SoforDetailVazgec.push(soforDetayAd, soforDetaySoyad, soforDetayDurum, soforDetayLokasyon, soforDetayTelefon, soforDetayEmail, soforDetayAdres, soforDetayAciklama, soforDetayUlke, soforDetayIl, soforDetayIlce, soforDetaySemt, soforDetayMahalle, soforDetaySokak, soforDetayPostaKodu, soforDetayCaddeNo, soforBolgeID, soforBolgeAd, soforBolgeNID, soforBolgeNAd, soforAracID, soforAracPlaka, soforAracNID, soforAracNAd);
    },
    soforDetailSil: function () {
        var sofordetail_id = $("input[name=soforDetayID]").val();
        $.ajax({
            data: {"sofordetail_id": sofordetail_id, "tip": "soforDetailDelete"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    disabledForm();
                    $("input[name=SoforDetayAdi]").val(' ');
                    $("input[name=SoforDetaySoyadi]").val(' ');
                    $("#SoforDetayDurum").val(' ');
                    $("input[name=KurumLokasyon]").val(' ');
                    $("input[name=SoforDetayTelefon]").val(' ');
                    $("input[name=SoforDetayEmail]").val(' ');
                    $("textarea[name=SoforDetayAdresDetay]").val(' ');
                    $("textarea[name=DetayAciklama]").val(' ');
                    $("input[name=country]").val(' ');
                    $("input[name=administrative_area_level_1]").val(' ');
                    $("input[name=administrative_area_level_2]").val(' ');
                    $("input[name=locality]").val(' ');
                    $("input[name=neighborhood]").val(' ');
                    $("input[name=route]").val(' ');
                    $("input[name=postal_code]").val(' ');
                    $("input[name=street_number]").val(' ');
                    var soforCount = $('#smallSofor').text(' ');
                    soforCount--;
                    $('#smallSofor').text(soforCount);
                    var length = $('tbody#soforRow tr').length;
                    for (var t = 0; t < length; t++) {
                        var attrValueId = $("tbody#soforRow > tr > td > a").eq(t).attr('value');
                        if (attrValueId == sofordetail_id) {
                            var deleteRow = $('tbody#soforRow > tr:eq(' + t + ')');
                            SoforTable.DataTable().row($(deleteRow)).remove().draw();
                        }
                    }
                }
            }
        });
        return true;
    },
    soforDetailKaydet: function () {
        var sofordetail_id = $("input[name=soforDetayID]").val();
        //Şoför İşlemleri Değerleri
        var soforDetayAd = $("input[name=SoforDetayAdi]").val();
        var soforDetaySoyad = $("input[name=SoforDetaySoyadi]").val();
        var soforDetayDurum = $("#SoforDetayDurum").val();
        var soforDetayLokasyon = $("input[name=KurumLokasyon]").val();
        var soforDetayTelefon = $("input[name=SoforDetayTelefon]").val();
        var soforDetayEmail = $("input[name=SoforDetayEmail]").val();
        var soforDetayAdres = $("textarea[name=SoforDetayAdresDetay]").val();
        var soforDetayAciklama = $("textarea[name=DetayAciklama]").val();
        var soforDetayUlke = $("input[name=country]").val();
        var soforDetayIl = $("input[name=administrative_area_level_1]").val();
        var soforDetayIlce = $("input[name=administrative_area_level_2]").val();
        var soforDetaySemt = $("input[name=locality]").val();
        var soforDetayMahalle = $("input[name=neighborhood]").val();
        var soforDetaySokak = $("input[name=route]").val();
        var soforDetayPostaKodu = $("input[name=postal_code]").val();
        var soforDetayCaddeNo = $("input[name=street_number]").val();

        //şoför Bölge ID
        var soforBolgeID = new Array();
        $('select#SoforDetaySelectBolge option:selected').each(function () {
            soforBolgeID.push($(this).val());
        });
        //şoför Bölge Ad
        var soforBolgeAd = new Array();
        $('select#SoforDetaySelectBolge option:selected').each(function () {
            soforBolgeAd.push($(this).attr('title'));
        });
        //şoför Şoför Id
        var soforAracID = new Array();
        $('select#SoforDetayArac option:selected').each(function () {
            soforAracID.push($(this).val());
        });
        //şoför Şoför Ad
        var soforAracPlaka = new Array();
        $('select#SoforDetayArac option:selected').each(function () {
            soforAracPlaka.push($(this).attr('title'));
        });
        //şoför Seçili Olmayan Bölge ID
        var soforBolgeNID = new Array();
        $('select#SoforDetaySelectBolge option:not(:selected)').each(function () {
            soforBolgeNID.push($(this).val());
        });
        //şoför Seçili Olmayan Bölge Ad
        var soforBolgeNAd = new Array();
        $('select#SoforDetaySelectBolge option:not(:selected)').each(function () {
            soforBolgeNAd.push($(this).attr('title'));
        });
        //şoför Seçili Olmayan Şoför Id
        var soforAracNID = new Array();
        $('select#SoforDetayArac option:not(:selected)').each(function () {
            soforAracNID.push($(this).val());
        });
        //şoför Seçili Olmayan Şoför Ad
        var soforAracNAd = new Array();
        $('select#SoforDetayArac option:not(:selected)').each(function () {
            soforAracNAd.push($(this).attr('title'));
        });

        var farkbolge = farkArray(SoforDetailVazgec[16], soforBolgeID);
        var farkbolgelength = farkbolge.length;
        var farksofor = farkArray(SoforDetailVazgec[20], soforAracID);
        var farksoforlength = farksofor.length;

        if (SoforDetailVazgec[0] == soforDetayAd && SoforDetailVazgec[1] == soforDetaySoyad && SoforDetailVazgec[2] == soforDetayDurum && SoforDetailVazgec[3] == soforDetayLokasyon && SoforDetailVazgec[4] == soforDetayTelefon && SoforDetailVazgec[5] == soforDetayEmail && SoforDetailVazgec[6] == soforDetayAdres && SoforDetailVazgec[7] == soforDetayAciklama && SoforDetailVazgec[8] == soforDetayUlke && SoforDetailVazgec[9] == soforDetayIl && SoforDetailVazgec[10] == soforDetayIlce && SoforDetailVazgec[11] == soforDetaySemt && SoforDetailVazgec[12] == soforDetayMahalle && SoforDetailVazgec[13] == soforDetaySokak && SoforDetailVazgec[14] == soforDetayPostaKodu && SoforDetailVazgec[15] == soforDetayCaddeNo && farkbolgelength == 0 && farksoforlength == 0) {
            alert("Lütfen değişiklik yaptığınıza emin olun.");
        } else {
            var soforBolgeLength = $('select#SoforDetaySelectBolge option:selected').val();
            if (soforBolgeLength) {
                $.ajax({
                    data: {"sofordetail_id": sofordetail_id, "soforBolgeID[]": soforBolgeID, "soforBolgeAd[]": soforBolgeAd, "soforAracID[]": soforAracID, "soforAracPlaka[]": soforAracPlaka, "soforDetayAd": soforDetayAd,
                        "soforDetaySoyad": soforDetaySoyad, "soforDetayDurum": soforDetayDurum, "soforDetayLokasyon": soforDetayLokasyon, "soforDetayTelefon": soforDetayTelefon,
                        "soforDetayEmail": soforDetayEmail, "soforDetayAdres": soforDetayAdres, "soforDetayAciklama": soforDetayAciklama, "soforDetayUlke": soforDetayUlke,
                        "soforDetayIl": soforDetayIl, "soforDetayIlce": soforDetayIlce, "soforDetaySemt": soforDetaySemt, "soforDetayMahalle": soforDetayMahalle,
                        "soforDetaySokak": soforDetaySokak, "soforDetayPostaKodu": soforDetayPostaKodu, "soforDetayCaddeNo": soforDetayCaddeNo, "tip": "soforDetailKaydet"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            alert(cevap.hata);
                        } else {

                            disabledForm();
                            var SelectBolgeOptions = new Array();
                            var SelectSoforOptions = new Array();
                            if (soforBolgeID.length > 0) {
                                var bolgelength = soforBolgeID.length;
                                for (var b = 0; b < bolgelength; b++) {
                                    SelectBolgeOptions[b] = {label: soforBolgeAd[b], title: soforBolgeAd[b], value: soforBolgeID[b], disabled: true, selected: true};
                                }
                            }
                            if (soforBolgeNID.length > 0) {
                                var aracBolgeLength = soforBolgeNID.length;
                                for (var z = 0; z < aracBolgeLength; z++) {
                                    SelectBolgeOptions[b] = {label: soforBolgeNAd[z], title: soforBolgeNAd[z], value: soforBolgeNID[z], disabled: true};
                                    b++;
                                }

                            }
                            if (soforAracID.length > 0) {
                                var soforselectlength = soforAracID.length;
                                for (var t = 0; t < soforselectlength; t++) {
                                    SelectSoforOptions[t] = {label: soforAracPlaka[t], title: soforAracPlaka[t], value: soforAracID[t], disabled: true, selected: true};
                                }

                                if (soforAracNID.length > 0) {
                                    var soforlength = soforAracNID.length;
                                    for (var f = 0; f < soforlength; f++) {
                                        SelectSoforOptions[t] = {label: soforAracNAd[f], title: soforAracNAd[f], value: soforAracNID[f], disabled: true};
                                        t++;
                                    }
                                }
                            } else {
                                if (soforAracNID.length > 0) {
                                    var soforlength = soforAracNID.length;
                                    for (var t = 0; f < soforlength; t++) {
                                        SelectSoforOptions[t] = {label: soforAracNAd[t], title: soforAracNAd[t], value: soforAracNID[t], disabled: true};
                                    }
                                }
                            }

                            $('#SoforDetaySelectBolge').multiselect('refresh');
                            $('#SoforDetayArac').multiselect('refresh');
                            $('#SoforDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
                            $('#SoforDetayArac').multiselect('dataprovider', SelectSoforOptions);
                            var length = $('tbody#soforRow tr').length;
                            for (var t = 0; t < length; t++) {
                                var attrValueId = $("tbody#soforRow > tr > td > a").eq(t).attr('value');
                                if (attrValueId == sofordetail_id) {
                                    if (soforDetayDurum != 0) {
                                        $("tbody#soforRow > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-user"></i> ' + soforDetayAd);
                                        $("tbody#soforRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(soforDetaySoyad);
                                        $("tbody#soforRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(soforDetayTelefon);
                                        $("tbody#soforRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(soforDetayEmail);
                                        $("tbody#soforRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(soforDetayAciklama);
                                        $('tbody#soforRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                    } else {
                                        $("tbody#soforRow > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-user" style="color:red"></i> ' + soforDetayAd);
                                        $("tbody#soforRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(soforDetaySoyad);
                                        $("tbody#soforRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(soforDetayTelefon);
                                        $("tbody#soforRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(soforDetayEmail);
                                        $("tbody#soforRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(soforDetayAciklama);
                                        $('tbody#soforRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                alert("Lütfen Bölge Seçiniz");
            }
        }
    },
}


