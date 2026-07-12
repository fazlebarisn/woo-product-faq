<?php
defined('ABSPATH') or die('Nice Try!');
?>
<div class="wrap fbs-author-wrap">
    <style>
        .wp-core-ui .fbs-author-wrap {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
            padding: 20px 20px 20px 0 !important;
            box-sizing: border-box !important;
        }
        .wp-core-ui .fbs-author-container {
            display: flex !important;
            gap: 30px !important;
            margin-top: 20px !important;
            box-sizing: border-box !important;
        }
        /* Left Card Styling */
        .wp-core-ui .fbs-author-sidebar {
            width: 320px !important;
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            padding: 30px 25px !important;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03) !important;
            text-align: center !important;
            flex-shrink: 0 !important;
            box-sizing: border-box !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }
        .wp-core-ui .fbs-author-avatar {
            width: 100px !important;
            height: 100px !important;
            border-radius: 50% !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #ffffff !important;
            font-size: 2.25rem !important;
            font-weight: 700 !important;
            margin-bottom: 20px !important;
            box-shadow: 0 10px 15px -3px rgba(102, 126, 234, 0.3) !important;
        }
        .wp-core-ui .fbs-author-sidebar h2 {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            color: #1f2937 !important;
            margin: 0 0 5px 0 !important;
            line-height: 1.2 !important;
        }
        .wp-core-ui .fbs-author-sidebar p.title {
            font-size: 0.95rem !important;
            font-weight: 500 !important;
            color: #667eea !important;
            margin: 0 0 25px 0 !important;
        }
        .wp-core-ui .fbs-author-details-list {
            width: 100% !important;
            border-top: 1px solid #f3f4f6 !important;
            padding-top: 20px !important;
            margin: 0 0 25px 0 !important;
            text-align: left !important;
        }
        .wp-core-ui .fbs-author-detail-item {
            margin-bottom: 15px !important;
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            font-size: 0.875rem !important;
            color: #4b5563 !important;
        }
        .wp-core-ui .fbs-author-detail-item svg {
            width: 18px !important;
            height: 18px !important;
            color: #9ca3af !important;
            fill: none !important;
        }
        .wp-core-ui .fbs-author-detail-item a {
            color: #4b5563 !important;
            text-decoration: none !important;
        }
        .wp-core-ui .fbs-author-detail-item a:hover {
            color: #667eea !important;
        }
        /* Right Content Area */
        .wp-core-ui .fbs-author-main {
            flex-grow: 1 !important;
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            padding: 35px !important;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03) !important;
            box-sizing: border-box !important;
        }
        .wp-core-ui .fbs-author-section {
            margin-bottom: 30px !important;
        }
        .wp-core-ui .fbs-author-section:last-child {
            margin-bottom: 0 !important;
        }
        .wp-core-ui .fbs-author-main h3 {
            font-size: 1.25rem !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
            margin: 0 0 15px 0 !important;
            padding-bottom: 8px !important;
            border-bottom: 2px solid #f3f4f6 !important;
            position: relative !important;
        }
        .wp-core-ui .fbs-author-main h3::after {
            content: '' !important;
            position: absolute !important;
            bottom: -2px !important;
            left: 0 !important;
            width: 40px !important;
            height: 2px !important;
            background: #667eea !important;
        }
        .wp-core-ui .fbs-author-main p {
            font-size: 0.95rem !important;
            color: #4b5563 !important;
            line-height: 1.7 !important;
            margin: 0 !important;
        }
        .wp-core-ui .fbs-author-skills-grid {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 10px !important;
        }
        .wp-core-ui .fbs-author-skill-tag {
            background: #f3f4f6 !important;
            color: #374151 !important;
            padding: 6px 14px !important;
            border-radius: 20px !important;
            font-size: 0.85rem !important;
            font-weight: 500 !important;
        }
        /* Social Media Icons */
        .wp-core-ui .fbs-author-socials {
            display: flex !important;
            gap: 12px !important;
            justify-content: center !important;
            width: 100% !important;
            margin-top: auto !important;
        }
        .wp-core-ui .fbs-author-social-link {
            width: 38px !important;
            height: 38px !important;
            border-radius: 50% !important;
            background: #f3f4f6 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #4b5563 !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
        }
        .wp-core-ui .fbs-author-social-link:hover {
            background: #667eea !important;
            color: #ffffff !important;
            transform: translateY(-3px) !important;
        }
        .wp-core-ui .fbs-author-social-link svg {
            width: 18px !important;
            height: 18px !important;
            fill: currentColor !important;
        }
        
        @media (max-width: 768px) {
            .wp-core-ui .fbs-author-container {
                flex-direction: column !important;
            }
            .wp-core-ui .fbs-author-sidebar {
                width: 100% !important;
            }
        }
    </style>

    <!-- Content -->
    <div class="fbs-author-container">
        
        <!-- Left Sidebar Card -->
        <div class="fbs-author-sidebar">
            <div class="fbs-author-avatar">FB</div>
            <h2>Fazle Bari</h2>
            <p class="title">WordPress &amp; Laravel Developer</p>
            
            <div class="fbs-author-details-list">
                <div class="fbs-author-detail-item">
                    <!-- Envelope SVG -->
                    <svg stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <a href="mailto:fazlebarisn@gmail.com">fazlebarisn@gmail.com</a>
                </div>
                <div class="fbs-author-detail-item">
                    <!-- Phone SVG -->
                    <svg stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>+8801717442809</span>
                </div>
                <div class="fbs-author-detail-item">
                    <!-- Location SVG -->
                    <svg stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Dhaka, Bangladesh</span>
                </div>
            </div>

            <!-- Social Links -->
            <div class="fbs-author-socials">
                <a href="https://github.com/fazlebarisn" target="_blank" class="fbs-author-social-link" title="GitHub">
                    <!-- GitHub SVG -->
                    <svg role="img" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                </a>
                <a href="https://www.linkedin.com/in/fazle-bari/" target="_blank" class="fbs-author-social-link" title="LinkedIn">
                    <!-- LinkedIn SVG -->
                    <svg role="img" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0z"/></svg>
                </a>
                <a href="https://web.facebook.com/fazle.sony" target="_blank" class="fbs-author-social-link" title="Facebook">
                    <!-- Facebook SVG -->
                    <svg role="img" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
            </div>
        </div>

        <!-- Right Content Main Card -->
        <div class="fbs-author-main">
            
            <div class="fbs-author-section">
                <h3>About Me</h3>
                <p>I am a seasoned Full Stack WordPress Developer with a strong focus on WooCommerce plugin engineering. Over the past five years, I have built highly customized, robust, and performant plugin architectures, ensuring clean code flow and compliance with WordPress standards. I pair my WordPress development with Laravel to deploy secure and scalable SaaS components, APIs, and custom integrations tailored to specialized user goals.</p>
            </div>

            <div class="fbs-author-section">
                <h3>Professional Skills</h3>
                <div class="fbs-author-skills-grid">
                    <span class="fbs-author-skill-tag">WooCommerce Plugin Engineering</span>
                    <span class="fbs-author-skill-tag">Custom WordPress Hook Architecture</span>
                    <span class="fbs-author-skill-tag">PHP &amp; Laravel Backend Development</span>
                    <span class="fbs-author-skill-tag">REST API &amp; Webhook Integrations</span>
                    <span class="fbs-author-skill-tag">JavaScript / jQuery UI Interactions</span>
                    <span class="fbs-author-skill-tag">Database Optimization &amp; Security</span>
                </div>
            </div>

            <div class="fbs-author-section">
                <h3>Our Promise</h3>
                <p>We build our plugins with three core values in mind: **performance**, **security**, and **simplicity**. Every line of code is structured to ensure it runs lightning-fast, remains secure against external threats, and provides an exceptionally clean UI/UX dashboard out-of-the-box.</p>
            </div>

        </div>

    </div>
</div>