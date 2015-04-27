<?php

class AdminTurAjaxSorgu extends Controller {

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

                case "turBolgeEkleSelect":
                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //super adminse tüm bölgeler çekilir
                        if ($adminRutbe != 0) {
                            $bolgeListe = $Panel_Model->turBolgeListele();

                            $turbolge = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$turbolge] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$turbolge] = $bolgelist['SBBolgeID'];
                                $turbolge++;
                            }
                        } else {//değilse admin ıd ye göre bölge görür
                            $bolgeListeRutbe = $Panel_Model->adminTurBolgeListele($adminID);

                            foreach ($bolgeListeRutbe as $rutbe) {
                                $bolgerutbeId[] = $rutbe['BSBolgeID'];
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);


                            $bolgeListe = $Panel_Model->turRutbeBolgeListele($rutbebolgedizi);

                            $kurumbolge = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$kurumbolge] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$kurumbolge] = $bolgelist['SBBolgeID'];
                                $kurumbolge++;
                            }
                        }

                        $sonuc["adminTurBolge"] = $adminBolge['AdminBolge'];
                        $sonuc["adminTurBolgee"] = $adminBolge['AdminBolgeID'];
                    }
                    break;

                case "turKurumSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("turBolgeID", true);
                        $turBolgeID = $form->values['turBolgeID'];

                        $kurumListe = $Panel_Model->turKurumSelect($turBolgeID);

                        $a = 0;
                        foreach ($kurumListe as $kurumListee) {
                            $turKurumSelect['KurumSelectID'][$a] = $kurumListee['SBKurumID'];
                            $turKurumSelect['KurumSelectAd'][$a] = $kurumListee['SBKurumAdi'];
                            $turKurumSelect['KurumSelectTip'][$a] = $kurumListee['SBKurumTip'];
                            $a++;
                        }
                        $sonuc["kurumSelect"] = $turKurumSelect;
                    }
                    break;

                case "turAracSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("turBolgeID", true);
                        $form->post("turKurumID", true);
                        $form->post("turSaat1ID", true);
                        $form->post("turSaat2ID", true);
                        $turBolgeID = $form->values['turBolgeID'];
                        $turKurumID = $form->values['turKurumID'];
                        $turSaat1ID = $form->values['turSaat1ID'];
                        $turSaat2ID = $form->values['turSaat2ID'];
                        $turGunID = $_REQUEST['turGunID'];

                        $kurumListe = $Panel_Model->turKurumSelect($turBolgeID);

                        $a = 0;
                        foreach ($kurumListe as $kurumListee) {
                            $turKurumSelect['KurumSelectID'][$a] = $kurumListee['SBKurumID'];
                            $turKurumSelect['KurumSelectAd'][$a] = $kurumListee['SBKurumAdi'];
                            $turKurumSelect['KurumSelectTip'][$a] = $kurumListee['SBKurumTip'];
                            $a++;
                        }
                        $sonuc["kurumSelect"] = $turKurumSelect;
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

