$.ajaxSetup({
    type: "post",
    url: SITE_URL + "AdminDuyuruAjaxSorgu",
    //timeout:3000,
    dataType: "json",
    error: function (a, b) {
        if (b == "timeout")
            reset();
        alertify.alert(jsDil.InternetBaglanti);
        return false;
    },
    statusCode: {
        404: function () {
            reset();
            alertify.alert(jsDil.InternetBaglanti);
            return false;
        }
    }
});
$(document).ready(function () {

    DuyuruTable = $('#duyuruTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });

    //duyuru page custom
    var bolgeler = new Array();
    var kurumlar = new Array();
    var turlar = new Array();

    $('#DuyuruBolge').multiselect({
        onDropdownShow: function (event) {
            var bolgeLength = $('select#DuyuruBolge option').length;
            if (bolgeLength) {
                $('#DuyuruBolge').multiselect('refresh');
            } else {
                reset();
                alertify.alert(jsDil.BolgeOlustur);
                return false;
            }
        },
        onChange: function (option, checked, select) {
            bolgeler = $('select#DuyuruBolge option[value!="-1"]:selected').val();
            $(".kurumFiltre").fadeOut();
            $(".turFiltre").fadeOut();
            $(".DuyuruFiltre").fadeOut();

            if (bolgeler) {
                $(".bolgeKullanici").fadeIn();
                $(".bolgeIslem").fadeIn();
                $(".bolgeDetaylandir").fadeIn();
            } else {
                $(".bolgeKullanici").fadeOut();
                $(".bolgeIslem").fadeOut();
                $(".bolgeDetaylandir").fadeOut();
            }
            $('input[name=bolgeAdmin]').iCheck('uncheck');
            $('input[name=bolgeSofor]').iCheck('uncheck');
            $('input[name=bolgeHostes]').iCheck('uncheck');
            $('input[name=bolgeVeli]').iCheck('uncheck');
            $('input[name=bolgeOgrenci]').iCheck('uncheck');
            $('input[name=bolgePersonel]').iCheck('uncheck');
            $("ul#userAdmin").empty();
            $("ul#userSofor").empty();
            $("ul#userHostes").empty();
            $("ul#userVeli").empty();
            $("ul#userOgrenci").empty();
            $("ul#userPersonel").empty();
            $("#AdminCount").text('');
            $("#SoforCount").text('');
            $("#HostesCount").text('');
            $("#VeliCount").text('');
            $("#OgrenciCount").text('');
            $("#PersonelCount").text('');
        }
    });

    $(document).on("click", ".bolgeDetaylandir", function () {
        $(".bolgeKullanici").fadeOut();
        $(".bolgeIslem").fadeOut();
        $(".kurumFiltre").fadeIn();
        $(".kurumIslem").fadeIn();
        $('input[name=kurumAdmin]').iCheck('uncheck');
        $('input[name=kurumSofor]').iCheck('uncheck');
        $('input[name=kurumHostes]').iCheck('uncheck');
        $('input[name=kurumVeli]').iCheck('uncheck');
        $('input[name=kurumOgrenci]').iCheck('uncheck');
        $('input[name=kurumPersonel]').iCheck('uncheck');
        $("ul#userAdmin").empty();
        $("ul#userSofor").empty();
        $("ul#userHostes").empty();
        $("ul#userVeli").empty();
        $("ul#userOgrenci").empty();
        $("ul#userPersonel").empty();
        $("#AdminCount").text('');
        $("#SoforCount").text('');
        $("#HostesCount").text('');
        $("#VeliCount").text('');
        $("#OgrenciCount").text('');
        $("#PersonelCount").text('');
        var duyuruBolgeID = new Array();
        $('select#DuyuruBolge option:selected').each(function () {
            duyuruBolgeID.push($(this).val());
        });
        var KurumOptions = new Array();
        $.ajax({
            data: {"duyuruBolgeID[]": duyuruBolgeID, "tip": "duyuruKurumMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.kurumMultiSelect) {
                        var kurumlength = cevap.kurumMultiSelect.KurumSelectID.length;
                        for (var i = 0; i < kurumlength; i++) {
                            KurumOptions[i] = {label: cevap.kurumMultiSelect.KurumSelectAd[i], title: cevap.kurumMultiSelect.KurumSelectAd[i], value: cevap.kurumMultiSelect.KurumSelectID[i]};
                        }
                        $('#DuyuruKurum').multiselect('refresh');
                        $('#DuyuruKurum').multiselect('dataprovider', KurumOptions);
                    } else {
                        $('#DuyuruKurum').multiselect('refresh');
                        $('#DuyuruKurum').multiselect('dataprovider', KurumOptions);
                    }
                }
            }
        });
    });

    $('#DuyuruKurum').multiselect({
        onDropdownShow: function (event) {
            var kurumLength = $('select#DuyuruKurum option').length;
            if (kurumLength) {
                $('#DuyuruKurum').multiselect('refresh');
            } else {
                reset();
                alertify.alert(jsDil.BolgeKurumYok);
                return false;
            }
        },
        onChange: function (option, checked, select) {
            kurumlar = $('select#DuyuruKurum option[value!="-1"]:selected').val();
            $(".turFiltre").fadeOut();
            $(".DuyuruFiltre").fadeOut();
            if (kurumlar) {
                $(".kurumKullanici").fadeIn();
                $(".kurumIslem").fadeIn();
            } else {
                $(".kurumKullanici").fadeOut();
                $(".kurumIslem").fadeOut();
            }
            $('input[name=kurumAdmin]').iCheck('uncheck');
            $('input[name=kurumSofor]').iCheck('uncheck');
            $('input[name=kurumHostes]').iCheck('uncheck');
            $('input[name=kurumVeli]').iCheck('uncheck');
            $('input[name=kurumOgrenci]').iCheck('uncheck');
            $('input[name=kurumPersonel]').iCheck('uncheck');
            $("ul#userAdmin").empty();
            $("ul#userSofor").empty();
            $("ul#userHostes").empty();
            $("ul#userVeli").empty();
            $("ul#userOgrenci").empty();
            $("ul#userPersonel").empty();
            $("#AdminCount").text('');
            $("#SoforCount").text('');
            $("#HostesCount").text('');
            $("#VeliCount").text('');
            $("#OgrenciCount").text('');
            $("#PersonelCount").text('');
        }
    });

    $(document).on("click", ".kurumGizle", function () {
        $(".kurumFiltre").fadeOut();
        $(".bolgeKullanici").fadeIn();
        $(".bolgeIslem").fadeIn();
        $('input[name=bolgeAdmin]').iCheck('uncheck');
        $('input[name=bolgeAdmin]').iCheck('uncheck');
        $('input[name=bolgeSofor]').iCheck('uncheck');
        $('input[name=bolgeHostes]').iCheck('uncheck');
        $('input[name=bolgeVeli]').iCheck('uncheck');
        $('input[name=bolgeOgrenci]').iCheck('uncheck');
        $('input[name=bolgePersonel]').iCheck('uncheck');
        $("ul#userAdmin").empty();
        $("ul#userSofor").empty();
        $("ul#userHostes").empty();
        $("ul#userVeli").empty();
        $("ul#userOgrenci").empty();
        $("ul#userPersonel").empty();
        $("#AdminCount").text('');
        $("#SoforCount").text('');
        $("#HostesCount").text('');
        $("#VeliCount").text('');
        $("#OgrenciCount").text('');
        $("#PersonelCount").text('');

    });

    $(document).on("click", ".kurumDetaylandir", function () {
        $(".kurumKullanici").fadeOut();
        $(".kurumIslem").fadeOut();
        $(".turFiltre").fadeIn();
        $(".turIslem").fadeIn();
        $('input[name=turAdmin]').iCheck('uncheck');
        $('input[name=turSofor]').iCheck('uncheck');
        $('input[name=turHostes]').iCheck('uncheck');
        $('input[name=turVeli]').iCheck('uncheck');
        $('input[name=turOgrenci]').iCheck('uncheck');
        $('input[name=turPersonel]').iCheck('uncheck');
        $("ul#userAdmin").empty();
        $("ul#userSofor").empty();
        $("ul#userHostes").empty();
        $("ul#userVeli").empty();
        $("ul#userOgrenci").empty();
        $("ul#userPersonel").empty();
        $("#AdminCount").text('');
        $("#SoforCount").text('');
        $("#HostesCount").text('');
        $("#VeliCount").text('');
        $("#OgrenciCount").text('');
        $("#PersonelCount").text('');
        var duyuruKurumID = new Array();
        $('select#DuyuruKurum option:selected').each(function () {
            duyuruKurumID.push($(this).val());
        });
        var TurOptions = new Array();
        $.ajax({
            data: {"duyuruKurumID[]": duyuruKurumID, "tip": "duyuruTurMultiSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.turMultiSelect) {
                        var turlength = cevap.turMultiSelect.TurSelectID.length;
                        for (var i = 0; i < turlength; i++) {
                            TurOptions[i] = {label: cevap.turMultiSelect.TurSelectAd[i], title: cevap.turMultiSelect.TurSelectAd[i], value: cevap.turMultiSelect.TurSelectID[i]};
                        }
                        $('#DuyuruTur').multiselect('refresh');
                        $('#DuyuruTur').multiselect('dataprovider', TurOptions);
                    } else {
                        $('#DuyuruTur').multiselect('refresh');
                        $('#DuyuruTur').multiselect('dataprovider', TurOptions);
                    }
                }
            }
        });
    });

    $('#DuyuruTur').multiselect({
        onDropdownShow: function (event) {
            var turLength = $('select#DuyuruTur option').length;
            if (turLength) {
                $('#DuyuruTur').multiselect('refresh');
            } else {
                reset();
                alertify.alert(jsDil.TurYok);
                return false;
            }
        },
        onChange: function (option, checked, select) {
            turlar = $('select#DuyuruTur option[value!="-1"]:selected').val();
            $(".DuyuruFiltre").fadeOut();
            if (turlar) {
                $(".kurumKullanici").fadeOut();
                $(".kurumIslem").fadeOut();
                $(".turKullanici").fadeIn();
                $(".turIslem").fadeIn();
            } else {
                $(".turKullanici").fadeOut();
                $(".turIslem").fadeOut();
            }
            $('input[name=turAdmin]').iCheck('uncheck');
            $('input[name=turSofor]').iCheck('uncheck');
            $('input[name=turHostes]').iCheck('uncheck');
            $('input[name=turVeli]').iCheck('uncheck');
            $('input[name=turOgrenci]').iCheck('uncheck');
            $('input[name=turPersonel]').iCheck('uncheck');
            $("ul#userAdmin").empty();
            $("ul#userSofor").empty();
            $("ul#userHostes").empty();
            $("ul#userVeli").empty();
            $("ul#userOgrenci").empty();
            $("ul#userPersonel").empty();
            $("#AdminCount").text('');
            $("#SoforCount").text('');
            $("#HostesCount").text('');
            $("#VeliCount").text('');
            $("#OgrenciCount").text('');
            $("#PersonelCount").text('');
        }
    });

    $(document).on("click", ".turGizle", function () {
        $(".turFiltre").fadeOut();
        $(".kurumKullanici").fadeIn();
        $(".kurumIslem").fadeIn();
        $('input[name=kurumAdmin]').iCheck('uncheck');
        $('input[name=kurumSofor]').iCheck('uncheck');
        $('input[name=kurumHostes]').iCheck('uncheck');
        $('input[name=kurumVeli]').iCheck('uncheck');
        $('input[name=kurumOgrenci]').iCheck('uncheck');
        $('input[name=kurumPersonel]').iCheck('uncheck');
        $("ul#userAdmin").empty();
        $("ul#userSofor").empty();
        $("ul#userHostes").empty();
        $("ul#userVeli").empty();
        $("ul#userOgrenci").empty();
        $("ul#userPersonel").empty();
        $("#AdminCount").text('');
        $("#SoforCount").text('');
        $("#HostesCount").text('');
        $("#VeliCount").text('');
        $("#OgrenciCount").text('');
        $("#PersonelCount").text('');
    });

    $(document).on("click", ".duyuruYaz", function () {
        $(".DuyuruFiltre").fadeIn();
        $(".turIslem").fadeOut();
    });

    $(document).on("click", ".duyuruGizle", function () {
        $(".DuyuruFiltre").fadeOut();
        $(".turKullanici").fadeIn();
        $(".turIslem").fadeIn();
    });
    //bölge admin
    $(document).on("ifClicked", "#bolgeAdmin", function () {
        var duyuruBolgeID = new Array();
        $('select#DuyuruBolge option:selected').each(function () {
            duyuruBolgeID.push($(this).val());
        });
        var val = $(this).prop("checked");
        if (val == true) {
            $("ul#userAdmin").empty();
            $("#AdminCount").text('');
        } else {
            $.ajax({
                data: {"duyuruBolgeID[]": duyuruBolgeID, "tip": "duyuruBolgeAdminMultiSelect"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruAdmin) {
                            var adminlength = cevap.duyuruAdmin.AdminID.length;
                            $("#AdminCount").text('(' + adminlength + ')');
                            for (var i = 0; i < adminlength; i++) {
                                $("ul#userAdmin").append('<li value="' + cevap.duyuruAdmin.AdminID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruAdmin.AdminAd[i] + ' ' + cevap.duyuruAdmin.AdminSoyad[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userAdmin").empty();
                            $("#AdminCount").text('');
                        }
                    }
                }
            });
        }
    });
    //bölge Şoför
    $(document).on("ifClicked", "#bolgeSofor", function () {
        var duyuruBolgeID = new Array();
        $('select#DuyuruBolge option:selected').each(function () {
            duyuruBolgeID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userSofor").empty();
            $("#SoforCount").text('');
        } else {
            $.ajax({
                data: {"duyuruBolgeID[]": duyuruBolgeID, "tip": "duyuruBolgeSoforMultiSelect"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruSofor) {
                            var soforlength = cevap.duyuruSofor.SoforID.length;
                            $("#SoforCount").text('(' + soforlength + ')');
                            for (var i = 0; i < soforlength; i++) {
                                $("ul#userSofor").append('<li value="' + cevap.duyuruSofor.SoforID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruSofor.SoforAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userSofor").empty();
                            $("#SoforCount").text('');
                        }
                    }
                }
            });
        }
    });
    //bölge Hostes
    $(document).on("ifClicked", "#bolgeHostes", function () {
        var duyuruBolgeID = new Array();
        $('select#DuyuruBolge option:selected').each(function () {
            duyuruBolgeID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userHostes").empty();
            $("#HostesCount").text('');
        } else {
            $.ajax({
                data: {"duyuruBolgeID[]": duyuruBolgeID, "tip": "duyuruBolgeHostesMultiSelect"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruHostes) {
                            var hosteslength = cevap.duyuruHostes.HostesID.length;
                            $("#HostesCount").text('(' + hosteslength + ')');
                            for (var i = 0; i < hosteslength; i++) {
                                $("ul#userHostes").append('<li value="' + cevap.duyuruHostes.HostesID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruHostes.HostesAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userHostes").empty();
                            $("#HostesCount").text('');
                        }
                    }
                }
            });
        }
    });
    //bölge Veli
    $(document).on("ifClicked", "#bolgeVeli", function () {
        var duyuruBolgeID = new Array();
        $('select#DuyuruBolge option:selected').each(function () {
            duyuruBolgeID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userVeli").empty();
            $("#VeliCount").text('');
        } else {
            $.ajax({
                data: {"duyuruBolgeID[]": duyuruBolgeID, "tip": "duyuruBolgeVeliMultiSelect"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruVeli) {
                            var velilength = cevap.duyuruVeli.VeliID.length;
                            $("#VeliCount").text('(' + velilength + ')');
                            for (var i = 0; i < velilength; i++) {
                                $("ul#userVeli").append('<li value="' + cevap.duyuruVeli.VeliID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruVeli.VeliAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userVeli").empty();
                            $("#VeliCount").text('');
                        }
                    }
                }
            });
        }
    });
    //bölge Öğrenci
    $(document).on("ifClicked", "#bolgeOgrenci", function () {
        var duyuruBolgeID = new Array();
        $('select#DuyuruBolge option:selected').each(function () {
            duyuruBolgeID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userOgrenci").empty();
            $("#OgrenciCount").text('');
        } else {
            $.ajax({
                data: {"duyuruBolgeID[]": duyuruBolgeID, "tip": "duyuruBolgeOgrenciMultiSelect"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruOgrenci) {
                            var ogrencilength = cevap.duyuruOgrenci.OgrenciID.length;
                            $("#OgrenciCount").text('(' + ogrencilength + ')');
                            for (var i = 0; i < ogrencilength; i++) {
                                $("ul#userOgrenci").append('<li value="' + cevap.duyuruOgrenci.OgrenciID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruOgrenci.OgrenciAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userOgrenci").empty();
                            $("#OgrenciCount").text('');
                        }
                    }
                }
            });
        }
    });
    //bölge Personel
    $(document).on("ifClicked", "#bolgePersonel", function () {
        var duyuruBolgeID = new Array();
        $('select#DuyuruBolge option:selected').each(function () {
            duyuruBolgeID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userPersonel").empty();
            $("#PersonelCount").text('');
        } else {
            $.ajax({
                data: {"duyuruBolgeID[]": duyuruBolgeID, "tip": "duyuruBolgePersonelMultiSelect"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruPersonel) {
                            var personellength = cevap.duyuruPersonel.PersonelID.length;
                            $("#PersonelCount").text('(' + personellength + ')');
                            for (var i = 0; i < personellength; i++) {
                                $("ul#userPersonel").append('<li value="' + cevap.duyuruPersonel.PersonelID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruPersonel.PersonelAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userPersonel").empty();
                            $("#PersonelCount").text('');
                        }
                    }
                }
            });
        }
    });
    //kurum admin
    $(document).on("ifClicked", "#kurumAdmin", function () {
        var duyuruBolgeID = new Array();
        $('select#DuyuruBolge option:selected').each(function () {
            duyuruBolgeID.push($(this).val());
        });
        var val = $(this).prop("checked");
        if (val == true) {
            $("ul#userAdmin").empty();
            $("#AdminCount").text('');
        } else {
            $.ajax({
                data: {"duyuruBolgeID[]": duyuruBolgeID, "tip": "duyuruBolgeAdminMultiSelect"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruAdmin) {
                            var adminlength = cevap.duyuruAdmin.AdminID.length;
                            $("#AdminCount").text('(' + adminlength + ')');
                            for (var i = 0; i < adminlength; i++) {
                                $("ul#userAdmin").append('<li value="' + cevap.duyuruAdmin.AdminID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruAdmin.AdminAd[i] + ' ' + cevap.duyuruAdmin.AdminSoyad[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userAdmin").empty();
                            $("#AdminCount").text('');
                        }
                    }
                }
            });
        }
    });
    //kurum Şoför
    $(document).on("ifClicked", "#kurumSofor", function () {
        var duyuruBolgeID = new Array();
        $('select#DuyuruBolge option:selected').each(function () {
            duyuruBolgeID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userSofor").empty();
            $("#SoforCount").text('');
        } else {
            $.ajax({
                data: {"duyuruBolgeID[]": duyuruBolgeID, "tip": "duyuruBolgeSoforMultiSelect"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruSofor) {
                            var soforlength = cevap.duyuruSofor.SoforID.length;
                            $("#SoforCount").text('(' + soforlength + ')');
                            for (var i = 0; i < soforlength; i++) {
                                $("ul#userSofor").append('<li value="' + cevap.duyuruSofor.SoforID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruSofor.SoforAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userSofor").empty();
                            $("#SoforCount").text('');
                        }
                    }
                }
            });
        }
    });
    //kurum Hostes
    $(document).on("ifClicked", "#kurumHostes", function () {
        var duyuruBolgeID = new Array();
        $('select#DuyuruBolge option:selected').each(function () {
            duyuruBolgeID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userHostes").empty();
            $("#HostesCount").text('');
        } else {
            $.ajax({
                data: {"duyuruBolgeID[]": duyuruBolgeID, "tip": "duyuruBolgeHostesMultiSelect"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruHostes) {
                            var hosteslength = cevap.duyuruHostes.HostesID.length;
                            $("#HostesCount").text('(' + hosteslength + ')');
                            for (var i = 0; i < hosteslength; i++) {
                                $("ul#userHostes").append('<li value="' + cevap.duyuruHostes.HostesID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruHostes.HostesAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userHostes").empty();
                            $("#HostesCount").text('');
                        }
                    }
                }
            });
        }
    });
    //kurum Veli
    $(document).on("ifClicked", "#kurumVeli", function () {
        var duyuruKurumID = new Array();
        $('select#DuyuruKurum option:selected').each(function () {
            duyuruKurumID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userVeli").empty();
            $("#VeliCount").text('');
        } else {
            $.ajax({
                data: {"duyuruKurumID[]": duyuruKurumID, "tip": "duyuruKurumVeli"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruVeli) {
                            var velilength = cevap.duyuruVeli.VeliID.length;
                            $("#VeliCount").text('(' + velilength + ')');
                            for (var i = 0; i < velilength; i++) {
                                $("ul#userVeli").append('<li value="' + cevap.duyuruVeli.VeliID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruVeli.VeliAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userVeli").empty();
                            $("#VeliCount").text('');
                        }
                    }
                }
            });
        }
    });
    //kurum Öğrenci
    $(document).on("ifClicked", "#kurumOgrenci", function () {
        var duyuruKurumID = new Array();
        $('select#DuyuruKurum option:selected').each(function () {
            duyuruKurumID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userOgrenci").empty();
            $("#OgrenciCount").text('');
        } else {
            $.ajax({
                data: {"duyuruKurumID[]": duyuruKurumID, "tip": "duyuruKurumOgrenci"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruOgrenci) {
                            var ogrencilength = cevap.duyuruOgrenci.OgrenciID.length;
                            $("#OgrenciCount").text('(' + ogrencilength + ')');
                            for (var i = 0; i < ogrencilength; i++) {
                                $("ul#userOgrenci").append('<li value="' + cevap.duyuruOgrenci.OgrenciID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruOgrenci.OgrenciAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userOgrenci").empty();
                            $("#OgrenciCount").text('');
                        }
                    }
                }
            });
        }
    });
    //kurum Personel
    $(document).on("ifClicked", "#kurumPersonel", function () {
        var duyuruKurumID = new Array();
        $('select#DuyuruKurum option:selected').each(function () {
            duyuruKurumID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userPersonel").empty();
            $("#PersonelCount").text('');
        } else {
            $.ajax({
                data: {"duyuruKurumID[]": duyuruKurumID, "tip": "duyuruKurumIsci"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruPersonel) {
                            var personellength = cevap.duyuruPersonel.PersonelID.length;
                            $("#PersonelCount").text('(' + personellength + ')');
                            for (var i = 0; i < personellength; i++) {
                                $("ul#userPersonel").append('<li value="' + cevap.duyuruPersonel.PersonelID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruPersonel.PersonelAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userPersonel").empty();
                            $("#PersonelCount").text('');
                        }
                    }
                }
            });
        }
    });
    //tur admin
    $(document).on("ifClicked", "#turAdmin", function () {
        var duyuruBolgeID = new Array();
        $('select#DuyuruBolge option:selected').each(function () {
            duyuruBolgeID.push($(this).val());
        });
        var val = $(this).prop("checked");
        if (val == true) {
            $("ul#userAdmin").empty();
            $("#AdminCount").text('');
        } else {
            $.ajax({
                data: {"duyuruBolgeID[]": duyuruBolgeID, "tip": "duyuruBolgeAdminMultiSelect"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruAdmin) {
                            var adminlength = cevap.duyuruAdmin.AdminID.length;
                            $("#AdminCount").text('(' + adminlength + ')');
                            for (var i = 0; i < adminlength; i++) {
                                $("ul#userAdmin").append('<li value="' + cevap.duyuruAdmin.AdminID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruAdmin.AdminAd[i] + ' ' + cevap.duyuruAdmin.AdminSoyad[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userAdmin").empty();
                            $("#AdminCount").text('');
                        }
                    }
                }
            });
        }
    });
    //tur Şoför
    $(document).on("ifClicked", "#turSofor", function () {
        var duyuruBolgeID = new Array();
        $('select#DuyuruBolge option:selected').each(function () {
            duyuruBolgeID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userSofor").empty();
            $("#SoforCount").text('');
        } else {
            $.ajax({
                data: {"duyuruBolgeID[]": duyuruBolgeID, "tip": "duyuruBolgeSoforMultiSelect"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruSofor) {
                            var soforlength = cevap.duyuruSofor.SoforID.length;
                            $("#SoforCount").text('(' + soforlength + ')');
                            for (var i = 0; i < soforlength; i++) {
                                $("ul#userSofor").append('<li value="' + cevap.duyuruSofor.SoforID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruSofor.SoforAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userSofor").empty();
                            $("#SoforCount").text('');
                        }
                    }
                }
            });
        }
    });
    //tur Hostes
    $(document).on("ifClicked", "#turHostes", function () {
        var duyuruBolgeID = new Array();
        $('select#DuyuruBolge option:selected').each(function () {
            duyuruBolgeID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userHostes").empty();
            $("#HostesCount").text('');
        } else {
            $.ajax({
                data: {"duyuruBolgeID[]": duyuruBolgeID, "tip": "duyuruBolgeHostesMultiSelect"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruHostes) {
                            var hosteslength = cevap.duyuruHostes.HostesID.length;
                            $("#HostesCount").text('(' + hosteslength + ')');
                            for (var i = 0; i < hosteslength; i++) {
                                $("ul#userHostes").append('<li value="' + cevap.duyuruHostes.HostesID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruHostes.HostesAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userHostes").empty();
                            $("#HostesCount").text('');
                        }
                    }
                }
            });
        }
    });
    //tur Veli
    $(document).on("ifClicked", "#turVeli", function () {
        var duyuruKurumID = new Array();
        $('select#DuyuruKurum option:selected').each(function () {
            duyuruKurumID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userVeli").empty();
            $("#VeliCount").text('');
        } else {
            $.ajax({
                data: {"duyuruKurumID[]": duyuruKurumID, "tip": "duyuruKurumVeli"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruVeli) {
                            var velilength = cevap.duyuruVeli.VeliID.length;
                            $("#VeliCount").text('(' + velilength + ')');
                            for (var i = 0; i < velilength; i++) {
                                $("ul#userVeli").append('<li value="' + cevap.duyuruVeli.VeliID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruVeli.VeliAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userVeli").empty();
                            $("#VeliCount").text('');
                        }
                    }
                }
            });
        }
    });
    //tur Öğrenci
    $(document).on("ifClicked", "#turOgrenci", function () {
        var duyuruKurumID = new Array();
        $('select#DuyuruKurum option:selected').each(function () {
            duyuruKurumID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userOgrenci").empty();
            $("#OgrenciCount").text('');
        } else {
            $.ajax({
                data: {"duyuruKurumID[]": duyuruKurumID, "tip": "duyuruKurumOgrenci"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruOgrenci) {
                            var ogrencilength = cevap.duyuruOgrenci.OgrenciID.length;
                            $("#OgrenciCount").text('(' + ogrencilength + ')');
                            for (var i = 0; i < ogrencilength; i++) {
                                $("ul#userOgrenci").append('<li value="' + cevap.duyuruOgrenci.OgrenciID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruOgrenci.OgrenciAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userOgrenci").empty();
                            $("#OgrenciCount").text('');
                        }
                    }
                }
            });
        }
    });
    //tur Personel
    $(document).on("ifClicked", "#turPersonel", function () {
        var duyuruKurumID = new Array();
        $('select#DuyuruKurum option:selected').each(function () {
            duyuruKurumID.push($(this).val());
        });
        var val = $(this).prop("checked");

        if (val == true) {
            $("ul#userPersonel").empty();
            $("#PersonelCount").text('');
        } else {
            $.ajax({
                data: {"duyuruKurumID[]": duyuruKurumID, "tip": "duyuruKurumIsci"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        if (cevap.duyuruPersonel) {
                            var personellength = cevap.duyuruPersonel.PersonelID.length;
                            $("#PersonelCount").text('(' + personellength + ')');
                            for (var i = 0; i < personellength; i++) {
                                $("ul#userPersonel").append('<li value="' + cevap.duyuruPersonel.PersonelID[i] + '" class="list-group-item"><label class="control-label"><input name="kullanici" type="checkbox" class="" checked />' + ' ' + cevap.duyuruPersonel.PersonelAd[i] + '</label></li>');
                            }
                            checkIt();
                        } else {
                            $("ul#userPersonel").empty();
                            $("#PersonelCount").text('');
                        }
                    }
                }
            });
        }
    });
});
$.AdminIslemler = {
    adminDuyuruYeni: function () {
        var BolgeOptions = new Array();
        $.ajax({
            data: {"tip": "duyuruBolgeSelect"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    if (cevap.adminDuyuruBolge) {
                        var bolgelength = cevap.adminDuyuruBolge.AdminBolgeID.length;
                        for (var i = 0; i < bolgelength; i++) {
                            BolgeOptions[i] = {label: cevap.adminDuyuruBolge.AdminBolge[i], title: cevap.adminDuyuruBolge.AdminBolge[i], value: cevap.adminDuyuruBolge.AdminBolgeID[i]};
                        }
                    }
                    $('#DuyuruBolge').multiselect('refresh');
                    $('#DuyuruBolge').multiselect('dataprovider', BolgeOptions);
                    $('#DuyuruKurum').multiselect();
                    $('#DuyuruTur').multiselect();
                    var selectLength = $('#DuyuruBolge > option').length;
                    if (!selectLength) {
                        reset();
                        alertify.alert(jsDil.BolgeOlustur);
                        return false;
                    }

                }

            }
        });
        return true;
    },
    adminDuyuruGonder: function () {
        var admin = new Array();
        var adminText = new Array();
        var sofor = new Array();
        var soforText = new Array();
        var hostes = new Array();
        var hostesText = new Array();
        var veli = new Array();
        var veliText = new Array();
        var ogrenci = new Array();
        var ogrenciText = new Array();
        var personel = new Array();
        var personelText = new Array();
        //admin
        var adminLength = $("#userAdmin>li").length;
        for (var a = 0; a < adminLength; a++) {
            if ($("#userAdmin>li:eq(" + a + ")>label>div>input").prop("checked")) {
                admin.push($("#userAdmin>li:eq(" + a + ")").val());
                adminText.push($("#userAdmin>li:eq(" + a + ")").text());
            }
        }
        //sofor
        var soforLength = $("#userSofor>li").length;
        for (var s = 0; s < soforLength; s++) {
            if ($("#userSofor>li:eq(" + s + ")>label>div>input").prop("checked")) {
                sofor.push($("#userSofor>li:eq(" + s + ")").val());
                soforText.push($("#userSofor>li:eq(" + s + ")").text());
            }
        }
        //hostes
        var hostesLength = $("#userHostes>li").length;
        for (var h = 0; h < hostesLength; h++) {
            if ($("#userHostes>li:eq(" + h + ")>label>div>input").prop("checked")) {
                hostes.push($("#userHostes>li:eq(" + h + ")").val());
                hostesText.push($("#userHostes>li:eq(" + h + ")").text());
            }
        }
        //veli
        var veliLength = $("#userVeli>li").length;
        for (var v = 0; v < veliLength; v++) {
            if ($("#userVeli>li:eq(" + v + ")>label>div>input").prop("checked")) {
                veli.push($("#userVeli>li:eq(" + v + ")").val());
                veliText.push($("#userVeli>li:eq(" + v + ")").text());
            }
        }
        //öğrenci
        var ogrenciLength = $("#userOgrenci>li").length;
        for (var o = 0; o < ogrenciLength; o++) {
            if ($("#userOgrenci>li:eq(" + o + ")>label>div>input").prop("checked")) {
                ogrenci.push($("#userOgrenci>li:eq(" + o + ")").val());
                ogrenciText.push($("#userOgrenci>li:eq(" + o + ")").text());
            }
        }
        //personel
        var personelLength = $("#userPersonel>li").length;
        for (var p = 0; p < personelLength; p++) {
            if ($("#userPersonel>li:eq(" + p + ")>label>div>input").prop("checked")) {
                personel.push($("#userPersonel>li:eq(" + p + ")").val());
                personelText.push($("#userPersonel>li:eq(" + p + ")").text());
            }
        }
        var hedef = admin.length + sofor.length + hostes.length + veli.length + ogrenci.length + personel.length;
        if (hedef == 0) {
            reset();
            alertify.alert(jsDil.HedefKullanici);
            return false;
        } else {
            var duyuruText = $("#duyuruText").val();
            $.ajax({
                data: {"admin[]": admin, "adminText[]": adminText, "sofor[]": sofor, "soforText[]": soforText,
                    "hostes[]": hostes, "hostesText[]": hostesText, "veli[]": veli, "veliText[]": veliText,
                    "ogrenci[]": ogrenci, "ogrenciText[]": ogrenciText, "personel[]": personel,
                    "personelText[]": personelText, "duyuruText": duyuruText, "hedef": hedef, "tip": "duyuruGonder"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.duyuru != "") {
                            var dt = new Date();
                            var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                            var date = dt.getDate() + "/" + dt.getMonth() + "/" + dt.getFullYear();
                            reset();
                            alertify.success(cevap.duyuru[1]);
                            var addRow = "<tr><td>"
                                    + "<a data-toggle='tooltip' data-placement='top'>"
                                    + "<i class='fa fa-bullhorn'></i>" + ' ' + time + '--' + date + "</a></td>"
                                    + "<td class='hidden-xs'>" + cevap.duyuru[0] + " (Admin)" + "</td>"
                                    + "<td class='hidden-xs'>" + duyuruText + "</td>"
                                    + "<td class='hidden-xs'>" + hedef + ' ' + jsDil.Kullanici + "</td></tr>";
                            DuyuruTable.DataTable().row.add($(addRow)).draw();
                        }
                    }
                }
            });
            return true;
        }
    },
}


