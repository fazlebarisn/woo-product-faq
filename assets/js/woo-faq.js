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
      }
    );
})(jQuery);