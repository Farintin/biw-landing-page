jQuery(document).ready(function($) {
    "use strict";

    var navHeight = $('#navTop').outerHeight();


    // Selecting active section link
    $('.nav-link').on('click', function(event) {

        $('.nav-link.active').removeClass('active');
        $(this).addClass('active');

        event.preventDefault();

        var section = $($(this).attr('href'));
  	   	var sectionOffset = section.offset();

  	    $('html, body').animate({scrollTop: sectionOffset.top - navHeight + 5}, 1000, "easeInOutExpo");

    });

    // Moved down below navigation bar height effect
    $(window).on('scroll', function() {

      if ($(window).scrollTop() > navHeight) {
        $('#navTop').addClass('scrolled-down');
        $('#navTop').addClass('fixedtop-md-max');
      } else {
        $('#navTop').removeClass('scrolled-down');
        $('#navTop').removeClass('fixedtop-md-max');
      }
   	
      $('.nav-link').each(function() {

      	var section = $($(this).attr('href'));
      	var sectionOffset = section.offset();

      	if ($(window).scrollTop() >= sectionOffset.top - navHeight) {
      		$('.nav-link.active').removeClass('active');
        	$(this).addClass('active');
      	}

      });

    });

    // Selecting active Events section view
    var eventsSection = $('.events');

    eventsSection.hide();
    eventsSection.first().find('.nav-btn .prev').hide();
    eventsSection.last().find('.nav-btn .next').hide();
    eventsSection.first().show();

    eventsSection.find('.nav-btn div').click(function () {

      var currentEventsSection = $(this).parents('.events');

      if ($(this).hasClass('next')) {
        currentEventsSection.hide();
        currentEventsSection.next().show();
      } else if ($(this).hasClass('prev')) {
        currentEventsSection.hide();
        currentEventsSection.prev().show();
      }

    });

    // Selecting active Information section view
    var sectionInfo = $('main.infos section.info');

    sectionInfo.hide();
    sectionInfo.first().find('.nav-btn .left').hide();
    sectionInfo.last().find('.nav-btn .right').hide();
    sectionInfo.first().show();

    sectionInfo.find('.nav-btn div').click(function () {

      var currentSectionInfo = $(this).parents('section.info');

      if ($(this).hasClass('right')) {
        currentSectionInfo.hide();
        currentSectionInfo.next().show();
      } else if ($(this).hasClass('left')) {
        currentSectionInfo.hide();
        currentSectionInfo.prev().show();
      }

    });



    // Mobile nav bar toggler
    let navLS = $('.links-segment');
    $('#mobileNavToggler').click(function () {

      if (navLS.hasClass('hide')) {

        navLS.removeClass('hide');
        navLS.addClass('show');

      } else {

        navLS.addClass('hide');
        navLS.removeClass('show');


      };

    });


    

    // Selecting active Social-postssection view
    var mediaSection = $('#socialPosts .media-section');
    var mediaNavLinks = $('#socialPosts .header .nav p');

    mediaSection.hide();

    function mediaSectionSelection () {
      mediaSection.each(function () {

        if ($(this).hasClass($('#socialPosts .header .nav p.active').attr('data-media-section'))) {
          $(this).show();                                                                                                               
        };

      });
    };
    mediaSectionSelection ();

    mediaNavLinks.click(function () {

      mediaNavLinks.removeClass('active');
      $(this).addClass('active');
      mediaSection.hide();
      mediaSectionSelection ();

    });



    //social media section post navigation
    const rpv = 8;
    
    class MediaPosts {

      constructor (htmlPost, htmlPosts, htmlNext, htmlPrev) {

        this.post = htmlPost;
        this.posts = htmlPosts;
        this.nextBtn = htmlNext;
        this.prevBtn = htmlPrev;
        this.vn = 1;
        this.startIndex = function (vn) {

          return rpv * (this.vn - 1);

        };
        this.postsView = function () {

          this.posts.hide();
          if (this.posts.length <= rpv) {
            this.nextBtn.hide();
            this.prevBtn.hide();
          };
          this.currentPostsView = this.posts.slice(this.startIndex (this.vn), rpv * this.vn);
          this.currentPostsView.each(function () {
            $(this).show()
          });
          return this.currentPostsView;

        };
        this.postsView();
        this.prevBtn.hide();

      };

      postsPagNav () {

        this.currentPostsView = this.postsView ();
        if ($(this.currentPostsView[0]).hasClass('first')) {
          this.nextBtn.show();
          this.prevBtn.hide()
        } else if ($(this.currentPostsView[this.currentPostsView.length - 1]).hasClass('last')) {
          this.nextBtn.hide();
          this.prevBtn.show().addClass('all-border-sides-closed')
        } else {
          this.nextBtn.show();
          this.prevBtn.show().removeClass('all-border-sides-closed')
        };

      };

      switchNextPostsView () {

        this.vn++;
        this.postsPagNav ()

      };

      switchPrevPostsView () {

        this.vn--;
        this.postsPagNav ()

      };

    };



    let instagramPost = $('#socialPosts #instagram .posts');
    let instagramPosts = $('#socialPosts #instagram .posts .post');
    let instagramNextBtn = $('#socialPosts #instagram .nav-btn .next');
    let instagramPrevBtn = $('#socialPosts #instagram .nav-btn .prev');

    $('#socialPosts .posts').each(function () {
      $(this).children('.post').first().addClass('first');
      $(this).children('.post').last().addClass('last');
    });

    const instagram = new MediaPosts (instagramPost, instagramPosts, instagramNextBtn, instagramPrevBtn);
    
    instagram.nextBtn.click(function () {

      instagram.switchNextPostsView ()

    });
    instagram.prevBtn.click(function () {

      instagram.switchPrevPostsView ()

    });



    let facebookPost = $('#socialPosts #facebook .posts');
    let facebookPosts = $('#socialPosts #facebook .posts .post');
    let facebookNextBtn = $('#socialPosts #facebook .nav-btn .next');
    let facebookPrevBtn = $('#socialPosts #facebook .nav-btn .prev');

    const facebook = new MediaPosts (facebookPost, facebookPosts, facebookNextBtn, facebookPrevBtn);
    
    facebook.nextBtn.click(function () {

      facebook.switchNextPostsView ()

    });
    facebook.prevBtn.click(function () {

      facebook.switchPrevPostsView ()

    });

});