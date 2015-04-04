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


            //db ye  bağlanma
            $form->post("firmId", true);
            $firmId = $form->values['firmId'];

            $formDbConfig = $this->load->otherClasses('DatabaseConfig');
            $usersselect_model = $this->load->model("adminselectdb_mobil");


            //return database results
            $UserSelectDb = $usersselect_model->adminFirmMobilID($firmId);

            $SelectdbName = $UserSelectDb[0]['rootFirmaDbName'];
            $SelectdbIp = $UserSelectDb[0]['rootFirmaDbIp'];
            $SelectdbUser = $UserSelectDb[0]['rootFirmaDbUser'];
            $SelectdbPassword = $UserSelectDb[0]['rootFirmaDbSifre'];


            $formDbConfig->configDb($SelectdbName, $SelectdbIp, $SelectdbUser, $SelectdbPassword);


            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model_mobile");

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

                case "adminBolgeYeniKaydet":

                    $form->post('rutbe', true);
                    $adminRutbe = $form->values['rutbe'];

                    if ($adminRutbe != 1) {
                        Session::destroy();
                        header("Location:" . SITE_URL);
                    } else {
                        $form->post('username', true);
                        $uniqueKey = $form->values['username'];
                        $uniqueKey = $uniqueKey . '_AFirma';
                        $form->post('id', true);
                        $adminID = $form->values['id'];


                        $form->post('bolge_adi', true);
                        $form->post('bolge_aciklama', true);

                        if ($form->submit()) {
                            $data = array(
                                'SBBolgeAdi' => $form->values['bolge_adi'],
                                'SBBolgeAciklama' => $form->values['bolge_aciklama']
                            );
                        }


                        $resultuID = $Panel_Model->MaddNewAdminBolge($data);

                        if ($resultuID) {
                            $dataID = array(
                                'BSAdminID' => $adminID,
                                'BSBolgeID' => $resultuID
                            );
                            $resultIDD = $Panel_Model->MaddAdminBolge($dataID);
                            if ($resultIDD) {
                                $resultMemcache = $MemcacheModel->get($uniqueKey);
                                if ($resultMemcache) {
                                    $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                }
                                $sonuc["newBolgeID"] = $resultIDD;
                                $sonuc["insert"] = "Başarıyla Yeni bölge Eklenmiştir.";
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    break;

                case "adminBolgeDetail":

                    $form->post('rutbe', true);
                    $adminRutbe = $form->values['rutbe'];

                    if ($adminRutbe != 1) {
                        Session::destroy();
                        header("Location:" . SITE_URL);
                    } else {

                        $form->post('adminbolgeRowid', true);
                        $adminBolgeDetailID = $form->values['adminbolgeRowid'];

                        $data["adminBolgeDetail"] = $Panel_Model->MadminBolgeDetail($adminBolgeDetailID);

                        $returnModelData = $data["adminBolgeDetail"][0];

                        $a = 0;
                        foreach ($returnModelData as $key => $value) {
                            $new_array['AdminBolgesshkey'][$a] = md5(sha1(md5($key)));
                            $a++;
                        }

                        $returnFormdata['adminBolgeDetail'] = $form->newKeys($data["adminBolgeDetail"][0], $new_array['AdminBolgesshkey']);


                        $data["adminBolgeKurumDetail"] = $Panel_Model->MadminBolgeKurumDetail($adminBolgeDetailID);

                        for ($kurum = 0; $kurum < count($data["adminBolgeKurumDetail"]); $kurum++) {
                            $data["adminBolgeKurum"][$kurum] = array_values($data["adminBolgeKurumDetail"][$kurum]);
                        }

                        $sonuc["adminBolgeDetail"] = $returnFormdata['adminBolgeDetail'];
                        $sonuc["adminBolgeKurumDetail"] = $data["adminBolgeKurum"];
                    }

                    break;

                case "adminBolgeDetailDuzenle":

                    $form->post('rutbe', true);
                    $adminRutbe = $form->values['rutbe'];

                    if ($adminRutbe != 1) {
                        Session::destroy();
                        header("Location:" . SITE_URL);
                    } else {
                        $form->post('username', true);
                        $uniqueKey = $form->values['username'];
                        $uniqueKey = $uniqueKey . '_ABolge';

                        $form->post('bolgedetail_adi', true);
                        $form->post('bolgedetail_aciklama', true);
                        $form->post('bolgedetail_id', true);
                        $adminBolgeDetailID = $form->values['bolgedetail_id'];

                        if ($form->submit()) {
                            $data = array(
                                'SBBolgeAdi' => $form->values['bolgedetail_adi'],
                                'SBBolgeAciklama' => $form->values['bolgedetail_aciklama']
                            );
                        }

                        $resultupdate = $Panel_Model->MadminBolgeOzelliklerDuzenle($data, $adminBolgeDetailID);
                        if ($resultupdate) {
                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                            if ($resultMemcache) {
                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                            }
                            $sonuc["update"] = "Başarıyla Bölgeniz Güncellenmiştir.";
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    break;

                case "adminBolgeDetailDelete":

                    $form->post('rutbe', true);
                    $adminRutbe = $form->values['rutbe'];

                    if ($adminRutbe != 1) {
                        Session::destroy();
                        header("Location:" . SITE_URL);
                    } else {

                        $form->post('username', true);
                        $uniqueKey = $form->values['username'];
                        $uniqueKey = $uniqueKey . '_ABolge';

                        $form->post('bolgedetail_id', true);
                        $adminBolgeDetailID = $form->values['bolgedetail_id'];

                        $deleteresult = $Panel_Model->MadminBolgeDelete($adminBolgeDetailID);
                        if ($deleteresult) {
                            $resultdelete = $Panel_Model->MadminBolgeIDDelete($adminBolgeDetailID);
                            if ($resultdelete) {
                                $resultMemcache = $MemcacheModel->get($uniqueKey);
                                if ($resultMemcache) {
                                    $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                }
                                $sonuc["delete"] = "Bölge kaydı başarıyla silinmiştir.";
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }


                        $sonuc["adminBolgeDetail"] = $data["adminBolgeDetail"];
                    }

                    break;

                case "adminBolgeKurumKaydet":

                    $form->post('rutbe', true);
                    $adminRutbe = $form->values['rutbe'];

                    if ($adminRutbe != 1) {
                        Session::destroy();
                        header("Location:" . SITE_URL);
                    } else {

                        $form->post('username', true);
                        $uniqueKey = $form->values['username'];
                        $uniqueKey = $uniqueKey . '_ABolge';

                        $form->post('bolgeid', true);
                        $form->post('bolgead', true);
                        $form->post('bolgkurumadi', true);
                        $form->post('bolgkurumTlfn', true);
                        $form->post('bolgkurumEmail', true);
                        $form->post('bolgkurumwebsite', true);
                        $form->post('bolgkurumadrsDty', true);
                        $form->post('bolgkurumaciklama', true);
                        $form->post('bolgkurumulke', true);
                        $form->post('bolgkurumil', true);
                        $form->post('bolgkurumilce', true);
                        $form->post('bolgkurumsemt', true);
                        $form->post('bolgkurummahalle', true);
                        $form->post('bolgkurumsokak', true);
                        $form->post('bolgkurumpostakodu', true);
                        $form->post('bolgkurumcaddeno', true);
                        $form->post('bolgkurumlocation', true);

                        if ($form->submit()) {
                            $data = array(
                                'SBKurumAdi' => $form->values['bolgkurumadi'],
                                'SBKurumAciklama' => $form->values['bolgkurumaciklama'],
                                'SBBolgeID' => $form->values['bolgeid'],
                                'SBBolgeAdi' => $form->values['bolgead'],
                                'SBKurumUlke' => $form->values['bolgkurumulke'],
                                'SBKurumIl' => $form->values['bolgkurumil'],
                                'SBKurumIlce' => $form->values['bolgkurumilce'],
                                'SBKurumSemt' => $form->values['bolgkurumsemt'],
                                'SBKurumMahalle' => $form->values['bolgkurummahalle'],
                                'SBKurumSokak' => $form->values['bolgkurumsokak'],
                                'SBKurumLokasyon' => $form->values['bolgkurumlocation'],
                                'SBKurumTelefon' => $form->values['bolgkurumTlfn'],
                                'SBKurumAdres' => $form->values['bolgkurumadrsDty'],
                                'SBKurumEmail' => $form->values['bolgkurumEmail'],
                                'SBKurumWebsite' => $form->values['bolgkurumwebsite'],
                                'SBKurumPostaKodu' => $form->values['bolgkurumpostakodu'],
                                'SBKurumCaddeNo' => $form->values['bolgkurumcaddeno']
                            );
                        }

                        $resultKurumID = $Panel_Model->MaddNewAdminBolgeKurum($data);

                        if ($resultKurumID) {
                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                            if ($resultMemcache) {
                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                            }
                            $sonuc["newBolgeKurumID"] = $resultKurumID;
                            $sonuc["insert"] = "Başarıyla Bölgenize yeni Kurum Eklenmiştir.";
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
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

