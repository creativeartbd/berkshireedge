window.EStrap = (function (window, document, $, undefined) {
    'use strict';

    var sync1 = $('#slider-thumb');
    var sync2 = $('#preview-thumb');
    var thumbnailItemClass = '.owl-item';

    var app = {
        init: function () {
            $(window).on('scroll', app.handleSticky);
            $('.hamburger-btn').on('click', app.toggleNavDrawer);
            $('.nav-drawer-close').on('click', app.closeNavDrawer);
            $('.single-post-comment').on('click', app.toogleComment);
            $('.re-single-post-comment').on('click', app.toogleReComment);
            $('.modal-search-dialog .close-popup').on('click', app.closeSearchModal);
            $('.send-message').on('click', app.sendMessage);
            $('.click-to-copy').on('click', app.copyLink);
            $('.print-page').on('click', app.printPage);
            app.contentGallerySlider('.gallery');

            sync1.owlCarousel({
                video: true,
                startPosition: 12,
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 6000,
                autoplayHoverPause: false,
                nav: false,
                dots: true
            }).on('changed.owl.carousel', app.syncPosition);

                sync2.owlCarousel({
                    loop: true,
                    margin: 5,
                    responsiveClass: true,
                    dots: false,
                    nav:true,
                    navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
                    responsive: {
                        0: {
                            items: 3,
                            nav: true
                        },
                        600: {
                            items: 4,
                            nav: false
                        },
                        1000: {
                            items: 4,
                            nav: true,
                            loop: false,
                            margin: 20
                        }
                    },
                    onInitialized: function (e) {
                        var thumbnailCurrentItem = $(e.target).find(thumbnailItemClass).eq(this._current);
                        thumbnailCurrentItem.addClass('synced');
                    }
                })
                .on('click', thumbnailItemClass, function (e) {
                    e.preventDefault();
                    var duration = 300;
                    var itemIndex = $(e.target).parents(thumbnailItemClass).index();
                    sync1.trigger('to.owl.carousel', [itemIndex, duration, true]);
                }).on('changed.owl.carousel', function (el) {
                var number = el.item.index;
                var $owl_slider = sync1.data('owl.carousel');
                $owl_slider.to(number, 100, true);
                });


            // $('.owl-carousel').owlCarousel({
            // 	loop: true,
            // 	margin: 5,
            // 	responsiveClass: true,
            // 	dots: false,
            // 	nav:true,
            // 	navText : ['<i class='fa fa-angle-left' aria-hidden='true'></i>','<i class='fa fa-angle-right' aria-hidden='true'></i>'],
            // 	responsive: {
            // 		0: {
            // 			items: 3,
            // 			nav: true
            // 		},
            // 		600: {
            // 			items: 4,
            // 			nav: false
            // 		},
            // 		1000: {
            // 			items: 4,
            // 			nav: true,
            // 			loop: false,
            // 			margin: 20
            // 		}
            // 	}
            // });
        },
        syncPosition: function (el) {
            var $owl_slider = $(this).data('owl.carousel');
            var loop = $owl_slider.options.loop;

            var curr = '';

            if (loop) {
                var count = el.item.count - 1;
                curr = Math.round(el.item.index - (el.item.count / 2) - 0.5);
                if (curr < 0) {
                    curr = count;
                }
                if (curr > count) {
                    curr = 0;
                }
            } else {
                curr = el.item.index;
            }

            var owl_thumbnail = sync2.data('owl.carousel');
            var itemClass = '.' + owl_thumbnail.options.itemClass;


            var thumbnailCurrentItem = sync2
                .find(itemClass)
                .removeClass('synced')
                .eq(curr);

            thumbnailCurrentItem.addClass('synced');

            if (!thumbnailCurrentItem.hasClass('active')) {
                var duration = 300;
                sync2.trigger('to.owl.carousel', [curr, duration, true]);
            }
        },
        sendMessage: function (e) {
            e.preventDefault();
            var postTitle = $(this).data('title');
            window.open('mailto:your@email.com?subject=Share Post&body=' + postTitle);
        },
        printPage: function () {
            window.print();
        },
        copyLink: function () {
            var elem = $(this).data('link');

            var $temp = $('<input id="pastebin">');
            $('body').append($temp);
            $temp.val(elem).select();

            try {
                document.execCommand('copy');
                $temp.remove();
                window.alert('Copied current URL to clipboard!');
            } catch (err) {
                window.alert('unable to copy text');
            }
        },
        toogleReComment: function () {
            var that = $(this);
            that.parent().next('.post-comments').toggle();
        },
        toogleComment: function () {
            var that = $(this);
            that.parent().next('.post-comments').toggle();
        },
        handleSticky: function () {

            var window_width = $(window).width();
            var is_home_page = window.location.pathname === '/';
            var window_scroll_top = $(window).scrollTop();

            if (is_home_page) {
                if (window_width > 768) {

                    //console.log( window_scroll_top );


                    if (window_scroll_top > 4400) {
                        $('.sticky_ad').addClass('sticky_ad_class');
                    } else {
                        $('.sticky_ad').removeClass('sticky_ad_class');
                    }

                    // if ( window_scroll_top > 500 && window_scroll_top < 3100 ) {
                    // 	$('.eevorg-widget-event-container').addClass('sticky-sidebar-widget');
                    // } else  {
                    // 	$('.eevorg-widget-event-container').removeClass('sticky-sidebar-widget');
                    // }

                }

            }

            if ($(window).scrollTop() > 600) {
                $('#main-nav').addClass('sticky-header');
            } else if ($(window).scrollTop() < 300) {
                $('#main-nav').removeClass('sticky-header');
            }

        },
        toggleNavDrawer: function () {
            var $nav_drawer = $('#nav-drawer');
            $nav_drawer.toggleClass('open');
        },
        closeNavDrawer: function () {
            var $nav_drawer = $('#nav-drawer');
            $nav_drawer.removeClass('open');
        },
        closeSearchModal: function () {
            var $search_modal = $('.header-popup-nav-wrapper');
            $search_modal.removeClass('show').hide();
        },
        contentGallerySlider: function ($selector) {
            $($selector).slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 2000,
                fade: true
            });
        }
    };

    $(document).ready(app.init);
    return app;
})(window, document, jQuery);
