jQuery(document).ready(function($) {
    // Tab functionality
    $('.woo-faq-settings-nav .nav-tab').on('click', function(e) {
        e.preventDefault();

        // Deactivate all tabs and content
        $('.woo-faq-settings-nav .nav-tab').removeClass('nav-tab-active');
        $('.woo-faq-settings-content .tab-content').removeClass('active');

        // Activate the clicked tab and its content
        $(this).addClass('nav-tab-active');
        var targetContent = $(this).data('target');
        $('#' + targetContent).addClass('active');

        // Save active tab to localStorage
        localStorage.setItem('wooFaqAdminActiveTab', targetContent);
    });

    // Show the last active tab, or the first tab by default
    var lastTab = localStorage.getItem('wooFaqAdminActiveTab');
    if (lastTab && $('.woo-faq-settings-nav .nav-tab[data-target="' + lastTab + '"]').length) {
        $('.woo-faq-settings-nav .nav-tab[data-target="' + lastTab + '"]').trigger('click');
    } else {
        $('.woo-faq-settings-nav .nav-tab').first().trigger('click');
    }

    // Initialize WordPress color picker
    if ($.fn.wpColorPicker) {
        $('.color-field').wpColorPicker();
    }

    // AI Connection Test Handler
    $(document).on('click', '#woo-faq-test-ai-key', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var $result = $('#woo-faq-ai-test-result');
        var provider = $('#woo_faq_ai_provider').val();
        var apiKey = $('#woo_faq_ai_api_key').val();

        if (!apiKey || apiKey.trim() === '') {
            $result.css('color', '#ef4444').text('❌ Please paste an API key first.');
            return;
        }

        $btn.prop('disabled', true).text('Testing...');
        $result.css('color', '#6b7280').text('Testing connection to ' + provider + '...');

        var ajaxUrl = typeof faqAjax !== 'undefined' && faqAjax.ajax_url ? faqAjax.ajax_url : (typeof ajaxurl !== 'undefined' ? ajaxurl : '/wp-admin/admin-ajax.php');
        var nonce = typeof faqAjax !== 'undefined' && faqAjax.nonce ? faqAjax.nonce : '';

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'woo_faq_test_ai_connection',
                nonce: nonce,
                provider: provider,
                api_key: apiKey
            },
            success: function(response) {
                $btn.prop('disabled', false).text('Test Connection');
                if (response && response.success) {
                    $result.css('color', '#10b981').text('✅ ' + response.data.message);
                } else {
                    var errMsg = response && response.data && response.data.message ? response.data.message : 'Connection failed. Please check your API key.';
                    $result.css('color', '#ef4444').text('❌ ' + errMsg);
                }
            },
            error: function(xhr, status, error) {
                $btn.prop('disabled', false).text('Test Connection');
                $result.css('color', '#ef4444').text('❌ Server request failed: ' + (error || 'Network error'));
            }
        });
    });
}); 