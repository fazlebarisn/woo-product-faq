<?php

namespace Woo\Faq\Admin;

class AdminNotice{
    public function __construct(){

        if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
        }
        
        // Show pro promotion notice occasionally
        add_action( 'admin_notices', [ $this, 'pro_promotion_notice' ] );

        // Show review request notice after 7 days of installation
        add_action( 'admin_notices', [ $this, 'review_request_notice' ] );
    }

    public function admin_notice_missing_main_plugin(){
        $class = 'notice notice-error';
        $message = __( "Product FAQ for WooCommerce Requires WooCommerce to be Activated", "product-faq-for-woocommerce" );
     
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    }
    
    public function pro_promotion_notice(){
        // Don't show if pro plugin is active
        if ( in_array( 'woo-product-faq-pro/product-faq-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            return;
        }
        
        // Only show on plugin pages and occasionally
        $screen = get_current_screen();
        if ( !$screen || strpos($screen->id, 'woo_') === false ) {
            return;
        }
        
        // Check if user has dismissed the notice
        $dismissed = get_user_meta(get_current_user_id(), 'woo_faq_pro_notice_dismissed', true);
        if ($dismissed) {
            return;
        }
        
        // Show notice randomly (20% chance)
        if (wp_rand(1, 5) !== 1) {
            return;
        }
        
        ?>
        <div class="notice notice-info is-dismissible woo-faq-pro-notice" style="border-left: 4px solid #667eea;">
            <div style="display: flex; align-items: center; gap: 1rem; padding: 0.5rem 0;">
                <div style="font-size: 2rem;">🚀</div>
                <div style="flex: 1;">
                    <h3 style="margin: 0 0 0.5rem 0; color: #1f2937;">Upgrade to Product FAQ Pro!</h3>
                    <p style="margin: 0; color: #6b7280;">
                        Unlock advanced features like unlimited FAQ groups, analytics, custom styling, and priority support.
                        <a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" style="color: #667eea; font-weight: 600; text-decoration: none;">
                            Get Pro Version →
                        </a>
                    </p>
                </div>
                <div>
                    <a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" class="button button-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 6px; font-weight: 600;">
                        Upgrade Now
                    </a>
                </div>
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $('.woo-faq-pro-notice').on('click', '.notice-dismiss', function() {
                $.post(ajaxurl, {
                    action: 'woo_faq_dismiss_pro_notice',
                    nonce: '<?php echo esc_js(wp_create_nonce('woo_faq_dismiss_pro_notice')); ?>'
                });
            });
        });
        </script>
        <?php
    }

    /**
     * Show review request notice after 7 days of installation
     * @since 1.3.2
     */
    public function review_request_notice(){
        // Only show if user has permission
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // Check if user has dismissed the notice
        $dismissed = get_user_meta(get_current_user_id(), 'woo_faq_review_notice_dismissed', true);
        if ($dismissed) {
            return;
        }

        // Only show if plugin has been installed for 7 days or more
        $installed_time = get_option( 'woo_faq_installed' );
        if ( ! $installed_time || ( time() - $installed_time ) < 7 * DAY_IN_SECONDS ) {
            return;
        }

        ?>
        <style>
        .woo-faq-review-notice {
            border-left-color: #4caf50 !important;
            padding: 15px 20px !important;
            margin: 15px 20px 15px 0 !important;
            background: #fff !important;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1) !important;
            border-radius: 4px !important;
        }
        .woo-faq-review-notice h3 {
            margin: 0 0 5px 0 !important;
            color: #1f2937 !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            line-height: 1.4 !important;
        }
        .woo-faq-review-notice p {
            margin: 0 !important;
            color: #6b7280 !important;
            font-size: 13px !important;
            line-height: 1.5 !important;
        }
        .woo-faq-review-notice .button-primary {
            background: #4caf50 !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 8px 16px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #fff !important;
            cursor: pointer !important;
            text-decoration: none !important;
            display: inline-block !important;
            height: auto !important;
            line-height: 1.4 !important;
            margin: 0 !important;
            box-sizing: border-box !important;
            box-shadow: none !important;
            text-shadow: none !important;
            transition: background 0.2s ease !important;
        }
        .woo-faq-review-notice .button-primary:hover {
            background: #43a047 !important;
            color: #fff !important;
        }
        .woo-faq-review-notice .woo-faq-review-dismiss {
            color: #6b7280 !important;
            text-decoration: none !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            margin-left: 10px !important;
            line-height: 1.4 !important;
            display: inline-block !important;
        }
        .woo-faq-review-notice .woo-faq-review-dismiss:hover {
            color: #1f2937 !important;
        }
        </style>
        <div class="notice notice-info is-dismissible woo-faq-review-notice">
            <div style="display: flex; align-items: center; gap: 1rem; padding: 0.5rem 0;">
                <div style="font-size: 2rem;">⭐</div>
                <div style="flex: 1;">
                    <h3>Enjoying Product FAQ for WooCommerce?</h3>
                    <p>
                        We hope our plugin is helping you organize FAQs and boost conversions. If you like it, please leave us a 5-star review on WordPress.org. It helps us keep the free version alive!
                    </p>
                </div>
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <a href="https://wordpress.org/support/plugin/product-faq-for-woocommerce/reviews/?filter=5#new-post" target="_blank" class="button button-primary" style="background: #4caf50; border: none; border-radius: 6px; font-weight: 600; text-decoration: none;">
                        Sure, I'd love to!
                    </a>
                    <a href="#" class="woo-faq-review-dismiss" style="color: #6b7280; text-decoration: none; font-size: 13px; margin-left: 0.5rem; font-weight: 500;">
                        No, thanks
                    </a>
                </div>
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            function dismissReviewNotice() {
                $.post(ajaxurl, {
                    action: 'woo_faq_dismiss_review_notice',
                    nonce: '<?php echo esc_js(wp_create_nonce('woo_faq_dismiss_review_notice')); ?>'
                });
                $('.woo-faq-review-notice').fadeTo(100, 0, function() {
                    $(this).slideUp(100, function() {
                        $(this).remove();
                    });
                });
            }

            $('.woo-faq-review-notice').on('click', '.notice-dismiss, .woo-faq-review-dismiss', function(e) {
                e.preventDefault();
                dismissReviewNotice();
            });
        });
        </script>
        <?php
    }
}
