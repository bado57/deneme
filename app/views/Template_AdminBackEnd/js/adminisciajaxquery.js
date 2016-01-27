$.ajaxSetup({
    type: "post",
    url: SITE_URL + "AdminIsciAjaxSorgu",
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
var gidisBildAyar = new Array();
var donusBildAyar = new Array();
$(document).ready(function () {
    IsciTable = $('#isciTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    IsciTurTable = $('#adminIsciTurTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    //İşçi İşlemleri
    $(document).on('click', 'tbody#isciRow > tr > td > a', function (e) {
        var i = $(this).find("i");
        i.removeClass("glyphicon glyphicon-user");
        i.addClass("fa fa-spinner");
        var isciRowid = $(this).attr('value');
        $.ajax({
            data: {"isciRowid": isciRowid, "tip": "isciDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    $("input[name=IsciDetayAdi]").val(cevap.isciDetail[0].IsciListAd);
                    $("input[name=IsciDetaySoyadi]").val(cevap.isciDetail[0].IsciListSoyad);
                    $("#IsciDetayDurum").val(cevap.isciDetail[0].IsciListDurum);
                    $("input[name=KurumLokasyon]").val(cevap.isciDetail[0].IsciListLokasyon);
                    $("input[name=IsciDetayTelefon]").val(cevap.isciDetail[0].IsciListTelefon);
                    $("input[name=IsciDetayEmail]").val(cevap.isciDetail[0].IsciListMail);
                    $("textarea[name=IsciDetayAdresDetay]").val(cevap.isciDetail[0].IsciListAdres);
                    $("textarea[name=DetayAciklama]").val(cevap.isciDetail[0].IsciListAciklama);
                    $("input[name=country]").val(cevap.isciDetail[0].IsciListUlke);
                    $("input[name=administrative_area_level_1]").val(cevap.isciDetail[0].IsciListIl);
                    $("input[name=administrative_area_level_2]").val(cevap.isciDetail[0].IsciListIlce);
                    $("input[name=locality]").val(cevap.isciDetail[0].IsciListSemt);
                    $("input[name=neighborhood]").val(cevap.isciDetail[0].IsciListMahalle);
                    $("input[name=route]").val(cevap.isciDetail[0].IsciListSokak);
                    $("input[name=postal_code]").val(cevap.isciDetail[0].IsciListPostaKodu);
                    $("input[name=street_number]").val(cevap.isciDetail[0].IsciListCaddeNo);
                    $("input[name=isciDetayID]").val(cevap.isciDetail[0].IsciListID);
                    $("input[name=isciDetayAdres]").val(cevap.isciDetail[0].IsciListDetayAdres);
                    $("#detayDovizTip").val(cevap.isciDetail[0].IsciParaTip);
                    $("input[name=detayOdemeTutar]").val(cevap.isciDetail[0].IsciOTutar);

                    var SelectBilGidis = new Array();
                    gidisBildAyar = cevap.isciDetail[0].IsciGBild;
                    SelectBilGidis[0] = {label: cevap.isciDetail[0].IsciGBild + " m", title: cevap.isciDetail[0].IsciGBild + " m", value: cevap.isciDetail[0].IsciGBild, disabled: true};
                    $('#IscDetGdsMAyarSelect').multiselect('dataprovider', SelectBilGidis);
                    $('#IscDetGdsMAyarSelect').multiselect('disable');
                    $('#IscDetGdsMAyarSelect').multiselect('refresh');
                    var SelectBilDonus = new Array();
                    donusBildAyar = cevap.isciDetail[0].IsciDBild;
                    SelectBilDonus[0] = {label: cevap.isciDetail[0].IsciDBild + " m", title: cevap.isciDetail[0].IsciDBild + " m", value: cevap.isciDetail[0].IsciDBild, disabled: true};
                    $('#IscDetDnsMAyarSelect').multiselect('dataprovider', SelectBilDonus);
                    $('#IscDetDnsMAyarSelect').multiselect('disable');
                    $('#IscDetDnsMAyarSelect').multiselect('refresh');

                    var SelectBolgeOptions = new Array();
                    var SelectKurumOptions = new Array();
                    if (cevap.isciSelectBolge) {
                        var bolgelength = cevap.isciSelectBolge.length;
                        for (var b = 0; b < bolgelength; b++) {
                            SelectBolgeOptions[b] = {label: cevap.isciSelectBolge[b].SelectIsciBolgeAdi, title: cevap.isciSelectBolge[b].SelectIsciBolgeAdi, value: cevap.isciSelectBolge[b].SelectIsciBolgeID, selected: true, disabled: true};
                        }

                        if (cevap.isciBolge) {
                            var bolgelength = cevap.isciBolge.length;
                            for (var z = 0; z < bolgelength; z++) {
                                SelectBolgeOptions[b] = {label: cevap.isciBolge[z].DigerIsciBolgeAdi, title: cevap.isciBolge[z].DigerIsciBolgeAdi, value: cevap.isciBolge[z].DigerIsciBolgeID, disabled: true};
                                b++;
                            }

                        }
                    } else {
                        if (cevap.isciBolge) {
                            var bolgelength = cevap.isciBolge.length;
                            for (var b = 0; b < bolgelength; b++) {
                                SelectBolgeOptions[b] = {label: cevap.isciBolge[b].DigerIsciBolgeAdi, title: cevap.isciBolge[b].DigerIsciBolgeAdi, value: cevap.isciBolge[b].DigerIsciBolgeID, disabled: true};
                            }
                        }
                    }


                    if (cevap.isciSelectKurum) {
                        var kurumselectlength = cevap.isciSelectKurum.length;
                        for (var t = 0; t < kurumselectlength; t++) {
                            SelectKurumOptions[t] = {label: cevap.isciSelectKurum[t].SelectIsciKurumAd, title: cevap.isciSelectKurum[t].SelectIsciKurumAd, value: cevap.isciSelectKurum[t].SelectIsciKurumID, selected: true, disabled: true};
                        }
                        if (cevap.isciKurum) {
                            var kurumlength = cevap.isciKurum.length;
                            for (var f = 0; f < kurumlength; f++) {
                                SelectKurumOptions[t] = {label: cevap.isciKurum[f].DigerIsciKurumAd, title: cevap.isciKurum[f].DigerIsciKurumAd, value: cevap.isciKurum[f].DigerIsciKurumID, disabled: true};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.isciKurum) {
                            var kurumlength = cevap.isciKurum.length;
                            for (var t = 0; t < kurumlength; t++) {
                                SelectKurumOptions[t] = {label: cevap.isciKurum[t].DigerIsciKurumAd, title: cevap.isciKurum[t].DigerIsciKurumAd, value: cevap.isciKurum[t].DigerIsciKurumID, disabled: true};
                            }
                        }
                    }

                    $('#IsciDetaySelectBolge').multiselect('refresh');
                    $('#IsciDetayKurum').multiselect('refresh');
                    $('#IsciDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
                    $('#IsciDetayKurum').multiselect('dataprovider', SelectKurumOptions);
                    svControl('svAdd', 'IsciDetay', '');
                    i.removeClass("fa fa-spinner");
                    i.addClass("glyphicon glyphicon-user");
                }
            }
        });
    });
//kullanıcı işlemleri bölge select
    $('#IsciSelectBolge').on('change', function () {
        var isciBolgeID = new Array();
        $('select#IsciSelectBolge option:selected').each(function () {
            isciBolgeID.push($(this).val());
        });
        var KurumOptions = new Array();
        $.ajax({
            data: {"isciBolgeID[]": isciBolgeID, "tip": "isciKurumMultiSelect"},
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
                        $('#IsciKurumSelect').multiselect('refresh');
                        $('#IsciKurumSelect').multiselect('dataprovider', KurumOptions);
                    } else {
                        $('#IsciKurumSelect').multiselect('refresh');
                        $('#IsciKurumSelect').multiselect('dataprovider', KurumOptions);
                    }
                }
            }
        });
    });
    $('#IsciDetaySelectBolge').on('change', function () {

        var isciID = $("input[name=isciDetayID]").val();
        var isciDetailBolgeID = new Array();
        $('select#IsciDetaySelectBolge option:selected').each(function () {
            isciDetailBolgeID.push($(this).val());
        });
        $('#AracDetaySurucu').multiselect('refresh');
        var KurumOptions = new Array();
        $.ajax({
            data: {"isciID": isciID, "isciDetailBolgeID[]": isciDetailBolgeID, "tip": "IsciDetailMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.adminIsciSelectKurum) {
                        var isciselectlength = cevap.adminIsciSelectKurum.length;
                        for (var t = 0; t < isciselectlength; t++) {
                            KurumOptions[t] = {label: cevap.adminIsciSelectKurum[t].SelectIsciKurumAd, title: cevap.adminIsciSelectKurum[t].SelectIsciKurumAd, value: cevap.adminIsciSelectKurum[t].SelectIsciKurumID, selected: true};
                        }
                        if (cevap.adminIsciKurum) {
                            var iscilength = cevap.adminIsciKurum.length;
                            for (var f = 0; f < iscilength; f++) {
                                KurumOptions[t] = {label: cevap.adminIsciKurum[f].DigerIsciKurumAd, title: cevap.adminIsciKurum[f].DigerIsciKurumAd, value: cevap.adminIsciKurum[f].DigerIsciKurumID};
                                t++;
                            }
                        }
                    } else {
                        if (cevap.adminIsciKurum) {
                            var iscilength = cevap.adminIsciKurum.length;
                            for (var t = 0; t < iscilength; t++) {
                                KurumOptions[t] = {label: cevap.adminIsciKurum[t].DigerIsciKurumAd, title: cevap.adminIsciKurum[t].DigerIsciKurumAd, value: cevap.adminIsciKurum[t].DigerIsciKurumID};
                            }
                        }
                    }
                    $('#IsciDetayKurum').multiselect('refresh');
                    $('#IsciDetayKurum').multiselect('dataprovider', KurumOptions);
                }
            }
        });
    });
//multi select açılma eventları
//işçi
    $('#IsciSelectBolge').multiselect({
        onDropdownShow: function (event) {
            $('#IsciKurumSelect').show();
        },
        onDropdownHide: function (event) {
            $('#IsciKurumSelect').hide();
        }
    });
    //işçi detail
    $('#IsciDetaySelectBolge').multiselect({
        onDropdownShow: function (event) {
            $('#IsciDetayKurum').show();
        },
        onDropdownHide: function (event) {
            $('#IsciDetayKurum').hide();
        }
    });
    $('#IscDetGdsMAyarSelect').multiselect({
        onDropdownShow: function (event) {
            var SelectGidisOptions = new Array();
            var SelectGidisValue = new Array(200, 400, 600, 800, 1000, 1200, 1400, 1600, 1800, 2000,
                    2200, 2400, 2600, 2800, 3000);
            var SelectGidisText = new Array('200 m', '400 m', '600 m', '800 m', '1000 m', '1200 m', '1400 m',
                    '1600 m', '1800 m', '2000 m', '2200 m', '2400 m', '2600 m', '2800 m', '3000 m');
            var saat2Length = SelectGidisValue.length;
            for (var b = 0; b < saat2Length; b++) {
                if (SelectGidisValue[b] == gidisBildAyar) {
                    SelectGidisOptions[b] = {label: SelectGidisText[b], title: SelectGidisText[b], value: SelectGidisValue[b], selected: true};
                } else {
                    SelectGidisOptions[b] = {label: SelectGidisText[b], title: SelectGidisText[b], value: SelectGidisValue[b]};
                }
            }
            $('#IscDetGdsMAyarSelect').multiselect('refresh');
            $('#IscDetGdsMAyarSelect').multiselect('dataprovider', SelectGidisOptions);
        },
        onChange: function (option, checked, select) {
            gidisBildAyar = $('select#IscDetGdsMAyarSelect option:selected').val();
        }
    });
    $('#IscDetDnsMAyarSelect').multiselect({
        onDropdownShow: function (event) {
            var SelectDonusOptions = new Array();
            var SelectDonusValue = new Array(200, 400, 600, 800, 1000, 1200, 1400, 1600, 1800, 2000,
                    2200, 2400, 2600, 2800, 3000);
            var SelectDonusText = new Array('200 m', '400 m', '600 m', '800 m', '1000 m', '1200 m', '1400 m',
                    '1600 m', '1800 m', '2000 m', '2200 m', '2400 m', '2600 m', '2800 m', '3000 m');
            var saat2Length = SelectDonusValue.length;
            for (var b = 0; b < saat2Length; b++) {
                if (SelectDonusValue[b] == donusBildAyar) {
                    SelectDonusOptions[b] = {label: SelectDonusText[b], title: SelectDonusText[b], value: SelectDonusValue[b], selected: true};
                } else {
                    SelectDonusOptions[b] = {label: SelectDonusText[b], title: SelectDonusText[b], value: SelectDonusValue[b]};
                }
            }
            $('#IscDetDnsMAyarSelect').multiselect('refresh');
            $('#IscDetDnsMAyarSelect').multiselect('dataprovider', SelectDonusOptions);
        },
        onChange: function (option, checked, select) {
            donusBildAyar = $('select#IscDetDnsMAyarSelect option:selected').val();
        }
    });
});
var IsciDetailVazgec = [];
$.AdminIslemler = {
    isciVazgec: function () {
        return true;
    },
    isciYeni: function () {
        $("input[name=IsciAdi]").val('');
        $("input[name=IsciSoyadi]").val('');
        $("#IsciDurum").val("1");
        $("input[name=KurumLokasyon]").val('');
        $("input[name=IsciTelefon]").val('');
        $("input[name=IsciEmail]").val('');
        $("textarea[name=IsciAdresDetay]").val('');
        $("textarea[name=Aciklama]").val('');
        $("input[name=odemeTutar]").val('');
        $("input[name=country]").val('');
        $("input[name=administrative_area_level_1]").val('');
        $("input[name=administrative_area_level_2]").val('');
        $("input[name=locality]").val('');
        $("input[name=neighborhood]").val('');
        $("input[name=route]").val('');
        $("input[name=postal_code]").val('');
        $("input[name=street_number]").val('');
        var BolgeOptions = new Array();
        var IsciKurumOptions = new Array();
        $.ajax({
            data: {"tip": "isciEkleSelect"},
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
                        $('#IsciSelectBolge').multiselect('refresh');
                        $('#IsciSelectBolge').multiselect('dataprovider', BolgeOptions);
                        $('#IscGdsMAyarSelect').multiselect('refresh');
                        $('#IscDnsMAyarSelect').multiselect('refresh');
                    } else {
                        $('#IsciSelectBolge').multiselect('refresh');
                        $('#IsciSelectBolge').multiselect('dataprovider', BolgeOptions);
                        $('#IscGdsMAyarSelect').multiselect('refresh');
                        $('#IscDnsMAyarSelect').multiselect('refresh');
                    }

                    $('#IsciKurumSelect').multiselect('refresh');
                    $('#IsciKurumSelect').multiselect('dataprovider', IsciKurumOptions);
                    var selectLength = $('#IsciSelectBolge > option').length;
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
    isciEkle: function () {
        var isciAd = $("input[name=IsciAdi]").val();
        isciAd = isciAd.trim();
        if (isciAd == '') {
            reset();
            alertify.alert(jsDil.IsimBos);
            return false;
        } else {
            if (isciAd.length < 2) {
                reset();
                alertify.alert(jsDil.IsimKarekter);
                return false;
            } else {
                var isciSoyad = $("input[name=IsciSoyadi]").val();
                isciSoyad = isciSoyad.trim();
                if (isciSoyad == '') {
                    reset();
                    alertify.alert(jsDil.SoyadBos);
                    return false;
                } else {
                    if (isciSoyad.length < 2) {
                        reset();
                        alertify.alert(jsDil.SoyadKarekter);
                        return false;
                    } else {
                        var isciEmail = $("input[name=IsciEmail]").val();
                        if (isciEmail == ' ') {
                            reset();
                            alertify.alert(jsDil.EpostaBos);
                            return false;
                        } else {
                            isciEmail = isciEmail.trim();
                            var result = ValidateEmail(isciEmail);
                            if (!result) {
                                reset();
                                alertify.alert(jsDil.EpostaUygun);
                                return false;
                            } else {
                                var selectLength = $('#IsciSelectBolge > option').length;
                                if (selectLength) {
                                    var select = $('select#IsciSelectBolge option:selected').val();
                                    if (select) {
                                        var selectKurumLength = $('#IsciKurumSelect > option').length;
                                        if (selectKurumLength) {
                                            var selectKurum = $('select#IsciKurumSelect option:selected').val();
                                            if (selectKurum) {
                                                var isciDurum = $("#IsciDurum option:selected").val();
                                                var isciLokasyon = $("input[name=KurumLokasyon]").val();
                                                var isciTelefon = $("input[name=IsciTelefon]").val();
                                                var isciAdres = $("textarea[name=IsciAdresDetay]").val();
                                                var aciklama = $("textarea[name=Aciklama]").val();
                                                var ulke = $("input[name=country]").val();
                                                var il = $("input[name=administrative_area_level_1]").val();
                                                var ilce = $("input[name=administrative_area_level_2]").val();
                                                var semt = $("input[name=locality]").val();
                                                var mahalle = $("input[name=neighborhood]").val();
                                                var sokak = $("input[name=route]").val();
                                                var postakodu = $("input[name=postal_code]").val();
                                                var caddeno = $("input[name=street_number]").val();
                                                var gdsbildirim = $('select#IscGdsMAyarSelect option:selected').val();
                                                var dnsbildirim = $('select#IscDnsMAyarSelect option:selected').val();
                                                //işçi Bölge ID
                                                var isciBolgeID = new Array();
                                                $('select#IsciSelectBolge option:selected').each(function () {
                                                    isciBolgeID.push($(this).val());
                                                });
                                                //işçi Bölge Adi
                                                var isciBolgeAdi = new Array();
                                                $('select#IsciSelectBolge option:selected').each(function () {
                                                    isciBolgeAdi.push($(this).attr('title'));
                                                });
                                                //işçi Kurum ID
                                                var isciKurumID = new Array();
                                                $('select#IsciKurumSelect option:selected').each(function () {
                                                    isciKurumID.push($(this).val());
                                                });
                                                //işçi Kurum ID
                                                var isciKurumAd = new Array();
                                                $('select#IsciKurumSelect option:selected').each(function () {
                                                    isciKurumAd.push($(this).attr('title'));
                                                });
                                                var odemeTutar = $("#odemeTutar").val();
                                                var odemeTip = $("#dovizTip option:selected").val();
                                                var splitodeme = odemeTutar.split(".");
                                                var odemelength = splitodeme[0].length;
                                                if (odemeTutar != "") {
                                                    if (odemelength <= 13) {
                                                        $.ajax({
                                                            data: {"isciBolgeID[]": isciBolgeID, "isciBolgeAdi[]": isciBolgeAdi, "isciKurumID[]": isciKurumID, "isciKurumAd[]": isciKurumAd, "isciAd": isciAd,
                                                                "isciSoyad": isciSoyad, "isciDurum": isciDurum, "isciLokasyon": isciLokasyon, "isciTelefon": isciTelefon,
                                                                "isciEmail": isciEmail, "isciAdres": isciAdres, "aciklama": aciklama, "ulke": ulke,
                                                                "il": il, "ilce": ilce, "semt": semt, "mahalle": mahalle,
                                                                "sokak": sokak, "postakodu": postakodu, "caddeno": caddeno,
                                                                "gdsbildirim": gdsbildirim, "dnsbildirim": dnsbildirim,
                                                                "odemeTutar": odemeTutar, "odemeTip": odemeTip, "detayAdres": ttl, "tip": "isciKaydet"},
                                                            success: function (cevap) {
                                                                if (cevap.hata) {
                                                                    reset();
                                                                    alertify.alert(cevap.hata);
                                                                    return false;
                                                                } else {
                                                                    reset();
                                                                    alertify.success(cevap.insert);
                                                                    var isciCount = $('#smallIsci').text();
                                                                    isciCount++;
                                                                    $('#smallIsci').text(isciCount);
                                                                    if (isciDurum != 0) {
                                                                        var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                                + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newIsciID + "'>"
                                                                                + "<i class='glyphicon glyphicon-user' style='color:green;'></i> " + isciAd + "</a></td>"
                                                                                + "<td class='hidden-xs'>" + isciSoyad + "</td>"
                                                                                + "<td class='hidden-xs'>" + isciTelefon + "</td>"
                                                                                + "<td class='hidden-xs'>" + isciEmail + "</td>"
                                                                                + "<td class='hidden-xs'>" + aciklama + "</td></tr>";
                                                                        IsciTable.DataTable().row.add($(addRow)).draw();
                                                                    } else {
                                                                        var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                                                                + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newIsciID + "'>"
                                                                                + "<i class='glyphicon glyphicon-user' style='color:red;'></i> " + isciAd + "</a></td>"
                                                                                + "<td class='hidden-xs'>" + isciSoyad + "</td>"
                                                                                + "<td class='hidden-xs'>" + isciTelefon + "</td>"
                                                                                + "<td class='hidden-xs'>" + isciEmail + "</td>"
                                                                                + "<td class='hidden-xs'>" + aciklama + "</td></tr>";
                                                                        IsciTable.DataTable().row.add($(addRow)).draw();
                                                                    }
                                                                    isciBolgeID = [];
                                                                    isciKurumID = [];
                                                                }
                                                            }
                                                        });
                                                        return true;
                                                    } else {
                                                        reset();
                                                        alertify.alert(jsDil.OdemeTutarB);
                                                        return false;
                                                    }
                                                } else {
                                                    reset();
                                                    alertify.alert(jsDil.OdemeTutar);
                                                    return false;
                                                }
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
    isciDetailDuzenle: function () {
        //İşçi İşlemleri Değerleri
        var isciDetayAd = $("input[name=IsciDetayAdi]").val();
        var isciDetaySoyad = $("input[name=IsciDetaySoyadi]").val();
        var isciDetayDurum = $("#IsciDetayDurum").val();
        var isciDetayLokasyon = $("input[name=KurumLokasyon]").val();
        var isciDetayTelefon = $("input[name=IsciDetayTelefon]").val();
        var isciDetayEmail = $("input[name=IsciDetayEmail]").val();
        var isciDetayAdres = $("textarea[name=IsciDetayAdresDetay]").val();
        var isciDetayAciklama = $("textarea[name=DetayAciklama]").val();
        var isciDetayUlke = $("input[name=country]").val();
        var isciDetayIl = $("input[name=administrative_area_level_1]").val();
        var isciDetayIlce = $("input[name=administrative_area_level_2]").val();
        var isciDetaySemt = $("input[name=locality]").val();
        var isciDetayMahalle = $("input[name=neighborhood]").val();
        var isciDetaySokak = $("input[name=route]").val();
        var isciDetayPostaKodu = $("input[name=postal_code]").val();
        var isciDetayCaddeNo = $("input[name=street_number]").val();
        var dovizTip = $("#detayDovizTip").val();
        var odemeTutar = $("input[name=detayOdemeTutar]").val();
        //işçi Bölge ID
        var isciBolgeID = new Array();
        $('select#IsciDetaySelectBolge option:selected').each(function () {
            isciBolgeID.push($(this).val());
        });
        //İşçi Bölge Ad
        var isciBolgeAd = new Array();
        $('select#IsciDetaySelectBolge option:selected').each(function () {
            isciBolgeAd.push($(this).attr('title'));
        });
        //İşçi Şoför Id
        var isciKurumID = new Array();
        $('select#IsciDetayKurum option:selected').each(function () {
            isciKurumID.push($(this).val());
        });
        //İşçi Şoför Ad
        var isciKurumAd = new Array();
        $('select#IsciDetayKurum option:selected').each(function () {
            isciKurumAd.push($(this).attr('title'));
        });
        //İşçi Seçili Olmayan Bölge ID
        var isciBolgeNID = new Array();
        $('select#IsciDetaySelectBolge option:not(:selected)').each(function () {
            isciBolgeNID.push($(this).val());
        });
        //işçi Seçili Olmayan Bölge Ad
        var isciBolgeNAd = new Array();
        $('select#IsciDetaySelectBolge option:not(:selected)').each(function () {
            isciBolgeNAd.push($(this).attr('title'));
        });
        //işçi Seçili Olmayan Şoför Id
        var isciKurumNID = new Array();
        $('select#IsciDetayKurum option:not(:selected)').each(function () {
            isciKurumNID.push($(this).val());
        });
        //işçi Seçili Olmayan Şoför Ad
        var isciKurumNAd = new Array();
        $('select#IsciDetayKurum option:not(:selected)').each(function () {
            isciKurumNAd.push($(this).attr('title'));
        });

        $('#IscDetGdsMAyarSelect').multiselect('enable');
        $('#IscDetGdsMAyarSelect').multiselect('refresh');
        $('#IscDetDnsMAyarSelect').multiselect('enable');
        $('#IscDetDnsMAyarSelect').multiselect('refresh');
        var gdsbildirim = $('select#IscDetGdsMAyarSelect option:selected').val();
        var gdsbildirimtext = $('select#IscDetGdsMAyarSelect option:selected').attr('title');
        var dnsbildirim = $('select#IscDetDnsMAyarSelect option:selected').val();
        var dnsbildirimtext = $('select#IscDetDnsMAyarSelect option:selected').attr('title');

        var SelectBolgeOptions = new Array();
        var SelectIsciOptions = new Array();
        if (isciBolgeID.length > 0) {
            var bolgelength = isciBolgeID.length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: isciBolgeAd[b], title: isciBolgeAd[b], value: isciBolgeID[b], selected: true};
            }

            if (isciBolgeNID.length > 0) {
                var isciBolgeLength = isciBolgeNID.length;
                for (var z = 0; z < isciBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: isciBolgeNAd[z], title: isciBolgeNAd[z], value: isciBolgeNID[z]};
                    b++;
                }

            }
        } else {
            if (isciBolgeNID.length > 0) {
                var isciBolgeLength = isciBolgeNID.length;
                for (var b = 0; b < isciBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: isciBolgeNAd[b], title: isciBolgeNAd[b], value: isciBolgeNID[b]};
                }

            }
        }

        if (isciKurumID.length > 0) {
            var aracselectlength = isciKurumID.length;
            for (var t = 0; t < aracselectlength; t++) {
                SelectIsciOptions[t] = {label: isciKurumAd[t], title: isciKurumAd[t], value: isciKurumID[t], selected: true};
            }

            if (isciKurumNID.length > 0) {
                var iscilength = isciKurumNID.length;
                for (var f = 0; f < iscilength; f++) {
                    SelectIsciOptions[t] = {label: isciKurumNAd[f], title: isciKurumNAd[f], value: isciKurumNID[f]};
                    t++;
                }
            }

        } else {
            if (isciKurumNID.length > 0) {
                var iscilength = isciKurumNID.length;
                for (var t = 0; t < iscilength; t++) {
                    SelectIsciOptions[t] = {label: isciKurumNAd[t], title: isciKurumNAd[t], value: isciKurumNID[t]};
                }
            }
        }

        $('#IsciDetaySelectBolge').multiselect('refresh');
        $('#IsciDetayKurum').multiselect('refresh');
        $('#IsciDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
        $('#IsciDetayKurum').multiselect('dataprovider', SelectIsciOptions);
        IsciDetailVazgec = [];
        IsciDetailVazgec.push(isciDetayAd, isciDetaySoyad, isciDetayDurum, isciDetayLokasyon, isciDetayTelefon,
                isciDetayEmail, isciDetayAdres, isciDetayAciklama, isciDetayUlke, isciDetayIl, isciDetayIlce,
                isciDetaySemt, isciDetayMahalle, isciDetaySokak, isciDetayPostaKodu, isciDetayCaddeNo,
                isciBolgeID, isciBolgeAd, isciBolgeNID, isciBolgeNAd, isciKurumID, isciKurumAd, isciKurumNID,
                isciKurumNAd, gdsbildirim, gdsbildirimtext, dnsbildirim, dnsbildirimtext, dovizTip, odemeTutar);
    },
    isciDetailVazgec: function () {
        $("input[name=IsciDetayAdi]").val(IsciDetailVazgec[0]);
        $("input[name=IsciDetaySoyadi]").val(IsciDetailVazgec[1]);
        $("#IsciDetayDurum").val(IsciDetailVazgec[2]);
        $("input[name=KurumLokasyon]").val(IsciDetailVazgec[3]);
        $("input[name=IsciDetayTelefon]").val(IsciDetailVazgec[4]);
        $("input[name=IsciDetayEmail]").val(IsciDetailVazgec[5]);
        $("textarea[name=IsciDetayAdresDetay]").val(IsciDetailVazgec[6]);
        $("textarea[name=DetayAciklama]").val(IsciDetailVazgec[7]);
        $("input[name=country]").val(IsciDetailVazgec[8]);
        $("input[name=administrative_area_level_1]").val(IsciDetailVazgec[9]);
        $("input[name=administrative_area_level_2]").val(IsciDetailVazgec[10]);
        $("input[name=locality]").val(IsciDetailVazgec[11]);
        $("input[name=neighborhood]").val(IsciDetailVazgec[12]);
        $("input[name=route]").val(IsciDetailVazgec[13]);
        $("input[name=postal_code]").val(IsciDetailVazgec[14]);
        $("input[name=street_number]").val(IsciDetailVazgec[15]);
        var SelectBolgeOptions = new Array();
        var SelectIsciOptions = new Array();
        if (IsciDetailVazgec[16].length > 0) {
            var bolgelength = IsciDetailVazgec[16].length;
            for (var b = 0; b < bolgelength; b++) {
                SelectBolgeOptions[b] = {label: IsciDetailVazgec[17][b], title: IsciDetailVazgec[17][b], value: IsciDetailVazgec[16][b], selected: true, disabled: true};
            }
            if (IsciDetailVazgec[18].length > 0) {
                var isciBolgeLength = IsciDetailVazgec[18].length;
                for (var z = 0; z < isciBolgeLength; z++) {
                    SelectBolgeOptions[b] = {label: IsciDetailVazgec[19][z], title: IsciDetailVazgec[19][z], value: IsciDetailVazgec[18][z], disabled: true};
                    b++;
                }
            }
        } else {
            if (IsciDetailVazgec[18].length > 0) {
                var isciBolgeLength = IsciDetailVazgec[18].length;
                for (var b = 0; b < isciBolgeLength; b++) {
                    SelectBolgeOptions[b] = {label: IsciDetailVazgec[19][b], title: IsciDetailVazgec[19][b], value: IsciDetailVazgec[18][b], disabled: true};
                }
            }
        }


        if (IsciDetailVazgec[20].length > 0) {
            var isciselectlength = IsciDetailVazgec[20].length;
            for (var t = 0; t < isciselectlength; t++) {
                SelectIsciOptions[t] = {label: IsciDetailVazgec[21][t], title: IsciDetailVazgec[21][t], value: IsciDetailVazgec[20][t], selected: true, disabled: true};
            }
            if (IsciDetailVazgec[22].length > 0) {
                var iscilength = IsciDetailVazgec[22].length;
                for (var f = 0; f < iscilength; f++) {
                    SelectIsciOptions[t] = {label: IsciDetailVazgec[23][f], title: IsciDetailVazgec[23][f], value: IsciDetailVazgec[22][f], disabled: true};
                    t++;
                }
            }
        } else {
            if (IsciDetailVazgec[22].length > 0) {
                var iscilength = IsciDetailVazgec[22].length;
                for (var t = 0; t < iscilength; t++) {
                    SelectIsciOptions[t] = {label: IsciDetailVazgec[23][t], title: IsciDetailVazgec[23][t], value: IsciDetailVazgec[22][t], disabled: true};
                }
            }
        }

        var SelectBilGidis = new Array();
        SelectBilGidis[0] = {label: IsciDetailVazgec[25], title: IsciDetailVazgec[25], value: IsciDetailVazgec[24], disabled: true};
        $('#IscDetGdsMAyarSelect').multiselect('dataprovider', SelectBilGidis);
        $('#IscDetGdsMAyarSelect').multiselect('disable');
        $('#IscDetGdsMAyarSelect').multiselect('refresh');
        var SelectBilDonus = new Array();
        SelectBilDonus[0] = {label: IsciDetailVazgec[27], title: IsciDetailVazgec[27], value: IsciDetailVazgec[26], disabled: true};
        $('#IscDetDnsMAyarSelect').multiselect('dataprovider', SelectBilDonus);
        $('#IscDetDnsMAyarSelect').multiselect('disable');
        $('#IscDetDnsMAyarSelect').multiselect('refresh');

        $("#detayDovizTip").val(IsciDetailVazgec[28]);
        $("input[name=detayOdemeTutar]").val(IsciDetailVazgec[29]);

        $('#IsciDetaySelectBolge').multiselect('refresh');
        $('#IsciDetayKurum').multiselect('refresh');
        $('#IsciDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
        $('#IsciDetayKurum').multiselect('dataprovider', SelectIsciOptions);
    },
    isciDetailSil: function () {
        reset();
        alertify.confirm(jsDil.SilOnay, function (e) {
            if (e) {
                var iscidetail_id = $("input[name=isciDetayID]").val();
                $.ajax({
                    data: {"iscidetail_id": iscidetail_id, "tip": "isciDetailDelete"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(jsDil.Hata);
                            return false;
                        } else {
                            disabledForm();
                            $("input[name=IsciDetayAdi]").val('');
                            $("input[name=IsciDetaySoyadi]").val('');
                            $("#IsciDetayDurum").val('');
                            $("input[name=KurumLokasyon]").val('');
                            $("input[name=IsciDetayTelefon]").val('');
                            $("input[name=IsciDetayEmail]").val('');
                            $("textarea[name=IsciDetayAdresDetay]").val('');
                            $("textarea[name=DetayAciklama]").val('');
                            $("input[name=country]").val('');
                            $("input[name=administrative_area_level_1]").val('');
                            $("input[name=administrative_area_level_2]").val('');
                            $("input[name=locality]").val('');
                            $("input[name=neighborhood]").val('');
                            $("input[name=route]").val('');
                            $("input[name=postal_code]").val('');
                            $("input[name=street_number]").val('');
                            var isciCount = $('#smallIsci').text();
                            isciCount--;
                            $('#smallIsci').text(isciCount);
                            var length = $('tbody#isciRow tr').length;
                            for (var t = 0; t < length; t++) {
                                var attrValueId = $("tbody#isciRow > tr > td > a").eq(t).attr('value');
                                if (attrValueId == iscidetail_id) {
                                    var deleteRow = $('tbody#isciRow > tr:eq(' + t + ')');
                                    IsciTable.DataTable().row($(deleteRow)).remove().draw();
                                }
                            }
                            reset();
                            alertify.success(jsDil.SilEvet);
                            svControl('svClose', 'IsciDetay', '');
                        }
                    }
                });
            } else {
                alertify.error(jsDil.SilRed);
            }
        });
    },
    isciDetailKaydet: function () {
        if (ttl == '') {
            ttl = $("input[name=isciDetayAdres]").val();
        }
        var iscidetail_id = $("input[name=isciDetayID]").val();
        //İşçi İşlemleri Değerleri
        var isciDetayAd = $("input[name=IsciDetayAdi]").val();
        var isciDetaySoyad = $("input[name=IsciDetaySoyadi]").val();
        var isciDetayDurum = $("#IsciDetayDurum").val();
        var isciDetayLokasyon = $("input[name=KurumLokasyon]").val();
        var isciDetayTelefon = $("input[name=IsciDetayTelefon]").val();
        var isciDetayEmail = $("input[name=IsciDetayEmail]").val();
        var isciDetayAdres = $("textarea[name=IsciDetayAdresDetay]").val();
        var isciDetayAciklama = $("textarea[name=DetayAciklama]").val();
        var isciDetayUlke = $("input[name=country]").val();
        var isciDetayIl = $("input[name=administrative_area_level_1]").val();
        var isciDetayIlce = $("input[name=administrative_area_level_2]").val();
        var isciDetaySemt = $("input[name=locality]").val();
        var isciDetayMahalle = $("input[name=neighborhood]").val();
        var isciDetaySokak = $("input[name=route]").val();
        var isciDetayPostaKodu = $("input[name=postal_code]").val();
        var isciDetayCaddeNo = $("input[name=street_number]").val();
        var gdsbildirim = $('select#IscDetGdsMAyarSelect option:selected').val();
        var dnsbildirim = $('select#IscDetDnsMAyarSelect option:selected').val();
        //işçi Bölge ID
        var isciBolgeID = new Array();
        $('select#IsciDetaySelectBolge option:selected').each(function () {
            isciBolgeID.push($(this).val());
        });
        //İşçi Bölge Ad
        var isciBolgeAd = new Array();
        $('select#IsciDetaySelectBolge option:selected').each(function () {
            isciBolgeAd.push($(this).attr('title'));
        });
        //İşçi Şoför Id
        var isciKurumID = new Array();
        $('select#IsciDetayKurum option:selected').each(function () {
            isciKurumID.push($(this).val());
        });
        //İşçi Şoför Ad
        var isciKurumAd = new Array();
        $('select#IsciDetayKurum option:selected').each(function () {
            isciKurumAd.push($(this).attr('title'));
        });
        //İşçi Seçili Olmayan Bölge ID
        var isciBolgeNID = new Array();
        $('select#IsciDetaySelectBolge option:not(:selected)').each(function () {
            isciBolgeNID.push($(this).val());
        });
        //işçi Seçili Olmayan Bölge Ad
        var isciBolgeNAd = new Array();
        $('select#IsciDetaySelectBolge option:not(:selected)').each(function () {
            isciBolgeNAd.push($(this).attr('title'));
        });
        //işçi Seçili Olmayan Şoför Id
        var isciKurumNID = new Array();
        $('select#IsciDetayKurum option:not(:selected)').each(function () {
            isciKurumNID.push($(this).val());
        });
        //işçi Seçili Olmayan Şoför Ad
        var isciKurumNAd = new Array();
        $('select#IsciDetayKurum option:not(:selected)').each(function () {
            isciKurumNAd.push($(this).attr('title'));
        });
        var farkbolge = farkArray(IsciDetailVazgec[16], isciBolgeID);
        var farkbolgelength = farkbolge.length;
        var farkisci = farkArray(IsciDetailVazgec[20], isciKurumID);
        var farkiscilength = farkisci.length;

        var odemeTutar = $("#detayOdemeTutar").val();
        var odemeTip = $("#detayDovizTip option:selected").val();
        var splitodeme = odemeTutar.split(".");
        var odemelength = splitodeme[0].length;
        var eskiAd = IsciDetailVazgec[0];
        var eskiSoyad = IsciDetailVazgec[1];
        if (IsciDetailVazgec[0] == isciDetayAd && IsciDetailVazgec[1] == isciDetaySoyad &&
                IsciDetailVazgec[2] == isciDetayDurum && IsciDetailVazgec[3] == isciDetayLokasyon
                && IsciDetailVazgec[4] == isciDetayTelefon && IsciDetailVazgec[5] == isciDetayEmail
                && IsciDetailVazgec[6] == isciDetayAdres && IsciDetailVazgec[7] == isciDetayAciklama
                && IsciDetailVazgec[8] == isciDetayUlke && IsciDetailVazgec[9] == isciDetayIl &&
                IsciDetailVazgec[10] == isciDetayIlce && IsciDetailVazgec[11] == isciDetaySemt &&
                IsciDetailVazgec[12] == isciDetayMahalle && IsciDetailVazgec[13] == isciDetaySokak &&
                IsciDetailVazgec[14] == isciDetayPostaKodu && IsciDetailVazgec[15] == isciDetayCaddeNo
                && farkbolgelength == 0 && farkiscilength == 0 && IsciDetailVazgec[24] == gdsbildirim &&
                IsciDetailVazgec[26] == dnsbildirim && IsciDetailVazgec[28] == odemeTip && IsciDetailVazgec[29] == odemeTutar) {
            reset();
            alertify.alert(jsDil.Degisiklik);
            return false;
        } else {
            isciDetayAd = isciDetayAd.trim();
            if (isciDetayAd == '') {
                reset();
                alertify.alert(jsDil.IsimBos);
                return false;
            } else {
                if (isciDetayAd.length < 2) {
                    reset();
                    alertify.alert(jsDil.IsimKarekter);
                    return false;
                } else {
                    isciDetaySoyad = isciDetaySoyad.trim();
                    if (isciDetaySoyad == '') {
                        reset();
                        alertify.alert(jsDil.SoyadBos);
                        return false;
                    } else {
                        if (isciDetaySoyad.length < 2) {
                            reset();
                            alertify.alert(jsDil.SoyadKarekter);
                            return false;
                        } else {
                            var isciDetayEmail = $("input[name=IsciDetayEmail]").val();
                            if (isciDetayEmail == ' ') {
                                reset();
                                alertify.alert(jsDil.EpostaBos);
                                return false;
                            } else {
                                isciDetayEmail = isciDetayEmail.trim();
                                var result = ValidateEmail(isciDetayEmail);
                                if (!result) {
                                    reset();
                                    alertify.alert(jsDil.EpostaUygun);
                                    return false;
                                } else {
                                    var isciBolgeLength = $('select#IsciDetaySelectBolge option:selected').val();
                                    if (isciBolgeLength) {
                                        var isciKurumLength = $('select#IsciDetayKurum option:selected').val();
                                        if (isciKurumLength) {
                                            if (odemeTutar != "") {
                                                if (odemelength <= 13) {
                                                    $.ajax({
                                                        data: {"eskiAd": eskiAd, "eskiSoyad": eskiSoyad, "iscidetail_id": iscidetail_id, "isciBolgeID[]": isciBolgeID, "isciBolgeAd[]": isciBolgeAd, "isciKurumID[]": isciKurumID, "isciKurumAd[]": isciKurumAd, "isciDetayAd": isciDetayAd,
                                                            "isciDetaySoyad": isciDetaySoyad, "isciDetayDurum": isciDetayDurum, "isciDetayLokasyon": isciDetayLokasyon, "isciDetayTelefon": isciDetayTelefon,
                                                            "isciDetayEmail": isciDetayEmail, "isciDetayAdres": isciDetayAdres, "isciDetayAciklama": isciDetayAciklama, "isciDetayUlke": isciDetayUlke,
                                                            "isciDetayIl": isciDetayIl, "isciDetayIlce": isciDetayIlce, "isciDetaySemt": isciDetaySemt, "isciDetayMahalle": isciDetayMahalle,
                                                            "isciDetaySokak": isciDetaySokak, "isciDetayPostaKodu": isciDetayPostaKodu, "isciDetayCaddeNo": isciDetayCaddeNo,
                                                            "gdsbildirim": gdsbildirim, "dnsbildirim": dnsbildirim,
                                                            "odemeTutar": odemeTutar, "odemeTip": odemeTip, "detayAdres": ttl, "tip": "isciDetailKaydet"},
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
                                                                var SelectIsciOptions = new Array();
                                                                if (isciBolgeID.length > 0) {
                                                                    var bolgelength = isciBolgeID.length;
                                                                    for (var b = 0; b < bolgelength; b++) {
                                                                        SelectBolgeOptions[b] = {label: isciBolgeAd[b], title: isciBolgeAd[b], value: isciBolgeID[b], selected: true};
                                                                    }

                                                                    if (isciBolgeNID.length > 0) {
                                                                        var isciBolgeLength = isciBolgeNID.length;
                                                                        for (var z = 0; z < isciBolgeLength; z++) {
                                                                            SelectBolgeOptions[b] = {label: isciBolgeNAd[z], title: isciBolgeNAd[z], value: isciBolgeNID[z]};
                                                                            b++;
                                                                        }

                                                                    }
                                                                } else {
                                                                    if (isciBolgeNID.length > 0) {
                                                                        var isciBolgeLength = isciBolgeNID.length;
                                                                        for (var b = 0; b < isciBolgeLength; b++) {
                                                                            SelectBolgeOptions[b] = {label: isciBolgeNAd[b], title: isciBolgeNAd[b], value: isciBolgeNID[b]};
                                                                        }

                                                                    }
                                                                }

                                                                if (isciKurumID.length > 0) {
                                                                    var aracselectlength = isciKurumID.length;
                                                                    for (var t = 0; t < aracselectlength; t++) {
                                                                        SelectIsciOptions[t] = {label: isciKurumAd[t], title: isciKurumAd[t], value: isciKurumID[t], selected: true};
                                                                    }

                                                                    if (isciKurumNID.length > 0) {
                                                                        var iscilength = isciKurumNID.length;
                                                                        for (var f = 0; f < iscilength; f++) {
                                                                            SelectIsciOptions[t] = {label: isciKurumNAd[f], title: isciKurumNAd[f], value: isciKurumNID[f]};
                                                                            t++;
                                                                        }
                                                                    }

                                                                } else {
                                                                    if (isciKurumNID.length > 0) {
                                                                        var iscilength = isciKurumNID.length;
                                                                        for (var t = 0; t < iscilength; t++) {
                                                                            SelectIsciOptions[t] = {label: isciKurumNAd[t], title: isciKurumNAd[t], value: isciKurumNID[t]};
                                                                        }
                                                                    }
                                                                }

                                                                $('#IsciDetaySelectBolge').multiselect('refresh');
                                                                $('#IsciDetayKurum').multiselect('refresh');
                                                                $('#IsciDetaySelectBolge').multiselect('dataprovider', SelectBolgeOptions);
                                                                $('#IsciDetayKurum').multiselect('dataprovider', SelectIsciOptions);
                                                                var length = $('tbody#isciRow tr').length;
                                                                for (var t = 0; t < length; t++) {
                                                                    var attrValueId = $("tbody#isciRow > tr > td > a").eq(t).attr('value');
                                                                    if (attrValueId == iscidetail_id) {
                                                                        if (isciDetayDurum != 0) {
                                                                            $("tbody#isciRow > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-user"></i> ' + isciDetayAd);
                                                                            $("tbody#isciRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(isciDetaySoyad);
                                                                            $("tbody#isciRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(isciDetayTelefon);
                                                                            $("tbody#isciRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(isciDetayEmail);
                                                                            $("tbody#isciRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(isciDetayAciklama);
                                                                            $('tbody#isciRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                                                        } else {
                                                                            $("tbody#isciRow > tr > td > a").eq(t).html('<i class="glyphicon glyphicon-user" style="color:red"></i> ' + isciDetayAd);
                                                                            $("tbody#isciRow > tr > td > a").eq(t).parent().parent().find('td:eq(1)').text(isciDetaySoyad);
                                                                            $("tbody#isciRow > tr > td > a").eq(t).parent().parent().find('td:eq(2)').text(isciDetayTelefon);
                                                                            $("tbody#isciRow > tr > td > a").eq(t).parent().parent().find('td:eq(3)').text(isciDetayEmail);
                                                                            $("tbody#isciRow > tr > td > a").eq(t).parent().parent().find('td:eq(5)').text(isciDetayAciklama);
                                                                            $('tbody#isciRow > tr:eq(' + t + ')').css({"background-color": "#F2F2F2"});
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    reset();
                                                    alertify.alert(jsDil.OdemeTutarB);
                                                    return false;
                                                }
                                            } else {
                                                reset();
                                                alertify.alert(jsDil.OdemeTutar);
                                                return false;
                                            }
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
                    }
                }
            }
        }
    },
    isciDetailTur: function () {
        IsciTurTable.DataTable().clear().draw();
        var isciID = $("input[name=isciDetayID]").val();
        $.ajax({
            data: {"isciID": isciID, "tip": "isciDetailTur"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.isciDetailTur) {
                        var turCount = cevap.isciDetailTur.length;
                        for (var i = 0; i < turCount; i++) {
                            if (cevap.isciDetailTur[i].TurTip == 0) {
                                TurTip = jsDil.Ogrenci;
                            } else if (cevap.isciDetailTur[i].TurTip == 1) {
                                TurTip = jsDil.Personel;
                            } else {
                                TurTip = jsDil.OgrenciPersonel;
                            }
                            if (cevap.isciDetailTur[i].TurAktiflik != 0) {
                                var addRow = "<tr><td>"
                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.isciDetailTur[i].TurID + "'>"
                                        + "<i class='fa fa-map-marker'></i> " + cevap.isciDetailTur[i].TurAd + "</a></td>"
                                        + "<td class='hidden-xs' >" + TurTip + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.isciDetailTur[i].TurAciklama + "</td>"
                                        + "<td class='hidden-xs'>" + cevap.isciDetailTur[i].TurKurum + "</td>"
                                        + "<td class='hidden-xs'>" + cevap.isciDetailTur[i].TurBolge + "</td></tr>";
                                IsciTurTable.DataTable().row.add($(addRow)).draw();
                            } else {
                                var addRow = "<tr><td>"
                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.isciDetailTur[i].TurID + "'>"
                                        + "<i class='fa fa-map-marker' style='color:red'></i> " + cevap.isciDetailTur[i].TurAd + "</a></td>"
                                        + "<td class='hidden-xs' >" + TurTip + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.isciDetailTur[i].TurAciklama + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.isciDetailTur[i].TurKurum + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.isciDetailTur[i].TurBolge + "</td></tr>";
                                IsciTurTable.DataTable().row.add($(addRow)).draw();
                            }
                        }
                    }
                }
            }
        });
        return true;
    },
}


