<?php
/**
 * Created by PhpStorm.
 * User: elbachirnouni
 * Date: 27/03/2016
 * Time: 13:09
 */
require_once '../bootstrap.php';

use Com\NickelIt\Html\Select\Option\ChildOption;
use Com\NickelIt\Html\Select\Option\ParentOption;
use Com\NickelIt\Html\Select\SelectBuilder;

$selectBuilder = SelectBuilder::thisParent( 'ville_production',
	[
		new ParentOption( '10', 'Rabat' ),
		new ParentOption( '20', 'Salé' ),
	]
)->withChild( 'site_production',
	[
		new ChildOption( '10', '10', 'Site de Agdal' ),
		new ChildOption( '10', '20', 'Site de Rabat ville' ),
		new ChildOption( '20', '30', 'Site de Salé Tabrikt' ),
	]
)->withChild( 'projet_production',
	[
		new ChildOption( '10', '10', 'Projet Orange Rabat Agdal' ),
		new ChildOption( '20', '20', 'Projet Orange Rabat ville' ),
		new ChildOption( '20', '30', 'Projet Axa Assurance Rabat ville' ),
		new ChildOption( '30', '40', 'Projet Axa Assurance Salé Tabrikt' ),
		new ChildOption( '30', '50', 'Projet Axa Free Salé Tabrikt' ),
	]
)->end();

?>
<script>
	<?php echo $selectBuilder->script(); ?>
</script>
<form action="" method="post">
	<?php $selects = $selectBuilder->iterator(); ?>
	<div style=" margin-top: 10px;">
		<label for="ville_production">Ville de production</label>

		<div><?php echo $selects->next()->render( 'codeVilleProduction', '10', [ 'class' => 'ville_production' ] ); ?></div>
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
