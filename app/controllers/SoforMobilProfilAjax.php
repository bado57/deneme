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

                    case "soforProfilKaydet":

                        $form->post('sofor_id', true);
                        $soforID = $form->values['sofor_id'];

                        if (!$soforID) {
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
                                        'BSSoforAd' => $ad,
                                        'BSSoforSoyad' => $soyad,
                                        'BSSoforPhone' => $form->values['telefon'],
                                        'BSSoforEmail' => $email
                                    );
                                }
                                if ($ad != $eskiAd || $soyad != $eskiSoyad) {
                                    $dataTur = array(
                                        'BSTurSoforAd' => $adSoyad,
                                    );
                                    $dataBolge = array(
                                        'BSSoforAd' => $adSoyad,
                                    );
                                    $dataArac = array(
                                        'BSSoforAd' => $adSoyad,
                                    );

                                    $resultupdate1 = $Panel_Model->soforProfilDuzenle1($dataTur, $soforID);
                                    $resultupdate2 = $Panel_Model->soforProfilDuzenle2($dataBolge, $soforID);
                                    $resultupdate3 = $Panel_Model->soforProfilDuzenle3($dataArac, $soforID);
                                }
                                $resultupdate = $Panel_Model->soforProfilDuzenle($data, $soforID);
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
                    case "soforSifreKaydet":
                        $form->post('sofor_id', true);
                        $soforID = $form->values['sofor_id'];

                        if (!$soforID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
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
                                    $sonuc["update"] = $languagedeger['SifreGuncelle'];
                                } else {
                                    $sonuc["hata"] = $languagedeger['Hata'];
                                }
                            } else {
                                $sonuc["hata"] = $languagedeger['SifreUyusma'];
                            }
                        }

                        break;
                    case "soforSifreUnuttum":
                        $form->post('sofor_id', true);
                        $soforID = $form->values['sofor_id'];

                        if (!$soforID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('email', true);
                            $soforID = $form->values['email'];

                            $form->post('adSoyad', true);
                            $adSoyad = $form->values['adSoyad'];

                            $resultSifre = $Panel_Model->soforSifre($soforID);
                            $sifre = $resultSifre[0]['BSSoforRSifre'];
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
                            $sonuc["hata"] = $languagedeger['Hack'];
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

