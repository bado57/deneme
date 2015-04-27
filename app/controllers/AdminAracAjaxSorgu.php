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

        if ($_POST && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" && Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
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
                        $sonuc["aracYeniSoforMultiSelect"] = $aracSoforSelect;
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

