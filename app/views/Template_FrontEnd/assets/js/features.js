
$(document).ready(function () {

    var url = window.location.href;
    var arr = url.split('#');
    if (arr[1] != undefined) {
        $('#specTabs').find('.active').removeClass('active');
        if (arr[1] == "parents") {
            $("ul#specTabs li:eq(1)").addClass("active");
            $("ul#specTabs li:eq(1)>a").prop('aria-expanded', true);
        } else if (arr[1] == "workers") {
            $("ul#specTabs li:eq(2)").addClass("active");
            $("ul#specTabs li:eq(2)>a").prop('aria-expanded', true);
        }
    }
});
 