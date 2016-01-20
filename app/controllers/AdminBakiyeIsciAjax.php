<?php

class AdminBakiyeIsciAjax extends Controller {

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
            $Panel_Model = $this->load->model("Panel_Model");
            //language 
            $lang = Session::get("dil");
            $formlanguage = $this->load->ajaxlanguage($lang);
            $languagedeger = $formlanguage->ajaxlanguage();

            $form->post("tip", true);
            $tip = $form->values['tip'];

            Switch ($tip) {
                case "isciDetail":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('id', true);
                        $isciDetailID = $form->values['id'];

                        //Öğrenci Özellikleri
                        $isciOzellik = $Panel_Model->isciBakiyeDetail($isciDetailID);
                        foreach ($isciOzellik as $isciOzellikk) {
                            $isciList[0][0]['IsciListID'] = $isciOzellikk['SBIsciID'];
                            $isciList[0][0]['IsciListAd'] = $isciOzellikk['SBIsciAd'];
                            $isciList[0][0]['IsciListSoyad'] = $isciOzellikk['SBIsciSoyad'];
                            $isciList[0][0]['OdemeTutar'] = number_format($isciOzellikk['OdemeTutar'], 2, '.', ',');
                            $isciList[0][0]['OdenenTutar'] = number_format($isciOzellikk['OdenenTutar'], 2, '.', ',');
                            $isciList[0][0]['OdemeParaTip'] = $isciOzellikk['OdemeParaTip'];
                            $isciList[0][0]['KalanTutar'] = number_format($isciOzellikk['OdemeTutar'] - $isciOzellikk['OdenenTutar'], 2, '.', ',');
                        }

                        //işçi Ödeme Özellikleri
                        $isciOdeme = $Panel_Model->isciOdemeDetail($isciDetailID);
                        if (count($isciOdeme) > 0) {
                            $o = 0;
                            foreach ($isciOdeme as $isciOdemee) {
                                $isciList[1][$o]['ID'] = $isciOdemee['BSOdemeID'];
                                $isciList[1][$o]['OdemeAlanID'] = $isciOdemee['BSOdemeAlanID'];
                                $isciList[1][$o]['OdemeAlanAd'] = $isciOdemee['BSOdemeAlanAd'];
                                $isciList[1][$o]['OdemeAlanTip'] = $languagedeger['Yonetici'];
                                $isciList[1][$o]['OdemeYapanID'] = $isciOdemee['BSOdemeYapanID'];
                                $isciList[1][$o]['OdemeYapanAd'] = $isciOdemee['BSOdemeYapanAd'];
                                $isciList[1][$o]['OdemeYapanTip'] = $languagedeger['Personel'];
                                $isciList[1][$o]['OdemeTutar'] = number_format($isciOdemee['BSOdemeTutar'], 2, '.', ',');
                                $tarih = explode(" ", $isciOdemee['BSOdemeTarih']);
                                $digerTarih = explode("-", $tarih[0]);
                                $yeniTarih = $tarih[1] . '--' . $digerTarih[2] . '/' . $digerTarih[1] . '/' . $digerTarih[0];
                                $isciList[1][$o]['OdemeTarih'] = $yeniTarih;
                                $isciList[1][$o]['OdemeAciklama'] = $isciOdemee['BSOdemeAciklama'];
                                if ($isciOdemee['BSOdemeTip'] == 0) {
                                    $isciList[1][$o]['OdemeTip'] = $languagedeger['Elden'];
                                } elseif ($isciOdemee['BSOdemeTip'] == 1) {
                                    $isciList[1][$o]['OdemeTip'] = $languagedeger['KrediKartı'];
                                } else {
                                    $isciList[1][$o]['OdemeTip'] = $languagedeger['Havale'];
                                }
                                $o++;
                            }
                        }
                        //sonuçlar
                        $sonuc["isciDetail"] = $isciList;
                    }
                    break;
                case "isciOdemeKaydet":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $degerbildirim = $formlanguage->bildirimlanguage();
                        $form->post('odemeYapanText', true);
                        $form->post('odemeYapanVal', true);
                        $form->post('odemeYapanTip', true);
                        $form->post('odemeTutar', true);
                        $form->post('dovizTip', true);
                        $form->post('odemeSekil', true);
                        $form->post('aciklama', true);
                        $form->post('odenenID', true);
                        $form->post('odenenAdSyd', true);
                        $odemeYapanText = $form->values['odemeYapanText'];
                        $odemeYapan = explode("(", $odemeYapanText);
                        $odemeYapanVal = $form->values['odemeYapanVal'];
                        $odemeYapanTip = $form->values['odemeYapanTip'];
                        $odemeTutar = $form->values['odemeTutar'];
                        $dovizTip = $form->values['dovizTip'];
                        $odemeSekil = $form->values['odemeSekil'];
                        $aciklama = $form->values['aciklama'];
                        $odenenID = $form->values['odenenID'];
                        $odenenAdSyd = $form->values['odenenAdSyd'];

                        //gelen para değerini virgülden temizleme
                        $length = strlen($odemeTutar);
                        for ($l = 0; $l < $length; $l++) {
                            if ($odemeTutar[$l] != ",") {
                                $odemeValue.=$odemeTutar[$l];
                            }
                        }
                        if ($form->submit()) {
                            $data = array(
                                'BSOdemeAlanID' => $adminID,
                                'BSOdemeAlanAd' => Session::get("kullaniciad") . " " . Session::get("kullanicisoyad"),
                                'BSOdemeAlanTip' => 0,
                                'BSOdenenID' => $odenenID,
                                'BSOdenenAd' => $odenenAdSyd,
                                'BSOdemeYapanID' => $odemeYapanVal,
                                'BSOdemeYapanAd' => trim($odemeYapan[0]),
                                'BSOdemeTutar' => $odemeValue,
                                'BSOdemeAciklama' => $aciklama,
                                'BSOdemeTip' => $odemeSekil,
                                'BSDovizTip' => $dovizTip
                            );
                        }
                        $result = $Panel_Model->isciBakiyeKaydet($data);
                        if ($result) {
                            $insertDate = date('H:i:s--d/m/Y');
                            $iscibak = $Panel_Model->bakiyeIsciOdenen($odenenID);
                            $dataUpdate = array(
                                'OdenenTutar' => $iscibak[0]['OdenenTutar'] + $odemeValue
                            );
                            $resultUpdate = $Panel_Model->isciBakiyeGuncelle($dataUpdate, $odenenID);
                            if ($resultUpdate) {
                                //Bildirim Durumları
                                //öğrenciye bildirim gönderme
                                $alert = $degerbildirim["OdemeYapma"];
                                $resultIsciCihaz = $Panel_Model->bakiyeIsciCihaz($odenenID);
                                if (count($resultIsciCihaz) > 0) {
                                    foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                        $isciCihaz[] = $resultIsciCihazz['bsiscicihazRecID'];
                                    }
                                    $isciCihazlar = implode(',', $isciCihaz);
                                    $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["Bakiye"]);
                                }
                                $isciList[0]['OdemeAlanAd'] = Session::get("kullaniciad") . " " . Session::get("kullanicisoyad");
                                $isciList[0]['OdemeAlanTip'] = $languagedeger['Yonetici'];
                                $isciList[0]['OdemeYapanAd'] = trim($odemeYapan[0]);
                                $isciList[0]['OdemeYapanTip'] = $languagedeger['Personel'];
                                $isciList[0]['OdemeTutar'] = $odemeTutar;
                                $isciList[0]['OdemeParaTip'] = $dovizTip;
                                if ($odemeSekil == 0) {
                                    $isciList[0]['OdemeTip'] = $languagedeger['Elden'];
                                } elseif ($odemeSekil == 1) {
                                    $isciList[0]['OdemeTip'] = $languagedeger['KrediKartı'];
                                } else {
                                    $isciList[0]['OdemeTip'] = $languagedeger['Havale'];
                                }
                                $isciList[0]['OdemeTarih'] = $insertDate;
                                $odenenTutar = $iscibak[0]['OdenenTutar'] + $odemeValue;
                                $isciList[0]['OdenenTutar'] = number_format($odenenTutar, 2, '.', ',');
                                $isciList[0]['KalanTutar'] = number_format($iscibak[0]['OdemeTutar'] - $odenenTutar, 2, '.', ',');
                                $isciList[0]['Insert'] = $languagedeger['YeniOdeme'];
                                $isciList[0]['ID'] = $result;
                                $sonuc["result"] = $isciList;
                            } else {
                                $deleteresult = $Panel_Model->isciBakiyeDelete($result);
                                $sonuc["hata"] = $languagedeger['Hata'];
                            }
                        } else {
                            $sonuc["hata"] = $languagedeger['Hata'];
                        }
                    }
                    break;
                case "bakiyeDetailDelete":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('rowID', true);
                        $form->post('isciID', true);
                        $form->post('tutar', true);
                        $rowID = $form->values['rowID'];
                        $isciID = $form->values['isciID'];
                        $tutar = $form->values['tutar'];
                        $length = strlen($tutar);
                        for ($l = 0; $l < $length; $l++) {
                            if ($tutar[$l] != ",") {
                                $newTutar.=$tutar[$l];
                            }
                        }
                        $deleteresult = $Panel_Model->isciBakiyeDelete($rowID);
                        if ($deleteresult) {
                            $isciDetail = $Panel_Model->iscOdemeDetail($isciID);
                            $odenenTutar = $isciDetail[0]["OdenenTutar"] - $newTutar;
                            $dataUpdate = array(
                                'OdenenTutar' => $odenenTutar
                            );
                            $resultUpdate = $Panel_Model->isciSilmeBakiyeGuncelle($dataUpdate, $isciID);
                            if ($resultUpdate) {
                                $isciList[0]['OdenenTutar'] = number_format($odenenTutar, 2, '.', ',');
                                $isciList[0]['KalanTutar'] = number_format($isciDetail[0]['OdemeTutar'] - $odenenTutar, 2, '.', ',');
                            } else {
                                $resultUpdate = $Panel_Model->isciSilmeBakiyeGuncelle($dataUpdate, $isciID);
                                if ($resultUpdate) {
                                    $isciList[0]['OdenenTutar'] = number_format($odenenTutar, 2, '.', ',');
                                    $isciList[0]['KalanTutar'] = number_format($isciDetail[0]['OdemeTutar'] - $odenenTutar, 2, '.', ',');
                                }
                            }
                            $isciList[0]['Delete'] = $languagedeger['BakiyeSilme'];
                            $sonuc["result"] = $isciList;
                        } else {
                            $sonuc["hata"] = $languagedeger['Hata'];
                        }
                    }
                    break;
                case "isciOdemeDetailKaydet":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('odemeYapanText', true);
                        $form->post('odemeYapanVal', true);
                        $form->post('odemeTutar', true);
                        $form->post('oncekiTutar', true);
                        $form->post('dovizTip', true);
                        $form->post('odemeSekil', true);
                        $form->post('aciklama', true);
                        $form->post('odenenID', true);
                        $form->post('odenenAdSyd', true);
                        $form->post('rowID', true);
                        $odemeYapanText = $form->values['odemeYapanText'];
                        $odemeYapan = explode("(", $odemeYapanText);
                        $odemeYapanVal = $form->values['odemeYapanVal'];
                        $odemeTutar = $form->values['odemeTutar'];
                        $oncekiTutar = $form->values['oncekiTutar'];
                        $dovizTip = $form->values['dovizTip'];
                        $odemeSekil = $form->values['odemeSekil'];
                        $aciklama = $form->values['aciklama'];
                        $odenenID = $form->values['odenenID'];
                        $odenenAdSyd = $form->values['odenenAdSyd'];
                        $rowID = $form->values['rowID'];

                        //gelen para değerini virgülden temizleme
                        $length = strlen($odemeTutar);
                        for ($l = 0; $l < $length; $l++) {
                            if ($odemeTutar[$l] != ",") {
                                $odemeValue.=$odemeTutar[$l];
                            }
                        }
                        $length = strlen($oncekiTutar);
                        for ($l = 0; $l < $length; $l++) {
                            if ($oncekiTutar[$l] != ",") {
                                $odemeValueOnceki.=$oncekiTutar[$l];
                            }
                        }
                        if ($form->submit()) {
                            $data = array(
                                'BSOdemeYapanID' => $odemeYapanVal,
                                'BSOdemeYapanAd' => trim($odemeYapan[0]),
                                'BSOdemeTutar' => $odemeValue,
                                'BSOdemeAciklama' => $aciklama,
                                'BSOdemeTip' => $odemeSekil
                            );
                        }
                        $result = $Panel_Model->isciBakiyeDetailGuncelle($data, $rowID);
                        if ($result) {
                            $iscibak = $Panel_Model->bakiyeIsciOdenen($odenenID);
                            $dataUpdate = array(
                                'OdenenTutar' => ($iscibak[0]['OdenenTutar'] - $odemeValueOnceki) + $odemeValue
                            );
                            $resultUpdate = $Panel_Model->isciBakiyeGuncelle($dataUpdate, $odenenID);
                            if ($resultUpdate) {
                                $isciList[0]['OdemeYapanAd'] = trim($odemeYapan[0]);
                                $isciList[0]['OdemeYapanTip'] = $languagedeger['Personel'];
                                $isciList[0]['OdemeTutar'] = $odemeTutar;
                                $isciList[0]['OdemeParaTip'] = $dovizTip;
                                if ($odemeSekil == 0) {
                                    $isciList[0]['OdemeTip'] = $languagedeger['Elden'];
                                } elseif ($odemeSekil == 1) {
                                    $isciList[0]['OdemeTip'] = $languagedeger['KrediKartı'];
                                } else {
                                    $isciList[0]['OdemeTip'] = $languagedeger['Havale'];
                                }
                                $odenenTutar = ($iscibak[0]['OdenenTutar'] - $odemeValueOnceki) + $odemeValue;
                                $isciList[0]['OdenenTutar'] = number_format($odenenTutar, 2, '.', ',');
                                $isciList[0]['KalanTutar'] = number_format($iscibak[0]['OdemeTutar'] - $odenenTutar, 2, '.', ',');
                                $isciList[0]['update'] = $languagedeger['OdemeDuzenle'];
                                $sonuc["result"] = $isciList;
                            } else {
                                $sonuc["hata"] = $languagedeger['Hata'];
                            }
                        } else {
                            $sonuc["hata"] = $languagedeger['Hata'];
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

