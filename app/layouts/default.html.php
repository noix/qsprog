<div class="couleur">
	<div class="boite">
		<div id="intro">
			<? if ($afficherEtape): ?>
			<? $etapes = Module::GetNewModule('fleche', $etape) ?>
			<? $etapes->Display() ?>
			<? endif; ?>

			<? if ($titre): ?><h2><?= $titre ?></h2><? endif; ?>
			<? if ($afficherVideo): ?>
			<div class="themes">
				<? if ($intro): ?><p class="themes"><?= $intro ?></p><? endif; ?>
				<div class="video themes">
					<div id="videotheme"></div>
				</div>
			</div>
			<? else: ?>
				<? if ($intro): ?><p><?= $intro ?></p><? endif; ?>
			<? endif; ?>
		</div>
		
		<? if ($afficherTheme): ?>
		<div id="themes-nav">
			<h3>Les thèmes</h3>
			<? $themes = Module::GetNewModule('themes') ?>
			<? $themes->LoadView('entete') ?>
		</div>
		<? endif; ?>

		<div class="clear">&nbsp;</div>
	</div>
</div>

<div class="navigation">
	<div class="boite">
		<?= $body ?>
		<div class="clear">&nbsp;</div>
	</div>
</div>
