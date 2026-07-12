<?php
defined('ABSPATH') or die('Nice Try!');
?>
<div class="wrap fbs-plugins-wrap">
    <style>
        .wp-core-ui .fbs-plugins-wrap {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
            padding: 20px 20px 20px 0 !important;
            box-sizing: border-box !important;
        }
        .wp-core-ui .fbs-plugins-header {
            margin-bottom: 2.5rem !important;
            max-width: 800px !important;
        }
        .wp-core-ui .fbs-plugins-header h1 {
            font-size: 2.25rem !important;
            font-weight: 700 !important;
            margin: 0 0 0.75rem 0 !important;
            color: #1f2937 !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }
        .wp-core-ui .fbs-plugins-header p {
            font-size: 1.1rem !important;
            color: #4b5563 !important;
            margin: 0 !important;
            line-height: 1.6 !important;
        }
        .wp-core-ui .fbs-plugins-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)) !important;
            gap: 25px !important;
            box-sizing: border-box !important;
        }
        .wp-core-ui .fbs-plugin-card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            overflow: hidden !important;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            display: flex !important;
            flex-direction: column !important;
            box-sizing: border-box !important;
        }
        .wp-core-ui .fbs-plugin-card:hover {
            transform: translateY(-6px) !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
            border-color: #d1d5db !important;
        }
        .wp-core-ui .fbs-plugin-card-header {
            padding: 30px 25px 20px 25px !important;
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            gap: 15px !important;
        }
        .wp-core-ui .fbs-plugin-icon-wrap {
            width: 54px !important;
            height: 54px !important;
            border-radius: 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex-shrink: 0 !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05) !important;
        }
        .wp-core-ui .fbs-plugin-icon-wrap svg {
            width: 28px !important;
            height: 28px !important;
            fill: #ffffff !important;
        }
        .wp-core-ui .fbs-plugin-card-header h3 {
            font-size: 1.25rem !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
            margin: 0 !important;
            line-height: 1.4 !important;
        }
        .wp-core-ui .fbs-plugin-card-body {
            padding: 0 25px 25px 25px !important;
            flex-grow: 1 !important;
            display: flex !important;
            flex-direction: column !important;
        }
        .wp-core-ui .fbs-plugin-card-body p {
            font-size: 0.925rem !important;
            color: #6b7280 !important;
            line-height: 1.6 !important;
            margin: 0 0 25px 0 !important;
            flex-grow: 1 !important;
        }
        .wp-core-ui .fbs-plugin-card-footer {
            padding: 0 25px 25px 25px !important;
            margin-top: auto !important;
        }
        .wp-core-ui .fbs-plugin-btn {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            width: 100% !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
            font-size: 0.9rem !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            box-sizing: border-box !important;
            transition: all 0.2s ease !important;
        }
        
        /* Plugin Theme Gradients */
        .wp-core-ui .bg-stockmind { background: linear-gradient(135deg, #02aab0 0%, #00cdac 100%) !important; }
        .wp-core-ui .btn-stockmind { background: #00cdac !important; color: #ffffff !important; }
        .wp-core-ui .btn-stockmind:hover { background: #02aab0 !important; }
        
        .wp-core-ui .bg-activity { background: linear-gradient(135deg, #4776e6 0%, #8e54e9 100%) !important; }
        .wp-core-ui .btn-activity { background: #8e54e9 !important; color: #ffffff !important; }
        .wp-core-ui .btn-activity:hover { background: #4776e6 !important; }
        
        .wp-core-ui .bg-secure { background: linear-gradient(135deg, #f12711 0%, #f5af19 100%) !important; }
        .wp-core-ui .btn-secure { background: #f5af19 !important; color: #ffffff !important; }
        .wp-core-ui .btn-secure:hover { background: #f12711 !important; }

        .wp-core-ui .bg-faq { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; }
        .wp-core-ui .btn-faq { background: #764ba2 !important; color: #ffffff !important; }
        .wp-core-ui .btn-faq:hover { background: #667eea !important; }

        .wp-core-ui .bg-table { background: linear-gradient(135deg, #ff0844 0%, #ffb199 100%) !important; }
        .wp-core-ui .btn-table { background: #ffb199 !important; color: #ffffff !important; }
        .wp-core-ui .btn-table:hover { background: #ff0844 !important; }

        .wp-core-ui .bg-payout { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important; }
        .wp-core-ui .btn-payout { background: #38ef7d !important; color: #ffffff !important; }
        .wp-core-ui .btn-payout:hover { background: #11998e !important; }
    </style>

    <!-- Header -->
    <div class="fbs-plugins-header">
        <h1>All Our Plugins</h1>
        <p>Explore our premium suite of WordPress and WooCommerce utilities. Built with focus on security, speed, and sales growth.</p>
    </div>

    <!-- Grid -->
    <div class="fbs-plugins-grid">

        <!-- FBS StockMind -->
        <div class="fbs-plugin-card">
            <div class="fbs-plugin-card-header">
                <div class="fbs-plugin-icon-wrap bg-stockmind">
                    <!-- Stock / Box Icon -->
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>FBS StockMind</h3>
            </div>
            <div class="fbs-plugin-card-body">
                <p>Smart Inventory & Stock Alert Manager for WooCommerce. Track low stock thresholds, send automation restock notifications, and optimize product supplies.</p>
            </div>
            <div class="fbs-plugin-card-footer">
                <a href="https://wordpress.org/plugins/fbs-stockmind/" target="_blank" class="fbs-plugin-btn btn-stockmind">
                    Learn More
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            </div>
        </div>

        <!-- FBS Activity Tracker -->
        <div class="fbs-plugin-card">
            <div class="fbs-plugin-card-header">
                <div class="fbs-plugin-icon-wrap bg-activity">
                    <!-- Activity / List Icon -->
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>FBS Activity Tracker</h3>
            </div>
            <div class="fbs-plugin-card-body">
                <p>Monitor user logins, settings modifications, and content updates in real-time. Keep a clean, searchable, and exportable audit trail of all site events.</p>
            </div>
            <div class="fbs-plugin-card-footer">
                <a href="https://wordpress.org/plugins/fbs-activity-tracker/" target="_blank" class="fbs-plugin-btn btn-activity">
                    Learn More
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            </div>
        </div>

        <!-- FBS Secure Optimize -->
        <div class="fbs-plugin-card">
            <div class="fbs-plugin-card-header">
                <div class="fbs-plugin-icon-wrap bg-secure">
                    <!-- Security / Speed Icon -->
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>FBS Secure Optimize</h3>
            </div>
            <div class="fbs-plugin-card-body">
                <p>All-in-one protection and performance suite. Safeguard your site against security threats, clean up database tables, and speed up loading times.</p>
            </div>
            <div class="fbs-plugin-card-footer">
                <a href="https://wordpress.org/plugins/fbs-secure-optimize/" target="_blank" class="fbs-plugin-btn btn-secure">
                    Learn More
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            </div>
        </div>

        <!-- Product FAQ for WooCommerce -->
        <div class="fbs-plugin-card">
            <div class="fbs-plugin-card-header">
                <div class="fbs-plugin-icon-wrap bg-faq">
                    <!-- FAQ Speech Bubble Icon -->
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>Product FAQ for WooCommerce</h3>
            </div>
            <div class="fbs-plugin-card-body">
                <p>Answer customer questions directly on single product pages. Group questions, design beautiful accordions, and decrease pre-sale queries instantly.</p>
            </div>
            <div class="fbs-plugin-card-footer">
                <a href="https://wordpress.org/plugins/product-faq-for-woocommerce/" target="_blank" class="fbs-plugin-btn btn-faq">
                    Active Plugin
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            </div>
        </div>

        <!-- Product Table for Group Products -->
        <div class="fbs-plugin-card">
            <div class="fbs-plugin-card-header">
                <div class="fbs-plugin-icon-wrap bg-table">
                    <!-- Grid / Table Icon -->
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="3" width="18" height="18" rx="2" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="9" y1="3" x2="9" y2="21" stroke="#ffffff" stroke-width="2"/>
                        <line x1="15" y1="3" x2="15" y2="21" stroke="#ffffff" stroke-width="2"/>
                        <line x1="3" y1="9" x2="21" y2="9" stroke="#ffffff" stroke-width="2"/>
                        <line x1="3" y1="15" x2="21" y2="15" stroke="#ffffff" stroke-width="2"/>
                    </svg>
                </div>
                <h3>Product Table For Group Products</h3>
            </div>
            <div class="fbs-plugin-card-body">
                <p>Enhance group products with table-style listings. Allow customers to compare items and purchase combinations easily on a single screen.</p>
            </div>
            <div class="fbs-plugin-card-footer">
                <a href="https://wordpress.org/plugins/product-table-for-group-products/" target="_blank" class="fbs-plugin-btn btn-table">
                    Learn More
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            </div>
        </div>

        <!-- Export Payout For AffiliateWp -->
        <div class="fbs-plugin-card">
            <div class="fbs-plugin-card-header">
                <div class="fbs-plugin-icon-wrap bg-payout">
                    <!-- Export / Money Icon -->
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="4" width="18" height="16" rx="2" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="16" y1="2" x2="16" y2="4" stroke="#ffffff" stroke-width="2"/>
                        <line x1="8" y1="2" x2="8" y2="4" stroke="#ffffff" stroke-width="2"/>
                        <line x1="3" y1="10" x2="21" y2="10" stroke="#ffffff" stroke-width="2"/>
                        <path d="M12 14v4M10 16h4" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3>Export Payout For AffiliateWp</h3>
            </div>
            <div class="fbs-plugin-card-body">
                <p>One-click payout export utility for AffiliateWP. Easily filter payout logs by date, status, or method, and export to CSV or Excel instantly for clean bookkeeping.</p>
            </div>
            <div class="fbs-plugin-card-footer">
                <a href="https://wordpress.org/plugins/export-payout-for-affiliatewp/" target="_blank" class="fbs-plugin-btn btn-payout">
                    Learn More
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            </div>
        </div>

    </div>
</div>