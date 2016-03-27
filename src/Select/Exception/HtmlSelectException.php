<?php
/**
 * Created by PhpStorm.
 * User: elbachirnouni
 * Date: 27/03/2016
 * Time: 13:37
 */

namespace Com\NickelIt\Html\Select\Exception;


use Exception;

class HtmlSelectException extends \Exception {
	public function __construct( $message = "", $code = 0, Exception $previous = null ) {
		parent::__construct( $message, $code, $previous );
	}

}