<? if ($publier): ?>
<p class="auteur">par <?= $cercle ?></p>
<div class="sous-boite">
<? if ($phase == 2): ?>
	<? if ($typeModification != 4): ?>
	<? switch ($typeModification):
		case 1:
			$typeString = 'est un amendement à';
			break;
		case 2:
			$typeString = 's’inscrit immédiatement avant';
			break;
		case 3:
			$typeString = 's’inscrit immédiatement après';
			break;
	endswitch; ?>
	<p>Cette contribution <?= $typeString ?> la perspective <strong><?= $perspective_numero ?></strong>:</p>
	<div class="perspective">
		<div class="texte"><?= TextRenderer::FormatText($perspective_texte) ?></div>
	</div>
	<? else: ?>
	<p>Cette contribution est un commentaire général sur l’ensemble des perspectives.</p>
	<? endif; ?>
<? endif; ?>
<?= $contribution ?>
</div>
<? endif; ?>