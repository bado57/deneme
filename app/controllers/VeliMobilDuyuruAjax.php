<?php

class VeliMobilDuyuruAjax extends Controller {

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

                    case "veliDuyuruYolcu":
                        $form->post('veli_id', true);
                        $veliID = $form->values['veli_id'];
                        if (!$veliID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $resultOgrenciler = $Panel_Model->veliDuyuruOgrenciler($veliID);
                            $o = 0;
                            if (count($resultOgrenciler) > 0) {
                                foreach ($resultOgrenciler as $resultOgrencilerr) {
                                    $veliAd = $resultOgrencilerr['BSVeliAd'];
                                    $ogrID[] = $resultOgrencilerr['BSOgrenciID'];
                                    $veliOgrenci[$o]['ID'] = $resultOgrencilerr['BSOgrenciID'];
                                    $veliOgrenci[$o]['Ad'] = $resultOgrencilerr['BSOgrenciAd'];
                                    $o++;
                                }

                                $ogrIDler = implode(',', $ogrID);

                                $ogrBolge = $Panel_Model->ogrDuyuruBolge($ogrIDler);
                                foreach ($ogrBolge as $ogrBolgee) {
                                    $ogrbolgeid[] = $ogrBolgee['BSBolgeID'];
                                }
                                $ogrbolgeler = implode(',', $ogrbolgeid);

                                $bolgeYonetici = $Panel_Model->ogrDuyuruYonetici($ogrbolgeler);
                                foreach ($bolgeYonetici as $bolgeYoneticii) {
                                    $bolgeyoneticiid[] = $bolgeYoneticii['BSAdminID'];
                                }
                                $bolgeyoneticiler = implode(',', $bolgeyoneticiid);

                                $veliDuyuruYonetici = $Panel_Model->veliDuyuruYoneticiler($bolgeyoneticiler);
                                $d = 0;
                                foreach ($veliDuyuruYonetici as $veliDuyuruYoneticii) {
                                    $veliYonet[$d]['Id'] = $veliDuyuruYoneticii['BSAdminID'];
                                    $veliYonet[$d]['Ad'] = $veliDuyuruYoneticii['BSAdminAd'];
                                    $veliYonet[$d]['Soyad'] = $veliDuyuruYoneticii['BSAdminSoyad'];
                                    $d++;
                                }
                                $sonuc["Veli"] = $veliAd;
                                $sonuc["Yolcu"] = $veliOgrenci;
                                $sonuc["Yonet"] = $veliYonet;
                            } else {
                                $veliBolge = $Panel_Model->veliDuyuruBolge($veliID);
                                foreach ($veliBolge as $veliBolgee) {
                                    $veliAd = $veliBolgee['BSVeliAd'];
                                    $velibolgeid[] = $veliBolgee['BSBolgeID'];
                                }
                                $velbolgeler = implode(',', $velibolgeid);

                                $bolgeYonetici = $Panel_Model->ogrDuyuruYonetici($velbolgeler);
                                foreach ($bolgeYonetici as $bolgeYoneticii) {
                                    $bolgeyoneticiid[] = $bolgeYoneticii['BSAdminID'];
                                }
                                $bolgeyoneticiler = implode(',', $bolgeyoneticiid);

                                $veliDuyuruYonetici = $Panel_Model->veliDuyuruYoneticiler($bolgeyoneticiler);
                                $d = 0;
                                foreach ($veliDuyuruYonetici as $veliDuyuruYoneticii) {
                                    $veliYonet[$d]['Id'] = $veliDuyuruYoneticii['BSAdminID'];
                                    $veliYonet[$d]['Ad'] = $veliDuyuruYoneticii['BSAdminAd'];
                                    $veliYonet[$d]['Soyad'] = $veliDuyuruYoneticii['BSAdminSoyad'];
                                    $d++;
                                }
                                $sonuc["Veli"] = $veliAd;
                                $sonuc["Yolcu"] = "";
                                $sonuc["Yonet"] = $veliYonet;
                            }
                        }

                        break;
                    case "duyuruGonder":
                        $form->post('veli_id', true);
                        $veliID = $form->values['veli_id'];
                        if (!$veliID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('veliAd', true);
                            $form->post('text', true);
                            $form->post('hedef', true);
                            $veliAd = $form->values['veliAd'];
                            $text = $form->values['text'];
                            $hedef = $form->values['hedef'];

                            $ogrenci = $_REQUEST['ogrenci'];
                            $ogrenciID = $_REQUEST['ogrenciID'];
                            $yonetici = $_REQUEST['yonetici'];
                            $yoneticiID = $_REQUEST['yoneticiID'];

                            //admin
                            if (count($yonetici) > 0) {
                                $countAdmin = count($yonetici);
                                for ($a = 0; $a < $countAdmin; $a++) {
                                    $admindata[$a] = array(
                                        'BSDuyuruText' => $text,
                                        'BSDuyuruHedef' => $hedef,
                                        'BSGonderenID' => $veliID,
                                        'BSGonderenAdSoyad' => $veliAd,
                                        'BSGonderenTip' => 1,
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
                            if (count($ogrenciID) > 0) {
                                $countOgrenci = count($ogrenciID);
                                for ($o = 0; $o < $countOgrenci; $o++) {
                                    $ogrencidata[$o] = array(
                                        'BSDuyuruText' => $text,
                                        'BSDuyuruHedef' => $hedef,
                                        'BSGonderenID' => $veliID,
                                        'BSGonderenAdSoyad' => $veliAd,
                                        'BSGonderenTip' => 1,
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

                            $velilog = array(
                                'BSEkleyenID' => $veliID,
                                'BSEkleyenAdSoyad' => $veliAd,
                                'BSLogText' => $text,
                                'BSLogHedef' => $hedef
                            );

                            $resultLogDuyuru = $Panel_Model->addVeliLogDuyuru($velilog);
                            if ($resultLogDuyuru) {
                                $sonuc["result"] = $languagedeger['DuyuruGonder'];
                            } else {
                                $sonuc["hata"] = $languagedeger['Hack'];
                            }
                        }

                        break;
                    case "duyuruGelen":
                        $form->post('veli_id', true);
                        $veliID = $form->values['veli_id'];
                        if (!$veliID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $result = $Panel_Model->veliGelenDuyuru($veliID);
                            if (count($result) > 0) {
                                $a = 0;
                                foreach ($result as $resultt) {
                                    $gelen[0][$a]['Text'] = $resultt['BSDuyuruText'];
                                    $gelen[0][$a]['ID'] = $resultt['BSVeliDuyuruID'];
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
                            $resultDuyuru = $Panel_Model->veliGelenOkundu($data, $duyuruID);
                            if ($resultDuyuru) {
                                $sonuc["okundu"] = 1;
                            } else {
                                $sonuc["hata"] = $languagedeger['Hata'];
                            }
                        }
                        break;
                    case "duyuruGonderilen":
                        $form->post('veli_id', true);
                        $veliID = $form->values['veli_id'];
                        if (!$veliID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $result = $Panel_Model->veliGonderilenDuyuru($veliID);
                            if (count($result) > 0) {
                                $a = 0;
                                foreach ($result as $resultt) {
                                    $gonderilen[0][$a]['Text'] = $resultt['BSLogText'];
                                    $gonderilen[0][$a]['ID'] = $resultt['BSVeliLogID'];
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
                        $form->post('veli_id', true);
                        $veliID = $form->values['veli_id'];
                        if (!$veliID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $ayar = $Panel_Model->veliDuyuruAyar($veliID);
                            foreach ($ayar as $ayarr) {
                                $ayarDeger['Deger'] = $ayarr['duyuruStatu'];
                            }
                            $sonuc["Detay"] = $ayarDeger;
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

