<?php

/**
 * Search taxonomy
 * @author Fazle Bari <fazlebarisn@gmail.com>
 */
add_action('wp_ajax_faq_term_search', function () {
    check_ajax_referer('faq_nonce', 'nonce');

    $term     = isset($_GET['term']) ? sanitize_text_field(wp_unslash($_GET['term'])) : '';
    $taxonomy = isset($_GET['taxonomy']) ? sanitize_text_field(wp_unslash($_GET['taxonomy'])) : '';

    $allowed_taxonomies = apply_filters( 'woo_faq_archive_taxonomies', [
        'product_cat' => __( 'Category', 'product-faq-for-woocommerce' ),
        'product_tag' => __( 'Tag', 'product-faq-for-woocommerce' ),
    ] );

    if (!array_key_exists($taxonomy, $allowed_taxonomies)) {
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

/**
 * Handle dismissing pro promotion notice
 * @author Fazle Bari <fazlebarisn@gmail.com>
 */
add_action('wp_ajax_woo_faq_dismiss_pro_notice', function () {
    check_ajax_referer('woo_faq_dismiss_pro_notice', 'nonce');
    
    $user_id = get_current_user_id();
    if ($user_id) {
        update_user_meta($user_id, 'woo_faq_pro_notice_dismissed', true);
    }
    
    wp_send_json_success();
});

/**
 * Handle dismissing review request notice
 * @author Fazle Bari <fazlebarisn@gmail.com>
 */
add_action('wp_ajax_woo_faq_dismiss_review_notice', function () {
    check_ajax_referer('woo_faq_dismiss_review_notice', 'nonce');
    
    $user_id = get_current_user_id();
    if ($user_id) {
        update_user_meta($user_id, 'woo_faq_review_notice_dismissed', true);
    }
    
    wp_send_json_success();
});