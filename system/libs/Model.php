<?php

/*
 * //ana model kullanma sebebi her dosya extends ile bağlanabilsin buna
 * 
 */

class Model {

    protected $db = array();

    //çoklu database
    public function __construct() {

        if (!isset($_SESSION['selectDbEncryption']) && Session::get('selectDbEncryption') != 'ShutteBSDb') {
            $dsn = 'mysql:dbname=' . $this->selectDbName . ';host=' . $this->selectDbIp;
            $user = $this->selectDbUser;
            $password = $this->selectDbSifre;
        } else {
            if (isset($_SESSION['selectDbEncryption']) && Session::get('selectDbEncryption') == 'ShutteBSDb') {
                $dsn = 'mysql:dbname=' . Session::get('selectDbName') . ';host=' . Session::get('selectDbIp');
                $user = Session::get('selectDbUser');
                $password = Session::get('selectDbPassword');
            } else {
                header("Location:" . SITE_URL_HOME . "/panel");
            }
        }
        $this->db = new Database($dsn, $user, $password);
    }

}

?>
