$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminVeliAjaxSorgu",
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

    VeliTable = $('#veliTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    //Veli İşlemleri
    $(document).on('click', 'tbody#veliRow > tr > td > a', function (e) {
        var i = $(this).find("i");
        i.removeClass("glyphicon glyphicon-user");
        i.addClass("fa fa-spinner");
        var veliRowid = $(this).attr('value');
        $.ajax({
            data: {"veliRowid": veliRowid, "tip": "veliDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {

                    $("input[name=VeliDetayAdi]").val(cevap.veliDetail[0].VeliListAd);
                    $("input[name=VeliDetaySoyadi]").val(cevap.veliDetail[0].VeliListSoyad);
                    $("#VeliDetayDurum").val(cevap.veliDetail[0].VeliListDurum);
                    $("input[name=KurumLokasyon]").val(cevap.veliDetail[0].VeliListLokasyon);
                    $("input[name=VeliDetayTelefon]").val(cevap.veliDetail[0].VeliListTelefon);
                    $("input[name=VeliDetayEmail]").val(cevap.veliDetail[0].VeliListMail);
                    $("textarea[name=VeliDetayAdresDetay]").val(cevap.veliDetail[0].VeliListAdres);
                    $("textarea[name=DetayAciklama]").val(cevap.veliDetail[0].VeliListAciklama);
                    $("input[name=country]").val(cevap.veliDetail[0].VeliListUlke);
                    $("input[name=administrative_area_level_1]").val(cevap.veliDetail[0].VeliListIl);
                    $("input[name=administrative_area_level_2]").val(cevap.veliDetail[0].VeliListIlce);
                    $("input[name=locality]").val(cevap.veliDetail[0].VeliListSemt);
                    $("input[name=neighborhood]").val(cevap.veliDetail[0].VeliListMahalle);
                    $("input[name=route]").val(cevap.veliDetail[0].VeliListSokak);
                    $("input[name=postal_code]").val(cevap.veliDetail[0].VeliListPostaKodu);
                    $("input[name=street_number]").val(cevap.veliDetail[0].VeliListCaddeNo);
                    $("input[name=veliDetayID]").val(cevap.veliDetail[0].VeliListID);
                    var SelectBolgeOptions = new Array();
                    var SelectKurumOptions = new Array();
                    var SelectOgrenciOptions = new Array();
                    if (cevap.veliSelectBolge) {
                        var bolgelength = cevap.veliSelectBolge.length;
                        for (var b = 0; b < bolgelength; b++) {
                            SelectBolgeOptions[b] = {label: cevap.veliSelectBolge[b].SelectVeliBolgeAdi, title: cevap.veliSelectBolge[b].SelectVeliBolgeAdi, value: cevap.veliSelectBolge[b].SelectVeliBolgeID, selected: true, disabled: true};
                        }

                        if (cevap.veliBolge) {
                            var bolgelength = cevap.veliBolge.length;
                            for (var z = 0; z < bolgelength; z++) {
                                SelectBolgeOptions[b] = {label: cevap.veliBolge[z].DigerVeliBolgeAdi, title: cevap.veliBolge[z].DigerVeliBolgeAdi, value: cevap.veliBolge[z].DigerVeliBolgeID, disabled: true};
                                b++;
                            }

                        }
                    } else {
                        if (cevap.veliBolge) {
                            var bolgelength = cevap.veliBolge.length;
                            for (var b = 0; b < bolgelength; b++) {
                                SelectBolgeOptions[b] = {label: cevap.veliBolge[b].DigerVeliBolgeAdi, title: cevap.veliBolge[b].DigerVeliBolgeAdi, value: cevap.veliBolge[b].DigerVeliBolgeID, disabled: true};
                            }
                        }
                    }


                    if (cevap.veliSelectKurum) {
                        var kurumselectlength = cevap.veliSelectKurum.length;
                        for (var t = 0; t < kurumselectlength; t++) {
                            SelectKurumOptions[t] = {label: cevap.veliSelectKurum[t].SelectVeliKurumAd, title: cevap.veliSelectKurum[t].SelectVeliKurumAd, value: cevap.veliSelectKurum[t].SelectVeliKurumID, selected: true, disabled: true};
                        }
                        if (cevap.veliKurum) {
                            var kurumlength = cevap.veliKurum.length;
                            for (var f = 0; f < kurumlength; f++) {
                                SelectKurumOptions[t] = {label: cevap.veliKurum[f].DigerVeliKurumAd, title: cevap.veliKurum[f].DigerVeliKurumAd, value: cevap.veliKurum[f].DigerVeliKurumID, disabled: true};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.veliKurum) {
                            var kurumlength = cevap.veliKurum.length;
                            for (var t = 0; t < kurumlength; t++) {
                                SelectKurumOptions[t] = {label: cevap.veliKurum[t].DigerVeliKurumAd, title: cevap.veliKurum[t].DigerVeliKurumAd, value: cevap.veliKurum[t].DigerVeliKurumID, disabled: true};
                            }
                        }
                    }

                    if (cevap.veliSelectOgrenci) {
                        var ogrenciselectlength = cevap.veliSelectOgrenci.length;
                        for (var t = 0; t < ogrenciselectlength; t++) {
                            SelectOgrenciOptions[t] = {label: cevap.veliSelectOgrenci[t].SelectVeliOgrenciAd, title: cevap.veliSelectOgrenci[t].SelectVeliOgrenciAd, value: cevap.veliSelectOgrenci[t].SelectVeliOgrenciID, selected: true, disabled: true};
                        }
                        if (cevap.veliOgrenci) {
                            var ogrencilength = cevap.veliOgrenci.length;
                            for (var f = 0; f < ogrencilength; f++) {
                                SelectOgrenciOptions[t] = {label: cevap.veliOgrenci[f].DigerVeliOgrenciAd, title: cevap.veliOgrenci[f].DigerVeliOgrenciAd, value: cevap.veliOgrenci[f].DigerVeliOgrenciID, disabled: true};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.veliOgrenci) {
                            var ogrencilength = cevap.veliOgrenci.length;
                            for (var t = 0; t < ogrencilength; t++) {
                                SelectOgrenciOptions[t] = {label: cevap.veliOgrenci[t].DigerVeliOgrenciAd, title: cevap.veliOgrenci[t].DigerVeliOgrenciAd, value: cevap.veliOgrenci[t].DigerVeliOgrenciID, disabled: true};
                            }
                        }
                    }

                    $('#VeliDetaySelectBolge').multiselect('refresh');
                    $('#VeliDetayKurum').multiselect('refresh');
                    $('#VeliDetayOgrenciSelect').multiselect('refresh');
                    $('#VeliDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
                    $('#VeliDetayKurum').multiselect('dataprovider', SelectKurumOptions);
                    $('#VeliDetayOgrenciSelect').multiselect('dataprovider', SelectOgrenciOptions);
                    svControl('svAdd', 'VeliDetay', '');
                    i.removeClass("fa fa-spinner");
                    i.addClass("glyphicon glyphicon-user");
                }
            }
        });
    });
//kullanıcı işlemleri bölge select
    $('#VeliSelectBolge').on('change', function () {
        var veliBolgeID = new Array();
        $('select#VeliSelectBolge option:selected').each(function () {
            veliBolgeID.push($(this).val());
        });
        var KurumOptions = new Array();
        $.ajax({
            data: {"veliBolgeID[]": veliBolgeID, "tip": "veliKurumMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.kurumMultiSelect) {
                        var kurumlength = cevap.kurumMultiSelect.KurumSelectID.length;
                        for (var i = 0; i < kurumlength; i++) {
                            KurumOptions[i] = {label: cevap.kurumMultiSelect.KurumSelectAd[i], title: cevap.kurumMultiSelect.KurumSelectAd[i], value: cevap.kurumMultiSelect.KurumSelectID[i]};
                        }
                        $('#VeliKurumSelect').multiselect('refresh');
                        $('#VeliKurumSelect').multiselect('dataprovider', KurumOptions);
                    } else {
                        $('#VeliKurumSelect').multiselect('refresh');
                        $('#VeliKurumSelect').multiselect('dataprovider', KurumOptions);
                    }
                }
            }
        });
    });
    $('#VeliKurumSelect').on('change', function () {
        var kurumBolgeID = new Array();
        $('select#VeliKurumSelect option:selected').each(function () {
            kurumBolgeID.push($(this).val());
        });
        var OgrenciOptions = new Array();
        $.ajax({
            data: {"kurumBolgeID[]": kurumBolgeID, "tip": "veliOgrenciMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.ogrenciMultiSelect) {
                        var ogrencilength = cevap.ogrenciMultiSelect.OgrenciSelectID.length;
                        for (var i = 0; i < ogrencilength; i++) {
                            OgrenciOptions[i] = {label: cevap.ogrenciMultiSelect.OgrenciSelectAd[i], title: cevap.ogrenciMultiSelect.OgrenciSelectAd[i], value: cevap.ogrenciMultiSelect.OgrenciSelectID[i]};
                        }
                        $('#VeliOgrenciSelect').multiselect('refresh');
                        $('#VeliOgrenciSelect').multiselect('dataprovider', OgrenciOptions);
                    } else {
                        $('#VeliOgrenciSelect').multiselect('refresh');
                        $('#VeliOgrenciSelect').multiselect('dataprovider', OgrenciOptions);
                    }
                }
            }
        });
    });
    $('#VeliDetaySelectBolge').on('change', function () {

        var veliID = $("input[name=veliDetayID]").val();
        var veliDetailBolgeID = new Array();
        $('select#VeliDetaySelectBolge option:selected').each(function () {
            veliDetailBolgeID.push($(this).val());
        });
        $('#VeliDetayKurum').multiselect('refresh');
        var KurumOptions = new Array();
        $.ajax({
            data: {"veliID": veliID, "veliDetailBolgeID[]": veliDetailBolgeID, "tip": "VeliDetailMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.adminVeliSelectKurum) {
                        var veliselectlength = cevap.adminVeliSelectKurum.length;
                        for (var t = 0; t < veliselectlength; t++) {
                            KurumOptions[t] = {label: cevap.adminVeliSelectKurum[t].SelectVeliKurumAd, title: cevap.adminVeliSelectKurum[t].SelectVeliKurumAd, value: cevap.adminVeliSelectKurum[t].SelectVeliKurumID, selected: true};
                        }
                        if (cevap.adminVeliKurum) {
                            var velilength = cevap.adminVeliKurum.length;
                            for (var f = 0; f < velilength; f++) {
                                KurumOptions[t] = {label: cevap.adminVeliKurum[f].DigerVeliKurumAd, title: cevap.adminVeliKurum[f].DigerVeliKurumAd, value: cevap.adminVeliKurum[f].DigerVeliKurumID};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.adminVeliKurum) {
                            var velilength = cevap.adminVeliKurum.length;
                            for (var t = 0; t < velilength; t++) {
                                KurumOptions[t] = {label: cevap.adminVeliKurum[t].DigerVeliKurumAd, title: cevap.adminVeliKurum[t].DigerVeliKurumAd, value: cevap.adminVeliKurum[t].DigerVeliKurumID};
                            }
                        }
                    }
                    $('#VeliDetayKurum').multiselect('refresh');
                    $('#VeliDetayKurum').multiselect('dataprovider', KurumOptions);
                }
            }
        });
    });
    $('#VeliDetayKurum').on('change', function () {

        var veliID = $("input[name=veliDetayID]").val();
        var veliDetailKurumID = new Array();
        $('select#VeliDetayKurum option:selected').each(function () {
            veliDetailKurumID.push($(this).val());
        });
        $('#VeliDetayKurum').multiselect('refresh');
        var OgrenciOptions = new Array();
        $.ajax({
            data: {"veliID": veliID, "veliDetailKurumID[]": veliDetailKurumID, "tip": "OgrenciDetailMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.adminVeliSelectOgrenci) {
                        var veliselectlength = cevap.adminVeliSelectOgrenci.length;
                        for (var t = 0; t < veliselectlength; t++) {
                            OgrenciOptions[t] = {label: cevap.adminVeliSelectOgrenci[t].SelectVeliOgrenciAd, title: cevap.adminVeliSelectOgrenci[t].SelectVeliOgrenciAd, value: cevap.adminVeliSelectOgrenci[t].SelectVeliOgrenciID, selected: true};
                        }
                        if (cevap.adminVeliOgrenci) {
                            var velilength = cevap.adminVeliOgrenci.length;
                            for (var f = 0; f < velilength; f++) {
                                OgrenciOptions[t] = {label: cevap.adminVeliOgrenci[f].DigerVeliOgrenciAd, title: cevap.adminVeliOgrenci[f].DigerVeliOgrenciAd, value: cevap.adminVeliOgrenci[f].DigerVeliOgrenciID};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.adminVeliOgrenci) {
                            var velilength = cevap.adminVeliOgrenci.length;
                            for (var t = 0; t < velilength; t++) {
                                OgrenciOptions[t] = {label: cevap.adminVeliOgrenci[t].DigerVeliOgrenciAd, title: cevap.adminVeliOgrenci[t].DigerVeliOgrenciAd, value: cevap.adminVeliOgrenci[t].DigerVeliOgrenciID};
                            }
                        }
                    }
                    $('#VeliDetayOgrenciSelect').multiselect('refresh');
                    $('#VeliDetayOgrenciSelect').multiselect('dataprovider', OgrenciOptions);
                }
            }
        });
    });
//multi select açılma eventları
    //veli bölge
    $('#VeliSelectBolge').multiselect({
        onDropdownShow: function (event) {
            $('#VeliKurumSelect').show();
        },
        onDropdownHide: function (event) {
            $('#VeliKurumSelect').hide();
        }
    });
    //veli kurum
    $('#VeliKurumSelect').multiselect({
        onDropdownShow: function (event) {
            $('#VeliOgrenciSelect').show();
        },
        onDropdownHide: function (event) {
            $('#VeliOgrenciSelect').hide();
        }
    });
    //veli detail bölge
    $('#VeliDetaySelectBolge').multiselect({
        onDropdownShow: function (event) {
            $('#VeliDetayKurum').show();
        },
        onDropdownHide: function (event) {
            $('#VeliDetayKurum').hide();
        }
    });
    //veli detail kurum
    $('#VeliDetayKurum').multiselect({
        onDropdownShow: function (event) {
            $('#VeliDetayOgrenciSelect').show();
        },
        onDropdownHide: function (event) {
            $('#VeliDetayOgrenciSelect').hide();
        }
    });
});
var VeliDetailVazgec = [];
$.AdminIslemler = {
    veliYeni: function () {
        $("input[name=VeliAdi]").val('');
        $("input[name=VeliSoyadi]").val('');
        $("#VeliDurum").val("1");
        $("input[name=KurumLokasyon]").val('');
        $("input[name=VeliTelefon]").val('');
        $("input[name=VeliEmail]").val('');
        $("textarea[name=VeliAdresDetay]").val('');
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
        var VeliKurumOptions = new Array();
        var OgrenciKurumOptions = new Array();
        $.ajax({
            data: {"tip": "veliEkleSelect"},
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
                        $('#VeliSelectBolge').multiselect('refresh');
                        $('#VeliSelectBolge').multiselect('dataprovider', BolgeOptions);
                    } else {
                        $('#VeliSelectBolge').multiselect('refresh');
                        $('#VeliSelectBolge').multiselect('dataprovider', BolgeOptions);
                    }

                    $('#VeliKurumSelect').multiselect('refresh');
                    $('#VeliKurumSelect').multiselect('dataprovider', VeliKurumOptions);
                    $('#VeliOgrenciSelect').multiselect('refresh');
                    $('#VeliOgrenciSelect').multiselect('dataprovider', OgrenciKurumOptions);
                    var selectLength = $('#VeliSelectBolge > option').length;
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
    veliVazgec: function () {
        return true;
    },
    veliEkle: function () {

        var veliAd = $("input[name=VeliAdi]").val();
        veliAd = veliAd.trim();
        if (veliAd == '') {
            reset();
            alertify.alert(jsDil.IsimBos);
            return false;
        } else {
            if (veliAd.length < 2) {
                reset();
                alertify.alert(jsDil.IsimKarekter);
                return false;
            } else {
                var veliSoyad = $("input[name=VeliSoyadi]").val();
                veliSoyad = veliSoyad.trim();
                if (veliSoyad == '') {
                    reset();
                    alertify.alert(jsDil.SoyadBos);
                    return false;
                } else {
                    if (veliSoyad.length < 2) {
                        reset();
                        alertify.alert(jsDil.SoyadKarekter);
                        return false;
                    } else {
                        var veliEmail = $("input[name=VeliEmail]").val();
                        if (veliEmail == ' ') {
                            reset();
                            alertify.alert(jsDil.EpostaBos);
                            return false;
                        } else {
                            veliEmail = veliEmail.trim();
                            var result = ValidateEmail(veliEmail);
                            if (!result) {
                                reset();
                                alertify.alert(jsDil.EpostaUygun);
                                return false;
                            } else {
                                var selectLength = $('#VeliSelectBolge > option').length;
                                if (selectLength) {
                                    var select = $('select#VeliSelectBolge option:selected').val();
                                    if (select) {
                                        var selectKurumLength = $('#VeliKurumSelect > option').length;
                                        if (selectKurumLength) {
                                            var selectKurum = $('select#VeliKurumSelect option:selected').val();
                                            if (selectKurum) {

                                                var veliDurum = $("#VeliDurum option:selected").val();
                                                var veliLokasyon = $("input[name=KurumLokasyon]").val();
                                                var veliTelefon = $("input[name=VeliTelefon]").val();
                                                var veliAdres = $("textarea[name=VeliAdresDetay]").val();
                                                var aciklama = $("textarea[name=Aciklama]").val();
                                                var ulke = $("input[name=country]").val();
                                                var il = $("input[name=administrative_area_level_1]").val();
                                                var ilce = $("input[name=administrative_area_level_2]").val();
                                                var semt = $("input[name=locality]").val();
                                                var mahalle = $("input[name=neighborhood]").val();
                                                var sokak = $("input[name=route]").val();
                                                var postakodu = $("input[name=postal_code]").val();
                                                var caddeno = $("input[name=street_number]").val();
                                                //veli Bölge ID
                                                var veliBolgeID = new Array();
                                                $('select#VeliSelectBolge option:selected').each(function () {
                                                    veliBolgeID.push($(this).val());
                                                });
                                                //veli Bölge Adi
                                                var veliBolgeAdi = new Array();
                                                $('select#VeliSelectBolge option:selected').each(function () {
                                                    veliBolgeAdi.push($(this).attr('title'));
                                                });
                                                //veli Kurum ID
                                                var veliKurumID = new Array();
                                                $('select#VeliKurumSelect option:selected').each(function () {
                                                    veliKurumID.push($(this).val());
                                                });
                                                //veli Kurum Ad
                                                var veliKurumAd = new Array();
                                                $('select#VeliKurumSelect option:selected').each(function () {
                                                    veliKurumAd.push($(this).attr('title'));
                                                });
                                                //veli Öğrenci ID
                                                var veliOgrenciID = new Array();
                                                $('select#VeliOgrenciSelect option:selected').each(function () {
                                                    veliOgrenciID.push($(this).val());
                                                });
                                                //veli Öğrenci Ad
                                                var veliOgrenciAd = new Array();
                                                $('select#VeliOgrenciSelect option:selected').each(function () {
                                                    veliOgrenciAd.push($(this).attr('title'));
                                                });
                                                $.ajax({
                                                    data: {"veliBolgeID[]": veliBolgeID, "veliBolgeAdi[]": veliBolgeAdi, "veliKurumID[]": veliKurumID,
                                                        "veliKurumAd[]": veliKurumAd, "veliOgrenciID[]": veliOgrenciID, "veliOgrenciAd[]": veliOgrenciAd, "veliAd": veliAd,
                                                        "veliSoyad": veliSoyad, "veliDurum": veliDurum, "veliLokasyon": veliLokasyon, "veliTelefon": veliTelefon,
                                                        "veliEmail": veliEmail, "veliAdres": veliAdres, "aciklama": aciklama, "ulke": ulke,
                                                        "il": il, "ilce": ilce, "semt": semt, "mahalle": mahalle,
                                                        "sokak": sokak, "postakodu": postakodu, "caddeno": caddeno, "tip": "veliKaydet"},
                                                    success: function (cevap) {
                                                        if (cevap.hata) {
                                                            reset();
                                                            alertify.alert(jsDil.Hata);
                                                            return false;
                                                        } else {
                                                            reset();
                                                            alertify.success(jsDil.VeliKaydet);
                                                            var veliCount = $('#smallVeli').text();
                                                            veliCount++;
                                                            $('#smallVeli').text(veliCount);
                                                            if (veliDurum != 0) {
                                                                var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newVeliID + "'>"
                                                                        + "<i class='glyphicon glyphicon-user' style='color:green;'></i> " + veliAd + "</a></td>"
                                                                        + "<td class='hidden-xs'>" + veliSoyad + "</td>"
                                                                        + "<td class='hidden-xs'>" + veliTelefon + "</td>"
                                                                        + "<td class='hidden-xs'>" + veliEmail + "</td>"
                                                                        + "<td class='hidden-xs'>" + aciklama + "</td>";
                                                                VeliTable.DataTable().row.add($(addRow)).draw();
                                                            } else {
                                                                var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newVeliID + "'>"
                                                                        + "<i class='glyphicon glyphicon-user' style='color:red;'></i> " + veliAd + "</a></td>"
                                                                        + "<td class='hidden-xs'>" + veliSoyad + "</td>"
                                                                        + "<td class='hidden-xs'>" + veliTelefon + "</td>"
                                                                        + "<td class='hidden-xs'>" + veliEmail + "</td>"
                                                                        + "<td class='hidden-xs'>" + aciklama + "</td>";
                                                                VeliTable.DataTable().row.add($(addRow)).draw();
                                                            }
                                                        }
                                                    }
                                                });
                                                return true;
                                            } else {
                                                reset();
                                                alertify.alert(jsDil.KurumSec);
                                                return false;
                                            }
                                        } else {
                                            reset();
                                            alertify.alert(jsDil.KurumOlustur);
                                            return false;
                                        }
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
    veliDetailDuzenle: function () {
        //Veli İşlemleri Değerleri
        var veliDetayAd = $("input[name=VeliDetayAdi]").val();
        var veliDetaySoyad = $("input[name=VeliDetaySoyadi]").val();
        var veliDetayDurum = $("#VeliDetayDurum").val();
        var veliDetayLokasyon = $("input[name=KurumLokasyon]").val();
        var veliDetayTelefon = $("input[name=VeliDetayTelefon]").val();
        var veliDetayEmail = $("input[name=VeliDetayEmail]").val();
        var veliDetayAdres = $("textarea[name=VeliDetayAdresDetay]").val();
        var veliDetayAciklama = $("textarea[name=DetayAciklama]").val();
        var veliDetayUlke = $("input[name=country]").val();
        var veliDetayIl = $("input[name=administrative_area_level_1]").val();
        var veliDetayIlce = $("input[name=administrative_area_level_2]").val();
        var veliDetaySemt = $("input[name=locality]").val();
        var veliDetayMahalle = $("input[name=neighborhood]").val();
        var veliDetaySokak = $("input[name=route]").val();
        var veliDetayPostaKodu = $("input[name=postal_code]").val();
        var veliDetayCaddeNo = $("input[name=street_number]").val();
        //veli Bölge ID
        var veliBolgeID = new Array();
        $('select#VeliDetaySelectBolge option:selected').each(function () {
            veliBolgeID.push($(this).val());
        });
        //veli Bölge Ad
        var veliBolgeAd = new Array();
        $('select#VeliDetaySelectBolge option:selected').each(function () {
            veliBolgeAd.push($(this).attr('title'));
        });
        //veli Kurum Id
        var veliKurumID = new Array();
        $('select#VeliDetayKurum option:selected').each(function () {
            veliKurumID.push($(this).val());
        });
        //veli Kurum Ad
        var veliKurumAd = new Array();
        $('select#VeliDetayKurum option:selected').each(function () {
            veliKurumAd.push($(this).attr('title'));
        });
        //veli Öğrenci Id
        var veliOgrenciID = new Array();
        $('select#VeliDetayOgrenciSelect option:selected').each(function () {
            veliOgrenciID.push($(this).val());
        });
        //veli Öğrenci Ad
        var veliOgrenciAd = new Array();
        $('select#VeliDetayOgrenciSelect option:selected').each(function () {
            veliOgrenciAd.push($(this).attr('title'));
        });
        //Veli Seçili Olmayan Bölge ID
        var veliBolgeNID = new Array();
        $('select#VeliDetaySelectBolge option:not(:selected)').each(function () {
            veliBolgeNID.push($(this).val());
        });
        //veli Seçili Olmayan Bölge Ad
        var veliBolgeNAd = new Array();
        $('select#VeliDetaySelectBolge option:not(:selected)').each(function () {
            veliBolgeNAd.push($(this).attr('title'));
        });
        //veli Seçili Olmayan Kurum Id
        var veliKurumNID = new Array();
        $('select#VeliDetayKurum option:not(:selected)').each(function () {
            veliKurumNID.push($(this).val());
        });
        //veli Seçili Olmayan Kurum Ad
        var veliKurumNAd = new Array();
        $('select#VeliDetayKurum option:not(:selected)').each(function () {
            veliKurumNAd.push($(this).attr('title'));
        });
        //veli Seçili Olmayan Öğrenci Id
        var veliOgrenciNID = new Array();
        $('select#VeliDetayOgrenciSelect option:not(:selected)').each(function () {
            veliOgrenciNID.push($(this).val());
        });
        //veli Seçili Olmayan Öğrenci Ad
        var veliOgrenciNAd = new Array();
        $('select#VeliDetayOgrenciSelect option:not(:selected)').each(function () {
            veliOgrenciNAd.push($(this).attr('title'));
        });
        var SelectBolgeOptions = new Array();
        var SelectKurumOptions = new Array();
        var SelectOgrenciOptions = new Array();
        if (veliBolgeID.length > 0) {
            var bolgelength = veliBolgeID.length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: veliBolgeAd[b], title: veliBolgeAd[b], value: veliBolgeID[b], selected: true};
            }

            if (veliBolgeNID.length > 0) {
                var veliBolgeLength = veliBolgeNID.length;
                for (var z = 0; z < veliBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: veliBolgeNAd[z], title: veliBolgeNAd[z], value: veliBolgeNID[z]};
                    b++;
                }

            }
        } else {
            if (veliBolgeNID.length > 0) {
                var veliBolgeLength = veliBolgeNID.length;
                for (var b = 0; b < veliBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: veliBolgeNAd[b], title: veliBolgeNAd[b], value: veliBolgeNID[b]};
                }

            }
        }

        if (veliKurumID.length > 0) {
            var aracselectlength = veliKurumID.length;
            for (var t = 0; t < aracselectlength; t++) {
                SelectKurumOptions[t] = {label: veliKurumAd[t], title: veliKurumAd[t], value: veliKurumID[t], selected: true};
            }

            if (veliKurumNID.length > 0) {
                var velilength = veliKurumNID.length;
                for (var f = 0; f < velilength; f++) {
                    SelectKurumOptions[t] = {label: veliKurumNAd[f], title: veliKurumNAd[f], value: veliKurumNID[f]};
                    t++;
                }
            }

        } else {
            if (veliKurumNID.length > 0) {
                var velilength = veliKurumNID.length;
                for (var t = 0; t < velilength; t++) {
                    SelectKurumOptions[t] = {label: veliKurumNAd[t], title: veliKurumNAd[t], value: veliKurumNID[t]};
                }
            }
        }

        if (veliOgrenciID.length > 0) {
            var ogrenciselectlength = veliOgrenciID.length;
            for (var t = 0; t < ogrenciselectlength; t++) {
                SelectOgrenciOptions[t] = {label: veliOgrenciAd[t], title: veliOgrenciAd[t], value: veliOgrenciID[t], selected: true};
            }

            if (veliOgrenciNID.length > 0) {
                var ogrencilength = veliOgrenciNID.length;
                for (var f = 0; f < ogrencilength; f++) {
                    SelectOgrenciOptions[t] = {label: veliOgrenciNAd[f], title: veliOgrenciNAd[f], value: veliOgrenciNID[f]};
                    t++;
                }
            }

        } else {
            if (veliOgrenciNID.length > 0) {
                var ogrencilength = veliOgrenciNID.length;
                for (var t = 0; t < ogrencilength; t++) {
                    SelectOgrenciOptions[t] = {label: veliOgrenciNAd[t], title: veliOgrenciNAd[t], value: veliOgrenciNID[t]};
                }
            }
        }

        $('#VeliDetaySelectBolge').multiselect('refresh');
        $('#VeliDetayKurum').multiselect('refresh');
        $('#VeliDetayOgrenciSelect').multiselect('refresh');
        $('#VeliDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
        $('#VeliDetayKurum').multiselect('dataprovider', SelectKurumOptions);
        $('#VeliDetayOgrenciSelect').multiselect('dataprovider', SelectOgrenciOptions);
        VeliDetailVazgec = [];
        VeliDetailVazgec.push(veliDetayAd, veliDetaySoyad, veliDetayDurum, veliDetayLokasyon, veliDetayTelefon, veliDetayEmail, veliDetayAdres, veliDetayAciklama, veliDetayUlke, veliDetayIl, veliDetayIlce, veliDetaySemt, veliDetayMahalle, veliDetaySokak, veliDetayPostaKodu, veliDetayCaddeNo, veliBolgeID, veliBolgeAd, veliBolgeNID, veliBolgeNAd, veliKurumID, veliKurumAd, veliKurumNID, veliKurumNAd, veliOgrenciID, veliOgrenciAd, veliOgrenciNID, veliOgrenciNAd);
    },
    veliDetailVazgec: function () {
        $("input[name=VeliDetayAdi]").val(VeliDetailVazgec[0]);
        $("input[name=VeliDetaySoyadi]").val(VeliDetailVazgec[1]);
        $("#VeliDetayDurum").val(VeliDetailVazgec[2]);
        $("input[name=KurumLokasyon]").val(VeliDetailVazgec[3]);
        $("input[name=VeliDetayTelefon]").val(VeliDetailVazgec[4]);
        $("input[name=VeliDetayEmail]").val(VeliDetailVazgec[5]);
        $("textarea[name=VeliDetayAdresDetay]").val(VeliDetailVazgec[6]);
        $("textarea[name=DetayAciklama]").val(VeliDetailVazgec[7]);
        $("input[name=country]").val(VeliDetailVazgec[8]);
        $("input[name=administrative_area_level_1]").val(VeliDetailVazgec[9]);
        $("input[name=administrative_area_level_2]").val(VeliDetailVazgec[10]);
        $("input[name=locality]").val(VeliDetailVazgec[11]);
        $("input[name=neighborhood]").val(VeliDetailVazgec[12]);
        $("input[name=route]").val(VeliDetailVazgec[13]);
        $("input[name=postal_code]").val(VeliDetailVazgec[14]);
        $("input[name=street_number]").val(VeliDetailVazgec[15]);
        var SelectBolgeOptions = new Array();
        var SelectKurumOptions = new Array();
        var SelectOgrenciOptions = new Array();
        if (VeliDetailVazgec[16].length > 0) {
            var bolgelength = VeliDetailVazgec[16].length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: VeliDetailVazgec[17][b], title: VeliDetailVazgec[17][b], value: VeliDetailVazgec[16][b], selected: true, disabled: true};
            }
            if (VeliDetailVazgec[18].length > 0) {
                var isciBolgeLength = VeliDetailVazgec[18].length;
                for (var z = 0; z < isciBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: VeliDetailVazgec[19][z], title: VeliDetailVazgec[19][z], value: VeliDetailVazgec[18][z], disabled: true};
                    b++;
                }
            }
        } else {
            if (VeliDetailVazgec[18].length > 0) {
                var isciBolgeLength = VeliDetailVazgec[18].length;
                for (var b = 0; b < isciBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: VeliDetailVazgec[19][b], title: VeliDetailVazgec[19][b], value: VeliDetailVazgec[18][b], disabled: true};
                }
            }
        }


        if (VeliDetailVazgec[20].length > 0) {
            var kurumselectlength = VeliDetailVazgec[20].length;
            for (var t = 0; t < kurumselectlength; t++) {
                SelectKurumOptions[t] = {label: VeliDetailVazgec[21][t], title: VeliDetailVazgec[21][t], value: VeliDetailVazgec[20][t], selected: true, disabled: true};
            }
            if (VeliDetailVazgec[22].length > 0) {
                var kurumlength = VeliDetailVazgec[22].length;
                for (var f = 0; f < kurumlength; f++) {
                    SelectKurumOptions[t] = {label: VeliDetailVazgec[23][f], title: VeliDetailVazgec[23][f], value: VeliDetailVazgec[22][f], disabled: true};
                    t++;
                }
            }
        } else {
            if (VeliDetailVazgec[22].length > 0) {
                var kurumlength = VeliDetailVazgec[22].length;
                for (var t = 0; t < kurumlength; t++) {
                    SelectKurumOptions[t] = {label: VeliDetailVazgec[23][t], title: VeliDetailVazgec[23][t], value: VeliDetailVazgec[22][t], disabled: true};
                }
            }
        }

        if (VeliDetailVazgec[24].length > 0) {
            var ogrenciselectlength = VeliDetailVazgec[24].length;
            for (var t = 0; t < ogrenciselectlength; t++) {
                SelectOgrenciOptions[t] = {label: VeliDetailVazgec[25][t], title: VeliDetailVazgec[25][t], value: VeliDetailVazgec[25][t], selected: true, disabled: true};
            }
            if (VeliDetailVazgec[26].length > 0) {
                var ogrencilength = VeliDetailVazgec[26].length;
                for (var f = 0; f < ogrencilength; f++) {
                    SelectOgrenciOptions[t] = {label: VeliDetailVazgec[27][f], title: VeliDetailVazgec[27][f], value: VeliDetailVazgec[26][f], disabled: true};
                    t++;
                }
            }
        } else {
            if (VeliDetailVazgec[26].length > 0) {
                var ogrencilength = VeliDetailVazgec[26].length;
                for (var t = 0; t < ogrencilength; t++) {
                    SelectOgrenciOptions[t] = {label: VeliDetailVazgec[27][t], title: VeliDetailVazgec[27][t], value: VeliDetailVazgec[26][t], disabled: true};
                }
            }
        }

        $('#VeliDetaySelectBolge').multiselect('refresh');
        $('#VeliDetayKurum').multiselect('refresh');
        $('#VeliDetayOgrenciSelect').multiselect('refresh');
        $('#VeliDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
        $('#VeliDetayKurum').multiselect('dataprovider', SelectKurumOptions);
        $('#VeliDetayOgrenciSelect').multiselect('dataprovider', SelectOgrenciOptions);
    },
    veliDetailSil: function () {
        reset();
        alertify.confirm(jsDil.SilOnay, function (e) {
            if (e) {
                var velidetail_id = $("input[name=veliDetayID]").val();
                $.ajax({
                    data: {"velidetail_id": velidetail_id, "tip": "veliDetailDelete"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(jsDil.Hata);
                            return false;
                        } else {
                            disabledForm();
                            $("input[name=VeliDetayAdi]").val('');
                            $("input[name=VeliDetaySoyadi]").val('');
                            $("#VeliDetayDurum").val('');
                            $("input[name=KurumLokasyon]").val('');
                            $("input[name=VeliDetayTelefon]").val('');
                            $("input[name=VeliDetayEmail]").val('');
                            $("textarea[name=VeliDetayAdresDetay]").val('');
                            $("textarea[name=DetayAciklama]").val('');
                            $("input[name=country]").val('');
                            $("input[name=administrative_area_level_1]").val('');
                            $("input[name=administrative_area_level_2]").val('');
                            $("input[name=locality]").val('');
                            $("input[name=neighborhood]").val('');
                            $("input[name=route]").val('');
                            $("input[name=postal_code]").val('');
                            $("input[name=street_number]").val('');
                            var veliCount = $('#smallVeli').text();
                            veliCount--;
                            $('#smallVeli').text(veliCount);
                            var length = $('tbody#veliRow tr').length;
                            for (var t = 0; t < length; t++) {
                                var attrValueId = $("tbody#veliRow > tr > td > a").eq(t).attr('value');
                                if (attrValueId == velidetail_id) {
                                    var deleteRow = $('tbody#veliRow > tr:eq(' + t + ')');
                                    VeliTable.DataTable().row($(deleteRow)).remove().draw();
                                }
                            }
                            reset();
                            alertify.success(jsDil.SilEvet);
                            svControl('svClose', 'VeliDetay', '');
                        }
                    }
                });
            } else {
                alertify.error(jsDil.SilRed);
            }
        });
    },
    veliDetailKaydet: function () {
        var velidetail_id = $("input[name=veliDetayID]").val();
        //Veli İşlemleri Değerleri
        var veliDetayAd = $("input[name=VeliDetayAdi]").val();
        var veliDetaySoyad = $("input[name=VeliDetaySoyadi]").val();
        var veliDetayDurum = $("#VeliDetayDurum").val();
        var veliDetayLokasyon = $("input[name=KurumLokasyon]").val();
        var veliDetayTelefon = $("input[name=VeliDetayTelefon]").val();
        var veliDetayEmail = $("input[name=VeliDetayEmail]").val();
        var veliDetayAdres = $("textarea[name=VeliDetayAdresDetay]").val();
        var veliDetayAciklama = $("textarea[name=DetayAciklama]").val();
        var veliDetayUlke = $("input[name=country]").val();
        var veliDetayIl = $("input[name=administrative_area_level_1]").val();
        var veliDetayIlce = $("input[name=administrative_area_level_2]").val();
        var veliDetaySemt = $("input[name=locality]").val();
        var veliDetayMahalle = $("input[name=neighborhood]").val();
        var veliDetaySokak = $("input[name=route]").val();
        var veliDetayPostaKodu = $("input[name=postal_code]").val();
        var veliDetayCaddeNo = $("input[name=street_number]").val();
        //veli Bölge ID
        var veliBolgeID = new Array();
        $('select#VeliDetaySelectBolge option:selected').each(function () {
            veliBolgeID.push($(this).val());
        });
        //veli Bölge Ad
        var veliBolgeAd = new Array();
        $('select#VeliDetaySelectBolge option:selected').each(function () {
            veliBolgeAd.push($(this).attr('title'));
        });
        //veli Kurum Id
        var veliKurumID = new Array();
        $('select#VeliDetayKurum option:selected').each(function () {
            veliKurumID.push($(this).val());
        });
        //veli Kurum Ad
        var veliKurumAd = new Array();
        $('select#VeliDetayKurum option:selected').each(function () {
            veliKurumAd.push($(this).attr('title'));
        });
        //veli Öğrenci Id
        var veliOgrenciID = new Array();
        $('select#VeliDetayOgrenciSelect option:selected').each(function () {
            veliOgrenciID.push($(this).val());
        });
        //veli Öğrenci Ad
        var veliOgrenciAd = new Array();
        $('select#VeliDetayOgrenciSelect option:selected').each(function () {
            veliOgrenciAd.push($(this).attr('title'));
        });
        //Veli Seçili Olmayan Bölge ID
        var veliBolgeNID = new Array();
        $('select#VeliDetaySelectBolge option:not(:selected)').each(function () {
            veliBolgeNID.push($(this).val());
        });
        //veli Seçili Olmayan Bölge Ad
        var veliBolgeNAd = new Array();
        $('select#VeliDetaySelectBolge option:not(:selected)').each(function () {
            veliBolgeNAd.push($(this).attr('title'));
        });
        //veli Seçili Olmayan Kurum Id
        var veliKurumNID = new Array();
        $('select#VeliDetayKurum option:not(:selected)').each(function () {
            veliKurumNID.push($(this).val());
        });
        //veli Seçili Olmayan Kurum Ad
        var veliKurumNAd = new Array();
        $('select#VeliDetayKurum option:not(:selected)').each(function () {
            veliKurumNAd.push($(this).attr('title'));
        });
        //veli Seçili Olmayan Öğrenci Id
        var veliOgrenciNID = new Array();
        $('select#VeliDetayOgrenciSelect option:not(:selected)').each(function () {
            veliOgrenciNID.push($(this).val());
        });
        //veli Seçili Olmayan Öğrenci Ad
        var veliOgrenciNAd = new Array();
        $('select#VeliDetayOgrenciSelect option:not(:selected)').each(function () {
            veliOgrenciNAd.push($(this).attr('title'));
        });
        var farkbolge = farkArray(VeliDetailVazgec[16], veliBolgeID);
        var farkbolgelength = farkbolge.length;
        var farkkurum = farkArray(VeliDetailVazgec[20], veliKurumID);
        var farkkurumlength = farkkurum.length;
        var farkogrenci = farkArray(VeliDetailVazgec[24], veliOgrenciID);
        var farkogrencilength = farkogrenci.length;
        if (VeliDetailVazgec[0] == veliDetayAd && VeliDetailVazgec[1] == veliDetaySoyad && VeliDetailVazgec[2] == veliDetayDurum && VeliDetailVazgec[3] == veliDetayLokasyon && VeliDetailVazgec[4] == veliDetayTelefon && VeliDetailVazgec[5] == veliDetayEmail && VeliDetailVazgec[6] == veliDetayAdres && VeliDetailVazgec[7] == veliDetayAciklama && VeliDetailVazgec[8] == veliDetayUlke && VeliDetailVazgec[9] == veliDetayIl && VeliDetailVazgec[10] == veliDetayIlce && VeliDetailVazgec[11] == veliDetaySemt && VeliDetailVazgec[12] == veliDetayMahalle && VeliDetailVazgec[13] == veliDetaySokak && VeliDetailVazgec[14] == veliDetayPostaKodu && VeliDetailVazgec[15] == veliDetayCaddeNo && farkbolgelength == 0 && farkkurumlength == 0 && farkogrencilength == 0) {
            reset();
            alertify.alert(jsDil.Degisiklik);
            return false;
        } else {
            var veliBolgeLength = $('select#VeliDetaySelectBolge option:selected').val();
            if (veliBolgeLength) {
                var veliKurumLength = $('select#VeliDetayKurum option:selected').val();
                if (veliKurumLength) {
                    $.ajax({
                        data: {"velidetail_id": velidetail_id, "veliBolgeID[]": veliBolgeID, "veliBolgeAd[]": veliBolgeAd, "veliKurumID[]": veliKurumID, "veliKurumAd[]": veliKurumAd,
                            "veliOgrenciID[]": veliOgrenciID, "veliOgrenciAd[]": veliOgrenciAd, "veliDetayAd": veliDetayAd,
                            "veliDetaySoyad": veliDetaySoyad, "veliDetayDurum": veliDetayDurum, "veliDetayLokasyon": veliDetayLokasyon, "veliDetayTelefon": veliDetayTelefon,
                            "veliDetayEmail": veliDetayEmail, "veliDetayAdres": veliDetayAdres, "veliDetayAciklama": veliDetayAciklama, "veliDetayUlke": veliDetayUlke,
                            "veliDetayIl": veliDetayIl, "veliDetayIlce": veliDetayIlce, "veliDetaySemt": veliDetaySemt, "veliDetayMahalle": veliDetayMahalle,
                            "veliDetaySokak": veliDetaySokak, "veliDetayPostaKodu": veliDetayPostaKodu, "veliDetayCaddeNo": veliDetayCaddeNo, "tip": "veliDetailKaydet"},
                        success: function (cevap) {
                            if (cevap.hata) {
                                reset();
                                alertify.alert(jsDil.Hata);
                                return false;
                            } else {
                                disabledForm();
                                reset();
                                alertify.success(jsDil.VeliDuzenle);
                                var SelectBolgeOptions = new Array();
                                var SelectKurumOptions = new Array();
                                var SelectOgrenciOptions = new Array();
                                if (veliBolgeID.length > 0) {
                                    var bolgelength = veliBolgeID.length;
                                    for (var b = 0; b < bolgelength; b++) {
                                        SelectBolgeOptions[b] = {label: veliBolgeAd[b], title: veliBolgeAd[b], value: veliBolgeID[b], selected: true, disabled: true};
                                    }

                                    if (veliBolgeNID.length > 0) {
                                        var veliBolgeLength = veliBolgeNID.length;
                                        for (var z = 0; z < veliBolgeLength; z++) {
                                            SelectBolgeOptions[b] = {label: veliBolgeNAd[z], title: veliBolgeNAd[z], value: veliBolgeNID[z], disabled: true};
                                            b++;
                                        }

                                    }
                                } else {
                                    if (veliBolgeNID.length > 0) {
                                        var veliBolgeLength = veliBolgeNID.length;
                                        for (var b = 0; b < veliBolgeLength; b++) {
                                            SelectBolgeOptions[b] = {label: veliBolgeNAd[b], title: veliBolgeNAd[b], value: veliBolgeNID[b], disabled: true};
                                        }

                                    }
                                }

                                if (veliKurumID.length > 0) {
                                    var kurumselectlength = veliKurumID.length;
                                    for (var t = 0; t < kurumselectlength; t++) {
                                        SelectKurumOptions[t] = {label: veliKurumAd[t], title: veliKurumAd[t], value: veliKurumID[t], selected: true, disabled: true};
                                    }

                                    if (veliKurumNID.length > 0) {
                                        var kurumlength = veliKurumNID.length;
                                        for (var f = 0; f < kurumlength; f++) {
                                            SelectKurumOptions[t] = {label: veliKurumNAd[f], title: veliKurumNAd[f], value: veliKurumNID[f], disabled: true};
                                            t++;
                                        }
                                    }

                                } else {
                                    if (veliKurumNID.length > 0) {
                                        var kurumlength = veliKurumNID.length;
                                        for (var t = 0; t < kurumlength; t++) {
                                            SelectKurumOptions[t] = {label: veliKurumNAd[t], title: veliKurumNAd[t], value: veliKurumNID[t], disabled: true};
                                        }
                                    }
                                }

                                if (veliOgrenciID.length > 0) {
                                    var ogrenciselectlength = veliOgrenciID.length;
                                    for (var k = 0; k < ogrenciselectlength; k++) {
                                        SelectOgrenciOptions[k] = {label: veliOgrenciAd[k], title: veliOgrenciAd[k], value: veliOgrenciID[k], selected: true};
                                    }

                                    if (veliOgrenciNID.length > 0) {
                                        var ogrencilength = veliOgrenciNID.length;
                                        for (var l = 0; l < ogrencilength; l++) {
                                            SelectOgrenciOptions[k] = {label: veliOgrenciNAd[l], title: veliOgrenciNAd[l], value: veliOgrenciNID[l], disabled: true};
                                            k++;
                                        }
                                    }

                                } else {
                                    if (veliOgrenciNID.length > 0) {
                                        var ogrencilength = veliOgrenciNID.length;
                                        for (var k = 0; k < ogrencilength; k++) {
                                            SelectOgrenciOptions[k] = {label: veliOgrenciNAd[k], title: veliOgrenciNAd[k], value: veliOgrenciNID[k], disabled: true};
                                        }
                                    }
                                }

                                $('#VeliDetaySelectBolge').multiselect('refresh');
                                $('#VeliDetayKurum').multiselect('refresh');
                                $('#VeliDetayOgrenciSelect').multiselect('refresh');
                                $('#VeliDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
                                $('#VeliDetayKurum').multiselect('dataprovider', SelectKurumOptions);
                                $('#VeliDetayOgrenciSelect').multiselect('dataprovider', SelectOgrenciOptions);
                                var length = $('tbody#veliRow tr').length;
                                for (var t = 0; t < length; t++) {
                                    var attrValueId = $("tbody#veliRow > tr > td > a").eq(t).attr('value');
                                    if (attrValueId == velidetail_id) {
                                        if (veliDetayDurum != 0) {
                                            $("tbody#veliRow > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-user"></i> ' + veliDetayAd);
                                            $("tbody#veliRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(veliDetaySoyad);
                                            $("tbody#veliRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(veliDetayTelefon);
                                            $("tbody#veliRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(veliDetayEmail);
                                            $("tbody#veliRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(veliDetayAciklama);
                                            $('tbody#veliRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                        } else {
                                            $("tbody#veliRow > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-user" style="color:red"></i> ' + veliDetayAd);
                                            $("tbody#veliRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(veliDetaySoyad);
                                            $("tbody#veliRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(veliDetayTelefon);
                                            $("tbody#veliRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(veliDetayEmail);
                                            $("tbody#veliRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(veliDetayAciklama);
                                            $('tbody#veliRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                        }
                                    }
                                }
                            }
                        }
                    });
                } else {
                    reset();
                    alertify.alert(jsDil.KurumSec);
                    return false;
                }
            } else {
                reset();
                alertify.alert(jsDil.BolgeSec);
                return false;
            }
        }
    }
}


