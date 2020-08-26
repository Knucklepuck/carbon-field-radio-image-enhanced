<?php

namespace Carbon_Field_Radio_Image_Enhanced;

use Carbon_Fields\Field\Radio_Image_Field;
use Carbon_Fields\Helper\Helper;

class Radio_Image_Enhanced_Field extends Radio_Image_Field {
	/**
	 * Changes the options array structure. This is needed to keep the array items order when it is JSON encoded.
	 * Will also work with a callable that returns an array.
	 *
	 * @param array|callable $options
	 * @param bool $stringify_value (optional)
	 * @return array
	 */
	protected function parse_options( $options, $stringify_value = false ) {
		$parsed = array();

		if ( is_callable( $options ) ) {
			$options = call_user_func( $options );
		}

		foreach ( $options as $key => $value ) {
			if ( is_array( $value ) && ! empty( $value['label'] ) ) {
				$parsed[] = array(
					'value' => $stringify_value ? strval( $key ) : $key,
					'label' => strval( $value['label'] ),
					'image' => strval( $value['image'] ),
				);
			} else {
				$parsed[] = array(
					'value' => $stringify_value ? strval( $key ) : $key,
					'label' => strval( $value ),
				);
			}
		}

		return $parsed;
	}

	/**
	 * {@inheritDoc}
	 */
	public function set_value_from_input( $input ) {
		$options_values = $this->get_options_values();

		$value = null;
		if ( isset( $input[ $this->get_name() ] ) ) {
			$raw_value = stripslashes_deep( $input[ $this->get_name() ] );
			$raw_value = Helper::get_valid_options( array( $raw_value ), $options_values );
			if ( ! empty( $raw_value ) ) {
				$value = $raw_value[0];
			}
		}

		if ( $value === null ) {
			$value = $options_values[0];
		}

		return $this->set_value( $value );
	}

	/**
	 * {@inheritDoc}
	 */
	public function to_json( $load ) {
		$field_data = parent::to_json( $load );
		$options = $this->parse_options( $this->get_options(), true );
		$value = strval( $this->get_formatted_value() );

		$field_data = array_merge( $field_data, array(
			'value' => strval( $value ),
			'options' => $options,
		) );

		return $field_data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_formatted_value() {
		$options_values = $this->get_options_values();
		if ( empty( $options_values ) ) {
			$options_values[] = '';
		}

		$value = $this->get_value();
		$value = $this->get_values_from_options( array( $value ) );
		$value = ! empty( $value ) ? $value[0] : $options_values[0];

		return $value;
	}

	/**
	 * Prepare the field type for use.
	 * Called once per field type when activated.
	 *
	 * @static
	 * @access public
	 *
	 * @return void
	 */
	public static function field_type_activated() {
		$dir = \Carbon_Field_Radio_Image_Enhanced\DIR . '/languages/';
		$locale = get_locale();
		$path = $dir . $locale . '.mo';
		load_textdomain( 'carbon-field-Radio_Image_Enhanced', $path );
	}

	/**
	 * Enqueue scripts and styles in admin.
	 * Called once per field type.
	 *
	 * @static
	 * @access public
	 *
	 * @return void
	 */
	public static function admin_enqueue_scripts() {
		$root_uri = \Carbon_Fields\Carbon_Fields::directory_to_url( \Carbon_Field_Radio_Image_Enhanced\DIR );

		// Enqueue field styles.
		wp_enqueue_style( 'carbon-field-Radio_Image_Enhanced', $root_uri . '/build/bundle.css' );

		// Enqueue field scripts.
		wp_enqueue_script( 'carbon-field-Radio_Image_Enhanced', $root_uri . '/build/bundle.js', array( 'carbon-fields-core' ) );
	}
}
