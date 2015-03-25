$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminAjaxSorgu",
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

        $.ajax({
            data: {"firma_adi": firma_adi, "firma_aciklama": firma_aciklama, "ogrenci_chechkbox": ogrenci_chechkbox,
                "personel_chechkbox": personel_chechkbox, "firma_adres": firma_adres, "firma_telefon": firma_telefon,
                "firma_email": firma_email, "firma_website": firma_website, "firma_lokasyon": firma_lokasyon, "tip": "adminFirmaIslemlerKaydet"},
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
        var firma_durum = $("input[name=FirmaDurum]").val();
        var firma_adres = $("textarea[name=FirmaAdres]").val();
        var firma_telefon = $("input[name=FirmaTelefon]").val();
        var firma_email = $("input[name=FirmaEmail]").val();
        var firma_website = $("input[name=FirmaWebAdresi]").val();
        var firma_lokasyon = $("input[name=FirmaLokasyon]").val();
        //vazgeç için değerler
        var firma_kodu = $("input[name=FrmKod]").val();
        AdminVazgec = [];
        AdminVazgec.push(firma_kodu, firma_adi, firma_aciklama, firma_durum, ogrenci_chechkbox, personel_chechkbox, firma_adres, firma_telefon, firma_email, firma_website, firma_lokasyon);
    },
    adminBolgeKaydet: function () {
        AdminBolgeKaydet = [];
        var bolge_adi = $("input[name=BolgeAdi]").val();
        var bolge_aciklama = $("textarea[name=BolgeAciklama]").val();

        AdminBolgeKaydet.push(bolge_adi);
        AdminBolgeKaydet.push(bolge_aciklama);

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
                        $("tbody#adminBolgeRow").prepend("<tr style='background-color:#F2F2F2'><td><a class='svToggle' data-type='svDetail' role='button' data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newBolgeID + "'>"
                                + "<i class='fa fa-search'></i> " + AdminBolgeKaydet[0] + "</a>"
                                + "</td><td class='hidden-xs'>0</td><td class='hidden-xs'>" + AdminBolgeKaydet[1] + "</td></tr>");
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

                    for (var t = 0; t < $('tbody#adminBolgeRow tr').length; t++) {
                        var attrValueId = $("tbody#adminBolgeRow > tr > td > a").eq(t).attr('value');
                        if (attrValueId == bolgedetail_id) {
                            $('tbody#adminBolgeRow > tr:eq(' + t + ')').remove();
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
                        alert(cevap.update);
                        for (var t = 0; t < $('tbody#adminBolgeRow tr').length; t++) {
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
    adminBolgeKurumMapVazgec: function () {
        $("input[name=country]").val(AdminBolgeKurumHarita[0]);
        $("input[name=administrative_area_level_1]").val(AdminBolgeKurumHarita[1]);
        $("input[name=administrative_area_level_2]").val(AdminBolgeKurumHarita[2]);
        $("input[name=locality]").val(AdminBolgeKurumHarita[3]);
        $("input[name=neighborhood]").val(AdminBolgeKurumHarita[4]);
        $("input[name=route]").val(AdminBolgeKurumHarita[5]);
        $("input[name=postal_code]").val(AdminBolgeKurumHarita[6]);
        $("input[name=street_number]").val(AdminBolgeKurumHarita[7]);
        $("input[name=KurumLokasyon]").val(AdminBolgeKurumHarita[8]);
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
                data: {"bolgeid": bolgeid, "bolgkurumadi": bolgkurumadi, "bolgkurumTlfn": bolgkurumTlfn, "bolgkurumEmail": bolgkurumEmail,
                    "bolgkurumwebsite": bolgkurumwebsite, "bolgkurumadrsDty": bolgkurumadrsDty, "bolgkurumaciklama": bolgkurumaciklama,
                    "bolgkurumulke": bolgkurumulke, "bolgkurumil": bolgkurumil, "bolgkurumilce": bolgkurumilce, "bolgkurumsemt": bolgkurumsemt,
                    "bolgkurummahalle": bolgkurummahalle, "bolgkurumsokak": bolgkurumsokak, "bolgkurumpostakodu": bolgkurumpostakodu,
                    "bolgkurumcaddeno": bolgkurumcaddeno, "bolgkurumlocation": bolgkurumlocation, "tip": "adminBolgeKurumKaydet"},
                success: function (cevap) {
                    if (cevap.hata) {
                        AdminBolgeDetailNewKurum = [];
                        alert(cevap.hata);
                    } else {
                        for (var t = 0; t < $('tbody#adminBolgeRow tr').length; t++) {
                            var attrValueId = $("tbody#adminBolgeRow > tr > td > a").eq(t).attr('value');
                            if (attrValueId == bolgeid) {
                                var bolgekurumsayac = $('tbody#adminBolgeRow > tr:eq(' + t + ') > td:eq(1)').text();
                                bolgekurumsayac++;
                                $('tbody#adminBolgeRow > tr:eq(' + t + ') > td:eq(1)').text(bolgekurumsayac);
                            }
                        }
                        $("ul#adminBolgeKurumDetail").prepend("<li class='list-group-item' style='background-color:#F2F2F2'>"
                                + "<a class='svToggle' data-type='svOpen' data-islemler='adminBolgeMultiMap' data-class='map' data-index='index' role='button' data-toggle='tooltip'data-value=" + cevap.newBolgeKurumID + " data-placement='top' title='' value='" + AdminBolgeDetailNewKurum[1] + "'>"
                                + "<i class='fa fa-map-marker'></i>    " + AdminBolgeDetailNewKurum[0] + "</a><i></i></li>");
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

        var count = $('ul#adminBolgeKurumDetail > li').length;

        var MapValue = $(this).attr('value');

        for (var countK = 0; countK < count; countK++) {
            var bolgeKurumlarMap = $('ul#adminBolgeKurumDetail > li:eq(' + countK + ') > a').attr('value');
            var LocationBolme = bolgeKurumlarMap.split(",");
            var bolgeKurumName = $('ul#adminBolgeKurumDetail > li:eq(' + countK + ') > a').text();
            MultipleMapArray[countK] = Array(bolgeKurumName, LocationBolme[0], LocationBolme[1]);
        }
        $("#singleMapBaslik").text(bolge_adi);
        return true;
    },
    adminBolgeKurumTablo: function () {
    }
}

$(document).on('click', 'tbody#adminBolgeRow > tr > td > a', function (e) {
    var i = $(this).find("i")
    i.removeClass("fa-search");
    i.addClass("fa-spinner fa-spin");
    var adminbolgeRowid = $(this).attr('value');
    $('ul#adminBolgeKurumDetail > li').remove();
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
                    $("ul#adminBolgeKurumDetail").find("li").remove();
                    for (var kurum = 0; kurum < bolgeKurumSayi; kurum++) {
                        $("ul#adminBolgeKurumDetail").append("<li class='list-group-item'>"
                                + "<a class='svToggle' data-type='svOpen' data-islemler='adminBolgeMultiMap' data-class='map' data-index='index' data-value=" + cevap.adminBolgeKurumDetail[kurum][2] + " data-islemler='adminBolgeMultiMap' role='button' data-toggle='tooltip' data-placement='top' title='' value='" + cevap.adminBolgeKurumDetail[kurum][1] + "'>"
                                + "<i class='fa fa-map-marker'></i>    " + cevap.adminBolgeKurumDetail[kurum][0] + "</a><i></i></li>");
                    }
                }
                svControl('svAdd', 'bolgeDetay', '');
                i.removeClass("fa-spinner fa-spin");
                i.addClass("fa-search");
            }
        }
    });
});
/*
 $(document).on('click', 'ul#adminBolgeKurumDetail > li > a', function (e) {
 var AdminBolgeKurumMap = new Array();
 
 var bolge_adi = $("input[name=BolgeDetailAdi]").val();
 
 //Tıklanılan değer indexi
 var index = $(this).parent().index();
 
 var count = $('ul#adminBolgeKurumDetail > li').length;
 
 var MapValue = $(this).attr('value');
 
 for (var countK = 0; countK < count; countK++) {
 var bolgeKurumlarMap = $('ul#adminBolgeKurumDetail > li:eq(' + countK + ') > a').attr('value');
 var LocationBolme = bolgeKurumlarMap.split(",");
 var bolgeKurumName = $('ul#adminBolgeKurumDetail > li:eq(' + countK + ') > a').text();
 AdminBolgeKurumMap[countK] = Array(bolgeKurumName, LocationBolme[0], LocationBolme[1]);
 }
 $("#kurumHaritaName").text(bolge_adi);
 multipleMapping(AdminBolgeKurumMap, index);
 google.maps.event.addDomListener(window, 'load', multipleMapping);
 });
 */

/*
 var proje_son_id;
 
 
 var yapiekle_deger = $("#ProjeYapiSelect select option:selected").val();
 if (yapiekle_deger == 1) {
 yapiekle_deger = "Apartman";
 $('div#degisken_yapi').css("name", "InputBlokSayii");
 } else if (yapiekle_deger == 2) {
 yapiekle_deger = "Villa";
 $('div#degisken_yapi').css("name", "InputVillaSayii");
 } else {
 yapiekle_deger = "Müstakil";
 }
 
 var degerim = $('#ProjeYapiSelect select option:selected').val();
 $("#ProjeYapiSelect select").change(function () {
 alert($('#ProjeYapiSelect select option:selected').html());
 });
 
 //Blok sayısı değerleri*
 var blok_dizi = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'İ', 'J', 'K', 'L', 'M', 'N', 'O', 'Ö', 'U', 'Ü', 'P', 'R', 'S', 'T', 'U'];
 var eleman = 0;
 var indexx = 0;
 $('input[name=InputBlokSayii]').jStepper({minValue: 1, maxValue: 20, minLength: 2});
 $('body').on('keyup', 'input[name=InputBlokSayii]', function () {
 if (this.value.match(/[^0-9]/g)) {
 this.value = this.value.replace(/[^0-9]/g, '');
 return true;
 }
 var eski_eleman = eleman;
 eleman1 = $(this).val();
 
 if ($.isNumeric(eleman1)) {
 eleman = eleman1
 } else {
 eleman = eleman;
 }
 
 if (eski_eleman < eleman) {
 for (var i = eski_eleman; i < eleman; i++) {
 $('div#deneme>div').eq(i).css("display", "block");
 $('div#deneme input').eq(2 * i).val(blok_dizi[i] + "  BLOK");
 $('div#deneme input').eq(2 * i + 1).val(" 8 ");
 }
 } else {
 for (var y = eleman; y < eski_eleman; y++) {
 $('div#deneme>div').eq(y).css("display", "none");
 }
 }
 $("label#istek").html(eleman);
 indexx = $("label#istek").html();
 });
 
 
 
 var ajax_dizi_Text = new Array();
 var ajax_dizi_Sayi = new Array();
 
 $.SatisKayit = {
 projeKayit: function () {
 var projeekle_kodu = $("input[name=InputPKodu]").val();
 var projeekle_durum = $("select option:selected").val();
 var projeekle_adi = $("input[name=InputProjeAdi]").val();
 var projeekle_bas_tarih = $("input[name=projekayit_bas_tarih]").val();
 var projeekle_bitis_tarih = $("input[name=projekayit_bitis_tarih]").val();
 var projeekle_textarea = $("textarea[name=projeKayit_textarea]").val();
 $.ajax({
 data: {"projeekle_kodu": projeekle_kodu, "projeekle_durum": projeekle_durum, "projeekle_adi": projeekle_adi, "projeekle_bas_tarih": projeekle_bas_tarih, "projeekle_bitis_tarih": projeekle_bitis_tarih, "projeekle_textarea": projeekle_textarea, "tip": "projeKayitt"},
 success: function (cevap) {
 if (cevap.proje_hata) {
 alert(cevap.proje_hata);
 } else {
 alert(cevap.proje_sonuc);
 $("#satis_ilk_kayit_sag_proje_kayit").slideUp(2000);
 $("#satis_ilk_kayit_sag_site_kayit").slideDown(2000);
 
 
 var proje_son_id = cevap.proje_son_id;
 
 $("#blokekle").click(function () {
 
 ajax_dizi_Text = [];
 ajax_dizi_Sayi = [];
 
 if (indexx == 0) {
 indexx = 1;
 }
 
 for (var a = 1; a <= indexx; a++) {
 ajax_dizi_Text.push($("#InputBlokText" + a).val());
 }
 for (var c = 1; c <= indexx; c++) {
 ajax_dizi_Sayi.push($("#InputBlokSayi" + c).val());
 }
 
 var yapiekle_adi = $("input[name=InputBlokAdi]").val();
 var yapiekle_tipi = $("#ProjeYapiSelect select option:selected").val();
 var yapiekle_sayi = $("input[name=InputBlokSayi]").val();
 var yapiekle_textarea = $("textarea[name=siteKayit_textarea]").val();
 $.ajax({
 data: {"proje_son_id": proje_son_id, "blok_adi[]": ajax_dizi_Text, "blok_sayi[]": ajax_dizi_Sayi, "yapiekle_adi": yapiekle_adi, "yapiekle_sayi": yapiekle_sayi, "yapiekle_tipi": yapiekle_tipi, "yapiekle_textarea": yapiekle_textarea, "tip": "siteKayitt"},
 success: function (cevap) {
 if (cevap.proje_yapi_hata) {
 alert(cevap.proje_yapi_hata);
 } else {
 $("#satis_ilk_kayit_sag_proje_kayit").slideUp(2000);
 }
 }
 });
 });
 }
 }
 });
 }*/




