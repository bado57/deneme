jQuery(function ($) {
    'use strict';

    //Responsive Nav
    $('li.dropdown').find('.fa-angle-down').each(function () {
        $(this).on('click', function () {
            if ($(window).width() < 768) {
                $(this).parent().next().slideToggle();
            }
            return false;
        });
    });

    //Fit Vids
    if ($('#video-container').length) {
        $("#video-container").fitVids();
    }

    //Initiat WOW JS
    new WOW().init();

    // portfolio filter
    $(window).load(function () {

        $('.main-slider').addClass('animate-in');
        $('.preloader').remove();
        //End Preloader

        if ($('.masonery_area').length) {
            $('.masonery_area').masonry();//Masonry
        }

        var $portfolio_selectors = $('.portfolio-filter >li>a');

        if ($portfolio_selectors.length) {

            var $portfolio = $('.portfolio-items');
            $portfolio.isotope({
                itemSelector: '.portfolio-item',
                layoutMode: 'fitRows'
            });

            $portfolio_selectors.on('click', function () {
                $portfolio_selectors.removeClass('active');
                $(this).addClass('active');
                var selector = $(this).attr('data-filter');
                $portfolio.isotope({filter: selector});
                return false;
            });
        }

    });

    $('.timer').each(count);
    function count(options) {
        var $this = $(this);
        options = $.extend({}, options || {}, $this.data('countToOptions') || {});
        $this.countTo(options);
    }

    // Search
    $('.fa-search').on('click', function () {
        $('.field-toggle').fadeToggle(200);
    });

    // Contact form
    var form = $('#main-contact-form');
    form.submit(function (event) {
        event.preventDefault();
        var form_status = $('<div class="form_status"></div>');
        $.ajax({
            url: $(this).attr('action'),
            beforeSend: function () {
                form.prepend(form_status.html('<p><i class="fa fa-spinner fa-spin"></i> Email is sending...</p>').fadeIn());
            }
        }).done(function (data) {
            form_status.html('<p class="text-success">Thank you for contact us. As early as possible  we will contact you</p>').delay(3000).fadeOut();
        });
    });

    // Progress Bar
    $.each($('div.progress-bar'), function () {
        $(this).css('width', $(this).attr('data-transition') + '%');
    });

    $(document).ready(function () {
        $(document).on("click", "#iletsubmit", function (e) {
            var adsoyad = $("#iletname").val();
            var email = $("#iletemail").val();
            var mesaj = $("#iletmessage").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "FrontGenel",
                cache: false,
                dataType: "json",
                data: {"adsoyad": adsoyad, "email": email,
                    "mesaj": mesaj, "tip": "iletisim"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        $("#iletname").val("");
                        $("#iletemail").val("");
                        $("#iletmessage").val("");
                        reset();
                        alertify.alert(cevap.result);
                        return false;
                    }
                }
            });
        });
        $(document).on("click", "#gosign_up", function (e) {
            $.ajax({
                type: "post",
                url: SITE_URL + "FrontGenel",
                cache: false,
                dataType: "json",
                data: {"tip": "signupKayit"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        reset();
                        alertify.alert(cevap.result);
                        return false;
                    }
                }
            });
        });
        // Anamenüde aktif link ayarlama.
        var sPageURL = window.location.pathname.split('/');
        var activePage = sPageURL[sPageURL.length - 1];
        $('.mainMenu').find('.active').removeClass('active');
        $('#' + activePage).addClass('active');

        // iCheck eklentisi
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
            increaseArea: '20%' // optional
        });

        $('[data-toggle="tooltip"]').tooltip();

        //selectbox language
        $("select#kullaniciLanguage").change(function () {
            var lang = $(this).val();
            $.ajax({
                type: "post",
                url: SITE_URL + "Language",
                cache: false,
                dataType: "json",
                data: {"lang": lang},
                success: function (cevap) {
                    if (cevap.hata) {
                        //alert(cevap.hata);
                    } else {
                        window.location.reload();
                    }
                }
            });
        });
    });
});