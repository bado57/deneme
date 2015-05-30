$.ajaxSetup({
    type: "post",
    url: "http://localhost/SProject/AdminBolgeAjaxSorgu",
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

    newBolgeTable = $('#adminBolgeTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    KurumTable = $('#adminBolgeKurumTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    //bölge işlemleri
    $(document).on('click', 'tbody#adminBolgeRow > tr > td > a', function (e) {
        var i = $(this).find("i")
        i.removeClass("fa-search");
        i.addClass("fa-spinner fa-spin");
        var adminbolgeRowid = $(this).attr('value');
        KurumTable.DataTable().clear().draw();
        $.ajax({
            data: {"adminbolgeRowid": adminbolgeRowid, "tip": "adminBolgeDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    $("input[name=BolgeDetailAdi]").val(cevap.adminBolgeDetail['5dff8e4f44d1afe5716832b74770e3fe']);
                    $("textarea[name=BolgeDetailAciklama]").val(cevap.adminBolgeDetail['5d7991851fff325b2e913c1093f8c7bb']);
                    $("input[name=adminBolgeDetailID]").val(cevap.adminBolgeDetail['95d1cff7e918f5edec2758321aeca910']);
                    if (cevap.adminBolgeKurumDetail == null) {
                        $("#BolgeDetailDeleteBtn").show();
                    } else {
                        var bolgeKurumSayi = cevap.adminBolgeKurumDetail.length;
                        if (bolgeKurumSayi != 0) {
                            $("#BolgeDetailDeleteBtn").hide();
                        } else {
                            $("#BolgeDetailDeleteBtn").show();
                        }
                        for (var kurum = 0; kurum < bolgeKurumSayi; kurum++) {
                            var addRow = "<tr><td>"
                                    + "<a class='svToggle' data-type='svOpen' data-islemler='adminBolgeMultiMap' data-class='map' data-index='index' data-value=" + cevap.adminBolgeKurumDetail[kurum][2] + " data-islemler='adminBolgeMultiMap' role='button' data-toggle='tooltip' data-placement='top' title='' value='" + cevap.adminBolgeKurumDetail[kurum][1] + "'>"
                                    + "<i class='fa fa-map-marker'></i>    " + cevap.adminBolgeKurumDetail[kurum][0] + "</a><i></i></td></tr>";
                            KurumTable.DataTable().row.add($(addRow)).draw();
                        }
                    }
                    svControl('svAdd', 'bolgeDetay', '');
                    i.removeClass("fa-spinner fa-spin");
                    i.addClass("fa-search");
                }
            }
        })
    });
});
var AdminVazgec = [];
$.AdminIslemler = {
    adminDuyuruYeni: function () {
        $('#DuyuruBolge').multiselect();
        $('#DuyuruKurum').multiselect();
        $('#DuyuruTur').multiselect();
        return true;
    }
}


