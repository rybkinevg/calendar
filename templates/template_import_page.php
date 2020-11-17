<input id="file" type="file" name="file">
<input id="action" type="hidden" name="action" value="import" />
<input id="nonce" type="hidden" name="nonce" value="<?= wp_create_nonce('import_events') ?>" />
<a href="#" class="upload_files button">Загрузить файлы</a>
<div class="ajax-reply"></div>