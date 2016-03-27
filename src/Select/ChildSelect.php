<?php
/**
 * Created by PhpStorm.
 * User: elbachirnouni
 * Date: 27/03/2016
 * Time: 13:22
 */

namespace Com\NickelIt\Html\Select;


use Com\NickelIt\Html\Select\Option\ChildOption;

class ChildSelect extends ParentSelect {
	/** @var  ParentSelect */
	protected $parent;
	/** @var  string */
	protected $htmlId;
	/** @var  array */
	protected $options;

	/**
	 * ChildSelect constructor.
	 *
	 * @param ParentSelect $parent
	 * @param string       $htmlId
	 * @param array        $options
	 */
	public function __construct( ParentSelect $parent, $htmlId, array $options ) {
		parent::__construct( $htmlId, $options );
		$this->parent = $parent;
	}


	/**
	 * Return true if the select dose not have any parent
	 *
	 * @return bool
	 */
	public function isRoot() {
		return false;
	}

	/**
	 * @return ParentSelect
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @return string
	 */
	public function getHtmlId() {
		return $this->htmlId;
	}

	/**
	 * @return array
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * @return array of array [prentKey, childKey]
	 */
	public function getKeysWithParentKey() {
		return array_map( function ( ChildOption $option ) {
			return [ $option->getParentKey(), $option->getKey() ];
		},
			$this->options );
	}

}