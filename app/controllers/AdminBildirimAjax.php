<?php

class AdminBildirimAjax extends Controller {

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
            //form class bağlanısı
            $MemcacheModel = $this->load->model("AdminMemcache_Model");

            $form->post("tip", true);
            $tip = $form->values['tip'];
            $adminID = Session::get("userId");
            Switch ($tip) {
                case "adminBildirim":
                    $adminRutbe = Session::get("userRutbe");
                    $uniqueBidirimKey = Session::get("userFirmaKod");
                    $uniqueBidirimKey = $uniqueBidirimKey . '_ABildirimAyar' . $adminID;
                    $resultMemcacheBildirim = $MemcacheModel->get($uniqueBidirimKey);
                    if ($resultMemcacheBildirim == false) {
                        $bildirimAyar = $resultMemcacheBildirim[0];
                    } else {
                        $resultBildirim = $Panel_Model->adminBildirimAyar($adminID);
                        foreach ($resultBildirim as $resultBildirimm) {
                            $adminBildirimm[] = $resultBildirimm['BSAyarTip'];
                        }
                        $MemcacheModel->set($uniqueBidirimKey, $adminBildirimm, false, 3600);
                        $bildirimAyar = $resultMemcacheBildirim[0];
                    }

                    $resultBildirimler = $Panel_Model->adminBildirimler($bildirimAyar, $adminID);
                    $a = 0;
                    foreach ($resultBildirimler as $resultBildirimlerr) {
                        $adminBildirim['ID'][$a] = $resultBildirimlerr['BSAdminBildirimID'];
                        $adminBildirim['Text'][$a] = $resultBildirimlerr['BSBildirimText'];
                        $adminBildirim['Icon'][$a] = $resultBildirimlerr['BSBildirimIcon'];
                        $adminBildirim['Url'][$a] = $resultBildirimlerr['BSBildirimUrl'];
                        $adminBildirim['Renk'][$a] = $resultBildirimlerr['BSBildirimRenk'];
                        $adminBildirim['Tip'][$a] = $resultBildirimlerr['BSBildirimTip'];
                        $adminBildirim['Okundu'][$a] = $resultBildirimlerr['BSOkundu'];
                        $adminBildirim['Tarih'][$a] = $resultBildirimlerr['BSBildirimTarih'];

                        $a++;
                    }
                    $resultBildirimlerCount = $Panel_Model->adminBildirimlerCount($bildirimAyar, $adminID);
                    if (count($resultBildirimlerCount) > 0) {
                        $sonuc["BildirCount"] = $resultBildirimlerCount[0]['COUNT(*)'];
                    }

                    $sonuc["Bildir"] = $adminBildirim;
                    break;

                case "loaderDocument":
                    $adminRutbe = Session::get("userRutbe");
                    $uniqueBidirimKey = Session::get("userFirmaKod");
                    $uniqueBidirimKey = $uniqueBidirimKey . '_ABildirimAyar' . $adminID;
                    $resultMemcacheBildirim = $MemcacheModel->get($uniqueBidirimKey);
                    if ($resultMemcacheBildirim != false) {
                        $bildirimAyar = $resultMemcacheBildirim[0];
                    } else {
                        $resultBildirim = $Panel_Model->adminBildirimAyar($adminID);
                        foreach ($resultBildirim as $resultBildirimm) {
                            $adminBildirimm[] = $resultBildirimm['BSAyarTip'];
                        }
                        $MemcacheModel->set($uniqueBidirimKey, $adminBildirimm, false, 3600);
                        $bildirimAyar = $resultMemcacheBildirim[0];
                    }

                    $form->post('sonDeger', true);
                    $sonDeger = $form->values['sonDeger'];

                    $resultBildirimler = $Panel_Model->loaderBildirimler($bildirimAyar, $adminID, $sonDeger);
                    $a = 0;
                    foreach ($resultBildirimler as $resultBildirimlerr) {
                        $adminBildirim['ID'][$a] = $resultBildirimlerr['BSAdminBildirimID'];
                        $adminBildirim['Text'][$a] = $resultBildirimlerr['BSBildirimText'];
                        $adminBildirim['Icon'][$a] = $resultBildirimlerr['BSBildirimIcon'];
                        $adminBildirim['Url'][$a] = $resultBildirimlerr['BSBildirimUrl'];
                        $adminBildirim['Renk'][$a] = $resultBildirimlerr['BSBildirimRenk'];
                        $adminBildirim['Tip'][$a] = $resultBildirimlerr['BSBildirimTip'];
                        $adminBildirim['Okundu'][$a] = $resultBildirimlerr['BSOkundu'];
                        $adminBildirim['Tarih'][$a] = $resultBildirimlerr['BSBildirimTarih'];

                        $a++;
                    }
                    $resultBildirimlerCount = $Panel_Model->adminBildirimlerCount($bildirimAyar, $adminID);
                    if (count($resultBildirimlerCount) > 0) {
                        $sonuc["BildirCount"] = $resultBildirimlerCount[0]['COUNT(*)'];
                    }

                    $sonuc["Bildir"] = $adminBildirim;
                    break;

                case "adminOkundu":
                    $form->post('ID', true);
                    $bildirimID = $form->values['ID'];
                    if ($form->submit()) {
                        $data = array(
                            'BSOkundu' => 1
                        );
                    }
                    $resultBildirim = $Panel_Model->adminBildirimOkundu($data, $bildirimID);
                    break;

                case "adminGoruldu":
                    if ($form->submit()) {
                        $data = array(
                            'BSGoruldu' => 1
                        );
                    }
                    $resultBildirim = $Panel_Model->adminBildirimGoruldu($data, $adminID);
                    break;

                case "tumunuOkundu":

                    if ($form->submit()) {
                        $data = array(
                            'BSOkundu' => 1
                        );
                    }
                    $resultBildirim = $Panel_Model->bildirimTumunuOkundu($data, $adminID);
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

