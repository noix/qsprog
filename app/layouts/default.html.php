<div class="couleur">
	<div class="boite">
		<div id="intro">
			<? if ($surtitreEntete): ?><h3><?= $surtitreEntete ?></h3><? endif; ?>
			<? if ($titreEntete): ?><h2><?= $titreEntete ?></h2><? endif; ?>
			<? if ($afficherVideo): ?>
			<div class="themes">
				<? if ($introEntete): ?><p class="themes"><?= $introEntete ?></p><? endif; ?>
				<div class="video themes">
					<div id="videotheme"></div>
				</div>
			</div>
			<? else: ?>
				<? if ($introEntete): ?><?= $introEntete ?><? endif; ?>
			<? endif; ?>
		</div>
		
		<? if ($afficherTheme): ?>
		<div id="themes-nav">
			<h3>Les thèmes</h3>
			<? $themes = Module::GetNewModule('themes') ?>
			<? $themes->LoadView('entete') ?>
		</div>
		<? endif; ?>

		<? if ($afficherEtape): ?>
		<? $etapes = Module::GetNewModule('fleche', $etape) ?>
		<? $etapes->Display() ?>
		<? endif; ?>
		<div class="clear">&nbsp;</div>
	</div>
</div>

<? if ($titreCorps): ?>
<div id="titre">
	<div class="boite">
		<h2><?= $titreCorps ?></h2>
	</div>
</div>
<? endif; ?>
<div class="navigation">
	<div class="boite">
		<?= $body ?>
		<div class="clear">&nbsp;</div>
	</div>
</div>
