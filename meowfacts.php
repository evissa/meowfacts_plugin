<?php
/*
Plugin Name: Meow Facts Plugin
Description: This plugin displays a random cat fact at the beginning of each post.
Version: 1.0
Author: Evisa C.
*/

// Fetchs a random cat fact from the Cat API
function get_random_cat_fact() {
    $api_url = 'https://cat-fact.herokuapp.com/facts/random?animal_type=cat&amount=1';
    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!empty($data['text'])) {
        return $data['text']; 
    } else {
        return false;
    }
}

// Displays cat fact at the beginning of each post
function display_cat_fact($content) {
    if (is_single()) {
        $cat_fact = get_random_cat_fact();
        if ($cat_fact) {
            $cat_fact_html = '<div class="cat-fact"style="padding: 20px 10px; background-color:#66D7D1; color:#6369D1; font-weight: bold;">' . esc_html($cat_fact) . '</div>';
            $content = $cat_fact_html . $content;
        }
    }
    return $content;
}
add_filter('the_content', 'display_cat_fact');
?>
