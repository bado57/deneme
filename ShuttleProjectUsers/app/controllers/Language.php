<?php

class Language extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->selectlanguage();
    }

    function selectlanguage() {
        Session::init();
        $dil = strip_tags($_GET["language"]);
        if ($dil == "tr" || $dil == "en") {
            Session::set("dil", $dil);
            header("Location:" . SITE_URL_HOME . "/userslogin");
        } else {
            header("Location:" . SITE_URL_HOME . "/userslogin");
        }
    }

}
?>

