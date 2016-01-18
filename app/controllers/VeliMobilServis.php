<?php

class VeliMobilServis extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->home();
    }

    public function home() {
        if ($_POST) {
            $form = $this->load->otherClasses('Form');
            $form->post("tip", true);
            $tip = $form->values['tip'];

            $form->post("language", true);
            $lang = $form->values['language'];

            $formLanguage = $this->load->mobillanguage($lang);
            $languagedeger = $formLanguage->mobillanguage();

            $form->post('username', true);
            $loginKadi = $form->values['username'];

            if ($loginKadi != '') {

                $formDbConfig = $this->load->otherClasses('DatabaseConfig');
                $usersselect_model = $this->load->model("AdminSelectDb_Mobil");

                $loginfirmaID = $form->substrEnd($loginKadi, 8);
                //return database results
                $UserSelectDb = $usersselect_model->MkullaniciSelectDb($loginfirmaID);
                $SelectdbName = $UserSelectDb[0]['rootFirmaDbName'];
                $SelectdbIp = $UserSelectDb[0]['rootFirmaDbIp'];
                $SelectdbUser = $UserSelectDb[0]['rootFirmaDbUser'];
                $SelectdbPassword = $UserSelectDb[0]['rootFirmaDbSifre'];
                $SelectdbFirmaKod = $UserSelectDb[0]['rootfirmaKodu'];
                $firmaDurum = $UserSelectDb[0]['rootfirmaDurum'];
                if ($firmaDurum != 0) {
                    $formDbConfig->configDb($SelectdbName, $SelectdbIp, $SelectdbUser, $SelectdbPassword);
                    //model bağlantısı
                    $Panel_Model = $this->load->model("Panel_Model_Mobile");

                    Switch ($tip) {
                        case "profilislem":
                            $form->post("id", true);
                            $kid = $form->values['id'];

                            $form->post("enlem", true);
                            $enlem = $form->values['enlem'];

                            $form->post("boylam", true);
                            $boylam = $form->values['boylam'];

                            //bölge html ye username i gönderiyorum
                            $profil['Username'] = $loginKadi;
                            $profil['id'] = $kid;
                            $profil['FirmaId'] = $loginfirmaID;
                            $profil['enlem'] = $enlem;
                            $profil['boylam'] = $boylam;
                            $profil['dil'] = $lang;

                            $result = $Panel_Model->veliProfil($kid);
                            if (count($result) > 0) {
                                foreach ($result as $resultt) {
                                    $profil['Ad'] = $resultt['SBVeliAd'];
                                    $profil['Soyad'] = $resultt['SBVeliSoyad'];
                                    $profil['Kadi'] = $resultt['SBVeliKadi'];
                                    $profil['Phone'] = $resultt['SBVeliPhone'];
                                    $profil['Email'] = $resultt['SBVeliEmail'];
                                    $profil['Adres'] = $resultt['SBVeliDetayAdres'];
                                    $profil['Location'] = $resultt['SBVeliLocation'];
                                }
                            }
                            $this->load->view("Template_Veli/veliprofil", $languagedeger, $profil);

                            break;
                        case "ogrenciislem":
                            $form->post("id", true);
                            $kid = $form->values['id'];

                            $form->post("enlem", true);
                            $enlem = $form->values['enlem'];

                            $form->post("boylam", true);
                            $boylam = $form->values['boylam'];
                            $form->post("android_id", true);
                            $android_id = $form->values['android_id'];

                            //bölge html ye username i gönderiyorum
                            $ogrenci[0][0]['Username'] = $loginKadi;
                            $ogrenci[0][0]['id'] = $kid;
                            $ogrenci[0][0]['FirmaId'] = $loginfirmaID;
                            $ogrenci[0][0]['enlem'] = $enlem;
                            $ogrenci[0][0]['boylam'] = $boylam;
                            $ogrenci[0][0]['dil'] = $lang;
                            $ogrenci[0][0]['android_id'] = $android_id;

                            $resultOgrenciler = $Panel_Model->veliOgrenciler($kid);
                            $o = 0;
                            if (count($resultOgrenciler) > 0) {
                                foreach ($resultOgrenciler as $resultOgrencilerr) {
                                    $ogrenci[1][$o]['ID'] = $resultOgrencilerr['BSOgrenciID'];
                                    $ogrenci[1][$o]['Ad'] = $resultOgrencilerr['BSOgrenciAd'];
                                    $o++;
                                }
                            }
                            $this->load->view("Template_Veli/veliogrenciler", $languagedeger, $ogrenci);

                            break;
                        case "duyuruislem":
                            $form->post("id", true);
                            $kid = $form->values['id'];

                            $form->post("enlem", true);
                            $enlem = $form->values['enlem'];

                            $form->post("boylam", true);
                            $boylam = $form->values['boylam'];

                            //bölge html ye username i gönderiyorum
                            $duyuru['Username'] = $loginKadi;
                            $duyuru['id'] = $kid;
                            $duyuru['FirmaId'] = $loginfirmaID;
                            $duyuru['enlem'] = $enlem;
                            $duyuru['boylam'] = $boylam;
                            $duyuru['dil'] = $lang;

                            $this->load->view("Template_Veli/veliduyuru", $languagedeger, $duyuru);

                            break;
                    }
                } else {
                    $this->load->view("Template_Veli/velinotuse", $languagedeger);
                }
            } else {
                echo 'Are you Hacking?';
            }
        } else {
            echo 'Are you Hacking?';
        }
    }

}
?>

