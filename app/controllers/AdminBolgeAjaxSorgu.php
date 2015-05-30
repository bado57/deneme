<?php

class AdminBolgeAjaxSorgu extends Controller {

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
            //dil yapılandırılması
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (!Session::get("dil")) {
                Session::set("dil", $lang);
                $formm = $this->load->multilanguage($lang);
                $deger = $formm->multilanguage();
            } else {
                $formm = $this->load->multilanguage(Session::get("dil"));
                $deger = $formm->multilanguage();
            }
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            //form class bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");

            $form->post("tip", true);
            $tip = $form->values['tip'];
            $adSoyad = Session::get("kullaniciad") . ' ' . Session::get("kullanicisoyad");
            $bolgeIcon = 'fa fa-th';
            $bolgeUrl = 'bolgeliste';
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
                    error_log("adminRutbe" . $adminRutbe);
                    $uniqueKey = Session::get("username");
                    $uniqueKey = $uniqueKey . '_ABolge';

                    if (!$adminID) {
                        $form->yonlendir(SITE_URL_LOGOUT);
                    } else {
                        $form->post('bolge_adi', true);
                        $form->post('bolge_aciklama', true);
                        $bolgeAdi = $form->values['bolge_adi'];

                        if ($form->submit()) {
                            $data = array(
                                'SBBolgeAdi' => $bolgeAdi,
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
                                $alert = $adSoyad . ' ' . $bolgeAdi . $deger["BolgeEkleme"];
                                //bildirim ayarları
                                if ($adminRutbe != 1) {
                                    $bolgeRenk = 'success';
                                    $dataBildirim = $form->adminBildirimDuzen($alert, $bolgeIcon, $bolgeUrl, $bolgeRenk, $adminID, $adSoyad, 1, 1);
                                    $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                    if ($resultBildirim) {
                                        $resultAdminCihaz = $Panel_Model->adminCihaz();
                                        if (count($resultAdminCihaz) > 0) {
                                            foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                            }
                                            $adminCihaz = implode(',', $adminCihaz);
                                            $form->shuttleNotification($adminCihaz, $alert, $deger["BolgeEkle"]);
                                        }
                                    }
                                }
                                //log ayarları
                                $dataLog = $form->adminLogDuzen($adminID, $adSoyad, 0, $alert);
                                $resultLog = $Panel_Model->addNewAdminLog($dataLog);
                                if ($resultLog) {
                                    $sonuc["newBolgeID"] = $resultIDD;
                                    $sonuc["insert"] = "Başarıyla Yeni bölge Eklenmiştir.";
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
                        $adminRutbe = Session::get("userRutbe");

                        $form->post('bolgedetail_adi', true);
                        $form->post('bolgedetail_aciklama', true);
                        $form->post('bolgedetail_id', true);
                        $adminBolgeDetailID = $form->values['bolgedetail_id'];
                        $bolgeAdi = $form->values['bolgedetail_adi'];

                        if ($form->submit()) {
                            $data = array(
                                'SBBolgeAdi' => $bolgeAdi,
                                'SBBolgeAciklama' => $form->values['bolgedetail_aciklama']
                            );
                        }

                        $resultupdate = $Panel_Model->adminBolgeOzelliklerDuzenle($data, $adminBolgeDetailID);
                        if ($resultupdate) {
                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                            if ($resultMemcache) {
                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                            }
                            $alert = $adSoyad . ' ' . $bolgeAdi . $deger["BolgeDuzenleme"];
                            $bolgeRenk = 'warning';
                            //bildirim ayarları
                            if ($adminRutbe != 1) {//normal admin
                                $resultAdminBolgeler = $Panel_Model->ortakBolge($adminID);
                                foreach ($resultAdminBolgeler as $resultAdminBolgelerr) {
                                    $adminBolge[] = $resultAdminBolgelerr['BSBolgeID'];
                                }
                                $adminBolgeler = implode(',', $adminBolge);
                                $adminIDLer = array(1, $adminID);
                                $adminImplodeID = implode(',', $adminIDLer);
                                $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($adminBolgeler, $adminImplodeID);
                                $adminBolgeCount = count($resultAdminBolgeler);
                                if ($adminBolgeCount > 0) {//diğer adminler
                                    for ($b = 0; $b < $adminBolgeCount; $b++) {
                                        $multiData[$b] = $form->adminBildirimDuzen($alert, $bolgeIcon, $bolgeUrl, $bolgeRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 5);
                                    }
                                    $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                    if ($resultBildirim) {
                                        $adminNotfIDLer = array(1, $adminImplodeID);
                                        $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                        $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                        if (count($resultAdminCihaz) > 0) {
                                            foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                            }
                                            $adminCihaz = implode(',', $adminCihaz);
                                            $form->shuttleNotification($adminCihaz, $alert, $deger["BolgeDuzen"]);
                                        }
                                    }
                                } else {
                                    $dataBildirim = $form->adminBildirimDuzen($alert, $bolgeIcon, $bolgeUrl, $bolgeRenk, $adminID, $adSoyad, 1, 5);
                                    $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                    if ($resultBildirim) {
                                        $resultAdminCihaz = $Panel_Model->adminCihaz();
                                        if (count($resultAdminCihaz) > 0) {
                                            foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                            }
                                            $adminCihaz = implode(',', $adminCihaz);
                                            $form->shuttleNotification($adminCihaz, $alert, $deger["BolgeDuzen"]);
                                        }
                                    }
                                }
                            } else {//üst admin
                                $resultBolgeAdminID = $Panel_Model->ortakAdminBolge($adminBolgeDetailID);
                                $adminIDCount = count($resultBolgeAdminID);
                                if ($adminIDCount > 0) {
                                    for ($b = 0; $b < $adminIDCount; $b++) {
                                        $multiData[$b] = $form->adminBildirimDuzen($alert, $bolgeIcon, $bolgeUrl, $bolgeRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 5);
                                    }
                                    $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                    if ($resultBildirim) {
                                        $adminImplodeID = implode(',', $resultBolgeAdminID);
                                        $adminNotfIDLer = array($adminImplodeID);
                                        $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                        $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                        if (count($resultAdminCihaz) > 0) {
                                            foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                            }
                                            $adminCihaz = implode(',', $adminCihaz);
                                            $form->shuttleNotification($adminCihaz, $alert, $deger["BolgeDuzen"]);
                                        }
                                    }
                                }
                            }
                            //log ayarları
                            $dataLog = $form->adminLogDuzen($adminID, $adSoyad, 0, $alert);
                            $resultLog = $Panel_Model->addNewAdminLog($dataLog);
                            if ($resultLog) {
                                $sonuc["update"] = "Başarıyla Bölgeniz Güncellenmiştir.";
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
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
                        $adminRutbe = Session::get("userRutbe");

                        $form->post('bolgedetail_id', true);
                        $form->post('bolge_adi', true);
                        $adminBolgeDetailID = $form->values['bolgedetail_id'];
                        $bolgeAdi = $form->values['bolge_adi'];

                        $deleteresult = $Panel_Model->adminBolgeDelete($adminBolgeDetailID);
                        if ($deleteresult) {
                            $resultdelete = $Panel_Model->adminBolgeIDDelete($adminBolgeDetailID);
                            if ($resultdelete) {
                                $resultMemcache = $MemcacheModel->get($uniqueKey);
                                if ($resultMemcache) {
                                    $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                }
                                $alert = $adSoyad . ' ' . $bolgeAdi . $deger["BolgeSilme"];
                                $bolgeRenk = 'danger';
                                //bildirim ayarları
                                if ($adminRutbe != 1) {//normal admin
                                    $resultAdminBolgeler = $Panel_Model->ortakBolge($adminID);
                                    foreach ($resultAdminBolgeler as $resultAdminBolgelerr) {
                                        $adminBolge[] = $resultAdminBolgelerr['BSBolgeID'];
                                    }
                                    $adminBolgeler = implode(',', $adminBolge);
                                    $adminIDLer = array(1, $adminID);
                                    $adminImplodeID = implode(',', $adminIDLer);
                                    $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($adminBolgeler, $adminImplodeID);
                                    $adminBolgeCount = count($resultAdminBolgeler);
                                    if ($adminBolgeCount > 0) {//diğer adminler
                                        for ($b = 0; $b < $adminBolgeCount; $b++) {
                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $bolgeIcon, $bolgeUrl, $bolgeRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 3);
                                        }
                                        $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                        if ($resultBildirim) {
                                            $adminNotfIDLer = array(1, $adminImplodeID);
                                            $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                            $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                            if (count($resultAdminCihaz) > 0) {
                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                }
                                                $adminCihaz = implode(',', $adminCihaz);
                                                $form->shuttleNotification($adminCihaz, $alert, $deger["BolgeSil"]);
                                            }
                                        }
                                    } else {
                                        $dataBildirim = $form->adminBildirimDuzen($alert, $bolgeIcon, $bolgeUrl, $bolgeRenk, $adminID, $adSoyad, 1, 3);
                                        $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                        if ($resultBildirim) {
                                            $resultAdminCihaz = $Panel_Model->adminCihaz();
                                            if (count($resultAdminCihaz) > 0) {
                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                }
                                                $adminCihaz = implode(',', $adminCihaz);
                                                $form->shuttleNotification($adminCihaz, $alert, $deger["BolgeSil"]);
                                            }
                                        }
                                    }
                                } else {//üst admin
                                    $resultBolgeAdminID = $Panel_Model->ortakAdminBolge($adminBolgeDetailID);
                                    $adminIDCount = count($resultBolgeAdminID);
                                    if ($adminIDCount > 0) {
                                        for ($b = 0; $b < $adminIDCount; $b++) {
                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $bolgeIcon, $bolgeUrl, $bolgeRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 3);
                                        }
                                        $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                        if ($resultBildirim) {
                                            $adminImplodeID = implode(',', $resultBolgeAdminID);
                                            $adminNotfIDLer = array($adminImplodeID);
                                            $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                            $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                            if (count($resultAdminCihaz) > 0) {
                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                }
                                                $adminCihaz = implode(',', $adminCihaz);
                                                $form->shuttleNotification($adminCihaz, $alert, $deger["BolgeSil"]);
                                            }
                                        }
                                    }
                                }
                                //log ayarları
                                $dataLog = $form->adminLogDuzen($adminID, $adSoyad, 0, $alert);
                                $resultLog = $Panel_Model->addNewAdminLog($dataLog);
                                if ($resultLog) {
                                    $sonuc["delete"] = "Bölge kaydı başarıyla silinmiştir.";
                                } else {
                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                }
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
                        $adminRutbe = Session::get("userRutbe");

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
                        $kurumAd = $form->values['bolgkurumadi'];
                        $adminBolgeDetailID = $form->values['bolgeid'];

                        if ($form->submit()) {
                            $data = array(
                                'SBKurumAdi' => $kurumAd,
                                'SBKurumAciklama' => $form->values['bolgkurumaciklama'],
                                'SBBolgeID' => $adminBolgeDetailID,
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
                            $alert = $adSoyad . ' ' . $kurumAd . $deger["KurumEkleme"];
                            $kurumRenk = 'success';
                            $kurumUrl = 'kurumliste';
                            $kurumIcon = 'fa fa-building-o';
                            //bildirim ayarları
                            if ($adminRutbe != 1) {//normal admin
                                $resultAdminBolgeler = $Panel_Model->ortakBolge($adminID);
                                foreach ($resultAdminBolgeler as $resultAdminBolgelerr) {
                                    $adminBolge[] = $resultAdminBolgelerr['BSBolgeID'];
                                }
                                $adminBolgeler = implode(',', $adminBolge);
                                $adminIDLer = array(1, $adminID);
                                $adminImplodeID = implode(',', $adminIDLer);
                                $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($adminBolgeler, $adminImplodeID);
                                $adminBolgeCount = count($resultAdminBolgeler);
                                if ($adminBolgeCount > 0) {//diğer adminler
                                    for ($b = 0; $b < $adminBolgeCount; $b++) {
                                        $multiData[$b] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 10);
                                    }
                                    $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                    if ($resultBildirim) {
                                        $adminNotfIDLer = array(1, $adminImplodeID);
                                        $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                        $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                        if (count($resultAdminCihaz) > 0) {
                                            foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                            }
                                            $adminCihaz = implode(',', $adminCihaz);
                                            $form->shuttleNotification($adminCihaz, $alert, $deger["KurumEkle"]);
                                        }
                                    }
                                } else {
                                    $dataBildirim = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, 1, 10);
                                    $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                    if ($resultBildirim) {
                                        $resultAdminCihaz = $Panel_Model->adminCihaz();
                                        if (count($resultAdminCihaz) > 0) {
                                            foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                            }
                                            $adminCihaz = implode(',', $adminCihaz);
                                            $form->shuttleNotification($adminCihaz, $alert, $deger["KurumEkle"]);
                                        }
                                    }
                                }
                            } else {//üst admin
                                $resultBolgeAdminID = $Panel_Model->ortakAdminBolge($adminBolgeDetailID);
                                $adminIDCount = count($resultBolgeAdminID);
                                if ($adminIDCount > 0) {
                                    for ($b = 0; $b < $adminIDCount; $b++) {
                                        $multiData[$b] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 10);
                                    }
                                    $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                    if ($resultBildirim) {
                                        $adminImplodeID = implode(',', $resultBolgeAdminID);
                                        $adminNotfIDLer = array($adminImplodeID);
                                        $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                        $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                        if (count($resultAdminCihaz) > 0) {
                                            foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                            }
                                            $adminCihaz = implode(',', $adminCihaz);
                                            $form->shuttleNotification($adminCihaz, $alert, $deger["KurumEkle"]);
                                        }
                                    }
                                }
                            }
                            //log ayarları
                            $dataLog = $form->adminLogDuzen($adminID, $adSoyad, 0, $alert);
                            $resultLog = $Panel_Model->addNewAdminLog($dataLog);
                            if ($resultLog) {
                                $sonuc["newBolgeKurumID"] = $resultKurumID;
                                $sonuc["insert"] = "Başarıyla Bölgenize yeni Kurum Eklenmiştir.";
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    break;

                default :
                    header("Location:" . SITE_URL_LOGOUT);
                    break;
            }
            echo json_encode($sonuc);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

}
?>

