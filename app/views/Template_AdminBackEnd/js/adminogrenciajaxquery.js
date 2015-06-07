$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminOgrenciAjaxSorgu",
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
    OgrenciTable = $('#ogrenciTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    //Öğrenci İşlemleri
    $(document).on('click', 'tbody#ogrenciRow > tr > td > a', function (e) {
        var i = $(this).find("i");
        i.removeClass("glyphicon glyphicon-user");
        i.addClass("fa fa-spinner");
        var ogrenciRowid = $(this).attr('value');
        $.ajax({
            data: {"ogrenciRowid": ogrenciRowid, "tip": "ogrenciDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {

                    $("input[name=OgrenciDetayAdi]").val(cevap.ogrenciDetail[0].OgrenciListAd);
                    $("input[name=OgrenciDetaySoyadi]").val(cevap.ogrenciDetail[0].OgrenciListSoyad);
                    $("#OgrenciDetayDurum").val(cevap.ogrenciDetail[0].OgrenciListDurum);
                    $("input[name=KurumLokasyon]").val(cevap.ogrenciDetail[0].OgrenciListLokasyon);
                    $("input[name=OgrenciDetayTelefon]").val(cevap.ogrenciDetail[0].OgrenciListTelefon);
                    $("input[name=OgrenciDetayEmail]").val(cevap.ogrenciDetail[0].OgrenciListMail);
                    $("textarea[name=OgrenciDetayAdresDetay]").val(cevap.ogrenciDetail[0].OgrenciListAdres);
                    $("textarea[name=DetayAciklama]").val(cevap.ogrenciDetail[0].OgrenciListAciklama);
                    $("input[name=country]").val(cevap.ogrenciDetail[0].OgrenciListUlke);
                    $("input[name=administrative_area_level_1]").val(cevap.ogrenciDetail[0].OgrenciListIl);
                    $("input[name=administrative_area_level_2]").val(cevap.ogrenciDetail[0].OgrenciListIlce);
                    $("input[name=locality]").val(cevap.ogrenciDetail[0].OgrenciListSemt);
                    $("input[name=neighborhood]").val(cevap.ogrenciDetail[0].OgrenciListMahalle);
                    $("input[name=route]").val(cevap.ogrenciDetail[0].OgrenciListSokak);
                    $("input[name=postal_code]").val(cevap.ogrenciDetail[0].OgrenciListPostaKodu);
                    $("input[name=street_number]").val(cevap.ogrenciDetail[0].OgrenciListCaddeNo);
                    $("input[name=ogrenciDetayID]").val(cevap.ogrenciDetail[0].OgrenciListID);
                    var SelectBolgeOptions = new Array();
                    var SelectKurumOptions = new Array();
                    var SelectVeliOptions = new Array();
                    if (cevap.ogrenciSelectBolge) {
                        var bolgelength = cevap.ogrenciSelectBolge.length;
                        for (var b = 0; b < bolgelength; b++) {
                            SelectBolgeOptions[b] = {label: cevap.ogrenciSelectBolge[b].SelectOgrenciBolgeAdi, title: cevap.ogrenciSelectBolge[b].SelectOgrenciBolgeAdi, value: cevap.ogrenciSelectBolge[b].SelectOgrenciBolgeID, selected: true, disabled: true};
                        }

                        if (cevap.ogrenciBolge) {
                            var bolgelength = cevap.ogrenciBolge.length;
                            for (var z = 0; z < bolgelength; z++) {
                                SelectBolgeOptions[b] = {label: cevap.ogrenciBolge[z].DigerOgrenciBolgeAdi, title: cevap.ogrenciBolge[z].DigerOgrenciBolgeAdi, value: cevap.ogrenciBolge[z].DigerOgrenciBolgeID, disabled: true};
                                b++;
                            }

                        }
                    } else {
                        if (cevap.ogrenciBolge) {
                            var bolgelength = cevap.ogrenciBolge.length;
                            for (var b = 0; b < bolgelength; b++) {
                                SelectBolgeOptions[b] = {label: cevap.ogrenciBolge[b].DigerOgrenciBolgeAdi, title: cevap.ogrenciBolge[b].DigerOgrenciBolgeAdi, value: cevap.ogrenciBolge[b].DigerOgrenciBolgeID, disabled: true};
                            }
                        }
                    }


                    if (cevap.ogrenciSelectKurum) {
                        var kurumselectlength = cevap.ogrenciSelectKurum.length;
                        for (var t = 0; t < kurumselectlength; t++) {
                            SelectKurumOptions[t] = {label: cevap.ogrenciSelectKurum[t].SelectOgrenciKurumAd, title: cevap.ogrenciSelectKurum[t].SelectOgrenciKurumAd, value: cevap.ogrenciSelectKurum[t].SelectOgrenciKurumID, selected: true, disabled: true};
                        }
                        if (cevap.ogrenciKurum) {
                            var kurumlength = cevap.ogrenciKurum.length;
                            for (var f = 0; f < kurumlength; f++) {
                                SelectKurumOptions[t] = {label: cevap.ogrenciKurum[f].DigerOgrenciKurumAd, title: cevap.ogrenciKurum[f].DigerOgrenciKurumAd, value: cevap.ogrenciKurum[f].DigerOgrenciKurumID, disabled: true};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.ogrenciKurum) {
                            var kurumlength = cevap.ogrenciKurum.length;
                            for (var t = 0; t < kurumlength; t++) {
                                SelectKurumOptions[t] = {label: cevap.ogrenciKurum[t].DigerOgrenciKurumAd, title: cevap.ogrenciKurum[t].DigerOgrenciKurumAd, value: cevap.ogrenciKurum[t].DigerOgrenciKurumID, disabled: true};
                            }
                        }
                    }

                    if (cevap.ogrenciSelectVeli) {
                        var ogrenciselectlength = cevap.ogrenciSelectVeli.length;
                        for (var t = 0; t < ogrenciselectlength; t++) {
                            SelectVeliOptions[t] = {label: cevap.ogrenciSelectVeli[t].SelectOgrenciVeliAd, title: cevap.ogrenciSelectVeli[t].SelectOgrenciVeliAd, value: cevap.ogrenciSelectVeli[t].SelectOgrenciVeliID, selected: true, disabled: true};
                        }
                        if (cevap.ogrenciVeli) {
                            var velilength = cevap.ogrenciVeli.length;
                            for (var f = 0; f < velilength; f++) {
                                SelectVeliOptions[t] = {label: cevap.ogrenciVeli[f].DigerOgrenciVeliAd, title: cevap.ogrenciVeli[f].DigerOgrenciVeliAd, value: cevap.ogrenciVeli[f].DigerOgrenciVeliID, disabled: true};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.ogrenciVeli) {
                            var velilength = cevap.ogrenciVeli.length;
                            for (var t = 0; t < velilength; t++) {
                                SelectVeliOptions[t] = {label: cevap.ogrenciVeli[t].DigerOgrenciVeliAd, title: cevap.ogrenciVeli[t].DigerOgrenciVeliAd, value: cevap.ogrenciVeli[t].DigerOgrenciVeliID, disabled: true};
                            }
                        }
                    }

                    $('#OgrenciDetaySelectBolge').multiselect('refresh');
                    $('#OgrenciDetayKurum').multiselect('refresh');
                    $('#OgrenciDetayVeliSelect').multiselect('refresh');
                    $('#OgrenciDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
                    $('#OgrenciDetayKurum').multiselect('dataprovider', SelectKurumOptions);
                    $('#OgrenciDetayVeliSelect').multiselect('dataprovider', SelectVeliOptions);
                    svControl('svAdd', 'OgrenciDetay', '');
                    i.removeClass("fa fa-spinner");
                    i.addClass("glyphicon glyphicon-user");
                }
            }
        });
    });
//kullanıcı işlemleri bölge select
    $('#OgrenciSelectBolge').on('change', function () {
        var ogrenciBolgeID = new Array();
        $('select#OgrenciSelectBolge option:selected').each(function () {
            ogrenciBolgeID.push($(this).val());
        });
        var KurumOptions = new Array();
        $.ajax({
            data: {"ogrenciBolgeID[]": ogrenciBolgeID, "tip": "ogrenciKurumMultiSelect"},
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
                        $('#OgrenciKurumSelect').multiselect('refresh');
                        $('#OgrenciKurumSelect').multiselect('dataprovider', KurumOptions);
                    } else {
                        $('#OgrenciKurumSelect').multiselect('refresh');
                        $('#OgrenciKurumSelect').multiselect('dataprovider', KurumOptions);
                    }
                }
            }
        });
    });
    $('#OgrenciKurumSelect').on('change', function () {
        var kurumBolgeID = new Array();
        $('select#OgrenciKurumSelect option:selected').each(function () {
            kurumBolgeID.push($(this).val());
        });
        var VeliOptions = new Array();
        $.ajax({
            data: {"kurumBolgeID[]": kurumBolgeID, "tip": "ogrenciVeliMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.veliMultiSelect) {
                        var velilength = cevap.veliMultiSelect.VeliSelectID.length;
                        for (var i = 0; i < velilength; i++) {
                            VeliOptions[i] = {label: cevap.veliMultiSelect.VeliSelectAd[i], title: cevap.veliMultiSelect.VeliSelectAd[i], value: cevap.veliMultiSelect.VeliSelectID[i]};
                        }
                        $('#OgrenciVeliSelect').multiselect('refresh');
                        $('#OgrenciVeliSelect').multiselect('dataprovider', VeliOptions);
                    } else {
                        $('#OgrenciVeliSelect').multiselect('refresh');
                        $('#OgrenciVeliSelect').multiselect('dataprovider', VeliOptions);
                    }
                }
            }
        });
    });
    $('#OgrenciDetaySelectBolge').on('change', function () {

        var ogrenciID = $("input[name=ogrenciDetayID]").val();
        var ogrenciDetailBolgeID = new Array();
        $('select#OgrenciDetaySelectBolge option:selected').each(function () {
            ogrenciDetailBolgeID.push($(this).val());
        });
        $('#OgrenciDetayKurum').multiselect('refresh');
        var KurumOptions = new Array();
        $.ajax({
            data: {"ogrenciID": ogrenciID, "ogrenciDetailBolgeID[]": ogrenciDetailBolgeID, "tip": "OgrenciBolgeDetailMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.adminOgrenciSelectKurum) {
                        var ogrenciselectlength = cevap.adminOgrenciSelectKurum.length;
                        for (var t = 0; t < ogrenciselectlength; t++) {
                            KurumOptions[t] = {label: cevap.adminOgrenciSelectKurum[t].SelectOgrenciKurumAd, title: cevap.adminOgrenciSelectKurum[t].SelectOgrenciKurumAd, value: cevap.adminOgrenciSelectKurum[t].SelectOgrenciKurumID, selected: true};
                        }
                        if (cevap.adminOgrenciKurum) {
                            var ogrencilength = cevap.adminOgrenciKurum.length;
                            for (var f = 0; f < ogrencilength; f++) {
                                KurumOptions[t] = {label: cevap.adminOgrenciKurum[f].DigerOgrenciKurumAd, title: cevap.adminOgrenciKurum[f].DigerOgrenciKurumAd, value: cevap.adminOgrenciKurum[f].DigerOgrenciKurumID};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.adminOgrenciKurum) {
                            var ogrencilength = cevap.adminOgrenciKurum.length;
                            for (var t = 0; t < ogrencilength; t++) {
                                KurumOptions[t] = {label: cevap.adminOgrenciKurum[t].DigerOgrenciKurumAd, title: cevap.adminOgrenciKurum[t].DigerOgrenciKurumAd, value: cevap.adminOgrenciKurum[t].DigerOgrenciKurumID};
                            }
                        }
                    }
                    $('#OgrenciDetayKurum').multiselect('refresh');
                    $('#OgrenciDetayKurum').multiselect('dataprovider', KurumOptions);
                }
            }
        });
    });
    $('#OgrenciDetayKurum').on('change', function () {

        var ogrenciID = $("input[name=ogrenciDetayID]").val();
        var veliDetailKurumID = new Array();
        $('select#OgrenciDetayKurum option:selected').each(function () {
            veliDetailKurumID.push($(this).val());
        });
        $('#OgrenciDetayKurum').multiselect('refresh');
        var VeliOptions = new Array();
        $.ajax({
            data: {"ogrenciID": ogrenciID, "veliDetailKurumID[]": veliDetailKurumID, "tip": "OgrenciVeliDetailMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.adminOgrenciSelectVeli) {
                        var veliselectlength = cevap.adminOgrenciSelectVeli.length;
                        for (var t = 0; t < veliselectlength; t++) {
                            VeliOptions[t] = {label: cevap.adminOgrenciSelectVeli[t].SelectOgrenciVeliAd, title: cevap.adminOgrenciSelectVeli[t].SelectOgrenciVeliAd, value: cevap.adminOgrenciSelectVeli[t].SelectOgrenciVeliID, selected: true};
                        }
                        if (cevap.adminOgrenciVeli) {
                            var velilength = cevap.adminOgrenciVeli.length;
                            for (var f = 0; f < velilength; f++) {
                                VeliOptions[t] = {label: cevap.adminOgrenciVeli[f].DigerOgrenciVeliAd, title: cevap.adminOgrenciVeli[f].DigerOgrenciVeliAd, value: cevap.adminOgrenciVeli[f].DigerOgrenciVeliID};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.adminOgrenciVeli) {
                            var velilength = cevap.adminOgrenciVeli.length;
                            for (var t = 0; t < velilength; t++) {
                                VeliOptions[t] = {label: cevap.adminOgrenciVeli[t].DigerOgrenciVeliAd, title: cevap.adminOgrenciVeli[t].DigerOgrenciVeliAd, value: cevap.adminOgrenciVeli[t].DigerOgrenciVeliID};
                            }
                        }
                    }
                    $('#OgrenciDetayVeliSelect').multiselect('refresh');
                    $('#OgrenciDetayVeliSelect').multiselect('dataprovider', VeliOptions);
                }
            }
        });
    });
//multi select açılma eventları
    //öğrenci bölge
    $('#OgrenciSelectBolge').multiselect({
        onDropdownShow: function (event) {
            $('#OgrenciKurumSelect').show();
        },
        onDropdownHide: function (event) {
            $('#OgrenciKurumSelect').hide();
        }
    });
    //öğrenci kurum
    $('#OgrenciKurumSelect').multiselect({
        onDropdownShow: function (event) {
            $('#OgrenciVeliSelect').show();
        },
        onDropdownHide: function (event) {
            $('#OgrenciVeliSelect').hide();
        }
    });
    //öğrenci detail bölge
    $('#OgrenciDetaySelectBolge').multiselect({
        onDropdownShow: function (event) {
            $('#OgrenciDetayKurum').show();
        },
        onDropdownHide: function (event) {
            $('#OgrenciDetayKurum').hide();
        }
    });
    //öğrenci detail kurum
    $('#OgrenciDetayKurum').multiselect({
        onDropdownShow: function (event) {
            $('#OgrenciDetayVeliSelect').show();
        },
        onDropdownHide: function (event) {
            $('#OgrenciDetayVeliSelect').hide();
        }
    });
});
var OgrenciDetailVazgec = [];
$.AdminIslemler = {
    ogrenciYeni: function () {
        $("input[name=OgrenciAdi]").val('');
        $("input[name=OgrenciSoyadi]").val('');
        $("#OgrenciDurum").val("1");
        $("input[name=KurumLokasyon]").val('');
        $("input[name=OgrenciTelefon]").val('');
        $("input[name=OgrenciEmail]").val('');
        $("textarea[name=OgrenciAdresDetay]").val('');
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
        var OgrenciKurumOptions = new Array();
        var VeliKurumOptions = new Array();
        $.ajax({
            data: {"tip": "ogrenciEkleSelect"},
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
                        $('#OgrenciSelectBolge').multiselect('refresh');
                        $('#OgrenciSelectBolge').multiselect('dataprovider', BolgeOptions);
                    } else {
                        $('#OgrenciSelectBolge').multiselect('refresh');
                        $('#OgrenciSelectBolge').multiselect('dataprovider', BolgeOptions);
                    }

                    $('#OgrenciKurumSelect').multiselect('refresh');
                    $('#OgrenciKurumSelect').multiselect('dataprovider', OgrenciKurumOptions);
                    $('#OgrenciVeliSelect').multiselect('refresh');
                    $('#OgrenciVeliSelect').multiselect('dataprovider', VeliKurumOptions);
                    var selectLength = $('#OgrenciSelectBolge > option').length;
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
    ogrenciVazgec: function () {
        return true;
    },
    ogrenciEkle: function () {

        var ogrenciAd = $("input[name=OgrenciAdi]").val();
        ogrenciAd = ogrenciAd.trim();
        if (ogrenciAd == '') {
            reset();
            alertify.alert(jsDil.IsimBos);
            return false;
        } else {
            if (ogrenciAd.length < 2) {
                reset();
                alertify.alert(jsDil.IsimKarekter);
                return false;
            } else {
                var ogrenciSoyad = $("input[name=OgrenciSoyadi]").val();
                ogrenciSoyad = ogrenciSoyad.trim();
                if (ogrenciSoyad == '') {
                    reset();
                    alertify.alert(jsDil.SoyadBos);
                    return false;
                } else {
                    if (ogrenciSoyad.length < 2) {
                        reset();
                        alertify.alert(jsDil.SoyadKarekter);
                        return false;
                    } else {
                        var ogrenciEmail = $("input[name=OgrenciEmail]").val();
                        if (ogrenciEmail == ' ') {
                            reset();
                            alertify.alert(jsDil.EpostaBos);
                            return false;
                        } else {
                            ogrenciEmail = ogrenciEmail.trim();
                            var result = ValidateEmail(ogrenciEmail);
                            if (!result) {
                                reset();
                                alertify.alert(jsDil.EpostaUygun);
                                return false;
                            } else {
                                var selectLength = $('#OgrenciSelectBolge > option').length;
                                if (selectLength) {
                                    var select = $('select#OgrenciSelectBolge option:selected').val();
                                    if (select) {
                                        var selectKurumLength = $('#OgrenciKurumSelect > option').length;
                                        if (selectKurumLength) {
                                            var selectKurum = $('select#OgrenciKurumSelect option:selected').val();
                                            if (selectKurum) {

                                                var ogrenciDurum = $("#OgrenciDurum option:selected").val();
                                                var ogrenciLokasyon = $("input[name=KurumLokasyon]").val();
                                                var ogrenciTelefon = $("input[name=OgrenciTelefon]").val();
                                                var ogrenciAdres = $("textarea[name=OgrenciAdresDetay]").val();
                                                var aciklama = $("textarea[name=Aciklama]").val();
                                                var ulke = $("input[name=country]").val();
                                                var il = $("input[name=administrative_area_level_1]").val();
                                                var ilce = $("input[name=administrative_area_level_2]").val();
                                                var semt = $("input[name=locality]").val();
                                                var mahalle = $("input[name=neighborhood]").val();
                                                var sokak = $("input[name=route]").val();
                                                var postakodu = $("input[name=postal_code]").val();
                                                var caddeno = $("input[name=street_number]").val();
                                                //ogrenci Bölge ID
                                                var ogrenciBolgeID = new Array();
                                                $('select#OgrenciSelectBolge option:selected').each(function () {
                                                    ogrenciBolgeID.push($(this).val());
                                                });
                                                //ogrenci Bölge Adi
                                                var ogrenciBolgeAdi = new Array();
                                                $('select#OgrenciSelectBolge option:selected').each(function () {
                                                    ogrenciBolgeAdi.push($(this).attr('title'));
                                                });
                                                //ogrenci Kurum ID
                                                var ogrenciKurumID = new Array();
                                                $('select#OgrenciKurumSelect option:selected').each(function () {
                                                    ogrenciKurumID.push($(this).val());
                                                });
                                                //ogrenci Kurum Ad
                                                var ogrenciKurumAd = new Array();
                                                $('select#OgrenciKurumSelect option:selected').each(function () {
                                                    ogrenciKurumAd.push($(this).attr('title'));
                                                });
                                                // Öğrenci veli ID
                                                var ogrenciVeliID = new Array();
                                                $('select#OgrenciVeliSelect option:selected').each(function () {
                                                    ogrenciVeliID.push($(this).val());
                                                });
                                                //Öğrenci veli  Ad
                                                var ogrenciVeliAd = new Array();
                                                $('select#OgrenciVeliSelect option:selected').each(function () {
                                                    ogrenciVeliAd.push($(this).attr('title'));
                                                });
                                                $.ajax({
                                                    data: {"ogrenciBolgeID[]": ogrenciBolgeID, "ogrenciBolgeAdi[]": ogrenciBolgeAdi, "ogrenciKurumID[]": ogrenciKurumID,
                                                        "ogrenciKurumAd[]": ogrenciKurumAd, "ogrenciVeliID[]": ogrenciVeliID, "ogrenciVeliAd[]": ogrenciVeliAd, "ogrenciAd": ogrenciAd,
                                                        "ogrenciSoyad": ogrenciSoyad, "ogrenciDurum": ogrenciDurum, "ogrenciLokasyon": ogrenciLokasyon, "ogrenciTelefon": ogrenciTelefon,
                                                        "ogrenciEmail": ogrenciEmail, "ogrenciAdres": ogrenciAdres, "aciklama": aciklama, "ulke": ulke,
                                                        "il": il, "ilce": ilce, "semt": semt, "mahalle": mahalle,
                                                        "sokak": sokak, "postakodu": postakodu, "caddeno": caddeno, "tip": "ogrenciKaydet"},
                                                    success: function (cevap) {
                                                        if (cevap.hata) {
                                                            reset();
                                                            alertify.alert(jsDil.Hata);
                                                            return false;
                                                        } else {
                                                            reset();
                                                            alertify.success(jsDil.OgrenciKaydet);
                                                            var ogrenciCount = $('#smallOgrenci').text();
                                                            ogrenciCount++;
                                                            $('#smallOgrenci').text(ogrenciCount);
                                                            if (ogrenciDurum != 0) {
                                                                var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newOgrenciID + "'>"
                                                                        + "<i class='glyphicon glyphicon-user' style='color:green;'></i> " + ogrenciAd + "</a></td>"
                                                                        + "<td class='hidden-xs'>" + ogrenciSoyad + "</td>"
                                                                        + "<td class='hidden-xs'>" + ogrenciTelefon + "</td>"
                                                                        + "<td class='hidden-xs'>" + ogrenciEmail + "</td>"
                                                                        + "<td class='hidden-xs'>" + aciklama + "</td></tr>";
                                                                OgrenciTable.DataTable().row.add($(addRow)).draw();
                                                            } else {
                                                                var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newOgrenciID + "'>"
                                                                        + "<i class='glyphicon glyphicon-user' style='color:red;'></i> " + ogrenciAd + "</a></td>"
                                                                        + "<td class='hidden-xs'>" + ogrenciSoyad + "</td>"
                                                                        + "<td class='hidden-xs'>" + ogrenciTelefon + "</td>"
                                                                        + "<td class='hidden-xs'>" + ogrenciEmail + "</td>"
                                                                        + "<td class='hidden-xs'>" + aciklama + "</td></tr>";
                                                                OgrenciTable.DataTable().row.add($(addRow)).draw();
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
    ogrenciDetailDuzenle: function () {
        //Öğrenci İşlemleri Değerleri
        var ogrenciDetayAd = $("input[name=OgrenciDetayAdi]").val();
        var ogrenciDetaySoyad = $("input[name=OgrenciDetaySoyadi]").val();
        var ogrenciDetayDurum = $("#OgrenciDetayDurum").val();
        var ogrenciDetayLokasyon = $("input[name=KurumLokasyon]").val();
        var ogrenciDetayTelefon = $("input[name=OgrenciDetayTelefon]").val();
        var ogrenciDetayEmail = $("input[name=OgrenciDetayEmail]").val();
        var ogrenciDetayAdres = $("textarea[name=OgrenciDetayAdresDetay]").val();
        var ogrenciDetayAciklama = $("textarea[name=DetayAciklama]").val();
        var ogrenciDetayUlke = $("input[name=country]").val();
        var ogrenciDetayIl = $("input[name=administrative_area_level_1]").val();
        var ogrenciDetayIlce = $("input[name=administrative_area_level_2]").val();
        var ogrenciDetaySemt = $("input[name=locality]").val();
        var ogrenciDetayMahalle = $("input[name=neighborhood]").val();
        var ogrenciDetaySokak = $("input[name=route]").val();
        var ogrenciDetayPostaKodu = $("input[name=postal_code]").val();
        var ogrenciDetayCaddeNo = $("input[name=street_number]").val();
        //öğrenci Bölge ID
        var ogrenciBolgeID = new Array();
        $('select#OgrenciDetaySelectBolge option:selected').each(function () {
            ogrenciBolgeID.push($(this).val());
        });
        //öğrenci Bölge Ad
        var ogrenciBolgeAd = new Array();
        $('select#OgrenciDetaySelectBolge option:selected').each(function () {
            ogrenciBolgeAd.push($(this).attr('title'));
        });
        //öğrenci Kurum Id
        var ogrenciKurumID = new Array();
        $('select#OgrenciDetayKurum option:selected').each(function () {
            ogrenciKurumID.push($(this).val());
        });
        //öğrenci Kurum Ad
        var ogrenciKurumAd = new Array();
        $('select#OgrenciDetayKurum option:selected').each(function () {
            ogrenciKurumAd.push($(this).attr('title'));
        });
        //öğrenci Öğrenci Id
        var ogrenciVeliID = new Array();
        $('select#OgrenciDetayVeliSelect option:selected').each(function () {
            ogrenciVeliID.push($(this).val());
        });
        //öğrenci Öğrenci Ad
        var ogrenciVeliAd = new Array();
        $('select#OgrenciDetayVeliSelect option:selected').each(function () {
            ogrenciVeliAd.push($(this).attr('title'));
        });
        //öğrenci Seçili Olmayan Bölge ID
        var ogrenciBolgeNID = new Array();
        $('select#OgrenciDetaySelectBolge option:not(:selected)').each(function () {
            ogrenciBolgeNID.push($(this).val());
        });
        //öğrenci Seçili Olmayan Bölge Ad
        var ogrenciBolgeNAd = new Array();
        $('select#OgrenciDetaySelectBolge option:not(:selected)').each(function () {
            ogrenciBolgeNAd.push($(this).attr('title'));
        });
        //öğrenci Seçili Olmayan Kurum Id
        var ogrenciKurumNID = new Array();
        $('select#OgrenciDetayKurum option:not(:selected)').each(function () {
            ogrenciKurumNID.push($(this).val());
        });
        //öğrenci Seçili Olmayan Kurum Ad
        var ogrenciKurumNAd = new Array();
        $('select#OgrenciDetayKurum option:not(:selected)').each(function () {
            ogrenciKurumNAd.push($(this).attr('title'));
        });
        //öğrenci Seçili Olmayan Öğrenci Id
        var ogrenciVeliNID = new Array();
        $('select#OgrenciDetayVeliSelect option:not(:selected)').each(function () {
            ogrenciVeliNID.push($(this).val());
        });
        //öğrenci Seçili Olmayan Öğrenci Ad
        var ogrenciVeliNAd = new Array();
        $('select#OgrenciDetayVeliSelect option:not(:selected)').each(function () {
            ogrenciVeliNAd.push($(this).attr('title'));
        });
        var SelectBolgeOptions = new Array();
        var SelectKurumOptions = new Array();
        var SelectVeliOptions = new Array();
        if (ogrenciBolgeID.length > 0) {
            var bolgelength = ogrenciBolgeID.length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: ogrenciBolgeAd[b], title: ogrenciBolgeAd[b], value: ogrenciBolgeID[b], selected: true};
            }

            if (ogrenciBolgeNID.length > 0) {
                var veliBolgeLength = ogrenciBolgeNID.length;
                for (var z = 0; z < veliBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: ogrenciBolgeNAd[z], title: ogrenciBolgeNAd[z], value: ogrenciBolgeNID[z]};
                    b++;
                }

            }
        } else {
            if (ogrenciBolgeNID.length > 0) {
                var veliBolgeLength = ogrenciBolgeNID.length;
                for (var b = 0; b < veliBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: ogrenciBolgeNAd[b], title: ogrenciBolgeNAd[b], value: ogrenciBolgeNID[b]};
                }

            }
        }

        if (ogrenciKurumID.length > 0) {
            var aracselectlength = ogrenciKurumID.length;
            for (var t = 0; t < aracselectlength; t++) {
                SelectKurumOptions[t] = {label: ogrenciKurumAd[t], title: ogrenciKurumAd[t], value: ogrenciKurumID[t], selected: true};
            }

            if (ogrenciKurumNID.length > 0) {
                var velilength = ogrenciKurumNID.length;
                for (var f = 0; f < velilength; f++) {
                    SelectKurumOptions[t] = {label: ogrenciKurumNAd[f], title: ogrenciKurumNAd[f], value: ogrenciKurumNID[f]};
                    t++;
                }
            }

        } else {
            if (ogrenciKurumNID.length > 0) {
                var velilength = ogrenciKurumNID.length;
                for (var t = 0; t < velilength; t++) {
                    SelectKurumOptions[t] = {label: ogrenciKurumNAd[t], title: ogrenciKurumNAd[t], value: ogrenciKurumNID[t]};
                }
            }
        }

        if (ogrenciVeliID.length > 0) {
            var ogrenciselectlength = ogrenciVeliID.length;
            for (var t = 0; t < ogrenciselectlength; t++) {
                SelectVeliOptions[t] = {label: ogrenciVeliAd[t], title: ogrenciVeliAd[t], value: ogrenciVeliID[t], selected: true};
            }

            if (ogrenciVeliNID.length > 0) {
                var velilength = ogrenciVeliNID.length;
                for (var f = 0; f < velilength; f++) {
                    SelectVeliOptions[t] = {label: ogrenciVeliNAd[f], title: ogrenciVeliNAd[f], value: ogrenciVeliNID[f]};
                    t++;
                }
            }

        } else {
            if (ogrenciVeliNID.length > 0) {
                var velilength = ogrenciVeliNID.length;
                for (var t = 0; t < velilength; t++) {
                    SelectVeliOptions[t] = {label: ogrenciVeliNAd[t], title: ogrenciVeliNAd[t], value: ogrenciVeliNID[t]};
                }
            }
        }

        $('#OgrenciDetaySelectBolge').multiselect('refresh');
        $('#OgrenciDetayKurum').multiselect('refresh');
        $('#OgrenciDetayVeliSelect').multiselect('refresh');
        $('#OgrenciDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
        $('#OgrenciDetayKurum').multiselect('dataprovider', SelectKurumOptions);
        $('#OgrenciDetayVeliSelect').multiselect('dataprovider', SelectVeliOptions);
        OgrenciDetailVazgec = [];
        OgrenciDetailVazgec.push(ogrenciDetayAd, ogrenciDetaySoyad, ogrenciDetayDurum, ogrenciDetayLokasyon, ogrenciDetayTelefon, ogrenciDetayEmail, ogrenciDetayAdres, ogrenciDetayAciklama, ogrenciDetayUlke, ogrenciDetayIl, ogrenciDetayIlce, ogrenciDetaySemt, ogrenciDetayMahalle, ogrenciDetaySokak, ogrenciDetayPostaKodu, ogrenciDetayCaddeNo, ogrenciBolgeID, ogrenciBolgeAd, ogrenciBolgeNID, ogrenciBolgeNAd, ogrenciKurumID, ogrenciKurumAd, ogrenciKurumNID, ogrenciKurumNAd, ogrenciVeliID, ogrenciVeliAd, ogrenciVeliNID, ogrenciVeliNAd);
    },
    ogrenciDetailVazgec: function () {
        $("input[name=OgrenciDetayAdi]").val(OgrenciDetailVazgec[0]);
        $("input[name=OgrenciDetaySoyadi]").val(OgrenciDetailVazgec[1]);
        $("#OgrenciDetayDurum").val(OgrenciDetailVazgec[2]);
        $("input[name=KurumLokasyon]").val(OgrenciDetailVazgec[3]);
        $("input[name=OgrenciDetayTelefon]").val(OgrenciDetailVazgec[4]);
        $("input[name=OgrenciDetayEmail]").val(OgrenciDetailVazgec[5]);
        $("textarea[name=OgrenciDetayAdresDetay]").val(OgrenciDetailVazgec[6]);
        $("textarea[name=DetayAciklama]").val(OgrenciDetailVazgec[7]);
        $("input[name=country]").val(OgrenciDetailVazgec[8]);
        $("input[name=administrative_area_level_1]").val(OgrenciDetailVazgec[9]);
        $("input[name=administrative_area_level_2]").val(OgrenciDetailVazgec[10]);
        $("input[name=locality]").val(OgrenciDetailVazgec[11]);
        $("input[name=neighborhood]").val(OgrenciDetailVazgec[12]);
        $("input[name=route]").val(OgrenciDetailVazgec[13]);
        $("input[name=postal_code]").val(OgrenciDetailVazgec[14]);
        $("input[name=street_number]").val(OgrenciDetailVazgec[15]);
        var SelectBolgeOptions = new Array();
        var SelectKurumOptions = new Array();
        var SelectOgrenciOptions = new Array();
        if (OgrenciDetailVazgec[16].length > 0) {
            var bolgelength = OgrenciDetailVazgec[16].length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: OgrenciDetailVazgec[17][b], title: OgrenciDetailVazgec[17][b], value: OgrenciDetailVazgec[16][b], selected: true, disabled: true};
            }
            if (OgrenciDetailVazgec[18].length > 0) {
                var isciBolgeLength = OgrenciDetailVazgec[18].length;
                for (var z = 0; z < isciBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: OgrenciDetailVazgec[19][z], title: OgrenciDetailVazgec[19][z], value: OgrenciDetailVazgec[18][z], disabled: true};
                    b++;
                }
            }
        } else {
            if (OgrenciDetailVazgec[18].length > 0) {
                var isciBolgeLength = OgrenciDetailVazgec[18].length;
                for (var b = 0; b < isciBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: OgrenciDetailVazgec[19][b], title: OgrenciDetailVazgec[19][b], value: OgrenciDetailVazgec[18][b], disabled: true};
                }
            }
        }


        if (OgrenciDetailVazgec[20].length > 0) {
            var kurumselectlength = OgrenciDetailVazgec[20].length;
            for (var t = 0; t < kurumselectlength; t++) {
                SelectKurumOptions[t] = {label: OgrenciDetailVazgec[21][t], title: OgrenciDetailVazgec[21][t], value: OgrenciDetailVazgec[20][t], selected: true, disabled: true};
            }
            if (OgrenciDetailVazgec[22].length > 0) {
                var kurumlength = OgrenciDetailVazgec[22].length;
                for (var f = 0; f < kurumlength; f++) {
                    SelectKurumOptions[t] = {label: OgrenciDetailVazgec[23][f], title: OgrenciDetailVazgec[23][f], value: OgrenciDetailVazgec[22][f], disabled: true};
                    t++;
                }
            }
        } else {
            if (OgrenciDetailVazgec[22].length > 0) {
                var kurumlength = OgrenciDetailVazgec[22].length;
                for (var t = 0; t < kurumlength; t++) {
                    SelectKurumOptions[t] = {label: OgrenciDetailVazgec[23][t], title: OgrenciDetailVazgec[23][t], value: OgrenciDetailVazgec[22][t], disabled: true};
                }
            }
        }

        if (OgrenciDetailVazgec[24].length > 0) {
            var ogrenciselectlength = OgrenciDetailVazgec[24].length;
            for (var t = 0; t < ogrenciselectlength; t++) {
                SelectOgrenciOptions[t] = {label: OgrenciDetailVazgec[25][t], title: OgrenciDetailVazgec[25][t], value: OgrenciDetailVazgec[25][t], selected: true, disabled: true};
            }
            if (OgrenciDetailVazgec[26].length > 0) {
                var ogrencilength = OgrenciDetailVazgec[26].length;
                for (var f = 0; f < ogrencilength; f++) {
                    SelectOgrenciOptions[t] = {label: OgrenciDetailVazgec[27][f], title: OgrenciDetailVazgec[27][f], value: OgrenciDetailVazgec[26][f], disabled: true};
                    t++;
                }
            }
        } else {
            if (OgrenciDetailVazgec[26].length > 0) {
                var ogrencilength = OgrenciDetailVazgec[26].length;
                for (var t = 0; t < ogrencilength; t++) {
                    SelectOgrenciOptions[t] = {label: OgrenciDetailVazgec[27][t], title: OgrenciDetailVazgec[27][t], value: OgrenciDetailVazgec[26][t], disabled: true};
                }
            }
        }

        $('#OgrenciDetaySelectBolge').multiselect('refresh');
        $('#OgrenciDetayKurum').multiselect('refresh');
        $('#OgrenciDetayVeliSelect').multiselect('refresh');
        $('#OgrenciDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
        $('#OgrenciDetayKurum').multiselect('dataprovider', SelectKurumOptions);
        $('#OgrenciDetayVeliSelect').multiselect('dataprovider', SelectOgrenciOptions);
    },
    ogrenciDetailSil: function () {
        reset();
        alertify.confirm(jsDil.SilOnay, function (e) {
            if (e) {
                var ogrencidetail_id = $("input[name=ogrenciDetayID]").val();
                $.ajax({
                    data: {"ogrencidetail_id": ogrencidetail_id, "tip": "ogrenciDetailDelete"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(jsDil.Hata);
                            return false;
                        } else {
                            disabledForm();
                            $("input[name=OgrenciDetayAdi]").val('');
                            $("input[name=OgrenciDetaySoyadi]").val('');
                            $("#OgrenciDetayDurum").val('');
                            $("input[name=KurumLokasyon]").val('');
                            $("input[name=OgrenciDetayTelefon]").val('');
                            $("input[name=OgrenciDetayEmail]").val('');
                            $("textarea[name=OgrenciDetayAdresDetay]").val('');
                            $("textarea[name=DetayAciklama]").val('');
                            $("input[name=country]").val('');
                            $("input[name=administrative_area_level_1]").val('');
                            $("input[name=administrative_area_level_2]").val('');
                            $("input[name=locality]").val('');
                            $("input[name=neighborhood]").val('');
                            $("input[name=route]").val('');
                            $("input[name=postal_code]").val('');
                            $("input[name=street_number]").val('');
                            var ogrenciCount = $('#smallOgrenci').text();
                            ogrenciCount--;
                            $('#smallOgrenci').text(ogrenciCount);
                            var length = $('tbody#ogrenciRow tr').length;
                            for (var t = 0; t < length; t++) {
                                var attrValueId = $("tbody#ogrenciRow > tr > td > a").eq(t).attr('value');
                                if (attrValueId == ogrencidetail_id) {
                                    var deleteRow = $('tbody#ogrenciRow > tr:eq(' + t + ')');
                                    OgrenciTable.DataTable().row($(deleteRow)).remove().draw();
                                }
                            }
                            reset();
                            alertify.success(jsDil.SilEvet);
                            svControl('svClose', 'OgrenciDetay', '');
                        }
                    }
                });
            } else {
                alertify.error(jsDil.SilRed);
            }
        });
    },
    ogrenciDetailKaydet: function () {
        var ogrencidetail_id = $("input[name=ogrenciDetayID]").val();
        //Öğrenci İşlemleri Değerleri
        var ogrenciDetayAd = $("input[name=OgrenciDetayAdi]").val();
        var ogrenciDetaySoyad = $("input[name=OgrenciDetaySoyadi]").val();
        var ogrenciDetayDurum = $("#OgrenciDetayDurum").val();
        var ogrenciDetayLokasyon = $("input[name=KurumLokasyon]").val();
        var ogrenciDetayTelefon = $("input[name=OgrenciDetayTelefon]").val();
        var ogrenciDetayEmail = $("input[name=OgrenciDetayEmail]").val();
        var ogrenciDetayAdres = $("textarea[name=OgrenciDetayAdresDetay]").val();
        var ogrenciDetayAciklama = $("textarea[name=DetayAciklama]").val();
        var ogrenciDetayUlke = $("input[name=country]").val();
        var ogrenciDetayIl = $("input[name=administrative_area_level_1]").val();
        var ogrenciDetayIlce = $("input[name=administrative_area_level_2]").val();
        var ogrenciDetaySemt = $("input[name=locality]").val();
        var ogrenciDetayMahalle = $("input[name=neighborhood]").val();
        var ogrenciDetaySokak = $("input[name=route]").val();
        var ogrenciDetayPostaKodu = $("input[name=postal_code]").val();
        var ogrenciDetayCaddeNo = $("input[name=street_number]").val();
        //öğrenci Bölge ID
        var ogrenciBolgeID = new Array();
        $('select#OgrenciDetaySelectBolge option:selected').each(function () {
            ogrenciBolgeID.push($(this).val());
        });
        //öğrenci Bölge Ad
        var ogrenciBolgeAd = new Array();
        $('select#OgrenciDetaySelectBolge option:selected').each(function () {
            ogrenciBolgeAd.push($(this).attr('title'));
        });
        //öğrenci Kurum Id
        var ogrenciKurumID = new Array();
        $('select#OgrenciDetayKurum option:selected').each(function () {
            ogrenciKurumID.push($(this).val());
        });
        //öğrenci Kurum Ad
        var ogrenciKurumAd = new Array();
        $('select#OgrenciDetayKurum option:selected').each(function () {
            ogrenciKurumAd.push($(this).attr('title'));
        });
        //öğrenci Öğrenci Id
        var ogrenciVeliID = new Array();
        $('select#OgrenciDetayVeliSelect option:selected').each(function () {
            ogrenciVeliID.push($(this).val());
        });
        //öğrenci Öğrenci Ad
        var ogrenciVeliAd = new Array();
        $('select#OgrenciDetayVeliSelect option:selected').each(function () {
            ogrenciVeliAd.push($(this).attr('title'));
        });
        //öğrenci Seçili Olmayan Bölge ID
        var ogrenciBolgeNID = new Array();
        $('select#OgrenciDetaySelectBolge option:not(:selected)').each(function () {
            ogrenciBolgeNID.push($(this).val());
        });
        //öğrenci Seçili Olmayan Bölge Ad
        var ogrenciBolgeNAd = new Array();
        $('select#OgrenciDetaySelectBolge option:not(:selected)').each(function () {
            ogrenciBolgeNAd.push($(this).attr('title'));
        });
        //öğrenci Seçili Olmayan Kurum Id
        var ogrenciKurumNID = new Array();
        $('select#OgrenciDetayKurum option:not(:selected)').each(function () {
            ogrenciKurumNID.push($(this).val());
        });
        //öğrenci Seçili Olmayan Kurum Ad
        var ogrenciKurumNAd = new Array();
        $('select#OgrenciDetayKurum option:not(:selected)').each(function () {
            ogrenciKurumNAd.push($(this).attr('title'));
        });
        //öğrenci Seçili Olmayan Öğrenci Id
        var ogrenciVeliNID = new Array();
        $('select#OgrenciDetayVeliSelect option:not(:selected)').each(function () {
            ogrenciVeliNID.push($(this).val());
        });
        //öğrenci Seçili Olmayan Öğrenci Ad
        var ogrenciVeliNAd = new Array();
        $('select#OgrenciDetayVeliSelect option:not(:selected)').each(function () {
            ogrenciVeliNAd.push($(this).attr('title'));
        });
        var farkbolge = farkArray(OgrenciDetailVazgec[16], ogrenciBolgeID);
        var farkbolgelength = farkbolge.length;
        var farkkurum = farkArray(OgrenciDetailVazgec[20], ogrenciKurumID);
        var farkkurumlength = farkkurum.length;
        var farkogrenci = farkArray(OgrenciDetailVazgec[24], ogrenciVeliID);
        var farkogrencilength = farkogrenci.length;
        if (OgrenciDetailVazgec[0] == ogrenciDetayAd && OgrenciDetailVazgec[1] == ogrenciDetaySoyad && OgrenciDetailVazgec[2] == ogrenciDetayDurum && OgrenciDetailVazgec[3] == ogrenciDetayLokasyon && OgrenciDetailVazgec[4] == ogrenciDetayTelefon && OgrenciDetailVazgec[5] == ogrenciDetayEmail && OgrenciDetailVazgec[6] == ogrenciDetayAdres && OgrenciDetailVazgec[7] == ogrenciDetayAciklama && OgrenciDetailVazgec[8] == ogrenciDetayUlke && OgrenciDetailVazgec[9] == ogrenciDetayIl && OgrenciDetailVazgec[10] == ogrenciDetayIlce && OgrenciDetailVazgec[11] == ogrenciDetaySemt && OgrenciDetailVazgec[12] == ogrenciDetayMahalle && OgrenciDetailVazgec[13] == ogrenciDetaySokak && OgrenciDetailVazgec[14] == ogrenciDetayPostaKodu && OgrenciDetailVazgec[15] == ogrenciDetayCaddeNo && farkbolgelength == 0 && farkkurumlength == 0 && farkogrencilength == 0) {
            reset();
            alertify.alert(jsDil.Degisiklik);
            return false;
        } else {
            var ogrenciBolgeLength = $('select#OgrenciDetaySelectBolge option:selected').val();
            if (ogrenciBolgeLength) {
                var ogrenciKurumLength = $('select#OgrenciDetayKurum option:selected').val();
                if (ogrenciKurumLength) {
                    $.ajax({
                        data: {"ogrencidetail_id": ogrencidetail_id, "ogrenciBolgeID[]": ogrenciBolgeID, "ogrenciBolgeAd[]": ogrenciBolgeAd, "ogrenciKurumID[]": ogrenciKurumID, "ogrenciKurumAd[]": ogrenciKurumAd,
                            "ogrenciVeliID[]": ogrenciVeliID, "ogrenciVeliAd[]": ogrenciVeliAd, "ogrenciDetayAd": ogrenciDetayAd,
                            "ogrenciDetaySoyad": ogrenciDetaySoyad, "ogrenciDetayDurum": ogrenciDetayDurum, "ogrenciDetayLokasyon": ogrenciDetayLokasyon, "ogrenciDetayTelefon": ogrenciDetayTelefon,
                            "ogrenciDetayEmail": ogrenciDetayEmail, "ogrenciDetayAdres": ogrenciDetayAdres, "ogrenciDetayAciklama": ogrenciDetayAciklama, "ogrenciDetayUlke": ogrenciDetayUlke,
                            "ogrenciDetayIl": ogrenciDetayIl, "ogrenciDetayIlce": ogrenciDetayIlce, "ogrenciDetaySemt": ogrenciDetaySemt, "ogrenciDetayMahalle": ogrenciDetayMahalle,
                            "ogrenciDetaySokak": ogrenciDetaySokak, "ogrenciDetayPostaKodu": ogrenciDetayPostaKodu, "ogrenciDetayCaddeNo": ogrenciDetayCaddeNo, "tip": "ogrenciDetailKaydet"},
                        success: function (cevap) {
                            if (cevap.hata) {
                                reset();
                                alertify.alert(jsDil.Hata);
                                return false;
                            } else {
                                disabledForm();
                                reset();
                                alertify.success(jsDil.OgrenciDuzenle);
                                var SelectBolgeOptions = new Array();
                                var SelectKurumOptions = new Array();
                                var SelectVeliOptions = new Array();
                                if (ogrenciBolgeID.length > 0) {
                                    var bolgelength = ogrenciBolgeID.length;
                                    for (var b = 0; b < bolgelength; b++) {
                                        SelectBolgeOptions[b] = {label: ogrenciBolgeAd[b], title: ogrenciBolgeAd[b], value: ogrenciBolgeID[b], selected: true};
                                    }

                                    if (ogrenciBolgeNID.length > 0) {
                                        var veliBolgeLength = ogrenciBolgeNID.length;
                                        for (var z = 0; z < veliBolgeLength; z++) {
                                            SelectBolgeOptions[b] = {label: ogrenciBolgeNAd[z], title: ogrenciBolgeNAd[z], value: ogrenciBolgeNID[z]};
                                            b++;
                                        }

                                    }
                                } else {
                                    if (ogrenciBolgeNID.length > 0) {
                                        var veliBolgeLength = ogrenciBolgeNID.length;
                                        for (var b = 0; b < veliBolgeLength; b++) {
                                            SelectBolgeOptions[b] = {label: ogrenciBolgeNAd[b], title: ogrenciBolgeNAd[b], value: ogrenciBolgeNID[b]};
                                        }

                                    }
                                }

                                if (ogrenciKurumID.length > 0) {
                                    var aracselectlength = ogrenciKurumID.length;
                                    for (var t = 0; t < aracselectlength; t++) {
                                        SelectKurumOptions[t] = {label: ogrenciKurumAd[t], title: ogrenciKurumAd[t], value: ogrenciKurumID[t], selected: true};
                                    }

                                    if (ogrenciKurumNID.length > 0) {
                                        var velilength = ogrenciKurumNID.length;
                                        for (var f = 0; f < velilength; f++) {
                                            SelectKurumOptions[t] = {label: ogrenciKurumNAd[f], title: ogrenciKurumNAd[f], value: ogrenciKurumNID[f]};
                                            t++;
                                        }
                                    }

                                } else {
                                    if (ogrenciKurumNID.length > 0) {
                                        var velilength = ogrenciKurumNID.length;
                                        for (var t = 0; t < velilength; t++) {
                                            SelectKurumOptions[t] = {label: ogrenciKurumNAd[t], title: ogrenciKurumNAd[t], value: ogrenciKurumNID[t]};
                                        }
                                    }
                                }

                                if (ogrenciVeliID.length > 0) {
                                    var ogrenciselectlength = ogrenciVeliID.length;
                                    for (var t = 0; t < ogrenciselectlength; t++) {
                                        SelectVeliOptions[t] = {label: ogrenciVeliAd[t], title: ogrenciVeliAd[t], value: ogrenciVeliID[t], selected: true};
                                    }

                                    if (ogrenciVeliNID.length > 0) {
                                        var velilength = ogrenciVeliNID.length;
                                        for (var f = 0; f < velilength; f++) {
                                            SelectVeliOptions[t] = {label: ogrenciVeliNAd[f], title: ogrenciVeliNAd[f], value: ogrenciVeliNID[f]};
                                            t++;
                                        }
                                    }

                                } else {
                                    if (ogrenciVeliNID.length > 0) {
                                        var velilength = ogrenciVeliNID.length;
                                        for (var t = 0; t < velilength; t++) {
                                            SelectVeliOptions[t] = {label: ogrenciVeliNAd[t], title: ogrenciVeliNAd[t], value: ogrenciVeliNID[t]};
                                        }
                                    }
                                }

                                $('#OgrenciDetaySelectBolge').multiselect('refresh');
                                $('#OgrenciDetayKurum').multiselect('refresh');
                                $('#OgrenciDetayVeliSelect').multiselect('refresh');
                                $('#OgrenciDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
                                $('#OgrenciDetayKurum').multiselect('dataprovider', SelectKurumOptions);
                                $('#OgrenciDetayVeliSelect').multiselect('dataprovider', SelectVeliOptions);
                                var length = $('tbody#ogrenciRow tr').length;
                                for (var t = 0; t < length; t++) {
                                    var attrValueId = $("tbody#ogrenciRow > tr > td > a").eq(t).attr('value');
                                    if (attrValueId == ogrencidetail_id) {
                                        if (ogrenciDetayDurum != 0) {
                                            $("tbody#ogrenciRow > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-user"></i> ' + ogrenciDetayAd);
                                            $("tbody#ogrenciRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(ogrenciDetaySoyad);
                                            $("tbody#ogrenciRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(ogrenciDetayTelefon);
                                            $("tbody#ogrenciRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(ogrenciDetayEmail);
                                            $("tbody#ogrenciRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(ogrenciDetayAciklama);
                                            $('tbody#ogrenciRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                        } else {
                                            $("tbody#ogrenciRow > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-user" style="color:red"></i> ' + ogrenciDetayAd);
                                            $("tbody#ogrenciRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(ogrenciDetaySoyad);
                                            $("tbody#ogrenciRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(ogrenciDetayTelefon);
                                            $("tbody#ogrenciRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(ogrenciDetayEmail);
                                            $("tbody#ogrenciRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(ogrenciDetayAciklama);
                                            $('tbody#ogrenciRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
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
    },
}


