/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var detail_berita = {
    init: function () {
        this.count_comment_fb();
    },
    
}


$(document).ready(function () {
    var page = {
        init: function(){
            
        },
        load_artikel: function () {
                $('#loading-bar').hide().css('text-align', 'center');
                $('ul#wrapper-artikel').find('li:last-child').not('.artikel-empty').attr('id', 'next-load');
                $('.pagination').remove();
                var data_perpage = $('ul#wrapper-artikel li').not('.list-ads').length;
                $(document)
                        .on('pjax:beforeSend', function (event, xhr, settings) {
                            $('#loading-bar').show();
                        })
                        .on('pjax:beforeReplace', function (contents, options) {
                            var string = contents.target.innerHTML;
                            $.old_content = $(string).find('li').not('.artikel-empty').removeAttr('id'); // get element li from response html kecuali li dengan class artikel-empty
                        })
                        .on('pjax:end', function (data, status, xhr, options) {
                            var isContains = $('.empty').length;
                            if (isContains == 0) { // jika data nya tidak kosong
//                                console.log($.old_content);
                                var list_after_load = $("ul.wrapper-list-berita li").length;
                                $('ul#wrapper-artikel').prepend($.old_content); // add data to container
                                $('ul#wrapper-artikel').find('li:last-child').not('.artikel-empty').attr('id', 'next-load');
                                $('#txt-data').val(0); // set input value to 0
                                var count_list = $("ul.wrapper-list-berita li").length - (list_after_load);
                                var list = $("ul.wrapper-list-berita li:nth-child("+count_list+")").offset().top;
//                                console.log(list);
                                $('html, body').animate({
                                        scrollTop: list
                                    }, 1000);
                            } else {
                                var string = '<ul id="wrapper-artikel" class="wrapper-list-berita">';
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
    //                        page.share();
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

                        if ($(window).scrollTop() >= $('ul li#next-load').offset().top + $('ul li#next-load').outerHeight() - window.innerHeight) {
//                        if ($(window).scrollTop() >= $('ul li#next-load').offset().top + $('ul li#load-page').outerHeight() - window.innerHeight) {
//                            console.log('scroll');
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
                                    url: url,
                                    container: '#beritalist',
                                    replace: false,
                                    push: false,
                                    scrollTo: false,
                                    timeout: 5000,
                                });
                            }
                        }
                        e.preventDefault();
                    });
        },
    };
    page.load_artikel();
});

$(window).load(function () {
    
}); // end ready function
