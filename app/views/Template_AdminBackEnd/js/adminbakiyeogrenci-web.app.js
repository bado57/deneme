// Document Ready
var z = 1;

$(document).ready(function () {
    //ÖĞRENCİ EKLEME mask money
    $(function () {
        $('#odemeTutar').maskMoney();
        $('#odemeDTutar').maskMoney();
    });

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
    // End Form Enable / Dissable Kontrolleri

    // Sol Menu Navigasyon Kontrolü   
    $(".sidebar-menu").find(".active").removeClass("active");
    $("#" + activeMenu).addClass("active");
    $(".sidebar-menu").find(".activeli").removeClass("activeli");
    $("#" + activeMenu).find("#" + activeLink).addClass("activeli");
    // End Sol Menu Navigasyon Kontrolü

    //subview kontrolü. Class'a Göre
    $(document).on("click", ".svToggle", function (e) {
        e.preventDefault();
        if ($(this).attr("data-index") == 'index') {
            MultipleMapindex = $(this).parent().parent().index();
        }
        var dtype = $(this).attr("data-type");
        var dclass = $(this).attr("data-class");
        var dislemler = $(this).attr("data-islemler");
        svControl(dtype, dclass, dislemler);
    });
});
// End Document Ready
var isMap = false;
var isSingle = true;
var svDiv;
// Subview Kontrolü
function svControl(dtype, dclass, dislemler) {
    var effect = 'slide';
    var options = {direction: 'right'};
    var duration = 500;
    var h = $(window).height();
    var hh = $(document).find("header").height();
    var th = h - hh;
    svDiv = $("#" + dclass);

//Subview açılıyor
    if (dtype != 'svClose') {
        switch (dislemler) {
            case 'ogrenciOdemeYeni' :
                var returnCevap = $.AdminIslemler.odemeYeni();
                break;
            default :
                $("#" + dclass).height(th);
                $("#" + dclass).css("z-index", z);
                $("#" + dclass).attr("data-z", z);
                $('[data-z="' + (z - 1) + '"]').css("display", "none");
                $('#' + dclass).toggle(effect, options, duration);
                z++;
                break;
        }
        if (returnCevap == true) {
            $("#" + dclass).height(th);
            $("#" + dclass).css("z-index", z);
            $("#" + dclass).attr("data-z", z);
            $('[data-z="' + (z - 1) + '"]').css("display", "none");
            $('#' + dclass).toggle(effect, options, duration);
            z++;
        }
    }//Subview kapanıyor
    else if (dtype != 'svOpen') {
        switch (dislemler) {
            case 'ogrenciOdemeCancel' :
                var returnCevap = $.AdminIslemler.ogrenciOdemeCancel();
                break;
            case 'odemeKaydet' :
                var returnCevap = $.AdminIslemler.odemeKaydet();
                break;
            case 'ogrenciOdemeDCancel' :
                var returnCevap = $.AdminIslemler.ogrenciOdemeDCancel();
                break;
            case 'adminBakiyeDetailSil' :
                var returnCevap = $.AdminIslemler.adminBakiyeDetailSil();
                break;
            default :
                $("#" + dclass).height(th);
                $("#" + dclass).css("z-index", z);
                $('[data-z="' + (z - 2) + '"]').css("display", "block");
                svDiv = $('[data-z="' + (z - 2) + '"]');
                $('#' + dclass).toggle(effect, options, duration);
                z--;
                break;
        }
        if (returnCevap == true) {
            $("#" + dclass).height(th);
            $("#" + dclass).css("z-index", z);
            $('[data-z="' + (z - 2) + '"]').css("display", "block");
            svDiv = $('[data-z="' + (z - 2) + '"]');
            $('#' + dclass).toggle(effect, options, duration);
            z--;
        }
    }
    if (z > 1) {
        $(".wrapper").find("aside").css("display", "none");
        setSvHeight();
    } else {
        $(".wrapper").find("aside").css("display", "block");
    }
}

$(window).resize(function () {
    setSvHeight();
});

// Subview Yükseklik Ayarlama
function setSvHeight() {
    if (z > 1) {
        var hh = $(".header").height();
        svDiv.height($(window).height() - hh);
    }
}



// End Subview Kontrolü

//Edit Kontrol
function editControl(edtislemler) {
    switch (edtislemler) {
        case 'adminBakiyeDetailEdit' :
            $.AdminIslemler.adminBakiyeDetailEdit();
            break;
        default :
            break;
    }
}
//End Edit Kontrol

//Vazgeç Kontrol
function vzgControl(vzgislemler) {
    switch (vzgislemler) {
        case 'adminBakiyeDetailVazgec' :
            $.AdminIslemler.adminBakiyeDetailVazgec();
            break;
        default :
            break;
    }
}
//End Vezgeç Kontrol

//Kaydet Kontrol
function saveControl(saveislemler) {
    switch (saveislemler) {
        case 'adminBakiyeDetailKaydet' :
            $.AdminIslemler.adminBakiyeDetailKaydet();
            break;
        default :
            break;
    }
}
//End Kaydet Kontrol 

// CheckBox Kontrolü
function checkIt() {
    $("input[type='checkbox'], input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });
}
// End CheckBox Kontrolü    

// Form disable işlemleri
function disabledForm() {
    $(document).find(".dsb").prop("disabled", true);
    $(document).find(".submit-group").css("display", "none");
    $(document).find(".edit-group").fadeIn();
    checkIt();
}
// End form disable işlemleri
