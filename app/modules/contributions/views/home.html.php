<? if ($items): ?>
<dl>
<? foreach($items as $item): ?>
	<dt><?= a($item['path'], $item['titre']) ?></dt>
	<dd>par <?= $item['cercle'] ?></dd>
<? endforeach; ?>
</dl>
<?= a('contributions', 'Voir toutes les contributions') ?>
<? endif; ?>
