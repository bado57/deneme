<?php

class tr {

    public function __construct() {
        
    }

    public function ajaxlanguage() {
        $trdil = array(
            "Hata" => "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.",
            "Merhaba" => "Merhaba",
            "Yonetici" => "Yönetici",
            "Sofor" => "Şoför",
            "Hostes" => "Hostes",
            "Veli" => "Veli",
            "Isci" => "İşçi",
            "Ogrenci" => "Öğrenci",
            "Personel" => "Personel",
            "YeniOdeme" => "Yeni ödeme kaydedildi.",
            "OdemeDuzenle" => "Ödeme kaydınız düzenlendi.",
            "KullaniciAdi" => "Kullanıcı Adı",
            "KullaniciSifre" => "Kullancı Şifreniz",
            "IyiGunler" => "İyi günler dileriz.",
            "UyelikBilgi" => "Üyelik Bilgileri",
            "SHtrltMail" => "Shuttle - Üyelik Bilgileri",
            "GecersizKullanici" => "Lütfen Yeni Bir Kullanıcı Adı yada Şifre Giriniz.",
            "AdminEkle" => "Başarıyla Admin Eklenmiştir.",
            "GecerliEmail" => "Lütfen geçerli bir email adresi giriniz.",
            "BaskaEmail" => "Mailiniz kullanımda değildir. Lütfen başka bir mail deneyiniz.",
            "KullanilmisEmail" => "Bu mail daha önce kullanılmış başka bir mail adresi deneyiniz.",
            "AdminDuzen" => "Başarıyla admin kaydı düzenlendi.",
            "AdminEkle" => "Başarıyla admin kaydı eklendi.",
            "AdminSil" => "Başarıyla admin kaydı silindi.",
            "SoforEkle" => "Başarıyla şoför kaydı eklendi.",
            "SoforSil" => "Başarıyla şoför kaydı silindi.",
            "SoforDuzenle" => "Başarıyla şoför kaydı düzenlendi.",
            "BolgeSec" => "Lütfen bölge seçmeyi unutmayınız.",
            "HostesEkle" => "Başarıyla hostes kaydı eklendi.",
            "HostesSil" => "Başarıyla hostes kaydı silindi.",
            "HostesDuzenle" => "Başarıyla hostes kaydı düzenlendi.",
            "VeliEkle" => "Başarıyla veli kaydı eklendi.",
            "VeliSil" => "Başarıyla veli kaydı silindi.",
            "VeliDuzenle" => "Başarıyla veli kaydı düzenlendi.",
            "KurumSec" => "Lütfen kurum seçmeyi unutmayınız.",
            "OgrenciEkle" => "Başarıyla öğrenci kaydı eklendi.",
            "OgrenciSil" => "Başarıyla öğrenci kaydı silindi.",
            "OgrenciDuzenle" => "Başarıyla öğrenci kaydı düzenlendi.",
            "IsciEkle" => "Başarıyla personel kaydı eklendi.",
            "IsciSil" => "Başarıyla personel kaydı silindi.",
            "IsciDuzenle" => "Başarıyla personel kaydı düzenlendi.",
            "FirmaDuzenle" => "Firma Bilgileri Başarı ile Düzenlendi.",
            "BolgeKaydet" => "Yeni Bölge Başarı ile Eklendi.",
            "BolgeDuzenle" => "Bölge Bilgileri Başarı ile Düzenlendi.",
            "BolgeSilme" => "Bölge Bilgileri Başarı ile Düzenlendi.",
            "KurumKaydet" => "Başarıyla Yeni Kurum Eklenmiştir.",
            "KurumSilme" => "Kurum Bilgileri Başarı ile Düzenlendi.",
            "KurumDuzenle" => "Kurum Bilgileri Başarı ile Düzenlendi.",
            "GidisTur" => "Gidiş Turu Oluşturdu.",
            "DonusTur" => "Dönüş Turu Oluşturdu.",
            "GidisTurDuzenle" => "Gidiş Turu Düzenlendi.",
            "DonusTurDuzenle" => "Dönüş Turu Düzenlendi.",
            "TurSilme" => "Silme İşlemi Başarılı Şekilde Gerçekleşmiştir.",
            "BakiyeSilme" => "Silme İşlemi Başarılı Şekilde Gerçekleşmiştir.",
            "AracKaydet" => "Araç Başarı ile Eklendi.",
            "AracSil" => "Araç Başarı ile Silindi.",
            "AracDuzenle" => "Araç Bilgileri Başarı ile Düzenlendi.",
            "DuyuruGonder" => "Duyurunuz başarılı bir şekilde gönderilmiştir.",
            "ProfilDuzenle" => "Profil Bilgileriniz Başarılı Bir Şekilde Düzenlendi.",
            "BildirimAyarKaydet" => "Bildirim Ayarları Kaydedildi.",
            "Elden" => "Elden",
            "KrediKartı" => "Kredi Kartı",
            "Havale" => "Havale",
        );
        return $trdil;
    }

    public function bildirimlanguage() {
        $trdil = array(
            "Hata" => "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.",
            "BolgeEkle" => "Bölge Ekleme",
            "BolgeEkleme" => " Bölgesini Ekledi.",
            "BolgeDuzenleme" => " Bölgesini Düzenledi.",
            "BolgeDuzen" => "Bölge Düzenleme",
            "BolgeSilme" => " Bölgesini Sildi.",
            "BolgeSil" => "Bölge Silme.",
            "KurumSilme" => " Kurumunu Sildi.",
            "KurumSil" => "Kurum Silme.",
            "KurumEkleme" => " Kurumunu Ekledi.",
            "KurumEkle" => "Kurum Ekleme.",
            "KurumDuzenleme" => " Kurumunu Düzenledi.",
            "KurumDuzen" => "Kurum Düzenleme",
            "TurGidisAtama" => " Gidiş Turuna Ekledi.Detayları Tur Sayfasından Görebilirsiniz.",
            "TurAta" => "Tur Atama",
            "TurAtama" => " Turuna Ekledi.Detayları Tur Sayfasından Görebilirsiniz.",
            "TurEkleme" => " Turunu Ekledi.Detayları Tur Sayfasından Görebilirsiniz.",
            "TurEkle" => "Tur Ekleme.",
            "TurDonusAtama" => " Dönüş Turuna Ekledi.Detayları Tur Sayfasından Görebilirsiniz.",
            "TurGidisDuzenleme" => " Gidiş Turunu Düzenledi.Detayları Tur Sayfasından Görebilirsiniz.",
            "TurDuzen" => "Tur Düzenleme",
            "TurSilme" => " Turunu Sildi.Detayları Tur Sayfasından Görebilirsiniz.",
            "TurSil" => "Tur Silme.",
            "TurDonusDuzenleme" => " Dönüş Turunu Düzenledi.Detayları Tur Sayfasından Görebilirsiniz.",
            "Bakiye" => "Bakiye İşlemleri",
            "OdemeYapma" => "Hesabınıza yeni ödeme yapılmıştır.Detayları bakiye sayfasından görebilirsiniz.",
            "AracAta" => "Arac Atama",
            "AracAtama" => " Aracı Size Atadı.",
            "AracEkleme" => " Aracını Ekledi.",
            "AracEkle" => "Araç Ekleme.",
            "AracSilme" => " Aracını Sildi.",
            "AracSil" => "Araç Silme.",
            "AracDuzenleme" => " Aracını Düzenledi.",
            "AracDuzen" => "Araç Düzenleme",
            "AracCıkarma" => " Aracı Sizden Çıkardı.",
            "YeniDuyuru" => "Yeni Duyuru",
            "DuyuruGonder" => "Duyurunuz başarılı bir şekilde gönderilmiştir.",
        );
        return $trdil;
    }

}

?>