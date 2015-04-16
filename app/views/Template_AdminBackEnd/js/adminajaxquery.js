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
        var i = $(this).find("i")
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
        var i = $(this).find("i")
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
                    }
                    if (cevap.adminAracBolge) {
                        var aracBolgeLength = cevap.adminAracBolge.length;
                        for (var z = 0; z < aracBolgeLength; z++) {
                            SelectBolgeOptions[b] = {label: cevap.adminAracBolge[z].DigerAracBolgeAdi, title: cevap.adminAracBolge[z].DigerAracBolgeAdi, value: cevap.adminAracBolge[z].DigerAracBolgeID, disabled: true};
                            b++;
                        }

                    }

                    if (cevap.adminAracSelectSofor) {
                        var soforselectlength = cevap.adminAracSelectSofor.length;
                        for (var t = 0; t < soforselectlength; t++) {
                            SelectAracOptions[t] = {label: cevap.adminAracSelectSofor[t].SelectAracSoforAdi, title: cevap.adminAracSelectSofor[t].SelectAracSoforAdi, value: cevap.adminAracSelectSofor[t].SelectAracSoforID, selected: true, disabled: true};
                        }
                    }
                    if (cevap.adminAracSofor) {
                        var soforlength = cevap.adminAracSofor.length;
                        for (var f = 0; f < soforlength; f++) {
                            SelectAracOptions[t] = {label: cevap.adminAracSofor[f].DigerAracSoforAdi, title: cevap.adminAracSofor[f].DigerAracSoforAdi, value: cevap.adminAracSofor[f].DigerAracSoforID, disabled: true};
                            t++;
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
        $("input[name=AracMarka]").val('');
        $("input[name=AracYil]").val('');
        $("textarea[name=AracAciklama]").val('');
        $("input[name=AracKapasite]").val('');
        var BolgeOptions = new Array();
        var AracOptions = new Array();
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
                    if (cevap.adminAracSofor) {
                        var soforLength = cevap.adminAracSofor.AdminSoforID.length;
                        for (var t = 0; t < soforLength; t++) {
                            AracOptions[t] = {label: cevap.adminAracSofor.AdminSoforAd[t] + ' ' + cevap.adminAracSofor.AdminSoforSoyad[t], title: cevap.adminAracSofor.AdminSoforAd[t] + ' ' + cevap.adminAracSofor.AdminSoforSoyad[t], value: cevap.adminAracSofor.AdminSoforID[t]};
                        }
                    }
                    $('#AracBolgeSelect').multiselect('refresh');
                    $('#AracSurucu').multiselect('refresh');
                    $('#AracBolgeSelect').multiselect('dataprovider', BolgeOptions);
                    $('#AracSurucu').multiselect('dataprovider', AracOptions);
                }

            }
        });
        return true;
    },
    adminAracEkle: function () {

        var aracPlaka = $("input[name=AracPlaka]").val();
        if (aracPlaka == '') {
            alert("Plaka Boş geçilemez");
        } else {

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
        }
        if (aracBolgeNID.length > 0) {
            var aracBolgeLength = aracBolgeNID.length;
            for (var z = 0; z < aracBolgeLength; z++) {
                SelectBolgeOptions[b] = {label: aracBolgeNAd[z], title: aracBolgeNAd[z], value: aracBolgeNID[z]};
                b++;
            }

        }
        if (aracSoforID.length > 0) {
            var soforselectlength = aracSoforID.length;
            for (var t = 0; t < soforselectlength; t++) {
                SelectAracOptions[t] = {label: aracSoforAd[t], title: aracSoforAd[t], value: aracSoforID[t], selected: true};
            }
        }
        if (aracSoforNID.length > 0) {
            var soforlength = aracSoforNID.length;
            for (var f = 0; f < soforlength; f++) {
                SelectAracOptions[t] = {label: aracSoforNAd[f], title: aracSoforNAd[f], value: aracSoforNID[f]};
                t++;
            }
        }

        $('#AracDetayBolgeSelect').multiselect('refresh');
        $('#AracDetaySurucu').multiselect('refresh');
        $('#AracDetayBolgeSelect').multiselect('dataprovider', SelectBolgeOptions);
        $('#AracDetaySurucu').multiselect('dataprovider', SelectAracOptions);
        AdminAracDetailVazgec = [];
        AdminAracDetailVazgec.push(aracPlaka, aracMarka, aracModelYil, aracKapasite, aracAciklama, aracDurum, aracBolgeID, aracBolgeAd, aracBolgeNID, aracBolgeNAd, aracSoforID, aracSoforAd, aracSoforNID, aracSoforNAd);
        console.log(AdminAracDetailVazgec);
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
        }
        if (AdminAracDetailVazgec[8].length > 0) {
            var aracBolgeLength = AdminAracDetailVazgec[8].length;
            for (var z = 0; z < aracBolgeLength; z++) {
                SelectBolgeOptions[b] = {label: AdminAracDetailVazgec[9][z], title: AdminAracDetailVazgec[9][z], value: AdminAracDetailVazgec[8][z], disabled: true};
                b++;
            }
        }
        if (AdminAracDetailVazgec[10].length > 0) {
            var soforselectlength = AdminAracDetailVazgec[10].length;
            for (var t = 0; t < soforselectlength; t++) {
                SelectAracOptions[t] = {label: AdminAracDetailVazgec[11][t], title: AdminAracDetailVazgec[11][t], value: AdminAracDetailVazgec[10][t], selected: true, disabled: true};
            }
        }
        if (AdminAracDetailVazgec[12].length > 0) {
            var soforlength = AdminAracDetailVazgec[12].length;
            for (var f = 0; f < soforlength; f++) {
                SelectAracOptions[t] = {label: AdminAracDetailVazgec[13][f], title: AdminAracDetailVazgec[13][f], value: AdminAracDetailVazgec[12][f], disabled: true};
                t++;
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
        var aracPlaka = $("input[name=AracDetayPlaka]").val();
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
                        }
                        if (aracSoforNID.length > 0) {
                            var soforlength = aracSoforNID.length;
                            for (var f = 0; f < soforlength; f++) {
                                SelectAracOptions[t] = {label: aracSoforNAd[f], title: aracSoforNAd[f], value: aracSoforNID[f], disabled: true};
                                t++;
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
                                $("tbody#adminAracRow > tr > td > a").eq(t).html('<i class="fa fa-bus"></i> ' + aracPlaka);
                                $("tbody#adminAracRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(aracMarka);
                                $("tbody#adminAracRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(aracModelYil);
                                $("tbody#adminAracRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(aracKapasite);
                                $("tbody#adminAracRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(aracDurumText);
                                $('tbody#adminAracRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                            }
                        }

                        aracBolgeID = [];
                        aracBolgeAd = [];
                        aracSoforID = [];
                        aracSoforAd = [];
                    }
                }
            });
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
    }
}


