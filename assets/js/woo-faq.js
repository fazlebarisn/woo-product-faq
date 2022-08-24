;(function($){
    $(document).ready(function(){
        const items = document.querySelectorAll(".accordion button");

        function toggleAccordion() {
          const itemToggle = this.getAttribute('aria-expanded');
          
          for (i = 0; i < items.length; i++) {
            items[i].setAttribute('aria-expanded', 'false');
          }
          
          if (itemToggle == 'false') {
            this.setAttribute('aria-expanded', 'true');
          }
        }
        
        items.forEach(item => item.addEventListener('click', toggleAccordion));

        // $('.add-question').on('click' , function(event){
        //   //event.preventDefault();
        //   console.log(88888888);
        //   alert(2222222);
        // });
        // $(".add-question").click(function(){
        //   alert("The paragraph was clicked.");
        // });
alert(3333);
        $(document.body).on('click','.add-question',function(){
          alert(3433)
          var myNum = $('div.option-group-wrapper .options_group').length + 1;
          console.log(myNum);
          var myElement = '<div class="options_group">';
          myElement += '<p class="form-field faq_' + myNum + '_field ">';
          myElement += '<label for="faq_' + myNum + '">Question ' + myNum + 1 + '</label><input type="text" class="faq_input" style="" name="faq[question][' + myNum + ']" id="faq_' + myNum + '" value="sdsad" placeholder=""> </p><p class="form-field faq_ans_' + myNum + '_field ">';
          myElement += '<label for="faq_ans_' + myNum + '">Answer ' + myNum + 1 +  '</label><input type="text" class="faq_input" style="" name="faq[answer][' + myNum + ']" id="faq_ans_' + myNum + '" value="asd" placeholder=""> </p>                </div>';
          console.log(myElement);
          $('div.option-group-wrapper').append(myElement);

        });
      }
    );
})(jQuery);