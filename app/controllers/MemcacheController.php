<?php
    class MemcacheController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->get();
    }
    
    //insert example
    public function get() {

        $model = $this->load->model("memcachedeneme_model");
        $result = $model->get('deneme');
        if($result){
            echo $result;
        }else{
            echo "istenilen key bulunamadı";
        }
    }
    
    //insert example
    public function set() {

        $model = $this->load->model("memcachedeneme_model");
        $result = $model->set('deneme','memcachecontroller',false,60);
        if($result){
            echo "kayıt işlemi tamam";
        }else{
            echo "kayıt işlemi olmadı";
        }
    }
    
    //replace example
    public function replace() {

        $model = $this->load->model("memcachedeneme_model");
        $result = $model->replace('deneme','yeni deneme değer',false,60);
        if($result){
            echo "değiştirme işlemi tamam";
        }else{
            echo "değiştirme işlemi olmadı";
        }
    }
    
    //replace example
    public function deleteKey() {

        $model = $this->load->model("memcachedeneme_model");
        $result = $model->deleteKey('deneme');
        if($result){
            echo "key değerine sahip değerin silme işlemi tamam";
        }else{
            echo "key değerine sahip değerin silme işlemi olmadı";
        }
    }
    
    //deleteAllKey example
    public function deleteAllKey() {

        $model = $this->load->model("memcachedeneme_model");
        $result = $model->deleteAllKey();
        if($result){
            echo "Tüm key değerlerine sahip değerlerin silme işlemi tamam";
        }else{
            echo "Tüm key değerlerine sahip değerlerin silme işlemi olmadı";
        }
    }
    
     //replace example
    public function serverStatus() {

        $model = $this->load->model("memcachedeneme_model");
        $result = $model->serverStatus();
        if($result){
            echo $result;
            echo "Server Açık";
        }else{
            echo $result;
            echo "Server Kapalı";
        }
    }
    }
?>

