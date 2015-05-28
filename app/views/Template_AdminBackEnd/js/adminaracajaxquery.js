$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminAracAjaxSorgu",
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

    NewAracTable = $('#adminAracTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    AracTurTable = $('#adminAracTurTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
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
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
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
                    var SelectHostesOptions = new Array();
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

                    //Şoför varsa
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

                    //Hostes varsa
                    if (cevap.adminAracSelectHostes) {
                        var hostesselectlength = cevap.adminAracSelectHostes.length;
                        for (var h = 0; h < hostesselectlength; h++) {
                            SelectHostesOptions[h] = {label: cevap.adminAracSelectHostes[h].SelectAracHostesAdi, title: cevap.adminAracSelectHostes[h].SelectAracHostesAdi, value: cevap.adminAracSelectHostes[h].SelectAracHostesID, selected: true, disabled: true};
                        }
                        if (cevap.adminAracHostes) {
                            var hosteslength = cevap.adminAracHostes.length;
                            for (var v = 0; v < hosteslength; v++) {
                                SelectHostesOptions[h] = {label: cevap.adminAracHostes[v].DigerAracHostesAdi, title: cevap.adminAracHostes[v].DigerAracHostesAdi, value: cevap.adminAracHostes[v].DigerAracHostesID, disabled: true};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.adminAracHostes) {
                            var hosteslength = cevap.adminAracHostes.length;
                            for (var v = 0; v < hosteslength; v++) {
                                SelectHostesOptions[v] = {label: cevap.adminAracHostes[v].DigerAracHostesAdi, title: cevap.adminAracHostes[v].DigerAracHostesAdi, value: cevap.adminAracHostes[v].DigerAracHostesID, disabled: true};
                            }
                        }
                    }

                    $('#AracDetayBolgeSelect').multiselect('refresh');
                    $('#AracDetaySurucu').multiselect('refresh');
                    $('#AracDetayHostes').multiselect('refresh');
                    $('#AracDetayBolgeSelect').multiselect('dataprovider', SelectBolgeOptions);
                    $('#AracDetaySurucu').multiselect('dataprovider', SelectAracOptions);
                    $('#AracDetayHostes').multiselect('dataprovider', SelectHostesOptions);
                    svControl('svAdd', 'aracDetay', '');
                    i.removeClass("fa-spinner fa-spin");
                    i.addClass("fa fa-bus");
                }
            }
        });
    });
//kullanıcı işlemleri bölge select
    $('#AracDetayBolgeSelect').on('change', function () {

        var aracID = $("input[name=adminAracDetailDeger]").val();
        var aracDetailBolgeID = new Array();
        $('select#AracDetayBolgeSelect option:selected').each(function () {
            aracDetailBolgeID.push($(this).val());
        });

        var SoforOptions = new Array();
        var HostesOptions = new Array();
        $.ajax({
            data: {"aracID": aracID, "aracDetailBolgeID[]": aracDetailBolgeID, "tip": "AracDetailMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
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
        var AracHostesOptions = new Array();
        $.ajax({
            data: {"aracBolgeID[]": aracBolgeID, "tip": "AracSoforMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
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

                    if (cevap.aracYeniHostesMultiSelect) {
                        var hosteslength = cevap.aracYeniHostesMultiSelect.HostesSelectID.length;
                        for (var h = 0; h < hosteslength; h++) {
                            AracHostesOptions[h] = {label: cevap.aracYeniHostesMultiSelect.HostesSelectAd[h] + ' ' + cevap.aracYeniHostesMultiSelect.HostesSelectSoyad[h], title: cevap.aracYeniHostesMultiSelect.HostesSelectAd[h] + ' ' + cevap.aracYeniHostesMultiSelect.HostesSelectSoyad[h], value: cevap.aracYeniHostesMultiSelect.HostesSelectID[h]};
                        }
                        $('#AracHostes').multiselect('refresh');
                        $('#AracHostes').multiselect('dataprovider', AracHostesOptions);
                    } else {
                        $('#AracHostes').multiselect('refresh');
                        $('#AracHostes').multiselect('dataprovider', AracHostesOptions);
                    }
                }
            }
        });
    });
//multi select açılma eventları
    //araç select
    $('#AracBolgeSelect').multiselect({
        onDropdownShow: function (event) {
            $('#AracSurucu').show();
            $('#AracHostes').show();
        },
        onDropdownHide: function (event) {
            $('#AracSurucu').hide();
            $('#AracHostes').hide();
        }
    });
//araç detail
    $('#AracDetayBolgeSelect').multiselect({
        onDropdownShow: function (event) {
            $('#AracDetaySurucu').show();
            $('#AracDetayHostes').show();
        },
        onDropdownHide: function (event) {
            $('#AracDetaySurucu').hide();
            $('#AracDetayHostes').hide();
        }
    });
});
var AdminAracDetailVazgec = [];
$.AdminIslemler = {
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
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
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
                    $('#AracHostes').multiselect('refresh');
                    var selectLength = $('#AracBolgeSelect > option').length;
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
    adminAracEkle: function () {
        var aracPlaka = $("input[name=AracPlaka]").val().toUpperCase();
        if (aracPlaka == '') {
            reset();
            alertify.alert(jsDil.PlakaBos);
            return false;
        } else {
            var select = $('select#AracBolgeSelect option:selected').val();
            if (select) {
                var aracKapasite = $("input[name=AracKapasite]").val();
                if (aracKapasite < 2) {
                    reset();
                    alertify.alert(jsDil.AracKapasite);
                    return false;
                } else {
                    var aracMarka = $("input[name=AracMarka]").val();
                    var aracModelYil = $("input[name=AracYil]").val();

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
                    //araç Hostes Id
                    var aracHostesID = new Array();
                    $('select#AracHostes option:selected').each(function () {
                        aracHostesID.push($(this).val());
                    });
                    //araç Hostes Ad
                    var aracHostesAd = new Array();
                    $('select#AracHostes option:selected').each(function () {
                        aracHostesAd.push($(this).attr('title'));
                    });
                    $.ajax({
                        data: {"aracBolgeID[]": aracBolgeID, "aracBolgeAd[]": aracBolgeAd, "aracSoforID[]": aracSoforID, "aracSoforAd[]": aracSoforAd,
                            "aracHostesID[]": aracHostesID, "aracHostesAd[]": aracHostesAd, "aracPlaka": aracPlaka, "aracMarka": aracMarka, "aracModelYil": aracModelYil,
                            "aracKapasite": aracKapasite, "aracAciklama": aracAciklama, "aracDurum": aracDurum, "tip": "adminAracKaydet"},
                        success: function (cevap) {
                            if (cevap.hata) {
                                reset();
                                alertify.alert(jsDil.Hata);
                                return false;
                            } else {
                                reset();
                                alertify.success(jsDil.AracKaydet);
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
                                aracHostesID = [];
                                aracHostesAd = [];
                            }
                        }
                    });
                    return true;
                }
            } else {
                reset();
                alertify.alert(jsDil.BolgeSec);
                return false;
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
        //araç Hostes Id
        var aracHostesID = new Array();
        $('select#AracDetayHostes option:selected').each(function () {
            aracHostesID.push($(this).val());
        });
        //araç Hostes Ad
        var aracHostesAd = new Array();
        $('select#AracDetayHostes option:selected').each(function () {
            aracHostesAd.push($(this).attr('title'));
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
        //araç Seçili Olmayan Hostes Id
        var aracHostesNID = new Array();
        $('select#AracDetayHostes option:not(:selected)').each(function () {
            aracHostesNID.push($(this).val());
        });
        //araç Seçili Olmayan Hostes Ad
        var aracHostesNAd = new Array();
        $('select#AracDetayHostes option:not(:selected)').each(function () {
            aracHostesNAd.push($(this).attr('title'));
        });
        var SelectBolgeOptions = new Array();
        var SelectAracOptions = new Array();
        var SelectHostesOptions = new Array();
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

        if (aracHostesID.length > 0) {
            var hostesselectlength = aracHostesID.length;
            for (var h = 0; h < hostesselectlength; h++) {
                SelectHostesOptions[h] = {label: aracHostesAd[h], title: aracHostesAd[h], value: aracHostesID[h], selected: true};
            }

            if (aracHostesNID.length > 0) {
                var hosteslength = aracHostesNID.length;
                for (var v = 0; v < hosteslength; v++) {
                    SelectHostesOptions[h] = {label: aracHostesNAd[v], title: aracHostesNAd[v], value: aracHostesNID[v]};
                    h++;
                }
            }
        } else {
            if (aracHostesNID.length > 0) {
                var hosteslength = aracHostesNID.length;
                for (var v = 0; v < hosteslength; v++) {
                    SelectHostesOptions[v] = {label: aracHostesNAd[v], title: aracHostesNAd[v], value: aracHostesNID[v]};
                }
            }
        }


        $('#AracDetayBolgeSelect').multiselect('refresh');
        $('#AracDetaySurucu').multiselect('refresh');
        $('#AracDetayHostes').multiselect('refresh');
        $('#AracDetayBolgeSelect').multiselect('dataprovider', SelectBolgeOptions);
        $('#AracDetaySurucu').multiselect('dataprovider', SelectAracOptions);
        $('#AracDetayHostes').multiselect('dataprovider', SelectHostesOptions);
        AdminAracDetailVazgec = [];
        AdminAracDetailVazgec.push(aracPlaka, aracMarka, aracModelYil, aracKapasite, aracAciklama, aracDurum, aracBolgeID, aracBolgeAd, aracBolgeNID, aracBolgeNAd, aracSoforID, aracSoforAd, aracSoforNID, aracSoforNAd, aracHostesID, aracHostesAd, aracHostesNID, aracHostesNAd);
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
        var SelectHostesOptions = new Array();
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

        if (AdminAracDetailVazgec[14].length > 0) {
            var hostesselectlength = AdminAracDetailVazgec[14].length;
            for (var h = 0; h < hostesselectlength; h++) {
                SelectHostesOptions[h] = {label: AdminAracDetailVazgec[15][h], title: AdminAracDetailVazgec[15][h], value: AdminAracDetailVazgec[14][h], selected: true, disabled: true};
            }
            if (AdminAracDetailVazgec[16].length > 0) {
                var hosteslength = AdminAracDetailVazgec[16].length;
                for (var v = 0; v < hosteslength; v++) {
                    SelectHostesOptions[h] = {label: AdminAracDetailVazgec[17][v], title: AdminAracDetailVazgec[17][v], value: AdminAracDetailVazgec[16][v], disabled: true};
                    h++;
                }
            }
        } else {
            if (AdminAracDetailVazgec[16].length > 0) {
                var soforlength = AdminAracDetailVazgec[16].length;
                for (var v = 0; v < soforlength; v++) {
                    SelectHostesOptions[v] = {label: AdminAracDetailVazgec[17][v], title: AdminAracDetailVazgec[17][v], value: AdminAracDetailVazgec[16][v], disabled: true};
                }
            }
        }

        $('#AracDetayBolgeSelect').multiselect('refresh');
        $('#AracDetaySurucu').multiselect('refresh');
        $('#AracDetayHostes').multiselect('refresh');
        $('#AracDetayBolgeSelect').multiselect('dataprovider', SelectBolgeOptions);
        $('#AracDetaySurucu').multiselect('dataprovider', SelectAracOptions);
        $('#AracDetayHostes').multiselect('dataprovider', SelectHostesOptions);
    },
    adminAracDetailSil: function () {
        reset();
        alertify.confirm(jsDil.SilOnay, function (e) {
            if (e) {
                var aracdetail_id = $("input[name=adminAracDetailDeger]").val();
                $.ajax({
                    data: {"aracdetail_id": aracdetail_id, "tip": "adminAracDetailDelete"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(jsDil.Hata);
                            return false;
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
                            reset();
                            alertify.success(jsDil.SilEvet);
                            svControl('svClose', 'aracDetay', '');
                        }
                    }
                });
            } else {
                alertify.error(jsDil.SilRed);
            }
        });
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
        //araç Hostes Id
        var aracHostesID = new Array();
        $('select#AracDetayHostes option:selected').each(function () {
            aracHostesID.push($(this).val());
        });
        //araç Hostes Ad
        var aracHostesAd = new Array();
        $('select#AracDetayHostes option:selected').each(function () {
            aracHostesAd.push($(this).attr('title'));
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
        //araç Seçili Olmayan Hostes Id
        var aracHostesNID = new Array();
        $('select#AracDetayHostes option:not(:selected)').each(function () {
            aracHostesNID.push($(this).val());
        });
        //araç Seçili Olmayan Hostes Ad
        var aracHostesNAd = new Array();
        $('select#AracDetayHostes option:not(:selected)').each(function () {
            aracHostesNAd.push($(this).attr('title'));
        });
        var farkbolge = farkArray(AdminAracDetailVazgec[6], aracBolgeID);
        var farkbolgelength = farkbolge.length;
        var farkarac = farkArray(AdminAracDetailVazgec[10], aracSoforID);
        var farkaraclength = farkarac.length;
        var farkhostes = farkArray(AdminAracDetailVazgec[14], aracHostesID);
        var farkhosteslength = farkhostes.length;
        if (AdminAracDetailVazgec[0] == aracPlaka && AdminAracDetailVazgec[1] == aracMarka && AdminAracDetailVazgec[2] == aracModelYil && AdminAracDetailVazgec[3] == aracKapasite && AdminAracDetailVazgec[4] == aracAciklama && AdminAracDetailVazgec[5] == aracDurum && farkbolgelength == 0 && farkaraclength == 0 && farkhosteslength == 0) {
            reset();
            alertify.alert(jsDil.Degisiklik);
            return false;
        } else {
            if (aracPlaka == '') {
                reset();
                alertify.alert(jsDil.PlakaBos);
                return false;
            } else {
                if (aracKapasite < 2) {
                    reset();
                    alertify.alert(jsDil.AracKapasite);
                    return false;
                } else {
                    var aracBolgeLength = $('select#AracDetayBolgeSelect option:selected').val();
                    if (aracBolgeLength) {
                        $.ajax({
                            data: {"aracdetail_id": aracdetail_id, "aracBolgeID[]": aracBolgeID, "aracBolgeAd[]": aracBolgeAd,
                                "aracSoforID[]": aracSoforID, "aracSoforAd[]": aracSoforAd, "aracHostesID[]": aracHostesID, "aracHostesAd[]": aracHostesAd,
                                "aracPlaka": aracPlaka, "aracMarka": aracMarka, "aracModelYil": aracModelYil,
                                "aracKapasite": aracKapasite, "aracAciklama": aracAciklama, "aracDurum": aracDurum, "tip": "adminAracDetailKaydet"},
                            success: function (cevap) {
                                if (cevap.hata) {
                                    reset();
                                    alertify.alert(jsDil.Hata);
                                    return false;
                                } else {
                                    disabledForm();
                                    reset();
                                    alertify.success(jsDil.AracDuzenle);
                                    var SelectBolgeOptions = new Array();
                                    var SelectAracOptions = new Array();
                                    var SelectHostesOptions = new Array();
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
                                    //şoför multi select
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
                                            for (var f = 0; f < soforlength; f++) {
                                                SelectAracOptions[f] = {label: aracSoforNAd[f], title: aracSoforNAd[f], value: aracSoforNID[f], disabled: true};
                                            }
                                        }
                                    }
                                    //hostes multi select
                                    if (aracHostesID.length > 0) {
                                        var hostesselectlength = aracHostesID.length;
                                        for (var h = 0; h < hostesselectlength; h++) {
                                            SelectHostesOptions[h] = {label: aracHostesAd[h], title: aracHostesAd[h], value: aracHostesID[h], disabled: true, selected: true};
                                        }

                                        if (aracHostesNID.length > 0) {
                                            var hosteslength = aracHostesNID.length;
                                            for (var v = 0; v < hosteslength; v++) {
                                                SelectHostesOptions[h] = {label: aracHostesNAd[v], title: aracHostesNAd[v], value: aracHostesNID[v], disabled: true};
                                                h++;
                                            }
                                        }
                                    } else {
                                        if (aracHostesNID.length > 0) {
                                            var hosteslength = aracHostesNID.length;
                                            for (var v = 0; v < hosteslength; v++) {
                                                SelectHostesOptions[v] = {label: aracHostesNAd[v], title: aracHostesNAd[v], value: aracHostesNID[v], disabled: true};
                                            }
                                        }
                                    }

                                    $('#AracDetayBolgeSelect').multiselect('refresh');
                                    $('#AracDetaySurucu').multiselect('refresh');
                                    $('#AracDetayHostes').multiselect('refresh');
                                    $('#AracDetayBolgeSelect').multiselect('dataprovider', SelectBolgeOptions);
                                    $('#AracDetaySurucu').multiselect('dataprovider', SelectAracOptions);
                                    $('#AracDetayHostes').multiselect('dataprovider', SelectHostesOptions);
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
                        reset();
                        alertify.alert(jsDil.BolgeSec);
                        return false;
                    }
                }
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
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.aracDetailTur) {
                        var turCount = cevap.aracDetailTur.length;
                        for (var i = 0; i < turCount; i++) {
                            if (cevap.aracDetailTur[i].TurTip == 0) {
                                TurTip = 'Öğrenci';
                            } else if (cevap.aracDetailTur[i].TurTip == 1) {
                                TurTip = 'Personel';
                            } else {
                                TurTip = 'Öğrenci/Personel';
                            }
                            if (cevap.aracDetailTur[i].TurAktiflik != 0) {
                                var addRow = "<tr><td>"
                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.aracDetailTur[i].TurID + "'>"
                                        + "<i class='fa fa-map-marker'></i> " + cevap.aracDetailTur[i].TurAd + "</a></td>"
                                        + "<td class='hidden-xs' >" + TurTip + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.aracDetailTur[i].TurAciklama + "</td>"
                                        + "<td class='hidden-xs'>" + cevap.aracDetailTur[i].TurKurum + "</td>"
                                        + "<td class='hidden-xs'>" + cevap.aracDetailTur[i].TurBolge + "</td></tr>";
                                AracTurTable.DataTable().row.add($(addRow)).draw();
                            } else {
                                var addRow = "<tr><td>"
                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.aracDetailTur[i].TurID + "'>"
                                        + "<i class='fa fa-map-marker' style='color:red'></i> " + cevap.aracDetailTur[i].TurAd + "</a></td>"
                                        + "<td class='hidden-xs' >" + TurTip + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.aracDetailTur[i].TurAciklama + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.aracDetailTur[i].TurKurum + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.aracDetailTur[i].TurBolge + "</td></tr>";
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


