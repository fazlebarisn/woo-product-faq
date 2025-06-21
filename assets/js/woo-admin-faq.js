(function ($) {
  $(document).ready(function () {
    const isProActive = typeof wooFaqPro !== 'undefined' && wooFaqPro.is_pro;
    const MAX_SINGLE_FAQS = isProActive ? Infinity : 4;
    const MAX_GROUPS_FREE = isProActive ? Infinity : 2;
    const MAX_FAQS_FREE = isProActive ? Infinity : 3;

    // Declare a global counter to track the number of FAQs
    var faqCounter = 1;

    $(document.body).on("click", ".faq-add-question", function () {
      const currentFaqs = $("div.option-group-wrapper .options_group").length;
      if (currentFaqs >= MAX_SINGLE_FAQS) {
        alert("Upgrade to the Pro version to add more than 3 FAQs per product.");
        return;
      }

      var lastFaqNumber = $(
        "div.option-group-wrapper .options_group .faq-question-box"
      ).length;
      // Use the counter value directly and increment it for each new FAQ
      var faqNumber = faqCounter + lastFaqNumber;

      // Use template literals for better readability
      var myElement = `
              <div class="options_group">
                  <p class="form-field faq_${faqNumber}_field">
                      <label for="faq_${faqNumber}">Question</label>
                      <input type="text" class="faq_input" name="faq[question][${faqNumber}]" id="faq_${faqNumber}" value="" placeholder="Add Question">
                  </p>
                  <p class="form-field faq_ans_${faqNumber}_field">
                      <label for="faq_ans_${faqNumber}">Answer</label>
                      <input type="text" class="faq_input" name="faq[answer][${faqNumber}]" id="faq_ans_${faqNumber}" value="" placeholder="Add Answer">
                  </p>
              </div>
          `;

      // Append the new FAQ input fields
      $("div.option-group-wrapper").append(myElement);

      // Increment the counter for the next click
      faqCounter++;
    });

    // Archive FAQ code start here

    $("#fbs-add-faq-group").on("click", function () {
      const currentGroups = $(
        "#faq-groups-container .fbs-faq-archive-group"
      ).length;

      if (currentGroups >= MAX_GROUPS_FREE) {
        alert("Upgrade to the Pro version to add more than 2 FAQ groups.");
        return;
      }

      const groupIndex = currentGroups;
      let groupHtml = $("#fbs-faq-group-template")
        .html()
        .replace(/_INDEX_/g, groupIndex);
      $("#faq-groups-container").append(groupHtml);

      // Disable the add group button if max reached
      if (groupIndex + 1 >= MAX_GROUPS_FREE) {
        $("#fbs-add-faq-group")
          .prop("disabled", true)
          .css("opacity", 1)
          .text("Upgrade")
          .addClass("fbs-upgrade-button");
      }
    });

    // Remove FAQ Group
    $("#faq-groups-container").on(
      "click",
      ".fbs-archive-remove-faq-group",
      function () {
        $(this).closest(".fbs-faq-archive-group").remove();

        const currentGroups = $(
          "#faq-groups-container .fbs-faq-archive-group"
        ).length;

        if (currentGroups < MAX_GROUPS_FREE) {
          $("#fbs-add-faq-group")
            .prop("disabled", false)
            .text("Add FAQ Group")
            .removeClass("fbs-upgrade-button");
        }
      }
    );

    // Add FAQ Item
    $("#faq-groups-container").on(
      "click",
      ".fsb-archive-add-faq-item",
      function () {
        const groupEl = $(this).closest(".fbs-faq-archive-group");
        const currentFaqs = groupEl.find(".fbs-archive-faq-item").length;

        if (currentFaqs >= MAX_FAQS_FREE) {
          alert(
            "Upgrade to the Pro version to add more than 3 FAQs per group."
          );
          return;
        }

        const groupIndex = groupEl.index();
        const faqIndex = currentFaqs;
        let faqTemplate = $("#fbs-archive-faq-item-template").html();
        faqTemplate = faqTemplate
          .replace(/_GROUP_INDEX_/g, groupIndex)
          .replace(/_FAQ_INDEX_/g, faqIndex);

        groupEl.find(".fbs-archive-faq-items").append(faqTemplate);

        // Disable the button if max reached
        if (faqIndex + 1 >= MAX_FAQS_FREE) {
          groupEl
            .find(".fsb-archive-add-faq-item")
            .prop("disabled", true)
            .css("opacity", 1)
            .text("Upgrade")
            .addClass("fbs-upgrade-button");
        }
      }
    );

    // Remove FAQ Item
    $("#faq-groups-container").on(
      "click",
      ".fbs-archive-remove-faq-item",
      function () {
        const groupEl = $(this).closest(".fbs-faq-archive-group");
        $(this).closest(".fbs-archive-faq-item").remove();

        const currentFaqs = groupEl.find(".fbs-archive-faq-item").length;

        if (currentFaqs < MAX_FAQS_FREE) {
          groupEl
            .find(".fsb-archive-add-faq-item")
            .prop("disabled", false)
            .text("Add FAQ Item")
            .removeClass("fbs-upgrade-button");
        }
      }
    );

    function showUpgradeNotice(message) {
      const upgradeHTML = `
        <div class="notice notice-warning" style="margin-top:10px;">
          <p>${message} <a href="https://yourplugin.com/pro" target="_blank">Upgrade to Pro</a></p>
        </div>`;
      $(".wrap .fbs-product-archive-faq").append(upgradeHTML);
    }

    $(document).on("click", ".fbs-upgrade-button", function (e) {
      e.preventDefault();
      window.open("https://tarunnerswapno.org/", "_blank");
    });

    // Show/hide archive term row
    $("#faq-groups-container").on("change", "select.archive-type", function () {
      const selected = $(this).val();
      const $termRow = $(this).closest("table").find(".archive-term-row");
      if (selected === "product_cat" || selected === "product_tag") {
        $termRow.show();
      } else {
        $termRow.hide();
      }
    });

    // 🚀 Show one FAQ group and one FAQ item by default
    // $("#fbs-add-faq-group").trigger("click");
    // setTimeout(function () {
    //   $("#faq-groups-container .fsb-archive-add-faq-item")
    //     .first()
    //     .trigger("click");
    // }, 100);

    // Delegate input event on term field
    $("#faq-groups-container").on("focus", ".archive-term", function () {
      const $input = $(this);
      const $group = $input.closest(".fbs-faq-archive-group");
      const $select = $group.find(".archive-type");
      const taxonomy = $select.val();

      if (!taxonomy) return;

      $input.autocomplete({
        source: function (request, response) {
          if (request.term.length < 3) return;

          $.getJSON(
            faqAjax.ajax_url,
            {
              action: "faq_term_search",
              nonce: faqAjax.nonce,
              taxonomy: taxonomy,
              term: request.term,
            },
            function (data) {
              response(data);
            }
          );
        },
        minLength: 3,
        select: function (event, ui) {
          event.preventDefault();
          $input.val("");

          const $selectedTerms = $group.find(".selected-terms");

          if (
            $selectedTerms.find('input[value="' + ui.item.value + '"]').length
          ) {
            return;
          }

          const selectedHtml = `
                      <span class="term-pill" style="display:inline-block; margin:3px; padding:3px 8px; background:#f1f1f1; border:1px solid #ccc; border-radius:20px;">
                          ${ui.item.label}
                          <a href="#" class="remove-term" style="margin-left:5px; color:red; text-decoration:none;">&times;</a>
                          <input type="hidden" name="faq_groups[${$group.index()}][archive_terms][]" value="${
            ui.item.value
          }">
                      </span>
                  `;
          $selectedTerms.append(selectedHtml);
        },
      });
    });

    // Remove selected term
    $("#faq-groups-container").on("click", ".remove-term", function (e) {
      e.preventDefault();
      $(this).closest(".term-pill").remove();
    });

    // Show/hide archive term row + reset inputs
    $("#faq-groups-container").on("change", "select.archive-type", function () {
      const $group = $(this).closest(".fbs-faq-archive-group");
      const selected = $(this).val();
      const $termRow = $group.find(".archive-term-row");

      if (selected === "product_cat" || selected === "product_tag") {
        $termRow.show();
      } else {
        $termRow.hide();
        $termRow.find(".archive-term").val("");
        $termRow.find(".selected-terms").empty();
      }
    });
  });
})(jQuery);
