<?php

class AdminAdminAjaxSorgu extends Controller {

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

                case "adminEkleSelect":
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
                        }

                        $sonuc["adminBolge"] = $adminBolge;
                    }
                    break;

                    break;
                case "adminKaydet":
                    $adminRutbe = Session::get("userRutbe");

                    if ($adminRutbe != 1) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $userTip = 1;

                        $firmaID = Session::get("FirmaId");

                        $userKadi = $form->kadiOlustur($firmaID);
                        if ($userKadi) {
                            $realSifre = $form->sifreOlustur();
                            if ($realSifre) {
                                $adminSifre = $form->userSifreOlustur($userKadi, $realSifre, $userTip);
                                if ($adminSifre) {

                                    $form->post('adminAd', true);
                                    $form->post('adminSoyad', true);
                                    $form->post('adminEmail', true);
                                    $form->post('adminDurum', true);
                                    $form->post('adminLokasyon', true);
                                    $form->post('adminTelefon', true);
                                    $form->post('adminAdres', true);
                                    $form->post('aciklama', true);
                                    $form->post('ulke', true);
                                    $form->post('il', true);
                                    $form->post('ilce', true);
                                    $form->post('semt', true);
                                    $form->post('mahalle', true);
                                    $form->post('sokak', true);
                                    $form->post('postakodu', true);
                                    $form->post('caddeno', true);
                                    $form->post('detayAdres', true);
                                    $adminEmail = $form->values['adminEmail'];
                                    $adminAd = $form->values['adminAd'];
                                    $adminSoyad = $form->values['adminSoyad'];
                                    $adminAdSoyad = $adminAd . ' ' . $adminSoyad;

                                    $adminBolgeID = $_REQUEST['adminBolgeID'];
                                    if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL) === false) {
                                        $emailValidate = $form->mailControl1($adminEmail);
                                        if ($emailValidate == 1) {
                                            $kullaniciliste = $Panel_Model->adminEmailDbKontrol($adminEmail);
                                            if (count($kullaniciliste) <= 0) {
                                                if ($form->submit()) {
                                                    $data = array(
                                                        'BSAdminAd' => $adminAd,
                                                        'BSAdminSoyad' => $adminSoyad,
                                                        'BSAdminKadi' => $userKadi,
                                                        'BSAdminSifre' => $adminSifre,
                                                        'BSAdminRSifre' => $realSifre,
                                                        'BSAdminPhone' => $form->values['adminTelefon'],
                                                        'BSAdminEmail' => $adminEmail,
                                                        'BSAdminLocation' => $form->values['adminLokasyon'],
                                                        'BSAdminUlke' => $form->values['ulke'],
                                                        'BSAdminIl' => $form->values['il'],
                                                        'BSAdminIlce' => $form->values['ilce'],
                                                        'BSAdminSemt' => $form->values['semt'],
                                                        'BSAdminMahalle' => $form->values['mahalle'],
                                                        'BSAdminSokak' => $form->values['sokak'],
                                                        'BSAdminPostaKodu' => $form->values['postakodu'],
                                                        'BSAdminCaddeNo' => $form->values['caddeno'],
                                                        'BSAdminAdres' => $form->values['adminAdres'],
                                                        'BSAdminDetayAdres' => $form->values['detayAdres'],
                                                        'Status' => $form->values['adminDurum'],
                                                        'BSAdminAciklama' => $form->values['aciklama']
                                                    );
                                                }
                                                $resultAdminID = $Panel_Model->addNewAdmin($data);

                                                if ($resultAdminID != 'unique') {
                                                    $bolgeID = count($adminBolgeID);
                                                    if ($bolgeID > 0) {
                                                        for ($b = 0; $b < $bolgeID; $b++) {
                                                            $bolgedata[$b] = array(
                                                                'BSAdminID' => $resultAdminID,
                                                                'BSBolgeID' => $adminBolgeID[$b]
                                                            );
                                                        }
                                                        $resultBolgeID = $Panel_Model->addNewBolgeAdmin($bolgedata);
                                                        if ($resultBolgeID) {
                                                            //kullanıcıya gerekli giriş mail yazısı
                                                            $setTitle = $languagedeger['UyelikBilgi'];
                                                            $subject = $languagedeger['SHtrltMail'];
                                                            $body = $languagedeger['Merhaba'] . ' ' . $adminAdSoyad . '!<br/>' . $languagedeger['KullaniciAdi'] . ' = ' . $userKadi . '<br/>'
                                                                    . $languagedeger['KullaniciSifre'] . ' = ' . $realSifre . '<br/>'
                                                                    . $languagedeger['IyiGunler'];
                                                            //kullanıcıya gerekli giriş bilgileri gönderiliyor.
                                                            $resultMail = $form->sifreHatirlatMail($adminEmail, $setTitle, $adminAdSoyad, $subject, $body);
                                                            $sonuc["newAdminID"] = $resultAdminID;
                                                            $sonuc["insert"] = $languagedeger['AdminEkle'];
                                                        } else {
                                                            //admin kaydedilirken hata geldi ise
                                                            $deleteresult = $Panel_Model->adminDelete($resultAdminID);

                                                            $deleteresultt = $Panel_Model->adminMultiBolgeDelete($resultAdminID);
                                                            if ($deleteresultt) {
                                                                $sonuc["hata"] = $languagedeger['Hata'];
                                                            }
                                                        }
                                                    } else {
                                                        $sonuc["newAdminID"] = $resultAdminID;
                                                        $sonuc["hata"] = $languagedeger['BolgeSec'];
                                                    }
                                                } else {
                                                    $sonuc["hata"] = $languagedeger['GecersizKullanici'];
                                                }
                                            } else {
                                                $sonuc["hata"] = $languagedeger['KullanilmisEmail'];
                                            }
                                        } else {
                                            $sonuc["hata"] = $languagedeger['BaskaEmail'];
                                        }
                                    } else {
                                        $sonuc["hata"] = $languagedeger['GecerliEmail'];
                                    }
                                } else {
                                    $sonuc["hata"] = $languagedeger['Hata'];
                                }
                            } else {
                                $sonuc["hata"] = $languagedeger['Hata'];
                            }
                        } else {
                            $sonuc["hata"] = $languagedeger['Hata'];
                        }
                    }
                case "adminDetail":

                    $adminRutbe = Session::get("userRutbe");

                    if ($adminRutbe != 1) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //superadminse
                        if ($adminRutbe != 0) {
                            $form->post('adminRowid', true);
                            $adminDetailID = $form->values['adminRowid'];

                            $adminListe = $Panel_Model->adminIDListele($adminDetailID);

                            $a = 0;
                            foreach ($adminListe as $adminListee) {
                                $adminList[$a]['AdminListID'] = $adminListee['BSAdminID'];
                                $adminList[$a]['AdminListAd'] = $adminListee['BSAdminAd'];
                                $adminList[$a]['AdminListSoyad'] = $adminListee['BSAdminSoyad'];
                                $adminList[$a]['AdminListTelefon'] = $adminListee['BSAdminPhone'];
                                $adminList[$a]['AdminListMail'] = $adminListee['BSAdminEmail'];
                                $adminList[$a]['AdminListLokasyon'] = $adminListee['BSAdminLocation'];
                                $adminList[$a]['AdminListUlke'] = $adminListee['BSAdminUlke'];
                                $adminList[$a]['AdminListIl'] = $adminListee['BSAdminIl'];
                                $adminList[$a]['AdminListIlce'] = $adminListee['BSAdminIlce'];
                                $adminList[$a]['AdminListSemt'] = $adminListee['BSAdminSemt'];
                                $adminList[$a]['AdminListMahalle'] = $adminListee['BSAdminMahalle'];
                                $adminList[$a]['AdminListSokak'] = $adminListee['BSAdminSokak'];
                                $adminList[$a]['AdminListPostaKodu'] = $adminListee['BSAdminPostaKodu'];
                                $adminList[$a]['AdminListCaddeNo'] = $adminListee['BSAdminCaddeNo'];
                                $adminList[$a]['AdminListAdres'] = $adminListee['BSAdminAdres'];
                                $adminList[$a]['AdminListDetayAdres'] = $adminListee['BSAdminDetayAdres'];
                                $adminList[$a]['AdminListDurum'] = $adminListee['Status'];
                                $adminList[$a]['AdminListAciklama'] = $adminListee['BSAdminAciklama'];
                                $a++;
                            }

                            //admine ait bölgeler
                            $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminDetailID);

                            foreach ($bolgeListeRutbe as $rutbe) {
                                $bolgerutbeId[] = $rutbe['BSBolgeID'];
                            }

                            $adminBolgeCount = count($bolgerutbeId);
                            if ($adminBolgeCount > 0) {
                                $rutbebolgedizi = implode(',', $bolgerutbeId);

                                //admine ai bölgeler
                                $bolgeListe = $Panel_Model->rutbeBolgeListele($rutbebolgedizi);
                                //bölge count için
                                if (count($bolgeListe) != 0) {
                                    $adminBolge[0]['AdminBolgeCount'] = count($bolgeListe);
                                }

                                $b = 0;
                                foreach ($bolgeListe as $bolge) {
                                    $adminBolge[$b]['AdminBolge'] = $bolge['SBBolgeAdi'];
                                    $adminBolge[$b]['AdminBolgeID'] = $bolge['SBBolgeID'];
                                    $b++;
                                }

                                //admine ait olmayan bölgeler
                                $bolgeNotListe = $Panel_Model->rutbeNotBolgeListele($rutbebolgedizi);
                                //bölge count için
                                if (count($bolgeNotListe) != 0) {
                                    $adminBolge[0]['AdminNotBolgeCount'] = count($bolgeNotListe);
                                }

                                $c = 0;
                                foreach ($bolgeNotListe as $bolgeNotListee) {
                                    $adminNoBolge[$c]['AdminBolge'] = $bolgeNotListee['SBBolgeAdi'];
                                    $adminNoBolge[$c]['AdminBolgeID'] = $bolgeNotListee['SBBolgeID'];
                                    $c++;
                                }
                            } else {
                                //admine ait olmayan bölgeler
                                $bolgeNotListe = $Panel_Model->adminBolge();
                                //bölge count için
                                if (count($bolgeNotListe) != 0) {
                                    $adminNoBolge[0]['AdminNotBolgeCount'] = count($bolgeNotListe);
                                }

                                $c = 0;
                                foreach ($bolgeNotListe as $bolgeNotListee) {
                                    $adminNoBolge[$c]['AdminBolge'] = $bolgeNotListee['SBBolgeAdi'];
                                    $adminNoBolge[$c]['AdminBolgeID'] = $bolgeNotListee['SBBolgeID'];
                                    $c++;
                                }
                            }
                        }
                        //sonuçlar
                        $sonuc["adminDetail"] = $adminList;
                        $sonuc["adminBolge"] = $adminBolge;
                        $sonuc["adminNoBolge"] = $adminNoBolge;
                    }

                    break;
                case "adminDetailDelete":
                    $adminRutbe = Session::get("userRutbe");
                    if ($adminRutbe != 1) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('admindetail_id', true);
                        $adminDetailID = $form->values['admindetail_id'];

                        $deleteresult = $Panel_Model->adminDetailDelete($adminDetailID);
                        if ($deleteresult) {
                            $deleteresulttt = $Panel_Model->adminDetailBolgeDelete($adminDetailID);
                            if ($deleteresulttt) {
                                $sonuc["delete"] = $languagedeger['AdminSil'];
                            }
                        } else {
                            $sonuc["hata"] = $languagedeger['Hata'];
                        }
                    }

                    $sonuc["adminDetail"] = $data["adminDetail"];

                    break;
                case "adminDetailKaydet":

                    $adminRutbe = Session::get("userRutbe");
                    if ($adminRutbe != 1) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('admindetail_id', true);
                        $adminID = $form->values['admindetail_id'];

                        $form->post('adminAd', true);
                        $form->post('adminSoyad', true);
                        $form->post('adminEmail', true);
                        $form->post('adminDurum', true);
                        $form->post('adminLokasyon', true);
                        $form->post('adminTelefon', true);
                        $form->post('adminAdres', true);
                        $form->post('aciklama', true);
                        $form->post('ulke', true);
                        $form->post('il', true);
                        $form->post('ilce', true);
                        $form->post('semt', true);
                        $form->post('mahalle', true);
                        $form->post('sokak', true);
                        $form->post('postakodu', true);
                        $form->post('caddeno', true);
                        $form->post('detayAdres', true);
                        $adminEmail = $form->values['adminEmail'];

                        $adminBolgeAd = $_REQUEST['adminBolgeAd'];
                        $adminBolgeID = $_REQUEST['adminBolgeID'];

                        if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL) === false) {
                            $emailValidate = $form->mailControl1($adminEmail);
                            if ($emailValidate == 1) {
                                $kullaniciliste = $Panel_Model->adminEmailDbKontrol($adminEmail);
                                if (count($kullaniciliste) <= 0) {
                                    if ($form->submit()) {
                                        $data = array(
                                            'BSAdminAd' => $form->values['adminAd'],
                                            'BSAdminSoyad' => $form->values['adminSoyad'],
                                            'BSAdminPhone' => $form->values['adminTelefon'],
                                            'BSAdminEmail' => $adminEmail,
                                            'BSAdminLocation' => $form->values['adminLokasyon'],
                                            'BSAdminUlke' => $form->values['ulke'],
                                            'BSAdminIl' => $form->values['il'],
                                            'BSAdminIlce' => $form->values['ilce'],
                                            'BSAdminSemt' => $form->values['semt'],
                                            'BSAdminMahalle' => $form->values['mahalle'],
                                            'BSAdminSokak' => $form->values['sokak'],
                                            'BSAdminPostaKodu' => $form->values['postakodu'],
                                            'BSAdminCaddeNo' => $form->values['caddeno'],
                                            'BSAdminAdres' => $form->values['adminAdres'],
                                            'BSAdminDetayAdres' => $form->values['detayAdres'],
                                            'Status' => $form->values['adminDurum'],
                                            'BSAdminAciklama' => $form->values['aciklama']
                                        );
                                    }
                                    $resultAdminUpdate = $Panel_Model->adminOzelliklerDuzenle($data, $adminID);
                                    if ($resultAdminUpdate) {
                                        $deleteresulttt = $Panel_Model->adminMultiBolgeDelete($adminID);
                                        if ($deleteresulttt) {
                                            $bolgeID = count($adminBolgeID);
                                            for ($b = 0; $b < $bolgeID; $b++) {
                                                $bolgedata[$b] = array(
                                                    'BSAdminID' => $adminID,
                                                    'BSBolgeID' => $adminBolgeID[$b]
                                                );
                                            }
                                            $resultBolgeID = $Panel_Model->addNewBolgeAdmin($bolgedata);
                                            if ($resultBolgeID) {
                                                $sonuc["newAdminID"] = $adminID;
                                                $sonuc["update"] = $languagedeger['AdminDuzen'];
                                            } else {
                                                $sonuc["hata"] = $languagedeger['Hata'];
                                            }
                                        }
                                    } else {
                                        $sonuc["hata"] = $languagedeger['Hata'];
                                    }
                                } else {
                                    $sonuc["hata"] = $languagedeger['KullanilmisEmail'];
                                }
                            } else {
                                $sonuc["hata"] = $languagedeger['BaskaEmail'];
                            }
                        } else {
                            $sonuc["hata"] = $languagedeger['GecerliEmail'];
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

