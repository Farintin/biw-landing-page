let newsLetterModal = $('#modalNewsletterForm');

newsLetterModal.hide();
$(window).on('load', function () {
  
  // Preloader
  if ($('#preloader').length) {

    $('#preloader').delay(100).fadeOut('slow', function () {

    	$('#preloader').removeClass('bg-white');
    	$('#preloader').addClass('bg-white-40p');
      	$(this).hide();

    });
    newsLetterModal.delay(30000).fadeIn(1000);
    
  }
  
});



let modal = $('.modal');
modal.hide();

modal.click(function (e) {

	if (e.target == this) {

	 $(this).hide()

	}

});
$('.close-btn').click(function () {

	$(this).parents('.modal').hide()
  	
});


newsLetterModal.click(function (e) {

  if (e.target == this) {

   $(this).hide()

  }

});
newsLetterModal.find('.close-btn').click(function () {

	newsLetterModal.fadeOut(500)
  	
});