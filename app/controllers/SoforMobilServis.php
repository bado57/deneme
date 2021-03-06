<?php

class SoforMobilServis extends Controller {

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

                            $result = $Panel_Model->soforProfil($kid);
                            if (count($result) > 0) {
                                foreach ($result as $resultt) {
                                    $profil['Ad'] = $resultt['BSSoforAd'];
                                    $profil['Soyad'] = $resultt['BSSoforSoyad'];
                                    $profil['Kadi'] = $resultt['BSSoforKadi'];
                                    $profil['Phone'] = $resultt['BSSoforPhone'];
                                    $profil['Email'] = $resultt['BSSoforEmail'];
                                    $profil['Adres'] = $resultt['BSSoforDetayAdres'];
                                    $profil['Location'] = $resultt['BSSoforLocation'];
                                }
                            }
                            $this->load->view("Template_Sofor/soforprofil", $languagedeger, $profil);

                            break;
                        case "turislem":
                            $form->post("id", true);
                            $kid = $form->values['id'];

                            $form->post("enlem", true);
                            $enlem = $form->values['enlem'];

                            $form->post("boylam", true);
                            $boylam = $form->values['boylam'];

                            //bölge html ye username i gönderiyorum
                            $tur[0]['Username'] = $loginKadi;
                            $tur[0]['id'] = $kid;
                            $tur[0]['FirmaId'] = $loginfirmaID;
                            $tur[0]['enlem'] = $enlem;
                            $tur[0]['boylam'] = $boylam;
                            $tur[0]['dil'] = $lang;

                            $resultTur = $Panel_Model->soforTurKurum($kid);
                            foreach ($resultTur as $resultTurr) {
                                $turID[] = $resultTurr['BSTurID'];
                            }
                            $soforTurID = implode(',', $turID);

                            $result = $Panel_Model->soforTurKurumlar($soforTurID);
                            if (count($result) > 0) {
                                $a = 0;
                                foreach ($result as $resultt) {
                                    $tur[$a]['Ad'] = $resultt['SBTurAd'];
                                    $tur[$a]['ID'] = $resultt['SBTurID'];
                                    $a++;
                                }
                            }
                            $this->load->view("Template_Sofor/sofortur", $languagedeger, $tur);


                            break;
                        case "aracislem":
                            $form->post("id", true);
                            $kid = $form->values['id'];

                            $form->post("enlem", true);
                            $enlem = $form->values['enlem'];

                            $form->post("boylam", true);
                            $boylam = $form->values['boylam'];

                            //bölge html ye username i gönderiyorum
                            $arac[0]['Username'] = $loginKadi;
                            $arac[0]['id'] = $kid;
                            $arac[0]['FirmaId'] = $loginfirmaID;
                            $arac[0]['enlem'] = $enlem;
                            $arac[0]['boylam'] = $boylam;
                            $arac[0]['dil'] = $lang;


                            $result = $Panel_Model->soforAraclar($kid);
                            if (count($result) > 0) {
                                $a = 0;
                                foreach ($result as $resultt) {
                                    $arac[$a]['ID'] = $resultt['BSAracID'];
                                    $arac[$a]['Plaka'] = $resultt['BSAracPlaka'];
                                    $a++;
                                }
                            }
                            $this->load->view("Template_Sofor/soforarac", $languagedeger, $arac);


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

                            $this->load->view("Template_Sofor/soforduyuru", $languagedeger, $duyuru);

                            break;
                    }
                } else {
                    $this->load->view("Template_Sofor/sofornotuse", $language);
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

