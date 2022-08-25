<h1>Faq Page Options</h1>
<?php settings_errors() ?>
<form method="post" action="options.php">
    <?php settings_fields('woofaq-settings-group'); ?>
    <?php do_settings_sections('woo_sfaq'); ?>
    <?php submit_button() ?>
</form>