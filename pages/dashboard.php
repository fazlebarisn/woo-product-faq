<?php
defined('ABSPATH') or die('Nice Try!');
?>
<div class="wrap fbs-faq-admin">
    <h1>Product FAQ Settings</h1>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php settings_fields('woofaq-settings-group'); ?>

        <div class="woo-faq-settings-wrap">
            <div class="woo-faq-settings-nav">
                <button type="button" class="nav-tab" data-target="tab-general">General</button>
                <button type="button" class="nav-tab" data-target="tab-design">Design</button>
                <?php if ( ! in_array( 'woo-product-faq-pro/product-faq-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) : ?>
                <button type="button" class="nav-tab" data-target="tab-pro">🚀 Pro Features</button>
                <?php endif; ?>
            </div>
            <div class="woo-faq-settings-content">
                <div id="tab-general" class="tab-content">
                    <h2>General Settings</h2>
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">Product Faq</th>
                            <td><?php $menu_instance->ProductFaq(); ?></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Faq Position</th>
                            <td><?php $menu_instance->faqPosition(); ?></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Faq Heading</th>
                            <td><?php $menu_instance->Heading(); ?></td>
                        </tr>
                    </table>
                </div>
                <div id="tab-design" class="tab-content">
                    <h2>Design Settings</h2>
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">Heading Font Color</th>
                            <td><?php $menu_instance->HeadingColor(); ?></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Question Font Color</th>
                            <td><?php $menu_instance->QuestionColor(); ?></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Answer Font Color</th>
                            <td><?php $menu_instance->AnswerColor(); ?></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Heading Font Size</th>
                            <td><?php $menu_instance->HeadingFontSize(); ?></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Question Font Size</th>
                            <td><?php $menu_instance->QuestionFontSize(); ?></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Answer Font Size</th>
                            <td><?php $menu_instance->AnswerFontSize(); ?></td>
                        </tr>
                    </table>
                </div>
                <?php if ( ! in_array( 'woo-product-faq-pro/product-faq-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) : ?>
                <div id="tab-pro" class="tab-content">
                    <h2>🚀 Upgrade to Pro</h2>
                    <div class="pro-features-container">
                        <div class="pro-hero-section">
                            <div class="pro-hero-content">
                                <h3>Unlock Advanced FAQ Features</h3>
                                <p>Take your product FAQs to the next level with our Pro version. Get access to powerful features that will help you manage FAQs more efficiently and provide better customer experience.</p>
                                <a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" class="pro-upgrade-button">
                                    <span class="pro-button-text">Upgrade to Pro</span>
                                    <span class="pro-button-price">From $5</span>
                                </a>
                            </div>
                            <div class="pro-hero-image">
                                <div class="pro-icon">⭐</div>
                            </div>
                        </div>
                        
                        <div class="pro-features-grid">
                            <div class="pro-feature-card">
                                <div class="pro-feature-icon">📊</div>
                                <h4>Advanced Analytics</h4>
                                <p>Track FAQ performance, most viewed questions, and customer engagement metrics.</p>
                            </div>
                            
                            <div class="pro-feature-card">
                                <div class="pro-feature-icon">🎨</div>
                                <h4>Custom Styling</h4>
                                <p>Advanced customization options with custom CSS, themes, and layout options.</p>
                            </div>
                            
                            <div class="pro-feature-card">
                                <div class="pro-feature-icon">🔍</div>
                                <h4>Smart Search</h4>
                                <p>Add search functionality to your FAQs with intelligent filtering and suggestions.</p>
                            </div>
                            
                            <div class="pro-feature-card">
                                <div class="pro-feature-icon">📱</div>
                                <h4>Mobile Optimized</h4>
                                <p>Enhanced mobile experience with touch-friendly interactions and responsive design.</p>
                            </div>
                            
                            <div class="pro-feature-card">
                                <div class="pro-feature-icon">⚡</div>
                                <h4>Performance Boost</h4>
                                <p>Optimized loading speeds and caching for better site performance.</p>
                            </div>
                            
                            <div class="pro-feature-card">
                                <div class="pro-feature-icon">🛠️</div>
                                <h4>Priority Support</h4>
                                <p>Get dedicated support with faster response times and priority assistance.</p>
                            </div>
                        </div>
                        
                        <div class="pro-comparison-section">
                            <h3>Free vs Pro Comparison</h3>
                            <div class="comparison-table">
                                <div class="comparison-header">
                                    <div class="comparison-feature">Feature</div>
                                    <div class="comparison-free">Free</div>
                                    <div class="comparison-pro">Pro</div>
                                </div>
                                <div class="comparison-row">
                                    <div class="comparison-feature">Basic FAQ Display</div>
                                    <div class="comparison-free">✅</div>
                                    <div class="comparison-pro">✅</div>
                                </div>
                                <div class="comparison-row">
                                    <div class="comparison-feature">FAQ Groups</div>
                                    <div class="comparison-free">✅ Limited</div>
                                    <div class="comparison-pro">✅ Unlimited</div>
                                </div>
                                <div class="comparison-row">
                                    <div class="comparison-feature">Custom Styling</div>
                                    <div class="comparison-free">✅ Basic</div>
                                    <div class="comparison-pro">✅ Advanced</div>
                                </div>
                                <div class="comparison-row">
                                    <div class="comparison-feature">Analytics & Reports</div>
                                    <div class="comparison-free">❌</div>
                                    <div class="comparison-pro">✅</div>
                                </div>
                                <div class="comparison-row">
                                    <div class="comparison-feature">Search Functionality</div>
                                    <div class="comparison-free">❌</div>
                                    <div class="comparison-pro">✅</div>
                                </div>
                                <div class="comparison-row">
                                    <div class="comparison-feature">Priority Support</div>
                                    <div class="comparison-free">❌</div>
                                    <div class="comparison-pro">✅</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="pro-cta-section">
                            <h3>Ready to Upgrade?</h3>
                            <p>Join thousands of satisfied customers who have upgraded to Pro and transformed their FAQ experience.</p>
                            <a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" class="pro-cta-button">
                                Get Pro Version Now
                            </a>
                            <div class="pro-guarantee">
                                <span class="guarantee-icon">🛡️</span>
                                <span>30-day money-back guarantee</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php submit_button(); ?>
    </form>
</div>