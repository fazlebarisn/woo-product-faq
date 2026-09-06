<?php
defined('ABSPATH') or die('Nice Try!');
$is_pro_active = in_array( 'woo-product-faq-pro/product-faq-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
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
                <button type="button" class="nav-tab" data-target="tab-ai">🤖 AI Assistant</button>
                <?php do_action( 'woo_faq_settings_tabs' ); ?>
                <?php if ( ! $is_pro_active ) : ?>
                <button type="button" class="nav-tab" data-target="tab-analytics-mock">📊 Analytics <span class="nav-lock-icon" style="font-size: 10px; margin-left: 2px;">🔒</span></button>
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
                        <tr valign="top">
                            <th scope="row">Google FAQ Schema (JSON-LD)</th>
                            <td><?php $menu_instance->EnableSchema(); ?></td>
                        </tr>
                        <?php if ( ! $is_pro_active ) : ?>
                        <tr valign="top" class="pro-locked-row">
                            <th scope="row" style="position: relative;">
                                Live FAQ Search
                                <span class="pro-badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; font-size: 9px; font-weight: 600; padding: 2px 6px; border-radius: 4px; margin-left: 5px; text-transform: uppercase;">PRO 🔒</span>
                            </th>
                            <td>
                                <div class="pro-locked-field" style="opacity: 0.6; pointer-events: none;">
                                    <label class="switch-mock" style="position: relative; display: inline-block; width: 44px; height: 24px; margin-bottom: 5px;">
                                        <input type="checkbox" disabled checked style="opacity: 0; width: 0; height: 0;">
                                        <span class="slider-mock" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #667eea; transition: .4s; border-radius: 24px;"></span>
                                    </label>
                                </div>
                                <span class="pro-field-desc" style="display: block; font-size: 12px; color: #6b7280; margin-top: 5px;">Add a live-search bar above accordions to let users filter questions instantly. <a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" style="color: #667eea; font-weight: 500; text-decoration: none;">Upgrade to Pro</a></span>
                            </td>
                        </tr>
                        <tr valign="top" class="pro-locked-row">
                            <th scope="row" style="position: relative;">
                                Accordion Toggle Icon
                                <span class="pro-badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; font-size: 9px; font-weight: 600; padding: 2px 6px; border-radius: 4px; margin-left: 5px; text-transform: uppercase;">PRO 🔒</span>
                            </th>
                            <td>
                                <div class="pro-locked-field" style="opacity: 0.6; pointer-events: none;">
                                    <select disabled class="select-mock" style="width: 100%; max-width: 400px; height: 42px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 15px; padding: 8px 16px; background: #ffffff;">
                                        <option>Chevron Icon (Default)</option>
                                    </select>
                                </div>
                                <span class="pro-field-desc" style="display: block; font-size: 12px; color: #6b7280; margin-top: 5px;">Choose from premium toggle layouts like Plus/Minus, Arrows, or custom icons. <a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" style="color: #667eea; font-weight: 500; text-decoration: none;">Upgrade to Pro</a></span>
                            </td>
                        </tr>
                        <?php endif; ?>
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
                        <?php if ( ! $is_pro_active ) : ?>
                        <tr valign="top" class="pro-locked-row">
                            <th scope="row" style="position: relative;">
                                Active Accordion BG
                                <span class="pro-badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; font-size: 9px; font-weight: 600; padding: 2px 6px; border-radius: 4px; margin-left: 5px; text-transform: uppercase;">PRO 🔒</span>
                            </th>
                            <td>
                                <div class="pro-locked-field" style="opacity: 0.6; pointer-events: none;">
                                    <input type="text" class="color-field-mock" value="#e8edff" disabled style="background-color: #e8edff; border: 1px solid #d1d5db; border-radius: 4px; padding: 4px 8px; width: 80px; font-weight: 500;">
                                </div>
                                <span class="pro-field-desc" style="display: block; font-size: 12px; color: #6b7280; margin-top: 5px;">Customize background color of expanded/active FAQ items. <a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" style="color: #667eea; font-weight: 500; text-decoration: none;">Upgrade to Pro</a></span>
                            </td>
                        </tr>
                        <tr valign="top" class="pro-locked-row">
                            <th scope="row" style="position: relative;">
                                Active Accordion Text
                                <span class="pro-badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; font-size: 9px; font-weight: 600; padding: 2px 6px; border-radius: 4px; margin-left: 5px; text-transform: uppercase;">PRO 🔒</span>
                            </th>
                            <td>
                                <div class="pro-locked-field" style="opacity: 0.6; pointer-events: none;">
                                    <input type="text" class="color-field-mock" value="#2271b1" disabled style="background-color: #2271b1; color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px; padding: 4px 8px; width: 80px; font-weight: 500;">
                                </div>
                                <span class="pro-field-desc" style="display: block; font-size: 12px; color: #6b7280; margin-top: 5px;">Customize text/title color of expanded/active FAQ items. <a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" style="color: #667eea; font-weight: 500; text-decoration: none;">Upgrade to Pro</a></span>
                            </td>
                        </tr>
                        <tr valign="top" class="pro-locked-row">
                            <th scope="row" style="position: relative;">
                                Card Border Radius
                                <span class="pro-badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; font-size: 9px; font-weight: 600; padding: 2px 6px; border-radius: 4px; margin-left: 5px; text-transform: uppercase;">PRO 🔒</span>
                            </th>
                            <td>
                                <div class="pro-locked-field" style="opacity: 0.6; pointer-events: none;">
                                    <input type="text" value="8px" disabled style="width: 80px; text-align: center; border-radius: 4px; border: 1px solid #d1d5db; padding: 4px 8px;">
                                </div>
                                <span class="pro-field-desc" style="display: block; font-size: 12px; color: #6b7280; margin-top: 5px;">Round the corners of your accordion cards for a modern container layout. <a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" style="color: #667eea; font-weight: 500; text-decoration: none;">Upgrade to Pro</a></span>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
                <div id="tab-ai" class="tab-content">
                    <h2>🤖 AI FAQ Assistant Settings</h2>
                    <p style="color: #4b5563; font-size: 14px; margin-bottom: 20px;">
                        Connect your AI provider to instantly generate high-converting, objection-busting FAQs for your WooCommerce products in 1 click.
                    </p>
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">AI Provider</th>
                            <td><?php $menu_instance->AiProvider(); ?></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">AI Model</th>
                            <td><?php $menu_instance->AiModel(); ?></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">API Key</th>
                            <td><?php $menu_instance->AiApiKey(); ?></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Default Generation Tone</th>
                            <td><?php $menu_instance->AiTone(); ?></td>
                        </tr>
                    </table>

                    <div style="margin-top: 25px; padding: 18px; border-radius: 10px; background: linear-gradient(135deg, #f0f4ff 0%, #faf5ff 100%); border: 1px solid #e0e7ff; max-width: 650px;">
                        <h4 style="margin: 0 0 8px 0; color: #3730a3; font-size: 15px; display: flex; align-items: center; gap: 6px;">
                            <span>✨</span> How AI Generation Works on Products
                        </h4>
                        <p style="margin: 0; color: #4338ca; font-size: 13px; line-height: 1.5;">
                            When editing any WooCommerce product, open the <strong>FAQ</strong> tab and click the <strong>"✨ Generate with AI"</strong> button. The AI analyzes your product title, description, and categories to create realistic, customer-focused FAQs that resolve buyer hesitation and boost sales.
                        </p>
                    </div>
                </div>
                <?php if ( ! $is_pro_active ) : ?>
                <div id="tab-analytics-mock" class="tab-content">
                    <h2>📊 FAQ Engagement Analytics</h2>
                    <div class="analytics-mock-container" style="position: relative; border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb; padding: 20px; background: #ffffff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                        
                        <!-- Mock Dashboard Cards -->
                        <div class="mock-stats-grid" style="display: flex; gap: 15px; margin-bottom: 25px;">
                            <div class="mock-stat-card" style="flex: 1; padding: 15px; border-radius: 8px; background: #f9fafb; border: 1px solid #f3f4f6;">
                                <div style="font-size: 13px; color: #6b7280; font-weight: 500;">Total FAQ Views</div>
                                <div style="font-size: 24px; font-weight: 600; color: #1f2937; margin-top: 5px;">12,840</div>
                                <div style="font-size: 11px; color: #10b981; font-weight: 500; margin-top: 5px;">▲ 14.2% since last week</div>
                            </div>
                            <div class="mock-stat-card" style="flex: 1; padding: 15px; border-radius: 8px; background: #f9fafb; border: 1px solid #f3f4f6;">
                                <div style="font-size: 13px; color: #6b7280; font-weight: 500;">Top FAQ Conversions</div>
                                <div style="font-size: 24px; font-weight: 600; color: #1f2937; margin-top: 5px;">84.5%</div>
                                <div style="font-size: 11px; color: #10b981; font-weight: 500; margin-top: 5px;">▲ 2.8% read completion</div>
                            </div>
                            <div class="mock-stat-card" style="flex: 1; padding: 15px; border-radius: 8px; background: #f9fafb; border: 1px solid #f3f4f6;">
                                <div style="font-size: 13px; color: #6b7280; font-weight: 500;">Reduced Support Tickets</div>
                                <div style="font-size: 24px; font-weight: 600; color: #1f2937; margin-top: 5px;">32% Est.</div>
                                <div style="font-size: 11px; color: #10b981; font-weight: 500; margin-top: 5px;">▲ 124 support tickets saved</div>
                            </div>
                        </div>

                        <!-- Mock Chart Block -->
                        <div class="mock-chart-wrapper" style="height: 250px; background: #f9fafb; border-radius: 8px; border: 1px solid #f3f4f6; display: flex; align-items: flex-end; padding: 20px; position: relative;">
                            <!-- Mock SVG Graph -->
                            <svg viewBox="0 0 500 150" style="width: 100%; height: 100%; position: absolute; left: 0; bottom: 0;">
                                <defs>
                                    <linearGradient id="mock-grad" x1="0%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="0%" stop-color="rgba(102, 126, 234, 0.25)" />
                                        <stop offset="100%" stop-color="rgba(102, 126, 234, 0.0)" />
                                    </linearGradient>
                                </defs>
                                <path d="M0 130 C 50 110, 100 80, 150 95 C 200 110, 250 40, 300 60 C 350 80, 400 30, 450 15 C 480 8, 500 5, 500 5 L500 150 L0 150 Z" fill="url(#mock-grad)"></path>
                                <path d="M0 130 C 50 110, 100 80, 150 95 C 200 110, 250 40, 300 60 C 350 80, 400 30, 450 15 C 480 8, 500 5, 500 5" fill="none" stroke="rgba(102, 126, 234, 0.8)" stroke-width="3"></path>
                            </svg>
                            <div style="font-size: 11px; color: #9ca3af; position: absolute; left: 10px; top: 10px; font-weight: 500;">FAQ Views (Daily)</div>
                        </div>

                        <!-- Blur Overlay and CTA Card -->
                        <div class="analytics-mock-overlay" style="position: absolute; left: 0; top: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); display: flex; align-items: center; justify-content: center;">
                            <div class="mock-upgrade-card" style="width: 380px; background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); padding: 25px; text-align: center; box-sizing: border-box;">
                                <div style="font-size: 32px; margin-bottom: 15px;">📊</div>
                                <h4 style="font-size: 18px; font-weight: 600; color: #1f2937; margin: 0 0 10px 0;">Unlock FAQ Analytics</h4>
                                <p style="font-size: 13px; color: #6b7280; line-height: 1.5; margin: 0 0 20px 0;">
                                    Track views, expansion rates, and see which product questions your customers read the most to optimize your store conversion.
                                </p>
                                <a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" class="button-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; text-decoration: none; border-radius: 8px; padding: 10px 24px; color: #ffffff !important; font-weight: 600; font-size: 14px; display: inline-block; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3) !important; border: none; cursor: pointer;">
                                    Upgrade to Pro
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
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
                <?php do_action( 'woo_faq_settings_tab_contents' ); ?>
            </div>
        </div>
        
        <?php submit_button(); ?>
    </form>
</div>