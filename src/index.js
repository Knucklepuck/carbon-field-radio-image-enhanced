/**
 * External dependencies.
 */
import { registerFieldType } from '@carbon-fields/core';

/**
 * Internal dependencies.
 */
import './style.scss';
import RadioImageEnhancedField from './main';

registerFieldType( 'radio_image_enhanced', RadioImageEnhancedField );
