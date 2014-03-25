/**
 * Handles toggling the main navigation menu for small screens.
 */
jQuery( document ).ready( function( $ ) {
	var $masthead = $( '#header' ),
	    timeout = false;

	$.fn.smallMenu = function() {
		$masthead.find( '#access' ).removeClass( 'main-navigation' ).addClass( 'main-small-navigation' );
		$masthead.find( '#access .menu-assist' ).addClass( 'menu-toggle' ).show();
		$masthead.find( '#access .ma-hide' ).show();

		$( '.menu-toggle' ).unbind( 'click' ).click( function() {
			$masthead.find( '.menu' ).toggle();
			$( this ).toggleClass( 'toggled-on' );
		} );
	};

	// Check viewport width on first load.
	if ( $( window ).width() < 600 )
		$.fn.smallMenu();

	// Check viewport width when user resizes the browser window.
	$( window ).resize( function() {
		var browserWidth = $( window ).width();

		if ( false !== timeout )
			clearTimeout( timeout );

		timeout = setTimeout( function() {
			if ( browserWidth < 600 ) {
				$.fn.smallMenu();
			} else {
				$masthead.find( '#access' ).removeClass( 'main-small-navigation' ).addClass( 'main-navigation' );
				$masthead.find( '#access .menu-assist' ).removeClass( 'menu-toggle' ).hide();
				$masthead.find( '#access .ma-hide' ).hide();
				$masthead.find( '.menu' ).removeAttr( 'style' );
			}
		}, 200 );
	} );
} );
