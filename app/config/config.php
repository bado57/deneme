<?php

/*
 * Config kısmı genel sabitleri tanımlaya yaramaktadır.Buradan tanımladığımız define ları framework dosyalarımızın
 * istenilen her yerinden ulaşabiliriz.Bu kısma aşağıdaki gibi bir tanımalam yeterli gelecektir.
 */
//sitenin url bilgisi
define("SITE_URL", "http://localhost/SProject");
define("SITE_AD", "Shuttle");
//Dom animator
define("SITE_URL_DOM", "http://localhost/SProject/app/views/assets/js/dom-animator.js");

//notification
define("SITE_NOTIFICATION", "https://api.parse.com/1/push");

//site language
define("SITE_URLLANGUAGE", "http://localhost/SProject/app/language");

//UsersFrontEnd
define("SITE_USERFRONT_CSS", "http://localhost/SProject/app/views/Template_FrontEnd/assets/css");
define("SITE_USERFRONT_JS", "http://localhost/SProject/app/views/Template_FrontEnd/assets/js");
define("SITE_USERFRONT_IMG", "http://localhost/SProject/app/views/Template_FrontEnd/assets/images");
define("SITE_USERFRONT_FONTAWESOME", "http://localhost/SProject/app/views/Template_FrontEnd/assets/font-awesome");

//UsersLogin
define("SITE_URL_LOGIN", "http://localhost/SProject");
define("SITE_URL_LOGINN", "http://localhost/SProject/UsersLogin");

//404
define("SITE_URL404", "http://localhost/SProject/UserIndex/fail");

//script js language
define("SITE_JS_LANGUAGE", "http://localhost/SProject/app/scriptlanguage");

//logout
define("SITE_URL_LOGOUT", "http://localhost/SProject/UsersLogout");

//UsersBackEnd
define("SITE_URL_HOME", "http://localhost/SProject");

//PLUGINS URL
define("SITE_PLUGIN", "http://localhost/SProject/Plugins");
define("SITE_PLUGINFLOGO", "http://localhost/SProject/Plugins/firmlogo/");
//datatable
define("SITE_PLUGINDATATABLE_JS", "http://localhost/SProject/app/views/assets/js/datatable");

//admin back end
define("SITE_PLUGINADMIN", "http://localhost/SProject/AdminWeb/");
define("SITE_PLUGINADMIN_CSS", "http://localhost/SProject/app/views/assets/css");
define("SITE_PLUGINADMIN_FONTS", "http://localhost/SProject/app/views/assets/fonts");
define("SITE_PLUGINADMIN_IMG", "http://localhost/SProject/app/views/assets/img");
define("SITE_PLUGINADMIN_JS", "http://localhost/SProject/app/views/assets/js");
define("SITE_PLUGINADMIN_AjaxJs", "http://localhost/SProject/app/views/Template_AdminBackEnd/js");
define("SITE_PLUGINADMIN_Kurum", "http://localhost/SProject/AdminWeb/kurumliste");
define("SITE_PLUGINADMIN_Tur", "http://localhost/SProject/AdminWeb/turliste");
define("SITE_IMG", "http://localhost/SProject/app/views/assets/img");

//admin mobil 
define("SITE_PLUGINMADMIN_CSS", "http://192.168.1.23/SProject/app/views/Template_AdminBackEnd/MobileAdmin/css");
define("SITE_PLUGIN_MCSS", "http://192.168.1.23/SProject/app/views/Template_AdminBackEnd/MobileAdmin/css");
define("SITE_PLUGINMADMIN_FONTS", "http://192.168.1.23/SProject/app/views/Template_AdminBackEnd/MobileAdmin/font-awesome");
define("SITE_PLUGINMADMIN_JS", "http://192.168.1.23/SProject/app/views/Template_AdminBackEnd/MobileAdmin/js");
define("SITE_PLUGINM_JS", "http://192.168.1.23/SProject/app/views/assets/js");
define("MLANGUAGE_JS", "http://192.168.1.23/SProject/app/mobilscriptlanguage/");
define("SITE_PLUGINMADMIN_AjaxJs", "http://192.168.1.23/SProject/app/views/Template_AdminBackEnd/MobileAdmin/js");
define("SITE_MPLUGIN_JS", "http://192.168.1.23/SProject/app/views/assets/js");
define("SITE_MPLUGIN_CSS", "http://192.168.1.23/SProject/app/views/assets/css");
define("SITE_MIMG", "http://192.168.1.23/SProject/app/views/assets/img");
//veli back end
define("SITE_PLUGINMVELI_CSS", "http://192.168.1.23/SProject/app/views/Template_Veli/css");
define("SITE_PLUGINMVELI_JS", "http://192.168.1.23/SProject/app/views/Template_Veli/js");
//öğrenci back end
define("SITE_PLUGINMOGR_CSS", "http://192.168.1.23/SProject/app/views/Template_Ogrenci/css");
define("SITE_PLUGINMOGR_JS", "http://192.168.1.23/SProject/app/views/Template_Ogrenci/js");
//şoför back end
define("SITE_PLUGINMSOFOR_CSS", "http://192.168.1.23/SProject/app/views/Template_Sofor/css");
define("SITE_PLUGINMSOFOR_JS", "http://192.168.1.23/SProject/app/views/Template_Sofor/js");
//işci back end
?>