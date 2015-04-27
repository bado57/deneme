<?php

class AdminKurumAjaxSorgu extends Controller {

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

                case "adminKurumDetail":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {

                        $form->post('adminkurumRowid', true);
                        $adminKurumDetailID = $form->values['adminkurumRowid'];

                        $data["adminKurumDetail"] = $Panel_Model->adminKurumDetail($adminKurumDetailID);

                        $returnModelData = $data["adminKurumDetail"][0];

                        $a = 0;
                        foreach ($returnModelData as $key => $value) {
                            $new_array['AdminKurumsshkey'][$a] = md5(sha1(md5($key)));
                            $a++;
                        }

                        $returnFormdata['adminKurumDetail'] = $form->newKeys($data["adminKurumDetail"][0], $new_array['AdminKurumsshkey']);


                        $adminKurumTurDetail = $Panel_Model->adminKurumTurDetail($adminKurumDetailID);

                        //arac detail tur
                        $b = 0;
                        foreach ($adminKurumTurDetail as $adminKurumTurDetaill) {
                            $kurumDetailTur[$b]['KurumTurID'] = $adminKurumTurDetaill['SBTurID'];
                            $kurumDetailTur[$b]['KurumDetailTurAdi'] = $adminKurumTurDetaill['SBTurAdi'];
                            $kurumDetailTur[$b]['KurumTurAktiflik'] = $adminKurumTurDetaill['SBTurAktiflik'];
                            $kurumDetailTur[$b]['KurumTurTip'] = $adminKurumTurDetaill['SBTurType'];
                            $kurumDetailTur[$b]['KurumTurAcikla'] = $adminKurumTurDetaill['SBTurAciklama'];
                            $b++;
                        }

                        $sonuc["adminKurumDetail"] = $returnFormdata['adminKurumDetail'];
                        $sonuc["adminKurumTurDetail"] = $kurumDetailTur;
                    }

                    break;

                case "adminKurumDetailDelete":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AKurum';


                        $form->post('kurumdetail_id', true);
                        $adminKurumDetailID = $form->values['kurumdetail_id'];

                        $deleteresult = $Panel_Model->adminKurumDelete($adminKurumDetailID);
                        if ($deleteresult) {
                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                            if ($resultMemcache) {
                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                            }
                            $sonuc["delete"] = "Kurum kaydı başarıyla silinmiştir.";
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    $sonuc["adminKurumDetail"] = $data["adminKurumDetail"];

                    break;

                case "adminKurumDetailDuzenle":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {

                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AKurum';

                        $form->post('kurumdetail_adi', true);
                        $form->post('kurumdetail_bolge', true);
                        $form->post('kurumdetail_tip', true);
                        $form->post('kurumdetail_telefon', true);
                        $form->post('kurumdetail_email', true);
                        $form->post('kurumdetail_adres', true);
                        $form->post('kurumdetail_aciklama', true);

                        $form->post('kurumdetail_id', true);
                        $adminKurumDetailID = $form->values['kurumdetail_id'];

                        if ($form->submit()) {
                            $data = array(
                                'SBKurumAdi' => $form->values['kurumdetail_adi'],
                                'SBKurumAciklama' => $form->values['kurumdetail_aciklama'],
                                'SBBolgeAdi' => $form->values['kurumdetail_bolge'],
                                'SBKurumTip' => $form->values['kurumdetail_tip'],
                                'SBKurumTelefon' => $form->values['kurumdetail_telefon'],
                                'SBKurumAdres' => $form->values['kurumdetail_adres'],
                                'SBKurumEmail' => $form->values['kurumdetail_email']
                            );
                        }
                        $resultupdate = $Panel_Model->adminKurumOzelliklerDuzenle($data, $adminKurumDetailID);
                        if ($resultupdate) {
                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                            if ($resultMemcache) {
                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                            }
                            $sonuc["update"] = "Başarıyla Kurum Bilgileriniz Güncellenmiştir.";
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    break;

                case "adminKurumSelectBolge":
                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //super adminse tüm bölgeler çekilir
                        if ($adminRutbe != 0) {
                            $bolgeListe = $Panel_Model->kurumBolgeListele();

                            $kurumbolge = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$kurumbolge] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$kurumbolge] = $bolgelist['SBBolgeID'];
                                $kurumbolge++;
                            }
                        } else {//değilse admin ıd ye göre bölge görür
                            $bolgeListeRutbe = $Panel_Model->adminKurumBolgeListele($adminID);

                            foreach ($bolgeListeRutbe as $rutbe) {
                                $bolgerutbeId[] = $rutbe['BSBolgeID'];
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);


                            $bolgeListe = $Panel_Model->soforRutbeBolgeListele($rutbebolgedizi);

                            $kurumbolge = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$kurumbolge] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$kurumbolge] = $bolgelist['SBBolgeID'];
                                $kurumbolge++;
                            }
                        }

                        $sonuc["adminKurumBolge"] = $adminBolge['AdminBolge'];
                        $sonuc["adminKurumBolgee"] = $adminBolge['AdminBolgeID'];
                    }
                    break;

                case "adminKurumKaydet":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AKurum';

                        $form->post('kurumadi', true);
                        $form->post('bolgead', true);
                        $form->post('bolgeId', true);
                        $form->post('kurumtip', true);
                        $form->post('kurumlocation', true);
                        $form->post('kurumTlfn', true);
                        $form->post('kurumEmail', true);
                        $form->post('kurumwebsite', true);
                        $form->post('kurumadrsDty', true);
                        $form->post('kurumaciklama', true);
                        $form->post('kurumulke', true);
                        $form->post('kurumil', true);
                        $form->post('kurumilce', true);
                        $form->post('kurumsemt', true);
                        $form->post('kurummahalle', true);
                        $form->post('kurumsokak', true);
                        $form->post('kurumpostakodu', true);
                        $form->post('kurumcaddeno', true);


                        if ($form->submit()) {
                            $data = array(
                                'SBKurumAdi' => $form->values['kurumadi'],
                                'SBKurumAciklama' => $form->values['kurumaciklama'],
                                'SBBolgeID' => $form->values['bolgeId'],
                                'SBBolgeAdi' => $form->values['bolgead'],
                                'SBKurumTip' => $form->values['kurumtip'],
                                'SBKurumUlke' => $form->values['kurumulke'],
                                'SBKurumIl' => $form->values['kurumil'],
                                'SBKurumIlce' => $form->values['kurumilce'],
                                'SBKurumSemt' => $form->values['kurumsemt'],
                                'SBKurumMahalle' => $form->values['kurummahalle'],
                                'SBKurumSokak' => $form->values['kurumsokak'],
                                'SBKurumLokasyon' => $form->values['kurumlocation'],
                                'SBKurumTelefon' => $form->values['kurumTlfn'],
                                'SBKurumAdres' => $form->values['kurumadrsDty'],
                                'SBKurumEmail' => $form->values['kurumEmail'],
                                'SBKurumWebsite' => $form->values['kurumwebsite'],
                                'SBKurumPostaKodu' => $form->values['kurumpostakodu'],
                                'SBKurumCaddeNo' => $form->values['kurumcaddeno']
                            );
                        }

                        $resultKurumID = $Panel_Model->addNewAdminKurum($data);

                        if ($resultKurumID) {
                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                            if ($resultMemcache) {
                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                            }
                            $sonuc["newKurumID"] = $resultKurumID;
                            $sonuc["insert"] = "Başarıyla Kurum Eklenmiştir.";
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

