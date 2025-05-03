<div class="wrap">
    <div class="fbs-product-archive-faq">
        <h1>Settings for Product Archive FAQ</h1>
        <div id="faq-groups-container"></div>
        <p><button type="button" class="button button-primary" id="fbs-add-faq-group">Add FAQ Group</button></p>
        <hr>
        <p><button type="submit" class="button button-primary">Save Settings</button></p>
    </div>
</div>

<!-- Template for FAQ Group -->
<script type="text/html" id="fbs-faq-group-template">
    <div class="fbs-faq-archive-group" style="margin-bottom: 30px; padding: 15px; border: 2px solid #ccd0d4; background: #f8f9fa;">
        <h2>FAQ Group</h2>
        <!-- Archive Selector -->
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
                    <input type="text" class="archive-term regular-text" name="faq_groups[_INDEX_][archive_term]" placeholder="Search..." />
                    <div class="term-suggestions" style="margin-top:5px;"></div>
                </td>
            </tr>
        </table>

        <!-- FAQ Items -->
        <div class="fbs-archive-faq-items"></div>
        <p><button type="button" class="button fsb-archive-add-faq-item">Add New FAQ</button></p>

        <button type="button" class="button fbs-archive-remove-faq-group" style="margin-top: 10px;">Remove Group</button>
    </div>
</script>

<!-- Template for single Q&A -->
<script type="text/html" id="fbs-archive-faq-item-template">
    <div class="fbs-archive-faq-item" style="margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; background: #fff;">
        <p>
            <label>Question<br>
                <input type="text" name="faq_groups[_GROUP_INDEX_][questions][]" class="regular-text" />
            </label>
        </p>
        <p>
            <label>Answer<br>
                <textarea name="faq_groups[_GROUP_INDEX_][answers][]" rows="3" class="large-text"></textarea>
            </label>
        </p>
        <button type="button" class="button fbs-archive-remove-faq-item">Remove FAQ</button>
    </div>
</script>

<!-- JavaScript Logic -->
<script>
jQuery(document).ready(function($) {
    let groupIndex = 0;

    // Add FAQ Group
    $('#fbs-add-faq-group').on('click', function() {
        const template = $('#fbs-faq-group-template').html().replace(/_INDEX_/g, groupIndex);
        $('#faq-groups-container').append(template);
        groupIndex++;
    });

    // Remove FAQ Group
    $('#faq-groups-container').on('click', '.fbs-archive-remove-faq-group', function() {
        $(this).closest('.fbs-faq-archive-group').remove();
    });

    // Add FAQ Item
    $('#faq-groups-container').on('click', '.fsb-archive-add-faq-item', function() {
        const $group = $(this).closest('.fbs-faq-archive-group');
        const groupIndex = $group.find('select.archive-type').attr('name').match(/\d+/)[0];
        const template = $('#fbs-archive-faq-item-template').html().replace(/_GROUP_INDEX_/g, groupIndex);
        $group.find('.fbs-archive-faq-items').append(template);
    });

    // Remove FAQ Item
    $('#faq-groups-container').on('click', '.fbs-archive-remove-faq-item', function() {
        $(this).closest('.fbs-archive-faq-item').remove();
    });

    // Show/hide archive term row based on archive type
    $('#faq-groups-container').on('change', 'select.archive-type', function() {
        const selected = $(this).val();
        const $termRow = $(this).closest('table').find('.archive-term-row');
        if (selected === 'product_cat' || selected === 'product_tag') {
            $termRow.show();
        } else {
            $termRow.hide();
        }
    });
});

</script>