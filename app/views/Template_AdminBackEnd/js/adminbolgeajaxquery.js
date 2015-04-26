$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminBolgeAjaxSorgu",
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
    KurumTable = $('#adminBolgeKurumTable').dataTable({
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
});
var AdminVazgec = [];
var AdminBolgeDetailVazgec = [];
var AdminBolgeKaydet = [];
var AdminBolgeKurumHarita = [];
var AdminBolgeDetailNewKurum = [];
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
        console.log("js");
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
    }
}


