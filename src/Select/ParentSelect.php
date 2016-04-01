<?php
/**
 * Created by PhpStorm.
 * User: elbachirnouni
 * Date: 27/03/2016
 * Time: 13:22
 */

namespace Com\NickelIt\Html\Select;


use Com\NickelIt\Html\Select\Exception\HtmlSelectException;
use Com\NickelIt\Html\Select\Option\ChildOption;
use Com\NickelIt\Html\Select\Option\ParentOption;

class ParentSelect {
	/** @var  string */
	protected $htmlId;
	/** @var array array */
	protected $options;

	/** @var  ChildSelect */
	protected $directChild;

	/** @var  string */
	protected $selectedkey;

	/**
	 * ParentSelect constructor.
	 *
	 * @param  string $htmlId
	 * @param array   $options an array of ParentOption
	 */
	public function __construct( $htmlId, array $options ) {
		$this->htmlId      = $htmlId;
		$this->options     = $options;
		$this->directChild = null;
		$this->selectedkey = null;
	}


	/**
	 * Return true if the select dose not have any parent
	 *
	 * @return bool
	 */
	public function isRoot() {
		return true;
	}

	/**
	 * @param string $childHtmlId
	 * @param array  $childOptions an array of ChildOption
	 *
	 * @return ChildSelect
	 * @throws HtmlSelectException
	 */
	public function withChild( $childHtmlId, array $childOptions ) {
		$optionsKeys = $this->getKeys();
		/** @var ChildOption $option */
		foreach ( $childOptions as $option ) {
			if ( ! in_array( $option->getParentKey(), $optionsKeys ) ) {
				throw new HtmlSelectException( sprintf( "Invalid parent key %s on option (%s, %s)",
					$option->getParentKey(),
					$option->getKey(),
					$option->getValue() ) );
			}
		}
		$this->directChild = new ChildSelect( $this, $childHtmlId, $childOptions );

		return $this->directChild;
	}

	/**
	 * @return bool
	 */
	public function hasDirectChild() {
		return $this->directChild != null;
	}

	/**
	 * @return array of string
	 */
	public function getKeys() {
		return array_map( function ( ParentOption $option ) {
			return $option->getKey();
		},
			$this->options );
	}

	/**
	 * @return ChildSelect|null
	 */
	public function getDirectChild() {
		return $this->directChild;
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
	 * @param string $selectedkey
	 */
	public function setSelectedkey( $selectedkey ) {
		$this->selectedkey = $selectedkey;
	}

	/**
	 * @return string
	 */
	public function getSelectedkey() {
		return $this->selectedkey;
	}

	/**
	 * Return true if no value is selected before
	 *
	 * @return bool
	 */
	public function noneSelected() {
		return is_null( $this->selectedkey );
	}
}