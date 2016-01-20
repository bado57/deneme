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

    function adminBildirimDuzen($alert, $icon, $url, $renk, $gonderenID, $gonderenAdSoyad, $alanKisi, $tip) {
        $dataBildirim = array(
            'BSBildirimText' => $alert,
            'BSBildirimIcon' => $icon,
            'BSBildirimUrl' => $url,
            'BSBildirimRenk' => $renk,
            'BSGonderenID' => $gonderenID,
            'BSGonderenAdSoyad' => $gonderenAdSoyad,
            'BSAlanID' => $alanKisi,
            'BSOkundu' => 0,
            'BSGoruldu' => 0,
            'BSBildirimTip' => $tip
        );
        return $dataBildirim;
    }

    function adminLogDuzen($ID, $adSoyad, $tip, $text) {
        $dataLog = array(
            'BSEkleyenID' => $ID,
            'BSEkleyenAdSoyad' => $adSoyad,
            'BSLogTip' => $tip,
            'BSLogText' => $text
        );
        return $dataLog;
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

    function myip() {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
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
            $sql .= '(SBTurPzt=1';

            if (in_array("Sli", $gunler)) {
                $sql .= ' OR SBTurSli=1';
            }

            if (in_array("Crs", $gunler)) {
                $sql .= ' OR SBTurCrs=1';
            }

            if (in_array("Prs", $gunler)) {
                $sql .= ' OR SBTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR SBTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Sli", $gunler)) {
            $sql .= '(SBTurSli=1';

            if (in_array("Crs", $gunler)) {
                $sql .= ' OR SBTurCrs=1';
            }

            if (in_array("Prs", $gunler)) {
                $sql .= ' OR SBTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR SBTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Crs", $gunler)) {
            $sql .= '(SBTurCrs=1 ';
            if (in_array("Prs", $gunler)) {
                $sql .= ' OR SBTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR SBTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Prs", $gunler)) {
            $sql .= '(SBTurPrs=1';

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR SBTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Cma", $gunler)) {
            $sql .= '(SBTurCma=1';
            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Cmt", $gunler)) {
            $sql .= 'SBTurCmt=1';
            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else {
            $sql .= '(SBTurPzr=1';
        }
        $sql.=')';

        return $sql;
    }

    function sqlGunSaatSofor($turBolgeID, $turAracID, $turSaat1, $turSaat2, $gunler = array()) {
        $sql = 'BSTurBolgeID=' . $turBolgeID . ' AND BSTurAracID=' . $turAracID . ' AND ((' . $turSaat1 . ' BETWEEN BSTurBslngc AND BSTurBts) OR (' . $turSaat2 . ' BETWEEN BSTurBslngc AND BSTurBts)) AND ';
        if (in_array("Pzt", $gunler)) {
            $sql .= '(SBTurPzt=1';

            if (in_array("Sli", $gunler)) {
                $sql .= ' OR SBTurSli=1';
            }

            if (in_array("Crs", $gunler)) {
                $sql .= ' OR SBTurCrs=1';
            }

            if (in_array("Prs", $gunler)) {
                $sql .= ' OR SBTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR SBTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Sli", $gunler)) {
            $sql .= '(SBTurSli=1';

            if (in_array("Crs", $gunler)) {
                $sql .= ' OR SBTurCrs=1';
            }

            if (in_array("Prs", $gunler)) {
                $sql .= ' OR SBTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR SBTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Crs", $gunler)) {
            $sql .= '(SBTurCrs=1 ';
            if (in_array("Prs", $gunler)) {
                $sql .= ' OR SBTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR SBTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Prs", $gunler)) {
            $sql .= '(SBTurPrs=1';

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR SBTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Cma", $gunler)) {
            $sql .= '(SBTurCma=1';
            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Cmt", $gunler)) {
            $sql .= 'SBTurCmt=1';
            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else {
            $sql .= '(SBTurPzr=1';
        }
        $sql.=')';

        return $sql;
    }

    function sqlGunSaatHostes($turBolgeID, $turAracID, $turSaat1, $turSaat2, $gunler = array()) {
        $sql = 'BSTurBolgeID=' . $turBolgeID . ' AND BSTurAracID=' . $turAracID . ' AND ((' . $turSaat1 . ' BETWEEN BSTurBslngc AND BSTurBts) OR (' . $turSaat2 . ' BETWEEN BSTurBslngc AND BSTurBts)) AND ';
        if (in_array("Pzt", $gunler)) {
            $sql .= '(SBTurPzt=1';

            if (in_array("Sli", $gunler)) {
                $sql .= ' OR SBTurSli=1';
            }

            if (in_array("Crs", $gunler)) {
                $sql .= ' OR SBTurCrs=1';
            }

            if (in_array("Prs", $gunler)) {
                $sql .= ' OR SBTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR SBTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Sli", $gunler)) {
            $sql .= '(SBTurSli=1';

            if (in_array("Crs", $gunler)) {
                $sql .= ' OR SBTurCrs=1';
            }

            if (in_array("Prs", $gunler)) {
                $sql .= ' OR SBTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR SBTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Crs", $gunler)) {
            $sql .= '(SBTurCrs=1 ';
            if (in_array("Prs", $gunler)) {
                $sql .= ' OR SBTurPrs=1';
            }

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR SBTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Prs", $gunler)) {
            $sql .= '(SBTurPrs=1';

            if (in_array("Cma", $gunler)) {
                $sql .= ' OR SBTurCma=1';
            }

            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Cma", $gunler)) {
            $sql .= '(SBTurCma=1';
            if (in_array("Cmt", $gunler)) {
                $sql .= ' OR SBTurCmt=1';
            }

            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else if (in_array("Cmt", $gunler)) {
            $sql .= 'SBTurCmt=1';
            if (in_array("Pzr", $gunler)) {
                $sql .= ' OR SBTurPzr=1';
            }
        } else {
            $sql .= '(SBTurPzr=1';
        }
        $sql.=')';

        return $sql;
    }

    function sqlGunInsert($gunler = array()) {
        $gunData = array();
        if (in_array("Pzt", $gunler)) {
            $gunData['SBTurPzt'] = 1;

            if (in_array("Sli", $gunler)) {
                $gunData['SBTurSli'] = 1;
            }

            if (in_array("Crs", $gunler)) {
                $gunData['SBTurCrs'] = 1;
            }

            if (in_array("Prs", $gunler)) {
                $gunData['SBTurPrs'] = 1;
            }

            if (in_array("Cma", $gunler)) {
                $gunData['SBTurCma'] = 1;
            }

            if (in_array("Cmt", $gunler)) {
                $gunData['SBTurCmt'] = 1;
            }

            if (in_array("Pzr", $gunler)) {
                $gunData['SBTurPzr'] = 1;
            }
        } else if (in_array("Sli", $gunler)) {
            $gunData['SBTurSli'] = 1;

            if (in_array("Crs", $gunler)) {
                $gunData['SBTurCrs'] = 1;
            }

            if (in_array("Prs", $gunler)) {
                $gunData['SBTurPrs'] = 1;
            }

            if (in_array("Cma", $gunler)) {
                $gunData['SBTurCma'] = 1;
            }

            if (in_array("Cmt", $gunler)) {
                $gunData['SBTurCmt'] = 1;
            }

            if (in_array("Pzr", $gunler)) {
                $gunData['SBTurPzr'] = 1;
            }
        } else if (in_array("Crs", $gunler)) {
            $gunData['SBTurCrs'] = 1;
            if (in_array("Prs", $gunler)) {
                $gunData['SBTurPrs'] = 1;
            }

            if (in_array("Cma", $gunler)) {
                $gunData['SBTurCma'] = 1;
            }

            if (in_array("Cmt", $gunler)) {
                $gunData['SBTurCmt'] = 1;
            }

            if (in_array("Pzr", $gunler)) {
                $gunData['SBTurPzr'] = 1;
            }
        } else if (in_array("Prs", $gunler)) {
            $gunData['SBTurPrs'] = 1;

            if (in_array("Cma", $gunler)) {
                $gunData['SBTurCma'] = 1;
            }

            if (in_array("Cmt", $gunler)) {
                $gunData['SBTurCmt'] = 1;
            }

            if (in_array("Pzr", $gunler)) {
                $gunData['SBTurPzr'] = 1;
            }
        } else if (in_array("Cma", $gunler)) {
            $gunData['SBTurCma'] = 1;
            if (in_array("Cmt", $gunler)) {
                $gunData['SBTurCmt'] = 1;
            }

            if (in_array("Pzr", $gunler)) {
                $gunData['SBTurPzr'] = 1;
            }
        } else if (in_array("Cmt", $gunler)) {
            $gunData['SBTurCmt'] = 1;
            if (in_array("Pzr", $gunler)) {
                $gunData['SBTurPzr'] = 1;
            }
        } else {
            $gunData['SBTurPzr'] = 1;
        }
        return $gunData;
    }

    function sqlGunUpdate($gunler = array()) {
        $gunData = array();
        if (in_array("Pzt", $gunler)) {
            $gunData['SBTurPzt'] = 1;

            if (in_array("Sli", $gunler)) {
                $gunData['SBTurSli'] = 1;
            } else {
                $gunData['SBTurSli'] = 0;
            }

            if (in_array("Crs", $gunler)) {
                $gunData['SBTurCrs'] = 1;
            } else {
                $gunData['SBTurCrs'] = 0;
            }

            if (in_array("Prs", $gunler)) {
                $gunData['SBTurPrs'] = 1;
            } else {
                $gunData['SBTurPrs'] = 0;
            }

            if (in_array("Cma", $gunler)) {
                $gunData['SBTurCma'] = 1;
            } else {
                $gunData['SBTurCma'] = 0;
            }

            if (in_array("Cmt", $gunler)) {
                $gunData['SBTurCmt'] = 1;
            } else {
                $gunData['SBTurCmt'] = 0;
            }

            if (in_array("Pzr", $gunler)) {
                $gunData['SBTurPzr'] = 1;
            } else {
                $gunData['SBTurPzr'] = 0;
            }
        } else if (in_array("Sli", $gunler)) {
            $gunData['SBTurPzt'] = 0;
            $gunData['SBTurSli'] = 1;

            if (in_array("Crs", $gunler)) {
                $gunData['SBTurCrs'] = 1;
            } else {
                $gunData['SBTurCrs'] = 0;
            }

            if (in_array("Prs", $gunler)) {
                $gunData['SBTurPrs'] = 1;
            } else {
                $gunData['SBTurPrs'] = 0;
            }

            if (in_array("Cma", $gunler)) {
                $gunData['SBTurCma'] = 1;
            } else {
                $gunData['SBTurCma'] = 0;
            }

            if (in_array("Cmt", $gunler)) {
                $gunData['SBTurCmt'] = 1;
            } else {
                $gunData['SBTurCmt'] = 0;
            }

            if (in_array("Pzr", $gunler)) {
                $gunData['SBTurPzr'] = 1;
            } else {
                $gunData['SBTurPzr'] = 0;
            }
        } else if (in_array("Crs", $gunler)) {
            $gunData['SBTurPzt'] = 0;
            $gunData['SBTurSli'] = 0;
            $gunData['SBTurCrs'] = 1;
            if (in_array("Prs", $gunler)) {
                $gunData['SBTurPrs'] = 1;
            } else {
                $gunData['SBTurPrs'] = 0;
            }

            if (in_array("Cma", $gunler)) {
                $gunData['SBTurCma'] = 1;
            } else {
                $gunData['SBTurCma'] = 0;
            }

            if (in_array("Cmt", $gunler)) {
                $gunData['SBTurCmt'] = 1;
            } else {
                $gunData['SBTurCmt'] = 0;
            }

            if (in_array("Pzr", $gunler)) {
                $gunData['SBTurPzr'] = 1;
            } else {
                $gunData['SBTurPzr'] = 0;
            }
        } else if (in_array("Prs", $gunler)) {
            $gunData['SBTurPzt'] = 0;
            $gunData['SBTurSli'] = 0;
            $gunData['SBTurCrs'] = 0;
            $gunData['SBTurPrs'] = 1;

            if (in_array("Cma", $gunler)) {
                $gunData['SBTurCma'] = 1;
            } else {
                $gunData['SBTurCma'] = 0;
            }

            if (in_array("Cmt", $gunler)) {
                $gunData['SBTurCmt'] = 1;
            } else {
                $gunData['SBTurCmt'] = 0;
            }

            if (in_array("Pzr", $gunler)) {
                $gunData['SBTurPzr'] = 1;
            } else {
                $gunData['SBTurPzr'] = 0;
            }
        } else if (in_array("Cma", $gunler)) {
            $gunData['SBTurPzt'] = 0;
            $gunData['SBTurSli'] = 0;
            $gunData['SBTurCrs'] = 0;
            $gunData['SBTurPrs'] = 0;
            $gunData['SBTurCma'] = 1;
            if (in_array("Cmt", $gunler)) {
                $gunData['SBTurCmt'] = 1;
            } else {
                $gunData['SBTurCmt'] = 0;
            }

            if (in_array("Pzr", $gunler)) {
                $gunData['SBTurPzr'] = 1;
            } else {
                $gunData['SBTurPzr'] = 0;
            }
        } else if (in_array("Cmt", $gunler)) {
            $gunData['SBTurPzt'] = 0;
            $gunData['SBTurSli'] = 0;
            $gunData['SBTurCrs'] = 0;
            $gunData['SBTurPrs'] = 0;
            $gunData['SBTurCma'] = 0;
            $gunData['SBTurCmt'] = 1;
            if (in_array("Pzr", $gunler)) {
                $gunData['SBTurPzr'] = 1;
            } else {
                $gunData['SBTurPzr'] = 0;
            }
        } else {
            $gunData['SBTurPzt'] = 0;
            $gunData['SBTurSli'] = 0;
            $gunData['SBTurCrs'] = 0;
            $gunData['SBTurPrs'] = 0;
            $gunData['SBTurCma'] = 0;
            $gunData['SBTurCmt'] = 0;
            $gunData['SBTurPzr'] = 1;
        }
        return $gunData;
    }

    function gunCevirme($gun) {

        if ($gun == 'Mon') {
            $yeniGun = 'BSPzt';
        } else if ($gun == 'Tue') {
            $yeniGun = 'BSSli';
        } else if ($gun == 'Wed') {
            $yeniGun = 'BSCrs';
        } else if ($gun == 'Thu') {
            $yeniGun = 'BSPrs';
        } else if ($gun == 'Fri') {
            $yeniGun = 'BSCma';
        } else if ($gun == 'Sat') {
            $yeniGun = 'BSCmt';
        } else {
            $yeniGun = 'BSPzr';
        }
        return $yeniGun;
    }

    function calendar($deger = array(), $title = array()) {

        $length = count($deger);
        $b = 0;
        $myarray = [];
        for ($i = 0; $i < $length; $i++) {
            //saat1 için
            $baslangic;
            if (strlen((string) $deger[$i]['Bslngc']) == 1) {
                $baslangic = '00:00';
            } else if (strlen((string) $deger[$i]['Bslngc']) == 2) {
                $baslangic = '00:' . $deger[$i]['Bslngc'];
            } else if (strlen((string) $deger[$i]['Bslngc']) == 3) {
                $ilkHarf1 = substr($deger[$i]['Bslngc'], 0, 1);
                $sondaikiHarf1 = substr($deger[$i]['Bslngc'], 1, 3);
                $baslangic = '0' . $ilkHarf1 . ':' . $sondaikiHarf1;
            } else {
                $ilkikiHarf1 = substr($deger[$i]['Bslngc'], 0, 2);
                $sondaikiHarf1 = substr($deger[$i]['Bslngc'], 2, 4);
                $baslangic = $ilkikiHarf1 . ':' . $sondaikiHarf1;
            }

            $bitis;
            if (strlen((string) $deger[$i]['Bts']) == 1) {
                $bitis = '00:00';
            } else if (strlen((string) $deger[$i]['Bts']) == 2) {
                $bitis = '00:' . $deger[$i]['Bts'];
            } else if (strlen((string) $deger[$i]['Bts']) == 3) {
                $ilkHarf1 = substr($deger[$i]['Bts'], 0, 1);
                $sondaikiHarf1 = substr($deger[$i]['Bts'], 1, 3);
                $bitis = '0' . $ilkHarf1 . ':' . $sondaikiHarf1;
            } else {
                $ilkikiHarf1 = substr($deger[$i]['Bts'], 0, 2);
                $sondaikiHarf1 = substr($deger[$i]['Bts'], 2, 4);
                $bitis = $ilkikiHarf1 . ':' . $sondaikiHarf1;
            }

            if ($deger[$i]['Pzt'] != 0) {//0 sa
                array_push($myarray, array('title' => $title[$i], 'start' => '2015-03-02T' . $baslangic, 'end' => '2015-03-02T' . $bitis));
            }
            if ($deger[$i]['Sli'] != 0) {//0 sa
                array_push($myarray, array('title' => $title[$i], 'start' => '2015-03-03T' . $baslangic, 'end' => '2015-03-03T' . $bitis));
            }
            if ($deger[$i]['Crs'] != 0) {//0 sa
                array_push($myarray, array('title' => $title[$i], 'start' => '2015-03-04T' . $baslangic, 'end' => '2015-03-04T' . $bitis));
            }
            if ($deger[$i]['Prs'] != 0) {//0 sa
                array_push($myarray, array('title' => $title[$i], 'start' => '2015-03-05T' . $baslangic, 'end' => '2015-03-05T' . $bitis));
            }
            if ($deger[$i]['Cma'] != 0) {//0 sa
                array_push($myarray, array('title' => $title[$i], 'start' => '2015-03-06T' . $baslangic, 'end' => '2015-03-06T' . $bitis));
            }
            if ($deger[$i]['Cmt'] != 0) {//0 sa
                array_push($myarray, array('title' => $title[$i], 'start' => '2015-03-07T' . $baslangic, 'end' => '2015-03-07T' . $bitis));
            }
            if ($deger[$i]['Pzr'] != 0) {//0 sas
                array_push($myarray, array('title' => $title[$i], 'start' => '2015-03-08T' . $baslangic, 'end' => '2015-03-08T' . $bitis));
            }
        }
        return $myarray;
    }

    //iki zaman arasıdnaki fark time=12:15
    function get_time_difference($time1, $time2) {
        $time1 = strtotime("1980-01-01 $time1");
        $time2 = strtotime("1980-01-01 $time2");

        if ($time2 < $time1) {
            $time2 += 86400;
        }
        return date("H:i", strtotime("1980-01-01 00:00") + ($time2 - $time1));
    }

    //decimal parayı //1500.00 virgül eçvirme 1,500.00
    function convertDecimal($odemeTutar) {
        $ex = explode(".", $odemeTutar);
        $length = strlen($ex[0]);
        $bas = 1;
        $son = 0;
        for ($l = 0; $l < $length; $l++) {
            if ($son < 3) {
                $odemeValue.=$odemeTutar[$length - $bas];
                $son++;
                $bas++;
            } else {
                $odemeValue.=",";
                $son = 0;
                $l--;
            }
        }
        return strrev($odemeValue) . "." . $ex[1];
    }

    //smtp ile tekli mail controlü yapma
    function mailControl1($validemail) {
        require_once('smtp_validateEmail.class.php');
        // sorgu atacak email. //noreply@floracicek.com
        $sender = 'noreply@shuttleoperator.com';

        $SMTP_Validator = new SMTP_validateEmail();
        $SMTP_Validator->debug = true;
        // valdiation
        $results = $SMTP_Validator->validate(array($validemail), $sender);
        // sonuç
        //echo $email . ' is ' . ($results[$email] ? 'valid' : 'invalid') . "\n";
        // send email? 
        if ($results[$validemail]) {
            return 1;
        } else {
            return 0;
        }
    }

    //smtp ile ikili mail controlü yapma
    function mailControl2($validemail) {
        require_once('smtp_validateEmail.class.php');

        // doğrulanacak email
        $emails = array('user@example.com', 'user2@example.com');
        // sorgu atacak email. //noreply@floracicek.com
        $sender = 'noreply@turkiyefloracicek.com';

        $SMTP_Validator = new SMTP_validateEmail();
        $SMTP_Validator->debug = true;
        // valdiation
        $results = $SMTP_Validator->validate(array($emails), $sender);
        // sonuç
        foreach ($results as $email => $result) {
            // send email? 
            if ($result) {
                //mail($email, 'Confirm Email', 'Please reply to this email to confirm', 'From:'.$sender."\r\n"); // send email
            } else {
                echo 'The email address ' . $email . ' is not valid';
            }
        }
    }

    //smtp ile mail gönderme işlemi
    function sifreHatirlatMail($email, $setTitle, $isim, $subject, $body) {
        require "Plugins/PHPMailer/PHPMailerAutoload.php";
        $mail = new PHPMailer;

        //$mail->SMTPDebug = 2;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->SMTPAuth = true;         // Enable SMTP authentication

        $mail->Host = 'ns1.shuttleoperator.com';  // Specify main and backup SMTP servers
        $mail->Username = 'noreply@shuttleoperator.com';                 // SMTP username
        $mail->Password = '478965Shuttle';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to(ssl ise port 465)

        $mail->setFrom('noreply@turkiyefloracicek.com', $setTitle);
        $mail->addAddress($email, $isim);     // Add a recipient
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body = $body;

        if (!$mail->send()) {
            return 0;
        } else {
            return 1;
        }
    }

    //smtp ile mail gönderme işlemi
    function sSiparisMailGonder($email, $isim, $siparisNo) {
        require "Plugins/PHPMailer/PHPMailerAutoload.php";
        $mail = new PHPMailer;

        //$mail->SMTPDebug = 2;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->SMTPAuth = true;         // Enable SMTP authentication

        $mail->Host = 'ns1.turkiyefloracicek.com';  // Specify main and backup SMTP servers
        $mail->Username = 'siparis@turkiyefloracicek.com';                 // SMTP username
        $mail->Password = '478965Siparis';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to(ssl ise port 465)
        // keeps the current $mail settings and creates new object
        $mail2 = clone $mail;
        $mail->setFrom('siparis@turkiyefloracicek.com', 'Sipariş Sonucu');
        $mail->addAddress($email, $isim);     // Add a recipient
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Türkiye Flora Çiçek - Sipariş';
        $mailBodyKullanici = 'Merhaba ' . $isim . '!<br/> Siparişiniz alınmıştır. Aşağıda verilen sipariş kodu ile <a href="https://www.turkiyefloracicek.com">Türkiye Flora Çiçek</a> adresinden siparişinizin son durumu hakkında bilgi alabilirsiniz.'
                . '<br/><br/>Sipariş Kodunuz : ' . $siparisNo . ' Geri dönmek için aşağıdaki linke tıklayınız.'
                . '<br/><br/>Bir sonraki çiçek gönderiminizde tekrar görüşmek dileğiyle.'
                . '<br/><a href="https://www.turkiyefloracicek.com">Türkiye Flora Çiçek</a>';
        $mail->Body = $mailBodyKullanici;
        if (!$mail->Send()) {
            return 0;
        } else {
            // now send to user.
            $mail2->setFrom('siparis@turkiyefloracicek.com', 'Sipariş Sonucu');
            $mail2->AddAddress("info@turkiyefloracicek.com", $isim);
            $mail2->CharSet = 'UTF-8';
            $mail2->isHTML(true);
            $mail2->Subject = 'Türkiye Flora Çiçek - Yeni Sipariş';
            $mailBodyAdmin = 'Yeni bir sipariş aldınız. <br/>Detayları görmek için aşağıdaki linke tıklayınız. '
                    . '<a href="https://www.turkiyefloracicek.com/Admin/BekleyenSiparis">Türkiye Flora Çiçek Yönetim Paneli</a>';
            $mail2->Body = $mailBodyAdmin;

            if (!$mail2->Send()) {
                return false;
            } else {
                return true;
            }
        }
    }

    //smtp backup önderme işlemi
    function backupDatabase($file) {
        require "Plugins/PHPMailer/PHPMailerAutoload.php";
        $mail = new PHPMailer;
        //$mail->SMTPDebug = 2;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->SMTPAuth = true;         // Enable SMTP authentication

        $mail->Host = 'ns1.turkiyefloracicek.com';  // Specify main and backup SMTP servers
        $mail->Username = 'noreply@turkiyefloracicek.com';                 // SMTP username
        $mail->Password = '478965Flora';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to(ssl ise port 465)
        date_default_timezone_set('Europe/Istanbul');
        $mail->setFrom('noreply@turkiyefloracicek.com', 'Flora Database Yedek');
        $mail->addAddress('info@turkiyefloracicek.com', 'Flora Sql/' . date('d.m.Y H:i:s'));     // Add a recipient
        $mail->addAttachment($file);
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->AddEmbeddedImage("vitrin/logo.png", "logo", "vitrin/logo.png");
        $mail->Subject = 'Türkiye Flora Çiçek - Flora Database Yedek';
        $mail->Body = 'Geri dönmek için aşağıdaki linke tıklayınız.'
                . '<br/><br/><a href="https://www.turkiyefloracicek.com">Türkiye Flora Çiçek</a>'
                . '<br/><br/><br/><img src="cid:logo" alt="Türkiye Flora Çiçek" >';

        if (!$mail->send()) {
            return 0;
        } else {
            return 1;
        }
    }

}

?>