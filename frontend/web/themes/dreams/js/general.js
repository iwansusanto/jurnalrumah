/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



//var jurnalrumah = {
//    base_url: base_url,
//    init: function () {
//        
//    },
//}
//
//var scrollto = {
//    init: function () {
////        this.top();
//    },
//    top: function () {
//        var st = $(window).scrollTop();
//        if (st < 1500)
//            $(".go-top").hide();
//        else
//            $(".go-top").show();
//    },
//    lock_leftmenu: function(){
//            $.lockfixed(".content-left .list-rumah-dijual",{offset: {top: 100, bottom: 0}});
//            $.lockfixed(".content-right .list-berita-popular",{offset: {top: 100, bottom: 0}});
//        },
//    lock_menuheader: function(){
//        $(window).scroll(function(){
//            var lastScrollTop = 40;
//            if ($(window).scrollTop() >= lastScrollTop) {
//               $('.menuheader').addClass('fixed-header');
//            }
//            else {
//               $('.menuheader').removeClass('fixed-header');
//            }
//        });
//    },
//    submit_cari_artikel: function(){
//        $('#cariberita-form').submit(function() {
//            window.location = $(this).attr("action") + '/' + $('#q').val();
//            return false;
//         });
//    }
//}

//$(document).ready(function () {
//    $(".go-top").hide();
//    jurnalrumah.init();
//    $(window).scroll(function () {
//        scrollto.top();
//    });
//
//    $(".go-top").click(function () {
//        $('html, body').animate({scrollTop: 0}, 'normal');
//        return false;
//    });
//
//    scrollto.lock_leftmenu();
//    scrollto.lock_menuheader();
////    scrollto.submit_cari_artikel();
//    
//
//
//   
//
//    (function ($) {
////        $.lockfixed(".konten-kiri .block-iklan-160-600", {offset: {top: 10, bottom: 505}});
//    })(jQuery);
//    
//});

$(document).ready(function () {
    var page = {
        init: function(){
            $(".go-top").hide();
            $(window).scroll(function () {
                page.top();
            });

            $(".go-top").click(function () {
                $('html, body').animate({scrollTop: 0}, 'normal');
                return false;
            });
        },
        top: function () {
            var st = $(window).scrollTop();
            if (st < 1500){
                $(".go-top").hide();
                console.log('hide');
            }else{
                $(".go-top").show();
                console.log('show');
            };    
        },
        lock_leftmenu: function(){
            var list_berita_populer = $("ul.list-berita-popular");
//            console.log(list_berita_populer.children().last().offset().top);
                $.lockfixed(".content-left .list-rumah-dijual",{offset: {top: 100, bottom: 100}});
                $.lockfixed(".content-right .list-berita-popular",{offset: {top: 100, bottom: 100}});
//                $.lockfixed(".content-right .tag-wrapper",{offset: {top: 100, bottom: 20}});
            },
        lock_menuheader: function(){
            $(window).scroll(function(){
                var lastScrollTop = 40;
                if ($(window).scrollTop() >= lastScrollTop) {
                   $('.menuheader').addClass('fixed-header');
                }
                else {
                   $('.menuheader').removeClass('fixed-header');
                }
            });
        },
    };
    page.lock_leftmenu();
    page.lock_menuheader();
});


