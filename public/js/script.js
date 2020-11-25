// Инициализация
$('.wpsec-datepicker').datepicker({
    toggleSelected: 'click',
    todayButton: new Date(),
    showOtherMonths: false,
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
        $.ajax({
            url: ajax.url,
            type: 'GET',
            data: {
                action: ajax.action,
                date: formattedDate
            },
            success: function (data) {
                $('.wpsec-list').html(data);
            },
            error: function (error) {
                console.error(error);
            }
        });

        $('.wpsec-datepicker').blur();
    }
})