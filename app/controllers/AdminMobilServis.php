<?php

class AdminMobilServis extends Controller {

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
            $language = $form->values['language'];

            $formLanguage = $this->load->multilanguage($language);
            $deger = $formLanguage->multilanguage();

            $form->post('username', true);
            $loginKadi = $form->values['username'];

            if ($loginKadi != '') {

                Switch ($tip) {

                    case "firmaislem":
                        $form->post("rutbe", true);
                        $rutbe = $form->values['rutbe'];

                        $formDbConfig = $this->load->otherClasses('DatabaseConfig');
                        $usersselect_model = $this->load->model("adminselectdb_model");
                        //memcache model bağlanısı
                        $MemcacheModel = $this->load->model("adminmemcache_model");


                        $loginfirmaID = $form->substrEnd($loginKadi, 6);
                        //return database results
                        $UserSelectDb = $usersselect_model->kullaniciSelectDb($loginfirmaID);

                        $SelectdbName = $UserSelectDb[0]['rootFirmaDbName'];
                        $SelectdbIp = $UserSelectDb[0]['rootFirmaDbIp'];
                        $SelectdbUser = $UserSelectDb[0]['rootFirmaDbUser'];
                        $SelectdbPassword = $UserSelectDb[0]['rootFirmaDbSifre'];
                        $SelectdbFirmaKod = $UserSelectDb[0]['rootfirmaKodu'];

                        $formDbConfig->configDb($SelectdbName, $SelectdbIp, $SelectdbUser, $SelectdbPassword);
                        //model bağlantısı
                        $Panel_Model = $this->load->model("panel_model_mobile");

                        $uniqueKey = $SelectdbFirmaKod . '_AFirma';

                        $resultMemcache = $MemcacheModel->get($uniqueKey);
                        if ($resultMemcache) {
                            $sonuc["FirmaOzellikler"] = $resultMemcache;
                        } else {
                            $data["FirmaOzellikler"] = $Panel_Model->MfirmaOzellikler();
                            $returnModelData = $data['FirmaOzellikler'][0];

                            $a = 0;
                            foreach ($returnModelData as $key => $value) {
                                $new_array['Firmasshkey'][$a] = md5(sha1(md5($key)));
                                $a++;
                            }
                            $returnFormdata['FirmaOzellikler'] = $form->newKeys($data['FirmaOzellikler'][0], $new_array['Firmasshkey']);

                            $result = $MemcacheModel->set($uniqueKey, $returnFormdata['FirmaOzellikler'], false, 10);

                            $sonuc["FirmaOzellikler"] = $returnFormdata['FirmaOzellikler'];
                        }



                        $this->load->view("Template_AdminBackEnd/MobileAdmin/adminfirmamobil", $deger, $sonuc["FirmaOzellikler"], $rutbe);
                        break;
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

