<?php
/*
 * Plugin Name: ACF Taxonomy Chooser
 * Plugin URI: https://github.com/ControlledChaos/acf-term-and-taxonomy-chooser
 * Description: Choose from any taxonomy or term.
 * Version: 1.2
 * Author: Marktime Media, Controlled Chaos Design
 * Author URI:
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * GitHub Plugin URI: https://github.com/ControlledChaos/acf-term-and-taxonomy-chooser
*/

// Set text domain.
load_plugin_textdomain( 'acf-taxonomy-chooser', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );

// Include field type for ACF5.
function include_field_types_taxonomy_chooser( $version ) {
	include_once( 'acf-taxonomy-chooser-v5.php' );
}
add_action( 'acf/include_field_types', 'include_field_types_taxonomy_chooser' );
