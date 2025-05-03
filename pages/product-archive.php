<?php
if (isset($_POST['save_woo_afaq']) && check_admin_referer('save_woo_afaq_data', 'woo_afaq_nonce')) {
    $raw_faq_groups = $_POST['faq_groups'] ?? [];

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

// Get saved data

$saved_data = get_option('woo_afaq_global_groups', []);
// dd($saved_data); // Debugging line, remove in production
?>

<div class="wrap">
    <div class="fbs-product-archive-faq">
        <h1>Settings for Product Archive FAQ</h1>
        <form method="post" action="">
            <?php wp_nonce_field('save_woo_afaq_data', 'woo_afaq_nonce'); ?>
            <div id="faq-groups-container"></div>
            <p><button type="button" class="button" id="fbs-add-faq-group">Add FAQ Group</button></p>
            <hr>
            <input type="submit" name="save_woo_afaq" class="button button-primary" value="Save FAQs">
        </form>
    </div>
</div>

<!-- Templates -->
<script type="text/html" id="fbs-faq-group-template">
    <div class="fbs-faq-archive-group" style="margin-bottom: 30px; padding: 15px 15px 25px 15px; border: 2px solid #ccd0d4; background: #f8f9fa;">
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
                    <div class="term-suggestions" style="margin-top:5px;"></div>
                    <div class="selected-terms"></div>
                </td>
            </tr>
        </table>

        <div class="fbs-archive-faq-items"></div>
        <p><button type="button" class="button fsb-archive-add-faq-item">Add New FAQ</button></p>
        <button type="button" class="button fbs-archive-remove-faq-group" style="margin-top: 10px; float:right; background:#fff; color:red; border-color:red;">Remove Group</button>
    </div>
</script>

<script type="text/html" id="fbs-archive-faq-item-template">
    <div class="fbs-archive-faq-item" style="margin-bottom: 30px; padding:10px 10px 15px 10px; border: 1px solid #ddd; background: #fff;">
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
        <button type="button" style="float: right; background:#fff; color:red; border-color:red;" class="button fbs-archive-remove-faq-item">Remove FAQ</button>
    </div>
</script>

<?php if (!empty($saved_data)) : ?>
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

            // Show term row
            $group.find('.archive-term-row').show();

            // Populate selected terms
            const selectedContainer = $group.find('.selected-terms');
            const termNames = group.term_names || {}; // Optional backup
            if (Array.isArray(group.archive_terms)) {
                group.archive_terms.forEach(function (termId) {
                    const termName = termNames[termId] || 'Term #' + termId;
                    const termHtml = `<div class="selected-term" data-id="${termId}">
                        ${termName} <input type="hidden" name="faq_groups[${gIndex}][archive_terms][]" value="${termId}">
                    </div>`;
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
<?php endif; ?>