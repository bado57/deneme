<?php

class AdminAjaxSorgu extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->adminAjaxSorgu();
    }

    public function adminAjaxSorgu() {
        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');
        $sessionKey = $form->sessionKontrol();

        if ($_POST && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" && Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey) {
            $sonuc = array();
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            //form class bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");

            $form->post("tip", true);
            $tip = $form->values['tip'];

            Switch ($tip) {

                case "adminfirmaislem":
                    $data = $form->post('usersloginadi', true);
                    $data = $form->post('usersloginsifre', true);
                    $data = $form->post('usersloginselect', true);
                    if ($form->submit()) {
                        $data = array(
                            ':usersloginadi' => $form->values['usersloginadi'],
                            ':usersloginsifre' => $form->values['usersloginsifre'],
                            ':usersloginselect' => $form->values['usersloginselect']
                        );
                    }
                    $data["UsersLogin"] = $Panel_Model->susersLogin();
                    $sonuc["usersLogin"] = $data["UsersLogin"];
                    break;

                case "adminFirmaIslemlerKaydet":

                    $uniqueKey = Session::get("userFirmaKod");
                    $uniqueKey = $uniqueKey . '_AFirma';

                    $form->post('firma_adi', true);
                    $form->post('firma_aciklama', true);
                    $form->post('ogrenci_chechkbox', true);
                    $form->post('personel_chechkbox', true);
                    $form->post('firma_adres', true);
                    $form->post('firma_telefon', true);
                    $form->post('firma_email', true);
                    $form->post('firma_website', true);
                    $form->post('firma_lokasyon', true);
                    error_log("datakod" . $form->values['firma_kod']);

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
                    $resultupdate = $Panel_Model->firmaOzelliklerDuzenle($data);

                    //memcache kadetmek için verileri üncellemeden sonra tekrar çekiyoruz.
                    $data["FirmaOzellikler"] = $Panel_Model->firmaOzellikler();


                    $returnModelData = $data['FirmaOzellikler'][0];

                    $a = 0;
                    foreach ($returnModelData as $key => $value) {
                        $new_array['Firmasshkey'][$a] = md5(sha1(md5($key)));
                        $a++;
                    }
                    $returnFormdata['FirmaOzellikler'] = $form->newKeys($data['FirmaOzellikler'][0], $new_array['Firmasshkey']);


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

                    $adminID = Session::get("userId");
                    $adminRutbe = Session::get("userRutbe");
                    $uniqueKey = Session::get("username");
                    $uniqueKey = $uniqueKey . '_ABolge';

                    if ($adminRutbe != 1) {
                        Session::destroy();
                        header("Location:" . SITE_URL);
                    } else {

                        $form->post('bolge_adi', true);
                        $form->post('bolge_aciklama', true);

                        if ($form->submit()) {
                            $data = array(
                                'SBBolgeAdi' => $form->values['bolge_adi'],
                                'SBBolgeAciklama' => $form->values['bolge_aciklama']
                            );
                        }

                        $resultuID = $Panel_Model->addNewAdminBolge($data);

                        if ($resultuID) {
                            $dataID = array(
                                'BSAdminID' => $adminID,
                                'BSBolgeID' => $resultuID
                            );
                            $resultIDD = $Panel_Model->addAdminBolge($dataID);
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

                    //$data["FirmaOzellikler"] = $Panel_Model->firmaOzellikler();

                    break;

                case "adminBolgeDetail":

                    $adminRutbe = Session::get("userRutbe");

                    if ($adminRutbe != 1) {
                        Session::destroy();
                        header("Location:" . SITE_URL);
                    } else {

                        $form->post('adminbolgeRowid', true);
                        $adminBolgeDetailID = $form->values['adminbolgeRowid'];

                        $data["adminBolgeDetail"] = $Panel_Model->adminBolgeDetail($adminBolgeDetailID);

                        $returnModelData = $data["adminBolgeDetail"][0];

                        $a = 0;
                        foreach ($returnModelData as $key => $value) {
                            $new_array['AdminBolgesshkey'][$a] = md5(sha1(md5($key)));
                            $a++;
                        }

                        $returnFormdata['adminBolgeDetail'] = $form->newKeys($data["adminBolgeDetail"][0], $new_array['AdminBolgesshkey']);


                        $data["adminBolgeKurumDetail"] = $Panel_Model->adminBolgeKurumDetail($adminBolgeDetailID);

                        for ($kurum = 0; $kurum < count($data["adminBolgeKurumDetail"]); $kurum++) {
                            $data["adminBolgeKurum"][$kurum] = array_values($data["adminBolgeKurumDetail"][$kurum]);
                        }

                        $sonuc["adminBolgeDetail"] = $returnFormdata['adminBolgeDetail'];
                        $sonuc["adminBolgeKurumDetail"] = $data["adminBolgeKurum"];
                    }

                    break;

                case "adminBolgeDetailDuzenle":

                    $adminRutbe = Session::get("userRutbe");

                    if ($adminRutbe != 1) {
                        Session::destroy();
                        header("Location:" . SITE_URL);
                    } else {

                        $uniqueKey = Session::get("username");
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

                        $resultupdate = $Panel_Model->adminBolgeOzelliklerDuzenle($data, $adminBolgeDetailID);
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

                    $adminRutbe = Session::get("userRutbe");

                    if ($adminRutbe != 1) {
                        Session::destroy();
                        header("Location:" . SITE_URL);
                    } else {

                        $form->post('bolgedetail_id', true);
                        $adminBolgeDetailID = $form->values['bolgedetail_id'];

                        $deleteresult = $Panel_Model->adminBolgeDelete($adminBolgeDetailID);
                        if ($deleteresult) {
                            $resultdelete = $Panel_Model->adminBolgeIDDelete($adminBolgeDetailID);
                            if ($resultdelete) {
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

                case "gayri_proje_ekle":
                    $form->post('projeekle_kodu', true)
                            ->isEmpty();
                    $form->post('projeekle_durum', true);
                    $form->post('projeekle_adi', true)
                            ->isEmpty();
                    $date = $form->post('projeekle_bas_tarih', true)
                            ->tarihduzenle();
                    $date1 = $form->post('projeekle_bitis_tarih', true)
                            ->tarihduzenle();
                    $form->post('projeekle_textarea', true);
                    $form->post('projekytkydtkpt', true);
                    if ($form->submit()) {
                        $data = array(
                            'insaat_proje_kodu' => $form->values['projeekle_kodu'],
                            'insaat_proje_adi' => $form->values['projeekle_adi'],
                            'insaat_proje_durum' => $form->values['projeekle_durum'],
                            'insaat_proje_bas_tarih' => $date,
                            'insaat_proje_bitis_tarih' => $date1,
                            'insaat_proje_mesaj' => $form->values['projeekle_textarea']
                        );
                        $gelenlabel = $form->values['projekytkydtkpt'];
                        if ($gelenlabel == "") {
                            $model = $this->load->model("panel_model");
                            $result = $model->addNewProjectInsert($data);
                            if ($result) {
                                $sonuc["proje_son_id"] = $result;
                            } else {
                                $sonuc = "Bi Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                //$sonuc["Id"]=$Idresult;
                            }
                        } else {
                            $model = $this->load->model("panel_model");
                            $resultupdate = $model->updateNewProject($data, $gelenlabel);
                            if ($resultupdate) {
                                $sonuc["proje_update"] = "Başarıyla güncellenmiştir";
                            } else {
                                $sonuc = "Bi Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        }
                    }
                    break;

                case "projeSiteKayit":
                    $dizi = array();
                    $dizi_sayi = array();
                    $form->post('projekayitSonId', true)
                            ->isEmpty();
                    $form->post('yapiekle_adi', true)
                            ->isEmpty();
                    $form->post('yapiekle_sayi', true)
                            ->isEmpty();
                    $form->post('yapiekle_tipi', true)
                            ->isEmpty();
                    $form->post('yapiekle_textarea', true);
                    $form->post('blokkytkydtkpt', true);
                    if ($form->submit()) {
                        $data = array(
                            'insaat_yapi_proje' => $form->values['projekayitSonId'],
                            'insaat_proje_yapi_adi' => $form->values['yapiekle_adi'],
                            'insaat_proje_yapi_sayi' => $form->values['yapiekle_sayi'],
                            'insaat_proje_yapi_tip' => $form->values['yapiekle_tipi'],
                            'insaat_proje_yapi_metin' => $form->values['yapiekle_textarea']
                        );
                        $gelenlabelblok = $form->values['blokkytkydtkpt'];
                        if ($gelenlabelblok == "") {
                            $model = $this->load->model("panel_model");
                            $result = $model->addNewProjectBuildingInsert($data);
                            if ($result) {
                                $son = $form->dizipost('blok_adi', true);
                                $donen = $form->values['blok_adi'];

                                $sonsayi = $form->dizipost('blok_sayi', true);
                                $donensayi = $form->values['blok_sayi'];

                                $toplam = $form->count($donen);
                                for ($i = 0; $i < $toplam; $i++) {
                                    $gecici = array_push($dizi, $donen[$i]);
                                    $gecici_sayi = array_push($dizi_sayi, $donensayi[$i]);

                                    $data = array(
                                        'insaat_proje_yapi_blok_adi' => $dizi[$i],
                                        'insaat_proje_yapi_blok_sayi' => $dizi_sayi[$i],
                                        'insaat_proje_yapi_id' => $result
                                    );
                                    $resultt = $model->addBuildingInsert($data);
                                    if ($resultt) {
                                        $sonuc["proje_yapi_label_id"] = $result;
                                        $sonuc["projeKonutBasari"] = "Başarıyla kaydınız tamamlanmıştır.";
                                    } else {
                                        $sonuc["hata"] = "Lütfent tekrar deneyiniz.";
                                    }
                                }
                            } else {
                                $sonuc = "Bi Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        } else {
                            $model = $this->load->model("panel_model");
                            $resultupdatelabel = $model->updateNewBlokProject($data, $gelenlabelblok);

                            if ($resultupdatelabel) {
                                $sonucum = $model->addBuildingDelete($gelenlabelblok);
                                if ($sonucum) {

                                    $son = $form->dizipost('blok_adi', true);
                                    $donen = $form->values['blok_adi'];

                                    $sonsayi = $form->dizipost('blok_sayi', true);
                                    $donensayi = $form->values['blok_sayi'];

                                    $toplam = $form->count($donen);
                                    for ($i = 0; $i < $toplam; $i++) {
                                        $gecici = array_push($dizi, $donen[$i]);
                                        $gecici_sayi = array_push($dizi_sayi, $donensayi[$i]);

                                        $data = array(
                                            'insaat_proje_yapi_blok_adi' => $dizi[$i],
                                            'insaat_proje_yapi_blok_sayi' => $dizi_sayi[$i],
                                            'insaat_proje_yapi_id' => $gelenlabelblok
                                        );
                                        $resultt = $model->addBuildingUpdateInsert($data, $gelenlabelblok);
                                        if ($resultt) {
                                            $sonuc["proje_yapi_label_id"] = $gelenlabelblok;
                                            $sonuc["projeKonutBasariUpdate"] = "Başarıyla güncelleştirmeniz tamamlanmıştır.";
                                        } else {
                                            $sonuc["hata"] = "Lütfent tekrar deneyiniz.";
                                        }
                                    }
                                } else {
                                    $sonuc["hata"] = "Bir hata oluştu";
                                }
                            } else {
                                $sonuc = "Bi Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        }
                    }

                    break;

                case "proje_il_option":
                    $PIlOption = $this->load->model("panel_model");
                    $data["projeIlListele"] = $PIlOption->projeIlListele();
                    $sonuc["projeIlListele"] = $data["projeIlListele"];

                    break;
                case "proje_ilce_option":

                    $data = $form->post('proje_il_id', true);
                    if ($form->submit()) {
                        $data = array(
                            ':proje_il_id' => $form->values['proje_il_id']
                        );
                    }
                    $projeIlceListele = $this->load->model("panel_model");
                    $data["projeIlceListele"] = $projeIlceListele->projeIlceListele($data);
                    $sonuc["projeIlceListele"] = $data["projeIlceListele"];
                    break;

                case "proje_Semt_Option":

                    $data = $form->post('proje_ilce_id', true);
                    if ($form->submit()) {
                        $data = array(
                            ':proje_ilce_id' => $form->values['proje_ilce_id']
                        );
                    }
                    $projeSemtListele = $this->load->model("panel_model");
                    $data["projeSemtListele"] = $projeSemtListele->projeSemtListele($data);
                    $sonuc["projeSemtListele"] = $data["projeSemtListele"];
                    break;

                case "proje_Mahalle_Option":

                    $data = $form->post('proje_semt_id', true);
                    if ($form->submit()) {
                        $data = array(
                            ':proje_semt_id' => $form->values['proje_semt_id']
                        );
                    }
                    $projeMahalleListele = $this->load->model("panel_model");
                    $data["projeMahalleListele"] = $projeMahalleListele->projeMahalleListele($data);
                    $sonuc["projeMahalleListele"] = $data["projeMahalleListele"];
                    break;

                case "proje_PostaKodu_Option":

                    $data = $form->post('proje_mahalle_id', true);
                    if ($form->submit()) {
                        $data = array(
                            ':proje_mahalle_id' => $form->values['proje_mahalle_id']
                        );
                    }
                    $projePostaKoduGoster = $this->load->model("panel_model");
                    $data["projePostaKoduGoster"] = $projePostaKoduGoster->projePostaKoduGoster($data);
                    $sonuc["projePostaKoduGoster"] = $data["projePostaKoduGoster"];
                    break;

                case "projeAdres_Deger":
                    $form->post('projeadres_il', true);
                    $form->post('projeadres_ilce', true);
                    $form->post('projeadres_semt', true);
                    $form->post('projeadres_mahalle', true);
                    $form->post('projeadres_postaKodu', true);
                    $form->post('projeadres_Adres', true);
                    $form->post('projeAdres_proje_id', true);
                    $form->post('projekayitAdres_label', true);
                    if ($form->submit()) {
                        $data = array(
                            'insaat_proje_yapi_il' => $form->values['projeadres_il'],
                            'insaat_proje_yapi_ilce' => $form->values['projeadres_ilce'],
                            'insaat_proje_yapi_semt' => $form->values['projeadres_semt'],
                            'insaat_proje_yapi_mahalle' => $form->values['projeadres_mahalle'],
                            'insaat_proje_yapi_Pkodu' => $form->values['projeadres_postaKodu'],
                            'insaat_proje_yapi_adres' => $form->values['projeadres_Adres'],
                            'insaat_proje_yapi_id' => $form->values['projeAdres_proje_id']
                        );
                        $projekayitAdres_label = $form->values['projekayitAdres_label'];
                        if ($projekayitAdres_label == "") {
                            $model = $this->load->model("panel_model");
                            $result = $model->addNewProjectAdressInsert($data);

                            if ($result) {
                                $sonuc["Adreslabel_id"] = $result;
                                $sonuc["adres_basari"] = "Proje Adresiniz başarıyla eklenmiştir.";
                            } else {
                                $sonuc["hata"] = "Bi Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                //$sonuc["Id"]=$Idresult;
                            }
                        } else {
                            $model = $this->load->model("panel_model");
                            $result = $model->updateProjectAdressInsert($data, $projekayitAdres_label);
                            if ($result) {
                                $sonuc["Adreslabel_id"] = $result;
                                $sonuc["adres_basari"] = "Proje Adresiniz başarıyla güncellenmiştir.";
                            } else {
                                $sonuc["hata"] = "Bi Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                //$sonuc["Id"]=$Idresult;
                            }
                        }
                    }

                    break;

                case "ProjeModalDetayIconId":
                    $data = $form->post('projeModalDtyID', true);
                    if ($form->submit()) {
                        $data = array(
                            ':projeModalDtyID' => $form->values['projeModalDtyID']
                        );
                    }
                    $projeModalDetayIcon = $this->load->model("panel_model");
                    $data["projeModalDetayIcons"] = $projeModalDetayIcon->projeModalDetayIcon($data);
                    $sonuc["projeModalDetayIcons"] = $data["projeModalDetayIcons"];
                    break;
            }
            echo json_encode($sonuc);
        } else {
            die("Hacklemeye mi Çalışıyorsun pezevenk?");
        }
    }

}
?>

