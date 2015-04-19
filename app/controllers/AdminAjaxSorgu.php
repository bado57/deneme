<?php

class AdminAjaxSorgu extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->adminAjaxSorgu();
    }

    public function adminAjaxSorgu() {
        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');
        $sessionKey = $form->sessionKontrol();

        if ($_POST && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" && Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey) {
            $sonuc = array();
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            //form class bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");

            $form->post("tip", true);
            $tip = $form->values['tip'];

            Switch ($tip) {

                case "adminfirmaislem":
                    $adminRutbe = Session::get("userRutbe");

                    if ($adminRutbe != 1) {
                        $form->yonlendir("Location:" . SITE_URL_LOGOUT);
                    } else {

                        $data = $form->post('usersloginadi', true);
                        $data = $form->post('usersloginsifre', true);
                        $data = $form->post('usersloginselect', true);
                        if ($form->submit()) {
                            $data = array(
                                ':usersloginadi' => $form->values['usersloginadi'],
                                ':usersloginsifre' => $form->values['usersloginsifre'],
                                ':usersloginselect' => $form->values['usersloginselect']
                            );
                        }
                        $data["UsersLogin"] = $Panel_Model->susersLogin();
                        $sonuc["usersLogin"] = $data["UsersLogin"];
                    }
                    break;

                case "adminFirmaIslemlerKaydet":

                    $adminRutbe = Session::get("userRutbe");

                    if ($adminRutbe != 1) {
                        $form->yonlendir("Location:" . SITE_URL_LOGOUT);
                    } else {

                        $uniqueKey = Session::get("userFirmaKod");
                        $uniqueKey = $uniqueKey . '_AFirma';

                        $form->post('firma_adi', true);
                        $form->post('firma_aciklama', true);
                        $form->post('ogrenci_chechkbox', true);
                        $form->post('personel_chechkbox', true);
                        $form->post('firma_adres', true);
                        $form->post('firma_telefon', true);
                        $form->post('firma_email', true);
                        $form->post('firma_website', true);
                        $form->post('firma_lokasyon', true);

                        $form->post('firmaulke', true);
                        $form->post('firmail', true);
                        $form->post('firmailce', true);
                        $form->post('firmasemt', true);
                        $form->post('firmamahalle', true);
                        $form->post('firmasokak', true);
                        $form->post('firmapostakodu', true);
                        $form->post('firmacaddeno', true);

                        if ($form->submit()) {
                            $data = array(
                                'BSFirmaAdi' => $form->values['firma_adi'],
                                'BSFirmaAdres' => $form->values['firma_adres'],
                                'BSFirmaTelefon' => $form->values['firma_telefon'],
                                'BSFirmaWebsite' => $form->values['firma_website'],
                                'BSFirmaEmail' => $form->values['firma_email'],
                                'BSFirmaLokasyon' => $form->values['firma_lokasyon'],
                                'BSFirmaUlke' => $form->values['firmaulke'],
                                'BSFirmaIl' => $form->values['firmail'],
                                'BSFirmaIlce' => $form->values['firmailce'],
                                'BSFirmaSemt' => $form->values['firmasemt'],
                                'BSFirmaMahalle' => $form->values['firmamahalle'],
                                'BSFirmaSokak' => $form->values['firmasokak'],
                                'BSFirmaPostaKodu' => $form->values['firmapostakodu'],
                                'BSFirmaCaddeNo' => $form->values['firmacaddeno'],
                                'BSFirmaAciklama' => $form->values['firma_aciklama'],
                                'BSOgrenciServis' => $form->values['ogrenci_chechkbox'],
                                'BSPersonelServis' => $form->values['personel_chechkbox'],
                                'BSHesapAktif' => $form->values['hesap_aktif']
                            );
                        }


                        //error_log("Firma Id".$data["FirmaListele"][0]["FirmaID"]);
                        $resultupdate = $Panel_Model->firmaOzelliklerDuzenle($data);

                        //memcache kadetmek için verileri üncellemeden sonra tekrar çekiyoruz.
                        $data["FirmaOzellikler"] = $Panel_Model->firmaOzellikler();


                        $returnModelData = $data['FirmaOzellikler'][0];

                        $a = 0;
                        foreach ($returnModelData as $key => $value) {
                            $new_array['Firmasshkey'][$a] = md5(sha1(md5($key)));
                            $a++;
                        }
                        $returnFormdata['FirmaOzellikler'] = $form->newKeys($data['FirmaOzellikler'][0], $new_array['Firmasshkey']);


                        if ($resultupdate) {
                            $resultMemcache = $MemcacheModel->get($uniqueKey);

                            if ($resultMemcache) {
                                $MemcacheModel->replace($uniqueKey, $returnFormdata['FirmaOzellikler'], false, 10);
                            } else {
                                $result = $MemcacheModel->set($uniqueKey, $returnFormdata['FirmaOzellikler'], false, 10);
                            }
                            $sonuc["update"] = "Başarıyla güncellenmiştir";
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    break;

                case "adminBolgeYeniKaydet":

                    $adminID = Session::get("userId");
                    $adminRutbe = Session::get("userRutbe");
                    $uniqueKey = Session::get("username");
                    $uniqueKey = $uniqueKey . '_ABolge';

                    if (!$adminID) {
                        $form->yonlendir(SITE_URL_LOGOUT);
                    } else {

                        $form->post('bolge_adi', true);
                        $form->post('bolge_aciklama', true);

                        if ($form->submit()) {
                            $data = array(
                                'SBBolgeAdi' => $form->values['bolge_adi'],
                                'SBBolgeAciklama' => $form->values['bolge_aciklama']
                            );
                        }

                        $resultuID = $Panel_Model->addNewAdminBolge($data);

                        if ($resultuID) {
                            $dataID = array(
                                'BSAdminID' => $adminID,
                                'BSBolgeID' => $resultuID
                            );
                            $resultIDD = $Panel_Model->addAdminBolge($dataID);
                            if ($resultIDD) {
                                $resultMemcache = $MemcacheModel->get($uniqueKey);
                                if ($resultMemcache) {
                                    $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                }
                                $sonuc["newBolgeID"] = $resultIDD;
                                $sonuc["insert"] = "Başarıyla Yeni bölge Eklenmiştir.";
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    break;

                case "adminBolgeDetail":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {

                        $form->post('adminbolgeRowid', true);
                        $adminBolgeDetailID = $form->values['adminbolgeRowid'];

                        $data["adminBolgeDetail"] = $Panel_Model->adminBolgeDetail($adminBolgeDetailID);

                        $returnModelData = $data["adminBolgeDetail"][0];

                        $a = 0;
                        foreach ($returnModelData as $key => $value) {
                            $new_array['AdminBolgesshkey'][$a] = md5(sha1(md5($key)));
                            $a++;
                        }

                        $returnFormdata['adminBolgeDetail'] = $form->newKeys($data["adminBolgeDetail"][0], $new_array['AdminBolgesshkey']);


                        $data["adminBolgeKurumDetail"] = $Panel_Model->adminBolgeKurumDetail($adminBolgeDetailID);
                        $kurum = 0;
                        foreach ($data["adminBolgeKurumDetail"] as $kurumdetail) {
                            $data["adminBolgeKurum"][$kurum] = array_values($kurumdetail);
                            $kurum++;
                        }

                        $sonuc["adminBolgeDetail"] = $returnFormdata['adminBolgeDetail'];
                        $sonuc["adminBolgeKurumDetail"] = $data["adminBolgeKurum"];
                    }

                    break;

                case "adminBolgeDetailDuzenle":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {

                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_ABolge';

                        $form->post('bolgedetail_adi', true);
                        $form->post('bolgedetail_aciklama', true);
                        $form->post('bolgedetail_id', true);
                        $adminBolgeDetailID = $form->values['bolgedetail_id'];

                        if ($form->submit()) {
                            $data = array(
                                'SBBolgeAdi' => $form->values['bolgedetail_adi'],
                                'SBBolgeAciklama' => $form->values['bolgedetail_aciklama']
                            );
                        }

                        $resultupdate = $Panel_Model->adminBolgeOzelliklerDuzenle($data, $adminBolgeDetailID);
                        if ($resultupdate) {
                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                            if ($resultMemcache) {
                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                            }
                            $sonuc["update"] = "Başarıyla Bölgeniz Güncellenmiştir.";
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    break;

                case "adminBolgeDetailDelete":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_ABolge';

                        $form->post('bolgedetail_id', true);
                        $adminBolgeDetailID = $form->values['bolgedetail_id'];

                        $deleteresult = $Panel_Model->adminBolgeDelete($adminBolgeDetailID);
                        if ($deleteresult) {
                            $resultdelete = $Panel_Model->adminBolgeIDDelete($adminBolgeDetailID);
                            if ($resultdelete) {
                                $resultMemcache = $MemcacheModel->get($uniqueKey);
                                if ($resultMemcache) {
                                    $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                }
                                $sonuc["delete"] = "Bölge kaydı başarıyla silinmiştir.";
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }


                        $sonuc["adminBolgeDetail"] = $data["adminBolgeDetail"];
                    }

                    break;

                case "adminBolgeKurumKaydet":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_ABolge';

                        $form->post('bolgeid', true);
                        $form->post('bolgead', true);
                        $form->post('bolgkurumadi', true);
                        $form->post('bolgkurumTlfn', true);
                        $form->post('bolgkurumEmail', true);
                        $form->post('bolgkurumwebsite', true);
                        $form->post('bolgkurumadrsDty', true);
                        $form->post('bolgkurumaciklama', true);
                        $form->post('bolgkurumulke', true);
                        $form->post('bolgkurumil', true);
                        $form->post('bolgkurumilce', true);
                        $form->post('bolgkurumsemt', true);
                        $form->post('bolgkurummahalle', true);
                        $form->post('bolgkurumsokak', true);
                        $form->post('bolgkurumpostakodu', true);
                        $form->post('bolgkurumcaddeno', true);
                        $form->post('bolgkurumlocation', true);

                        if ($form->submit()) {
                            $data = array(
                                'SBKurumAdi' => $form->values['bolgkurumadi'],
                                'SBKurumAciklama' => $form->values['bolgkurumaciklama'],
                                'SBBolgeID' => $form->values['bolgeid'],
                                'SBBolgeAdi' => $form->values['bolgead'],
                                'SBKurumUlke' => $form->values['bolgkurumulke'],
                                'SBKurumIl' => $form->values['bolgkurumil'],
                                'SBKurumIlce' => $form->values['bolgkurumilce'],
                                'SBKurumSemt' => $form->values['bolgkurumsemt'],
                                'SBKurumMahalle' => $form->values['bolgkurummahalle'],
                                'SBKurumSokak' => $form->values['bolgkurumsokak'],
                                'SBKurumLokasyon' => $form->values['bolgkurumlocation'],
                                'SBKurumTelefon' => $form->values['bolgkurumTlfn'],
                                'SBKurumAdres' => $form->values['bolgkurumadrsDty'],
                                'SBKurumEmail' => $form->values['bolgkurumEmail'],
                                'SBKurumWebsite' => $form->values['bolgkurumwebsite'],
                                'SBKurumPostaKodu' => $form->values['bolgkurumpostakodu'],
                                'SBKurumCaddeNo' => $form->values['bolgkurumcaddeno']
                            );
                        }

                        $resultKurumID = $Panel_Model->addNewAdminBolgeKurum($data);

                        if ($resultKurumID) {
                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                            if ($resultMemcache) {
                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                            }
                            $sonuc["newBolgeKurumID"] = $resultKurumID;
                            $sonuc["insert"] = "Başarıyla Bölgenize yeni Kurum Eklenmiştir.";
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    break;

                case "adminKurumDetail":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {

                        $form->post('adminkurumRowid', true);
                        $adminKurumDetailID = $form->values['adminkurumRowid'];

                        $data["adminKurumDetail"] = $Panel_Model->adminKurumDetail($adminKurumDetailID);

                        $returnModelData = $data["adminKurumDetail"][0];

                        $a = 0;
                        foreach ($returnModelData as $key => $value) {
                            $new_array['AdminKurumsshkey'][$a] = md5(sha1(md5($key)));
                            $a++;
                        }

                        $returnFormdata['adminKurumDetail'] = $form->newKeys($data["adminKurumDetail"][0], $new_array['AdminKurumsshkey']);


                        $adminKurumTurDetail = $Panel_Model->adminKurumTurDetail($adminKurumDetailID);

                        //arac detail tur
                        $b = 0;
                        foreach ($adminKurumTurDetail as $adminKurumTurDetaill) {
                            $kurumDetailTur[$b]['KurumTurID'] = $adminKurumTurDetaill['SBTurID'];
                            $kurumDetailTur[$b]['KurumDetailTurAdi'] = $adminKurumTurDetaill['SBTurAdi'];
                            $kurumDetailTur[$b]['KurumTurAktiflik'] = $adminKurumTurDetaill['SBTurAktiflik'];
                            $kurumDetailTur[$b]['KurumTurTip'] = $adminKurumTurDetaill['SBTurType'];
                            $kurumDetailTur[$b]['KurumTurAcikla'] = $adminKurumTurDetaill['SBTurAciklama'];
                            $b++;
                        }

                        $sonuc["adminKurumDetail"] = $returnFormdata['adminKurumDetail'];
                        $sonuc["adminKurumTurDetail"] = $kurumDetailTur;
                    }

                    break;

                case "adminKurumDetailDelete":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AKurum';


                        $form->post('kurumdetail_id', true);
                        $adminKurumDetailID = $form->values['kurumdetail_id'];

                        $deleteresult = $Panel_Model->adminKurumDelete($adminKurumDetailID);
                        if ($deleteresult) {
                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                            if ($resultMemcache) {
                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                            }
                            $sonuc["delete"] = "Kurum kaydı başarıyla silinmiştir.";
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    $sonuc["adminKurumDetail"] = $data["adminKurumDetail"];

                    break;

                case "adminKurumDetailDuzenle":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {

                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AKurum';

                        $form->post('kurumdetail_adi', true);
                        $form->post('kurumdetail_bolge', true);
                        $form->post('kurumdetail_telefon', true);
                        $form->post('kurumdetail_email', true);
                        $form->post('kurumdetail_adres', true);
                        $form->post('kurumdetail_aciklama', true);

                        $form->post('kurumdetail_id', true);
                        $adminKurumDetailID = $form->values['kurumdetail_id'];

                        if ($form->submit()) {
                            $data = array(
                                'SBKurumAdi' => $form->values['kurumdetail_adi'],
                                'SBKurumAciklama' => $form->values['kurumdetail_aciklama'],
                                'SBBolgeAdi' => $form->values['kurumdetail_bolge'],
                                'SBKurumTelefon' => $form->values['kurumdetail_telefon'],
                                'SBKurumAdres' => $form->values['kurumdetail_adres'],
                                'SBKurumEmail' => $form->values['kurumdetail_email']
                            );
                        }
                        $resultupdate = $Panel_Model->adminKurumOzelliklerDuzenle($data, $adminKurumDetailID);
                        if ($resultupdate) {
                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                            if ($resultMemcache) {
                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                            }
                            $sonuc["update"] = "Başarıyla Kurum Bilgileriniz Güncellenmiştir.";
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    break;
                case "adminKurumSelectBolge":
                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //super adminse tüm bölgeler çekilir
                        if ($adminRutbe != 0) {
                            $bolgeListe = $Panel_Model->kurumBolgeListele();

                            $kurumbolge = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$kurumbolge] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$kurumbolge] = $bolgelist['SBBolgeID'];
                                $kurumbolge++;
                            }
                        } else {//değilse admin ıd ye göre bölge görür
                            $bolgeListeRutbe = $Panel_Model->adminKurumBolgeListele($adminID);

                            foreach ($bolgeListeRutbe as $rutbe) {
                                $bolgerutbeId[] = $rutbe['BSBolgeID'];
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);


                            $bolgeListe = $Panel_Model->adminRutbeKurumBolgeListele($rutbebolgedizi);

                            $kurumbolge = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$kurumbolge] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$kurumbolge] = $bolgelist['SBBolgeID'];
                                $kurumbolge++;
                            }
                        }

                        $sonuc["adminKurumBolge"] = $adminBolge['AdminBolge'];
                        $sonuc["adminKurumBolgee"] = $adminBolge['AdminBolgeID'];
                    }
                    break;

                case "adminKurumKaydet":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AKurum';

                        $form->post('kurumadi', true);
                        $form->post('bolgead', true);
                        $form->post('bolgeId', true);
                        $form->post('kurumlocation', true);
                        $form->post('kurumTlfn', true);
                        $form->post('kurumEmail', true);
                        $form->post('kurumwebsite', true);
                        $form->post('kurumadrsDty', true);
                        $form->post('kurumaciklama', true);
                        $form->post('kurumulke', true);
                        $form->post('kurumil', true);
                        $form->post('kurumilce', true);
                        $form->post('kurumsemt', true);
                        $form->post('kurummahalle', true);
                        $form->post('kurumsokak', true);
                        $form->post('kurumpostakodu', true);
                        $form->post('kurumcaddeno', true);


                        if ($form->submit()) {
                            $data = array(
                                'SBKurumAdi' => $form->values['kurumadi'],
                                'SBKurumAciklama' => $form->values['kurumaciklama'],
                                'SBBolgeID' => $form->values['bolgeId'],
                                'SBBolgeAdi' => $form->values['bolgead'],
                                'SBKurumUlke' => $form->values['kurumulke'],
                                'SBKurumIl' => $form->values['kurumil'],
                                'SBKurumIlce' => $form->values['kurumilce'],
                                'SBKurumSemt' => $form->values['kurumsemt'],
                                'SBKurumMahalle' => $form->values['kurummahalle'],
                                'SBKurumSokak' => $form->values['kurumsokak'],
                                'SBKurumLokasyon' => $form->values['kurumlocation'],
                                'SBKurumTelefon' => $form->values['kurumTlfn'],
                                'SBKurumAdres' => $form->values['kurumadrsDty'],
                                'SBKurumEmail' => $form->values['kurumEmail'],
                                'SBKurumWebsite' => $form->values['kurumwebsite'],
                                'SBKurumPostaKodu' => $form->values['kurumpostakodu'],
                                'SBKurumCaddeNo' => $form->values['kurumcaddeno']
                            );
                        }

                        $resultKurumID = $Panel_Model->addNewAdminKurum($data);

                        if ($resultKurumID) {
                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                            if ($resultMemcache) {
                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                            }
                            $sonuc["newKurumID"] = $resultKurumID;
                            $sonuc["insert"] = "Başarıyla Kurum Eklenmiştir.";
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                case "adminAracEkleSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //super adminse tüm bölgeler çekilir
                        if ($adminRutbe != 0) {
                            //bölgeleri getirir
                            $bolgeListe = $Panel_Model->aracBolgeListele();

                            $a = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$a] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$a] = $bolgelist['SBBolgeID'];
                                $a++;
                            }

                            //şöforlar için
                            $soforListe = $Panel_Model->aracSoforListele();

                            $b = 0;
                            foreach ($soforListe as $soforlist) {
                                $adminSofor['AdminSoforID'][$b] = $soforlist['BSSoforID'];
                                $adminSofor['AdminSoforAd'][$b] = $soforlist['BSSoforAd'];
                                $adminSofor['AdminSoforSoyad'][$b] = $soforlist['BSSoforSoyad'];
                                $b++;
                            }
                        } else {//değilse admin ıd ye göre bölge görür
                            $bolgeListeRutbe = $Panel_Model->adminAracBolgeListele($adminID);

                            foreach ($bolgeListeRutbe as $rutbe) {
                                $bolgerutbeId[] = $rutbe['BSBolgeID'];
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);

                            //rütbeye göre bölge listele
                            $bolgeListe = $Panel_Model->adminRutbeAracBolgeListele($rutbebolgedizi);

                            $a = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$a] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$a] = $bolgelist['SBBolgeID'];
                                $a++;
                            }

                            //rütbeye göre şoför listele
                            $soforIDListe = $Panel_Model->adminRutbeSoforIDListele($rutbebolgedizi);

                            $b = 0;
                            foreach ($soforIDListe as $soforIDlist) {
                                $bolgesoforId[] = $soforIDlist['BSSoforID'];
                                $b++;
                            }
                            $rutbesofordizi = implode(',', $bolgesoforId);

                            //rütbeye göre şoför listele
                            $soforListe = $Panel_Model->adminRutbeSoforListele($rutbesofordizi);

                            $c = 0;
                            foreach ($soforListe as $soforlist) {
                                $adminSofor['AdminSoforID'][$c] = $soforlist['BSSoforID'];
                                $adminSofor['AdminSoforAd'][$c] = $soforlist['BSSoforAd'];
                                $adminSofor['AdminSoforSoyad'][$c] = $soforlist['BSSoforSoyad'];
                                $c++;
                            }
                        }

                        $sonuc["adminAracBolge"] = $adminBolge;
                        $sonuc["adminAracSofor"] = $adminSofor;
                    }
                    break;

                    break;

                case "adminAracKaydet":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AArac';

                        $form->post('aracPlaka', true);
                        $form->post('aracMarka', true);
                        $form->post('aracModelYil', true);
                        $form->post('aracKapasite', true);
                        $form->post('aracAciklama', true);
                        $form->post('aracDurum', true);
                        $aracSoforID = $_REQUEST['aracSoforID'];
                        $aracSoforAd = $_REQUEST['aracSoforAd'];
                        $aracBolgeAd = $_REQUEST['aracBolgeAd'];
                        $aracBolgeID = $_REQUEST['aracBolgeID'];

                        if ($form->submit()) {
                            $data = array(
                                'SBAracMarka' => $form->values['aracMarka'],
                                'SBAracModelYili' => $form->values['aracModelYil'],
                                'SBAracPlaka' => $form->values['aracPlaka'],
                                'SBAracKapasite' => $form->values['aracKapasite'],
                                'SBAracKm' => 0,
                                'SBAracAciklama' => $form->values['aracAciklama'],
                                'SBAracDurum' => $form->values['aracDurum']
                            );
                        }
                        $resultAracID = $Panel_Model->addNewAdminArac($data);

                        if ($resultAracID) {

                            $soforID = count($aracSoforID);
                            for ($a = 0; $a < $soforID; $a++) {
                                $sofordata[$a] = array(
                                    'BSAracID' => $resultAracID,
                                    'BSSoforID' => $aracSoforID[$a],
                                    'BSSoforAd' => $aracSoforAd[$a]
                                );
                            }
                            $resultSoforID = $Panel_Model->addNewAdminAracSofor($sofordata);
                            if ($resultSoforID) {
                                $bolgeID = count($aracBolgeID);
                                for ($b = 0; $b < $bolgeID; $b++) {
                                    $bolgedata[$b] = array(
                                        'SBAracID' => $resultAracID,
                                        'SBBolgeID' => $aracBolgeID[$b],
                                        'SBBolgeAdi' => $aracBolgeAd[$b]
                                    );
                                }
                                $resultBolgeID = $Panel_Model->addNewAdminBolgeSofor($bolgedata);
                                if ($resultBolgeID) {
                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                    if ($resultMemcache) {
                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                    }

                                    $sonuc["newAracID"] = $resultAracID;
                                    $sonuc["insert"] = "Başarıyla Araç Eklenmiştir.";
                                } else {
                                    //arac şofor kaydedilirken bi hata meydana geldi ise
                                    $deleteresult = $Panel_Model->adminAracDelete($resultAracID);

                                    $deleteresultt = $Panel_Model->adminAracSoforDelete($resultAracID);
                                    //arac şofmr kaydedilirken bi hata meydana geldi ise
                                    if ($deleteresultt) {
                                        $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                    }
                                }
                            } else {
                                $deleteresult = $Panel_Model->adminAracDelete($resultAracID);
                                //arac şofmr kaydedilirken bi hata meydana geldi ise
                                if ($deleteresult) {
                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                }
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                case "adminAracDetail":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //superadminse
                        if ($adminRutbe != 0) {
                            $form->post('adminaracRowid', true);
                            $adminAracDetailID = $form->values['adminaracRowid'];

                            $adminAracBolge = $Panel_Model->adminDetailAracBolge($adminAracDetailID);
                            //arac bölge idler
                            $a = 0;
                            foreach ($adminAracBolge as $aracBolge) {
                                $selectAracBolge[$a]['SelectAracBolgeID'] = $aracBolge['SBBolgeID'];
                                $selectAracBolge[$a]['SelectAracBolgeAdi'] = $aracBolge['SBBolgeAdi'];
                                $aracbolgeId[] = $aracBolge['SBBolgeID'];
                                $a++;
                            }
                            //aracın turu var mı yokmu
                            $adminAracTur = $Panel_Model->adminDetailAracTur($adminAracDetailID);
                            //arac bölge idler
                            $z = 0;
                            foreach ($adminAracTur as $adminAracTurr) {
                                $selectAracTur[$z]['SelectAracTur'] = $adminAracTurr['SBTurAktiflik'];
                                $z++;
                            }

                            $aracbolgedizi = implode(',', $aracbolgeId);
                            //aracın bolgesi dışındakiler
                            $digerBolge = $Panel_Model->adminDetailAracSBolge($aracbolgedizi);
                            //arac diğer bölgeler
                            $b = 0;
                            foreach ($digerBolge as $digerBolgee) {
                                $digerAracBolge[$b]['DigerAracBolgeID'] = $digerBolgee['SBBolgeID'];
                                $digerAracBolge[$b]['DigerAracBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                $b++;
                            }

                            //admin araç seçili şoför
                            $adminAracSofor = $Panel_Model->adminDetailAracSofor($adminAracDetailID);
                            //arac Şofor idler
                            $c = 0;
                            foreach ($adminAracSofor as $adminAracSoforr) {
                                $selectAracSofor[$c]['SelectAracSoforID'] = $adminAracSoforr['BSSoforID'];
                                $selectAracSofor[$c]['SelectAracSoforAdi'] = $adminAracSoforr['BSSoforAd'];
                                $aracsoforId[] = $adminAracSoforr['BSSoforID'];
                                $c++;
                            }
                            $aracsofordizi = implode(',', $aracsoforId);
                            //aracın şoforü dışındakiler
                            $digerSofor = $Panel_Model->adminDetailAracSSofor($aracsofordizi);
                            //arac diğer şoförler
                            $d = 0;
                            foreach ($digerSofor as $digerSoforr) {
                                $digerAracSofor[$d]['DigerAracSoforID'] = $digerSoforr['BSSoforID'];
                                $digerAracSofor[$d]['DigerAracSoforAdi'] = $digerSoforr['BSSoforAd'];
                                $digerAracSofor[$d]['DigerAracSoforSoyad'] = $digerSoforr['BSSoforSoyad'];
                                $d++;
                            }

                            //araç Özellikleri
                            $aracOzellik = $Panel_Model->adminDetailAracOzellik($adminAracDetailID);
                            $e = 0;
                            foreach ($aracOzellik as $aracOzellikk) {
                                $adminAracDetail[$e]['AdminAracID'] = $aracOzellikk['SBAracID'];
                                $adminAracDetail[$e]['AdminAracPlaka'] = $aracOzellikk['SBAracPlaka'];
                                $adminAracDetail[$e]['AdminAracMarka'] = $aracOzellikk['SBAracMarka'];
                                $adminAracDetail[$e]['AdminAracYil'] = $aracOzellikk['SBAracModelYili'];
                                $adminAracDetail[$e]['AdminAracKapasite'] = $aracOzellikk['SBAracKapasite'];
                                $adminAracDetail[$e]['AdminAracKm'] = $aracOzellikk['SBAracKm'];
                                $adminAracDetail[$e]['AdminAracDurum'] = $aracOzellikk['SBAracDurum'];
                                $adminAracDetail[$e]['AdminAracAciklama'] = $aracOzellikk['SBAracAciklama'];
                                $e++;
                            }
                        } else {
                            $adminID = Session::get("userId");
                            //normal adminse
                            $form->post('adminaracRowid', true);
                            $adminAracDetailID = $form->values['adminaracRowid'];

                            //küçük adminin olan bölgeleri
                            $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                            //bölge idler
                            $r = 0;
                            foreach ($bolgeListeRutbe as $bolgeListeRutbee) {
                                $bolgerutbeId[] = $bolgeListeRutbee['BSBolgeID'];
                                $r++;
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);

                            //aracın turu var mı yokmu
                            $adminAracTur = $Panel_Model->adminDetailRutbeAracTur($rutbebolgedizi, $adminAracDetailID);
                            //arac bölge idler
                            $z = 0;
                            foreach ($adminAracTur as $adminAracTurr) {
                                $selectAracTur[$z]['SelectAracTur'] = $adminAracTurr['SBTurAktiflik'];
                                $z++;
                            }

                            $adminAracBolge = $Panel_Model->adminDetailAracBolge($adminAracDetailID);
                            //arac bölge idler
                            $a = 0;
                            foreach ($adminAracBolge as $adminAracBolgee) {
                                $selectAracBolge[$a]['SelectAracBolgeID'] = $adminAracBolgee['SBBolgeID'];
                                $selectAracBolge[$a]['SelectAracBolgeAdi'] = $adminAracBolgee['SBBolgeAdi'];
                                $aracbolgeId[] = $adminAracBolgee['SBBolgeID'];
                                $a++;
                            }

                            //küçük admine göre farkını alıp, select olmayan bölgeleri çıkarıyoruz
                            $bolgefark = array_diff($bolgerutbeId, $aracbolgeId);
                            $bolgefarkk = implode(',', $bolgefark);

                            //aracın bolgesi dışındakiler
                            $digerBolge = $Panel_Model->adminRutbeDetailAracSBolge($bolgefarkk);
                            //arac diğer bölgeler
                            $b = 0;
                            foreach ($digerBolge as $digerBolgee) {
                                $digerAracBolge[$b]['DigerAracBolgeID'] = $digerBolgee['SBBolgeID'];
                                $digerAracBolge[$b]['DigerAracBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                $b++;
                            }
                            //admin araç seçili şoför
                            $adminAracSofor = $Panel_Model->adminDetailAracSofor($adminAracDetailID);
                            //arac Şofor idler
                            $c = 0;
                            foreach ($adminAracSofor as $adminAracSoforr) {
                                $selectAracSofor[$c]['SelectAracSoforID'] = $adminAracSoforr['BSSoforID'];
                                $selectAracSofor[$c]['SelectAracSoforAdi'] = $adminAracSoforr['BSSoforAd'];
                                $aracsoforId[] = $adminAracSoforr['BSSoforID'];
                                $c++;
                            }
                            //admin araç bölgedeki tüm  şöforler
                            $bolgeAracSofor = $Panel_Model->adminAracBolgeSofor($rutbebolgedizi);
                            //arac Şofor idler
                            $k = 0;
                            foreach ($bolgeAracSofor as $bolgeAracSoforr) {
                                $bolgeSoforler[] = $bolgeAracSoforr['BSSoforID'];
                                $k++;
                            }
                            //küçük admine göre farkını alıp, select olmayan aracları çıkarıyoruz
                            $aracfark = array_diff($bolgeSoforler, $aracsoforId);
                            $aracfarkk = implode(',', $aracfark);
                            //aracın şoforü dışındakiler
                            $digerSofor = $Panel_Model->adminRutbeDetailAracSSofor($aracfarkk);
                            //arac diğer şoförler
                            $d = 0;
                            foreach ($digerSofor as $digerSoforr) {
                                $digerAracSofor[$d]['DigerAracSoforID'] = $digerSoforr['BSSoforID'];
                                $digerAracSofor[$d]['DigerAracSoforAdi'] = $digerSoforr['BSSoforAd'];
                                $digerAracSofor[$d]['DigerAracSoforSoyad'] = $digerSoforr['BSSoforSoyad'];
                                $d++;
                            }
                            //araç Özellikleri
                            $aracOzellik = $Panel_Model->adminDetailAracOzellik($adminAracDetailID);
                            $e = 0;
                            foreach ($aracOzellik as $aracOzellikk) {
                                $adminAracDetail[$e]['AdminAracID'] = $aracOzellikk['SBAracID'];
                                $adminAracDetail[$e]['AdminAracPlaka'] = $aracOzellikk['SBAracPlaka'];
                                $adminAracDetail[$e]['AdminAracMarka'] = $aracOzellikk['SBAracMarka'];
                                $adminAracDetail[$e]['AdminAracYil'] = $aracOzellikk['SBAracModelYili'];
                                $adminAracDetail[$e]['AdminAracKapasite'] = $aracOzellikk['SBAracKapasite'];
                                $adminAracDetail[$e]['AdminAracKm'] = $aracOzellikk['SBAracKm'];
                                $adminAracDetail[$e]['AdminAracDurum'] = $aracOzellikk['SBAracDurum'];
                                $adminAracDetail[$e]['AdminAracAciklama'] = $aracOzellikk['SBAracAciklama'];
                                $e++;
                            }
                        }
                        //sonuçlar
                        $sonuc["adminAracSelectBolge"] = $selectAracBolge;
                        $sonuc["adminAracBolge"] = $digerAracBolge;
                        $sonuc["adminAracSelectSofor"] = $selectAracSofor;
                        $sonuc["adminAracSofor"] = $digerAracSofor;
                        $sonuc["adminAracOzellik"] = $adminAracDetail;
                        $sonuc["adminAracTur"] = $selectAracTur;
                    }

                    break;

                case "adminAracDetailDelete":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AArac';


                        $form->post('aracdetail_id', true);
                        $adminAracDetailID = $form->values['aracdetail_id'];

                        $deleteresult = $Panel_Model->adminDetailAracDelete($adminAracDetailID);
                        if ($deleteresult) {

                            $deleteresultt = $Panel_Model->adminDetailAracSoforDelete($adminAracDetailID);
                            if ($deleteresultt) {

                                $deleteresulttt = $Panel_Model->adminDetailAracBolgeDelete($adminAracDetailID);
                                if ($deleteresultttß) {
                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                    if ($resultMemcache) {
                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                    }
                                    $sonuc["delete"] = "Araç kaydı başarıyla silinmiştir.";
                                }
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    $sonuc["adminKurumDetail"] = $data["adminKurumDetail"];

                    break;

                case "adminAracDetailKaydet":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AArac';

                        $form->post('aracdetail_id', true);
                        $aracID = $form->values['aracdetail_id'];

                        $form->post('aracPlaka', true);
                        $form->post('aracMarka', true);
                        $form->post('aracModelYil', true);
                        $form->post('aracKapasite', true);
                        $form->post('aracAciklama', true);
                        $form->post('aracDurum', true);
                        $aracSoforID = $_REQUEST['aracSoforID'];
                        $aracSoforAd = $_REQUEST['aracSoforAd'];
                        $aracBolgeAd = $_REQUEST['aracBolgeAd'];
                        $aracBolgeID = $_REQUEST['aracBolgeID'];

                        if ($form->submit()) {
                            $data = array(
                                'SBAracMarka' => $form->values['aracMarka'],
                                'SBAracModelYili' => $form->values['aracModelYil'],
                                'SBAracPlaka' => $form->values['aracPlaka'],
                                'SBAracKapasite' => $form->values['aracKapasite'],
                                'SBAracAciklama' => $form->values['aracAciklama'],
                                'SBAracDurum' => $form->values['aracDurum']
                            );
                        }
                        $resultAracUpdate = $Panel_Model->adminAracOzelliklerDuzenle($data, $aracID);
                        if ($resultAracUpdate) {
                            $deleteresultt = $Panel_Model->adminAracSoforDelete($aracID);
                            if ($deleteresultt) {
                                $soforID = count($aracSoforID);
                                for ($a = 0; $a < $soforID; $a++) {
                                    $sofordata[$a] = array(
                                        'BSAracID' => $aracID,
                                        'BSSoforID' => $aracSoforID[$a],
                                        'BSSoforAd' => $aracSoforAd[$a]
                                    );
                                }
                                $resultSoforUpdate = $Panel_Model->addNewAdminAracSofor($sofordata);
                                if ($resultSoforUpdate) {
                                    $deleteresulttt = $Panel_Model->adminDetailAracBolgeDelete($aracID);
                                    if ($deleteresulttt) {
                                        $bolgeID = count($aracBolgeID);
                                        for ($b = 0; $b < $bolgeID; $b++) {
                                            $bolgedata[$b] = array(
                                                'SBAracID' => $aracID,
                                                'SBBolgeID' => $aracBolgeID[$b],
                                                'SBBolgeAdi' => $aracBolgeAd[$b]
                                            );
                                        }
                                        $resultBolgeID = $Panel_Model->addNewAdminBolgeSofor($bolgedata);
                                        if ($resultBolgeID) {
                                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                                            if ($resultMemcache) {
                                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                            }

                                            $sonuc["newAracID"] = $aracID;
                                            $sonuc["update"] = "Başarıyla Araç Düzenlenmiştir.";
                                        } else {
                                            //arac şofor kaydedilirken bi hata meydana geldi ise
                                            //$deleteresult = $Panel_Model->adminAracDelete($resultAracID);
                                            //$deleteresultt = $Panel_Model->adminAracSoforDelete($resultAracID);
                                            //arac şofmr kaydedilirken bi hata meydana geldi ise
                                            //if ($deleteresultt) {
                                            //    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                            //}
                                        }
                                    } else {
                                        //$deleteresult = $Panel_Model->adminAracDelete($resultAracID);
                                        //arac şofmr kaydedilirken bi hata meydana geldi ise
                                        //if ($deleteresult) {
                                        //   $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                        //}
                                    }
                                } else {
                                    
                                }
                            } else {
                                
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                case "adminAracDetailTur":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {

                        $form->post('aracID', true);
                        $adminAracDetailID = $form->values['aracID'];

                        $adminAracTurDetail = $Panel_Model->adminAracTurDetail($adminAracDetailID);

                        //arac detail tur
                        $a = 0;
                        foreach ($adminAracTurDetail as $adminAracTurDetaill) {
                            $aracDetailTur[$a]['AracTurID'] = $adminAracTurDetaill['SBTurID'];
                            $aracDetailTur[$a]['AracDetailTurAdi'] = $adminAracTurDetaill['SBTurAdi'];
                            $aracDetailTur[$a]['AracTurAktiflik'] = $adminAracTurDetaill['SBTurAktiflik'];
                            $aracDetailTur[$a]['AracTurTip'] = $adminAracTurDetaill['SBTurType'];
                            $aracDetailTur[$a]['AracTurAcikla'] = $adminAracTurDetaill['SBTurAciklama'];
                            $aracTurKurumId .= 'SELECT SBKurumID,SBKurumAdi FROM sbkurum WHERE SBKurumID=' . $adminAracTurDetaill['SBKurumID'] . ' UNION ALL ';
                            $aracTurBolgeId .= 'SELECT SBBolgeID,SBBolgeAdi FROM sbbolgeler WHERE SBBolgeID=' . $adminAracTurDetaill['SBBolgeID'] . ' UNION ALL ';
                            $deger.='selam ';
                            $a++;
                        }

                        $aracTurKurumTrim = rtrim($aracTurKurumId, " UNION ALL ");
                        $aracTurBolgeTrim = rtrim($aracTurBolgeId, " UNION ALL ");

                        $adminAracTurKurum = $Panel_Model->adminAracTurKurum($aracTurKurumTrim);

                        //arac  detail tur kurum
                        $b = 0;
                        foreach ($adminAracTurKurum as $adminAracTurKurumm) {
                            $aracDetailTurKurum[$b]['AracTurKurumID'] = $adminAracTurKurumm['SBKurumID'];
                            $aracDetailTurKurum[$b]['AracTurKurumAdi'] = $adminAracTurKurumm['SBKurumAdi'];
                            $b++;
                        }

                        $adminAracTurBolge = $Panel_Model->adminAracTurBolge($aracTurBolgeTrim);

                        //arac  detail tur kurum
                        $c = 0;
                        foreach ($adminAracTurBolge as $adminAracTurBolgee) {
                            $aracDetailTurBolge[$c]['AracTurBolgeID'] = $adminAracTurBolgee['SBBolgeID'];
                            $aracDetailTurBolge[$c]['AracTurBolgeAdi'] = $adminAracTurBolgee['SBBolgeAdi'];
                            $c++;
                        }


                        $sonuc["adminAracDetailTur"] = $aracDetailTur;
                        $sonuc["adminAracTurKurum"] = $aracDetailTurKurum;
                        $sonuc["adminAracTurBolge"] = $aracDetailTurBolge;
                    }

                    break;

                case "adminEkleSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //super adminse tüm bölgeler çekilir
                        if ($adminRutbe != 0) {
                            //bölgeleri getirir
                            $bolgeListe = $Panel_Model->aracBolgeListele();

                            $a = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$a] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$a] = $bolgelist['SBBolgeID'];
                                $a++;
                            }
                        }

                        $sonuc["adminBolge"] = $adminBolge;
                    }
                    break;

                    break;

                case "adminKaydet":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $userTip = 1;

                        $firmaID = Session::get("FirmaId");

                        $userKadi = $form->kadiOlustur($firmaID);
                        if ($userKadi) {
                            $realSifre = $form->sifreOlustur();
                            if ($realSifre) {//$loginKadi, $loginSifre, $loginTip
                                $adminSifre = $form->userSifreOlustur($userKadi, $realSifre, $userTip);
                                if ($adminSifre) {

                                    $uniqueKey = Session::get("username");
                                    $uniqueKey = $uniqueKey . '_AAdmin';

                                    $form->post('adminAd', true);
                                    $form->post('adminSoyad', true);
                                    $form->post('adminEmail', true);
                                    $form->post('adminDurum', true);
                                    $form->post('adminLokasyon', true);
                                    $form->post('adminTelefon', true);
                                    $form->post('adminAdres', true);
                                    $form->post('aciklama', true);
                                    $form->post('ulke', true);
                                    $form->post('il', true);
                                    $form->post('ilce', true);
                                    $form->post('semt', true);
                                    $form->post('mahalle', true);
                                    $form->post('sokak', true);
                                    $form->post('postakodu', true);
                                    $form->post('caddeno', true);

                                    $adminBolgeID = $_REQUEST['adminBolgeID'];

                                    if ($form->submit()) {
                                        $data = array(
                                            'BSAdminAd' => $form->values['adminAd'],
                                            'BSAdminSoyad' => $form->values['adminSoyad'],
                                            'BSAdminKadi' => $userKadi,
                                            'BSAdminSifre' => $adminSifre,
                                            'BSAdminRSifre' => $realSifre,
                                            'BSAdminPhone' => $form->values['adminTelefon'],
                                            'BSAdminEmail' => $form->values['adminEmail'],
                                            'BSAdminLocation' => $form->values['adminLokasyon'],
                                            'BSAdminUlke' => $form->values['ulke'],
                                            'BSAdminIl' => $form->values['il'],
                                            'BSAdminIlce' => $form->values['ilce'],
                                            'BSAdminSemt' => $form->values['semt'],
                                            'BSAdminMahalle' => $form->values['mahalle'],
                                            'BSAdminSokak' => $form->values['sokak'],
                                            'BSAdminPostaKodu' => $form->values['postakodu'],
                                            'BSAdminCaddeNo' => $form->values['caddeno'],
                                            'BSAdminAdres' => $form->values['adminAdres'],
                                            'BSAdminStatus' => $form->values['adminDurum'],
                                            'BSAdminAciklama' => $form->values['aciklama']
                                        );
                                    }
                                    $resultAdminID = $Panel_Model->addNewAdmin($data);

                                    if ($resultAdminID) {

                                        $bolgeID = count($adminBolgeID);
                                        for ($b = 0; $b < $bolgeID; $b++) {
                                            $bolgedata[$b] = array(
                                                'BSAdminID' => $resultAdminID,
                                                'BSBolgeID' => $adminBolgeID[$b]
                                            );
                                        }
                                        $resultBolgeID = $Panel_Model->addNewBolgeAdmin($bolgedata);
                                        if ($resultBolgeID) {
                                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                                            if ($resultMemcache) {
                                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                            }

                                            $sonuc["newAdminID"] = $resultAdminID;
                                            $sonuc["insert"] = "Başarıyla Admin Eklenmiştir.";
                                        } else {
                                            //admin kaydedilirken hata geldi ise
                                            $deleteresult = $Panel_Model->adminDelete($resultAdminID);

                                            $deleteresultt = $Panel_Model->adminMultiBolgeDelete($resultAdminID);
                                            if ($deleteresultt) {
                                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                            }
                                        }
                                    } else {
                                        $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                    }
                                } else {
                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                }
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }
            }
            echo json_encode($sonuc);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

}
?>

