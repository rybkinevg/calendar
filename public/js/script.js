
if (typeof (calendar_data) != "undefined" && calendar_data !== null) {
    function Calendar(id, year, month) {
        var lastDay = new Date(year, month + 1, 0).getDate(),
            lastDate = new Date(year, month, lastDay),
            lastWeekNum = new Date(lastDate.getFullYear(), lastDate.getMonth(), lastDay).getDay(),
            firstWeekNum = new Date(lastDate.getFullYear(), lastDate.getMonth(), 1).getDay(),
            calendar = '<tr>',
            month = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];

        function formatDate(day, date) {
            if (day < 10) {
                day = `0${day}`;
            }
            return `${date.getFullYear()}-${date.getMonth() + 1}-${day}`;
        }

        function checkDate(date) {
            const result = calendar_data['dates_array'].filter(element => element == date);
            if (result.length > 0) {
                return true;
            } else {
                return false;
            }
        }
        if (firstWeekNum != 0) {
            for (var i = 1; i < firstWeekNum; i++) calendar += '<td>';
        } else {
            for (var i = 0; i < 6; i++) calendar += '<td>';
        }
        for (var i = 1; i <= lastDay; i++) {
            if (checkDate(formatDate(i, lastDate))) {
                calendar += `<td class="today"><a class="calendarLink" href="?date=${lastDate.getFullYear()}-${lastDate.getMonth() + 1}-${i}">${i}</a>`;
            } else {
                calendar += '<td>' + i;
            }
            if (new Date(lastDate.getFullYear(), lastDate.getMonth(), i).getDay() == 0) {
                calendar += '<tr>';
            }
        }

        for (var i = lastWeekNum; i < 7; i++) calendar += '<td>&nbsp;';
        document.querySelector('#' + id + ' tbody').innerHTML = calendar;
        document.querySelector('#' + id + ' thead td:nth-child(2)').innerHTML = month[lastDate.getMonth()] + ' ' + lastDate.getFullYear();
        document.querySelector('#' + id + ' thead td:nth-child(2)').dataset.month = lastDate.getMonth();
        document.querySelector('#' + id + ' thead td:nth-child(2)').dataset.year = lastDate.getFullYear();
        if (document.querySelectorAll('#' + id + ' tbody tr').length < 6) { // чтобы при перелистывании месяцев не "подпрыгивала" вся страница, добавляется ряд пустых клеток. Итог: всегда 6 строк для цифр
            document.querySelector('#' + id + ' tbody').innerHTML += '<tr><td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;';
        }
    }

    const calendar = calendar_data['id'];
    const month = document.querySelector('.wppc-month');
    const prevMonth = document.querySelector('.wppc-prev-month');
    const nextMonth = document.querySelector('.wppc-next-month');

    Calendar(
        calendar,
        new Date().getFullYear(),
        new Date().getMonth()
    );
    // переключатель минус месяц
    prevMonth.onclick = function () {
        Calendar(
            calendar,
            month.dataset.year,
            parseFloat(month.dataset.month) - 1
        );
    }
    // переключатель плюс месяц
    nextMonth.onclick = function () {
        Calendar(
            calendar,
            month.dataset.year,
            parseFloat(month.dataset.month) + 1
        );
    }
}