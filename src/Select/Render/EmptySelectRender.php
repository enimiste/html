<?php
/**
 * Created by PhpStorm.
 * User: elbachirnouni
 * Date: 27/03/2016
 * Time: 13:57
 */

namespace Com\NickelIt\Html\Select\Render;


class EmptySelectRender implements SelectRenderInteface {

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

		$randomName = '__' . time();

		return sprintf( '<select name="%s" id="%s" %s><option>Attention : there is no select defined</option></select>', $randomName, $randomName, $attrs );
	}
}