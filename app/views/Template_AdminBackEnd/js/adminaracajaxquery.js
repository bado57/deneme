$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminAracAjaxSorgu",
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
//kullanıcı işlemleri bölge select
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
//multi select açılma eventları
    //araç select
    $('#AracBolgeSelect').multiselect({
        onDropdownShow: function (event) {
            $('#AracSurucu').show();
        },
        onDropdownHide: function (event) {
            $('#AracSurucu').hide();
        }
    });
//araç detail
    $('#AracDetayBolgeSelect').multiselect({
        onDropdownShow: function (event) {
            $('#AracDetaySurucu').show();
        },
        onDropdownHide: function (event) {
            $('#AracDetaySurucu').hide();
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
    }
}


