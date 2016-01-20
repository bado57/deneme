$.ajaxSetup({
    type: "post",
    url: SITE_URL + "AdminSoforAjaxSorgu",
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

    SoforTable = $('#soforTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    SoforTurTable = $('#soforTurTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    //Şoför işlemleri
    $(document).on('click', 'tbody#soforRow > tr > td > a', function (e) {
        var i = $(this).find("i");
        i.removeClass("glyphicon glyphicon-user");
        i.addClass("fa fa-spinner");
        var soforRowid = $(this).attr('value');
        $.ajax({
            data: {"soforRowid": soforRowid, "tip": "soforDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
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
                    $("input[name=soforDetayAdres]").val(cevap.soforDetail[0].SoforListDetayAdres);
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
                    i.removeClass("fa fa-spinner");
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
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
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
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
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
//şoför insert
    $('#SoforSelectBolge').multiselect({
        onDropdownShow: function (event) {
            $('#SoforAracSelect').show();
        },
        onDropdownHide: function (event) {
            $('#SoforAracSelect').hide();
        }
    });
//şoför detail
    $('#SoforDetaySelectBolge').multiselect({
        onDropdownShow: function (event) {
            $('#SoforDetayArac').show();
        },
        onDropdownHide: function (event) {
            $('#SoforDetayArac').hide();
        }
    });
});
var SoforDetailVazgec = [];
$.AdminIslemler = {
    soforYeni: function () {
        $("input[name=SoforAdi]").val('');
        $("input[name=SoforSoyadi]").val('');
        $("#SoforDurum").val("1");
        $("input[name=KurumLokasyon]").val('');
        $("input[name=SoforTelefon]").val('');
        $("input[name=SoforEmail]").val('');
        $("textarea[name=SoforAdresDetay]").val('');
        $("textarea[name=Aciklama]").val('');
        $("input[name=country]").val('');
        $("input[name=administrative_area_level_1]").val('');
        $("input[name=administrative_area_level_2]").val('');
        $("input[name=locality]").val('');
        $("input[name=neighborhood]").val('');
        $("input[name=route]").val('');
        $("input[name=postal_code]").val('');
        $("input[name=street_number]").val('');
        var BolgeOptions = new Array();
        var AracOptions = new Array();
        $.ajax({
            data: {"tip": "soforEkleSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
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
                        reset();
                        alertify.alert(jsDil.BolgeOlustur);
                        return false;
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
            reset();
            alertify.alert(jsDil.IsimBos);
            return false;
        } else {
            if (soforAd.length < 2) {
                reset();
                alertify.alert(jsDil.IsimKarekter);
                return false;
            } else {
                var soforSoyad = $("input[name=SoforSoyadi]").val();
                soforSoyad = soforSoyad.trim();
                if (soforSoyad == '') {
                    reset();
                    alertify.alert(jsDil.SoyadBos);
                    return false;
                } else {
                    if (soforSoyad.length < 2) {
                        reset();
                        alertify.alert(jsDil.SoyadKarekter);
                        return false;
                    } else {
                        var soforEmail = $("input[name=SoforEmail]").val();
                        if (soforEmail == '') {
                            reset();
                            alertify.alert(jsDil.EpostaBos);
                            return false;
                        } else {
                            soforEmail = soforEmail.trim();
                            var result = ValidateEmail(soforEmail);
                            if (!result) {
                                reset();
                                alertify.alert(jsDil.EpostaUygun);
                                return false;
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
                                                "sokak": sokak, "postakodu": postakodu, "detayAdres": ttl, "caddeno": caddeno, "tip": "soforKaydet"},
                                            success: function (cevap) {
                                                if (cevap.hata) {
                                                    reset();
                                                    alertify.alert(cevap.hata);
                                                    return false;
                                                } else {
                                                    reset();
                                                    alertify.success(cevap.insert);
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
                                                                + "<td class='hidden-xs'>" + aciklama + "</td></tr>";
                                                        SoforTable.DataTable().row.add($(addRow)).draw();
                                                    } else {
                                                        var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newSoforID + "'>"
                                                                + "<i class='glyphicon glyphicon-user' style='color:red;'></i> " + soforAd + "</a></td>"
                                                                + "<td class='hidden-xs'>" + soforSoyad + "</td>"
                                                                + "<td class='hidden-xs'>" + soforTelefon + "</td>"
                                                                + "<td class='hidden-xs'>" + soforEmail + "</td>"
                                                                + "<td class='hidden-xs'>" + aciklama + "</td></tr>";
                                                        SoforTable.DataTable().row.add($(addRow)).draw();
                                                    }
                                                    soforBolgeID = [];
                                                    soforAracID = [];
                                                }
                                            }
                                        });
                                        return true;
                                    } else {
                                        reset();
                                        alertify.alert(jsDil.BolgeSec);
                                        return false;
                                    }
                                } else {
                                    reset();
                                    alertify.alert(jsDil.BolgeOlustur);
                                    return false;
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
                var araclength = SoforDetailVazgec[22].length;
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
        reset();
        alertify.confirm(jsDil.SilOnay, function (e) {
            if (e) {
                var sofordetail_id = $("input[name=soforDetayID]").val();
                $.ajax({
                    data: {"sofordetail_id": sofordetail_id, "tip": "soforDetailDelete"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(jsDil.Hata);
                            return false;
                        } else {
                            disabledForm();
                            $("input[name=SoforDetayAdi]").val('');
                            $("input[name=SoforDetaySoyadi]").val('');
                            $("#SoforDetayDurum").val('');
                            $("input[name=KurumLokasyon]").val('');
                            $("input[name=SoforDetayTelefon]").val('');
                            $("input[name=SoforDetayEmail]").val('');
                            $("textarea[name=SoforDetayAdresDetay]").val('');
                            $("textarea[name=DetayAciklama]").val('');
                            $("input[name=country]").val('');
                            $("input[name=administrative_area_level_1]").val('');
                            $("input[name=administrative_area_level_2]").val('');
                            $("input[name=locality]").val('');
                            $("input[name=neighborhood]").val('');
                            $("input[name=route]").val('');
                            $("input[name=postal_code]").val('');
                            $("input[name=street_number]").val('');
                            var soforCount = $('#smallSofor').text();
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
                            reset();
                            alertify.success(jsDil.SilEvet);
                            svControl('svClose', 'soforDetay', '');
                        }
                    }
                });
            } else {
                alertify.error(jsDil.SilRed);
            }
        });
    },
    soforDetailKaydet: function () {
        if (ttl == '') {
            ttl = $("input[name=soforDetayAdres]").val();
        }
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
        var eskiAd = SoforDetailVazgec[0];
        var eskiSoyad = SoforDetailVazgec[1];
        if (SoforDetailVazgec[0] == soforDetayAd && SoforDetailVazgec[1] == soforDetaySoyad && SoforDetailVazgec[2] == soforDetayDurum && SoforDetailVazgec[3] == soforDetayLokasyon && SoforDetailVazgec[4] == soforDetayTelefon && SoforDetailVazgec[5] == soforDetayEmail && SoforDetailVazgec[6] == soforDetayAdres && SoforDetailVazgec[7] == soforDetayAciklama && SoforDetailVazgec[8] == soforDetayUlke && SoforDetailVazgec[9] == soforDetayIl && SoforDetailVazgec[10] == soforDetayIlce && SoforDetailVazgec[11] == soforDetaySemt && SoforDetailVazgec[12] == soforDetayMahalle && SoforDetailVazgec[13] == soforDetaySokak && SoforDetailVazgec[14] == soforDetayPostaKodu && SoforDetailVazgec[15] == soforDetayCaddeNo && farkbolgelength == 0 && farksoforlength == 0) {
            reset();
            alertify.alert(jsDil.Degisiklik);
            return false;
        } else {
            if (soforDetayAd == '') {
                reset();
                alertify.alert(jsDil.IsimBos);
                return false;
            } else {
                if (soforDetayAd.length < 2) {
                    reset();
                    alertify.alert(jsDil.IsimKarekter);
                    return false;
                } else {
                    if (soforDetaySoyad == '') {
                        reset();
                        alertify.alert(jsDil.SoyadBos);
                        return false;
                    } else {
                        if (soforDetaySoyad.length < 2) {
                            reset();
                            alertify.alert(jsDil.SoyadKarekter);
                            return false;
                        } else {
                            if (soforDetayEmail == ' ') {
                                reset();
                                alertify.alert(jsDil.EpostaBos);
                                return false;
                            } else {
                                soforDetayEmail = soforDetayEmail.trim();
                                var result = ValidateEmail(soforDetayEmail);
                                if (!result) {
                                    reset();
                                    alertify.alert(jsDil.EpostaUygun);
                                    return false;
                                } else {
                                    var soforBolgeLength = $('select#SoforDetaySelectBolge option:selected').val();
                                    if (soforBolgeLength) {
                                        $.ajax({
                                            data: {"eskiAd": eskiAd, "eskiSoyad": eskiSoyad, "sofordetail_id": sofordetail_id, "soforBolgeID[]": soforBolgeID, "soforBolgeAd[]": soforBolgeAd, "soforAracID[]": soforAracID, "soforAracPlaka[]": soforAracPlaka, "soforDetayAd": soforDetayAd,
                                                "soforDetaySoyad": soforDetaySoyad, "soforDetayDurum": soforDetayDurum, "soforDetayLokasyon": soforDetayLokasyon, "soforDetayTelefon": soforDetayTelefon,
                                                "soforDetayEmail": soforDetayEmail, "soforDetayAdres": soforDetayAdres, "soforDetayAciklama": soforDetayAciklama, "soforDetayUlke": soforDetayUlke,
                                                "soforDetayIl": soforDetayIl, "soforDetayIlce": soforDetayIlce, "soforDetaySemt": soforDetaySemt, "soforDetayMahalle": soforDetayMahalle,
                                                "soforDetaySokak": soforDetaySokak, "soforDetayPostaKodu": soforDetayPostaKodu, "soforDetayCaddeNo": soforDetayCaddeNo, "detayAdres": ttl, "tip": "soforDetailKaydet"},
                                            success: function (cevap) {
                                                if (cevap.hata) {
                                                    reset();
                                                    alertify.alert(cevap.hata);
                                                    return false;
                                                } else {
                                                    disabledForm();
                                                    reset();
                                                    alertify.success(cevap.update);
                                                    var SelectBolgeOptions = new Array();
                                                    var SelectSoforOptions = new Array();
                                                    if (soforBolgeID.length > 0) {
                                                        var bolgelength = soforBolgeID.length;
                                                        for (var b = 0; b < bolgelength; b++) {
                                                            SelectBolgeOptions[b] = {label: soforBolgeAd[b], title: soforBolgeAd[b], value: soforBolgeID[b], disabled: true, selected: true};
                                                        }

                                                        if (soforBolgeNID.length > 0) {
                                                            var aracBolgeLength = soforBolgeNID.length;
                                                            for (var z = 0; z < aracBolgeLength; z++) {
                                                                SelectBolgeOptions[b] = {label: soforBolgeNAd[z], title: soforBolgeNAd[z], value: soforBolgeNID[z], disabled: true};
                                                                b++;
                                                            }

                                                        }
                                                    } else {
                                                        var bolgelength = soforBolgeID.length;
                                                        for (var b = 0; b < bolgelength; b++) {
                                                            SelectBolgeOptions[b] = {label: soforBolgeAd[b], title: soforBolgeAd[b], value: soforBolgeID[b], disabled: true, selected: true};
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
                                        reset();
                                        alertify.alert(jsDil.BolgeSec);
                                        return false;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    },
    soforDetailTur: function () {
        SoforTurTable.DataTable().clear().draw();
        var soforID = $("input[name=soforDetayID]").val();
        $.ajax({
            data: {"soforID": soforID, "tip": "soforDetailTur"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.soforDetailTur) {
                        var turCount = cevap.soforDetailTur.length;
                        for (var i = 0; i < turCount; i++) {
                            if (cevap.soforDetailTur[i].TurTip == 0) {
                                TurTip = jsDil.Ogrenci;
                            } else if (cevap.soforDetailTur[i].TurTip == 1) {
                                TurTip = jsDil.Personel;
                            } else {
                                TurTip = jsDil.OgrenciPersonel;
                            }
                            if (cevap.soforDetailTur[i].TurAktiflik != 0) {
                                var addRow = "<tr><td>"
                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.soforDetailTur[i].TurID + "'>"
                                        + "<i class='fa fa-map-marker'></i> " + cevap.soforDetailTur[i].TurAd + "</a></td>"
                                        + "<td class='hidden-xs' >" + TurTip + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.soforDetailTur[i].TurAciklama + "</td>"
                                        + "<td class='hidden-xs'>" + cevap.soforDetailTur[i].TurKurum + "</td>"
                                        + "<td class='hidden-xs'>" + cevap.soforDetailTur[i].TurBolge + "</td></tr>";
                                SoforTurTable.DataTable().row.add($(addRow)).draw();
                            } else {
                                var addRow = "<tr><td>"
                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.soforDetailTur[i].TurID + "'>"
                                        + "<i class='fa fa-map-marker' style='color:red'></i> " + cevap.soforDetailTur[i].TurAd + "</a></td>"
                                        + "<td class='hidden-xs' >" + TurTip + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.soforDetailTur[i].TurAciklama + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.soforDetailTur[i].TurKurum + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.soforDetailTur[i].TurBolge + "</td></tr>";
                                SoforTurTable.DataTable().row.add($(addRow)).draw();
                            }
                        }
                    }
                }
            }
        });
        return true;
    },
    adminSoforTakvim: function () {
        var currentLangCode = $("input[name=takvimLang]").val();
        var soforDetayAd = $("input[name=SoforDetayAdi]").val();
        var soforDetaySoyad = $("input[name=SoforDetaySoyadi]").val();
        $("#takvimSofor").text(soforDetayAd + ' ' + soforDetaySoyad);
        $('#calendar').fullCalendar('refetchEvents');
        $('#calendar').fullCalendar('refresh');
        $('#calendar').fullCalendar({
            header: {
                right: ''
            },
            defaultDate: '2015-03-02',
            defaultView: 'agendaWeek',
            weekNumbers: false,
            editable: false,
            weekdaysShort: true,
            height: 'auto',
            lang: currentLangCode,
            allDaySlot: true,
            slotDuration: "00:15:01",
            axisFormat: 'HH:mm',
            timeFormat: {
                agenda: 'HH:mm'
            },
            events: function (start, end, timezone, callback) {
                $.ajax({
                    data: {start: '2015-03-02', end: '2015-03-09', "id": GetCustomValue(), "tip": "adminSoforTakvim"},
                    success: function (doc) {
                        callback(doc);
                    }
                });
            },
            eventColor: '#009933',
            loading: function (bool) {
                $('#loading').toggle(bool);
            }
        });
        function GetCustomValue()
        {
            return $("input[name=soforDetayID]").val();
        }
        for (var i = 0; i < 7; i++) {
            var days = $(".fc-day-header").eq(i).text();
            var kelime = days.substr(0, days.indexOf(' '));
            if (kelime) {
                //var sonkelime=kelime.replace(/,\s*$/, "");
                $(".fc-day-header").eq(i).text(kelime);
            }
        }
        return true;
    },
}


