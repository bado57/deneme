<?php

class tr {

    public function __construct() {
        
    }

    public function multilanguage() {
        $trdil = array(
            "FirmaAd" => "Shuttle",
            "LoginSelectlanguage" => "Dil Seçiniz",
            "LoginTitle" => "Giriş",
            "Loginkadi" => "Kullanıcı Adı",
            "Loginsifre" => "Şifre",
            "Admin" => "Admin",
            "Sofor" => "Şoför",
            "Hostes" => "Hostes",
            "Veli" => "Veli",
            "Isci" => "İşçi",
            "Ogrenci" => "Öğrenci",
            "Personel" => "Personel",
            "LoginButton" => "Giriş",
            "Merhaba" => "Merhaba",
            "Baslik" => "Admin",
            "TitleSofor" => "Şoför",
            "TitleVeli" => "Veli",
            "TitleOgrenci" => "Öğrenci",
            "TitleIsci" => "İşci",
            "Anasayfa" => "Anasayfa",
            "Panel" => "Yönetim Paneli",
            "KontrolPanel" => "Kontrol Paneli",
            "FirmaIslem" => "Firma İşlemleri",
            "AracIslem" => "Araç İşlemleri",
            "KullaniciIslem" => "Kullanıcı İşlemleri",
            "TurIslem" => "Tur İşlemleri",
            "BakiyeIslem" => "Bakiye İşlemleri",
            "BolgeIslem" => "Bölge İşlemleri",
            "KurumIslem" => "Kurum İşlemleri",
            "LokasyonSorgu" => "Lokasyon Sorgusu",
            "Duyuru" => "Duyurular",
            "Mesaj" => "Mesajlar",
            "Rapor" => "Raporlar",
            "Search" => "Arama",
            "CikisYap" => "Çıkış Yap",
            "Firmaİslem" => "Firma İşlemleri",
            "FirmaBilgi" => "Firma Bilgileri",
            "İslemler" => "İşlemler",
            "AnaMenuDon" => "Ana Menüye Dön",
            "Duzenle" => "Düzenle",
            "GenelBilgi" => "Genel Bilgiler",
            "FirmaKodu" => "Firma Kodu",
            "FirmaAdı" => "Firma Adı",
            "Aciklama" => "Açıklama",
            "Durum" => "Durum",
            "Aktif" => "Aktif",
            "Pasif" => "Pasif",
            "OgrenciServisi" => "Öğrenci Servisi",
            "PersonelServisi" => "Personel Servisi",
            "Iletisim" => "İletişim Bilgileri",
            "Adres" => "Adres",
            "Il" => "İl",
            "Ulke" => "Ülke",
            "Ilce" => "İlçe",
            "Semt" => "Semt",
            "Mahalle" => "Mahalle",
            "CaddeSokak" => "Cadde / Sokak",
            "PostaKodu" => "Posta Kodu",
            "CaddeNo" => "Cadde No",
            "Telefon" => "Telefon",
            "Email" => "Email",
            "WebSite" => "Web Sitesi",
            "Lokasyon" => "Lokasyon",
            "KonumuKaydet" => "Konumu Kaydet",
            "Vazgec" => "Vazgeç",
            "Kaydet" => "Kaydet",
            "Toplam" => "Toplam",
            "Odenmemis" => "Ödenmemiş",
            "AktifServis" => "Aktif Servis",
            "Okunmamis" => "Okunmamış",
            "YeniDuyuru" => "Yeni Duyuru",
            "YeniRapor" => "Yeni Rapor",
            "GuvenliCikis" => "Güvenli Çıkış",
            "Profil" => "Profil",
            "Bolgeler" => "Bölgeler",
            "BolgeListe" => "Bölge Listesi",
            "Kurumlar" => "Kurumlar",
            "KurumListe" => "Kurum Listesi",
            "AracListe" => "Araç Listesi",
            "BolgeAd" => "Bölge Adı",
            "BolgeKurumSayi" => "Kurum Sayısı",
            "BolgeTurSayi" => "Araç Listesi",
            "BolgeMusteriSayi" => "Müşteri / Yolcu Sayısı",
            "BolgeYeni" => "Yeni Bölge",
            "Detay" => "Detaylar",
            "Sil" => "Sil",
            "BolgeTanimlama" => "Bölge Tanımlama",
            "KurumTanimlama" => "Kurum Tanımlama",
            "KurumAdi" => "Kurum",
            "BolgeDetay" => "Bölge Detayları",
            "YeniEkle" => "Yeni Ekle",
            "TumunuGor" => "Tümünü Gör",
            "AdresDetay" => "Adres Detayları",
            "LokasyonTanimlama" => "Lokasyon Tanımlama",
            "KurumYeni" => "Yeni Kurum",
            "TurSayi" => "Tur Sayısı",
            "KurumDetay" => "Kurum Detayları",
            "Bolge" => "Bölge",
            "Turlar" => "Turlar",
            "TurAdi" => "Tur Adı",
            "BolgeAdi" => "Bölge",
            "Toplam" => "Toplam",
            "LoginNotification" => "Hesabiniza giris yapilmistir.",
            "Araclar" => "Araç",
            "Plaka" => "Plaka",
            "Marka" => "Marka",
            "ModelYil" => "Model Yılı",
            "AracKm" => "Araç Km",
            "Kapasite" => "Kapasite",
            "YeniArac" => "Yeni Araç",
            "AracTanimlama" => "Araç Tanımlama",
            "Surucu" => "Sürücü",
            "AracDetay" => "Araç Detayları",
            "TurListe" => "Tur Listesi",
            "Tür" => "Türü",
            "Kurum" => "Kurum",
            "KurumEkle" => "Kurum Ekle",
            "KullaniciPanel" => "Kullanıcı Paneli",
            "Adi" => "Adı",
            "Soyadi" => "Soyadı",
            "YeniAdmin" => "Yeni Admin",
            "AdminTanimlama" => "Admin Tanimlama",
            "AdminDetay" => "Admin Detaylari",
            "YeniSofor" => "Yeni Şoför",
            "YeniHostes" => "Yeni Hostes",
            "SoforTanimlama" => "Şoför Tanimlama",
            "HostesTanimlama" => "Hostes Tanimlama",
            "SoforAdi" => "Şoför Adi",
            "SoforDetay" => "Şoför Detayları",
            "HostesDetay" => "Hostes Detayları",
            "Arac" => "Araçlar",
            "YeniIsci" => "Yeni İşçi",
            "IsciTanimlama" => "İşçi Tanimlama",
            "Kurumlar" => "Kurumlar",
            "IsciDetay" => "İşçi Detayları",
            "YeniVeli" => "Yeni Veli",
            "VeliTanimlama" => "Veli Tanimlama",
            "Ogrenciler" => "Öğrenciler",
            "VeliDetay" => "Veli Detayları",
            "OgrenciDetay" => "Öğrenci Detayları",
            "YeniOgrenci" => "Yeni Öğrenci",
            "OgrenciTanimlama" => "Öğrenci Tanimlama",
            "Veliler" => "Veliler",
            "TurYeni" => "Yeni Tur",
            "KurumTip" => "Kurum Tip",
            "TurListe" => "Tur Listesi",
            "TurTanimlama" => "Tur Tanımlama",
            "Gunler" => "Günler",
            "Pazartesi" => "Pazartesi",
            "Sali" => "Salı",
            "Carsamba" => "Çarsamba",
            "Persembe" => "Perşembe",
            "Cuma" => "Cuma",
            "Cumartesi" => "Cumartesi",
            "Pazar" => "Pazar",
            "BasSaat" => "Başlangıç Saati",
            "BitSaat" => "Bitiş Saati",
            "Gidis" => "Gidiş",
            "Donus" => "Dönüş",
            "Seciniz" => "Seçiniz",
            "HaritaGor" => "Haritada Gör",
            "OgrenciPersonel" => "Öğrenci-Personel",
            "AdresBilgi" => "Adres Bilgileri",
            "TurAnimasyon" => "Animasyon Oynat",
            "ToplamKm" => "Toplam Km",
            "TurSecim" => "Tur Detayları",
            "TurGidis" => "Tur Gidiş",
            "TurDonus" => "Tur Dönüş",
            "OgrenciPersonel" => "Öğrenci/Personel",
            "AracLokasyon" => "Araç Lokasyon",
            "TurKurum" => "Tur Kurum",
            "TurBolge" => "Tur Bölge",
            "TurKm" => "Tur Km",
            "AracKapasite" => "Araç Kapasite",
            "TurKisi" => "Tur Kişi",
            "HesapIslem" => "Hesap İşlemleri",
            "Bildirimler" => "Bildirimler",
            "TumunuGor" => "Tümünü Göster",
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
            "AracSilme" => " Aracını Sildi.",
            "AracSil" => "Araç Silme.",
            "AracEkleme" => " Aracını Ekledi.",
            "AracEkle" => "Araç Ekleme.",
            "AracDuzenleme" => " Aracını Düzenledi.",
            "AracDuzen" => "Araç Düzenleme",
            "TurSilme" => " Turunu Sildi.",
            "TurSil" => "Tur Silme.",
            "TurEkleme" => " Turunu Ekledi.",
            "TurEkle" => "Tur Ekleme.",
            "TurDuzenleme" => " Turunu Düzenledi.",
            "TurDuzen" => "Tur Düzenleme",
            "TurAtama" => " Turuna Ekledi.",
            "TurAta" => "Tur Atama",
            "TurGidisAtama" => " Gidiş Turuna Ekledi.",
            "TurDonusAtama" => " Dönüş Turuna Ekledi.",
            "TurGidisDuzenleme" => " Gidiş Turunu Düzenledi.",
            "TurDonusDuzenleme" => " Dönüş Turunu Düzenledi.",
        );
        return $trdil;
    }

}

?>