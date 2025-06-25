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
}); 