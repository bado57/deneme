<?php

class AdminAjaxSorgu extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->adminAjaxSorgu();
    }

    public function adminAjaxSorgu() {


        if ($_POST && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") {
            $sonuc = array();
            $form = $this->load->otherClasses('Form');
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
                    $Suserslogin = $this->load->model("panel_model");
                    $data["UsersLogin"] = $Suserslogin->susersLogin();
                    $sonuc["usersLogin"] = $data["UsersLogin"];
                    break;

                case "adminFirmaIslemler":
                    $AdminId = Session::get("userId");
                    $Pkayit_model = $this->load->model("panel_model");
                    $data["AdminFirmaID"] = $Pkayit_model->adminFirmaID($AdminId);
                    //error_log("Firma Id".$data["FirmaListele"][0]["FirmaID"]);
                    $data["FirmaOzellikler"] = $Pkayit_model->firmaOzellikler($data["AdminFirmaID"][0]["FirmaID"]);
                    $sonuc["FirmaOzellikler"] = $data["FirmaOzellikler"];
                    break;

                case "adminFirmaIslemlerKaydet":
                    $AdminId = Session::get("userId");
                    $Pkayit_model = $this->load->model("panel_model");
                    $dataID["AdminFirmaID"] = $Pkayit_model->adminFirmaID($AdminId);
                    
                    $form->post('firma_kod', true);
                    $form->post('firma_adi', true);
                    $form->post('firma_aciklama', true);
                    $form->post('firma_durum', true);
                    $form->post('ogrenci_chechkbox', true);
                    $form->post('personel_chechkbox', true);
                    $form->post('firma_adres', true);
                    $form->post('firma_telefon', true);
                    $form->post('firma_email', true);
                    $form->post('firma_website', true);
                    $form->post('firma_lokasyon', true);
                    error_log("datakod".$form->values['firma_kod']);

                    if ($form->submit()) {
                        $data = array(
                            'FirmaKodu' => $form->values['firma_kod'],
                            'FirmaAdi' => $form->values['firma_adi'],
                            'FirmaAdres' => $form->values['firma_adres'],
                            'FirmaTelefon' => $form->values['firma_telefon'],
                            'FirmaWebsite' => $form->values['firma_website'],
                            'FirmaLokasyon' => $form->values['firma_lokasyon'],
                            'FirmaAciklama' => $form->values['firma_aciklama'],
                            'FirmaDurum' => $form->values['firma_durum'],
                            'OgrenciServis' => $form->values['ogrenci_chechkbox'],
                            'PersonelServis' => $form->values['personel_chechkbox'],
                            'HesapAktif' => $form->values['hesap_aktif']
                        );
                    }
                    
                    //error_log("Firma Id".$data["FirmaListele"][0]["FirmaID"]);
                    $resultupdate = $Pkayit_model->firmaOzelliklerDuzenle($data, $dataID["AdminFirmaID"][0]["FirmaID"]);
                    if ($resultupdate) {
                        $sonuc["firmaozellik_update"] = "Başarıyla güncellenmiştir";
                    } else {
                        $sonuc["hata"] = "Bi Hata Oluştu Lütfen Tekrar Deneyiniz.";
                    }

                    break;

                case "gayri_benzersiz_deger_kodu":
                    $data = $form->post('InputPkodu', true);
                    if ($form->submit()) {
                        $data = array(
                            ':InputPkodu' => $form->values['InputPkodu']
                        );
                    }
                    $PkayitKod = $this->load->model("panel_model");
                    $result = $PkayitKod->gayri_benzersiz_deger_kodu($data);
                    if ($result) {
                        $sonuc["var"] = "Bu Kodda Proje Bulunmaktadır";
                    } else {
                        $sonuc["yok"] = "yok";
                    }

                    break;

                case "gayri_benzersiz_deger_adi":
                    $data = $form->post('InputPadi', true);
                    if ($form->submit()) {
                        $data = array(
                            ':InputPadi' => $form->values['InputPadi']
                        );
                    }

                    $PkayitAdi = $this->load->model("panel_model");
                    $result = $PkayitAdi->gayri_benzersiz_deger_adi($data);
                    if ($result) {
                        $sonuc["var"] = "Bu İsimde Proje Bulunmaktadır";
                    } else {
                        $sonuc["yok"] = "yok";
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
                        error_log("1" . $projekayitAdres_label);
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

