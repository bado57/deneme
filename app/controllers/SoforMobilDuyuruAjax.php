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
                    case "soforTurDuyuru":

                        $form->post('kisiid', true);
                        $kid = $form->values['kisiid'];
                        if (!$kid) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $resultTur = $Panel_Model->soforTurKurum($kid);
                            if (count($resultTur) > 0) {
                                foreach ($resultTur as $resultTurr) {
                                    $turID[] = $resultTurr['BSTurID'];
                                }
                                $soforTurID = implode(',', $turID);

                                $result = $Panel_Model->soforTurKurumlar($soforTurID);
                                if (count($result) > 0) {
                                    $a = 0;
                                    foreach ($result as $resultt) {
                                        $duyuru[0][$a]['Ad'] = $resultt['SBTurAd'];
                                        $duyuru[0][$a]['ID'] = $resultt['SBTurID'];
                                        $duyuru[0][$a]['Tip'] = $resultt['SBTurTip'];
                                        $duyuru[0][$a]['BID'] = $resultt['SBBolgeID'];
                                        $a++;
                                    }
                                }
                            } else {
                                $duyuru[1][0]['Yok'] = $languagedeger['TurYok'];
                            }
                            $sonuc["TurDuyuru"] = $duyuru;
                        }

                        break;
                    case "soforDuyuruYolcu":
                        if (!$firmId) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('turid', true);
                            $form->post('bolgeid', true);
                            $form->post('turtip', true);
                            $turID = $form->values['turid'];
                            $bolgeID = $form->values['bolgeid'];
                            $turTip = $form->values['turtip'];

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
                        $form->post('soforid', true);
                        $soforid = $form->values['soforid'];
                        if (!$soforid) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('soforAd', true);
                            $form->post('text', true);
                            $form->post('hedef', true);
                            $soforAd = $form->values['soforAd'];
                            $text = $form->values['text'];
                            $hedef = $form->values['hedef'];

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
                                    $resultAdminCihaz = $Panel_Model->duyuruAdminCihaz($adminIDler);
                                    if (count($resultAdminCihaz) > 0) {
                                        foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                            $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                        }
                                        $adminCihazlar = implode(',', $adminCihaz);
                                        $form->shuttleNotification($adminCihazlar, $text, $languagedeger["YeniDuyuru"]);
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
                                    $resultSoforCihaz = $Panel_Model->duyuruSoforCihaz($soforIDler);
                                    if (count($resultSoforCihaz) > 0) {
                                        foreach ($resultSoforCihaz as $resultSoforCihazz) {
                                            $soforCihaz[] = $resultSoforCihazz['sbsoforcihazRecID'];
                                        }
                                        $soforCihazlar = implode(',', $soforCihaz);
                                        $form->shuttleNotification($soforCihazlar, $text, $languagedeger["YeniDuyuru"]);
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
                                    $resultHostesCihaz = $Panel_Model->duyuruHostesCihaz($hostesIDler);
                                    if (count($resultHostesCihaz) > 0) {
                                        foreach ($resultHostesCihaz as $resultHostesCihazz) {
                                            $hostesCihaz[] = $resultHostesCihazz['bshostescihazRecID'];
                                        }
                                        $hostesCihazlar = implode(',', $hostesCihaz);
                                        $form->shuttleNotification($hostesCihazlar, $text, $languagedeger["YeniDuyuru"]);
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
                                    $resultVeliCihaz = $Panel_Model->duyuruVeliCihaz($veliIDler);
                                    if (count($resultVeliCihaz) > 0) {
                                        foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                            $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                        }
                                        $veliCihazlar = implode(',', $veliCihaz);
                                        $form->shuttleNotification($veliCihazlar, $text, $languagedeger["YeniDuyuru"]);
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
                                    $resultOgrenciCihaz = $Panel_Model->duyuruOgrenciCihaz($ogrenciIDler);
                                    if (count($resultOgrenciCihaz) > 0) {
                                        foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                            $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                        }
                                        $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                        $form->shuttleNotification($ogrenciCihazlar, $text, $languagedeger["YeniDuyuru"]);
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
                                    $resultIsciCihaz = $Panel_Model->duyuruIsciCihaz($isciIDler);
                                    if (count($resultIsciCihaz) > 0) {
                                        foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                            $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                        }
                                        $isciCihazlar = implode(',', $isciCihaz);
                                        $form->shuttleNotification($isciCihazlar, $text, $languagedeger["YeniDuyuru"]);
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
                            if ($resultLogDuyuru) {
                                $sonuc["result"] = $languagedeger['DuyuruGonder'];
                            } else {
                                $sonuc["hata"] = $languagedeger['Hack'];
                            }
                        }

                        break;
                    case "duyuruGelen":
                        $form->post('soforid', true);
                        $kid = $form->values['soforid'];
                        if (!$kid) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $result = $Panel_Model->soforGelenDuyuru($kid);
                            if (count($result) > 0) {
                                $a = 0;
                                foreach ($result as $resultt) {
                                    $gelen[0][$a]['Text'] = $resultt['BSDuyuruText'];
                                    $gelen[0][$a]['ID'] = $resultt['BSSoforDuyuruID'];
                                    $gelen[0][$a]['Ad'] = $resultt['BSGonderenAdSoyad'];
                                    $gelen[0][$a]['Tip'] = $resultt['BSGonderenTip'];
                                    $gelen[0][$a]['Okundu'] = $resultt['BSOkundu'];
                                    $gelen[0][$a]['Tarih'] = $resultt['BSDuyuruTarih'];
                                    $a++;
                                }
                            } else {
                                $gelen[1][0]['Result'] = $languagedeger['DuyuruYok'];
                            }
                            $sonuc["GelenDuyuru"] = $gelen;
                        }

                        break;
                    case "gelenOkundu":
                        if (!$firmId) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('gelenduyuruid', true);
                            $duyuruID = $form->values['gelenduyuruid'];
                            if ($form->submit()) {
                                $data = array(
                                    'BSOkundu' => 1
                                );
                            }
                            $resultDuyuru = $Panel_Model->soforGelenOkundu($data, $duyuruID);
                            if ($resultDuyuru) {
                                $sonuc["okundu"] = 1;
                            } else {
                                $sonuc["hata"] = $languagedeger['Hata'];
                            }
                        }
                        break;
                    case "duyuruGonderilen":
                        $form->post('soforid', true);
                        $kid = $form->values['soforid'];
                        if (!$kid) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $result = $Panel_Model->soforGonderilenDuyuru($kid);
                            if (count($result) > 0) {
                                $a = 0;
                                foreach ($result as $resultt) {
                                    $gonderilen[0][$a]['Text'] = $resultt['BSLogText'];
                                    $gonderilen[0][$a]['ID'] = $resultt['BSSoforLogID'];
                                    $gonderilen[0][$a]['Hedef'] = $resultt['BSLogHedef'];
                                    $gonderilen[0][$a]['Tarih'] = $resultt['BsLogTarih'];
                                    $a++;
                                }
                            } else {
                                $gonderilen[1][0]['Result'] = $languagedeger['DuyuruYok'];
                            }

                            $sonuc["GonderilenDuyuru"] = $gonderilen;
                        }

                        break;
                    case "duyrayarkaydet":
                        $form->post('veli_id', true);
                        $veliID = $form->values['veli_id'];
                        if (!$veliID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('duyuruVal', true);
                            $form->post('duyuruayarDeger', true);
                            $duyuruVal = $form->values['duyuruVal'];
                            $duyuruayarDeger = $form->values['duyuruayarDeger'];
                            if ($duyuruVal != $duyuruayarDeger) {
                                if ($form->submit()) {
                                    $data = array(
                                        'duyuruStatu' => $duyuruVal
                                    );
                                }
                                $resultupdate = $Panel_Model->veliDuyrAyarKaydet($data, $veliID);
                                if ($resultupdate) {
                                    $sonuc["update"] = $languagedeger['DuyrAyarUpdate'];
                                } else {
                                    $sonuc["hata"] = $languagedeger['Hata'];
                                }
                            } else {
                                $sonuc["hata"] = $languagedeger['DegisiklikYok'];
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

