'use strict';
$(function() {
    // tuning
    $(window).scroll(function() {
        if ($(window).scrollTop() < 300) {
            $('.tuning-prev').css('opacity', 0);
        } else {
            $('.tuning-prev').css('opacity', 1);
        }
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 350) {
            $('.tuning-next').css('opacity', 0);
        } else {
            $('.tuning-next').css('opacity', 1);
        }
    }); 

    $('.tuning i').on('click', function() {
        var date = $(this).attr('data-date') || 2015;
        $('html,body').animate({scrollTop: $('#' + date).offset().top}, 150);
        history.pushState({}, null, '#' + date);
    })

    var yearList = [];
    $('.content .year').each(function(i) {
        var $element = $(this);
        yearList[i] = {
            element: $element,
            position_min: $element.position().top
        };
    });
    for (var i = 0, n = yearList.length; i < n; i++) {
        if (i === n - 1) {
            yearList[i]['position_max'] = yearList[1]['position_min'] + 100;
        } else {
            yearList[i]['position_max'] = yearList[i + 1]['position_min'];
        }
    }
    for (var i = 0; i < yearList.length; i++) {
        yearList[i]['element'].scrollspy({
            min: yearList[i]['position_min'],
            max: yearList[i]['position_max'],
            onEnter: function(element, position) {
                $('.tuning-prev').attr('data-date', Math.min(parseInt(element.id) + 1, 2016));
                $('.tuning-next').attr('data-date', Math.max(parseInt(element.id) - 1, 2004));
            }
        });
    }

    // tips
    if ( ! utils.isMobileClient()) {
        $('nav a i').tipsy({
            gravity: 'n',
            opacity: 0.6,
            offset: 3
        });
    }
});
