<div class="wrap">
    <h1 class="wp-heading-inline">
        Импорт мероприятий
    </h1>
    <div id="message" class="notice" style="display: none;">
        <p class="message-text"></p>
    </div>
    <div style="margin-top: 30px;">
        <input id="file" type="file" name="file">
        <input id="action" type="hidden" name="action" value="import" />
        <input id="nonce" type="hidden" name="nonce" value="<?= wp_create_nonce('import_events') ?>" />
        <a href="#" class="upload_files button">Загрузить файлы</a>
    </div>

    <form id="insert">
        <input id="insert_action" type="hidden" name="action" value="insert" />
        <input id="insert_nonce" type="hidden" name="nonce" value="<?= wp_create_nonce('insert') ?>" />
        <div class="table-wrapper" style="overflow-x: auto;">
            <table class="table">
                <tbody class="table-body">
                    <tr class="table-select">

                    </tr>
                    <tr class="titles">

                    </tr>
                </tbody>
            </table>
        </div>
        <input type="submit" value="Импортировать">
    </form>

</div>