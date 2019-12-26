<?php
/**
 * ACF Term and Taxonomy Chooser
 *
 * @package ACF_Taxonomy_Chooser
 * @version 1.0.0
 * @author  Marktime Media, modified by Controlled Chaos Design
 * @link    https://github.com/ControlledChaos/acf-term-and-taxonomy-chooser
 * @license GPL-3.0+ http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * Plugin Name:  ACF Term and Taxonomy Chooser
 * Plugin URI:   https://github.com/ControlledChaos/acf-term-and-taxonomy-chooser
 * Description:  Choose from any taxonomy or term.
 * Version:      1.0.0
 * Author:       Marktime Media, modified by Controlled Chaos Design
 * Author URI:   https://github.com/ControlledChaos
 * License:      GPL-3.0+
 * License URI:  https://www.gnu.org/licenses/gpl.txt
 * Text Domain:  acf-taxonomy-chooser
 * Domain Path:  /languages
 * Tested up to: 5.2.3
 */

/**
 * License & Warranty
 *
 * ACF Term and Taxonomy Chooser is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * ACF Term and Taxonomy Chooser is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACF Term and Taxonomy Chooser. If not, see {URI to Plugin License}.
 */

// Set text domain.
load_plugin_textdomain( 'acf-taxonomy-chooser', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

// Include field type for ACF5.
function include_field_types_taxonomy_chooser( $version ) {
	include_once( 'class-taxonomy-chooser.php' );
}
add_action( 'acf/include_field_types', 'include_field_types_taxonomy_chooser' );