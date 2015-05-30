<?php

class AdminAracAjaxSorgu extends Controller {

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
        $adSoyad = Session::get("kullaniciad") . ' ' . Session::get("kullanicisoyad");
        $bolgeIcon = 'fa fa-th';
        $bolgeUrl = 'bolgeliste';

        if ($_POST && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" && Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
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
            $sonuc = array();
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            //form class bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");

            $form->post("tip", true);
            $tip = $form->values['tip'];

            Switch ($tip) {

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
                        $adminRutbe = Session::get("userRutbe");

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
                        $aracHostesID = $_REQUEST['aracHostesID'];
                        $aracHostesAd = $_REQUEST['aracHostesAd'];
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
                            $hostesID = count($aracHostesID);
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
                                    if ($hostesID > 0) {
                                        for ($h = 0; $h < $soforID; $h++) {
                                            $hostesdata[$h] = array(
                                                'BSAracID' => $resultAracID,
                                                'BSAracPlaka' => $aracPlaka,
                                                'BSHostesID' => $aracHostesID[$h],
                                                'BSHostesAd' => $aracHostesAd[$h]
                                            );
                                        }
                                        $resultHostesID = $Panel_Model->addNewAdminAracHostes($hostesdata);
                                    }

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
                                        $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracEkleme"];
                                        $aracRenk = 'success';
                                        $aracUrl = 'aracliste';
                                        $aracIcon = 'fa fa-bus';
                                        //bildirim ayarları
                                        if ($adminRutbe != 1) {//normal admin
                                            $adminBolgeler = implode(',', $aracBolgeID);
                                            $adminIDLer = array(1, $adminID);
                                            $adminImplodeID = implode(',', $adminIDLer);
                                            $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($adminBolgeler, $adminImplodeID);
                                            $adminBolgeCount = count($resultAdminBolgeler);
                                            if ($adminBolgeCount > 0) {//diğer adminler
                                                for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 11);
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
                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                    }
                                                }
                                            } else {
                                                $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 11);
                                                $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                if ($resultBildirim) {
                                                    $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                    if (count($resultAdminCihaz) > 0) {
                                                        foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                            $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                        }
                                                        $adminCihaz = implode(',', $adminCihaz);
                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                    }
                                                }
                                            }
                                        } else {//üst admin
                                            $adminBolgeler = implode(',', $aracBolgeID);
                                            $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($adminBolgeler);
                                            $adminIDCount = count($resultBolgeAdminID);
                                            if ($adminIDCount > 0) {
                                                for ($b = 0; $b < $adminIDCount; $b++) {
                                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 11);
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
                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                    }
                                                }
                                            }
                                        }
                                        //log ayarları
                                        $dataLog = $form->adminLogDuzen($adminID, $adSoyad, 0, $alert);
                                        $resultLog = $Panel_Model->addNewAdminLog($dataLog);
                                        if ($resultLog) {
                                            $sonuc["newAracID"] = $resultAracID;
                                            $sonuc["insert"] = "Başarıyla Araç Eklenmiştir.";
                                        } else {
                                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                        }
                                    } else {
                                        //arac şofor kaydedilirken bi hata meydana geldi ise
                                        $deleteresult = $Panel_Model->adminAracDelete($resultAracID);

                                        $deleteresultt = $Panel_Model->adminAracSoforDelete($resultAracID);

                                        $deleteresulttt = $Panel_Model->adminAracHostesDelete($resultAracID);
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
                                if ($hostesID > 0) {
                                    for ($h = 0; $h < $soforID; $h++) {
                                        $hostesdata[$h] = array(
                                            'BSAracID' => $resultAracID,
                                            'BSAracPlaka' => $aracPlaka,
                                            'BSHostesID' => $aracHostesID[$h],
                                            'BSHostesAd' => $aracHostesAd[$h]
                                        );
                                    }
                                    $resultHostesID = $Panel_Model->addNewAdminAracHostes($hostesdata);
                                }

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
                                    $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracEkleme"];
                                    $aracRenk = 'success';
                                    $aracUrl = 'aracliste';
                                    $aracIcon = 'fa fa-bus';
                                    //bildirim ayarları
                                    if ($adminRutbe != 1) {//normal admin
                                        $adminBolgeler = implode(',', $aracBolgeID);
                                        $adminIDLer = array(1, $adminID);
                                        $adminImplodeID = implode(',', $adminIDLer);
                                        $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($adminBolgeler, $adminImplodeID);
                                        $adminBolgeCount = count($resultAdminBolgeler);
                                        if ($adminBolgeCount > 0) {//diğer adminler
                                            for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 11);
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
                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                }
                                            }
                                        } else {
                                            $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 11);
                                            $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                            if ($resultBildirim) {
                                                $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                if (count($resultAdminCihaz) > 0) {
                                                    foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                        $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                    }
                                                    $adminCihaz = implode(',', $adminCihaz);
                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                }
                                            }
                                        }
                                    } else {//üst admin
                                        $adminBolgeler = implode(',', $aracBolgeID);
                                        $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($adminBolgeler);
                                        $adminIDCount = count($resultBolgeAdminID);
                                        if ($adminIDCount > 0) {
                                            for ($b = 0; $b < $adminIDCount; $b++) {
                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 11);
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
                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                }
                                            }
                                        }
                                    }
                                    //log ayarları
                                    $dataLog = $form->adminLogDuzen($adminID, $adSoyad, 0, $alert);
                                    $resultLog = $Panel_Model->addNewAdminLog($dataLog);
                                    if ($resultLog) {
                                        $sonuc["newAracID"] = $resultAracID;
                                        $sonuc["insert"] = "Başarıyla Araç Eklenmiştir.";
                                    } else {
                                        $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                    }
                                } else {
                                    //arac şofor kaydedilirken bi hata meydana geldi ise
                                    $deleteresult = $Panel_Model->adminAracDelete($resultAracID);

                                    $deleteresultt = $Panel_Model->adminAracSoforDelete($resultAracID);

                                    $deleteresulttt = $Panel_Model->adminAracHostesDelete($resultAracID);
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
                            //admin araç hostes
                            $adminAracHostes = $Panel_Model->adminDetailAracHostes($adminAracDetailID);
                            $aracSoforCount = count($adminAracSofor);
                            $aracHostesCount = count($adminAracHostes);
                            //eğer aracın seçili şoförü varsa burası gelecek
                            if ($aracSoforCount > 0) {
                                if ($aracHostesCount > 0) {
                                    //arac Hostes idler
                                    $h = 0;
                                    foreach ($adminAracHostes as $adminAracHostess) {
                                        $selectAracHostes[$h]['SelectAracHostesID'] = $adminAracHostess['BSHostesID'];
                                        $selectAracHostes[$h]['SelectAracHostesAdi'] = $adminAracHostess['BSHostesAd'];
                                        $arachostesId[] = $adminAracHostess['BSHostesID'];
                                        $h++;
                                    }
                                    //seçili olan bölge
                                    $aracbolgedizim = implode(',', $aracbolgeId);
                                    //seöili olan hostes
                                    $aracbolgehostes = implode(',', $arachostesId);
                                    //adamın seçili olab bölgedeki diğer hostesleri
                                    $adminAracBolgeHostes = $Panel_Model->adminSelectBolgeHostes($aracbolgedizim, $aracbolgehostes);

                                    if (count($adminAracBolgeHostes) > 0) {

                                        $t = 0;
                                        foreach ($adminAracBolgeHostes as $adminAracBolgeHostess) {
                                            $digerAracHostes[$t]['DigerAracHostesID'] = $adminAracBolgeHostess['BSHostesID'];
                                            $digerAracHostes[$t]['DigerAracHostesAdi'] = $adminAracBolgeHostess['BSHostesAd'];
                                            $t++;
                                        }
                                    }
                                } else {
                                    //seçili olan bölge
                                    $aracbolgedizim = implode(',', $aracbolgeId);
                                    //adamın seçili olab bölgedeki diğer hostesi
                                    $adminAracBolgeHostes = $Panel_Model->adminSelectBolgeHostess($aracbolgedizim);

                                    $t = 0;
                                    foreach ($adminAracBolgeHostes as $adminAracBolgeHostess) {
                                        $digerAracHostes[$t]['DigerAracHostesID'] = $adminAracBolgeHostess['BSHostesID'];
                                        $digerAracHostes[$t]['DigerAracHostesAdi'] = $adminAracBolgeHostess['BSHostesAd'];
                                        $t++;
                                    }
                                }

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
                                if ($aracHostesCount > 0) {
                                    //arac Hostes idler
                                    $h = 0;
                                    foreach ($adminAracHostes as $adminAracHostess) {
                                        $selectAracHostes[$h]['SelectAracHostesID'] = $adminAracHostess['BSHostesID'];
                                        $selectAracHostes[$h]['SelectAracHostesAdi'] = $adminAracHostess['BSHostesAd'];
                                        $arachostesId[] = $adminAracHostess['BSHostesID'];
                                        $h++;
                                    }
                                    //seçili olan bölge
                                    $aracbolgedizim = implode(',', $aracbolgeId);
                                    //seöili olan hostes
                                    $aracbolgehostes = implode(',', $arachostesId);
                                    //adamın seçili olab bölgedeki diğer hostesleri
                                    $adminAracBolgeHostes = $Panel_Model->adminSelectBolgeHostes($aracbolgedizim, $aracbolgehostes);

                                    if (count($adminAracBolgeHostes) > 0) {

                                        $t = 0;
                                        foreach ($adminAracBolgeHostes as $adminAracBolgeHostess) {
                                            $digerAracHostes[$t]['DigerAracHostesID'] = $adminAracBolgeHostess['BSHostesID'];
                                            $digerAracHostes[$t]['DigerAracHostesAdi'] = $adminAracBolgeHostess['BSHostesAd'];
                                            $t++;
                                        }
                                    }
                                } else {
                                    //seçili olan bölge
                                    $aracbolgedizim = implode(',', $aracbolgeId);
                                    //adamın seçili olab bölgedeki diğer hostesi
                                    $adminAracBolgeHostes = $Panel_Model->adminSelectBolgeHostess($aracbolgedizim);

                                    $t = 0;
                                    foreach ($adminAracBolgeHostes as $adminAracBolgeHostess) {
                                        $digerAracHostes[$t]['DigerAracHostesID'] = $adminAracBolgeHostess['BSHostesID'];
                                        $digerAracHostes[$t]['DigerAracHostesAdi'] = $adminAracBolgeHostess['BSHostesAd'];
                                        $t++;
                                    }
                                }

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
                            //araç şoförler
                            $adminAracSofor = $Panel_Model->adminDetailAracSofor($adminAracDetailID);
                            //araç hostesler
                            $adminAracHostes = $Panel_Model->adminDetailAracHostes($adminAracDetailID);
                            $aracSoforCount = count($adminAracSofor);
                            $aracHostesCount = count($adminAracHostes);
                            if ($aracSoforCount > 0) {
                                if ($aracHostesCount > 0) {
                                    //arac Hostes idler
                                    $h = 0;
                                    foreach ($adminAracHostes as $adminAracHostess) {
                                        $selectAracHostes[$h]['SelectAracHostesID'] = $adminAracHostess['BSHostesID'];
                                        $selectAracHostes[$h]['SelectAracHostesAdi'] = $adminAracHostess['BSHostesAd'];
                                        $arachostesId[] = $adminAracHostess['BSHostesID'];
                                        $h++;
                                    }
                                    //seçili olan bölge
                                    $aracbolgedizim = implode(',', $aracbolgeId);
                                    //seöili olan hostes
                                    $aracbolgehostes = implode(',', $arachostesId);
                                    //adamın seçili olab bölgedeki diğer hostesleri
                                    $adminAracBolgeHostes = $Panel_Model->adminSelectBolgeHostes($aracbolgedizim, $aracbolgehostes);

                                    if (count($adminAracBolgeHostes) > 0) {

                                        $t = 0;
                                        foreach ($adminAracBolgeHostes as $adminAracBolgeHostess) {
                                            $digerAracHostes[$t]['DigerAracHostesID'] = $adminAracBolgeHostess['BSHostesID'];
                                            $digerAracHostes[$t]['DigerAracHostesAdi'] = $adminAracBolgeHostess['BSHostesAd'];
                                            $t++;
                                        }
                                    }
                                } else {
                                    //seçili olan bölge
                                    $aracbolgedizim = implode(',', $aracbolgeId);
                                    //adamın seçili olab bölgedeki diğer hostesi
                                    $adminAracBolgeHostes = $Panel_Model->adminSelectBolgeHostess($aracbolgedizim);

                                    $t = 0;
                                    foreach ($adminAracBolgeHostes as $adminAracBolgeHostess) {
                                        $digerAracHostes[$t]['DigerAracHostesID'] = $adminAracBolgeHostess['BSHostesID'];
                                        $digerAracHostes[$t]['DigerAracHostesAdi'] = $adminAracBolgeHostess['BSHostesAd'];
                                        $t++;
                                    }
                                }
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
                                if ($aracHostesCount > 0) {
                                    //arac Hostes idler
                                    $h = 0;
                                    foreach ($adminAracHostes as $adminAracHostess) {
                                        $selectAracHostes[$h]['SelectAracHostesID'] = $adminAracHostess['BSHostesID'];
                                        $selectAracHostes[$h]['SelectAracHostesAdi'] = $adminAracHostess['BSHostesAd'];
                                        $arachostesId[] = $adminAracHostess['BSHostesID'];
                                        $h++;
                                    }
                                    //seçili olan bölge
                                    $aracbolgedizim = implode(',', $aracbolgeId);
                                    //seçili olan hostes
                                    $aracbolgehostes = implode(',', $arachostesId);
                                    //adamın seçili olab bölgedeki diğer hostesleri
                                    $adminAracBolgeHostes = $Panel_Model->adminSelectBolgeHostes($aracbolgedizim, $aracbolgehostes);

                                    if (count($adminAracBolgeHostes) > 0) {
                                        $t = 0;
                                        foreach ($adminAracBolgeHostes as $adminAracBolgeHostess) {
                                            $digerAracHostes[$t]['DigerAracHostesID'] = $adminAracBolgeHostess['BSHostesID'];
                                            $digerAracHostes[$t]['DigerAracHostesAdi'] = $adminAracBolgeHostess['BSHostesAd'];
                                            $t++;
                                        }
                                    }
                                } else {
                                    //seçili olan bölge
                                    $aracbolgedizim = implode(',', $aracbolgeId);
                                    //adamın seçili olab bölgedeki diğer hostesi
                                    $adminAracBolgeHostes = $Panel_Model->adminSelectBolgeHostess($aracbolgedizim);

                                    $t = 0;
                                    foreach ($adminAracBolgeHostes as $adminAracBolgeHostess) {
                                        $digerAracHostes[$t]['DigerAracHostesID'] = $adminAracBolgeHostess['BSHostesID'];
                                        $digerAracHostes[$t]['DigerAracHostesAdi'] = $adminAracBolgeHostess['BSHostesAd'];
                                        $t++;
                                    }
                                }

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
                        $sonuc["adminAracSelectHostes"] = $selectAracHostes;
                        $sonuc["adminAracHostes"] = $digerAracHostes;
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
                        $adminRutbe = Session::get("userRutbe");

                        $form->post('aracdetail_id', true);
                        $form->post('arac_plaka', true);
                        $adminAracDetailID = $form->values['aracdetail_id'];
                        $aracPlak = $form->values['arac_plaka'];
                        $aracPlaka = strtoupper($aracPlak);
                        $aracBolgeID = $_REQUEST['aracBolgeID'];

                        $deleteresult = $Panel_Model->adminDetailAracDelete($adminAracDetailID);
                        if ($deleteresult) {
                            $deleteresultt = $Panel_Model->adminDetailAracSoforDelete($adminAracDetailID);
                            if ($deleteresultt) {
                                $deletehostes = $Panel_Model->adminDetailAracHostesDelete($adminAracDetailID);
                                if ($deletehostes) {
                                    $deleteresulttt = $Panel_Model->adminDetailAracBolgeDelete($adminAracDetailID);
                                    if ($deleteresulttt) {
                                        $resultMemcache = $MemcacheModel->get($uniqueKey);
                                        if ($resultMemcache) {
                                            $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                        }
                                        $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracSilme"];
                                        $aracRenk = 'danger';
                                        $aracUrl = 'aracliste';
                                        $aracIcon = 'fa fa-bus';
                                        //bildirim ayarları
                                        if ($adminRutbe != 1) {//normal admin
                                            $adminBolgeler = implode(',', $aracBolgeID);
                                            $adminIDLer = array(1, $adminID);
                                            $adminImplodeID = implode(',', $adminIDLer);
                                            $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($adminBolgeler, $adminImplodeID);
                                            $adminBolgeCount = count($resultAdminBolgeler);
                                            if ($adminBolgeCount > 0) {//diğer adminler
                                                for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 31);
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
                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                    }
                                                }
                                            } else {
                                                $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 31);
                                                $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                if ($resultBildirim) {
                                                    $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                    if (count($resultAdminCihaz) > 0) {
                                                        foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                            $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                        }
                                                        $adminCihaz = implode(',', $adminCihaz);
                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                    }
                                                }
                                            }
                                        } else {//üst admin
                                            $adminBolgeler = implode(',', $aracBolgeID);
                                            $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($adminBolgeler);
                                            $adminIDCount = count($resultBolgeAdminID);
                                            if ($adminIDCount > 0) {
                                                for ($b = 0; $b < $adminIDCount; $b++) {
                                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 31);
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
                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                    }
                                                }
                                            }
                                        }
                                        //log ayarları
                                        $dataLog = $form->adminLogDuzen($adminID, $adSoyad, 0, $alert);
                                        $resultLog = $Panel_Model->addNewAdminLog($dataLog);
                                        if ($resultLog) {
                                            $sonuc["delete"] = "Araç kaydı başarıyla silinmiştir.";
                                        } else {
                                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                        }
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
                                $deletehostes = $Panel_Model->adminDetailAracHostesDelete($adminAracDetailID);
                                if ($deletehostes) {
                                    $deleteresulttt = $Panel_Model->adminDetailAracBolgeDelete($adminAracDetailID);
                                    if ($deleteresulttt) {
                                        $resultMemcache = $MemcacheModel->get($uniqueKey);
                                        if ($resultMemcache) {
                                            $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                        }
                                        $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracSilme"];
                                        $aracRenk = 'danger';
                                        $aracUrl = 'aracliste';
                                        $aracIcon = 'fa fa-bus';
                                        //bildirim ayarları
                                        if ($adminRutbe != 1) {//normal admin
                                            $adminBolgeler = implode(',', $aracBolgeID);
                                            $adminIDLer = array(1, $adminID);
                                            $adminImplodeID = implode(',', $adminIDLer);
                                            $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($adminBolgeler, $adminImplodeID);
                                            $adminBolgeCount = count($resultAdminBolgeler);
                                            if ($adminBolgeCount > 0) {//diğer adminler
                                                for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 31);
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
                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                    }
                                                }
                                            } else {
                                                $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 31);
                                                $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                if ($resultBildirim) {
                                                    $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                    if (count($resultAdminCihaz) > 0) {
                                                        foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                            $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                        }
                                                        $adminCihaz = implode(',', $adminCihaz);
                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                    }
                                                }
                                            }
                                        } else {//üst admin
                                            $adminBolgeler = implode(',', $aracBolgeID);
                                            $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($adminBolgeler);
                                            $adminIDCount = count($resultBolgeAdminID);
                                            if ($adminIDCount > 0) {
                                                for ($b = 0; $b < $adminIDCount; $b++) {
                                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 31);
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
                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                    }
                                                }
                                            }
                                        }
                                        //log ayarları
                                        $dataLog = $form->adminLogDuzen($adminID, $adSoyad, 0, $alert);
                                        $resultLog = $Panel_Model->addNewAdminLog($dataLog);
                                        if ($resultLog) {
                                            $sonuc["delete"] = "Araç kaydı başarıyla silinmiştir.";
                                        } else {
                                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                        }
                                    }
                                } else {
                                    $deleteresulttt = $Panel_Model->adminDetailAracBolgeDelete($adminAracDetailID);
                                    if ($deleteresulttt) {
                                        $resultMemcache = $MemcacheModel->get($uniqueKey);
                                        if ($resultMemcache) {
                                            $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                        }
                                        $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracSilme"];
                                        $aracRenk = 'danger';
                                        $aracUrl = 'aracliste';
                                        $aracIcon = 'fa fa-bus';
                                        //bildirim ayarları
                                        if ($adminRutbe != 1) {//normal admin
                                            $adminBolgeler = implode(',', $aracBolgeID);
                                            $adminIDLer = array(1, $adminID);
                                            $adminImplodeID = implode(',', $adminIDLer);
                                            $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($adminBolgeler, $adminImplodeID);
                                            $adminBolgeCount = count($resultAdminBolgeler);
                                            if ($adminBolgeCount > 0) {//diğer adminler
                                                for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 31);
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
                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                    }
                                                }
                                            } else {
                                                $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 31);
                                                $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                if ($resultBildirim) {
                                                    $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                    if (count($resultAdminCihaz) > 0) {
                                                        foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                            $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                        }
                                                        $adminCihaz = implode(',', $adminCihaz);
                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                    }
                                                }
                                            }
                                        } else {//üst admin
                                            $adminBolgeler = implode(',', $aracBolgeID);
                                            $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($adminBolgeler);
                                            $adminIDCount = count($resultBolgeAdminID);
                                            if ($adminIDCount > 0) {
                                                for ($b = 0; $b < $adminIDCount; $b++) {
                                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 31);
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
                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                    }
                                                }
                                            }
                                        }
                                        //log ayarları
                                        $dataLog = $form->adminLogDuzen($adminID, $adSoyad, 0, $alert);
                                        $resultLog = $Panel_Model->addNewAdminLog($dataLog);
                                        if ($resultLog) {
                                            $sonuc["delete"] = "Araç kaydı başarıyla silinmiştir.";
                                        } else {
                                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                        }
                                    }
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
                        $adminRutbe = Session::get("userRutbe");

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
                        $aracHostesID = $_REQUEST['aracHostesID'];
                        $aracHostesAd = $_REQUEST['aracHostesAd'];
                        $aracBolgeAd = $_REQUEST['aracBolgeAd'];
                        $aracBolgeID = $_REQUEST['aracBolgeID'];
                        $aracEskiBolgeID = $_REQUEST['aracEskiBolgeID'];

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
                            $hostesID = count($aracHostesID);
                            if ($soforID > 0) {
                                $deleteresultt = $Panel_Model->adminAracSoforDelete($aracID);
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
                                    //hostes seçildi ise
                                    if ($hostesID > 0) {
                                        $deletehostes = $Panel_Model->adminAracHostesDelete($aracID);
                                        for ($h = 0; $h < $hostesID; $h++) {
                                            $hostesdata[$h] = array(
                                                'BSAracID' => $aracID,
                                                'BSAracPlaka' => $aracPlaka,
                                                'BSHostesID' => $aracHostesID[$h],
                                                'BSHostesAd' => $aracHostesAd[$h]
                                            );
                                        }
                                        $resultHostesUpdate = $Panel_Model->addNewAdminAracHostes($hostesdata);
                                    }
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

                                            //yeni bölge ile eski bölge arasıdnaki farklar
                                            if (count($aracBolgeID) >= count($aracEskiBolgeID)) {
                                                $bolgeIDEklenen = array_diff($aracBolgeID, $aracEskiBolgeID);
                                                if (count($bolgeIDEklenen) > 0) {//fark var
                                                    //yeni bölge eklenmiş
                                                    $yeniEklenen = implode(",", $bolgeIDEklenen);
                                                    //yeni eklenen bölge ayarı
                                                    $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracEkleme"];
                                                    $aracRenk = 'success';
                                                    $aracUrl = 'aracliste';
                                                    $aracIcon = 'fa fa-bus';
                                                    //bildirim ayarları
                                                    if ($adminRutbe != 1) {//normal admin
                                                        $adminIDLer = array(1, $adminID);
                                                        $adminImplodeID = implode(',', $adminIDLer);
                                                        $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($yeniEklenen, $adminImplodeID);
                                                        $adminBolgeCount = count($resultAdminBolgeler);
                                                        if ($adminBolgeCount > 0) {//diğer adminler
                                                            for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 11);
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
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                                }
                                                            }
                                                        } else {
                                                            $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 11);
                                                            $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                            if ($resultBildirim) {
                                                                $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                                if (count($resultAdminCihaz) > 0) {
                                                                    foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                        $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                                    }
                                                                    $adminCihaz = implode(',', $adminCihaz);
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                                }
                                                            }
                                                        }
                                                    } else {//üst admin
                                                        $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($yeniEklenen);
                                                        $adminIDCount = count($resultBolgeAdminID);
                                                        if ($adminIDCount > 0) {
                                                            for ($b = 0; $b < $adminIDCount; $b++) {
                                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 11);
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
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                                }
                                                            }
                                                        }
                                                    }

                                                    $bolgeIDSilinen = array_diff($aracEskiBolgeID, $aracBolgeID);
                                                    if (count($bolgeIDSilinen) > 0) {
                                                        $yeniSilinen = implode(",", $bolgeIDSilinen);
                                                        //bölgeden araç silindi
                                                        $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracSilme"];
                                                        $aracRenk = 'danger';
                                                        $aracUrl = 'aracliste';
                                                        $aracIcon = 'fa fa-bus';
                                                        //bildirim ayarları
                                                        if ($adminRutbe != 1) {//normal admin
                                                            $adminIDLer = array(1, $adminID);
                                                            $adminImplodeID = implode(',', $adminIDLer);
                                                            $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($yeniSilinen, $adminImplodeID);
                                                            $adminBolgeCount = count($resultAdminBolgeler);
                                                            if ($adminBolgeCount > 0) {//diğer adminler
                                                                for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 31);
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
                                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                                    }
                                                                }
                                                            } else {
                                                                $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 31);
                                                                $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                                if ($resultBildirim) {
                                                                    $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                                    if (count($resultAdminCihaz) > 0) {
                                                                        foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                            $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                                        }
                                                                        $adminCihaz = implode(',', $adminCihaz);
                                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                                    }
                                                                }
                                                            }
                                                        } else {//üst admin
                                                            $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($yeniSilinen);
                                                            $adminIDCount = count($resultBolgeAdminID);
                                                            if ($adminIDCount > 0) {
                                                                for ($b = 0; $b < $adminIDCount; $b++) {
                                                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 31);
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
                                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {//fark yok sa demekki dizide değişiklik yok yani dizi ile ilgili düzenleme yapılmakta
                                                    $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracDuzenleme"];
                                                    $aracRenk = 'warning';
                                                    $aracUrl = 'aracliste';
                                                    $aracIcon = 'fa fa-bus';
                                                    //bildirim ayarları
                                                    if ($adminRutbe != 1) {//normal admin
                                                        $adminBolgeler = implode(',', $aracBolgeID);
                                                        $adminIDLer = array(1, $adminID);
                                                        $adminImplodeID = implode(',', $adminIDLer);
                                                        $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($adminBolgeler, $adminImplodeID);
                                                        $adminBolgeCount = count($resultAdminBolgeler);
                                                        if ($adminBolgeCount > 0) {//diğer adminler
                                                            for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 51);
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
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                                }
                                                            }
                                                        } else {
                                                            $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 51);
                                                            $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                            if ($resultBildirim) {
                                                                $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                                if (count($resultAdminCihaz) > 0) {
                                                                    foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                        $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                                    }
                                                                    $adminCihaz = implode(',', $adminCihaz);
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                                }
                                                            }
                                                        }
                                                    } else {//üst admin
                                                        $adminBolgeler = implode(',', $aracBolgeID);
                                                        $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($adminBolgeler);
                                                        $adminIDCount = count($resultBolgeAdminID);
                                                        if ($adminIDCount > 0) {
                                                            for ($b = 0; $b < $adminIDCount; $b++) {
                                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 51);
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
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            } else {
                                                $bolgeIDEklenen = array_diff($aracBolgeID, $aracEskiBolgeID);
                                                if (count($bolgeIDEklenen) > 0) {//fark var
                                                    $yeniEklenen = implode(",", $bolgeIDEklenen);
                                                    //yeni eklenen bölge ayarı
                                                    $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracEkleme"];
                                                    $aracRenk = 'success';
                                                    $aracUrl = 'aracliste';
                                                    $aracIcon = 'fa fa-bus';
                                                    //bildirim ayarları
                                                    if ($adminRutbe != 1) {//normal admin
                                                        $adminIDLer = array(1, $adminID);
                                                        $adminImplodeID = implode(',', $adminIDLer);
                                                        $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($yeniEklenen, $adminImplodeID);
                                                        $adminBolgeCount = count($resultAdminBolgeler);
                                                        if ($adminBolgeCount > 0) {//diğer adminler
                                                            for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 11);
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
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                                }
                                                            }
                                                        } else {
                                                            $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 11);
                                                            $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                            if ($resultBildirim) {
                                                                $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                                if (count($resultAdminCihaz) > 0) {
                                                                    foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                        $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                                    }
                                                                    $adminCihaz = implode(',', $adminCihaz);
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                                }
                                                            }
                                                        }
                                                    } else {//üst admin
                                                        $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($yeniEklenen);
                                                        $adminIDCount = count($resultBolgeAdminID);
                                                        if ($adminIDCount > 0) {
                                                            for ($b = 0; $b < $adminIDCount; $b++) {
                                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 11);
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
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                                }
                                                            }
                                                        }
                                                    }

                                                    $bolgeIDSilinen = array_diff($aracEskiBolgeID, $aracBolgeID);
                                                    if (count($bolgeIDSilinen) > 0) {
                                                        $yeniSilinen = implode(",", $bolgeIDSilinen);
                                                        //bölgeden araç silindi
                                                        $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracSilme"];
                                                        $aracRenk = 'danger';
                                                        $aracUrl = 'aracliste';
                                                        $aracIcon = 'fa fa-bus';
                                                        //bildirim ayarları
                                                        if ($adminRutbe != 1) {//normal admin
                                                            $adminIDLer = array(1, $adminID);
                                                            $adminImplodeID = implode(',', $adminIDLer);
                                                            $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($yeniSilinen, $adminImplodeID);
                                                            $adminBolgeCount = count($resultAdminBolgeler);
                                                            if ($adminBolgeCount > 0) {//diğer adminler
                                                                for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 31);
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
                                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                                    }
                                                                }
                                                            } else {
                                                                $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 31);
                                                                $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                                if ($resultBildirim) {
                                                                    $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                                    if (count($resultAdminCihaz) > 0) {
                                                                        foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                            $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                                        }
                                                                        $adminCihaz = implode(',', $adminCihaz);
                                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                                    }
                                                                }
                                                            }
                                                        } else {//üst admin
                                                            $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($yeniSilinen);
                                                            $adminIDCount = count($resultBolgeAdminID);
                                                            if ($adminIDCount > 0) {
                                                                for ($b = 0; $b < $adminIDCount; $b++) {
                                                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 31);
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
                                                                        $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {//fark yok sa demekki dizide değişiklik yok yani dizi ile ilgili düzenleme yapılmakta
                                                    $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracDuzenleme"];
                                                    $aracRenk = 'warning';
                                                    $aracUrl = 'aracliste';
                                                    $aracIcon = 'fa fa-bus';
                                                    //bildirim ayarları
                                                    if ($adminRutbe != 1) {//normal admin
                                                        $adminBolgeler = implode(',', $aracBolgeID);
                                                        $adminIDLer = array(1, $adminID);
                                                        $adminImplodeID = implode(',', $adminIDLer);
                                                        $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($adminBolgeler, $adminImplodeID);
                                                        $adminBolgeCount = count($resultAdminBolgeler);
                                                        if ($adminBolgeCount > 0) {//diğer adminler
                                                            for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 51);
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
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                                }
                                                            }
                                                        } else {
                                                            $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 51);
                                                            $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                            if ($resultBildirim) {
                                                                $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                                if (count($resultAdminCihaz) > 0) {
                                                                    foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                        $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                                    }
                                                                    $adminCihaz = implode(',', $adminCihaz);
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                                }
                                                            }
                                                        }
                                                    } else {//üst admin
                                                        $adminBolgeler = implode(',', $aracBolgeID);
                                                        $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($adminBolgeler);
                                                        $adminIDCount = count($resultBolgeAdminID);
                                                        if ($adminIDCount > 0) {
                                                            for ($b = 0; $b < $adminIDCount; $b++) {
                                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 51);
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
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            //düzenleme yapılırken ortak bölge id leri için
                                            $bolgeIDOrtak = array_intersect($aracBolgeID, $aracEskiBolgeID);
                                            if (count($bolgeIDOrtak) > 0) {
                                                $yeniOrtakBolge = implode(",", $bolgeIDOrtak);
                                                //bölgeden araç düzenleme
                                                $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracDuzenleme"];
                                                $aracRenk = 'warning';
                                                $aracUrl = 'aracliste';
                                                $aracIcon = 'fa fa-bus';
                                                //bildirim ayarları
                                                if ($adminRutbe != 1) {//normal admin
                                                    $adminIDLer = array(1, $adminID);
                                                    $adminImplodeID = implode(',', $adminIDLer);
                                                    $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($yeniOrtakBolge, $adminImplodeID);
                                                    $adminBolgeCount = count($resultAdminBolgeler);
                                                    if ($adminBolgeCount > 0) {//diğer adminler
                                                        for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 31);
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
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                            }
                                                        }
                                                    } else {
                                                        $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 31);
                                                        $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                        if ($resultBildirim) {
                                                            $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                            if (count($resultAdminCihaz) > 0) {
                                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                                }
                                                                $adminCihaz = implode(',', $adminCihaz);
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                            }
                                                        }
                                                    }
                                                } else {//üst admin
                                                    $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($yeniOrtakBolge);
                                                    $adminIDCount = count($resultBolgeAdminID);
                                                    if ($adminIDCount > 0) {
                                                        for ($b = 0; $b < $adminIDCount; $b++) {
                                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 31);
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
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracDuzenleme"];
                                            //log ayarları
                                            $dataLog = $form->adminLogDuzen($adminID, $adSoyad, 0, $alert);
                                            $resultLog = $Panel_Model->addNewAdminLog($dataLog);
                                            if ($resultLog) {
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
                                //hostes seçildi ise
                                if ($hostesID > 0) {
                                    $deletehostes = $Panel_Model->adminAracHostesDelete($aracID);
                                    for ($h = 0; $h < $hostesID; $h++) {
                                        $hostesdata[$h] = array(
                                            'BSAracID' => $aracID,
                                            'BSAracPlaka' => $aracPlaka,
                                            'BSHostesID' => $aracHostesID[$h],
                                            'BSHostesAd' => $aracHostesAd[$h]
                                        );
                                    }
                                    $resultHostesUpdate = $Panel_Model->addNewAdminAracHostes($hostesdata);
                                }
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
                                        //yeni bölge ile eski bölge arasıdnaki farklar
                                        if (count($aracBolgeID) >= count($aracEskiBolgeID)) {
                                            $bolgeIDEklenen = array_diff($aracBolgeID, $aracEskiBolgeID);
                                            if (count($bolgeIDEklenen) > 0) {//fark var
                                                //yeni bölge eklenmiş
                                                $yeniEklenen = implode(",", $bolgeIDEklenen);
                                                //yeni eklenen bölge ayarı
                                                $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracEkleme"];
                                                $aracRenk = 'success';
                                                $aracUrl = 'aracliste';
                                                $aracIcon = 'fa fa-bus';
                                                //bildirim ayarları
                                                if ($adminRutbe != 1) {//normal admin
                                                    $adminIDLer = array(1, $adminID);
                                                    $adminImplodeID = implode(',', $adminIDLer);
                                                    $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($yeniEklenen, $adminImplodeID);
                                                    $adminBolgeCount = count($resultAdminBolgeler);
                                                    if ($adminBolgeCount > 0) {//diğer adminler
                                                        for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 11);
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
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                            }
                                                        }
                                                    } else {
                                                        $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 11);
                                                        $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                        if ($resultBildirim) {
                                                            $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                            if (count($resultAdminCihaz) > 0) {
                                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                                }
                                                                $adminCihaz = implode(',', $adminCihaz);
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                            }
                                                        }
                                                    }
                                                } else {//üst admin
                                                    $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($yeniEklenen);
                                                    $adminIDCount = count($resultBolgeAdminID);
                                                    if ($adminIDCount > 0) {
                                                        for ($b = 0; $b < $adminIDCount; $b++) {
                                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 11);
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
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                            }
                                                        }
                                                    }
                                                }

                                                $bolgeIDSilinen = array_diff($aracEskiBolgeID, $aracBolgeID);
                                                if (count($bolgeIDSilinen) > 0) {
                                                    $yeniSilinen = implode(",", $bolgeIDSilinen);
                                                    //bölgeden araç silindi
                                                    $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracSilme"];
                                                    $aracRenk = 'danger';
                                                    $aracUrl = 'aracliste';
                                                    $aracIcon = 'fa fa-bus';
                                                    //bildirim ayarları
                                                    if ($adminRutbe != 1) {//normal admin
                                                        $adminIDLer = array(1, $adminID);
                                                        $adminImplodeID = implode(',', $adminIDLer);
                                                        $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($yeniSilinen, $adminImplodeID);
                                                        $adminBolgeCount = count($resultAdminBolgeler);
                                                        if ($adminBolgeCount > 0) {//diğer adminler
                                                            for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 31);
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
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                                }
                                                            }
                                                        } else {
                                                            $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 31);
                                                            $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                            if ($resultBildirim) {
                                                                $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                                if (count($resultAdminCihaz) > 0) {
                                                                    foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                        $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                                    }
                                                                    $adminCihaz = implode(',', $adminCihaz);
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                                }
                                                            }
                                                        }
                                                    } else {//üst admin
                                                        $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($yeniSilinen);
                                                        $adminIDCount = count($resultBolgeAdminID);
                                                        if ($adminIDCount > 0) {
                                                            for ($b = 0; $b < $adminIDCount; $b++) {
                                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 31);
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
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            } else {//fark yok sa demekki dizide değişiklik yok yani dizi ile ilgili düzenleme yapılmakta
                                                $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracDuzenleme"];
                                                $aracRenk = 'warning';
                                                $aracUrl = 'aracliste';
                                                $aracIcon = 'fa fa-bus';
                                                //bildirim ayarları
                                                if ($adminRutbe != 1) {//normal admin
                                                    $adminBolgeler = implode(',', $aracBolgeID);
                                                    $adminIDLer = array(1, $adminID);
                                                    $adminImplodeID = implode(',', $adminIDLer);
                                                    $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($adminBolgeler, $adminImplodeID);
                                                    $adminBolgeCount = count($resultAdminBolgeler);
                                                    if ($adminBolgeCount > 0) {//diğer adminler
                                                        for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 51);
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
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                            }
                                                        }
                                                    } else {
                                                        $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 51);
                                                        $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                        if ($resultBildirim) {
                                                            $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                            if (count($resultAdminCihaz) > 0) {
                                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                                }
                                                                $adminCihaz = implode(',', $adminCihaz);
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                            }
                                                        }
                                                    }
                                                } else {//üst admin
                                                    $adminBolgeler = implode(',', $aracBolgeID);
                                                    $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($adminBolgeler);
                                                    $adminIDCount = count($resultBolgeAdminID);
                                                    if ($adminIDCount > 0) {
                                                        for ($b = 0; $b < $adminIDCount; $b++) {
                                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 51);
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
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            $bolgeIDEklenen = array_diff($aracBolgeID, $aracEskiBolgeID);
                                            if (count($bolgeIDEklenen) > 0) {//fark var
                                                $yeniEklenen = implode(",", $bolgeIDEklenen);
                                                //yeni eklenen bölge ayarı
                                                $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracEkleme"];
                                                $aracRenk = 'success';
                                                $aracUrl = 'aracliste';
                                                $aracIcon = 'fa fa-bus';
                                                //bildirim ayarları
                                                if ($adminRutbe != 1) {//normal admin
                                                    $adminIDLer = array(1, $adminID);
                                                    $adminImplodeID = implode(',', $adminIDLer);
                                                    $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($yeniEklenen, $adminImplodeID);
                                                    $adminBolgeCount = count($resultAdminBolgeler);
                                                    if ($adminBolgeCount > 0) {//diğer adminler
                                                        for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 11);
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
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                            }
                                                        }
                                                    } else {
                                                        $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 11);
                                                        $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                        if ($resultBildirim) {
                                                            $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                            if (count($resultAdminCihaz) > 0) {
                                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                                }
                                                                $adminCihaz = implode(',', $adminCihaz);
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                            }
                                                        }
                                                    }
                                                } else {//üst admin
                                                    $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($yeniEklenen);
                                                    $adminIDCount = count($resultBolgeAdminID);
                                                    if ($adminIDCount > 0) {
                                                        for ($b = 0; $b < $adminIDCount; $b++) {
                                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 11);
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
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracEkle"]);
                                                            }
                                                        }
                                                    }
                                                }

                                                $bolgeIDSilinen = array_diff($aracEskiBolgeID, $aracBolgeID);
                                                if (count($bolgeIDSilinen) > 0) {
                                                    $yeniSilinen = implode(",", $bolgeIDSilinen);
                                                    //bölgeden araç silindi
                                                    $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracSilme"];
                                                    $aracRenk = 'danger';
                                                    $aracUrl = 'aracliste';
                                                    $aracIcon = 'fa fa-bus';
                                                    //bildirim ayarları
                                                    if ($adminRutbe != 1) {//normal admin
                                                        $adminIDLer = array(1, $adminID);
                                                        $adminImplodeID = implode(',', $adminIDLer);
                                                        $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($yeniSilinen, $adminImplodeID);
                                                        $adminBolgeCount = count($resultAdminBolgeler);
                                                        if ($adminBolgeCount > 0) {//diğer adminler
                                                            for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 31);
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
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                                }
                                                            }
                                                        } else {
                                                            $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 31);
                                                            $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                            if ($resultBildirim) {
                                                                $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                                if (count($resultAdminCihaz) > 0) {
                                                                    foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                        $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                                    }
                                                                    $adminCihaz = implode(',', $adminCihaz);
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                                }
                                                            }
                                                        }
                                                    } else {//üst admin
                                                        $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($yeniSilinen);
                                                        $adminIDCount = count($resultBolgeAdminID);
                                                        if ($adminIDCount > 0) {
                                                            for ($b = 0; $b < $adminIDCount; $b++) {
                                                                $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 31);
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
                                                                    $form->shuttleNotification($adminCihaz, $alert, $deger["AracSil"]);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            } else {//fark yok sa demekki dizide değişiklik yok yani dizi ile ilgili düzenleme yapılmakta
                                                $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracDuzenleme"];
                                                $aracRenk = 'warning';
                                                $aracUrl = 'aracliste';
                                                $aracIcon = 'fa fa-bus';
                                                //bildirim ayarları
                                                if ($adminRutbe != 1) {//normal admin
                                                    $adminBolgeler = implode(',', $aracBolgeID);
                                                    $adminIDLer = array(1, $adminID);
                                                    $adminImplodeID = implode(',', $adminIDLer);
                                                    $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($adminBolgeler, $adminImplodeID);
                                                    $adminBolgeCount = count($resultAdminBolgeler);
                                                    if ($adminBolgeCount > 0) {//diğer adminler
                                                        for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 51);
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
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                            }
                                                        }
                                                    } else {
                                                        $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 51);
                                                        $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                        if ($resultBildirim) {
                                                            $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                            if (count($resultAdminCihaz) > 0) {
                                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                                }
                                                                $adminCihaz = implode(',', $adminCihaz);
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                            }
                                                        }
                                                    }
                                                } else {//üst admin
                                                    $adminBolgeler = implode(',', $aracBolgeID);
                                                    $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($adminBolgeler);
                                                    $adminIDCount = count($resultBolgeAdminID);
                                                    if ($adminIDCount > 0) {
                                                        for ($b = 0; $b < $adminIDCount; $b++) {
                                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 51);
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
                                                                $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        //düzenleme yapılırken ortak bölge id leri için
                                        $bolgeIDOrtak = array_intersect($aracBolgeID, $aracEskiBolgeID);
                                        if (count($bolgeIDOrtak) > 0) {
                                            $yeniOrtakBolge = implode(",", $bolgeIDOrtak);
                                            //bölgeden araç düzenleme
                                            $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracDuzenleme"];
                                            $aracRenk = 'warning';
                                            $aracUrl = 'aracliste';
                                            $aracIcon = 'fa fa-bus';
                                            //bildirim ayarları
                                            if ($adminRutbe != 1) {//normal admin
                                                $adminIDLer = array(1, $adminID);
                                                $adminImplodeID = implode(',', $adminIDLer);
                                                $resultAdminBolgeler = $Panel_Model->digerOrtakBolge($yeniOrtakBolge, $adminImplodeID);
                                                $adminBolgeCount = count($resultAdminBolgeler);
                                                if ($adminBolgeCount > 0) {//diğer adminler
                                                    for ($b = 0; $b < $adminBolgeCount; $b++) {
                                                        $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 31);
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
                                                            $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                        }
                                                    }
                                                } else {
                                                    $dataBildirim = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, 1, 31);
                                                    $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                                    if ($resultBildirim) {
                                                        $resultAdminCihaz = $Panel_Model->adminCihaz();
                                                        if (count($resultAdminCihaz) > 0) {
                                                            foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                                $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                            }
                                                            $adminCihaz = implode(',', $adminCihaz);
                                                            $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                        }
                                                    }
                                                }
                                            } else {//üst admin
                                                $resultBolgeAdminID = $Panel_Model->ortakDigerAdminBolge($yeniOrtakBolge);
                                                $adminIDCount = count($resultBolgeAdminID);
                                                if ($adminIDCount > 0) {
                                                    for ($b = 0; $b < $adminIDCount; $b++) {
                                                        $multiData[$b] = $form->adminBildirimDuzen($alert, $aracIcon, $aracUrl, $aracRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 31);
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
                                                            $form->shuttleNotification($adminCihaz, $alert, $deger["AracDuzen"]);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $alert = $adSoyad . ' ' . $aracPlaka . $deger["AracDuzenleme"];
                                        //log ayarları
                                        $dataLog = $form->adminLogDuzen($adminID, $adSoyad, 0, $alert);
                                        $resultLog = $Panel_Model->addNewAdminLog($dataLog);
                                        if ($resultLog) {
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

                        //arac TUR İD
                        $a = 0;
                        foreach ($adminAracTurDetail as $adminAracTurDetaill) {
                            $aracturId[] = $adminAracTurDetaill['BSTurID'];
                            $a++;
                        }
                        $turId = implode(',', $aracturId);

                        $aracTur = $Panel_Model->adminAracDetailTur($turId);

                        $b = 0;
                        foreach ($aracTur as $aracTurr) {
                            $aracDetailTur[$b]['TurID'] = $aracTurr['SBTurID'];
                            $aracDetailTur[$b]['TurAd'] = $aracTurr['SBTurAd'];
                            $aracDetailTur[$b]['TurAciklama'] = $aracTurr['SBTurAciklama'];
                            $aracDetailTur[$b]['TurAktiflik'] = $aracTurr['SBTurAktiflik'];
                            $aracDetailTur[$b]['TurKurum'] = $aracTurr['SBKurumAd'];
                            $aracDetailTur[$b]['TurTip'] = $aracTurr['SBTurTip'];
                            $aracDetailTur[$b]['TurBolge'] = $aracTurr['SBBolgeAd'];
                            $b++;
                        }
                        $sonuc["aracDetailTur"] = $aracDetailTur;
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
                                $digerBolgeSofor = $Panel_Model->adminDetailAracNotSelectSofor($diger_sofor_fark);

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

                        //hostes bilgileri
                        $hostesBolgeListe = $Panel_Model->aracDetailHostesMultiSelectBolgee($multisofordizi);
                        foreach ($hostesBolgeListe as $hostesBolgeListee) {
                            $hostesrutbeId[] = $hostesBolgeListee['BSHostesID'];
                        }
                        $rutbehostesdizi = implode(',', $hostesrutbeId);
                        //bölgeleri getirir
                        $hostesListe = $Panel_Model->hostesMultiSelectt($rutbehostesdizi);

                        $a = 0;
                        foreach ($hostesListe as $hostesListee) {
                            $aracHostesSelect['HostesSelectID'][$a] = $hostesListee['BSHostesID'];
                            $aracHostesSelect['HostesSelectAd'][$a] = $hostesListee['BSHostesAd'];
                            $aracHostesSelect['HostesSelectSoyad'][$a] = $hostesListee['BSHostesSoyad'];
                            $a++;
                        }

                        $sonuc["aracYeniSoforMultiSelect"] = $aracSoforSelect;
                        $sonuc["aracYeniHostesMultiSelect"] = $aracHostesSelect;
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

