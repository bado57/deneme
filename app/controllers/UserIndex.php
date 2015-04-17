<?php

class UserIndex extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->login();
    }

    //daha önce login oldu ise
    function login() {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (!Session::get("dil")) {
            Session::set("dil", $lang);
            $formMulti = $this->load->frontmultilanguage($lang);
            $deger = $formMulti->frontmultilanguage();
        } else {
            $formMulti = $this->load->frontmultilanguage(Session::get("dil"));
            $deger = $formMulti->frontmultilanguage();
        }

        $this->load->view("Template_FrontEnd/header", $deger);
        $this->load->view("Template_FrontEnd/home", $deger);
        $this->load->view("Template_FrontEnd/footer", $deger);
    }

}

?>