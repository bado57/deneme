$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminHostesAjaxSorgu",
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

    HostesTable = $('#hostesTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    //Hostes işlemleri
    $(document).on('click', 'tbody#hostesRow > tr > td > a', function (e) {
        var i = $(this).find("i");
        i.removeClass("glyphicon glyphicon-user");
        i.addClass("fa fa-spinner");
        var hostesRowid = $(this).attr('value');
        $.ajax({
            data: {"hostesRowid": hostesRowid, "tip": "hostesDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {

                    $("input[name=HostesDetayAdi]").val(cevap.hostesDetail[0].HostesListAd);
                    $("input[name=HostesDetaySoyadi]").val(cevap.hostesDetail[0].HostesListSoyad);
                    $("#HostesDetayDurum").val(cevap.hostesDetail[0].HostesListDurum);
                    $("input[name=KurumLokasyon]").val(cevap.hostesDetail[0].HostesListLokasyon);
                    $("input[name=HostesDetayTelefon]").val(cevap.hostesDetail[0].HostesListTelefon);
                    $("input[name=HostesDetayEmail]").val(cevap.hostesDetail[0].HostesListMail);
                    $("textarea[name=HostesDetayAdresDetay]").val(cevap.hostesDetail[0].HostesListAdres);
                    $("textarea[name=DetayAciklama]").val(cevap.hostesDetail[0].HostesListAciklama);
                    $("input[name=country]").val(cevap.hostesDetail[0].HostesListUlke);
                    $("input[name=administrative_area_level_1]").val(cevap.hostesDetail[0].HostesListIl);
                    $("input[name=administrative_area_level_2]").val(cevap.hostesDetail[0].HostesListIlce);
                    $("input[name=locality]").val(cevap.hostesDetail[0].HostesListSemt);
                    $("input[name=neighborhood]").val(cevap.hostesDetail[0].HostesListMahalle);
                    $("input[name=route]").val(cevap.hostesDetail[0].HostesListSokak);
                    $("input[name=postal_code]").val(cevap.hostesDetail[0].HostesListPostaKodu);
                    $("input[name=street_number]").val(cevap.hostesDetail[0].HostesListCaddeNo);
                    $("input[name=hostesDetayID]").val(cevap.hostesDetail[0].HostesListID);
                    var SelectBolgeOptions = new Array();
                    var SelectHostesOptions = new Array();
                    if (cevap.hostesSelectBolge) {
                        var bolgelength = cevap.hostesSelectBolge.length;
                        for (var b = 0; b < bolgelength; b++) {
                            SelectBolgeOptions[b] = {label: cevap.hostesSelectBolge[b].SelectHostesBolgeAdi, title: cevap.hostesSelectBolge[b].SelectHostesBolgeAdi, value: cevap.hostesSelectBolge[b].SelectHostesBolgeID, selected: true, disabled: true};
                        }

                        if (cevap.hostesBolge) {
                            var hostesBolgeLength = cevap.hostesBolge.length;
                            for (var z = 0; z < hostesBolgeLength; z++) {
                                SelectBolgeOptions[b] = {label: cevap.hostesBolge[z].DigerHostesBolgeAdi, title: cevap.hostesBolge[z].DigerHostesBolgeAdi, value: cevap.hostesBolge[z].DigerHostesBolgeID, disabled: true};
                                b++;
                            }

                        }
                    } else {
                        if (cevap.hostesBolge) {
                            var hostesBolgeLength = cevap.hostesBolge.length;
                            for (var b = 0; b < hostesBolgeLength; b++) {
                                SelectBolgeOptions[b] = {label: cevap.hostesBolge[b].DigerHostesBolgeAdi, title: cevap.hostesBolge[b].DigerHostesBolgeAdi, value: cevap.hostesBolge[b].DigerHostesBolgeID, disabled: true};
                            }
                        }
                    }


                    if (cevap.hostesSelectArac) {
                        var aracselectlength = cevap.hostesSelectArac.length;
                        for (var t = 0; t < aracselectlength; t++) {
                            SelectHostesOptions[t] = {label: cevap.hostesSelectArac[t].SelectHostesAracPlaka, title: cevap.hostesSelectArac[t].SelectHostesAracPlaka, value: cevap.hostesSelectArac[t].SelectHostesAracID, selected: true, disabled: true};
                        }
                        if (cevap.hostesArac) {
                            var hosteslength = cevap.hostesArac.length;
                            for (var f = 0; f < hosteslength; f++) {
                                SelectHostesOptions[t] = {label: cevap.hostesArac[f].DigerHostesAracPlaka, title: cevap.hostesArac[f].DigerHostesAracPlaka, value: cevap.hostesArac[f].DigerHostesAracID, disabled: true};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.hostesArac) {
                            var hosteslength = cevap.hostesArac.length;
                            for (var t = 0; t < hosteslength; t++) {
                                SelectHostesOptions[t] = {label: cevap.hostesArac[t].DigerHostesAracPlaka, title: cevap.hostesArac[t].DigerHostesAracPlaka, value: cevap.hostesArac[t].DigerHostesAracID, disabled: true};
                            }
                        }
                    }

                    $('#HostesDetaySelectBolge').multiselect('refresh');
                    $('#HostesDetayArac').multiselect('refresh');
                    $('#HostesDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
                    $('#HostesDetayArac').multiselect('dataprovider', SelectHostesOptions);
                    svControl('svAdd', 'hostesDetay', '');
                    i.removeClass("fa fa-spinner");
                    i.addClass("glyphicon glyphicon-user");
                }
            }
        });
    });
//kullanıcı işlemleri bölge select
    $('#HostesSelectBolge').on('change', function () {
        var hostesBolgeID = new Array();
        $('select#HostesSelectBolge option:selected').each(function () {
            hostesBolgeID.push($(this).val());
        });
        var AracOptions = new Array();
        $.ajax({
            data: {"hostesBolgeID[]": hostesBolgeID, "tip": "hostesAracMultiSelect"},
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
                        $('#HostesAracSelect').multiselect('refresh');
                        $('#HostesAracSelect').multiselect('dataprovider', AracOptions);
                    } else {
                        $('#HostesAracSelect').multiselect('refresh');
                        $('#HostesAracSelect').multiselect('dataprovider', AracOptions);
                    }
                }
            }
        });
    });

    $('#HostesDetaySelectBolge').on('change', function () {

        var hostesID = $("input[name=hostesDetayID]").val();
        var hostesDetailBolgeID = new Array();
        $('select#HostesDetaySelectBolge option:selected').each(function () {
            hostesDetailBolgeID.push($(this).val());
        });
        $('#AracDetaySurucu').multiselect('refresh');
        var AracOptions = new Array();
        $.ajax({
            data: {"hostesID": hostesID, "hostesDetailBolgeID[]": hostesDetailBolgeID, "tip": "hostesDetailMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.adminHostesSelectArac) {
                        var aracselectlength = cevap.adminHostesSelectArac.length;
                        for (var t = 0; t < aracselectlength; t++) {
                            AracOptions[t] = {label: cevap.adminHostesSelectArac[t].SelectHostesAracPlaka, title: cevap.adminHostesSelectArac[t].SelectHostesAracPlaka, value: cevap.adminHostesSelectArac[t].SelectHostesAracID, selected: true};
                        }
                        if (cevap.adminHostesArac) {
                            var araclength = cevap.adminHostesArac.length;
                            for (var f = 0; f < araclength; f++) {
                                AracOptions[t] = {label: cevap.adminHostesArac[f].DigerHostesAracPlaka, title: cevap.adminHostesArac[f].DigerHostesAracPlaka, value: cevap.adminHostesArac[f].DigerHostesAracID};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.adminHostesArac) {
                            var araclength = cevap.adminHostesArac.length;
                            for (var t = 0; t < araclength; t++) {
                                AracOptions[t] = {label: cevap.adminHostesArac[t].DigerHostesAracPlaka, title: cevap.adminHostesArac[t].DigerHostesAracPlaka, value: cevap.adminHostesArac[t].DigerHostesAracID};
                            }
                        }
                    }
                    $('#HostesDetayArac').multiselect('refresh');
                    $('#HostesDetayArac').multiselect('dataprovider', AracOptions);
                }
            }
        });
    });
//multi select açılma eventları
//hostes insert
    $('#HostesSelectBolge').multiselect({
        onDropdownShow: function (event) {
            $('#HostesAracSelect').show();
        },
        onDropdownHide: function (event) {
            $('#HostesAracSelect').hide();
        }
    });
//hostes detail
    $('#HostesDetaySelectBolge').multiselect({
        onDropdownShow: function (event) {
            $('#HostesDetayArac').show();
        },
        onDropdownHide: function (event) {
            $('#HostesDetayArac').hide();
        }
    });
});
var HostesDetailVazgec = [];
$.AdminIslemler = {
    hostesYeni: function () {
        $("input[name=HostesAdi]").val('');
        $("input[name=HostesSoyadi]").val('');
        $("#HostesDurum").val("1");
        $("input[name=KurumLokasyon]").val('');
        $("input[name=HostesTelefon]").val('');
        $("input[name=HostesEmail]").val('');
        $("textarea[name=HostesAdresDetay]").val('');
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
            data: {"tip": "hostesEkleSelect"},
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
                        $('#HostesSelectBolge').multiselect('refresh');
                        $('#HostesSelectBolge').multiselect('dataprovider', BolgeOptions);
                    } else {
                        $('#HostesSelectBolge').multiselect('refresh');
                        $('#HostesSelectBolge').multiselect('dataprovider', BolgeOptions);
                    }

                    $('#HostesAracSelect').multiselect('refresh');
                    $('#HostesAracSelect').multiselect('dataprovider', AracOptions);
                    var selectLength = $('#HostesSelectBolge > option').length;
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
    hostesVazgec: function () {
        return true;
    },
    hostesEkle: function () {

        var hostesAd = $("input[name=HostesAdi]").val();
        hostesAd = hostesAd.trim();
        if (hostesAd == '') {
            reset();
            alertify.alert(jsDil.IsimBos);
            return false;
        } else {
            if (hostesAd.length < 2) {
                reset();
                alertify.alert(jsDil.IsimKarekter);
                return false;
            } else {
                var hostesSoyad = $("input[name=HostesSoyadi]").val();
                hostesSoyad = hostesSoyad.trim();
                if (hostesSoyad == '') {
                    reset();
                    alertify.alert(jsDil.SoyadBos);
                    return false;
                } else {
                    if (hostesSoyad.length < 2) {
                        reset();
                        alertify.alert(jsDil.SoyadKarekter);
                        return false;
                    } else {
                        var hostesEmail = $("input[name=HostesEmail]").val();
                        if (hostesEmail == ' ') {
                            reset();
                            alertify.alert(jsDil.EpostaBos);
                            return false;
                        } else {
                            hostesEmail = hostesEmail.trim();
                            var result = ValidateEmail(hostesEmail);
                            if (!result) {
                                reset();
                                alertify.alert(jsDil.EpostaUygun);
                                return false;
                            } else {
                                var selectLength = $('#HostesSelectBolge > option').length;
                                if (selectLength) {
                                    var select = $('select#HostesSelectBolge option:selected').val();
                                    if (select) {
                                        var hostesDurum = $("#HostesDurum option:selected").val();
                                        var hostesLokasyon = $("input[name=KurumLokasyon]").val();
                                        var hostesTelefon = $("input[name=HostesTelefon]").val();
                                        var hostesAdres = $("textarea[name=HostesAdresDetay]").val();
                                        var aciklama = $("textarea[name=Aciklama]").val();
                                        var ulke = $("input[name=country]").val();
                                        var il = $("input[name=administrative_area_level_1]").val();
                                        var ilce = $("input[name=administrative_area_level_2]").val();
                                        var semt = $("input[name=locality]").val();
                                        var mahalle = $("input[name=neighborhood]").val();
                                        var sokak = $("input[name=route]").val();
                                        var postakodu = $("input[name=postal_code]").val();
                                        var caddeno = $("input[name=street_number]").val();
                                        //hostes Bölge ID
                                        var hostesBolgeID = new Array();
                                        $('select#HostesSelectBolge option:selected').each(function () {
                                            hostesBolgeID.push($(this).val());
                                        });
                                        //hostes Bölge Adi
                                        var hostesBolgeAdi = new Array();
                                        $('select#HostesSelectBolge option:selected').each(function () {
                                            hostesBolgeAdi.push($(this).attr('title'));
                                        });
                                        //hostes Arac ID
                                        var hostesAracID = new Array();
                                        $('select#HostesAracSelect option:selected').each(function () {
                                            hostesAracID.push($(this).val());
                                        });
                                        //hostes Arac ID
                                        var hostesAracPlaka = new Array();
                                        $('select#HostesAracSelect option:selected').each(function () {
                                            hostesAracPlaka.push($(this).attr('title'));
                                        });
                                        $.ajax({
                                            data: {"hostesBolgeID[]": hostesBolgeID, "hostesBolgeAdi[]": hostesBolgeAdi, "hostesAracID[]": hostesAracID, "hostesAracPlaka[]": hostesAracPlaka, "hostesAd": hostesAd,
                                                "hostesSoyad": hostesSoyad, "hostesDurum": hostesDurum, "hostesLokasyon": hostesLokasyon, "hostesTelefon": hostesTelefon,
                                                "hostesEmail": hostesEmail, "hostesAdres": hostesAdres, "aciklama": aciklama, "ulke": ulke,
                                                "il": il, "ilce": ilce, "semt": semt, "mahalle": mahalle,
                                                "sokak": sokak, "postakodu": postakodu, "caddeno": caddeno, "tip": "hostesKaydet"},
                                            success: function (cevap) {
                                                if (cevap.hata) {
                                                    reset();
                                                    alertify.alert(jsDil.Hata);
                                                    return false;
                                                } else {
                                                    reset();
                                                    alertify.success(jsDil.HostesKaydet);
                                                    var hostesCount = $('#smallHostes').text();
                                                    hostesCount++;
                                                    $('#smallHostes').text(hostesCount);
                                                    if (hostesDurum != 0) {
                                                        var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newHostesID + "'>"
                                                                + "<i class='glyphicon glyphicon-user' style='color:green;'></i> " + hostesAd + "</a></td>"
                                                                + "<td class='hidden-xs'>" + hostesSoyad + "</td>"
                                                                + "<td class='hidden-xs'>" + hostesTelefon + "</td>"
                                                                + "<td class='hidden-xs'>" + hostesEmail + "</td>"
                                                                + "<td class='hidden-xs'>" + aciklama + "</td>";
                                                        HostesTable.DataTable().row.add($(addRow)).draw();
                                                    } else {
                                                        var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newHostesID + "'>"
                                                                + "<i class='glyphicon glyphicon-user' style='color:red;'></i> " + hostesAd + "</a></td>"
                                                                + "<td class='hidden-xs'>" + hostesSoyad + "</td>"
                                                                + "<td class='hidden-xs'>" + hostesTelefon + "</td>"
                                                                + "<td class='hidden-xs'>" + hostesEmail + "</td>"
                                                                + "<td class='hidden-xs'>" + aciklama + "</td>";
                                                        HostesTable.DataTable().row.add($(addRow)).draw();
                                                    }
                                                    hostesBolgeID = [];
                                                    hostesAracID = [];
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
    hostesDetailVazgec: function () {
        $("input[name=HostesDetayAdi]").val(HostesDetailVazgec[0]);
        $("input[name=HostesDetaySoyadi]").val(HostesDetailVazgec[1]);
        $("#HostesDetayDurum").val(HostesDetailVazgec[2]);
        $("input[name=KurumLokasyon]").val(HostesDetailVazgec[3]);
        $("input[name=HostesDetayTelefon]").val(HostesDetailVazgec[4]);
        $("input[name=HostesDetayEmail]").val(HostesDetailVazgec[5]);
        $("textarea[name=HostesDetayAdresDetay]").val(HostesDetailVazgec[6]);
        $("textarea[name=DetayAciklama]").val(HostesDetailVazgec[7]);
        $("input[name=country]").val(HostesDetailVazgec[8]);
        $("input[name=administrative_area_level_1]").val(HostesDetailVazgec[9]);
        $("input[name=administrative_area_level_2]").val(HostesDetailVazgec[10]);
        $("input[name=locality]").val(HostesDetailVazgec[11]);
        $("input[name=neighborhood]").val(HostesDetailVazgec[12]);
        $("input[name=route]").val(HostesDetailVazgec[13]);
        $("input[name=postal_code]").val(HostesDetailVazgec[14]);
        $("input[name=street_number]").val(HostesDetailVazgec[15]);
        var SelectBolgeOptions = new Array();
        var SelectHostesOptions = new Array();
        if (HostesDetailVazgec[16].length > 0) {
            var bolgelength = HostesDetailVazgec[16].length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: HostesDetailVazgec[17][b], title: HostesDetailVazgec[17][b], value: HostesDetailVazgec[16][b], selected: true, disabled: true};
            }
            if (HostesDetailVazgec[18].length > 0) {
                var aracBolgeLength = HostesDetailVazgec[18].length;
                for (var z = 0; z < aracBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: HostesDetailVazgec[19][z], title: HostesDetailVazgec[19][z], value: HostesDetailVazgec[18][z], disabled: true};
                    b++;
                }
            }
        } else {
            if (HostesDetailVazgec[18].length > 0) {
                var aracBolgeLength = HostesDetailVazgec[18].length;
                for (var b = 0; b < aracBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: HostesDetailVazgec[19][b], title: HostesDetailVazgec[19][b], value: HostesDetailVazgec[18][b], disabled: true};
                }
            }
        }


        if (HostesDetailVazgec[20].length > 0) {
            var aracselectlength = HostesDetailVazgec[20].length;
            for (var t = 0; t < aracselectlength; t++) {
                SelectHostesOptions[t] = {label: HostesDetailVazgec[21][t], title: HostesDetailVazgec[21][t], value: HostesDetailVazgec[20][t], selected: true, disabled: true};
            }
            if (HostesDetailVazgec[22].length > 0) {
                var araclength = HostesDetailVazgec[22].length;
                for (var f = 0; f < araclength; f++) {
                    SelectHostesOptions[t] = {label: HostesDetailVazgec[23][f], title: HostesDetailVazgec[23][f], value: HostesDetailVazgec[22][f], disabled: true};
                    t++;
                }
            }
        } else {
            if (HostesDetailVazgec[22].length > 0) {
                var araclength = HostesDetailVazgec[22].length;
                for (var t = 0; t < araclength; t++) {
                    SelectHostesOptions[t] = {label: HostesDetailVazgec[23][t], title: HostesDetailVazgec[23][t], value: HostesDetailVazgec[22][t], disabled: true};
                }
            }
        }

        $('#HostesDetaySelectBolge').multiselect('refresh');
        $('#HostesDetayArac').multiselect('refresh');
        $('#HostesDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
        $('#HostesDetayArac').multiselect('dataprovider', SelectHostesOptions);
    },
    hostesDetailDuzenle: function () {
        //Hostes İşlemleri Değerleri
        var hostesDetayAd = $("input[name=HostesDetayAdi]").val();
        var hostesDetaySoyad = $("input[name=HostesDetaySoyadi]").val();
        var hostesDetayDurum = $("#HostesDetayDurum").val();
        var hostesDetayLokasyon = $("input[name=KurumLokasyon]").val();
        var hostesDetayTelefon = $("input[name=HostesDetayTelefon]").val();
        var hostesDetayEmail = $("input[name=HostesDetayEmail]").val();
        var hostesDetayAdres = $("textarea[name=HostesDetayAdresDetay]").val();
        var hostesDetayAciklama = $("textarea[name=DetayAciklama]").val();
        var hostesDetayUlke = $("input[name=country]").val();
        var hostesDetayIl = $("input[name=administrative_area_level_1]").val();
        var hostesDetayIlce = $("input[name=administrative_area_level_2]").val();
        var hostesDetaySemt = $("input[name=locality]").val();
        var hostesDetayMahalle = $("input[name=neighborhood]").val();
        var hostesDetaySokak = $("input[name=route]").val();
        var hostesDetayPostaKodu = $("input[name=postal_code]").val();
        var hostesDetayCaddeNo = $("input[name=street_number]").val();
        //hostes Bölge ID
        var hostesBolgeID = new Array();
        $('select#HostesDetaySelectBolge option:selected').each(function () {
            hostesBolgeID.push($(this).val());
        });
        //hostes Bölge Ad
        var hostesBolgeAd = new Array();
        $('select#HostesDetaySelectBolge option:selected').each(function () {
            hostesBolgeAd.push($(this).attr('title'));
        });
        //hostes Hostes Id
        var hostesAracID = new Array();
        $('select#HostesDetayArac option:selected').each(function () {
            hostesAracID.push($(this).val());
        });
        //hostes Hostes Ad
        var hostesAracPlaka = new Array();
        $('select#HostesDetayArac option:selected').each(function () {
            hostesAracPlaka.push($(this).attr('title'));
        });
        //hostes Seçili Olmayan Bölge ID
        var hostesBolgeNID = new Array();
        $('select#HostesDetaySelectBolge option:not(:selected)').each(function () {
            hostesBolgeNID.push($(this).val());
        });
        //hostes Seçili Olmayan Bölge Ad
        var hostesBolgeNAd = new Array();
        $('select#HostesDetaySelectBolge option:not(:selected)').each(function () {
            hostesBolgeNAd.push($(this).attr('title'));
        });
        //hostes Seçili Olmayan Hostes Id
        var hostesAracNID = new Array();
        $('select#HostesDetayArac option:not(:selected)').each(function () {
            hostesAracNID.push($(this).val());
        });
        //hostes Seçili Olmayan Hostes Ad
        var hostesAracNAd = new Array();
        $('select#HostesDetayArac option:not(:selected)').each(function () {
            hostesAracNAd.push($(this).attr('title'));
        });
        var SelectBolgeOptions = new Array();
        var SelectHostesOptions = new Array();
        if (hostesBolgeID.length > 0) {
            var bolgelength = hostesBolgeID.length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: hostesBolgeAd[b], title: hostesBolgeAd[b], value: hostesBolgeID[b], selected: true};
            }

            if (hostesBolgeNID.length > 0) {
                var hostesBolgeLength = hostesBolgeNID.length;
                for (var z = 0; z < hostesBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: hostesBolgeNAd[z], title: hostesBolgeNAd[z], value: hostesBolgeNID[z]};
                    b++;
                }

            }
        } else {
            if (hostesBolgeNID.length > 0) {
                var hostesBolgeLength = hostesBolgeNID.length;
                for (var b = 0; b < hostesBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: hostesBolgeNAd[b], title: hostesBolgeNAd[b], value: hostesBolgeNID[b]};
                }

            }
        }

        if (hostesAracID.length > 0) {
            var aracselectlength = hostesAracID.length;
            for (var t = 0; t < aracselectlength; t++) {
                SelectHostesOptions[t] = {label: hostesAracPlaka[t], title: hostesAracPlaka[t], value: hostesAracID[t], selected: true};
            }

            if (hostesAracNID.length > 0) {
                var araclength = hostesAracNID.length;
                for (var f = 0; f < araclength; f++) {
                    SelectHostesOptions[t] = {label: hostesAracNAd[f], title: hostesAracNAd[f], value: hostesAracNID[f]};
                    t++;
                }
            }

        } else {
            if (hostesAracNID.length > 0) {
                var araclength = hostesAracNID.length;
                for (var t = 0; t < araclength; t++) {
                    SelectHostesOptions[t] = {label: hostesAracNAd[t], title: hostesAracNAd[t], value: hostesAracNID[t]};
                }
            }
        }

        $('#HostesDetaySelectBolge').multiselect('refresh');
        $('#HostesDetayArac').multiselect('refresh');
        $('#HostesDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
        $('#HostesDetayArac').multiselect('dataprovider', SelectHostesOptions);
        HostesDetailVazgec = [];
        HostesDetailVazgec.push(hostesDetayAd, hostesDetaySoyad, hostesDetayDurum, hostesDetayLokasyon, hostesDetayTelefon, hostesDetayEmail, hostesDetayAdres, hostesDetayAciklama, hostesDetayUlke, hostesDetayIl, hostesDetayIlce, hostesDetaySemt, hostesDetayMahalle, hostesDetaySokak, hostesDetayPostaKodu, hostesDetayCaddeNo, hostesBolgeID, hostesBolgeAd, hostesBolgeNID, hostesBolgeNAd, hostesAracID, hostesAracPlaka, hostesAracNID, hostesAracNAd);
    },
    hostesDetailSil: function () {
        reset();
        alertify.confirm(jsDil.SilOnay, function (e) {
            if (e) {
                var hostesdetail_id = $("input[name=hostesDetayID]").val();
                $.ajax({
                    data: {"hostesdetail_id": hostesdetail_id, "tip": "hostesDetailDelete"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(jsDil.Hata);
                            return false;
                        } else {
                            disabledForm();
                            $("input[name=HostesDetayAdi]").val('');
                            $("input[name=HostesDetaySoyadi]").val('');
                            $("#HostesDetayDurum").val('');
                            $("input[name=KurumLokasyon]").val('');
                            $("input[name=HostesDetayTelefon]").val('');
                            $("input[name=HostesDetayEmail]").val('');
                            $("textarea[name=HostesDetayAdresDetay]").val('');
                            $("textarea[name=DetayAciklama]").val('');
                            $("input[name=country]").val('');
                            $("input[name=administrative_area_level_1]").val('');
                            $("input[name=administrative_area_level_2]").val('');
                            $("input[name=locality]").val('');
                            $("input[name=neighborhood]").val('');
                            $("input[name=route]").val('');
                            $("input[name=postal_code]").val('');
                            $("input[name=street_number]").val('');
                            var hostesCount = $('#smallHostes').text();
                            hostesCount--;
                            $('#smallHostes').text(hostesCount);
                            var length = $('tbody#hostesRow tr').length;
                            for (var t = 0; t < length; t++) {
                                var attrValueId = $("tbody#hostesRow > tr > td > a").eq(t).attr('value');
                                if (attrValueId == hostesdetail_id) {
                                    var deleteRow = $('tbody#hostesRow > tr:eq(' + t + ')');
                                    HostesTable.DataTable().row($(deleteRow)).remove().draw();
                                }
                            }
                            reset();
                            alertify.success(jsDil.SilEvet);
                            svControl('svClose', 'hostesDetay', '');
                        }
                    }
                });
            } else {
                alertify.error(jsDil.SilRed);
            }
        });
    },
    hostesDetailKaydet: function () {
        var hostesdetail_id = $("input[name=hostesDetayID]").val();
        //Hostes İşlemleri Değerleri
        var hostesDetayAd = $("input[name=HostesDetayAdi]").val();
        var hostesDetaySoyad = $("input[name=HostesDetaySoyadi]").val();
        var hostesDetayDurum = $("#HostesDetayDurum").val();
        var hostesDetayLokasyon = $("input[name=KurumLokasyon]").val();
        var hostesDetayTelefon = $("input[name=HostesDetayTelefon]").val();
        var hostesDetayEmail = $("input[name=HostesDetayEmail]").val();
        var hostesDetayAdres = $("textarea[name=HostesDetayAdresDetay]").val();
        var hostesDetayAciklama = $("textarea[name=DetayAciklama]").val();
        var hostesDetayUlke = $("input[name=country]").val();
        var hostesDetayIl = $("input[name=administrative_area_level_1]").val();
        var hostesDetayIlce = $("input[name=administrative_area_level_2]").val();
        var hostesDetaySemt = $("input[name=locality]").val();
        var hostesDetayMahalle = $("input[name=neighborhood]").val();
        var hostesDetaySokak = $("input[name=route]").val();
        var hostesDetayPostaKodu = $("input[name=postal_code]").val();
        var hostesDetayCaddeNo = $("input[name=street_number]").val();
        //hostes Bölge ID
        var hostesBolgeID = new Array();
        $('select#HostesDetaySelectBolge option:selected').each(function () {
            hostesBolgeID.push($(this).val());
        });
        //hostes Bölge Ad
        var hostesBolgeAd = new Array();
        $('select#HostesDetaySelectBolge option:selected').each(function () {
            hostesBolgeAd.push($(this).attr('title'));
        });
        //hostes Hostes Id
        var hostesAracID = new Array();
        $('select#HostesDetayArac option:selected').each(function () {
            hostesAracID.push($(this).val());
        });
        //hostes Hostes Ad
        var hostesAracPlaka = new Array();
        $('select#HostesDetayArac option:selected').each(function () {
            hostesAracPlaka.push($(this).attr('title'));
        });
        //hostes Seçili Olmayan Bölge ID
        var hostesBolgeNID = new Array();
        $('select#HostesDetaySelectBolge option:not(:selected)').each(function () {
            hostesBolgeNID.push($(this).val());
        });
        //hostes Seçili Olmayan Bölge Ad
        var hostesBolgeNAd = new Array();
        $('select#HostesDetaySelectBolge option:not(:selected)').each(function () {
            hostesBolgeNAd.push($(this).attr('title'));
        });
        //hostes Seçili Olmayan Hostes Id
        var hostesAracNID = new Array();
        $('select#HostesDetayArac option:not(:selected)').each(function () {
            hostesAracNID.push($(this).val());
        });
        //hostes Seçili Olmayan Hostes Ad
        var hostesAracNAd = new Array();
        $('select#HostesDetayArac option:not(:selected)').each(function () {
            hostesAracNAd.push($(this).attr('title'));
        });
        var farkbolge = farkArray(HostesDetailVazgec[16], hostesBolgeID);
        var farkbolgelength = farkbolge.length;
        var farkhostes = farkArray(HostesDetailVazgec[20], hostesAracID);
        var farkhosteslength = farkhostes.length;
        if (HostesDetailVazgec[0] == hostesDetayAd && HostesDetailVazgec[1] == hostesDetaySoyad && HostesDetailVazgec[2] == hostesDetayDurum && HostesDetailVazgec[3] == hostesDetayLokasyon && HostesDetailVazgec[4] == hostesDetayTelefon && HostesDetailVazgec[5] == hostesDetayEmail && HostesDetailVazgec[6] == hostesDetayAdres && HostesDetailVazgec[7] == hostesDetayAciklama && HostesDetailVazgec[8] == hostesDetayUlke && HostesDetailVazgec[9] == hostesDetayIl && HostesDetailVazgec[10] == hostesDetayIlce && HostesDetailVazgec[11] == hostesDetaySemt && HostesDetailVazgec[12] == hostesDetayMahalle && HostesDetailVazgec[13] == hostesDetaySokak && HostesDetailVazgec[14] == hostesDetayPostaKodu && HostesDetailVazgec[15] == hostesDetayCaddeNo && farkbolgelength == 0 && farkhosteslength == 0) {
            reset();
            alertify.alert(jsDil.Degisiklik);
            return false;
        } else {
            var hostesBolgeLength = $('select#HostesDetaySelectBolge option:selected').val();
            if (hostesBolgeLength) {
                $.ajax({
                    data: {"hostesdetail_id": hostesdetail_id, "hostesBolgeID[]": hostesBolgeID, "hostesBolgeAd[]": hostesBolgeAd, "hostesAracID[]": hostesAracID, "hostesAracPlaka[]": hostesAracPlaka, "hostesDetayAd": hostesDetayAd,
                        "hostesDetaySoyad": hostesDetaySoyad, "hostesDetayDurum": hostesDetayDurum, "hostesDetayLokasyon": hostesDetayLokasyon, "hostesDetayTelefon": hostesDetayTelefon,
                        "hostesDetayEmail": hostesDetayEmail, "hostesDetayAdres": hostesDetayAdres, "hostesDetayAciklama": hostesDetayAciklama, "hostesDetayUlke": hostesDetayUlke,
                        "hostesDetayIl": hostesDetayIl, "hostesDetayIlce": hostesDetayIlce, "hostesDetaySemt": hostesDetaySemt, "hostesDetayMahalle": hostesDetayMahalle,
                        "hostesDetaySokak": hostesDetaySokak, "hostesDetayPostaKodu": hostesDetayPostaKodu, "hostesDetayCaddeNo": hostesDetayCaddeNo, "tip": "hostesDetailKaydet"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(jsDil.Hata);
                            return false;
                        } else {
                            disabledForm();
                            reset();
                            alertify.success(jsDil.HostesDuzenle);
                            var SelectBolgeOptions = new Array();
                            var SelectHostesOptions = new Array();
                            if (hostesBolgeID.length > 0) {
                                var bolgelength = hostesBolgeID.length;
                                for (var b = 0; b < bolgelength; b++) {
                                    SelectBolgeOptions[b] = {label: hostesBolgeAd[b], title: hostesBolgeAd[b], value: hostesBolgeID[b], disabled: true, selected: true};
                                }

                                if (hostesBolgeNID.length > 0) {
                                    var aracBolgeLength = hostesBolgeNID.length;
                                    for (var z = 0; z < aracBolgeLength; z++) {
                                        SelectBolgeOptions[b] = {label: hostesBolgeNAd[z], title: hostesBolgeNAd[z], value: hostesBolgeNID[z], disabled: true};
                                        b++;
                                    }
                                }
                            } else {
                                if (hostesBolgeNID.length > 0) {
                                    var aracBolgeLength = hostesBolgeNID.length;
                                    for (var b = 0; b < aracBolgeLength; b++) {
                                        SelectBolgeOptions[b] = {label: hostesBolgeNAd[b], title: hostesBolgeNAd[b], value: hostesBolgeNID[b], disabled: true};
                                    }
                                }
                            }

                            if (hostesAracID.length > 0) {
                                var hostesselectlength = hostesAracID.length;
                                for (var t = 0; t < hostesselectlength; t++) {
                                    SelectHostesOptions[t] = {label: hostesAracPlaka[t], title: hostesAracPlaka[t], value: hostesAracID[t], disabled: true, selected: true};
                                }

                                if (hostesAracNID.length > 0) {
                                    var hosteslength = hostesAracNID.length;
                                    for (var f = 0; f < hosteslength; f++) {
                                        SelectHostesOptions[t] = {label: hostesAracNAd[f], title: hostesAracNAd[f], value: hostesAracNID[f], disabled: true};
                                        t++;
                                    }
                                }
                            } else {
                                if (hostesAracNID.length > 0) {
                                    var hosteslength = hostesAracNID.length;
                                    for (var t = 0; f < hosteslength; t++) {
                                        SelectHostesOptions[t] = {label: hostesAracNAd[t], title: hostesAracNAd[t], value: hostesAracNID[t], disabled: true};
                                    }
                                }
                            }

                            $('#HostesDetaySelectBolge').multiselect('refresh');
                            $('#HostesDetayArac').multiselect('refresh');
                            $('#HostesDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
                            $('#HostesDetayArac').multiselect('dataprovider', SelectHostesOptions);
                            var length = $('tbody#hostesRow tr').length;
                            for (var t = 0; t < length; t++) {
                                var attrValueId = $("tbody#hostesRow > tr > td > a").eq(t).attr('value');
                                if (attrValueId == hostesdetail_id) {
                                    if (hostesDetayDurum != 0) {
                                        $("tbody#hostesRow > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-user"></i> ' + hostesDetayAd);
                                        $("tbody#hostesRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(hostesDetaySoyad);
                                        $("tbody#hostesRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(hostesDetayTelefon);
                                        $("tbody#hostesRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(hostesDetayEmail);
                                        $("tbody#hostesRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(hostesDetayAciklama);
                                        $('tbody#hostesRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                    } else {
                                        $("tbody#hostesRow > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-user" style="color:red"></i> ' + hostesDetayAd);
                                        $("tbody#hostesRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(hostesDetaySoyad);
                                        $("tbody#hostesRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(hostesDetayTelefon);
                                        $("tbody#hostesRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(hostesDetayEmail);
                                        $("tbody#hostesRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(hostesDetayAciklama);
                                        $('tbody#hostesRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
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


