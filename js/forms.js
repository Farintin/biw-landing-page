jQuery(document).ready(function($) {
  "use strict";

  $('.formLoader').hide();
  


  let forms = $('form');
  let inputs = $('form input');
  inputs = inputs.each((i, e) => {

    if ($(e).attr('type') == 'submit' | 'hidden') {

      inputs.splice(i, 1);

    }

  });
  function blankInputsVal (i) {
    
    if (i.val() == i.attr('placeholder')) {

      i.val('');

    }

  };
  function populateInputsVal (i) {

    if (i.val() == '') {

      i.val(i.attr('placeholder'))

    }

  };


  inputs.each(function () {

    $(this).attr('placeholder', $(this).val());

  });
  inputs.focus(function () {

    blankInputsVal ($(this));

  });
  inputs.blur(function () {

    populateInputsVal ($(this));

  });

  forms.each(function () {

    let form = this;
    let specFormInputs = $(form).find('input');
    let submitBtn = form.querySelector('input[type="submit"]');


    $(submitBtn).mouseover(function () {
      
      specFormInputs = specFormInputs.each((i, e) => {

        if (($(e).attr('type') == 'submit') | ($(e).attr('type') == 'hidden')) {

          specFormInputs.splice(i, 1);

        }

      });
      specFormInputs.each(function () {
        
        blankInputsVal ($(this));

      });

    });
    $(submitBtn).mouseout(function () {

      specFormInputs = specFormInputs.each((i, e) => {

        if (($(e).attr('type') == 'submit') | ($(e).attr('type') == 'hidden')) {

          specFormInputs.splice(i, 1);

        }

      });
      specFormInputs.each(function () {
        
        populateInputsVal ($(this));

      });

    })

  })



  $('form').submit(function() {

      let activeForm = $(this);
      let activeFormLoader = activeForm.find('.formLoader');
      let str = activeForm.serialize();
      let action = activeForm.attr('action');


      if( ! action ) {

        action = 'forms.php';

      }

      $.ajax({

        type: "POST",
        url: action,
        data: str,
        beforeSend: function() {

          activeFormLoader.delay(200).fadeIn('slow', function () {

            activeFormLoader.removeClass('bg-white-10p');
            activeFormLoader.addClass('bg-white-40p');
            $(this).show();
            
          });
  
        },
        success: function(jsonMsg) {

          jsonMsg = JSON.parse(jsonMsg);

          activeFormLoader.delay(200).fadeOut('slow', function () {

            activeFormLoader.removeClass('bg-white-40p');
            activeFormLoader.addClass('bg-white-10p');
            $(this).hide();

          });
      
          if (jsonMsg.mail_delivery == true) {

            let formTitle = '#'.concat(activeForm.find('input[type="hidden"]').val());
            $(formTitle).fadeIn(500);
            if (formTitle == '#newsletter') {

              $('#modalNewsletterForm').fadeOut(200)

            };

            activeForm.find("input, textarea").each((i, e) => {
             
              if (!(($(e).attr('type') == 'submit') | ($(e).attr('type') == 'hidden'))) {

                $(e).val('');

              }

            });
            console.log(jsonMsg.sql_insert);

          } else if (jsonMsg.error == 'Fill in completely the forms') {

            console.log(jsonMsg.error);

          } else {
            
            console.log(msg);
          };

        },
        error: function() {

          activeFormLoader.hide();

        }

      });
      return false;

  });

});
