$.ajaxSetup({
    type: "post",
    url: SITE_URL + "AdminProfilAjaxSorgu",
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

});
var AdminProfilVazgec = [];
$.AdminIslemler = {
    profilKaydet: function () {
        var id = $("input[name=ID]").val();
        var ad = $("input[name=Ad]").val();
        var soyad = $("input[name=Soyad]").val();
        var aciklama = $("textarea[name=Aciklama]").val();
        var telefon = $("input[name=Telefon]").val();
        var email = $("input[name=Email]").val();
        var lokasyon = $("input[name=KurumLokasyon]").val();
        var ulke = $("input[name=country]").val();
        var il = $("input[name=administrative_area_level_1]").val();
        var ilce = $("input[name=administrative_area_level_2]").val();
        var semt = $("input[name=locality]").val();
        var mahalle = $("input[name=neighborhood]").val();
        var sokak = $("input[name=route]").val();
        var postakodu = $("input[name=postal_code]").val();
        var caddeno = $("input[name=street_number]").val();
        var adres = $("textarea[name=Adres]").val();
        $.ajax({
            data: {"id": id, "ad": ad, "soyad": soyad, "aciklama": aciklama, "telefon": telefon,
                "email": email, "lokasyon": lokasyon, "ulke": ulke,
                "il": il, "ilce": ilce, "semt": semt,
                "mahalle": mahalle, "sokak": sokak, "postakodu": postakodu,
                "caddeno": caddeno, "adres": adres, "tip": "profilDuzenle"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    disabledForm();
                    reset();
                    alertify.success(cevap.update);
                }
            }
        });
    },
    profilVazgec: function () {
        $("input[name=Ad]").val(AdminProfilVazgec[0]);
        $("input[name=Soyad]").val(AdminProfilVazgec[1]);
        $("input[name=Kadi]").val(AdminProfilVazgec[2]);
        $("input[name=Sifre]").val(AdminProfilVazgec[3]);
        $("textarea[name=Aciklama]").val(AdminProfilVazgec[4]);
        $("input[name=Durum]").val(AdminProfilVazgec[5]);
        $("input[name=Telefon]").val(AdminProfilVazgec[6]);
        $("input[name=Email]").val(AdminProfilVazgec[7]);
        $("input[name=KurumLokasyon]").val(AdminProfilVazgec[8]);
        $("input[name=country]").val(AdminProfilVazgec[9]);
        $("input[name=administrative_area_level_1]").val(AdminProfilVazgec[10]);
        $("input[name=administrative_area_level_2]").val(AdminProfilVazgec[11]);
        $("input[name=locality]").val(AdminProfilVazgec[12]);
        $("input[name=neighborhood]").val(AdminProfilVazgec[13]);
        $("input[name=route]").val(AdminProfilVazgec[14]);
        $("input[name=postal_code]").val(AdminProfilVazgec[15]);
        $("input[name=street_number]").val(AdminProfilVazgec[16]);
        $("textarea[name=Adres]").val(AdminProfilVazgec[17]);
    },
    profilDuzenle: function () {
        var ad = $("input[name=Ad]").val();
        var soyad = $("input[name=Soyad]").val();
        var kadi = $("input[name=Kadi]").val();
        var sifre = $("input[name=Sifre]").val();
        var aciklama = $("textarea[name=Aciklama]").val();
        var durum = $("input[name=Durum]").val();
        var telefon = $("input[name=Telefon]").val();
        var email = $("input[name=Email]").val();
        var lokasyon = $("input[name=KurumLokasyon]").val();
        var ulke = $("input[name=country]").val();
        var il = $("input[name=administrative_area_level_1]").val();
        var ilce = $("input[name=administrative_area_level_2]").val();
        var semt = $("input[name=locality]").val();
        var mahalle = $("input[name=neighborhood]").val();
        var sokak = $("input[name=route]").val();
        var postakodu = $("input[name=postal_code]").val();
        var caddeno = $("input[name=street_number]").val();
        var adres = $("textarea[name=Adres]").val();
        //vazgeç için değerler
        AdminProfilVazgec = [];
        AdminProfilVazgec.push(ad, soyad, kadi, sifre, aciklama, durum, telefon, email,
                lokasyon, ulke, il, ilce, semt, mahalle, sokak, postakodu, caddeno, adres);
    },
    sifreDuzenle: function () {
        $("input[name=eskiSifre]").val('');
        $("input[name=yeniSifre]").val('');
        $("input[name=yeniSifreTekrar]").val('');
        return true;
    },
    sifreVazgec: function () {
        return true;
    },
    sifreKaydet: function () {
        var eskiSifre = $("input[name=eskiSifre]").val();
        var yeniSifre = $("input[name=yeniSifre]").val();
        var yeniSifreTkrr = $("input[name=yeniSifreTekrar]").val();
        $.ajax({
            data: {"eskiSifre": eskiSifre, "yeniSifre": yeniSifre,
                "yeniSifreTkrr": yeniSifreTkrr, "tip": "sifreKaydet"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    reset();
                    alertify.success(cevap.update);
                    $("input[name=eskiSifre]").val('');
                    $("input[name=yeniSifre]").val('');
                    $("input[name=yeniSifreTekrar]").val('');
                    return true;
                }
            }
        });
    },
}


