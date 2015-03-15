<?php

class Form {

    public $currentValue;
    public $values = array();
    public $errors = array();
    public $count = array();

    public function __construct() {
        
    }

    //post metodu almak için
    public function post($key, $st = false) {
        if ($st) {
            $this->values[$key] = htmlspecialchars(addslashes(trim($_POST[$key])));
            $this->currentValue = $key;
            return $this;
        } else {
            return addslashes(trim($_POST[$key]));
        }
    }

    //get metodundan verileri almak için
    public function get($key, $st = false) {
        if ($st) {
            $this->values[$key] = htmlspecialchars(addslashes(trim($_GET[$key])));
            $this->currentValue = $key;
            return $this;
        } else {
            return addslashes(trim($_GET[$key]));
        }
    }

    //dizi post etme burada özel karekterleri silme gibi durumlar sıkıntı çıkardığı için üsttekinden faklı
    public function dizipost($key, $st = false) {
        if ($st) {
            $this->values[$key] = $_POST[$key];
            $this->currentValue = $key;
            return $this;
        } else {
            return $_POST[$key];
        }
    }

    //dizi sayısı
    public function count($array) {
        $deger = count($array);
        return $deger;
    }

    //en son kullanılan değerin boş mu dolu mu olduğuna bakacak
    public function isEmpty() {
        if (empty($this->values[$this->currentValue])) {
            //boşsa
            $this->errors[$this->currentValue]["empty"] = "Lütfen bu alanı boş Bırakmayınız";
        }
        return $this;
    }

    //kullanıcı 5 ile 10 karekter arası girip girmediği gibi
    public function length($min = 0, $max) {
        if (strlen($this->values[$this->currentValue]) < $min OR strlen($this->values[$this->currentValue]) > $max) {
            $this->errors[$this->currentValue]["length"] = "Lütfen " . $min . "  ve  " . $max . "  değerleri arasında bir yazı giriniz.";
        }
        return $this;
    }

    //mail formatında olup olmadığı gösterilmektedir
    public function isMail() {
        if (!filter_var($this->values[$this->currentValue], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$this->currentValue]['mail'] = "Lütfen geçerli bir email adresi giriniz.";
        }
        return $this;
    }

    //onaylayıp hata kontrolü
    public function submit() {
        if (empty($this->errors)) {
            return true;
        } else {
            return false;
        }
    }

    //tarih düzenleme, tarih formatı YYYY/MM/DD şeklinde functiona gelmektedir
    function tarihduzenle() {
        if ($this->values[$this->currentValue]) {
            $tarihim = explode('/', $this->values[$this->currentValue]);
            $son = $tarihim[2] . '-' . $tarihim[1] . '-' . $tarihim[0];
        } else {
            $son = "";
        }
        return $son;
    }

    //uzunluğu kısaltma fonksiyonu
    function kisalt($paremetre, $uzunluk = 50) {

        if (strlen($paremetre) > $uzunluk) {
            //bazı sunucularda mb çalışmıyor onun yerine mb silip direkt substr yazılması gerekir
            $paremetre = mb_substr($paremetre, 0, $uzunluk, "UTF8") . "..";
        }
        return $paremetre;
    }

    //başka sayfaya yönlendirme fonksiyonu
    function yonlendir($paremetre, $time = 0) {
        if ($time == 0) {
            header("Location:{$paremetre}");
        } else {
            header("Refresh: {$time}; url={$paremetre}");
        }
    }

    //session kontrol değeri, real sunucuya kurunca yorumlar kaldırılacak
    function sessionKontrol() {
        /*
          if (getenv("HTTP_CLIENT_IP")) {
          $ip = getenv("HTTP_CLIENT_IP");
          } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
          $ip = getenv("HTTP_X_FORWARDED_FOR");
          if (strstr($ip, ',')) {
          $tmp = explode(',', $ip);
          $ip = trim($tmp[0]);
          }
          } else {
          $ip = getenv("REMOTE_ADDR");
          } */

        $SecretKey = 'BSShuttle38';
        //error_log("function icerisi" . md5(sha1(md5($SecretKey))));
        //return md5(sha1(md5($ip . $SecretKey . $_SERVER['HTTP_USER_AGENT'])));
        return md5(sha1(md5($SecretKey)));
    }

    //array key değiştirme js güvenliği için
    function newKeys($oldkeys, $newkeys) {
        if (count($oldkeys) !== count($newkeys))
            return false;

        $data = array();
        $i = 0;
        foreach ($oldkeys as $k => $v) {
            $data[$newkeys[$i]] = $v;  // yeni array oluştur
            $i++;
        }
        return $data;
    }

    //array değer bulma fonksiyonu(count)
    function array_deger_filtreleme($array, $index, $value) {
        if (is_array($array) && count($array) > 0) {
            foreach (array_keys($array) as $key) {
                $temp[$key] = $array[$key][$index];

                if ($temp[$key] == $value) {
                    $newarray[$key] = $array[$key];
                }
            }
        }
        return $newarray;
    }

}

?>