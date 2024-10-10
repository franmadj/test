

//function toggleMenu() {
//    var $header = $('[data-ref="mobileHeader"]');
//    var $menu = $('[data-ref="navMenu"]');
//    var $icon = $('[data-ref="navButtonIcon"]');
//    var $body = $(document.body);
//    var noScrollClass = 'no-scroll';
//
//
//
//    if ($menu.hasClass('-disabled')) {
//        $body.addClass(noScrollClass)
//        $icon.addClass('-active')
//        $header.css('zIndex', 5)
//        $menu.removeClass('-disabled')
//        $menu.addClass('-disabledd')
//    } else {
//        $body.removeClass(noScrollClass)
//        //$icon.addClass('-disabled')
//        $header.removeAttr('style')
//        $menu.addClass('-disabled')
//        $icon.removeClass('-active')
//    }
//
//
//}











var locations = [];
let email_checked = false;
let user_exists = false;
jQuery(document).ready(function ($) {

    if (script_custom_object.is_menu_item) {
        $('html').css('overflow-y', 'hidden')

    }

    $('.hero__arrow').click(function () {
        let focus = $(this).data('focus');
        if ($('a[href="' + focus + '"]').length)
            $('a[href="' + focus + '"]').focus()

    })

    $('.image-hotspot').click(function () {
        if ('false' == $(this).attr('aria-pressed')) {
            $('.image-hotspot').attr('aria-pressed', 'false')
            $(this).attr('aria-pressed', 'true')
        } else {
            $('.image-hotspot').attr('aria-pressed', 'false')
        }
    });
    //data-ref="modalTwoClose"

    $('button[data-ref="experienceModal"]').click(function () {
        $('div[data-ref="modalTwoClose"]').focus()
    })

    $('div[data-ref="modalTwoClose"]').keydown(function (e) {
        var key = getKeyCode(event);
        if ('Enter' == key) {
            $(this).click()

        }

    });

    $('.u-reveal-locations').keydown(function (e) {
        var key = getKeyCode(event);

        if ('Enter' == key) {

            let next_el = $($('.c-locations__item--hidden')[0]);
//        let class_focus='next-focus-' + next_el.data('index')
//        next_el.addClass(class_focus)
//        console.log($($('.c-locations__item--hidden')[0]));
            $(this).click()
            setTimeout(function () {
                next_el.focus()
            }, 600)
        }


    });







    if ($('.menu-inner').length)
        window.addEventListener("keydown", function (event) {
            var key = getKeyCode(event);

            if ('Escape' == key) {
                $('.-active').removeClass('-active')
                $('.side-panel').addClass('-disabled')
            }


        }, true);

    $('.menu-categories__button').click(function () {
        $($(this).attr('href')).find('.menu-directory__cta').focus()

    })

    setTimeout(function () {
        $('#__HAPPYFOX_WIDGET_BADGE__').attr('role', 'button')
    }, 2000)

    setTimeout(function () {
        $('.ihhnqt').focus()
    }, 3000)


//    var menuItems = document.querySelectorAll('li.has-submenu');
//    console.log('menuItems',menuItems);
//    Array.prototype.forEach.call(menuItems, function (el, i) {
//        el.querySelector('a').addEventListener("click", function (event) {
//            event.preventDefault();
//            console.log('className',this.parentNode.className.includes("has-submenu"));
//            if (this.parentNode.className.includes("has-submenu")) {
//                this.parentNode.className = "nav__list-item has-dropdown has-submenu open";
//                this.setAttribute('aria-expanded', "true");
//            } else {
//                this.parentNode.className = "nav__list-item has-dropdown has-submenu";
//                this.setAttribute('aria-expanded', "false");
//            }
//            
//            return false;
//        });
//    });

    $('.has-submenu .nav__link').click(function (e) {
        console.log(e.originalEvent.detail);
        if (e.originalEvent.detail === 0) {
            e.stopPropagation();
            // keyboard "click" event
            console.log('.has-submenu .nav__link');
            e.preventDefault();
            let parent = $(this).parent();
            if (parent.hasClass('open')) {
                parent.removeClass('open');
                $(this).attr('aria-expanded', "false")
            } else {
                parent.addClass('open');
                $(this).attr('aria-expanded', "true")
            }
        } else {
            // mouse "click" event
        }


    })
    $('.has-submenu .nav__link, .is-link-submenu').mouseout(function () {
        let li = $(this).closest('.has-submenu');
        li.removeClass('open');
        li.find('.sh-nav__link').attr('aria-expanded', "false")

    })
    $('.has-submenu .nav__link, .is-link-submenu').blur(function () {
        let li = $(this).closest('.has-submenu');
        setTimeout(() => {
            console.log($(document.activeElement), $(document.activeElement).hasClass('is-link-submenu'));
            if (!$(document.activeElement).hasClass('is-link-submenu')) {
                if (li.hasClass('open')) {
                    li.removeClass('open');
                    li.find('.sh-nav__link').attr('aria-expanded', "false")
                }
            }
        }, 100);
    })

//    $('.is-link-submenu').blur(function () {
//        setTimeout(() => {
//            console.log($(document.activeElement), $(document.activeElement).hasClass('is-link-submenu'));
//            if (!$(document.activeElement).hasClass('is-link-submenu')) {
//                if (parent.hasClass('open')) {
//                    parent.removeClass('open');
//                    $(this).attr('aria-expanded', "false")
//                }
//            }
//        }, 100);
//        
//    });




    $('*_').focus(function () {
        if ($(this).hasClass('gd-subnav__link') || $(this).hasClass('gd-nav__link'))
            $(this).next().attr('style', 'display:block');
        else
            $(this).next().attr('style', '');
    })

//    $('.has-dropdown').click(function(e){ 
//        e.preventDefault()
//        console.log(event.which);
//        
//        
//    })

    $('#order_comments').keyup(function () {
        let count = $(this).val().length
        $('.u-chars-count').text(count + '/' + (100))
        if (count > 99)
            return false;
    })




    /*SET DEVICE TYPE*/
    if (!isMobileDevice()) {
        $('body').addClass('desktop-device')
    } else {
        $('body').addClass('mobile-device')
        if ('iOS' == getMobileOS())
            $('body').addClass('ios-device')
        else
            $('body').addClass('android-device')
    }

    let checkGoogleTranslatorTopBar = setInterval(function () {
        if ($('.skiptranslate').length) {
            clearInterval(checkGoogleTranslatorTopBar);
            $('.skiptranslate').remove()
            $('body').css('top', '0')
        }

    }, 100);


    if ($('#resturant-select').length) {
        //delete window.choices['RestaurantID0'];
        //La llamada AJAX

        $.ajax({
            type: "post",
            url: wc_add_to_cart_params.ajax_url,
            data: {
                action: "get_locations_dropdown",
            },
            error: function (response) {

            },
            success: function (response) {
                // Actualiza el mensaje con la respuesta
                $('#resturant-select').html(response);

                $('#restref').val($($('#resturant-select option')[0]).val());

                if (!isMobileDevice()) {
                    setTimeout(function () {
                        window.choices['RestaurantID0'] = new Choices($('#resturant-select')[0], {
                            shouldSort: false,
                            shouldSortItems: false
                        })


                        //class="choices__item choices__item--selectable"




                    }, 10)
                } else if ('iOS' == getMobileOS()) {
                    const length = $($('#resturant-select option')[0]).text().length
                    updatePaddingLeft(length)
                    $('#resturant-select').change(function () {

                        var length = $(this).find("option:selected").text().length;
                        updatePaddingLeft(length)

                    });


                }

            }
        })

        function updatePaddingLeft(newLength) {
            return false;
            //console.log('*****hartford, connecticut');
            const baseLength = 21;
            const basePadding = 81;


            const diffLength = (baseLength - newLength) * 3;
            const left = basePadding + diffLength;



            //console.log(diffLength, left);

            $('#resturant-select').css('paddingLeft', left + 'px');

        }
    }

    if ($('.mobile-device').length) {
        trapModalMobileMenu();

    }






    const blockChatBoot = 'yes' == script_custom_object.block_chatbot;
    console.log('blockChatBoot ' + blockChatBoot);
    if ($('.desktop-device').length) {
        console.log('script_custom_object', script_custom_object, blockChatBoot);
        /*TRAP FOCUS IN CAMPAIGN MODAL*/
//        var focusCampaignBanner = setInterval(function () {
//            if ($('.Campaign').length) {
//                clearInterval(focusCampaignBanner);
//                trapModalCampaign();
//            }
//
//        }, 1000);


        /*CHATBOT*/
        var checkWidgetD = setInterval(function () {
            if (blockChatBoot && $('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').length) {
                $('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').parent().remove()
                clearInterval(checkWidgetD);
            }
            if ($('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').length && $('.Campaign').length) {
                clearInterval(checkWidgetD);

                //$('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').parent().css('z-index', 1)
                setInterval(function () {
                    //console.log('campaigns',$('.Campaign'), $('.Campaign').hasOwnProperty('1'), $('.Campaign').hasOwnProperty('10'), $('.Campaign')['1']);
                    if ($('.Campaign').hasOwnProperty('1') && $($('.Campaign')['1']).is(':visible'))
                        $('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').parent().css('bottom', '120px')
                    else
                        $('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').parent().css('bottom', '10px')
                }, 1000);
            }
            setTimeout(function () {
                clearInterval(checkWidgetD);
            }, 30000)
        }, 1000)
    }
    /*CHATBOT*/
    if ($('.mobile-device').length) {
        var checkWidgetM = setInterval(function () {
            if (blockChatBoot && $('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').length) {
                $('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').parent().remove()
                clearInterval(checkWidgetM);
            }
            if ($('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').length) {
                $('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').css('max-height', '520px')
            }
            if ($('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').length && $('.Campaign').length) {
                clearInterval(checkWidgetM);
                $('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').parent().css('z-index', 4)
//                setInterval(function () {
//                    console.log($('.Campaign:visible'));
//                    if ($('.Campaign:visible').length > 1)
//                        $('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').parent().css('bottom', '229px')
//                    else
//                        $('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').parent().css('bottom', '10px')
//                }, 500);
            }
            setTimeout(function () {
                clearInterval(checkWidgetM);
            }, 30000)
        }, 1000)



        var checkChatbot = setInterval(function () {
            //console.log($('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__'));
            if ($('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').width() > 0) {
                //$('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').css({'min-height':'unset'})
            } else {
                $('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').css({'min-height': 'unset'})
            }

        }, 1000)


        //goog-te-banner-frame
        var checkGoogleTransBanner = setInterval(function () {
            if ($('.goog-te-banner-frame').length) {
                clearInterval(checkGoogleTransBanner);
                $('.mobile-header').css('position', 'relative')

            }
            setTimeout(function () {
                clearInterval(checkGoogleTransBanner);
            }, 30000)
        }, 1000)

    }


    $('a[href="#donation"]').click(function () {
        window.location = "#donation"
    });
    if ('#donation' == window.location.hash) {
        $('div[data-type="donation"]').removeClass('-disabled')
        //$('#accounts_submit input[name="firstName"]').focus()


    }




    /*GROUP DINING*/

    $('div[data-type="catering"],div[data-type="hosting"],div[data-type="accounts"]').keydown(function (e) {
        if (e.key == "Escape") {
            $(this).find('.event-modal__exit').click()
        }
    })

    $('.event-modal .event-modal__exit').click(function () {
        let type = $(this).closest('.event-modal').data('type')
        console.log(type);
        $('a[href="#' + type + '"]').focus();

    })


    $('a[href="/group-dining/#host-an-event"], a[href="/group-dining/#churrascaria-catering"]').click(function () {

        if ('/group-dining/' == window.location.pathname) {
            const href = $(this).attr('href');

            if ('/group-dining/#churrascaria-catering' == href) {
                window.location.hash = '#churrascaria-catering';
                $('div[data-type="catering"]').removeClass('-disabled')
                $('#catering_form input[name="firstName"]').focus()
                $('div[data-type="catering"] .event-modal__exit').focus()
                $(window).scrollTop(0);
            }

            if ('/group-dining/#host-an-event' == href) {
                window.location.hash = '#host-an-event';
                $('div[data-type="hosting"]').removeClass('-disabled')
                $('body').addClass('modal-enabled');
                $('div[data-type="hosting"] .event-modal__exit').focus()
                $(window).scrollTop(0);

            }

        }
    });


    $('a[href="#accounts"]').click(function () {
        window.location = "#na_accounts"
        $('body').addClass('modal-enabled');
        $('div[data-type="accounts"] .event-modal__exit').focus()
        $(window).scrollTop(0);
    });
    $('a[href="#catering"]').click(function () {
        window.location = "#churrascaria-catering"
        $('body').addClass('modal-enabled');
        $('div[data-type="catering"] .event-modal__exit').focus()
        $(window).scrollTop(0);
    });
    $('a[href="#hosting"]').click(function () {
        window.location = "#host-an-event"
        $('body').addClass('modal-enabled');
        $('div[data-type="hosting"] .event-modal__exit').focus()
        $(window).scrollTop(0);
    });
    $('.event-modal__exit').click(function () {
        $('body').removeClass('modal-enabled');
        $('body').removeClass('modal-enabled');
    })




    if ('#host-an-event' == window.location.hash) {
        $('div[data-type="hosting"]').removeClass('-disabled')
        $('body').addClass('modal-enabled');
        $('div[data-type="hosting"] .event-modal__exit').focus()
        $(window).scrollTop(0);
    }
    if ('#churrascaria-catering' == window.location.hash) {
        $('div[data-type="catering"]').removeClass('-disabled')
        $('body').addClass('modal-enabled');
        $('div[data-type="catering"] .event-modal__exit').focus()
        $(window).scrollTop(0);

    }
    if ('#na_accounts' == window.location.hash) {
        $('div[data-type="accounts"]').removeClass('-disabled')
        $('div[data-type="accounts"] .event-modal__exit').focus()
        $(window).scrollTop(0);

    }

    $('svg, path').attr('tabindex', '-1')

    $('.tab-links a').click(function () {
        $('.tab-links a').attr('aria-selected', 'false');
        $(this).attr('aria-selected', 'true');

    });

    $('[data-ref="modalClose"]').attr('role', 'button')

    $('[data-ref="reserveButton"]').on('click', function () {
        $('#reserveTable').focus();
    })

    $('.c-modal-close-reserve').blur(function () {
        $('#reserveTable').focus();
    });
    $('.last-element').focus(function () {
        $(this).closest('form').find('input').filter(':visible:first').focus();
    });

//    $('*').blur(function () {
//        console.log(this);
//
//    })




    /*ADA skip to main content*/
    $('main.main').attr('id', 'main-content');
    $skip_link = $('<a href="#main-content" style="" id="skip-main-content">skip to main content</a>');
    $skip_link.focus(function () {
        $(this).css('visibility', 'visible')
    })
    $('body').prepend($skip_link);
    $(window).on('hashchange', function () {
        if ('#main-content' == window.location.hash) {
            $('#skip-main-content').addClass('is-active');
            $(window).keydown(function (e) {
                if (e.which == 9) {
                    $('#skip-main-content').removeClass('is-active');
                }
            });
        }
    })



    $('[data-ref="navButton"]').on('click', function () {
        if ($(this).find('.menu-icon').hasClass('-active')) {
            $(this).attr('aria-expanded', 'true');
            $('#nav-modal').find('.first-element').focus();
            $('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').parent().hide()
        } else {
            $(this).attr('aria-expanded', 'false')
            $('#__HAPPYFOX_WIDGET_FRAME_CONTAINER__').parent().show()
        }
    })

    $('footer').find('ul').attr('role', 'list');
    $('footer').find('li').attr('role', 'listitem');

    $('svg').attr('title', 'Image');





    /*RESERVATION WIDGET SET DEFAULT TIME 3 SLOTS AHEAD*/
    if ($('.datepicker-wai').length) {
        //DESKTOP
        var input = $('.datepicker-wai .date > input')[0]
        //var input = document.getElementById('id-textbox-1');
        //console.log('input_',input_,input);
        var currentTime = input.dataset.currenttime;
        var jumpDay = currentTime >= 2100;
        var elevenSameDay = currentTime >= 0 && currentTime < 1000;



        //////SET TIME //////
        var dd = new Date()
        if (jumpDay) {
            dd = dd.addDays(1);
            dd.setHours(11, 00, 00);

        } else if (elevenSameDay) {
            dd.setHours(11, 00, 00);
        } else {
            var dateToMilliseconds = dd.getTime();
            var addedMinutes = dateToMilliseconds + (60000 * 90);
            //This will add 90 minutes to our time.
            var dd = new Date(addedMinutes);
        }

        /****/
        var getHours = dd.getHours()
        var getMinutes = dd.getMinutes()

        if (getMinutes >= 30) {
            getMinutes = '30';
        } else {
            getMinutes = '00';
        }

        var getAmPm = 'AM'
        if (getHours <= 10) {
            getHours = '11';
            getMinutes = '00';
        } else if (getHours >= 12) {
            getAmPm = 'PM'
            if (getHours > 12)
                getHours = getHours - 12
        }

        var mkTimeInNextHour = getHours + ':' + getMinutes + ' ' + getAmPm
        mkTimeInNextHour = mkTimeInNextHour.replace(/\s/g, '')

        if (!mkTimeInNextHour)
            mkTimeInNextHour = '11:00 AM';

        $('[data-el="tableFinderTime"] option').eq(0).val(mkTimeInNextHour).text(mkTimeInNextHour)
        $('.time-picker-dropdown div.choices__list--single > div').eq(0).data('value', mkTimeInNextHour).text(mkTimeInNextHour)


        var dayOffset = 0
        ///////////////// SET DATE ///////
        var date = new Date();
        if (jumpDay) {
            date = date.addDays(1);
            date.setHours(11, 00, 00);
        }
        var today = date.getTime();
        var today = new Date(today + dayOffset);
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        var mkTodayDate = mm + '/' + dd + '/' + yyyy;
        let selecttableFinderDate = document.querySelectorAll('[data-el="tableFinderDate"]')
        Array.prototype.forEach.call(selecttableFinderDate, function (el) {
            if (!$(el).hasClass('no-default'))
                el.value = mkTodayDate
        })












    } else if ($('#resTime').length) {
        //MOBILE
        Date.prototype.addDays = function (days) {
            var date = new Date(this.valueOf());
            date.setDate(date.getDate() + days);
            return date;
        }

        var input = document.getElementById('resTime');
        var currentTime = input.dataset.currenttime;
        var jumpDay = currentTime >= 2100;
        var elevenSameDay = currentTime >= 0 && currentTime < 1000;

        //////SET TIME //////
        var dd = new Date()
        if (jumpDay) {
            dd = dd.addDays(1);
            dd.setHours(11, 00, 00);
        } else if (elevenSameDay) {
            dd.setHours(11, 00, 00);
        } else {
            var dateToMilliseconds = dd.getTime();
            var addedMinutes = dateToMilliseconds + (60000 * 90);
            //This will add 90 minutes to our time.
            var dd = new Date(addedMinutes);
        }


        var getHours = dd.getHours()
        var getMinutes = dd.getMinutes()

        if (getMinutes >= 30) {
            getMinutes = '30';
        } else {
            getMinutes = '00';
        }

        var getAmPm = 'AM'
        if (getHours <= 10) {
            getHours = '11';
            getMinutes = '00';
        } else if (getHours >= 12) {
            getAmPm = 'PM'
            if (getHours > 12)
                getHours = getHours - 12
        }
        var mkTimeInNextHour = getHours + ':' + getMinutes + ' ' + getAmPm
        $(input).val(mkTimeInNextHour);

        var dayOffset = 0

        ///////////////// SET DATE ///////
        var date = new Date();
        if (jumpDay) {
            date = date.addDays(1);
            date.setHours(11, 00, 00);
        }
        var today = date.getTime();
        var today = new Date(today + dayOffset);
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        var mkTodayDate = mm + '/' + dd + '/' + yyyy;
        $('.trigger-date').text(mkTodayDate)

    }













    /*CART QTY UPDATE*/
    $('.update-cart-qty').change(function (e) {
        let $this = $(this);
        $this.attr('readonly', true);
        if (isMobileDevice())
            $('.c-table-desktop').remove();
        else
            $('.c-table-mobile').remove();

        var data = $('.woocommerce-cart-form').serialize() + '&action=update_cart_custom';
        $.ajax({
            type: "POST",
            url: woocommerce_params.ajax_url,
            data: data,
            success: function (data)
            {
                if ('ok' == data) {
                    window.location.reload();
                } else {
                    $this.attr('readonly', false);
                    $('.woocommerce-notices-wrapper').html(`<div class="woocommerce-error" role="alert">${data}</div>`)
                    $this.val($this.data('value'));
                }
            }
        });

    });




    /*POPUP CHECKOUT FIRST*/
    $('.front-shop .c-product').on('click', function () {
        const href = $(this).data('ref');
        if (href.includes("https://shop.texasdebrazil.com")) {
            $('.checkout-first').removeClass('-disabled').data('href', href);
        } else {
            window.location = href;
        }
    });


    $('a').click(function (e) {
        if (getCookie('woocommerce_items_in_cart')) {
            if ($(this).attr('href').includes("https://shop.texasdebrazil.com")) {
                e.preventDefault();
                e.stopPropagation();
                $('.checkout-first').removeClass('-disabled').data('href', $(this).attr('href'));
                $('.checkout-first-exit').focus()
            }
        } else {
            return true;
        }
    });

    $('.checkout-first-exit').click(function () {
        $('.checkout-first').addClass('-disabled');
    });





    /*LOCATIONS*/
    $('.all-location-links a').each(function () {
        locations.push({"href": $(this).attr('href'), "location": $(this).text()});
    });
    //console.log(locations);
    if ($('#search-location').length)
        autocomplete(document.getElementById("search-location"), locations, $);

//    if ($('.search-location').length) {
//        $('.search-location').each(function (i, el) {
//            autocompleteDropdown(el, locations, $);
//
//        });
//
//
//    }
    $('.selecting-international').click(function (e) {
        if ($('.u-finder__address').val().length) {
            e.stopPropagation();
            window.location = '/locations/?international=act'
        }

    });
    /*PRESELECT "INTERNATIONAL ONLY" WHEN "?international=act" IN THE URL*/
    function get(name) {
        if (name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search))
            return decodeURIComponent(name[1]);
    }
    var international = get('international');
    if (typeof international != 'undefined') {

        setTimeout(function () {
            $('.selecting-international').trigger('click');
        }, 2000)
    }



    /*ADMIN HIDE MENUS*/
    $('#menu-posts-specials,#menu-posts-locations,#menu-posts-host_event,#menu-posts-cattering-submission,#menu-posts-na_submission,#menu-posts-awards,#menu-posts-faqs,#menu-posts-contact_submission,#menu-posts-themes,#menu-posts-leasing_expansion,#menu-posts-e_club,#menu-posts-donations').hide();




    if ($('#u-eclub-submit1').length) {
        var form = document.getElementById('u-eclub-submit1');
        $('input, select').blur(function () {
            $('.u-form-check__input').next().removeClass('active-check');
            setTimeout(function () {
                if ($(document.activeElement).hasClass('u-form-check__input')) {
                    $('.u-form-check__input').next().addClass('active-check');
                    form.addEventListener("keydown", listenEnterConditions);
                } else {
                    form.removeEventListener("keydown", listenEnterConditions);
                }
            }, 100)
        });

        function listenEnterConditions(e) {
            var key = getKeyCode(e);
            if (key == 'Enter') {
                if ($('#conditions').is(':checked')) {
                    $('#conditions').attr('checked', false).change();
                } else {
                    $('#conditions').attr('checked', true).change();
                }
                e.preventDefault();
                //e.stopPropagation();
                return false;
            }
        }
    }


    if ($('#variations_form').length) {
        var form = document.getElementById('variations_form');
        $('select[name="attribute_denominations"]').focus();
        form.addEventListener("keydown", listenTabVariations);


        function listenTabVariations(event) {
            setTimeout(function () {
                var key = getKeyCode(event);
                if (key == 'Tab') {
                    if ($(document.activeElement).hasClass('theme-simulation')) {
                        form.addEventListener("keydown", listenThemeNavigation);
                    } else {
                        form.removeEventListener("keydown", listenThemeNavigation);
                    }
                }
            }, 200)
        }
        function listenThemeNavigation(e) {
            var key = getKeyCode(e);
            if ('ArrowUp' == key) {
                e.preventDefault();
                var $target = $('.c-option__thumb--selected').prev('.c-option__thumb').prev('.c-option__thumb').prev('.c-option__thumb').prev('.c-option__thumb');
                if ($target.length) {
                    $('.c-option__thumb--selected').removeClass('c-option__thumb--selected');
                    $target.addClass('c-option__thumb--selected');
                    $('#theme-id').val($target.data('id'));
                }
            } else if ('ArrowDown' == key) {
                e.preventDefault();
                var $target = $('.c-option__thumb--selected').next('.c-option__thumb').next('.c-option__thumb').next('.c-option__thumb').next('.c-option__thumb');
                if ($target.length) {
                    $('.c-option__thumb--selected').removeClass('c-option__thumb--selected');
                    $target.addClass('c-option__thumb--selected');
                    $('#theme-id').val($target.data('id'));
                }
            }
            if ('ArrowLeft' == key) {
                e.preventDefault();
                var $target = $('.c-option__thumb--selected').prev('.c-option__thumb');
                if ($target.length) {
                    $('.c-option__thumb--selected').removeClass('c-option__thumb--selected');
                    $target.addClass('c-option__thumb--selected');
                    $('#theme-id').val($target.data('id'));
                }



            } else if ('ArrowRight' == key) {
                e.preventDefault();
                var $target = $('.c-option__thumb--selected').next('.c-option__thumb');
                if ($target.length) {
                    $('.c-option__thumb--selected').removeClass('c-option__thumb--selected');
                    $target.addClass('c-option__thumb--selected');
                    $('#theme-id').val($target.data('id'));
                }


            }

        }
    }


    //







    var dayPosition = 0;
    $('.datepicker').click(function () {
        dayPosition = 0;
    });
    if ($('.find-date-selector').length)
        window.addEventListener("keydown", function (event) {
            var key = getKeyCode(event);
            if ($('.find-date-selector').length) {
                //ArrowRight,ArrowLeft
                if ('ArrowRight' == key) {
                    dayPosition++;
                    $(".find-date-selector").datepicker("setDate", "+" + dayPosition);



                } else if ('ArrowLeft' == key) {
                    dayPosition--;
                    $(".find-date-selector").datepicker("setDate", "+" + dayPosition);


                }


            }


        }, true);

    $('.reserve-with-location').click(function () {
        $('#resturant-select option').eq(0)
                .val($(this).data('valor'))
                .text($(this).data('title'))
                .parent()
                .next().find('div.choices__item--selectable')
                .data('value', $(this).data('valor'))
                .text($(this).data('title'))



    });

    $('#catering_starttime option,#catering_endtime option').each(function (i, el) {
        $(this).data('index', i);
    });

    $('#catering_starttime').change(function () {
        let index = $('#catering_starttime option:selected').data('index');
        if (index > 22)
            index = 22;
        let end_time = $('#catering_starttime option').eq(parseInt(index) + 4).val();
        $('#catering_endtime').val(end_time);
    });


    $('#starttime option,#endtime option').each(function (i, el) {
        $(this).data('index', i);
    });

    $('#starttime').change(function () {
        let index = $('#starttime option:selected').data('index');
        if (index > 22)
            index = 22;
        let end_time = $('#starttime option').eq(parseInt(index) + 4).val();
        $('#endtime').val(end_time);
    });

    var w_width = $(window).width();
    if (w_width > 400) {
        $('.tx-mobile-view').remove();
    } else {
        $('body').addClass('mobile-view');
        $('.tx-desktop-view').remove();
        $('.event-modal__inner').css({"padding-left": "2rem", "padding-right": "2rem"})
    }




//    if ($('.body--cart.mobile-view').length)
//        $('[data-ref="navButton"]').on('click', function () {
//            toggleMenu();
//        })
    $('[data-ref="navButton"]').on('click', function () {
        let $html = $('html');
        let noScrollClass = 'no-scroll';
        let $menu = $('[data-ref="navMenu"]');
        if (!$menu.hasClass('-disabled')) {
            $html.addClass(noScrollClass)

        } else {
            $html.removeClass(noScrollClass)

        }
    })

//    if ($('.specials-page').length) {
//
//        setTimeout(function () {
//            $('.main').css('minHeight', '3248px');
//        }, 500);
//
//    }

//    if (!$('.body--cart').length && !$('.eclub').length)
//        $(window).scroll(function (e) {
//
//
//
//            if ($(window).scrollTop()) {
//                $('.header__mobile-logo').css('opacity', 0);
//
//            } else {
//                $('.header__mobile-logo').css('opacity', 1);
//            }
//
//
//
//        });

    function bindEvents() {//target-o-col-second
        var eclubIconsFrame = document.querySelector('[data-ref="eclub-icons"]');
        if (window.innerWidth < 999) {
            if (eclubIconsFrame)
                document.querySelector('[data-el="target-o-col-first"]').prepend(eclubIconsFrame);
            $('[data-ref="desktopHeader"]').hide();
        } else {
            $('[data-ref="mobileHeader"]').hide();
        }
    }
    bindEvents();
    $('.butcher-gallery-images img').click(function () {
        $('.c-current-card').css({'opacity': '0', 'background-image': 'url(' + $(this).data('full') + ')'}).animate({
            opacity: 1,

        }, 1000, function () {
            // Animation complete.
        });
    });

    jQuery("#order_review input[name='payment_method']").attr('checked', true);

    if ($('.reserve-with-location').length) {

        let title = $('.reserve-with-location').data('title');
        //Tyler, TEXAS
        let parts = title.split(', ');
        $('.reserve-with-location').data('title', parts[0] + ', ' + parts[1].charAt(0).toUpperCase() + parts[1].slice(1).toLowerCase())


    }




    var formattedDates = $('.date-formatted__');

    function checkValue(str, max) {
        if (str.charAt(0) !== '0' || str == '00') {
            var num = parseInt(str);
            if (isNaN(num) || num <= 0 || num > max)
                num = 1;
            str = num > parseInt(max.toString().charAt(0)) && num.toString().length == 1 ? '0' + num : num.toString();
        }
        ;
        return str;
    }

    formattedDates.each(function (i, el) {
        //console.log('formattedDates', el);

        el.addEventListener('input', function (e) {
            this.type = 'text';
            var input = this.value;
            //console.log(/\D\/$/.test(input));
            if (/\D\/$/.test(input))
                input = input.substr(0, input.length - 3);
            var values = input.split('/').map(function (v) {
                return v.replace(/\D/g, '')
            });
            if (values[0])
                values[0] = checkValue(values[0], 12);
            if (values[1])
                values[1] = checkValue(values[1], 31);
            var output = values.map(function (v, i) {
                return v.length == 2 && i < 2 ? v + ' / ' : v;
            });
            //console.log(output)
            this.value = output.join('').substr(0, 14);
        });

        el.addEventListener('blur', function (e) {
            this.type = 'text';
            var input = this.value;
            var values = input.split('/').map(function (v, i) {
                return v.replace(/\D/g, '')
            });
            var output = '';

            if (values.length == 3) {
                var year = values[2].length !== 4 ? parseInt(values[2]) + 2000 : parseInt(values[2]);
                var month = parseInt(values[0]) - 1;
                var day = parseInt(values[1]);
                var d = new Date(year, month, day);
                if (!isNaN(d)) {
                    document.getElementById('result').innerText = d.toString();
                    var dates = [d.getMonth() + 1, d.getDate(), d.getFullYear()];
                    output = dates.map(function (v) {
                        v = v.toString();
                        return v.length == 1 ? '0' + v : v;
                    }).join(' / ');
                }
                ;
            }
            ;
            this.value = output;
        });

    })





});


const trapFocus = (element, prevFocusableElement = document.activeElement) => {
    const focusableEls = Array.from(
            element.querySelectorAll(
                    'a[href]:not([disabled]), button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled])'
                    )
            );
    const firstFocusableEl = focusableEls[0];
    const lastFocusableEl = focusableEls[focusableEls.length - 1];
    let currentFocus = null;

    firstFocusableEl.focus();
    currentFocus = firstFocusableEl;

    const handleFocus = e => {
        e.preventDefault();
        // if the focused element "lives" in your modal container then just focus it
        if (focusableEls.includes(e.target)) {
            currentFocus = e.target;

        } else {
            // you're out of the container
            // if previously the focused element was the first element then focus the last 
            // element - means you were using the shift key
            if (currentFocus === firstFocusableEl) {
                lastFocusableEl.focus();
            } else {
                // you previously were focused on the last element so just focus the first one
                firstFocusableEl.focus();
            }
            // update the current focus var
            currentFocus = document.activeElement;

        }
        console.log('currentFocus', currentFocus);
    };

    const handlekeydown = function (event) {
        console.log(event.keyCode);
        if (event.keyCode == 27) {//ESC
            element.querySelector('.walhalla-close').click();
            document.removeEventListener("focus", handleFocus, true);
            document.removeEventListener("keydown", handlekeydown, true);

        }



    };



    document.addEventListener("focus", handleFocus, true);
    document.addEventListener("keydown", handlekeydown, true);


};

const trapModalCampaign = ((e) => {
    const modal = document.querySelector(".Campaign");
    if (modal)
        trapped = trapFocus(modal);
})

const trapModalMobileMenu = ((e) => {
    const modal = document.getElementById("nav-modal");
    if (modal)
        trapped = trapFocus(modal);
})












