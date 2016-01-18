<?php

class AdminDuyuruAjax extends Controller {

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
            $adminID = Session::get("userId");
            Switch ($tip) {
                case "adminDuyuru":
                    $adminRutbe = Session::get("userRutbe");

                    $resultDuyurular = $Panel_Model->adminDuyurular($adminID);
                    $a = 0;
                    foreach ($resultDuyurular as $resultDuyurularr) {
                        $adminDuyuru['ID'][$a] = $resultDuyurularr['BSAdminDuyuruID'];
                        $adminDuyuru['Text'][$a] = $resultDuyurularr['BSDuyuruText'];
                        $adminDuyuru['Okundu'][$a] = $resultDuyurularr['BSOkundu'];
                        $adminDuyuru['Tarih'][$a] = $resultDuyurularr['BSDuyuruTarih'];

                        $a++;
                    }
                    $resultDuyuruCount = $Panel_Model->adminDuyurularCount($adminID);
                    if (count($resultDuyuruCount) > 0) {
                        $sonuc["DuyurCount"] = $resultDuyuruCount[0]['COUNT(*)'];
                    }

                    $sonuc["Duyur"] = $adminDuyuru;
                    break;
                case "loaderDocument":
                    $form->post('sonDeger', true);
                    $sonDeger = $form->values['sonDeger'];

                    $resultDuyurular = $Panel_Model->loaderDuyurular($adminID, $sonDeger);
                    $a = 0;
                    foreach ($resultDuyurular as $resultDuyurularr) {
                        $adminDuyuru['ID'][$a] = $resultDuyurularr['BSAdminDuyuruID'];
                        $adminDuyuru['Text'][$a] = $resultDuyurularr['BSDuyuruText'];
                        $adminDuyuru['Okundu'][$a] = $resultDuyurularr['BSOkundu'];
                        $adminDuyuru['Tarih'][$a] = $resultDuyurularr['BSDuyuruTarih'];
                        $a++;
                    }
                    $resultDuyurularCount = $Panel_Model->adminDuyurularCount($adminID);
                    if (count($resultDuyurularCount) > 0) {
                        $sonuc["DuyurCount"] = $resultDuyurularCount[0]['COUNT(*)'];
                    }

                    $sonuc["Duyur"] = $adminDuyuru;
                    break;
                case "adminOkundu":
                    $form->post('ID', true);
                    $duyuruID = $form->values['ID'];
                    if ($form->submit()) {
                        $data = array(
                            'BSOkundu' => 1
                        );
                    }
                    $resultDuyuru = $Panel_Model->adminDuyuruOkundu($data, $duyuruID);
                    break;
                case "adminGoruldu":
                    if ($form->submit()) {
                        $data = array(
                            'BSGoruldu' => 1
                        );
                    }
                    $resultDuyuru = $Panel_Model->adminDuyuruGoruldu($data, $adminID);
                    break;
                case "tumunuOkundu":
                    if ($form->submit()) {
                        $data = array(
                            'BSOkundu' => 1
                        );
                    }
                    $resultDuyuru = $Panel_Model->duyuruTumunuOkundu($data, $adminID);
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

