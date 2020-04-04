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

      function activeFormLoaderRemover () {

        activeFormLoader.delay(100).fadeOut('slow', function () {

          $(this).removeClass('bg-white-40p');
          $(this).addClass('bg-white-10p');
          $(this).hide();
            
        });
  
      };

      if(!action) {

        action = 'forms.php';

      };

      $.ajax({

        type: "POST",
        url: action,
        data: str,
        beforeSend: function() {

          activeFormLoader.delay(200).fadeIn('slow', function () {

            $(this).removeClass('bg-white-10p');
            $(this).addClass('bg-white-40p');
            $(this).show();
              
          });

        },
        success: function(jsonMsg) {
          console.log(jsonMsg);
          activeFormLoaderRemover();

          /*if (jsonMsg[0] != '{') {

            console.log('Not a json:\n', jsonMsg);
            let formTitle = '#'.concat(activeForm.find('input[type="hidden"]').val());
            if (formTitle == '#masterclass') {

              $(formTitle).find('.bottom').html("<p>You are just one step away from joining our masterclasses. "
              + "We'll be in touch will you for the second registration. " + 
              "A connection error occured in our mail server, please we'll send you an e-mail message later, thank you.</p>");

            } else if (formTitle == '#event') {

              $(formTitle).find('.bottom').html(`<p>Thank's for writing to us your message. 
                We will try to be responsive as possible. A connection error occured in our mail server, 
                Our team will get back to you with answer to your message later, thank you.</p>`);

            } else if (formTitle == '#newsletter') {

              $(formTitle).find('.bottom').html(`<p>Thank's for subscribing to our newsletter you will be recieving events info and news feeds on all around our industry.</p>
                <p>A connection error occured in our mail server, please we'll send you an e-mail message later, thank you.</p>`);
              $('#modalNewsletterForm').fadeOut(200)

            };
            $(formTitle).fadeIn(500);

          } else {

            console.log('A json:\n', jsonMsg);
            jsonMsg = JSON.parse(jsonMsg);
            if (jsonMsg.mail_delivery == true) {

              let formTitle = '#'.concat(activeForm.find('input[type="hidden"]').val());
              $(formTitle).fadeIn(500);
              if (formTitle == '#newsletter') {

                $('#modalNewsletterForm').fadeOut(200)

              };

              // Empty form fields after submission
              activeForm.find("input, textarea").each((i, e) => {
               
                if (!(($(e).attr('type') == 'submit') | ($(e).attr('type') == 'hidden'))) {

                  $(e).val('')

                }

              });
              console.log(jsonMsg.sql_insert)

            } else if (jsonMsg.error) {

              console.log(jsonMsg.error)

            }

          }*/


          $.getJSON("form_msg.php", function(msg) {
            
            console.log(msg);
            if (msg.mail_delivery == true) {

              let formTitle = '#'.concat(activeForm.find('input[type="hidden"]').val());
              $(formTitle).fadeIn(500);
              if (formTitle == '#newsletter') {

                $('#modalNewsletterForm').fadeOut(200)

              };

              // Empty form fields after submission
              activeForm.find("input, textarea").each((i, e) => {
               
                if (!(($(e).attr('type') == 'submit') | ($(e).attr('type') == 'hidden'))) {

                  $(e).val('')

                }

              });

            } else {

              let formTitle = '#'.concat(activeForm.find('input[type="hidden"]').val());
              if (formTitle == '#masterclass') {

                $(formTitle).find('.bottom').html("<p>You are just one step away from joining our masterclasses. "
                + "We'll be in touch will you for the second registration. " + 
                "A connection error occured in our mail server, please we'll send you an e-mail message later, thank you.</p>");

              } else if (formTitle == '#event') {

                $(formTitle).find('.bottom').html(`<p>Thank's for writing to us your message. 
                  We will try to be responsive as possible. A connection error occured in our mail server, 
                  Our team will get back to you with answer to your message later, thank you.</p>`);

              } else if (formTitle == '#newsletter') {

                $(formTitle).find('.bottom').html(`<p>Thank's for subscribing to our newsletter you will be recieving events info and news feeds on all around our industry.</p>
                  <p>A connection error occured in our mail server, please we'll send you an e-mail message later, thank you.</p>`);
                $('#modalNewsletterForm').fadeOut(200)

              };
              $(formTitle).fadeIn(500)

            }

          })

        },
        error: function(xhr,status,error) {

          console.log(error);
          activeFormLoaderRemover();

          let formTitle = '#'.concat(activeForm.find('input[type="hidden"]').val());
          if (formTitle == '#masterclass') {

            $(formTitle).find('.bottom').html("<p>You are just one step away from joining our masterclasses. "
            + "We'll be in touch will you for the second registration. " + 
            "A connection error occured in our mail server, please we'll send you an e-mail message later, thank you.</p>");

          } else if (formTitle == '#event') {

            $(formTitle).find('.bottom').html(`<p>Thank's for writing to us your message. 
              We will try to be responsive as possible. A connection error occured in our mail server, 
              Our team will get back to you with answer to your message later, thank you.</p>`);

          } else if (formTitle == '#newsletter') {

            $(formTitle).find('.bottom').html(`<p>Thank's for subscribing to our newsletter you will be recieving events info and news feeds on all around our industry.</p>
              <p>A connection error occured in our mail server, please we'll send you an e-mail message later, thank you.</p>`);
            $('#modalNewsletterForm').fadeOut(200)

          };
          $(formTitle).fadeIn(500)

        }

      });
      return false;

  });

});
