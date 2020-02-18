jQuery(function() {	

	jQuery('#main-nav-menu-toggle').click(function(){
		jQuery(this).toggleClass('toggled-on');
		jQuery('#main-nav-menu').toggleClass('toggled-on');
	});
	jQuery('a[href="#"]').click(function(){
		return false;
	});
	
	/* galerie d'avatar */
	jQuery.fn.myNegativMarginTop = function(){
		if( jQuery('.avadelete').length ) {
			var getHt = jQuery(this).height();
			mtVal = '-'+getHt+'px';
			jQuery('.avadelete').css( 'marginTop', mtVal );
			jQuery(this).closest('.panel-body').height(getHt);
		}			
	}	
	jQuery('.avalist').myNegativMarginTop();
	jQuery('.opn-toggle').click(function(){
		var getToggleId = jQuery(this).attr('id');
		var toggleIntId = getToggleId.replace(/[^0-9]/g, '');
		console.log(toggleIntId);
		jQuery('#opn-this-'+toggleIntId).toggleClass('opn');
	});
});	