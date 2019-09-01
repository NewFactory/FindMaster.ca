/* globals global */
jQuery(function ($) {
    var searchRequest;
    $('.search-autocomplete').autoComplete({
        minChars: 2,
        source: function (term, suggest) {
            try {
                searchRequest.abort();
            } catch (e) {
            }
            searchRequest = $.post(global.ajax, {search: term, action: 'search_site'}, function (res) {
                suggest(res.data);
            });
        }
    });
});


jQuery(function ($) {

    var note = $('.aft-schedule-note-section'),
        noteTexts = $('.aft-schedule-date-countdown').attr('data-message'),
        finalDate = $('.aft-schedule-date-countdown').attr('data-date'),
        ts = new Date(finalDate),
        newYear = true;

    if ((new Date()) > ts) {
        // The new year is here! Count towards something else.
        // Notice the *1000 at the end - time must be in milliseconds
        ts = (new Date()).getTime() + 10 * 24 * 60 * 60 * 1000;
        newYear = false;
    }

    $('.aft-schedule-date-countdown').countdown({
        timestamp: ts,
        callback: function (days, hours, minutes, seconds) {

            var message = "",
                daySingular = $("input[name=aft-day-singular]").val(),
                dayPlural = $("input[name=aft-day-plural]").val(),
                hourSingular = $("input[name=aft-hour-singular]").val(),
                hourPlural = $("input[name=aft-hour-plural]").val(),
                minuteSingular = $("input[name=aft-minute-singular]").val(),
                minutePlural = $("input[name=aft-minute-plural]").val(),
                secondSingular = $("input[name=aft-second-singular]").val(),
                secondPlural = $("input[name=aft-second-plural]").val(),
                andText = $("input[name=aft-and-text]").val();


            message += days + " " + (days == 1 ? daySingular : dayPlural) + ", ";
            message += hours + " " + (hours == 1 ? hourSingular : hourPlural) + ", ";
            message += minutes + " " + (minutes == 1 ? minuteSingular : minutePlural) + " " + andText + " ";
            message += seconds + " " + (seconds == 1 ? secondSingular : secondPlural) + " <br />";

            if (noteTexts) {
                message += noteTexts;
            }

            note.html(message);
        }
    });

});