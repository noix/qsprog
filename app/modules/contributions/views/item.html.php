<? if ($publier): ?>
<p class="auteur">par <?= $cercle ?></p>
<div class="sous-boite">
<? if ($phase == 2): ?>
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
<? endif; ?>
<?= $contribution ?>
</div>
<? endif; ?>