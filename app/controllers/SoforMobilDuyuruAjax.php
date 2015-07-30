<?php

class SoforMobilDuyuruAjax extends Controller {

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

                case "soforTurDuyuru":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('kisiid', true);
                        $kid = $form->values['kisiid'];
                        $resultTur = $Panel_Model->soforTurKurum($kid);
                        foreach ($resultTur as $resultTurr) {
                            $turID[] = $resultTurr['BSTurID'];
                        }
                        $soforTurID = implode(',', $turID);

                        $result = $Panel_Model->soforTurKurumlar($soforTurID);
                        if (count($result) > 0) {
                            $a = 0;
                            foreach ($result as $resultt) {
                                $duyuru[$a]['Ad'] = $resultt['SBTurAd'];
                                $duyuru[$a]['ID'] = $resultt['SBTurID'];
                                $duyuru[$a]['Tip'] = $resultt['SBTurTip'];
                                $duyuru[$a]['BID'] = $resultt['SBBolgeID'];
                                $a++;
                            }
                        }

                        $sonuc["TurDuyuru"] = $duyuru;
                    }

                    break;

                case "soforDuyuruYolcu":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('turid', true);
                        $form->post('bolgeid', true);
                        $form->post('turtip', true);
                        $form->post('id', true);
                        $turID = $form->values['turid'];
                        $bolgeID = $form->values['bolgeid'];
                        $turTip = $form->values['turtip'];
                        $kisiID = $form->values['id'];

                        if ($turTip == 0) {//öğrenci
                            $turOgrenci = $Panel_Model->soforTurOgrenci($turID);
                            $a = 0;
                            foreach ($turOgrenci as $turOgrencii) {
                                $turOgrenciID[] = $turOgrencii['BSOgrenciID'];
                                $turYolcu[$a]['Id'] = $turOgrencii['BSOgrenciID'];
                                $turYolcu[$a]['Ad'] = $turOgrencii['BSOgrenciAd'];
                                $a++;
                            }

                            $ogrenciid = implode(',', $turOgrenciID);
                            $turVeli = $Panel_Model->soforTurVeli($ogrenciid);
                            if (count($turVeli) > 0) {
                                $v = 0;
                                foreach ($turVeli as $turVelii) {
                                    $turVeli[$v]['Id'] = $turVelii['BSVeliID'];
                                    $turVeli[$v]['Ad'] = $turVelii['BSVeliAd'];
                                    $v++;
                                }
                            }
                        } else if ($turTip == 1) {//işçi
                            $turIsci = $Panel_Model->soforTurIsci($turID);
                            $a = 0;
                            foreach ($turIsci as $turIscii) {
                                $turYolcu[$a]['Id'] = $turIscii['SBIsciID'];
                                $turYolcu[$a]['Ad'] = $turIscii['SBIsciAd'];
                                $a++;
                            }
                        } else {//öğrenci-personel
                            $turOgrenci = $Panel_Model->soforTurIsciOgrenci($turID);
                            if (count($turOgrenci) > 0) {
                                $a = 0;
                                foreach ($turOgrenci as $turOgrencii) {
                                    $turYolcu[$a]['Id'] = $turOgrencii['BSOgrenciIsciID'];
                                    $turYolcu[$a]['Ad'] = $turOgrencii['BSOgrenciIsciAd'];
                                    if ($turOgrencii['BSKullaniciTip'] != 1) {
                                        $turOgrenciID[] = $turOgrencii['BSOgrenciIsciID'];
                                    }
                                    $turYolcu[$a]['Tip'] = $turOgrencii['BSKullaniciTip'];
                                    $a++;
                                }

                                $ogrenciid = implode(',', $turOgrenciID);
                                $turVeli = $Panel_Model->soforTurVeli($ogrenciid);
                                if (count($turVeli) > 0) {
                                    $v = 0;
                                    foreach ($turVeli as $turVelii) {
                                        $turVeli[$v]['Id'] = $turVelii['BSVeliID'];
                                        $turVeli[$v]['Ad'] = $turVelii['BSVeliAd'];
                                        $v++;
                                    }
                                }
                            }
                        }

                        $turSofor = $Panel_Model->soforTurDiger($turID);
                        $c = 0;
                        foreach ($turSofor as $turSoforr) {
                            $turSoforler[$c]['Id'] = $turSoforr['BSTurSoforID'];
                            $turSoforler[$c]['Ad'] = $turSoforr['BSTurSoforAd'];
                            $c++;
                        }

                        $turHostes = $Panel_Model->soforTurHostes($turID);
                        if (count($turHostes) > 0) {
                            $e = 0;
                            foreach ($turHostes as $turHostess) {
                                $turHostesler[$e]['Id'] = $turHostess['BSTurHostesID'];
                                $turHostesler[$e]['Ad'] = $turHostess['BSTurHostesAd'];
                                $e++;
                            }
                        }

                        $turYonetici = $Panel_Model->soforTurYonetici($bolgeID);
                        foreach ($turYonetici as $turYoneticii) {
                            $turyoneticiid[] = $turYoneticii['BSAdminID'];
                        }
                        $turyoneticiler = implode(',', $turyoneticiid);

                        $turSoforYoneti = $Panel_Model->soforTurYoneticiler($turyoneticiler);
                        $d = 0;
                        foreach ($turSoforYoneti as $turSoforYonetici) {
                            $turYonet[$d]['Id'] = $turSoforYonetici['BSAdminID'];
                            $turYonet[$d]['Ad'] = $turSoforYonetici['BSAdminAd'];
                            $turYonet[$d]['Soyad'] = $turSoforYonetici['BSAdminSoyad'];
                            $d++;
                        }

                        $sonuc["TurYolcu"] = $turYolcu;
                        $sonuc["TurVeli"] = $turVeli;
                        $sonuc["TurSofor"] = $turSoforler;
                        $sonuc["TurHostes"] = $turHostesler;
                        $sonuc["TurYonet"] = $turYonet;
                    }

                    break;

                case "duyuruGonder":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('soforid', true);
                        $form->post('soforAd', true);
                        $form->post('text', true);
                        $form->post('hedef', true);
                        $form->post('lang', true);
                        $soforid = $form->values['soforid'];
                        $soforAd = $form->values['soforAd'];
                        $text = $form->values['text'];
                        $hedef = $form->values['hedef'];
                        $lang = $form->values['lang'];


                        $formLanguage = $this->load->mobillanguage($lang);
                        $language = $formLanguage->mobillanguage();

                        $ogrenci = $_REQUEST['ogrenci'];
                        $ogrenciID = $_REQUEST['ogrenciID'];
                        $isci = $_REQUEST['isci'];
                        $isciID = $_REQUEST['isciID'];
                        $veli = $_REQUEST['veli'];
                        $veliID = $_REQUEST['veliID'];
                        $sofor = $_REQUEST['sofor'];
                        $soforID = $_REQUEST['soforID'];
                        $hostes = $_REQUEST['hostes'];
                        $hostesID = $_REQUEST['hostesID'];
                        $yonetici = $_REQUEST['yonetici'];
                        $yoneticiID = $_REQUEST['yoneticiID'];

                        //admin
                        if (count($yonetici) > 0) {
                            $countAdmin = count($yonetici);
                            for ($a = 0; $a < $countAdmin; $a++) {
                                $admindata[$a] = array(
                                    'BSDuyuruText' => $text,
                                    'BSDuyuruHedef' => $hedef,
                                    'BSGonderenID' => $soforid,
                                    'BSGonderenAdSoyad' => $soforAd,
                                    'BSGonderenTip' => 3,
                                    'BSAlanID' => $yoneticiID[$a],
                                    'BSAlanAdSoyad' => $yonetici[$a],
                                    'BSOkundu' => 0,
                                    'BSGoruldu' => 0
                                );
                            }
                            $resultAdminDuyuru = $Panel_Model->addAdminDuyuru($admindata);
                            if ($resultAdminDuyuru) {
                                $adminIDler = implode(',', $yoneticiID);
                                $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminIDler);
                                if (count($resultAdminCihaz) > 0) {
                                    foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                        $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                    }
                                    $adminCihazlar = implode(',', $adminCihaz);
                                    $form->shuttleNotification($adminCihazlar, $text, $language["YeniDuyuru"]);
                                }
                            }
                        }

                        //şoför
                        if (count($soforID) > 0) {
                            $countSofor = count($soforID);
                            for ($s = 0; $s < $countSofor; $s++) {
                                $sofordata[$s] = array(
                                    'BSDuyuruText' => $text,
                                    'BSDuyuruHedef' => $hedef,
                                    'BSGonderenID' => $soforid,
                                    'BSGonderenAdSoyad' => $soforAd,
                                    'BSGonderenTip' => 3,
                                    'BSAlanID' => $soforID[$s],
                                    'BSAlanAdSoyad' => $sofor[$s],
                                    'BSOkundu' => 0,
                                    'BSGoruldu' => 0
                                );
                            }
                            $resultSoforDuyuru = $Panel_Model->addSoforDuyuru($sofordata);
                            if ($resultSoforDuyuru) {
                                $soforIDler = implode(',', $soforID);
                                $resultSoforCihaz = $Panel_Model->digerSoforCihaz($soforIDler);
                                if (count($resultSoforCihaz) > 0) {
                                    foreach ($resultSoforCihaz as $resultSoforCihazz) {
                                        $soforCihaz[] = $resultSoforCihazz['sbsoforcihazRecID'];
                                    }
                                    $soforCihazlar = implode(',', $soforCihaz);
                                    $form->shuttleNotification($soforCihazlar, $text, $language["YeniDuyuru"]);
                                }
                            }
                        }

                        //hostes
                        if (count($hostesID) > 0) {
                            $countHostes = count($hostesID);
                            for ($h = 0; $h < $countHostes; $h++) {
                                $hostesdata[$h] = array(
                                    'BSDuyuruText' => $text,
                                    'BSDuyuruHedef' => $hedef,
                                    'BSGonderenID' => $soforid,
                                    'BSGonderenAdSoyad' => $soforAd,
                                    'BSGonderenTip' => 3,
                                    'BSAlanID' => $hostesID[$h],
                                    'BSAlanAdSoyad' => $hostes[$h],
                                    'BSOkundu' => 0,
                                    'BSGoruldu' => 0
                                );
                            }
                            $resultHostesDuyuru = $Panel_Model->addHostesDuyuru($hostesdata);
                            if ($resultHostesDuyuru) {
                                $hostesIDler = implode(',', $hostesID);
                                $resultHostesCihaz = $Panel_Model->digerHostesCihaz($hostesIDler);
                                if (count($resultHostesCihaz) > 0) {
                                    foreach ($resultHostesCihaz as $resultHostesCihazz) {
                                        $hostesCihaz[] = $resultHostesCihazz['bshostescihazRecID'];
                                    }
                                    $hostesCihazlar = implode(',', $hostesCihaz);
                                    $form->shuttleNotification($hostesCihazlar, $text, $language["YeniDuyuru"]);
                                }
                            }
                        }

                        //veli
                        if (count($veliID) > 0) {
                            $countVeli = count($veliID);
                            for ($v = 0; $v < $countVeli; $v++) {
                                $velidata[$v] = array(
                                    'BSDuyuruText' => $text,
                                    'BSDuyuruHedef' => $hedef,
                                    'BSGonderenID' => $soforid,
                                    'BSGonderenAdSoyad' => $soforAd,
                                    'BSGonderenTip' => 3,
                                    'BSAlanID' => $veliID[$v],
                                    'BSAlanAdSoyad' => $veli[$v],
                                    'BSOkundu' => 0,
                                    'BSGoruldu' => 0
                                );
                            }
                            $resultVeliDuyuru = $Panel_Model->addVeliDuyuru($velidata);
                            if ($resultVeliDuyuru) {
                                $veliIDler = implode(',', $veliID);
                                $resultVeliCihaz = $Panel_Model->veliCihaz($veliIDler);
                                if (count($resultVeliCihaz) > 0) {
                                    foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                        $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                    }
                                    $veliCihazlar = implode(',', $veliCihaz);
                                    $form->shuttleNotification($veliCihazlar, $text, $language["YeniDuyuru"]);
                                }
                            }
                        }

                        //öğrenci
                        if (count($ogrenciID) > 0) {
                            $countOgrenci = count($ogrenciID);
                            for ($o = 0; $o < $countOgrenci; $o++) {
                                $ogrencidata[$o] = array(
                                    'BSDuyuruText' => $text,
                                    'BSDuyuruHedef' => $hedef,
                                    'BSGonderenID' => $soforid,
                                    'BSGonderenAdSoyad' => $soforAd,
                                    'BSGonderenTip' => 3,
                                    'BSAlanID' => $ogrenciID[$o],
                                    'BSAlanAdSoyad' => $ogrenci[$o],
                                    'BSOkundu' => 0,
                                    'BSGoruldu' => 0
                                );
                            }
                            $resultOgrenciDuyuru = $Panel_Model->addOgrenciDuyuru($ogrencidata);
                            if ($resultOgrenciDuyuru) {
                                $ogrenciIDler = implode(',', $ogrenciID);
                                $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciIDler);
                                if (count($resultOgrenciCihaz) > 0) {
                                    foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                        $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                    }
                                    $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                    $form->shuttleNotification($ogrenciCihazlar, $text, $language["YeniDuyuru"]);
                                }
                            }
                        }

                        //işçi
                        if (count($isciID) > 0) {
                            $countIsci = count($isciID);
                            for ($i = 0; $i < $countIsci; $i++) {
                                $iscidata[$i] = array(
                                    'SBDuyuruText' => $text,
                                    'SBDuyuruHedef' => $hedef,
                                    'SBGonderenID' => $soforid,
                                    'SBGonderenAdSoyad' => $soforAd,
                                    'SBGonderenTip' => 3,
                                    'SBAlanID' => $isciID[$i],
                                    'SBAlanAdSoyad' => $isci[$i],
                                    'SBOkundu' => 0,
                                    'SBGoruldu' => 0
                                );
                            }
                            $resultIsciDuyuru = $Panel_Model->addIsciDuyuru($iscidata);
                            if ($resultIsciDuyuru) {
                                $isciIDler = implode(',', $isciID);
                                $resultIsciCihaz = $Panel_Model->isciCihaz($isciIDler);
                                if (count($resultIsciCihaz) > 0) {
                                    foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                        $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                    }
                                    $isciCihazlar = implode(',', $isciCihaz);
                                    $form->shuttleNotification($isciCihazlar, $text, $language["YeniDuyuru"]);
                                }
                            }
                        }

                        $soforlog = array(
                            'BSEkleyenID' => $soforid,
                            'BSEkleyenAdSoyad' => $soforAd,
                            'BSLogText' => $text,
                            'BSLogHedef' => $hedef
                        );

                        $resultLogDuyuru = $Panel_Model->addSoforLogDuyuru($soforlog);

                        $sonuc["TurDuyuru"] = $duyuru;
                    }

                    break;

                case "duyuruGelen":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('soforid', true);
                        $kid = $form->values['soforid'];

                        $result = $Panel_Model->soforGelenDuyuru($kid);
                        if (count($result) > 0) {
                            $a = 0;
                            foreach ($result as $resultt) {
                                $gelen[$a]['Text'] = $resultt['BSDuyuruText'];
                                $gelen[$a]['ID'] = $resultt['BSSoforDuyuruID'];
                                $gelen[$a]['Ad'] = $resultt['BSGonderenAdSoyad'];
                                $gelen[$a]['Tip'] = $resultt['BSGonderenTip'];
                                $gelen[$a]['Okundu'] = $resultt['BSOkundu'];
                                $gelen[$a]['Tarih'] = $resultt['BSDuyuruTarih'];
                                $a++;
                            }
                        }

                        $sonuc["GelenDuyuru"] = $gelen;
                    }

                    break;

                case "gelenOkundu":
                    $form->post('gelenduyuruid', true);
                    $duyuruID = $form->values['gelenduyuruid'];
                    if ($form->submit()) {
                        $data = array(
                            'BSOkundu' => 1
                        );
                    }
                    $resultDuyuru = $Panel_Model->soforGelenOkundu($data, $duyuruID);
                    $sonuc["okundu"] = 1;
                    break;

                case "duyuruGonderilen":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('soforid', true);
                        $kid = $form->values['soforid'];

                        $result = $Panel_Model->soforGonderilenDuyuru($kid);
                        if (count($result) > 0) {
                            $a = 0;
                            foreach ($result as $resultt) {
                                $gonderilen[$a]['Text'] = $resultt['BSLogText'];
                                $gonderilen[$a]['ID'] = $resultt['BSSoforLogID'];
                                $gonderilen[$a]['Hedef'] = $resultt['BSLogHedef'];
                                $gonderilen[$a]['Tarih'] = $resultt['BsLogTarih'];
                                $a++;
                            }
                        }

                        $sonuc["GonderilenDuyuru"] = $gonderilen;
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

