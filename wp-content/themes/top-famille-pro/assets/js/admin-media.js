(function ($) {
	'use strict';

	$( '.tfp-champ-photo__choisir' ).on( 'click', function () {
		var $champ = $( this ).closest( '.tfp-champ-photo' );
		var frame = wp.media( { title: 'Choisir une image', multiple: false } );
		frame.on( 'select', function () {
			var attachment = frame.state().get( 'selection' ).first().toJSON();
			$champ.find( '.tfp-champ-photo__id' ).val( attachment.id );
			$champ.find( '.tfp-champ-photo__apercu' ).html(
				'<img src="' + ( attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url ) + '" style="max-width:120px;height:auto;">'
			);
		} );
		frame.open();
	} );

	$( '.tfp-champ-photo__retirer' ).on( 'click', function () {
		var $champ = $( this ).closest( '.tfp-champ-photo' );
		$champ.find( '.tfp-champ-photo__id' ).val( '0' );
		$champ.find( '.tfp-champ-photo__apercu' ).empty();
	} );
})( jQuery );
