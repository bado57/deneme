<?php

class AdminAjaxSorguMobil extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->adminAjaxSorguMobil();
    }

    public function adminAjaxSorguMobil() {

        if ($_POST) {
            $sonuc = array();

            $form = $this->load->otherClasses('Form');

            $MemcacheModel = $this->load->model("adminmemcache_model");

            $form->post("tip", true);
            $tip = $form->values['tip'];

            Switch ($tip) {

                case "adminFirmaIslemlerKaydet":

                    $form->post("firma_kod", true);
                    $firma_kod = $form->values['firma_kod'];
                    
                    $formDbConfig = $this->load->otherClasses('DatabaseConfig');
                    $usersselect_model = $this->load->model("adminselectdb_mobil");
                    

                    //return database results
                    $UserSelectDb = $usersselect_model->adminFirmMobil($firma_kod);

                    $SelectdbName = $UserSelectDb[0]['rootFirmaDbName'];
                    $SelectdbIp = $UserSelectDb[0]['rootFirmaDbIp'];
                    $SelectdbUser = $UserSelectDb[0]['rootFirmaDbUser'];
                    $SelectdbPassword = $UserSelectDb[0]['rootFirmaDbSifre'];
                    

                    $formDbConfig->configDb($SelectdbName, $SelectdbIp, $SelectdbUser, $SelectdbPassword);

                    $form->post('firma_adi', true);
                    $form->post('firma_aciklama', true);
                    $form->post('ogrenci_chechkbox', true);
                    $form->post('personel_chechkbox', true);
                    $form->post('firma_adres', true);
                    $form->post('firma_telefon', true);
                    $form->post('firma_email', true);
                    $form->post('firma_website', true);
                    $form->post('firma_lokasyon', true);

                    if ($form->submit()) {
                        $data = array(
                            'BSFirmaAdi' => $form->values['firma_adi'],
                            'BSFirmaAdres' => $form->values['firma_adres'],
                            'BSFirmaTelefon' => $form->values['firma_telefon'],
                            'BSFirmaWebsite' => $form->values['firma_website'],
                            'BSFirmaEmail' => $form->values['firma_email'],
                            'BSFirmaLokasyon' => $form->values['firma_lokasyon'],
                            'BSFirmaAciklama' => $form->values['firma_aciklama'],
                            'BSOgrenciServis' => $form->values['ogrenci_chechkbox'],
                            'BSPersonelServis' => $form->values['personel_chechkbox'],
                            'BSHesapAktif' => $form->values['hesap_aktif']
                        );
                    }

                    //model bağlantısı
                    $Panel_Model = $this->load->model("panel_model_mobile");

                    //error_log("Firma Id".$data["FirmaListele"][0]["FirmaID"]);
                    $resultupdate = $Panel_Model->MfirmaOzelliklerDuzenle($data);

                    //memcache kadetmek için verileri üncellemeden sonra tekrar çekiyoruz.
                    $data["FirmaOzellikler"] = $Panel_Model->MfirmaOzellikler();


                    $returnModelData = $data['FirmaOzellikler'][0];

                    $a = 0;
                    foreach ($returnModelData as $key => $value) {
                        $new_array['Firmasshkey'][$a] = md5(sha1(md5($key)));
                        $a++;
                    }
                    $returnFormdata['FirmaOzellikler'] = $form->newKeys($data['FirmaOzellikler'][0], $new_array['Firmasshkey']);

                    //Memcache model
                    $uniqueKey = $firma_kod . '_AFirma';

                    if ($resultupdate) {
                        $resultMemcache = $MemcacheModel->get($uniqueKey);

                        if ($resultMemcache) {
                            $MemcacheModel->replace($uniqueKey, $returnFormdata['FirmaOzellikler'], false, 10);
                        } else {
                            $result = $MemcacheModel->set($uniqueKey, $returnFormdata['FirmaOzellikler'], false, 10);
                        }
                        $sonuc["update"] = "Başarıyla güncellenmiştir";
                    } else {
                        $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                    }

                    break;
            }
            echo json_encode($sonuc);
        } else {
            die("Hacklemeye mi Çalışıyorsun pezevenk?");
        }
    }

}
?>

