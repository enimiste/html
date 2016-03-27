<?php
/**
 * Created by PhpStorm.
 * User: elbachirnouni
 * Date: 27/03/2016
 * Time: 13:59
 */
namespace Com\NickelIt\Html\Select\Render;

interface SelectRenderInteface {
	/**
	 * @param string $htmlName
	 * @param null   $selectedkey
	 * @param array  $htmlAttributes
	 *
	 * @return string
	 */
	public function render( $htmlName, $selectedkey = null, array $htmlAttributes = [ ] );
}