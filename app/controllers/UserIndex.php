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
        $this->load->view("Template_FrontEnd/header");
        $this->load->view("Template_FrontEnd/home");
        $this->load->view("Template_FrontEnd/footer");
    }

}

?>