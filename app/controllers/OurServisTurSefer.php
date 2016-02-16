<?php

/*
 * Bu webservis hafta da sadece bir defa pazar öğlen çalışackatır.
 * Bu servisin görevi ise haftalık olarka tura gelip gidenlerin takvimini 
 * belirleyen kayını tutan tabloyu temizleyecektir.
 * Tura katılmayacak öğrenciler sefer tablolarına kayıt olur ve her hafta buna göre sistem aktif edilir.
 * Gelmeyecekler çıkarılır sonrasında ise sadece gelecek öğrenciler üzerinden tur aktif
 * edilir.Ama bunu her hafta başı yada hafta içi herhangi bir gün kişiler gelmeyeceği
 * günü değiştirebilir kendi kullanıcı arayüzlerinden.Kaydolan veriler de hafta bittikten sonra 
 * bu servis tarafindan temizlenir.
 * 
 */

class OurServisTurSefer extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->service();
    }

    public function service() {
        //$form = $this->load->otherClasses('Form');
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model_Our");

        $rootDbFirma = $Panel_Model->rootFirmaConnectSefer();

        $a = 0;
        $firmtable = array();
        foreach ($rootDbFirma as $rootDbFirmaa) {
            $firmtable[$a]['Name'] = $rootDbFirmaa['rootFirmaDbName'];
            $firmtable[$a]['Sifre'] = $rootDbFirmaa['rootFirmaDbSifre'];
            $firmtable[$a]['Ip'] = $rootDbFirmaa['rootFirmaDbIp'];
            $firmtable[$a]['User'] = $rootDbFirmaa['rootFirmaDbUser'];
            $firmtable[$a]['Ogr'] = $rootDbFirmaa['rootfirmaOgrServis'];
            $firmtable[$a]['Personel'] = $rootDbFirmaa['rootfirmaPersonelServis'];
            $a++;
        }

        $size = count($firmtable);
        for ($f = 0; $f < $size; $f++) {
            try {
                $db = new PDO("mysql:host=" . $firmtable[$f]["Ip"] . ";dbname=" . $firmtable[$f]["Name"] . ";charset=utf8", $firmtable[$f]['User'], $firmtable[$f]['Sifre']);
            } catch (PDOException $e) {
                print $e->getMessage();
            }
            if ($firmtable[$f]['Ogr'] == 1 && $firmtable[$f]['Personel'] == 1) {//öğrenci servisi ve personel servisi
                $deleteOgr = $db->exec("DELETE FROM bsseferogrenci");
                $deleteOgrIsci = $db->exec("DELETE FROM bsseferogrenciisci");
                $deleteIsci = $db->exec("DELETE FROM bsseferisci");
            } elseif ($firmtable[$f]['Ogr'] == 1) {//öğrenci servisi
                $deleteOgr = $db->exec("DELETE FROM bsseferogrenci");
                $deleteOgrIsci = $db->exec("DELETE FROM bsseferogrenciisci");
            } elseif ($firmtable[$f]['Personel'] == 1) {//personel servisi
                $deleteOgrIsci = $db->exec("DELETE FROM bsseferogrenciisci");
                $deleteIsci = $db->exec("DELETE FROM bsseferisci");
            }
        }
    }

}

?>