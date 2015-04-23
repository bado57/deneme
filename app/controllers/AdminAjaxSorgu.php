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

        if ($_POST && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" && Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
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


                            $bolgeListe = $Panel_Model->soforRutbeBolgeListele($rutbebolgedizi);

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
                        }

                        $sonuc["adminAracBolge"] = $adminBolge;
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
                        $aracPlak = $form->values['aracPlaka'];
                        $aracPlaka = strtoupper($aracPlak);

                        $aracSoforID = $_REQUEST['aracSoforID'];
                        $aracSoforAd = $_REQUEST['aracSoforAd'];
                        $aracBolgeAd = $_REQUEST['aracBolgeAd'];
                        $aracBolgeID = $_REQUEST['aracBolgeID'];

                        if ($form->submit()) {
                            $data = array(
                                'SBAracMarka' => $form->values['aracMarka'],
                                'SBAracModelYili' => $form->values['aracModelYil'],
                                'SBAracPlaka' => $aracPlaka,
                                'SBAracKapasite' => $form->values['aracKapasite'],
                                'SBAracKm' => 0,
                                'SBAracAciklama' => $form->values['aracAciklama'],
                                'SBAracDurum' => $form->values['aracDurum']
                            );
                        }
                        $resultAracID = $Panel_Model->addNewAdminArac($data);

                        if ($resultAracID) {
                            $soforID = count($aracSoforID);
                            if ($soforID > 0) {
                                for ($a = 0; $a < $soforID; $a++) {
                                    $sofordata[$a] = array(
                                        'BSAracID' => $resultAracID,
                                        'BSAracPlaka' => $aracPlaka,
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
                                            'SBAracPlaka' => $aracPlaka,
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
                                $bolgeID = count($aracBolgeID);
                                for ($b = 0; $b < $bolgeID; $b++) {
                                    $bolgedata[$b] = array(
                                        'SBAracID' => $resultAracID,
                                        'SBAracPlaka' => $aracPlaka,
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

                            //araca ait bölge varmı(kesin oalcak arac a bölge seçtirmeden ekletmiyoruz
                            $aracCountBolge = count($aracbolgeId);
                            if ($aracCountBolge > 0) {
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
                            }

                            //admin araç seçili şoför
                            $adminAracSofor = $Panel_Model->adminDetailAracSofor($adminAracDetailID);
                            $aracSoforCount = count($adminAracSofor);
                            //eğer aracın seçili şoförü varsa burası gelecek
                            if ($aracSoforCount > 0) {
                                //arac Şofor idler
                                $c = 0;
                                foreach ($adminAracSofor as $adminAracSoforr) {
                                    $selectAracSofor[$c]['SelectAracSoforID'] = $adminAracSoforr['BSSoforID'];
                                    $selectAracSofor[$c]['SelectAracSoforAdi'] = $adminAracSoforr['BSSoforAd'];
                                    $aracsoforId[] = $adminAracSoforr['BSSoforID'];
                                    $c++;
                                }
                                //seçili olan bölge
                                $aracbolgedizim = implode(',', $aracbolgeId);
                                //seöili olan soför
                                $aracbolgesofor = implode(',', $aracsoforId);
                                //adamın seçili olab bölgedeki diğer şoförleri
                                $adminAracBolgeSofor = $Panel_Model->adminSelectBolgeSofor($aracbolgedizim, $aracbolgesofor);

                                if (count($adminAracBolgeSofor) > 0) {

                                    $d = 0;
                                    foreach ($adminAracBolgeSofor as $adminAracBolgeSoforr) {
                                        $digerAracSofor[$d]['DigerAracSoforID'] = $adminAracBolgeSoforr['BSSoforID'];
                                        $digerAracSofor[$d]['DigerAracSoforAdi'] = $adminAracBolgeSoforr['BSSoforAd'];
                                        $d++;
                                    }
                                }
                            } else {
                                //seçili olan bölge
                                $aracbolgedizim = implode(',', $aracbolgeId);
                                //adamın seçili olab bölgedeki diğer şoförleri
                                $adminAracBolgeSofor = $Panel_Model->adminSelectBolgeSoforr($aracbolgedizim);

                                $d = 0;
                                foreach ($adminAracBolgeSofor as $adminAracBolgeSoforr) {
                                    $digerAracSofor[$d]['DigerAracSoforID'] = $adminAracBolgeSoforr['BSSoforID'];
                                    $digerAracSofor[$d]['DigerAracSoforAdi'] = $adminAracBolgeSoforr['BSSoforAd'];
                                    $d++;
                                }
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

                            //küçük admine göre farkını alıp, select olmayan bölgeleri çıkarıyoruz$aracbolgeId
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


                            $adminAracSofor = $Panel_Model->adminDetailAracSofor($adminAracDetailID);
                            $adminAracCount = count($adminAracSofor);
                            if ($adminAracCount > 0) {
                                //arac Şofor idler
                                $c = 0;
                                foreach ($adminAracSofor as $adminAracSoforr) {
                                    $selectAracSofor[$c]['SelectAracSoforID'] = $adminAracSoforr['BSSoforID'];
                                    $selectAracSofor[$c]['SelectAracSoforAdi'] = $adminAracSoforr['BSSoforAd'];
                                    $aracsoforId[] = $adminAracSoforr['BSSoforID'];
                                    $c++;
                                }

                                //seçili olan bölge
                                $aracbolgedizim = implode(',', $aracbolgeId);
                                $aracbolgesofor = implode(',', $aracsoforId);
                                //adamın seçili olab bölgedeki diğer şoförleri
                                $adminAracBolgeSofor = $Panel_Model->adminSelectBolgeSofor($aracbolgedizim, $aracbolgesofor);

                                $d = 0;
                                foreach ($adminAracBolgeSofor as $adminAracBolgeSoforr) {
                                    $digerAracSofor[$d]['DigerAracSoforID'] = $adminAracBolgeSoforr['BSSoforID'];
                                    $digerAracSofor[$d]['DigerAracSoforAdi'] = $adminAracBolgeSoforr['BSSoforAd'];
                                    $d++;
                                }
                            } else {

                                //adamın seçili olab bölgedeki diğer şoförleri
                                $adminAracBolgeSofor = $Panel_Model->adminSelectBolgeSoforr($rutbebolgedizi);

                                $d = 0;
                                foreach ($adminAracBolgeSofor as $adminAracBolgeSoforr) {
                                    $digerAracSofor[$d]['DigerAracSoforID'] = $adminAracBolgeSoforr['BSSoforID'];
                                    $digerAracSofor[$d]['DigerAracSoforAdi'] = $adminAracBolgeSoforr['BSSoforAd'];
                                    $d++;
                                }
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
                                if ($deleteresulttt) {
                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                    if ($resultMemcache) {
                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                    }
                                    $sonuc["delete"] = "Araç kaydı başarıyla silinmiştir.";
                                }
                            } else {
                                $deleteresulttt = $Panel_Model->adminDetailAracBolgeDelete($adminAracDetailID);
                                if ($deleteresulttt) {
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
                        $aracPlak = $form->values['aracPlaka'];
                        $aracPlaka = strtoupper($aracPlak);

                        $aracSoforID = $_REQUEST['aracSoforID'];
                        $aracSoforAd = $_REQUEST['aracSoforAd'];
                        $aracBolgeAd = $_REQUEST['aracBolgeAd'];
                        $aracBolgeID = $_REQUEST['aracBolgeID'];

                        if ($form->submit()) {
                            $data = array(
                                'SBAracMarka' => $form->values['aracMarka'],
                                'SBAracModelYili' => $form->values['aracModelYil'],
                                'SBAracPlaka' => $aracPlaka,
                                'SBAracKapasite' => $form->values['aracKapasite'],
                                'SBAracAciklama' => $form->values['aracAciklama'],
                                'SBAracDurum' => $form->values['aracDurum']
                            );
                        }
                        $resultAracUpdate = $Panel_Model->adminAracOzelliklerDuzenle($data, $aracID);
                        if ($resultAracUpdate) {
                            $soforID = count($aracSoforID);
                            if ($soforID > 0) {
                                $deleteresultt = $Panel_Model->adminAracSoforDelete($aracID);
                                if ($deleteresultt) {
                                    for ($a = 0; $a < $soforID; $a++) {
                                        $sofordata[$a] = array(
                                            'BSAracID' => $aracID,
                                            'BSAracPlaka' => $aracPlaka,
                                            'BSSoforID' => $aracSoforID[$a],
                                            'BSSoforAd' => $aracSoforAd[$a]
                                        );
                                    }
                                    $resultSoforUpdate = $Panel_Model->addNewAdminAracSofor($sofordata);
                                    if ($resultSoforUpdate) {
                                        $bolgeID = count($aracBolgeID);
                                        $deleteresulttt = $Panel_Model->adminDetailAracBolgeDelete($aracID);
                                        if ($deleteresulttt) {
                                            for ($b = 0; $b < $bolgeID; $b++) {
                                                $bolgedata[$b] = array(
                                                    'SBAracID' => $aracID,
                                                    'SBAracPlaka' => $aracPlaka,
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
                            } else {
                                $deleteresultt = $Panel_Model->adminAracSoforDelete($aracID);
                                $deleteresulttt = $Panel_Model->adminDetailAracBolgeDelete($aracID);
                                if ($deleteresulttt) {
                                    $bolgeID = count($aracBolgeID);
                                    for ($b = 0; $b < $bolgeID; $b++) {
                                        $bolgedata[$b] = array(
                                            'SBAracID' => $aracID,
                                            'SBAracPlaka' => $aracPlaka,
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
                                        $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                    }
                                } else {
                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                }
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

                    $adminRutbe = Session::get("userRutbe");

                    if ($adminRutbe != 1) {
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
                                            'Status' => $form->values['adminDurum'],
                                            'BSAdminAciklama' => $form->values['aciklama']
                                        );
                                    }
                                    $resultAdminID = $Panel_Model->addNewAdmin($data);

                                    if ($resultAdminID != 'unique') {
                                        $bolgeID = count($adminBolgeID);
                                        if ($bolgeID > 0) {
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
                                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                                            if ($resultMemcache) {
                                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                            }

                                            $sonuc["newAdminID"] = $resultAdminID;
                                            $sonuc["insert"] = "Başarıyla Admin Eklenmiştir.";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Lütfen Yeni Bir Kullanıcı Adı yada Şifre Giriniz.";
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

                case "adminDetail":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //superadminse
                        if ($adminRutbe != 0) {
                            $form->post('adminRowid', true);
                            $adminDetailID = $form->values['adminRowid'];

                            $adminListe = $Panel_Model->adminIDListele($adminDetailID);

                            $a = 0;
                            foreach ($adminListe as $adminListee) {
                                $adminList[$a]['AdminListID'] = $adminListee['BSAdminID'];
                                $adminList[$a]['AdminListAd'] = $adminListee['BSAdminAd'];
                                $adminList[$a]['AdminListSoyad'] = $adminListee['BSAdminSoyad'];
                                $adminList[$a]['AdminListTelefon'] = $adminListee['BSAdminPhone'];
                                $adminList[$a]['AdminListMail'] = $adminListee['BSAdminEmail'];
                                $adminList[$a]['AdminListLokasyon'] = $adminListee['BSAdminLocation'];
                                $adminList[$a]['AdminListUlke'] = $adminListee['BSAdminUlke'];
                                $adminList[$a]['AdminListIl'] = $adminListee['BSAdminIl'];
                                $adminList[$a]['AdminListIlce'] = $adminListee['BSAdminIlce'];
                                $adminList[$a]['AdminListSemt'] = $adminListee['BSAdminSemt'];
                                $adminList[$a]['AdminListMahalle'] = $adminListee['BSAdminMahalle'];
                                $adminList[$a]['AdminListSokak'] = $adminListee['BSAdminSokak'];
                                $adminList[$a]['AdminListPostaKodu'] = $adminListee['BSAdminPostaKodu'];
                                $adminList[$a]['AdminListCaddeNo'] = $adminListee['BSAdminCaddeNo'];
                                $adminList[$a]['AdminListAdres'] = $adminListee['BSAdminAdres'];
                                $adminList[$a]['AdminListDurum'] = $adminListee['Status'];
                                $adminList[$a]['AdminListAciklama'] = $adminListee['BSAdminAciklama'];
                                $a++;
                            }

                            //admine ait bölgeler
                            $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminDetailID);

                            foreach ($bolgeListeRutbe as $rutbe) {
                                $bolgerutbeId[] = $rutbe['BSBolgeID'];
                            }

                            $adminBolgeCount = count($bolgerutbeId);
                            if ($adminBolgeCount > 0) {
                                $rutbebolgedizi = implode(',', $bolgerutbeId);

                                //admine ai bölgeler
                                $bolgeListe = $Panel_Model->rutbeBolgeListele($rutbebolgedizi);
                                //bölge count için
                                if (count($bolgeListe) != 0) {
                                    $adminBolge[0]['AdminBolgeCount'] = count($bolgeListe);
                                }

                                $b = 0;
                                foreach ($bolgeListe as $bolge) {
                                    $adminBolge[$b]['AdminBolge'] = $bolge['SBBolgeAdi'];
                                    $adminBolge[$b]['AdminBolgeID'] = $bolge['SBBolgeID'];
                                    $b++;
                                }

                                //admine ait olmayan bölgeler
                                $bolgeNotListe = $Panel_Model->rutbeNotBolgeListele($rutbebolgedizi);
                                //bölge count için
                                if (count($bolgeNotListe) != 0) {
                                    $adminBolge[0]['AdminNotBolgeCount'] = count($bolgeNotListe);
                                }

                                $c = 0;
                                foreach ($bolgeNotListe as $bolgeNotListee) {
                                    $adminNoBolge[$c]['AdminBolge'] = $bolgeNotListee['SBBolgeAdi'];
                                    $adminNoBolge[$c]['AdminBolgeID'] = $bolgeNotListee['SBBolgeID'];
                                    $c++;
                                }
                            } else {
                                //admine ait olmayan bölgeler
                                $bolgeNotListe = $Panel_Model->adminBolge();
                                //bölge count için
                                if (count($bolgeNotListe) != 0) {
                                    $adminNoBolge[0]['AdminNotBolgeCount'] = count($bsolgeNotListe);
                                }

                                $c = 0;
                                foreach ($bolgeNotListe as $bolgeNotListee) {
                                    $adminNoBolge[$c]['AdminBolge'] = $bolgeNotListee['SBBolgeAdi'];
                                    $adminNoBolge[$c]['AdminBolgeID'] = $bolgeNotListee['SBBolgeID'];
                                    $c++;
                                }
                            }
                        }
                        //sonuçlar
                        $sonuc["adminDetail"] = $adminList;
                        $sonuc["adminBolge"] = $adminBolge;
                        $sonuc["adminNoBolge"] = $adminNoBolge;
                    }

                    break;

                case "adminDetailDelete":

                    $adminRutbe = Session::get("userRutbe");
                    if ($adminRutbe != 1) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AAdmin';


                        $form->post('admindetail_id', true);
                        $adminDetailID = $form->values['admindetail_id'];

                        $deleteresult = $Panel_Model->adminDetailDelete($adminDetailID);
                        if ($deleteresult) {
                            $deleteresulttt = $Panel_Model->adminDetailBolgeDelete($adminDetailID);
                            if ($deleteresulttt) {
                                $resultMemcache = $MemcacheModel->get($uniqueKey);
                                if ($resultMemcache) {
                                    $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                }
                                $sonuc["delete"] = "Admin kaydı başarıyla silinmiştir.";
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    $sonuc["adminDetail"] = $data["adminDetail"];

                    break;

                case "adminDetailKaydet":

                    $adminRutbe = Session::get("userRutbe");
                    if ($adminRutbe != 1) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AAdmin';

                        $form->post('admindetail_id', true);
                        $adminID = $form->values['admindetail_id'];

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

                        $adminBolgeAd = $_REQUEST['adminBolgeAd'];
                        $adminBolgeID = $_REQUEST['adminBolgeID'];

                        if ($form->submit()) {
                            $data = array(
                                'BSAdminAd' => $form->values['adminAd'],
                                'BSAdminSoyad' => $form->values['adminSoyad'],
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
                                'Status' => $form->values['adminDurum'],
                                'BSAdminAciklama' => $form->values['aciklama']
                            );
                        }
                        $resultAdminUpdate = $Panel_Model->adminOzelliklerDuzenle($data, $adminID);
                        if ($resultAdminUpdate) {
                            $deleteresulttt = $Panel_Model->adminMultiBolgeDelete($adminID);
                            if ($deleteresulttt) {
                                $bolgeID = count($adminBolgeID);
                                for ($b = 0; $b < $bolgeID; $b++) {
                                    $bolgedata[$b] = array(
                                        'BSAdminID' => $adminID,
                                        'BSBolgeID' => $adminBolgeID[$b]
                                    );
                                }
                                $resultBolgeID = $Panel_Model->addNewBolgeAdmin($bolgedata);
                                if ($resultBolgeID) {
                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                    if ($resultMemcache) {
                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                    }

                                    $sonuc["newAdminID"] = $adminID;
                                    $sonuc["update"] = "Başarıyla Admin Düzenlenmiştir.";
                                } else {
                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                }
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                case "soforEkleSelect":
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
                        } else {
                            $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                            foreach ($bolgeListeRutbe as $rutbe) {
                                $bolgerutbeId[] = $rutbe['BSBolgeID'];
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);

                            $bolgeListe = $Panel_Model->soforRutbeBolgeListele($rutbebolgedizi);

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

                case "soforAracMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $aracBolgeID = $_REQUEST['soforBolgeID'];
                        $multisofordizi = implode(',', $aracBolgeID);

                        $soforBolgeListe = $Panel_Model->aracMultiSelectBolge($multisofordizi);
                        foreach ($soforBolgeListe as $soforBolgeListee) {
                            $aracrutbeId[] = $soforBolgeListee['SBAracID'];
                        }
                        $rutbearacdizi = implode(',', $aracrutbeId);
                        //bölgeleri getirir
                        $aracListe = $Panel_Model->aracMultiSelect($rutbearacdizi);

                        $a = 0;
                        foreach ($aracListe as $aracListee) {
                            $soforAracSelect['AracSelectID'][$a] = $aracListee['SBAracID'];
                            $soforAracSelect['AracSelectPlaka'][$a] = $aracListee['SBAracPlaka'];
                            $a++;
                        }
                        $sonuc["aracMultiSelect"] = $soforAracSelect;
                    }
                    break;

                case "AracDetailMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $aracDetailBolgeID = $_REQUEST['aracDetailBolgeID'];
                        $form->post('aracID', true);
                        $aracID = $form->values['aracID'];

                        //araca ait şoförler
                        $adminAracSofor = $Panel_Model->aracDetailMultiSelectSofor($aracID);
                        if (count($adminAracSofor) > 0) {
                            $a = 0;
                            foreach ($adminAracSofor as $adminAracSoforr) {
                                $aracsoforId[] = $adminAracSoforr['BSSoforID'];
                                $a++;
                            }
                            //araca ait şoförler
                            $aracbolgesofor = implode(',', $aracsoforId);
                            //seçilen bölgeler
                            $aracbolgedizim = implode(',', $aracDetailBolgeID);
                            //seçilen bölgedeki şoförler
                            $adminAracBolgeSofor = $Panel_Model->adminSelectBolgeSoforr($aracbolgedizim);
                            $b = 0;
                            foreach ($adminAracBolgeSofor as $adminAracBolgeSoforr) {
                                $aracDigerSoforId[] = $adminAracBolgeSoforr['BSSoforID'];
                                $b++;
                            }
                            //gelen şoför ıdlerinde aynı olan idler, seçili şoförlerdir.
                            $ortakIDler = array_intersect($aracsoforId, $aracDigerSoforId);
                            //gelen idlerde ki farklı olanlar seçili olmayan şoförlerdir yani diğer şoförler
                            $sofor_fark = array_diff($aracDigerSoforId, $aracsoforId);
                            $diger_sofor_fark = implode(',', $sofor_fark);

                            //ortak ıd ye sahip şoför varmı
                            if (count($ortakIDler) > 0) {
                                //seçili şoförler
                                $secilenIdSofor = implode(',', $ortakIDler);
                                $selectBolgeSofor = $Panel_Model->adminDetailAracNotSelectSofor($secilenIdSofor);
                                $c = 0;
                                foreach ($selectBolgeSofor as $selectBolgeSoforr) {
                                    $selectAracSofor[$c]['SelectAracSoforID'] = $selectBolgeSoforr['BSSoforID'];
                                    $selectAracSofor[$c]['SelectAracSoforAd'] = $selectBolgeSoforr['BSSoforAd'];
                                    $selectAracSofor[$c]['SelectAracSoforSoyad'] = $selectBolgeSoforr['BSSoforSoyad'];
                                    $c++;
                                }

                                //diğer şoförler
                                $digerBolgeSofor = $Panel_Model->adminDetailAracNotSelectSofor($aracbolgedizim);

                                $d = 0;
                                foreach ($digerBolgeSofor as $digerBolgeSoforr) {
                                    $digerAracSofor[$d]['DigerAracSoforID'] = $digerBolgeSoforr['BSSoforID'];
                                    $digerAracSofor[$d]['DigerAracSoforAdi'] = $digerBolgeSoforr['BSSoforAd'];
                                    $digerAracSofor[$d]['DigerAracSoforSoyad'] = $digerBolgeSoforr['BSSoforSoyad'];
                                    $d++;
                                }
                            } else {
                                //ortak id yoksa seçili şoför yoktur
                                //diğer şoförler
                                $digerBolgeSofor = $Panel_Model->adminDetailAracNotSelectSofor($diger_sofor_fark);

                                $d = 0;
                                foreach ($digerBolgeSofor as $digerBolgeSoforr) {
                                    $digerAracSofor[$d]['DigerAracSoforID'] = $digerBolgeSoforr['BSSoforID'];
                                    $digerAracSofor[$d]['DigerAracSoforAdi'] = $digerBolgeSoforr['BSSoforAd'];
                                    $digerAracSofor[$d]['DigerAracSoforSoyad'] = $digerBolgeSoforr['BSSoforSoyad'];
                                    $d++;
                                }
                            }
                        } else {
                            $aracDetailBollgeID = implode(',', $aracDetailBolgeID);
                            //adamın seçili olab bölgedeki diğer şoförleri
                            $adminAracBolgeSofor = $Panel_Model->adminSelectBolgeSoforr($aracDetailBollgeID);
                            $g = 0;
                            foreach ($adminAracBolgeSofor as $adminAracBolgeSoforr) {
                                $aracDigerSoforId[] = $adminAracBolgeSoforr['BSSoforID'];
                                $g++;
                            }

                            $aracSelectDigerSoforId = implode(',', $aracDigerSoforId);
                            //aracın bolgesi dışındakiler
                            $digerBolgeSofor = $Panel_Model->adminDetailAracBolgeSofor($aracSelectDigerSoforId);

                            $d = 0;
                            foreach ($digerBolgeSofor as $digerBolgeSoforr) {
                                $digerAracSofor[$d]['DigerAracSoforID'] = $digerBolgeSoforr['BSSoforID'];
                                $digerAracSofor[$d]['DigerAracSoforAdi'] = $digerBolgeSoforr['BSSoforAd'];
                                $digerAracSofor[$d]['DigerAracSoforSoyad'] = $digerBolgeSoforr['BSSoforSoyad'];
                                $d++;
                            }
                        }

                        //sonuçlar
                        $sonuc["adminAracSelectSofor"] = $selectAracSofor;
                        $sonuc["adminAracSofor"] = $digerAracSofor;
                    }
                    break;

                case "soforKaydet":

                    $adminRutbe = Session::get("userRutbe");

                    if ($adminRutbe != 1) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $userTip = 2;

                        $firmaID = Session::get("FirmaId");

                        $userKadi = $form->kadiOlustur($firmaID);
                        if ($userKadi) {
                            $realSifre = $form->sifreOlustur();
                            if ($realSifre) {
                                $adminSifre = $form->userSifreOlustur($userKadi, $realSifre, $userTip);
                                if ($adminSifre) {

                                    $uniqueKey = Session::get("username");
                                    $uniqueKey = $uniqueKey . '_ASofor';

                                    $form->post('soforAd', true);
                                    $form->post('soforSoyad', true);
                                    $form->post('soforEmail', true);
                                    $form->post('soforDurum', true);
                                    $form->post('soforLokasyon', true);
                                    $form->post('soforTelefon', true);
                                    $form->post('soforAdres', true);
                                    $form->post('aciklama', true);
                                    $form->post('ulke', true);
                                    $form->post('il', true);
                                    $form->post('ilce', true);
                                    $form->post('semt', true);
                                    $form->post('mahalle', true);
                                    $form->post('sokak', true);
                                    $form->post('postakodu', true);
                                    $form->post('caddeno', true);

                                    $soforAd = $form->values['soforAd'];
                                    $soforSoyad = $form->values['soforSoyad'];
                                    $soforAdSoyad = $soforAd . ' ' . $soforSoyad;

                                    $soforBolgeID = $_REQUEST['soforBolgeID'];
                                    $soforBolgeAdi = $_REQUEST['soforBolgeAdi'];
                                    $soforAracID = $_REQUEST['soforAracID'];
                                    $soforAracPlaka = $_REQUEST['soforAracPlaka'];

                                    if ($form->submit()) {
                                        $data = array(
                                            'BSSoforAd' => $soforAd,
                                            'BSSoforSoyad' => $soforSoyad,
                                            'BSSoforKadi' => $userKadi,
                                            'BSSoforSifre' => $adminSifre,
                                            'BSSoforRSifre' => $realSifre,
                                            'BSSoforPhone' => $form->values['soforTelefon'],
                                            'BSSoforEmail' => $form->values['soforEmail'],
                                            'BSSoforLocation' => $form->values['soforLokasyon'],
                                            'BSSoforUlke' => $form->values['ulke'],
                                            'BSSoforIl' => $form->values['il'],
                                            'BSSoforIlce' => $form->values['ilce'],
                                            'BSSoforSemt' => $form->values['semt'],
                                            'BSSoforMahalle' => $form->values['mahalle'],
                                            'BSSoforSokak' => $form->values['sokak'],
                                            'BSSoforPostaKodu' => $form->values['postakodu'],
                                            'BSSoforCaddeNo' => $form->values['caddeno'],
                                            'BSSoforAdres' => $form->values['soforAdres'],
                                            'Status' => $form->values['soforDurum'],
                                            'BSSoforAciklama' => $form->values['aciklama']
                                        );
                                    }
                                    $resultSoforID = $Panel_Model->addNewSofor($data);

                                    if ($resultSoforID != 'unique') {
                                        $bolgeID = count($soforBolgeID);
                                        if ($bolgeID > 0) {
                                            for ($b = 0; $b < $bolgeID; $b++) {
                                                $bolgedata[$b] = array(
                                                    'BSSoforID' => $resultSoforID,
                                                    'BSSoforAd' => $soforAdSoyad,
                                                    'BSBolgeID' => $soforBolgeID[$b],
                                                    'BSBolgeAdi' => $soforBolgeAdi[$b]
                                                );
                                            }
                                            $resultBolgeID = $Panel_Model->addNewBolgeSofor($bolgedata);
                                            if ($resultBolgeID) {
                                                //şoföre araç seçildi ise
                                                $aracID = count($soforAracID);
                                                if ($aracID > 0) {
                                                    for ($c = 0; $c < $aracID; $c++) {
                                                        $aracdata[$c] = array(
                                                            'BSAracID' => $soforAracID[$c],
                                                            'BSAracPlaka' => $soforAracPlaka[$c],
                                                            'BSSoforID' => $resultSoforID,
                                                            'BSSoforAd' => $soforAdSoyad
                                                        );
                                                    }

                                                    $resultAracID = $Panel_Model->addNewAracSofor($aracdata);

                                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                                    if ($resultMemcache) {
                                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                                    }

                                                    $sonuc["newSoforID"] = $resultSoforID;
                                                    $sonuc["insert"] = "Başarıyla Şoför Eklenmiştir.";
                                                } else {
                                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                                    if ($resultMemcache) {
                                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                                    }

                                                    $sonuc["newSoforID"] = $resultSoforID;
                                                    $sonuc["insert"] = "Başarıyla Şoför Eklenmiştir.";
                                                }
                                            } else {
                                                //admin kaydedilirken hata geldi ise
                                                $deleteresult = $Panel_Model->soforDelete($resultSoforID);

                                                if ($deleteresult) {
                                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                                }
                                            }
                                        } else {
                                            //eğer şoförün bölgesi yoksa
                                            $deleteresult = $Panel_Model->soforDelete($resultSoforID);
                                            $sonuc["hata"] = "Lütfen Bölge Seçmeyi Unutmayınız.";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Lütfen Yeni Bir Kullanıcı Adı yada Şifre Giriniz.";
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

                case "AracSoforMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $aracBolgeID = $_REQUEST['aracBolgeID'];
                        $multisofordizi = implode(',', $aracBolgeID);

                        $soforBolgeListe = $Panel_Model->aracDetailMultiSelectBolgee($multisofordizi);
                        foreach ($soforBolgeListe as $soforBolgeListee) {
                            $soforrutbeId[] = $soforBolgeListee['BSSoforID'];
                        }
                        $rutbesofordizi = implode(',', $soforrutbeId);
                        //bölgeleri getirir
                        $soforListe = $Panel_Model->soforMultiSelectt($rutbesofordizi);

                        $a = 0;
                        foreach ($soforListe as $soforListee) {
                            $aracSoforSelect['SoforSelectID'][$a] = $soforListee['BSSoforID'];
                            $aracSoforSelect['SoforSelectAd'][$a] = $soforListee['BSSoforAd'];
                            $aracSoforSelect['SoforSelectSoyad'][$a] = $soforListee['BSSoforSoyad'];
                            $a++;
                        }
                        $sonuc["aracYeniSoforMultiSelect"] = $aracSoforSelect;
                    }
                    break;

                case "soforDetail":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //superadminse
                        if ($adminRutbe != 0) {
                            $form->post('soforRowid', true);
                            $soforDetailID = $form->values['soforRowid'];

                            $soforBolge = $Panel_Model->soforDetailBolge($soforDetailID);
                            //arac bölge idler
                            $a = 0;
                            foreach ($soforBolge as $soforBolgee) {
                                $selectSoforBolge[$a]['SelectSoforBolgeID'] = $soforBolgee['BSBolgeID'];
                                $selectSoforBolge[$a]['SelectSoforBolgeAdi'] = $soforBolgee['BSBolgeAdi'];
                                $soforbolgeId[] = $soforBolgee['BSBolgeID'];
                                $a++;
                            }

                            //araca ait bölge varmı(kesin oalcak arac a bölge seçtirmeden ekletmiyoruz
                            $soforCountBolge = count($soforbolgeId);
                            if ($soforCountBolge > 0) {
                                $soforbolgedizi = implode(',', $soforbolgeId);
                                //aracın bolgesi dışındakiler
                                $digerBolge = $Panel_Model->soforDetailSBolge($soforbolgedizi);
                                //arac diğer bölgeler
                                $b = 0;
                                foreach ($digerBolge as $digerBolgee) {
                                    $digerSoforBolge[$b]['DigerSoforBolgeID'] = $digerBolgee['SBBolgeID'];
                                    $digerSoforBolge[$b]['DigerSoforBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                    $b++;
                                }
                            }

                            //admin araç seçili şoför
                            $adminSoforArac = $Panel_Model->adminDetailSoforArac($soforDetailID);
                            $soforAracCount = count($adminSoforArac);
                            //eğer aracın seçili şoförü varsa burası gelecek
                            if ($soforAracCount > 0) {
                                //arac Şofor idler
                                $c = 0;
                                foreach ($adminSoforArac as $adminSoforAracc) {
                                    $selectSoforArac[$c]['SelectSoforAracID'] = $adminSoforAracc['BSAracID'];
                                    $selectSoforArac[$c]['SelectSoforAracPlaka'] = $adminSoforAracc['BSAracPlaka'];
                                    $soforaracId[] = $adminSoforAracc['BSAracID'];
                                    $c++;
                                }
                                //seçili olan bölge
                                $soforbolgedizim = implode(',', $soforbolgeId);
                                //seöili olan arac
                                $soforbolgearac = implode(',', $aracsoforId);
                                //adamın seçili olab bölgedeki diğer aracları
                                $adminSoforBolgeArac = $Panel_Model->adminSelectSoforBolge($soforbolgedizim, $soforbolgearac);

                                if (count($adminSoforBolgeArac) > 0) {
                                    $d = 0;
                                    foreach ($adminSoforBolgeArac as $adminSoforBolgeAracc) {
                                        $digerSoforArac[$d]['DigerSoforAracID'] = $adminSoforBolgeAracc['SBAracID'];
                                        $digerSoforArac[$d]['DigerSoforAracPlaka'] = $adminSoforBolgeAracc['SBAracPlaka'];
                                        $d++;
                                    }
                                }
                            } else {
                                //seçili olan bölge
                                $soforbolgedizim = implode(',', $soforbolgeId);
                                //adamın seçili olab bölgedeki diğer araçları
                                $adminSoforBolgeArac = $Panel_Model->adminSelectBolgeArac($soforbolgedizim);

                                $d = 0;
                                foreach ($adminSoforBolgeArac as $adminSoforBolgeAracc) {
                                    $digerSoforArac[$d]['DigerSoforAracID'] = $adminSoforBolgeAracc['SBAracID'];
                                    $digerSoforArac[$d]['DigerSoforAracPlaka'] = $adminSoforBolgeAracc['SBAracPlaka'];
                                    $d++;
                                }
                            }

                            //araç Özellikleri
                            $soforOzellik = $Panel_Model->soforDetail($soforDetailID);
                            $e = 0;
                            foreach ($soforOzellik as $soforOzellikk) {
                                $soforList[$e]['SoforListID'] = $soforOzellikk['BSSoforID'];
                                $soforList[$e]['SoforListAd'] = $soforOzellikk['BSSoforAd'];
                                $soforList[$e]['SoforListSoyad'] = $soforOzellikk['BSSoforSoyad'];
                                $soforList[$e]['SoforListTelefon'] = $soforOzellikk['BSSoforPhone'];
                                $soforList[$e]['SoforListMail'] = $soforOzellikk['BSSoforEmail'];
                                $soforList[$e]['SoforListLokasyon'] = $soforOzellikk['BSSoforLocation'];
                                $soforList[$e]['SoforListUlke'] = $soforOzellikk['BSSoforUlke'];
                                $soforList[$e]['SoforListIl'] = $soforOzellikk['BSSoforIl'];
                                $soforList[$e]['SoforListIlce'] = $soforOzellikk['BSSoforIlce'];
                                $soforList[$e]['SoforListSemt'] = $soforOzellikk['BSSoforSemt'];
                                $soforList[$e]['SoforListMahalle'] = $soforOzellikk['BSSoforMahalle'];
                                $soforList[$e]['SoforListSokak'] = $soforOzellikk['BSSoforSokak'];
                                $soforList[$e]['SoforListPostaKodu'] = $soforOzellikk['BSSoforPostaKodu'];
                                $soforList[$e]['SoforListCaddeNo'] = $soforOzellikk['BSSoforCaddeNo'];
                                $soforList[$e]['SoforListAdres'] = $soforOzellikk['BSSoforAdres'];
                                $soforList[$e]['SoforListDurum'] = $soforOzellikk['Status'];
                                $soforList[$e]['SoforListAciklama'] = $soforOzellikk['BSSoforAciklama'];
                                $e++;
                            }
                        } else {
                            $adminID = Session::get("userId");
                            //normal adminse
                            $form->post('soforRowid', true);
                            $soforDetailID = $form->values['soforRowid'];

                            //küçük adminin olan bölgeleri
                            $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                            //bölge idler
                            $r = 0;
                            foreach ($bolgeListeRutbe as $bolgeListeRutbee) {
                                $bolgerutbeId[] = $bolgeListeRutbee['BSBolgeID'];
                                $r++;
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);

                            $soforBolge = $Panel_Model->adminDetailSoforBolge($soforDetailID);

                            //arac bölge idler
                            //arac bölge idler
                            $a = 0;
                            foreach ($soforBolge as $soforBolgee) {
                                $selectSoforBolge[$a]['SelectSoforBolgeID'] = $soforBolgee['BSBolgeID'];
                                $selectSoforBolge[$a]['SelectSoforBolgeAdi'] = $soforBolgee['BSBolgeAdi'];
                                $soforbolgeId[] = $soforBolgee['BSBolgeID'];
                                $a++;
                            }

                            //küçük admine göre farkını alıp, select olmayan bölgeleri çıkarıyoruz
                            $bolgefark = array_diff($bolgerutbeId, $soforbolgeId);
                            $bolgefarkk = implode(',', $bolgefark);

                            //aracın bolgesi dışındakiler
                            $digerBolge = $Panel_Model->adminRutbeDetailAracSBolge($bolgefarkk);
                            //arac diğer bölgeler
                            $b = 0;
                            foreach ($digerBolge as $digerBolgee) {
                                $digerSoforBolge[$b]['DigerSoforBolgeID'] = $digerBolgee['SBBolgeID'];
                                $digerSoforBolge[$b]['DigerSoforBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                $b++;
                            }

                            //admin araç seçili şoför
                            $adminSoforArac = $Panel_Model->adminDetailSoforArac($soforDetailID);
                            $soforAracCount = count($adminSoforArac);
                            if ($soforAracCount > 0) {
                                //arac Şofor idler
                                $c = 0;
                                foreach ($adminSoforArac as $adminSoforAracc) {
                                    $selectSoforArac[$c]['SelectSoforAracID'] = $adminSoforAracc['BSAracID'];
                                    $selectSoforArac[$c]['SelectSoforAracPlaka'] = $adminSoforAracc['BSAracPlaka'];
                                    $soforaracId[] = $adminSoforAracc['BSAracID'];
                                    $c++;
                                }

                                //seçili olan bölge
                                $soforbolgedizim = implode(',', $soforbolgeId);
                                //seöili olan arac
                                $soforbolgearac = implode(',', $aracsoforId);
                                //adamın seçili olab bölgedeki diğer aracları
                                $adminSoforBolgeArac = $Panel_Model->adminSelectSoforBolge($soforbolgedizim, $soforbolgearac);

                                if (count($adminSoforBolgeArac) > 0) {
                                    $d = 0;
                                    foreach ($adminSoforBolgeArac as $adminSoforBolgeAracc) {
                                        $digerSoforArac[$d]['DigerSoforAracID'] = $adminSoforBolgeAracc['SBAracID'];
                                        $digerSoforArac[$d]['DigerSoforAracPlaka'] = $adminSoforBolgeAracc['SBAracPlaka'];
                                        $d++;
                                    }
                                }
                            } else {

                                //seçili olan bölge
                                $soforbolgedizim = implode(',', $soforbolgeId);
                                //adamın seçili olab bölgedeki diğer araçları
                                $adminSoforBolgeArac = $Panel_Model->adminSelectBolgeArac($rutbebolgedizi);

                                $d = 0;
                                foreach ($adminSoforBolgeArac as $adminSoforBolgeAracc) {
                                    $digerSoforArac[$d]['DigerSoforAracID'] = $adminSoforBolgeAracc['SBAracID'];
                                    $digerSoforArac[$d]['DigerSoforAracPlaka'] = $adminSoforBolgeAracc['SBAracPlaka'];
                                    $d++;
                                }
                            }
                            //araç Özellikleri
                            $soforOzellik = $Panel_Model->soforDetail($soforDetailID);
                            $e = 0;
                            foreach ($soforOzellik as $soforOzellikk) {
                                $soforList[$e]['SoforListID'] = $soforOzellikk['BSSoforID'];
                                $soforList[$e]['SoforListAd'] = $soforOzellikk['BSSoforAd'];
                                $soforList[$e]['SoforListSoyad'] = $soforOzellikk['BSSoforSoyad'];
                                $soforList[$e]['SoforListTelefon'] = $soforOzellikk['BSSoforPhone'];
                                $soforList[$e]['SoforListMail'] = $soforOzellikk['BSSoforEmail'];
                                $soforList[$e]['SoforListLokasyon'] = $soforOzellikk['BSSoforLocation'];
                                $soforList[$e]['SoforListUlke'] = $soforOzellikk['BSSoforUlke'];
                                $soforList[$e]['SoforListIl'] = $soforOzellikk['BSSoforIl'];
                                $soforList[$e]['SoforListIlce'] = $soforOzellikk['BSSoforIlce'];
                                $soforList[$e]['SoforListSemt'] = $soforOzellikk['BSSoforSemt'];
                                $soforList[$e]['SoforListMahalle'] = $soforOzellikk['BSSoforMahalle'];
                                $soforList[$e]['SoforListSokak'] = $soforOzellikk['BSSoforSokak'];
                                $soforList[$e]['SoforListPostaKodu'] = $soforOzellikk['BSSoforPostaKodu'];
                                $soforList[$e]['SoforListCaddeNo'] = $soforOzellikk['BSSoforCaddeNo'];
                                $soforList[$e]['SoforListAdres'] = $soforOzellikk['BSSoforAdres'];
                                $soforList[$e]['SoforListDurum'] = $soforOzellikk['Status'];
                                $soforList[$e]['SoforListAciklama'] = $soforOzellikk['BSSoforAciklama'];
                                $e++;
                            }
                        }
                        //sonuçlar
                        $sonuc["soforSelectBolge"] = $selectSoforBolge;
                        $sonuc["soforBolge"] = $digerSoforBolge;
                        $sonuc["soforSelectArac"] = $selectSoforArac;
                        $sonuc["soforArac"] = $digerSoforArac;
                        $sonuc["soforDetail"] = $soforList;
                    }

                    break;

                case "soforDetailDelete":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_ASofor';


                        $form->post('sofordetail_id', true);
                        $soforDetailID = $form->values['sofordetail_id'];

                        $deleteresult = $Panel_Model->detailSoforDelete($soforDetailID);
                        if ($deleteresult) {

                            $deleteresultt = $Panel_Model->detailSoforAracDelete($soforDetailID);
                            if ($deleteresultt) {
                                $deleteresulttt = $Panel_Model->detailSoforBolgeDelete($soforDetailID);
                                if ($deleteresulttt) {
                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                    if ($resultMemcache) {
                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                    }
                                    $sonuc["delete"] = "Şoför kaydı başarıyla silinmiştir.";
                                }
                            } else {
                                $deleteresulttt = $Panel_Model->detailSoforBolgeDelete($soforDetailID);
                                if ($deleteresulttt) {
                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                    if ($resultMemcache) {
                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                    }
                                    $sonuc["delete"] = "Şoför kaydı başarıyla silinmiştir.";
                                }
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    $sonuc["soforDetail"] = $data["soforDetail"];

                    break;

                case "soforDetailKaydet":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('sofordetail_id', true);
                        $soforID = $form->values['sofordetail_id'];

                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_ASofor';

                        $form->post('soforDetayAd', true);
                        $form->post('soforDetaySoyad', true);
                        $form->post('soforDetayEmail', true);
                        $form->post('soforDetayDurum', true);
                        $form->post('soforDetayLokasyon', true);
                        $form->post('soforDetayTelefon', true);
                        $form->post('soforDetayAdres', true);
                        $form->post('soforDetayAciklama', true);
                        $form->post('soforDetayUlke', true);
                        $form->post('soforDetayIl', true);
                        $form->post('soforDetayIlce', true);
                        $form->post('soforDetaySemt', true);
                        $form->post('soforDetayMahalle', true);
                        $form->post('soforDetaySokak', true);
                        $form->post('soforDetayPostaKodu', true);
                        $form->post('soforDetayCaddeNo', true);

                        $soforAd = $form->values['soforDetayAd'];
                        $soforSoyad = $form->values['soforDetaySoyad'];
                        $soforAdSoyad = $soforAd . ' ' . $soforSoyad;

                        $soforBolgeID = $_REQUEST['soforBolgeID'];
                        $soforBolgeAdi = $_REQUEST['soforBolgeAd'];
                        $soforAracID = $_REQUEST['soforAracID'];
                        $soforAracPlaka = $_REQUEST['soforAracPlaka'];

                        if ($form->submit()) {
                            $data = array(
                                'BSSoforAd' => $soforAd,
                                'BSSoforSoyad' => $soforSoyad,
                                'BSSoforPhone' => $form->values['soforDetayTelefon'],
                                'BSSoforEmail' => $form->values['soforDetayEmail'],
                                'BSSoforLocation' => $form->values['soforDetayLokasyon'],
                                'BSSoforUlke' => $form->values['soforDetayUlke'],
                                'BSSoforIl' => $form->values['soforDetayIl'],
                                'BSSoforIlce' => $form->values['soforDetayIlce'],
                                'BSSoforSemt' => $form->values['soforDetaySemt'],
                                'BSSoforMahalle' => $form->values['soforDetayMahalle'],
                                'BSSoforSokak' => $form->values['soforDetaySokak'],
                                'BSSoforPostaKodu' => $form->values['soforDetayPostaKodu'],
                                'BSSoforCaddeNo' => $form->values['soforDetayCaddeNo'],
                                'BSSoforAdres' => $form->values['soforDetayAdres'],
                                'BSSoforAciklama' => $form->values['soforDetayAciklama'],
                                'Status' => $form->values['soforDetayDurum']
                            );
                        }
                        $resultSoforUpdate = $Panel_Model->soforOzelliklerDuzenle($data, $soforID);
                        if ($resultSoforUpdate) {
                            $aracID = count($soforAracID);
                            if ($aracID > 0) {
                                $deleteresultt = $Panel_Model->adminSoforAracDelete($soforID);
                                if ($deleteresultt) {
                                    for ($a = 0; $a < $aracID; $a++) {
                                        $sofordata[$a] = array(
                                            'BSAracID' => $soforAracID[$a],
                                            'BSAracPlaka' => $soforAracPlaka[$a],
                                            'BSSoforID' => $soforID,
                                            'BSSoforAd' => $soforAdSoyad
                                        );
                                    }
                                    $resultSoforUpdate = $Panel_Model->addNewSoforArac($sofordata);
                                    if ($resultSoforUpdate) {
                                        $bolgeID = count($soforBolgeID);
                                        $deleteresulttt = $Panel_Model->adminDetailSoforBolgeDelete($bolgeID);
                                        if ($deleteresulttt) {
                                            for ($b = 0; $b < $bolgeID; $b++) {
                                                $bolgedata[$b] = array(
                                                    'BSSoforID' => $soforID,
                                                    'BSSoforAd' => $soforAdSoyad,
                                                    'BSBolgeID' => $soforBolgeID[$b],
                                                    'BSBolgeAdi' => $soforBolgeAdi[$b]
                                                );
                                            }
                                            $resultBolgeID = $Panel_Model->addNewSoforBolge($bolgedata);
                                            if ($resultBolgeID) {
                                                $resultMemcache = $MemcacheModel->get($uniqueKey);
                                                if ($resultMemcache) {
                                                    $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                                }

                                                $sonuc["newSoforID"] = $soforID;
                                                $sonuc["update"] = "Başarıyla Şoför Düzenlenmiştir.";
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
                            } else {
                                $deleteresultt = $Panel_Model->adminSoforAracDelete($soforID);
                                $deleteresulttt = $Panel_Model->adminDetailSoforBolgeDelete($soforID);
                                if ($deleteresulttt) {
                                    $bolgeID = count($soforBolgeID);
                                    for ($b = 0; $b < $bolgeID; $b++) {
                                        $bolgedata[$b] = array(
                                            'BSSoforID' => $soforID,
                                            'BSSoforAd' => $soforAdSoyad,
                                            'BSBolgeID' => $soforBolgeID[$b],
                                            'BSBolgeAdi' => $soforBolgeAdi[$b]
                                        );
                                    }
                                    $resultBolgeID = $Panel_Model->addNewSoforBolge($bolgedata);
                                    if ($resultBolgeID) {
                                        $resultMemcache = $MemcacheModel->get($uniqueKey);
                                        if ($resultMemcache) {
                                            $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                        }

                                        $sonuc["newSoforID"] = $soforID;
                                        $sonuc["update"] = "Başarıyla Şoför Düzenlenmiştir.";
                                    } else {
                                        $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                    }
                                } else {
                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                }
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                case "SoforDetailMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $soforDetailBolgeID = $_REQUEST['soforDetailBolgeID'];
                        $form->post('soforID', true);
                        $soforID = $form->values['soforID'];

                        //şoföre ait araçlar
                        $adminSoforArac = $Panel_Model->soforDetailMultiSelectSofor($soforID);
                        if (count($adminSoforArac) > 0) {
                            $a = 0;
                            foreach ($adminSoforArac as $adminSoforAracc) {
                                $soforaracId[] = $adminSoforAracc['BSAracID'];
                                $a++;
                            }
                            //şoföre ait araçlar
                            $soforbolgearac = implode(',', $soforaracId);
                            //seçilen bölgeler
                            $soforbolgedizim = implode(',', $soforDetailBolgeID);
                            //seçilen bölgedeki araçlar
                            $SoforBolgeArac = $Panel_Model->adminSelectBolgeAracc($soforbolgedizim);
                            $b = 0;
                            foreach ($SoforBolgeArac as $SoforBolgeAracc) {
                                $soforDigerAracId[] = $SoforBolgeAracc['SBAracID'];
                                $b++;
                            }
                            //gelen arac ıdlerinde aynı olan idler, seçili araçlardır.
                            $ortakIDler = array_intersect($soforaracId, $soforDigerAracId);
                            //gelen idlerde ki farklı olanlar seçili olmayan araçlardır yani diğer araçlar
                            $arac_fark = array_diff($soforDigerAracId, $soforaracId);
                            $diger_arac_fark = implode(',', $arac_fark);

                            //ortak ıd ye sahip arac varmı
                            if (count($ortakIDler) > 0) {
                                //seçili araçlar
                                $secilenIdArac = implode(',', $ortakIDler);
                                $selectBolgeArac = $Panel_Model->soforNotSelectArac($secilenIdArac);
                                $c = 0;
                                foreach ($selectBolgeArac as $selectBolgeAracc) {
                                    $selectSoforArac[$c]['SelectSoforAracID'] = $selectBolgeAracc['SBAracID'];
                                    $selectSoforArac[$c]['SelectSoforAracPlaka'] = $selectBolgeAracc['SBAracPlaka'];
                                    $c++;
                                }

                                //diğer şoförler
                                $digerBolgeArac = $Panel_Model->soforNotSelectArac($soforbolgedizim);

                                $d = 0;
                                foreach ($digerBolgeArac as $digerBolgeAracc) {
                                    $digerSoforArac[$d]['DigerSoforAracID'] = $digerBolgeAracc['SBAracID'];
                                    $digerSoforArac[$d]['DigerSoforAracPlaka'] = $digerBolgeAracc['SBAracPlaka'];
                                    $d++;
                                }
                            } else {
                                //ortak id yoksa seçili şoför yoktur
                                //diğer şoförler
                                $digerBolgeArac = $Panel_Model->soforNotSelectArac($diger_arac_fark);

                                $d = 0;
                                foreach ($digerBolgeArac as $digerBolgeAracc) {
                                    $digerSoforArac[$d]['DigerSoforAracID'] = $digerBolgeAracc['SBAracID'];
                                    $digerSoforArac[$d]['DigerSoforAracPlaka'] = $digerBolgeAracc['SBAracPlaka'];
                                    $d++;
                                }
                            }
                        } else {
                            $soforDetailBollgeID = implode(',', $soforDetailBolgeID);
                            //adamın seçili olab bölgedeki diğer şoförleri
                            $adminAracBolgeSofor = $Panel_Model->adminSelectBolgeAracc($soforDetailBollgeID);

                            $d = 0;
                            foreach ($adminAracBolgeSofor as $adminAracBolgeSoforr) {
                                $digerSoforArac[$d]['DigerSoforAracID'] = $adminAracBolgeSoforr['SBAracID'];
                                $digerSoforArac[$d]['DigerSoforAracPlaka'] = $adminAracBolgeSoforr['SBAracPlaka'];
                                $d++;
                            }
                        }

                        //sonuçlar
                        $sonuc["adminSoforSelectArac"] = $selectSoforArac;
                        $sonuc["adminSoforArac"] = $digerSoforArac;
                    }
                    break;
            }
            echo json_encode($sonuc);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

}
?>

