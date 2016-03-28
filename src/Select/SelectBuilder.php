<?php
/**
 * Created by PhpStorm.
 * User: elbachirnouni
 * Date: 27/03/2016
 * Time: 13:21
 */

namespace Com\NickelIt\Html\Select;


use Com\NickelIt\Html\Select\Option\ChildOption;
use Com\NickelIt\Html\Select\Option\ParentOption;

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
		$code     = '';
		$iterator = new SelectIterator( $this->rootParent );
		$selects  = $iterator->getSelects();
		/** @var ParentSelect $parent */
		$parent = array_shift( $selects );

		//0
		$jsArrays = $this->_prepareJsVars( $parent, $selects );
		//1
		$childsChange = '';
		for ( $i = 0; $i < count( $selects ) - 1; $i ++ ) {
			/** @var ChildSelect $child */
			$child     = $selects[ $i ];
			$childCode = sprintf( "$( '#%s option:selected' ).each(function() {%s", $child->getHtmlId(), PHP_EOL );
			$childCode .= sprintf( "var selectedCode = $( this ).val() || '';%s", PHP_EOL );
			$childCode .= sprintf( "var filteredChildren = _.filter(%ss, function(item){ return item.parent == selectedCode; });%s",
				$child->getDirectChild()->getHtmlId(),
				PHP_EOL );
			$childCode .= sprintf( 'jQuery("#%s").empty().append(_.map(filteredChildren, function(item){ return jQuery("<option></option>").attr("value", item.key).text(item.value); }))%s',
				$child->getDirectChild()->getHtmlId(),
				PHP_EOL );
			$childCode .= sprintf( "jQuery( '#%s' ).trigger('change');%s", $child->getDirectChild()->getHtmlId(), PHP_EOL );
			$childCode .= PHP_EOL . "});";
			$childsChange .= sprintf( "jQuery('#%s').change(function(event){%s});%s",
				$child->getHtmlId(),
				$childCode,
				PHP_EOL );
		}

		$parentCode = sprintf( "$( '#%s option:selected' ).each(function() {%s", $parent->getHtmlId(), PHP_EOL );
		$parentCode .= sprintf( "var _selectedCode = $( this ).val() || '';%s", PHP_EOL );
		$parentCode .= sprintf( "var _filteredChildren = _.filter(%ss, function(item){ return item.parent == _selectedCode; });%s",
			$parent->getDirectChild()->getHtmlId(),
			PHP_EOL );
		$parentCode .= sprintf( 'jQuery("#%s").empty().append(_.map(_filteredChildren, function(item){ return jQuery("<option></option>").attr("value", item.key).text(item.value); }))%s',
			$parent->getDirectChild()->getHtmlId(),
			PHP_EOL );
		$parentCode .= sprintf( "jQuery( '#%s' ).trigger('change');%s", $parent->getDirectChild()->getHtmlId(), PHP_EOL );
		$parentCode .= PHP_EOL . "});";
		$parentChange = sprintf( "jQuery('#%s').change(function(event){%s});%s",
			$parent->getHtmlId(),
			$parentCode,
			PHP_EOL );
		//2
		$code .= sprintf( " %s%s", $childsChange, PHP_EOL );
		$code .= sprintf( " %s%s", $parentChange, PHP_EOL );
		$code .= sprintf( "jQuery( '#%s' ).val(%ss[0].key);%s", $parent->getHtmlId(), $parent->getHtmlId(), PHP_EOL );
		$code .= sprintf( "jQuery( '#%s' ).trigger('change');", $parent->getHtmlId() );

		return sprintf( "%s%sjQuery(document).ready(function(){ %s%s%s });", $jsArrays, PHP_EOL, PHP_EOL, $code, PHP_EOL );
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

	/**
	 * @param $parent
	 * @param $selects
	 *
	 * @return string
	 */
	protected function _prepareJsVars( $parent, $selects ) {
		$jsArrays = 'var ' . $parent->getHtmlId() . 's = [' . rtrim( array_reduce( $parent->getOptions(),
				function ( $acc, ParentOption $op ) {
					return $acc . sprintf( '{"key":"%s", "value":"%s"},', $op->getKey(), $op->getValue() );
				},
				'' ),
				',' ) . '];';
		/** @var ChildSelect $select */
		foreach ( $selects as $select ) {
			$jsArrays .= PHP_EOL . 'var ' . $select->getHtmlId() . 's = [' . rtrim( array_reduce( $select->getOptions(),
					function ( $acc, ChildOption $op ) {
						return $acc . sprintf( '{"key":"%s","value":"%s", "parent":"%s"},', $op->getKey(), $op->getValue(), $op->getParentKey() );
					},
					'' ),
					',' ) . '];';
		}

		return $jsArrays;
	}
}