$(function() {
	'use strict';
	/*
	Mobile navigation
	=========================== */
    //build dropdown
    $("<select />").appendTo(".navbar .navbar-collapse .nav");
 
    //Default option "Voir les rubriques…"
    $("<option />", {
       "selected": "selected",
       "value"   : "",
       "text"    : "Select menu"
    }).appendTo(".navbar .navbar-collapse .nav select"); 
 
    //Menu items
    $(".navbar .navbar-collapse .nav li a").each(function() {
        var el = $(this);
        $("<option />", {
            "value"   : el.attr("href"),
            "text"    : el.text()
        }).appendTo(".navbar .navbar-collapse .nav select");
    });

    //Link
    $(".navbar .navbar-collapse .nav select").change(function() {
        window.location = $(this).find("option:selected").val();
    });	
 
	/*
	Bounce animated
	=========================== */	
	$(".e_bounce").hover(
		function () {
		$(this).addClass("animated bounce");
		},
		function () {
		$(this).removeClass("animated bounce");
		}
	);

	/*
	cbpScroller
	=========================== */		
	new cbpScroller( document.getElementById( 'cbp-so-scroller' ) );

	/*
	Gallery hover
	=========================== */	
	$('.gallery-img-wrapper').hover(function(){
		$(".caption-wrapper", this).stop().animate({top:'0'},{queue:false,duration:300});
	}, function() {
		$(".caption-wrapper", this).stop().animate({top:'100%'},{queue:false,duration:300});
	});	
	
	/*
	Client hover
	=========================== */			
	$(".logo-hover").css({'opacity':'0','filter':'alpha(opacity=0)'});
			$('.client-link').hover(
			function() {
				$(this).find('.logo-hover').stop().fadeTo(900, 1);
				$(this).find('.client-logo').stop().fadeTo(900, 0);
			},
			function() {
				$(this).find('.logo-hover').stop().fadeTo(900, 0);
				$(this).find('.client-logo').stop().fadeTo(900, 1);
			}
		)

});