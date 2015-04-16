$.ajaxSetup({
    type: "post",
    url: "http://192.168.1.20/SProject/AdminAjaxSorguMobil",
    //timeout:3000,
    dataType: "json",
    error: function (a, b) {
        if (b == "timeout")
            alert("İnternet Bağlantınızı Kontrol Ediniz.");
    },
    statusCode: {
        404: function () {
            alert("İnternet Bağlantınızı Kontrol Ediniz.");
        }
    }
});
var AdminVazgec = [];
var AdminBolgeDetailVazgec = [];
var AdminBolgeKaydet = [];
var AdminBolgeDetailNewKurum = [];

$.AdminIslemler = {
    adminFirmaOzellik: function () {
        //Firma İşlemleri Değerleri
        var firma_kod = $("input[name=FrmKod]").val();
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
        var firmakurumulke = $("input[name=country]").val();
        var firmakurumil = $("input[name=administrative_area_level_1]").val();
        var firmakurumilce = $("input[name=administrative_area_level_2]").val();
        var firmakurumsemt = $("input[name=locality]").val();
        var firmakurummahalle = $("input[name=neighborhood]").val();
        var firmakurumsokak = $("input[name=route]").val();
        var firmakurumpostakodu = $("input[name=postal_code]").val();
        var firmakurumcaddeno = $("input[name=street_number]").val();
        $.ajax({
            data: {"firma_kod": firma_kod, "firma_adi": firma_adi, "firma_aciklama": firma_aciklama, "ogrenci_chechkbox": ogrenci_chechkbox,
                "personel_chechkbox": personel_chechkbox, "firma_adres": firma_adres, "firma_telefon": firma_telefon,
                "firma_email": firma_email, "firma_website": firma_website, "firma_lokasyon": firma_lokasyon,
                "firmakurumulke": firmakurumulke, "firmakurumil": firmakurumil, "firmakurumilce": firmakurumilce,
                "firmakurumsemt": firmakurumsemt, "firmakurummahalle": firmakurummahalle, "firmakurumsokak": firmakurumsokak,
                "firmakurumpostakodu": firmakurumpostakodu, "firmakurumcaddeno": firmakurumcaddeno, "tip": "adminFirmaIslemlerKaydet"},
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
        $(document).on('pagebeforeshow', function () {
            $("input[name=bolgeAdi]").val('');
            $("textarea[name=bolgeAciklama]").val('');
        });
    },
    adminBolgeKaydet: function () {
        AdminBolgeKaydet = [];
        var bolge_adi = $("input[name=bolgeAdi]").val();
        var bolge_aciklama = $("textarea[name=bolgeAciklama]").val();
        var id = $("input[name=adminUserID]").val();
        var rutbe = $("input[name=adminRutbe]").val();
        var username = $("input[name=adminUsername]").val();
        var firmId = $("input[name=adminFirmId]").val();

        AdminBolgeKaydet.push(bolge_adi);
        AdminBolgeKaydet.push(bolge_aciklama);

        if (bolge_adi != '' && rutbe != 0 && id != '') {
            $.ajax({
                data: {"bolge_adi": bolge_adi, "bolge_aciklama": bolge_aciklama, "firmId": firmId, "id": id, "rutbe": rutbe, "username": username, "tip": "adminBolgeYeniKaydet"},
                success: function (cevap) {
                    if (cevap.hata) {
                        AdminBolgeKaydet = [];
                        alert(cevap.hata);
                    } else {
                        $('ul#bolgeList').prepend($('<li/>', {//here appending `<li>`
                            'data-role': "listview"
                        }).append($('<a/>', {//here appending `<a>` into `<li>`
                            'href': '#bolgeDetay',
                            'data-transition': 'slide',
                            'text': bolge_adi,
                            'value': cevap.newBolgeID
                        })));
                        $('ul#bolgeList').listview('refresh');
                        pageData.push(cevap.newBolgeID);
                        pageData.push(bolge_adi);
                        pageData.push(bolge_aciklama);
                        $.mobile.navigate("#bolgeDetay");
                    }
                }
            });
        } else {
            alert("Lütfen Bölge Adını Giriniz");
        }
    },
    adminBolgeDetail: function () {
        $(document).on('pagebeforeshow', function () {
            var id = $("input[name=adminUserID]").val();
            var firmId = $("input[name=adminFirmId]").val();
            if (!pageData[1]) {
                if (customID != '') {
                    $.ajax({
                        data: {"adminbolgeRowid": customID, "firmId": firmId, "id": id, "tip": "adminBolgeDetail"},
                        success: function (cevap) {
                            if (cevap.hata) {
                                alert(cevap.hata);
                            } else {
                                $("input[name=adminBolgeDetailID]").val(cevap.adminSelectBolge[0].SelectBolgeID);
                                $("input[name=BolgeDetailAdi]").val(cevap.adminSelectBolge[0].SelectBolgeAdi);
                                $("textarea[name=BolgeDetailAciklama]").val(cevap.adminSelectBolge[0].SelectBolgeAciklama);

                                if (cevap.adminBolgeKurum != 1) {
                                    $("#adminBolgeDetailSil").hide();
                                }
                            }
                        }
                    });
                } else {
                    alert("Bir hata meydana geldi");
                }
            } else {
                $("input[name=adminBolgeDetailID]").val(pageData[0]);
                $("input[name=BolgeDetailAdi]").val(pageData[1]);
                $("textarea[name=BolgeDetailAciklama]").val(pageData[2]);
            }

        });

        $(document).on('pageshow', '[data-role="page"]', function () {
            pageData = [];
        });
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
        var id = $("input[name=adminUserID]").val();
        var bolgedetail_id = $("input[name=adminBolgeDetailID]").val();
        var username = $("input[name=adminUsername]").val();
        var firmId = $("input[name=adminFirmId]").val();

        $.ajax({
            data: {"id": id, "firmId": firmId, "username": username, "bolgedetail_id": bolgedetail_id, "tip": "adminBolgeDetailDelete"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    var length = $('ul#bolgeList li').length;
                    for (var t = 0; t < length; t++) {
                        var attrValueId = $("ul#bolgeList > li > a").eq(t).attr('value');
                        if (attrValueId == bolgedetail_id) {
                            $('ul#bolgeList > li:eq(' + t + ')').remove();
                        }
                    }
                    $('ul#bolgeList').listview('refresh');
                    $.mobile.navigate("#bolgeMain");
                }
            }
        });
    },
    adminBolgeDetailKaydet: function () {
        var bolgedetail_adi = $("input[name=BolgeDetailAdi]").val();
        var bolgedetail_aciklama = $("textarea[name=BolgeDetailAciklama]").val();
        var bolgedetail_id = $("input[name=adminBolgeDetailID]").val();
        var firmId = $("input[name=adminFirmId]").val();
        var id = $("input[name=adminUserID]").val();

        if (AdminBolgeDetailVazgec[0] == bolgedetail_adi && AdminBolgeDetailVazgec[1] == bolgedetail_aciklama) {
            alert("Lütfen Değişiklik yaptığınıza emin olun.");
        } else {
            $.ajax({
                data: {"firmId": firmId, "id": id, "bolgedetail_id": bolgedetail_id, "bolgedetail_adi": bolgedetail_adi, "bolgedetail_aciklama": bolgedetail_aciklama, "tip": "adminBolgeDetailDuzenle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        alert(cevap.hata);
                    } else {
                        disabledForm();
                        //alert(cevap.update);
                        var length = $('ul#bolgeList li').length;
                        for (var t = 0; t < length; t++) {
                            var attrValueId = $("ul#bolgeList > li > a").eq(t).attr('value');
                            if (attrValueId == bolgedetail_id) {
                                $("ul#bolgeList li > a").eq(t).text(bolgedetail_adi);
                            }
                        }
                        $('ul#bolgeList').listview('refresh');
                    }
                }
            });
        }
    },
    adminBolgeKurum: function () {
        $(document).on('pagebeforeshow', function () {
            $('ul#bolgeKurumList').empty();
            var id = $("input[name=adminUserID]").val();
            var firmId = $("input[name=adminFirmId]").val();
            if (customID != '') {
                $.ajax({
                    data: {"adminbolgeRowid": customID, "firmId": firmId, "id": id, "tip": "adminKurumDetail"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            alert(cevap.hata);
                        } else {
                            var length = cevap.adminSelectBolgeKurum.length;
                            for (var i = 0; i < length; i++) {
                                $('ul#bolgeKurumList').prepend($('<li/>', {
                                    'data-role': "listview"
                                }).append($('<a/>', {
                                    'data-destination': '#bolgeKurumLokasyon',
                                    'class': 'jmMultiValue',
                                    'text': cevap.adminSelectBolgeKurum[i].SelectBolgeKurumAdi,
                                    'value': cevap.adminSelectBolgeKurum[i].SelectBolgeKurumLokasyon,
                                    'id': cevap.adminSelectBolgeKurum[i].SelectBolgeKurumID,
                                    'data-parent': '#bolgeKurumList'
                                })));
                            }
                            $('ul#bolgeKurumList').listview('refresh');
                        }
                    }
                });
            } else {
                alert("Bir hata meydana geldi");
            }
        });

        $(document).on('pageshow', '[data-role="page"]', function () {

        });
    },
    adminBolgeDetailYeniEkle: function () {
        $(document).on('pagebeforeshow', function () {
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
        });
    },
    adminBolgeKurumKaydet: function () {
        AdminBolgeDetailNewKurum = [];
        var bolgkurumadi = $("input[name=KurumAdi]").val();
        var bolgkurumlocation = $("input[name=KurumLokasyon]").val();
        var id = $("input[name=adminUserID]").val();
        AdminBolgeDetailNewKurum.push(bolgkurumadi);
        AdminBolgeDetailNewKurum.push(bolgkurumlocation);

        var bolgeid = $("input[name=adminBolgeDetailID]").val();
        var bolgead = $("input[name=BolgeDetailAdi]").val();
        //input hidden
        var username = $("input[name=adminUsername]").val();
        var firmId = $("input[name=adminFirmId]").val();
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
                data: {"firmId": firmId, "bolgead": bolgead, "id": id, "username": username, "bolgeid": bolgeid, "bolgkurumadi": bolgkurumadi, "bolgkurumTlfn": bolgkurumTlfn, "bolgkurumEmail": bolgkurumEmail,
                    "bolgkurumwebsite": bolgkurumwebsite, "bolgkurumadrsDty": bolgkurumadrsDty, "bolgkurumaciklama": bolgkurumaciklama,
                    "bolgkurumulke": bolgkurumulke, "bolgkurumil": bolgkurumil, "bolgkurumilce": bolgkurumilce, "bolgkurumsemt": bolgkurumsemt,
                    "bolgkurummahalle": bolgkurummahalle, "bolgkurumsokak": bolgkurumsokak, "bolgkurumpostakodu": bolgkurumpostakodu,
                    "bolgkurumcaddeno": bolgkurumcaddeno, "bolgkurumlocation": bolgkurumlocation, "tip": "adminBolgeKurumKaydet"},
                success: function (cevap) {
                    if (cevap.hata) {
                        AdminBolgeDetailNewKurum = [];
                        alert(cevap.hata);
                    } else {
                        $('ul#bolgeKurumList').prepend($('<li/>', {
                            'data-role': "listview"
                        }).append($('<a/>', {
                            'data-destination': '#bolgeKurumLokasyon',
                            'class': 'jmMultiValue',
                            'text': bolgkurumadi,
                            'value': bolgkurumlocation,
                            'id': cevap.adminSelectBolgeKurum[i].SelectBolgeKurumID,
                            'data-parent': '#bolgeKurumList'
                        })));
                        $('ul#bolgeKurumList').listview('refresh');
                        AdminBolgeDetailNewKurum = [];
                        $.mobile.navigate("#adminBolgeKurum");
                    }
                }
            });
        } else {
            alert("Lütfen Kurum Adını Giriniz");
        }
    }
}


