
$(document).ready(function () {

    // Sol Menu Navigasyon Kontrolü   
    $(".sidebar-menu").find(".active").removeClass("active");
    $("#" + activeMenu).addClass("active");
    $(".sidebar-menu").find(".activeli").removeClass("activeli");
    $("#" + activeMenu).find("#" + activeLink).addClass("activeli");
    
    // End Sol Menu Navigasyon Kontrolü
});
