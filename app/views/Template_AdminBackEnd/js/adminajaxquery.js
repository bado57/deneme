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
    

$.adminFirmaIslem = function (args) {
    //alert(ogrenci_chechkbox);
    
    //Firma İşlemleri Mysql-Return ve inputlara değerleri basma
    $.ajax({
        data: {"tip": "adminFirmaIslemler"},
        success: function (cevap) {
            if (cevap.hata) {
                alert("Üzgünüz tekrar deneyiniz.");
            } else {
                //$("#satis_ilk_kayit_sag_proje_kayit").slideUp(2000);
                $("input[name=FrmKod]").val(cevap.FirmaOzellikler[0]["FirmaKodu"]);
                $("input[name=FirmaAdi]").val(cevap.FirmaOzellikler[0]["FirmaAdi"]);
                $("textarea[name=Aciklama]").val(cevap.FirmaOzellikler[0]["FirmaAciklama"]);
                //hidden input
                $("input[name=FirmaDurum]").val(cevap.FirmaOzellikler[0]["FirmaDurum"]);
                $("select[name=FirmaDurum]").val(cevap.FirmaOzellikler[0]["FirmaDurum"]);
                if (cevap.FirmaOzellikler[0]["OgrenciServis"] != 1) {
                    $('#OgrenciServis').prop('checked', '');
                    checkIt();
                } else {
                    $('#OgrenciServis').prop('checked', 'true');
                    checkIt();
                }
                if (cevap.FirmaOzellikler[0]["PersonelServis"] != 1) {
                    $('#PersonelServis').prop('checked', '');
                    checkIt();
                } else {
                    $('#PersonelServis').prop('checked', 'true');
                    checkIt();
                }
                $("textarea[name=FirmaAdres]").val(cevap.FirmaOzellikler[0]["FirmaAdres"]);
                $("input[name=FirmaTelefon]").val(cevap.FirmaOzellikler[0]["FirmaTelefon"]);
                $("input[name=FirmaEmail]").val(cevap.FirmaOzellikler[0]["FirmaEmail"]);
                $("input[name=FirmaWebAdresi]").val(cevap.FirmaOzellikler[0]["FirmaWebsite"]);
                $("input[name=FirmaLokasyon]").val(cevap.FirmaOzellikler[0]["FirmaLokasyon"]);
            }
        }
    });
}



$.AdminIslemler = {
    adminFirmaOzellik: function () {
        //Firma İşlemleri Değerleri
        var firma_kodu = $("input[name=FrmKod]").val();
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
            data: {"firma_kod": firma_kodu, "firma_adi": firma_adi, "firma_aciklama": firma_aciklama, "ogrenci_chechkbox": ogrenci_chechkbox,
                "personel_chechkbox": personel_chechkbox, "firma_adres": firma_adres, "firma_telefon": firma_telefon,"firma_durum":firma_durum,
                "firma_email": firma_email, "firma_website": firma_website, "firma_lokasyon": firma_lokasyon, "tip": "adminFirmaIslemlerKaydet"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert("hata");
                } else {
                    alert(cevap.firmaozellik_update);
                }
            }
        });

    }
}



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
 },
 blokKayit: function () {
 alert(proje_son_id);
 
 }
 }
 
 $('body').on('keyup', 'input[name=satis_giris_username]', function(){
 var availname=$(this).val();					
 if(availname!=''){
 $('.check').show();
 $('.check').fadeIn(400).html('<img src="../img/ajax-loading.gif" /> ');
 $.ajax({
 data: {"satis_giris":availname,"tip":"giris_adi"},
 success: function(result){
 if(!result.giris_adi==''){
 $('.check').html('<img src="../img/accept.png" /> Geçerli Kullanıcı Adı');
 $(".check").removeClass("red");
 $('.check').addClass("green");
 $(".satis_giris_username").removeClass("yellow");
 $(".satis_giris_username").addClass("white");
 }else{
 $('.check').html('<img src="../img/error.png" /> Geçersiz Kullanıcı Adı');
 $(".check").removeClass("green");
 $('.check').addClass("red")
 $(".satis_giris_username").removeClass("white");
 $(".satis_giris_username").addClass("yellow");
 }
 }
 });
 }else{
 $('.check').html('');
 }
 
 });*/


/*Grafiksel Gösterim HighCharts*/
/*
 $('#container').highcharts({
 title: {
 text: 'Aylık Proje Kayıt Detayları',
 x: -20 //center
 },
 subtitle: {
 x: -20
 },
 xAxis: {
 categories: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran',
 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık']
 },
 yAxis: {
 title: {
 text: 'Proje Detayları'
 },
 plotLines: [{
 value: 0,
 width: 1,
 color: '#808080'
 }]
 },
 tooltip: {
 valueSuffix: ''
 },
 legend: {
 layout: 'vertical',
 align: 'right',
 verticalAlign: 'middle',
 borderWidth: 0
 },
 series: [{
 name: 'Apartman',
 data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6, ]
 }, {
 name: 'Villa',
 data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
 }, {
 name: 'Müstakil',
 data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
 }, {
 name: 'Apart',
 data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
 }]
 });
 
 
 $('#satisprojeKayit_form').validate({
 rules: {
 name: {
 minlength: 2,
 required: true
 },
 email: {
 required: true,
 email: true
 },
 subject: {
 minlength: 2,
 required: true
 },
 message: {
 minlength: 2,
 required: true
 }
 },
 highlight: function(element) {
 $(element).closest('.control-group').removeClass('success').addClass('error');
 },
 success: function(element) {
 element
 .text('OK!').addClass('valid')
 .closest('.control-group').removeClass('error').addClass('success');
 }
 });*/



/*DatePicker*/
//$("#date_text").datepicker();
//$("#date_text2").datepicker();



