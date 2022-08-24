;(function($){
    $(document).ready(function(){

        $(document.body).on('click','.faq-add-question',function(){

          var myNum = $('div.option-group-wrapper .options_group').length + 1;
          
          var myElement = '<div class="options_group">';
          myElement += '<p class="form-field faq_' + myNum + '_field ">';
          myElement += '<label for="faq_' + myNum + '">Question ' + myNum + '</label><input type="text" class="faq_input" name="faq[question][' + myNum + ']" id="faq_' + myNum + '" value="" placeholder="Add Question"> </p><p class="form-field faq_ans_' + myNum + '_field ">';
          myElement += '<label for="faq_ans_' + myNum + '">Answer ' + myNum +  '</label><input type="text" class="faq_input" name="faq[answer][' + myNum + ']" id="faq_ans_' + myNum + '" value="" placeholder="Add Answer"> </p></div>';

          $('div.option-group-wrapper').append(myElement);

        });
      }
    );
})(jQuery);