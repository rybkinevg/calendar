$(document).ready(function () {

    // ссылка на файл AJAX  обработчик
    var ajaxUrl = ajaxurl;
    var nonce = $('#nonce').attr('value');
    var action = $('#action').attr('value');
    var $replyContainer = $('#message');
    var $reply = $('.message-text');

    let importedData;

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

        var $table = $('.table');
        var $tableHead = $('.table-titles tr');
        var $tableBody = $('.table-body');

        // AJAX запрос
        $replyContainer.removeClass('updated error');
        $replyContainer.show('fast');
        $reply.text('Происходит загрузка файла на сервер');
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
                    $reply.text('Загрузка файла завершена');

                    importedData = respond.data;

                    const selectValues = {
                        unset: 'Не импортировать',
                        post_title: 'Название мероприятия',
                        post_content: 'Описание мероприятия',
                        post_type: 'Тип мероприятия',
                        date: 'Дата мероприятия',
                        time_start: 'Время начала мероприятия',
                        time_end: 'Время окончания мероприятия',
                        organizer: 'Организатор мероприятия',
                        address: 'Адрес мероприятия',
                        place: 'Место проведения мероприятия'
                    };

                    const getSelect = (values, id) => {
                        let options = '';
                        for (let key in values) {
                            options += `
                                <option value="${key}">${values[key]}</option>
                            `;
                        }
                        return `<select id="${id}" name="${id}">${options}<select>`;
                    };

                    for (var i = 0; i < importedData.length; i++) {
                        var item = importedData[i];

                        $tableBody.append('<tr class="row' + i + '"></tr>');

                        for (var key in item) {
                            if (i == 0) {
                                $('tr.titles').append('<td class="title"> ' + key + '</td> ');
                                $('tr.table-select').append('<td>' + getSelect(selectValues, key) + '</td>');
                            }
                            $('tr.row' + i).append('<td class="title">' + item[key] + '</td>');
                        }
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

    $("#insert").submit(function (e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        let formData = {
            action: $('#insert_action').attr('value'),
            nonce: $('#insert_nonce').attr('value'),
            data: importedData,
            formData: form.serialize()
        };

        $replyContainer.removeClass('updated error');
        $reply.text('Происходит импорт мероприятий в базу данных');
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: formData, // serializes the form's elements.
            success: function (respond) {
                if (respond.success) {
                    $replyContainer.addClass('updated');
                    $reply.text('Импорт мероприятий завершен');
                }
            }
        });


    });

    if ($('body').hasClass('post-type-events_organizer')) {
        $('#menu-posts-events, #menu-posts-events a.wp-has-submenu')
            .addClass('wp-menu-open wp-has-current-submenu wp-has-submenu')
            .removeClass('wp-not-current-submenu')
            .find("li a[href='edit.php?post_type=events_organizer']")
            .parent()
            .addClass('current');
    }

})