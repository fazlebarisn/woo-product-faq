<?php
defined('ABSPATH') or die('Nice Try!');

if (isset($_POST['save_woo_afaq']) && check_admin_referer('save_woo_afaq_data', 'woo_afaq_nonce')) {
    // Check if pro plugin is active first
    $is_pro_plugin_active = in_array( 'woo-product-faq-pro/product-faq-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
    
    // Only check license if pro plugin is active
    // If pro plugin is deactivated, allow saving (free limits enforced by JavaScript)
    if ( $is_pro_plugin_active ) {
        $is_license_active = false;
        if ( function_exists( 'faq_pro_is_license_active' ) ) {
            $is_license_active = faq_pro_is_license_active();
        }
        
        // Block saving if pro plugin is active but license is not
        if ( ! $is_license_active ) {
            echo '<div class="notice notice-error is-dismissible"><p>Please activate your license to use pro features.</p></div>';
            // Don't process the save, just show the error and return
            // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- wp_unslash() is used, individual sanitization happens in the loop
        } else {
            // License is active, proceed with save (unlimited)
            // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- wp_unslash() is used, individual sanitization happens in the loop
            $raw_faq_groups = isset($_POST['faq_groups']) ? wp_unslash($_POST['faq_groups']) : [];

            $faq_groups = [];

            foreach ($raw_faq_groups as $group) {
                if (empty($group['archive_type']) || empty($group['archive_terms'])) continue;

                $archive_type = sanitize_text_field($group['archive_type']);
                $archive_terms = array_map('intval', (array) $group['archive_terms']);

                $faqs = [];
                if (!empty($group['faqs']) && is_array($group['faqs'])) {
                    foreach ($group['faqs'] as $faq) {
                        $question = sanitize_text_field($faq['question'] ?? '');
                        $answer = sanitize_textarea_field($faq['answer'] ?? '');

                        if ($question && $answer) {
                            $faqs[] = compact('question', 'answer');
                        }
                    }
                }

                $faq_groups[] = [
                    'archive_type' => $archive_type,
                    'archive_terms' => $archive_terms,
                    'faqs' => $faqs,
                ];
            }

            update_option('woo_afaq_global_groups', $faq_groups);

            echo '<div class="notice notice-success is-dismissible"><p>FAQ groups saved successfully!</p></div>';
        }
    } else {
        // Pro plugin is not active, allow saving with free limits (JavaScript enforces limits)
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- wp_unslash() is used, individual sanitization happens in the loop
        $raw_faq_groups = isset($_POST['faq_groups']) ? wp_unslash($_POST['faq_groups']) : [];

        $faq_groups = [];

        foreach ($raw_faq_groups as $group) {
            if (empty($group['archive_type']) || empty($group['archive_terms'])) continue;

            $archive_type = sanitize_text_field($group['archive_type']);
            $archive_terms = array_map('intval', (array) $group['archive_terms']);

            $faqs = [];
            if (!empty($group['faqs']) && is_array($group['faqs'])) {
                foreach ($group['faqs'] as $faq) {
                    $question = sanitize_text_field($faq['question'] ?? '');
                    $answer = sanitize_textarea_field($faq['answer'] ?? '');

                    if ($question && $answer) {
                        $faqs[] = compact('question', 'answer');
                    }
                }
            }

            $faq_groups[] = [
                'archive_type' => $archive_type,
                'archive_terms' => $archive_terms,
                'faqs' => $faqs,
            ];
        }

        update_option('woo_afaq_global_groups', $faq_groups);

        echo '<div class="notice notice-success is-dismissible"><p>FAQ groups saved successfully!</p></div>';
    }
}

?>

<div class="wrap">
    <div class="fbs-product-archive-faq">
        <div class="archive-header">
            <h1>🚀 Bulk FAQ Management</h1>
            <p class="archive-description">Create FAQ groups that automatically apply to products based on categories, tags, or custom taxonomies.</p>
        </div>
        
        <!-- Pro Upgrade Banner -->
        <?php 
        $is_pro_plugin_active = in_array( 'woo-product-faq-pro/product-faq-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
        $is_license_active = false;
        if ( $is_pro_plugin_active && function_exists( 'faq_pro_is_license_active' ) ) {
            $is_license_active = faq_pro_is_license_active();
        }
        // Show upgrade banner only if pro plugin is not active (not if license is inactive)
        if ( ! $is_pro_plugin_active ) : 
        ?>
        <div class="pro-upgrade-banner">
            <div class="pro-banner-content">
                <div class="pro-banner-icon">⭐</div>
                <div class="pro-banner-text">
                    <h3>Unlock Advanced Bulk FAQ Features</h3>
                    <p>Get unlimited FAQ groups, advanced filtering, and priority support with our Pro version.</p>
                </div>
                <div class="pro-banner-action">
                    <a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" class="pro-banner-button">
                        Upgrade to Pro
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
            <div class="archive-form-container">
                <?php
                // License notice removed - SDK will show its own notice
                // Only disable form if pro plugin is active but license is not
                ?>
                <form method="post" action="" <?php echo ( $is_pro_plugin_active && ! $is_license_active ) ? 'style="opacity: 0.5; pointer-events: none;"' : ''; ?>>
                <?php wp_nonce_field('save_woo_afaq_data', 'woo_afaq_nonce'); ?>
                <div id="faq-groups-container"></div>
                <div class="form-actions">
                    <button type="button" class="button button-secondary fbs-add-faq-group" <?php echo ( $is_pro_plugin_active && ! $is_license_active ) ? 'disabled' : ''; ?>>
                        <span class="dashicons dashicons-plus-alt"></span>
                        Add FAQ Group
                    </button>
                    <input type="submit" name="save_woo_afaq" class="button button-primary" value="Save All FAQs" <?php echo ( $is_pro_plugin_active && ! $is_license_active ) ? 'disabled' : ''; ?>>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Templates -->
<script type="text/html" id="fbs-faq-group-template">
    <div class="fbs-faq-archive-group">
        <button type="button" class="button fbs-archive-remove-faq-group"><span class="dashicons dashicons-no-alt"></span></button>
        <h2>FAQ Group</h2>
        <table class="form-table">
            <tr>
                <th scope="row"><label>Archive Type</label></th>
                <td>
                    <select class="archive-type" name="faq_groups[_INDEX_][archive_type]">
                        <option value="">Select Archive Type</option>
                        <option value="product_cat">Category</option>
                        <option value="product_tag">Tag</option>
                    </select>
                </td>
            </tr>
            <tr class="archive-term-row" style="display:none;">
                <th scope="row"><label>Term</label></th>
                <td>
                    <input type="text" class="archive-term regular-text" name="" placeholder="Search..." />
                    <div class="term-suggestions"></div>
                    <div class="selected-terms"></div>
                </td>
            </tr>
        </table>

        <div class="fbs-archive-faq-items"></div>
        <p><button type="button" class="button fsb-archive-add-faq-item">Add New FAQ</button></p>
    </div>
</script>

<script type="text/html" id="fbs-archive-faq-item-template">
    <div class="fbs-archive-faq-item">
        <button type="button" class="button fbs-archive-remove-faq-item"><span class="dashicons dashicons-no-alt"></span></button>
        <p>
            <label>Question<br>
                <input type="text" name="faq_groups[_GROUP_INDEX_][faqs][_FAQ_INDEX_][question]" class="regular-text" />
            </label>
        </p>
        <p>
            <label>Answer<br>
                <textarea name="faq_groups[_GROUP_INDEX_][faqs][_FAQ_INDEX_][answer]" rows="3" class="large-text"></textarea>
            </label>
        </p>
    </div>
</script>

<?php
$saved_data = get_option('woo_afaq_global_groups', []);

if (!empty($saved_data)) {
    // Add term names to each group before sending to JS
    foreach ($saved_data as $g_index => &$group) {
        $archive_type = $group['archive_type'] ?? '';
        $term_names = [];

        if (!empty($group['archive_terms']) && taxonomy_exists($archive_type)) {
            foreach ($group['archive_terms'] as $term_id) {
                $term = get_term($term_id, $archive_type);
                if ($term && !is_wp_error($term)) {
                    $term_names[$term_id] = $term->name;
                }
            }
        }

        $group['term_names'] = $term_names;
    }
    unset($group); // Break reference
    ?>

    <script>
        jQuery(document).ready(function ($) {
            const groupTemplate = $('#fbs-faq-group-template').html();
            const faqTemplate = $('#fbs-archive-faq-item-template').html();

            const savedGroups = <?php echo json_encode($saved_data); ?>;

            $.each(savedGroups, function (gIndex, group) {
                let groupHtml = groupTemplate.replace(/_INDEX_/g, gIndex);
                const $group = $(groupHtml);

                // Set archive type
                $group.find('select.archive-type').val(group.archive_type);
                $group.find('.archive-term-row').show();

                // Populate selected terms with name
                const selectedContainer = $group.find('.selected-terms');
                const termNames = group.term_names || {};
                if (Array.isArray(group.archive_terms)) {
                    group.archive_terms.forEach(function (termId) {
                        const termName = termNames[termId] || 'Term #' + termId;
                        const termHtml = `<span class="term-pill" style="display:inline-block; margin:3px; padding:3px 8px; background:#f1f1f1; border:1px solid #ccc; border-radius:20px;" data-id="${termId}">
                            ${termName}
                            <a href="#" class="remove-term" style="margin-left:5px; color:red; text-decoration:none;">×</a>
                            <input type="hidden" name="faq_groups[${gIndex}][archive_terms][]" value="${termId}">
                        </span>`;

                        selectedContainer.append(termHtml);
                    });
                }

                // Add FAQs
                const faqs = group.faqs || [];
                const $faqContainer = $group.find('.fbs-archive-faq-items');
                $.each(faqs, function (faqIndex, faq) {
                    let faqHtml = faqTemplate
                        .replace(/_GROUP_INDEX_/g, gIndex)
                        .replace(/_FAQ_INDEX_/g, faqIndex);

                    const $faq = $(faqHtml);
                    $faq.find('input[name$="[question]"]').val(faq.question);
                    $faq.find('textarea[name$="[answer]"]').val(faq.answer);
                    $faqContainer.append($faq);
                });

                $('#faq-groups-container').append($group);
            });
        });
    </script>

    <script>
    jQuery(document).ready(function($) {
        $('form').on('submit', function(e) {
            var hasError = false;
            $('.fbs-faq-archive-group').each(function() {
                var $group = $(this);
                var archiveType = $group.find('select.archive-type').val();
                var selectedTerms = $group.find('.selected-terms input[type="hidden"]');
                if ((archiveType === 'product_cat' || archiveType === 'product_tag') && selectedTerms.length === 0) {
                    hasError = true;
                    // Show error message (only once per group)
                    if ($group.find('.fbs-term-error').length === 0) {
                        $group.find('.selected-terms').after('<div class="fbs-term-error">Please select at least one term.</div>');
                    }
                } else {
                    $group.find('.fbs-term-error').remove();
                }
            });
            if (hasError) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $('.fbs-term-error').first().offset().top - 100
                }, 300);
            }
        });
    });
    </script>
<?php } ?>
