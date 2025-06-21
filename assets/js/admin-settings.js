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
    });

    // Show the first tab by default
    $('.woo-faq-settings-nav .nav-tab').first().trigger('click');
}); 