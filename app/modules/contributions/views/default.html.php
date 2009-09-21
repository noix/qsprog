<? if ($this->items): ?>
<dl>
	<? foreach ($this->items as $item): ?>
	<dt><?= a($item['path'], $item['titre']) ?></dt>
	<dd>
		<? if ($item['phase'] == 2): ?>
		<p>
			<?= $item['typeModification_string'] . (($item['typeModification'] == 1) ? ' à' : '') ?>
			<?= ($item['typeModification'] == 4) ? '' : ' la perspective ' . e('strong', $item['perspective_numero']) ?></p>
		<? endif; ?>
		<p>par <?= $item['cercle'] ?></p>
	</dd>
	<? endforeach; ?>
</dl>
<? else: ?>
<? endif; ?>