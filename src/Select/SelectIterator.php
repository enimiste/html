<?php
/**
 * Created by PhpStorm.
 * User: elbachirnouni
 * Date: 27/03/2016
 * Time: 13:43
 */

namespace Com\NickelIt\Html\Select;


use Com\NickelIt\Html\Select\Option\ParentOption;
use Com\NickelIt\Html\Select\Render\EmptySelectRender;
use Com\NickelIt\Html\Select\Render\SelectRender;
use Com\NickelIt\Html\Select\Render\SelectRenderInteface;

class SelectIterator {
	/** @var array of ChildSelect */
	protected $selects;
	/**
	 * @var ParentSelect
	 */
	private $rootSelect;

	/**
	 * SelectIterator constructor.
	 *
	 * @param ParentSelect $select
	 */
	public function __construct( ParentSelect $select ) {
		$this->rootSelect = $select;

		$this->buildSelectsArray( $select );
	}


	/**
	 * Extract the first element (from parent to last child order)
	 *
	 * @return SelectRenderInteface
	 */
	public function next() {
		if ( empty( $this->selects ) ) {
			return new EmptySelectRender();
		}

		return new SelectRender( array_shift( $this->selects ) );
	}

	/**
	 * @param ParentSelect $select
	 */
	private function buildSelectsArray( ParentSelect $select ) {
		$this->selects[] = $select;
		if ( $select->hasDirectChild() ) {
			$this->buildSelectsArray( $select->getDirectChild() );
		}
	}

	/**
	 * @return array
	 */
	public function getSelectsKeys() {
		return array_map( function ( ParentSelect $item ) {
			return [
				'htmlId'  => $item->getHtmlId(),
				'options' => array_map( function ( ParentOption $op ) {
					return [ 'key' => $op->getKey(), 'value' => $op->getValue() ];
				},
					$item->getOptions() ),
			];
		},
			$this->selects );
	}

	/**
	 * @return array
	 */
	public function getSelects() {
		return $this->selects;
	}
}