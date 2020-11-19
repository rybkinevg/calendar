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

        console.log(data);

        var $replyContainer = $('#message');
        var $reply = $('.message-text');
        var $table = $('.table');

        // AJAX запрос
        $replyContainer.removeClass('updated error');
        $replyContainer.show('fast');
        $reply.text('Происходит загрузка и импорт данных');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: data,
            cache: false,
            // отключаем обработку передаваемых данных, пусть передаются как есть
            processData: false,
            // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
            contentType: false,
            // функция успешного ответа сервера
            success: function (respond, status, jqXHR) {
                // ОК
                if (respond.success) {
                    $replyContainer.addClass('updated');

                    const data = respond.data;

                    for (let i = 0; i < data.length; i++) {
                        console.log(data[i]);
                    }
                }
                // error
                else {
                    $replyContainer.addClass('error');
                    $reply.text('Ошибка: ' + respond.data);
                }
            },
            // функция ошибки ответа сервера
            error: function (jqXHR, status, errorThrown) {
                $replyContainer.addClass('error');
                $reply.text('Ошибка AJAX запроса: ' + status);
            }
        });

    });

    if ($('body').hasClass('post-type-organizer')) {
        $('#menu-posts-events, #menu-posts-events a.wp-has-submenu')
            .addClass('wp-menu-open wp-has-current-submenu wp-has-submenu')
            .removeClass('wp-not-current-submenu')
            .find("li a[href='edit.php?post_type=organizer']")
            .parent()
            .addClass('current');
    }

})