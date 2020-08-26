<?php

use Carbon_Fields\Carbon_Fields;
use Carbon_Field_Radio_Image_Enhanced\Radio_Image_Enhanced_Field;

define( 'Carbon_Field_Radio_Image_Enhanced\\DIR', __DIR__ );

Carbon_Fields::extend( Radio_Image_Enhanced_Field::class, function( $container ) {
	return new Radio_Image_Enhanced_Field(
		$container['arguments']['type'],
		$container['arguments']['name'],
		$container['arguments']['label']
	);
} );
