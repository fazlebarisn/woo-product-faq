(function ($) {
  $(document).ready(function () {
    const isProActive = typeof wooFaqPro !== 'undefined' && wooFaqPro.is_pro;
    const MAX_SINGLE_FAQS = isProActive ? Infinity : 3;
    const MAX_GROUPS_FREE = isProActive ? Infinity : 2;
    const MAX_FAQS_FREE = isProActive ? Infinity : 3;

    // Initialize FAQ counter based on existing FAQs
    var faqCounter = $("div.option-group-wrapper .options_group").length;
    
    // Disable the add button on page load if limit is reached
    if ($("div.option-group-wrapper .options_group").length >= MAX_SINGLE_FAQS) {
      const $btn = $(".faq-add-question");
      const $newBtn = $('<a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" class="button fbs-upgrade-button" style="background-color: #ff9800; border-color: #ff9800; color: #fff;">Upgrade</a>');
      $btn.replaceWith($newBtn);
    }

    $(document.body).on("click", ".faq-add-question", function () {
      const $addBtn = $(this);
      const currentFaqs = $("div.option-group-wrapper .options_group").length;
      if (currentFaqs >= MAX_SINGLE_FAQS) {
        const $newBtn = $('<a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" class="button fbs-upgrade-button" style="background-color: #ff9800; border-color: #ff9800; color: #fff;">Upgrade</a>');
        $addBtn.replaceWith($newBtn);
        alert("Upgrade to the Pro version to add more than 3 FAQs per product.");
        return;
      }

      // Use the current counter value for the new FAQ
      var faqNumber = faqCounter;

      // Use template literals for better readability
      var myElement = `
              <div class="options_group faq-group" data-index="${faqNumber}">
                  <button type="button" class="faq-remove-question" style="float:right; margin-top:5px; background:#fff; color:#b32d2e; border:1px solid #b32d2e; border-radius:50%; width:24px; height:24px; padding:0; cursor:pointer;">
                      <span class="dashicons dashicons-no-alt" style="font-size:12px; line-height:22px;"></span>
                  </button>
                  <p class="form-field faq_${faqNumber}_field">
                      <label for="faq_${faqNumber}">Question ${faqNumber + 1}</label>
                      <input type="text" class="faq_input faq-question-box" name="faq[question][${faqNumber}]" id="faq_${faqNumber}" value="" placeholder="Enter your question here..." style="width: 97%;">
                  </p>
                  <p class="form-field faq_ans_${faqNumber}_field">
                      <label for="faq_ans_${faqNumber}">Answer ${faqNumber + 1}</label>
                      <textarea class="faq_input faq-answer-box" name="faq[answer][${faqNumber}]" id="faq_ans_${faqNumber}" rows="3" placeholder="Enter your answer here..." style="width: 97%;"></textarea>
                  </p>
              </div>
          `;

      // Append the new FAQ input fields
      $("div.option-group-wrapper").append(myElement);

      // Increment the counter for the next click
      faqCounter++;

      // Restore the add button if under the limit (in case FAQs are removed)
      if ($("div.option-group-wrapper .options_group").length < MAX_SINGLE_FAQS) {
        const $upgradeBtn = $(".fbs-upgrade-button");
        if ($upgradeBtn.length) {
          const $newBtn = $('<button type="button" class="button faq-add-question">Add Question</button>');
          $upgradeBtn.replaceWith($newBtn);
        }
      }
    });

    // If you have a remove FAQ handler for single product, add this logic there as well:
          // After removing an FAQ, restore the add button if under the limit
      $(document.body).on("click", ".faq-remove-question", function () {
        $(this).closest(".options_group").remove();
        // Restore the add button if under the limit
        if ($("div.option-group-wrapper .options_group").length < MAX_SINGLE_FAQS) {
          const $upgradeBtn = $(".fbs-upgrade-button");
          if ($upgradeBtn.length) {
            const $newBtn = $('<button type="button" class="button faq-add-question">Add Question</button>');
            $upgradeBtn.replaceWith($newBtn);
          }
        }
      });

    // Archive FAQ code start here

    $(document.body).on("click", ".fbs-add-faq-group", function () {
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
        const $btn = $(".fbs-add-faq-group");
        const $newBtn = $('<a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" class="button fbs-upgrade-button" style="background-color: #ff9800; border-color: #ff9800; color: #fff;">Upgrade</a>');
        $btn.replaceWith($newBtn);
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
          const $upgradeBtn = $(".fbs-upgrade-button");
          if ($upgradeBtn.length) {
            const $newBtn = $('<button type="button" class="button fbs-add-faq-group">Add FAQ Group</button>');
            $upgradeBtn.replaceWith($newBtn);
          }
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
          const $btn = groupEl.find(".fsb-archive-add-faq-item");
          const $newBtn = $('<a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" class="button fbs-upgrade-button" style="background-color: #ff9800; border-color: #ff9800; color: #fff;">Upgrade</a>');
          $btn.replaceWith($newBtn);
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
          const $upgradeBtn = groupEl.find(".fbs-upgrade-button");
          if ($upgradeBtn.length) {
            const $newBtn = $('<button type="button" class="button fsb-archive-add-faq-item">Add New FAQ</button>');
            $upgradeBtn.replaceWith($newBtn);
          }
        }
      }
    );

    $(document.body).on("click", ".fbs-upgrade-button", function (e) {
      e.preventDefault();
      e.stopPropagation();
      window.open("https://wpbay.com/product/product-faq-for-woocommerce-pro/", "_blank");
    });



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
                      <span class="term-pill" data-id="${ui.item.value}">
                          ${ui.item.label}
                          <a href="#" class="remove-term">&times;</a>
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

    // Preset Objection-Buster Templates
    const FAQ_PRESET_TEMPLATES = {
      shipping: {
        q: "What are your shipping and delivery timeframes?",
        a: "Standard shipping takes 3-5 business days. Once dispatched, you will receive full tracking information via email."
      },
      returns: {
        q: "What is your return and refund policy?",
        a: "We offer a 30-day money-back guarantee. If you are not satisfied, return the product in its original condition for a replacement or full refund."
      },
      warranty: {
        q: "Is this product covered by warranty or authenticity guarantee?",
        a: "Yes! All products are 100% authentic and covered by a 1-year manufacturer warranty against defects."
      },
      sizing: {
        q: "How do I choose the correct size or fit?",
        a: "Please check our size guidelines in the product specifications. If you are between sizes, we recommend sizing up."
      },
      care: {
        q: "How should I care for and maintain this product?",
        a: "Follow the care label instructions provided. Clean gently with mild soap and water and store in a cool, dry place."
      }
    };

    function appendOrFillFaq(questionText, answerText) {
      let filled = false;
      $("div.option-group-wrapper .options_group").each(function () {
        const $q = $(this).find(".faq-question-box");
        const $a = $(this).find(".faq-answer-box");
        if ($q.val().trim() === "" && $a.val().trim() === "") {
          $q.val(questionText);
          $a.val(answerText);
          filled = true;
          return false; // break
        }
      });

      if (!filled) {
        const currentFaqs = $("div.option-group-wrapper .options_group").length;
        if (currentFaqs >= MAX_SINGLE_FAQS) {
          alert("Free version limit of 3 FAQs reached. Upgrade to Pro for unlimited FAQs.");
          return false;
        }

        const faqNumber = faqCounter;
        const myElement = `
          <div class="options_group faq-group" data-index="${faqNumber}">
              <button type="button" class="faq-remove-question" style="float:right; margin-top:5px; background:#fff; color:#b32d2e; border:1px solid #b32d2e; border-radius:50%; width:24px; height:24px; padding:0; cursor:pointer;">
                  <span class="dashicons dashicons-no-alt" style="font-size:12px; line-height:22px;"></span>
              </button>
              <p class="form-field faq_${faqNumber}_field">
                  <label for="faq_${faqNumber}">Question ${faqNumber + 1}</label>
                  <input type="text" class="faq_input faq-question-box" name="faq[question][${faqNumber}]" id="faq_${faqNumber}" value="${$("<div>").text(questionText).html()}" style="width: 97%;">
              </p>
              <p class="form-field faq_ans_${faqNumber}_field">
                  <label for="faq_ans_${faqNumber}">Answer ${faqNumber + 1}</label>
                  <textarea class="faq_input faq-answer-box" name="faq[answer][${faqNumber}]" id="faq_ans_${faqNumber}" rows="3" style="width: 97%;">${$("<div>").text(answerText).html()}</textarea>
              </p>
          </div>
        `;
        $("div.option-group-wrapper").append(myElement);
        faqCounter++;
      }
      return true;
    }

    $("#faq-insert-template-select").on("change", function () {
      const templateKey = $(this).val();
      if (!templateKey || !FAQ_PRESET_TEMPLATES[templateKey]) return;

      const tmpl = FAQ_PRESET_TEMPLATES[templateKey];
      appendOrFillFaq(tmpl.q, tmpl.a);
      $(this).val(""); // reset select
    });

    // AI Modal Handlers
    $(".faq-ai-modal-open-btn").on("click", function (e) {
      e.preventDefault();
      $("#faq-ai-modal-backdrop").css("display", "flex");
    });

    $("#faq-ai-modal-close, #faq-ai-modal-cancel-btn").on("click", function () {
      $("#faq-ai-modal-backdrop").hide();
    });

    $("#faq-ai-generate-submit-btn").on("click", function () {
      const $btn = $(this);
      const $spinner = $btn.find(".faq-ai-spinner");
      const $text = $btn.find(".faq-ai-btn-text");

      const title = $("#title").val() || $("input[name='post_title']").val() || "";
      let desc = "";
      if (typeof tinyMCE !== "undefined" && tinyMCE.get("content")) {
        desc = tinyMCE.get("content").getContent({ format: "text" });
      } else {
        desc = $("#content").val() || "";
      }

      const tone = $("#faq-ai-tone-select").val();
      const count = $("#faq-ai-count-select").val();

      $btn.prop("disabled", true);
      $spinner.show();
      $text.text("Generating with AI...");
      $("#faq-ai-results-wrapper").hide();
      $("#faq-ai-items-list").empty();

      $.ajax({
        url: typeof faqAjax !== "undefined" ? faqAjax.ajax_url : ajaxurl,
        type: "POST",
        data: {
          action: "woo_faq_generate_ai_faqs",
          nonce: typeof faqAjax !== "undefined" ? faqAjax.nonce : "",
          product_title: title,
          product_desc: desc,
          tone: tone,
          count: count,
        },
        success: function (response) {
          $btn.prop("disabled", false);
          $spinner.hide();
          $text.text("⚡ Generate FAQs with AI");

          if (response.success && response.data && response.data.faqs) {
            const faqs = response.data.faqs;
            if (response.data.message) {
              $("#faq-ai-notice").text(response.data.message).show();
            } else {
              $("#faq-ai-notice").hide();
            }

            faqs.forEach(function (faq, idx) {
              const itemHtml = `
                <div class="fbs-ai-item-card">
                  <label class="fbs-ai-item-label">
                    <input type="checkbox" class="faq-ai-select-checkbox" checked data-q="${$("<div>").text(faq.question).html()}" data-a="${$("<div>").text(faq.answer).html()}">
                    <div class="fbs-ai-item-content">
                      <strong class="fbs-ai-item-q">${faq.question}</strong>
                      <p class="fbs-ai-item-a">${faq.answer}</p>
                    </div>
                  </label>
                </div>
              `;
              $("#faq-ai-items-list").append(itemHtml);
            });

            $("#faq-ai-results-wrapper").show();
            $("#faq-ai-insert-all-btn").show();
          } else {
            alert(response.data && response.data.message ? response.data.message : "Failed to generate FAQs.");
          }
        },
        error: function () {
          $btn.prop("disabled", false);
          $spinner.hide();
          $text.text("⚡ Generate FAQs with AI");
          alert("Server error occurred while requesting AI FAQs.");
        },
      });
    });

    $("#faq-ai-insert-all-btn").on("click", function () {
      const $checked = $(".faq-ai-select-checkbox:checked");
      if (!$checked.length) {
        alert("Please select at least one FAQ item to insert.");
        return;
      }

      $checked.each(function () {
        const q = $(this).data("q");
        const a = $(this).data("a");
        appendOrFillFaq(q, a);
      });

      $("#faq-ai-modal-backdrop").hide();
    });
  });
})(jQuery);
