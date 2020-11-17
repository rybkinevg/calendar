$(document).ready(function () {

    // ссылка на файл AJAX  обработчик
    var ajaxUrl = ajaxurl;
    var nonce = $('#nonce').attr('value');
    var action = $('#action').attr('value');

    var files; // переменная. будет содержать данные файлов

    // заполняем переменную данными, при изменении значения поля file
    $('#file').on('change', function () {
        files = this.files;
    });

    // обработка и отправка AJAX запроса при клике на кнопку upload_files
    $('.upload_files').on('click', function (event) {

        event.stopPropagation(); // остановка всех текущих JS событий
        event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

        // ничего не делаем если files пустой
        if (typeof files == 'undefined') return;

        // создадим данные файлов в подходящем для отправки формате
        var data = new FormData();
        for (const [key, value] of Object.entries(files[0])) {
            console.log(key, value);
        }
        $(files[0]).each(function (key, value) {
            data.append(key, value);
        });

        // добавим переменную идентификатор запроса
        data.append('action', action);
        data.append('nonce', nonce);

        var $reply = $('.ajax-reply');

        // AJAX запрос
        $reply.text('Загружаю...');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            // отключаем обработку передаваемых данных, пусть передаются как есть
            processData: false,
            // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
            contentType: false,
            // функция успешного ответа сервера
            success: function (respond) {
                alert(respond);
            }

        });

    });

})