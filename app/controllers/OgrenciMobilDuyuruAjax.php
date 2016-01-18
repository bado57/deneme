<?php

class OgrenciMobilDuyuruAjax extends Controller {

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

                    case "ogrDuyuruYolcu":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $resultVeliler = $Panel_Model->ogrDuyuruVeliler($ogrID);
                            $v = 0;
                            if (count($resultVeliler) > 0) {
                                foreach ($resultVeliler as $resultVelilerr) {
                                    $ogrAd = $resultVelilerr['BSOgrenciAd'];
                                    $ogrVeli[$v]['ID'] = $resultVelilerr['BSVeliID'];
                                    $ogrVeli[$v]['Ad'] = $resultVelilerr['BSVeliAd'];
                                    $v++;
                                }

                                $ogrBolge = $Panel_Model->ogrDuyuruBolge($ogrID);
                                foreach ($ogrBolge as $ogrBolgee) {
                                    $ogrbolgeid[] = $ogrBolgee['BSBolgeID'];
                                }
                                $ogrbolgeler = implode(',', $ogrbolgeid);

                                $bolgeYonetici = $Panel_Model->ogrDuyuruYonetici($ogrbolgeler);
                                foreach ($bolgeYonetici as $bolgeYoneticii) {
                                    $bolgeyoneticiid[] = $bolgeYoneticii['BSAdminID'];
                                }
                                $bolgeyoneticiler = implode(',', $bolgeyoneticiid);

                                $ogrDuyuruYonetici = $Panel_Model->ogrDuyuruYoneticiler($bolgeyoneticiler);
                                $d = 0;
                                foreach ($ogrDuyuruYonetici as $ogrDuyuruYoneticii) {
                                    $ogrYonet[$d]['Id'] = $ogrDuyuruYoneticii['BSAdminID'];
                                    $ogrYonet[$d]['Ad'] = $ogrDuyuruYoneticii['BSAdminAd'];
                                    $ogrYonet[$d]['Soyad'] = $ogrDuyuruYoneticii['BSAdminSoyad'];
                                    $d++;
                                }
                                $sonuc["Ogr"] = $ogrAd;
                                $sonuc["Yolcu"] = $ogrVeli;
                                $sonuc["Yonet"] = $ogrYonet;
                            } else {
                                $ogrBolge = $Panel_Model->ogrDuyuruBolge($ogrID);
                                foreach ($ogrBolge as $ogrBolgee) {
                                    $ogrAd = $ogrBolgee['BSOgrenciAd'];
                                    $ogrbolgeid[] = $ogrBolgee['BSBolgeID'];
                                }
                                $ogrbolgeler = implode(',', $ogrbolgeid);

                                $bolgeYonetici = $Panel_Model->ogrDuyuruYonetici($ogrbolgeler);
                                foreach ($bolgeYonetici as $bolgeYoneticii) {
                                    $bolgeyoneticiid[] = $bolgeYoneticii['BSAdminID'];
                                }
                                $bolgeyoneticiler = implode(',', $bolgeyoneticiid);

                                $ogrDuyuruYonetici = $Panel_Model->ogrDuyuruYoneticiler($bolgeyoneticiler);
                                $d = 0;
                                foreach ($ogrDuyuruYonetici as $ogrDuyuruYoneticii) {
                                    $ogrYonet[$d]['Id'] = $ogrDuyuruYoneticii['BSAdminID'];
                                    $ogrYonet[$d]['Ad'] = $ogrDuyuruYoneticii['BSAdminAd'];
                                    $ogrYonet[$d]['Soyad'] = $ogrDuyuruYoneticii['BSAdminSoyad'];
                                    $d++;
                                }
                                $sonuc["Ogr"] = $ogrAd;
                                $sonuc["Yolcu"] = "";
                                $sonuc["Yonet"] = $ogrYonet;
                            }
                        }

                        break;
                    case "duyuruGonder":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('ogrAd', true);
                            $form->post('text', true);
                            $form->post('hedef', true);
                            $ogrAd = $form->values['ogrAd'];
                            $text = $form->values['text'];
                            $hedef = $form->values['hedef'];

                            $veli = $_REQUEST['veli'];
                            $veliID = $_REQUEST['veliID'];
                            $yonetici = $_REQUEST['yonetici'];
                            $yoneticiID = $_REQUEST['yoneticiID'];

                            //admin
                            if (count($yonetici) > 0) {
                                $countAdmin = count($yonetici);
                                for ($a = 0; $a < $countAdmin; $a++) {
                                    $admindata[$a] = array(
                                        'BSDuyuruText' => $text,
                                        'BSDuyuruHedef' => $hedef,
                                        'BSGonderenID' => $ogrID,
                                        'BSGonderenAdSoyad' => $ogrAd,
                                        'BSGonderenTip' => 0,
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

                            //öğrenci
                            if (count($veliID) > 0) {
                                $countVeli = count($veliID);
                                for ($v = 0; $v < $countVeli; $v++) {
                                    $velidata[$v] = array(
                                        'BSDuyuruText' => $text,
                                        'BSDuyuruHedef' => $hedef,
                                        'BSGonderenID' => $ogrID,
                                        'BSGonderenAdSoyad' => $ogrAd,
                                        'BSGonderenTip' => 0,
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

                            $ogrlog = array(
                                'BSEkleyenID' => $ogrID,
                                'BSEkleyenAdSoyad' => $ogrAd,
                                'BSLogText' => $text,
                                'BSLogHedef' => $hedef
                            );

                            $resultLogDuyuru = $Panel_Model->addOgrLogDuyuru($ogrlog);
                            if ($resultLogDuyuru) {
                                $sonuc["result"] = $languagedeger['DuyuruGonder'];
                            } else {
                                $sonuc["hata"] = $languagedeger['Hack'];
                            }
                        }

                        break;
                    case "duyuruGelen":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $result = $Panel_Model->ogrGelenDuyuru($ogrID);
                            if (count($result) > 0) {
                                $a = 0;
                                foreach ($result as $resultt) {
                                    $gelen[0][$a]['Text'] = $resultt['BSDuyuruText'];
                                    $gelen[0][$a]['ID'] = $resultt['BSOgrenciDuyuruID'];
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
                            $resultDuyuru = $Panel_Model->ogrGelenOkundu($data, $duyuruID);
                            if ($resultDuyuru) {
                                $sonuc["okundu"] = 1;
                            } else {
                                $sonuc["hata"] = $languagedeger['Hata'];
                            }
                        }
                        break;
                    case "duyuruGonderilen":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $result = $Panel_Model->ogrGonderilenDuyuru($ogrID);
                            if (count($result) > 0) {
                                $a = 0;
                                foreach ($result as $resultt) {
                                    $gonderilen[0][$a]['Text'] = $resultt['BSLogText'];
                                    $gonderilen[0][$a]['ID'] = $resultt['BSOgrenciLogID'];
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
                    case "duyuruayar":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $ayar = $Panel_Model->ogrDuyuruAyar($ogrID);
                            foreach ($ayar as $ayarr) {
                                $ayarDeger['Deger'] = $ayarr['duyuruStatu'];
                            }
                            $sonuc["Detay"] = $ayarDeger;
                        }
                        break;
                    case "duyrayarkaydet":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
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
                                $resultupdate = $Panel_Model->ogrDuyrAyarKaydet($data, $ogrID);
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

