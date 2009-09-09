<div id="big-bloc">
<? $this->DisplayNewModule('fleche') ?>
<div class="clear">&nbsp;</div>
<h3>Les thèmes</h3>
<? $this->DisplayNestedModule('themes') ?>
</div>

<div class="dynamique">
	<div class="bloc-dyn">
		<h2>Cahier de perspectives</h2>
		<ul>
			<li><a href="<?= ROOT ?>documents/Perspectives.pdf">Télécharger en format PDF (122 ko)</a></li>
			<li><a href="<?= ROOT ?>documents/lettre_pres_4.pdf">Lettre de présentation – Fichier PDF (88 ko)</a></li>
		</ul>
	</div>
	<div class="bloc-dyn">
		<h2>Événements</h2>
		<? $this->DisplayNestedModule('evenements') ?>
	</div>
</div>