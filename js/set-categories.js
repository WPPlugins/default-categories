// Iterate over all the category checkboxes
jQuery( document ).ready( function () {
		jQuery( '#categories-all' ).add( '#categories-pop' ).find( ':checkbox' ).each( dc_set_category ); 
	} );

function dc_set_category()
{
	// Set everything to unchecked
	jQuery( this ).removeAttr( 'checked' );
	// Recheck the default categories
	if ( typeof( dc_default_categories[ jQuery( this ).val() ] ) !== 'undefined' ) {
		jQuery( this ).attr( 'checked', 'checked' );
	}
}
