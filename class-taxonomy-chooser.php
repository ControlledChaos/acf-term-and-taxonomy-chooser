<?php
/**
 * Core plugin class
 *
 * @package ACF_Taxonomy_Chooser
 *
 * @version 1.0.0
 * @author  Marktime Media, modified by Controlled Chaos Design
 */

namespace ACF_Tax_Chooser;

class Taxonomy_Chooser extends \acf_field {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		/**
		 * Field name
		 *
		 * Single word, no spaces. Underscores allowed
		 *
		 * @return string
		 */
		$this->name = 'taxonomy-chooser';

		/**
		 * Field label
		 *
		 * Multiple words, can include spaces, visible when selecting a field type
		 *
		 * @return string
		 */
		$this->label = __( 'Term and Taxonomy Chooser', 'acf-taxonomy-chooser' );

		/**
		 * Field category
		 *
		 * basic|content|choice|relational|jquery|layout|CUSTOM GROUP NAME
		 *
		 * @return string
		 */
		$this->category = 'choice';

		/**
		 * Field defaults
		 *
		 * Array of default settings which are merged into the field object.
		 * These are used later in settings.
		 *
		 * @return array
		 *
		 * Notes: 'multiple' used to be associated with a 'select multiple values field' also
		 */
		$this->defaults = [
		    'choices'    => [],
		    'tax_type'   => 0,
		    'allow_null' => 0,
		    'ui'         => 0,
		    'ajax'       => 0,
		    'type_value' => 1,
		    'multiple'   => 0,
		];

		/**
		 * Field l10n
		 *
		 * Array of strings that are used in JavaScript.
		 *
		 * This allows JS strings to be translated in PHP and loaded via:
		 * `var message = acf._e( 'taxonomy-chooser', 'error' );`
		 *
		 * @return array
		 */
		$this->l10n = array(
			'error'	=> __( 'Error! Please enter a higher value', 'acf-taxonomy-chooser' ),
		);

		/**
		 * Extend constructor
		 *
		 * This extends the constructor method of the `acf_field` class.
		 */
    		parent::__construct();

	}

	/**
	 * Render Field Settings
	 *
	 * @param  $field arra) The field being edited.
	*  @return n/a
	 */
	function render_field_settings( $field ) {

		// Term or taxonomy.
		acf_render_field_setting( $field, [
		    'label'        => __( 'Select Type', 'acf-taxonomy-chooser' ),
		    'instructions' => '',
		    'type'         => 'select',
		    'name'         => 'tax_type',
		    'choices'      => [
			1 => __( 'Taxonomy', 'acf-taxonomy-chooser' ),
			0 => __( 'Term', 'acf-taxonomy-chooser' ),
				],
		    'layout'       => 'horizontal',
		] );

		 // Allowed taxonomies.
		acf_render_field_setting( $field, [
		    'label'        => __( 'Choose Allowed Taxonomies', 'acf-taxonomy-chooser' ),
		    'instructions' => '',
		    'type'         => 'select',
		    'name'         => 'choices',
		    'choices'      => acf_get_pretty_taxonomies(),
		    'multiple'     => 1,
		    'ui'           => 1,
		    'allow_null'   => 1,
		    'placeholder'  => __( 'All Taxonomies', 'acf-taxonomy-chooser' ),
			] );

			// Allow_null.
			acf_render_field_setting( $field, [
				'label'        => __( 'Allow Null', 'acf-taxonomy-chooser' ),
				'instructions' => '',
				'name'         => 'allow_null',
				'type'         => 'true_false',
				'ui'           => 1,
			] );

		 // Term ID or slug.
		acf_render_field_setting( $field, [
		    'label'        => __( 'Return Term Value', 'acf-taxonomy-chooser' ),
		    'instructions' => __( 'Specify the returned value on front end (taxonomies always return as slug)', 'acf-taxonomy-chooser' ),
		    'type'         => 'radio',
		    'name'         => 'type_value',
		    'choices'      => [
			1 => __( 'ID', 'acf-taxonomy-chooser' ),
			0 => __( 'Slug', 'acf-taxonomy-chooser' ),
				],
		    'layout'	=>	'horizontal',
		] );

	}

	/**
	 * Render Field
	 *
	 * @param  $field array The $field being edited.
	 * @return n/a
	 */
	function render_field( $field ) {

		$taxonomies          = [];
		$taxonomies          = acf_get_array( $taxonomies );
		$taxonomies          = acf_get_pretty_taxonomies( $taxonomies );
		$taxonomy_terms      = acf_get_taxonomy_terms();
		$selected_taxonomies = [];
		$terms               = [];

			if ( ! empty( $field['choices'] ) ) {
				$slug_name = $field['choices'];
			} else {
				$slug_name = array_keys( acf_get_pretty_taxonomies() );
			}

			// Select terms.
		if ( 'Term' == $field['tax_type'] ) {

			 foreach ( $slug_name as $k1 => $v1 ) {

					$found_terms = get_terms( $v1, [ 'hide_empty' => false ] );

				if ( ! empty( $found_terms ) && is_array( $found_terms ) ) {
						$terms = array_merge( $terms, $found_terms );
					}

			    foreach( $taxonomies as $k2 => $v2 ) {

				if ( $v1 == $k2 ) {
				    $slug_name[$k1] = $v2;
				}
			    }
			}

			foreach ( $slug_name as $k1 => $v1 ) {
			    foreach ( $taxonomy_terms as $k2 => $v2 ) {
				if ( $v1 == $k2 ) {
				    $selected_taxonomies[$v1] = $taxonomy_terms[$k2];
				}
			    }
			}

			// Select taxonomies.
		} else {

				$taxonomies = [];

				// Only use allowed taxonomies.
				foreach ( $slug_name as $tax_name ) {
					$taxonomies[ $tax_name ] = get_taxonomy( $tax_name );
				}

			    foreach( $taxonomies as $taxonomy ) {
					$selected_taxonomies[ $taxonomy->name ] = $taxonomy->label;
				}
		}

		$slug_name = $selected_taxonomies;

		// Add empty value (allows '' to be selected).
		if ( empty( $field['value'] ) ) {
		    $field['value'] = '';
		}

		// Placeholder.
		if ( empty( $field['placeholder'] ) ) {
		    $field['placeholder'] = __( 'Select', 'acf-taxonomy-chooser' );
		}


		// Select field attributes.
		$atts = [
		    'id'               => $field['id'],
		    'class'            => $field['class'] . ' js-multi-taxonomy-select2',
		    'name'             => $field['name'],
		    'data-ui'          => $field['ui'],
		    'data-ajax'        => $field['ajax'],
		    'data-placeholder' => $field['placeholder'],
		    'data-allow_null'  => $field['allow_null']
			];

		// Hidden input.
		if ( $field['ui'] ) {

		    acf_hidden_input( [
			'type'  => 'hidden',
			'id'    => $field['id'],
			'name'  => $field['name'],
			'value' => implode( ',', $field['value'])
		    ] );

		} elseif ( $field['multiple'] ) {

		    acf_hidden_input( [
			'type' => 'hidden',
			'name' => $field['name'],
		    ] );
		}


		// User interface;
		if ( $field['ui'] ) {
		    $atts['disabled'] = 'disabled';
		    $atts['class']   .= ' acf-hidden';
		}

		// Special attributes.
		foreach ( [ 'readonly', 'disabled' ] as $k ) {

		    if ( ! empty( $field[ $k ] ) ) {
			$atts[ $k ] = $k;
		    }
		}

		// Variables.
		$els     = [];
		$choices = [];

		// Loop through values and add them as options.
		if ( ! empty( $slug_name ) ) {

				// Allowed taxonomies.
		    foreach ( $slug_name as $k => $v ) {

				 if ( is_array( $v ) ) {

			    // The optgroup elements.
			    $els[] = [ 'type' => 'optgroup', 'label' => $k ];

			    if ( ! empty( $v ) ) {

				foreach ( $v as $k2 => $v2 ) {

								// Child categories have hyphens before the name, we need to remove them in order to match them.
					$strip_v2_hyphen = preg_replace( '#-\s?#', '', $v2 );

								// Value = term ID.
					if ( $field['type_value'] ) {

						foreach ( $terms as $key => $val ) {

							if ( $val->name == $strip_v2_hyphen ) {

							    $els[] = [ 'type' => 'option', 'value' => $val->term_id, 'label' => $v2 , 'selected' => $slct = ( $val->term_id == $field['value'] ? "selected": "" ) ];

							}
						}

								// Value = term slug.
					} else {

									// Originally returns 'taxonomy:term-slug' this removes 'taxonomy:'.
						preg_match( '#(?::)(.*)#', $k2, $value );

						$els[] = [ 'type' => 'option', 'value' => $value[1], 'label' => $v2, 'selected' => $slct = ( $value[1] == $field['value'] ? "selected": "" ) ];
					}
					$choices[] = $k2;

				}

			    }

			    $els[] = [ 'type' => '/optgroup' ];

					// Value = Taxonomy Slug.
			} else {

			    $els[] = [ 'type' => 'option', 'value' => $k, 'label' => $v, 'selected' => $slct = ( $k == $field['value'] ? "selected": "" ) ];
			    $choices[] = $k;
			}

		    }
		}

		// Null: the "Select" option.
		if ( $field['allow_null'] ) {
		    array_unshift( $els, [ 'type' => 'option', 'value' => '', 'label' => '- ' . $field['placeholder'] . ' -' ] );
		}

		// Select element markup.
		echo '<select ' . acf_esc_attr( $atts ) . '>';

			// construct html
			if ( ! empty( $els ) ) {

			    foreach ( $els as $el ) {

				// Extract type.
				$type = acf_extract_var( $el, 'type' );

				if ( $type == 'option' ) {

				    // Get label.
				    $label = acf_extract_var( $el, 'label' );

				    // Validate selected.
				    if ( acf_extract_var( $el, 'selected' ) ) {
					$el['selected'] = 'selected';
				   }
				    echo '<option ' . acf_esc_attr( $el ) . '>' . $label . '</option>';

				} else {
				    echo '<' . $type . ' ' . acf_esc_attr( $el ) . '>';
				}
			    }

			}

		echo '</select>';

	    }

	/**
	 * Enqueue scripts
	 *
	 * This action is called in the admin_enqueue_scripts action on
	 * the edit screen where your field is created.
	 *
	 * Use this action to add CSS + JavaScript to assist your render_field() action.
	 */
	function input_admin_enqueue_scripts() {

		$dir = plugin_dir_url( __FILE__ );

		wp_register_script( 'acf-input-taxonomy-chooser', "{$dir}js/input.min.js" );
		wp_enqueue_script( 'acf-input-taxonomy-chooser' );

	}
}

// Run the class.
new Taxonomy_Chooser();
