<?php

class EvenementsModule extends Module {
	
	function ItemViewController() {
		// Determine date
		if ($this->item['plusieursJours']) {
			$date = $this->item['date']->DateRange($this->item['duree']);
		} else {
			$date = $this->item['date']->SmartDate();
		}
		$dateString = e('p', $date);
		$lieuString = e('p', $this->item['lieu']);
		$detailsString = e('div', array('class' => 'details'), $dateString . $lieuString);
		$introString = $detailsString . $this->item['description'];
		
		$templateVariables = array(
			'enteteSurtitre' => 'Événements',
			'enteteTitre' => $this->item['titre'],
			'intro' => $introString,
			'afficherEtape' => true,
			'etape' => 2
		);
		$this->template->AddVariables($templateVariables);
	}
	
	function HomeViewController() {
		$queryParams = array(
			'fields' => array('titre', 'date', 'duree', 'plusieursJours', 'lieu'),
			'where' => 'date > NOW()',
			'orderby' => 'date ASC'
		);
		$this->FetchItems($queryParams);
	}
	
	function ThemesViewController() {
		$queryParams = array(
			'fields' => array('titre', 'date', 'lieu'),
			'where' => array('date > NOW()', 'theme = '. $this->parentModule->itemID),
			'orderby' => 'date ASC'
		);
		$this->FetchItems($queryParams);
	}
	
}

?>