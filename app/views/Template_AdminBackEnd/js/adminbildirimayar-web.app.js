$(document).ready(function () {

    // Form Enable / Disable Kontrolleri
    $(document).on("click", "#editForm", function (e) {
        e.preventDefault();
        $(document).find(".dsb").prop("disabled", false);
        $(document).find(".edit-group").css("display", "none");
        $(document).find(".submit-group").fadeIn();
        checkIt();
        var edtislemler = $(this).attr("data-Editislem");
        editControl(edtislemler);
    });
    $(document).on("click", ".vzg", function (e) {
        e.preventDefault();
        $(document).find(".dsb").prop("disabled", true);
        $(document).find(".submit-group").css("display", "none");
        $(document).find(".edit-group").fadeIn();
        checkIt();
        var vzgislemler = $(this).attr("data-Vzgislem");
        vzgControl(vzgislemler);
    });
    $(document).on("click", ".save", function (e) {
        e.preventDefault();
        var saveislemler = $(this).attr("data-Saveislem");
        saveControl(saveislemler);
    });

    $(document).on("ifClicked", "#allCheck", function () {
        var val = $(this).prop("checked");
        //ters çalışıyo
        if (val == true) { // false olmuş demektir.
            $("td").find("input[type='checkbox']").prop("checked", false).iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });
        } else {
            $("td").find("input[type='checkbox']").prop("checked", true).iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });
        }
    });

    $(document).on("ifClicked", ".alanCheck", function () {
        var val = $(this).prop("checked");
        if (val == true) {
            $(this).parent().parent().parent().find("input[type='checkbox']").prop("checked", false).iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });
        } else {
            $(this).parent().parent().parent().find("input[type='checkbox']").prop("checked", true).iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });
        }
    });
    var tbodytr = $("tbody>tr").length;
    var tbodytd = $("tbody>tr:eq(0)>td").length;
    var deger = $("#degerler").val();
    var array = JSON.parse("[" + deger + "]");
    var length = array.length;
    for (var i = 0; i < length; i++) {
        for (var tr = 0; tr < tbodytr; tr++) {
            for (var td = 1; td < tbodytd; td++) {
                var tdler = $("tbody>tr:eq(" + tr + ")>td:eq(" + td + ") > input").attr('data-islem');
                if (tdler == array[i]) {
                    $("tbody>tr:eq(" + tr + ")>td:eq(" + td + ") > input").prop("checked", false);
                }
            }
        }
    }
});

//Kaydet Kontrol
function saveControl(saveislemler) {
    switch (saveislemler) {
        case 'bildirimKaydet' :
            $.AdminIslemler.bildirimKaydet();
            break;
        default :
            break;
    }
}
//End Kaydet Kontrol 



