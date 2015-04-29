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

    //substr.İstenilen yerden sonrasını kelimede alma
    function substrEnd($statement, $value) {
        $result = substr($statement, $value);
        return $result;
    }

    //substr.İstenilen karekterler arasını alır
    function substrInterval($statement, $start, $end) {
        $result = substr($statement, $start, $end);
        return $result;
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

    //diziyi istenilen karekter göre bölme
    function implode($divide, $array) {
        if ($this->count($array) > 0) {
            $implodeArray = implode($divide, $array);
            return $implodeArray;
        } else {
            return $array;
        }
    }

    //gelen değeri  şifreleme
    function md5($value) {
        return md5($value);
    }

    //gelen değeri  şifreleme
    function security($value) {
        return md5(sha1(md5($value)));
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

    function shuttleNotification($target_device = array(), $alert, $title) {
        $appId = '54K06z74qYiVBTx1DAtHC0xgHWcQ8HcnZlJcS5th';
        $restKey = 'z7J7f963G4HF3G4Vh2JDJDeFRXCQ2PpHByQ3UUPL';

        $push_payload = json_encode(array(
            "where" => array(
                "UniqueId" => array(
                    '$in' => $target_device)
            ),
            "data" => array(
                "alert" => $alert,
                "title" => $title
            )
        ));
        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, SITE_NOTIFICATION);
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($rest, CURLOPT_PORT, 443);
        curl_setopt($rest, CURLOPT_POST, 1);
        curl_setopt($rest, CURLOPT_POSTFIELDS, $push_payload);
        curl_setopt($rest, CURLOPT_HTTPHEADER, array("X-Parse-Application-Id: " . $appId,
            "X-Parse-REST-API-Key: " . $restKey,
            "Content-Type: application/json"));
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($rest);
        $result = json_decode($response);
        $sonuc = $result->{"result"};
        curl_close($rest);

        return $sonuc;
    }

    function turkce_kucult_tr($string) {
        $buyuk = array("A", "B", "C", "Ç", "D", "E", "F", "G", "Ğ", "H", "I", "İ", "J", "K", "L", "M", "N", "O", "Ö", "P", "R", "S", "Ş", "T", "U", "Ü", "V", "Y", "Z", "Q", "W", "X", "ç", "ş", "ğ", "ü", "ö", "ı");
        $kucuk = array("a", "b", "c", "c", "d", "e", "f", "g", "g", "h", "i", "i", "j", "k", "l", "m", "n", "o", "o", "p", "r", "s", "s", "t", "u", "u", "v", "y", "z", "q", "w", "x", "c", "s", "g", "u", "o", "i");
        $cikti = str_replace($buyuk, $kucuk, $string);
        return $cikti;
    }

    function harf_Rakam_Donusum($string) {
        $buyuk = array("A", "B", "C", "Ç", "D", "E", "F", "G", "Ğ", "H", "I", "İ", "J", "K", "L", "M", "N", "O", "Ö", "P", "R", "S", "Ş", "T", "U", "Ü", "V", "Y", "Z", "Q", "W", "X", "a", "b", "c", "ç", "d", "e", "f", "g", "ğ", "h", "ı", "i", "j", "k", "l", "m", "n", "o", "ö", "p", "r", "s", "ş", "t", "u", "ü", "v", "y", "z", "q", "w", "x");
        $kucuk = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "1", "2", "3", "4");
        $cikti = str_replace($buyuk, $kucuk, $string);
        return $cikti;
    }

    function benzersiz_Sayi_Harf($uzunluk) {
        $karakterler = array(); // boş bir dizi oluşturuyoruz
        $karakterler = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z')); // range = belirtilen aralık arasında dizi oluşturur
        // array_merge = dizileri arka arkaya ekler
        srand((float) microtime() * 100000); // belirli bir düzen içerisinde rastgele sayı üretir
        shuffle($karakterler); // dizideki elemanları rasgele sıralar
        $sonuc = ''; // boş bir sonuc değişkeni oluşturuyoruz
        for ($i = 0; $i < $uzunluk; $i++) {
            $sonuc .= $karakterler[$i]; // karakterleri birleştirir
        }
        unset($karakterler); // tanımlanmamış hale getirir
        return $sonuc; // çıkan sonucu ekrana yazdırır
        //kod(8); // 5 haneli rastgele kod üretir isteğe göre ayarlanabilir
    }

    function benzersiz_Sayi($uzunluk) {
        $karakterler = array();
        $karakterler = array_merge(range(0, 9));
        srand((float) microtime() * 100000);
        shuffle($karakterler);
        $sonuc = '';
        for ($i = 0; $i < $uzunluk; $i++) {
            $sonuc .= $karakterler[$i];
        }
        unset($karakterler);
        return $sonuc;
    }

    function benzersiz_Harf($uzunluk) {
        $karakterler = array();
        $karakterler = array_merge(range('a', 'z'), range('A', 'Z'));
        srand((float) microtime() * 100000);
        shuffle($karakterler);
        $sonuc = '';
        for ($i = 0; $i < $uzunluk; $i++) {
            $sonuc .= $karakterler[$i];
        }
        unset($karakterler);
        return $sonuc;
    }

    function benzersiz_kucukHarf($uzunluk) {
        $karakterler = array();
        $karakterler = array_merge(range('a', 'z'));
        srand((float) microtime() * 100000);
        shuffle($karakterler);
        $sonuc = '';
        for ($i = 0; $i < $uzunluk; $i++) {
            $sonuc .= $karakterler[$i];
        }
        unset($karakterler);
        return $sonuc;
    }

    function benzersiz_Buyuk_Harf($uzunluk) {
        $karakterler = array();
        $karakterler = array_merge(range('A', 'Z'));
        srand((float) microtime() * 100000);
        shuffle($karakterler);
        $sonuc = '';
        for ($i = 0; $i < $uzunluk; $i++) {
            $sonuc .= $karakterler[$i];
        }
        unset($karakterler);
        return $sonuc;
    }

    function benzersiz_Istenilen_Sekilde($kharfuzunluk = 2, $bharfuzunluk = 2, $sayiuzunluk = 4) {

        $karakterler = array(); // boş bir dizi oluşturuyoruz
        $uzunluk = $kharfuzunluk + $bharfuzunluk + $sayiuzunluk;
        $arr1 = array();
        $arr1 = range(0, 9);
        $arr2 = array();
        $arr2 = range('a', 'z');
        $arr3 = array();
        $arr3 = range('A', 'Z');
        shuffle($arr1);
        shuffle($arr2);
        shuffle($arr3);

        $karakterler = array_merge(array_slice($arr1, 0, $sayiuzunluk), array_slice($arr2, 0, $kharfuzunluk), array_slice($arr3, 0, $bharfuzunluk));
        shuffle($karakterler);
        $sonuc = '';
        for ($i = 0; $i < $uzunluk; $i++) {

            $sonuc .= $karakterler[$i];
        }
        unset($karakterler); // tanımlanmamış hale getirir

        return $sonuc; // çıkan sonucu ekrana yazdırır
    }

    function sifreOlustur() {
        $userSifre = $this->benzersiz_Sayi(11);
        return $userSifre;
    }

    function kadiOlustur($firmaID) {
        $userKadi = $this->benzersiz_Sayi(8);
        $userKadi = $userKadi . $firmaID;
        return $userKadi;
    }

    function userSifreOlustur($loginKadi, $loginSifre, $loginTip) {
        $loginDeger = "bs";
        $sifreilkeleman = $loginDeger . $loginKadi . $loginTip;
        $sifreilkeleman1 = md5($sifreilkeleman);
        $sifreikincieleman = md5($loginSifre);
        $sifresonuc = $sifreilkeleman1 . $sifreikincieleman;
        return $sifresonuc;
    }

    function sqlGunSaat($turBolgeID, $turSaat1, $turSaat2, $gunler = array()) {
        $sql = 'BSTurBolgeID=' . $turBolgeID . ' AND ((' . $turSaat1 . ' BETWEEN BSTurBslngc AND BSTurBts) OR (' . $turSaat2 . ' BETWEEN BSTurBslngc AND BSTurBts)) AND ';
        if (in_array("Pzt", $gunler)) {
            $sql .= '(BSTurPzt=1';

            if (in_array("Sli", $gunler)) {
                $sql .= ' OR BSTurSli=1';
            }

            if (in_array("Crs", $gunler)) {
                $sql .= ' OR BSTurCrs=1';
            }

            if (in_array("Prs", $gunler)) {
                $sql .= ' OR BSTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR BSTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR BSTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR BSTurPzr=1';
            }
        } else if (in_array("Sli", $gunler)) {
            $sql .= '(BSTurSli=1';

            if (in_array("Crs", $gunler)) {
                $sql .= ' OR BSTurCrs=1';
            }

            if (in_array("Prs", $gunler)) {
                $sql .= ' OR BSTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR BSTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR BSTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR BSTurPzr=1';
            }
        } else if (in_array("Crs", $gunler)) {
            $sql .= '(BSTurCrs=1 ';
            if (in_array("Prs", $gunler)) {
                $sql .= ' OR BSTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR BSTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR BSTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR BSTurPzr=1';
            }
        } else if (in_array("Prs", $gunler)) {
            $sql .= '(BSTurPrs=1';

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR BSTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR BSTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR BSTurPzr=1';
            }
        } else if (in_array("Cma", $gunler)) {
            $sql .= '(BSTurCma=1';
            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR BSTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR BSTurPzr=1';
            }
        } else if (in_array("Cmt", $gunler)) {
            $sql .= 'BSTurCmt=1';
            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR BSTurPzr=1';
            }
        } else {
            $sql .= '(BSTurPzr=1';
        }
        $sql.=')';

        return $sql;
    }

    function sqlGunSaatSofor($turBolgeID, $turAracID, $turSaat1, $turSaat2, $gunler = array()) {
        $sql = 'BSTurBolgeID=' . $turBolgeID . ' AND BSTurAracID=' . $turAracID . ' AND ((' . $turSaat1 . ' BETWEEN BSTurBslngc AND BSTurBts) OR (' . $turSaat2 . ' BETWEEN BSTurBslngc AND BSTurBts)) AND ';
        if (in_array("Pzt", $gunler)) {
            $sql .= '(BSTurPzt=1';

            if (in_array("Sli", $gunler)) {
                $sql .= ' OR BSTurSli=1';
            }

            if (in_array("Crs", $gunler)) {
                $sql .= ' OR BSTurCrs=1';
            }

            if (in_array("Prs", $gunler)) {
                $sql .= ' OR BSTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR BSTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR BSTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR BSTurPzr=1';
            }
        } else if (in_array("Sli", $gunler)) {
            $sql .= '(BSTurSli=1';

            if (in_array("Crs", $gunler)) {
                $sql .= ' OR BSTurCrs=1';
            }

            if (in_array("Prs", $gunler)) {
                $sql .= ' OR BSTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR BSTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR BSTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR BSTurPzr=1';
            }
        } else if (in_array("Crs", $gunler)) {
            $sql .= '(BSTurCrs=1 ';
            if (in_array("Prs", $gunler)) {
                $sql .= ' OR BSTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR BSTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR BSTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR BSTurPzr=1';
            }
        } else if (in_array("Prs", $gunler)) {
            $sql .= '(BSTurPrs=1';

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR BSTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR BSTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR BSTurPzr=1';
            }
        } else if (in_array("Cma", $gunler)) {
            $sql .= '(BSTurCma=1';
            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR BSTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR BSTurPzr=1';
            }
        } else if (in_array("Cmt", $gunler)) {
            $sql .= 'BSTurCmt=1';
            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR BSTurPzr=1';
            }
        } else {
            $sql .= '(BSTurPzr=1';
        }
        $sql.=')';

        return $sql;
    }

}

?>