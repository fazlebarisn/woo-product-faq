<div class="wrap fbs-faq-admin">
    <h1>Product FAQ Settings</h1>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php settings_fields('woofaq-settings-group'); ?>

        <div class="woo-faq-settings-wrap">
            <div class="woo-faq-settings-nav">
                <button type="button" class="nav-tab" data-target="tab-general">General</button>
                <button type="button" class="nav-tab" data-target="tab-design">Design</button>
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
            </div>
        </div>
        
        <?php submit_button(); ?>
    </form>
</div>