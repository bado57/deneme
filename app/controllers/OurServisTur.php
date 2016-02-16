<?php

/*
 * Bu webservis günlük saat 12 de çalışacaktır.
 * Ve bu servis aracılıpıyla bsturtip tablosundaki
 * günler deki urun bittiğinin anladığımız kısım içindir.Yani turbittiğinde 1 olan kısımlar
 * bir şkilde 0 olması lazım ki diğer
 * hafta aynı ün tekrar aktif edilebilsin.Bunda da bu servis çalışıp sonrasında 2 gün sonrasındaki o güne ait 1 leri 0 
 * yapmaktadır.2 gün sonrası olmasının sebebi de dünya geneli olmasından kaynaklıdır.Aynı gün yapsak bu sefer aynı
 * gün için başka ülkede saat farkından dolayı 1 gün geçmiş olabilir.O yüzdende 2 sonrasını alıyorum sürekli
 * 
 */

class OurServisTur extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->service();
    }

    public function service() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model_Our");

        $rootDbFirma = $Panel_Model->rootFirmaConnect();

        $a = 0;
        $firmtable = array();
        foreach ($rootDbFirma as $rootDbFirmaa) {
            $firmtable[$a]['Name'] = $rootDbFirmaa['rootFirmaDbName'];
            $firmtable[$a]['Sifre'] = $rootDbFirmaa['rootFirmaDbSifre'];
            $firmtable[$a]['Ip'] = $rootDbFirmaa['rootFirmaDbIp'];
            $firmtable[$a]['User'] = $rootDbFirmaa['rootFirmaDbUser'];
            $a++;
        }
        /*
         * şu anki zamanın tarihini alıp buna iki gün ekliyoruzki turtipleri 
         * düzenlerken default time zone ye göre farklı ülkedeki bi db yi de etkilemeyelim.
         * Eğer iki gün sonrasını almazsak mozambikteki bi ülkede aynı gün yapılan turu da aynı gün için yapılmamış gibi 
         * gösterbilriiz ve bu da sıkıntı doğurur
         */
        $gun = date("D", strtotime("+2 day"));
        switch ($gun) {
            case "Sun":
                $yeniBitis = "SBTurPzrBitis";
                break;
            case "Mon":
                $yeniBitis = "SBTurPztBitis";
                break;
            case "Tue":
                $yeniBitis = "SBTurSliBitis";
                break;
            case "Wed":
                $yeniBitis = "SBTurCrsBitis";
                break;
            case "Thu":
                $yeniBitis = "SBTurPrsBitis";
                break;
            case "Fri":
                $yeniBitis = "SBTurCmaBitis";
                break;
            case "Sat":
                $yeniBitis = "SBTurCmtBitis";
                break;
            default:
                break;
        }

        $size = count($firmtable);
        for ($f = 0; $f < $size; $f++) {
            try {
                $db = new PDO("mysql:host=" . $firmtable[$f]["Ip"] . ";dbname=" . $firmtable[$f]["Name"] . ";charset=utf8", $firmtable[$f]['User'], $firmtable[$f]['Sifre']);
            } catch (PDOException $e) {
                print $e->getMessage();
            }
            $query = $db->prepare("UPDATE bsturtip SET
                    $yeniBitis = :yeni_kadi");
            $update = $query->execute(array(
                "yeni_kadi" => 0
            ));
            if ($update) {
                
            } else {
                $f--;
            }
        }
    }

}

?>