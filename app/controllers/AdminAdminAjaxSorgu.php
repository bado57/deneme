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
            $Panel_Model = $this->load->model("panel_model");
            //form class bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");

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
                            if ($realSifre) {//$loginKadi, $loginSifre, $loginTip
                                $adminSifre = $form->userSifreOlustur($userKadi, $realSifre, $userTip);
                                if ($adminSifre) {

                                    $uniqueKey = Session::get("username");
                                    $uniqueKey = $uniqueKey . '_AAdmin';

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

                                    $adminBolgeID = $_REQUEST['adminBolgeID'];

                                    if ($form->submit()) {
                                        $data = array(
                                            'BSAdminAd' => $form->values['adminAd'],
                                            'BSAdminSoyad' => $form->values['adminSoyad'],
                                            'BSAdminKadi' => $userKadi,
                                            'BSAdminSifre' => $adminSifre,
                                            'BSAdminRSifre' => $realSifre,
                                            'BSAdminPhone' => $form->values['adminTelefon'],
                                            'BSAdminEmail' => $form->values['adminEmail'],
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
                                                $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . Session::get("userId");
                                                $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                                $resultMemcache = $MemcacheModel->get($uniqueKey);
                                                if ($resultMemcache) {
                                                    $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                                }

                                                $sonuc["newAdminID"] = $resultAdminID;
                                                $sonuc["insert"] = "Başarıyla Admin Eklenmiştir.";
                                            } else {
                                                //admin kaydedilirken hata geldi ise
                                                $deleteresult = $Panel_Model->adminDelete($resultAdminID);

                                                $deleteresultt = $Panel_Model->adminMultiBolgeDelete($resultAdminID);
                                                if ($deleteresultt) {
                                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                                }
                                            }
                                        } else {
                                            $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . Session::get("userId");
                                            $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                                            if ($resultMemcache) {
                                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                            }

                                            $sonuc["newAdminID"] = $resultAdminID;
                                            $sonuc["insert"] = "Başarıyla Admin Eklenmiştir.";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Lütfen Yeni Bir Kullanıcı Adı yada Şifre Giriniz.";
                                    }
                                } else {
                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                }
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
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
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AAdmin';


                        $form->post('admindetail_id', true);
                        $adminDetailID = $form->values['admindetail_id'];

                        $deleteresult = $Panel_Model->adminDetailDelete($adminDetailID);
                        if ($deleteresult) {
                            $deleteresulttt = $Panel_Model->adminDetailBolgeDelete($adminDetailID);
                            if ($deleteresulttt) {
                                $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . Session::get("userId");
                                $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                $resultMemcache = $MemcacheModel->get($uniqueKey);
                                if ($resultMemcache) {
                                    $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                }
                                $sonuc["delete"] = "Admin kaydı başarıyla silinmiştir.";
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    $sonuc["adminDetail"] = $data["adminDetail"];

                    break;

                case "adminDetailKaydet":

                    $adminRutbe = Session::get("userRutbe");
                    if ($adminRutbe != 1) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AAdmin';

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

                        $adminBolgeAd = $_REQUEST['adminBolgeAd'];
                        $adminBolgeID = $_REQUEST['adminBolgeID'];

                        if ($form->submit()) {
                            $data = array(
                                'BSAdminAd' => $form->values['adminAd'],
                                'BSAdminSoyad' => $form->values['adminSoyad'],
                                'BSAdminPhone' => $form->values['adminTelefon'],
                                'BSAdminEmail' => $form->values['adminEmail'],
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
                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                    if ($resultMemcache) {
                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                    }

                                    $sonuc["newAdminID"] = $adminID;
                                    $sonuc["update"] = "Başarıyla Admin Düzenlenmiştir.";
                                } else {
                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                }
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
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
