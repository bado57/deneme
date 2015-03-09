<?php

class Panel extends Controller {

    public function __construct() {

        parent::__construct();
        //oturum kontrolü
        Session::checkSession();
    }

    public function index() {
        $this->home();
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
        } elseif ($loginTip == 2) {
            $this->load->view("Template_SoforBackEnd/header", $deger);
            $this->load->view("Template_SoforBackEnd/left", $deger);
            $this->load->view("Template_SoforBackEnd/home", $deger);
            $this->load->view("Template_SoforBackEnd/footer", $deger);
        } elseif ($loginTip == 3) {
            $this->load->view("Template_VeliBackEnd/header", $deger);
            $this->load->view("Template_VeliBackEnd/left", $deger);
            $this->load->view("Template_VeliBackEnd/home", $deger);
            $this->load->view("Template_VeliBackEnd/footer", $deger);
        } elseif ($loginTip == 4) {
            $this->load->view("Template_OgrenciBackEnd/header", $deger);
            $this->load->view("Template_OgrenciBackEnd/left", $deger);
            $this->load->view("Template_OgrenciBackEnd/home", $deger);
            $this->load->view("Template_OgrenciBackEnd/footer", $deger);
        } else if ($loginTip == 5) {
            $this->load->view("Template_IsciBackEnd/header", $deger);
            $this->load->view("Template_IsciBackEnd/left", $deger);
            $this->load->view("Template_IsciBackEnd/home", $deger);
            $this->load->view("Template_IsciBackEnd/footer", $deger);
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

