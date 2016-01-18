<?php

class AdminLokasyonAjaxSorgu extends Controller {

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

            $form->post("tip", true);
            $tip = $form->values['tip'];

            Switch ($tip) {

                case "aracLokasyonDetail":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {

                        $form->post('aracID', true);
                        $form->post('turID', true);
                        $form->post('turTipID', true);
                        $form->post('turGidisDonus', true);
                        $aracID = $form->values['aracID'];
                        $turID = $form->values['turID'];
                        $turTip = $form->values['turTipID'];
                        $turGidisDonus = $form->values['turGidisDonus'];
                        $yeniGun = $form->gunCevirme(date("D"));

                        //araç anlık lokasyon
                        $aracLokasyon = $Panel_Model->aracLokasyon($aracID);

                        if ($turGidisDonus != 1) {//Gidiş
                            if ($turTip == 0) {//öğrenci turu
                                $ogrenciTurListele = $Panel_Model->turOgrenciIDListele($turID);
                                foreach ($ogrenciTurListele as $ogrenciTurListelee) {
                                    $turGelen[] = $ogrenciTurListelee['BSOgrenciID'];
                                }
                                //o gün gelemeyen öğrenci
                                $ogrenciTurGunListele = $Panel_Model->turOgrenciGunIDListele($turID, $yeniGun, $turGidisDonus);
                                foreach ($ogrenciTurGunListele as $ogrenciTurGunListelee) {
                                    $turGelmeyen[] = $ogrenciTurGunListelee['BSOgrenciID'];
                                }
                                if (count($turGelmeyen) > 0) {//o tura gelmeyen varsa
                                    $turagelenler = array_diff($turGelen, $turGelmeyen);
                                    //tura giderken binenler kimler
                                    $ogrenciBinen = $Panel_Model->turOgrenciBinenIDListele($turID);
                                    foreach ($ogrenciBinen as $ogrenciBinenn) {
                                        $turBinen[] = $ogrenciBinenn['BSKisiID'];
                                    }
                                    //tur binmeyenler
                                    if (count($ogrenciBinen) > 0) {
                                        $turbinmeyen = array_diff($turagelenler, $turBinen);
                                    } else {
                                        $turbinmeyen = $turagelenler;
                                    }
                                    $turaBinenler = implode(',', $turBinen);

                                    $ogrenciBinenListele = $Panel_Model->turGidisOgrenciBinenListele($turID, $turaBinenler);
                                    if (count($ogrenciBinenListele) > 0) {
                                        $a = 0;
                                        foreach ($ogrenciBinenListele as $ogrenciBinenListelee) {
                                            $turBinenler['TurBinenTip'][$a] = 0;
                                            $turBinenler['TurBinenID'][$a] = $ogrenciBinenListelee['BSOgrenciID'];
                                            $turBinenler['TurBinenAd'][$a] = $ogrenciBinenListelee['BSOgrenciAd'];
                                            $turBinenler['TurBinenLocation'][$a] = $ogrenciBinenListelee['BSOgrenciLocation'];
                                            $a++;
                                        }
                                    }
                                    $turaBinemeyen = implode(',', $turbinmeyen);
                                    $ogrenciBinmeyenListele = $Panel_Model->turGidisOgrenciBinmeyenListele($turID, $turaBinemeyen);
                                    $b = 0;
                                    foreach ($ogrenciBinmeyenListele as $ogrenciBinmeyenListelee) {
                                        $turBinmeyen['TurBinmeyenTip'][$b] = 0;
                                        $turBinmeyen['TurBinmeyenID'][$b] = $ogrenciBinmeyenListelee['BSOgrenciID'];
                                        $turBinmeyen['TurBinmeyenAd'][$b] = $ogrenciBinmeyenListelee['BSOgrenciAd'];
                                        $turBinmeyen['TurBinmeyenLocation'][$b] = $ogrenciBinmeyenListelee['BSOgrenciLocation'];
                                        $b++;
                                    }
                                } else {//tura gelmeyen yoksa yani herkes geliyorsa
                                    //tura giderken binenler kimler
                                    $ogrenciBinen = $Panel_Model->turOgrenciBinenIDListele($turID);
                                    foreach ($ogrenciBinen as $ogrenciBinenn) {
                                        $turBinen[] = $ogrenciBinenn['BSKisiID'];
                                    }
                                    //tur binmeyenler
                                    if (count($ogrenciBinen) > 0) {
                                        $turbinmeyen = array_diff($turGelen, $turBinen);
                                    } else {
                                        $turbinmeyen = $turGelen;
                                    }

                                    $turaBinenler = implode(',', $turBinen);

                                    $ogrenciBinenListele = $Panel_Model->turGidisOgrenciBinenListele($turID, $turaBinenler);
                                    if (count($ogrenciBinenListele) > 0) {
                                        $a = 0;
                                        foreach ($ogrenciBinenListele as $ogrenciBinenListelee) {
                                            $turBinenler['TurBinenTip'][$a] = 0;
                                            $turBinenler['TurBinenID'][$a] = $ogrenciBinenListelee['BSOgrenciID'];
                                            $turBinenler['TurBinenAd'][$a] = $ogrenciBinenListelee['BSOgrenciAd'];
                                            $turBinenler['TurBinenLocation'][$a] = $ogrenciBinenListelee['BSOgrenciLocation'];
                                            $a++;
                                        }
                                    }
                                    $turaBinemeyen = implode(',', $turbinmeyen);
                                    $ogrenciBinmeyenListele = $Panel_Model->turGidisOgrenciBinmeyenListele($turID, $turaBinemeyen);
                                    $b = 0;
                                    foreach ($ogrenciBinmeyenListele as $ogrenciBinmeyenListelee) {
                                        $turBinmeyen['TurBinmeyenTip'][$b] = 0;
                                        $turBinmeyen['TurBinmeyenID'][$b] = $ogrenciBinmeyenListelee['BSOgrenciID'];
                                        $turBinmeyen['TurBinmeyenAd'][$b] = $ogrenciBinmeyenListelee['BSOgrenciAd'];
                                        $turBinmeyen['TurBinmeyenLocation'][$b] = $ogrenciBinmeyenListelee['BSOgrenciLocation'];
                                        $b++;
                                    }
                                }
                            } else if ($turTip == 1) {//işçi turu
                                $isciTurListele = $Panel_Model->turIsciIDListele($turID);
                                foreach ($isciTurListele as $isciTurListelee) {
                                    $turGelen[] = $isciTurListelee['SBIsciID'];
                                }
                                //o gün gelemeyen öğrenci
                                $isciTurGunListele = $Panel_Model->turIsciGunIDListele($turID, $yeniGun, $turGidisDonus);
                                foreach ($isciTurGunListele as $isciTurGunListelee) {
                                    $turGelmeyen[] = $isciTurGunListelee['BSIsciID'];
                                }
                                if (count($turGelmeyen) > 0) {//o tura gelmeyen varsa
                                    $turagelenler = array_diff($turGelen, $turGelmeyen);
                                    //tura giderken binenler kimler
                                    $isciBinen = $Panel_Model->turIsciBinenIDListele($turID);
                                    foreach ($isciBinen as $isciBinenn) {
                                        $turBinen[] = $isciBinenn['BSKisiID'];
                                    }
                                    //tur binmeyenler
                                    if (count($isciBinen) > 0) {
                                        $turbinmeyen = array_diff($turagelenler, $turBinen);
                                    } else {
                                        $turbinmeyen = $turagelenler;
                                    }
                                    $turaBinen = implode(',', $turBinen);
                                    $isciBinenListele = $Panel_Model->turGidisIsciBinenListele($turID, $turaBinen);
                                    if (count($isciBinenListele) > 0) {
                                        $a = 0;
                                        foreach ($isciBinenListele as $isciBinenListelee) {
                                            $turBinenler['TurBinenTip'][$a] = 1;
                                            $turBinenler['TurBinenID'][$a] = $isciBinenListelee['SBIsciID'];
                                            $turBinenler['TurBinenAd'][$a] = $isciBinenListelee['SBIsciAd'];
                                            $turBinenler['TurBinenLocation'][$a] = $isciBinenListelee['SBIsciLocation'];
                                            $a++;
                                        }
                                    }
                                    $turaBinemeyen = implode(',', $turbinmeyen);
                                    $isciBinmeyenListele = $Panel_Model->turGidisIsciBinmeyenListele($turID, $turaBinemeyen);
                                    $b = 0;
                                    foreach ($isciBinmeyenListele as $isciBinmeyenListelee) {
                                        $turBinmeyen['TurBinmeyenTip'][$b] = 1;
                                        $turBinmeyen['TurBinmeyenID'][$b] = $isciBinmeyenListelee['SBIsciID'];
                                        $turBinmeyen['TurBinmeyenAd'][$b] = $isciBinmeyenListelee['SBIsciAd'];
                                        $turBinmeyen['TurBinmeyenLocation'][$b] = $isciBinmeyenListelee['SBIsciLocation'];
                                        $b++;
                                    }
                                } else {//tura gelmeyen yoksa yani herkes geliyorsa
                                    //tura giderken binenler kimler
                                    $isciBinen = $Panel_Model->turIsciBinenIDListele($turID);
                                    foreach ($isciBinen as $isciBinenn) {
                                        $turBinen[] = $isciBinenn['BSKisiID'];
                                    }
                                    //tur binmeyenler
                                    if (count($isciBinen) > 0) {
                                        $turbinmeyen = array_diff($turGelen, $turBinen);
                                    } else {
                                        $turbinmeyen = $turGelen;
                                    }
                                    $turBinen = implode(',', $turbinmeyen);
                                    $isciBinenListele = $Panel_Model->turGidisIsciBinenListele($turID, $turBinen);
                                    if (count($isciBinenListele) > 0) {
                                        $a = 0;
                                        foreach ($isciBinenListele as $isciBinenListelee) {
                                            $turBinenler['TurBinenTip'][$a] = 1;
                                            $turBinenler['TurBinenID'][$a] = $isciBinenListelee['SBIsciID'];
                                            $turBinenler['TurBinenAd'][$a] = $isciBinenListelee['SBIsciAd'];
                                            $turBinenler['TurBinenLocation'][$a] = $isciBinenListelee['SBIsciLocation'];
                                            $a++;
                                        }
                                    }
                                    $turaBinemeyen = implode(',', $turbinmeyen);
                                    $isciBinmeyenListele = $Panel_Model->turGidisIsciBinmeyenListele($turID, $turaBinemeyen);
                                    $b = 0;
                                    foreach ($isciBinmeyenListele as $isciBinmeyenListelee) {
                                        $turBinmeyen['TurBinmeyenTip'][$b] = 1;
                                        $turBinmeyen['TurBinmeyenID'][$b] = $isciBinmeyenListelee['SBIsciID'];
                                        $turBinmeyen['TurBinmeyenAd'][$b] = $isciBinmeyenListelee['SBIsciAd'];
                                        $turBinmeyen['TurBinmeyenLocation'][$b] = $isciBinmeyenListelee['SBIsciLocation'];
                                        $b++;
                                    }
                                }
                            } else {//hem işçi hem öğrenci
                                $isciOgrenciTurListele = $Panel_Model->turIsciOgrenciIDListele($turID);
                                foreach ($isciOgrenciTurListele as $isciOgrenciTurListelee) {
                                    if ($isciOgrenciTurListelee['BSKullaniciTip'] != 1) {//öğrenci
                                        $turGelen[] = 'o' . $isciOgrenciTurListelee['BSOgrenciIsciID'];
                                    } else {//personel
                                        $turGelen[] = 'p' . $isciOgrenciTurListelee['BSOgrenciIsciID'];
                                    }
                                }
                                //o gün gelemeyen öğrenci
                                $isciOgrenciTurGunListele = $Panel_Model->turIsciOgrenciGunIDListele($turID, $yeniGun, $turGidisDonus);
                                foreach ($isciOgrenciTurGunListele as $isciOgrenciTurGunListelee) {
                                    if ($isciOgrenciTurGunListelee['BSKullaniciTip'] != 1) {//öğrenci
                                        $turGelmeyen[] = 'o' . $isciOgrenciTurGunListelee['BSKisiID'];
                                    } else {//personel
                                        $turGelmeyen[] = 'p' . $isciOgrenciTurGunListelee['BSKisiID'];
                                    }
                                }
                                if (count($turGelmeyen) > 0) {//o tura gelmeyen varsa
                                    $turagelenler = array_diff($turGelen, $turGelmeyen);
                                    //tura giderken binenler kimler
                                    $isciogrenciBinen = $Panel_Model->turIsciOgrenciBinenIDListele($turID);
                                    foreach ($isciogrenciBinen as $isciogrenciBinenn) {
                                        if ($isciogrenciBinenn['BSKisiTip'] != 1) {//öğrenci
                                            $turBinen[] = 'o' . $isciogrenciBinenn['BSKisiID'];
                                            $turBinenTip[] = 0;
                                        } else {//işçi
                                            $turBinen[] = 'p' . $isciogrenciBinenn['BSKisiID'];
                                            $turBinenTip[] = 1;
                                        }
                                    }
                                    $turaBinenTip = implode(',', $turBinenTip);
                                    //tur binmeyenler
                                    if (count($isciogrenciBinen) > 0) {
                                        $turbinmeyen = array_diff($turagelenler, $turBinen);
                                    } else {
                                        $turbinmeyen = $turagelenler;
                                    }

                                    //turbinenin baştaki işaretlemeleri kaldıracağız
                                    foreach ($turBinen as $turBinenn) {
                                        $turBinennn[] = ltrim($turBinenn, $turBinenn[0]);
                                    }
                                    $turaBinen = implode(',', $turBinennn);

                                    $isciOgrenciBinenListele = $Panel_Model->turGidisIsciOgrenciBinenListele($turID, $turaBinen, $turaBinenTip);
                                    if (count($isciOgrenciBinenListele) > 0) {
                                        $a = 0;
                                        foreach ($isciOgrenciBinenListele as $isciOgrenciBinenListelee) {
                                            if ($isciOgrenciBinenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                                $turBinenler['TurBinenTip'][$a] = 0;
                                            } else {//işçi
                                                $turBinenler['TurBinenTip'][$a] = 1;
                                            }
                                            $turBinenler['TurBinenID'][$a] = $isciOgrenciBinenListelee['BSOgrenciIsciID'];
                                            $turBinenler['TurBinenAd'][$a] = $isciOgrenciBinenListelee['BSOgrenciIsciAd'];
                                            $turBinenler['TurBinenLocation'][$a] = $isciOgrenciBinenListelee['BSOgrenciIsciLocation'];
                                            $a++;
                                        }
                                    }

                                    //tura binmeyenlerin tiplerinin ayrıştırma
                                    foreach ($turbinmeyen as $turbinmeyenn) {
                                        $turaBinemeyen[] = ltrim($turbinmeyenn, $turbinmeyenn[0]);
                                    }
                                    //tura binmeyenlerin tiplerinin ayrıştırma
                                    foreach ($turbinmeyen as $turbinmeyenIlk) {
                                        if ($turbinmeyenIlk[0] == 'o') {
                                            $turBinmeyenTip[] = 0;
                                        } else {
                                            $turBinmeyenTip[] = 1;
                                        }
                                    }
                                    $turaBinmeyen = implode(',', $turaBinemeyen);
                                    $turaBinmeyenTip = implode(',', $turBinmeyenTip);
                                    $isciOgrenciBinmeyenListele = $Panel_Model->turGidisOgrenciIsciBinmeyenListele($turID, $turaBinmeyen, $turaBinmeyenTip);
                                    $b = 0;
                                    foreach ($isciOgrenciBinmeyenListele as $isciOgrenciBinmeyenListelee) {
                                        if ($isciOgrenciBinmeyenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                            if (!in_array('o' . $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'], $turBinen)) {
                                                $turBinmeyen['TurBinmeyenTip'][$b] = 0;
                                                $turBinmeyen['TurBinmeyenID'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'];
                                                $turBinmeyen['TurBinmeyenAd'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciAd'];
                                                $turBinmeyen['TurBinmeyenLocation'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciLocation'];
                                                $b++;
                                            }
                                        } else {//işçi
                                            if (!in_array('p' . $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'], $turBinen)) {
                                                $turBinmeyen['TurBinmeyenTip'][$b] = 1;
                                                $turBinmeyen['TurBinmeyenID'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'];
                                                $turBinmeyen['TurBinmeyenAd'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciAd'];
                                                $turBinmeyen['TurBinmeyenLocation'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciLocation'];
                                                $b++;
                                            }
                                        }
                                    }
                                } else {//tura gelmeyen yoksa yani herkes geliyorsa
                                    //tura giderken binenler kimler
                                    $isciogrenciBinen = $Panel_Model->turIsciOgrenciBinenIDListele($turID);
                                    foreach ($isciogrenciBinen as $isciogrenciBinenn) {
                                        if ($isciogrenciBinenn['BSKisiTip'] != 1) {//öğrenci
                                            $turBinen[] = 'o' . $isciogrenciBinenn['BSKisiID'];
                                            $turBinenTip[] = 0;
                                        } else {//işçi
                                            $turBinen[] = 'p' . $isciogrenciBinenn['BSKisiID'];
                                            $turBinenTip[] = 1;
                                        }
                                    }
                                    $turaBinenTip = implode(',', $turBinenTip);
                                    //tur binmeyenler
                                    if (count($isciogrenciBinen) > 0) {
                                        $turbinmeyen = array_diff($turGelen, $turBinen);
                                    } else {
                                        $turbinmeyen = $turGelen;
                                    }
                                    //turbinenin baştaki işaretlemeleri kaldıracağız
                                    foreach ($turBinen as $turBinenn) {
                                        $turBinennn[] = ltrim($turBinenn, $turBinenn[0]);
                                    }
                                    $turaBinen = implode(',', $turBinennn);

                                    $isciOgrenciBinenListele = $Panel_Model->turGidisIsciOgrenciBinenListele($turID, $turaBinen, $turaBinenTip);
                                    if (count($isciOgrenciBinenListele) > 0) {
                                        $a = 0;
                                        foreach ($isciOgrenciBinenListele as $isciOgrenciBinenListelee) {
                                            if ($isciOgrenciBinenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                                $turBinenler['TurBinenTip'][$a] = 0;
                                            } else {//işçi
                                                $turBinenler['TurBinenTip'][$a] = 1;
                                            }
                                            $turBinenler['TurBinenID'][$a] = $isciOgrenciBinenListelee['BSOgrenciIsciID'];
                                            $turBinenler['TurBinenAd'][$a] = $isciOgrenciBinenListelee['BSOgrenciIsciAd'];
                                            $turBinenler['TurBinenLocation'][$a] = $isciOgrenciBinenListelee['BSOgrenciIsciLocation'];
                                            $a++;
                                        }
                                    }

                                    //tura binmeyenlerin tiplerinin ayrıştırma
                                    foreach ($turbinmeyen as $turbinmeyenn) {
                                        $turaBinemeyen[] = ltrim($turbinmeyenn, $turbinmeyenn[0]);
                                    }
                                    //tura binmeyenlerin tiplerinin ayrıştırma
                                    foreach ($turbinmeyen as $turbinmeyenIlk) {
                                        if ($turbinmeyenIlk[0] == 'o') {
                                            $turBinmeyenTip[] = 0;
                                        } else {
                                            $turBinmeyenTip[] = 1;
                                        }
                                    }
                                    $turaBinmeyen = implode(',', $turaBinemeyen);
                                    $turaBinmeyenTip = implode(',', $turBinmeyenTip);
                                    $isciOgrenciBinmeyenListele = $Panel_Model->turGidisOgrenciIsciBinmeyenListele($turID, $turaBinmeyen, $turaBinmeyenTip);
                                    $b = 0;
                                    foreach ($isciOgrenciBinmeyenListele as $isciOgrenciBinmeyenListelee) {
                                        if ($isciOgrenciBinmeyenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                            if (!in_array('o' . $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'], $turBinen)) {
                                                $turBinmeyen['TurBinmeyenTip'][$b] = 0;
                                                $turBinmeyen['TurBinmeyenID'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'];
                                                $turBinmeyen['TurBinmeyenAd'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciAd'];
                                                $turBinmeyen['TurBinmeyenLocation'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciLocation'];
                                                $b++;
                                            }
                                        } else {//işçi
                                            if (!in_array('p' . $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'], $turBinen)) {
                                                $turBinmeyen['TurBinmeyenTip'][$b] = 1;
                                                $turBinmeyen['TurBinmeyenID'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'];
                                                $turBinmeyen['TurBinmeyenAd'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciAd'];
                                                $turBinmeyen['TurBinmeyenLocation'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciLocation'];
                                                $b++;
                                            }
                                        }
                                    }
                                }
                            }
                        } else {//Dönüş
                            if ($turTip == 0) {//öğrenci turu
                                $ogrenciTurListele = $Panel_Model->turOgrenciIDListele($turID);
                                foreach ($ogrenciTurListele as $ogrenciTurListelee) {
                                    $turGelen[] = $ogrenciTurListelee['BSOgrenciID'];
                                }
                                //o gün gelemeyen öğrenci
                                $ogrenciTurGunListele = $Panel_Model->turOgrenciGunIDListele($turID, $yeniGun, $turGidisDonus);
                                foreach ($ogrenciTurGunListele as $ogrenciTurGunListelee) {
                                    $turGelmeyen[] = $ogrenciTurGunListelee['BSOgrenciID'];
                                }
                                if (count($turGelmeyen) > 0) {//o tura gelmeyen varsa
                                    $turagelenler = array_diff($turGelen, $turGelmeyen);
                                    //tura giderken binenler kimler
                                    $ogrenciInen = $Panel_Model->turOgrenciInenIDListele($turID);
                                    foreach ($ogrenciInen as $ogrenciInenn) {
                                        $turInen[] = $ogrenciInenn['BSKisiID'];
                                    }
                                    //tur inmeyenler
                                    if (count($ogrenciInen) > 0) {
                                        $turinmeyen = array_diff($turagelenler, $turInen);
                                    } else {
                                        $turinmeyen = $turagelenler;
                                    }
                                    $turaInenler = implode(',', $turInen);

                                    $ogrenciInenListele = $Panel_Model->turDonusOgrenciInenListele($turID, $turaInenler);
                                    if (count($ogrenciInenListele) > 0) {
                                        $a = 0;
                                        foreach ($ogrenciInenListele as $ogrenciInenListelee) {
                                            $turInenler['TurInenTip'][$a] = 0;
                                            $turInenler['TurInenID'][$a] = $ogrenciInenListelee['BSOgrenciID'];
                                            $turInenler['TurInenAd'][$a] = $ogrenciInenListelee['BSOgrenciAd'];
                                            $turInenler['TurInenLocation'][$a] = $ogrenciInenListelee['BSOgrenciLocation'];
                                            $a++;
                                        }
                                    }
                                    $turaInemeyen = implode(',', $turinmeyen);
                                    $ogrenciInmeyenListele = $Panel_Model->turDonusOgrenciInmeyenListele($turID, $turaInemeyen);
                                    $b = 0;
                                    foreach ($ogrenciInmeyenListele as $ogrenciInmeyenListelee) {
                                        $turInmeyen['TurInmeyenTip'][$b] = 0;
                                        $turInmeyen['TurInmeyenID'][$b] = $ogrenciInmeyenListelee['BSOgrenciID'];
                                        $turInmeyen['TurInmeyenAd'][$b] = $ogrenciInmeyenListelee['BSOgrenciAd'];
                                        $turInmeyen['TurInmeyenLocation'][$b] = $ogrenciInmeyenListelee['BSOgrenciLocation'];
                                        $b++;
                                    }
                                } else {//tura gelmeyen yoksa yani herkes geliyorsa
                                    //tura giderken inenler kimler
                                    $ogrenciInen = $Panel_Model->turOgrenciInenIDListele($turID);
                                    foreach ($ogrenciInen as $ogrenciInenn) {
                                        $turInen[] = $ogrenciInenn['BSKisiID'];
                                    }
                                    //tur inmeyenler
                                    if (count($ogrenciInen) > 0) {
                                        $turinmeyen = array_diff($turGelen, $turInen);
                                    } else {
                                        $turinmeyen = $turGelen;
                                    }
                                    $turaInenler = implode(',', $turInen);

                                    $ogrenciInenListele = $Panel_Model->turDonusOgrenciInenListele($turID, $turaInenler);
                                    if (count($ogrenciInenListele) > 0) {
                                        $a = 0;
                                        foreach ($ogrenciInenListele as $ogrenciInenListelee) {
                                            $turInenler['TurInenTip'][$a] = 0;
                                            $turInenler['TurInenID'][$a] = $ogrenciInenListelee['BSOgrenciID'];
                                            $turInenler['TurInenAd'][$a] = $ogrenciInenListelee['BSOgrenciAd'];
                                            $turInenler['TurInenLocation'][$a] = $ogrenciInenListelee['BSOgrenciLocation'];
                                            $a++;
                                        }
                                    }
                                    $turaInemeyen = implode(',', $turinmeyen);
                                    $ogrenciInmeyenListele = $Panel_Model->turDonusOgrenciInmeyenListele($turID, $turaInemeyen);
                                    $b = 0;
                                    foreach ($ogrenciInmeyenListele as $ogrenciInmeyenListelee) {
                                        $turInmeyen['TurInmeyenTip'][$b] = 0;
                                        $turInmeyen['TurInmeyenID'][$b] = $ogrenciInmeyenListelee['BSOgrenciID'];
                                        $turInmeyen['TurInmeyenAd'][$b] = $ogrenciInmeyenListelee['BSOgrenciAd'];
                                        $turInmeyen['TurInmeyenLocation'][$b] = $ogrenciInmeyenListelee['BSOgrenciLocation'];
                                        $b++;
                                    }
                                }
                            } else if ($turTip == 1) {//işçi turu
                                $isciTurListele = $Panel_Model->turIsciIDListele($turID);
                                foreach ($isciTurListele as $isciTurListelee) {
                                    $turGelen[] = $isciTurListelee['SBIsciID'];
                                }
                                //o gün gelemeyen öğrenci
                                $isciTurGunListele = $Panel_Model->turIsciGunIDListele($turID, $yeniGun, $turGidisDonus);
                                foreach ($isciTurGunListele as $isciTurGunListelee) {
                                    $turGelmeyen[] = $isciTurGunListelee['BSIsciID'];
                                }
                                if (count($turGelmeyen) > 0) {//o tura gelmeyen varsa
                                    $turagelenler = array_diff($turGelen, $turGelmeyen);
                                    //tura giderken inenler kimler
                                    $isciInen = $Panel_Model->turIsciDonenIDListele($turID);
                                    foreach ($isciInen as $isciInenn) {
                                        $turInen[] = $isciInenn['BSKisiID'];
                                    }
                                    //tur inmeyenler
                                    if (count($isciInen) > 0) {
                                        $turinmeyen = array_diff($turagelenler, $turInen);
                                    } else {
                                        $turinmeyen = $turagelenler;
                                    }
                                    $turaInenler = implode(',', $turInen);
                                    $isciInenListele = $Panel_Model->turDonusIsciInenListele($turID, $turaInenler);
                                    if (count($isciInenListele) > 0) {
                                        $a = 0;
                                        foreach ($isciInenListele as $isciInenListelee) {
                                            $turInenler['TurInenTip'][$a] = 1;
                                            $turInenler['TurInenID'][$a] = $isciInenListelee['SBIsciID'];
                                            $turInenler['TurInenAd'][$a] = $isciInenListelee['SBIsciAd'];
                                            $turInenler['TurInenLocation'][$a] = $isciInenListelee['SBIsciLocation'];
                                            $a++;
                                        }
                                    }
                                    $turaInemeyen = implode(',', $turinmeyen);
                                    $isciInmeyenListele = $Panel_Model->turDonusIsciInmeyenListele($turID, $turaInemeyen);
                                    $b = 0;
                                    foreach ($isciInmeyenListele as $isciInmeyenListelee) {
                                        $turInmeyen['TurInmeyenTip'][$b] = 1;
                                        $turInmeyen['TurInmeyenID'][$b] = $isciInmeyenListelee['SBIsciID'];
                                        $turInmeyen['TurInmeyenAd'][$b] = $isciInmeyenListelee['SBIsciAd'];
                                        $turInmeyen['TurInmeyenLocation'][$b] = $isciInmeyenListelee['SBIsciLocation'];
                                        $b++;
                                    }
                                } else {//tura gelmeyen yoksa yani herkes geliyorsa
                                    //tura giderken inenler kimler
                                    $isciInen = $Panel_Model->turIsciDonenIDListele($turID);
                                    foreach ($isciInen as $isciInenn) {
                                        $turInen[] = $isciInenn['BSKisiID'];
                                    }
                                    //tur inmeyenler
                                    if (count($isciInen) > 0) {
                                        $turinmeyen = array_diff($turGelen, $turInen);
                                    } else {
                                        $turinmeyen = $turGelen;
                                    }
                                    $turaInenler = implode(',', $turInen);
                                    $isciInenListele = $Panel_Model->turDonusIsciInenListele($turID, $turaInenler);
                                    if (count($isciInenListele) > 0) {
                                        $a = 0;
                                        foreach ($isciInenListele as $isciInenListelee) {
                                            $turInenler['TurInenTip'][$a] = 1;
                                            $turInenler['TurInenID'][$a] = $isciInenListelee['SBIsciID'];
                                            $turInenler['TurInenAd'][$a] = $isciInenListelee['SBIsciAd'];
                                            $turInenler['TurInenLocation'][$a] = $isciInenListelee['SBIsciLocation'];
                                            $a++;
                                        }
                                    }
                                    $turaInemeyen = implode(',', $turinmeyen);
                                    $isciInmeyenListele = $Panel_Model->turDonusIsciInmeyenListele($turID, $turaInemeyen);
                                    $b = 0;
                                    foreach ($isciInmeyenListele as $isciInmeyenListelee) {
                                        $turInmeyen['TurInmeyenTip'][$b] = 1;
                                        $turInmeyen['TurInmeyenID'][$b] = $isciInmeyenListelee['SBIsciID'];
                                        $turInmeyen['TurInmeyenAd'][$b] = $isciInmeyenListelee['SBIsciAd'];
                                        $turInmeyen['TurInmeyenLocation'][$b] = $isciInmeyenListelee['SBIsciLocation'];
                                        $b++;
                                    }
                                }
                            } else {//hem işçi hem öğrenci
                                $isciOgrenciTurListele = $Panel_Model->turIsciOgrenciIDListele($turID);
                                foreach ($isciOgrenciTurListele as $isciOgrenciTurListelee) {
                                    if ($isciOgrenciTurListelee['BSKullaniciTip'] != 1) {//öğrenci
                                        $turGelen[] = 'o' . $isciOgrenciTurListelee['BSOgrenciIsciID'];
                                    } else {//personel
                                        $turGelen[] = 'p' . $isciOgrenciTurListelee['BSOgrenciIsciID'];
                                    }
                                }
                                //o gün gelemeyen öğrenci
                                $isciOgrenciTurGunListele = $Panel_Model->turIsciOgrenciGunIDListele($turID, $yeniGun, $turGidisDonus);
                                foreach ($isciOgrenciTurGunListele as $isciOgrenciTurGunListelee) {
                                    if ($isciOgrenciTurGunListelee['BSKullaniciTip'] != 1) {//öğrenci
                                        $turGelmeyen[] = 'o' . $isciOgrenciTurGunListelee['BSKisiID'];
                                    } else {//personel
                                        $turGelmeyen[] = 'p' . $isciOgrenciTurGunListelee['BSKisiID'];
                                    }
                                }
                                if (count($turGelmeyen) > 0) {//o tura gelmeyen varsa
                                    $turagelenler = array_diff($turGelen, $turGelmeyen);
                                    //tura giderken binenler kimler
                                    $isciogrenciInen = $Panel_Model->turIsciOgrenciInenIDListele($turID);
                                    foreach ($isciogrenciInen as $isciogrenciInenn) {
                                        if ($isciogrenciInenn['BSKisiTip'] != 1) {//öğrenci
                                            $turInen[] = 'o' . $isciogrenciInenn['BSKisiID'];
                                            $turInenTip[] = 0;
                                        } else {//işçi
                                            $turInen[] = 'p' . $isciogrenciInenn['BSKisiID'];
                                            $turInenTip[] = 1;
                                        }
                                    }
                                    $turaInenTip = implode(',', $turInenTip);
                                    //tur inmeyenler
                                    if (count($isciogrenciInen) > 0) {
                                        $turinmeyen = array_diff($turagelenler, $turInen);
                                    } else {
                                        $turinmeyen = $turagelenler;
                                    }
                                    //turbinenin baştaki işaretlemeleri kaldıracağız
                                    foreach ($turInen as $turInenn) {
                                        $turInennn[] = ltrim($turInenn, $turInenn[0]);
                                    }
                                    $turaInen = implode(',', $turInennn);

                                    $isciOgrenciInenListele = $Panel_Model->turDonusIsciOgrenciInenListele($turID, $turaInen, $turaInenTip);
                                    if (count($isciOgrenciInenListele) > 0) {
                                        $a = 0;
                                        foreach ($isciOgrenciInenListele as $isciOgrenciInenListelee) {
                                            if ($isciOgrenciInenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                                $turInenler['TurInenTip'][$a] = 0;
                                            } else {//işçi
                                                $turInenler['TurInenTip'][$a] = 1;
                                            }
                                            $turInenler['TurInenID'][$a] = $isciOgrenciInenListelee['BSOgrenciIsciID'];
                                            $turInenler['TurInenAd'][$a] = $isciOgrenciInenListelee['BSOgrenciIsciAd'];
                                            $turInenler['TurInenLocation'][$a] = $isciOgrenciInenListelee['BSOgrenciIsciLocation'];
                                            $a++;
                                        }
                                    }

                                    //tura inmeyenlerin tiplerinin ayrıştırma
                                    foreach ($turinmeyen as $turinmeyenn) {
                                        $turaInemeyen[] = ltrim($turinmeyenn, $turinmeyenn[0]);
                                    }
                                    //tura inmeyenlerin tiplerinin ayrıştırma
                                    foreach ($turinmeyen as $turinmeyenIlk) {
                                        if ($turinmeyenIlk[0] == 'o') {
                                            $turInmeyenTip[] = 0;
                                        } else {
                                            $turInmeyenTip[] = 1;
                                        }
                                    }
                                    $turaInmeyen = implode(',', $turaInemeyen);
                                    $turaInmeyenTip = implode(',', $turInmeyenTip);
                                    $isciOgrenciInmeyenListele = $Panel_Model->turDonusOgrenciIsciInmeyenListele($turID, $turaInmeyen, $turaInmeyenTip);
                                    $b = 0;
                                    foreach ($isciOgrenciInmeyenListele as $isciOgrenciInmeyenListelee) {
                                        if ($isciOgrenciInmeyenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                            if (!in_array('o' . $isciOgrenciInmeyenListelee['BSOgrenciIsciID'], $turInen)) {
                                                $turInmeyen['TurInmeyenTip'][$b] = 0;
                                                $turInmeyen['TurInmeyenID'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciID'];
                                                $turInmeyen['TurInmeyenAd'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciAd'];
                                                $turInmeyen['TurInmeyenLocation'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciLocation'];
                                                $b++;
                                            }
                                        } else {//işçi
                                            if (!in_array('p' . $isciOgrenciInmeyenListelee['BSOgrenciIsciID'], $turInen)) {
                                                $turInmeyen['TurInmeyenTip'][$b] = 1;
                                                $turInmeyen['TurInmeyenID'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciID'];
                                                $turInmeyen['TurInmeyenAd'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciAd'];
                                                $turInmeyen['TurInmeyenLocation'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciLocation'];
                                                $b++;
                                            }
                                        }
                                    }
                                } else {//tura gelmeyen yoksa yani herkes geliyorsa
                                    //tura gelirken inenler kimler
                                    $isciogrenciInen = $Panel_Model->turIsciOgrenciInenIDListele($turID);
                                    foreach ($isciogrenciInen as $isciogrenciInenn) {
                                        if ($isciogrenciInenn['BSKisiTip'] != 1) {//öğrenci
                                            $turInen[] = 'o' . $isciogrenciInenn['BSKisiID'];
                                            $turInenTip[] = 0;
                                        } else {//işçi
                                            $turInen[] = 'p' . $isciogrenciInenn['BSKisiID'];
                                            $turInenTip[] = 1;
                                        }
                                    }
                                    $turaInenTip = implode(',', $turInenTip);
                                    //tur inmeyenler
                                    if (count($isciogrenciInen) > 0) {
                                        $turinmeyen = array_diff($turGelen, $turInen);
                                    } else {
                                        $turinmeyen = $turGelen;
                                    }
                                    //turbinenin baştaki işaretlemeleri kaldıracağız
                                    foreach ($turInen as $turInenn) {
                                        $turInennn[] = ltrim($turInenn, $turInenn[0]);
                                    }
                                    $turaInen = implode(',', $turInennn);

                                    $isciOgrenciInenListele = $Panel_Model->turDonusIsciOgrenciInenListele($turID, $turaInen, $turaInenTip);
                                    if (count($isciOgrenciInenListele) > 0) {
                                        $a = 0;
                                        foreach ($isciOgrenciInenListele as $isciOgrenciInenListelee) {
                                            if ($isciOgrenciInenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                                $turInenler['TurInenTip'][$a] = 0;
                                            } else {//işçi
                                                $turInenler['TurInenTip'][$a] = 1;
                                            }
                                            $turInenler['TurInenID'][$a] = $isciOgrenciInenListelee['BSOgrenciIsciID'];
                                            $turInenler['TurInenAd'][$a] = $isciOgrenciInenListelee['BSOgrenciIsciAd'];
                                            $turInenler['TurInenLocation'][$a] = $isciOgrenciInenListelee['BSOgrenciIsciLocation'];
                                            $a++;
                                        }
                                    }

                                    //tura inmeyenlerin tiplerinin ayrıştırma
                                    foreach ($turinmeyen as $turinmeyenn) {
                                        $turaInemeyen[] = ltrim($turinmeyenn, $turinmeyenn[0]);
                                    }
                                    //tura inmeyenlerin tiplerinin ayrıştırma
                                    foreach ($turinmeyen as $turinmeyenIlk) {
                                        if ($turinmeyenIlk[0] == 'o') {
                                            $turInmeyenTip[] = 0;
                                        } else {
                                            $turInmeyenTip[] = 1;
                                        }
                                    }
                                    $turaInmeyen = implode(',', $turaInemeyen);
                                    $turaInmeyenTip = implode(',', $turInmeyenTip);
                                    $isciOgrenciInmeyenListele = $Panel_Model->turDonusOgrenciIsciInmeyenListele($turID, $turaInmeyen, $turaInmeyenTip);
                                    $b = 0;
                                    foreach ($isciOgrenciInmeyenListele as $isciOgrenciInmeyenListelee) {
                                        if ($isciOgrenciInmeyenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                            if (!in_array('o' . $isciOgrenciInmeyenListelee['BSOgrenciIsciID'], $turInen)) {
                                                $turInmeyen['TurInmeyenTip'][$b] = 0;
                                                $turInmeyen['TurInmeyenID'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciID'];
                                                $turInmeyen['TurInmeyenAd'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciAd'];
                                                $turInmeyen['TurInmeyenLocation'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciLocation'];
                                                $b++;
                                            }
                                        } else {//işçi
                                            if (!in_array('p' . $isciOgrenciInmeyenListelee['BSOgrenciIsciID'], $turInen)) {
                                                $turInmeyen['TurInmeyenTip'][$b] = 1;
                                                $turInmeyen['TurInmeyenID'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciID'];
                                                $turInmeyen['TurInmeyenAd'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciAd'];
                                                $turInmeyen['TurInmeyenLocation'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciLocation'];
                                                $b++;
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        $sonuc["turBinen"] = $turBinenler;
                        $sonuc["turBinemeyen"] = $turBinmeyen;
                        $sonuc["turInen"] = $turInenler;
                        $sonuc["turInemeyen"] = $turInmeyen;
                        $sonuc["aracLokasyon"] = $aracLokasyon[0]["BSAracLokasyon"];
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

