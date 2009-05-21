<?php

class ContributionsModule extends Module {
	
	var $missingMember;
	var $participants = array();
	
	function GetPath() {
		$themesModule = Module::GetNewModule('themes', $this->item['theme']);
		if ($path = $themesModule->item['path'] .'/'. String::PrepareForURL($this->item['titre'])) {
			return $path;
		} else {
			trigger_error("Couldn't get path for item", E_USER_ERROR);
			return false;
		}
	}
	
	function ValidateData() {
		global $_JAM;
		
		if ($_JAM->rootModuleName != 'admin') {
			// Valider les participants
			for ($i = 1; $i < 99; $i++) {
				if ($_POST['membre'. $i] || $_POST['prenom'. $i] || $_POST['nom'. $i]) {
					// S'assurer que toutes les informations sont là
					$this->postData['membre'. $i] = $_POST['membre'. $i];
					$this->postData['nom'. $i] = $_POST['nom'. $i];
					$this->postData['prenom'. $i] = $_POST['prenom'. $i];
					if (!$_POST['nom'. $i]) {
						$this->missingData[] = 'nom'. $i;
					}
					if (!$_POST['prenom'. $i]) {
						$this->missingData[] = 'prenom'. $i;
					}
					if (!$this->missingData) {
						$this->participants[$i] = array(
							'nom' => $_POST['nom'. $i],
							'prenom' => $_POST['prenom'. $i],
							'membre' => $_POST['membre'. $i]
						);
					}
				}
			}

			// S'assurer qu'il y a au moins 3 membres
			$count = count($this->participants);
			if (!$this->participants || $count < 3) {
				$this->missingData[] = 'missingParticipants';
				for ($i = 1; $i < 4; $i++) {
					if (!$this->participants[$i]) {
						$this->missingData[] = 'prenom'. $i;
						$this->missingData[] = 'nom'. $i;
					}
				}
			}

			// S'assurer qu'il y a au moins un membre de QS
			if ($this->participants) {
				foreach ($this->participants as $participant) {
					if ($participant['membre']) {
						$hasMember = true;
						continue;
					}
				}
			}
			if (!$hasMember) {
				$this->missingMember = true;
				$this->missingData[] = 'hasMember';
			}

			// S'assurer qu'un thème ait été sélectionné
			if (!$_POST['theme']) {
				$this->missingData[] = 'theme';
			}
		}
		
		return parent::ValidateData();
	}

	function PostProcessData($id) {
		foreach ($this->participants as $participant) {
			$params = $participant;
			$params['contribution'] = $id;
			if (!Database::Insert('participants', $params)) {
				trigger_error("Couldn't insert data for child module", E_USER_ERROR);
				return false;
			}
		}
	}
	
	function DefaultViewController() {
		if (!$this->item['publier']) {
			$this->LoadView('private');
			return false;
		}
		$layoutVariables = array(
			'surtitre' => 'Réfléchir',
			'titre' => 'Contribution',
			'intro' => "Les contributions comme celle ci-dessous ont été rédigées par des cercles citoyens. Elles vous sont suggérées comme lecture afin d'alimenter votre réflexion sur les enjeux et vous montrer la diversité des opinions, des théories et des tendances des membres de Québec solidaire. Vous pouvez utiliser ces textes comme point de départ et y réagir, ou alors écrire votre contribution en partant d'ailleurs.",
			'titreCorps' => $this->item['titre'],
			'afficherTheme' => true,
			'theme' => $this->item['theme'],
			'afficherEtape' => true,
			'etape' => 1
		);
		$this->layout->AddVariables($layoutVariables);
	}
	
	function PagesViewController() {
		$this->view['form'] = $this->GetForm();

		$themes = Module::GetNewModule('themes');
		$queryParams = array(
			'fields' => 'titreCourt',
			'orderby' => 'sortIndex'
		);
		$themes->FetchItems($queryParams);

		$this->view['themes'] = $themes->items;
	}
	
	function ThemesViewController() {
		$queryParams = array(
			'fields' => array('titre', 'cercle'),
			'where' => array(
				'theme = '. $this->parentModule->itemID,
				'publier = TRUE'
			),
			'orderby' => 'modified DESC'
		);
		$this->FetchItems($queryParams);
	}

	function PrivateViewController() {
		$layoutVariables = array(
			'surtitre' => 'Réfléchir',
			'titre' => 'Non-disponible',
			'intro' => "La contribution à cette adresse n'est pas offerte en consultation publique.",
			'afficherEtape' => true,
			'etape' => 1
		);
		$this->layout->AddVariables($layoutVariables);
	}
	
}

?>