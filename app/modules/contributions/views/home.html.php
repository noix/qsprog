<? if ($items): ?>
<dl>
<? foreach($items as $item): ?>
	<dt><?= a($item['path'], $item['titre']) ?></dt>
	<dd>par <?= $item['cercle'] ?></dd>
<? endforeach; ?>
</dl>
<? endif; ?>