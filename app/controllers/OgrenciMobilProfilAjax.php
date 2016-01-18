<?php

class OgrenciMobilProfilAjax extends Controller {

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

            $form->post("lang", true);
            $lang = $form->values['lang'];

            $formLanguage = $this->load->mobillanguage($lang);
            $languagedeger = $formLanguage->ajaxlanguage();

            $formDbConfig = $this->load->otherClasses('DatabaseConfig');
            $usersselect_model = $this->load->model("AdminSelectDb_Mobil");

            //return database results
            $UserSelectDb = $usersselect_model->adminFirmMobilID($firmId);
            if (count($UserSelectDb) > 0) {
                $SelectdbName = $UserSelectDb[0]['rootFirmaDbName'];
                $SelectdbIp = $UserSelectDb[0]['rootFirmaDbIp'];
                $SelectdbUser = $UserSelectDb[0]['rootFirmaDbUser'];
                $SelectdbPassword = $UserSelectDb[0]['rootFirmaDbSifre'];

                $formDbConfig->configDb($SelectdbName, $SelectdbIp, $SelectdbUser, $SelectdbPassword);

                //model bağlantısı
                $Panel_Model = $this->load->model("Panel_Model_Mobile");

                Switch ($tip) {

                    case "ogrProfilKaydet":
                        $form->post('ogr_id', true);
                        $ogr_id = $form->values['ogr_id'];
                        if (!$ogr_id) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('ad', true);
                            $form->post('soyad', true);
                            $form->post('telefon', true);
                            $form->post('email', true);
                            $form->post('eskiAd', true);
                            $form->post('eskiSoyad', true);
                            $ad = $form->values['ad'];
                            $soyad = $form->values['soyad'];
                            $eskiAd = $form->values['eskiAd'];
                            $eskiSoyad = $form->values['eskiSoyad'];
                            $email = $form->values['email'];
                            $adSoyad = $ad . ' ' . $soyad;

                            $emailValidate = $form->mailControl1($email);
                            if ($emailValidate == 1) {
                                if ($form->submit()) {
                                    $data = array(
                                        'BSOgrenciAd' => $ad,
                                        'BSOgrenciSoyad' => $soyad,
                                        'BSOgrenciPhone' => $form->values['telefon'],
                                        'BSOgrenciEmail' => $email
                                    );
                                }
                                if ($ad != $eskiAd || $soyad != $eskiSoyad) {
                                    $dataDuzenle = array(
                                        'BSGonderenAdSoyad' => $adSoyad
                                    );
                                    $updateduyuru = $Panel_Model->ogrOzellikDuzenle($dataDuzenle, $ogr_id);
                                    $dataDuzenle1 = array(
                                        'BSEkleyenAdSoyad' => $adSoyad
                                    );
                                    $updateduyurulog = $Panel_Model->ogrOzellikDuzenle1($dataDuzenle1, $ogr_id);
                                    $dataDuzenle2 = array(
                                        'BSOgrenciAd' => $adSoyad
                                    );
                                    $updateogrenci = $Panel_Model->ogrOzellikDuzenle2($dataDuzenle2, $ogr_id);
                                    $updatekurum = $Panel_Model->ogrOzellikDuzenle3($dataDuzenle2, $ogr_id);
                                    $updatebolge = $Panel_Model->ogrOzellikDuzenle4($dataDuzenle2, $ogr_id);
                                    $updateogrtur = $Panel_Model->ogrOzellikDuzenle6($dataDuzenle2, $ogr_id);
                                    $dataDuzenle3 = array(
                                        'BSOgrenciIsciAd' => $adSoyad
                                    );
                                    $updateogriscitur = $Panel_Model->ogrOzellikDuzenle5($dataDuzenle3, $ogr_id);
                                }
                                $resultupdate = $Panel_Model->ogrProfilDuzenle($data, $ogr_id);
                                if ($resultupdate) {
                                    $sonuc["update"] = $languagedeger['ProfilGuncelle'];
                                } else {
                                    $sonuc["hata"] = $languagedeger['Hata'];
                                }
                            } else {
                                $sonuc["hata"] = $languagedeger['EmailDogrula'];
                            }
                        }

                        break;
                    case "ogrSifreKaydet":
                        $form->post('ogr_id', true);
                        $ogr_id = $form->values['ogr_id'];

                        if (!$ogr_id) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('eskisifre', true);
                            $form->post('yenisifre', true);
                            $form->post('yenisifretkrar', true);
                            $eskiSifre = $form->values['eskisifre'];
                            $yeniSifre = $form->values['yenisifre'];
                            //$yeniSifreTkrar = $form->values['yenisifretkrar'];

                            $resultSifre = $Panel_Model->ogrSifre($ogr_id);
                            $ogrSifre = $resultSifre[0]['BSOgrenciRSifre'];
                            if ($ogrSifre == $eskiSifre) {
                                $form->post('kadi', true);
                                $userKadi = $form->values['kadi'];
                                $userTip = 5;
                                $adminSifre = $form->userSifreOlustur($userKadi, $yeniSifre, $userTip);
                                $data = array(
                                    'BSOgrenciSifre' => $adminSifre,
                                    'BSOgrenciRSifre' => $yeniSifre
                                );
                                $resultupdate = $Panel_Model->ogrSifreDuzenle($data, $ogr_id);
                                if ($resultupdate) {
                                    $sonuc["update"] = $languagedeger['SifreGuncelle'];
                                } else {
                                    $sonuc["hata"] = $languagedeger['Hata'];
                                }
                            } else {
                                $sonuc["hata"] = $languagedeger['SifreUyusma'];
                            }
                        }

                        break;
                    case "ogrSifreUnuttum":
                        $form->post('ogr_id', true);
                        $ogr_id = $form->values['ogr_id'];
                        if (!$ogr_id) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('email', true);
                            $email = $form->values['email'];

                            $form->post('adSoyad', true);
                            $adSoyad = $form->values['adSoyad'];

                            $resultSifre = $Panel_Model->ogrSifre($ogr_id);
                            $sifre = $resultSifre[0]['BSOgrenciRSifre'];
                            //mail işlemleri
                            $setTitle = $languagedeger['SifreHatirlatma'];
                            $subject = $languagedeger['SUnutMail'];
                            $body = $languagedeger['Merhaba'] . ' ' . $adSoyad . '!<br/>'
                                    . $languagedeger['KullaniciSifre'] . ' = ' . $sifre . '<br/>'
                                    . $languagedeger['IyiGunler'];
                            //kullanıcıya gerekli giriş bilgileri gönderiliyor.
                            $resultMail = $form->sifreHatirlatMail($email, $setTitle, $adSoyad, $subject, $body);
                            if ($resultMail == 1) {
                                $sonuc["sifregonder"] = $languagedeger['SifreMail'];
                            } else {
                                $sonuc["hata"] = $languagedeger['Hata'];
                            }
                        }

                        break;
                    case "ogrHaritaKaydet":
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
                        $ogr_id = $form->values['id'];

                        if (!$ogr_id) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $mapData = array(
                                'BSOgrenciLocation' => $form->values['lokasyon'],
                                'BSOgrenciUlke' => $form->values['ulke'],
                                'BSOgrenciIl' => $form->values['il'],
                                'BSOgrenciIlce' => $form->values['ilce'],
                                'BSOgrenciSemt' => $form->values['semt'],
                                'BSOgrenciMahalle' => $form->values['mahalle'],
                                'BSOgrenciSokak' => $form->values['sokak'],
                                'BSOgrenciPostaKodu' => $form->values['postakodu'],
                                'BSOgrenciCaddeNo' => $form->values['caddeno'],
                                'BSOgrenciDetayAdres' => $form->values['detayAdres']
                            );
                            $resultupdate = $Panel_Model->ogrMapDuzenle($mapData, $ogr_id);
                            if ($resultupdate) {
                                $sonuc["update"] = $languagedeger['HaritaGuncel'];
                            } else {
                                $sonuc["hata"] = $languagedeger['Hata'];
                            }
                        }

                        break;
                }
            } else {
                $sonuc["hata"] = $languagedeger['Hata'];
            }
            echo json_encode($sonuc);
        } else {
            die("Hacklemeye mi Çalışıyorsun pezevenk?");
        }
    }

}
?>

