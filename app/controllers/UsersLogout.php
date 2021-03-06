<?php

class UsersLogout extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->logout();
    }

    //Çıkış Yap
    public function logout() {
        unset($_SESSION['selectDbEncryption']);
        unset($_SESSION['selectDbName']);
        unset($_SESSION['selectDbIp']);
        unset($_SESSION['selectDbUser']);
        unset($_SESSION['selectDbPassword']);
        unset($_SESSION['selectFirmaDurum']);
        unset($_SESSION['sessionkey']);
        unset($_SESSION['username']);
        unset($_SESSION['kullaniciad']);
        unset($_SESSION['kullanicisoyad']);
        unset($_SESSION['userId']);
        unset($_SESSION['userTip']);
        unset($_SESSION['userRutbe']);
        unset($_SESSION['userFirmaKod']);
        unset($_SESSION['OgrServis']);
        unset($_SESSION['PersServis']);
        unset($_SESSION['FirmaId']);

        //Session::destroy();
        header("Location:" . SITE_URL);
    }

}
?>


