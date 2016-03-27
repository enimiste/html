<?php
/**
 * Created by PhpStorm.
 * User: elbachirnouni
 * Date: 27/03/2016
 * Time: 13:25
 */

namespace Com\NickelIt\Html\Select\Option;


class ParentOption {

	/** @var  string */
	protected $key;
	/** @var  string */
	protected $value;

	/**
	 * ParentOption constructor.
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function __construct( $key, $value ) {
		$this->key   = $key;
		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param ParentOption|ChildOption $option
	 *
	 * @return bool
	 */
	public function isEqual( $option ) {
		return $option->key == $this->key;
	}
}