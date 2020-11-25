<?php

class WPSEC_Insert
{
    public function __construct()
    {
        $this->hooks();
    }

    public function hooks()
    {
        if (is_admin()) {
            add_action('wp_ajax_insert', [$this, 'insert']);
        }
    }

    public function enqueue()
    {
    }

    public function insert()
    {
        check_ajax_referer('insert', 'nonce');

        $keys = $this->clear_post_data($_POST['formData']);
        $data = $_POST['data'];

        $new_data = $this->sort_array($data, $keys);

        $this->do_insert($new_data);

        wp_send_json_success($new_data);
    }

    public function clear_post_data($post)
    {
        parse_str($post, $result);

        unset($result['action']);
        unset($result['nonce']);

        foreach ($result as $key => $value) {
            if ($value == 'unset') {
                unset($result[$key]);
            }
        }

        return $result;
    }

    public function sort_array($data, $keys)
    {
        for ($i = 0; $i < count($data); $i++) {
            foreach ($data[$i] as $key => $value) {
                if (key_exists($key, $keys)) {
                    unset($data[$i][$key]);
                    $data[$i][$keys[$key]] = $value;
                } else {
                    unset($data[$i][$key]);
                }
            }
        }

        return $data;
    }

    public function do_insert($data)
    {
        foreach ($data as $key => $value) {
            $post_data = [
                'post_type'     => WPSEC_Core::$post_type,
                'post_status'   => 'publish',
                'post_author'   => 1
            ];

            if (key_exists('post_title', $value)) {
                $post_data['post_title'] = $value['post_title'];
            }

            if (key_exists('post_content', $value)) {
                $post_data['post_content'] = $value['post_content'];
            }

            $post_id = wp_insert_post(wp_slash($post_data));

            if (!is_wp_error($post_id)) {
                if (key_exists('date', $value)) {
                    update_post_meta($post_id, '_date', $value['date']);
                }

                if (key_exists('time_start', $value)) {
                    update_post_meta($post_id, '_time_start', $value['time_start']);
                }

                if (key_exists('time_end', $value)) {
                    update_post_meta($post_id, '_time_end', $value['time_end']);
                }

                if (key_exists('organizer', $value)) {
                    update_post_meta($post_id, '_organizer', $value['organizer']);
                }

                if (key_exists('address', $value)) {
                    update_post_meta($post_id, '_address', $value['address']);
                }

                if (key_exists('place', $value)) {
                    update_post_meta($post_id, '_place', $value['place']);
                }
            }
        }
    }
}
