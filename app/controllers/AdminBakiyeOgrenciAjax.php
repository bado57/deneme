<?php

class AdminBakiyeOgrenciAjax extends Controller {

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
                case "ogrenciDetail":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('id', true);
                        $ogrenciDetailID = $form->values['id'];

                        //Öğrenci Özellikleri
                        $ogrenciOzellik = $Panel_Model->ogrenciBakiyeDetail($ogrenciDetailID);
                        foreach ($ogrenciOzellik as $ogrenciOzellikk) {
                            $ogrenciList[0][0]['OgrenciListID'] = $ogrenciOzellikk['BSOgrenciID'];
                            $ogrenciList[0][0]['OgrenciListAd'] = $ogrenciOzellikk['BSOgrenciAd'];
                            $ogrenciList[0][0]['OgrenciListSoyad'] = $ogrenciOzellikk['BSOgrenciSoyad'];
                            $ogrenciList[0][0]['OdemeTutar'] = number_format($ogrenciOzellikk['OdemeTutar'], 2, '.', ',');
                            $ogrenciList[0][0]['OdenenTutar'] = number_format($ogrenciOzellikk['OdenenTutar'], 2, '.', ',');
                            $ogrenciList[0][0]['OdemeParaTip'] = $ogrenciOzellikk['OdemeParaTip'];
                            $ogrenciList[0][0]['KalanTutar'] = number_format($ogrenciOzellikk['OdemeTutar'] - $ogrenciOzellikk['OdenenTutar'], 2, '.', ',');
                        }

                        //Öğrenci Ödeme Özellikleri
                        $ogrenciOdeme = $Panel_Model->ogrenciOdemeDetail($ogrenciDetailID);
                        if (count($ogrenciOdeme) > 0) {
                            $o = 0;
                            foreach ($ogrenciOdeme as $ogrenciOdemee) {
                                $ogrenciList[1][$o]['ID'] = $ogrenciOdemee['BSOdemeID'];
                                $ogrenciList[1][$o]['OdemeAlanID'] = $ogrenciOdemee['BSOdemeAlanID'];
                                $ogrenciList[1][$o]['OdemeAlanAd'] = $ogrenciOdemee['BSOdemeAlanAd'];
                                $ogrenciList[1][$o]['OdemeAlanTip'] = $languagedeger['Yonetici'];
                                $ogrenciList[1][$o]['OdemeYapanID'] = $ogrenciOdemee['BSOdemeYapanID'];
                                $ogrenciList[1][$o]['OdemeYapanAd'] = $ogrenciOdemee['BSOdemeYapanAd'];
                                if ($ogrenciOdemee['BSOdemeYapanTip'] == 0) {
                                    $ogrenciList[1][$o]['OdemeYapanTp'] = 0;
                                    $ogrenciList[1][$o]['OdemeYapanTip'] = $languagedeger['Ogrenci'];
                                } else {
                                    $ogrenciList[1][$o]['OdemeYapanTp'] = 1;
                                    $ogrenciList[1][$o]['OdemeYapanTip'] = $languagedeger['Veli'];
                                }
                                $ogrenciList[1][$o]['OdemeTutar'] = number_format($ogrenciOdemee['BSOdemeTutar'], 2, '.', ',');
                                $tarih = explode(" ", $ogrenciOdemee['BSOdemeTarih']);
                                $digerTarih = explode("-", $tarih[0]);
                                $yeniTarih = $tarih[1] . '--' . $digerTarih[2] . '/' . $digerTarih[1] . '/' . $digerTarih[0];
                                $ogrenciList[1][$o]['OdemeTarih'] = $yeniTarih;
                                $ogrenciList[1][$o]['OdemeAciklama'] = $ogrenciOdemee['BSOdemeAciklama'];
                                if ($ogrenciOdemee['BSOdemeTip'] == 0) {
                                    $ogrenciList[1][$o]['OdemeTip'] = $languagedeger['Elden'];
                                } elseif ($ogrenciOdemee['BSOdemeTip'] == 1) {
                                    $ogrenciList[1][$o]['OdemeTip'] = $languagedeger['KrediKartı'];
                                } else {
                                    $ogrenciList[1][$o]['OdemeTip'] = $languagedeger['Havale'];
                                }
                                $o++;
                            }
                        }
                        //sonuçlar
                        $sonuc["ogrenciDetail"] = $ogrenciList;
                    }
                    break;
                case "ogrenciYeniOdeme":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('ogrID', true);
                        $ogrID = $form->values['ogrID'];

                        //Öğrenci Vewlileri
                        $veliler = $Panel_Model->ogrenciBakiyeVeli($ogrID);
                        $veliList = [];
                        if (count($veliler) > 0) {
                            $a = 0;
                            foreach ($veliler as $velilerr) {
                                $veliList[$a]['ID'] = $velilerr['BSVeliID'];
                                $veliList[$a]['Ad'] = $velilerr['BSVeliAd'];
                            }
                            $a++;
                        }
                        //sonuçlar
                        $sonuc["veliler"] = $veliList;
                    }
                    break;
                case "ogrenciOdemeKaydet":
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
                                'BSOdemeYapanTip' => $odemeYapanTip,
                                'BSOdemeYapanAd' => trim($odemeYapan[0]),
                                'BSOdemeTutar' => $odemeValue,
                                'BSOdemeAciklama' => $aciklama,
                                'BSOdemeTip' => $odemeSekil,
                                'BSDovizTip' => $dovizTip
                            );
                        }
                        $result = $Panel_Model->ogrenciBakiyeKaydet($data);
                        if ($result) {
                            $insertDate = date('H:i:s--d/m/Y');
                            $ogrencibak = $Panel_Model->bakiyeOgrenciOdenen($odenenID);
                            $dataUpdate = array(
                                'OdenenTutar' => $ogrencibak[0]['OdenenTutar'] + $odemeValue
                            );
                            $resultUpdate = $Panel_Model->ogrenciBakiyeGuncelle($dataUpdate, $odenenID);
                            if ($resultUpdate) {
                                //Bildirim Durumları
                                //öğrenciye bildirim gönderme
                                $alert = $degerbildirim["OdemeYapma"];
                                $resultOgrenciCihaz = $Panel_Model->bakiyeOgrenciCihaz($odenenID);
                                if (count($resultOgrenciCihaz) > 0) {
                                    foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                        $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                    }
                                    $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                    $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["Bakiye"]);
                                }

                                //veliye bildirim gönderme
                                $resultVeliOgrenci = $Panel_Model->veliOgrenci($odenenID);
                                if (count($resultVeliOgrenci) > 0) {
                                    foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                        $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                    }
                                    $ogrenciVelim = implode(',', $ogrenciVeliler);
                                    $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                    foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                        $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                    }
                                    $veliCihazlar = implode(',', $veliCihaz);
                                    $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["Bakiye"]);
                                }

                                $ogrenciList[0]['OdemeAlanAd'] = Session::get("kullaniciad") . " " . Session::get("kullanicisoyad");
                                $ogrenciList[0]['OdemeAlanTip'] = $languagedeger['Yonetici'];
                                $ogrenciList[0]['OdemeYapanAd'] = trim($odemeYapan[0]);
                                if ($odemeYapanTip == 0) {
                                    $ogrenciList[0]['OdemeYapanTp'] = 0;
                                    $ogrenciList[0]['OdemeYapanTip'] = $languagedeger['Ogrenci'];
                                } else {
                                    $ogrenciList[0]['OdemeYapanTp'] = 1;
                                    $ogrenciList[0]['OdemeYapanTip'] = $languagedeger['Veli'];
                                }
                                $ogrenciList[0]['OdemeTutar'] = $odemeTutar;
                                $ogrenciList[0]['OdemeParaTip'] = $dovizTip;
                                if ($odemeSekil == 0) {
                                    $ogrenciList[0]['OdemeTip'] = $languagedeger['Elden'];
                                } elseif ($odemeSekil == 1) {
                                    $ogrenciList[0]['OdemeTip'] = $languagedeger['KrediKartı'];
                                } else {
                                    $ogrenciList[0]['OdemeTip'] = $languagedeger['Havale'];
                                }
                                $ogrenciList[0]['OdemeTarih'] = $insertDate;
                                $odenenTutar = $ogrencibak[0]['OdenenTutar'] + $odemeValue;
                                $ogrenciList[0]['OdenenTutar'] = number_format($odenenTutar, 2, '.', ',');
                                $ogrenciList[0]['KalanTutar'] = number_format($ogrencibak[0]['OdemeTutar'] - $odenenTutar, 2, '.', ',');
                                $ogrenciList[0]['Insert'] = $languagedeger['YeniOdeme'];
                                $ogrenciList[0]['ID'] = $result;
                                $sonuc["result"] = $ogrenciList;
                            } else {
                                $deleteresult = $Panel_Model->ogrenciBakiyeDelete($result);
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
                        $form->post('ogrID', true);
                        $form->post('tutar', true);
                        $rowID = $form->values['rowID'];
                        $ogrID = $form->values['ogrID'];
                        $tutar = $form->values['tutar'];
                        $length = strlen($tutar);
                        for ($l = 0; $l < $length; $l++) {
                            if ($tutar[$l] != ",") {
                                $newTutar.=$tutar[$l];
                            }
                        }
                        $deleteresult = $Panel_Model->ogrenciBakiyeDelete($rowID);
                        if ($deleteresult) {
                            $ogrDetail = $Panel_Model->ogrOdemeDetail($ogrID);
                            $odenenTutar = $ogrDetail[0]["OdenenTutar"] - $newTutar;
                            $dataUpdate = array(
                                'OdenenTutar' => $odenenTutar
                            );
                            $resultUpdate = $Panel_Model->ogrenciSilmeBakiyeGuncelle($dataUpdate, $ogrID);
                            if ($resultUpdate) {
                                $ogrenciList[0]['OdenenTutar'] = number_format($odenenTutar, 2, '.', ',');
                                $ogrenciList[0]['KalanTutar'] = number_format($ogrDetail[0]['OdemeTutar'] - $odenenTutar, 2, '.', ',');
                            } else {
                                $resultUpdate = $Panel_Model->ogrenciSilmeBakiyeGuncelle($dataUpdate, $ogrID);
                                if ($resultUpdate) {
                                    $ogrenciList[0]['OdenenTutar'] = number_format($odenenTutar, 2, '.', ',');
                                    $ogrenciList[0]['KalanTutar'] = number_format($ogrDetail[0]['OdemeTutar'] - $odenenTutar, 2, '.', ',');
                                }
                            }
                            $ogrenciList[0]['Delete'] = $languagedeger['BakiyeSilme'];
                            $sonuc["result"] = $ogrenciList;
                        } else {
                            $sonuc["hata"] = $languagedeger['Hata'];
                        }
                    }
                    break;
                case "ogrenciOdemeDetailKaydet":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('odemeYapanText', true);
                        $form->post('odemeYapanVal', true);
                        $form->post('odemeYapanTip', true);
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
                        $odemeYapanTip = $form->values['odemeYapanTip'];
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
                                'BSOdemeYapanTip' => $odemeYapanTip,
                                'BSOdemeYapanAd' => trim($odemeYapan[0]),
                                'BSOdemeTutar' => $odemeValue,
                                'BSOdemeAciklama' => $aciklama,
                                'BSOdemeTip' => $odemeSekil
                            );
                        }
                        $result = $Panel_Model->ogrenciBakiyeDetailGuncelle($data, $rowID);
                        if ($result) {
                            $ogrencibak = $Panel_Model->bakiyeOgrenciOdenen($odenenID);
                            $dataUpdate = array(
                                'OdenenTutar' => ($ogrencibak[0]['OdenenTutar'] - $odemeValueOnceki) + $odemeValue
                            );
                            $resultUpdate = $Panel_Model->ogrenciBakiyeGuncelle($dataUpdate, $odenenID);
                            if ($resultUpdate) {
                                $ogrenciList[0]['OdemeYapanAd'] = trim($odemeYapan[0]);
                                if ($odemeYapanTip == 0) {
                                    $ogrenciList[0]['OdemeYapanTp'] = 0;
                                    $ogrenciList[0]['OdemeYapanTip'] = $languagedeger['Ogrenci'];
                                } else {
                                    $ogrenciList[0]['OdemeYapanTp'] = 1;
                                    $ogrenciList[0]['OdemeYapanTip'] = $languagedeger['Veli'];
                                }
                                $ogrenciList[0]['OdemeTutar'] = $odemeTutar;
                                $ogrenciList[0]['OdemeParaTip'] = $dovizTip;
                                if ($odemeSekil == 0) {
                                    $ogrenciList[0]['OdemeTip'] = $languagedeger['Elden'];
                                } elseif ($odemeSekil == 1) {
                                    $ogrenciList[0]['OdemeTip'] = $languagedeger['KrediKartı'];
                                } else {
                                    $ogrenciList[0]['OdemeTip'] = $languagedeger['Havale'];
                                }
                                $odenenTutar = ($ogrencibak[0]['OdenenTutar'] - $odemeValueOnceki) + $odemeValue;
                                $ogrenciList[0]['OdenenTutar'] = number_format($odenenTutar, 2, '.', ',');
                                $ogrenciList[0]['KalanTutar'] = number_format($ogrencibak[0]['OdemeTutar'] - $odenenTutar, 2, '.', ',');
                                $ogrenciList[0]['update'] = $languagedeger['OdemeDuzenle'];
                                $sonuc["result"] = $ogrenciList;
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

