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
            $Panel_Model = $this->load->model("panel_model");
            //form class bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");

            $form->post("tip", true);
            $tip = $form->values['tip'];
            $adSoyad = Session::get("kullaniciad") . ' ' . Session::get("kullanicisoyad");
            $adminID = Session::get("userId");
            if ($tip == 'adminBildirim') {
                $adminRutbe = Session::get("userRutbe");
                $uniqueBidirimKey = Session::get("userFirmaKod");
                $uniqueBidirimKey = $uniqueBidirimKey . '_ABildirimAyar' . $adminID;
                $resultMemcacheBildirim = $MemcacheModel->get($uniqueBidirimKey);
                if ($resultMemcacheBildirim != false) {
                    $bildirimAyar = $resultMemcacheBildirim[0];
                } else {
                    $resultBildirim = $Panel_Model->adminBildirimAyar($adminID);
                    foreach ($resultBildirim as $resultBildirimm) {
                        $adminBildirim[] = $resultBildirimm['BSAyarTip'];
                    }
                    $MemcacheModel->set($uniqueBidirimKey, $adminBildirim, false, 3600);
                    $bildirimAyar = $resultMemcacheBildirim[0];
                }
                if ($adminRutbe != 1) {//küçük admin
                } else {//büyük admin
                    $resultBildirimler = $Panel_Model->adminBildirimler($bildirimAyar);
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
                    $resultBildirimlerCount = $Panel_Model->adminBildirimlerCount();

                    $sonuc["Bildir"] = $adminBildirim;
                    $sonuc["BildirCount"] = $resultBildirimlerCount[0]['COUNT(*)'];
                }
            }
            echo json_encode($sonuc);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

}
?>

