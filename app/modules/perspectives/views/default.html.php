<? if ($this->items): ?>
<ul class="perspectives">
<? foreach ($this->items as $item): ?>
<? if ($item['soustitre']): ?>
<li class="entete<?= $item['first'] ? ' section' : '' ?>"><?= $item['soustitre'] ?></li>
<? endif ?>
<? if ($item['header'] && !$item['veryFirst']): ?>
	</ul>
</li>
<li>
<? else: ?>
<li>
<? endif; ?>
	<div class="numero"><?= $item['numero'] ?></div>
	<div class="texte"><?= TextRenderer::FormatText($item['texte']) ?></div>
<? if ($item['header']): ?>
	<ul>
<? else: ?>
</li>
<? endif; ?>
<? endforeach; ?>
	</ul>
</li>
</ul>
<? endif; ?>
