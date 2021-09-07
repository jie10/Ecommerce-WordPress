/* =========== Document ready ==================== */
jQuery(document).ready(function($){
"use strict";
if ($('.countdown').length > 0) {
    $.countdown.regionalOptions[''] = {
        labels: [
            nasa_countdown_l10n.years,
            nasa_countdown_l10n.months,
            nasa_countdown_l10n.weeks,
            nasa_countdown_l10n.days,
            nasa_countdown_l10n.hours,
            nasa_countdown_l10n.minutes,
            nasa_countdown_l10n.seconds
        ],
        labels1: [
            nasa_countdown_l10n.year,
            nasa_countdown_l10n.month,
            nasa_countdown_l10n.week,
            nasa_countdown_l10n.day,
            nasa_countdown_l10n.hour,
            nasa_countdown_l10n.minute,
            nasa_countdown_l10n.second
        ],
        compactLabels: ['y', 'm', 'w', 'd'],
        whichLabels: null,
        digits: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
        timeSeparator: ':',
        isRTL: true
    };

    $.countdown.setDefaults($.countdown.regionalOptions['']);
    
    $('.countdown').each(function () {
        var count = $(this);
        if (!$(count).hasClass('countdown-loaded')) {
            var austDay = new Date(count.data('countdown'));
            $(count).countdown({
                until: austDay,
                padZeroes: true
            });

            if($(count).hasClass('pause')) {
                $(count).countdown('pause');
            }

            $(count).addClass('countdown-loaded');
        }
    });
}
});