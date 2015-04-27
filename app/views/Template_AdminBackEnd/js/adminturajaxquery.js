$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminTurAjaxSorgu",
    //timeout:3000,
    dataType: "json",
    error: function (a, b) {
        if (b == "timeout")
            alert("Ajax İsteği Zaman Aşımına Uğradı");
    },
    statusCode: {
        404: function () {
            alert("Ajax dosyası bulunamadı");
        }
    }
});
$(document).ready(function () {

    TurTable = $('#adminTurTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    //kurum işlemleri
    $(document).on('click', 'tbody#adminKurumRow > tr > td > a', function (e) {
        var s = $(this).find("i");
        s.removeClass("fa-search");
        s.addClass("fa-spinner fa-spin");
        var adminkurumRowid = $(this).attr('value');
        KurumTurTable.DataTable().clear().draw();
        $.ajax({
            data: {"adminkurumRowid": adminkurumRowid, "tip": "adminKurumDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {

                    $("input[name=KurumDetailAdi]").val(cevap.adminKurumDetail['2065df742f65c58446e8796c751fcd15']);
                    $("input[name=KurumDetailBolge]").val(cevap.adminKurumDetail['5dff8e4f44d1afe5716832b74770e3fe']);
                    $("input[name=KurumDetailTelefon]").val(cevap.adminKurumDetail['1ca4e7d1e05313c9c9ea295bd91eee63']);
                    $("input[name=KurumDetailEmail]").val(cevap.adminKurumDetail['20d22439a604859a4fcc07e250c00842']);
                    $("textarea[name=KurumDetailAdres]").val(cevap.adminKurumDetail['ffe825a3429333ccd27ec1b77b63d7b3']);
                    $("textarea[name=KurumDetailAciklama]").val(cevap.adminKurumDetail['b8ecd9075c0c9a7f7afa1784acb13c2e']);
                    $("input[name=adminKurumDetailID]").val(cevap.adminKurumDetail['3bcdc7d6f02b5b42c7be9604808e7c07']);
                    $("input[name=adminKurumDetailLocation]").val(cevap.adminKurumDetail['a465db00f313bd4781af6805a8d6fb31']);
                    if (cevap.adminKurumTurDetail) {
                        var KurumTurSayi = cevap.adminKurumTurDetail.length;
                        if (KurumTurSayi != 0) {
                            $("#KurumDetailDeleteBtn").hide();
                        } else {
                            $("#KurumDetailDeleteBtn").show();
                        }

                        var turCount = cevap.adminKurumTurDetail.length;
                        for (var i = 0; i < turCount; i++) {
                            if (cevap.adminKurumTurDetail[i].KurumTurTip != 1) {
                                TurTip = 'Öğrenci';
                            } else {
                                TurTip = 'İşçi';
                            }

                            if (cevap.adminKurumTurDetail[i].KurumTurAktiflik != 0) {
                                var addRow = "<tr><td>"
                                        + "<a class='svToggle' data-type='svOpen' data-islemler='adminKurumMultiMap' data-class='map' data-index='index' data-toggle='tooltip' data-placement='top' title='' value='" + cevap.adminKurumTurDetail[i].KurumTurID + "'>"
                                        + "<i class='fa fa-map-marker'></i> " + cevap.adminKurumTurDetail[i].KurumDetailTurAdi + "</a></td>"
                                        + "<td class='hidden-xs' >" + TurTip + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.adminKurumTurDetail[i].KurumTurAcikla + "</td></tr>";
                                KurumTurTable.DataTable().row.add($(addRow)).draw();
                            } else {
                                var addRow = "<tr><td>"
                                        + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.adminKurumTurDetail[i].KurumTurID + "'>"
                                        + "<i class='fa fa-map-marker' style='color:red'></i> " + cevap.adminKurumTurDetail[i].KurumDetailTurAdi + "</a></td>"
                                        + "<td class='hidden-xs' >" + TurTip + "</td>"
                                        + "<td class='hidden-xs' >" + cevap.adminKurumTurDetail[i].KurumTurAcikla + "</td></tr>";
                                KurumTurTable.DataTable().row.add($(addRow)).draw();
                            }

                        }
                    }
                    svControl('svAdd', 'kurumDetay', '');
                    s.removeClass("fa-spinner fa-spin");
                    s.addClass("fa-search");
                }
            }
        });
    });
    //tur bölge select change
    $('#TurSelectBolge').on('change', function () {
        $('#TurSelectKurum option[value!="0"]').remove();
        var turBolgeID = $('select#TurSelectBolge option:selected').val();
        $.ajax({
            data: {"turBolgeID": turBolgeID, "tip": "turKurumSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    if (cevap.kurumSelect) {
                        var length = cevap.kurumSelect.KurumSelectID.length;
                        for (var i = 0; i < length; i++) {
                            $("#TurSelectKurum").append('<option value="' + cevap.kurumSelect.KurumSelectID[i] + '" id="' + cevap.kurumSelect.KurumSelectTip[i] + '">' + cevap.kurumSelect.KurumSelectAd[i] + '</option>');
                        }
                    }
                }
            }
        });
    });
    //tur araç focus
    $("#TurArac").focus(function () {
        var turBolgeID = $('select#TurSelectBolge option[value!="0"]:selected').val();
        if (turBolgeID) {
            var turKurumID = $('select#TurSelectKurum option[value!="0"]:selected').val();
            if (turKurumID) {
                var turGunID = new Array();
                $('select#TurSelectGun option:selected').each(function () {
                    turGunID.push($(this).val());
                });
                var turgunlength = turGunID.length;
                if (turgunlength > 0) {
                    var turSaat1ID = $('select#TurSaat1 option[value!="0"]:selected').val();
                    if (turSaat1ID) {
                        var turSaat2ID = $('select#TurSaat2 option[value!="0"]:selected').val();
                        if (turSaat2ID) {
                            $.ajax({
                                data: {"turBolgeID": turBolgeID, "turKurumID": turKurumID, "turGunID[]": turGunID, "turSaat1ID": turSaat1ID, "turSaat2ID": turSaat2ID, "tip": "turAracSelect"},
                                success: function (cevap) {
                                    if (cevap.hata) {
                                        alert(cevap.hata);
                                    } else {
                                        if (cevap.kurumSelect) {
                                            var length = cevap.kurumSelect.KurumSelectID.length;
                                            for (var i = 0; i < length; i++) {
                                                $("#TurArac").append('<option value="' + cevap.kurumSelect.KurumSelectID[i] + '" id="' + cevap.kurumSelect.KurumSelectTip[i] + '">' + cevap.kurumSelect.KurumSelectAd[i] + '</option>');
                                            }
                                        }
                                    }
                                }
                            });
                        } else {
                            alert("Lütfen Saat Seçiniz");
                        }
                    } else {
                        alert("Lütfen Saat Seçiniz");
                    }
                } else {
                    alert("Lütfen Gün Seçiniz");
                }
            } else {
                alert("Lütfen Kurum Seçiniz");
            }
        } else {
            alert("Lütfen Bölge Seçiniz");
        }
    });
});

$.AdminIslemler = {
    adminTurYeni: function () {
        $("input[name=TurAdi]").val(' ');
        $.ajax({
            data: {"tip": "turBolgeEkleSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    if (cevap.adminTurBolgee) {
                        var length = cevap.adminTurBolgee.length;
                        for (var i = 0; i < length; i++) {
                            $("#TurSelectBolge").append('<option value="' + cevap.adminTurBolgee[i] + '">' + cevap.adminTurBolge[i] + '</option>');
                        }
                    }
                    $('#TurSelectGun').multiselect('refresh');
                    $('#TurSelectTip').multiselect('refresh');
                    var selectLength = $('#TurSelectBolge > option').length;
                    if (!selectLength) {
                        alert("Lütfen Öncelikle Bölge İşlemlerine Gidip Yeni Bölge Oluşturunuz");
                    }
                }
            }
        });
        return true;
    },
    adminAddKurumVazgec: function () {
        $("input[name=KurumAdi]").val('');
        $("textarea[name=KurumAciklama]").val('');
        return true;
    },
    adminKurumKaydet: function () {
        AdminKurumKaydet = [];
        var kurum_adi = $("input[name=KurumAdi]").val();
        var kurum_aciklama = $("textarea[name=KurumAciklama]").val();
        AdminKurumKaydet.push(kurum_adi);
        AdminKurumKaydet.push(kurum_adi);
        if (bolge_adi != '') {
            $.ajax({
                data: {"kurum_adi": kurum_adi, "kurum_aciklama": kurum_aciklama, "tip": "adminKurumYeniKaydet"},
                success: function (cevap) {
                    if (cevap.hata) {
                        AdminKurumKaydet = [];
                        alert(cevap.hata);
                    } else {
                        var bolgeCount = $('#smallBolge').text();
                        bolgeCount++;
                        $('#smallBolge').text(bolgeCount);
                        var addRow = ("<tr style='background-color:#F2F2F2'><td><a class='svToggle' data-type='svDetail' role='button' data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newBolgeID + "'>"
                                + "<i class='fa fa-search'></i> " + AdminBolgeKaydet[0] + "</a>"
                                + "</td><td class='hidden-xs'>0</td><td class='hidden-xs'>" + AdminBolgeKaydet[1] + "</td></tr>");
                        NewKurumTable.DataTable().row.add($(addRow)).draw();
                    }
                }
            });
            return true;
        } else {
            alert("Lütfen Kurum Adını Giriniz");
        }
    },
    adminKurumDetailSil: function () {
        var kurumdetail_id = $("input[name=adminKurumDetailID]").val();
        $.ajax({
            data: {"kurumdetail_id": kurumdetail_id, "tip": "adminKurumDetailDelete"},
            success: function (cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    disabledForm();
                    $("input[name=KurumDetailAdi]").val('');
                    $("input[name=KurumDetailBolge]").val('');
                    $("input[name=KurumDetailTelefon]").val('');
                    $("input[name=KurumDetailEmail]").val('');
                    $("textarea[name=KurumDetailAdres]").val('');
                    $("textarea[name=KurumDetailAciklama]").val('');
                    $("input[name=adminKurumDetailID]").val('');
                    var kurumCount = $('#smallKurum').text();
                    kurumCount--;
                    $('#smallKurum').text(kurumCount);
                    var length = $('tbody#adminKurumRow tr').length;
                    for (var t = 0; t < length; t++) {
                        var attrValueId = $("tbody#adminKurumRow > tr > td > a").eq(t).attr('value');
                        if (attrValueId == kurumdetail_id) {
                            var deleteRow = $('tbody#adminKurumRow > tr:eq(' + t + ')');
                            NewKurumTable.DataTable().row($(deleteRow)).remove().draw();
                        }
                    }
                }
            }
        });
        return true;
    },
    adminKurumDetailDuzenle: function () {
        //Kurum İşlemleri Değerleri
        var kurumdetail_adi = $("input[name=KurumDetailAdi]").val();
        var kurumdetail_bolge = $("input[name=KurumDetailBolge]").val();
        var kurumdetail_telefon = $("input[name=KurumDetailTelefon]").val();
        var kurumdetail_email = $("input[name=KurumDetailEmail]").val();
        var kurumdetail_adres = $("textarea[name=KurumDetailAdres]").val();
        var kurumdetail_aciklama = $("textarea[name=KurumDetailAciklama]").val();
        AdminKurumDetailVazgec = [];
        AdminKurumDetailVazgec.push(kurumdetail_adi, kurumdetail_bolge, kurumdetail_telefon, kurumdetail_email, kurumdetail_adres, kurumdetail_aciklama);
    },
    adminKurumDetailVazgec: function () {
        $("input[name=KurumDetailAdi]").val(AdminKurumDetailVazgec[0]);
        $("input[name=KurumDetailBolge]").val(AdminKurumDetailVazgec[1]);
        $("input[name=KurumDetailTelefon]").val(AdminKurumDetailVazgec[2]);
        $("input[name=KurumDetailEmail]").val(AdminKurumDetailVazgec[3]);
        $("textarea[name=KurumDetailAdres]").val(AdminKurumDetailVazgec[4]);
        $("textarea[name=KurumDetailAciklama]").val(AdminKurumDetailVazgec[5]);
    },
    adminKurumDetailKaydet: function () {
        var kurumdetail_adi = $("input[name=KurumDetailAdi]").val();
        var kurumdetail_bolge = $("input[name=KurumDetailBolge]").val();
        var kurumdetail_telefon = $("input[name=KurumDetailTelefon]").val();
        var kurumdetail_email = $("input[name=KurumDetailEmail]").val();
        var kurumdetail_adres = $("textarea[name=KurumDetailAdres]").val();
        var kurumdetail_aciklama = $("textarea[name=KurumDetailAciklama]").val();
        var kurumdetail_id = $("input[name=adminKurumDetailID]").val();
        if (AdminKurumDetailVazgec[0] == kurumdetail_adi && AdminKurumDetailVazgec[1] == kurumdetail_bolge && AdminKurumDetailVazgec[2] == kurumdetail_telefon && AdminKurumDetailVazgec[3] == kurumdetail_email && AdminKurumDetailVazgec[4] == kurumdetail_adres && AdminKurumDetailVazgec[5] == kurumdetail_aciklama) {
            alert("Lütfen Değişiklik yaptığınıza emin olun.");
        } else {
            $.ajax({
                data: {"kurumdetail_id": kurumdetail_id, "kurumdetail_adi": kurumdetail_adi, "kurumdetail_bolge": kurumdetail_bolge, "kurumdetail_telefon": kurumdetail_telefon, "kurumdetail_email": kurumdetail_email, "kurumdetail_adres": kurumdetail_adres, "kurumdetail_aciklama": kurumdetail_aciklama, "tip": "adminKurumDetailDuzenle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        alert(cevap.hata);
                    } else {
                        disabledForm();
                        var length = $('tbody#adminKurumRow tr').length;
                        for (var t = 0; t < length; t++) {
                            var attrValueId = $("tbody#adminKurumRow > tr > td > a").eq(t).attr('value');
                            if (attrValueId == kurumdetail_id) {
                                $("tbody#adminKurumRow > tr > td > a").eq(t).html('<i class="fa fa-search"></i> ' + kurumdetail_adi);
                                $("tbody#adminKurumRow > tr > td > a").eq(t).parent().parent().find('td:last-child').text(kurumdetail_aciklama);
                                $('tbody#adminKurumRow > tr:eq(' + t + ') > td:eq(0)').css({"background-color": "#F2F2F2"});
                            }
                        }
                    }
                }
            });
        }
    },
    adminKurumVazgec: function () {
        return true;
    },
    adminKurumEkle: function () {
        var kurumadi = $("input[name=KurumAdi]").val();
        if (kurumadi == '') {
            alert("Kurum Adı Boş geçilemez");
        } else {

            var kurumlocation = $("input[name=KurumLokasyon]").val();
            var bolgead = $("#KurumBolgeSelect option:selected").text();
            var bolgeId = $("#KurumBolgeSelect option:selected").val();
            var kurumTlfn = $("input[name=KurumTelefon]").val();
            var kurumEmail = $("input[name=KurumEmail]").val();
            var kurumwebsite = $("input[name=KurumWebSite]").val();
            var kurumadrsDty = $("textarea[name=KurumAdresDetay]").val();
            var kurumaciklama = $("textarea[name=Aciklama]").val();
            var kurumulke = $("input[name=country]").val();
            var kurumil = $("input[name=administrative_area_level_1]").val();
            var kurumilce = $("input[name=administrative_area_level_2]").val();
            var kurumsemt = $("input[name=locality]").val();
            var kurummahalle = $("input[name=neighborhood]").val();
            var kurumsokak = $("input[name=route]").val();
            var kurumpostakodu = $("input[name=postal_code]").val();
            var kurumcaddeno = $("input[name=street_number]").val();
            $.ajax({
                data: {"kurumadi": kurumadi, "bolgeId": bolgeId, "bolgead": bolgead, "kurumlocation": kurumlocation, "kurumTlfn": kurumTlfn, "kurumEmail": kurumEmail,
                    "kurumwebsite": kurumwebsite, "kurumadrsDty": kurumadrsDty, "kurumaciklama": kurumaciklama,
                    "kurumulke": kurumulke, "kurumil": kurumil, "kurumilce": kurumilce, "kurumsemt": kurumsemt,
                    "kurummahalle": kurummahalle, "kurumsokak": kurumsokak, "kurumpostakodu": kurumpostakodu,
                    "kurumcaddeno": kurumcaddeno, "tip": "adminKurumKaydet"},
                success: function (cevap) {
                    if (cevap.hata) {
                        alert(cevap.hata);
                    } else {
                        var kurumCount = $('#smallKurum').text();
                        kurumCount++;
                        $('#smallKurum').text(kurumCount);
                        var addRow = "<tr style='background-color:#F2F2F2'><td>"
                                + "<a data-toggle='tooltip' data-placement='top' title='' value='" + cevap.newKurumID + "'>"
                                + "<i class='fa fa-map-marker'></i> " + kurumadi + "</a></td>"
                                + "<td class='hidden-xs' value='" + bolgeId + "'>" + bolgead + "</td>"
                                + "<td class='hidden-xs'>0</td><td class='hidden-xs'>" + kurumaciklama + "</td></tr>";
                        NewKurumTable.DataTable().row.add($(addRow)).draw();
                    }
                }
            });
            return true;
        }
    },
    adminKurumMap: function () {
        var kurum_location = $("input[name=adminKurumDetailLocation]").val();
        var kurum_adi = $("input[name=KurumDetailAdi]").val();
        if (!kurum_location) {
            alert("Kurumunuza ait lokasyon bilgisi bulunmamaktadır");
        } else {
            var count = $('table#adminBolgeKurumTable > tbody > tr').length;
            var MapValue = $(this).attr('value');
            var LocationBolme = kurum_location.split(",");
            MultipleMapArray[0] = Array(kurum_adi, LocationBolme[0], LocationBolme[1]);
            $("#singleMapBaslik").text(kurum_adi);
            return true;
        }
    }
}


