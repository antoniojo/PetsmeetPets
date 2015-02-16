
   $(window).load(function(){
      'use strict';
      $('.flexslider').flexslider({
        animation: "fade",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });