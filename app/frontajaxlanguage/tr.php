<?php

class tr {

    public function __construct() {
        
    }

    public function ajaxlanguage() {
        $trdil = array(
            "Hata" => "Bir hata oluştu tekrar deneyiniz.",
            "IsimGir" => "Lütfen isminizi giriniz.",
            "GecerliEmail" => "Lütfen geçerli bir email adresi giriniz.",
            "KullanilirEmail" => "Mailiniz kullanımda değildir. Lütfen başka bir mail deneyiniz.",
            "MesajGir" => "Lütfen mesajınızı giriniz.",
            "MesajSonuc" => "Mesajınız için teşekkür ederiz. Kısa zamanda dönüş yapılacaktır. İyi günler dileriz.",
            "TestSurec" => "Şu an test sürecindedir.Yakın zamanda kullanıma açılacaktır. Lütfen iletişim formundan irtibata geçiniz.",
        );
        return $trdil;
    }

}

?>