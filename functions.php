<?php
/**
 * Only for developer
 * @author Fazle Bari <fazlebarisn@gmail.com>
 */
if (!function_exists('dd')) {
    function dd(...$vals)
    {
        if (!empty($vals) && is_array($vals)) {
            ob_start(); // Start output buffering
            foreach ($vals as $val) {
                echo "<pre>";
                var_dump($val);
                echo "</pre>";
            }
            $output = ob_get_clean(); // Get the buffered output and clear the buffer
            echo $output; // Output the buffered content
        }
    }
}

add_action('wp_ajax_faq_term_search', function () {
    check_ajax_referer('faq_nonce', 'nonce');

    $term = sanitize_text_field($_GET['term']);
    $taxonomy = sanitize_text_field($_GET['taxonomy']);

    if (!in_array($taxonomy, ['product_cat', 'product_tag'])) {
        wp_send_json([]);
    }

    $results = get_terms([
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'name__like' => $term,
        'number'     => 10,
    ]);

    $formatted = array_map(function ($term) {
        return [
            'label' => $term->name,
            'value' => $term->term_id
        ];
    }, $results);

    wp_send_json($formatted);
});
