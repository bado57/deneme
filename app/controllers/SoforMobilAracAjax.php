<?php

class SoforMobilAracAjax extends Controller {

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

                case "aracDetay":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('aracid', true);
                        $aracID = $form->values['aracid'];

                        $aracOzellik = $Panel_Model->soforArac($aracID);
                        foreach ($aracOzellik as $aracOzellikk) {
                            $aracList['Marka'] = $aracOzellikk['SBAracMarka'];
                            $aracList['Yil'] = $aracOzellikk['SBAracModelYili'];
                            $aracList['Plaka'] = $aracOzellikk['SBAracPlaka'];
                            $aracList['Kapasite'] = $aracOzellikk['SBAracKapasite'];
                            $aracList['Km'] = $aracOzellikk['SBAracKm'];
                            $aracList['Durum'] = $aracOzellikk['SBAracDurum'];
                            $aracList['Aciklama'] = $aracOzellikk['SBAracAciklama'];
                        }

                        $aracTur = $Panel_Model->soforAracTur($aracID);
                        foreach ($aracTur as $aracTurr) {
                            $aracTurID[] = $aracTurr['BSTurID'];
                        }

                        if (count($aracTurID) > 0) {
                            $turidler = implode(',', $aracTurID);
                            $aracTurDetay = $Panel_Model->soforAracTurlar($turidler);
                            $a = 0;
                            foreach ($aracTurDetay as $aracTurDetayy) {
                                $turList[$a]['ID'] = $aracTurDetayy['SBTurID'];
                                $turList[$a]['Ad'] = $aracTurDetayy['SBTurAd'];
                                $a++;
                            }
                        }

                        $sonuc["Detay"] = $aracList;
                        $sonuc["Tur"] = $turList;
                    }

                    break;

                case "soforAracYolcu":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('aracid', true);
                        $aracID = $form->values['aracid'];

                        $aracSofor = $Panel_Model->soforAraclarS($aracID);
                        $a = 0;
                        foreach ($aracSofor as $aracSoforr) {
                            $aracSoforler[$a]['Id'] = $aracSoforr['BSSoforID'];
                            $aracSoforler[$a]['Ad'] = $aracSoforr['BSSoforAd'];
                            $a++;
                        }

                        $aracHostes = $Panel_Model->soforAraclarH($aracID);
                        if (count($aracHostes) > 0) {
                            $b = 0;
                            foreach ($aracHostes as $aracHostess) {
                                $aracHostesler[$b]['Id'] = $aracHostess['BSHostesID'];
                                $aracHostesler[$b]['Ad'] = $aracHostess['BSHostesAd'];
                                $b++;
                            }
                        }

                        $sonuc["Sofor"] = $aracSoforler;
                        $sonuc["Hostes"] = $aracHostesler;
                    }

                    break;

                case "soforAracYonetici":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('aracid', true);
                        $aracID = $form->values['aracid'];

                        $aracYonetici = $Panel_Model->soforAracY($aracID);
                        foreach ($aracYonetici as $aracYoneticii) {
                            $aracyoneticiid[] = $aracYoneticii['SBBolgeID'];
                        }
                        $aracyoneticiler = implode(',', $aracyoneticiid);

                        $aracSoforYoneti = $Panel_Model->soforAracYoneticiler($aracyoneticiler);
                        foreach ($aracSoforYoneti as $aracSoforYonetii) {
                            $adminler[] = $aracSoforYonetii['BSAdminID'];
                        }
                        $yoneticiler = implode(',', $adminler);

                        $aracYoneti = $Panel_Model->soforYoneticiler($yoneticiler);
                        $a = 0;
                        foreach ($aracYoneti as $aracYonetii) {
                            $adminList[$a]['Id'] = $aracYonetii['BSAdminID'];
                            $adminList[$a]['Ad'] = $aracYonetii['BSAdminAd'];
                            $adminList[$a]['Soyad'] = $aracYonetii['BSAdminSoyad'];
                            $a++;
                        }

                        $sonuc["Yonetici"] = $adminList;
                    }

                    break;

                case "soforYolcuDetay":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('kisiid', true);
                        $form->post('kisitip', true);
                        $kisiID = $form->values['kisiid'];
                        $kisiTip = $form->values['kisitip'];

                        if ($kisiTip == 0) {
                            $yolcuOzellik = $Panel_Model->soforSYolcu($kisiID);
                            foreach ($yolcuOzellik as $yolcuOzellikk) {
                                $kisiList['Ad'] = $yolcuOzellikk['BSSoforAd'];
                                $kisiList['Soyad'] = $yolcuOzellikk['BSSoforSoyad'];
                                $kisiList['Tel'] = $yolcuOzellikk['BSSoforPhone'];
                                $kisiList['Mail'] = $yolcuOzellikk['BSSoforEmail'];
                                $kisiList['Lokasyon'] = $yolcuOzellikk['BSSoforLocation'];
                                $kisiList['Adres'] = $yolcuOzellikk['BSSoforDetayAdres'];
                            }
                        } else {
                            $yolcuOzellik = $Panel_Model->soforHYolcu($kisiID);
                            foreach ($yolcuOzellik as $yolcuOzellikk) {
                                $kisiList['Ad'] = $yolcuOzellikk['BSHostesAd'];
                                $kisiList['Soyad'] = $yolcuOzellikk['BSHostesSoyad'];
                                $kisiList['Tel'] = $yolcuOzellikk['BSHostesPhone'];
                                $kisiList['Mail'] = $yolcuOzellikk['BSHostesEmail'];
                                $kisiList['Lokasyon'] = $yolcuOzellikk['BSHostesLocation'];
                                $kisiList['Adres'] = $yolcuOzellikk['BSHostesDetayAdres'];
                            }
                        }

                        $sonuc["Detay"] = $kisiList;
                    }

                    break;

                case "soforYoneticiDetay":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('kisiid', true);
                        $kisiID = $form->values['kisiid'];

                        $yolcuOzellik = $Panel_Model->soforYYolcu($kisiID);
                        foreach ($yolcuOzellik as $yolcuOzellikk) {
                            $kisiList['Ad'] = $yolcuOzellikk['BSAdminAd'];
                            $kisiList['Soyad'] = $yolcuOzellikk['BSAdminSoyad'];
                            $kisiList['Tel'] = $yolcuOzellikk['BSAdminPhone'];
                            $kisiList['Mail'] = $yolcuOzellikk['BSAdminEmail'];
                            $kisiList['Lokasyon'] = $yolcuOzellikk['BSAdminLocation'];
                            $kisiList['Adres'] = $yolcuOzellikk['BSAdminDetayAdres'];
                        }

                        $sonuc["Detay"] = $kisiList;
                    }

                    break;

                case "soforAracTakvim":
                    $calendar = $this->load->otherClasses('Calendar');
                    // Short-circuit if the client did not give us a date range.
                    if (!isset($_POST['start']) || !isset($_POST['end'])) {
                        error_log("die");
                        die("Please provide a date range.");
                    }
                    // Parse the start/end parameters.
                    // These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
                    // Since no timezone will be present, they will parsed as UTC.
                    $range_start = parseDateTime($_POST['start']);
                    $range_end = parseDateTime($_POST['end']);
                    // Parse the timezone parameter if it is present.
                    $timezone = null;
                    if (isset($_POST['timezone'])) {
                        $timezone = new DateTimeZone($_POST['timezone']);
                    }

                    $form->post("id", true);
                    $id = $form->values['id'];
                    $soforAracTakvim = $Panel_Model->soforAracTakvim($id);
                    $a = 0;
                    foreach ($soforAracTakvim as $soforAracTakvimm) {
                        $tkvimID[$a] = $soforAracTakvimm['BSTurID'];
                        $soforTkvim[$a]['Pzt'] = $soforAracTakvimm['SBTurPzt'];
                        $soforTkvim[$a]['Sli'] = $soforAracTakvimm['SBTurSli'];
                        $soforTkvim[$a]['Crs'] = $soforAracTakvimm['SBTurCrs'];
                        $soforTkvim[$a]['Prs'] = $soforAracTakvimm['SBTurPrs'];
                        $soforTkvim[$a]['Cma'] = $soforAracTakvimm['SBTurCma'];
                        $soforTkvim[$a]['Cmt'] = $soforAracTakvimm['SBTurCmt'];
                        $soforTkvim[$a]['Pzr'] = $soforAracTakvimm['SBTurPzr'];
                        $soforTkvim[$a]['Bslngc'] = $soforAracTakvimm['BSTurBslngc'];
                        $soforTkvim[$a]['Bts'] = $soforAracTakvimm['BSTurBts'];
                        $a++;
                    }

                    $count = count($tkvimID);
                    foreach ($tkvimID as $value) {
                        $sql .= 'SELECT SBTurAd FROM sbtur WHERE SBTurID=' . $value . ' UNION ALL ';
                    }
                    $uzunluk = strlen($sql);
                    $uzunluk = $uzunluk - 10;
                    $sqlTitle = substr($sql, 0, $uzunluk);
                    $takvimTitle = $Panel_Model->takvimTitle($sqlTitle);
                    $c = 0;
                    foreach ($takvimTitle as $takvimTitlee) {
                        $title[$c] = $takvimTitlee['SBTurAd'];
                        $c++;
                    }

                    $input_arrays = [];
                    $input_arrays = $form->calendar($soforTkvim, $title);

                    // Accumulate an output array of event data arrays.
//                    foreach ($input_arrays as $array) {
//
//                        // Convert the input array into a useful Event object
//                        $event = new Calendar($array, $timezone);
//
//                        // If the event is in-bounds, add it to the output
//                        if ($event->isWithinDayRange($range_start, $range_end)) {
//                            //$sonuc[] = $event->toArray();
//                        }
//                    }
                    $sonuc = $input_arrays;
                    break;

                case "yolcuTakvim":
                    $calendar = $this->load->otherClasses('Calendar');
                    // Short-circuit if the client did not give us a date range.
                    if (!isset($_POST['start']) || !isset($_POST['end'])) {
                        error_log("die");
                        die("Please provide a date range.");
                    }
                    // Parse the start/end parameters.
                    // These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
                    // Since no timezone will be present, they will parsed as UTC.
                    $range_start = parseDateTime($_POST['start']);
                    $range_end = parseDateTime($_POST['end']);
                    // Parse the timezone parameter if it is present.
                    $timezone = null;
                    if (isset($_POST['timezone'])) {
                        $timezone = new DateTimeZone($_POST['timezone']);
                    }

                    $form->post("id", true);
                    $form->post("yolcutip", true);
                    $id = $form->values['id'];
                    $yolcuTip = $form->values['yolcutip'];
                    if ($yolcuTip == 0) {//şoför
                        $aracTakvim = $Panel_Model->soforTakvim($id);
                    } else if ($yolcuTip == 1) {//hostes
                        $aracTakvim = $Panel_Model->hostesTakvim($id);
                    }

                    $a = 0;
                    foreach ($aracTakvim as $aracTakvimm) {
                        $tkvimID[$a] = $aracTakvimm['BSTurID'];
                        $aracTkvim[$a]['Pzt'] = $aracTakvimm['SBTurPzt'];
                        $aracTkvim[$a]['Sli'] = $aracTakvimm['SBTurSli'];
                        $aracTkvim[$a]['Crs'] = $aracTakvimm['SBTurCrs'];
                        $aracTkvim[$a]['Prs'] = $aracTakvimm['SBTurPrs'];
                        $aracTkvim[$a]['Cma'] = $aracTakvimm['SBTurCma'];
                        $aracTkvim[$a]['Cmt'] = $aracTakvimm['SBTurCmt'];
                        $aracTkvim[$a]['Pzr'] = $aracTakvimm['SBTurPzr'];
                        $aracTkvim[$a]['Bslngc'] = $aracTakvimm['BSTurBslngc'];
                        $aracTkvim[$a]['Bts'] = $aracTakvimm['BSTurBts'];
                        $a++;
                    }

                    $count = count($tkvimID);
                    foreach ($tkvimID as $value) {
                        $sql .= 'SELECT SBTurAd FROM sbtur WHERE SBTurID=' . $value . ' UNION ALL ';
                    }
                    $uzunluk = strlen($sql);
                    $uzunluk = $uzunluk - 10;
                    $sqlTitle = substr($sql, 0, $uzunluk);
                    $takvimTitle = $Panel_Model->takvimTitle($sqlTitle);
                    $c = 0;
                    foreach ($takvimTitle as $takvimTitlee) {
                        $title[$c] = $takvimTitlee['SBTurAd'];
                        $c++;
                    }

                    $input_arrays = [];
                    $input_arrays = $form->calendar($aracTkvim, $title);

                    // Accumulate an output array of event data arrays.
//                    foreach ($input_arrays as $array) {
//
//                        // Convert the input array into a useful Event object
//                        $event = new Calendar($array, $timezone);
//
//                        // If the event is in-bounds, add it to the output
//                        if ($event->isWithinDayRange($range_start, $range_end)) {
//                            //$sonuc[] = $event->toArray();
//                        }
//                    }
                    $sonuc = $input_arrays;
                    break;
            }
            echo json_encode($sonuc);
        } else {
            die("Hacklemeye mi Çalışıyorsun pezevenk?");
        }
    }

}
?>

