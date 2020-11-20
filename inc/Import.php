<?php

class WPPC_Import
{
    public static $imported_data;
    public static $str = '123';

    public function __construct()
    {
        $this->hooks();
    }

    public function hooks()
    {
        if (is_admin()) {
            add_action('wp_ajax_import', [$this, 'import']);
            add_action('admin_enqueue_scripts', [$this, 'enqueue']);
        }

        if (isset($_POST['action']) && $_POST['action'] == 'import') {
            add_filter('upload_dir', [$this, 'upload_file']);
        }
    }

    public function enqueue()
    {
        wp_register_script(
            'wppc-import',
            WPPC_URL . 'admin/js/script.js',
            ['wppc-jquery'],
            filemtime(WPPC_DIR . 'admin/js/script.js'),
            true
        );

        wp_register_script(
            'wppc-jquery',
            'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js',
            [],
            filemtime(WPPC_DIR . 'public/js/datepicker.min.js'),
            true
        );

        wp_enqueue_script('wppc-import');
        wp_enqueue_script('wppc-jquery');
    }



    public function get_csv_keys($csv_file)
    {
        if (($handle = fopen($csv_file, "r")) !== false) {
            if (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $keys = $data;
            }

            fclose($handle);

            return $keys;
        } else {
            return false;
        }
    }

    public function csv_to_array($csv_file)
    {
        $assoc_array = [];

        if (($handle = fopen($csv_file, "r")) !== false) {
            if (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $keys = $data;
            }
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $assoc_array[] = array_combine($keys, $data);
            }
            fclose($handle);

            return $assoc_array;
        } else {
            return false;
        }
    }

    public function upload_file($upload)
    {
        $upload['basedir'] = WPPC_DIR;
        $upload['baseurl'] = WPPC_URL;
        $upload['subdir'] = 'imports';
        $upload['url']  = $upload['baseurl'] . $upload['subdir'];
        $upload['path'] = $upload['basedir'] . $upload['subdir'];

        return $upload;
    }

    public function check_mimes($file)
    {
        $acceptable_mime_types = [
            'text/plain',
            'text/csv',
            'text/comma-separated-values'
        ];

        $tmp_name = $file['tmp_name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $tmp_name);

        $file_mime_type = mime_content_type($tmp_name);

        return in_array($mime_type, $acceptable_mime_types) && in_array($file_mime_type, $acceptable_mime_types);
    }

    public function insert($array)
    {
        foreach ($array as $key => $value) {
            if (is_null(get_page_by_title($value['title'], OBJECT, WPPC_Core::$post_type))) {
                $post_data = [
                    'post_type'     => WPPC_Core::$post_type,
                    'post_title'    => $value['title'],
                    'post_content'  => $value['content'],
                    'post_status'   => 'publish',
                    'post_author'   => 1
                ];

                $post_id = wp_insert_post(wp_slash($post_data));

                if (!is_wp_error($post_id)) {
                    update_post_meta($post_id, '_date', $value['date']);
                    update_post_meta($post_id, '_time_start', $value['time_start']);
                    update_post_meta($post_id, '_time_end', $value['time_end']);
                    update_post_meta($post_id, '_organizer', $value['organizer']);
                    update_post_meta($post_id, '_address', $value['address']);
                    update_post_meta($post_id, '_place', $value['place']);
                }
            }
        }
    }

    public function import()
    {
        /**
         * Проверка нонсы (случайного набора символов, отправляемого вместе с файлом)
         */
        check_ajax_referer('import_events', 'nonce');

        /**
         * Пустой массив с файлами
         */
        if (empty($_FILES[0]))
            wp_send_json_error('Файлов нет');

        /**
         * Файл
         */
        $file = $_FILES[0];

        /**
         * Проверка типа файла
         */
        if ($this->check_mimes($file)) {

            /**
             * Подключение работы с файлами WP
             */
            if (!function_exists('wp_handle_upload'))
                require_once(ABSPATH . 'wp-admin/includes/file.php');

            /**
             * Указатель, что форма не тестовая
             */
            $overrides = ['test_form' => false];

            /**
             * Загрузка файла на сервер
             */
            $movefile = wp_handle_upload($file, $overrides);

            if ($movefile && empty($movefile['error'])) {
                self::$imported_data = $this->csv_to_array($movefile['url']);
                wp_send_json_success(self::$imported_data);
            } else {
                wp_send_json_error('Не удалось загрузить файл на сервер');
            }
        } else {
            wp_send_json_error('Неверный тип файла');
        }

        return '123';
    }
}
