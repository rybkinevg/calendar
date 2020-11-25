// Инициализация
$('.wpsec-datepicker').datepicker({
    toggleSelected: 'click',
    todayButton: new Date(),
    showOtherMonths: true,
    onRenderCell: function (date, cellType) {
        let currentDate = date.getDate();

        let currentDay = `${currentDate}`.padStart(2, "0");
        let currentMonth = date.getMonth() + 1;
        let currentYear = date.getFullYear();
        let fullDate = `${currentYear}-${currentMonth}-${currentDay}`;

        let eventDates = ajax.dates;

        if (cellType == 'day' && eventDates.indexOf(fullDate) != -1) {
            return {
                html: currentDate + '<span class="dp-note"></span>'
            }
        } else {
            return {
                disabled: true
            }
        }
    },
    onSelect: (formattedDate, date, inst) => {
        $('.wpsec-loader').addClass('show');
        $.ajax({
            url: ajax.url,
            type: 'GET',
            data: {
                action: ajax.action,
                date: formattedDate
            },
            success: function (data) {
                $('.wpsec-loader').removeClass('show');
                $('.wpsec-events').html(data);
            },
            error: function (error) {
                console.error(error);
            }
        });

        $('.wpsec-datepicker').blur();
    }
});

$('#wpsec-search').submit(function (e) {

    e.preventDefault();

    const $input = $('#wpsec-search #search').val();

    if ($input && $input.trim().length) {
        $('.wpsec-loader').addClass('show');
        $.ajax({
            url: ajax.url,
            type: 'GET',
            data: {
                action: ajax.action,
                s: $input
            },
            success: function (data) {
                $('.wpsec-loader').removeClass('show');
                $('.wpsec-events').html(data);
            },
            error: function (error) {
                console.error(error);
            }
        });
    }
});