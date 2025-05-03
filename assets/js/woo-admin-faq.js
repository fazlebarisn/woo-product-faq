(function ($) {
  $(document).ready(function () {
    // Declare a global counter to track the number of FAQs
    var faqCounter = 1;

    $(document.body).on("click", ".faq-add-question", function () {
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
    // Initialize the FAQ groups container
    let groupIndex = 0;

    // Add FAQ Group
    $("#fbs-add-faq-group").on("click", function () {
      const template = $("#fbs-faq-group-template")
        .html()
        .replace(/_INDEX_/g, groupIndex);
      $("#faq-groups-container").append(template);
      groupIndex++;
    });

    // Remove FAQ Group
    $("#faq-groups-container").on(
      "click",
      ".fbs-archive-remove-faq-group",
      function () {
        $(this).closest(".fbs-faq-archive-group").remove();
      }
    );

    // Add FAQ Item
    $("#faq-groups-container").on(
      "click",
      ".fsb-archive-add-faq-item",
      function () {
        const $group = $(this).closest(".fbs-faq-archive-group");
        const groupIndex = $group
          .find("select.archive-type")
          .attr("name")
          .match(/\d+/)[0];
        const template = $("#fbs-archive-faq-item-template")
          .html()
          .replace(/_GROUP_INDEX_/g, groupIndex);
        $group.find(".fbs-archive-faq-items").append(template);
      }
    );

    // Remove FAQ Item
    $("#faq-groups-container").on(
      "click",
      ".fbs-archive-remove-faq-item",
      function () {
        $(this).closest(".fbs-archive-faq-item").remove();
      }
    );

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
    $("#fbs-add-faq-group").trigger("click");
    setTimeout(function () {
      $("#faq-groups-container .fsb-archive-add-faq-item")
        .first()
        .trigger("click");
    }, 100);
  });
})(jQuery);
