<?php

class AdminBildirimAyarAjaxSorgu extends Controller {

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

            //language 
            $lang = Session::get("dil");
            $formm = $this->load->ajaxlanguage($lang);
            $deger = $formm->ajaxlanguage();
            //model bağlantısı
            $Panel_Model = $this->load->model("Panel_Model");
            //form class bağlanısı
            $MemcacheModel = $this->load->model("AdminMemcache_Model");

            $form->post("tip", true);
            $tip = $form->values['tip'];
            Switch ($tip) {

                case "bildirimTick":

                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        $form->yonlendir(SITE_URL_LOGOUT);
                    } else {
                        $tickArray = $_REQUEST['notTickArray'];
                        $newTickArray = implode(",", $tickArray);
                        $newArray = array($newTickArray);
                        $resultID = $Panel_Model->adminBildirimAyarSelect($adminID);
                        if ($resultID) {//update
                            $data = array(
                                'BSAyarTip' => $newTickArray
                            );
                            $resultBildirim = $Panel_Model->adminBildirimAyarDuzenle($data, $adminID);
                            if ($resultBildirim) {
                                $uniqueBidirimKey = Session::get("userFirmaKod");
                                $uniqueBidirimKey = $uniqueBidirimKey . '_ABildirimAyar' . $adminID;
                                $resultMemcache = $MemcacheModel->get($uniqueBidirimKey);
                                $sonuc["2"] = $resultMemcache;
                                if ($resultMemcache == false) {
                                    $resultDelete = $MemcacheModel->deleteKey($uniqueBidirimKey);
                                    if ($resultDelete) {
                                        $MemcacheModel->set($uniqueBidirimKey, $newArray, false, 3600);
                                        $sonuc["ayarDuzen"] = $newArray;
                                    }
                                } else {
                                    $resultDelete = $MemcacheModel->deleteKey($uniqueBidirimKey);
                                    if ($resultDelete) {
                                        $MemcacheModel->set($uniqueBidirimKey, $newArray, false, 3600);
                                        $sonuc["ayarDuzen"] = $newArray;
                                    }
                                }
                                $sonuc["update"] = $deger["BildirimAyarKaydet"];
                            } else {
                                $sonuc["hata"] = $deger["Hata"];
                            }
                        } else {//insert
                            $insertData = array(
                                'BSAdminID' => $adminID,
                                'BSAyarTip' => $newTickArray
                            );
                            $resultBildirim = $Panel_Model->addNewAdminBildirimAyar($insertData);
                            if ($resultBildirim) {
                                $uniqueBidirimKey = Session::get("userFirmaKod");
                                $uniqueBidirimKey = $uniqueBidirimKey . '_ABildirimAyar' . $adminID;
                                $resultMemcache = $MemcacheModel->get($uniqueBidirimKey);
                                if ($resultMemcache == false) {
                                    $resultDelete = $MemcacheModel->deleteKey($uniqueBidirimKey);
                                    if ($resultDelete) {
                                        $MemcacheModel->set($uniqueBidirimKey, $newArray, false, 3600);
                                        $sonuc["ayarDuzen"] = $newArray;
                                    }
                                } else {
                                    $resultDelete = $MemcacheModel->deleteKey($uniqueBidirimKey);
                                    if ($resultDelete) {
                                        $MemcacheModel->set($uniqueBidirimKey, $newArray, false, 3600);
                                        $sonuc["ayarDuzen"] = $newArray;
                                    }
                                }
                                $sonuc["update"] = $deger["BildirimAyarKaydet"];
                            } else {
                                $sonuc["hata"] = $deger["Hata"];
                            }
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

