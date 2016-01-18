<?php

class LoginForm extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->login();
    }

    //daha önce login oldu ise
    function login() {
        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');
        $sessionKey = $form->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey) {
            header("Location:" . SITE_URL_HOME . "/Panel");
        } else {
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (!Session::get("dil")) {
                Session::set("dil", $lang);
                $formMulti = $this->load->multilanguage($lang);
                $deger = $formMulti->multilanguage();
            } else {
                $formMulti = $this->load->multilanguage(Session::get("dil"));
                $deger = $formMulti->multilanguage();
            }
            $this->load->view("Entry/loginForm", $deger);
        }
    }

}

?>