/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
//    var iframe = {
//        1: $('<iframe></iframe>').attr({
//            src: rajamobil.base_url + '/iframe/iklanartikellist',
//            id: 'iframe_1',
//            width: '468',
//            height: '60',
//            frameborder: '0',
//            allowtransparency: 'yes',
//            scrolling: 'no',
//            marginwidth: '0',
//            marginheight: '0',
//        }),
//        2: $('<iframe></iframe>').attr({
//            src: rajamobil.base_url + '/iframe/iklanartikellist2',
//            id: 'iframe_2',
//            width: '468',
//            height: '60',
//            frameborder: '0',
//            allowtransparency: 'yes',
//            scrolling: 'no',
//            marginwidth: '0',
//            marginheight: '0',
//        }),
//        3: $('<iframe></iframe>').attr({
//            src: rajamobil.base_url + '/iframe/iklanartikellist3',
//            id: 'iframe_2',
//            width: '468',
//            height: '60',
//            frameborder: '0',
//            allowtransparency: 'yes',
//            scrolling: 'no',
//            marginwidth: '0',
//            marginheight: '0',
//        })
//    };

    $(document).on('mouseover', '.artikel-list', function () {
        var pageUrl = $(this).find('span.facebook').attr('data-href'); //Location of this page
        pageUrl = pageUrl.replace('rmyii.rajamobil.dev', 'www.rajamobil.com');

        var counttwitter = $(this).find('span.count_twitter');
        var countfb = $(this).find('span.count_fb');

        if ($(this).find('span.count_fb').is(':empty')) {
            $.ajax({
                url: 'https://graph.facebook.com/?ids=' + pageUrl,
                type: 'POST',
                dataType: 'jsonp',
                success: function (data) {
                    if (data[pageUrl].shares) {
                        countfb.text(data[pageUrl].shares);
                    } else {
                        countfb.text('0');
                    }
                    countfb.show();
                }
            });

            $.ajax({
                url: 'http://urls.api.twitter.com/1/urls/count.json?url=' + pageUrl,
                type: 'POST',
                dataType: 'jsonp',
                success: function (data) {
                    if (data.count) {
                        counttwitter.text(data.count);
                    } else {
                        counttwitter.text('0');
                    }
                    counttwitter.show();
                }
            });
        } else {
            console.log('ada');
        }
        $(this).find('.sharer').show();
        if (countfb.is(':empty')) {
            countfb.hide();
        } else {
            countfb.show();
        }
        if (counttwitter.is(':empty')) {
            counttwitter.hide();
        } else {
            counttwitter.show();
        }

    }).on('mouseout', '.artikel-list', function () {
        $(this).find('.sharer').hide();
    });

    var page = {
        init: function () {

        },
        
        skywrapper_left: function () {
//            (function ($) {
//                $.lockfixed(".konten-kiri #block-iklan-160-600", {offset: {top: 50, bottom: 505}});
//                $.lockfixed(".subx .submenu-berita", {offset: {top: 0}});
//            })(jQuery);
        },
        load_artikel: function () {
            var i = 1; // unutuk looping iframe_1, iframe_2, iframe_3
            $('#loading-bar').hide().css('text-align', 'center');
            $('ul#wrapper-artikel').find('li:last-child').not('.artikel-empty').attr('id', 'next-load');
//            $('ul#wrapper-artikel').append('<li class="list-ads"><div id="banner_1"><div class="slot-470-60">' + iframe[i][0].outerHTML + '</div></div></li>');
            $('.pagination').remove();
            var data_perpage = $('ul#wrapper-artikel li').not('.list-ads').length;
            $(document)
                    .on('pjax:beforeSend', function (event, xhr, settings) {
                        $('#loading-bar').show();
                    })
                    .on('pjax:beforeReplace', function (contents, options) {
                        var string = contents.target.innerHTML;
//                            $.old_content = $(string).find('li').unwrap(); // get element li from response html
                        $.old_content = $(string).find('li').not('.artikel-empty').removeAttr('id'); // get element li from response html kecuali li dengan class artikel-empty
                    })
                    .on('pjax:end', function (data, status, xhr, options) {
                        var isContains = $('.empty').length;
//                        var iframe = $('#frame');
                        if (isContains == 0) { // jika data nya tidak kosong
                            console.log($.old_content);
                            $('ul#wrapper-artikel').prepend($.old_content); // add data to container
                            $('ul#wrapper-artikel').find('li:last-child').not('.artikel-empty').attr('id', 'next-load');
//                            $('ul#wrapper-artikel').append('<li class="list-ads"><div class="slot-470-60">' + iframe[i][0].outerHTML + '</div></li>');
                            $('#txt-data').val(0); // set input value to 0
                        } else {
                            var string = '<ul id="wrapper-artikel" class="berita">';
                            $.each($.old_content, function (key, value) {
                                string += $.old_content[key].outerHTML;
                            });
                            string += '<li class="artikel-empty">' + $('.empty').text() + '</li>';
                            string += '</ul>';
                            $('#w0').html(string);
                            $('#txt-data').val(0); // set input value to 0
//                        share_sosmed.init();
                            // for empty value
                        }

                        i = i + 1; // set i to iframe_i

                        if (i === 4) { // range nya 1 -3 , jika i = 4 maka 
                            i = 1;   // i di set menjadi 1 kembali
                        }
                        page.share();
                    })
                    .on('pjax:complete', function (contents, options) {
                        $('.pagination').remove();
                        $('#loading-bar').hide();


                    });

            $(window).bind('scroll', function (e) {
                e.preventDefault();
                if ($('ul li#next-load').length < 1) {
                    return false;
                }
                
//                var i = $('ul li#next-load').offset().top, j = $('ul li#load-page').outerHeight(), k = window.innerHeight;
//                var hasil = i+j+k;
//                console.log("ini = "+$(window).scrollTop() +" >= "+hasil);
                if ($(window).scrollTop() >= $('ul li#next-load').offset().top + $('ul li#load-page').outerHeight() - window.innerHeight) {
                    console.log('scroll');
                    if ($('#txt-data').val() == 0) {
                        $('#txt-data').val(1);
                        var qs = (function (a) {
                            if (a == '')
                                return {};
                            var b = {};
                            for (var i = 0; i < a.length; i++) {
                                var p = a[i].split('=', 2);

                                if (p.length == 1)
                                    b[p[0]] = '';
                                else
                                    b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, ' '));
                            }
                            return b;
                        })(window.location.search.substr(1).split('&'));

                        //              qs['r'] = 'berita/detail';
                        var current_page = $('ul#wrapper-artikel li').not('.list-ads').length;
                        qs['page'] = (current_page / data_perpage) + 1;
                        qs['per-page'] = data_perpage;
                        qs['pagesize'] = current_page;
                        var url = '?' + $.param(qs);
                        console.log(url);
                        $.pjax({
//                            type: 'GET',
                            url: url,
                            container: '#listberita',
//                            fragment:   '.list-view',
                            replace: false,
                            push: false,
                            scrollTo: '#w0',
                            timeout: 5000,
//                            async:  false
                        });
                    }
                }
                e.preventDefault();
            });
        },
        share: function () {
            $('.share-btn-wrap').find('span').on('click', function (event) {
                var pageUrl = $(this).attr('data-href'); //Location of this page
                pageUrl = pageUrl.replace('rmyii.rajamobil.dev', 'www.rajamobil.com');
                var pageTitle = $(this).attr('data-title'); //HTML page title
                var shareName = $(this).attr('class'); // get first class for element selected
                switch (shareName) {
                    case 'facebook':
                        page.OpenShareUrl('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(pageUrl) + '&amp;title=' + encodeURIComponent(pageTitle));
                        break;
                    case 'twitter':
                        page.OpenShareUrl('http://twitter.com/home?status=' + encodeURIComponent(pageTitle + ' ' + pageUrl));
                        break;
                }
            });
            if ($('.count_fb').is(':empty')) {
                $('.count_fb').hide();
            } else {
                $('.count_fb').show();
            }
            if ($('.count_twitter').is(':empty')) {
                $('.count_twitter').hide();
            } else {
                $('.count_twitter').show();
            }
            $('.berita li .sharer').hide();

        },
        OpenShareUrl: function (openLink) {
            //Parameters for the Popup window
            winWidth = 650;
            winHeight = 450;
            winLeft = ($(window).width() - winWidth) / 2,
                    winTop = ($(window).height() - winHeight) / 2,
                    winOptions = 'width=' + winWidth + ',height=' + winHeight + ',top=' + winTop + ',left=' + winLeft;
            window.open(openLink, 'Share This Link', winOptions); //open Popup window to share website.
            return false;
        },
        slider_headline: function () {
            $('.headline-slider').bxSlider({
                mode: 'horizontal',
                captions: true,
                auto: true,
                nextSelector: '#next',
                prevSelector: '#prev',
                pagerCustom: '#headline-pager'
            });
        },
        slider_showroompremium: function () {
            $('.showroompremiumx').bxSlider({
                mode: 'horizontal',
                captions: true,
                nextSelector: '#showroom-next',
                prevSelector: '#showroom-prev',
                pager: false,
            });
        },
//        scrollto_top: function () {
//            $(".go-top").on('click', function () {
//                $('html, body').animate({scrollTop: 0}, 'normal');
//                return false;
//            });
//        },
        googleClick: function () {
            $('#headline-pager li').on("click", function () {
                var detailUrl = $(this).data("detailurl");
                var title = $(this).children().children("span").text();
                page.googleAnalytic(detailUrl, title);
            });
        },
        googleAnalytic: function (url, title) {
            $(document).prop('title', title);
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-29765458-1']);
            _gaq.push(['_setDomainName', 'rajamobil.com']);
            _gaq.push(['_trackPageview'], url);
            _gaq.push(['_trackPageLoadTime']);
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o), m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-29765458-1', 'rajamobil.com');
            ga('send', 'pageview');
            console.log(url);
        },
        fixedmenu: function(){
            var menu = $(".subx"),
            pos = menu.offset();
            $(window).scroll(function(){
                if($(this).scrollTop() > pos.top+menu.height() && menu.hasClass('default')){
                    $(".subx").removeClass('default').addClass("fixed");
                    $(".submenu-berita").css("top","0px");
                    $(".submenu-berita").css("position","fixed");
                    $(".konten-kiri .block-iklan-160-600").css("top","50px");
                } else if($(this).scrollTop() <= pos.top && menu.hasClass('fixed')){
                    $(".subx").removeClass('fixed').addClass("default");
                    $(".submenu-berita").css("top","");
                    $(".submenu-berita").css("position","static");
                    $(".konten-kiri .block-iklan-160-600").css("top","");
                }
            });
        }
    };

    page.load_artikel();
    page.slider_headline();
    page.slider_showroompremium();
    page.skywrapper_left();
//    page.scrollto_top();
    page.fixedmenu();
    page.share();
    page.googleClick();
});


$(window).load(function () {
//    $('#iframe_1').attr('src',rajamobil.base_url+'/iframe/iklanartikellist');
    var iframe = {
        1: $('<iframe></iframe>').attr({
            src: rajamobil.base_url + '/iframe/iklanartikellist',
            id: 'iframe_1',
            width: '468',
            height: '60',
            frameborder: '0',
            allowtransparency: 'yes',
            scrolling: 'no',
            marginwidth: '0',
            marginheight: '0',
        })
    };
    $('.slot-470-60').css('background-color', '#ffffff').append(iframe[1][0].outerHTML);
});

