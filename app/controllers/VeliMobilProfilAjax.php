<?php

class VeliMobilProfilAjax extends Controller {

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

                    case "veliProfilKaydet":
                        $form->post('veli_id', true);
                        $veliID = $form->values['veli_id'];

                        if (!$veliID) {
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
                                        'SBVeliAd' => $ad,
                                        'SBVeliSoyad' => $soyad,
                                        'SBVeliPhone' => $form->values['telefon'],
                                        'SBVeliEmail' => $email
                                    );
                                }
                                if ($ad != $eskiAd || $soyad != $eskiSoyad) {
                                    $dataDuzenle = array(
                                        'BSGonderenAdSoyad' => $adSoyad
                                    );
                                    $updateduyuru = $Panel_Model->veliOzellikDuzenle($dataDuzenle, $veliID);
                                    $dataDuzenle1 = array(
                                        'BSEkleyenAdSoyad' => $adSoyad
                                    );
                                    $updateduyurulog = $Panel_Model->veliOzellikDuzenle1($dataDuzenle1, $veliID);
                                    $dataDuzenle2 = array(
                                        'BSVeliAd' => $adSoyad
                                    );
                                    $updateogrenci = $Panel_Model->veliOzellikDuzenle2($dataDuzenle2, $veliID);
                                    $updatekurum = $Panel_Model->veliOzellikDuzenle3($dataDuzenle2, $veliID);
                                    $updatebolge = $Panel_Model->veliOzellikDuzenle4($dataDuzenle2, $veliID);
                                }
                                $resultupdate = $Panel_Model->veliProfilDuzenle($data, $veliID);
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
                    case "veliSifreKaydet":
                        $form->post('veli_id', true);
                        $veliID = $form->values['veli_id'];

                        if (!$veliID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('eskisifre', true);
                            $form->post('yenisifre', true);
                            $form->post('yenisifretkrar', true);
                            $eskiSifre = $form->values['eskisifre'];
                            $yeniSifre = $form->values['yenisifre'];
                            //$yeniSifreTkrar = $form->values['yenisifretkrar'];

                            $resultSifre = $Panel_Model->veliSifre($veliID);
                            $soforSifre = $resultSifre[0]['SBVeliRSifre'];
                            if ($soforSifre == $eskiSifre) {
                                $form->post('kadi', true);
                                $userKadi = $form->values['kadi'];
                                $userTip = 4;
                                $adminSifre = $form->userSifreOlustur($userKadi, $yeniSifre, $userTip);
                                $data = array(
                                    'SBVeliSifre' => $adminSifre,
                                    'SBVeliRSifre' => $yeniSifre
                                );
                                $resultupdate = $Panel_Model->veliSifreDuzenle($data, $veliID);
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
                    case "veliSifreUnuttum":
                        $form->post('veli_id', true);
                        $veliID = $form->values['veli_id'];
                        if (!$veliID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('email', true);
                            $email = $form->values['email'];

                            $form->post('adSoyad', true);
                            $adSoyad = $form->values['adSoyad'];

                            $resultSifre = $Panel_Model->veliSifre($veliID);
                            $sifre = $resultSifre[0]['SBVeliRSifre'];
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
                    case "veliHaritaKaydet":
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
                        $veliID = $form->values['id'];

                        if (!$veliID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $mapData = array(
                                'SBVeliLocation' => $form->values['lokasyon'],
                                'SBVeliUlke' => $form->values['ulke'],
                                'SBVeliIl' => $form->values['il'],
                                'SBVeliIlce' => $form->values['ilce'],
                                'SBVeliSemt' => $form->values['semt'],
                                'SBVeliMahalle' => $form->values['mahalle'],
                                'SBVeliSokak' => $form->values['sokak'],
                                'SBVeliPostaKodu' => $form->values['postakodu'],
                                'SBVeliCaddeNo' => $form->values['caddeno'],
                                'SBVeliDetayAdres' => $form->values['detayAdres']
                            );
                            $resultupdate = $Panel_Model->veliMapDuzenle($mapData, $veliID);
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

