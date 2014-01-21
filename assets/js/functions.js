/**
 * Matty Theme QuickSwitch JavaScript
 *
 * @since 1.1.0
 * @author Matty
 * @access public
 * @return void
 */

(function ($) {
	mattyThemeQuickSwitch = {
		
		/**
		 * add_search_box method.
		 *
		 * @since 1.1.0
		 * @author Matty
		 * @access public
		 * @return void
		 */
		add_search_box: function () {
			var searchForm = $( '<form name="matty-theme-quickswitch-search" />' ).addClass( 'search-form' );
			searchForm.append( '<input type="text" class="search" />' );
			
			$( '#wp-admin-bar-matty-theme-quickswitch' ).find( '.ab-sub-wrapper ul' ).before( searchForm );
		}, 
		
		/**
		 * perform_search method.
		 *
		 * @since 1.1.0
		 * @author Matty
		 * @param string searchText
		 * @access public
		 * @return void
		 */
		perform_search: function ( searchText ) {
			mattyThemeQuickSwitch.reset_results();
			if ( searchText != '' && searchText.length >= 1 ) {
				
				$( '#wp-admin-bar-matty-theme-quickswitch li' ).each( function ( i ) {
					var hayStack = $( this ).text().toLowerCase();
					var needle = searchText.toLowerCase();

					if ( hayStack.indexOf( needle ) == -1 ) {
						$( this ).addClass( 'hide-theme' );
					}
				});
			}

		}, 

		/**
		 * reset_results method.
		 *
		 * @since 1.1.0
		 * @author Matty
		 * @access public
		 * @return void
		 */
		reset_results: function () {
			$( '#wp-admin-bar-matty-theme-quickswitch' ).find( '.hide-theme' ).removeClass( 'hide-theme' );
		}, 

		/**
		 * add_reset_button method.
		 *
		 * @since 1.1.0
		 * @author Matty
		 * @access public
		 * @return void
		 */
		add_reset_button: function () {
			if ( ! $( '.search-form .reset' ).length ) {
				var resetButton = $( '<a href="#" />' ).text( 'Reset' ).addClass( 'reset' ).addClass( 'button' );
				$( '#wp-admin-bar-matty-theme-quickswitch' ).find( 'input' ).after( resetButton );
			}
		}, 

		/**
		 * reset_button_handler method.
		 *
		 * @since 1.1.0
		 * @author Matty
		 * @access public
		 * @return void
		 */
		reset_button_handler: function ( e ) {
			$( '#wp-admin-bar-matty-theme-quickswitch' ).find( 'input' ).attr( 'value', '' );
			$( '#wp-admin-bar-matty-theme-quickswitch' ).find( '.hide-theme' ).removeClass( 'hide-theme' );
			$( '#wp-admin-bar-matty-theme-quickswitch a.reset' ).remove();
			return false;
		}

	}; // End mattyThemeQuickSwitch Object // Don't remove this, or the sky will fall on your head.
	
	$(document).ready(function () {

		mattyThemeQuickSwitch.add_search_box();

		// Make sure the search field focuses when visible.
		$( '#wp-admin-bar-matty-theme-quickswitch' ).mouseover( function ( e ) {
			$( '#wp-admin-bar-matty-theme-quickswitch' ).find( 'input.search' ).focus();
		});

		$( '#wp-admin-bar-matty-theme-quickswitch' ).find( 'input.search' ).keyup( function ( e ) {
			if ( $( this ).val() != '' ) {
				mattyThemeQuickSwitch.perform_search( $( this ).val() );
				mattyThemeQuickSwitch.add_reset_button();
				$( '.search-form a.reset' ).live( 'click', function () {
					mattyThemeQuickSwitch.reset_button_handler();
					return false;
				});			
			} else {
				mattyThemeQuickSwitch.reset_results();
				mattyThemeQuickSwitch.reset_button_handler();

				$( '#wp-admin-bar-matty-theme-quickswitch' ).find( 'input.search' ).focus();
			}
		});

	}); 
})(jQuery);