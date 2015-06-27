<?php

class SoforMobilProfilAjax extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->mobilPage();
    }

    public function mobilPage() {

        if ($_POST) {
            $sonuc = array();

            $form = $this->load->otherClasses('Form');

            $form->post("tip", true);
            $tip = $form->values['tip'];

            //db ye  bağlanma
            $form->post("firma_id", true);
            $firmId = $form->values['firma_id'];

            $formDbConfig = $this->load->otherClasses('DatabaseConfig');
            $usersselect_model = $this->load->model("adminselectdb_mobil");

            //return database results
            $UserSelectDb = $usersselect_model->adminFirmMobilID($firmId);

            $SelectdbName = $UserSelectDb[0]['rootFirmaDbName'];
            $SelectdbIp = $UserSelectDb[0]['rootFirmaDbIp'];
            $SelectdbUser = $UserSelectDb[0]['rootFirmaDbUser'];
            $SelectdbPassword = $UserSelectDb[0]['rootFirmaDbSifre'];


            $formDbConfig->configDb($SelectdbName, $SelectdbIp, $SelectdbUser, $SelectdbPassword);


            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model_mobile");

            Switch ($tip) {

                case "soforProfilKaydet":

                    $form->post('sofor_id', true);
                    $soforID = $form->values['sofor_id'];

                    if (!$soforID) {
                        $sonuc["hata"] = "Hacking?";
                    } else {

                        $form->post('ad', true);
                        $form->post('soyad', true);
                        $form->post('telefon', true);
                        $form->post('email', true);

                        if ($form->submit()) {
                            $data = array(
                                'BSSoforAd' => $form->values['ad'],
                                'BSSoforSoyad' => $form->values['soyad'],
                                'BSSoforPhone' => $form->values['telefon'],
                                'BSSoforEmail' => $form->values['email']
                            );
                        }

                        $resultupdate = $Panel_Model->soforProfilDuzenle($data, $soforID);
                        if ($resultupdate) {
                            $sonuc["update"] = "Başarıyla Profiliniz Güncellenmiştir.";
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    break;

                case "soforSifreKaydet":

                    $form->post("language", true);
                    $lang = $form->values['language'];

                    $formLanguage = $this->load->mobillanguage($lang);
                    $language = $formLanguage->mobillanguage();

                    $form->post('sofor_id', true);
                    $soforID = $form->values['sofor_id'];

                    if (!$soforID) {
                        $sonuc["hata"] = $language['Hata'];
                    } else {
                        $form->post('eskisifre', true);
                        $form->post('yenisifre', true);
                        $form->post('yenisifretkrar', true);
                        $eskiSifre = $form->values['eskisifre'];
                        $yeniSifre = $form->values['yenisifre'];
                        //$yeniSifreTkrar = $form->values['yenisifretkrar'];

                        $resultSifre = $Panel_Model->soforSifre($soforID);
                        $soforSifre = $resultSifre[0]['BSSoforRSifre'];
                        if ($soforSifre == $eskiSifre) {
                            $form->post('kadi', true);
                            $userKadi = $form->values['kadi'];
                            $userTip = 2;
                            $adminSifre = $form->userSifreOlustur($userKadi, $yeniSifre, $userTip);
                            $data = array(
                                'BSSoforSifre' => $adminSifre,
                                'BSSoforRSifre' => $yeniSifre
                            );
                            $resultupdate = $Panel_Model->soforSifreDuzenle($data, $soforID);
                            if ($resultupdate) {
                                $sonuc["update"] = "Başarıyla Şifreniz Güncellenmiştir.";
                            } else {
                                $sonuc["hata"] = $language['Hata'];
                            }
                        } else {
                            $sonuc["hata"] = $language['SifreUyusma'];
                        }
                    }

                    break;

                case "soforSifreUnuttum":

                    $form->post('sofor_id', true);
                    $soforID = $form->values['sofor_id'];

                    if (!$soforID) {
                        $sonuc["hata"] = 'Bir Hata Oluştu';
                    } else {
                        $form->post('email', true);
                        $soforID = $form->values['email'];

                        $resultSifre = $Panel_Model->soforSifre($soforID);
                        $soforSifre = $resultSifre[0]['BSSoforRSifre'];
                        //emaile şire gönderme fonksiyonu burda çalışacak
                        if (true) {
                            $sonuc["update"] = "Başarıyla Şifreniz Güncellenmiştir.";
                        } else {
                            $sonuc["hata"] = $language['Hata'];
                        }
                    }

                    break;

                case "soforHaritaKaydet":

                    $form->post('id', true);
                    $form->post('ulke', true);
                    $form->post('il', true);
                    $form->post('ilce', true);
                    $form->post('semt', true);
                    $form->post('mahalle', true);
                    $form->post('sokak', true);
                    $form->post('postakodu', true);
                    $form->post('caddeno', true);
                    $form->post('lokasyon', true);
                    $form->post('detayAdres', true);
                    $soforID = $form->values['id'];

                    if (!$soforID) {
                        $sonuc["hata"] = 'Bir Hata Oluştu';
                    } else {
                        $mapData = array(
                            'BSSoforLocation' => $form->values['lokasyon'],
                            'BSSoforUlke' => $form->values['ulke'],
                            'BSSoforIl' => $form->values['il'],
                            'BSSoforIlce' => $form->values['ilce'],
                            'BSSoforSemt' => $form->values['semt'],
                            'BSSoforMahalle' => $form->values['mahalle'],
                            'BSSoforSokak' => $form->values['sokak'],
                            'BSSoforPostaKodu' => $form->values['postakodu'],
                            'BSSoforCaddeNo' => $form->values['caddeno'],
                            'BSSoforDetayAdres' => $form->values['detayAdres']
                        );
                        $resultupdate = $Panel_Model->soforMapDuzenle($mapData, $soforID);
                        if ($resultupdate) {
                            $sonuc["update"] = "Başarıyla Harita Bilşgileriniz Güncellenmiştir.";
                        } else {
                            $sonuc["hata"] = $language['Hata'];
                        }
                    }

                    break;
            }
            echo json_encode($sonuc);
        } else {
            die("Hacklemeye mi Çalışıyorsun pezevenk?");
        }
    }

}
?>

