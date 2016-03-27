<?php
/**
 * Created by PhpStorm.
 * User: elbachirnouni
 * Date: 27/03/2016
 * Time: 13:49
 */

namespace Com\NickelIt\Html\Select\Render;

use Com\NickelIt\Html\Select\Option\ParentOption;
use Com\NickelIt\Html\Select\ParentSelect;

class SelectRender implements SelectRenderInteface {
	/**
	 * @var ParentSelect
	 */
	private $select;


	/**
	 * SelectRender constructor.
	 *
	 * @param ParentSelect $select
	 */
	public function __construct( ParentSelect $select ) {
		$this->select = $select;
	}

	/**
	 * @param string $htmlName
	 * @param null   $selectedkey
	 * @param array  $htmlAttributes
	 *
	 * @return string
	 */
	public function render( $htmlName, $selectedkey = null, array $htmlAttributes = [ ] ) {
		$attrs = ' ';
		foreach ( $htmlAttributes as $key => $v ) {
			$attrs .= sprintf( ' %s="%s"', $key, $v );
		}

		$options = ' ';
		/** @var ParentOption $option */
		foreach ( $this->select->getOptions() as $option ) {
			if ( ( is_integer( $selectedkey ) || is_string( $selectedkey ) ) && $option->getKey() == $selectedkey ) {
				$options .= sprintf( '<option value="%s" selected="selected">%s</option>', $option->getKey(), $option->getValue() );
			} else {
				$options .= sprintf( '<option value="%s">%s</option>', $option->getKey(), $option->getValue() );
			}
		}

		return sprintf( '<select name="%s" id="%s" %s>%s</select>', $htmlName, $this->select->getHtmlId(), $attrs, $options );
	}
}