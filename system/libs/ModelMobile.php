<?php

/*
 * //ana model kullanma sebebi her dosya extends ile bağlanabilsin buna
 * 
 * Burada çoklu database bağlanrısı bulunmaktadır.Kullancağın database i DatabaseConfig.php sınıfında define oalrak tanımlıyoruz.
 * Sonrasında da artık bir defa tanımlandımı her yerden ulaşım sağlanabilemektedir
 */

class ModelMobile {

    protected $db = array();

    //çoklu database
    public function __construct() {

        if (definedbEncryption != 'ShutteBSDb') {
            $dsn = 'mysql:dbname=' . $this->selectDbName . ';host=' . $this->selectDbIp;
            $user = $this->selectDbUser;
            $password = $this->selectDbSifre;
        } else {
            if (definedbEncryption == 'ShutteBSDb') {
                $dsn = 'mysql:dbname=' . selectName . ';host=' . selectDbIp;
                $user = selectDbUser;
                $password = selectDbPassword;
            }
        }
        $this->db = new Database($dsn, $user, $password);
    }

}

?>
