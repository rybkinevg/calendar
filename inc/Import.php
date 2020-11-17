<?php

class WPPC_Import
{
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

        check_ajax_referer('import_events', 'nonce'); // защита

        if (empty($_FILES))
            wp_send_json_error('Файлов нет...');

        var_dump($_POST);

        //$start = microtime(true);

        // if (wp_verify_nonce($_POST['fileup_nonce'], 'my_file_upload')) {

        //     if (!function_exists('wp_handle_upload'))
        //         require_once(ABSPATH . 'wp-admin/includes/file.php');

        //     $file = &$_FILES['my_file_upload'];

        //     $overrides = ['test_form' => false];

        //     $movefile = wp_handle_upload($file, $overrides);

        //     if ($movefile && empty($movefile['error'])) {
        //         echo '<h2>Файл успешно загружен!</h2>';
        //         self::insert(self::csv_to_array($movefile['url']));
        //         //echo 'Время выполнения скрипта: ' . round(microtime(true) - $start, 4) . ' сек.';
        //     } else {
        //         echo "Возможны атаки при загрузке файла!\n";
        //     }
        // }
    }
}
