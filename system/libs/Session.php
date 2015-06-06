<?php

class Session {

    public static function init() {//başlangıç
        session_start();
        //session oturum idisini tekraradan oluşturuyor.
        session_regenerate_id();
    }

    //get ve set session değişkeni tanımlama ve tanımladığım değişkeni alma şeklinde
    public static function set($key, $val) {
        //istediğim her yerden değer atayabiliyorum
        $_SESSION[$key] = $val;
    }

    public static function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    //kendi uygulamamız için framework oldu
    public static function checkSession() {
        self::init();
        if (self::get("BSShuttlelogin") == false) {
            self::destroy();
            header("Location:" . SITE_URL);
            return false;
        }
    }

    public static function destroy() {
        session_destroy();
    }

}
?>

