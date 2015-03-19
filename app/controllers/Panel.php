<?php

class Panel extends Controller {

    public function __construct() {

        parent::__construct();
        //oturum kontrolü
        Session::checkSession();
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
            $this->home();
        } else {
            header("Location:" . SITE_URL_HOME);
        }
    }

    public function home() {

        $loginTip = Session::get("userTip");
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (!Session::get("dil")) {
            Session::set("dil", $lang);
            $form = $this->load->multilanguage($lang);
            $deger = $form->multilanguage();
        } else {
            $form = $this->load->multilanguage(Session::get("dil"));
            $deger = $form->multilanguage();
        }

        if ($loginTip == 1) {
            $this->load->view("Template_AdminBackEnd/header", $deger);
            $this->load->view("Template_AdminBackEnd/left", $deger);
            $this->load->view("Template_AdminBackEnd/home", $deger);
            $this->load->view("Template_AdminBackEnd/footer", $deger);
        } else {
            //$this->load->view("Entry/loginForm");
        }
    }

    public function addNewContent() {
        $this->load->view("Template_BackEnd/header");
        $this->load->view("Template_BackEnd/left");
        $this->load->view("Template_BackEnd/home");
        $this->load->view("Template_BackEnd/right");
        $this->load->view("Template_BackEnd/footer");
    }

    public function addNewContentRun() {
        $form = $this->load->otherClasses('Form');
        $form->post("title")
                ->isEmpty()
                ->length(0, 100);

        $form->post("content")
                ->isEmpty()
                ->length(0, 50);

        if ($form->submit()) {
            $data = array(
                'title' => $form->values['title'],
                'content' => $form->values['content']
            );

            $model = $this->load->model("panel_model");
            $result = $model->addNewContentRun($data);
            if ($result) {
                echo 'Sorun yok';
            } else {
                echo 'Sorun var';
            }
        } else {
            //HATA VARSA
            $data["formErrors"] = $form->errors;

            //addnewCotent e gidip hatları yazdıyacak
            $this->load->view("Template_BackEnd/header");
            $this->load->view("Template_BackEnd/left");
            $this->load->view("Template_BackEnd/addNewContent", $data);
            $this->load->view("Template_BackEnd/footer");
        }
    }

    public function addNewProduct() {
        $this->load->view("Template_BackEnd/header");
        $this->load->view("Template_BackEnd/left");
        $this->load->view("Template_BackEnd/addNewProduct");
        $this->load->view("Template_BackEnd/footer");
    }

}
?>

