<? if ($items): ?>
<dl>
<? foreach($items as $item): ?>
	<dt><?= a($item['path'], $item['titre']) ?></dt>
	<dd>
		<p class="type"><?= $this->strings['typesModificationFrontend'][$item['typeModification']] ?> <?= $item['perspective_numero'] ?></p>
		<p class="auteur">par <?= $item['cercle'] ?></p>
	</dd>
<? endforeach; ?>
</dl>
<?= a('contributions', 'Voir toutes les contributions') ?>
<? endif; ?>
