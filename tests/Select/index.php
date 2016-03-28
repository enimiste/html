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
		new ParentOption( '30', 'Casa' ),
	]
)->withChild( 'site_production',
	[
		new ChildOption( '10', '10', 'Site de Agdal' ),
		new ChildOption( '10', '20', 'Site de Rabat ville' ),
		new ChildOption( '20', '30', 'Site de Salé Tabrikt' ),
		new ChildOption( '30', '40', 'Site de Casa Port' ),
		new ChildOption( '30', '50', 'Site de Casa Sidi Momen' ),
		new ChildOption( '30', '60', 'Site de Casa Sidi Maarouf' ),
	]
)->withChild( 'projet_production',
	[
		new ChildOption( '10', '10', 'Projet Orange Rabat Agdal' ),
		new ChildOption( '20', '20', 'Projet Orange Rabat ville' ),
		new ChildOption( '20', '30', 'Projet Axa Assurance Rabat ville' ),
		new ChildOption( '30', '40', 'Projet Axa Assurance Salé Tabrikt' ),
		new ChildOption( '30', '50', 'Projet Axa Assurance Salé Tabrikt' ),
	]
)->withChild( 'equipe_production',
	[
		new ChildOption( '10', '10', 'Equipe A' ),
		new ChildOption( '10', '10', 'Equipe B' ),
		new ChildOption( '20', '10', 'Equipe C' ),
		new ChildOption( '30', '10', 'Equipe D' ),
	]
)->end();

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
	<div style="margin-left: 30px; border-left: 1px solid black; margin-top: 10px;padding-left: 5px;">
		<label for="equipe_production">Equipe de production</label>

		<div><?php echo $selects->next()->render( 'codeEquipeProduction', null, [ 'class' => 'equipe_production' ] ); ?></div>
	</div>
</form>

<script src="/html/tests/assets/js/jquery-2.2.2.min.js"></script>
<script src="/html/tests/assets/js/underscore-min.js"></script>
<script>
	<?php echo $selectBuilder->script(); ?>
</script>
