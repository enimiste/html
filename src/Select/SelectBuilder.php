<?php
/**
 * Created by PhpStorm.
 * User: elbachirnouni
 * Date: 27/03/2016
 * Time: 13:21
 */

namespace Com\NickelIt\Html\Select;


class SelectBuilder {

	/** @var  ParentSelect */
	protected $rootParent;
	/** @var  ChildSelect */
	protected $lastChild;

	/**
	 * SelectBuilder constructor.
	 */
	private function __construct( ParentSelect $select ) {
		$this->rootParent = $select;
		$this->lastChild  = null;
	}


	/**
	 * @param string $htmlId
	 * @param array  $options
	 *
	 * @return SelectBuilder
	 */
	public static function thisParent( $htmlId, array $options ) {
		$builder = new self( new ParentSelect( $htmlId, $options ) );

		return $builder;
	}

	/**
	 * Return the Javascript code to output to a script tag
	 *
	 * @return string
	 */
	public function script() {
		return '';
	}

	/**
	 * @param       $htmlId
	 * @param array $options
	 *
	 * @return $this
	 * @throws Exception\HtmlSelectException
	 */
	public function withChild( $htmlId, array $options ) {
		if ( $this->lastChild == null ) {
			$this->lastChild = $this->rootParent->withChild( $htmlId, $options );
		} else {
			$this->lastChild = $this->lastChild->withChild( $htmlId, $options );
		}

		return $this;
	}

	/**
	 * @return $this
	 */
	public function end() {
		return $this;
	}

	/**
	 * @return SelectIterator
	 */
	public function iterator() {
		return new SelectIterator( $this->rootParent );
	}
}