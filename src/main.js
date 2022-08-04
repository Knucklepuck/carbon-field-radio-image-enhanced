/**
 * External dependencies.
 */
import { Component } from '@wordpress/element';

/**
 * The internal dependencies.
 */
import './style.scss';

const NoOptions = () => (
	<em>
		{ __( 'No options.', 'carbon-fields-ui' ) }
	</em>
);

class Radio_Image_EnhancedField extends Component {
	/**
	 * Handles the change of the input.
	 *
	 * @param {Object} e
	 * @return {void}
	 */
	handleChange = ( e ) => {
		const { id, onChange } = this.props;

		onChange( id, e.target.value );
	}

	/**
	 * Renders the radio options
	 *
	 * @return {Object}
	 */
	renderOptions() {
		const {
			id,
			field,
			value,
			image,
			name
		} = this.props;

		return (
			<ul className="cf-radio__list">
				{ field.options.map( ( option, index ) => (
					<li className="cf-radio__list-item" key={ index }>
						<input
							type="radio"
							id={ `${ id }-${ option.value }` }
							name={ name }
							value={ option.value }
							checked={ value === option.value }
							className="cf-radio__input"
							onChange={ this.handleChange }
							{ ...field.attributes }
						/>

						<label className="cf-radio__label" htmlFor={ `${ id }-${ option.value }` }>
							{<img aria-label={ option.label } className="cf-radio-image-enhanced__image has-tooltip" src={ option.image } />}
							<span>
								{ option.label }
							</span>
						</label>
					</li>
				) ) }
			</ul>
		);
	}

	/**
	 * Renders the component.
	 *
	 * @return {Object}
	 */
	render() {
		const { field } = this.props;

		return (
			field.options.length > 0
				? this.renderOptions()
				: <NoOptions />
		);
	}
}

export default Radio_Image_EnhancedField;
