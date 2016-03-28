<?php
/**
 * Created by PhpStorm.
 * User: elbachirnouni
 * Date: 28/03/2016
 * Time: 22:58
 */

use Com\NickelIt\Html\Select\Option\ChildOption;
use Com\NickelIt\Html\Select\Option\ParentOption;
use Com\NickelIt\Html\Select\SelectBuilder;

require_once '../bootstrap.php';

$baseUrl   = "http://158.69.221.100:9001";
$villeUrl  = $baseUrl . "/api/referentiel/villes_production";
$siteUrl   = $baseUrl . "/api/referentiel/sites_production";
$projetUrl = $baseUrl . "/api/referentiel/projets_production";

/**
 * @param string  $url
 * @param Closure $itemsFunc take a php stdClass and should return an array
 * @param Closure $mapFunc
 *
 * @return array
 */
function fetchFrom( $url, $itemsFunc, $mapFunc ) {
	$json = file_get_contents( $url );
	$obj  = json_decode( $json );

	$arr = $itemsFunc( $obj );

	return array_map( $mapFunc,
		$arr );
}


$villesOptions = fetchFrom( $villeUrl,
	function ( $obj ) {
		return $obj->data->data;
	},
	function ( $item ) {
		return new ParentOption( $item->code, $item->libelle );
	} );

$sitesOptions = fetchFrom( $siteUrl,
	function ( $obj ) {
		return $obj->data->data;
	},
	function ( $item ) {
		return new ChildOption( $item->codeVille, $item->code, $item->libelle );
	} );

$projetsOptions = fetchFrom( $projetUrl,
	function ( $obj ) {
		return $obj->data->data;
	},
	function ( $item ) {
		return new ChildOption( $item->codeSite, $item->code, $item->libelle );
	} );

// Exploitation du code
$selectBuilder = SelectBuilder::thisParent( 'ville_production', $villesOptions )
                              ->withChild( 'site_production', $sitesOptions )
                              ->withChild( 'projet_production', $projetsOptions )
                              ->end();
?>

<form action="" method="post">
	<?php $selects = $selectBuilder->iterator(); ?>
	<div style=" margin-top: 10px;">
		<label for="ville_production">Ville de production</label>

		<div><?php echo $selects->next()->render( 'codeVilleProduction', '20', [ 'class' => 'ville_production' ] ); ?></div>
	</div>
	<div style="margin-left: 10px; border-left: 1px solid black; margin-top: 10px;padding-left: 5px;">
		<label for="site_production">Site de production</label>

		<div><?php echo $selects->next()->render( 'codeSiteProduction', null, [ 'class' => 'site_production' ] ); ?></div>
	</div>
	<div style="margin-left: 20px; border-left: 1px solid black; margin-top: 10px;padding-left: 5px;">
		<label for="projet_production">Projet de production</label>

		<div><?php echo $selects->next()->render( 'codeProjetProduction', null, [ 'class' => 'projet_production' ] ); ?></div>
	</div>
</form>

<script src="/html/tests/assets/js/jquery-2.2.2.min.js"></script>
<script src="/html/tests/assets/js/underscore-min.js"></script>
<script>
	<?php echo $selectBuilder->script(); ?>
</script>

<?php
header( "Cache-Control: no-cache, must-revalidate" ); // HTTP/1.1
header( "Expires: Sat, 26 Jul 1997 05:00:00 GMT" );