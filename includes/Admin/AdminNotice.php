<?php

namespace Woo\Faq\Admin;

class AdminNotice{
    public function __construct(){

        if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
        }
        
        // Show pro promotion notice occasionally
        add_action( 'admin_notices', [ $this, 'pro_promotion_notice' ] );
    }

    public function admin_notice_missing_main_plugin(){
        $class = 'notice notice-error';
        $message = __( "Product FAQ for WooCommerce Requires WooCommerce to be Activated", "product-faq-for-woocommerce" );
     
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    }
    
    public function pro_promotion_notice(){
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
}
