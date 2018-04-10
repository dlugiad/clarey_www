(function($) {
	$(function(){

		// go to top button
		$('.go-to-top').click(function(){ 
		    $('html,body').animate({ scrollTop: 0 }, 'slow');
	        return false; 
	    });

		// styling navbar form
	    $('#loginform').addClass('navbar-form').find('p').addClass('form-group').filter('.login-submit').find('input[type="submit"]').addClass('btn btn-default bg-darker-green border-light-green');

	    //styling menu color
	    var color = $('#js-menu-color').attr('data-color');
	    // var hover = $('#js-menu-color').attr('data-hover');
	    // $('head').append('<style>.js-navbar{background:'+color+'!important;} .navbar-green li a:hover, .navbar-green li a:focus, .navbar-green li a.active {background-color: '+hover+';}</style>');
	    if (color){
	    	$('.js-navbar').removeClass('navbar-green').addClass('navbar-blue');
	    	$('.navbar-form').find('.bg-darker-green').removeClass('bg-darker-green border-light-green').addClass('bg-darker-blue');
	    }

	});
})(jQuery);