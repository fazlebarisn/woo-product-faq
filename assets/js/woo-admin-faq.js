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
  });
})(jQuery);
