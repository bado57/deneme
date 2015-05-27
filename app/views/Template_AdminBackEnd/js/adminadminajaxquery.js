$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminAdminAjaxSorgu",
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
    AdminTable = $('#adminTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    //admin işlemleri
    $(document).on('click', 'tbody#adminRow > tr > td > a', function (e) {
        var i = $(this).find("i");
        i.removeClass("glyphicon glyphicon-user");
        i.addClass("fa fa-spinner");
        var adminRowid = $(this).attr('value');
        $.ajax({
            data: {"adminRowid": adminRowid, "tip": "adminDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
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
                    i.removeClass("fa fa-spinner");
                    i.addClass("glyphicon glyphicon-user");
                }
            }
        });
    });
});
var AdminDetailVazgec = [];
$.AdminIslemler = {
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
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
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
                        reset();
                        alertify.alert(jsDil.BolgeOlustur);
                        return false;
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
            reset();
            alertify.alert(jsDil.IsimBos);
            return false;
        } else {
            if (adminAd.length < 2) {
                reset();
                alertify.alert(jsDil.IsimKarekter);
                return false;
            } else {
                var adminSoyad = $("input[name=AdminSoyadi]").val();
                adminSoyad = adminSoyad.trim();
                if (adminSoyad == '') {
                    reset();
                    alertify.alert(jsDil.SoyadBos);
                    return false;
                } else {
                    if (adminSoyad.length < 2) {
                        reset();
                        alertify.alert(jsDil.SoyadKarekter);
                        return false;
                    } else {
                        var adminEmail = $("input[name=AdminEmail]").val();
                        if (adminEmail == ' ') {
                            reset();
                            alertify.alert(jsDil.EpostaBos);
                            return false;
                        } else {
                            adminEmail = adminEmail.trim();
                            var result = ValidateEmail(adminEmail);
                            if (!result) {
                                reset();
                                alertify.alert(jsDil.EpostaUygun);
                                return false;
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
                                                    reset();
                                                    alertify.alert(jsDil.Hata);
                                                    return false;
                                                } else {
                                                    reset();
                                                    alertify.success(jsDil.AdminKaydet);
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
        reset();
        alertify.confirm(jsDil.SilOnay, function (e) {
            if (e) {
                var admindetail_id = $("input[name=adminDetayID]").val();
                $.ajax({
                    data: {"admindetail_id": admindetail_id, "tip": "adminDetailDelete"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(jsDil.Hata);
                            return false;
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
                            reset();
                            alertify.success(jsDil.SilEvet);
                            svControl('svClose', 'adminDetay', '');
                        }
                    }
                });
            } else {
                alertify.error(jsDil.SilRed);
            }
        });
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
            reset();
            alertify.alert(jsDil.Degisiklik);
            return false;
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
                            reset();
                            alertify.alert(jsDil.Hata);
                            return false;
                        } else {
                            disabledForm();
                            reset();
                            alertify.success(jsDil.AdminDuzenle);
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
                reset();
                alertify.alert(jsDil.BolgeSec);
                return false;
            }

        }
    }
}


