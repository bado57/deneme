<?php

/* Burası linkte girilen urllerin gidecekleri yerdir.
 * 
 * aşağıdaki genel tanımlamaların sebebi url[0] felan diye çağırıp
 *  durmayayım die ve sürekli bunlara değer atayrak devamını getirdim
 *   */

class Bootstrap {

    public $_url;
    public $_controllerName = "UserIndex";
    public $_methodName = 'index';
    public $_controllerPath = 'app/controllers/';
    //şu an çalışan controller
    public $_controller;

    //construct yönlendirmeyi yapacak
    public function __construct() {
        //aşağıdaki fonksiyon url i alıypruz $this->_url şeklinde
        $this->getUrl();

        //aşağıdaki fonksiyonu yani url set edildi ise
        //class yükleme
        $this->loadController();
        $this->callMethod();
    }

    //url i alıyoruz ilk iş olarak
    public function getUrl() {
        $this->_url = isset($_GET["url"]) ? $_GET["url"] : null;
        if ($this->_url != null) {
            $this->_url = rtrim($this->_url, "/");
            $this->_url = explode("/", $this->_url);
        } else {
            //unset fonksiyonu parametre olarak verilen değişkeni hafızadan silmek için kullanılır.
            unset($this->_url);
        }
    }

    public function loadController() {
        //url set edilmemişse index controlünün index metodunu çağır, yani baştaki default değerler
        //set değilse index in indexi
        if (!isset($this->_url[0])) {
            include $this->_controllerPath . $this->_controllerName . '.php';
            $this->_controller = new $this->_controllerName();
        } else {

            $this->_controllerName = $this->_url[0];

            $fileName = $this->_controllerPath . $this->_controllerName . ".php";
            if (file_exists($fileName)) {
                include $fileName;
                //class varsa
                if (class_exists($this->_controllerName)) {
                    //sınıf çağırma
                    $this->_controller = new $this->_controllerName();
                } else {
                    header("Location:" . SITE_URL404);
                }
            } else {
                
            }
        }
    }

    public function callMethod() {
        //paremetre varsa
        if (isset($this->_url[2])) {
            $this->_methodName = $this->_url[1];
            if (method_exists($this->_controller, $this->_methodName)) {
                //metod çağırma ve metoda paremetre gönderme
                $this->_controller->{$this->_methodName}($this->_url[2]);
            } else {
                //echo "Controller içinde method bulunamadı ";
                header("Location:" . SITE_URL404);
            }
        } else {

            if (isset($this->_url[1])) {
                //method ismini atıyorum
                $this->_methodName = $this->_url[1];
                if (method_exists($this->_controller, $this->_methodName)) {
                    //paremetesiz metodu çağırma
                    $this->_controller->{$this->_methodName}();
                } else {
                    //echo "Coontroller içinde bulunmadı";
                    header("Location:" . SITE_URL404);
                }
            } else {
                if (method_exists($this->_controller, $this->_methodName)) {
                    //kullanıcı bi metod girmedi ise ilgili kontrolün metodunu çağır yani default gibi
                    //control adını girmişim ama method girmemişim
                    //heryere index metodu girmeliyim ki ayni sınıfa kullanıcı sadece controller girmiş olsa da bu metdo çalışsın
                    $this->_controller->{$this->_methodName}();
                } else {
                    //echo "Controller içinde İndex metodu bulunamadı bulunmadı";
                    //Session::destroy();
                    header("Location:" . SITE_URL404);
                }
            }
        }
    }

}
?>

