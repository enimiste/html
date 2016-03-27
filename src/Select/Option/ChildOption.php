<?php
/**
 * Created by PhpStorm.
 * User: elbachirnouni
 * Date: 27/03/2016
 * Time: 13:30
 */

namespace Com\NickelIt\Html\Select\Option;


class ChildOption extends ParentOption {

	/** @var  string */
	protected $parentKey;

	/**
	 * @param string $parentKey
	 * @param string $key
	 * @param string $value
	 */
	public function __construct( $parentKey, $key, $value ) {
		parent::__construct( $key, $value );
		$this->parentKey = $parentKey;
	}

	/**
	 * @return string
	 */
	public function getParentKey() {
		return $this->parentKey;
	}

	/**
	 * @param ChildOption|ParentOption $option
	 *
	 * @return bool
	 */
	public function isEqual( $option ) {
		return parent::isEqual( $option ) && $option->parentKey == $this->parentKey;
	}


}