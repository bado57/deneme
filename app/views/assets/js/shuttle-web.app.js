$(document).ready(function() {

    // Form Enable / Disable Kontrolleri
    $(document).on("click", "#editForm", function () {
        $(document).find(".dsb").prop("disabled", false);
        $(document).find(".edit-group").css("display", "none");
        $(document).find(".submit-group").fadeIn();
        checkIt();
    });

    $(document).on("click", ".vzg", function () {
        $(document).find(".dsb").prop("disabled", true);
        $(document).find(".submit-group").css("display", "none");
        $(document).find(".edit-group").fadeIn();
        checkIt();
    });
    // End Form Enable / Dissable Kontrolleri
    
    
    // Sol Menu Navigasyon Kontrolü
    console.log(activeMenu + " / " + activeLink);
    
        $(".sidebar-menu").find(".active").removeClass("active");
        $("#"+activeMenu).find("a").click();
        $(".sidebar-menu").find(".activeli").removeClass("activeli");
        $("#"+activeMenu).find("#"+activeLink).addClass("activeli");
    
    // End Sol Menu Navigasyon Kontrolü
});

function checkIt() {
        $("input[type='checkbox'], input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });
    }